{load_presentation_object filename="jahangardan" assign="obj_main_page" subName="customers"}
{load_presentation_object filename="Session" assign="objSession" }
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{assign var="objFunctions" value=$objFunctions scope=parent}
{assign var="obj" value=$obj scope=parent}
{assign var="objDate" value=$objDate scope=parent}
{assign var="obj_main_page" value=$obj_main_page scope=parent}
{assign var="info_page" value=$obj_main_page->getInfoPage() scope=parent}
{assign var="info_access_client_to_service" value=$obj_main_page->getInfoAuthClient() scope=parent}
{if $smarty.const.SOFTWARE_LANG eq 'en'}
    {assign var='StyleSheet' value="styleEn.css" scope=parent}
    {assign var='StyleSheetHeader' value="headerEn.css" scope=parent}
    {assign var='main_page' value="/en" scope=parent}
{else}
    {assign var='main_page' value="" scope=parent}
    {assign var='StyleSheet' value="style.css" scope=parent}
    {assign var='StyleSheetMain' value="StyleSheet" }

{/if}
<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">
<head>
    <title> {$info_page['title']} </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{$info_page['title']}</title>
    {assign var="meta_tags" value=$info_page['meta_tags']|json_decode:true}
    {foreach $meta_tags as $key=>$tag}
        <meta name="{$tag['name']}" content="{$tag['content']}">
    {/foreach}
    <base href="{$smarty.const.CLIENT_DOMAIN}" />
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">

    <script type="text/javascript" src="project_files/js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="project_files/css/all.css">
    {if $smarty.const.GDS_SWITCH eq 'mainPage'}
{*        <link rel="stylesheet" type="text/css" href="{$smarty.const.ROOT_LIBRARY}/{$StyleSheetMain}.php" media="screen"/>*}

        <link rel="stylesheet" href="assets/main-asset/css/main.css">

        <link rel="stylesheet" href="project_files/css/owl.carousel.min.css">
        <link rel="stylesheet" href="project_files/css/select2.css">
        <link rel="stylesheet" href="project_files/css/tab.css">
        <link rel="stylesheet" href="assets/css/jquery-confirm.min.css"/>
        <link type="text/css" rel="stylesheet" href="assets/datepicker/jquery-ui.min.css"/>

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
        <script type="text/javascript" src="assets/datepicker/jalali.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.ui.core.js"></script>
        <script type="text/javascript" src="assets/datepicker/jquery.ui.datepicker-cc.js"></script>
        <script type="text/javascript" src="assets/datepicker/datepicker-scripts.js"></script>
        <script type="text/javascript" src="assets/datepicker/datepicker-declarations.js"></script>
    {/if}

    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/bootstrap.css">
    <link rel="stylesheet" href="project_files/css/style.css">

    {if $smarty.const.GDS_SWITCH neq 'mainPage' }
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    {/if}
</head>

<body>
{include file="include_files/menu.tpl"}

