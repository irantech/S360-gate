{assign var="params" value=['limit'=>'7','is_group'=>true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
<section class="Flight_sec">
    <div class="container">
        <h2 class="titel">جستجوی سریع پرواز</h2>
        <div class="Flight_sec_Owl owl-carousel owl-theme">
            {foreach $cities['cities_flight'] as $city}

                <div class="item">
                    <div class="Flight_box">
                        <h5>بلیط هواپیما از مبدأ  <span> {$city['main']['Departure_CityFa']} </span> به </h5>
                        <ul>
                            {foreach $city['sub_cities'] as $sub_city}
                                <li>
                                    <a data-target="#calenderBox" data-toggle="modal"
                                       onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                        <i class="far fa-plane"></i>  {$sub_city['Departure_CityFa']} <i class="fal fa-angle-right"></i>
                                    </a>
                                </li>
                            {/foreach}

                        </ul>
                    </div>
                </div>

            {/foreach}
        </div>
    </div>
</section>