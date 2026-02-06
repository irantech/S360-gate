{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="hotel_params_internal" value=['Count'=> '3', 'type' =>'internal']}
{assign var='hotel_internal' value=$obj_main_page->getHotelWebservice($hotel_params_internal)}
{if $hotel_internal}
    {assign var='check_hotel' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=3}


{assign var="hotel_params_external" value=['Count'=> '3', 'type' =>'external']}
{assign var='hotel_external' value=$obj_main_page->getHotelWebservice($hotel_params_external)}
{if $hotel_external}
    {assign var='check_hotel' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=3}

{if $check_hotel}
    <section class="i_modular_hotels_webservice hotel-ghods">
        <img alt="img-bg" class="hotel-bg1" src="project_files/images/bg1.jpg"/>
        <div class="container" style="position: relative; z-index: 2">
            <div class="title-demo">
                <div class="text-title-demo">
                    <h2>هتل های سفر یار گوهر توس</h2>
                    <p>

                        استراحت و لذت در قلب جاذبه‌های شهری، هتل ما منتظر حضور شماست

                    </p>
                </div>
                <a class="more-title-demo" href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                    <span>هتل های بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
                </a>
            </div>
            <div>
                <div class="parent-ul-hotel col-lg-12 col-md-12 col-12">
                    <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab-hotel" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button aria-controls="tour-dakheli" aria-selected="true" class="nav-link active" data-target="#hotel-dakheli" data-toggle="pill" id="tab-hotel-dakheli" role="tab" type="button">داخلی

                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button aria-controls="tour-khareji" aria-selected="false" class="nav-link" data-target="#hotel-khareji" data-toggle="pill" id="tab-hotel-khareji" role="tab" type="button">خارجی

                            </button>
                        </li>
                    </ul>
                </div>
                <div class="parent-tab-hotel">
                    <div class="tab-content" id="pills-tabContent-hotel">
                        <div aria-labelledby="tab-hotel-dakheli" class="tab-pane fade show active" id="hotel-dakheli" role="tabpanel">
                            <div class="owl-carousel owl-theme __hotel__internal__ owl-hotel-ghods">

                                {foreach $hotel_internal as $item}
                                    {if $min_internal <= $max_internal}

                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}">
                                                <img alt="{$item['City']}" class="__image_class__" src="{$item['Picture']}"/>
                                                <div class="text-hotel">
                                                    <div class="star-hotel">
                                                        {for $i = 0; $i < count($item['StarCode']); $i++}<i class="__star_class_light__1 fa-solid fa-star"></i>{/for}




                                                    </div>
                                                    <h3 class="__title_class__">{$item['Name']}</h3>
                                                    <span class="__city_class__">{$item['City']}</span>
                                                </div>
                                            </a>
                                        </div>

                                        {$min_internal = $min_internal + 1}
                                    {/if}
                                {/foreach}




                            </div>
                        </div>
                        <div aria-labelledby="tab-hotel-khareji" class="tab-pane fade" id="hotel-khareji" role="tabpanel">
                            <div class="owl-carousel owl-theme __hotel__external__ owl-hotel-ghods">

                                {foreach $hotel_external as $item}
                                    {if $min_external <= $max_external}

                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}">
                                                <img alt="{$item['City']}" class="__image_class__" src="{$item['Picture']}"/>
                                                <div class="text-hotel">
                                                    <div class="star-hotel">
                                                        {for $i = 0; $i < count($item['StarCode']); $i++}<i class="__star_class_light__1 fa-solid fa-star"></i>{/for}




                                                    </div>
                                                    <h3 class="__title_class__">{$item['Name']}</h3>
                                                    <span class="__city_class__">{$item['City']}</span>
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
            </div>
        </div>
    </section>
{/if}