<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="{$client['MainService']}">
<div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" data-target="_self" class="d_contents" id="package_form" name="package_form">
                {include file="./sections/package/origin_search_box.tpl"}
                {include file="./sections/package/destination_search_box.tpl"}
                {include file="./sections/package/date_package.tpl"}
                {include file="./sections/package/passenger_count.tpl"}
                <div class="search_btn_div col-lg-2 col-md-3 col-sm-6 col-12 margin-center search_btn_div">
                    <button type="button" onclick="searchPackage('package')" class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>