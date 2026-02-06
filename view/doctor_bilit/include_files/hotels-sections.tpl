{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['limit'=> '8', 'country' =>'internal']}
{assign var='hotel_internal' value=$obj_main_page->getHotelReservation($internal_hotel_params)}
{if $hotel_internal}
    {assign var='check_hotel' value=true}
{/if}


{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['limit'=> '8', 'country' =>'external']}
{assign var='hotel_external' value=$obj_main_page->getHotelReservation($internal_hotel_params)}
{if $hotel_external}
    {assign var='check_hotel' value=true}
{/if}
{if $check_hotel}
    <section class="i_modular_hotels_webservice hotel-ghods">
        <div class="container">
            <div class="title-demo">
                <div class="">
                    <h2>
                        هتل های داخلی
                    </h2>
                </div>
            </div>
            <div class="owl-carousel owl-theme __hotel__internal__ owl-hotel-ghods">
                {foreach $hotel_internal as $key=>$item}
                    <div class="__i_modular_nc_item_class_{$key} item">
                        <a class="link-parent"
                           href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/{$item['id']}/{$item['name_en']|strip:'-'}"
                        >
                            <img class="__image_class__"
                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['logo']}"
                                 alt="{$item['City']}">
                            <div class="text-hotel">
                                <div class="star-hotel">
                                    {for $i=1 to $item['star_code']}
                                        <i class="__star_class_light__1 fa-solid fa-star"></i>
                                    {/for}
                                </div>
                                <h3 class="__title_class__">{$item['name']}</h3>
                                <span class="__city_class__">{$item['city_name']}</span>
                            </div>
                        </a>
                    </div>
                {/foreach}
            </div>
            <a class="btn-more" href="https://192.168.1.100/gds/fa/page/hotel">

                هتل های بیشتر

                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </section>
{/if}