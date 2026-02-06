{assign var='cities' value=$obj_main_page->getBusRoutes()}
<div class="tab-pane {if $client['order_number'] eq '1' || ($smarty.const.GDS_SWITCH eq 'page' && $active_tab eq $client['MainService'])}active{/if}"
     id="{$client['MainService']}"
     role="tabpanel" aria-labelledby="{$client['MainService']}-tab">
    <div class="col-md-12 col-12">
        <div class="row">
            <form data-action="https://s360online.iran-tech.com/" method="post"  class="d_contents" id="gds_local_bus" name="gds_local_bus">
                {include file="./sections/bus/origin_selection.tpl" cities=$cities}
                {include file="./sections/bus/destination_selection.tpl" cities=$cities}
                {include file="./sections/bus/date_bus.tpl" }
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 btn_s col_search">
                    <button type="button" class="btn theme-btn seub-btn b-0 "
                            onclick="searchBus()"><span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
