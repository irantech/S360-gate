<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}

<main>
{*    {include file="include_files/banner-slider.tpl"}*}
    {include file="include_files/search-box.tpl"}
    {include file="include_files/special_tours.tpl"}
    {include file="include_files/new_tours.tpl"}
    {include file="include_files/hotel.tpl"}
    {include file="include_files/airline_box.tpl"}
{*    {include file="include_files/mag.tpl"}*}
    {include file="include_files/data_travel.tpl"}
    {include file="include_files/app.tpl"}
{*    {include file="include_files/blog.tpl"}*}
    {include file="include_files/newsletters.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>


{include file="include_files/footer_script.tpl"}
</html>