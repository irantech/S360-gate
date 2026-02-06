{assign var="info_access_client_to_service" value=$info_access_client_to_service}
{load_presentation_object filename="specialPages" assign="objSpecialPages"}
<style>
    .banner-slider-display {
        display: none !important;
    }
</style>

<coustom class="i_modular_banner_gallery">
<section class="search_box w-100">
<div class="container">
{if $smarty.const.GDS_SWITCH eq 'mainPage'}
    <div class="search_box_div_text">
        <h2>کجا می‌روید؟</h2>
        <h3>انتخاب مقصد باتو ، بقیه اش با هتلاتو</h3>
    </div>
{/if}

<div class="i_modular_searchBox search_box_div">
    {include file="./search-box/tabs-search-box.tpl"}
    {include file="./search-box/boxs-search.tpl"}
</div>
</div>
</section>
</coustom>
