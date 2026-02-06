
{assign var="countries" value=$obj_main_page->countryInsurance()}

<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Insurance">
    <div class="empty-div"></div>

    <div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  name="gdsInsurance" id="gdsInsurance" class="d_contents">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder="غاية"
                                name="insurance_destination_country"
                                id="insurance_destination_country"
                                class="select2_in  select2-hidden-accessible insurance-destination-country-js"
                                tabindex="-1" aria-hidden="true">
                            <option value="">##اختر## ...</option>
                            {foreach $countries as $country}
                                <option value="{$country['abbr']}">

                                    {$country['english_name']}

                                    ({$country['abbr']})</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder="##travelDurationChoose##"
                                name="travel_time" id="travel_time"
                                class="select2_in travel-time-js select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">##ChoseOption## ...</option>
                            <option selected="" default="" disabled> مدة السفر</option>
                            <option value="5" {if $smarty.const.INSURANCE_NUM_DAY eq 5} selected="selected" {/if}>الى 5 يوم</option>
                            <option value="7" {if $smarty.const.INSURANCE_NUM_DAY eq 7} selected="selected" {/if}الى 7 يوم}</option>
                            <option value="8" {if $smarty.const.INSURANCE_NUM_DAY eq 8} selected="selected" {/if}>الى 8 يوم</option>
                            <option value="15" {if $smarty.const.INSURANCE_NUM_DAY eq 15} selected="selected" {/if}>الى 15 يوم</option>
                            <option value="45" {if $smarty.const.INSURANCE_NUM_DAY eq 45} selected="selected" {/if}>الى 45 يوم</option>
                        </select></div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select name="number_of_passengers"
                                id="number_of_passengers"
                                data-placeholder="اختر عدد الركاب"
                                class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js"
                                tabindex="-1" aria-hidden="true">
                            <option value="">##ChoseOption## ...</option>
                            {for $num=1 to 9}
                                <option value="{$num}" {if $num eq $smarty.const.INSURANCE_NUM_MEMBER} selected="selected" {/if}>{$num} ##People##</option>
                            {/for}
                        </select>
                    </div>
                </div>
                <div class="count-passenger count-passengers-js ">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col nafarat-bime passenger-age-div-js p-1">
                        <div class="form-group">
                            <input type="text"
                                   readonly=""
                                   class="form-control passengers-age-js shamsiBirthdayCalendar"
                                   name="txt_birth_insurance1" autocomplete="off"
                                   id="txt_birth_insurance1"
                                   placeholder="تاريخ ميلاد الراكب ">
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1" >
                    <button type="button" onclick="searchInsurance()"
                            class="btn theme-btn seub-btn b-0"><span>بحث</span></button>
                </div>
            </form>
        </div>
    </div>
</div>