
{assign var="continents" value=$obj_main_page->getListContinents()}
<div aria-labelledby="visa-tab" class="__box__ tab-pane {if $active} active {/if}" id="Visa" role="tabpanel">
    <div class="col-12">
        <div class="row">
            <form class="d_contents w-100 d-flex flex-wrap" id="gdsVisa" method="post" name="gdsVisa" target="_blank">
                {include file="./sections/Visa/continent_visa.tpl"}
                {include file="./sections/Visa/country_visa.tpl"}
                {include file="./sections/Visa/type_visa.tpl"}
                {include file="./sections/Visa/passenger_count.tpl"}
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search btn_visa">
                    <button class="btn theme-btn seub-btn b-0" onclick="searchVisa()" type="button">
<span>
 جستجو
</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
