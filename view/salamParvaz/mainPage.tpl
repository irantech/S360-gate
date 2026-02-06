<!doctype html>
<html lang="fa" dir="rtl">
{include file="include_files/header.tpl"}
<body>
{if $smarty.const.GDS_SWITCH neq 'mainPage'}{include file="include_files/menu.tpl"}{/if}

<main>
    {include file="include_files/search-box.tpl"}

</main>
{if $smarty.const.GDS_SWITCH neq 'mainPage'}{include file="include_files/footer.tpl"}{/if}

</body>
{include file="include_files/footer_script.tpl"}
</html>