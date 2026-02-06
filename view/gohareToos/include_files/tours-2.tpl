{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '4','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=4}

{assign var="tour_params_external" value=['type'=>'','limit'=> '4','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=4}
{if $check_tour}
    <section class="i_modular_tours tour-demo">
        <div class="container">
            <div class="title-demo">
                <div class="text-title-demo">
                    <h2>تورهای سفر یار گوهر توس</h2>
                    <p>

                        سفر به دنیا، تورهای داخلی و خارجی پرطرفدار برای لذت بردن از زیبایی‌های جهان

                    </p>
                </div>
                <a class="more-title-demo" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
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
                    <div aria-labelledby="tab-tour-dakheli" class="__tour__internal__ tab-pane fade show active" id="tour-dakheli" role="tabpanel">
                        <div class="tour-owl-parent">
                            <div class="owl-carousel owl-theme tour-owl">

                                {foreach $tour_internal as $item}
                                    {if $min_internal <= $max_internal}

                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a class="parent-link-tour" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                                <div class="parent-img-tour">
                                                    <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                                </div>
                                                <div class="parent-text-tour">
                                                    <span class="city-tour">ایران</span>
                                                    <h4 class="__title_class__">{$item['tour_name']}</h4>
                                                    <div class="night-tour">
                                                        <i class="fa-sharp fa-solid fa-clock"></i>
                                                        <span class="__day_class__">{$item['night'] + 1}</span> روز و <span class="__night_class__">{$item['night']}</span> شب

                                                    </div>
                                                    <div class="price-tour">
                                                        <div class="start-tour">
                                                            <i class="fa-solid fa-star"></i>
                                                            <span class="__degree_class__">{$item['StarCode']}</span>
                                                            <span class="reviews">320 آرا</span>
                                                        </div>
                                                        <div class="start-price">
                                                            <span>شروع قیمت</span>
                                                            <span class="number-price"><span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {if $item['type_vehicle_name'] eq 'اتبوس'}
                                                    {$type_vehicle_image = 'project_files/images/cric1.png'}
                                                {elseif $item['type_vehicle_name'] eq 'هواپیما'}
                                                    {$type_vehicle_image = 'project_files/images/cric3.png'}
                                                {elseif $item['type_vehicle_name'] eq 'قطار'}
                                                    {$type_vehicle_image = 'project_files/images/cric2.png'}
                                                {elseif $item['type_vehicle_name'] eq 'کشتی'}
                                                    {$type_vehicle_image = 'project_files/images/cric4.png'}
                                                {else}
                                                    {$type_vehicle_image = 'project_files/images/cric1.png'}
                                                {/if}
                                                <img alt="img-tour" class="circle-tour" src="{$type_vehicle_image}"/>
                                            </a>
                                        </div>

                                        {$min_internal = $min_internal + 1}
                                    {/if}
                                {/foreach}





                            </div>
                        </div>
                    </div>
                    <div aria-labelledby="tab-tour-khareji" class="__tour__external__ tab-pane fade" id="tour-khareji" role="tabpanel">
                        <div class="tour-owl-parent">
                            <div class="owl-carousel owl-theme tour-owl">

                                {foreach $tour_external as $item}
                                    {if $min_external <= $max_external}

                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a class="parent-link-tour" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                                <div class="parent-img-tour">
                                                    <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                                </div>
                                                <div class="parent-text-tour">
                                                    <span class="__city_class__ city-tour">{$item['destination_city_name']}</span>
                                                    <h4 class="__title_class__">{$item['tour_name']}</h4>
                                                    <div class="night-tour">
                                                        <i class="fa-sharp fa-solid fa-clock"></i>
                                                        <span class="__day_class__">{$item['night'] + 1}</span> روز و <span class="__night_class__">{$item['night']}</span> شب

                                                    </div>
                                                    <div class="price-tour">
                                                        <div class="start-tour">
                                                            <i class="fa-solid fa-star"></i>
                                                            <span class="__degree_class__">{$item['StarCode']}</span>
                                                            <span class="reviews">3210 آرا</span>
                                                        </div>
                                                        <div class="start-price">
                                                            <span>شروع قیمت</span>
                                                            <span class="number-price"><span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img alt="img-tour" class="circle-tour" src="project_files/images/cric1.png"/>
                                            </a>
                                        </div>

                                        {$min_external = $min_external + 1}
                                    {/if}
                                {/foreach}





                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}