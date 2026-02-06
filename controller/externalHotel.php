<?php

error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
/**
 * Class externalHotel
 * @property externalHotel $externalHotel
 */
class externalHotel
{

    public function __construct()
    {}

    public function getCities($pageNumber, $search = null)
    {
        $ModelBase = Load::library('ModelBase');
        $startRecord = ($pageNumber * 100) - 100;
        $limit = 'LIMIT ' . $startRecord . ', ' . 100;
        $sql = " SELECT *, ( SELECT COUNT(id) FROM external_hotel_city_tb ";
        if (isset($search) && $search != ''){
            $sql .= " WHERE 
                country_name_fa LIKE '{$search}%' 
                OR city_name_fa LIKE '{$search}%' 
                OR country_name_en LIKE '{$search}%'
                OR city_name_en LIKE '{$search}%' ";
        }
        $sql .= " ) AS countCities FROM external_hotel_city_tb ";
        if (isset($search) && $search != ''){
            $sql .= " WHERE 
                country_name_fa LIKE '{$search}%' 
                OR city_name_fa LIKE '{$search}%' 
                OR country_name_en LIKE '{$search}%'
                OR city_name_en LIKE '{$search}%' ";
        }
        $sql .= $limit;
        $result = $ModelBase->select($sql);

        return $result;
    }

    public function updateExternalHotelCity($param)
    {
        $ModelBase = Load::library('ModelBase');

        $data[$param['inputName']] = $param['inputValue'];

        $condition = " id = '{$param['id']}' ";
        $ModelBase->setTable("external_hotel_city_tb");
        $resUpdate = $ModelBase->update($data, $condition);

        if ($resUpdate) {
            return true;
        } else {
            return false;
        }
    }


    public function getRooms($pageNumber, $search = null)
    {
        $ModelBase = Load::library('ModelBase');
        $startRecord = ($pageNumber * 100) - 100;
        $limit = 'LIMIT ' . $startRecord . ', ' . 100;
        $sql = " SELECT *, ( SELECT COUNT(id) FROM external_hotel_room_tb ";
        if (isset($search) && $search != ''){
            $sql .= " WHERE 
                room_name LIKE '{$search}%' 
                OR room_persian_name LIKE '{$search}%' ";
        }
        $sql .= " ) AS countCities FROM external_hotel_room_tb ";
        if (isset($search) && $search != ''){
            $sql .= " WHERE 
                room_name LIKE '{$search}%' 
                OR room_persian_name LIKE '{$search}%' ";
        }
        $sql .= " GROUP BY room_name ";
        $sql .= $limit;
        $result = $ModelBase->select($sql);

        return $result;
    }

    public function updateExternalHotelRoom($param)
    {
        $ModelBase = Load::library('ModelBase');

        $data[$param['inputName']] = $param['inputValue'];

        $condition = " room_name = '{$param['roomName']}' ";
        $ModelBase->setTable("external_hotel_room_tb");
        $resUpdate = $ModelBase->update($data, $condition);

        if ($resUpdate) {
            return true;
        } else {
            return false;
        }
    }



    public function getFacilities($pageNumber, $search = null)
    {
        $ModelBase = Load::library('ModelBase');
        $startRecord = ($pageNumber * 100) - 100;
        $limit = 'LIMIT ' . $startRecord . ', ' . 100;
        $sql = " SELECT *, ( SELECT COUNT(id) FROM external_hotel_facilities_tb ";
        if (isset($search) && $search != ''){
            $sql .= " WHERE 
                value LIKE '{$search}%' 
                OR value_persian LIKE '{$search}%' ";
        }
        $sql .= " ) AS countCities FROM external_hotel_facilities_tb ";
        if (isset($search) && $search != ''){
            $sql .= " WHERE 
                value LIKE '{$search}%' 
                OR value_persian LIKE '{$search}%' ";
        }
        $sql .= " GROUP BY value ";
        $sql .= $limit;
        $result = $ModelBase->select($sql);

        return $result;
    }

    public function updateExternalHotelFacilities($param)
    {
        $ModelBase = Load::library('ModelBase');

        $data[$param['inputName']] = $param['inputValue'];

        $condition = " value = '{$param['value']}' ";
        $ModelBase->setTable("external_hotel_facilities_tb");
        $resUpdate = $ModelBase->update($data, $condition);

        if ($resUpdate) {
            return true;
        } else {
            return false;
        }
    }


}