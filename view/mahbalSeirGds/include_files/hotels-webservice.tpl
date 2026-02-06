{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="hotel_params_internal" value=['Count'=> '6', 'type' =>'internal']}
{assign var='hotel_internal' value=$obj_main_page->getHotelWebservice($hotel_params_internal)}
{if $hotel_internal}
    {assign var='check_general' value=true}
{/if}
{assign var="min_internal" value=0}
{assign var="max_internal" value=5}

{assign var="hotel_params_external" value=['Count'=> '6', 'type' =>'external']}
{assign var='hotel_external' value=$obj_main_page->getHotelWebservice($hotel_params_external)}
{if $hotel_external}
    {assign var='check_general' value=true}
{/if}
{assign var="min_external" value=0}
{assign var="max_external" value=5}

{if $check_general}
    <div class="i_modular_hotels_webservice section_hotel popular_destination_area">
        <div class="container">
            <ul class="nav nav-tabs" id="tabsHotel" role="tablist">
                <li class="nav-item">
                    <a aria-controls="Hotel_L" aria-selected="true" class="nav-link active show" data-toggle="tab"
                       href="#Hotel_L" id="Hotel_L-tab" role="tab">هتل داخلی</a>
                </li>
                <li class="nav-item">
                    <a aria-controls="Hotel_F" aria-selected="false" class="nav-link" data-toggle="tab" href="#Hotel_F"
                       id="Hotel_F-tab" role="tab">هتل خارجی</a>
                </li>
            </ul>
            <div class="tab-content" id="tabsHotelContent">
                <div aria-labelledby="Hotel_L-tab" class="tab-pane fade show active" id="Hotel_L" role="tabpanel">
                    <div class="row">
                        <div class="__hotel__internal__ owl-hotel owl-carousel">

                            {foreach $hotel_internal as $item}
                                {if $min_internal <= $max_internal}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}">
                                            <div class="single_destination">
                                                <div class="thumb">
                                                    <img alt="{$item['City']}" class="__image_class__"
                                                         src="{$item['Picture']}" />
                                                </div>
                                                <div class="content">
                                                    <p class="__title_class__ d-flex align-items-center">{$item['Name']}</p>
                                                    <span class="__city_class__ d-flex align-items-center">{$item['City']}</span>
                                                    <div class="__degree_class__ rating rating_5">{$item['StarCode']}</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    {$min_internal = $min_internal + 1}
                                {/if}
                            {/foreach}


                        </div>
                    </div>
                </div>
                <div aria-labelledby="Hotel_F-tab" class="tab-pane" id="Hotel_F" role="tabpanel">
                    <div class="row">
                        <div class="__hotel__external__ owl-hotel owl-carousel">

                            {foreach $hotel_external as $item}
                                {if $min_external <= $max_external}
                                    <div class="__i_modular_nc_item_class_0 item">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}">
                                            <div class="single_destination">
                                                <div class="thumb">
                                                    <img alt="{$item['City']}" class="__image_class__"
                                                         src="{$item['Picture']}" />
                                                </div>
                                                <div class="content">
                                                    <p class="__city_class__ d-flex align-items-center">{$item['City']}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    {$min_external = $min_external + 1}
                                {/if}
                            {/foreach}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}