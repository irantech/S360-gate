<?php

/**
 * Class country
 * @property country $country
 */
class country extends clientAuth {
    public function __construct(){
        parent::__construct();
    }

    //region [allCountries]

    /**
     * @param array $params
     * @param bool $json
     * @return array|bool|mixed|string
     */
    public function getCountries($params = [], $json = false){
        $result = $this->getModel('countryCodesModel')->get()->all();
        if($json){
            return functions::toJson($result);
        }
        return $result;
    }

    /**
     * @param $country_id
     * @return array|bool|mixed|string
     */
    public function getCountry($country_id){
        return $this->getModel('countryCodesModel')->get()
            ->where('id',$country_id)
            ->find();

    }
    //endregion

    #region continentsList
	public function continentsList() {
 
		// First, get continents from the continent_codes_tb (different database)
		$continents = $this->getModel('continentCodesModel')->get()->all();
		
		// Get continent config model for sort orders
		$continentConfigModel = $this->getModel('reservationContinentConfigModel');
		
		// Process each continent to add sort order
		foreach ($continents as &$continent) {
			// Get sort order for this continent
			$sortOrderData = $continentConfigModel->getSortOrder($continent['id']);
			$continent['sort_order'] = $sortOrderData ? $sortOrderData['sort_order'] : 0;
		}
		
		// Sort continents: by sort_order DESC (higher numbers first), then by ID
		usort($continents, function($a, $b) {
			if ($a['sort_order'] == $b['sort_order']) {
				return $a['id'] - $b['id'];
			}
			return $b['sort_order'] - $a['sort_order'];
		});
		
		return $continents;
	}
	#endregion

	#region getContinentByID
	public function getContinentById( $id ) {
		$id        = filter_var( $id, FILTER_VALIDATE_INT );
		return $this->getController('continentCodes')->getContinent($id);
	}
	#endregion

    public function countriesOfContinent($param) {
        $continent_id= $param ;
        if(is_array($param)){
            $continent_id = $param['continent_id'];
        }

        $result_countries = $this->getModel( 'countryCodesModel' )->get()->where( 'continent_code',  $continent_id )->all();
        if($param['is_json']){
            return functions::withSuccess($result_countries,200,'data fetched successfully');
        }
        return  $result_countries ;
    }

	#region continentActivate: activate - deactivate a specified continent
	public function continentActivate( $id ) {
		$ModelBase    = Load::library( 'ModelBase' );
		$resultStatus = $this->getModel( 'countryCodesModel' )->get()->where( 'validate', '1' )->where( 'id', $id )->find();
		if ( $resultStatus['validate'] == 1 ) {
			$status = 0;
		} else {
			$status = 1;
		}
		$data['validate'] = $status;

		$ModelBase->setTable( 'continent_codes_tb' );
		$result = $ModelBase->update( $data, "id='{$id}'" );

		if ( $result ) {
			$output['result_status']  = 'success';
			$output['result_message'] = 'وضعیت قاره با موفقیت تغییر یافت';
		} else {
			$output['result_status']  = 'error';
			$output['result_message'] = 'خطا در تغییر وضعیت قاره';
		}

		return $output;
	}
	#endregion

	#region countriesList
	public function countriesList() {

		$ModelBase = Load::library( 'ModelBase' );

		$query = "SELECT COUNTRY.*, CONTINENT.titleFa AS continentTitle " .
		         "FROM country_codes_tb COUNTRY INNER JOIN continent_codes_tb CONTINENT ON COUNTRY.continent_code = CONTINENT.id";

		return $ModelBase->select( $query );
	}

	#endregion

	public function getAllCountries() {
		return $this->getModel( 'countryCodesModel' )->get( [
			'id',
			'code',
			'code_two_letter',
			'titleEn',
			'titleFa'
		] )->where( 'validate', '1' )->all();
	}

	#region getCountryByCode
	public function getCountryByCode( $code ) {
		$code                     = filter_var( $code, FILTER_SANITIZE_STRING );
		$CountryResult            = $this->getModel( 'reservationCountryModel' )->get()->where( 'abbreviation', $code )->find();
		$ContinentResult          = $this->getModel( 'countryCodesModel' )->get()->where( 'id', $CountryResult['id_continent'] )->find();
		$result['name']           = $CountryResult['name'];
		$result['continentTitle'] = $ContinentResult['titleFa'];
		$result['continentID']    = $ContinentResult['id'];
		$result['countryID']      = $CountryResult['id'];

		return $result;
	}
	#endregion

	#region countriesByContinentID: get list of countries of a specified continent
	public function countriesByContinentID( $id, $RemoveExistCountries = false ) {
        $additional_condition = array();
		if ( $RemoveExistCountries ) {
			$countries = $this->getModel( 'reservationCountryModel' )->get()->where( 'abbreviation', '', '!=' )->all(false);
			$abb = array();
			foreach ( $countries as $item ) {
				$abb[] = $item['abbreviation'];
			}
			$abbreviation = implode("','",$abb);


			if ( $abbreviation ) {
				$additional_condition = array(
					array( 'index' => 'code', 'value' => "$abbreviation", 'operator' => 'NOT IN' ),
					array( 'index' => 'code_two_letter', 'value' => "$abbreviation", 'operator' => 'NOT IN' ),
				);
			}

		}

		return $this->getModel( 'countryCodesModel' )->get()->where( 'continent_code', $id )->where($additional_condition)->all();


	}
	#endregion


	#region countriesByContinentID: get list of countries of a specified continent
	public function reservationCountriesByContinentID( $id ) {
		$id    = filter_var( $id, FILTER_VALIDATE_INT );

        // اگر ورودی معتبر نیست، خروجی خالی بده
        if (!$id) {
            return [];
        }

        return $this->getModel('reservationCountryModel')
            ->get()
            ->where('abbreviation', '', '!=')
            ->where('id_continent', $id)
            ->where('is_del', 'no')
            ->all();
	}
	#endregion

	#region countryActivate: activate - deactivate a specified country
	public function countryActivate( $id ) {
		$ModelBase = Load::library( 'ModelBase' );

		$queryStatus  = "SELECT `validate` FROM `country_codes_tb` WHERE `id` = '{$id}'";
		$resultStatus = $ModelBase->load( $queryStatus );
		if ( $resultStatus['validate'] == 1 ) {
			$status = 0;
		} else {
			$status = 1;
		}

		$data['validate'] = $status;

		$ModelBase->setTable( 'country_codes_tb' );
		$result = $ModelBase->update( $data, "id='{$id}'" );

		if ( $result ) {
			$output['result_status']  = 'success';
			$output['result_message'] = 'وضعیت کشور با موفقیت تغییر یافت';
		} else {
			$output['result_status']  = 'error';
			$output['result_message'] = 'خطا در تغییر وضعیت کشور';
		}

		return $output;
	}
	#endregion

    #region getContinentByID
    public function getContinentByCountryId( $country_id ) {
        $id  = filter_var( $country_id, FILTER_VALIDATE_INT );

        $country_model = $this->getModel('countryCodesModel');
        $country_table = $country_model->getTable();
        $continent_model = $this->getModel('continentCodesModel');
        $continent_table = $continent_model->getTable();

        $result = $continent_model
            ->get([ $continent_table . '.*', ], true)
            ->join($country_table, 'continent_code', 'id')
            ->where($country_table . '.id', $id);
        return $result->find();
    }
    #endregion

    public function getCountryCodes() {

        $countries = $this->getCountries();

        $final_countries = [];

        foreach ($countries as $country){
            $final_countries[$country['titleEn']] = $country;
        }
        return $final_countries ;
    }


    public function getCountriesWithVisa() {
        $Model     = Load::library( 'Model' );
        $query = "SELECT 
                      COUNTRY.*, 
                      COUNTRY.name AS titleFa ,
                      V.countryCode AS countryCode 
                    FROM reservation_country_tb COUNTRY 
                    INNER JOIN 
                    visa_tb V
                    ON COUNTRY.abbreviation = V.countryCode GROUP BY COUNTRY.abbreviation";
        return $Model->select( $query );
    }

    #region toggleFavoriteCountry: toggle favorite status of a country
    public function toggleFavoriteCountry( $params ) {
        $country_id = filter_var( $params['country_id'], FILTER_VALIDATE_INT );
        $sort_order = isset($params['sort_order']) ? filter_var($params['sort_order'], FILTER_VALIDATE_INT) : null;
	 
        // Get current sort order using ORM
        $currentCountry = $this->getModel( 'reservationCountryModel' )->get()->where( 'id',  $country_id )->find();
      
        if ( empty($currentCountry) ) {
            $output['result_status']  = 'error';
            $output['result_message'] = 'کشور مورد نظر یافت نشد';
            return $output;
        }
        
        // If sort_order is provided, use it; otherwise toggle between 0 and 1
        if ($sort_order !== null) {
            $newSortOrder = $sort_order;
        } else {
            // Toggle logic: if current is 0, set to 1; if current is > 0, set to 0
            $newSortOrder = ($currentCountry['sort_order'] > 0) ? 0 : 1;
        }

        $data['sort_order'] = $newSortOrder;
	
        // Update using ORM
        $result = $this->getModel( 'reservationCountryModel' )->update($data,'id = '.$country_id);

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'ترتیب نمایش کشور با موفقیت تغییر یافت';
            $output['sort_order'] = $newSortOrder;
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر ترتیب نمایش کشور';
        }

        return json_encode($output,JSON_UNESCAPED_UNICODE);
    }
    #endregion

    #region toggleFavoriteContinent: toggle sort order of a continent
    public function toggleFavoriteContinent( $params ) {
        $continent_id = filter_var( $params['continent_id'], FILTER_VALIDATE_INT );
        $sort_order = isset($params['sort_order']) ? filter_var($params['sort_order'], FILTER_VALIDATE_INT) : null;

        // Use the reservation continent config model to toggle sort order
        $continentConfigModel = $this->getModel( 'reservationContinentConfigModel' );
        $result = $continentConfigModel->toggleSortOrder( $continent_id, $sort_order );

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'ترتیب نمایش قاره با موفقیت تغییر یافت';
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر ترتیب نمایش قاره';
        }

        return json_encode($output, JSON_UNESCAPED_UNICODE);
    }
    #endregion

}

