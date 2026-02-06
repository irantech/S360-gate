{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['Count'=> '10', 'type' =>'internal']}


{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity()}
{assign var='internal_hotels' value=$obj_main_page->getHotelWebservice($internal_hotel_params)}
{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity($external_hotel_params)}



{if $foregin_hotels or $internal_hotels}
    <section class="i_modular_hotels_webservice hotel-ghods">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <div class="parent-svg-title">
                        <svg height="" viewBox="0 0 32 32" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M14.667 2.667a2.666 2.666 0 0 1 2.667 2.667v4h8a2.666 2.666 0 0 1 2.667 2.667v13.333l.156.009c.663.076 1.177.64 1.177 1.324V28H2.667v-1.333c0-.736.597-1.333 1.333-1.333v-20a2.666 2.666 0 0 1 2.667-2.667h8zm-1.334 16c-.736 0-1.333.597-1.333 1.333v5.333h2.667V20c0-.736-.597-1.333-1.333-1.333zm5.334 0c-.736 0-1.333.597-1.333 1.333v5.333h2.667V20c0-.736-.597-1.333-1.333-1.333zM8 18.667c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V20c0-.736-.597-1.333-1.333-1.333zm16 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V20c0-.736-.597-1.333-1.333-1.333zM8 12c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333C9.333 12.597 8.736 12 8 12zm5.333 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333c0-.736-.597-1.333-1.333-1.333zm5.334 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333c0-.736-.597-1.333-1.333-1.333zM24 12c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333c0-.736-.597-1.333-1.333-1.333zM8 5.333c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V6.666c0-.736-.597-1.333-1.333-1.333zm5.333 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V6.666c0-.736-.597-1.333-1.333-1.333z"></path></svg>
                        <h2>هتل های محبوب بیلیتیوم </h2>
                    </div>
                    <p>پناهگاهی از رفاه و زیبایی: هتل‌های ما، جایی که راحتی و شگفتی با یکدیگر تداخل پیدا می‌کنند</p>
                </div>
                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel" class="more-title-safiran">
                    <span>بیشتر</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"/>
                    </svg>
                </a>
            </div>
            <div>
                <div class="parent-ul-hotel col-lg-12 col-md-12 col-12">
                    <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab-hotel"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active"
                                    id="tab-hotel-dakheli"
                                    data-toggle="pill"
                                    data-target="#hotel-dakheli"
                                    type="button"
                                    role="tab"
                                    aria-controls="hotel-dakheli"
                                    aria-selected="true">داخلی
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link "
                                    id="tab-hotel-khareji"
                                    data-toggle="pill"
                                    data-target="#hotel-khareji"
                                    type="button"
                                    role="tab"
                                    aria-controls="hotel-khareji"
                                    aria-selected="false">خارجی
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="parent-tab-hotel">
                    <div class="tab-content" id="pills-tabContent-hotel">
                        <div class="__hotel__internal__ tab-pane fade show active" id="hotel-dakheli" role="tabpanel"
                             aria-labelledby="tab-hotel-dakheli">
                            <div class="owl-carousel owl-theme __hotel__internal__ owl-hotel-ghods">
                                {foreach $internal_hotels as $item}
                                <div class="__i_modular_nc_item_class_0 item">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="link-parent">
                                        <img alt="{$item['City']}" class="__image_class__"
                                             src="{$item['Picture']}" />
                                        <div class="text-hotel">
                                            <h3 class="__title_class__">{$item['Name']}</h3>
                                            <div class="star-hotel">
                                                {for $i = 1 to $item['StarCode']}
                                                    <i class="__star_class_light__1 fa-solid fa-star"></i>
                                                {/for}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                {/foreach}

                            </div>
                        </div>
                        <div class="__hotel__external__ tab-pane fade " id="hotel-khareji" role="tabpanel"
                             aria-labelledby="tab-hotel-khareji">
                            <div class="owl-carousel owl-theme __hotel__external__ owl-hotel-ghods">
                                {foreach $foregin_hotels as $item}
                                <div class="__i_modular_nc_item_class_0 item">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0" class="link-parent">
                                        <img alt="{$item['DepartureCityFa']}" class="__image_class__"
                                             src="assets/images/hotel/{$item['DepartureCode']}.jpg" />
                                        <div class="text-hotel">
                                            <h3 class="__title_class__">{$item['CountryFa']}</h3>
                                            <div class="star-hotel">
                                                {for $i=1 to $item['StarCode']}
                                                    <i class="__star_class_light__1 fa-solid fa-star"></i>
                                                {/for}
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
    </section>
{/if}