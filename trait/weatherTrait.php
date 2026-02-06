<?php

trait weatherTrait{
    public static function weatherPic($code) {
        switch ($code){
            case "clear sky":
                $pic = 'assets/images/weather/brightness.png';
                break;

            case "few clouds":
                $pic = 'assets/images/weather/cloud.png';
                break;

            case "scattered clouds":
                $pic = 'assets/images/weather/fewcloud.png';
                break;

            case "broken clouds":
                $pic = 'assets/images/weather/broken_cloud.png';
                break;

            case "shower rain":
                $pic = 'assets/images/weather/rainy.png';
                break;

            case "rain":
                $pic = 'assets/images/weather/storm.png';
                break;

            case "thunderstorm":
                $pic = 'assets/images/weather/thunderstorm.png';
                break;

            case "snow":
                $pic = 'assets/images/weather/snow.png';
                break;

            case "light snow":
                $pic = 'assets/images/weather/snow.png';
                break;
            case "mist":
                $pic = 'assets/images/weather/fog.png';
                break;

            case "light rain":
                $pic = 'assets/images/weather/wind.png';
                break;

            case "overcast clouds":
                $pic = 'assets/images/weather/clouds-and-sun.png';
                break;
            case "moderate rain":
                $pic = 'assets/images/weather/storm.png';
                break;

            default:
                $pic = '';
                break;
        }
        return $pic;
    }

    public static function WeatherConditionCodesPersian($code)
    {
        switch ($code){
            case "clear sky":
                return "##ClearSky##";
            case "few clouds":
                return "##FewClouds##";
            case "scattered clouds":
                return "##ScatteredClouds##";
            case "broken clouds":
                return "##BrokenClouds##";
            case "shower rain":
                return "##ShowerRain##";
            case "rain":
                return "##Rain##";
            case "thunderstorm":
                return "##ThunderStorm##";
            case "snow":
                return "##Snow##";
            case "light snow":
                return "##Snow##";
            case "mist":
                return "##Mist##";
            case "light rain":
                return "##LightRain##";
            case "overcast clouds":
                return "##OvercastClouds##";
            case "moderate rain":
                return "##ModerateRain##";
            default:
                return '';
        }
    }

    public static function getWeatherTitle($weather) {
        if ( SOFTWARE_LANG == 'fa' ) {
            return $weather['title'];
        }else if( SOFTWARE_LANG == 'ar' ) {
            return $weather['title_ar'];
        }else{
            return $weather['title_en'];
        }
    }

    public static function createWeatherData($weather) {
        $cityLastItem =  $weather['list'][0];
        $pic_weather  = self::weatherPic($cityLastItem['weather'][0]['description']);
        $description  = self::WeatherConditionCodesPersian($cityLastItem['weather'][0]['description']);
        return [
            'id' => $weather['id'],
            'title' => $weather['title'],
            'title_en' => $weather['title_en'] ,
            'code' => $weather['code'] ,
            'name' => $weather['city']['name'],
            'country' => $weather['city']['country'],
            'temp' => $cityLastItem['main']['temp'],
            'pressure' => $cityLastItem['main']['pressure'],
            'humidity' => $cityLastItem['main']['humidity'],
            'speed' => $cityLastItem['wind']['speed'],
            'description' => $description,
            'pic' => $pic_weather,
            'icon' => $cityLastItem['weather'][0]['icon'],
            'list' => $weather['list']
        ];
    }
}