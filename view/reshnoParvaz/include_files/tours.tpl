{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params" value=['type'=>'special','limit'=> '8','dateNow' => $dateNow, 'country' =>'','city' => null]}
{assign var='tour_special' value=$obj_main_page->getToursReservation($tour_params)}
{if $tour_special}
    {assign var='check_general' value=true}
{/if}
{assign var="min_" value=0}
{assign var="max_" value=7}
                    
{if $check_general}
    <section class="i_modular_tours tab-tour tours-section-special-p">
        <div class="container">
            <div class="title-site">
                <div>
                    <span></span>
                    <h2>پیشنهادات ویژه</h2>
                </div>
                <div class="line"></div>
                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">

                    بیشتر

                    <i class="fa-duotone fa-chevrons-left"></i>
                </a>
            </div>
            <div class="__tour__special__ parent-desc">

                {foreach $tour_special as $item}
                    {if $min_ <= $max_}
                        <div class="__i_modular_nc_item_class_0 items">
                            <a class="link-parent"
                               href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                <div class="parent-img-tour">
                                    <img alt="{$item['tour_name']}" class="__image_class__"
                                         src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                </div>
                                <div class="parent-text-owl">
                                    <h2 class="__title_class__ titr-tour-tab">{$item['tour_name']}</h2>
                                    <div class="money-tour-tab">
                                    <span>
                                    <i class="fa-light fa-sack-dollar"></i>

                                                            قیمت:

                                                        </span>
                                        <div class="color-toman">
                                            <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>

                                            تومان

                                        </div>
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
                                            {assign var="dayPre" value=substr($day ,0,1)}
                                            {assign var="dayafter" value=substr($day ,1,2)}
                                            {if $dayPre == 0}{$dayafter}{else}{$day}{/if} {$objDate->monthName($month)}


                                </span>
                                    </div>
                                    <div class="parent-btn-night">
                                        <div class="night">
                                            <i class="fa-light fa-clock"></i>
                                            <span class="__night_class__">{$item['night']}</span>

                                            شب

                                        </div>
                                        <button class="btn-tour-tab">

                                            مشاهده

                                            <i class="fa-solid fa-arrow-left"></i>
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {$min_ = $min_ + 1}
                    {/if}
                {/foreach}


            </div>


            <div class="special-tour owl-carousel owl-theme owl-tab-tour">
                {foreach $tour_special as $item}
                {if $min_ <= $max_}
                <div class="__i_modular_nc_item_class_0 items">
                    <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                        <div class="parent-img-tour">
                            <img alt="{$item['tour_name']}" class="__image_class__"
                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                        </div>
                        <div class="parent-text-owl">
                            <h2 class="__title_class__ titr-tour-tab">
                                {$item['tour_name']}
                            </h2>
                            <div class="money-tour-tab">
                            <span>
                            <i class="fa-light fa-sack-dollar"></i>

                                                            قیمت:

                                                        </span>
                                <div class="color-toman">
                                        <span class="___price_class__">
                                         {$item['min_price']['discountedMinPriceR']|number_format}
                                    </span>

                                    تومان

                                </div>
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
                                    {$year}/{$month}/{$day}

                                 </span>
                            </div>
                            <div class="parent-btn-night">
                                <div class="night">
                                    <i class="fa-light fa-clock"></i>
                                    <span class="__night_class__">{$item['night']}</span>
                                    شب
                                </div>
                                <button class="btn-tour-tab">

                                    مشاهده

                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
                    {$min_ = $min_ + 1}
                {/if}
                {/foreach}
            </div>
        </div>

    </section>
{/if}