<!DOCTYPE html>

<html dir="rtl" lang="fa-IR">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
     {include file="include_files/hotel-special-new.tpl"}
    {include file="include_files/special-hotel.tpl"}

    {include file="include_files/hotels-webservice.tpl"}
    {include file="include_files/text-mainPage.tpl"}
    {*    {include file="include_files/tours.tpl"}*}
    {include file="include_files/blog.tpl"}
    {include file="include_files/app.tpl"}

    {include file="include_files/newsletter.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>






{include file="include_files/footer_script.tpl"}
</html>