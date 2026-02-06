{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow, 'country' =>'','city' => null]}
{assign var='tour_special' value=$obj_main_page->getToursReservation($tour_params)}
{if $tour_special}
    {assign var='check_general' value=true}
{/if}
{assign var="min_" value=0}
{assign var="max_" value=4}

{if $check_general}
    <div class="i_modular_tours section_special_tour">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>تور های ویژه</h2>
                </div>
            </div>
            <div class="popular_places_area">
                <div class="">
                    <div class="__tour__special__ owl-carousel owl-theme owl-tour-arshida">

                        {foreach $tour_special as $item}
                            {if $min_ <= $max_}
                                <div class="__i_modular_nc_item_class_0 item">
                                    <div class="single_place">
                                        <div class="thumb">
                                            <img alt="{$item['tour_name']}" class="__image_class__"
                                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            <a class="prise" href="javascript:">
                                                <div class="package__details__inner">
                                                    <p>شروع قیمت از</p>
                                                    <p class="___price_class__ packg__prize">{$item['min_price']['discountedMinPriceR']|number_format}</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="place_info">
                                            <a href="javascript:">
                                                <h3 class="__title_class__">{$item['tour_name']}</h3>
                                            </a>
                                            <div class="rating_days flex-wrap d-flex justify-content-between">
<span class="w-100"><i class="fa fa-clock"></i>  مدت تور : <em class="__night_class__">{$item['night']}</em>
</span>
                                                <span class="w-100">
<i class="far fa-calendar-alt"></i> تاریخ حرکت :
                                                <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                </span>
</span>
                                            </div>
                                        </div>
                                        <div class="btn_theme">
                                            <a href="javascript:">
                                                <button class="btn theme-btn seub-btn b-0">
<span>
                                                    جزئیات تور
                                                </span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {$min_ = $min_ + 1}
                            {/if}
                        {/foreach}


                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}