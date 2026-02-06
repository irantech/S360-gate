{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var='check_tour' value=false}

{assign var="special_internal_tour_params" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal']}
{assign var='internal_tours' value=$obj_main_page->getToursReservation($special_internal_tour_params)}
{if $internal_tours}
    {assign var='check_tour' value=true}
{/if}
{assign var="local_min" value=0}
{assign var="local_max" value=10}


{assign var="foreging_external_tour_params" value=['type'=>'','limit'=> '10','dateNow' => $dateNow, 'country' =>'external']}
{assign var='external_tours' value=$obj_main_page->getToursReservation($foreging_external_tour_params)}
{if $external_tours}
    {assign var='check_tour' value=true}
{/if}
{assign var="portal_min" value=0}
{assign var="portal_max" value=10}

{if $check_tour}
    <section class="section_tours">
        <div class="container">
            <div class="w-100">
                <ul class="nav nav-tabs" id="tabsTour" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="tourl-tab" data-toggle="tab" href="#tourl" role="tab" aria-controls="tourl" aria-selected="true">تور داخلی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tourf-tab" data-toggle="tab" href="#tourf" role="tab" aria-controls="tourf" aria-selected="false">تور خارجی</a>
                    </li>
                </ul>
                <div class="tab-content" id="tabsTourContent">
                    <div class="tab-pane fade show active" id="tourl" role="tabpanel" aria-labelledby="tourl-tab">
                        <div class="owl-carousel owl_tour_local">
                            {foreach $internal_tours as $item}
                                {if $local_min <= $local_max}
                                <div class="item">
                                    <div class="project">
                                        <div class="img">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                        </div>
                                        <div class="text">
                                            <h3>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"> {$item['tour_name']}</a>
                                            </h3>
                                            <span class="detail_tour">
                                                    {$item['night']} شب


                                                <em>
                                            {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                                </em>
                                            </span>
                                            <div class="star d-flex clearfix more_tour">
                                                <h4 class="price">
                                                    {$item['min_price']['discountedMinPriceR']|number_format}
                                                    <i>ریال </i>
                                                </h4>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"><span>مشاهده جزئیات</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {$local_min = $local_min + 1}
                                {/if}
                            {/foreach}
                        </div>
                        <div class="d-flex justify-content-center mt-3"><a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/{$objDate->jtoday()}/all" class="button">نمایش همه تورها</a></div>
                    </div>
                    <div class="tab-pane fade" id="tourf" role="tabpanel" aria-labelledby="tourf-tab">
                        <div class="owl-carousel owl_tour_local">
                            {foreach $external_tours as $item}
                            {if $local_min <= $local_max}
                                <div class="item">
                                    <div class="project">
                                        <div class="img">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}" >
                                        </div>
                                        <div class="text">
                                            <h3>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tour['tour_slug']}"> {$item['tour_name']}</a>
                                            </h3>
                                            <span class="detail_tour">
                                                    {$item['night']} شب
                                            {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                <em>{$year}/{$month}/{$day}</em>
                                            </span>
                                            <div class="star d-flex clearfix more_tour">
                                                <h4 class="price">
                                                    {$item['min_price']['discountedMinPriceR']|number_format}
                                                    <i>ریال </i>
                                                </h4>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}"><span>مشاهده جزئیات</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                          {$local_min = $local_min + 1}
                                {/if}
                            {/foreach}
                        </div>
                        <div class="d-flex justify-content-center mt-3"><a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/{$objDate->jtoday()}/all" class="button">نمایش همه تورها</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
