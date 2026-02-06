{assign var="info_access_client_to_service" value=$info_access_client_to_service}
{load_presentation_object filename="specialPages" assign="objSpecialPages"}
<style>
    .banner-slider-display {
        display: none !important;
    }
</style>

<div class="banner">
    <div class="container">
        <div class="searchs_box">
            {include file="./search-box/tabs-search-box.tpl"}
            {include file="./search-box/boxs-search.tpl"}
        </div>
    </div>
</div>



