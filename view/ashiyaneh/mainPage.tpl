<!DOCTYPE html>

<html lang="en">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/tours.tpl"}
    {include file="include_files/about-us.tpl"}
    {include file="include_files/club-box.tpl"}

</main>
{include file="include_files/footer.tpl"}
</body>


{include file="include_files/footer_script.tpl"}
</html>