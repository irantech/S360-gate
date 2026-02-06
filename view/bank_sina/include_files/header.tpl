{load_presentation_object filename="relaxTourism" assign="obj_main_page" subName="customers"}
{load_presentation_object filename="Session" assign="objSession" }
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{assign var="objFunctions" value=$objFunctions scope=parent}
{assign var="obj" value=$obj scope=parent}
{assign var="objDate" value=$objDate scope=parent}
{assign var="obj_main_page" value=$obj_main_page scope=parent}
{assign var="info_access_client_to_service" value=$obj_main_page->getInfoAuthClient() scope=parent}

    {assign var='main_page' value="" scope=parent}
    {assign var='StyleSheet' value="style.css" scope=parent}
    {assign var='StyleSheetMain' value="StyleSheet" }
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/pageInfo/main.tpl" obj_main_page=$obj_main_page}

    {if isset($info_page['all_meta_tags']) && $info_page['all_meta_tags']}
        {assign var="meta_tags" value=$info_page['all_meta_tags']}
        {foreach $meta_tags as $key=>$tag}
            {if $tag['name'] neq ''}
                <meta name="{$tag['name']}" content="{$tag['content']}">
            {/if}
        {/foreach}
    {/if}

    <base href="{$smarty.const.CLIENT_DOMAIN}" />
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="project_files/images/favicon.png">

    {* todo: this use in all page and all of them are necessary*}
    <link rel="stylesheet" href="project_files/css/register.css">
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    <link rel="stylesheet" href="project_files/css/header.css">
    {* todo: this use only in main-page*}
    <script type="text/javascript" src="project_files/js/jquery-3.4.1.min.js"></script>
{*    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>*}

    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
       <link rel="stylesheet" href="assets/main-asset/css/main.css">


       <link rel="stylesheet" href="project_files/css/owl.carousel.min.css">
        <link rel="stylesheet" href="project_files/css/owl.theme.default.min.css">

        <link rel="stylesheet" href="project_files/css/placeholder-loading.min.css">
        <link rel="stylesheet" href="assets/css/jquery-confirm.min.css"/>
        <link type="text/css" rel="stylesheet" href="assets/datepicker/jquery-ui.min.css"/>
        <link rel="stylesheet" type="text/css" href="{$smarty.const.ROOT_LIBRARY}/{$StyleSheetMain}.php" media="screen"/>
    <script type="text/javascript">
      var rootMainPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}';
      var clientMainDomain = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_MAIN_DOMAIN}';
      var libraryPath = '{$smarty.const.ROOT_LIBRARY}/';
      var gdsSwitch = '{$smarty.const.GDS_SWITCH}';
      var amadeusPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/';
      var amadeusPathByLang = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/{$smarty.const.SOFTWARE_LANG}/';
      var lang = '{$smarty.const.SOFTWARE_LANG}';
      var main_color = '{$smarty.const.COLOR_MAIN_BG}';
      var main_dir_customer = '{$smarty.const.FRONT_TEMPLATE_NAME}';
      var refer_url = '{if isset($smarty.session.refer_url)} {$smarty.session.refer_url} {else} "" {/if}';
      var query_param_get = JSON.parse('{$smarty.get|json_encode}');
      </script>

        <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>

        <!-- datepicker calendar -->
        <script type="text/javascript" src="assets/datepicker/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.ui.core.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.ui.datepicker-cc.js"></script>
        <script type="text/javascript" src="assets/datepicker/datepicker-scripts.js"></script>
        <script type="text/javascript" src="assets/datepicker/datepicker-declarations.js"></script>
        <script defer language="javascript">
          $(document).ready(function (e) {
            <!--DateTempFormat1 Or DateTempFormat2-->
            if ($('#DateTempFormat1').length > 0) {
              $('#NameDayTemp1').html("یکشنبه");
              $('#DayTemp1').html("");
              $('#MounthTemp1').html("");
              $('#YearTemp1').html("");
            }
            if ($('#DateTempFormat2').length > 0) {
              $('#NameDayTemp2').html("یکشنبه");
              $('#DateTemp2').html("");
            }
            if ($('#TimeTemp').length > 0) {
              $('#TimeTemp').html("");
            }
            if ($('#TimeSecondTemp').length > 0) {
              setInterval("GetSecond()", 1000);
            }
            <!--End DateTempFormat1  Or DateTempFormat2-->

            <!--Date Convert-->
            if ($('#shamsiConvertButton').length > 0 || $('#miladiConvertButton').length > 0) {
              //shamsi
              $('#txtShamsiCalendar').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy/mm/dd',
                yearRange: '1300:1480'
              });
              $('#shamsiConvertButton').click(function () {
                ConvertDate('fa')
              });
              //miladi
              $('#txtMiladiCalendar').datepicker({
                regional: '',
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy/mm/dd',
                yearRange: '1920:2120'
              });
              $('#miladiConvertButton').click(function () {
                ConvertDate('en')
              });
            }
            <!--End Date Convert-->

            <!--Sokhan-->
            <!--End Sokhan-->

            <!--Contact Information-->
            if ($('.SMFooterPhone').length > 0) {
              $('.SMFooterPhone').html("");
              $('.SMFooterPhone').attr("href", "tel:");
            }
            if ($('.SMFooterFax').length > 0) {
              $('.SMFooterFax').html("");
            }
            if ($('.SMFooterEmail').length > 0) {
              $('.SMFooterEmail').html("");
              $('.SMFooterEmail').attr("href", "mailto:");
            }
            if ($('.SMFooterAddress').length > 0) {
              $('.SMFooterAddress').html("");
            }
            if ($('.SMFooterMobile').length > 0) {
              $('.SMFooterMobile').html("");
              $('.SMFooterMobile').attr("href", "tel:");
            }
            <!--End Contact Information-->

            <!--Popup-->
            <!--End Popup-->

            <!--Item Sms-->
            <!--End Item Sms-->

            <!--Package Visa-->
            <!--End Package Visa-->

            <!--SubMenu-->
            SubMenoProject();
            <!--End SubMenu-->
          });


          var masir_commands = '';
        </script>

    {/if}


    {if $smarty.const.GDS_SWITCH neq 'mainPage'}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    {/if}

    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
        <link rel="stylesheet" href="project_files/css/tabs.css">
    {/if}
    <link rel="stylesheet" href="project_files/css/all.min.css">
    <link rel="stylesheet" href="project_files/css/select2.css">

</head>

<body>

{include file="include_files/menu.tpl"}









