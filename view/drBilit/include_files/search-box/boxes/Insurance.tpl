{assign var="countries" value=$obj_main_page->countryInsurance()}

<div class="tab-pane {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq $client['MainService']}active{/if}"
     id="{$client['MainService']}" role="tabpanel" aria-labelledby="{$client['MainService']}-tab">
    <div class="col-md-12 col-12">
        <div class="row">
            <form data-action="https://s360online.iran-tech.com/"  method="post"  class="d_contents justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search margin-bottom">
                    <div class="form-group">
                        <select data-placeholder="نام کشور مقصد"
                                name="insurance_destination_country"
                                id="insurance_destination_country"
                                class="select2_in  select2-hidden-accessible insurance-destination-country-js "tabindex="-1" aria-hidden="true">
                            {foreach $countries as $country}
                                <option value="{$country['abbr']}">{$country['persian_name']}({$country['abbr']})</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search margin-bottom">
                    <div class="form-group">
                        <select data-placeholder="انتخاب مدت سفر" name="travel_time" id="travel_time" class="select2_in travel-time-js select2-hidden-accessible" ">
                            <option value="">انتخاب کنید...</option>
                            <option value="5">تا 5 روز</option>
                            <option value="7">تا 7 روز</option>
                            <option value="8">تا 8 روز</option>
                            <option value="15">تا 15 روز</option>
                            <option value="23">تا 23 روز</option>
                            <option value="31">تا 31 روز</option>
                            <option value="45">تا 45 روز</option>
                            <option value="62">تا 62 روز</option>
                            <option value="92">تا 92 روز</option>
                            <option value="182">تا 182 روز</option>
                            <option value="186">تا 186 روز</option>
                            <option value="365">تا 365 روز</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search margin-bottom">
                    <div class="form-group">
                        <select  name="number_of_passengers"
                                 id="number_of_passengers"
                                 data-placeholder="انتخاب تعداد مسافر"
                                 class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js">
                            <option value="">انتخاب کنید...</option>
                            {for $i=1 to 9}
                                <option value="{$i}">{$i} نفر</option>
                            {/for}
                        </select>
                    </div>
                </div>
                <div class="nafaratbime count-passengers-js">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search search_col nafarat-bime margin-bottom passenger-age-div-js">
                        <div class="form-group">
                            <input type="text" class="form-control shamsiBirthdayCalendar passengers-age-js"
                                   name="txt_birth_insurance1" autocomplete='off'
                                   id="txt_birth_insurance1" placeholder="تاریخ تولد مسافر 1">
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search search_btn_insuranc">
                    <button type="button" onclick="searchInsurance()" class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
