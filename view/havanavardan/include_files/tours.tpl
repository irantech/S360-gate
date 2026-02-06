{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'special','limit'=> '10','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{*{$foreginTours|json_encode}*}
{*{$foreginTours|var_dump}*}
{if !empty($internalTours) || !empty($foreginTours)}
<section class="i_modular_tours tour py-5">
    <div class="container">
        <div class="title">
            <h2>بهترین تورهای هوانوردان</h2>
        </div>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-tour-dakheli" data-toggle="pill" data-target="#content-tour-dakheli" type="button" role="tab" aria-controls="content-tour-dakheli" aria-selected="true">داخلی</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-tour-khareji" data-toggle="pill" data-target="#content-tour-khareji" type="button" role="tab" aria-controls="content-tour-khareji" aria-selected="false">خارجی</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class=" tab-pane fade show active" id="content-tour-dakheli" role="tabpanel" aria-labelledby="tab-tour-dakheli">
                <div class="__tour__internal__ owl-tour owl-carousel owl-theme">
                    {foreach $internalTours as $item}
                    <div class="__i_modular_c_item_class_0  item">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                            <div class="parent-img">
                                <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                            </div>
                            <div class="parent-text">
                                <h3 class="__title_class__">{$item['tour_name']}</h3>
                                <div class="calendar">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192h80v56H48V192zm0 104h80v64H48V296zm128 0h96v64H176V296zm144 0h80v64H320V296zm80-48H320V192h80v56zm0 160v40c0 8.8-7.2 16-16 16H320V408h80zm-128 0v56H176V408h96zm-144 0v56H64c-8.8 0-16-7.2-16-16V408h80zM272 248H176V192h96v56z"/></svg>
                                    </i>
                                    <span class="__date_class__">
                                        {assign var="year" value=substr($item['start_date'], 0, 4)}
                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                        {assign var="day" value=substr($item['start_date'], 6)}
                                        {$year}-{$month}-{$day}
                                    </span>
                                </div>
                                <div class="bluBox">
                                    <div>
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z"/></svg>
                                        </i>
                                        <span>{$item['night']} شب</span>
                                    </div>
                                    <div>
                                        <img data-v-e23218c1="" src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 40px'>
                                        <span>{$item['airline_name']}</span>
                                    </div>
                                </div>
                                <button>
                                    {assign var="price_t" value=$item['min_price']['discountedMinPriceR']}

                                    از
{*                                    {$item['min_price']['discountedMinPriceR']|number_format}*}
                                    {$price_t|number_format}
                                    ریال
                                </button>
                            </div>
                        </a>
                    </div>
                    {/foreach}
                </div>
            </div>
            <div class=" tab-pane fade" id="content-tour-khareji" role="tabpanel" aria-labelledby="tab-tour-khareji">
                <div class="__tour__external__ owl-tour owl-carousel owl-theme">
                    {foreach $foreginTours as $item}
                    <div class="__i_modular_c_item_class_0  item">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                            <div class="parent-img">
                                <img  class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                            </div>
                            <div class="parent-text">
                                <h3 class="__title_class__">
                                    {$item['tour_name']}
                                </h3>
                                <div class="calendar">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192h80v56H48V192zm0 104h80v64H48V296zm128 0h96v64H176V296zm144 0h80v64H320V296zm80-48H320V192h80v56zm0 160v40c0 8.8-7.2 16-16 16H320V408h80zm-128 0v56H176V408h96zm-144 0v56H64c-8.8 0-16-7.2-16-16V408h80zM272 248H176V192h96v56z"/></svg>
                                    </i>
                                    <span class="__date_class__">
                                        {assign var="year" value=substr($item['start_date'], 0, 4)}
                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                        {assign var="day" value=substr($item['start_date'], 6)}
                                        {$year}-{$month}-{$day}
                                    </span>
                                </div>
                                <div class="bluBox">
                                    <div>
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z"/></svg>
                                        </i>
                                        <span>{$item['night']}   شب</span>
                                    </div>
                                    <div>
                                        <img data-v-e23218c1="" src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 40px'>
                                        <span>{$item['airline_name']}</span>
                                    </div>
                                </div>
                                <button>
                                    {assign var="price_t" value=$item['min_price']['discountedMinPriceR']}
                                    از
                                    {$price_t|number_format}

                                    ریال
                                </button>
                            </div>
                        </a>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>

    </div>
</section>
{/if}

