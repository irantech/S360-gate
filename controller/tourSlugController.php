<?php

class tourSlugController extends slugController implements slugInterface
{
    protected static $model = reservationTour::class;

    /**
     * Initializes the data for tour slugs.
     *
     * This function retrieves all non-deleted countries, generates slugs for each country,
     * and then iterates through each country to generate slugs for its cities.
     * The generated slugs are stored in the database.
     *
     * @return string Returns the string "store" upon successful completion.
     */
    public function initData() {

        $countries = $this->getModel(reservationCountryModel::class)->get()->where('is_del', 'no')->all();




        $this->store(['en' => "All tours",'ru' => "All tours", 'ar' => "جميع التور", 'fa' => "همه‌ی تور ها"], ['city_id' => 'all', 'country_id' => 'all']);
        foreach ($countries as $country) {

            $this->store([
                'fa' => $this->generateEntitySlug('fa', $country),
                'en' => $this->generateEntitySlug('en', $country),
                'ru' => $this->generateEntitySlug('en', $country),
                'ar' => $this->generateEntitySlug('ar', $country),
            ], ['city_id' => 'all', 'country_id' => $country['id']]);


            $cities = $this->getModel('reservationCityModel')->get()->where('id_country', $country['id'])->all();

            foreach ($cities as $city) {
                $this->storeEntitySlugs($city, $country['id']);
            }
        }

        return "store";
    }

    public function generateEntitySlug($lang, $entity) {
     
        $nameKey = $lang === 'fa' ? 'name' : 'name_' . $lang;
        if(!empty($entity[$nameKey])) {
            $name = $entity[$nameKey];
        }else{
            if(!empty($entity['name'])) {
                $name = $entity['name'];
            }else{
                $name = null;
            }
        }
//        $name = isset($entity[$nameKey]) ? $entity[$nameKey] : isset($entity['name']) ? $entity['name'] : null;

        $default = $name;

        return $this->generateSlug($lang, $name, $default);
    }

    private function generateSlug($lang, $name, $default) {
        $translations = [
            'en' => $name ? "$name" : $default,
            'ar' => $name ? "$name" : "همه‌ی التور ها",
            'fa' => $name ? "$name" : "همه‌ی تور ها",
            'ru' => $name ? "$name" : $default,
        ];
        return isset($translations[$lang]) ? $translations[$lang] : $default;
    }

    private function storeEntitySlugs($entity, $countryId) {

        $this->store([
            'fa' => $this->generateEntitySlug('fa', $entity),
            'en' => $this->generateEntitySlug('en', $entity),
            'ru' => $this->generateEntitySlug('ru', $entity),
            'ar' => $this->generateEntitySlug('ar', $entity),
        ], ['city_id' => $entity['id'], 'country_id' => $countryId]);
    }


    public function redirectToSlug($doRedirect = true, $isOld = false) {

        if ($isOld) {
            return ROOT_ADDRESS . "/resultTourLocal/" . SEARCH_ORIGIN_COUNTRY . "-" . SEARCH_ORIGIN_CITY . "/" . SEARCH_DESTINATION_COUNTRY . "-" . SEARCH_DESTINATION_CITY . "/all/all";
        }


        // Get destination slug
        $destSlug = $this->reverse([
            'country_id' => SEARCH_DESTINATION_COUNTRY,
            'city_id' => SEARCH_DESTINATION_CITY,
        ]);

//        if ($_SERVER['REMOTE_ADDR'] == '93.118.161.174') {
//            var_dump('33destSlug222');
//            var_dump($_GET);
//            echo 'aaaaaaaaaaaaa';
//            echo '<br>';
//            var_dump($_POST);
//            die('awd');
//
//        }
        $ROOT_ADDRESS = ROOT_ADDRESS;
        $SOFTWARE_LANG = SOFTWARE_LANG;

        // Build the base URL
        $baseUrl = "${ROOT_ADDRESS}/tours/";



        if ($destSlug) {

            // Case 1: Both origin country and city are 'all'
            if (SEARCH_ORIGIN_COUNTRY === 'all' && SEARCH_ORIGIN_CITY === 'all' && SEARCH_DESTINATION_COUNTRY === 'all' && SEARCH_DESTINATION_CITY === 'all') {
                $baseUrl .= "همه‌ی-تور-ها";
            }
            else if (SEARCH_ORIGIN_COUNTRY === 'all' && SEARCH_ORIGIN_CITY === 'all') {
                $baseUrl .= "همه‌ی-تور-های-" . $destSlug["slug_${SOFTWARE_LANG}"];
            }
            // Case 2: Origin country is specific but city is 'all'
            else if (SEARCH_ORIGIN_COUNTRY === '1' && SEARCH_ORIGIN_CITY === 'all') {
                $baseUrl .= "تور-های-" . $destSlug["slug_${SOFTWARE_LANG}"];
            }
            // Case 3: Both origin country and city are specific
            else {
                // Get origin slug
                $originSlug = $this->reverse([
                    'country_id' => SEARCH_ORIGIN_COUNTRY,
                    'city_id' => SEARCH_ORIGIN_CITY,
                ]);

                if ($originSlug) {
                    // Changed from "-به-" to "-از-"
                    $baseUrl .= "تور-های-" . $destSlug["slug_${SOFTWARE_LANG}"] . "-از-" . $originSlug["slug_${SOFTWARE_LANG}"];
                } else {
                    $baseUrl .= "تور-های-" . $destSlug["slug_${SOFTWARE_LANG}"];
                }


            }
        }


        // Add remaining query parameters if they exist
        $get = '';
        if ((SEARCH_DATE && SEARCH_DATE !== 'all') || (SEARCH_TOUR_TYPE && SEARCH_TOUR_TYPE !== 'all')) {
            $get = '?';

            if (SEARCH_DATE && SEARCH_DATE !== 'all') {
                $date = SEARCH_DATE;
                if (functions::isDateShamsi($date)) {
                    $miladi = functions::ConvertToMiladi($date);
                    $shamsi = $date;
                } else {
                    $miladi = $date;
                    $shamsi = functions::ConvertToJalali($date);
                }
                defined('MILADI_SEARCH_DATE') or define('MILADI_SEARCH_DATE', $miladi);
                defined('SEARCH_DATE') or define('SEARCH_DATE', $shamsi);
                $get .= 'date=' . $shamsi . '&';
            }

            if (SEARCH_TOUR_TYPE && SEARCH_TOUR_TYPE !== 'all') {
                $get .= 'type=' . SEARCH_TOUR_TYPE . '&';
            }
            $get = rtrim($get, '&');
        }

        $url = $baseUrl . $get;

        if ($doRedirect) {
            header("Location: $url");
            exit();
        } else {
            return $url;
        }
    }


    public function defineSluggedPage() {

        $check=$this->getModel('slugModel')
            ->get('id')
            ->where('model', self::$model)
            ->find();

        if($check===false){
            $this->initData();
        }

        if (!SLUG) {
            require SITE_ROOT . '/404.shtml';
            exit();
        }

        // Remove query parameters if present
        $cleanSlug = strtok(SLUG, '&?');



        // Handle different slug patterns
        if (strpos($cleanSlug, 'همه‌ی-تور-های-') === 0) {

            // Case 2: همه‌ی-تور-های-یزد
            $destSlugPart = str_replace('همه‌ی-تور-های-', '', $cleanSlug);
            defined('SEARCH_ORIGIN_COUNTRY') or define('SEARCH_ORIGIN_COUNTRY', 'all');
            defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', 'all');
        }
        else if ($cleanSlug === 'همه‌ی-تور-ها') {  // Use exact match for this case
            // Case 1: همه‌ی-تور-ها
            $destSlugPart = $cleanSlug;


            defined('SEARCH_ORIGIN_COUNTRY') or define('SEARCH_ORIGIN_COUNTRY', 'all');
            defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', 'all');
            defined('SEARCH_DESTINATION_COUNTRY') or define('SEARCH_DESTINATION_COUNTRY', 'all');
            defined('SEARCH_DESTINATION_CITY') or define('SEARCH_DESTINATION_CITY', 'all');
        } else {

            // Check for origin-destination pattern
            $parts = explode('-از-', $cleanSlug); // Changed from '-به-' to '-از-'

            if (count($parts) > 1) {
                // Case 3: تور-های-مشهد-از-تهران
                $destSlugPart = str_replace('تور-های-', '', $parts[0]);
                $originSlugPart = $parts[1];

                // Get origin information
                $originSlug = $this->getSlug($originSlugPart);
                if ($originSlug) {
                    defined('SEARCH_ORIGIN_COUNTRY') or define('SEARCH_ORIGIN_COUNTRY', $originSlug['data']['country_id']);
                    defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', $originSlug['data']['city_id']);
                } else {
                    require SITE_ROOT . '/404.shtml';
                    exit();
                }
            } else {
                // Case 3: تور-های-یزد
                $destSlugPart = str_replace('تور-های-', '', $cleanSlug);
                defined('SEARCH_ORIGIN_COUNTRY') or define('SEARCH_ORIGIN_COUNTRY', '1');
                defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', '1');
            }
        }



        // Get destination information


        $destSlug = $this->getSlug($destSlugPart);

        if (!$destSlug) {
            require SITE_ROOT . '/404.shtml';
            exit();
        }

        // Set destination constants
        defined('SEARCH_DESTINATION_COUNTRY') or define('SEARCH_DESTINATION_COUNTRY', $destSlug['data']['country_id']);
        defined('SEARCH_DESTINATION_CITY') or define('SEARCH_DESTINATION_CITY', $destSlug['data']['city_id']);


        // Handle other parameters
        if (isset($_GET['type'])) {
            defined('SEARCH_TOUR_TYPE') or define('SEARCH_TOUR_TYPE', $_GET['type']);
        } else {
            defined('SEARCH_TOUR_TYPE') or define('SEARCH_TOUR_TYPE', 'all');
        }

        if (isset($_GET['date'])) {
            $date = $_GET['date'];
            if (functions::isDateShamsi($date)) {
                $shamsi = $date;
                $miladi = functions::ConvertToMiladi($date);
            } else {
                $shamsi = functions::ConvertToJalali($date);
                $miladi = $date;
            }
            defined('SEARCH_DATE') or define('SEARCH_DATE', $shamsi);
            defined('MILADI_SEARCH_DATE') or define('MILADI_SEARCH_DATE', $miladi);
        } else {
            defined('SEARCH_DATE') or define('SEARCH_DATE', 'all');
            defined('MILADI_SEARCH_DATE') or define('MILADI_SEARCH_DATE', 'all');
        }

        defined('SEARCH_TOUR_SPECIAL') or define('SEARCH_TOUR_SPECIAL', '0');
        defined('REQUEST') or define('REQUEST', GDS_SWITCH);

        /*dd([
            'SEARCH_ORIGIN_COUNTRY'=>SEARCH_ORIGIN_COUNTRY,
            'SEARCH_ORIGIN_CITY'=>SEARCH_ORIGIN_CITY,
            'SEARCH_DESTINATION_COUNTRY'=>SEARCH_DESTINATION_COUNTRY,
            'SEARCH_DESTINATION_CITY'=>SEARCH_DESTINATION_CITY,
        ]);*/


        if (!$destSlug['self']) {
            $self_slug = $this->getByParentId($destSlug['id']);
            if ($self_slug) {
                $this->redirectToSlug(true);
            }
        }
    }

    public function defineTourDetailSluggedPage() {

        $ROOT_ADDRESS = ROOT_ADDRESS;
        $TOUR_ID_SAME = TOUR_ID_SAME;
        $TOUR_NAME_EN = TOUR_NAME_EN;
        $tour = $this->getController('mainTour')->getTourByIdSame($TOUR_ID_SAME);

        if (!$tour) {

            $detail_tour_slug = str_replace('-', ' ', TOUR_NAME_EN);
            $slugged_tour = $this->getController('mainTour')->getTourBySlug($detail_tour_slug);

            if ($slugged_tour) {
                $new_tour_id = $slugged_tour[0]['id_same'];
                header("Location: $ROOT_ADDRESS/detailTour/$new_tour_id/$TOUR_NAME_EN");
                exit();
            } else {
                header("HTTP/1.1 410 Gone");
                include_once './410.shtml';
                exit();
            }

        }
        else if($tour['is_del'] == 'yes'){
            header("HTTP/1.1 410 Gone");
            include_once './410.shtml';
            exit();
        }
        else if (isset($tour['tour_name_en'])) {
            $tour_slug = str_replace(' ', '-', $tour['tour_name_en']);
            if ($tour_slug != TOUR_NAME_EN) {
                header("Location: $ROOT_ADDRESS/detailTour/$TOUR_ID_SAME/$tour_slug");
                exit();
            }

        }
    }

}
