
{assign var="countries" value=$obj_main_page->getListCountriesAll()}
<div class="__box__ tab-pane {if $active} active {/if}" id="Visa">
    <div class="col-md-12 col-12">
        <div class="row">
            <form class="d_contents" data-aaction="://s360online.iran-tech.com/" id="gdsVisa" method="post" name="gdsVisa" target="_blank">
                <input type='hidden' value='True' id='visa_continent' name='visa_continent' class='continent-visa-js'>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                        </i>
                        <div class="caption-input-search-box">##EnterDestination##</div>
                        <select aria-hidden="true" class="select2_in select2-hidden-accessible country-visa-js" data-placeholder=" مقصد" id="country_id" name="country_id" onchange="getVisaTypeSpecialCountry(this)" tabindex="-1">
                            <option  value="">##ChoseOption##...</option>
                            {foreach $countries as $country}
                                <option value="{$country['countryCode']}">{$country['titleFa']}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <div class="parent-input-search-box">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 48c8.8 0 16 7.2 16 16V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H384zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64zM96 400c0 8.8 7.2 16 16 16H336c8.8 0 16-7.2 16-16s-7.2-16-16-16H112c-8.8 0-16 7.2-16 16zm33.3-176h39.1c1.6 30.4 7.7 53.8 14.6 70.8c-27.9-13.2-48.4-39.4-53.7-70.8zM224 304l-.3 0c-2.4-3.5-5.7-8.9-9.1-16.5c-6-13.6-12.4-34.3-14.2-63.5h47.1c-1.8 29.2-8.1 49.9-14.2 63.5c-3.4 7.6-6.7 13-9.1 16.5l-.3 0zm94.7-80c-5.3 31.4-25.8 57.6-53.7 70.8c6.8-17.1 12.9-40.4 14.6-70.8h39.1zm0-32H279.6c-1.6-30.4-7.7-53.8-14.6-70.8c27.9 13.2 48.4 39.4 53.7 70.8zM224 112l.3 0c2.4 3.5 5.7 8.9 9.1 16.5c6 13.6 12.4 34.3 14.2 63.5H200.5c1.8-29.2 8.1-49.9 14.2-63.5c3.4-7.6 6.7-13 9.1-16.5l.3 0zm-94.7 80c5.3-31.4 25.8-57.6 53.7-70.8c-6.8 17.1-12.9 40.4-14.6 70.8H129.3zM224 336a128 128 0 1 0 0-256 128 128 0 1 0 0 256z"></path></svg>
                            </i>
                            <div class="caption-input-search-box">نوع ویزا خود را انتخاب کنید</div>
                            <select aria-hidden="true" class="select2_in select2-hidden-accessible visa-type-js" data-placeholder=" نوع ویزا" id="visa_type" name="visa_type" tabindex="-1">
                                <option selected="selected" value="">نوع ویزا</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                        <div class="parent-input-search-box" style="border:none !important;background:none !important">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"></path></svg>                            </i>

                            <input class="adult-visa-js" id="count_adult_internal" name="count_adult_internal" type="hidden" value="1">

                            <div class="caption-input-search-box"> تعداد مسافران</div>


                            <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
 <span class="text-count-passenger text-count-passenger-js">
1 مسافر
 </span>
                                <span class="fas fa-caret-down down-count-passenger">
 </span>
                            </div>
                        </div>
                        <div class="cbox-count-passenger cbox-count-passenger-js">
                            <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-6">
                                        <div class="type-of-count-passenger">
                                            <h6>
                                                مسافر
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-6">
                                        <div class="num-of-count-passenger">
                                            <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-visa="yes">
                                            </i>
                                            <i class="number-count-js number-count counting-of-count-passenger" data-min="1" data-number="1" data-type="adult" data-value="internal-adult">
                                                1
                                            </i>
                                            <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-visa="yes">
                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="div_btn">
<span class="btn btn-close">
 تأیید
</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search margin-center p-1">
                    <button class="btn theme-btn seub-btn b-0" onclick="searchVisa()" type="button">
<span>
 جستجو
</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"></path></svg>


                    </button>
                </div>
            </form>
        </div>
    </div>
</div>