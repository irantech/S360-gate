<!DOCTYPE html>

<html dir="rtl" lang="fa_IR">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
{include file="include_files/search-box.tpl"}
{include file="include_files/fast-search-flight.tpl"}
{include file="include_files/tours.tpl"}
{include file="include_files/hotel_reservation.tpl"}
{include file="include_files/blog.tpl"}
{include file="include_files/news.tpl"}
{include file="include_files/app.tpl"}
{include file="include_files/newsletter.tpl"}
{include file="include_files/footer.tpl"}
{include file="include_files/footer_script.tpl"}
</body>
</html>