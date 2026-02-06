<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/why.tpl"}
    {include file="include_files/advertisement.tpl"}
    {include file="include_files/tours.tpl"}
    {include file="include_files/tours-second.tpl"}
    {if $smarty.session.layout neq 'pwa' }{include file="include_files/menu-second.tpl"}{/if}
    {include file="include_files/blog.tpl"}
    {include file="include_files/news.tpl"}
    {include file="include_files/newsletter.tpl"}
    {include file="include_files/new_social.tpl"}
    {include file="include_files/other.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>


{include file="include_files/footer_script.tpl"}
</html>