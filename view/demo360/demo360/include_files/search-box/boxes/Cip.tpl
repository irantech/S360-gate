{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane search-background shadow-box" id="{$client['MainService']}">
    <div id="cip" class="d_flex flex-wrap  searchbox-style-cip">
        <form method="post" class="d_contents" target="_blank" id="cip_form" name="cip_form">
            {include file="./sections/Cip/origin_selection.tpl"}
            {include file="./sections/Cip/trip_type.tpl"}
            {include file="./sections/Cip/date_cip.tpl"}
            {include file="./sections/Cip/passenger_count.tpl"}
            <div class="col-md-2 col-sm-6 col-12 btn_s col_search margin-center" style="margin-left: 0;">
{*                <button type="button"*}
                <button type="button" onclick="searchCip()"
                        class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>

</div>
