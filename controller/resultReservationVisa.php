<?php
/**
 * Class resultReservationVisa
 * @property resultReservationVisa $resultReservationVisa
 */
class resultReservationVisa extends clientAuth
{
    public $Model;
    public $error = false;
    public $errorMessage = '';

    public function __construct() {
        $this->Model = Load::library('Model');
    }

    public function visaSearch($countryCode, $visaType , $visaCategory = 1)
    {

        $countryCode = filter_var($countryCode, FILTER_SANITIZE_STRING);
        $visaType = filter_var($visaType, FILTER_VALIDATE_INT);

        // شرط برای نوع ویزا
        $visaTypeCondition = '';
        if(!empty($visaType) && $visaType !== 'all'){
            $visaTypeCondition = " AND V.visaTypeID = '{$visaType}' ";
        }

        // شرط برای کشور
        $countryCondition = '';
        if(!empty($countryCode) && $countryCode !== 'all'){
            $countryCondition = " AND V.countryCode = '{$countryCode}' ";
        }

        $correctDate=date('Y-m-d H:i:s');
        $querySearch = "SELECT V.*, VT.title AS visaTypeTitle FROM visa_tb V
                        INNER JOIN visa_type_tb VT ON V.visaTypeID = VT.id " .
                       "LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=V.id " .
                       "LEFT JOIN visa_category_tb as Category ON Category.id=V.category_id " .
                       "WHERE
                       CASE

                                WHEN V.agency_id = '0' THEN
                                1 ELSE Expiration.expired_at
                            END >
                        CASE

                                WHEN V.agency_id = '0' THEN
                                0 ELSE '{$correctDate}'
                            END
                       AND V.isActive =  CASE WHEN V.agency_id = '0' THEN V.isActive  ELSE 'yes' END
                        AND V.isDell = 'no'
                        AND V.validate = 'granted'
                        AND V.category_id = '{$visaCategory}'
                        {$countryCondition} {$visaTypeCondition}
                        GROUP BY V.id ";


        $resultVisa = $this->Model->select($querySearch);

        if(!empty($resultVisa)){

            foreach ($resultVisa as $key => $eachVisa){

                $visaList[$key] = $eachVisa;

                $discountedPrice = $this->calcDiscountedPrice($eachVisa['mainCost']);
                $visaList[$key]['priceWithDiscount'] = $discountedPrice['price'];

            }
            return $visaList;

        } else{

            $this->error = true;
            $this->errorMessage = functions::Xmlinformation("PleaseSearchAnotherDestinationVisa").'<br />'.functions::Xmlinformation("CurrentlyNoVisaIntendedDestination");

        }
    }

    public function calcDiscountedPrice($price)
    {
        $userId = Session::getUserId();
        $userInfo = functions::infoMember($userId);
        $counterInfo = functions::infoCounterType($userInfo['fk_counter_type_id'], CLIENT_ID);
        $counterId = $counterInfo['id'];

        $serviceType = functions::getVisaServiceType();

        $discount = functions::ServiceDiscount($counterId, $serviceType);

        if ($discount['off_percent'] > 0) {
            $price -= $price * ($discount['off_percent'] / 100);
        }

        $output['percent'] = $discount['off_percent'];
        $output['price'] = $discount['off_percent'] > 0 ? round($price) : $price;

        return $output;
    }

    public function generateFactorNumber()
    {
        return substr(time(), 0, 4) . mt_rand(000000, 999999) . substr(time(), 6, 10);
    }

    public function countriesHaveVisa($continentID)
    {
        $continentID = filter_var($continentID, FILTER_SANITIZE_NUMBER_INT);
//        $countryController = Load::controller('country');
//        $requestedCountries = $countryController->countriesByContinentID($continentID,true);

        $correctDate=date('Y-m-d H:i:s');

        $query = "SELECT country.* FROM reservation_country_tb AS country
                    INNER JOIN visa_tb as visa ON country.abbreviation=visa.countryCode
                    INNER JOIN visa_type_tb visaType ON visa.visaTypeID = visaType.id
                    LEFT JOIN visa_expiration_tb as expiration ON expiration.visa_id=visa.id 
                    WHERE 
                          CASE
		
                                WHEN visa.agency_id = '0' THEN
                                1 ELSE expiration.expired_at 
                            END >
                        CASE
                                
                                WHEN visa.agency_id = '0' THEN
                                0 ELSE '{$correctDate}' 
                            END 
                       AND visa.isActive = 
                        CASE WHEN visa.agency_id = '0' THEN visa.isActive  ELSE 'yes' END
                          
                          
                          
                          
                    AND country.id_continent = '{$continentID}'
                    AND country.abbreviation != ''
                    AND visa.isDell = 'no'
                    AND visa.validate = 'granted'
                    GROUP BY country.abbreviation
                    ";

        $availibleVisa = $this->Model->select($query);



        return $availibleVisa;
    }


    public function allCountryVisaTypes($countryID ) {

//        $countryID = filter_var($countryID, FILTER_SANITIZE_NUMBER_INT);

        $correctDate = date('Y-m-d H:i:s');


        $whereCountry = "";

        if ($countryID !== 'all') {
            $whereCountry = " AND visa.countryCode = '{$countryID}' ";
        }

        $clientSql = "
    SELECT
        visaType.id,
        visaType.title
    FROM visa_type_tb visaType
        INNER JOIN visa_tb AS visa ON visa.visaTypeID = visaType.id
        INNER JOIN reservation_country_tb AS country ON visa.countryCode = country.abbreviation
        LEFT JOIN visa_expiration_tb AS Expiration ON Expiration.visa_id = visa.id
    WHERE
        CASE
            WHEN visa.agency_id = '0' THEN 1
            ELSE Expiration.expired_at
        END >
        CASE
            WHEN visa.agency_id = '0' THEN 0
            ELSE '{$correctDate}'
        END
        AND visa.isActive =
        CASE
            WHEN visa.agency_id = '0' THEN visa.isActive
            ELSE 'yes'
        END
        AND visa.isDell = 'no'
        {$whereCountry}
        AND visa.validate = 'granted'
    GROUP BY visaType.id
";


        return $this->Model->select($clientSql);

    }

}

?>