<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Visa">
    <div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" name="gdsVisa"
                  id="gdsVisa" target="_blank" class="d_contents">
                        {include file="./sections/visa/continent_visa.tpl"}
                        {include file="./sections/visa/country_visa.tpl"}
                        {include file="./sections/visa/type_visa.tpl"}
                        {include file="./sections/visa/passenger_count.tpl"}
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center">
                    <button type="button" onclick="searchVisa()" class="btn theme-btn seub-btn b-0">
                        <span>##Search##</span></button>
                </div>
            </form>
        </div>
    </div>
</div>