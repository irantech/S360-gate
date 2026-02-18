<?php


class visaTypeModel extends Model
{
    protected $table = 'visa_type_tb';
    protected $pk = 'id';

    public function getVisaTypeList($date)
    {
        $sql = "SELECT type.* FROM {$this->table} AS type
                INNER JOIN visa_tb as visa ON visa.visaTypeID=type.id
                LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=visa.id  
                WHERE CASE 
                    WHEN visa.agency_id = '0' THEN
                    1 ELSE Expiration.expired_at END > CASE
                    WHEN visa.agency_id = '0' THEN 0 ELSE '{$date}' 
                    END        
                    AND type.isDell = 'no'
                    AND visa.isActive = 
                    CASE WHEN visa.agency_id = '0' THEN visa.isActive  ELSE 'yes' END
                    AND visa.isActive = 'yes' 
                    AND visa.isDell = 'no'
                    AND visa.validate = 'granted'
                    GROUP BY type.id";

        return parent::select($sql);
    }
}