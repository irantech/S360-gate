<!doctype html>
<html lang="fa" dir="rtl">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}

</main>
{include file="include_files/footer.tpl"}

{include file="include_files/footer_script.tpl"}



</body>

</html>