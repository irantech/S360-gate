<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>

{if $smarty.session.layout neq 'pwa' }
    {include file="include_files/menu-1.tpl"}
{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/fast_flight_search-1.tpl"}


    {include file="include_files/about-us-1.tpl"}
{*    {include file="include_files/app.tpl"}*}

    {include file="include_files/newsletter-1.tpl"}
</main>
{include file="include_files/footer-1.tpl"}
</body>
{include file="include_files/footer_script.tpl"}
</html>