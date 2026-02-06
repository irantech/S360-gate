<?php

class general extends dateTimeSetting {

    public function __construct() {
        
    }

    /* function subStr($string,$start='0',$length=''){
      ($length != '')?($str=substr($string, $start,$length)):($str=substr($string, $start)) ;
      return $str;
      } */

    function miladitoshamsi($tarikh) {
        if (strpos($tarikh, '-') === false) {
            $jyear1 = substr($tarikh, 0, 4);
            $jmonth1 = substr($tarikh, 4, 2);
            $jday1 = substr($tarikh, 6, 2);
        } else {
            $jyear1 = substr($tarikh, 0, 4);
            $jmonth1 = substr($tarikh, 5, 2);
            $jday1 = substr($tarikh, 8, 2);
        }
        
        return parent::gregorian_to_jalali($jyear1, $jmonth1, $jday1, '-');
    }

    function shamsitomiladi($tarikh) {
        if (strpos($tarikh, '-') === false) {
            $jyear1 = substr($tarikh, 0, 4);
            $jmonth1 = substr($tarikh, 4, 2);
            $jday1 = substr($tarikh, 6, 2);
        } else {
            $jyear1 = substr($tarikh, 0, 4);
            $jmonth1 = substr($tarikh, 5, 2);
            $jday1 = substr($tarikh, 8, 2);
        }

        return parent::jalali_to_gregorian($jyear1, $jmonth1, $jday1, '-');
    }

    function typeDate($tarikh) {
        if (strpos($tarikh, '-') === false) {
            $jyear1 = substr($tarikh, 0, 4);
            $jmonth1 = substr($tarikh, 4, 2);
            $jday1 = substr($tarikh, 6, 2);
        } else {
            $jyear1 = substr($tarikh, 0, 4);
            $jmonth1 = substr($tarikh, 5, 2);
            $jday1 = substr($tarikh, 8, 2);
        }

        if ($jyear1 < 1700) {
            return 'solar';
        } else {
            return 'miladi';
        }
    }

    function lenthTime($time) {
        $time = str_replace('H', 'ساعت', $time);
        $time = str_replace('M', 'دقیقه', $time);
        return $time;
    }

    public function getAirlinePhoto($iata) {
        $airline = Load::model('airline');
        $rec = $airline->getByIata($iata);
      
        return ROOT_ADDRESS_WITHOUT_LANG . "/pic/airline/" . $rec['photo'];
    }

    public function classTime($time) {
        if ($time < 8) {
            echo 'early';
        } elseif ($time < 12) {
            echo 'morning';
        } elseif ($time < 18) {
            echo 'afternoon';
        } elseif ($time < 24) {
            echo 'night';
        }
    }

    /**
     * this function divides time into four parts: early, morning, afternoon, night
     * @param string $time in 24 hours format
     * @return early for (0-8) or morning for (8-12) or afternoon for (12-18) or night for (18-24)
     * @author Naime Barati
     */
    public function classTimeLOCAL($time) {
        
        if(substr($time, 0, 1) == '0'){
            $hour = substr($time, 1, 1);
        } else{
            $hour = substr($time, 0, 2);
        }

        if ($hour >= 0 && $hour < 8) {
            echo 'early';
        } elseif ($hour >= 8 && $hour < 12) {
            echo 'morning';
        } elseif ($hour >= 12 && $hour < 18) {
            echo 'afternoon';
        } elseif ($hour >= 18 && $hour < 24) {
            echo 'night';
        }
    }

    public function getAirlines() {
        $airline = Load::model('airline');
        return $airline->getAllSort();
    }
    

    
    

}

?>
