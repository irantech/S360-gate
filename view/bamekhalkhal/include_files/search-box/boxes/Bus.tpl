{assign var='cities' value=$obj_main_page->getBusRoutes()}
<div class="__box__ tab-pane {if $active} active {/if}" id="Bus">
    <div class="empty-div">
    </div>
    <div class="col-md-12 col-12">
        <div class="row">
            <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gds_local_bus" method="post"
                  name="gds_local_bus" target="_blank">
                {include file="./sections/Bus/origin_selection.tpl"}
                {include file="./sections/Bus/destination_selection.tpl"}
                {include file="./sections/Bus/date_bus.tpl"}
                <div class="col-12 btn_s col_search p-1">
                    <button type="button" class="btn theme-btn seub-btn b-0 "
                            onclick="searchBus()"><span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
