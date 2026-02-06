{assign var="countries" value=$obj_main_page->countryInsurance()}

<div class="__box__ tab-pane shadow-box {if $active} active {/if}" id="Insurance" style="padding:0.5px !important">
    <div class="col-md-12 col-12">
        <div class="row align-items-center">
            <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsInsurance" method="post" name="gdsInsurance" target="_blank">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1 mt-2 mt-lg-0">
                    <div class="form-group d-flex align-items-center form-insurance">
                        <i class="fas fa-map-marker-alt fa-lg mx-2"></i>

                        <select aria-hidden="true" class="select2_in select2-hidden-accessible insurance-destination-country-js" data-placeholder="نام کشور مقصد" id="insurance_destination_country" name="insurance_destination_country" tabindex="-1">
                            <option value="">##ChoseOption##...</option>
                            {foreach $countries as $country}
                                <option value="{$country['abbr']}">{$country['persian_name']}({$country['abbr']})</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group d-flex align-items-center form-insurance">
                        <i class="fas fa-calendar fa-lg mx-2"></i>

                        <select aria-hidden="true" class="select2_in travel-time-js select2-hidden-accessible" data-placeholder="انتخاب مدت سفر" id="travel_time" name="travel_time" tabindex="-1">
                            <option value="">##ChoseOption##...</option>
                            {assign var="durations" value=['5','7','8','15','23','31','45','62','92','182','186','365']}
                            {foreach $durations as $days}
                                <option value="{$days}">##untill## {$days} ##Day##</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1 mr-0">
                    <input type='hidden' name="passengers-count-js" class='passengers-count-js' id="passengers-count-js">
                    <div class="parent-input-search-box form-insurance" style="border-left:0 !important">
                        <i class="fas fa-user fa-lg mr-2"></i>

                        <div class="dropdown-insurance">
                            <div class="dropdown-toggle-insurance mr-2">تعداد مسافر</div>
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

                <div class="col-xl-1 col-lg-3 col-md-6 col-sm-6 col-12 col_search search_btn_insuranc mr-auto mt-1 mb-md-2 mb-lg-0">
                    <button class="btn theme-btn seub-btn b-0"  style="left:9.5px;" onclick="searchInsurance()" type="button">
<span>
 جستجو
</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>