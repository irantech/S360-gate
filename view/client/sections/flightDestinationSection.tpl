<div class="masir-section sections">
    <div class="air_title">
        <h4> ##Highdestinations## </h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="owl-carousel owl_flight">

                {foreach $cities as $key=>$city}
                    <div class="item">
                        <div class="masir-item">
                            <span class="masir-head-text site-border-bottom-main-color"> ##FlightsFromOrigin## {$city['translated_departure_city']}</span>
                            <div class="masir-deses">

                                {$cities[$key] = null}
                                {$cities = $cities|array_filter}
                                {foreach $cities as $sub_cty}
                                    <div class="masir-des">
                                        <a href="javascript:;"
                                           onclick="ShowModalOfFlights('{$city['Departure_Code']}','{$sub_cty['Departure_Code']}','searchFlight')"
                                           data-toggle="modal"
                                           data-target="#exampleModalScrollable">
                                            <div class="des-name site-color-main-color-before">
                                                <span>{$city['translated_departure_city']}</span>
                                                <span>{$sub_cty['translated_departure_city']}</span>
                                            </div>
                                        </a>
                                    </div>
                                {/foreach}
                                {$cities = $duplicated_cities}

                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="ModalOfFifteenFlights"
     tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>