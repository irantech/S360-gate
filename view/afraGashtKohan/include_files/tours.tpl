{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal_special' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal_special}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal_internal" value=0}
{assign var="max_internal_internal" value=4}

{assign var="tour_params_external" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external_special' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external_special}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external_external" value=0}
{assign var="max_external_external" value=4}

{if $check_general}
    <section class="i_modular_tours tours">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>تور های محبوب </h2>
                </div>
                <a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                    <span>بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
                </a>
            </div>
            <ul class="nav nav-pills mb-4" id="pills-tab-tour" role="tablist">
                <li class="nav-item" role="presentation">
                    <button aria-controls="pills-internal-tour" aria-selected="true" class="nav-link active" data-target="#pills-internal" data-toggle="pill" id="pills-internal-tour" role="tab" type="button">داخلی</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button aria-controls="pills-international-tour" aria-selected="false" class="nav-link" data-target="#pills-international" data-toggle="pill" id="pills-international-tour" role="tab" type="button">خارجی</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent-tour">
                <div aria-labelledby="pills-internal-tour" class="tab-pane fade show active" id="pills-internal" role="tabpanel">
                    <div class="__tour__internal__special__ owl-carousel owl-theme owl-tour-arshida">

                        {foreach $tour_internal_special as $item}
                            {if $min_internal_internal <= $max_internal_internal}

                                <a class="__i_modular_nc_item_class_0 tour-item" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="project">
                                        <div class="img">
                                            <img alt="{$item['tour_name']}" class="__image_class__ img-fluid" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <div class="text">
                                            <h3 class="__title_class__">{$item['tour_name']}</h3>
                                            <span class="detail_tour">
<span><span class="__night_class__">{$item['night']}</span> شب</span>
<span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
    {assign var="month" value=substr($item['start_date'], 4, 2)}
    {assign var="day" value=substr($item['start_date'], 6)}
    {$year}/{$month}/{$day}
                                </span>
</span>
                                            <div class="star d-flex clearfix more_tour">
                                                <h4 class="___price_class__ price">{$item['min_price']['discountedMinPriceR']|number_format}</h4>
                                                <span class="more_tour_btn">مشاهده جزئیات</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                {$min_internal_internal = $min_internal_internal + 1}
                            {/if}
                        {/foreach}




                    </div>
                </div>
                <div aria-labelledby="pills-international-tour" class="tab-pane fade" id="pills-international" role="tabpanel">
                    <div class="__tour__external__special__ owl-carousel owl-theme owl-tour-arshida">

                        {foreach $tour_external_special as $item}
                            {if $min_external_external <= $max_external_external}

                                <a class="__i_modular_nc_item_class_0 tour-item" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="project">
                                        <div class="img">
                                            <img alt="{$item['tour_name']}" class="__image_class__ img-fluid" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <div class="text">
                                            <h3 class="__title_class__">{$item['tour_name']}</h3>
                                            <span class="detail_tour">
<span><span class="__night_class__">{$item['night']}</span> شب</span>
<span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
    {assign var="month" value=substr($item['start_date'], 4, 2)}
    {assign var="day" value=substr($item['start_date'], 6)}
    {$year}/{$month}/{$day}
                                </span>
</span>
                                            <div class="star d-flex clearfix more_tour">
                                                <h4 class="___price_class__ price">{$item['min_price']['discountedMinPriceR']|number_format}</h4>
                                                <span class="more_tour_btn">مشاهده جزئیات</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                {$min_external_external = $min_external_external + 1}
                            {/if}
                        {/foreach}




                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}