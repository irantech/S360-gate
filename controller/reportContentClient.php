<?php

class reportContentClient extends clientAuth
{

    public static $CountArticle = ['news','mag'];
    public static $reports = [];
    public static $admin;
    public static $startDate;
    public static $endDate;

    public function __construct() {

        self::$admin =  Load::controller('admin');

        self::$startDate = $this->Date()['start'];
        self::$endDate = $this->Date()['end'];
    }

    public function Date() {
        $dates = array_keys($_REQUEST)[1];
        $dates = json_decode($dates,1);
        return ['start' => $dates['start_date'] , 'end' => $dates['end_date'] ];
    }


    public static function convertor_date($date,$type) {

        if ($type == 'Article' || $type == 'Special') {
            return functions::ConvertToMiladi($date, $mod = '-');
        }
        if ($type == 'Tour' )
        {
           // return str_replace('-','',$date);
            return $date;
        }
          //  return functions::convertJalaliDateToGregInt($date,  ' H:i:s Y-m-d ');
    }



    public function index()
    {
        foreach ($this->clients() as $client)
        {
            $CountArticle = $this->CountArticle($client['id']);
            $CountNews = ($CountArticle['news']['count'] == false || $CountArticle['news']['count'] == null)? ['count' => 0] : ['count' => $CountArticle['news']['count'] ] ;
            $CountMag = ($CountArticle['mag']['count'] == false || $CountArticle['mag']['count'] == null)? ['count' => 0] : ['count' => $CountArticle['mag']['count']] ;

            $CountTourInternal = ($this->CountTourInternal($client['id']) == false)? ['count' => 0] : $this->CountTourInternal($client['id']);
            $CountTourForeigner = ($this->CountTourForeigner($client['id']) == false)? ['count' => 0] : $this->CountTourForeigner($client['id']);
            $CountSpecialPages = ($this->CountSpecialPages($client['id']) == false)? ['count' => 0] : $this->CountSpecialPages($client['id']);
            $ClinetName = $client['AgencyName'];

            $CountSuccess = intval($CountNews['count']) +
                            intval($CountMag['count']) +
                            intval($CountTourInternal['count']) +
                            intval($CountTourForeigner['count']) +
                            intval($CountSpecialPages['count']);


                self::$reports[$client['id']] =
                    [
                        'CountNews' => $CountNews,
                        'CountMag' => $CountMag,
                        'CountTourInternal' => $CountTourInternal,
                        'CountTourForeigner' => $CountTourForeigner,
                        'CountSpecialPages' => $CountSpecialPages,
                        'ClinetName' => $ClinetName,
                        'CountSuccess' => $CountSuccess
                    ];

                       /*   'CountHotelInternal' => $this->CountHotelInternal($client['id']),
                       'CountHotelForeigner' => $this->CountHotelForeigner($client['id']),*/
        }
        echo json_encode(self::$reports);
    }



    public function connector($sql,$clientID)
    {
        return self::$admin->ConectDbClient($sql,$clientID, "Select", "", "", "");
    }


    public function clients()
    {
        $model = $this->getModel('clientsModel');
        $result = $model->get("id,AgencyName", true);

        $sql = $result->toSql();
        return $result->all();
    }

    public function CountArticle($clientID)
    {
        $startDate = self::convertor_date(self::$startDate,'Article');
        $endDate = self::convertor_date(self::$endDate,'Article');

        $result = [];
        foreach (self::$CountArticle as $article) {
            //for example => SELECT COUNT(id) as count  FROM articles_tb WHERE section = 'mag' AND created_at BETWEEN '2024-02-29' AND '2024-10-08'
            $sql =  "SELECT COUNT(id) as count  FROM articles_tb WHERE section = '{$article}' AND created_at BETWEEN '{$startDate}' AND '{$endDate}'";
            $result[$article] = $this->connector($sql,$clientID);
        }
        return $result;
    }


    public function CountHotelInternal($clientID)
    {
        $startDate = self::$startDate;
        $endDate = self::$endDate;
        $sql = "select count(id) as count from reservation_hotel_tb WHERE country = 1 AND creation_date_int BETWEEN {$startDate} AND {$endDate}";
        return $this->connector($sql,$clientID);

    }

    public function CountHotelForeigner($clientID)
    {
        $startDate = self::$startDate;
        $endDate = self::$endDate;
        $sql = "SELECT count(id) as count FROM reservation_hotel_tb where country > 1 AND creation_date_int BETWEEN '{$startDate}' AND '{$endDate}'";
        return $this->connector($sql,$clientID);

    }

    public function CountTourInternal($clientID)
    {
        $startDate = self::convertor_date(self::$startDate,'Tour');
        $endDate = self::convertor_date(self::$endDate,'Tour');

        $sql = "
          SELECT COUNT(*) as count FROM ( SELECT rh.id as tourID,id_same,tour_name,tour_code,create_date_in,start_date,fk_tour_id,tour_title,destination_country_id  FROM reservation_tour_tb rh INNER JOIN reservation_tour_rout_tb rtr ON rh.id = rtr.fk_tour_id 
            WHERE rtr.tour_title = 'dept' AND destination_country_id = 1 AND rh.create_date_in >= '{$startDate}' AND rh.create_date_in <= '{$endDate}' GROUP BY id_same
            ) AS subquery 
                ";

        return $this->connector($sql,$clientID);



    }

    public function CountTourForeigner($clientID)
    {
        $startDate = self::convertor_date(self::$startDate,'Tour');
        $endDate = self::convertor_date(self::$endDate,'Tour');

        
        $sql = "   SELECT COUNT(*) as count FROM ( SELECT rh.id as tourID,id_same,tour_name,tour_code,start_date,fk_tour_id,tour_title,destination_country_id  FROM reservation_tour_tb rh INNER JOIN reservation_tour_rout_tb rtr ON rh.id = rtr.fk_tour_id 
            WHERE rtr.tour_title = 'dept' AND destination_country_id != 1 AND rh.create_date_in >= '{$startDate}' AND rh.create_date_in <= '{$endDate}' GROUP BY id_same
            ) AS subquery";
        return $this->connector($sql,$clientID);
    }

    public function CountSpecialPages($clientID)
    {
        $startDate = self::convertor_date(self::$startDate,'Special');
        $endDate = self::convertor_date(self::$endDate,'Special');

        $sql = "SELECT COUNT(id) as count FROM special_pages_tb WHERE created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        return $this->connector($sql,$clientID);
    }



}