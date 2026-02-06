
{load_presentation_object filename="rayanetafzargds" assign="obj_main_page" subName="customers"}
{load_presentation_object filename="Session" assign="objSession" }
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{assign var="objFunctions" value=$objFunctions scope=parent}
{assign var="obj" value=$obj scope=parent}
{assign var="objDate" value=$objDate scope=parent}
{assign var="obj_main_page" value=$obj_main_page scope=parent}
{assign var="info_access_client_to_service" value=$obj_main_page->getInfoAuthClient() scope=parent}

{assign var='StyleSheetMain' value="StyleSheet" }

{*{assign var="testFlightParams" value=['origin'=> null, 'search_for' =>'تهران']}*}
{*{assign var="testFlightParams" value=['origin'=> 'NJF', 'search_for' =>'تهران']}*}

{*{assign var="searchFlights" value=$obj_main_page->searchAirports($testFlightParams)}*}
{*{assign var="allAirports" value=$obj_main_page->allAirports()}*}
{*{$allAirports|var_dump}*}



<head>
<meta charset="utf-8"/>
<meta test="i_modular_modulation"/>
<meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" name="viewport"/>
<meta content="ie=edge" http-equiv="X-UA-Compatible"/>

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/pageInfo/main.tpl" obj_main_page=$obj_main_page}

    {if isset($info_page['all_meta_tags']) && $info_page['all_meta_tags']}
        {assign var="meta_tags" value=$info_page['all_meta_tags']}
        {foreach $meta_tags as $key=>$tag}
            {if $tag['name'] neq ''}
                <meta content="{$tag['content']}" name="{$tag['name']}"/>
            {/if}
        {/foreach}
    {/if}

    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
<link href="project_files/images/favicon.png" rel="shortcut icon" type="image/x-icon"/>


    {* todo: this use in all page and all of them are necessary*}


    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/header.css">



    {* todo: this use only in main-page*}
    <script src="project_files/js/jquery-3.4.1.min.js" type="text/javascript"></script>
    {*    <script crossorigin="anonymous" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>*}
    <link href="assets/main-asset/css/main.css" rel="stylesheet"/>

    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}

<link rel="stylesheet" href="project_files/css/owl.carousel.min.css">
<link href="assets/css/jquery-confirm.min.css" rel="stylesheet">
<link href="assets/datepicker/jquery-ui.min.css" rel="stylesheet" type="text/css">
{if $smarty.const.GDS_SWITCH eq 'mainPage'}
    <link type="text/css" rel="stylesheet" href="assets/datepicker-new/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/datepicker-new/price_calender.css"/>
    {else}
    <link type="text/css" rel="stylesheet" href="assets/datepicker/jquery-ui.min.css"/>
    {/if}
<link href="{$smarty.const.ROOT_LIBRARY}/{$StyleSheetMain}.php" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
          var rootMainPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}';
          var clientMainDomain = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_MAIN_DOMAIN}';
          var libraryPath = '{$smarty.const.ROOT_LIBRARY}/';
          var gdsSwitch = '{$smarty.const.GDS_SWITCH}';
          var amadeusPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/';
          var amadeusPathByLang = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_MAIN_DOMAIN}/gds/{$smarty.const.SOFTWARE_LANG}/';
          var lang = '{$smarty.const.SOFTWARE_LANG}';
          var main_color = '{$smarty.const.COLOR_MAIN_BG}';
          var main_dir_customer = '{$smarty.const.FRONT_TEMPLATE_NAME}';
          var refer_url = '{if isset($smarty.session.refer_url)} {$smarty.session.refer_url} {else} "" {/if}';
          var query_param_get = JSON.parse('{$smarty.get|json_encode}');
        </script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>

        <!-- datepicker calendar -->
{*    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}*}
{*        <script type="text/javascript" src="assets/datepicker-new/getRnagePrice.js"></script>*}
{*        <script type="text/javascript" src="assets/datepicker-new/jquery.cookie.min.js"></script>*}
{*        <script type="text/javascript" src="assets/datepicker-new/jquery.ui.core.js"></script>*}
{*        <script type="text/javascript" src="assets/datepicker-new/jquery.ui.datepicker-cc.js"></script>*}
{*        <script type="text/javascript" src="assets/datepicker-new/datepicker-scripts.js"></script>*}
{*        <script type="text/javascript" src="assets/datepicker-new/datepicker-declarations.js"></script>*}
{*    {else}*}
        <script type="text/javascript" src="assets/datepicker/jalali.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.ui.core.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.ui.datepicker-cc.js"></script>
        <script type="text/javascript" src="assets/datepicker/datepicker-scripts.js"></script>
        <script type="text/javascript" src="assets/datepicker/datepicker-declarations.js"></script>
{*    {/if}*}

    {/if}




    {if $smarty.const.GDS_SWITCH neq 'mainPage' }

<link href="project_files/css/{$StyleSheetHeader}" rel="stylesheet"/>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    {/if}

    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
        <link rel="stylesheet" href="project_files/css/select2.css">

    {/if}

    <link rel="stylesheet" href="project_files/css/all.min.css">

{*    <link rel="stylesheet" href="project_files/css/select2.css">*}
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/tab.css">
</head>
