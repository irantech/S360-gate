<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
    {include file="include_files/search-box.tpl"}
    {include file="include_files/hotels-webservice.tpl"}
    {include file="include_files/tours.tpl"}
    {include file="include_files/tours-second.tpl"}
    {include file="include_files/blog.tpl"}
    {include file="include_files/newsletter.tpl"}
</main>
<svg enable-background="new 0 0 500 250" id="wave_footer" preserveaspectratio="none" version="1.1" viewbox="0 0 500 250"
     x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
<path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"
      id="path_footer_svg">
</path>
</svg>
{include file="include_files/footer.tpl"}
</body>


{include file="include_files/footer_script.tpl"}
</html>