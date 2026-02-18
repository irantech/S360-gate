<?php

class airline_tb extends ModelBase
{

    protected $table = 'airline_tb';
    protected $pk = 'id';

    public function getAll()
    {
        return parent::select("select * from $this->table where del='no' ORDER BY LEAST(Commission_internal, Commission_external) DESC");
    }

public function getAllOrderByiata()
{
    return parent::select("
        SELECT *
        FROM $this->table
        WHERE del = 'no'
        ORDER BY 
            (airline_iata_id IS NULL), 
            (airline_iata_id IN (
                SELECT airline_iata_id 
                FROM $this->table
                WHERE del = 'no' AND airline_iata_id IS NOT NULL
                GROUP BY airline_iata_id
                HAVING COUNT(*) > 1
            )) DESC,
            airline_iata_id,
            id
    ");
}


    public function getAllDomestic($client_id)
    {
        $admin = Load::controller('admin');
        $amadeus = DB_DATABASE_BASE;
        $customer_db = $admin->getClient($client_id)['DbName'];
        $sql = "SELECT * FROM $amadeus.{$this->table} WHERE foreignAirline = 'inactive' ORDER BY {$this->pk} ASC";
        return parent::select($sql);
    }
    public function getAllForeign($client_id)
    {
        $admin = Load::controller('admin');
        $amadeus = DB_DATABASE_BASE;
        $customer_db = $admin->getClient($client_id)['DbName'];
        $sql = "SELECT * FROM $amadeus.{$this->table} WHERE foreignAirline IS NULL OR foreignAirline = 'active' ORDER BY {$this->pk} ASC";
        return parent::select($sql);
    }
    public function getAllSort()
    {
        return parent::select("select * from $this->table where del='no'  ORDER BY name_fa COLLATE utf8_persian_ci  ASC");

    }

    public function get($nameEn)
    {
        return parent::load("select * from $this->table where name_en='$nameEn' and del='no' ");
    }

    public function getByIata($iata)
    {
        return parent::load("select * from $this->table where abbreviation='$iata' and del='no' ");
    }

    public function getById($id)
    {
        $result = parent::load("select * from $this->table where id='$id' and del='no' ");
        return $result;
    }

    public function InsertAirlineModel($InfoAirline)
    {

        $data['name_fa'] = $InfoAirline['nameFa'];
        $data['name_en'] = $InfoAirline['nameEn'];
        $data['abbreviation'] = $InfoAirline['abbreviation'];

        $config = Load::Config('application');
        $config->pathFile('airline/');
        $success = $config->UploadFile("pic", "photo", "");
        $explod_name_pic = explode(':', $success);
        if ($explod_name_pic[0] == "done") {

            $data['photo'] = $explod_name_pic[1];
            $result = parent::insertLocal($data);
            if ($result) {

                return 'success : خطوط پروازی مورد نظر با موفقیت ثبت شد';
            } else {
                return 'error : خطا در ثبت خطوط پروازی';
            }
        } else {
            return "error : خطا در ثبت لوگوی خطوط پروازی";
        }
    }

    public function airline_delete($id)
    {
        //return parent::delete("id='$id'");
        $data = array(
            'del' => "'yes'"
        );
        return parent::update($data, "id='$id'");
    }

    public function UpdateAirlineModel($InfoAirline)
    {


        $result = parent::load("select * from $this->table where $this->pk = '{$InfoAirline['airline_id']}' ");

        $id = $InfoAirline['airline_id'];
        if (!empty($result)) {
            $data['name_fa'] = $InfoAirline['nameFa'];
            $data['name_en'] = $InfoAirline['nameEn'];
            $data['abbreviation'] = $InfoAirline['abbreviation'];
            if (empty($_FILES['photo'])) {

                $success = "done:" . $result['photo'];
                $explod_name_pic = explode(':', $success);
            } else {
                $config = Load::Config('application');
                $config->pathFile('airline/');
                $success = $config->UploadFile("pic", "photo", "");
                $explod_name_pic = explode(':', $success);

            }

            if ($explod_name_pic[0] == "done") {
                $data['photo'] = $explod_name_pic[1];

                $res_update = parent::update($data, "id='{$id}'");
                if ($res_update) {
                    echo 'success : اطلاعات خطوط پروازی با موفقیت ویرایش شد';
                } else {
                    echo 'error : خطا در ویرایش اطلاعات خطوط پروازی';
                }
            }
        } else {

            echo "error : خطوط پروازی مورد نظر وجود ندارد،با وب مستر خود تماس بگیرید";
        }
    }

    public function getLastId()
    {
        return parent::getLastId();
    }

    public function active($id)
    {
        $rec = self::getById($id);
        if ($rec['active'] == 'on') {
            $data = array('active' => "'off'");
        } else {
            $data = array('active' => "'on'");
        }
        return parent::update($data, "id='$id'");
    }

    public function getActiveAirline($type)
    {
        Load::autoload('Model');

        $Model = new Model();


        switch ($type) {
            case 'system' :
                 $sql = "select airline_iata from airline_client_tb where system ='active'";
                break;
            case 'charter' :
                 $sql = "select airline_iata from airline_client_tb where charter='active' ";
                break;
            case 'private' :
                $sql = "select airline_iata from airline_client_tb where pid_private='1' ";
                break;
            case 'foreignAirline' :
                $sql = "select airline_iata from airline_client_tb where foreignAirline='active' ";
                break;
        }

        $result = $Model->select($sql);

//        echo Load::plog($result) ;
//        die();

        $arr = array();
        foreach ($result as $rec) {
            $arr[] = $rec[0];
        }

        return $arr;
    }

    public function getActiveOption()
    {
        $result = parent::select("select * from $this->table where del='no' and active !='off'");
        return $result;
    }

}
