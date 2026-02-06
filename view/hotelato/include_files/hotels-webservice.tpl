{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="hotel_params_internal" value=['Count'=> '5', 'type' =>'internal']}
{assign var='hotel_internal' value=$obj_main_page->getHotelWebservice($hotel_params_internal)}
{if $hotel_internal}
    {assign var='check_hotel' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=5}


{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity()}


{if $check_hotel}
    <section class="i_modular_hotels_webservice hotel-ghods mb-5 pb-5">
        <div class="container">
            <div>
                <div class="parent-ul-hotel col-lg-12 col-md-12 col-12">
                    <h3 class="title-hotel-new">هتل</h3>
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
                                                    <h3 class="__title_class__">{$item['Name']}</h3>
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

                    {foreach $foregin_hotels as $item}


                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0">
                                                <img alt="{$item['DepartureCityFa']}" class="__image_class__" src="assets/images/hotel/{$item['DepartureCode']}.jpg"/>
                                                <div class="text-hotel">
                                                    <h3 class="__title_class__">{$item['DepartureCityFa']}</h3>
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