<?php

//error_reporting(1);
//error_reporting(E_ALL);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

require_once ('contract/weatherInterface.php') ;
require_once ('trait/weatherTrait.php') ;
require_once ('service/weatherService.php') ;


class weather extends clientAuth
{
    use weatherTrait;
    /**
     * @var string
     */
    private $page_limit,$weather_tb, $weather_select_tb, $appId;
    /**
     * @var string
     */


    public function __construct() {
        parent::__construct();
        $this->weather_tb = 'weather_tb';
        $this->weather_select_tb = 'weather_select_tb';
        $this->appId = '4a4eba4c785db8c63f636665c90c6cf3';
        $this->page_limit = 6;
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function listWeather() {
        $weather_select=$this->getModel('weatherSelectModel')->get()
            ->all();
        $list_select = '';
        foreach ($weather_select as $select) {
            $last_arr[] = $select['weather_id'];
            $list_select = implode(',',$last_arr);
        }


        $weathers=$this->getModel( 'weatherModel')
            ->get()
            ->all();

        $list = [];
        $explode = explode(',', $list_select);
           foreach ($weathers as $weather) {
                  if (in_array($weather['id'], $explode)) {
                      $active = 'is_active';
                  } else {
                      $active = 'non_active';
                  }
                  $list[] = [
                      'id' => $weather['id'],
                      'title' => $weather['title'],
                      'title_en' => $weather['title_en'] ,
                      'title_ar' => $weather['title_ar'] ,
                      'code' => $weather['code'] ,
                      'active' => $active
                  ];
        }
        return $list;
    }

    public function getWeather() {
        //            $url = 'http://api.openweathermap.org/data/2.5/forecast?id='.$weather['code'].'&lang=en&units=metric&APPID='.$this->appId.'';

        $weather_select=$this->getModel('weatherSelectModel')->get()->all() ;

        $list_select = '';
        foreach ($weather_select as $select) {
            $last_arr[] = $select['weather_id'];
            $list_select = implode(',',$last_arr);
        }
        $weathers=$this->getModel( 'weatherModel')
            ->get();
        if(SOFTWARE_LANG != 'fa') {
            $weathers= $weathers->where('lang' , 'en');
        }

        $weathers= $weathers->all(false);
        $list = [];
        $explode = explode(',', $list_select);
        foreach ($weathers as $key => $weather) {

            $active = in_array($weather['id'], $explode) ? 'is_active' : 'non_active' ;
            $weatherService = new weatherService() ;
            $cityRequest = $weatherService->getWeatherData($weather['title_en']);
            $list[$key] = weatherTrait::createWeatherData($cityRequest);
            $list[$key]['active'] = $active;
            $list[$key]['title_show'] = weatherTrait::getWeatherTitle($weather);

        }

        return $list;
    }
    public function getWeatherSelect() {
        $weather_select=$this->getModel('weatherSelectModel')->orderBy('id' , 'desc')->get()->find() ;
        if($weather_select) {
            $query_id = $weather_select['weather_id'] ;
        }else {
            $query_id = 1 ;
        }
        $weather = $this->getModel( 'weatherDataModel')
            ->get()->where('query_id' , $query_id)->find(false);
//        if(SOFTWARE_LANG != 'fa') {
//            $weather= $weather->where('lang' , 'en');
//        }
//        $weather = $weather->find(false);

        $weather['list'] = json_decode($weather['list'], true);
//
//
//        $weatherService = new weatherService() ;
//        $cityRequest = $this->curlWeatherApi($weather['title_en']);
//        $result = weatherTrait::createWeatherData($cityRequest);
//        $result['title_show'] = weatherTrait::getWeatherTitle($weather);
//        $result['title'] = $weather['title'];
//        $result['title_en'] =$weather['title_en'];
        return $weather;
    }

    public function getCityWeather($params) {

        $weather = $this->getModel( 'weatherDataModel')
            ->get()->where('title_en' , $params['city_name']);
//        if(SOFTWARE_LANG != 'fa') {
//            $weather= $weather->where('lang' , 'en');
//        }
        $weather= $weather->find(false);

        $weather['list'] = json_decode($weather['list'], true);


//        $weatherService = new weatherService() ;
//        $cityRequest = $weatherService->getWeatherData($weather['title_en']);
//        $result = weatherTrait::createWeatherData($cityRequest);
//        $result['title_show'] = weatherTrait::getWeatherTitle($weather);
//        $result['title'] = $weather['title'];
//        $result['title_en'] =$weather['title_en'];

        return functions::JsonSuccess($weather ,  'درخواست با موفقیت انجام شد');
    }

    public function curlWeatherApi($city)
    {
        $url = 'https://api.codebazan.ir/weather/?city='.$city.'';
        $error = null;
        $data = null;

        $ch = curl_init(); // شروع درخواست

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_PROXY => '' // غیرفعال کردن پراکسی
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = [
                'error' => 'خطا در اتصال cURL',
                'details' => curl_error($ch)
            ];
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode !== 200) {
                $error = [
                    'error' => 'کد وضعیت HTTP معتبر نیست',
                    'http_code' => $httpCode
                ];
            } else {
                $data = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $error = [
                        'error' => 'خطا در تجزیه JSON',
                        'raw_response' => $response
                    ];
                }
            }
        }

        curl_close($ch); // بستن اتصال

        if ($error) {
            return $error;
        } else {
            return $data;
        }
    }

    public function findWeatherById($id) {
        return $this->getModel('weatherModel')->get()->where('id' , $id)->find();
    }

    public function findWeatherByIdSelect($id) {
        return $this->getModel('weatherSelectModel')->get()->where('weather_id' , $id)->find();
    }

    public function updateStatusWeather($data_update) {
        $check_exist_weather = $this->findWeatherById($data_update['id']);
        $check_exist_weather_select = $this->findWeatherByIdSelect($data_update['id']);
            if ($check_exist_weather_select) {
                $this->getModel('weatherSelectModel')->delete("weather_id='{$data_update['id']}'");

            }else {

                $this->getModel('weatherSelectModel')->delete("weather_id!='{$data_update['id']}'");
                $dataWeather = [
                    'code' => $check_exist_weather['code'],
                    'weather_id' => $check_exist_weather['id'],
                    'created_at' => date('Y-m-d H:i:s', time()),
                ];
                $this->getModel('weatherSelectModel')->insertWithBind($dataWeather);
            }
        return self::returnJson(true, 'تغییر شهر منتخب با موفقیت انجام شد');

    }


    public function getCityAll(){

        $city_model = $this->getModel('weatherModel')->get() ;
        if(SOFTWARE_LANG != 'fa') {
            $city_model = $city_model->where('lang' , 'en');
        }

        return  $city_model->all();
    }

    public function mainWeather($param) {
        return null;
        $result = $this->getModel('weatherModel')->get()->where('id', $param['cityId'])->find();
        $url = 'http://api.openweathermap.org/data/2.5/forecast?id='.$result['code'].'&lang=en&units=metric&APPID='.$this->appId.'';
        $cityRequest = functions::curlExecution($url,'');
        $cityLastItem = $cityRequest['list'][0];
        $pic_weather = $this->weatherPic($cityLastItem['weather'][0]['description']);
        $description = $this->WeatherConditionCodesPersian($cityLastItem['weather'][0]['description']);
        $image_url = ROOT_ADDRESS_WITHOUT_LANG . '/view/client/'.$pic_weather;
        $img = "<img src='".$image_url."' style='width: 50px;'>";
        $description_title = preg_replace("%##%", "", $description );
        if ( SOFTWARE_LANG == 'fa' ) {
            $title_show = $result['title'];
        }else if( SOFTWARE_LANG == 'ar' ) {
            $title_show = $result['title_ar'];
        }else{
            $title_show = $result['title_en'];
        }
          return json_encode([
            'id' => $result['id'],
            'title' => $title_show,
            'temp_max' => $cityLastItem['main']['temp_max'],
            'temp_min' => $cityLastItem['main']['temp_min'],
            'description_title' => functions::Xmlinformation($description_title)->__toString(),
            'image_url' => $pic_weather,
            'pic' => $img,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}


    public function findWeatherIdList_old($ids) {
        $result =  $this->getModel('weatherModel')->get('*')->whereIn('code', $ids)->all();
        return $result;
    }

    public function findWeatherIdList($ids) {
        $weather_select=$this->getModel('weatherSelectModel')->get()->all() ;

        $list_select = '';
        foreach ($weather_select as $select) {
            $last_arr[] = $select['weather_id'];
            $list_select = implode(',',$last_arr);
        }
        $weathers= $this->getModel('weatherModel')->get('*')->whereIn('code', $ids);
        if(SOFTWARE_LANG != 'fa') {
            $weathers= $weathers->where('lang' , 'en');
        }

        $weathers= $weathers->all(false);
//var_dump($weathers);
//die;
        $list = [];
//        return $list ;
        $explode = explode(',', $list_select);
        foreach ($weathers as $weather) {

//            $url = 'http://api.openweathermap.org/data/2.5/forecast?id='.$weather['code'].'&lang=en&units=metric&APPID='.$this->appId.'';
            $url = 'https://api.codebazan.ir/weather/?city='.$weather['title'].'';

            $cityRequest = functions::curlExecution($url,'');
//            echo "<pre>";
//            var_dump($cityRequest);
            $cityLastItem = $cityRequest['list'][0];
            $pic_weather = $this->weatherPic($cityLastItem['weather'][0]['description']);
            $description = $this->WeatherConditionCodesPersian($cityLastItem['weather'][0]['description']);

            if (in_array($weather['id'], $explode)) {
                $active = 'is_active';
            } else {
                $active = 'non_active';
            }
            if ( SOFTWARE_LANG == 'fa' ) {
                $title_show = $weather['title'];
            }else if( SOFTWARE_LANG == 'ar' ) {
                $title_show = $weather['title_ar'];
            }else{
                $title_show = $weather['title_en'];
            }
            $list[] = [
                'id' => $weather['id'],
                'title' => $weather['title'],
                'title_show' => $title_show,
                'title_en' => $weather['title_en'] ,
                'code' => $weather['code'] ,
                'active' => $active,
                'name' => $cityRequest['city']['name'],
                'country' => $cityRequest['city']['country'],
                'temp' => $cityLastItem['main']['temp'],
                'pressure' => $cityLastItem['main']['pressure'],
                'humidity' => $cityLastItem['main']['humidity'],
                'speed' => $cityLastItem['wind']['speed'],
                'description' => $description,
                'pic' => $pic_weather,
                'icon' => $cityLastItem['weather'][0]['icon'],
                'list' => $cityRequest['list']
            ];



        }

        return $list;
    }


}



