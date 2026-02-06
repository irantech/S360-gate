{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['Count'=> '5', 'type' =>'internal']}

{assign var='internal_hotels' value=$obj_main_page->getHotelWebservice($internal_hotel_params)}
{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity()}


{assign var="langVar" value=""}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="En"}
{else}
    {assign var="langVar" value="Fa"}
{/if}

<div class="section_hotel popular_destination_area">
    <div class="container">
        <ul class="nav nav-tabs" id="tabsHotel" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="Hotel_L-tab" data-toggle="tab" href="#Hotel_L"
                                    role="tab" aria-controls="Hotel_L" aria-selected="true">
                    ##domesticHotel##
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Hotel_F-tab" data-toggle="tab" href="#Hotel_F" role="tab"
                                    aria-controls="Hotel_F" aria-selected="false">
                    ##foreigneHotel##
                </a>
            </li>
        </ul>
        <div class="tab-content" id="tabsHotelContent">
            <div class="tab-pane fade show active" id="Hotel_L" role="tabpanel" aria-labelledby="Hotel_L-tab">
                <div class="row">
                    <div class="owl_4 owl-carousel">
                        {foreach $internal_hotels as $item}

                        <div class="item">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailHotel/api/{$item['HotelIndex']}">
                                <div class="single_destination">
                                    <div class="thumb">
                                        <img src="{$item['Picture']}"
                                                alt="{$item['City']}">
                                    </div>
                                    <div class="content">
                                        <p class="d-flex align-items-center">
                                            {$item['Name']}
                                        </p>
                                        <span class="d-flex align-items-center">
                                            {$item['City']}
                                        </span>
                                        {for $i = 0; $i < count($item['StarCode']); $i++}
                                            <div class="rating rating_{$item['StarCode']}">
                                                {for $star = 1; $star <= 5; $star++}
                                                    {if $star <= $item['StarCode']}
                                                        <i class="fa fa-star"></i>
                                                    {else}
                                                        <i class="fa fa-star-o"></i>
                                                    {/if}
                                                {/for}
                                            </div>
                                        {/for}

                                    </div>
                                </div>
                            </a></div>
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="tab-pane " id="Hotel_F" role="tabpanel" aria-labelledby="Hotel_F-tab">
                <div class="row">
                    <div class="owl_4 owl-carousel">
                        {foreach $foregin_hotels as $item}

                            <div class="item">
                                <a href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0">
                                    <div class="single_destination">
                                        <div class="thumb">
                                            <img src="assets/images/hotel/{$item['DepartureCode']}.jpg"
                                                 alt="{$item["DepartureCity$langVar"]}">
                                        </div>
                                        <div class="content">
                                            <p class="d-flex align-items-center">
                                                {$item["DepartureCity$langVar"]}
                                            </p>
{*                                            <span class="d-flex align-items-center">*}
{*                                            {$item['address']}*}
{*                                        </span>*}
{*                                            {for $i = 0; $i < count($item['star_code']); $i++}*}
{*                                                <div class="rating rating_{$item['star_code']}">*}
{*                                                    {for $star = 1; $star <= 5; $star++}*}
{*                                                        {if $star <= $item['star_code']}*}
{*                                                            <i class="fa fa-star"></i>*}
{*                                                        {else}*}
{*                                                            <i class="fa fa-star-o"></i>*}
{*                                                        {/if}*}
{*                                                    {/for}*}
{*                                                </div>*}
{*                                            {/for}*}

                                        </div>
                                    </div>
                                </a></div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
