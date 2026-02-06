{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="hotel_params_internal" value=['Count'=> '3', 'type' =>'internal']}
{assign var='hotel_internal' value=$obj_main_page->getHotelWebservice($hotel_params_internal)}
{if $hotel_internal}
    {assign var='check_hotel' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=3}


{assign var="hotel_params_external" value=['Count'=> '3', 'type' =>'external']}
{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity()}
{if $foregin_hotels || $hotel_internal}
    {assign var='check_hotel' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=3}

{if $check_hotel}
<div class="section_hotel popular_destination_area">
    <div class="container">
        <div class="titr">

            هتل های برگزیده

        </div>
        <ul class="nav nav-pills mb-3 ul-hotel" id="pills-hotel" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active btn-hotel" id="pills-in-tab" data-toggle="pill" data-target="#pills-in" type="button" role="tab" aria-controls="pills-in" aria-selected="true">هتل داخلی</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-hotel" id="pills-out-tab" data-toggle="pill" data-target="#pills-out" type="button" role="tab" aria-controls="pills-out" aria-selected="false">هتل خارجی</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-in" role="tabpanel" aria-labelledby="pills-in-tab">
                <div class="owl-hotel owl-carousel">
                    {foreach $hotel_internal as $item}
                      {if $min_internal <= $max_internal}
                        <div class="item">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}">
                                <div class="single_destination">
                                    <div class="thumb">
                                         <img alt="{$item['City']}" class="__image_class__" src="{$item['Picture']}"/>
                                    </div>
                                    <div class="content">
                                        <p class="d-flex align-items-center">
                                           {$item['Name']}
                                        </p>
                                        <span class="d-flex align-items-center">
                                          {$item['City']}
                                        </span>

                                    </div>
                                </div>
                            </a>
                        </div>
                     {$min_internal = $min_internal + 1}
                     {/if}
                     {/foreach}
                </div>
            </div>
            <div class="tab-pane fade" id="pills-out" role="tabpanel" aria-labelledby="pills-out-tab">
{*               {$foregin_hotels|var_dump}*}
                <div class="owl-hotel owl-carousel">
                    {foreach $foregin_hotels as $item}

                        <div class="item">
                            <a href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0">
                                <div class="single_destination">
                                    <div class="thumb">
                                        <img src="assets/images/hotel/{$item['DepartureCode']}.jpg"
                                             alt="{$item['DepartureCityFa']}">
                                    </div>
                                    <div class="content">
                                        <p class="d-flex align-items-center">
                                            {$item['DepartureCityFa']}
                                        </p>
                                        <span class="d-flex align-items-center">
                                    {$item['CountryFa']}
                                </span>
                                    </div>
                                </div>
                            </a>
                        </div>

                     {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
{/if}

