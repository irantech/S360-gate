<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
{include file="include_files/search-box.tpl"}
{include file="include_files/tours.tpl"}
{include file="include_files/hotels-webservice.tpl"}
{include file="include_files/news.tpl"}
{include file="include_files/newsletter.tpl"}
{include file="include_files/other-box.tpl"}
</main>
<footer>
{include file="include_files/footer.tpl"}





</footer>
</body>

{include file="include_files/footer_script.tpl"}
</html>