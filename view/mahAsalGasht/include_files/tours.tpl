{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{*{$foreginTours|json_encode}*}
{*{$foreginTours|var_dump}*}
{if !empty($internalTours) || !empty($foreginTours)}
<section class="i_modular_tours tour-kanoun">
    <div class="container">
        <div class="title-kanoun">
            <p>تورهای محبوب </p>
            <h2>سفرهای ویژه با تجربیات بی‌نظیر در دنیای گردشگری</h2>
            <img src="images/img-title.png" alt="img-title">
        </div>
        <div >
            <div class="parent-ul-tour col-lg-12 col-md-12 col-12">
                <ul class="nav nav-pills d-flex align-items-center justify-content-center " id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <button class="nav-link active" id="tab-tour-dakheli" data-toggle="pill" data-target="#tour-dakheli"
                                type="button" role="tab" aria-controls="tour-dakheli" aria-selected="true"> داخلی
                        </button>
                    </li>
                    <li class="nav-item " role="presentation">
                        <button class="nav-link " id="tab-tour-khareji" data-toggle="pill" data-target="#tour-khareji"
                                type="button" role="tab" aria-controls="tour-khareji" aria-selected="false"> خارجی
                        </button>
                    </li>
                </ul>
            </div>
            <div class="parent-tab-tour">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active __tour__internal__" id="tour-dakheli" role="tabpanel" aria-labelledby="tab-tour-dakheli">
                        <div class="owl-carousel owl-theme tour-owl">

                            {foreach $internalTours as $item}
                            <div class="__i_modular_nc_item_class_0 item">
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="">
                                    <div class="parent-img-tour">
                                        <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                    </div>
                                    <div class="parent-text-tour">
                                        <div class="__city_class__ city-tour">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                            <span>{$item['destination_city_name']}</span>
                                        </div>
                                        <h2 class="__title_class__">
                                            {$item['tour_name']}
                                        </h2>
                                        <div class="parent-price-days">
                                            <div class="___price_class__  parent-price">
                                                <span>
                                                     <i class="fa-light fa-sack-dollar"></i>
                                                          قیمت:
                                                  </span>
                                                <span class="color-toman">
                                                {$item['min_price']['discountedMinPriceR']|number_format} ریال
                                                </span>
                                            </div>
                                            <div class="__night_class__ night">
                                                <i class="fa-light fa-clock"></i>
                                                <span>{$item['night']} شب </span>
                                            </div>
                                        </div>
                                        <div class="parent-star-more">
                                            <div class="rating-stars">
                                                {for $i = 0; $i < count($item['rate_average']); $i++}{for $i = 0; $i < count($item['rate_average']); $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}{/for}

                                            </div>
                                            <button class="__all_link_href__">
                                                <span>مشاهده بیشتر</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM271 135c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-87 87 87 87c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L167 273c-9.4-9.4-9.4-24.6 0-33.9L271 135z"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            {/foreach}
                        </div>
                        <div class="parent-tours">
                            {foreach $internalTours as $item}
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="__i_modular_nc_item_class_0">
                                <div class="parent-img-tour">
                                    <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                </div>
                                <div class="parent-text-tour">
                                    <div class="__city_class__ city-tour">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                        <span>{$item['destination_city_name']}</span>
                                    </div>
                                    <h2 class="__title_class__">
                                        {$item['tour_name']}
                                    </h2>
                                    <div class="parent-price-days">
                                        <div class="___price_class__  parent-price">
                                                <span>
                                                     <i class="fa-light fa-sack-dollar"></i>
                                                          قیمت:
                                                  </span>
                                            <span class="color-toman">
                                                {$item['min_price']['discountedMinPriceR']|number_format} ریال
                                            </span>
                                        </div>
                                        <div class="__night_class__ night">
                                            <i class="fa-light fa-clock"></i>
                                            <span>{$item['night']} شب </span>
                                        </div>
                                    </div>
                                    <div class="parent-star-more">
                                        <div class="rating-stars">
                                            {for $i = 0; $i < count($item['rate_average']); $i++}{for $i = 0; $i < count($item['rate_average']); $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}{/for}
                                        </div>
                                        <button class="__all_link_href__">
                                            <span>مشاهده بیشتر</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM271 135c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-87 87 87 87c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L167 273c-9.4-9.4-9.4-24.6 0-33.9L271 135z"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </a>
                            {/foreach}
                        </div>
                    </div>
                    <div class="tab-pane fade  __tour__external__" id="tour-khareji" role="tabpanel" aria-labelledby="tab-tour-khareji">
                        <div class="owl-carousel owl-theme tour-owl">
                            {foreach $foreginTours as $item}
                            <div class="__i_modular_nc_item_class_0 item">
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="__i_modular_nc_item_class_0">
                                    <div class="parent-img-tour">
                                        <img  class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                    </div>
                                    <div class="parent-text-tour">
                                        <div class="__city_class__ city-tour">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                            <span>{$item['destination_city_name']}</span>
                                        </div>
                                        <h2 class="__title_class__">
                                            {$item['tour_name']}
                                        </h2>
                                        <div class="parent-price-days">
                                            <div class="___price_class__  parent-price">
                                                <span>
                                                     <i class="fa-light fa-sack-dollar"></i>
                                                          قیمت:
                                                  </span>
                                                <span class="color-toman">
                                                    {$item['min_price']['discountedMinPriceR']|number_format}  ریال
                                                </span>
                                            </div>
                                            <div class="__night_class__ night">
                                                <i class="fa-light fa-clock"></i>
                                                <span>{$item['night']}   شب</span>
                                            </div>
                                        </div>
                                        <div class="parent-star-more">
                                            <div class="rating-stars">
                                                {for $i = 0; $i < count($item['rate_average']); $i++}{for $i = 0; $i < count($item['rate_average']); $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}{/for}

                                            </div>
                                            <button class="__all_link_href__">
                                                <span>مشاهده بیشتر</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM271 135c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-87 87 87 87c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L167 273c-9.4-9.4-9.4-24.6 0-33.9L271 135z"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            {/foreach}
                        </div>
                        <div class="parent-tours">
                            {foreach $foreginTours as $item}
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="__i_modular_nc_item_class_0">
                                <div class="parent-img-tour">
                                    <img  class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                </div>
                                <div class="parent-text-tour">
                                    <div class="__city_class__ city-tour">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                        <span>{$item['destination_city_name']}</span>
                                    </div>
                                    <h2 class="__title_class__">
                                        {$item['tour_name']}
                                    </h2>
                                    <div class="parent-price-days">
                                        <div class="___price_class__  parent-price">
                                                <span>
                                                     <i class="fa-light fa-sack-dollar"></i>
                                                          قیمت:
                                                  </span>
                                            <span class="color-toman">
                                                    {$item['min_price']['discountedMinPriceR']|number_format}  ریال
                                                </span>
                                        </div>
                                        <div class="__night_class__ night">
                                            <i class="fa-light fa-clock"></i>
                                            <span>{$item['night']}   شب</span>
                                        </div>
                                    </div>
                                    <div class="parent-star-more">
                                        <div class="rating-stars">
                                            {for $i = 0; $i < count($item['rate_average']); $i++}{for $i = 0; $i < count($item['rate_average']); $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}{/for}

                                        </div>
                                        <button class="__all_link_href__">
                                            <span>مشاهده بیشتر</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM271 135c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-87 87 87 87c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L167 273c-9.4-9.4-9.4-24.6 0-33.9L271 135z"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </a>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{/if}