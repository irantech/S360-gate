{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['Count'=> '5', 'type' =>'internal' , 'star_code' => ['5']]}


{assign var='internal_hotels' value=$obj_main_page->getHotelWebservice($internal_hotel_params)}
<section class="special_hotel pb-3">
    <div class="container">
        <div class="special_hotel_box justify-content-center">
            <div class="col-lg-5 col-12">
                <h3>تخفیف های ویژه</h3>
                <h4>هتلاتو</h4>
                <div>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">

                    مشاهده بیشتر

                </a>
            </div>
            <div class="d-none d-lg-block col-lg-7 col-12">
                <div class='parent-discount-hotel'>
                    <div class="owl-carousel owl-theme __hotel__internal__ owl-hotel-ghods2">
                        {foreach $internal_hotels as $item}

                            {if $item['HotelIndex'] neq '13588'}
                                <div class="__i_modular_nc_item_class_0 item">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}" class="link-parent">
                                        <img class="__image_class__"  src="{$item['Picture']}"
                                             alt="{$item['City']}">
                                        <div class="text-hotel">
                                            <div class="star-hotel">
                                            {for $s=1 to $objHotel->infoHotel['hotel_starCode']}
                                                <i class="__star_class_light__1 fa-solid fa-star"></i>
                                            {/for}
                                            </div>
                                            <h3 class="__title_class__">{$item['Name']} </h3>
                                            <span class="__city_class__">{$item['City']}</span>
                                        </div>
                                    </a>
                                </div>
                            {/if}
                        {/foreach}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
