
{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="special_tour_params" value=['type'=>'special','limit'=> '4','dateNow' => $dateNow]}

{assign var='special_tours' value=$obj_main_page->getToursReservation($special_tour_params)}

{assign var="internal_tour_params" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}

<section class="i_modular_tours tour-demo">
    <div class="bg-absolute3"></div>
    <div class="container">
        <div class="__tour__category__ category-tour-demo">
            <div class="title-demo">
                <div class="">
                    <h2>
                        <span class="square-title"></span>
                        <span>تورهای ویژه</span>
                    </h2>
                    <p>
                        تورهای ویژه با برنامه‌های منحصر به فرد و خدمات اختصاصی، تجربه‌ای متمایز و به‌یادماندنی را برای مسافران فراهم می‌کنند.
                    </p>
                </div>
                <a class="__all_link_href__" href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/all'>
                        <span>
                            مشاهده همه
                        </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
                </a>
            </div>
            <div class="__tour__internal__special__category__ parent-category-tour-demo">
                {foreach $special_tours as $tour}
                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id_same']}/{$tour['tour_slug']}" class="__i_modular_nc_item_class_0">
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" alt="{$tour['tour_name']}">
                    <div class="parent-text-category-tour-demo">
                        <h3 class="__title_class__">
                            {$tour['tour_name']}
                        </h3>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM276.8 133.6v14.2c9.7 1.2 19.4 3.9 29 6.6c1.9 .5 3.7 1 5.6 1.6c11.5 3.2 18.3 15.1 15.1 26.6s-15.1 18.2-26.6 15.1c-1.5-.4-3.1-.9-4.7-1.3c-7-2-14-3.9-21.1-5.3c-13.2-2.5-28.5-1.3-40.8 4c-11 4.8-20.1 16.4-7.6 24.4c9.8 6.3 21.8 9.5 33.2 12.6c2.4 .6 4.7 1.3 7 1.9c15.6 4.4 35.5 10.1 50.4 20.3c19.4 13.3 28.5 34.9 24.2 58.1c-4.1 22.4-19.7 37.1-38.4 44.7c-7.8 3.2-16.3 5.2-25.2 6.2l0 15.2c0 11.9-9.7 21.6-21.6 21.6s-21.6-9.7-21.6-21.6l0-17.4c-14.5-3.3-28.7-7.9-42.8-12.5c-11.3-3.7-17.5-16-13.7-27.3s16-17.5 27.3-13.7c2.5 .8 5 1.7 7.5 2.5c11.3 3.8 22.9 7.7 34.5 9.6c17 2.5 30.6 1 39.5-2.6c12-4.8 17.7-19.1 5.9-27.1c-10.1-6.9-22.6-10.3-34.5-13.5c-2.3-.6-4.5-1.2-6.8-1.9c-15.1-4.3-34-9.6-48.2-18.7c-19.5-12.5-29.4-33.3-25.2-56.4c4-21.8 21-36.3 39-44.1c5.5-2.4 11.4-4.3 17.5-5.7V133.6c0-11.9 9.7-21.6 21.6-21.6s21.6 9.7 21.6 21.6z"/></svg>
                            <span class="___price_class__">{$tour['min_price_r']|number_format}</span>
                            <span>ریال</span>
                        </div>
                    </div>
                </a>
                {/foreach}

            </div>
        </div>
        <div class="tour-internal-external">
            <div class="title-demo">
                <div class="">
                    <h2>
                        <div class="square-title"></div>
                        <span>تورهای داخلی و خارجی</span>
                    </h2>
                    <p>
                        تورهای داخلی و خارجی فرصتی بی‌نظیر برای کشف فرهنگ‌ها، مناظر طبیعی و آثار تاریخی در داخل و خارج از کشور فراهم می‌کنند.
                    </p>
                </div>
                <a href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/all'>
                        <span>
                            مشاهده همه
                        </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
                </a>
            </div>
            <div class="parent-data-tour-tab-demo">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-tour-dakheli-demo" data-toggle="pill" data-target="#tour-dakheli-demo"
                                type="button" role="tab" aria-controls="tour-dakheli-demo" aria-selected="true"> داخلی
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="tab-tour-khareji-demo" data-toggle="pill" data-target="#tour-khareji-demo"
                                type="button" role="tab" aria-controls="tour-khareji-demo" aria-selected="false"> خارجی
                        </button>
                    </li>
                </ul>
                <div class="parent-tab-tour">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tour-dakheli-demo" role="tabpanel" aria-labelledby="tab-tour-dakheli-demo">
                            <div class="__tour__internal__ parent-tour-demo">
                                {foreach $internalTours as $item}
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="__i_modular_nc_item_class_0">
                                    <div class="parent-img">
                                        <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                        <div class="___price_class__ price-tour-demo">
                                            {$item['min_price']['discountedMinPriceR']|number_format}  ریال
                                        </div>
                                    </div>
                                    <div class="text-tour">
                                        <div class="city-tour">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                            <span class="__city_class__">{$item['destination_city_name']}</span>
                                        </div>
                                        <h4 class="__title_class__">{$item['tour_name']}</h4>
                                        <p class="__description_class__">
                                            {$item['description']|strip_tags}
                                        </p>
                                        <div class="data-tour">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                                            <span>تاریخ حرکت:</span>
                                            <span class="__date_class__ color-data-tour-demo">
                                                  {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                        <div class="parent-btn">
                                            <div class="parent-logo-airline">
                                                <img data-v-e23218c1="" src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 40px'>
                                                <div class="text-airline">
                                                    <h6 class="__airline_class__">{$item['airline_name']}</h6>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 167.4l-24 0c0 8.2 4.2 15.8 11.1 20.2L312 167.4zM473.3 270.6l12.9-20.2h0l-12.9 20.2zm-6.1 82.8l-7.3 22.9 7.3-22.9zM312 303.7l7.3-22.9c-7.3-2.3-15.3-1-21.5 3.5s-9.8 11.7-9.8 19.4h24zm0 72.3H288c0 7.6 3.6 14.7 9.6 19.2L312 376zm57.6 43.2l-14.4 19.2h0l14.4-19.2zM358 487.4l7.1-22.9 0 0L358 487.4zM256 456l7.1-22.9c-4.6-1.4-9.5-1.4-14.1 0L256 456zM154 487.4l-7.1-22.9h0l7.1 22.9zm-11.6-68.2l14.4 19.2-14.4-19.2zM200 376l14.4 19.2c6-4.5 9.6-11.6 9.6-19.2l-24 0zm0-72.3l24 0c0-7.7-3.7-14.9-9.8-19.4s-14.2-5.8-21.5-3.5l7.3 22.9zM44.9 353.3l7.3 22.9h0l-7.3-22.9zm-6.1-82.8L25.8 250.3l0 0 12.9 20.2zM200 167.4l12.9 20.2c6.9-4.4 11.1-12 11.1-20.2H200zM256 0c-17.4 0-31.1 8.8-40.7 18.7c-9.6 9.9-16.9 22.4-22.4 34.8C182.1 78 176 107.3 176 128h48c0-13.4 4.4-36.1 12.8-55.1c4.2-9.4 8.7-16.4 12.9-20.7c4.1-4.2 6.2-4.2 6.3-4.2V0zm80 128c0-20.6-5.8-49.8-16.5-74.4c-5.4-12.4-12.7-25-22.4-34.9C287.2 8.6 273.4 0 256 0V48c.6 0 2.8 .1 6.8 4.2c4.2 4.3 8.6 11.2 12.7 20.6C283.8 91.7 288 114.4 288 128l48 0zm0 39.4V128l-48 0v39.4l48 0zm150.2 83L324.9 147.1l-25.9 40.4L460.3 290.8l25.9-40.4zM512 297.5c0-19.1-9.7-36.9-25.8-47.2l-25.9 40.4c2.3 1.5 3.7 4 3.7 6.7h48zm0 40.6V297.5H464v40.6h48zm-52.2 38.1c25.8 8.3 52.2-11 52.2-38.1H464c0-5.4 5.3-9.3 10.4-7.6l-14.6 45.7zM304.7 326.5l155.1 49.6 14.6-45.7L319.3 280.8l-14.6 45.7zM336 376V303.7H288V376h48zm-38.4 19.2l57.6 43.2L384 400l-57.6-43.2-28.8 38.4zm57.6 43.2c-2-1.5-3.2-3.9-3.2-6.4h48c0-12.6-5.9-24.4-16-32l-28.8 38.4zM352 432v42.1h48V432H352zm0 42.1c0-5.6 4.5-10.1 10.1-10.1v48c20.9 0 37.9-17 37.9-37.9H352zM362.1 464c1 0 2 .2 3 .4l-14.1 45.9c3.6 1.1 7.4 1.7 11.1 1.7V464zm3 .4l-102-31.4-14.1 45.9 102 31.4 14.1-45.9zM248.9 433.1l-102 31.4 14.1 45.9 102-31.4-14.1-45.9zm-102 31.4c1-.3 2-.4 3-.4l0 48c3.8 0 7.5-.6 11.1-1.7l-14.1-45.9zm3-.4c5.6 0 10.1 4.5 10.1 10.1H112c0 20.9 17 37.9 37.9 37.9l0-48zM160 474.1l0-42.1H112v42.1h48zm0-42.1c0 2.5-1.2 4.9-3.2 6.4L128 400c-10.1 7.6-16 19.4-16 32h48zm-3.2 6.4l57.6-43.2-28.8-38.4L128 400l28.8 38.4zM176 303.7l0 72.3 48 0 0-72.3-48 0zM52.2 376.2l155.1-49.6-14.6-45.7L37.6 330.5l14.6 45.7zM0 338.1c0 27.1 26.4 46.4 52.2 38.1L37.6 330.5c5.2-1.7 10.4 2.2 10.4 7.6H0zm0-40.6l0 40.6H48l0-40.6H0zm25.8-47.2C9.7 260.6 0 278.4 0 297.5H48c0-2.7 1.4-5.3 3.7-6.7L25.8 250.3zM187.1 147.1L25.8 250.3l25.9 40.4L212.9 187.6l-25.9-40.4zM176 128v39.4h48V128H176z"/></svg>
                                                </div>
                                            </div>
                                            <button class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                {/foreach}
                            </div>
                            <div class="__tour__internal__ owl-carousel owl-theme owl-tour-demo">
                                {foreach $internalTours as $item}
                                <div class="__i_modular_nc_item_class_0 item">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="__link__">
                                        <div class="parent-img">
                                            <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                            <div class="___price_class__ price-tour-demo">
                                                {$item['min_price']['discountedMinPriceR']|number_format} ریال
                                            </div>
                                        </div>
                                        <div class="text-tour">
                                            <div class="city-tour">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                                <span class="__city_class__">{$item['destination_city_name']}</span>
                                            </div>
                                            <h4 class="__title_class__">{$item['tour_name']}</h4>
                                            <p class="__description_class__">
                                                {$item['description']|strip_tags}
                                            </p>
                                            <div class="data-tour">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                                                <span>تاریخ حرکت:</span>
                                                <span class="__date_class__ color-data-tour-demo">
                                                      {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                                </span>
                                            </div>
                                            <div class="parent-btn">
                                                <div class="parent-logo-airline">
                                                    <img data-v-e23218c1="" src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 40px'>
                                                    <div class="text-airline">
                                                        <h6 class="__airline_class__">{$item['airline_name']}</h6>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 167.4l-24 0c0 8.2 4.2 15.8 11.1 20.2L312 167.4zM473.3 270.6l12.9-20.2h0l-12.9 20.2zm-6.1 82.8l-7.3 22.9 7.3-22.9zM312 303.7l7.3-22.9c-7.3-2.3-15.3-1-21.5 3.5s-9.8 11.7-9.8 19.4h24zm0 72.3H288c0 7.6 3.6 14.7 9.6 19.2L312 376zm57.6 43.2l-14.4 19.2h0l14.4-19.2zM358 487.4l7.1-22.9 0 0L358 487.4zM256 456l7.1-22.9c-4.6-1.4-9.5-1.4-14.1 0L256 456zM154 487.4l-7.1-22.9h0l7.1 22.9zm-11.6-68.2l14.4 19.2-14.4-19.2zM200 376l14.4 19.2c6-4.5 9.6-11.6 9.6-19.2l-24 0zm0-72.3l24 0c0-7.7-3.7-14.9-9.8-19.4s-14.2-5.8-21.5-3.5l7.3 22.9zM44.9 353.3l7.3 22.9h0l-7.3-22.9zm-6.1-82.8L25.8 250.3l0 0 12.9 20.2zM200 167.4l12.9 20.2c6.9-4.4 11.1-12 11.1-20.2H200zM256 0c-17.4 0-31.1 8.8-40.7 18.7c-9.6 9.9-16.9 22.4-22.4 34.8C182.1 78 176 107.3 176 128h48c0-13.4 4.4-36.1 12.8-55.1c4.2-9.4 8.7-16.4 12.9-20.7c4.1-4.2 6.2-4.2 6.3-4.2V0zm80 128c0-20.6-5.8-49.8-16.5-74.4c-5.4-12.4-12.7-25-22.4-34.9C287.2 8.6 273.4 0 256 0V48c.6 0 2.8 .1 6.8 4.2c4.2 4.3 8.6 11.2 12.7 20.6C283.8 91.7 288 114.4 288 128l48 0zm0 39.4V128l-48 0v39.4l48 0zm150.2 83L324.9 147.1l-25.9 40.4L460.3 290.8l25.9-40.4zM512 297.5c0-19.1-9.7-36.9-25.8-47.2l-25.9 40.4c2.3 1.5 3.7 4 3.7 6.7h48zm0 40.6V297.5H464v40.6h48zm-52.2 38.1c25.8 8.3 52.2-11 52.2-38.1H464c0-5.4 5.3-9.3 10.4-7.6l-14.6 45.7zM304.7 326.5l155.1 49.6 14.6-45.7L319.3 280.8l-14.6 45.7zM336 376V303.7H288V376h48zm-38.4 19.2l57.6 43.2L384 400l-57.6-43.2-28.8 38.4zm57.6 43.2c-2-1.5-3.2-3.9-3.2-6.4h48c0-12.6-5.9-24.4-16-32l-28.8 38.4zM352 432v42.1h48V432H352zm0 42.1c0-5.6 4.5-10.1 10.1-10.1v48c20.9 0 37.9-17 37.9-37.9H352zM362.1 464c1 0 2 .2 3 .4l-14.1 45.9c3.6 1.1 7.4 1.7 11.1 1.7V464zm3 .4l-102-31.4-14.1 45.9 102 31.4 14.1-45.9zM248.9 433.1l-102 31.4 14.1 45.9 102-31.4-14.1-45.9zm-102 31.4c1-.3 2-.4 3-.4l0 48c3.8 0 7.5-.6 11.1-1.7l-14.1-45.9zm3-.4c5.6 0 10.1 4.5 10.1 10.1H112c0 20.9 17 37.9 37.9 37.9l0-48zM160 474.1l0-42.1H112v42.1h48zm0-42.1c0 2.5-1.2 4.9-3.2 6.4L128 400c-10.1 7.6-16 19.4-16 32h48zm-3.2 6.4l57.6-43.2-28.8-38.4L128 400l28.8 38.4zM176 303.7l0 72.3 48 0 0-72.3-48 0zM52.2 376.2l155.1-49.6-14.6-45.7L37.6 330.5l14.6 45.7zM0 338.1c0 27.1 26.4 46.4 52.2 38.1L37.6 330.5c5.2-1.7 10.4 2.2 10.4 7.6H0zm0-40.6l0 40.6H48l0-40.6H0zm25.8-47.2C9.7 260.6 0 278.4 0 297.5H48c0-2.7 1.4-5.3 3.7-6.7L25.8 250.3zM187.1 147.1L25.8 250.3l25.9 40.4L212.9 187.6l-25.9-40.4zM176 128v39.4h48V128H176z"/></svg>
                                                    </div>
                                                </div>
                                                <button class="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                {/foreach}
                            </div>
                        </div>
                        <div class="tab-pane fade " id="tour-khareji-demo" role="tabpanel" aria-labelledby="tab-tour-khareji-demo">
                            <div class="__tour__external__ parent-tour-demo">
                                {foreach $foreginTours as $item}
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="__i_modular_nc_item_class_0">
                                    <div class="parent-img">
                                        <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}" alt="img-tour">
                                        <div class="___price_class__ price-tour-demo">
                                            {$item['min_price']['discountedMinPriceR']|number_format} ریال
                                        </div>
                                    </div>
                                    <div class="text-tour">
                                        <div class="city-tour">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                            <span class="__city_class__">{$item['destination_city_name']}</span>
                                        </div>
                                        <h4 class="__title_class__">{$item['tour_name']}</h4>
                                        <p class="__description_class__">
                                            {$item['description']|strip_tags}
                                        </p>
                                        <div class="data-tour">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                                            <span>تاریخ حرکت:</span>
                                            <span class="__date_class__ color-data-tour-demo">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}

                                            </span>
                                        </div>
                                        <div class="parent-btn">
                                            <div class="parent-logo-airline">
                                                <img data-v-e23218c1="" src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 40px'>
                                                <div class="text-airline">
                                                    <h6 class="__airline_class__">{$item['airline_name']}</h6>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 167.4l-24 0c0 8.2 4.2 15.8 11.1 20.2L312 167.4zM473.3 270.6l12.9-20.2h0l-12.9 20.2zm-6.1 82.8l-7.3 22.9 7.3-22.9zM312 303.7l7.3-22.9c-7.3-2.3-15.3-1-21.5 3.5s-9.8 11.7-9.8 19.4h24zm0 72.3H288c0 7.6 3.6 14.7 9.6 19.2L312 376zm57.6 43.2l-14.4 19.2h0l14.4-19.2zM358 487.4l7.1-22.9 0 0L358 487.4zM256 456l7.1-22.9c-4.6-1.4-9.5-1.4-14.1 0L256 456zM154 487.4l-7.1-22.9h0l7.1 22.9zm-11.6-68.2l14.4 19.2-14.4-19.2zM200 376l14.4 19.2c6-4.5 9.6-11.6 9.6-19.2l-24 0zm0-72.3l24 0c0-7.7-3.7-14.9-9.8-19.4s-14.2-5.8-21.5-3.5l7.3 22.9zM44.9 353.3l7.3 22.9h0l-7.3-22.9zm-6.1-82.8L25.8 250.3l0 0 12.9 20.2zM200 167.4l12.9 20.2c6.9-4.4 11.1-12 11.1-20.2H200zM256 0c-17.4 0-31.1 8.8-40.7 18.7c-9.6 9.9-16.9 22.4-22.4 34.8C182.1 78 176 107.3 176 128h48c0-13.4 4.4-36.1 12.8-55.1c4.2-9.4 8.7-16.4 12.9-20.7c4.1-4.2 6.2-4.2 6.3-4.2V0zm80 128c0-20.6-5.8-49.8-16.5-74.4c-5.4-12.4-12.7-25-22.4-34.9C287.2 8.6 273.4 0 256 0V48c.6 0 2.8 .1 6.8 4.2c4.2 4.3 8.6 11.2 12.7 20.6C283.8 91.7 288 114.4 288 128l48 0zm0 39.4V128l-48 0v39.4l48 0zm150.2 83L324.9 147.1l-25.9 40.4L460.3 290.8l25.9-40.4zM512 297.5c0-19.1-9.7-36.9-25.8-47.2l-25.9 40.4c2.3 1.5 3.7 4 3.7 6.7h48zm0 40.6V297.5H464v40.6h48zm-52.2 38.1c25.8 8.3 52.2-11 52.2-38.1H464c0-5.4 5.3-9.3 10.4-7.6l-14.6 45.7zM304.7 326.5l155.1 49.6 14.6-45.7L319.3 280.8l-14.6 45.7zM336 376V303.7H288V376h48zm-38.4 19.2l57.6 43.2L384 400l-57.6-43.2-28.8 38.4zm57.6 43.2c-2-1.5-3.2-3.9-3.2-6.4h48c0-12.6-5.9-24.4-16-32l-28.8 38.4zM352 432v42.1h48V432H352zm0 42.1c0-5.6 4.5-10.1 10.1-10.1v48c20.9 0 37.9-17 37.9-37.9H352zM362.1 464c1 0 2 .2 3 .4l-14.1 45.9c3.6 1.1 7.4 1.7 11.1 1.7V464zm3 .4l-102-31.4-14.1 45.9 102 31.4 14.1-45.9zM248.9 433.1l-102 31.4 14.1 45.9 102-31.4-14.1-45.9zm-102 31.4c1-.3 2-.4 3-.4l0 48c3.8 0 7.5-.6 11.1-1.7l-14.1-45.9zm3-.4c5.6 0 10.1 4.5 10.1 10.1H112c0 20.9 17 37.9 37.9 37.9l0-48zM160 474.1l0-42.1H112v42.1h48zm0-42.1c0 2.5-1.2 4.9-3.2 6.4L128 400c-10.1 7.6-16 19.4-16 32h48zm-3.2 6.4l57.6-43.2-28.8-38.4L128 400l28.8 38.4zM176 303.7l0 72.3 48 0 0-72.3-48 0zM52.2 376.2l155.1-49.6-14.6-45.7L37.6 330.5l14.6 45.7zM0 338.1c0 27.1 26.4 46.4 52.2 38.1L37.6 330.5c5.2-1.7 10.4 2.2 10.4 7.6H0zm0-40.6l0 40.6H48l0-40.6H0zm25.8-47.2C9.7 260.6 0 278.4 0 297.5H48c0-2.7 1.4-5.3 3.7-6.7L25.8 250.3zM187.1 147.1L25.8 250.3l25.9 40.4L212.9 187.6l-25.9-40.4zM176 128v39.4h48V128H176z"/></svg>
                                                </div>
                                            </div>
                                            <button class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                {/foreach}
                            </div>
                            <div class="__tour__external__ owl-carousel owl-theme owl-tour-demo">
                                {foreach $foreginTours as $item}
                                <div class="__i_modular_nc_item_class_0 item">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="__link__">
                                        <div class="parent-img">
                                            <img class="__image_class__" src="images/tour-america.jpg" alt="img-tour">
                                            <div class="___price_class__ price-tour-demo">
                                                {$item['min_price']['discountedMinPriceR']|number_format} ریال
                                            </div>
                                        </div>
                                        <div class="text-tour">
                                            <div class="city-tour">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                                                <span class="__city_class__">{$item['destination_city_name']}</span>
                                            </div>
                                            <h4 class="__title_class__">{$item['tour_name']}</h4>
                                            <p class="__description_class__">
                                                {$item['description']|strip_tags}
                                            </p>
                                            <div class="data-tour">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                                                <span>تاریخ حرکت:</span>
                                                <span class="__date_class__ color-data-tour-demo">
                                                    {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                                </span>
                                            </div>
                                            <div class="parent-btn">
                                                <div class="parent-logo-airline">
                                                    <img data-v-e23218c1="" src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 40px'>
                                                    <div class="text-airline">
                                                        <h6 class="__airline_class__">{$item['airline_name']}</h6>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 167.4l-24 0c0 8.2 4.2 15.8 11.1 20.2L312 167.4zM473.3 270.6l12.9-20.2h0l-12.9 20.2zm-6.1 82.8l-7.3 22.9 7.3-22.9zM312 303.7l7.3-22.9c-7.3-2.3-15.3-1-21.5 3.5s-9.8 11.7-9.8 19.4h24zm0 72.3H288c0 7.6 3.6 14.7 9.6 19.2L312 376zm57.6 43.2l-14.4 19.2h0l14.4-19.2zM358 487.4l7.1-22.9 0 0L358 487.4zM256 456l7.1-22.9c-4.6-1.4-9.5-1.4-14.1 0L256 456zM154 487.4l-7.1-22.9h0l7.1 22.9zm-11.6-68.2l14.4 19.2-14.4-19.2zM200 376l14.4 19.2c6-4.5 9.6-11.6 9.6-19.2l-24 0zm0-72.3l24 0c0-7.7-3.7-14.9-9.8-19.4s-14.2-5.8-21.5-3.5l7.3 22.9zM44.9 353.3l7.3 22.9h0l-7.3-22.9zm-6.1-82.8L25.8 250.3l0 0 12.9 20.2zM200 167.4l12.9 20.2c6.9-4.4 11.1-12 11.1-20.2H200zM256 0c-17.4 0-31.1 8.8-40.7 18.7c-9.6 9.9-16.9 22.4-22.4 34.8C182.1 78 176 107.3 176 128h48c0-13.4 4.4-36.1 12.8-55.1c4.2-9.4 8.7-16.4 12.9-20.7c4.1-4.2 6.2-4.2 6.3-4.2V0zm80 128c0-20.6-5.8-49.8-16.5-74.4c-5.4-12.4-12.7-25-22.4-34.9C287.2 8.6 273.4 0 256 0V48c.6 0 2.8 .1 6.8 4.2c4.2 4.3 8.6 11.2 12.7 20.6C283.8 91.7 288 114.4 288 128l48 0zm0 39.4V128l-48 0v39.4l48 0zm150.2 83L324.9 147.1l-25.9 40.4L460.3 290.8l25.9-40.4zM512 297.5c0-19.1-9.7-36.9-25.8-47.2l-25.9 40.4c2.3 1.5 3.7 4 3.7 6.7h48zm0 40.6V297.5H464v40.6h48zm-52.2 38.1c25.8 8.3 52.2-11 52.2-38.1H464c0-5.4 5.3-9.3 10.4-7.6l-14.6 45.7zM304.7 326.5l155.1 49.6 14.6-45.7L319.3 280.8l-14.6 45.7zM336 376V303.7H288V376h48zm-38.4 19.2l57.6 43.2L384 400l-57.6-43.2-28.8 38.4zm57.6 43.2c-2-1.5-3.2-3.9-3.2-6.4h48c0-12.6-5.9-24.4-16-32l-28.8 38.4zM352 432v42.1h48V432H352zm0 42.1c0-5.6 4.5-10.1 10.1-10.1v48c20.9 0 37.9-17 37.9-37.9H352zM362.1 464c1 0 2 .2 3 .4l-14.1 45.9c3.6 1.1 7.4 1.7 11.1 1.7V464zm3 .4l-102-31.4-14.1 45.9 102 31.4 14.1-45.9zM248.9 433.1l-102 31.4 14.1 45.9 102-31.4-14.1-45.9zm-102 31.4c1-.3 2-.4 3-.4l0 48c3.8 0 7.5-.6 11.1-1.7l-14.1-45.9zm3-.4c5.6 0 10.1 4.5 10.1 10.1H112c0 20.9 17 37.9 37.9 37.9l0-48zM160 474.1l0-42.1H112v42.1h48zm0-42.1c0 2.5-1.2 4.9-3.2 6.4L128 400c-10.1 7.6-16 19.4-16 32h48zm-3.2 6.4l57.6-43.2-28.8-38.4L128 400l28.8 38.4zM176 303.7l0 72.3 48 0 0-72.3-48 0zM52.2 376.2l155.1-49.6-14.6-45.7L37.6 330.5l14.6 45.7zM0 338.1c0 27.1 26.4 46.4 52.2 38.1L37.6 330.5c5.2-1.7 10.4 2.2 10.4 7.6H0zm0-40.6l0 40.6H48l0-40.6H0zm25.8-47.2C9.7 260.6 0 278.4 0 297.5H48c0-2.7 1.4-5.3 3.7-6.7L25.8 250.3zM187.1 147.1L25.8 250.3l25.9 40.4L212.9 187.6l-25.9-40.4zM176 128v39.4h48V128H176z"/></svg>
                                                    </div>
                                                </div>
                                                <button class="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path></svg>
                                                </button>
                                            </div>
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
    </div>
</section>