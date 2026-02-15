{load_presentation_object filename="specialPages" assign="objSpecialPages"}
{assign var="page" value=$objSpecialPages->unSlugPage($smarty.const.PAGE_TITLE)}
{*{$page|var_dump}*}
<link rel="stylesheet" href="assets/modules/css/visa-page.css">

<link rel='stylesheet' href='assets/modules/css/special-pages.css'>
{if $page}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/detail.tpl"}
    {if $page.files.main_file}

        <section class="baner-slider banner-slider banner-slider-display" style='background-image:url("{$page.files.main_file.src}")'></section>
    {/if}
    {if $page.position || $page.position neq '' }
        
        {include file="`$smarty.const.FRONT_CURRENT_THEME`include_files/search-box.tpl" active_tab=$page.position}


    {/if}

    {*    item page*}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/pages/item.tpl" page=$page objSpecialPages=$objSpecialPages}
    <link rel="stylesheet" href="assets/modules/css/jquery.fancybox.min.css">
    <script src="assets/modules/js/jquery.fancybox.min.js"></script>
    <script src="assets/modules/js/page.js"></script>
    <script src="assets/modules/js/visa-page.js"></script>
{else}
<section class="attachments-special-pages m-5 text-center bg-error">
    <div class="container">
    <div class='col-lg-12 p-5 one error'>
        <p>##NotResultsFound##</p>
    </div>
    </div>
</section>

{/if}
