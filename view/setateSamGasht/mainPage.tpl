<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    <article class="parent-banner">
        {include file="include_files/search-box.tpl"}
    </article>
    {include file="include_files/other-box.tpl"}
    {include file="include_files/tours.tpl"}
    {include file="include_files/blog.tpl"}
    {include file="include_files/newsletter.tpl"}
</main>
{include file="include_files/footer.tpl"}
</body>

{include file="include_files/footer_script.tpl"}
</html>