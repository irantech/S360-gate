{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{*{$foreginTours|json_encode}*}
{*{$foreginTours|var_dump}*}
{if !empty($internalTours) || !empty($foreginTours)}

<section class="i_modular_tours tab-tour">
    <div class="container">
        <h2 class="title mb-5">تور های گلگشت</h2>
        <ul class="nav nav-pills mb-4 d-flex align-items-center justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">تور داخلی</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">تور خارجی</button>
            </li>
        </ul>
        <div class="parent-tab-tour">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="__tour__internal__ owl-carousel owl-theme owl-tab-tour">
                        {foreach $internalTours as $item}
                        <div class="__i_modular_nc_item_class_0 item">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="link-parent">
                                <div class="parent-img-tour">
                                    <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                </div>
                                <div class="parent-text-owl">
                                    <h2 class="__title_class__ titr-tour-tab">
                                        {$item['tour_name']}
                                    </h2>
                                    <div class="money-calendar-tab">
                                        <div>
                                            <span class="__night_class__">
                                                {$item['night']}
                                            </span>
                                            شب
                                        </div>
                                        <span class="__date_class__">
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
                                            <span class="___price_class__">
                                            {$item['min_price']['discountedMinPriceR']|number_format}
                                            </span>
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
                        {/foreach}

                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="__tour__external__ owl-carousel owl-theme owl-tab-tour">
                        {foreach $foreginTours as $item}
                        <div class="__i_modular_nc_item_class_0 item">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="link-parent">
                                <div class="parent-img-tour">
                                    <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                </div>
                                <div class="parent-text-owl">
                                    <h2 class="__title_class__ titr-tour-tab">
                                        {$item['tour_name']}
                                    </h2>
                                    <div class="money-calendar-tab">
                                        <div>
                                            <span class="__night_class__">
                                                {$item['night']}
                                            </span>
                                            شب
                                        </div>
                                        <span class="__date_class__">
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
                                            <span class="___price_class__">
                                                {$item['min_price']['discountedMinPriceR']|number_format}
                                            </span>
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
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{/if}

