{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane {if ($smarty.const.GDS_SWITCH eq 'mainPage' && $client['order_number'] eq '1') || ($smarty.const.GDS_SWITCH eq 'page' && $active_tab eq $client['MainService'])}active{/if}" id="{$client['MainService']}"
     role="tabpanel" aria-labelledby="{$client['MainService']}-tab">
    {include file="./sections/train/btn-type-way.tpl"}
    <div class="row m-auto">

            <form class="d_contents" target="_blank" method="post" name="gds_train" id="gds_train">
                {include file="./sections/train/origin_selection.tpl"}
                {include file="./sections/train/destination_selection.tpl"}
                {include file="./sections/train/date_train.tpl"}
                {include file="./sections/train/passenger_count.tpl"}
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-1 btn_s col_search my-btn-tab">
                    <button type="button" onclick="searchTrain(true)" class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                    </button>
                </div>
            </form>

    </div>
</div>