{assign var="params" value=['limit'=>'7','is_group'=>true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
{assign var="foreign_cities" value=['IKA','DXBALL','ISTALL','KUL', 'MOWALL' , 'NJF' , 'TBS']}
{assign var="__local_max_var__" value=4}

<div class="i_modular_fast_search_flight section_fast">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-2 col-xs-12">
                <div class="tg-section-head">
                    <div class="tg-section-heading"><h2> مسیر های پرتردد</h2></div>
                </div>
            </div>

            {assign var="i" value="1"}
            {foreach $cities['cities_flight'] as $city}
            {if $i < $__local_max_var__ }
            <div class="col-md-4" data-aos-delay="100">
                <div class="col_card"><h3 class="title"> پرواز {$city['main']['Departure_CityFa']} به </h3>
                    <section class="container">
                        <ul>
                            {foreach $city['sub_cities'] as $sub_city}
                            <li class="flightSearchBox list-item" data-target="#calenderBox" data-toggle="modal"
                                onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                <a class="d-flex align-items-center justify-content-between">

                                    {$sub_city['Departure_CityFa']}

                                    <i class="far fa-chevron-left"></i>
                                </a>
                            </li>
                            {/foreach}
                        </ul>
                    </section>
                </div>
            </div>
            {/if}
                {$i =  $i + 1}
            {/foreach}

        </div>
    </div>
</div>