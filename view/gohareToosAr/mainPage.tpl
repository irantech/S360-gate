<!doctype html>
<html lang="fa" dir="rtl">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/tours_special.tpl"}
{*    {include file="include_files/visa.tpl"}*}
    {include file="include_files/hotels.tpl"}
    {include file="include_files/newsletter.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>
{include file="include_files/footer_script.tpl"}

</html>