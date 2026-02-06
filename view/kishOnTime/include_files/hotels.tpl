{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['limit'=> '20', 'country' =>'internal']}
{assign var='internal_hotels' value=$obj_main_page->getHotelReservation($internal_hotel_params)}


{if $internal_hotels }
<div class="hotel-parent">
    <div class="container-fluid">
        <div class="col-xs-12 hotel-parent-title">هتلهای کیش</div>
        <div class="col-xs-12 padd-hotel-parent">
            <div class="slider-lastnews-parent slider-lastnews-items slide-tab3">
                <div class="owl-carousel owl-theme" id="owl-example3">


                    {foreach $internal_hotels as $item}
                    <div class="slider-lastnews-item item hotel-item">
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['logo']}"
                             alt="{$item['City']}" width="100%">
                        <a class="hotel-titr-parent" href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/{$item['id']}/{$item['name_en']|strip:'-'}">
                            <div class="star-parenr">
                                {for $i=1 to $item['star_code']}
                                <i aria-hidden="true" class="fa fa-star"></i>
                                {/for}
                            </div>
                            <div class="hotel-name"> {$item['name']}</div>
                            <div class="col-xs-12 hotel-titr">{$item['city_name']}</div>
                        </a>
                        </img></div>
                    {/foreach}


                </div>
            </div>
        </div>
    </div>
</div>
{/if}