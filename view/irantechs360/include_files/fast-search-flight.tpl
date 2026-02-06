{assign var="params" value=['limit'=>'7','is_group'=>true]}
{assign var="cities" value=$obj_main_page->dataFastSearchInternalFlight($params)}
{assign var="langVar" value="Fa"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="En"}
{/if}

<div class="section_special_flight">
    <div class="container">
        <div class="titr">##fastSearchFlight##</div>
        <div class="owl-carousel owl_4">
                {foreach $cities['cities_flight'] as $city}
                <div class="item">
                    <div class="col_card  {$city['Departure_Code']}"><h3 class="title">##flightTicketFrom## <i>{$city['main']["Departure_City$langVar"]}</i> ##to## </h3>
                        <section class="container_flights">
                            {foreach $city['sub_cities'] as $sub_city}
                                <div class="flightSearchBox" data-target="#calenderBox" data-toggle="modal"
                                     onclick="calenderFlightSearch('{$city['main']['Departure_Code']}','{$sub_city['Departure_Code']}')">
                                    <span class="list-item">
                                        <a>
                                            {$sub_city["Departure_City$langVar"]}
                                        </a>
                                    </span>
                                </div>
                            {/foreach}
                        </section>
                    </div>
                </div>
                {/foreach}
            </div>
    </div>
</div>