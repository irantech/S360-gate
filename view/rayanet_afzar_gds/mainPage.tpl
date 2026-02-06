<!doctype html>
<html lang="fa" dir="rtl">
{include file="include_files/header.tpl"}
<body>
{if $smarty.const.GDS_SWITCH neq 'mainPage'}
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
{/if}
{include file="include_files/search-box.tpl"}
</body>
{if $smarty.const.GDS_SWITCH neq 'mainPage'}
{include file="include_files/footer.tpl"}
{/if}
{include file="include_files/footer_script.tpl"}

</html>