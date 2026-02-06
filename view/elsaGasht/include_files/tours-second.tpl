{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '9','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=8}

{assign var="tour_params_internal" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
{assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
{if $tour_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=5}

{assign var="tour_params_external" value=['type'=>'','limit'=> '9','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=8}

{assign var="tour_params_external" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=5}

{if $check_general}
    <section class="i_modular_tours tab-tour">
        <div class="container">
            <div class="title">
                <h2>محبوبترین تورها</h2>
                <p>
                    تورهای داخلی و خارجی با کیفیت عالی، اقامت لوکس و تفریحات متنوع برای تجربه‌ای فراموش‌نشدنی.
                </p>
            </div>
            <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button aria-controls="tour-khareji" aria-selected="false" class="nav-link active"
                            data-target="#tour-khareji" data-toggle="pill" id="tab-tour-khareji" role="tab"
                            type="button"> خارجی

                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button aria-controls="tour-dakheli" aria-selected="true" class="nav-link"
                            data-target="#tour-dakheli" data-toggle="pill" id="tab-tour-dakheli" role="tab"
                            type="button"> داخلی

                    </button>
                </li>
            </ul>
            <div class="parent-tab-tour">
                <div class="tab-content" id="pills-tabContent">
                    <div aria-labelledby="tab-tour-dakheli" class="tab-pane fade" id="tour-dakheli" role="tabpanel">
                        <div class="__tour__internal__ parent-tour">

                            {foreach $tour_internal as $item}
                                {if $min_internal <= $max_internal}
                                    <a class="__i_modular_nc_item_class_0 tour-item-link"
                                       href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="parent-img-tour">
                                            <img alt="{$item['tour_name']}" class="__image_class__"
                                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                        </div>
                                        <div class="parent-text-tour">
                                            <h3 class="__title_class__">{$item['tour_name']}</h3>
                                            <div class="price-tour">
                                                <h5 class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</h5>
                                                <span>ریال</span>
                                                <span>/ هر نفر</span>
                                            </div>
                                            <div class="clock-tour">
                                                <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M240 112C240 103.2 247.2 96 256 96C264.8 96 272 103.2 272 112V247.4L360.9 306.7C368.2 311.6 370.2 321.5 365.3 328.9C360.4 336.2 350.5 338.2 343.1 333.3L247.1 269.3C242.7 266.3 239.1 261.3 239.1 256L240 112zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM32 256C32 379.7 132.3 480 256 480C379.7 480 480 379.7 480 256C480 132.3 379.7 32 256 32C132.3 32 32 132.3 32 256z"></path>
                                                </svg>
                                                <span class="__night_class__">{$item['night']}</span>شب

                                            </div>
                                            <div class="data-tour">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path>
                                                </svg>
                                                <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                </span>
                                            </div>
                                            <div class="airline-tour">
                                                <div class="box-airline-img-tour">
                                                    <img  class="__airline_class__"
                                                         src="{$item['logo_transport']}" alt="{$item['airline_name']}">
                                                </div>
                                                <div class="box-airline-tour">
                                                    <span class="__airline_class__">{$item['airline_name']}</span>
                                                    <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    {$min_internal = $min_internal + 1}
                                {/if}
                            {/foreach}


                        </div>
                        <div class="__tour__internal__ owl-carousel owl-theme owl-tour">
                            {foreach $tour_internal as $item}
                                {if $min_internal <= $max_internal}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a class="tour-item-link"
                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                            <div class="parent-img-tour">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <div class="parent-text-tour">
                                                <h3 class="__title_class__">{$item['tour_name']}</h3>
                                                <div class="price-tour">
                                                    <h5 class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</h5>
                                                    <span>/ هر نفر</span>
                                                </div>
                                                <div class="clock-tour">
                                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M240 112C240 103.2 247.2 96 256 96C264.8 96 272 103.2 272 112V247.4L360.9 306.7C368.2 311.6 370.2 321.5 365.3 328.9C360.4 336.2 350.5 338.2 343.1 333.3L247.1 269.3C242.7 266.3 239.1 261.3 239.1 256L240 112zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM32 256C32 379.7 132.3 480 256 480C379.7 480 480 379.7 480 256C480 132.3 379.7 32 256 32C132.3 32 32 132.3 32 256z"></path>
                                                    </svg>
                                                    <span class="__night_class__">{$item['night']}</span>شب

                                                </div>
                                                <div class="data-tour">
                                                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path>
                                                    </svg>
                                                    <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                </span>
                                                </div>
                                                <div class="airline-tour">
                                                    <div class="box-airline-img-tour">
                                                        <img class="__airline_class__"
                                                             src="{$item['logo_transport']}" alt="{$item['airline_name']}">
                                                    </div>
                                                    <div class="box-airline-tour">
                                                        <span class="__airline_class__">{$item['airline_name']}</span>
                                                        <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                            <path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    {$min_internal = $min_internal + 1}
                                {/if}
                            {/foreach}


                        </div>
                        <a class="btn-more" href="{$smarty.const.ROOT_ADDRESS}/page/tour">

                            نمایش تمام تورها

                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    </div>
                    <div aria-labelledby="tab-tour-khareji" class="tab-pane fade show active" id="tour-khareji"
                         role="tabpanel">
                        <div class="__tour__external__ parent-tour">

                            {foreach $tour_external as $item}
                                {if $min_external <= $max_external}
                                    <a class="__i_modular_nc_item_class_0 tour-item-link"
                                       href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="parent-img-tour">
                                            <img alt="{$item['tour_name']}" class="__image_class__"
                                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                        </div>
                                        <div class="parent-text-tour">
                                            <h3 class="__title_class__">{$item['tour_name']}</h3>
                                            <div class="price-tour">
                                                <h5 class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</h5>
                                                <span>ریال</span>
                                                <span>/ هر نفر</span>
                                            </div>
                                            <div class="clock-tour">
                                                <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M240 112C240 103.2 247.2 96 256 96C264.8 96 272 103.2 272 112V247.4L360.9 306.7C368.2 311.6 370.2 321.5 365.3 328.9C360.4 336.2 350.5 338.2 343.1 333.3L247.1 269.3C242.7 266.3 239.1 261.3 239.1 256L240 112zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM32 256C32 379.7 132.3 480 256 480C379.7 480 480 379.7 480 256C480 132.3 379.7 32 256 32C132.3 32 32 132.3 32 256z"></path>
                                                </svg>
                                                <span class="__night_class__">{$item['night']}</span>شب

                                            </div>
                                            <div class="data-tour">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path>
                                                </svg>
                                                <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                </span>
                                            </div>
                                            <div class="airline-tour">
                                                <div class="box-airline-img-tour">
                                                    <img  class="__airline_class__"
                                                         src="{$item['logo_transport']}" alt="{$item['airline_name']}">
                                                </div>
                                                <div class="box-airline-tour">
                                                    <span class="__airline_class__">{$item['airline_name']}</span>
                                                    <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    {$min_external = $min_external + 1}
                                {/if}
                            {/foreach}


                        </div>
                        <div class="__tour__external__ owl-carousel owl-theme owl-tour">

                            {foreach $tour_external as $item}
                                {if $min_external <= $max_external}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a class="tour-item-link"
                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                            <div class="parent-img-tour">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <div class="parent-text-tour">
                                                <h3 class="__title_class__">{$item['tour_name']}</h3>
                                                <div class="price-tour">
                                                    <h5 class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</h5>
                                                    <span>/ هر نفر</span>
                                                </div>
                                                <div class="clock-tour">
                                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M240 112C240 103.2 247.2 96 256 96C264.8 96 272 103.2 272 112V247.4L360.9 306.7C368.2 311.6 370.2 321.5 365.3 328.9C360.4 336.2 350.5 338.2 343.1 333.3L247.1 269.3C242.7 266.3 239.1 261.3 239.1 256L240 112zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM32 256C32 379.7 132.3 480 256 480C379.7 480 480 379.7 480 256C480 132.3 379.7 32 256 32C132.3 32 32 132.3 32 256z"></path>
                                                    </svg>
                                                    <span class="__night_class__">{$item['night']}</span>شب

                                                </div>
                                                <div class="data-tour">
                                                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path>
                                                    </svg>
                                                    <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                </span>
                                                </div>
                                                <div class="airline-tour">
                                                    <div class="box-airline-img-tour">
                                                        <img  class="__airline_class__"
                                                             src="{$item['logo_transport']}" alt="{$item['airline_name']}">
                                                    </div>
                                                    <div class="box-airline-tour">
                                                        <span class="__airline_class__">{$item['airline_name']}</span>
                                                        <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                            <path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    {$min_external = $min_external + 1}
                                {/if}
                            {/foreach}


                        </div>
                        <a class="btn-more" href="{$smarty.const.ROOT_ADDRESS}/page/tour">

                            نمایش تمام تورها

                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}