{assign var="params" value=['limit'=>'7','is_group'=>true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
{assign var="foreign_cities" value=['IKA','DXBALL','ISTALL','KUL', 'MOWALL' , 'NJF' , 'TBS']}
{assign var="__local_max_var__" value=7}

<div class="i_modular_fast_search_flight fast-search-flight">
    <div class="container">
        <div class="titr">
            جستجوی سریع پرواز
        </div>
        <div class="row">
            <div class="owl-carousel owlFlightProposal">
                {assign var="i" value="1"}
                {foreach $cities['cities_flight'] as $city}
                    {if $i < $__local_max_var__ }
                        <div class="__i_modular_nc_item_class_0 item">
                            <div class="col_card">
                                <h3 class="title">بلیط هواپیما از مبدأ <i>{$city['main']['Departure_CityFa']} </i> به </h3>
                                <section class="container_flights">

                                    {foreach $city['sub_cities'] as $sub_city}
                                        <div class=" flightSearchBox" data-target="#calenderBox"
                                             data-toggle="modal"
                                             onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                                <span class="list-item">
                                                    <a>
                                                       {$sub_city['Departure_CityFa']}
                                                    </a>
                                                </span>
                                        </div>

                                    {/foreach}

                                </section>
                            </div>
                        </div>
                    {/if}
                    {$i =  $i + 1}
                {/foreach}

            </div>
        </div>
    </div>
</div>