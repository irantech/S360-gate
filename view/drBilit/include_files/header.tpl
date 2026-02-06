{load_presentation_object filename="drBilit" assign="obj_main_page" subName="customers"}
{load_presentation_object filename="Session" assign="objSession" }
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}

{assign var="objFunctions" value=$objFunctions scope=parent}
{assign var="obj" value=$obj scope=parent}
{assign var="objDate" value=$objDate scope=parent}
{assign var="obj_main_page" value=$obj_main_page scope=parent}
{assign var="info_page" value=$obj_main_page->getInfoPage() scope=parent}
{assign var="info_access_client_to_service" value=$obj_main_page->getInfoAuthClient() scope=parent}

{assign var='main_page' value="" scope=parent}
{assign var='StyleSheet' value="style.css" scope=parent}
{assign var='StyleSheetMain' value="StyleSheet" }

{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    {assign var='StyleSheetHeader' value="header.css" scope=parent}
{/if}

<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$info_page['title']}</title>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/pageInfo/main.tpl" obj_main_page=$obj_main_page}

    {if isset($info_page['all_meta_tags']) && $info_page['all_meta_tags']}
        {assign var="meta_tags" value=$info_page['all_meta_tags']}
        {foreach $meta_tags as $key=>$tag}
            {if $tag['name'] neq ''}
                <meta name="{$tag['name']}" content="{$tag['content']}">
            {/if}
        {/foreach}
    {/if}

    <link rel="shortcut icon" href="project_files/images/favicon.png" type="image/x-icon">
    {if $smarty.const.GDS_SWITCH eq 'mainPage' }
        <link rel="stylesheet" href="project_files/css/all.min.css">
    {/if}
    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
        {assign var="css_files" value=[
            "css/owl.carousel.min.css",
            "css/select2.css",
            "css/bootstrap.min.css",
            "css/header.css",
            "css/ticker.css",
            "css/register.css",
            "css/style.css"
        ]}
        {foreach $css_files as $css}
            <link rel="stylesheet"
                  href="project_files/{$css}?v={"`$smarty.const.FRONT_THEMES_DIR``$smarty.const.FRONT_TEMPLATE_NAME`/project_files/`$css`"|filemtime}">
        {/foreach}
    {else}
        {assign var="css_files" value=[
        "css/all.min.css",
        "css/header.css",
        "css/ticker.css",
        "css/register.css",
        "css/style.css"
        ]}
        {foreach $css_files as $css}
            <link rel="stylesheet"
                  href="project_files/{$css}?v={"`$smarty.const.FRONT_THEMES_DIR``$smarty.const.FRONT_TEMPLATE_NAME`/project_files/`$css`"|filemtime}">
        {/foreach}
    {/if}
    {literal}
            <script type="text/javascript" src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}

    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}

        <link rel="stylesheet" href="assets/main-asset/css/main.css">
        <link rel="stylesheet" href="project_files/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/jquery-confirm.min.css"/>
        <link type="text/css" rel="stylesheet" href="assets/datepicker/jquery-ui.min.css"/>
        <link rel="stylesheet" type="text/css" href="{$smarty.const.ROOT_LIBRARY}/{$StyleSheetMain}.php" media="screen"/>
        <link rel="stylesheet" href="project_files/css/select2.css">



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

        {literal}
            <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
            <!-- datepicker calendar -->
            <script type="text/javascript" src="assets/datepicker/jalali.js"></script>
            <script type="text/javascript" src="assets/datepicker/jquery.cookie.min.js"></script>
            <script type="text/javascript" src="assets/datepicker/jquery.ui.core.js"></script>
            <script type="text/javascript" src="assets/datepicker/jquery.ui.datepicker-cc.js"></script>
            <script type="text/javascript" src="assets/datepicker/datepicker-scripts.js"></script>
            <script type="text/javascript" src="assets/datepicker/datepicker-declarations.js"></script>
        {/literal}
    {/if}
    {if $smarty.const.GDS_SWITCH neq 'mainPage' }
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    {/if}
    {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
        <link rel="stylesheet" href="project_files/css/tabs.css">
     {/if}
    {if $smarty.const.GDS_SWITCH eq 'page'}
        <link rel="stylesheet" href="project_files/css/all.min.css">
    {/if}


    {literal}
        <!-- Hotjar Tracking Code for https://versagasht.com -->
        <script>
          (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:3728786,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
          })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    {/literal}

</head>
<body>
{if $smarty.session.layout neq 'pwa' }
    {include file="include_files/menu.tpl"}
{/if}
