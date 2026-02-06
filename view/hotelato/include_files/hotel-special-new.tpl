{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'','limit'=> '10','dateNow' => dateNow, 'country' =>'internal', 'special' => '0']}
{assign var='internalHotels' value=$obj_main_page->getHotelReservationMarketPlace($internal_tour_params)}
{assign var="foregin_hotel_params" value=['limit'=> '5','country' =>'external']}

{assign var='internal_hotels' value=$obj_main_page->getHotelReservationMarketPlace($internal_hotel_params)}
{assign var='foregin_hotels' value=$obj_main_page->getHotelReservationMarketPlace($foregin_hotel_params)}

{if count($internal_hotels)>0}
    <section class="i_modular_hotels_webservice hotel-ghods mt-5 pt-5 mb-5">
        <div class="container">
            <div>
                <div class="parent-ul-hotel col-lg-12 col-md-12 col-12">
                    <h3 class="title-hotel-new">هتل ویژه</h3>
                    <ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab-hotel" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button aria-controls="tour-dakheli-special" aria-selected="true" class="nav-link active" data-target="#hotel-dakheli-special" data-toggle="pill" id="tab-hotel-dakheli-special" role="tab" type="button">داخلی

                            </button>
                        </li>
{*                        <li class="nav-item" role="presentation">*}
{*                            <button aria-controls="tour-khareji-special" aria-selected="false" class="nav-link" data-target="#hotel-khareji-special" data-toggle="pill" id="tab-hotel-khareji-special" role="tab" type="button">خارجی*}

{*                            </button>*}
{*                        </li>*}
                    </ul>
                </div>
                <div class="parent-tab-hotel">
                    <div class="tab-content" id="pills-tabContent-hotel">
                        <div aria-labelledby="tab-hotel-dakheli-special" class="tab-pane fade show active" id="hotel-dakheli-special" role="tabpanel">
                            <div class="owl-carousel owl-theme __hotel__internal__ owl-hotel-ghods">

                                {foreach $internal_hotels as $item}

                                        <div class="__i_modular_nc_item_class_0 item">
                                            <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/{$item['id']}/{$item['name_en']|strip:'-'}">
                                                <img alt="{$item['city_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['logo']}"/>
                                                <div class="text-hotel">
                                                    <h3 class="__title_class__">{$item['name']}</h3>
                                                </div>
                                            </a>
                                        </div>


                                {/foreach}





                            </div>
                        </div>
                        <div aria-labelledby="tab-hotel-khareji-special" class="tab-pane fade" id="hotel-khareji-special" role="tabpanel">
                            <div class="owl-carousel owl-theme __hotel__external__ owl-hotel-ghods">

                    {foreach $foregin_hotels as $item}
                        <div class="__i_modular_nc_item_class_0 item">
                            <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/roomHotelLocal/reservation/{$item['id']}/{$item['name_en']|strip:'-'}">
                                <img alt="{$item['name_en']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['logo']}"/>
                                <div class="text-hotel">
                                    <h3 class="__title_class__">{$item['name']}</h3>
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