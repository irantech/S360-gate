{assign var="countries" value=$obj_main_page->countryInsurance()}
<div class="__box__ tab-pane" id="Insurance">
    <div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  name="gdsInsurance" id="gdsInsurance" class="d_contents">
                {include file="./sections/Insurance/destination_country.tpl"}
                {include file="./sections/Insurance/duration_days_travel.tpl"}
                {include file="./sections/Insurance/number_of_passengers.tpl"}
                {include file="./sections/Insurance/date_of_birth.tpl"}
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_btn_insuranc p-1">
                    <button type="button" onclick="searchInsurance()"
                            class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
