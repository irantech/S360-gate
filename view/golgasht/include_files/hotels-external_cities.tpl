

{assign var='hotel_function_external_city' value=$obj_main_page->getExternalHotelCity()}
{if $hotel_function_external_city}
    {assign var='check_hotel' value=true}
{/if}
{assign var="min_external_external" value=0}
{assign var="max_external_external" value=5}

{if $check_hotel}
    <section class="i_modular_hotels_external_cities hotel-ghods py-5">
        <div class="container">
            <h2 class="title mb-5">هتل های لوکس </h2>
            <div data-aos="fade-up">
                <div class="__hotel_function__external__city__ parent-tab-hotel">

                    {foreach $hotel_function_external_city as $item}
                        {if $min_external_external <= $max_external_external}

                            <div class="__i_modular_nc_item_class_0">
                                <a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0">
                                    <img alt="{$item['DepartureCityFa']}" class="__image_class__" src="assets/images/hotel/{$item['DepartureCode']}.jpg"/>
                                    <div class="text-hotel">
                                        <div class="star-hotel">
                                            {for $i = 0; $i < count($item['StarCode']); $i++}<i class="__star_class_light__1 fa-solid fa-star"></i>{/for}




                                        </div>
                                        <h3 class="__title_class__">{$item['DepartureCityFa']}</h3>
                                        <span class="__city_class__">{$item['City']}</span>
                                    </div>
                                </a>
                            </div>

                            {$min_external_external = $min_external_external + 1}
                        {/if}
                    {/foreach}






                </div>
            </div>
        </div>
    </section>
{/if}