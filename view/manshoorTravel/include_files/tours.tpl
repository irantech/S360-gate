{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=8}

{assign var="tour_params_external" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=8}

{assign var="tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'','city' => null]}
{assign var='tour_special' value=$obj_main_page->getToursReservation($tour_params)}
{if $tour_special}
    {assign var='check_general' value=true}
{/if}
{assign var="min_" value=0}
{assign var="max_" value=1}

{if $check_general}
    <section class="i_modular_tours background tours">
        <div class="container d-flex flex-wrap">
            <h3 class="w-100 title mt-5">تور های منشور صلح پارسیان</h3>
            <div class="my-5 tours_1 col-12 col-xl-6 pr-lg-0 pl-lg-2">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a aria-controls="nav-home" aria-selected="true" class="tab-ul-tour nav-link active mask mask-hexagon"
                           data-toggle="tab" href="#nav-home" id="nav-home-tab" role="tab">داخلی</a>
                        <a aria-controls="nav-profile" aria-selected="false" class="tab-ul-tour nav-link mask mask-hexagon"
                           data-toggle="tab" href="#nav-profile" id="nav-profile-tab" role="tab">خارجی</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div aria-labelledby="nav-home-tab" class="__tour__internal__ tab-pane fade show active"
                         id="nav-home" role="tabpanel">
                        <div class="owl-tour owl-carousel owl-theme">

                            {foreach $tour_internal as $item}
                                {if $min_internal <= $max_internal}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                            <div class="mask mask-hexagon2 parent-img-tour1">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <article class="parent-text-tour-right">
                                                <span class="coin_money">
                                                <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال
                                                </span>
                                                <span class="calendar2">
                                                      اعتبار تور
                                                      <span class="__date_class__">
                                                        {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                                      </span>
                                                </span>
                                                <h5 class="__title_class__">{$item['tour_name']}</h5>
                                                <button class="btn-more">جزئیات</button>
                                            </article>
                                        </a>
                                    </div>
                                    {$min_internal = $min_internal + 1}
                                {/if}
                            {/foreach}


                        </div>
                    </div>
                    <div aria-labelledby="nav-profile-tab" class="__tour__external__ tab-pane fade" id="nav-profile"
                         role="tabpanel">
                        <div class="owl-tour owl-carousel owl-theme">

                            {foreach $tour_external as $item}
                                {if $min_external <= $max_external}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                            <div class="mask mask-hexagon2">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <article class="parent-text-tour-right">
                                            <span class="coin_money">

                                            قیمت  <span
            class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال

                                             </span>
                                                <span class="calendar2"> اعتبار تور <span
                                                            class="__date_class__">w</span></span>
                                                <h5 class="__title_class__">{$item['tour_name']}</h5>
                                                <button class="btn-more">جزئیات</button>
                                            </article>
                                        </a>
                                    </div>
                                    {$min_external = $min_external + 1}
                                {/if}
                            {/foreach}


                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5 tours_2 col-12 col-xl-6 pl-lg-0 pr-lg-2">
                <!--                <div>-->
                <!--                    <h3>تور های ویژه</h3>-->
                <!--                </div>-->
                <div class="__tour__special__ owl-carousel owl-theme" id="owl-tourS">

                    {foreach $tour_special as $item}
                        {if $min_ <= $max_}
                            <div class="__i_modular_nc_item_class_0 item">
                                <a class=""
                                   href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                    <div class="parent-img-bg">
                                        <img alt="{$item['tour_name']}" class="__image_class__"
                                             src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                    </div>
                                    <div class="parent-text-tours">
                                        <h5 class="__title_class__">{$item['tour_name']}</h5>
                                        <div class="calendar">
<span class="text-calendar">

                                        اعتبار تور

                                    </span>
                                            <span class="__date_class__ data-calendar">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                </span>
                                        </div>
                                        <p class="__description_class__ description">{$item['description']}</p>
                                        <div class="money-new-tours">
                                            <span class="text-money-new-tours">قیمت:</span>
                                            <span class="___price_class__ number-money-new-tours">{$item['min_price']['discountedMinPriceR']|number_format}</span>
                                        </div>
                                        <button class="btn-more">جزئیات</button>
                                    </div>
                                </a>
                            </div>
                            {$min_ = $min_ + 1}
                        {/if}
                    {/foreach}


                </div>
            </div>
        </div>
    </section>
{/if}