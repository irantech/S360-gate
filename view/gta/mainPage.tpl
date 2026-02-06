<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/other-box.tpl"}
    {include file="include_files/advertisement.tpl"}
    {include file="include_files/fast_flight_search.tpl"}
    {include file="include_files/tours.tpl"}
    {include file="include_files/about-us.tpl"}
    {include file="include_files/blog.tpl"}
    {include file="include_files/newsletter.tpl"}
</main>
{include file="include_files/footer.tpl"}
{include file="include_files/footer-second.tpl"}
</body>


{include file="include_files/footer_script.tpl"}
</html>