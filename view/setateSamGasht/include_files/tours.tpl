{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'special','limit'=> '4','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'special','limit'=> '4','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{*{$foreginTours|json_encode}*}
{if !empty($internalTours) || !empty($foreginTours)}
    <section class="i_modular_tours tour-salam">
        <div class="container">
            <div class="title-kanoun">
                <h4>تورهای محبوب</h4>
                <h2> برگزاری تورهای داخلی و خارجی با بهترین کیفیت و امکانات </h2>
            </div>
            <div class="">
                <div class="parent-ul-tour col-lg-12 col-md-12 col-12">
                    <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button aria-controls="tour-dakheli" aria-selected="true" class="nav-link active"
                                    data-target="#tour-dakheli" data-toggle="pill" id="tab-tour-dakheli" role="tab"
                                    type="button"> داخلی

                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button aria-controls="tour-khareji" aria-selected="false" class="nav-link"
                                    data-target="#tour-khareji" data-toggle="pill" id="tab-tour-khareji" role="tab"
                                    type="button"> خارجی

                            </button>
                        </li>
                    </ul>
                </div>
                <div class="parent-tab-tour">
                    <div class="tab-content" id="pills-tabContent">
                        <div aria-labelledby="tab-tour-dakheli" class="tab-pane fade show active" id="tour-dakheli"
                             role="tabpanel">
                            <div class="__tour__internal__ owl-tour owl-carousel owl-theme">

                                {foreach $internalTours as $item}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                            <div class="bluBox">
                                                <div>
                                                    <i>
                                                        <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                                            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M566.5 261.1C484 276.6 408.2 214.1 408.2 131.8c0-47.39 25.68-90.97 67.44-114.5c6.436-3.609 4.816-13.25-2.492-14.58C464.7 1.25 450.7 0 442.1 0C348.2 0 272 75.14 272 168c0 .5703 .1641 1.094 .1699 1.662c3.479 2.164 7.135 4.008 10.46 6.432C284.4 176 286.2 176 288 176c61.69 0 115.7 42.47 131.3 100.1c20.34 14.92 36.18 34.78 46.64 57.19c42.93-5.99 81.37-27.71 108.2-60.36C578.9 268.1 573.8 259.7 566.5 261.1zM390.8 296.4C383.3 246.4 340 208 288 208c-5.125 0-10.25 .375-15.25 1.125C248.5 188 217.3 176 184 176c-64 0-118.3 45.25-132.4 105.3C19.63 305.1 0 343 0 384c0 70.63 57.38 128 128 128h204c64 0 116-52 116-116C448 354.3 425.3 316.8 390.8 296.4zM332 464H128c-44.25 0-80-35.75-80-80c0-32.75 19.75-61 48.13-73.25C96.75 262.8 135.8 224 184 224c31.25 0 58.38 16.25 74.13 40.75c8.625-5.5 18.87-8.75 29.87-8.75C318.9 255.1 344 281.1 344 312c0 5.875-1.25 11.5-2.875 16.88C374.3 333.4 400 361.5 400 396C400 433.6 369.5 464 332 464z"></path>
                                                        </svg>
                                                    </i>
                                                    <h6 class="__night_class__">{$item['night']}</h6>
                                                </div>
                                                <div>
                                                    <i>
                                                        <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                                                            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M255.1 0C304.1 0 336 73.89 336 111.8V153.8L422.5 207.7C406.2 215.2 391.3 225.1 378.1 236.1L287.1 180.7V112.8C287.1 85.87 266.1 49.93 255.1 48.93C245.1 50.93 223.1 86.87 223.1 112.8V180.7L47.1 290.6V324.5L223.1 269.6V383.4L159.1 431.4V458.3L255.1 430.4L343.9 455.1C355.2 475.2 369.9 492.1 387.4 505.7C379.5 511.4 369.7 513.2 360 510.3L256 480.3L152 511.3C143 513.2 133 511.3 125 505.3C117 499.3 112 489.3 112 480.3V423.4C112 413.4 117 404.4 125 398.4L176 359.5V334.5L41 377.4C32 380.4 21 378.4 13 372.5C5 366.5 0 356.5 0 346.5V281.6C0 270.6 7 258.6 16 254.6L176 154.8V112.8C176 73.89 208 0 256 0L255.1 0zM319.1 367.5C319.1 382.7 321.9 397.5 325.6 411.6L287.1 383.4V269.6L340.1 285.9C327.3 310.2 319.1 338 319.1 367.5V367.5zM640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368zM540.7 324.7L480 385.4L451.3 356.7C445.1 350.4 434.9 350.4 428.7 356.7C422.4 362.9 422.4 373.1 428.7 379.3L468.7 419.3C474.9 425.6 485.1 425.6 491.3 419.3L563.3 347.3C569.6 341.1 569.6 330.9 563.3 324.7C557.1 318.4 546.9 318.4 540.7 324.7H540.7z"></path>
                                                        </svg>
                                                    </i>
                                                    <h6 class="__airline_class__">{$item['airline_name']}</h6>
                                                </div>
                                                <div>
                                                    <i>
                                                        <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                                                            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"></path>
                                                        </svg>
                                                    </i>
                                                    <h6 class="__city_class__">{$item['destination_city_name']}</h6>
                                                </div>
                                            </div>
                                            <div class="img_box">
                                                <img alt="{$item['tour_name']}" class="__image_class__"
                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                            </div>
                                            <div class="text_box">
                                                <h3 class="__title_class__">{$item['tour_name']}</h3>
                                                <div class="calendar">
                                                    <span>تاریخ حرکت : <span class="__date_class__">
                                                            {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                            {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                            {assign var="day" value=substr($item['start_date'], 6)}
                                                            {$year}/{$month}/{$day}
                                                            </span></span>
                                                            </div>
                                                            <p class="__description_class__">{$item['description']}</p>
                                                            <div class="price">
                                                             <span>

                                                            شروع قیمت از :

                                                            <span class="___price_class__">{$item['min_price_r']|number_format} </span>

                                                            ریال

                                                 </span>
                                                </div>
                                            </div>
                                            <div class="button-group-tour">
                                                <button>

                                                    جزئیات بیشتر

                                                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </div>
                                {/foreach}


                            </div>
                        </div>
                        <div aria-labelledby="tab-tour-khareji" class="tab-pane fade" id="tour-khareji" role="tabpanel">
                            <div class="__tour__internal__ owl-tour owl-carousel owl-theme">

                                {foreach $foreginTours as $item}
                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                                <div class="bluBox">
                                                    <div>
                                                        <i>
                                                            <svg viewbox="0 0 576 512"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                <path d="M566.5 261.1C484 276.6 408.2 214.1 408.2 131.8c0-47.39 25.68-90.97 67.44-114.5c6.436-3.609 4.816-13.25-2.492-14.58C464.7 1.25 450.7 0 442.1 0C348.2 0 272 75.14 272 168c0 .5703 .1641 1.094 .1699 1.662c3.479 2.164 7.135 4.008 10.46 6.432C284.4 176 286.2 176 288 176c61.69 0 115.7 42.47 131.3 100.1c20.34 14.92 36.18 34.78 46.64 57.19c42.93-5.99 81.37-27.71 108.2-60.36C578.9 268.1 573.8 259.7 566.5 261.1zM390.8 296.4C383.3 246.4 340 208 288 208c-5.125 0-10.25 .375-15.25 1.125C248.5 188 217.3 176 184 176c-64 0-118.3 45.25-132.4 105.3C19.63 305.1 0 343 0 384c0 70.63 57.38 128 128 128h204c64 0 116-52 116-116C448 354.3 425.3 316.8 390.8 296.4zM332 464H128c-44.25 0-80-35.75-80-80c0-32.75 19.75-61 48.13-73.25C96.75 262.8 135.8 224 184 224c31.25 0 58.38 16.25 74.13 40.75c8.625-5.5 18.87-8.75 29.87-8.75C318.9 255.1 344 281.1 344 312c0 5.875-1.25 11.5-2.875 16.88C374.3 333.4 400 361.5 400 396C400 433.6 369.5 464 332 464z"></path>
                                                            </svg>
                                                        </i>
                                                        <h6 class="__night_class__">{$item['night']}</h6>
                                                    </div>
                                                    <div>
                                                        <i>
                                                            <svg viewbox="0 0 640 512"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                <path d="M255.1 0C304.1 0 336 73.89 336 111.8V153.8L422.5 207.7C406.2 215.2 391.3 225.1 378.1 236.1L287.1 180.7V112.8C287.1 85.87 266.1 49.93 255.1 48.93C245.1 50.93 223.1 86.87 223.1 112.8V180.7L47.1 290.6V324.5L223.1 269.6V383.4L159.1 431.4V458.3L255.1 430.4L343.9 455.1C355.2 475.2 369.9 492.1 387.4 505.7C379.5 511.4 369.7 513.2 360 510.3L256 480.3L152 511.3C143 513.2 133 511.3 125 505.3C117 499.3 112 489.3 112 480.3V423.4C112 413.4 117 404.4 125 398.4L176 359.5V334.5L41 377.4C32 380.4 21 378.4 13 372.5C5 366.5 0 356.5 0 346.5V281.6C0 270.6 7 258.6 16 254.6L176 154.8V112.8C176 73.89 208 0 256 0L255.1 0zM319.1 367.5C319.1 382.7 321.9 397.5 325.6 411.6L287.1 383.4V269.6L340.1 285.9C327.3 310.2 319.1 338 319.1 367.5V367.5zM640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368zM540.7 324.7L480 385.4L451.3 356.7C445.1 350.4 434.9 350.4 428.7 356.7C422.4 362.9 422.4 373.1 428.7 379.3L468.7 419.3C474.9 425.6 485.1 425.6 491.3 419.3L563.3 347.3C569.6 341.1 569.6 330.9 563.3 324.7C557.1 318.4 546.9 318.4 540.7 324.7H540.7z"></path>
                                                            </svg>
                                                        </i>
                                                        <h6 class="__airline_class__">{$item['airline_name']}</h6>
                                                    </div>
                                                    <div>
                                                        <i>
                                                            <svg viewbox="0 0 384 512"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                <path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"></path>
                                                            </svg>
                                                        </i>
                                                        <h6 class="__city_class__">{$item['destination_city_name']}</h6>
                                                    </div>
                                                </div>
                                                <div class="img_box">
                                                    <img alt="{$item['tour_name']}" class="__image_class__"
                                                         src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                                                </div>
                                                <div class="text_box">
                                                    <h3 class="__title_class__">{$item['tour_name']}</h3>
                                                    <div class="calendar">
                                                <span>تاریخ حرکت : <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                                        {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                        {assign var="day" value=substr($item['start_date'], 6)}
                                                        {$year}/{$month}/{$day}
                                                        </span></span>
                                                        </div>
                                                        <p class="__description_class__">{$item['description']}</p>
                                                        <div class="price">
                                                <span>

                                                            شروع قیمت از :

                                                            <span class="___price_class__">{$item['min_price_r']|number_format}</span>

                                                            ریال

                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="button-group-tour">
                                                    <button>

                                                        جزئیات بیشتر

                                                        <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </a>
                                        </div>

                                {/foreach}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}