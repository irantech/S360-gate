<!DOCTYPE html>
<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main class="">
    {include file="include_files/search-box.tpl"}
    {include file="include_files/advertisement.tpl"}
    {include file="include_files/fast_flight_search.tpl"}
    {include file="include_files/special-page-box.tpl"}
    {include file="include_files/tours.tpl"}a
    {include file="include_files/tours-second.tpl"}
    {include file="include_files/hotels-webservice.tpl"}
    {include file="include_files/blog.tpl"}
    {include file="include_files/faqs.tpl"}
</main>
{include file="include_files/footer.tpl"}
{include file="include_files/other-box.tpl"}
<a class="scrollup back-top" data-type="section-switch" href="javascript:" id="scroll-top" style="display: block;">
    <i class="fas fa-angle-up"></i>
</a>
</body>
{include file="include_files/footer_script.tpl"}
</html>