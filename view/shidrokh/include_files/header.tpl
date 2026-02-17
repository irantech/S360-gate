{load_presentation_object filename="shidrokhGds" assign="obj_main_page" subName="customers"}
{load_presentation_object filename="Session" assign="objSession" }
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}
{assign var="objFunctions" value=$objFunctions scope=parent}
{assign var="obj" value=$obj scope=parent}
{assign var="objDate" value=$objDate scope=parent}
{assign var="obj_main_page" value=$obj_main_page scope=parent}
{assign var="info_access_client_to_service" value=$obj_main_page->getInfoAuthClient() scope=parent}
{assign var='StyleSheetMain' value="StyleSheet" }

<!doctype html>
<html lang="fa">
<head>
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>

    <meta charset="utf-8">
    <meta name="description" content="{$obj->Title_head()}">
    <meta name="application-name" content="default"/>
    <meta name="author" content="Iran Technology LTD"/>
    <meta name="generator" content="Iran teach"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="stylesheet" type="text/css" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/GlobalFile/css/register.css">
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">


    {literal}
        <script src="project_files/js/jquery-3.4.1.min.js"></script>

    {/literal}

    {if $smarty.session.layout neq 'pwa'}
        <link rel="stylesheet" href="project_files/css/all.min.css">
        {*        <link rel="stylesheet" href="project_files/css/fontawesome.min.css">*}
        <link rel="stylesheet" href="project_files/css/style.css">
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}




</head>