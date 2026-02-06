
<!DOCTYPE html>
<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
{include file="include_files/search-box.tpl"}
{include file="include_files/travel-agency.tpl"}
{include file="include_files/tours.tpl"}
{*{include file="include_files/tours-special-cat.tpl"}*}
    {include file="include_files/travel-advertise.tpl"}
    {include file="include_files/blog.tpl"}
{include file="include_files/brands.tpl"}
{include file="include_files/about-us.tpl"}
{include file="include_files/advantages.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>
{include file="include_files/footer_script.tpl"}
</html>