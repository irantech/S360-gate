<div aria-labelledby="flight-l-tab" class="__box__ tab-pane show active" id="Flight_internal" role="tabpanel">
    <div class="col-12">
        <div id="flight_dakheli">
            <form class="d-contents" data-action="https://s360online.iran-tech.com/" id="gds_local" method="post" name="gds_local" target="_blank">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
                        <div class="cntr">
                            <label for="rdo-10" class="btn-radio select-type-way-js" data-type='internal'>
                                <input  checked="" type="radio" id="rdo-10" name="select-rb2" value="1" class="internal-one-way-js">
                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                          class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                          class="outer"></path>
                                </svg>
                                <span>##Oneway##</span>
                            </label>
                            <label for="rdo-20"  class="btn-radio select-type-way-js mr-4" data-type='internal'>
                                <input type="radio" id="rdo-20" name="select-rb2" value="2" class="internal-two-way-js">
                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                          class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                          class="outer"></path>
                                </svg>
                                <span>##Twoway##</span>
                            </label>
                        </div>
                    </div>
                    {include file="./sections/Flight/internal/origin_selection.tpl"}
                    {include file="./sections/Flight/internal/destination_selection.tpl"}
                    {include file="./sections/Flight/internal/date_flight.tpl"}
                    {include file="./sections/Flight/internal/passenger_count.tpl"}
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                        <button class="btn theme-btn seub-btn b-0" onclick="searchFlight('internal')" type="button">
<span>

                                    جستجو

                                </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><div aria-labelledby="flight-f-tab" class="__box__ tab-pane" id="Flight_external" role="tabpanel">
    <div class="col-12">
        <div id="flight_khareji">
            <form class="d-contents" data-action="https://s360online.iran-tech.com/" id="gds_portal" method="post" name="gds_portal" target="_blank">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
                        <div class="cntr">
                            <label for="rdo-3" class="btn-radio select-type-way-js" data-type='international'>
                                <input checked="" class="multiselectportal international-one-way-js"
                                       type="radio" id="rdo-3" name="select-rb" value="1" '>
                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                          class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                          class="outer"></path>
                                </svg>
                                <span>##Oneway##</span>
                            </label>
                            <label for="rdo-4" class="btn-radio select-type-way-js mr-4" data-type='international'>
                                <input type="radio" class="multiselectportal international-two-way-js"
                                       id="rdo-4" name="select-rb" value="2" >
                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                          class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                          class="outer"></path>
                                </svg>
                                <span>##Twoway##</span>
                            </label>
                        </div>
                    </div>
                    {include file="./sections/Flight/international/origin_search_box.tpl"}
                    {include file="./sections/Flight/international/destination_search_box.tpl"}
                    {include file="./sections/Flight/international/date_flight.tpl"}
                    {include file="./sections/Flight/international/passenger_count.tpl"}
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                        <button onclick="searchFlight('international')" class="btn theme-btn seub-btn b-0" type="button"><span>جستجو</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>