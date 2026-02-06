<?php

/**
 * Class visaType
 * @property visaType $visaType
 */
class visaType extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }

    #region visaTypeList
    public function visaTypeList() {
        $Model = Load::library('Model');
        $correctDate = date('Y-m-d H:i:s');
        $query = "SELECT type.* FROM visa_type_tb AS type
                    INNER JOIN visa_tb as visa ON visa.visaTypeID=type.id
                    LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=visa.id  
                  WHERE 
                        CASE
		
                                WHEN visa.agency_id = '0' THEN
                                1 ELSE Expiration.expired_at 
                            END >
                        CASE
                                
                                WHEN visa.agency_id = '0' THEN
                                0 ELSE '{$correctDate}' 
                            END 
                            
                    AND type.isDell = 'no'
                    
                    AND visa.isActive = 
                        CASE WHEN visa.agency_id = '0' THEN visa.isActive  ELSE 'yes' END

                    AND visa.isActive = 'yes' 
                    AND visa.isDell = 'no'
                    
                    AND visa.validate = 'granted'
                    GROUP BY type.id
                    ";
        return $Model->select($query);
    }


    public function allVisaTypeList() {
        $Model = Load::library('Model');
        $correctDate = date('Y-m-d H:i:s');
        $query = "SELECT type.* FROM visa_type_tb AS type
                 
                  WHERE 
                    type.isDell = 'no'
                
                    ";
        return $Model->select($query);
    }
    #endregion

    #region getVisaTypeByID
    public function getVisaTypeByID($id) {

        $Model = Load::library('Model');
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $query = "SELECT * FROM  visa_type_tb  WHERE id = '{$id}'";
        return $Model->load($query);
    }
    #endregion

    #region visaTypeAdd: add a visa Type
    public function visaTypeAdd($param) {
        $Model = Load::library('Model');

        $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
        $data['documents'] = filter_var($param['documents'], FILTER_SANITIZE_STRING);
        $data['creationDateInt'] = time();
        $data['isDell'] = 'no';

        $Model->setTable('visa_type_tb');
        $resultInsert = $Model->insertLocal($data);

        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'افزودن نوع ویزا با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند افزودن نوع ویزا';
        }

        return $output;
    }
    #endregion

    #region visaTypeEdit: edit a visa Type
    public function visaTypeEdit($param) {
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);

        $Model = Load::library('Model');

        $sqlExist = "SELECT id AS existID FROM visa_type_tb WHERE id = '{$param['id']}'";
        $resultSelect = $Model->load($sqlExist);

        if (!empty($resultSelect['existID'])) {

            $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
            $data['documents'] = filter_var($param['documents'], FILTER_SANITIZE_STRING);
            $data['lastEditInt'] = time();

            $Condition = "id='{$param['id']}'";
            $Model->setTable('visa_type_tb');
            $resultInsert = $Model->update($data, $Condition);

            if ($resultInsert) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'ویرایش نوع ویزا با موفقیت انجام شد';
            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند ویرایش نوع ویزا';
            }

        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در ویرایش نوع ویزا، نوع ویزای مورد نظر یافت نشد';
        }

        return $output;
    }

    #endregion


    public function getVisaTypeSpecialCountry($params) {
        $Model = Load::library('Model');
        $correctDate = date('Y-m-d H:i:s');

        $visa_type_sql = "  SELECT visaType.id, visaType.title FROM visa_type_tb visaType
                         INNER JOIN visa_tb AS visa ON visa.visaTypeID = visaType.id
                         INNER JOIN reservation_country_tb AS country ON visa.countryCode = country.abbreviation
                         WHERE visa.isActive = 'yes'
                                            AND visa.isDell = 'no'
                                              AND visa.countryCode ='{$params['country_id']}'
                                                  AND visa.validate = 'granted'
                          GROUP BY visaType.id";
        
        $result_visa_type = $Model->select($visa_type_sql);

        if($params['is_json']){
            return functions::withSuccess($result_visa_type,200,'data fetched successfuly');
        }

        return $result_visa_type ;
    }

}