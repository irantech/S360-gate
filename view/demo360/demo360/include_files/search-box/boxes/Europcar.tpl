{load_presentation_object filename="mainCity" assign="objCity"}
{assign var="type_data" value=['is_active'=>1 , 'limit' =>30]}
{assign var='listTypeCar' value=$obj_main_page->getTypeCar($type_data)}
<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Europcar">
    <h4 class='title-searchBox-mobile'>جستجو برای اجاره خودرو</h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-empty-search-box"></div>
        <div class="d-flex flex-wrap w-100">
            <form class="d_contents" data-action="/" id="cartype_rentCar_js" method="post" name="cartype_rentCar_js" target="_blank">

                {include file="./sections/Europcar/carType.tpl"}
                {include file="./sections/Europcar/rentDate.tpl"}
                {include file="./sections/Europcar/rentPlace.tpl"}
                {include file="./sections/Europcar/deliveryDate.tpl"}
                {include file="./sections/Europcar/deliveryPlace.tpl"}

                <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                    <button type="button" onclick="rentcar_local()" class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>