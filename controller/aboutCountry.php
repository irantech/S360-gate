<?php

class  aboutCountry extends clientAuth {

    private $parvazUrl;
    private $tunnel ;
    public function __construct() {
        parent::__construct();
        $this->tunnel = tunnel_url;
        if (strpos($_SERVER['HTTP_HOST'], '192.168.') === false) {
            $this->parvazUrl = 'https://www.iran-tech.com/old/v10/fa/admin/keshvar_portal/';
        } else{
            $this->parvazUrl = 'http://192.168.1.100/parvaz_persian/fa/admin/keshvar_portal/';
        }

    }

    function my_substr($text, $start = 0, $end) {
        if (empty($text))
            return '';

        if (strlen($text) > $end) {
            $endText = '...';
        } else {
            $endText = '';
        }
        $out = mb_strcut($text, $start, $end, "UTF-8");

        $text = '' . $out . '' . $endText . '';
        return $text;
    }
    
    public function GetCountry() {
        $url = $this->parvazUrl.'gds_country_list.php';
        return $this->getResult($url) ;
    }

    public function getAboutCountry($id) {
        $url = $this->parvazUrl.'gds_country_info.php?id='.$id;
        return $this->getResult($url) ;
    }

    public function getOtherCountry($id) {
        $url = $this->parvazUrl.'gds_other_country_list.php?id='.$id;
        return $this->getResult($url) ;
    }


    public function getOtherCountryInfo($id , $countryId) {
        $url = $this->parvazUrl.'gds_other_country_info.php?id='.$id.'&countryId='.$countryId;
        return $this->getResult($url) ;
    }

    private function getResult($iran_tech_url) {
        if (strpos($_SERVER['HTTP_HOST'], '192.168.') === false) {
            return functions::curlExecution($iran_tech_url , '');
        }else{
            $data['safar360_url'] = $iran_tech_url ;
            return functions::curlExecution($this->tunnel ,json_encode($data));
        }

    }


}