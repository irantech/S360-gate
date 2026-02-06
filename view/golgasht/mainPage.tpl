<!DOCTYPE html>

<html dir="rtl" lang="fa-IR">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/advertising.tpl"}
    {include file="include_files/blog.tpl"}
    {include file="include_files/tours.tpl"}
    {include file="include_files/tour.tpl"}
    {include file="include_files/hotels-external_cities.tpl"}
    {include file="include_files/about-us.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>
{include file="include_files/footer_script.tpl"}
</html>