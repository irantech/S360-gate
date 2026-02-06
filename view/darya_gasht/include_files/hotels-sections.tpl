{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_hotel_params" value=['limit'=> '8', 'country' =>'internal']}
{assign var="foregin_hotel_params" value=['limit'=> '5','country' =>'external']}

{assign var='internal_hotels' value=$obj_main_page->getHotelReservation($internal_hotel_params)}
{assign var='foregin_hotels' value=$obj_main_page->getExternalHotelCity()}

{if $internal_hotels || $foregin_hotels}
<section class="section_hotel popular_destination_area">
    <div class="container">
        <ul class="nav nav-tabs" id="tabsHotel" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="Hotel_L-tab" data-toggle="tab" href="#Hotel_L" role="tab" aria-controls="Hotel_L" aria-selected="true">هتل داخلی</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Hotel_F-tab" data-toggle="tab" href="#Hotel_F" role="tab" aria-controls="Hotel_F" aria-selected="false">هتل خارجی</a>
            </li>
        </ul>
        <div class="tab-content" id="tabsHotelContent">
            <div class="tab-pane fade show active" id="Hotel_L" role="tabpanel" aria-labelledby="Hotel_L-tab">
                <div>
                    <div class="owl-hotel owl-carousel">
                        {foreach $internal_hotels as $item}

                            <div class="item">
                                <a href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/{$item['id']}/{$item['name_en']|strip:'-'}">
                                    <div class="single_destination">
                                        <div class="thumb">
                                            <img  src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['logo']}"
                                                  alt="{$item['City']}">
                                        </div>
                                        <div class="content">
                                            <p class="d-flex align-items-center">{$item['name']}</p>
                                            <span class="d-flex align-items-center">{$item['city_name']}</span>
                                            <div class="rating rating_5">
                                                {for $i=1 to $item['star_code']}
                                                    <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/></svg></i>
                                                {/for}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        {/foreach}

                    </div>
                </div>
            </div>
            <div class="tab-pane " id="Hotel_F" role="tabpanel" aria-labelledby="Hotel_F-tab">
                <div>
                    <div class="owl-hotel owl-carousel">
                        {foreach $foregin_hotels as $item}
                            <div class="item">
                                <a href="{$smarty.const.ROOT_ADDRESS}/resultExternalHotel/{$item['CountryEn']}/{$item['DepartureCityEn']}/{$objDate->daysAfterToday('7')}/{$objDate->daysAfterToday('8')}/1/R:2-0-0">
                                    <div class="single_destination">
                                        <div class="thumb">
                                            <img src="assets/images/hotel/{$item['DepartureCode']}.jpg"
                                                 alt="{$item['DepartureCityFa']}">                                        </div>
                                        <div class="content">
                                            <p class="d-flex align-items-center">{$item['DepartureCityFa']}</p>
                                            <span class="d-flex align-items-center">{$item['city_name']}</span>
{*                                            <div class="rating rating_5">*}

{*                                                {for $i=1 to $item['star_code']}*}
{*                                                    <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/></svg></i>*}
{*                                                {/for}*}
{*                                            </div>*}
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
</section>
{/if}