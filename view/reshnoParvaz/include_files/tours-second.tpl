{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '5','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=4}

{assign var="tour_params_external" value=['type'=>'','limit'=> '5','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=4}

{if $check_general}
    <section class="i_modular_tours tab-tour tours-section-p">
        <div class="container">
            <div class="title-site">
                <div>
                    <span></span>
                    <h2>تور های رشنو پرواز</h2>
                </div>
                <div class="line"></div>
                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">

                    بیشتر

                    <i class="fa-duotone fa-chevrons-left"></i>
                </a>
            </div>
            <ul class="nav nav-pills mb-4 d-flex align-items-center justify-content-center" id="pills-tab"
                role="tablist">
                <li class="nav-item" role="presentation">
                    <button aria-controls="pills-home" aria-selected="true" class="nav-link active"
                            data-target="#pills-home" data-toggle="pill" id="pills-home-tab" role="tab" type="button">
                        تور داخلی
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button aria-controls="pills-profile" aria-selected="false" class="nav-link"
                            data-target="#pills-profile" data-toggle="pill" id="pills-profile-tab" role="tab"
                            type="button">تور خارجی
                    </button>
                </li>
            </ul>
            <div class="parent-tab-tour">
                <div class="tab-content" id="pills-tabContent">
                    <div aria-labelledby="pills-home-tab" class="tab-pane fade show active" id="pills-home"
                         role="tabpanel">
                        <div class="__tour__internal__ owl-carousel owl-theme owl-tab-tour">

                            {foreach $tour_internal as $item}
                                {if $min_internal <= $max_internal}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a class="link-parent"
                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                            <div class="parent-img-tour">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <div class="parent-text-owl">
                                                <h2 class="__title_class__ titr-tour-tab">{$item['tour_name']}</h2>
                                                <div class="money-calendar-tab">
                                                    <div>
                                                        <span class="__night_class__">{$item['night']}</span>

                                                        شب

                                                    </div>
                                                    <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {assign var="dayPre" value=substr($day ,0,1)}
                                                        {assign var="dayafter" value=substr($day ,1,2)}
                                                        {if $dayPre == 0}{$dayafter}{else}{$day}{/if} {$objDate->monthName($month)}

                                </span>
                                                </div>
                                                <div class="parent-btn-night">
                                                    <div class="color-toman">
                                                        <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>

                                                        تومان

                                                    </div>
                                                    <button class="btn-tour-tab">

                                                        مشاهده

                                                        <i class="fa-solid fa-arrow-left"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    {$min_internal = $min_internal + 1}
                                {/if}
                            {/foreach}


                        </div>
                    </div>
                    <div aria-labelledby="pills-profile-tab" class="tab-pane fade" id="pills-profile" role="tabpanel">
                        <div class="__tour__external__ owl-carousel owl-theme owl-tab-tour">

                            {foreach $tour_external as $item}
                                {if $min_external <= $max_external}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a class="link-parent"
                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                            <div class="parent-img-tour">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <div class="parent-text-owl">
                                                <h2 class="__title_class__ titr-tour-tab">{$item['tour_name']}</h2>
                                                <div class="money-calendar-tab">
                                                    <div>
                                                        <span class="__night_class__">{$item['night']}</span>

                                                        شب

                                                    </div>
                                                    <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                </span>
                                                </div>
                                                <div class="parent-btn-night">
                                                    <div class="color-toman">
                                                        <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>

                                                        تومان

                                                    </div>
                                                    <button class="btn-tour-tab">

                                                        مشاهده

                                                        <i class="fa-solid fa-arrow-left"></i>
                                                    </button>
                                                </div>
                                            </div>
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
    </section>
{/if}