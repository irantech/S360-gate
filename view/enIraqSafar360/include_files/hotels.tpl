

{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{*{assign var="internal_hotel_params" value=['Count'=> '4', 'type' =>'internal']}*}
{assign var="external_hotel_params" value=['Count'=> '10']}


{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity($external_hotel_params)}
{*{assign var='internal_hotels' value=$obj_main_page->getHotelWebservice($internal_hotel_params)}*}

{if $foregin_hotels}
<section class="i_modular_hotels_webservice hotel-ghods">
    <img src="project_files/images/bg1.jpg" alt="img-bg" class="hotel-bg1">
    <div class="container" style="position: relative; z-index: 2">
        <div class="title-demo">
            <div class="text-title-demo">
                <h2>Hotels</h2>
                <p>
                    Comfort and enjoyment in the heart of urban landmarks, our hotel awaits your arrival
                </p>
            </div>
            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel" class="more-title-demo">
                <span>More Hotels</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
            </a>
        </div>
        <div>
            <div class="owl-carousel owl-theme __hotel__internal__ owl-hotel-ghods">
                {foreach $foregin_hotels as $item}
                <div class="item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0" class="__i_modular_nc_item_class_0 link-parent">
                        <img src="assets/images/hotel/{$item['DepartureCode']}.jpg"
                             alt="{$item['DepartureCityEn']}">
                        <div class="text-hotel">
                            {*
                               <div class="star-hotel">
                                   <i class="fa-solid fa-star"></i>
                                   <i class="fa-solid fa-star"></i>
                                   <i class="fa-solid fa-star"></i>
                                   <i class="fa-solid fa-star"></i>
                                   <i class="fa-solid fa-star"></i>
                               </div>
                               *}
                            <h3 class="__title_class__">{$item['DepartureCityEn']}</h3>
                            <span class="__city_class__">{$item['CountryEn']}</span>
                        </div>
                    </a>
                </div>
                {/foreach}
{*                {foreach $internal_hotels as $item}*}
{*                <div class="item">*}
{*                    <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="__i_modular_nc_item_class_1 link-parent">*}
{*                        <img src="{$item['Picture']}"*}
{*                             alt="{$item['City']}">*}
{*                        <div class="text-hotel">*}
{*                            *}{**}
{*                         <div class="star-hotel">*}
{*                             <i class="fa-solid fa-star"></i>*}
{*                             <i class="fa-solid fa-star"></i>*}
{*                             <i class="fa-solid fa-star"></i>*}
{*                             <i class="fa-solid fa-star"></i>*}
{*                             <i class="fa-solid fa-star"></i>*}
{*                         </div>*}
{*                         *}
{*                            <h3>{$item['Name']}</h3>*}
{*                            <span>{$item['City']}</span>*}
{*                        </div>*}
{*                    </a>*}
{*                </div>*}
{*                {/foreach}*}


            </div>




        </div>
    </div>
</section>
{/if}