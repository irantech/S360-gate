{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow, 'country' =>'','city' => null]}
{assign var='tour_special' value=$obj_main_page->getToursReservation($tour_params)}
{if $tour_special}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_" value=0}
{assign var="max_" value=5}

{if $check_tour}
    <div class="i_modular_tours section_special_tour">
        <div class="__tour__special__ container">
            <div class="titr">

                تور های برگزیده

            </div>
            <div class="popular_places_area">
                <div class="row">
                    <div class="owl-carousel owl_tour_local">

                        {foreach $tour_special as $item}
                            {if $min_ <= $max_}

                                <div class="__i_modular_nc_item_class_0 item">
                                    <div class="single_place">
                                        <div class="thumb">
                                            <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                            <a class="prise" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                                <div class="package__details__inner">
                                                    <p>شروع قیمت از</p>
                                                    <p class="packg__prize"><span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>

                                                        ریال<span></span>
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="place_info">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                                <h3>{$item['tour_name']}</h3></a>
                                            <div class="rating_days flex-wrap d-flex justify-content-between">
<span><i class="fal fa-clock"></i> مدت تور : <em> <span class="__night_class__">{$item['night']}</span>

                                            شب </em>
</span>
                                                <span>
<i class="fal fa-calendar-alt"></i> تاریخ حرکت :

                                        <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                            {assign var="month" value=substr($item['start_date'], 4, 2)}
                                            {assign var="day" value=substr($item['start_date'], 6)}
                                            {$year}/{$month}/{$day}
                                                </span>
</span>
                                            </div>
                                        </div>
                                        <div class="btn_theme">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
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