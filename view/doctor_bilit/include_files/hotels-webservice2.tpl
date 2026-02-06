{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{load_presentation_object filename="reservationHotel" assign="objHotelCity"}
{assign var="list_city_hotel" value=$objHotelCity->cityHotelMain()}


{if $list_city_hotel}
    <section class="i_modular_hotels_webservice hotel-popular">
        <div class="container">
            <div class="title-demo">
                <div class="">
                    <h2>
                        محبوب ترین هتل ها
                    </h2>
                </div>
            </div>
            <div class='box-hotel-popular'>
                    {foreach $list_city_hotel as $key=>$item}
                    {if $key<4}
                        <a href="{$smarty.const.ROOT_ADDRESS}/searchHotel&type=new&city={$item['id']}&startDate={$objDate->jtoday()}&nights=15&rooms=R:2-0-0" class="link-parent">
                            <img alt="{$item['city_name']}" class="__image_class__"
                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/cityPic/{$item.city_name_en}.jpg" />
                            <div class="text-hotel">
                                <h3 class="__title_class__">هتل های {$item['city_name']}</h3>

                            </div>
                        </a>
                    {/if}
                {/foreach}
        </div>
    </section>
{/if}