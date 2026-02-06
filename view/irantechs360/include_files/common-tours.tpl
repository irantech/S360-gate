{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}

{assign var="langVar" value=""}
{assign var="priceVar" value="_r"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="_en"}
    {assign var="priceVar" value="_a"}
{/if}
{if !empty($internalTours) || !empty($foreginTours)}
    <div class="section_tours">
        <div class="container">
            <div class="w-100">
                <ul class="nav nav-tabs" id="tabsTour" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show"
                           id="domestic_tour_tab"
                           data-toggle="tab"
                           href="#domestic_tour"
                           role="tab"
                           aria-controls="tourl"
                           aria-selected="true">
                            ##domesticTour##
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="foreign_tour_tab"
                           data-toggle="tab"
                           href="#foreign_tour"
                           role="tab"
                           aria-controls="tourf"
                           aria-selected="false">
                            ##foreigneTour##
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="tabsTourContent">
                    <div class="tab-pane fade show active"
                         id="domestic_tour"
                         role="tabpanel"
                         aria-labelledby="domestic_tour">
                        <div class="owl-carousel owl_4">
                            {foreach $internalTours as $item}
                                <div class="item">
                                    <div class="project">
                                        <div class="img">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}" class="img-fluid">
                                        </div>
                                        <div class="text">
                                            <h3>
                                                <a href="javascript:">{$item["tour_name$langVar"]}</a>
                                            </h3>
                                            <span
                                                    class="detail_tour">{$item['night']}
                                            ##Night##
                                            <em>
                                            {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}

                                            </em>
                                            </span>
                                            <div class="star d-flex clearfix more_tour"><h4 class="price">
                                                   {if $item["min_price$priceVar"]}
                                                       {$item["min_price$priceVar"]|number_format} <i>##Rial## </i>
                                                   {/if}
                                                </h4><a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"><span>##TourDetails##</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="foreign_tour"
                         role="tabpanel"
                         aria-labelledby="foreign_tour">
                        <div class="owl-carousel owl_4">
                            {foreach $foreginTours as $item}
                                <div class="item">
                                <div class="project">
                                    <div class="img">
                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}" class="img-fluid">
                                    </div>
                                    <div class="text">
                                        <h3>
                                            <a href="javascript:">{$item["tour_name$langVar"]}</a>
                                        </h3>
                                        <span
                                                class="detail_tour">{$item['night']}
                                            ##Night##
                                            <em>
                                            {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$day} /{$month}/{$year}

                                            </em></span>
                                        <div class="star d-flex clearfix more_tour"><h4 class="price">
                                                {if $item['min_price_r'] != 0}
                                                    {$item['min_price_r']|number_format} <i>##Rial## </i> <br>
                                                {/if}
                                                {if  $item['min_price_r'] != 0 &&  $item['min_price_a'] &&  $item['min_price_a'] != 0} + {/if}
                                                {if $item['min_price_a'] &&  $item['min_price_a'] != 0}

                                                    {$item['min_price_a']|number_format} <i>{$item['currency_type']} </i>
                                                {/if}

                                            </h4><a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"><span>##TourDetails##</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {/foreach}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
