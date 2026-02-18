{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane" id="{$client['MainService']}">
    <div id="cip" class="d_flex flex-wrap">
        <form method="post" class="d_contents" target="_blank" id="cip_form" name="cip_form">
            {include file="./sections/cip/origin_selection.tpl"}
            {include file="./sections/cip/trip_type.tpl"}
            {include file="./sections/cip/date_cip.tpl"}
            {include file="./sections/cip/passenger_count.tpl"}
            <div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-3 col-sm-6 col-12 btn_s col_search margin-center">
                <button type="button"
                <button type="button" onclick="searchCip()"
                        class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>

</div>
