{load_presentation_object filename="mainCity" assign="objCity"}
{assign var="type_data" value=['is_active'=>1 , 'limit' =>30]}
{assign var='listTypeCar' value=$obj_main_page->getTypeCar($type_data)}
<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Europcar">
    <div class="col-md-12 col-12">
        <div class="row">
            <form class="d_contents" data-action="/" id="cartype_rentCar_js" method="post" name="cartype_rentCar_js" target="_blank">
                {include file="./sections/europcar/carType.tpl"}
                {include file="./sections/europcar/rentDate.tpl"}
                {include file="./sections/europcar/rentPlace.tpl"}
                {include file="./sections/europcar/deliveryDate.tpl"}
                {include file="./sections/europcar/deliveryPlace.tpl"}
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search p-1">
                    <button class="btn theme-btn seub-btn b-0" onclick="rentcar_local()" type="button">
<span>
 جستجو
</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
