{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{*{$foreginTours|json_encode}*}
{*{$foreginTours|var_dump}*}
{if !empty($foreginTours)}
    <section class="i_modular_tours tab-tour">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>کاروان‌ها</h2>
                </div>
            </div>
            <div class="__tour__external__ owl-carousel owl-theme owl-tab-tour">

                     {foreach $foreginTours as $item}
                        <div class="__i_modular_nc_item_class_0 item">
                            <a class="link-parent"
                               href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                <div class="parent-img-tour">
                                    <img  src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}" class="__image_class__"/>
                                </div>
                                <div class="parent-text-owl">
                                    <h2 class="__title_class__ titr-tour-tab">{$item['tour_name']}</h2>
                                    <div class="money-tour-tab">
                                        <span>
                                        <i class="fa-light fa-sack-dollar"></i>
                                                            قیمت:
                                                        </span>
                                        <span class="___price_class__ color-toman">
                                             {if $item['min_price_r'] != 0}
                                                 {$item['min_price_r']|number_format} ریال
                                             {/if}
                                            {if  $item['min_price_r'] != 0 &&  $item['min_price_a'] } + {/if}
                                            {if $item['min_price_a']}

                                                {$item['min_price_a']|number_format} {$item['currency_type']}
                                            {/if}
                                        </span>
                                    </div>
                                    <div class="money-calendar-tab">
                                        <span>
                                        <i class="fa-light fa-calendar-days"></i>
                                                            تاریخ حرکت:
                                                        </span>
                                        <span class="__date_class__">
                                            {assign var="year" value=substr($item['start_date'], 0, 4)}
                                            {assign var="month" value=substr($item['start_date'], 4, 2)}
                                            {assign var="day" value=substr($item['start_date'], 6)}
                                            {$year}-{$month}-{$day}
                                </span>
                                    </div>
                                    <div class="parent-btn-night">
                                        <div class="night">
                                            <i class="fa-light fa-clock"></i>
                                            <span>{$item['night']}   شب</span>
                                        </div>
                                        <button class="btn-tour-tab">
                                            مشاهده
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                {/foreach}


            </div>


            <div class="bg-btn-karvan mx-auto mt-4">
                <a class="btn-karvan" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                    <span>بیشتر</span>
                    <i class="fa-solid fa-arrow-left mr-3"></i>
                </a>
            </div>


        </div>

    </section>
{/if}