<?php

if (!Session::IsLogin() && isset($_COOKIE['Login']) && $_COOKIE['Login'] == 'success') {
    Session::LoginDo($_COOKIE['nameUser'], $_COOKIE['userId'], $_COOKIE['cardNo'], 'counter');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="<?php echo SERVER_HTTP.CLIENT_DOMAIN?>/gds/"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/gds/dist/css/pwaApp.css">
    <link rel="stylesheet" type="text/css" href="/gds/library/StyleSheet.php" media="screen"/>





    <meta name="theme-color" content="<?php echo COLOR_MAIN_BG;?>">
    <link rel="apple-touch-icon" href="./view/<?php echo FRONT_TEMPLATE_NAME;?>/project_files/icons/icon-512x512.png" type="image/jpg">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
     <link rel="manifest" href="./manifest">
    <link rel="icon" type="image/png" sizes="32x32" href="./view/<?php echo FRONT_TEMPLATE_NAME;?>/project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./view/<?php echo FRONT_TEMPLATE_NAME;?>/project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./view/<?php echo FRONT_TEMPLATE_NAME;?>/project_files/images/favicon.png">



    <title><?php echo CLIENT_NAME?></title>
</head>
<style>
  .fixed-loading{
      position: fixed;
      z-index: 98;
      top: 0;
      left: 0;
      right: 0;
      background-color: #efefef;
      width: 100%;
      height: 100vh;
  }
</style>
<body dir='<?php if(SOFTWARE_LANG == 'fa') echo 'rtl'; else  echo 'ltr' ;?>'>
<script
        src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
        crossorigin="anonymous"></script>
<script src="<?php echo SERVER_HTTP . CLIENT_DOMAIN?>/gds/pwa/bootstrap.bundle.js"></script>

<script src="<?php echo SERVER_HTTP.CLIENT_DOMAIN?>/gds/pwa/javascript.js"></script>
<script>
    const rootMainPath ="<?php echo SERVER_HTTP.CLIENT_DOMAIN?>";
    const clientMainDomain ="<?php echo SERVER_HTTP.CLIENT_MAIN_DOMAIN?>";
    const libraryPath ="<?php echo ROOT_LIBRARY; ?>/";
    const gdsSwitch ="<?php echo GDS_SWITCH; ?>";
    const amadeusPath ="<?php echo SERVER_HTTP.CLIENT_DOMAIN;?>/gds/";
    const amadeusPathByLang ="<?php echo SERVER_HTTP.CLIENT_DOMAIN?>/gds/<?php echo SOFTWARE_LANG?>/";
    const lang ="<?php echo SOFTWARE_LANG; ?>";
    const project_files ="<?php echo SERVER_HTTP.CLIENT_DOMAIN?>/gds/view/<?php echo FRONT_TEMPLATE_NAME; ?>/project_files";
    const main_dir_customer ="<?php echo FRONT_TEMPLATE_NAME?>";
    const main_color ="<?php echo COLOR_MAIN_BG; ?>";
    const client_data ='<?php echo CLIENT_MAIN_DOMAIN;?>';
    const client_name ='<?php echo CLIENT_NAME;?>';
    const client_id ='<?php echo CLIENT_ID;?>';
    const client_services ='<?php

        require ('controller/searchService.php');
        $search_service=new searchService();


        echo  json_encode($search_service->checkAccessService(false,CLIENT_ID));?>';
    const client_services_detail ='<?php

        echo  json_encode($search_service->checkAccessService(true,CLIENT_ID));?>';
    const online_url ='<?php echo 'https://'.CLIENT_DOMAIN;?>';
    //const refer_url ="<?php //echo refer_url; ?>//";
</script>




<style>
    .content_main_app::before {
        background: <?php echo COLOR_MAIN_BG; ?> center repeat url(/gds/images/bgtexture.png) !important;
    }
</style>

<div class="w-100 position-unset" id="vueApp">
    <pwa-app></pwa-app>
</div>

<?php


$padding='';
if(preg_match("/iPhone|iPad|iPod/", $_SERVER['HTTP_USER_AGENT'])){
    $padding='pb-3';
}

?>

<div id='pwa-footer' class="menu_fixed_bottom pwa-footer <?php echo $padding;?>">
    <div class="phone-bottom ">
        <a href="<?php if(CLIENT_ID != '150') {?>/gds/<?php echo SOFTWARE_LANG ?>/app?to=search-service<?php }else {?>https://www.hoteldebitcard.ir/s/<?php }?>" class="nav-link <?php if($_GET['to'] == 'search-service' || ( $_GET['to'] == '' && GDS_SWITCH == 'app')){echo 'active'; }?> text-dark font-weight-bold" data-index="0">
            <i class="far fa-home-lg"></i>
            <span class="nav-text"><?php echo $search_service->translate('Home') ?></span>
        </a>
        <?php if(CLIENT_ID != '150') {
          ?>
          <a href="/gds/<?php echo SOFTWARE_LANG ?>/app?to=purchase-record" class="nav-link <?php if($_GET['to'] == 'purchase-record'){echo 'active'; }?> text-dark font-weight-bold" data-index="1">
            <i class="far fa-suitcase-rolling"></i>
            <span class="nav-text"><?php echo $search_service->translate('Buyarchive') ?></span>
        </a>
          <a href="/gds/<?php echo SOFTWARE_LANG ?>/app?to=user-profile" class="nav-link <?php if($_GET['to'] == 'user-profile'){echo 'active'; }?> text-dark font-weight-bold" data-index="2">
            <i class="far fa-user"></i>
            <span class="nav-text"><?php echo $search_service->translate('userAccount') ?></span>
        </a>
          <a href="/gds/<?php echo SOFTWARE_LANG ?>/app?to=information" class="nav-link align-items-center <?php if($_GET['to'] == 'information'){echo 'active'; }?> text-dark font-weight-bold" data-index="3">


        <svg
          version="1.0"
          style="    width: 26px;
    transform: rotate(90deg);
    margin-top: -1px;"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 200.000000 200.000000"
          preserveAspectRatio="xMidYMid meet">
          <g
            transform="translate(0.000000,200.000000) scale(0.100000,-0.100000)"
            stroke="none">
            <path
              d="M890 1728 c-58 -40 -74 -71 -78 -151 -3 -60 1 -80 20 -117 33 -64 74
            -85 168 -85 94 0 135 21 168 85 31 59 28 173 -4 217 -42 56 -80 73 -164 73
            -63 0 -83 -4 -110 -22z" />
            <path
              d="M914 1180 c-47 -15 -91 -70 -100 -126 -9 -63 2 -144 24 -173 41 -55
            67 -66 162 -66 74 0 93 3 116 21 59 43 69 68 69 164 0 95 -10 121 -67 163 -31
            23 -152 33 -204 17z" />
            <path
              d="M933 621 c-87 -22 -128 -90 -121 -202 4 -76 21 -108 78 -146 48 -33
            172 -33 220 -1 58 40 74 71 78 151 6 128 -47 192 -164 202 -32 2 -74 0 -91 -4z" />
          </g>
        </svg>

        <span class="nav-text"><?php echo $search_service->translate('myAgency') ?></span>

       </a>
            <?php
        };?>
    </div>
</div>
<script type="text/javascript" src="/gds/view/client/assets/main-asset/js/public-main.js"></script>

<script src="/gds/dist/js/pwaApp.js"></script>

<script>
    $(document).ready(()=>{
        $('.pwa-footer a').click(function (){
            // var loading_tag="<div style='left: unset; top: 3px;' class='mx-auto loading-spinner-holder' id='loading-holder'> <img class='w-100' src='/gds/pwa/spinner.gif'> </div>";
            var loading_tag='<div class="fixed-loading"> <div class="w-100-vh mx-auto" id="loading-holder"> <img class="w-100" src="/gds/pwa/spinner.gif" alt="spinner" /> </div></div>';
            $('body').append(loading_tag);
            // $(this).find('i').addClass('invisible');
        })
    })
</script>
</body>
</html>