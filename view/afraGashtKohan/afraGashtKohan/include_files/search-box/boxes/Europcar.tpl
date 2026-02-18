<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Europcar">
        <div class="col-md-12 col-12">
                <div class="row">
                        <form data-action="/" method="post" target="_blank" class="d_contents"
                              name="cartype_rentCar_js" id="cartype_rentCar_js">
                                {include file="./sections/europcar/carType.tpl"}
                                {include file="./sections/europcar/rentDate.tpl"}
                                {include file="./sections/europcar/rentPlace.tpl"}
                                {include file="./sections/europcar/deliveryDate.tpl"}
                                {include file="./sections/europcar/deliveryPlace.tpl"}
                                <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                                        <button type="button" onclick="rentcar_local()" class="btn theme-btn seub-btn b-0">
                                                <span>##Search##</span></button>
                                </div>
                        </form>
                </div>
        </div>
</div>