
{load_presentation_object filename="country" assign="objCountry"}
{assign var='visa_countries' value=$objCountry->getCountriesWithVisa()}
{load_presentation_object filename="visaType" assign="objType"}
{assign var='visa_types' value=$objType->allVisaTypeList()}
{load_presentation_object filename="visa" assign="objVisa"}
{assign var='visa_list' value=$objVisa->visaListWithTypeWithCountry()}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
{assign var='currencies' value=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}


<section class="special-pages-div text-right">
    <div class="container">

{*        {if $smarty.const.GDS_SWITCH neq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}*}
{*            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/main.tpl" obj_main_page=$obj_main_page}*}
{*        {/if}*}


{*        <div class="head-special-pages mt-3">*}
{*            <span class='h3'>{$page.heading}</span>*}
{*        </div>*}




        {if $page.position === 'Visa'}
            <!-- Visa Page Styles -->
            <section class="visa-section-page text-right">
                <div class="container">
                    <!-- Header with Filters and Country Select -->
<!--                    <div class="visa-header-controls">
                        <div class="row align-items-center">
                            &lt;!&ndash; Right Side: Filter Buttons &ndash;&gt;
                            <div class="col-lg-8 col-md-7 col-sm-12">
                                <div class="visa-filter-buttons">
                                    <button class="visa-filter-btn active" data-visa-type="all">
                                        همه ویزاها
                                    </button>
                                    {if !empty($visa_types)}
                                        {foreach $visa_types as $visa_type}
                                            <button class="visa-filter-btn" data-visa-type="{$visa_type.id}">
                                                {$visa_type.title}
                                            </button>
                                        {/foreach}
                                    {/if}

                                    {*                                                      *}
                                    {*                                                        <button class="visa-filter-btn" data-visa-type="work">*}
                                    {*                                                            کاری*}
                                    {*                                                        </button>*}
                                    {*                                                        <button class="visa-filter-btn" data-visa-type="study">*}
                                    {*                                                            تحصیلی*}
                                    {*                                                        </button>*}
                                    {*                                                        <button class="visa-filter-btn" data-visa-type="medical">*}
                                    {*                                                            درمانی*}
                                    {*                                                        </button>*}
                                    {*                                                        <button class="visa-filter-btn" data-visa-type="transit">*}
                                    {*                                                            ترانزیت*}
                                    {*                                                        </button>*}
                                </div>
                            </div>

                            &lt;!&ndash; Left Side: Country Select &ndash;&gt;
                            <div class="col-lg-4 col-md-5 col-sm-12">
                                <div class="visa-country-select-wrapper">
                                    <select data-placeholder="انتخاب کشور"
                                            name="visa_destination" id="visaCountrySelect"
                                            class="select2 visa-country-select"
                                            tabindex="-1" aria-hidden="true">
                                        <option value="all" selected>همه کشورها</option>
                                        {if !empty($visa_countries) && $visa_countries}
                                            {foreach $visa_countries as $country}
                                                <option value="{$country.id}">{$country.name}</option>
                                            {/foreach}
                                        {/if}



                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    {*            <a  >*}
                    <!-- Visa Cards Display -->
                    <div class="visa-cards-container mt-4">
                        <div class="row" id="visaCardsRow">
                            {if isset($visa_list) && $visa_list}
                                {foreach $visa_list as $visa}
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 visa-card-item"
                                         data-visa-type="{$visa.visaTypeID}"
                                         data-country-id="{$visa.country_id}"  >
                                        <div class="visa-card" onclick="sendToVisaPassengers({$visa.id})">
                                            <form method="post" action="" name="visaForm" id="visaForm-{$visa.id}">
                                                {*                                        <input type="hidden" name="adultQty" id="adultQty" value="{$smarty.const.SEARCH_ADULT}" />*}
                                                {*                                        <input type="hidden" name="childQty" id="childQty" value="{$smarty.const.SEARCH_CHILD}" />*}
                                                {*                                        <input type="hidden" name="infantQty" id="infantQty" value="{$smarty.const.SEARCH_INFANT}" />*}
                                                <input type="hidden" name="visa_type" id="visa_type" value="{$visa.visaTypeID}" />
                                                <input type="hidden" name="distination_code" id="distination_code"
                                                       value="{$visa.countryCode}" />
                                                <input type="hidden" name="visaID" id="visaID" value="{$visa.id}" />
                                                <input type="hidden" name="CurrencyCode" class="CurrencyCode"
                                                       value='{$objSession->getCurrency()}' />
                                            </form>
                                            <div class="visa-card-image">
                                                <img src="/gds/pic/{$visa['cover_image']}"
                                                     alt="{$visa.title}">

                                            </div>
                                            <div class="visa-card-body">
                                                {*                                        <h5 class="visa-card-title">{$visa.country_name}</h5>*}
                                                <div class="visa-card-info">
                                                    <div>
                                                        <div class="visa-info-item">
                                                            <span>{$visa.title}</span>
                                                        </div>
                                                        <div class="">
                                                            <span class="visa-info-item-time">زمان اخذ ویزا: <span class="visa-info-item-deadline">{$visa.deadline}</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="visa-card-footer">
                                                    <div class="visa-info-item-price">
{*                                                        <span class="price-label">قیمت</span>*}
                                                        <div>
                                                <span class="price">{number_format($visa.mainCost)}
                                                </span>
                                                            <span class="price-format">
                                                    {foreach $currencies as $currency}
                                                        {if $currency.CurrencyCode == $visa.currencyType}
                                                            {$currency.CurrencyTitle}
                                                        {/if}
                                                    {/foreach}

                                                                {if $visa.currencyType == 0}
                                                                    ریال
                                                                {/if}
</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            {else}
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        در حال حاضر ویزایی برای نمایش وجود ندارد.
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </div>

                </div>
            </section>

            <script src="assets/js/customForVisa.js"></script>
        {/if}
        {if $page.content || ($page.page_type eq 'separate' && $page['files']['gallery_files'])}
            <div class="content-whatever-special-pages parent_box_right">
                <div class='d-block flex-wrap'>
                    {$page.content}
                </div>
                {if $page.page_type eq 'separate' && $page['files']['gallery_files']}
                    <div class="head-special-pages">
                        <span>گالری تصاویر</span>
                    </div>

                    <div class='d-flex flex-wrap '>
                        <div class="owl-carousel owl-theme owl-gallery-page">
                            {foreach $page.files.gallery_files as $file}

                                {if isset($page.files.main_file) && $file.src == $page.files.main_file.src}
                                    {continue}
                                {/if}

                                <div class="item">
                                    <a data-fancybox="gallery" href="{$file.src}" class="link-owl-gallery-mag">
                                        <img class="owl-gallery-img" src="{$file.src}" alt="{$file.alt}">
                                    </a>
                                </div>

                            {/foreach}
                        </div>
                    </div>
                {/if}
            </div>
        {/if}
    </div>
</section>
{if $page.page_type eq 'separate' && $page['files']['attach_files']}
    <section class="attachments-special-pages mb-4 text-right">
        <div class="container">
            <div class="head-special-pages">
                <span>پیوست ها</span>
            </div>
            <div class="parent-attachments-special-pages">
                <div class="row">

                    {foreach $page['files']['attach_files'] as $file}
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="card-attachments-special-pages">
                                <a href="{$file['src']}" target='_blank' class="card-img-attachments-special-pages">
                                    <svg class='w-25' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M364.2 83.8C339.8 59.39 300.2 59.39 275.8 83.8L91.8 267.8C49.71 309.9 49.71 378.1 91.8 420.2C133.9 462.3 202.1 462.3 244.2 420.2L396.2 268.2C407.1 257.3 424.9 257.3 435.8 268.2C446.7 279.1 446.7 296.9 435.8 307.8L283.8 459.8C219.8 523.8 116.2 523.8 52.2 459.8C-11.75 395.8-11.75 292.2 52.2 228.2L236.2 44.2C282.5-2.08 357.5-2.08 403.8 44.2C450.1 90.48 450.1 165.5 403.8 211.8L227.8 387.8C199.2 416.4 152.8 416.4 124.2 387.8C95.59 359.2 95.59 312.8 124.2 284.2L268.2 140.2C279.1 129.3 296.9 129.3 307.8 140.2C318.7 151.1 318.7 168.9 307.8 179.8L163.8 323.8C157.1 330.5 157.1 341.5 163.8 348.2C170.5 354.9 181.5 354.9 188.2 348.2L364.2 172.2C388.6 147.8 388.6 108.2 364.2 83.8V83.8z" />
                                    </svg>
                                </a>
                                <a href="{$file['src']}" target='_blank' class="card-link-attachments-special-pages text-break">
                                    {$file['name']}
                                </a>
                            </div>
                        </div>
                    {/foreach}


                </div>
            </div>
        </div>
    </section>
{/if}





