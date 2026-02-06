<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="resultTourLocal" assign="objResult"}
{load_presentation_object filename="comments" assign="objComments"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="dateTimeSetting" assign="dateTimeSetting"}

{$objResult->getInfoTourByIdTour($smarty.const.TOUR_ID)}

{assign var="sessionid" value=$objSession->getUserId()}
{assign var="allComments" value=$objComments->getComments('tour',$objResult->arrayTour['infoTour']['id_same'])}

{if !empty($sessionid)}
    {load_presentation_object filename="user" assign="objUser"}
    {assign var="profile" value=$objUser->getProfile({$objSession->getUserId()})}
{/if}

<!-- login and register popup -->
{assign var="useType" value="tour"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->

{assign var=tourTypeIdArray value=$objResult->arrayTour['infoTour']['tour_type_id']|json_decode:true}
{assign var=TourTravelProgram value=$objResult->listTourTravelProgram($objResult->arrayTour['infoTour']['id_same'])}
{assign var=TourTravelProgramData value=$TourTravelProgram['data']|json_decode:true}






{if 1|in_array:$tourTypeIdArray}
    {assign var="typeTourReserve" value="oneDayTour"}
{else}
    {assign var="typeTourReserve" value="noOneDayTour"}
{/if}
<div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Tourreservation##</h3>
        </div>
        <i class="separator donetoactive"></i>
        <div class="step active">
        <span class="flat_icon_airplane">
        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577" width="25"
             xmlns="http://www.w3.org/2000/svg">
    <g>
        <path d="m441 145.789h29v105h-29z"/>
        <path d="m60 85.789h-60v387.898l60-209.999z"/>
        <path d="m86.314 280.789-60 210h420.263l55-210z"/>
        <g>
            <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z"/>
            <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z"/>
            <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z"/>
        </g>
    </g>
</svg>

            </span>
            <h3>##PassengersInformation##</h3>

        </div>
        <i class="separator"></i>
        <div class="step " >
             <span class="flat_icon_airplane">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25">
    <g id="Contact_form" data-name="Contact form">
        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z"/>
        <path d="M21,29H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z"/>
        <path d="M21,39H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z"/>
        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z"/>
        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z"/>
        <path d="M21,19H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z"/>
        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z"/>
        <rect x="20" y="8" width="26" height="4"/>
        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z"/>
    </g>
</svg>
             </span>
            <h3> ##Approvefinal## </h3>
        </div>
        <i class="separator"></i>
        <div class="step" >
            <span class="flat_icon_airplane">
                <svg  enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25"
                      xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <g>
                            <path d="m497 91h-331c-8.28 0-15 6.72-15 15 0 8.27-6.73 15-15 15s-15-6.73-15-15c0-8.28-6.72-15-15-15h-91c-8.28 0-15 6.72-15 15v300c0 8.28 6.72 15 15 15h91c8.28 0 15-6.72 15-15 0-8.27 6.73-15 15-15s15 6.73 15 15c0 8.28 6.72 15 15 15h331c8.28 0 15-6.72 15-15v-300c0-8.28-6.72-15-15-15zm-361 210h-61c-8.28 0-15-6.72-15-15s6.72-15 15-15h61c8.28 0 15 6.72 15 15s-6.72 15-15 15zm60-60h-121c-8.28 0-15-6.72-15-15s6.72-15 15-15h121c8.28 0 15 6.72 15 15s-6.72 15-15 15zm250.61 85.61c-5.825 5.825-15.339 5.882-21.22 0l-64.39-64.4v47.57l25.61 25.61c5.85 5.86 5.85 15.36 0 21.22-5.825 5.825-15.339 5.882-21.22 0l-19.39-19.4-19.39 19.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l25.61-25.61v-47.57l-64.39 64.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l85.61-85.61v-53.78c0-8.28 6.72-15 15-15s15 6.72 15 15v53.78l85.61 85.61c5.85 5.86 5.85 15.36 0 21.22z"/>
                        </g>
                    </g>
                </svg>
            </span>
            <h3> ##TicketReservation## </h3>
        </div>
    </div>

    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr">06:00</div>

</div>

<div class="w-100 BaseTimelineBoth d-flex flex-wrap">
    <div class="col-md-9 col-padding-5  ">
        <div class="col-md-12 p-0  ">
        <div class="BaseTourBox">
            <div class="timeline site-border-main-color">
                <div class="LiDot  ">
                    <div class="headline">
                        <span class="title site-main-text-color">
                            {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                {$objResult->arrayTour['infoTour']['name_en']}
                            {else}
                                {$objResult->arrayTour['infoTour']['origin_city_name']}
                            {/if}


                            <i>(##Starttour##)</i>
                        </span>
                    </div>
                </div>
                {foreach $objResult->arrayTour['infoTourRout'] as $k=>$rout}
                    {assign var=vehicleTypeClassName value=$objFunctions->vehicleTypeClassName($objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'])}


                    <div class="event site-border-main-color  p-0">
                        <div class=" T-flight-info">
                            <div class=" first_child site-border-main-color ul-last-li-airline-img {$vehicleTypeClassName}">

                                <ul>
                                    <li class=" site-border-main-color">

                                        <span>
                                        {if $k eq 0}

                                            {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                {$objResult->arrayTour['infoTour']['name_en']}
                                                {else}
                                                {$objResult->arrayTour['infoTour']['origin_city_name']}
                                            {/if}
                                        {else}
                                            {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                {$objResult->arrayTour['infoTourRout'][$k-1]['name_en']}
                                                {else}
                                                {$objResult->arrayTour['infoTourRout'][$k-1]['destination_city_name']}
                                            {/if}
                                        {/if}
                                    </span>
                                    </li>
                                    <li>
                                        <span >
                                            {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                {$rout['name_en']}
                                                {else}
                                                {$rout['destination_city_name']}
                                            {/if}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="two_child  site-border-main-color ">
                            <div>
                                <span class="type site-main-text-color">
                                {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                ##Airline##
                                {else}
                                ##Passengercompany##
                                {/if}
                                </span>
                                <span class="bar">{$rout['airline_name']}</span>
                                </div>
                            </div>
                            {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                            <div class="three_child  site-border-main-color">
                            <div>
                                <span class="type site-main-text-color">economy</span>
                                <span class="bar">##Permissible## : {$objResult->arrayTour['infoTour']['free']}</span>
                          </div>
                           </div>
                           {/if}
                            <div class="four_child  site-border-main-color ">
                                <div class="departure  site-border-main-color">
                                <small>{$rout['exit_hours']}</small>
                                <span class="site-main-text-color">
                                  {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                ##FlightExactTime##
                                {else}
                                ##timeMove##
                                {/if}
                                </span>
                                </div>
                                <div class="amount">
                                <small>{$rout['hours']}</small>
                                 <span class="site-main-text-color">
                                 {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                ##FlightDuration##
                                {else}
                                ##Durationmovement##
                                {/if}
                                </span></div>
                            </div>

                            <span class="fa fa-arrow-down arrowsIcons"></span>
                            <span class="fa fa-arrow-down arrowsIcons"></span>
                        </div>
                    </div>
                    <div class="LiDot ">
                        <div class="headline">

                        <span class="title site-main-text-color">
                        {if $smarty.const.SOFTWARE_LANG eq 'en'}
                        {$objResult->arrayTour['infoTourRout'][$k]['name_en']}
                        {else}
                        {$objResult->arrayTour['infoTourRout'][$k]['destination_city_name']}

                        {/if}
                            {if $rout['night'] neq 0}
                               <i> ({{$rout['night']}} ##Night##)</i>
                            {else}
                                (##EndOfTravel##)
                            {/if}
                        </span>
                        </div>

                    </div>
                {/foreach}


            </div>
            </div>
        </div>

        {if $TourTravelProgramData.day[0].title !== '' && (!empty($TourTravelProgramData.day) || !empty($objResult->arrayTour['infoTour']['travel_program'])) }


            <div class="col-md-12 p-0">

                <div class="col-md-12 p-4 BaseTourBox">

            <div class="TourTitreDiv">
                <span>##Travelprogram##</span>
            </div>
                    {if empty($TourTravelProgramData.day)}
                        <section class="site-bg-color-border-b">
                            <div>
                                {$objResult->arrayTour['infoTour']['travel_program']}
                            </div>
                        </section>
                    {else}
                        <section class="timeline-type2 site-bg-color-border-b">
                            <div class="container p-0">
                                {assign var=TourTravelProgramCounter value=1}
                                {foreach $TourTravelProgramData.day as $TourTravelProgramDay}
                                    <div class="timeline-type2-item">

                                        <div class="timeline-type2-img"></div>

                                        <div class="timeline-type2-content timeline-type2-card">
                                            <div class="timeline-type2-img-header">
                                                <div class="owl-carousel TourTravelProgramGallery1">
                                                    {foreach $TourTravelProgramDay.gallery as $TourTravelProgramGallery}
                                                        <div class="item_tour">
                                                            <div class="date">{$TourTravelProgramGallery.title}</div>
                                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$TourTravelProgramGallery.file}"
                                                                alt="{$TourTravelProgramGallery.title}">
                                                        </div>
                                                    {/foreach}
                                                </div>
                                                <div class="FlatTitle">
                                                    <h2>##Day## {$TourTravelProgramCounter}</h2>
                                                    <span>{$TourTravelProgramDay['title']}</span>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="bodyDiv NewScrollType1">

                                                    {$TourTravelProgramDay['body']}

                                                </div>
                                                <span class="btn_more_t">##Moredetail##</span>
                                            </div>

                                        </div>

                                    </div>
                                    {$TourTravelProgramCounter = $TourTravelProgramCounter+1}
                                {/foreach}

                            </div>
                        </section>
                    {/if}
                </div>


            </div>
        {/if}
        <form action="" method="post" id="formReservationTour">
        <input id="tourCode" name="tourCode" type="hidden" value="{$objResult->arrayTour['infoTour']['tour_code']}">
        <input id="tour_id" name="tour_id" type="hidden" value="{$smarty.const.TOUR_ID}">

                        <input type="hidden" id="cities" name="cities"
                               value="{$objResult->arrayTour['destination_cities']}">
                        <input type="hidden" id="serviceTitle" name="serviceTitle"
                               value="{$objResult->arrayTour['serviceTitle']}">
<input type="hidden" value="{$tour['startDate']} | {$tour['endDate']}"
                                               name="selectDate" id="selectDate">



<input type="hidden" id="prepaymentPercentage" name="prepaymentPercentage"
       value="{$objResult->arrayTour['infoTour']['prepayment_percentage']}">
<input type="hidden" id="totalOriginPrice" name="totalOriginPrice" value="0">
<input type="hidden" id="totalPrice" name="totalPrice" value="0">
<input type="hidden" id="totalPriceA" name="totalPriceA" value="0">
<input type="hidden" id="paymentPrice" name="paymentPrice" value="0">
<input type="hidden" id="passengerCount" name="passengerCount" value="0">
<input type="hidden" id="passengerCountADT" name="passengerCountADT" value="0">
<input type="hidden" id="passengerCountCHD" name="passengerCountCHD" value="0">
<input type="hidden" id="passengerCountINF" name="passengerCountINF" value="0">
<input type="hidden" id="countRoom" name="countRoom" value="">

<input type="hidden" value="{$objResult->arrayTour['infoTour']['tour_code']}" id="tourCode" name="tourCode">
<input type="hidden" value="{$smarty.const.TOUR_ID}" id="tour_id" name="tour_id">
<input type="hidden" value="{$typeTourReserve}" id="typeTourReserve" name="typeTourReserve">

     <div class="col-md-12 p-0 " id="TourPackagesList">
        <div class="TourTitreDiv ">

            <span>...</span>
        </div>
    </div>
    </form>
<!--       <div class="col-md-12 p-0 BaseTourBox">
            <div class="TourTitreDiv ">
                <span>##Rate##</span>
            </div>
            <div class="col-md-12 d-flex justify-content-center">

            <div class="mx-auto rater" >

            </div>
            </div>
        </div>-->

        <div class="col-md-12 p-0 BaseTourBox">
            <div class="TourTitreDiv ">
                <span>##Share##</span>
            </div>
            <div class="col-md-12 py-2 d-flex justify-content-center">

            <!-- Social Sharing icons from http://sharingbuttons.io-->

<!-- Sharingbutton Facebook -->
<button type="button" data-sharer="facebook"
         class="btn share_js resp-sharing-button text-white resp-sharing-button--facebook resp-sharing-button--small">
    <div aria-hidden="true" class="font-20 fa fa-facebook resp-sharing-button__icon resp-sharing-button__icon--solid">

    </div>
</button>

<!-- Sharingbutton Twitter -->
<button type="button" data-sharer="twitter"
         class="btn share_js resp-sharing-button text-white resp-sharing-button--twitter resp-sharing-button--small">
    <div aria-hidden="true" class="font-20 fa fa-twitter resp-sharing-button__icon resp-sharing-button__icon--solid">

    </div>
</button>



<!-- Sharingbutton E-Mail -->
<button type="button" data-sharer="email"
         class="btn share_js resp-sharing-button text-white resp-sharing-button--email resp-sharing-button--small">
    <div aria-hidden="true" class="font-20 fa fa-envelope resp-sharing-button__icon resp-sharing-button__icon--solid">

    </div>
</button>


<!-- Sharingbutton LinkedIn -->
<button type="button" data-sharer="linkedin"
         class="btn share_js resp-sharing-button text-white resp-sharing-button--linkedin resp-sharing-button--small">
    <div aria-hidden="true" class="font-20 fa fa-linkedin resp-sharing-button__icon resp-sharing-button__icon--solid">

    </div>
</button>


<!-- Sharingbutton WhatsApp -->
<button type="button" data-sharer="whatsapp"
         class="btn share_js resp-sharing-button text-white resp-sharing-button--whatsapp resp-sharing-button--small">
    <div aria-hidden="true" class="font-20 fa fa-whatsapp resp-sharing-button__icon resp-sharing-button__icon--solid">

    </div>
</button>



<!-- Sharingbutton Telegram -->
<button type="button" data-sharer="telegram"
         class="btn share_js resp-sharing-button text-white resp-sharing-button--twitter resp-sharing-button--small">
    <div aria-hidden="true" class="font-20 fa fa-telegram resp-sharing-button__icon resp-sharing-button__icon--solid">

    </div>
</button>



            </div>
        </div>

<div class="col-md-12 p-2 BaseTourBox BaseTourBox_documents ">

    <ul class="nav nav-pills mb-3 m-0" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-document-tab" data-toggle="pill" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="true">
                ##Documents##
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-cancelRule-tab" data-toggle="pill" href="#pills-cancelRule" role="tab" aria-controls="pills-cancelRule" aria-selected="false">
                ##Cancelrule##
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-Regulation-tab" data-toggle="pill" href="#pills-Regulation" role="tab" aria-controls="pills-Regulation" aria-selected="false">
                ##Regulation##
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-Description-tab" data-toggle="pill" href="#pills-Description" role="tab" aria-controls="pills-Description" aria-selected="false">
               ##Description##
            </a>
        </li>
    </ul>
    <div class="tab-content m-0 bg-light d-block" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-document" role="tabpanel" aria-labelledby="pills-document-tab">
            {$objResult->arrayTour['infoTour']['required_documents']}
        </div>
        <div class="tab-pane fade" id="pills-cancelRule" role="tabpanel" aria-labelledby="pills-cancelRule-tab">
            {$objResult->arrayTour['infoTour']['cancellation_rules']}
        </div>
        <div class="tab-pane fade" id="pills-Regulation" role="tabpanel" aria-labelledby="pills-Regulation-tab">
            {$objResult->arrayTour['infoTour']['rules']}
        </div>
        <div class="tab-pane fade" id="pills-Description" role="tabpanel" aria-labelledby="pills-Description-tab">
            {$objResult->arrayTour['infoTour']['description']}
        </div>
    </div>
</div>

    </div>
    <div class="col-md-3 col-padding-5  tour_search_parrnet ">
    <div class="BaseTourBox_1">

        <div class=" BaseTourBox ">
            <div class="container">
                <div class="row">
                    <div class="w-100">
                        <div class="pricing-BaseLabel w-100">
                            <div class="pricing-label w-100">##TourInformation##</div>
                        </div>

                        <div class="pricing-table col-md-12">

                            <h2 class="mb-3 site-main-text-color">{$objResult->arrayTour['infoTour'][$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'tour_name')]}</h2>
                            <h5 class="mb-3">{$objResult->arrayTour['infoTour']['night']} ##Night##
                                - {$objResult->arrayTour['infoTour']['day']} ##Day## </h5>
                            <div class="pricing-features NewScrollType1">
                                <div class="feature site-border-main-color">
                                    ##codeTour##<span>{$objResult->arrayTour['infoTour']['tour_code']}</span></div>


                                <div class="feature site-border-main-color">
                                    ##Insurance##<span>{if $objResult->arrayTour['infoTour']['insurance'] eq 'yes'}##Have##{else}##Donthave##{/if}</span>
                                </div>

                                {if $objResult->arrayTour['infoTour']['tour_type'] neq ''}
                                     <div class="feature site-border-main-color">
                                        ##Type##<span>{$objResult->arrayTour['infoTour']['tour_type']}</span>
                                    </div>
                                {/if}

                                {if $objResult->arrayTour['infoTour']['tour_reason'] neq ''}
                                    <div class="feature site-border-main-color">
                                        ##Special##<span>{$objResult->arrayTour['infoTour']['tour_reason']}</span></div>
                                {/if}


                                {if 1|in_array:$tourTypeIdArray}
                                    <div class="feature site-border-main-color">
                                        ##Destinationht##<span>{$objResult->arrayTour['destination_region_name']}</span>
                                    </div>


                                {/if}






                                 <div class="feature site-border-main-color">
                                    ##TourLeaderLanguage## <span>{if $objResult->arrayTour['infoTour']['tour_leader_language'] eq ''} {$objResult->arrayTour['infoTour']['language']} {else} {$objResult->arrayTour['infoTour']['tour_leader_language']} {/if}</span></div>



                                {if !empty($objResult->arrayTour['infoTour']['tour_file'])}
                                    <a class="feature btn d-block text-center btn-outline-warning mt-2"
                                     href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$objResult->arrayTour['infoTour']['tour_file']}'>
                                    <div class="">
                                        ##PackageTour##
                                        <span>

                                        </span>
                                    </div></a>
                                {/if}
                            </div>

                            {if $objResult->arrayTour['infoTour']['tour_services'] neq ''}
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3">
                                    <div class="pricing-label w-100 site-bg-main-color">##TourServices##</div>
                                </div>
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3 text-center">
                                    {foreach explode(',',$objResult->arrayTour['infoTour']['tour_services']) as $tour_service}
                                        <div class="badgeType3 display-inline-block">{{$tour_service}}</div>
                                    {/foreach}
                                </div>
                            {/if}
                            {if $objResult->arrayTour['infoTour']['tour_status'] neq ''}
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3">
                                    <div class="pricing-label w-100 site-bg-main-color">##TourStatus##</div>
                                </div>
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3 text-center">

                                    <div class="badgeType3 display-inline-block">
                                        ##{$objResult->arrayTour['infoTour']['tour_status']}##
                                    </div>

                                </div>
                            {/if}
                            {if $objResult->arrayTour['infoTour']['tour_difficulties'] neq ''}
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3">
                                    <div class="pricing-label w-100 site-bg-main-color">##TourDifficulties##</div>
                                </div>
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3 text-center">
                                    <div class="badgeType3 display-inline-block">
                                        {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'easy' } ##Easy## {/if}
                                        {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'average' } ##Average## {/if}
                                        {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'hard' } ##Hard## {/if}
                                        {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'very_hard' } ##VeryHard## {/if}
                                    </div>
                                </div>
                            {/if}
                            {if $objResult->arrayTour['infoTour']['age_categories'] neq ''}
                                {assign var=age_categories value=$objResult->arrayTour['infoTour']['age_categories']|json_decode:true}
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3">
                                    <div class="pricing-label w-100 site-bg-main-color">##AgeAverage##</div>
                                </div>
                                <div class="pricing-BaseLabel col-md-12 p-0 w-100 mb-3 text-center">
                                     {foreach $age_categories as $val}
                                        <div class="badgeType3 display-inline-block">
                                                {if $val == 'AgeCategories_Young'}##Young2Years##{/if}
                                                {if $val == 'AgeCategories_Children'}##Children12Years##{/if}
                                                {if $val == 'AgeCategories_Teenager'}##Teenagers18Years##{/if}
                                                {if $val == 'AgeCategories_Adult'}##Adults50Years##{/if}
                                                {if $val == 'AgeCategories_UltraAdult'}##Adults100Years##{/if}
                                        </div>
                                    {/foreach}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <div class="w-100 box_reserve_tour ">
        <div class=" BaseTourBox">
                <div class="container">
                    <div class="row">
                        <div class="w-100">
                            <div class="pricing-BaseLabel w-100">
                                <div class="pricing-label w-100">##TourDates##</div>
                            </div>
                            <div class="pricing-table col-md-12">
                                <!-- Table Head -->

                                <div class="w-100">
                                    <div id="TourDatesList" class="owl-carousel float-right">


                                        {assign var="TourDateCounter" value=1}
                                        {foreach $objResult->arrayTour['arrayDate'] as $k=>$tour}
                                            <div class="col_t_price {if $TourDateCounter == 1} active_col_today {/if}"
                                                 onclick="callFunctionResultTourPackage('{$tour['startDate']} | {$tour['endDate']}',$(this))">
                                                <div>
                                                    <a>
                                                        <div class="lowest-date">
                                                            <span class="ld-d">{$tour['startDate']}</span>


                                                        </div>
                                                        <span class="s_price">{$tour['endDate']}</span>
                                                    </a>
                                                </div>
                                            </div>
                                            {assign var="TourDateCounter" value=$TourDateCounter+1}
                                        {/foreach}


                                    </div>
                                </div>

                                {assign var="price" value=$objResult->calculateDiscountedPrices($objResult->arrayTour['infoTour']['discount_type'], $objResult->arrayTour['infoTour']['discount'],$objResult->arrayTour['infoTour']['min_price_r'])}
                                {assign var="arrayTourType" value=$objResult->arrayTour['tour_type_id']|json_decode:true}
                                <div class="col-md-12 w-100 price_reserve_box main-fixed-bottom-js">



                                <span class="amount">



                                {if '1'|in_array:$arrayTourType}
                                    {assign var="oneDayTour" value='yes'}
                                {else}
                                    {assign var="oneDayTour" value='no'}
                                {/if}
                                    {assign var="minPrice" value=$objResult->minPriceHotelByIdTourR($objResult->arrayTour['infoTour']['id'],$oneDayTour)}



{*                                    {$minPrice['minPriceR']|number_format} </b> ##Rial##*}



                                </span>

                               <span data-name="prepaymentPercentageValue" class="d-none justify-content-center flex-wrap prepayment">
                                    ##Prereserve## :
                                    <span class="px-1" ></span>
                                </span>

                                      <a id="buttonReserve" onclick="reserveTour()" class=" p-2 btn site-bg-main-color">
                                <span>##Reservation##  <i class="zmdi zmdi-chevron-left"></i></span>

                                <i class="zmdi zmdi-shopping-cart cart_booking_ "></i>

                                </a>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>




    </div>
    </div>
    </div>
</div>

    <div class="col-md-12 p-0 BaseTourBox commentBox">
         <div class="TourTitreDiv ">
            <span>##Writeyourcomment##</span>
        </div>

        <form class="SubmitNewComment">
            <input type="hidden" name="sessionid" value="{$sessionid}">
            <input type="hidden" name="parent_id" value="0">
            <input type="hidden" name="tour_id" value="{$objResult->arrayTour['infoTour']['id_same']}">
            <input type="hidden" name="flag" value="SubmitNewComment">
            <input type="hidden" name="section" value="tour">
              <div class="form-row">
                <div class="col">
                <label for="name">##Name## </label>
                  <input type="text"
                   {if !empty($sessionid)}
                    value="{$profile['name']}" disabled
                   {/if}
                   class="form-control" id="name" name="name" placeholder="##Example## : ##Hossein##">
                </div>

                <div class="col">
                <label for="family">##Family##</label>
                  <input type="text"
                   {if !empty($sessionid)}
                    value="{$profile['family']}" disabled
                   {/if}
                   class="form-control" id="family" name="family" placeholder="##Example## : ##Mohammadi##  ">
                </div>

                <div class="col">
                <label for="email">##Email##</label>
                  <input type="email"
                   {if !empty($sessionid)}
                    value="{$profile['email']}" disabled
                   {/if}
                   class="form-control" id="email" name="email" placeholder="{*##Email##*} ##Example## : info@example.com">
                </div>
              </div>

               <div class="form-row mb-3">
                <div class="col">


                  <textarea class="form-control" id="text_nazar" name="text" placeholder="{*##Body##*} ##Writeyourcomment## ... "></textarea>
                </div>

              </div>
              <div class="form-row mb-3">

               <div class="col btnSubmitCommentBox">
                  <button type="submit"class=" btn site-bg-main-color">##SubmitNewComment##</button>
               </div>

              </div>
            </form>
 <div class="col-md-12 ">


            <div class="col-md-12 p-0 pt-2 BaseCommentsBox">
            <ul class="timeline pt-0 mb-4 col-md-12 site-border-main-color">
                {foreach $allComments as $item}
                <li class="event LiDot col-md-12 mb-2">

                    <div class="col-md-12 p-0 mb-2 commentBox">
                    <div class="">
                        <span class=" d-flex comment-name"><i class="flat_user"></i>{$item.name}</span>
                        <span class="comment-date "> <i>##postagedate## </i> {$dateTimeSetting->jdate('Y-m-d ( H:i )',$item.created_at,'','','en')}</span>
                        </div>
                        <p class="w-100 d-block comment-text">{$item.text}</p>
                    </div>

                    {assign var="allCommentsReply" value=$objComments->getCommentsReply('tour',$objResult->arrayTour['infoTour']['id_same'],$item.id)}
{if !empty($allCommentsReply)}
                    <ul class="timeline pt-0 mb-2 col-md-12 site-border-main-color">
                    {foreach $allCommentsReply as $itemReply}
                <li class="event LiDot col-md-12 mb-2">
                    <div class="col-md-12 p-0 commentBox">
                    <div class="">
                        <span class="d-flex comment-name"><i class="flat_user"></i>{$itemReply.name}</span>
                        <span class="comment-date "> <i>##postagedate##</i> {$dateTimeSetting->jdate('Y-m-d ( H:i )',$itemReply.created_at,'','','en')}</span>
                       </div>
                        <p class="w-100 d-block comment-text">{$itemReply.text}</p>
                    </div>
                    </li>
                {/foreach}
                </ul>
                {/if}

                <button data-parent="{$item.id}" class="btn CommendReplyBtn site-bg-main-color">
                <span class="fa fa-reply"></span> ##Response##  </button>

                    </li>
                {/foreach}
                </ul>
            </div>

        </div>
         </div>



 {*<div class="w-100 BaseTimelineBoth  d-flex flex-wrap">


       <div class="sticky-top top-30 mb-4 BaseTourBox">
                <div class="container">
                    <div class="row">
                        <div class="w-100">
                            <div class="pricing-BaseLabel w-100">
                                <div class="pricing-label w-100">##TourDates##</div>
                            </div>
                            <div class="pricing-table col-md-12">
                                 awda wd
                            </div>
                        </div>
                    </div>
                </div>
            </div>


</div>*}


{*{if !empty($objResult->arrayTour['suggestionTours'])}

<div class="col-md-12 BaseTourBox">
    <div class="TourTitreDiv ">
        <span>##SuggestedToursFrom##
        <span class="text-primary">{$objResult->arrayTour['infoTour']['origin_city_name']}</span></span>
    </div>

{foreach $objResult->arrayTour['suggestionTours'] as $suggestionTour}
<div class="col-md-3 font-13 mb-2">

<a class="text-dark " href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$suggestionTour['id']}/{$suggestionTour['tour_name_en']}"
                                   target="_blank">
<div class="col-md-12 p-2 text-center bg-warning rounded ">
{$suggestionTour['tour_name']}
</div>
</a>
</div>

{/foreach}

</div>
{/if}*}

<div class="content-ditail2">







<!-- Modal Filter -->
<div class="modal fade" id="filter_tour" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">##advancedsearch##</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="mdi mdi-close" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-xs-12 col_filter">
                        <span class="filter-title site-main-text-color">##Namehotel##</span>
                        <div class="filter-content_tour ">
                            <input type="text" placeholder="##Namehotel##" id="inputSearchHotelName" name="inputSearchHotelName">
                            <i class="fa fa-search fa-stack-1x form-hotel-item-searchHotelName-i site-main-text-color"></i>
                        </div>
                    </div>

                    <input type="hidden" name="inputSearchHotelStar" id="inputSearchHotelStar">
                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span  class="filter-title site-main-text-color">  ##Starhotel##</span>
                            <div class="filter-content padb0">
                                <span class="event_star star_big mt-4" data-starnum="0"><i></i></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="inputSearchHotelMinPrice" id="inputSearchHotelMinPrice" value="">
                    <input type="hidden" name="inputSearchHotelMaxPrice" id="inputSearchHotelMaxPrice" value="">
                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color" > ##Price## (##Rial##)</span>
                            <div class="filter-content padb0">
                                <div class="filter-price-text">
                                    <span> <i></i> ##Rial##</span>
                                    <span> <i></i> ##Rial##</span>
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color">  ##Line##</span>
                            <div class="filter-content padb0">
                                <select class="js-example-basic-multiple select2"
                                        name="inputSearchHotelType[]" id="inputSearchHotelType" multiple="multiple">
                                    <option value="all">##All##</option>
                                    <option value="1">##Hotel##</option>
                                    <option value="2">##HotelApartments##</option>
                                    <option value="3">##Guesthouse##</option>
                                    <option value="4">##traditionalhouse##</option>
                                    <option value="5">##Traditionalhotel##</option>
                                    <option value="6">##Ecotourismresort##</option>
                                    <option value="7">##ForestHotel##</option>
                                    <option value="8">##RecreationalCulturalComplex##</option>
                                    <option value="9">##Boardinghouse##</option>
                                    <option value="10">##Motel##</option>
                                    <option value="12">##Villa##</option>
                                    <option value="13">##Inn##</option>
                                    <option value="14">##Residentialcomplex##</option>
                                    <option value="15">##Localhome##</option>
                                    <option value="16">##HotelVilla##</option>
                                    <option value="100">##Hostel##</option>
                                    <option value="101">##Boutique##</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
                    {$objBasic->showFacilities()}
                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color">  ##PossibilitiesHotel##</span>
                            <div class="filter-content padb0">
                                <select class="js-example-basic-multiple select2"
                                        name="inputSearchHotelFacilities[]" id="inputSearchHotelFacilities" multiple="multiple">
                                    {foreach $objBasic->listFacilities as $facilities}
                                        <option value="{$facilities['id']}">{$facilities['title']}</option>
                                        <option value="{$facilities['id']}">{$facilities['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 col-xs-12 col_filter col_filter_search">
                    <a class="btn site-bg-main-color site-secondary-text-color btn_search"
                       onclick="setFilterHotel();return false;">##Search##</a>
                </div>

            </div>
        </div>
    </div>
</div>

<form method="post" id="formHotel" action="" target="_blank">
    <input type="hidden" name="isShowReserve" id="isShowReserve" value="no">
</form>
{assign var="ArrayDate_FirstArray" value=reset($objResult->arrayTour['arrayDate'])}
<script type="text/javascript">
    {*getResultTourPackage('{$objResult->arrayTour['infoTour']['tour_code']}', '{$objResult->arrayTour['infoTour']['start_date']}', '{$typeTourReserve}');*}
    getResultTourPackage_newView('{$smarty.const.TOUR_ID}','{$objResult->arrayTour['infoTour']['tour_code']}', '{$ArrayDate_FirstArray['startDate']}','{$ArrayDate_FirstArray['endDate']}', '{$typeTourReserve}');
</script>


{literal}

    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">
  /*  $('.counter').counter({});

    $('.counter').on('counterStop', function () {
        $('.lazy_loader_flight').slideDown({
            start: function () {
                $(this).css({
                    display: "flex"
                })
            }
        });

    });*/
</script>

    <script>
        $(function(){
            $('.event_star').voteStar({
                callback: function(starObj, starNum){
                    $('#inputSearchHotelStar').val(starNum);
                }
            });
        });

        $(function () {
            $("#slider-range").slider({
                range: true,
                min:   parseInt($('#inputSearchHotelMinPrice').val()),
                max:  parseInt($('#inputSearchHotelMaxPrice').val()),
                step: 1000,
                animate: false,
                values: [parseInt($('#inputSearchHotelMinPrice').val()), parseInt($('#inputSearchHotelMaxPrice').val())],
                slide: function (event, ui) {

                    var minRange = ui.values[0];
                    var maxRange = ui.values[1];

                    $('#inputSearchHotelMinPrice').val(minRange);
                    $('#inputSearchHotelMaxPrice').val(maxRange);

                    $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                    $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

                }
            });
        });

        function setFilterHotel() {

            let hotelNameSearch = $('#inputSearchHotelName').val();
            let starSearch = parseInt($('#inputSearchHotelStar').val());
            let minPriceSearch = parseInt($('#inputSearchHotelMinPrice').val());
            let maxPriceSearch = parseInt($('#inputSearchHotelMaxPrice').val());
            let facilitiesSearch = $('#inputSearchHotelFacilities').val();
            let hotelTypeSearch = $('#inputSearchHotelType').val();

            let listPackage = $('.divTableRow');
            listPackage.hide().filter(function () {

                let flagSearchHotelName = true;
                let flagSearchHotelStar = true;
                let flagSearchTypeSearch = true;
                let flagSearchFacilities = true;
                let flagSearchPrice = true;

                let listHotel = $(this).find(".divTableCell .packageinfo");
                listHotel.each(function () {

                    if (hotelNameSearch != ''){
                        let hotelName = $(this).data("hotelname");
                        let searchName = hotelName.indexOf(hotelNameSearch);
                        if (searchName > -1){
                            flagSearchHotelName = true;
                        } else {
                            flagSearchHotelName = false;
                        }
                    }

                    if (starSearch > 0){
                        let hotelStar = parseInt($(this).data("hotelstar"), 10);
                        if (hotelStar <= starSearch){
                            flagSearchHotelStar = true;
                        } else {
                            flagSearchHotelStar = false;
                        }
                    }

                    if (hotelTypeSearch != null){
                        let hotelTypeCode = $(this).data("hoteltypecode").toString();
                        if (jQuery.inArray(hotelTypeCode, hotelTypeSearch) > -1){
                            flagSearchTypeSearch = true;
                        } else {
                            flagSearchTypeSearch = false;
                        }
                    }

                    if (facilitiesSearch != null){
                        let hotelFacilities = $(this).data("hotelfacilities");
                        hotelFacilities = hotelFacilities.split(',');
                        for ( let i = 0, l = facilitiesSearch.length; i < l; i++ ) {
                            if (jQuery.inArray(facilitiesSearch[i], hotelFacilities) == -1){
                                flagSearchFacilities = flagSearchFacilities && false;
                            }
                        }
                    }

                });


                let prices = $(this).find('input[name*=RoomPrice]');
                prices.each(function () {
                   let price  = $(this).val();
                   if (price > 0 && !(price >= minPriceSearch && price <= maxPriceSearch)){
                       flagSearchPrice = flagSearchPrice && false;
                   }
                });

                /*console.log('flagSearchHotelName', flagSearchHotelName);
                console.log('flagSearchHotelStar', flagSearchHotelStar);
                console.log('flagSearchTypeSearch', flagSearchTypeSearch);
                console.log('flagSearchFacilities', flagSearchFacilities);
                console.log('flagSearchPrice', flagSearchPrice);*/

                return flagSearchHotelName && flagSearchHotelStar && flagSearchTypeSearch && flagSearchFacilities && flagSearchPrice;
            }).show();

            setTimeout(function () {
                $('#filter_tour').removeClass('show');
            }, 200);
        }
    </script>



    <script src="assets/js/html5gallery.js"></script>
    <script>
        $(document).ready(function () {

            $('[data-toggle="tooltip"]').tooltip();



        });
    </script>
    <script>
        function openTab(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }
    </script>
    <script>
        $(document).ready(function () {
            /*$('.collapse__').click(function () {
                $('.mdi-chevron-down').toggleClass('mdi-chevron-up');
                $('#bundle-prices-109133301').toggleClass('show_hotels_');
            });*/

            var widthw = $(window).width();
            var hei = $(window).height();

            if (widthw < 768) {
                openTab('masir');
                $('#masirha_').addClass('active-tab');
                $('.n-mx-qeymat').addClass('fixedd');
                $('.n-mx-qeymat').css('bottom', 0);
            }


        });

        $(window).resize(function () {
            var widthw = $(window).width();
            var hei = $(window).height();

            if (widthw < 768) {
                $('.n-mx-qeymat').addClass('fixedd');
                $('.n-mx-qeymat').css('bottom', 0);
            }
            else {
                $('.n-mx-qeymat').removeClass('fixedd');
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            var widthw = $(window).width();

            var $nav = $('#fixing_sc'),
                posTop = $nav.position().top;
            $(window).scroll(function () {
                if (widthw > 767) {
                    var $hei_nav = $nav.height();
                    var y = $(this).scrollTop();
                    if (y > posTop) {
                        $nav.addClass('fixed_to_top');
                        $('#tabs11').css('margin-top', $hei_nav + 22);
                    } else {
                        $nav.removeClass('fixed_to_top');
                        $('#tabs11').css('margin-top', '11px');
                    }
                }

            });


            $('.entekab-date-click').click(function () {
                $('.scrollhereshowlist').removeClass('blou');
                $(this).parents('.scrollhereshowlist').addClass('blou');

            });
            var w = $(window).width();
            var ww = w - 160;
            $('.joz-div-xs').css('width', ww);


            $('.toggle-icon span').click(function () {
                $('.joz-toggle').toggleClass('display-joz');
                $('.toggle-icon span').toggleClass('mdi-arrow-up-thick');

            });

            $(".w3-bar button").click(function () {
                $('.w3-bar button').removeClass('active-tab');
                $(this).addClass('active-tab');
            });


            $('.tbl-div-tbl').click(function () {
                $(this).addClass('ezafe-class');
            });

            $('.toggle-div-tbl').click(function () {
                $('.tbl-div-tbl').removeClass('ezafe-class');
            });

        });

    </script>
    <script>
        $(window).resize(function () {
            var w = $(window).width();
            var ww = w - 100;
            $('.joz-div-xs').css('width', ww);
        })
    </script>

    <script type="text/javascript" src="assets/js/modal-login.js"></script>
 <script src="assets/js/scrollWithPage.min.js"></script>
    <script type="text/javascript">
 if($(window).width() > 990){
                $(".BaseTourBox_1").scrollWithPage(".tour_search_parrnet");
            }
        $.fn.blink = function (options) {
            var defaults = {delay: 500};
            var options = $.extend(defaults, options);
            return $(this).each(function (idx, itm) {
                setInterval(function () {
                    if ($(itm).css("visibility") === "visible") {
                        $(itm).css('visibility', 'hidden');
                    }
                    else {
                        $(itm).css('visibility', 'visible');
                    }
                }, options.delay);
            });
        };


        $(document).ready(function () {
            /* ===== Logic for creating fake Select Boxes ===== */
            $('.sel').each(function () {
                $(this).children('select').css('display', 'none');

                var $current = $(this);

                $(this).find('option').each(function (i) {
                    if (i == 0) {
                        $current.prepend($('<div>', {
                            class: $current.attr('class').replace(/sel/g, 'sel__box')
                        }));

                        var placeholder = $(this).text();
                        $current.prepend($('<span>', {
                            class: $current.attr('class').replace(/sel/g, 'sel__placeholder'),
                            text: placeholder,
                            'data-placeholder': placeholder
                        }));

                        return;
                    }

                    $current.children('div').append($('<span>', {
                        class: $current.attr('class').replace(/sel/g, 'sel__box__options'),
                        text: $(this).text(),
                        val: $(this).val()
                    }));
                });
            });

// Toggling the `.active` state on the `.sel`.
            $('.sel').click(function () {
                $(this).toggleClass('active');
            });

// Toggling the `.selected` state on the options.
            $('.btn--').click(function () {
                openTab('hotels');
                $('.w3-bar .w3-button').removeClass('active-tab');
                $('.w3-bar .w3-button:first-child').addClass('active-tab');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#tabs11").offset().top
                }, 2000);
            });


            $('.blink').blink({delay: 400});

            // hotelFacilities
            $('.contentHideMaxListItem ul.hotelFacilities').hideMaxListItems({
                'max': 6,
                'speed': 500,
                'moreText': '##Open## ([COUNT] ##Case##)'
            });

            $("#dynamicAdd").on("click", function (e) {
                e.preventDefault();
                $('.contentHideMaxListItem ul.hotelFacilities').append('<li>DYNAMIC LIST ITEM 1</li><li>DYNAMIC LIST ITEM 2</li><li>DYNAMIC LIST ITEM 3</li>');
                $('.content ul.hotelFacilities').hideMaxListItems({
                    'max': 6,
                    'speed': 500,
                    'moreText': '##Open##([COUNT])'
                });

            });
            $("#dynamicRemove").on("click", function (e) {
                e.preventDefault();
                $('.contentHideMaxListItem ul.hotelFacilities> li').not(':nth-child(1),:nth-child(2),:nth-child(3)').remove();
                $('.contentHideMaxListItem ul.hotelFacilities').hideMaxListItems({
                    'max': 6,
                    'speed': 500,
                    'moreText': '##Open## ([COUNT])'
                });
            });

            $(".slideDownHotelDescription").on("click", function () {
                $(this).siblings(".slideHotelDescriptionMin").addClass("slideHotelDescriptionMax");
                $(this).closest(".slideDownHotelDescription").addClass("displayiN");
                $(this).siblings(".slideUpHotelDescription").removeClass("displayiN");
            });

            $(".slideUpHotelDescription").on("click", function () {

                $(this).siblings(".slideHotelDescriptionMin").removeClass("slideHotelDescriptionMax");
                $(this).siblings(".slideDownHotelDescription").removeClass("displayiN");
                $(this).closest(".slideUpHotelDescription").addClass("displayiN");
            });

            //DistanceToImportantPlaces
            $(".slideDownHotelNear").click(function () {
                $(".slideHotelNearMin").addClass("slideHotelNearMax");
                $(".slideDownHotelNear").addClass("displayN");
                $(".slideUpHotelNear").removeClass("displayN");
            });
            $(".slideUpHotelNear").click(function () {
                $(".slideHotelNearMin").removeClass("slideHotelNearMax");
                $(".slideDownHotelNear").removeClass("displayN");
                $(".slideUpHotelNear").addClass("displayN");
            });

            $("body").delegate(".DetailPrice", "click", function () {
                $(this).parent().parent().next(".RoomDescription").toggleClass("trShowHideHotelDetail");
                $(this).parent().parent().next(".RoomDescription").find(".DetailPriceView").toggleClass("displayiN");
                $(this).children(".DetailPrice .fa").toggleClass("fa-caret-down fa-caret-up");
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $('#filter_btn_tour').click(function () {
                $('#filter_tour').addClass('show');
            });
            $('#filter_tour .modal-dialog').bind('click', function (e) {
                //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
                e.stopPropagation();
            });
            $('#filter_tour').click(function () {
                $(this).removeClass('show');
            });

            $('.close').click(function () {
                $('#filter_tour').removeClass('show');
            });

        });
    </script>
    <script>
        $(function () {
            $('ul.menu-quick li a').bind('click', function (event) {

                var $anchor = $(this);
                var headerHeight = $('header').height();
                $('html, body').stop().animate({
                    scrollTop: $($anchor.attr('href')).offset().top - headerHeight

                }, 1500, 'easeInOutExpo');

                var x = $anchor.attr('href');
                if (x == '#showTableHotelRoomForAjax') {
                    getInfoHotelRoomPriceForAjax();
                }

                event.preventDefault();

            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.mb-0').hover(function () {
                $(this).parents('.rounded').find('.hotelname img').css('display', 'block');
            });
            $('.mb-0').mouseleave(function () {
                $(this).parents('.rounded').find('.hotelname img').css('display', 'none');
            });
        });
    </script>

    <script>
        /*var downloadButton = document.querySelector('.buttond--');
        if (downloadButton) {
            downloadButton.addEventListener('click', function (event) {
                event.preventDefault();

                /!* Start loading process. *!/
                downloadButton.classList.add('loading');

                /!* Set delay before switching from loading to success. *!/
                window.setTimeout(function () {
                    downloadButton.classList.remove('loading');
                    downloadButton.classList.add('success');
                }, 3000);

                /!* Reset animation. *!/
                window.setTimeout(function () {
                    downloadButton.classList.remove('success');
                }, 8000);
            });
        };*/
    </script>
    <script src="assets/js/html5gallery.js"></script>


    <script>
        $(document).ready(function () {


          $('.share_js').each(function (){
            $(this).attr('data-title','{/literal}{$objResult->arrayTour['infoTour'][$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'tour_name')]}{literal}')
            $(this).attr('data-url','https://{/literal}{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}{literal}')
          })

            // =============number input
            function add(value1, value2) {
                var currentVal = parseInt($("#countt" + value1 + value2).val());
                if (!isNaN(currentVal)) {
                    $("#countt" + value).val(currentVal + 1);
                }
            }

            function minus(value1, value2) {
                var currentVal = parseInt($("#countt" + value1 + value2).val());
                if (!isNaN(currentVal)) {
                    if (currentVal > 0) {
                        $("#countt" + value).val(currentVal - 1);
                    }
                }
            }

            function closeOver(f, value) {
                return function () {
                    f(value);
                };
            }

            $(function () {
                var numButtons = 6;
                var countPackage = parseInt($('#countPackage').val());
                for (var j = 0; j <= countPackage; j++) {
                    for (var i = 1; i <= numButtons; i++) {
                        $("#add" + i + j).click(closeOver(add, i, j));
                        $("#minus" + i + j).click(closeOver(minus, i, j));
                    }
                }

            });


            /*$('body').on('click', 'i.plus', function () {
                var packageId = $(this).attr('packageId');
                calculatePricesTour(packageId, 'countt');
            });
            $('body').on('click', 'i.minus', function () {
                var packageId = $(this).attr('packageId');
                calculatePricesTour(packageId, 'countt');
            });*/
        });
    </script>

    <script src="assets/js/sharer.min.js"></script>




{/literal}