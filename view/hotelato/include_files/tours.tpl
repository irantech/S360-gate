{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '5','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=5}

{assign var="tour_params_external" value=['type'=>'','limit'=> '5','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=5}

{if $check_tour}
    <section class="i_modular_tours tour_internal d-flex">
        <div class="container">
{*            <div class="parent-ul-hotel col-lg-12 col-md-12 col-12">*}
{*                <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab-hotel1" role="tablist">*}
{*                    <li class="nav-item" role="presentation">*}
{*                        <button aria-controls="tour-dakheli1" aria-selected="true" class="nav-link active" data-target="#hotel-dakheli1" data-toggle="pill" id="tab-hotel-dakheli1" role="tab" type="button">*}

{*                            داخلی*}

{*                        </button>*}
{*                    </li>*}
{*                    <li class="nav-item" role="presentation">*}
{*                        <button aria-controls="tour-khareji1" aria-selected="false" class="nav-link" data-target="#hotel-khareji1" data-toggle="pill" id="tab-hotel-khareji1" role="tab" type="button">*}

{*                            خارجی*}

{*                        </button>*}
{*                    </li>*}
{*                </ul>*}
{*            </div>*}
{*            <div class="tab-content" id="pills-tabContent-hotel1">*}
{*                <div aria-labelledby="tab-hotel-dakheli" class="tab-pane fade show active" id="hotel-dakheli1" role="tabpanel">*}
{*                    *}
{*                </div>*}
{*                <div aria-labelledby="tab-hotel-khareji" class="tab-pane fade" id="hotel-khareji1" role="tabpanel">*}
{*                    *}
{*                </div>*}
{*            </div>*}

            <div class='parent-tours'>
                <div class='tour-dakheli'>
                    <h3 class="title">تور داخلی</h3>
                    <div class="owl-carousel owl-theme __tour__internal__ owl-hotel-tour tour_grid">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}

                                <div class="__i_modular_nc_item_class_0 item">
                                    <a class="" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                        <div class="imgBox">
                                            <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <div class="tour_txt">
                                            <div class="tour_txt_header">
                                                <h2 class="__title_class__">{$item['tour_name']}</h2>
                                            </div>
                                            <div class="tour_txt_footer">
                                                <h5>تاریخ حرکت : <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                                </span></h5>
                                                <h6> قیمت : <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}






                    </div>
                </div>
                <div class='tour-khareji'>
                    <h3 class="title">تور خارجی</h3>
                    <div class="owl-carousel owl-theme __tour__external__ owl-hotel-tour tour_grid">

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}

                                <div class="__i_modular_nc_item_class_0 item">
                                    <a class="" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                        <div class="imgBox">
                                            <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <div class="tour_txt">
                                            <div class="tour_txt_header">
                                                <h2 class="__title_class__">{$item['tour_name']}</h2>
                                            </div>
                                            <div class="tour_txt_footer">
                                                <h5>تاریخ حرکت : <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                                </span></h5>
                                                <h6> قیمت : <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</h6>
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
    </section>
{/if}