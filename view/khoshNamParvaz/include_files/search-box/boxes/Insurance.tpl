
{assign var="countries" value=$obj_main_page->countryInsurance()}
{assign var="countries" value=$obj_main_page->countryInsuranceExternal()}
<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Insurance">
    <h4 class='title-searchBox-mobile'>جستجو برای بیمه مسافرتی</h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-Insurance_search">
            {*                        <label>نوع بیمه</label>*}
{*            <select class="form-control select2_in" id="insuranceType" name="insuranceType" onchange="toggleInsuranceType()">*}
{*                <option value="external">بیمه خارجی</option>*}
{*                <option value="internal">بیمه داخلی</option>*}
{*            </select>*}
        </div>
        <div class="d-flex flex-wrap w-100">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  name="gdsInsurance" id="gdsInsurance" class="d_contents">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1" id="internalSection"  style="display: none;">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                        </i>
                        <div class="caption-input-search-box">مبدأ خود را وارد کنید</div>
                        <select data-placeholder=" کشور مقصد"
                                name="insurance_destination_country_internal"
                                id="insurance_destination_country_internal"
                                class="select2_in  select2-hidden-accessible insurance-destination-country-internal-js"
                                tabindex="-1" aria-hidden="true">
                            {*            <option value="">##ChoseOption## ...</option>*}
                            <option value="IRN" selected>
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    ایران
                                {else}
                                    Iran
                                {/if}
                                (IRN)
                            </option>
                        </select>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1" id="externalSection">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                        </i>
                        <div class="caption-input-search-box">مبدأ خود را وارد کنید</div>
                        <select data-placeholder=" کشور مقصد"
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
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                        </i>
                        <div class="caption-input-search-box">انتخاب مدت سفر</div>
                        <select data-placeholder=" مدت سفر"
                                name="travel_time" id="travel_time"
                                class="select2_in travel-time-js select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            <option value="4"> 1 تا 4 روز</option>
                            <option value="8">5 تا 8 روز</option>
                            <option value="10">9 تا 10 روز</option>
                            <option value="15">11 تا 15 روز</option>
                            <option value="21">16 تا 21 روز</option>
                            <option value="23">22 تا 23 روز</option>
                            <option value="31">24 تا 31 روز</option>
                            <option value="45">32 تا 45 روز</option>
                            <option value="62">46 تا 62 روز</option>
                            <option value="92">3 ماه</option>
                            <option value="180">6 ماه</option>
                            <option value="365">1 سال</option>
                        </select></div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1">
                    <input type='hidden' name="passengers-count-js" class='passengers-count-js' id="passengers-count-js">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"></path></svg>
                        </i>
                        <div class="caption-input-search-box">انتخاب تعداد مسافران</div>
                        <div class="dropdown-insurance">
                            <div class="dropdown-toggle-insurance">تعداد مسافر</div>
                            <div class="dropdown-menu-insurance">
                                <div class='title-dropdown-item-insurance'>
                                    <span class='text-right'>بازه سنی</span>
                                    <span>تعداد نفرات</span>
                                </div>
                                <div class="dropdown-item-insurance">
                                    <span>۰ تا ۱۲ سال</span>
                                    <div class="counter-insurance">
                                        <button type='button' class="increase" data-age='0-12'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                                        </button>
                                        <span>0</span>
                                        <button type='button' class="decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown-item-insurance">
                                    <span>۱۳ تا ۶۴ سال</span>
                                    <div class="counter-insurance">
                                        <button type='button' class="increase" data-age='13-64'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                                        </button>
                                        <span>0</span>
                                        <button type='button' class="decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown-item-insurance">
                                    <span>۶۵ تا ۷۰ سال</span>
                                    <div class="counter-insurance">
                                        <button type='button' class="increase"  data-age='65-70'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                                        </button>
                                        <span>0</span>
                                        <button type='button' class="decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown-item-insurance">
                                    <span>۷۱ تا ۷۵ سال</span>
                                    <div class="counter-insurance">
                                        <button type='button' class="increase" data-age='71-75'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                                        </button>
                                        <span>0</span>
                                        <button type='button' class="decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown-item-insurance">
                                    <span>۷۶ تا 80 سال</span>
                                    <div class="counter-insurance">
                                        <button type='button' class="increase" data-age='76-80'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                                        </button>
                                        <span>0</span>
                                        <button type='button' class="decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown-item-insurance">
                                    <span>۸۱ سال به بالا</span>
                                    <div class="counter-insurance">
                                        <button type='button' class="increase" data-age='+81'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M232 72c0-13.3-10.7-24-24-24s-24 10.7-24 24V232H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H184V440c0 13.3 10.7 24 24 24s24-10.7 24-24V280H392c13.3 0 24-10.7 24-24s-10.7-24-24-24H232V72z"/></svg>
                                        </button>
                                        <span>0</span>
                                        <button type='button' class="decrease">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 256c0 13.3-10.7 24-24 24L24 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l368 0c13.3 0 24 10.7 24 24z"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_btn_insuranc p-1">
                    <button type="button" onclick="searchInsuranceWithType()"
                            class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



