


<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Insurance">
    <div class="empty-div">
    </div>
    <div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  name="gdsInsurance" id="gdsInsurance" class="d_contents">
                {include file="./sections/insurance/country.tpl"}
                {include file="./sections/insurance/duration.tpl"}
                {include file="./sections/insurance/passengerCount.tpl"}
                {*                {include file="./sections/insurance/date.tpl"}*}
                <div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-6 col-sm-6 col-12 col_search search_btn_insuranc">
                    <button type="button" onclick="searchInsurance()"
                            class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

