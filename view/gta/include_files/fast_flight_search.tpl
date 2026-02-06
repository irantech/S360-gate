{assign var="params" value=['limit'=>'7','is_group'=>true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
{assign var="foreign_cities" value=['IKA','DXBALL','ISTALL','KUL', 'MOWALL' , 'NJF' , 'TBS']}
{assign var="__local_max_var__" value=7}

<section class="i_modular_fast_search_flight search_flight d-flex">
    <div class="container">
        <div class="title-safiran">
            <div class="text-title-safiran">
                <h2>جستجوی سریع پرواز </h2>
            </div>
        </div>
        <div class="Flight_sec_Owl owl-carousel owl-theme">

            {assign var="i" value="1"}
            {foreach $cities['cities_flight'] as $city}
            {if $i < $__local_max_var__ }
            <div class="item">
                <div class="Flight_box {$city['Departure_Code']}">
                    <h5>بلیط هواپیما از مبدأ <span> {$city['main']['Departure_CityFa']} </span> به </h5>
                    <ul>
                        {foreach $city['sub_cities'] as $sub_city}

                            <li class="__final_destination_0 flightSearchBox"  data-target="#calenderBox" data-toggle="modal"
                                onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                <a >
                                    <i class="far fa-plane"></i>
                                    <span class="__destination__">
                        {$sub_city['Departure_CityFa']}
                    </span>
                                    <i class="fal fa-angle-left"></i>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            {/if}
                {$i =  $i + 1}
            {/foreach}
        </div>
    </div>
</section>