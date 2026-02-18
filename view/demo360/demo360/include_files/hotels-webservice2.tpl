{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{load_presentation_object filename="reservationHotel" assign="objHotelCity"}
{assign var="list_city_hotel" value=$objHotelCity->cityHotelMain()}


{if $list_city_hotel}
    <section class="i_modular_hotels_webservice hotel-popular">
        <div class="container">
            <div class="title-demo">
                <div class="">
                    <h2>
                        <span class="square-title"></span>
                        <span>محبوب ترین هتل ها</span>
                    </h2>
                    <p>
                        پناهگاهی از رفاه و زیبایی: هتل‌های ما، جایی که راحتی و شگفتی با یکدیگر تداخل پیدا می‌کنند
                    </p>
                </div>
                <a class="__all_link_href__" href='{$smarty.const.ROOT_ADDRESS}/page/hotel'>
                        <span>
                            مشاهده همه
                        </span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
                </a>
            </div>
            <div class='box-hotel-popular'>
                    {foreach $list_city_hotel as $key=>$item}
                    {if $key<4}
                        <a href="{$smarty.const.ROOT_ADDRESS}/searchHotel&type=new&city={$item['id']}&startDate={$objDate->jtoday()}&nights=3&rooms=R:2-0-0" class="link-parent">
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