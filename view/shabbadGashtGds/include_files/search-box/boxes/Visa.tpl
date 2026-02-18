<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Visa">
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
                        <span>جستجو</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>