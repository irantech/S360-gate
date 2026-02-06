{assign var="params" value=['use_customer_db'=>true,'origin_city'=>'IKA','destination_city'=>['IKA','DXB','IST','CDG','YYZ','NJF','MHD']]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternationalFlight($params)}


<div class="section_special_flight">
    <div class="container">
        <div class="titr">جستجوی سریع پرواز</div>
        <div class="row">
            <div class="owl-carousel owl_4">
                {foreach $cities['sub_cities'] as $sub_city}
                <div class="item">
                    <div class="col_card  {$city['DepartureCode']}">
                        <section class="container_flights">

                                <div class="flightSearchBox" data-target="#calenderBox" data-toggle="modal"
                                     onclick="calenderFlightSearch('{$cities['main']['DepartureCode']}','{$sub_city['DepartureCode']}')">
                                    <span class="list-item">
                                        <a>
                                          بلیط هواپیما از مبدأ <i>{$cities['main']['DepartureCityFa']}</i> به<i>{$sub_city['DepartureCityFa']}  </i>
                                        </a>
                                    </span>
                                </div>

                        </section>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
