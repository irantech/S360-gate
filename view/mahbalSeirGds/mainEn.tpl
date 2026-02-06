<!DOCTYPE html>
<html dir="rtl" lang="en">
{include file="include_files/headerEn.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menuEn.tpl"}{/if}
<main class="">
    {include file="include_files/search-box.tpl"}
    {include file="include_files/blog.tpl"}
</main>
{include file="include_files/footerEn.tpl"}
{include file="include_files/other-box-en.tpl"}
<a class="scrollup back-top" data-type="section-switch" href="javascript:" id="scroll-top" style="display: block;">
    <i class="fas fa-angle-up"></i>
</a>
</body>
{include file="include_files/footer_script.tpl"}
</html>