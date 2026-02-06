{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=5}

{assign var="tour_params_external" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=5}

{if $check_general}
    <div class="i_modular_tours section_tours">
        <div class="container">
            <div class="w-100">
                <ul class="nav nav-tabs" id="tabsTour" role="tablist">
                    <li class="nav-item">
                        <a aria-controls="tourl" aria-selected="true" class="nav-link active show" data-toggle="tab"
                           href="#tourl" id="tourl-tab" role="tab">تور داخلی</a>
                    </li>
                    <li class="nav-item">
                        <a aria-controls="tourf" aria-selected="false" class="nav-link" data-toggle="tab" href="#tourf"
                           id="tourf-tab" role="tab">تور خارجی</a>
                    </li>
                </ul>
                <div class="tab-content" id="tabsTourContent">
                    <div aria-labelledby="tourl-tab" class="tab-pane fade show active" id="tourl" role="tabpanel">
                        <div class="row">
                            <div class="__tour__internal__ owl-carousel owl_tour_local1">

                                {foreach $tour_internal as $item}
                                    {if $min_internal <= $max_internal}
                                        <div class="__i_modular_nc_item_class_0 item">
                                            <div class="project">
                                                <div class="img">
                                                    <img alt="{$item['tour_name']}" class="__image_class__ img-fluid"
                                                         src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                                </div>
                                                <div class="text">
                                                    <h3>
                                                        <a class="__title_class__"
                                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">{$item['tour_name']}</a>
                                                    </h3>
                                                    <span class="detail_tour">
                                                    <span>
                                                    <em class="__night_class__">{$item['night']}</em>
                                                         شب

                                                    </span>
                                                    <em class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                                     </em>
                                                    </span>
                                                    <div class="star d-flex clearfix more_tour">
                                                        <h4 class="price">
                                                            تومان
                                                            <i class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</i>
                                                        </h4>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"><span>مشاهده جزئیات</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {$min_internal = $min_internal + 1}
                                    {/if}
                                {/foreach}


                            </div>
                        </div>
                    </div>
                    <div aria-labelledby="tourf-tab" class="tab-pane fade" id="tourf" role="tabpanel">
                        <div class="__tour__external__ owl-carousel owl_tour_local1">

                            {foreach $tour_external as $item}
                                {if $min_external <= $max_external}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <div class="project">
                                            <div class="img">
                                                <img alt="{$item['tour_name']}" class="__image_class__ img-fluid"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <div class="text">
                                                <h3>
                                                    <a class="__title_class__"
                                                       href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">{$item['tour_name']}</a>
                                                </h3>
                                                <span class="detail_tour">
                                                <span>
                                                <em class="__night_class__">{$item['night']}</em>
                                                         شب

                                                    </span>
                                                    <em class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                                       </em>
                                                    </span>
                                                <div class="star d-flex clearfix more_tour">
                                                    <h4 class="price">
                                                        تومان
                                                        <i class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</i>
                                                    </h4>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"><span>مشاهده جزئیات</span></a>
                                                </div>
                                            </div>
                                        </div>
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
{/if}