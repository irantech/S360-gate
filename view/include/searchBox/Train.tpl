{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Train">
    {include file="./sections/train/btn-type-way.tpl"}
    <div class="row m-auto">
        <div class='d_contents'>
            {include file="./sections/train/origin_selection.tpl"}
            {include file="./sections/train/destination_selection.tpl"}
            {include file="./sections/train/date_train.tpl"}
            {include file="./sections/train/passenger_count.tpl"}
            <div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-3 col-sm-6 col-12 btn_s col_search margin-center">
                <button type="button" onclick="searchTrain(true)" class="btn theme-btn seub-btn b-0">
                    <span>جستجو</span>
                </button>
            </div>
        </div>
    </div>
</div>