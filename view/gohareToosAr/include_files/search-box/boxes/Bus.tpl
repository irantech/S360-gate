<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Bus">
    <div class="empty-div"></div>
    <div class="col-md-12 col-12">
        <div class="row">
            <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gds_local_bus" method="post" name="gds_local_bus" target="_blank">
                {include file="./sections/Bus/origin_selection.tpl"}
                {include file="./sections/Bus/destination_selection.tpl"}
                {include file="./sections/Bus/date_bus.tpl"}



                <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                    <button type="button" class="btn theme-btn seub-btn b-0" onclick="searchBus()">
                        <span>بحث</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>