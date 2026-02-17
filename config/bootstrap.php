<?php

//if ($_SERVER['REMOTE_ADDR'] === '93.118.161.174') {
   // error_reporting(E_ALL);
   // ini_set('display_errors', 1);
//}



date_default_timezone_set('Asia/Tehran');
// SITE_ROOT contains the full path to the Project folder
defined('SITE_ROOT') or define('SITE_ROOT', dirname(dirname(__FILE__)));
defined('CONFIG_DIR') or define('CONFIG_DIR', SITE_ROOT . '/config/');
defined('CONTROLLERS_DIR') or define('CONTROLLERS_DIR', SITE_ROOT . '/controller/');
defined('LANG_DIR') or define('LANG_DIR', SITE_ROOT . '/langs/');
defined('CRONJOBS_DIR') or define('CRONJOBS_DIR', SITE_ROOT . '/cronjobs/');
defined('CONTROLLERS_DIR_APP') or define('CONTROLLERS_DIR_APP', SITE_ROOT . '/controller/appController/');
defined('MODEL_DIR') or define('MODEL_DIR', SITE_ROOT . '/model/');
defined('LIBRARY_DIR') or define('LIBRARY_DIR', SITE_ROOT . '/library/');
defined('LOGS_DIR') or define('LOGS_DIR', SITE_ROOT . '/logs/');
defined('FRONT_THEMES_DIR') or define('FRONT_THEMES_DIR', SITE_ROOT . '/view/');
defined('PIC_ROOT') or define('PIC_ROOT', SITE_ROOT . '/pic/');
defined('ADMIN_DIR') or define('ADMIN_DIR', 'administrator');
defined('FOLDER_ADMIN') or define('FOLDER_ADMIN', 'itadmin');
defined('FOLDER_CLIENT') or define('FOLDER_CLIENT', 'client');
defined('FOLDER_PANEL') or define('FOLDER_PANEL', 'club');
defined('FOLDER_APP') or define('FOLDER_APP', 'app');
defined('PANEL_APP') or define('PANEL_APP', 'app');
defined('PANEL_DIR') or define('PANEL_DIR', 'uipanel');
defined('FRONT_CURRENT_ADMIN') or define('FRONT_CURRENT_ADMIN', SITE_ROOT . '/view/' . ADMIN_DIR . '/');
defined('FRONT_CURRENT_CLIENT') or define('FRONT_CURRENT_CLIENT', SITE_ROOT . '/view/' . FOLDER_CLIENT . '/');
defined('FRONT_CURRENT_PANEL') or define('FRONT_CURRENT_PANEL', SITE_ROOT . '/view/' . FOLDER_PANEL . '/');
defined('HTTP_HOST_SITE') or define('HTTP_HOST_SITE', $_SERVER["HTTP_HOST"]);
// Settings needed to configure the Smarty template engine
defined('SMARTY_DIR') or define('SMARTY_DIR', LIBRARY_DIR . 'smarty/');
defined('COMPILE_DIR') or define('COMPILE_DIR', SITE_ROOT . '/casch/tmp');
defined('CASCH_IMAGES_PATH') or define('CASCH_IMAGES_PATH', SITE_ROOT . '/casch/img');
//connect to main database for fetching client's informations
require CONFIG_DIR . 'configBase.php';
$mainConfig = new PDO(
    'mysql:host=' . DB_SERVER_BASE . ';dbname=' . DB_DATABASE_BASE . ';charset=utf8', DB_USERNAME_BASE, DB_PASSWORD_BASE
);



$mainConfig->exec("set names utf8");
$domainName = $_SERVER["HTTP_HOST"];

/*$SqlClient = "SELECT C.*, COlOR.ColorMainBg, COlOR.ColorMainBgHover, COlOR.ColorMainText, COlOR.ColorMainTextHover
              FROM clients_tb AS C
              LEFT JOIN client_colors_tb AS COlOR ON C.id = COlOR.ClientId
              WHERE C.Domain = '{$domainName}' ";*/
$SqlClient = "
        SELECT
            GROUP_CONCAT( DISTINCT CONCAT( SERVICE.Service, ',', AUTH.SourceId, ',', AUTH.Username ) ORDER BY AUTH.SourceId SEPARATOR ';' ) AS Services,
            AUTH.Username AS AuthUsername,
            C.*,
            COlOR.ColorMainBg,
            COlOR.ColorMainBgHover,
            COlOR.ColorMainText,
            COlOR.ColorMainTextHover
        FROM
            clients_tb AS C
            LEFT JOIN client_colors_tb AS COlOR ON C.id = COlOR.ClientId
            LEFT JOIN client_auth_tb AS AUTH ON AUTH.ClientId = C.id
            LEFT JOIN client_services_tb AS SERVICE ON AUTH.ServiceId = SERVICE.id
        WHERE
            C.Domain = '{$domainName}'
            AND AUTH.IsActive = 'Active'
        ";
$query = $mainConfig->prepare($SqlClient);
$query->execute();
$client = $query->fetch(PDO::FETCH_ASSOC);



//select id current page panel counter
if (isset($_SESSION['memberIdCounterInAdmin']) && !isset($pageCallCurllFactorIrantech)) {
    defined('memberIdCounterInAdmin') or define('memberIdCounterInAdmin',$_SESSION['memberIdCounterInAdmin']);
    if (!empty($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER']) > strlen('https://localhost/')) {
        $urlPageNow = $_SERVER['HTTP_REFERER'];
    } else {
        $urlPageNow = $_SERVER['REQUEST_URI'];
    }

    // حذف همه‌چیز قبل از "gds/itadmin/"
    $pos = strpos($urlPageNow, 'gds/itadmin/');
    if ($pos !== false) {
        $urlPageNow = substr($urlPageNow, $pos + strlen('gds/itadmin/')); // خروجی: pagesPermissions/pagesPermissions&id=787&agencyID=2
    }
    // جدا کردن تا قبل از اولین &
    $ampPos = strpos($urlPageNow, '&');
    if ($ampPos !== false) {
        $urlPageNow = substr($urlPageNow, 0, $ampPos); // خروجی: pagesPermissions/pagesPermissions
    }

    $SqlIdPage = "SELECT
                      id
                  FROM
                     admin_pages_tb
                  WHERE
                     address = '{$urlPageNow}'  AND
                     dell = '0'
                    ";
    $queryIdPage = $mainConfig->prepare($SqlIdPage);
    $queryIdPage->execute();
    $IdPage = $queryIdPage->fetch(PDO::FETCH_ASSOC);
    // ذخیره در دیفالت
    defined('currentPagePanelCounter') or define('currentPagePanelCounter', $IdPage['id']);
}


if ((isset($_SERVER['REDIRECT_HTTPS']) && $_SERVER['REDIRECT_HTTPS'] == 'on') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) {
    defined('SERVER_HTTP') or define('SERVER_HTTP', 'https://');
} else {
    defined('SERVER_HTTP') or define('SERVER_HTTP', 'http://');
}

defined('tunnel_url') or define('tunnel_url', 'https://api.ladyscarf.ir/transfer.php');

if(!empty($client['Services'])){

    if(empty($client['id'])){
        $SqlClient = " SELECT * FROM sub_agency_tb WHERE url_agency='{$domainName}'";
        $query = $mainConfig->prepare($SqlClient);
        $query->execute();
        $clientWhiteLabel = $query->fetch(PDO::FETCH_ASSOC);
        if(!empty($clientWhiteLabel['client_id']))
        {
            $SqlClient = "
        SELECT
            GROUP_CONCAT( DISTINCT CONCAT( SERVICE.Service, ',', AUTH.SourceId, ',', AUTH.Username ) ORDER BY AUTH.SourceId SEPARATOR ';' ) AS Services,
            AUTH.Username AS AuthUsername,
            C.*,
            COlOR.ColorMainBg,
            COlOR.ColorMainBgHover,
            COlOR.ColorMainText,
            COlOR.ColorMainTextHover,
            services_order.order_number
        FROM
            clients_tb AS C
            LEFT JOIN client_colors_tb AS COlOR ON C.id = COlOR.ClientId
            LEFT JOIN client_auth_tb AS AUTH ON AUTH.ClientId = C.id
            LEFT JOIN client_services_tb AS SERVICE ON AUTH.ServiceId = SERVICE.id 
            LEFT JOIN search_service_order_tb AS services_order ON services_order.service_group_id = SERVICE.ServiceGroupId 
        WHERE
            C.id = '{$clientWhiteLabel['client_id']}' 
            AND AUTH.IsActive = 'Active'
        ";

            $query = $mainConfig->prepare($SqlClient);
            $query->execute();
            $client = $query->fetch(PDO::FETCH_ASSOC);

            $configClient = new PDO('mysql:host=localhost;dbname=' . $client['DbName'], $client['DbUser'], $client['DbPass'], array(PDO::ATTR_PERSISTENT => 'true', PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            $SqlAgency = "SELECT *
              FROM agency_tb
              WHERE id = '{$clientWhiteLabel['agency_id']}' AND active='on' ";
            $query = $configClient->prepare($SqlAgency);
            $query->execute();
            $agency = $query->fetch(PDO::FETCH_ASSOC);


            if(!empty($agency['id']))
            {
           
                $client['id'] = $clientWhiteLabel['client_id'];
                $client['Domain'] = $agency['domain'];
                $client['MainDomain'] = $agency['mainDomain'];
                $client['AgencyName'] = $agency['name_fa'];
                $client['Title'] = $agency['name_fa'];
                $client['Address'] = $agency['address_fa'];
                $client['AddressEn'] = $agency['address_en'];
                $client['Email'] = $agency['email'];
                $client['Mobile'] = $agency['mobile'];
                $client['Phone'] = $agency['phone'];
                $client['Logo'] = $agency['logo'];
                $client['ThemeDir'] = $agency['theme_dir'];
                $client['ColorMainBg'] = $agency['colorMainBg'];
                $client['ColorMainBgHover'] = $agency['colorMainBgHover'];
                $client['ColorMainText'] = $agency['colorMainText'];
                $client['ColorMainTextHover'] = $agency['colorMainTextHover'];
                $client['AboutMe'] = $agency['aboutAgency'];
                $client['AboutMePic'] = $agency['aboutMePic'];
                defined('SUB_CLIENT_AGENCY_DOMAIN') or define('SUB_CLIENT_AGENCY_DOMAIN',$client['Domain']);
                defined('SUB_AGENCY_ID') or define('SUB_AGENCY_ID',$agency['id']);

            }else{

                header('location: ' . ROOT_ADDRESS_WITHOUT_LANG . '/404.shtml');
            }

        }
    }



    $mizbanFly=[
        '192.168.1.1',

    ];

    $safar360FielsR = [
        '0' => 'yazdseir',
        '1' => 'jahangardan',
        '2' => 'marz_por_gohar',
        '3' => 'bime_saman',
        '4' => 'oshida',
        '5' => 'sayare',
        '6' => 'manshore_solh_new',
        '7' => 'sufarainvestment',
        '8' => 'torang_gasht',
        '9' => 'irantechs360',
        '15' => 'pabepa360',
        '16' => 'ava_parvaz',
        '18' => 'versa360',
        '19' => 'yazdSeir_I_m',
        '20' => 'ababil',

        '22' => 'ava_parvaz_modular',
        '23' => 'ava_parvaz_modular_test_data',
        '25' => 'asareh_ar',
        '27' => 'asareh',
        '28' => 'asareh_en',

        '29' => 'ava_parvaz_ar',
        '30' => 'ava_parvaz_en',
        '31' => 'darya_gasht',
        '33' => 'avan',
        '34' => 'hayat_seir',
        '35' => 'homan_seir',

        '36' => 'touring_persia',
        '39' => 'ghods_gasht360',
        '40' => 'white_label',
        '41' => 'adineh360',
        '42' => 'keyhan_mohajer',
        '43' => 'ww',
        '44' => 'raspina360',
        '45' => 'lika',
        '46' => 'safar360',
        '47' => 'paeez_sahra',
        '48' => 'safiran360',
        '49' => 'gisoo',
        '50' => 'solan360',
        '51' => 'safar360_child',
        '53' => 'golgasht',
        '54' => 'pars_parvaz',
        '55' => 'hotelato',
        '56' => 'mizbanfly',
        '57' => 'test_search_box',
        '58' => 'test1',
        '59' => 'venos',
        '60' => 'mahbod',
        '61' => 'paeizSahraTes',
        '62' => 'parvazBist',
        '63' => 'kanonSeir',
        '64' => 'raymon',
        '65' => 'gandomTalaee',
        '66' => 'ww',
        '67' => 'meraj',
        '68' => 'salam_aseman',
        '69' => 'kharazmi',
        '70' => 'havanavardan',
        '71' => 'donyaeSafar',
        '72' => 'midari',
        '73' => 'atiyeGasht',
        '74' => 'anis',
        '75' => 'skyHealth',
        '76' => 'manshoorTravel',
        '77' => 'bank_sina',
        '78' => 'neginRoxan',
        '79' => 'sepid_gasht_morvarid',
        '80' => 'irOtagh',
        '81' => 'arshidaSeirAseman',
        '82' => 'parvaz_talaee',
        '83' => 'mahbalSeirGds',
        '84' => 'setateSamGasht',
        '85' => 'reshnoParvaz',
        '86' => 'demo360',
        '87' => 'aviatop',
        '88' => 'jeyjet',
        '89' => 'parsParvazJonob',
        '90' => 'mahAsalGasht',
        '91' => 'donyaeSafarNew',
        '92' => 'gta',
        '93' => 'airaavia',
        '94' => 'safirAlIraq',
        '95' => 'ashiyaneh',
        '96' => 'karvanSadat',
        '97' => 'tehranGasht',
        '98' => 'tavousGasht',
        '99' => 'kishOnTime',
        '100' => 'abiBalSeir',
        '101' => 'rayanet_afzar_gds',
        '102' => 'afrashteh',
        '103' => 'afrashtehfive',
        '104' => 'afrashtehThree',
        '105' => 'gardima',
        '106' => 'sanaSeirGds',
        '107' => 'drBilit',
        '108' => 'mynaGds',
        '109' => 'shidrokhGds',
        '110' => 'yazdmehrGds',
        '111' => 'sam24Gds',
        '112' => 'afrashtehSix',
        '113' => 'shabbadgashtGds',
        '114' => 'bilitiom',
        '115' => 'barandazanGds',
        '116' => 'vanaparvaz',
        '117' => 'orangGds',
        '118' => 'shenhayesaheli',
        '119' => 'bahartravel',
        '120' => 'taktinsafar',
        '121' => 'aghayetourGds',
        '122' => 'azarakhshparse',
        '123' => 'jazirehganj',
        '124' => 'watchparvaz',
        '125' => 'kifsafar',
        '126' => 'razdonya',
        '127' => 'bamekhalkhal',
        '128' => 'ferdosi',
        '129' => 'karevansadat',
        '130' => 'hafez',
        '131' => 'sohrabsepehri',
        '132' => 'khayam',
        '133' => 'amirrrrrR',
        //gardesh
        '10' => 'pa_be_pa',
        '11' => 'shidrokh',
        '12' => 'shidrokh_old',
        '99' => 'manshore_solh_new',
        '17' => 'adinehgasht',
        '37' => 'relaxtourismW',
        '38' => 'relaxtourism_m',
        '52' => 'myna',
    ];

    if(in_array($_SERVER['REMOTE_ADDR'],$mizbanFly)) {
        $client['jahangaThemeDir'] = 'mizbanfly';
    }
    // mr farhadi >>>
    elseif($_SERVER['REMOTE_ADDR']=='192.168.1.9') {
        $client['ThemeDir'] = 'demoJami';
    }
    // mr abbasi >>>
    elseif($_SERVER['REMOTE_ADDR']=='192.168.1.56') {
        $client['ThemeDir'] = 'doctor_bilit';
    }
    // mr shojaii >>>
    elseif($_SERVER['REMOTE_ADDR']=='192.168.1.2') {
        $client['ThemeDir'] = 'doctor_bilit';
    }
    // mr tester >>>
    elseif($_SERVER['REMOTE_ADDR']=='192.168.1.7') {
        $client['ThemeDir'] = 'ava_parvaz_ar';
    }
    // mr javani >>>
    elseif($_SERVER['REMOTE_ADDR'] == "127.0.0.1")
    {
        $client['ThemeDir'] = 'hamsafaranUranus';
    }



    defined('CLIENT_SERVICES') or define('CLIENT_SERVICES', $client['Services']);

    defined('FRONT_CURRENT_THEME') or define('FRONT_CURRENT_THEME', FRONT_THEMES_DIR . $client['ThemeDir'] . '/');
    defined('FRONT_TEMPLATE_NAME') or define('FRONT_TEMPLATE_NAME', $client['ThemeDir']);
    defined('CLIENT_DOMAIN') or define('CLIENT_DOMAIN', $client['Domain']);
    defined('CLIENT_MAIN_DOMAIN') or define('CLIENT_MAIN_DOMAIN', $client['MainDomain']);
    defined('DOMAIN_FOR_URL') or define('DOMAIN_FOR_URL', SERVER_HTTP.$client['MainDomain']);
    defined('TYPE_ADMIN') or define('TYPE_ADMIN', $client['Type']);
    defined('CLIENT_ID') or define('CLIENT_ID', $client['id']);
    defined('CLIENT_NAME') or define('CLIENT_NAME', $client['AgencyName']);
    defined('CLIENT_ADDRESS') or define('CLIENT_ADDRESS', $client['Address']);
    defined('CLIENT_ADDRESS_EN') or define('CLIENT_ADDRESS_EN', $client['AddressEn']);
    defined('CLIENT_EMAIL') or define('CLIENT_EMAIL', $client['Email']);
    defined('CLIENT_MOBILE') or define('CLIENT_MOBILE', $client['Mobile']);
    defined('CLIENT_PHONE') or define('CLIENT_PHONE', $client['Phone']);
    defined('CLIENT_MAP_LAT') or define('CLIENT_MAP_LAT', $client['GoogleMapLatitude']);
    defined('CLIENT_MAP_LNG') or define('CLIENT_MAP_LNG', $client['GoogleMapLongitude']);
    defined('CLIENT_ENAMAD') or define('CLIENT_ENAMAD', $client['Enamad']);
    defined('CLIENT_SAMANDEHI') or define('CLIENT_SAMANDEHI', $client['Samandehi']);
    defined('IS_ENABLE_TICKET_HTC') or define('IS_ENABLE_TICKET_HTC', $client['IsEnableTicketHTC']);
    defined('URL_RULS') or define('URL_RULS', $client['UrlRuls']);
    defined('IdWhmcsCurll') or define('IdWhmcsCurll', $client['hash_id_whmcs']);


//defined('USER_NAME_API') or define('USER_NAME_API', $client['UserNameApi']);
//defined('USER_ID_API') or define('USER_ID_API', $client['UserIdApi']);
    defined('CLIENT_LOGO') or define('CLIENT_LOGO', $client['Logo']);
    defined('CLIENT_STAMP') or define('CLIENT_STAMP', $client['Stamp']);
    defined('ROOT_LIBRARY') or define('ROOT_LIBRARY', SERVER_HTTP . $client['Domain'] . '/gds/library');
    defined('IS_ENABLE_CLUB') or define('IS_ENABLE_CLUB', $client['IsEnableClub']);
    defined('CLIENT_PRE_CARD_NO') or define('CLIENT_PRE_CARD_NO', $client['ClubPreCardNo']);
    defined('AllowSendSms') or define('AllowSendSms', $client['AllowSendSms']);
    defined('USERNAMESMS') or define('USERNAMESMS', $client['UsernameSms']);
    defined('PASSWORFSMS') or define('PASSWORFSMS', $client['PasswordSms']);
    defined('NUMBERSMS') or define('NUMBERSMS', $client['NumberSms']);
    defined('COLOR_MAIN_BG') or define('COLOR_MAIN_BG', $client['ColorMainBg']);
    defined('COLOR_MAIN_BG_HOVER') or define('COLOR_MAIN_BG_HOVER', $client['ColorMainBgHover']);
    defined('COLOR_MAIN_TEXT') or define('COLOR_MAIN_TEXT', $client['ColorMainText']);
    defined('COLOR_MAIN_TEXT_HOVER') or define('COLOR_MAIN_TEXT_HOVER', $client['ColorMainTextHover']);
    defined('TITLE_SITE') or define('TITLE_SITE', $client['Title']);
    defined('DESCRIPTION_SITE') or define('DESCRIPTION_SITE', $client['Description']);
    defined('ISCURRENCY') or define('ISCURRENCY', $client['IsCurrency']);
    defined('DiamondAccess') or define('DiamondAccess', $client['diamondAccess']);
    defined('LOGO_AGENCY') or define('LOGO_AGENCY', $client['Logo']);
    defined('ABOUT_ME') or define('ABOUT_ME', $client['AboutMe']);
    defined('ADDITIONAL_DATA') or define('ADDITIONAL_DATA', $client['AdditionalData']);
    defined('ABOUT_ME_PIC') or define('ABOUT_ME_PIC', isset($client['AboutMePic']) ? $client['AboutMePic'] : '');
    defined('PARENT_ID') or define('PARENT_ID', $client['parent_id']);
    defined('DEFAULT_DB') or define('DEFAULT_DB', $client['DefaultDb']);
    defined('IS_ENABLE_TEL_ORDER') or define('IS_ENABLE_TEL_ORDER', $client['IsEnableTelOrder']);
    defined('IS_ENABLE_SMS_ORDER') or define('IS_ENABLE_SMS_ORDER', $client['IsEnableSmsOrder']);

    defined('SERVER_BASE_ADMIN') or define('SERVER_BASE_ADMIN', DB_SERVER_BASE);
    defined('ConstPrintTicket') or define('ConstPrintTicket', 'eticketLocal');
    defined('ConstPrintHotel') or define('ConstPrintHotel', 'ehotelLocal');
    defined('ConstPrintEuropcar') or define('ConstPrintEuropcar', 'eEuropcarLocal');
    defined('ConstPrintHotelReservation') or define('ConstPrintHotelReservation', 'ehotelReservation');
    defined('ConstPrintTicketReservation') or define('ConstPrintTicketReservation', 'eReservationTicket');
    defined('ConstPrintTourReservation') or define('ConstPrintTourReservation', 'eTourReservation');
    defined('ConstPrintBusTicket') or define('ConstPrintBusTicket', 'eBusTicket');
    defined('ConstPrintHotelReservationAhuan') or define('ConstPrintHotelReservationAhuan', 'ehotelAhuan');
    defined('ConstPrintHotelReservationZarvan') or define('ConstPrintHotelReservationZarvan', 'ehotelZarvan');


    defined('USERNAME_M4') or define('USERNAME_M4', 'abazar_afshar');
    defined('PASSWORD_M4') or define('PASSWORD_M4', 'Mr.H@san1#');
    defined('KEY_TABADOL_M4') or define('KEY_TABADOL_M4', 'c4463bb2-b13c-46f1-97b9-863a8e7e3a67');

    defined('IT_COMMISSION') or define('IT_COMMISSION', 0);
    defined('PRICE_CHARTER_INC') or define('PRICE_CHARTER_INC', 10000);
    defined('PRICE_POINT') or define('PRICE_POINT', 1000000);





// get url for find which page should open
    if(isset($_GET['gad_source']) || isset($_GET['gclid']) || isset($_GET['fbclid']) ){
        header('Location: ' . SERVER_HTTP . $_SERVER["HTTP_HOST"].strtok($_SERVER["REQUEST_URI"], '?'));
        exit();
    }

    $firstURL = urldecode($_SERVER['REQUEST_URI']);


//    var_dump('dsfsfsdf');
    if($firstURL == '/robots.txt'){
        if(file_exists(FRONT_CURRENT_THEME . 'project_files/robots.txt')) {
            header('Location: http://' . CLIENT_MAIN_DOMAIN . '/gds/view/' . FRONT_TEMPLATE_NAME . '/project_files/robots.txt');
            exit();
        }else{
//            var_dump('sdfsfsdfa3');
            require SITE_ROOT . '/404.shtml';
        }
    }

    $firstURL = str_replace('?', '&', $firstURL);
    $queryString = $_SERVER['QUERY_STRING'];
    $adminUrl = explode('/', $queryString);
    $arrUrlFirst = explode('/', $firstURL);


    if($firstURL == '/410.shtml') {
        header("HTTP/1.1 410 Gone");
        include_once './410.shtml';
        exit();
    }


    if(in_array('gds',$arrUrlFirst)){
        foreach ( $arrUrlFirst as $part){
            $part = strip_tags($part);
            $string = str_replace("'", "", $part);
            $string = str_replace("\"", "", $part);
            $string = str_replace(array("\n", "'", "‘", "’", "'", "“", "”", "„" , '"', '(', ')', '<', '>','</','/>','alert','+'), array(
                "",
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
            ), $part);
            $string = filter_var($string,FILTER_SANITIZE_STRING);
            $arrUrl[] = $string;

        }
        $arrayLanguage = ['fa', 'ar', 'en' , 'ru'];
        if (!in_array($arrUrl[2], $arrayLanguage)) {
            $arrUrlCopy = $arrUrl;
            $arrUrl = array();
            foreach ($arrUrlCopy as $keyUrl => $valUrl) {
                if ($keyUrl < 2) {
                    $arrUrl[$keyUrl] = $arrUrlCopy[$keyUrl];
                } elseif ($keyUrl == 2) {
                    if(isset($_SERVER['HTTP_REFERER']))
                    {
                        $HTTP_REFERER = str_replace(SERVER_HTTP, '', $_SERVER['HTTP_REFERER']);

                        $arrUrlRefer = explode('/', $HTTP_REFERER);
                    }else{
                        $arrUrlRefer = array();
                    }
                    if (!empty($arrUrlRefer) && isset($arrUrlRefer[2]) && in_array($arrUrlRefer[2], $arrayLanguage)) {
                        $arrUrl[$keyUrl] = $arrUrlRefer[2];
                    } else {
                        $arrUrl[$keyUrl] = $client['default_language'];
                    }
                } else {
                    $arrUrl[$keyUrl] = $arrUrlCopy[$keyUrl - 1];
                }
            }
            $arrUrl[$keyUrl + 1] = $arrUrlCopy[$keyUrl];
        }



        defined('SOFTWARE_LANG') or define('SOFTWARE_LANG', $arrUrl[2]);
        defined('DEFAULT_LANG') or define('DEFAULT_LANG', $client['default_language']);

        if (isset($arrUrl[3]) && strpos($arrUrl[3], '&') !== false) {

            $arrExplode = explode('&', $arrUrl[3]); // baraye zamani ke dar url '&' dashte bashim (example pdf)
            defined('GDS_SWITCH') or define('GDS_SWITCH', $arrExplode[0]);
            defined('VAR_GDS_SWITCH') or define('VAR_GDS_SWITCH', $arrExplode[1]);

            defined('NAME_SECOND_FILE') or define('NAME_SECOND_FILE', $arrExplode[2]);
            defined('NAME_THIRD_FILE') or define('NAME_THIRD_FILE', $arrExplode[3]);


        } else if (isset($arrUrl[3])) {
            defined('GDS_SWITCH') or define('GDS_SWITCH', $arrUrl[3]);
            if (isset($arrUrl[4]))
            {
                defined('GDS_SWITCH_PAGE') or define('GDS_SWITCH_PAGE', $arrUrl[4]);
            }
        }
        defined('ROOT_ADDRESS') or define('ROOT_ADDRESS', SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG);
        defined('ROOT_ADDRESS_WITHOUT_LANG') or define('ROOT_ADDRESS_WITHOUT_LANG', SERVER_HTTP . CLIENT_DOMAIN . '/gds');

        if (!empty($adminUrl[1])) {

            if (substr_count($firstURL, FOLDER_ADMIN)) {
                if (is_dir(FRONT_CURRENT_ADMIN . $adminUrl[1])) {

                    $UrlExplode = explode('&', $adminUrl[2]);
                    defined('ADMIN_MODULE_FOLDER') or define('ADMIN_MODULE_FOLDER', $adminUrl[1]);
                    defined('ADMIN_FILE') or define('ADMIN_FILE', $adminUrl[1] . '/' . $UrlExplode[0]);
                } else {
                    $UrlExplode = explode('&', $adminUrl[1]);
                    defined('ADMIN_FILE') or define('ADMIN_FILE', $UrlExplode[0]);
                }
            } elseif (substr_count($firstURL, PANEL_DIR)) {
                if (is_dir(FRONT_CURRENT_PANEL . $adminUrl[1])) {

                    $UrlExplode = explode('&', $adminUrl[2]);
                    defined('PANEL_MODULE_FOLDER') or define('PANEL_MODULE_FOLDER', $adminUrl[1]);
                    defined('PANEL_FILE') or define('PANEL_FILE', $adminUrl[1] . '/' . $UrlExplode[0]);
                } else {

                    $UrlExplode = explode('&', $adminUrl[1]);
                    defined('PANEL_FILE') or define('PANEL_FILE', $UrlExplode[0]);
                }
            }
        }
        $arraySoftwareName = [
            'international', 'local', 'resultHotelLocal', 'resultInsurance','rentCar','reserveCar',
            'resultExternalHotel', 'resultBus', 'resultTrainApi', 'resultTrain',
            'trainResult',
            'resultGasht',
            'resultEuropcarLocal', 'resultTourLocal', 'tours', 'resultVisa', 'flatResultVisa', 'agencyListByCity',
            'roomHotelLocal', 'detailTour', 'detailTour-v2', 'detailTour-v3', 'buses', 'mag', 'news', 'page', 'roomExternalHotel', 'detailEntertainment', 'resultEntertainment',
            'searchHotel','detailHotel','articles','recommendation','introductIran','introductCountry','aboutIran','aboutCountry','video','gallery','pay','search-flight' , 'immigration' , 'visa' , 'embassy' , 'pickup', 'hotel' , 'bookings','roomManagement'
            ,'hotelLog','hotelFinancialCenter' , 'hotelInvoices' , 'newInvoice' , 'exclusive-tour' , 'exclusive-tour-detail', 'search-cip' , 'cip-detail'

        ];
        $array_delete_refer = array(
            'detailHotel',
            'roomHotelLocal',
            'searchFlight',
            'resultTrainApi',
            'buses',

            'international'
        );
        if(in_array(GDS_SWITCH,$array_delete_refer)){
            $_SESSION['refer_url'] = '';
            unset($_SESSION['refer_url']);
//	Session::delete('refer_url');
        }

        if (in_array(GDS_SWITCH, $arraySoftwareName)) {


            switch (GDS_SWITCH) {
                case 'local':
                case 'search-flight':
                {
                    if (isset($arrUrl[5])) {
                        $orig_dest = explode('-', $arrUrl[5]);

                        if (isset($orig_dest[0])) {
                            defined('SEARCH_ORIGIN') or define('SEARCH_ORIGIN', strtoupper($orig_dest[0]));
                        }
                        if (isset($orig_dest[1])) {
                            defined('SEARCH_DESTINATION') or define('SEARCH_DESTINATION', strtoupper($orig_dest[1]));
                        }
                    }

                    if (isset($arrUrl[6])) {

                        $dates = explode('&', $arrUrl[6]);
                        defined('SEARCH_DEPT_DATE') or define('SEARCH_DEPT_DATE', $dates[0]);
                        if (!empty($dates[1])) {
                            defined('SEARCH_RETURN_DATE') or define('SEARCH_RETURN_DATE', $dates[1]);
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'TwoWay');
                        } else {
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'OneWay');
                        }
                    }
                    if (isset($arrUrl[7])) {
                        defined('SEARCH_CLASSF') or define('SEARCH_CLASSF', $arrUrl[7]);
                    }
                    if (isset($arrUrl[8])) {

//                echo $arrUrl[8];
                        $num = explode('-', $arrUrl[8]);

                        defined('SEARCH_ADULT') or define('SEARCH_ADULT', $num[0]);
                        defined('SEARCH_CHILD') or define('SEARCH_CHILD', $num[1]);
                        defined('SEARCH_INFANT') or define('SEARCH_INFANT', $num[2]);

                    }

                    if (isset($arrUrl[9]) && $arrUrl[9] != '') {
                        defined('SEARCH_FLIGHT_NUMBER') or define('SEARCH_FLIGHT_NUMBER', $arrUrl[9]);
                    }

                    if (GDS_SWITCH == 'local'){
                        defined('FLIGHT') or define('FLIGHT', 'local');
                        defined('REQUEST') or define('REQUEST', 'resultLocal');
                    }
                    else{
                        defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    }
                    break;
                }
                case 'exclusive-tour':
                {
                    if (isset($arrUrl[4])) {
                        defined('TOUR_SEARCH_IS_INTERNAL') or define('TOUR_SEARCH_IS_INTERNAL', $arrUrl[4]);
                    }
                    if (isset($arrUrl[5])) {
                        $orig_dest = explode('-', $arrUrl[5]);

                        if (isset($orig_dest[0])) {
                            defined('TOUR_SEARCH_ORIGIN') or define('TOUR_SEARCH_ORIGIN', strtoupper($orig_dest[0]));
                        }
                        if (isset($orig_dest[1])) {
                            defined('TOUR_SEARCH_DESTINATION') or define('TOUR_SEARCH_DESTINATION', strtoupper($orig_dest[1]));
                        }
                    }
                    if (isset($arrUrl[6])) {
                        $dates = explode('&', $arrUrl[6]);
                        defined('TOUR_SEARCH_DEPT_DATE') or define('TOUR_SEARCH_DEPT_DATE', $dates[0]);
                        defined('TOUR_SEARCH_RETURN_DATE') or define('TOUR_SEARCH_RETURN_DATE', $dates[1]);
                    }
                    if (isset($arrUrl[7])) {
                        defined('TOUR_SEARCH_ROOMS') or define('TOUR_SEARCH_ROOMS', $arrUrl[7]);
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'exclusive-tour-detail':
                {
                    if (isset($arrUrl[4])) {
                        defined('REQUEST_NUMBER') or define('REQUEST_NUMBER', $arrUrl[4]);
                    }

                    if (isset($arrUrl[5])) {
                        defined('SOURCE_ID') or define('SOURCE_ID', $arrUrl[5]);
                    }

                    if (isset($arrUrl[6])) {
                        defined('HOTEL_GLOBAL_ID') or define('HOTEL_GLOBAL_ID', $arrUrl[6]);
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'search-cip':
                {
                    if (isset($arrUrl[4])) {
                        defined('CIP_AIRPORT_SEARCH') or define('CIP_AIRPORT_SEARCH', $arrUrl[4]);
                    }
                    if (isset($arrUrl[5])) {
                        defined('CIP_DATE_SEARCH') or define('CIP_DATE_SEARCH',$arrUrl[5]);
                    }
                    if (isset($arrUrl[6])) {
                        $flightTypeAndTripType = explode('&', $arrUrl[6]);
                        defined('CIP_FLIGHT_TYPE_SEARCH') or define('CIP_FLIGHT_TYPE_SEARCH', $flightTypeAndTripType[0]);
                        defined('CIP_TRIP_TYPE_SEARCH') or define('CIP_TRIP_TYPE_SEARCH', $flightTypeAndTripType[1]);
                    }
                    if (isset($arrUrl[7])) {
                        $num = explode('-', $arrUrl[7]);

                        defined('SEARCH_ADULT') or define('SEARCH_ADULT', $num[0]);
                        defined('SEARCH_CHILD') or define('SEARCH_CHILD', $num[1]);
                        defined('SEARCH_INFANT') or define('SEARCH_INFANT', $num[2]);

                    }
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    break;

//                case 'cip-detail':
//                {
//                    if (isset($arrUrl[4])) {
//                        defined('REQUEST_NUMBER') or define('REQUEST_NUMBER', $arrUrl[4]);
//                    }
//
//                    if (isset($arrUrl[5])) {
//                        defined('SOURCE_ID') or define('SOURCE_ID', $arrUrl[5]);
//                    }
//
//                    if (isset($arrUrl[6])) {
//                        defined('HOTEL_GLOBAL_ID') or define('HOTEL_GLOBAL_ID', $arrUrl[6]);
//                    }
//
//                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
//
//                    break;
                }
                case 'international': {
                    $orig_dest = explode('-', $arrUrl[5]);

                    if (isset($orig_dest[0])) {
                        defined('SEARCH_ORIGIN') or define('SEARCH_ORIGIN', $orig_dest[0]);
                    }
                    if (isset($orig_dest[1])) {
                        defined('SEARCH_DESTINATION') or define('SEARCH_DESTINATION', $orig_dest[1]);
                    }
                    if (isset($arrUrl[6])) {

                        $dates = explode('&', $arrUrl[6]);
                        defined('SEARCH_DEPT_DATE') or define('SEARCH_DEPT_DATE', $dates[0]);
                        if (!empty($dates[1])) {
                            defined('SEARCH_RETURN_DATE') or define('SEARCH_RETURN_DATE', $dates[1]);
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'TwoWay');
                        } else {
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'OneWay');
                        }
                    }
                    if (isset($arrUrl[7])) {
                        defined('SEARCH_CLASSF') or define('SEARCH_CLASSF', $arrUrl[7]);
                    }
                    if (isset($arrUrl[8])) {
                        $num = explode('-', $arrUrl[8]);

                        defined('SEARCH_ADULT') or define('SEARCH_ADULT', $num[0]);
                        defined('SEARCH_CHILD') or define('SEARCH_CHILD', $num[1]);
                        defined('SEARCH_INFANT') or define('SEARCH_INFANT', $num[2]);

                    }

                    /*    if (isset($arrUrl[8]) && !empty($arrUrl[8])) {
                            defined('CITY_SELECTED_INTERNATIONAL') or define('CITY_SELECTED_INTERNATIONAL', $arrUrl[9]);
                        }*/


                    defined('FLIGHT') or define('FLIGHT', 'international');
                    defined('REQUEST') or define('REQUEST', 'internationalFlight');
                    defined('ISFOREIGN') or define('ISFOREIGN', 'international');

                    break;
                }
                case 'resultHotelLocal':{

                    defined('SEARCH_CITY') or define('SEARCH_CITY', $arrUrl[4]);
                    defined('SEARCH_START_DATE') or define('SEARCH_START_DATE', $arrUrl[5]);
                    defined('SEARCH_NIGHT') or define('SEARCH_NIGHT', $arrUrl[6]);

                    if (isset($arrUrl[7])) {
                        defined('SEARCH_HOTEL_TYPE') or define('SEARCH_HOTEL_TYPE', $arrUrl[7]);
                    } else {
                        defined('SEARCH_HOTEL_TYPE') or define('SEARCH_HOTEL_TYPE', 'all');
                    }
                    if (isset($arrUrl[8])) {
                        defined('SEARCH_STAR') or define('SEARCH_STAR', $arrUrl[8]);
                    }
                    if (isset($arrUrl[9])) {
                        defined('SEARCH_PRICE') or define('SEARCH_PRICE', $arrUrl[9]);
                    }
                    if (isset($arrUrl[10])) {
                        defined('SEARCH_HOTEL_NAME') or define('SEARCH_HOTEL_NAME', $arrUrl[10]);
                    }
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'searchHotel' :{

                    defined('SEARCH_CITY') or define('SEARCH_CITY', $arrUrl[4]);
                    defined('SEARCH_START_DATE') or define('SEARCH_START_DATE', isset($arrUrl[5]) ? $arrUrl[5] : '');
                    defined('SEARCH_NIGHT') or define('SEARCH_NIGHT', isset($arrUrl[6]) ? $arrUrl[6]: 1);
                    defined('SEARCH_HOTEL_TYPE') or define('SEARCH_HOTEL_TYPE', isset($arrUrl[7]) ? $arrUrl[7] : 'all');
                    defined('SEARCH_HOTEL_SOURCE') or define('SEARCH_HOTEL_SOURCE', isset($arrUrl[8]) ? $arrUrl[8] : 'all');
                    defined('SEARCH_STAR') or define('SEARCH_STAR', isset($arrUrl[9]) ? $arrUrl[9] : 'all');
                    defined('SEARCH_HOTEL_NAME') or define('SEARCH_HOTEL_NAME', isset($arrUrl[10]) ? $arrUrl[10] : 'all');
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                   
                    break;
                }
                case 'detailHotel' :{


                    defined('TYPE_APPLICATION') or define('TYPE_APPLICATION', $arrUrl[4]);
                    defined('HOTEL_INDEX') or define('HOTEL_INDEX', $arrUrl[5]);
                    defined('REQUEST_NUMBER') or define('REQUEST_NUMBER', $arrUrl[6]);
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    break;
                }
                case 'roomHotelLocal': {
                    defined('ROOM_HOTEL_TITLE') or define('ROOM_HOTEL_TITLE', $arrUrl[4]);
                    defined('TYPE_APPLICATION') or define('TYPE_APPLICATION', $arrUrl[4]);
                    defined('HOTEL_ID') or define('HOTEL_ID', $arrUrl[5]);
                    defined('HOTEL_NAME_EN') or define('HOTEL_NAME_EN', $arrUrl[6]);
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset($_POST['nights'])) {
                            defined('NIGHTS') or define('NIGHTS', $_POST['nights']);
                        } elseif (isset($_POST['NightsForHotelLocal'])) {
                            defined('NIGHTS') or define('NIGHTS', $_POST['NightsForHotelLocal']);
                        } else {
                            defined('NIGHTS') or define('NIGHTS', '1');
                        }

                        if (isset($_POST['startDate'])) {
                            defined('START_DATE') or define('START_DATE', $_POST['startDate']);
                        } elseif (isset($_POST['NightsForHotelLocal'])) {
                            defined('START_DATE') or define('START_DATE', $_POST['startDateForHotelLocal']);
                        } else {
                            defined('START_DATE') or define('START_DATE', '');
                        }

                        if (isset($_POST['isShowReserve'])){
                            defined('IS_SHOW_RESERVE') or define('IS_SHOW_RESERVE', $_POST['isShowReserve']);
                        } else {
                            defined('IS_SHOW_RESERVE') or define('IS_SHOW_RESERVE', '');
                        }

                        if (isset($_POST['isExternal'])){
                            defined('IS_EXTERNAL') or define('IS_EXTERNAL', $_POST['isExternal']);
                        } else {
                            defined('IS_EXTERNAL') or define('IS_EXTERNAL', 'no');
                        }
                        defined('CURRENCY_CODEE') or define('CURRENCY_CODEE', $_POST['CurrencyCode']);


                    }
                    else {
                        defined('NIGHTS') or define('NIGHTS', '1');
                        defined('START_DATE') or define('START_DATE', '');
                        defined('IS_SHOW_RESERVE') or define('IS_SHOW_RESERVE', '');
                        defined('CURRENCY_CODEE') or define('CURRENCY_CODEE', '');
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'resultEuropcarLocal': {

                    if (strpos($arrUrl[4], "-")) {
                        $stationId = explode('-', $arrUrl[4]);
                        defined('SOURCE_STATION_ID') or define('SOURCE_STATION_ID', $stationId[0]);
                        defined('DEST_STATION_ID') or define('DEST_STATION_ID', $stationId[1]);

                    } else {
                        defined('SOURCE_STATION_ID') or define('SOURCE_STATION_ID', $arrUrl[4]);
                        defined('DEST_STATION_ID') or define('DEST_STATION_ID', $arrUrl[4]);

                    }
                    defined('GET_CAR_DATETIME') or define('GET_CAR_DATETIME', $arrUrl[5]);
                    defined('RETURN_CAR_DATETIME') or define('RETURN_CAR_DATETIME', $arrUrl[5]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'tours':{

                    $destination = $arrUrl[4];
                    defined('SLUG') or define('SLUG', $destination);
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    break;
                }
                case 'resultTourLocal': {

                    $origin = explode('-', $arrUrl[4]);
                    defined('SEARCH_ORIGIN_COUNTRY') or define('SEARCH_ORIGIN_COUNTRY', $origin[0]);
                    defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', $origin[1]);
                    if (isset($origin[2]) && !empty($origin[2])) {
                        defined('SEARCH_ORIGIN_REGION') or define('SEARCH_ORIGIN_REGION', $origin[2]);
                    }

                    $destination = explode('-', $arrUrl[5]);
                    defined('SEARCH_DESTINATION_COUNTRY') or define('SEARCH_DESTINATION_COUNTRY', $destination[0]);
                    defined('SEARCH_DESTINATION_CITY') or define('SEARCH_DESTINATION_CITY', $destination[1]);
                    if (isset($destination[2]) && !empty($destination[2])) {
                        defined('SEARCH_DESTINATION_REGION') or define('SEARCH_DESTINATION_REGION', $destination[2]);
                    }

                    defined('SEARCH_DATE') or define('SEARCH_DATE', $arrUrl[6]);

                    if (isset($arrUrl[7]) && !empty($arrUrl[7])) {
                        defined('SEARCH_TOUR_TYPE') or define('SEARCH_TOUR_TYPE', $arrUrl[7]);
                    } else {
                        defined('SEARCH_TOUR_TYPE') or define('SEARCH_TOUR_TYPE', 'all');
                    }

                    if (isset($arrUrl[8]) && !empty($arrUrl[8])) {
                        defined('SEARCH_TOUR_SPECIAL') or define('SEARCH_TOUR_SPECIAL', $arrUrl[8]);
                    } else {
                        defined('SEARCH_TOUR_SPECIAL') or define('SEARCH_TOUR_SPECIAL', '0');
                    }
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'detailTour-v2':
                {

                    defined('TOUR_ID') or define('TOUR_ID', $arrUrl[4]);
                    defined('TOUR_NAME_EN') or define('TOUR_NAME_EN', $arrUrl[5]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'detailTour':
                {


//                    defined('TOUR_ID') or define('TOUR_ID', $arrUrl[4]);
                    defined('TOUR_ID_SAME') or define('TOUR_ID_SAME', $arrUrl[4]);
                    defined('TOUR_NAME_EN') or define('TOUR_NAME_EN', $arrUrl[5]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'detailTour-v3':
                {

                    defined('TOUR_ID') or define('TOUR_ID', $arrUrl[4]);
                    defined('TOUR_NAME_EN') or define('TOUR_NAME_EN', $arrUrl[5]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'detailEntertainment': {

                    defined('ENTERTAINMENT_ID') or define('ENTERTAINMENT_ID', $arrUrl[4]);
                    defined('ENTERTAINMENT_TITLE_EN') or define('ENTERTAINMENT_TITLE_EN', $arrUrl[5]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'resultGasht': {

                    defined('REQUEST_TYPE') or define('REQUEST_TYPE', $arrUrl[4]);

                    defined('CITY_CODE') or define('CITY_CODE', $arrUrl[5]);
                    if (!empty($arrUrl[6])) {
                        defined('REQUEST_DATE') or define('REQUEST_DATE', $arrUrl[6]);
                    }

                    if (!empty($arrUrl[7]) && REQUEST_TYPE == 0) {
                        defined('GASHT_TYPE') or define('GASHT_TYPE', $arrUrl[7]);
                    } else if (!empty($arrUrl[7]) && REQUEST_TYPE == 1) {
                        $type = explode('-', $arrUrl[7]);
                        defined('WELCOME_TYPE') or define('WELCOME_TYPE', $type[0]);
                        defined('VEHICLE_TYPE') or define('VEHICLE_TYPE', $type[1]);
                        defined('TRANSFER_PLACE') or define('TRANSFER_PLACE', $type[2]);
                    }


                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'buses': {

                    $arrCity = explode('-', $arrUrl[4]);
                    defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', strtoupper($arrCity[0]));
                    defined('SEARCH_DESTINATION_CITY') or define('SEARCH_DESTINATION_CITY', strtoupper($arrCity[1]));
                    defined('SEARCH_DATE_MOVE') or define('SEARCH_DATE_MOVE', $arrUrl[5]);

                    defined('REQUEST') or define('REQUEST', 'resultBusTicket');

                    break;
                }
                case 'mag': {



                    defined('MAG_TITLE') or define('MAG_TITLE', $arrUrl[4]);
                    defined('MAG_CATEGORY') or define('MAG_CATEGORY', $arrUrl[5]);
                    defined('REQUEST') or define('REQUEST', 'mag');

                    break;
                }

                case 'visa':
                case 'immigration':
                case 'pickup':
                case 'embassy':
                {

                    defined('IMMIGRATION_COUNTRY') or define('IMMIGRATION_COUNTRY', $arrUrl[4]);
                    defined('IMMIGRATION_ID') or define('IMMIGRATION_ID', $arrUrl[5]);
                    defined('REQUEST') or define('REQUEST', 'immigration');

                    break;
                }
                case 'news': {
                    defined('NEWS_TITLE') or define('NEWS_TITLE', $arrUrl[4]);
                    defined('NEWS_CATEGORY') or define('NEWS_CATEGORY', $arrUrl[5]);
                    defined('MAG_CATEGORY') or define('MAG_CATEGORY', $arrUrl[5]);
                    
                    defined('REQUEST') or define('REQUEST', 'news');

                    break;
                }
                case 'page': {

                    defined('PAGE_TITLE') or define('PAGE_TITLE', $arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', 'page');

                    break;
                }

                case 'trainResult':
                case 'resultTrainApi': {
                    $dep_arr = explode('-', $arrUrl[4]);
                    $person_arr = explode('-', $arrUrl[7]);

                    if (isset($dep_arr[0])) {
                        defined('DEP_CITY') or define('DEP_CITY', strtoupper($dep_arr[0]));
                    }
                    if (isset($dep_arr[1])) {
                        defined('ARR_CITY') or define('ARR_CITY', strtoupper($dep_arr[1]));
                    }
                    if (!empty($arrUrl[5])) {

                        $dates = explode('&', $arrUrl[5]);
                        defined('REQUEST_DATE') or define('REQUEST_DATE', $dates[0]);
                        if (!empty($dates[1])) {
                            defined('SEARCH_RETURN_DATE') or define('SEARCH_RETURN_DATE', $dates[1]);
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'TwoWay');
                        } else {
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'OneWay');
                        }

                    }
                    if (!empty($arrUrl[6])) {
                        defined('TYPE_WAGON') or define('TYPE_WAGON', $arrUrl[6]);
                    }
                    if (isset($person_arr[0])) {
                        defined('ADULT') or define('ADULT', $person_arr[0]);
                    }
                    if (isset($person_arr[1])) {
                        defined('CHILD') or define('CHILD', $person_arr[1]);
                    }
                    if (isset($person_arr[2])) {
                        defined('INFANT') or define('INFANT', $person_arr[2]);
                    }
                    defined('PASSENGER_NUM') or define('PASSENGER_NUM', $arrUrl[6]);
                    defined('PASSENGER_COUNT') or define('PASSENGER_COUNT', ($person_arr[0]+$person_arr[1]+$person_arr[2]));

                    if (isset($arrUrl[8])) {
                        defined('COUPE') or define('COUPE', $arrUrl[8]);
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }

                case 'resultTrain': {
                    $dep_arr = explode('-', $arrUrl[4]);
                    $person_arr = explode('-', $arrUrl[7]);

                    if (isset($dep_arr[0])) {
                        defined('DEP_CITY') or define('DEP_CITY', strtoupper($dep_arr[0]));
                    }
                    if (isset($dep_arr[1])) {
                        defined('ARR_CITY') or define('ARR_CITY', strtoupper($dep_arr[1]));
                    }
                    if (!empty($arrUrl[5])) {

                        $dates = explode('&', $arrUrl[5]);
                        defined('REQUEST_DATE') or define('REQUEST_DATE', $dates[0]);
                        if (!empty($dates[1])) {
                            defined('SEARCH_RETURN_DATE') or define('SEARCH_RETURN_DATE', $dates[1]);
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'TwoWay');
                        } else {
                            defined('SEARCH_MULTI_WAY') or define('SEARCH_MULTI_WAY', 'OneWay');
                        }

                    }
                    if (!empty($arrUrl[6])) {
                        defined('TYPE_WAGON') or define('TYPE_WAGON', $arrUrl[6]);
                    }
                    if (isset($person_arr[0])) {
                        defined('ADULT') or define('ADULT', $person_arr[0]);
                    }
                    if (isset($person_arr[1])) {
                        defined('CHILD') or define('CHILD', $person_arr[1]);
                    }
                    if (isset($person_arr[2])) {
                        defined('INFANT') or define('INFANT', $person_arr[2]);
                    }
                    defined('PASSENGER_NUM') or define('PASSENGER_NUM', $arrUrl[6]);
                    defined('PASSENGER_COUNT') or define('PASSENGER_COUNT', ($person_arr[0]+$person_arr[1]+$person_arr[2]));

                    if (isset($arrUrl[8])) {
                        defined('COUPE') or define('COUPE', $arrUrl[8]);
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'resultInsurance': {
                    if($arrUrl[4] == '1') {
                        defined('INSURANCE_DESTINATION') or define('INSURANCE_DESTINATION', 'IRN');
                    }else{
                        defined('INSURANCE_DESTINATION') or define('INSURANCE_DESTINATION', $arrUrl[5]);
                    }

                    if($arrUrl[4] == '2') {
                        defined('INSURANCE_ORIGIN') or define('INSURANCE_ORIGIN', 'IRN');
                    }else{
                        defined('INSURANCE_ORIGIN') or define('INSURANCE_ORIGIN', $arrUrl[5]);
                    }
                    defined('INSURANCE_TYPE') or define('INSURANCE_TYPE', $arrUrl[4]);
                    defined('INSURANCE_NUM_DAY') or define('INSURANCE_NUM_DAY', $arrUrl[6]);
                    defined('INSURANCE_NUM_MEMBER') or define('INSURANCE_NUM_MEMBER', $arrUrl[7]);

                    //        Birth Date For Insurance Member
                    $insuranceBirthDates = array($arrUrl[8]);
                    if (!empty($arrUrl[9])) {
                        array_push($insuranceBirthDates, $arrUrl[9]);
                    }
                    if (!empty($arrUrl[10])) {
                        array_push($insuranceBirthDates, $arrUrl[10]);
                    }
                    if (!empty($arrUrl[11])) {
                        array_push($insuranceBirthDates, $arrUrl[11]);
                    }
                    if (!empty($arrUrl[12])) {
                        array_push($insuranceBirthDates, $arrUrl[12]);
                    }
                    if (!empty($arrUrl[13])) {
                        array_push($insuranceBirthDates, $arrUrl[13]);
                    }
                    if (!empty($arrUrl[14])) {
                        array_push($insuranceBirthDates, $arrUrl[14]);
                    }
                    if (!empty($arrUrl[15])) {
                        array_push($insuranceBirthDates, $arrUrl[15]);
                    }
                    if (!empty($arrUrl[16])) {
                        array_push($insuranceBirthDates, $arrUrl[16]);
                    }

                    define("INSURANCE_BIRTH_DATE", serialize($insuranceBirthDates));

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'rentCar': {
                    defined('CAR_TYPE') or define('CAR_TYPE', $arrUrl[4]);
                    defined('RENT_DATE') or define('RENT_DATE', $arrUrl[5]);
                    defined('RENT_PLACE') or define('RENT_PLACE', $arrUrl[6]);
                    defined('DELIVERY_DATE') or define('DELIVERY_DATE', $arrUrl[7]);
                    defined('DELIVERY_PLACE') or define('DELIVERY_PLACE', $arrUrl[8]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'reserveCar': {
                    defined('CAR_ID') or define('CAR_ID', $arrUrl[4]);
                    defined('CAR_TYPE') or define('CAR_TYPE', $arrUrl[5]);
                    defined('RENT_DATE') or define('RENT_DATE', $arrUrl[6]);
                    defined('RENT_PLACE') or define('RENT_PLACE', $arrUrl[7]);
                    defined('DELIVERY_DATE') or define('DELIVERY_DATE', $arrUrl[8]);
                    defined('DELIVERY_PLACE') or define('DELIVERY_PLACE', $arrUrl[9]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'resultExternalHotel': {

                    defined('SEARCH_COUNTRY') or define('SEARCH_COUNTRY', $arrUrl[4]);
                    defined('SEARCH_CITY') or define('SEARCH_CITY', $arrUrl[5]);
                    defined('SEARCH_START_DATE') or define('SEARCH_START_DATE', $arrUrl[6]);
                    defined('SEARCH_END_DATE') or define('SEARCH_END_DATE', $arrUrl[7]);
                    defined('SEARCH_NIGHT') or define('SEARCH_NIGHT', $arrUrl[8]);
                    defined('SEARCH_ROOMS') or define('SEARCH_ROOMS', $arrUrl[9]);
                    if (isset($arrUrl[10])) {
                        $name = str_replace("-", " ", $arrUrl[10]);
                        $name = strtolower($name);
                        defined('SEARCH_HOTEL_NAME') or define('SEARCH_HOTEL_NAME', $name);
                    } else {
                        defined('SEARCH_HOTEL_NAME') or define('SEARCH_HOTEL_NAME', '');
                    }
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'roomExternalHotel': {

                    defined('TYPE_APPLICATION') or define('TYPE_APPLICATION', $arrUrl[4]);
                    defined('HOTEL_ID') or define('HOTEL_ID', $arrUrl[5]);
                    defined('HOTEL_NAME_EN') or define('HOTEL_NAME_EN', $arrUrl[6]);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        defined('START_DATE') or define('START_DATE', $_POST['startDate']);
                        defined('END_DATE') or define('END_DATE', $_POST['endDate']);
                        defined('NIGHTS') or define('NIGHTS', $_POST['nights']);
                        defined('SEARCH_ROOMS') or define('SEARCH_ROOMS', $_POST['searchRooms']);
                        defined('LOGIN_ID_API') or define('LOGIN_ID_API', $_POST['loginIdApi']);
                        defined('SEARCH_ID_API') or define('SEARCH_ID_API', $_POST['searchIdApi']);
                        defined('CURRENCY_CODEE') or define('CURRENCY_CODEE', $_POST['CurrencyCode']);
                    } else {
                        defined('START_DATE') or define('START_DATE', '');
                        defined('END_DATE') or define('END_DATE', '');
                        defined('NIGHTS') or define('NIGHTS', '1');
                        defined('SEARCH_ROOMS') or define('SEARCH_ROOMS', 'R:1-0-0');
                        defined('LOGIN_ID_API') or define('LOGIN_ID_API', '');
                        defined('SEARCH_ID_API') or define('SEARCH_ID_API', '');
                        defined('CURRENCY_CODEE') or define('CURRENCY_CODEE', '');
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'resultBus': {
                    $orig_dest = explode('-', $arrUrl[4]);

                    if (isset($orig_dest[0])) {
                        defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', $orig_dest[0]);
                    }
                    if (isset($orig_dest[1])) {
                        defined('SEARCH_DESTINATION_CITY') or define('SEARCH_DESTINATION_CITY', $orig_dest[1]);
                    }
                    defined('SEARCH_DEPT_DATE') or define('SEARCH_DEPT_DATE', $arrUrl[5]);

                    $num = explode('-', $arrUrl[6]);
                    defined('SEARCH_ADULT') or define('SEARCH_ADULT', $num[0]);
                    defined('SEARCH_CHILD') or define('SEARCH_CHILD', $num[1]);
                    defined('SEARCH_INFANT') or define('SEARCH_INFANT', $num[2]);

                    defined('TIME_INTERVAL') or define('TIME_INTERVAL', $arrUrl[7]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }

                case 'resultVisa':
                case 'flatResultVisa':
                {
                    defined('DESTINATION_CODE') or define('DESTINATION_CODE', $arrUrl[4]);
                    defined('VISA_TYPE') or define('VISA_TYPE', $arrUrl[5]);
                    if(isset($arrUrl[7])) {
                        defined('VISA_CATEGORY') or define('VISA_CATEGORY', $arrUrl[7]);
                    }else{
                        defined('VISA_CATEGORY') or define('VISA_CATEGORY', 1);
                    }

                    $num = explode('-', $arrUrl[6]);
                    defined('SEARCH_ADULT') or define('SEARCH_ADULT', $num[0]);
                    defined('SEARCH_CHILD') or define('SEARCH_CHILD', $num[1]);
                    defined('SEARCH_INFANT') or define('SEARCH_INFANT', $num[2]);
                    defined('SEARCH_CATEGORY') or define('SEARCH_CATEGORY', $arrUrl[7]);

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'agencyListByCity': {

                    defined('SEARCH_CITY') or define('SEARCH_CITY', $arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'resultEntertainment': {
                    defined('COUNTRY_ID') or define('COUNTRY_ID', $arrUrl[4]);
                    defined('CITY_ID') or define('CITY_ID', $arrUrl[5]);
                    defined('CATEGORY_ID') or define('CATEGORY_ID', $arrUrl[6]);



                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'articles' : {
                    defined('ARTICLE_SERVICE') or define('ARTICLE_SERVICE',$arrUrl[4]);
                    if(isset($arrUrl[5])){
                        if($arrUrl[4] == 'archive'){
                            defined('ARCHIVE') or define('archive',$arrUrl[5]);
                        }else{
                            defined('ARTICLE_ID') or define('ARTICLE_ID',$arrUrl[5]);
                        }
                    }

                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);

                    break;
                }
                case 'aboutIran': {

                    defined('ABOUT_IRAN_ID') or define('ABOUT_IRAN_ID',$arrUrl[4]);
                    defined('ANCIENT_TITLE') or define('ANCIENT_TITLE', $arrUrl[7]);
                    defined('ANCIENT_ID') or define('ANCIENT_ID',$arrUrl[7]);
                    defined('REQUEST') or define('REQUEST', 'aboutIran');

                    break;
                }
                case 'aboutCountry': {
                    defined('ABOUT_COUNTRY_ID') or define('ABOUT_COUNTRY_ID',$arrUrl[5]);
                    defined('OTHER_COUNTRY_ID') or define('OTHER_COUNTRY_ID',$arrUrl[6]);
                    defined('COUNTRY_ID') or define('COUNTRY_ID',$arrUrl[7]);
                    defined('REQUEST') or define('REQUEST', 'aboutCountry');

                    break;
                }
                case 'introductIran': {
                    defined('INTRODUCT_IRAN_ID') or define('INTRODUCT_IRAN_ID',$arrUrl[4]);
                    defined('ANCIENT_TITLE') or define('ANCIENT_TITLE', $arrUrl[7]);
                    defined('ANCIENT_ID') or define('ANCIENT_ID',$arrUrl[7]);
                    defined('REQUEST') or define('REQUEST', 'introductIran');

                    break;
                }
                case 'introductCountry': {
                    defined('INTRODUCT_COUNTRY_ID') or define('INTRODUCT_COUNTRY_ID',$arrUrl[4]);
                    defined('PROVINCE_TITLE') or define('PROVINCE_TITLE', $arrUrl[7]);
                    defined('PROVINCE_ID') or define('PROVINCE_ID',$arrUrl[7]);
                    defined('REQUEST') or define('REQUEST', 'introductCountry');

                    break;
                }
                case 'video': {
                    defined('VIDEO_ID') or define('VIDEO_ID',$arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', 'video');

                    break;
                }
                case 'recommendation': {
                    defined('RECOMMENDATION_ID') or define('RECOMMENDATION_ID',$arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', 'recommendation');
                    break;
                }
                case 'gallery': {
                    defined('GALLERY_ID') or define('GALLERY_ID',$arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', 'gallery');

                    break;
                }
                case 'pay': {
                    defined('PAY_ID') or define('PAY_ID',$arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', 'pay');

                    break;
                }
                case 'hotel':
                case 'bookings':
                case 'roomManagement':
                case 'hotelLog':
                case 'hotelFinancialCenter':
                case 'newInvoice':
                case 'hotelInvoices': {
              
                    defined('MARKET_HOTEL_ID') or define('MARKET_HOTEL_ID', $arrUrl[4]);
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    break;
                }
                case 'hotelRole': {
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    break;
                }
                default: {
                    defined('REQUEST') or define('REQUEST', GDS_SWITCH);
                    break;
                }
            }

        } else {
            defined('REQUEST') or define('REQUEST', GDS_SWITCH);
        }


        if (isset($arrUrl[4]) && !empty($arrUrl[4])) {
            defined('HASH_CODE') or define('HASH_CODE', $arrUrl[4]);
        }

        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '&') !== false) {
            $arrExplode = explode('&', $_SERVER['HTTP_REFERER']); // baraye zamani ke dar url '&' dashte bashim (example pdf)
            if(isset($arrExplode[2])){

                defined('NAME_SECOND_FILE_IFRAME') or define('NAME_SECOND_FILE_IFRAME', $arrExplode[2]);
            }
            if(isset($arrExplode[3])){
                defined('NAME_THIRD_FILE_IFRAME') or define('NAME_THIRD_FILE_IFRAME', $arrExplode[3]);
            }
        }

    }
    else{

        $lang = in_array($arrUrlFirst[1], ['ar', 'en' , 'ru']) ? $arrUrlFirst[1] : 'fa';

        if ($lang != 'fa') {
            defined('SOFTWARE_LANG') or define('SOFTWARE_LANG', $lang);
        } elseif (isset($client['default_language'])) {
            defined('SOFTWARE_LANG') or define('SOFTWARE_LANG', $client['default_language']);
        }

        $rootAddressWithoutLang = SERVER_HTTP . CLIENT_DOMAIN . '/gds';

        $rootAddress = $rootAddressWithoutLang . '/' . SOFTWARE_LANG;
        defined('ROOT_ADDRESS_WITHOUT_LANG') or define('ROOT_ADDRESS_WITHOUT_LANG', $rootAddressWithoutLang);
        defined('ROOT_ADDRESS') or define('ROOT_ADDRESS', $rootAddress);


        if ( isset($arrUrlFirst[1]) && !in_array($arrUrlFirst[1], ['gds', '', 'intro', 'sitemap.xml'])) {

            if (isset($_GET['fbclid']) || isset($_GET['hjVerifyInstall'])) {
                header('Location: ' . SERVER_HTTP . $_SERVER["HTTP_HOST"]);
                exit();
            }elseif(isset($_GET['gad_source']) || isset($_GET['gclid'])){
                header('Location: ' . SERVER_HTTP . $_SERVER["HTTP_HOST"]);
                exit();
            } elseif (in_array($arrUrlFirst[1], ['ar', 'en','fa' , 'ru'])) {

                defined('GDS_SWITCH') or define('GDS_SWITCH', 'mainPage');
                defined('REQUEST') or define('REQUEST', GDS_SWITCH);
            } else {
	  
                header("HTTP/1.0 404 Not Found");
                include_once './404.html';
                exit();
            }
        }
        else {


            if(CLIENT_ID =='302' || CLIENT_ID=='303')
            {

                if ((strpos(CLIENT_MAIN_DOMAIN,'intro') !=false)) {
                    $newUrl = SERVER_HTTP.CLIENT_DOMAIN.'/intro';

                    if($_SERVER['HTTP_REFERER']!=$newUrl)
                    {
                        if($arrUrlFirst[1]=='intro'){

                            defined('GDS_SWITCH') or define('GDS_SWITCH', 'intro');
                        }else{


                            header('Location: ' . $newUrl);
                            exit();
                        }
                    }else{
                        defined('GDS_SWITCH') or define('GDS_SWITCH', 'mainPage');
                    }
                } else {
                    defined('GDS_SWITCH') or define('GDS_SWITCH', 'mainPage');
                }
            }
            else if(isset($arrUrlFirst[1]) && in_array($arrUrlFirst[1], ['sitemap.xml'])){
                defined('GDS_SWITCH') or define('GDS_SWITCH', 'sitemap');
            }
            else{

                defined('GDS_SWITCH') or define('GDS_SWITCH', 'mainPage');
            }
            defined('REQUEST') or define('REQUEST', GDS_SWITCH);
        }
        

    }

}
else {

    include_once './under/under.php';
    exit();
}



function sanitize_input($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

function detect_and_redirect_xss($array_url = null) {
    // Sanitize the entire request URI
    $_SERVER['REQUEST_URI'] = sanitize_input($_SERVER['REQUEST_URI']);

    // Check if URL parameters are present in $_GET or $array_url
    $parameters = !empty($_GET) ? $_GET : $array_url;

    $array_special_char = ["{","}",";","\n","'", "‘", "’", "'", "“", "”", "„" , '"', "(", ")", "<", ">","</","/>","alert","+","sleep","script"] ;


//    echo '<pre>'.print_r($array_url,true).'</pre>';

    if(empty($parameters)){
        $parameters = [];
    }

    $final_parameters = [];

        foreach ($parameters as $key => $value) {
            if(is_array($value)){
                foreach ($value as $key_array=>$val){
                    $final_parameters[] = $val;
                }
            }else{
                $final_parameters[$key] = $value;
            }
        }

    

    foreach ($final_parameters as $key => $value) {

        foreach ($array_special_char as $char) {

            if (strpos($value, $char) !== false) {
                include_once './403.php';
                exit();
            }

            if (strpos($key, $char) !== false) {
                include_once './403.php';
                exit();
            }
        }
        // Sanitize each parameter value
        $sanitized_value = sanitize_input($value);

        // Compare sanitized value with original value
        if ($sanitized_value !== $value) {
            // If they are different, potential XSS attack detected
            include_once './403.php';
            exit();
        }
    }
}

// Call the function with appropriate URL parameters
detect_and_redirect_xss($arrUrl);
