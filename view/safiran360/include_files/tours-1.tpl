{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'special','limit'=> '4','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal_special' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal_special}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_internal_internal" value=0}
{assign var="max_internal_internal" value=4}

{assign var="tour_params_external" value=['type'=>'special','limit'=> '4','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external_special' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external_special}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_external_external" value=0}
{assign var="max_external_external" value=4}

{if $check_tour}
    <section class="i_modular_tours tour-safiran">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>تورهای محبوب </h2>
                    <p>سفر به دنیا، تورهای داخلی و خارجی پرطرفدار برای لذت بردن از زیبایی‌های جهان</p>
                </div>
                <a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all">
                    <span>تورهای بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
                </a>
            </div>
            <div class="parent-ul-tour col-lg-12 col-md-12 col-12">
                <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button aria-controls="tour-dakheli" aria-selected="true" class="nav-link active" data-target="#tour-dakheli" data-toggle="pill" id="tab-tour-dakheli" role="tab" type="button"> داخلی
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button aria-controls="tour-khareji" aria-selected="false" class="nav-link" data-target="#tour-khareji" data-toggle="pill" id="tab-tour-khareji" role="tab" type="button"> خارجی
                        </button>
                    </li>
                </ul>
            </div>
            <div class="parent-tab-tour">
                <div class="tab-content" id="pills-tabContent">
                    <div aria-labelledby="tab-tour-dakheli" class="__tour__internal__special__ tab-pane fade show active" id="tour-dakheli" role="tabpanel">
                        <div class="owl-carousel owl-theme owl-tour-safiran">

                            {foreach $tour_internal_special as $item}

                                {if $min_internal_internal <= $max_internal_internal}

                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a class="items-tour" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                            <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                            <div class="text-top-tour">
                                                <h6 class="__city_class__">{$item['destination_city_name']}</h6>
                                            </div>
                                            <div class="text-bottom-tour">
                                                <h2 class="__title_class__">{$item['tour_name']}</h2>
                                                <div class="parent-info-tour-avan">
                                                    <div class="info-right">
                                                        <pre class="days"><span class="__day_class__">{$item['night'] + 1}</span> روز     |</pre>
                                                        <div class="cost">از <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span></div>
                                                    </div>
                                                    <div class="info-left">
                                                        <div class="rating-stars">
                                                            {if $item['rate_average']}
                                                            {for $i = 0; $i < $item['rate_average']; $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}
                                                            {/if}


                                                        </div>
{*                                                        <p class="rating-text">آرا 5</p>*}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    {$min_internal_internal = $min_internal_internal + 1}
                                {/if}
                            {/foreach}





                        </div>
                    </div>
                    <div aria-labelledby="tab-tour-khareji" class="__tour__external__special__ tab-pane fade" id="tour-khareji" role="tabpanel">
                        <div class="owl-carousel owl-theme owl-tour-safiran">

                            {foreach $tour_external_special as $item}
                                {if $min_external_external <= $max_external_external}

                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a class="items-tour" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                            <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                            <div class="text-top-tour">
                                                <h6 class="__city_class__">{$item['destination_city_name']}</h6>
                                            </div>
                                            <div class="text-bottom-tour">
                                                <h2 class="__title_class__">{$item['tour_name']}</h2>
                                                <div class="parent-info-tour-avan">
                                                    <div class="info-right">
                                                        <pre class="days"><span class="__day_class__">{$item['night'] + 1}</span> روز     |</pre>
                                                        <div class="cost">از <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span></div>
                                                    </div>
                                                    <div class="info-left">
                                                        <div class="rating-stars">
                                                            {if $item['rate_average']}
                                                                {for $i = 0; $i < $item['rate_average']; $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}
                                                            {/if}
                                                        </div>
{*                                                        <p class="rating-text">آرا 11</p>*}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    {$min_external_external = $min_external_external + 1}
                                {/if}
                            {/foreach}





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}