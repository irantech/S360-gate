<?php

/*if($_SERVER['REMOTE_ADDR'] == '192.168.1.25')
{
    phpinfo();
    die();
}*/

//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
if ((empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') && $_SERVER['REQUEST_METHOD'] !='POST' && $_SERVER['REMOTE_ADDR'] !='172.18.0.1') {
    // Construct the new URL with HTTPS
    $newUrl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Perform the 301 redirect
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $newUrl);
    exit();
}
//ini_set('memory_limit', '-1');

//error_reporting(0);


//if($_SERVER['REMOTE_ADDR']==='178.131.171.199'){
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


//date_default_timezone_set('Asia/Tehran');
require 'config/bootstrap.php';


if ($_SERVER['REMOTE_ADDR'] == '84.241.4.202' && CLIENT_ID=='327') {

    session_start();
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//    session_write_close();
//    session_regenerate_id(true);
//    var_dump($_SESSION);
//    die();
}



require CONFIG_DIR . 'config.php';



require LIBRARY_DIR . 'Load.php';

require CONFIG_DIR . 'application.php';

require LIBRARY_DIR . 'functions.php';


require LIBRARY_DIR . 'baseController.php';
require LIBRARY_DIR . 'Session.php';

require CONTROLLERS_DIR . 'dateTimeSetting.php';

//echo 'after required==>'. calculate_time($start) .'mili seconde'.'<hr/>';
;
//   error_reporting(1);
//   error_reporting(E_ALL | E_STRICT);
//   @ini_set('display_errors', 1);
//   @ini_set('display_errors', 'on');

if(CLIENT_ID == '166'){
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');

}

Session::init();


    Session::getDefaultCurrency();


//Session::setSessionSelectLayout();
    functions::setPwaSession();



/*if(in_array(CLIENT_ID , functions::isSuspend())) {
    ?>
    <img src='<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/pic/1024.jpg' alt='suspend' style='width:100%; height:100%;'>
<?php
    exit();
}*/


$date = dateTimeSetting::jdate("Y-m-d", "", "", "", "en");
defined('DATE') or define('DATE', $date);
spl_autoload_register(array('Load', 'autoload'));

$page = new application();




$pwa_access=functions::checkClientConfigurationAccess('pwa',CLIENT_ID);





// echo 'after pwa_access==>'. calculate_time($start) .'mili seconde'.'<hr/>';

if (functions::checkClientConfigurationAccess('redirect',CLIENT_ID)) {

    functions::redirectToNewUrl();
}




functions::redirectTo410();

if(GDS_SWITCH == 'mag' && SOFTWARE_LANG == 'fa') {
    functions::redirectWithLang();
}

/**
 * @return void
 */
if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
    if(CLIENT_ID == '390'){
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
        $slug_controller = new tourSlugController();
        $slug_controller->initData();
        die('awd');
    }
}


if (GDS_SWITCH == 'resultTourLocal' && (CLIENT_ID == '298' || CLIENT_ID == '292'  ||  CLIENT_ID == '224' ||  CLIENT_ID == '325' ||  CLIENT_ID == '166' || CLIENT_ID == '339' || CLIENT_ID == '383' || CLIENT_ID == '373' || CLIENT_ID == '318')) {
    $slug_controller = new tourSlugController();
    $slug_controller->redirectToSlug();
} elseif (GDS_SWITCH == 'tours') {
    if (!SLUG){
        require SITE_ROOT . '/404.shtml';
        die();
    }
    $slug_controller = new tourSlugController();
    $slug = $slug_controller->defineSluggedPage();
}
elseif (GDS_SWITCH == 'detailTour') {

    if (!SLUG){
        require SITE_ROOT . '/404.shtml';
    }
    $slug_controller = new tourSlugController();
    $slug = $slug_controller->defineTourDetailSluggedPage();
}


//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
//}



if(GDS_SWITCH == 'resultExternalHotel' || GDS_SWITCH == 'searchHotel') {
    functions::urlWithDate(GDS_SWITCH);
}
//

if(GDS_SWITCH == 'roomHotelLocal' || GDS_SWITCH == 'resultTourLocal') {
    functions::setCorrectName(GDS_SWITCH);
}

if (GDS_SWITCH == '404.shtml') {
//    header("HTTP/1.0 404 Not Found");
//    include_once './404.php';
//    exit();
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
    require SITE_ROOT . '/404.php';
}else if (GDS_SWITCH == '410.shtml') {
    require SITE_ROOT . '/410.shtml';
}
elseif (GDS_SWITCH == 'pdf') {
    require LIBRARY_DIR . 'pdfMaker.php';
    $newpdfMaker = new pdfMaker();
}/* elseif (GDS_SWITCH == 'app') {

    $pagestring = $page->fetch('pwaApp.tpl');
    $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'user');
}*/

elseif (GDS_SWITCH == 'app' && !$pwa_access) {
    require SITE_ROOT . '/app/AppHome.php';
}
elseif(GDS_SWITCH == 'app' && $pwa_access){
    require SITE_ROOT . '/pwa/index.php';
}
elseif(GDS_SWITCH == 'manifest' && $pwa_access){
    require SITE_ROOT . '/pwa/manifest.php';
}
elseif(GDS_SWITCH == 'sitemap'){

    if(file_exists(FRONT_CURRENT_THEME . '/project_files/sitemap.xml')) {
        header('Location: https://' . CLIENT_MAIN_DOMAIN . '/gds/view/' . FRONT_TEMPLATE_NAME . '/project_files/sitemap.xml');
    }else{

        require SITE_ROOT . '/404.shtml';
    }

}
elseif (GDS_SWITCH == 'iframe') {


//    $pagestring = $page->fetch('../' . VAR_GDS_SWITCH . '/topBarMain.tpl');

    $second = NAME_SECOND_FILE ;
    $third = NAME_THIRD_FILE ;
    if(!empty($second))
    {
        if(!empty($third))
        {
            $nameIframeSecond =  $third.'/'.$second.'.tpl';
        }else{
            $nameIframeSecond =  $second.'.tpl';
        }

    }else{
        $nameIframeSecond =  'topBarMain.tpl';
    }

    $pagestring = $page->fetch('../' . VAR_GDS_SWITCH . '/'.$nameIframeSecond);
    $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'iframe');
    $trans = $page->parseTagsRecursive($pageChangedDirection);
    echo $trans;
//        require  FRONT_THEMES_DIR . '/'.VAR_GDS_SWITCH.'/topBarMain.tpl';
}
elseif (strpos(GDS_SWITCH, 'SearchEngine') !== false) {
    require LIBRARY_DIR . 'ApiSource/searchEngineApi/sepehr360.php';
}
elseif (strpos(GDS_SWITCH, 'apiTrain') !== false) {
    if(strpos(GDS_SWITCH, 'apiTrainCronjob') !== false) {
        require CRONJOBS_DIR . 'ApiTrainCronjob.php';
    }else{
        require LIBRARY_DIR . 'apiTrain.php';
    }

}
elseif (GDS_SWITCH == 'api') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/api.php';
}
elseif (GDS_SWITCH == 'apiTest') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/apiTest/ApiFlight.php';
}
elseif (GDS_SWITCH == 'apiHotelsTest') {

    require LIBRARY_DIR.'ApiSource/iranTechApi/apiTest/ApiHotel.php';
}
elseif (GDS_SWITCH == 'apiBusTest') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/apiTest/ApiBus.php';
}
elseif (GDS_SWITCH == 'apiTourTest') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/apiTest/ApiTour.php';
}
elseif (GDS_SWITCH == 'apiTour') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/ApiTour.php';
}
elseif (GDS_SWITCH == 'apiExternalHotel'|| GDS_SWITCH == 'apiExternalHotelTest') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/externalHotelApi.php';
}
elseif (GDS_SWITCH == 'apiHotels') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/hotelApi.php';
}
elseif (GDS_SWITCH == 'apiBus') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/busApi.php';
}
elseif (GDS_SWITCH == 'registerApi') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/registerApi.php';
}
elseif (GDS_SWITCH == 'creditClub') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/Club.php';
}
elseif (GDS_SWITCH == 'infoGds') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/infoGds.php';
}
elseif (GDS_SWITCH == 'webService') {
    require LIBRARY_DIR.'ApiSource/iranTechApi/webService.php';
}
elseif (GDS_SWITCH == 'axios') {
    require LIBRARY_DIR.'ApiSource/ClientsApi/axios.php';
}
elseif (GDS_SWITCH == 'show-result') {
    require LIBRARY_DIR.'ApiSource/showPrettyResult.php';
}
elseif (GDS_SWITCH == 'ajax') {
    require LIBRARY_DIR.'ajax/ajax.php';
}
elseif (GDS_SWITCH == 'checkStatusFlight') {
    require CRONJOBS_DIR . 'checkStatusFlight.php';
}
elseif (GDS_SWITCH == 'deleteLogs') {
    require CRONJOBS_DIR . 'deleteLogs.php';
}
elseif (GDS_SWITCH == 'smsCountTicket') {
    require CRONJOBS_DIR . 'smsCountTicket.php';
}
elseif (GDS_SWITCH == 'syncDataGds') {
        require CRONJOBS_DIR . 'syncDataGds.php';
}
elseif (GDS_SWITCH == 'checkStatusHotel') {
    require CRONJOBS_DIR . 'checkStatusHotel.php';
}

elseif (GDS_SWITCH == 'ApiWeatherCronjob') {
    require CRONJOBS_DIR . 'ApiWeatherCronjob.php';
}

elseif (GDS_SWITCH == 'TrainBotSearch') {

    require CRONJOBS_DIR . 'TrainBotSearch.php';
} else {


    if (substr_count($firstURL, FOLDER_ADMIN)) {

        $pagestring = $page->fetch('../' . ADMIN_DIR . '/frontAdmin.tpl');

        $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'admin');

    }
    elseif (substr_count($firstURL, PANEL_DIR)) {

        $pagestring = $page->fetch('../' . FOLDER_PANEL . '/frontPanel.tpl');
        $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'panel');

    }
    elseif (GDS_SWITCH=='mainPage') {
        $api_clients = functions::getApiClient();
        if(in_array(CLIENT_ID , $api_clients)) {
            require SITE_ROOT . '/404.shtml';
            die();
        }
        $pagestring = $page->fetch('mainPage.tpl');

        $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'user');
    }
    elseif (GDS_SWITCH=='intro') {

        $pagestring = $page->fetch('intro.tpl');

        $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'user');

    }
    else {

        $pagestring = $page->fetch('frontMaster.tpl');

            $pageChangedDirection = $page->changeDirection($direction, $pagestring, 'user');
//                echo 'after pageChangedDirection==>'. calculate_time($start) .'mili seconde'.'<hr/>';

    }

    $trans = $page->parseTagsRecursive($pageChangedDirection);



//        echo 'after trans==>'. calculate_time($start) .'mili seconde'.'<hr/>';


    echo $trans;

}

