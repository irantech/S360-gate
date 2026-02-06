<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Entertainment">
    <div class="col-md-12 col-12">
        <div class="row">
            <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                  name="submit_tafrih_form" id="submit_tafrih_form">
                        {include file="./sections/entertainment/country_destination.tpl"}
                        {include file="./sections/entertainment/city_destination.tpl"}
                        {include file="./sections/entertainment/category_entertainment.tpl"}
                        {include file="./sections/entertainment/sub_category_entertainment.tpl"}


                <div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-2 col-sm-6 col-12 btn_s col_search margin-center">
                    <button type="button" onclick="searchEntertainment()"
                            class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
                </div>
            </form>
        </div>
    </div>
</div>