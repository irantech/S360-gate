{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=20}

{if $check_general}
    <div class="i_modular_tours tour-parent">
        <div class="container">
            <div class="col-xs-12 tour-parent-title">تورهای داخلی</div>
            <div class="col-xs-12">
                <div class="slider-lastnews-parent slider-lastnews-items slide-tab3">
                    <div class="__tour__internal__ owl-carousel owl-theme" id="owl-example2">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}
                                <div class="__i_modular_nc_item_class_0 slider-lastnews-item item tour-item">
                                    <img alt="{$item['tour_name']}" width="100%" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>

                                    <div class="hover_tour">
                                        <div>
                                            <div class="__title_class__ tour-name">{$item['tour_name']}</div>
                                            <span class="price_tour"> <span
                                                        class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> <em>تومان</em> </span>
                                        </div>
                                    </div>
                                    <div class="tour-titr-parent" href="javascript:">
                                        <div class="__title_class__ tour-name">{$item['tour_name']}</div>
                                        <div class="col-xs-12 tour-titr">
                                            <span> تور <span class="__night_class__">{$item['night']}</span> شب </span>
                                            <a class="reserve_btn"
                                               href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                                رزرو
                                                تور</a>
                                        </div>
                                    </div>
                                </div>
                                {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}

                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <a class="all-tours" href="{$smarty.const.ROOT_ADDRESS}/page/tour"> مشاهده تمام تورها</a>
            </div>
        </div>
    </div>
{/if}