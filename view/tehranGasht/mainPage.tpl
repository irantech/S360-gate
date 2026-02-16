<!doctype html>
<html lang="fa" dir="rtl">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/services.tpl"}
    {include file="include_files/advertisement.tpl"}
    {include file="include_files/blog.tpl"}
    {include file="include_files/customers.tpl"}
    {include file="include_files/newsletter.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>
{include file="include_files/footer_script.tpl"}
</html>