<?php

    error_reporting(1);
    error_reporting(E_ALL);
    @ini_set('display_errors', 1);
    @ini_set('display_errors', 'on');

    ini_set('max_execution_time', 300);


require_once ('trait/weatherTrait.php') ;

//require_once ('trait/weatherTrait.php') ;
//require_once ('config/bootstrap.php') ;
//require_once ('config/configBase.php') ;
//require_once ('library/functions.php') ;
//require_once ('library/ModelBase.php') ;
//require_once ('library/Load.php') ;
//require_once ('library/baseController.php') ;
//require_once ('library/clientAuth.php') ;
//require_once ('model/weatherModel.php') ;
//require_once ('model/weatherDataModel.php') ;

class ApiWeatherCronjob extends clientAuth
{
    public $transactions;

    public function __construct() {

        parent::__construct();



    }
    public function getCityAll(){

        $city_model = $this->getModel('weatherModel')->get() ;
        if(SOFTWARE_LANG != 'fa') {
            $city_model = $city_model->where('lang' , 'en');
        }

        return  $city_model->all();
    }

    public function getWeatherSelect() {

        $city_list = $this->getCityAll();
//        $city_list = [
//            'Tehran' => [
//                'id' => 1,
//                'en' => 'Tehran',
//                'fa' => 'تهران',
//                'ar' => 'طهران',
//                'code' => '112931'
//            ],
//            'Bushehr' => [
//                'id' => 2,
//                'en' => 'Bushehr',
//                'fa' => 'بوشهر',
//                'ar' => 'بوشهر',
//                'code' => '139817'
//            ],
//            'Kerman' => [
//                'id' => 5,
//                'en' => 'Kerman',
//                'fa' => 'کرمان',
//                'ar' => 'کرمان',
//                'code' => '128231'
//            ],
//            'Qom' => [
//                'id' => 7,
//                'en' => 'Qom',
//                'fa' => 'قم',
//                'ar' => 'مدينة قم',
//                'code' => '443794'
//            ],
//            'Qazvin' => [
//                'id' => 8,
//                'en' => 'Qazvin',
//                'fa' => 'قزوین',
//                'ar' => 'القزوین',
//                'code' => '119505'
//            ],
//            'Semnan' => [
//                'id' => 9,
//                'en' => 'Semnan',
//                'fa' => 'سمنان',
//                'ar' => 'سمنان',
//                'code' => '116402'
//            ],
//            'Yazd' => [
//                'id' => 10,
//                'en' => 'Yazd',
//                'fa' => 'یزد',
//                'ar' => 'يزد',
//                'code' => '111821'
//            ],
//            'Tabriz' => [
//                'id' => 11,
//                'en' => 'Tabriz',
//                'fa' => 'تبریز',
//                'ar' => 'مدينة تبریز',
//                'code' => '113646'
//            ],
//            'Ilam' => [
//                'id' => 12,
//                'en' => 'Ilam',
//                'fa' => 'ایلام',
//                'ar' => 'محافظة ایلام',
//                'code' => '130801'
//            ],
//            'Rasht' => [
//                'id' => 14,
//                'en' => 'Rasht',
//                'fa' => 'رشت',
//                'ar' => 'رشت',
//                'code' => '118743'
//            ],
//            'Mashhad' => [
//                'id' => 15,
//                'en' => 'Mashhad',
//                'fa' => 'مشهد',
//                'ar' => 'مشهد',
//                'code' => '124665'
//            ],
//            'Gheshm' => [
//                'id' => 17,
//                'en' => 'Gheshm',
//                'fa' => 'قشم',
//                'ar' => 'قشم',
//                'code' => '119374'
//            ],
//            'Dubai' => [
//                'id' => 30,
//                'en' => 'Dubai',
//                'fa' => 'دبی',
//                'ar' => 'دبي',
//                'code' => '292223'
//            ],
//            'Antalya' => [
//                'id' => 32,
//                'en' => 'Antalya',
//                'fa' => 'آنتالیا',
//                'ar' => 'أنطاليا',
//                'code' => '323776'
//            ],
//            'Beijing' => [
//                'id' => 33,
//                'en' => 'Beijing',
//                'fa' => 'پکن',
//                'ar' => 'بكين',
//                'code' => '181667'
//            ],
//            'Shanghai' => [
//                'id' => 34,
//                'en' => 'Shanghai',
//                'fa' => 'شانگهای',
//                'ar' => 'شانغهاي',
//                'code' => '179623'
//            ],
//            'Bangkok' => [
//                'id' => 35,
//                'en' => 'Bangkok',
//                'fa' => 'بانکوک',
//                'ar' => 'بانكوك',
//                'code' => '160934'
//            ],
//            'Jakarta' => [
//                'id' => 37,
//                'en' => 'Jakarta',
//                'fa' => 'جاکارتا',
//                'ar' => 'جاكرتا',
//                'code' => '164291'
//            ],
//            'Mecca' => [
//                'id' => 38,
//                'en' => 'Mecca',
//                'fa' => 'مکه',
//                'ar' => 'مكة المكرمة',
//                'code' => '537196'
//            ],
//            'Karbala' => [
//                'id' => 39,
//                'en' => 'Karbala',
//                'fa' => 'کربلا',
//                'ar' => 'كربلاء',
//                'code' => '94824'
//            ],
//            'Doha' => [
//                'id' => 40,
//                'en' => 'Doha',
//                'fa' => 'دوحه',
//                'ar' => 'الدوحة',
//                'code' => '290030'
//            ],
//            'Sofia' => [
//                'id' => 41,
//                'en' => 'Sofia',
//                'fa' => 'صوفیه',
//                'ar' => 'صوفيا',
//                'code' => '727011'
//            ],
//            'Moscow' => [
//                'id' => 42,
//                'en' => 'Moscow',
//                'fa' => 'مسکو',
//                'ar' => 'موسكو',
//                'code' => '520200'
//            ],
//            'London' => [
//                'id' => 43,
//                'en' => 'London',
//                'fa' => 'لندن',
//                'ar' => 'لندن',
//                'code' => '536781'
//            ]
//        ];

        $weatherData = [];
        foreach ($city_list as $city) {
            $cityRequest = $this->curlWeatherApi($city['title_en']);
            functions::insertLog('data fetch core with req ==>' . $city['title_en'] . '==>' . json_encode($cityRequest, 256), 'getWeatherApi');
            $result = weatherTrait::createWeatherData($cityRequest);
            $weatherData[$city['title_en']] = [
                'title_show' => $city['title'],
                'country' => $result['country'],
                'title_en' => $city['title_en'],
                'pic' => $result['pic'],
                'temp' => $result['temp'],
                'description' => $result['description'],
                'pressure' => $result['pressure'],
                'humidity' => $result['humidity'],
                'speed' => $result['speed'],
                'list' => $result['list'],
                'title_ar' => $city['title_ar'],
                'query_id' => $city['id']
            ];
        }

        if ($result) {

        } else {
            return 'خطا در دریافت دیتا از api';
        }

        $weather_model = $this->getModel('weatherDataModel') ;
        $delete_weather_data = $weather_model->delete(true) ;
        if (!$delete_weather_data) {
            return 'حذف دیتای قبلی با خطا مواجه شد';
        }
        foreach ($weatherData as $weatherDataCity) {
            $insert_weather_data = $weather_model->insertWithBind([
                'title_show' => $weatherDataCity['title_show'],
                'country' => $weatherDataCity['country'],
                'title_en' => $weatherDataCity['title_en'],
                'pic' => $weatherDataCity['pic'],
                'temp' => $weatherDataCity['temp'],
                'description' => $weatherDataCity['description'],
                'pressure' => $weatherDataCity['pressure'],
                'humidity' => $weatherDataCity['humidity'],
                'speed' => $weatherDataCity['speed'],
                'list' => json_encode($weatherDataCity['list']),
                'title_ar' => $weatherDataCity['title_ar'],
                'updated_at' => date('Y-m-d H:i:s', time()),
                'query_id' => $weatherDataCity['query_id']
            ]);
        }

        if ($insert_weather_data) {
            return 'دیتا با موفقیت ذخیره شد';
        } else {
            return 'ذخیره دیتا با خطا مواجه شد';
        }
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
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_PROXY => '',
            CURLOPT_CONNECTTIMEOUT => 300,
            CURLOPT_TIMEOUT => 60
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



}

$ApiWeatherCronjob = new ApiWeatherCronjob();
$test = $ApiWeatherCronjob->getWeatherSelect();

echo '<pre>';
var_dump($test);