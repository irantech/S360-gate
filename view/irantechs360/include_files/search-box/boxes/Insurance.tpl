
{assign var="countries" value=$obj_main_page->countryInsurance()}

<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Insurance">
    <div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  name="gdsInsurance" id="gdsInsurance" class="d_contents">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
                    <div class="form-group">
                            <select data-placeholder="##CountryName## ##Destination##"
                                    name="insurance_destination_country"
                                    id="insurance_destination_country"
                                    class="select2_in  select2-hidden-accessible insurance-destination-country-js"
                                    tabindex="-1" aria-hidden="true">
                            <option value="">##ChoseOption## ...</option>
                                {foreach $countries as $country}
                                <option value="{$country['abbr']}">
                                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                            {$country['persian_name']}
                                        {else}
                                            {$country['english_name']}
                                        {/if}
                                    ({$country['abbr']})</option>
                                    {/foreach}
                            </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
                    <div class="form-group">
                        <select data-placeholder="##travelDurationChoose##"
                                name="travel_time" id="travel_time"
                                class="select2_in travel-time-js select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">##ChoseOption## ...</option>
                            <option selected="" default="" disabled> ##Durationtrip##</option>
                            <option value="5" {if $smarty.const.INSURANCE_NUM_DAY eq 5} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'5'],"TOXDay")}</option>
                            <option value="7" {if $smarty.const.INSURANCE_NUM_DAY eq 7} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'7'],"TOXDay")}</option>
                            <option value="8" {if $smarty.const.INSURANCE_NUM_DAY eq 8} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'8'],"TOXDay")}</option>
                            <option value="15" {if $smarty.const.INSURANCE_NUM_DAY eq 15} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'15'],"TOXDay")}</option>
                            <option value="23" {if $smarty.const.INSURANCE_NUM_DAY eq 23} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'23'],"TOXDay")}</option>
                            <option value="31" {if $smarty.const.INSURANCE_NUM_DAY eq 31} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'31'],"TOXDay")}</option>
                            <option value="45" {if $smarty.const.INSURANCE_NUM_DAY eq 45} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'45'],"TOXDay")}</option>
                            <option value="62" {if $smarty.const.INSURANCE_NUM_DAY eq 62} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'62'],"TOXDay")}</option>
                            <option value="92" {if $smarty.const.INSURANCE_NUM_DAY eq 92} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'92'],"TOXDay")}</option>
                            <option value="182" {if $smarty.const.INSURANCE_NUM_DAY eq 182} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'182'],"TOXDay")}</option>
                            <option value="186" {if $smarty.const.INSURANCE_NUM_DAY eq 186} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'186'],"TOXDay")}</option>
                            <option value="365" {if $smarty.const.INSURANCE_NUM_DAY eq 365} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'365'],"TOXDay")}</option>
                        </select></div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
                    <div class="form-group">
                        <select name="number_of_passengers"
                                id="number_of_passengers"
                                data-placeholder="##ChoosePassangersNumber##"
                                class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js"
                                tabindex="-1" aria-hidden="true">
                            <option value="">##ChoseOption## ...</option>
                            {for $num=1 to 9}
                                <option value="{$num}" {if $num eq $smarty.const.INSURANCE_NUM_MEMBER} selected="selected" {/if}>{$num} ##People##</option>
                            {/for}
                        </select>
                    </div>
                </div>
                <div class="count-passenger count-passengers-js">
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_col nafarat-bime passenger-age-div-js">
                        <div class="form-group">
                            <input type="text"
			    readonly=""
                                   class="form-control passengers-age-js shamsiBirthdayCalendar"
                                   name="txt_birth_insurance1" autocomplete="off"
                                   id="txt_birth_insurance1"
                                   placeholder="##BirthDayNumberOfPeople## 1">
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 col_search search_btn_insuranc">
                    <button type="button" onclick="searchInsurance()"
                            class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
                </div>
            </form>
        </div>
    </div>
</div>