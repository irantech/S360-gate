<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Visa">
    <h4 class='title-searchBox-mobile'>جستجو برای ویزای مسافرتی</h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-empty-search-box"></div>
        <div class="d-flex flex-wrap w-100">
            <form data-action="https://s360online.iran-tech.com/" method="post" name="gdsVisa"
                  id="gdsVisa" target="_blank" class="d_contents">
                {include file="./sections/Visa/continent_visa.tpl"}
                {include file="./sections/Visa/country_visa.tpl"}
                {include file="./sections/Visa/type_visa.tpl"}
                {include file="./sections/Visa/passenger_count.tpl"}

                <div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center p-1">
                    <button type="button" onclick="searchVisa()" class="btn theme-btn seub-btn b-0">
                        <span>##Search##</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>