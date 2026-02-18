<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{load_presentation_object filename="reservationTour" assign="objTour"}
{load_presentation_object filename="resultTourLocal" assign="objResult"}
{load_presentation_object filename="requestReservation" assign="objRequestReservation"}
{assign var="showTourToman" value = $objFunctions->isEnableSetting('toman')}
{if $showTourToman}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('toman')}
{else}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('Rial')}
{/if}
{$objRequestReservation->initialize($smarty.post.serviceName)}

{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

<div id="steps">

    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Tourreservation##</h3>
        </div>
        <i class="separator donetoactive"></i>
        <div class="step active">
        <span class="flat_icon_airplane">
        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577"
             width="25"
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
        <div class="step ">
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
        <div class="step">
            <span class="flat_icon_airplane">
                <svg enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25"
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
         style="direction: ltr">06:00
    </div>

</div>


{assign var="targetDetail" value=$objRequestReservation->getTargetDetail($smarty.post)}
<form method="post" id="formPassengerDetailTourLocal"
      action="{$smarty.const.ROOT_ADDRESS}/factorTourLocal"
      enctype="multipart/form-data">
<section class="passengerDetailReservationTour">

    <div class="row">

        <div class="col-lg-8 col-12 px-lg-3 px-0">






<span id="SOFTWARE_LANG_SPAN" data-lang="{$smarty.const.SOFTWARE_LANG}" class="d-none"></span>

{if $smarty.const.SOFTWARE_LANG === 'en'}
    {assign var="countryTitleName" value="titleEn"}
{else}
    {assign var="countryTitleName" value="titleFa"}
{/if}

{if isset($smarty.post.factor_number)}
    {assign var="factorNumber" value=$smarty.post.factor_number}
{else}
    {assign var="factorNumber" value=$objResult->getFactorNumber()}
{/if}

{assign var="priceChanged" value=$objTour->getRequestPriceChanged($factorNumber)}



<div id="lightboxContainer" class="lightboxContainerOpacity"></div>
<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->


{assign var="date" value="|"|explode:$smarty.post.selectDate}

            {if $smarty.post.is_api eq '1'}
                {assign var="data_tour" value=['tour_code'=>$smarty.post.tourCode, 'start_date'=>$date[0],'type_tour'=>$smarty.post.typeTourReserve]}
                {assign var="infoTour" value=$objTour->infoTourByDateApi($data_tour)}

            {else}
                {assign var="infoTour" value=$objTour->infoTourByDate($smarty.post.tourCode, $date[0],$smarty.post.typeTourReserve)}

            {/if}
{$objResult->getInfoTourByIdTour($infoTour['id'])}

{assign var="array_package" value=[]}

{assign var="hotels" value=$objTour->infoTourHotelByIdPackage($smarty.post.packageId,$smarty.post.is_api)}




{foreach from=$hotels item=hotel key=hotel_key}
    {assign var="hotel_information" value=$objTour->getHotelInformation($hotel['fk_hotel_id'],$smarty.post.is_api)}
    {assign var="tour_route_information" value=$objTour->infoTourRoutByIdPackage($infoTour['id'], $hotel['fk_city_id'],$smarty.post.is_api)}
    {$array_package['hotels'][$hotel_key] = $hotel_information}
    {$array_package['hotels'][$hotel_key]['night'] = $tour_route_information[0]['night']}
    {$array_package['hotels'][$hotel_key]['room_service'] = $tour_route_information[0]['room_service']}
{/foreach}


{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="index_name" value='name'}
    {assign var="index_name_tag" value='name_fa'}
    {assign var="index_city" value='city_name'}
{else}
    {assign var="index_name" value='name_en'}
    {assign var="index_name_tag" value='name_en'}
    {assign var="index_city" value='city_name_en'}
{/if}


{assign var="cities" value=[]}

{foreach $objResult->arrayTour['infoTourRout'] as $item}
    {$cities[]=$item[$index_name]}

{/foreach}


{if $smarty.post.typeTourReserve eq 'noOneDayTour'}
{assign var="arrayTourPackage" value=$objResult->setInfoReserveTourPackage($smarty.post.packageId, $smarty.post.countRoom,$smarty.post.is_api)}
{/if}

{assign var="arrayTypeVehicle" value=$objResult->getTypeVehicle($infoTour['id'])}
{if $infoTour['prepayment_percentage'] neq 0}
    {assign var="paymentStatusValue" value='prePayment'}
{else}
    {assign var="paymentStatusValue" value='fullPayment'}
{/if}


    {load_presentation_object filename="currencyEquivalent" assign="objCurrency"}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/tour.tpl" targetDetail=$targetDetail}

           <h2 class="passengerDetailReservationTour_title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z"/></svg>
                ##PassengersInformation##
            </h2>

                    <div class="passengerDetailReservationTour_users">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding ">


{*                        {$smarty.post|var_dump}*}
                        {for $nPassenger=1 to $smarty.post.passengerCount}

                            {* Calculate actual adults (2 rooms × 2 adults = 4) *}
                            {assign var="actualAdults" value=$smarty.post.passengerCountADT}
                            {assign var="actualChildren" value=$smarty.post.passengerCountCHD}

                            {if $nPassenger le $actualAdults}
                                {* Adult passenger (first 4 passengers) *}
                                {assign var="passengerAge" value="adt"}
                                {assign var="classNameBirthdayShamsi" value="shamsiBirthdayCalendar"}
                                {assign var="classNameBirthdayMiladi" value="gregorianAdultBirthdayCalendar"}
                            {elseif $nPassenger gt $actualAdults && $nPassenger le $actualAdults + $actualChildren}
                                {* Child passenger (if passengerCountCHD > 0) *}
                                {assign var="passengerAge" value="chd"}
                                {assign var="classNameBirthdayShamsi" value="shamsiChildBirthdayCalendar"}
                                {assign var="classNameBirthdayMiladi" value="gregorianChildBirthdayCalendar"}
                            {else}
                                {* Infant passenger (remaining passengers) *}
                                {assign var="passengerAge" value="inf"}
                                {assign var="classNameBirthdayShamsi" value="shamsiInfantBirthdayCalendar"}
                                {assign var="classNameBirthdayMiladi" value="gregorianInfantBirthdayCalendar"}
                            {/if}
                            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first require_check require_check_{$nPassenger}">
                            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                                {if $passengerAge eq 'adt'} ##Adult##
                                {elseif $passengerAge eq 'chd'} ##Child##
                                {elseif $passengerAge eq 'inf'} ##InfantOrBedlessChild##
                                {/if}
                                <i class="soap-icon-family"></i>
                                      {if $objSession->IsLogin()}
                                          <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                                onclick="setHidenFildnumberRow('{$nPassenger}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"></path></svg>
                                              ##Passengerbook##
                                        </span>
                                      {/if}
                            </span>
                            <input type="hidden" id="numberRow" value="{$nPassenger}">
                            <input type="hidden" name="passengerAge{$nPassenger}" id="passengerAge{$nPassenger}" value="{$passengerAge}">

                            <div class="panel-default-change site-border-main-color">
                                <div class="panel-default-change_kindOfPasenger nationalityChangeBaseDiv">
                                    <span class="kindOfPasenger">
                                        <label class="control--checkbox">
                                            <input type="radio" name="passengerNationality{$nPassenger}"
                                                   onchange="passengerFormInit('{$smarty.post.passengerCount}')"
                                                   id="passengerNationality{$nPassenger}" value="0"
                                                   checked>
                                            <span>##Iranian##</span>

{*                                            <div class="checkbox">*}
{*                                                <div class="filler"></div>*}
{*                                                  <svg fill="#000000"  viewBox="0 0 30 30" >*}
{*                                                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>*}
{*                                                               </svg>*}
{*                                            </div>*}
                                        </label>
                                    </span>
                                    <span class="kindOfPasenger">
                                        <label class="control--checkbox">
                                            <input type="radio" name="passengerNationality{$nPassenger}"
                                                   onchange="passengerFormInit('{$smarty.post.passengerCount}')"
                                                   id="passengerNationality{$nPassenger}" value="1">
                                            <span>##Noiranian##</span>
{*                                            <div class="checkbox">*}
{*                                                <div class="filler"></div>*}
{*                                                 <svg fill="#000000"  viewBox="0 0 30 30" >*}
{*                                                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>*}
{*                                                               </svg>*}
{*                                            </div>*}
                                        </label>
                                    </span>
                                </div>
                                <div class="clear"></div>
                                <div class="panel-body-change">

                                    <div class="s-u-passenger-item s-u-passenger-item-change entry_div">
                                        <select class="gend{$nPassenger}" required="required" id="gender{$nPassenger}" name="gender{$nPassenger}">
                                            <option value="" disabled="" selected="selected">##Sex##</option>
                                            <option value="Male">##Sir##</option>
                                            <option value="Female">##Lady##</option>
                                        </select>
                                    </div>

                            <div class="s-u-passenger-item s-u-passenger-item-changes entry_div d-none">
                                <input data-required="foreign"
                                       id="nameEn{$nPassenger}" type="text" placeholder="##Nameenglish##"
                                       name="nameEn{$nPassenger}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEn{$nPassenger}')"
                                       class="">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                                <input data-required="foreign"
                                       id="familyEn{$nPassenger}" type="text" placeholder="##Familyenglish##"
                                       name="familyEn{$nPassenger}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEn{$nPassenger}')"
                                       class="">
                            </div>

                                    <div class="s-u-passenger-item no-before s-u-passenger-item-change entry_div d-none">
                                        <input data-required="iranian"
                                               id="nameFa{$nPassenger}" type="text" placeholder="##Namepersion##"
                                               name="nameFa{$nPassenger}"
                                               onkeypress=" return persianLetters(event, 'nameFa{$nPassenger}')"
                                               class="justpersian">
                                    </div>
                                    <div class="s-u-passenger-item no-before s-u-passenger-item-change entry_div d-none">
                                        <input data-required="iranian"
                                               id="familyFa{$nPassenger}" type="text" placeholder="##Familypersion##"
                                               name="familyFa{$nPassenger}"
                                               onkeypress=" return persianLetters(event, 'familyFa{$nPassenger}')"
                                               class="justpersian">
                                    </div>

                                    <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                                        <input data-required="iranian"
                                               id="birthday{$nPassenger}" type="text"
                                               placeholder="##shamsihappybirthday##" name="birthday{$nPassenger}"
                                               class="{$classNameBirthdayShamsi} "
                                               readonly="readonly">
                                    </div>
                                    <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                                        <input data-required="foreign"
                                               id="birthdayEn{$nPassenger}" type="text" placeholder="##miladihappybirthday##"
                                               name="birthdayEn{$nPassenger}"
                                               class="{$classNameBirthdayMiladi}" readonly="readonly">
                                    </div>

                                    <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                                        <input data-required="iranian"
                                               id="NationalCode{$nPassenger}" type="tel"
                                               placeholder="##Nationalnumber##" name="NationalCode{$nPassenger}" maxlength="10"
                                               class="UniqNationalCode"
                                               onkeyup="return checkNumber(event, 'NationalCode{$nPassenger}')">
                                    </div>

                                    <div class="s-u-passenger-item s-u-passenger-item-change select-meliat entry_div d-none">
                                        <select placeholder="##Countryissuingpassport##" data-required="foreign"
                                                name="passportCountry{$nPassenger}" id="passportCountry{$nPassenger}"
                                                class="select2">
                                            <option value="">##Countryissuingpassport##</option>
                                            {foreach $objFunctions->CountryCodes() as $Country}
                                                <option value="{$Country['code']}">{$Country[$countryTitleName]}</option>
                                            {/foreach}
                                        </select>
                                    </div>

                                    <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                                        <input data-required="iranian,external|foreign"
                                               id="passportNumber{$nPassenger}" type="text" placeholder="##Numpassport##"
                                               name="passportNumber{$nPassenger}" class="UniqPassportNumber"
                                               onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumber{$nPassenger}')">
                                    </div>
                                    <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                                        <input data-required="iranian,external|foreign"
                                               id="passportExpire{$nPassenger}" class="gregorianFromTodayCalendar" type="text"
                                               placeholder="##Passportexpirydate##" name="passportExpire{$nPassenger}">
                                    </div>



                                    {*{if $smarty.post.serviceTitle eq 'PublicLocalTour'}
                                        <div class="panel-default-change pull-right site-border-main-color">
                                            <div class="panel-heading-change">
                                                <span class="">##Nationalcardphoto##:</span>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="panel-body-change">
                                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                                    <input type="file" id="NationalImage{$nPassenger}"
                                                           name="NationalImage{$nPassenger}">
                                                </div>
                                            </div>
                                        </div>
                                    {else}
                                        <div class="panel-default-change pull-right site-border-main-color">
                                            <div class="panel-heading-change">
                                                <span class="">##Passportphoto##:</span>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="panel-body-change">
                                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                                    <input type="file" id="passportImage{$nPassenger}"
                                                           name="passportImage{$nPassenger}">
                                                </div>
                                            </div>
                                        </div>
                                    {/if}*}
                                    <div class="clear"></div>

                                    <div class="alert_msg d-flex gap-10 my-3" id="message{$nPassenger}"></div>
                                </div>
                                {if $infoTour['custom_file_fields'] neq ''}
                                    {assign var="custom_file_fields" value=json_decode($infoTour['custom_file_fields'],true)}

                                    {foreach $custom_file_fields as $key=>$item}
                                        <div class="s-u-passenger-item s-u-passenger-item-change">

                                            <div>
                                                <div class="input-group d-flex flex-wrap">
                                                    <span class="input-group-btn_style input-group-btn d-flex flex-wrap">
                                                        <span class="btn btn-file  border-radius-top-right position-relative">
                                                            <input type="file"
                                                                                        placeholder="{$item}"
                                                                                        data-id="{$nPassenger}{$key}"
                                                                                        id="custom_file_fields_{$nPassenger}"
                                                                                        name="custom_file_fields_{$nPassenger}[]"
                                                                                        single>
                                                            <div class='parent-upload'>
                                                                <span class=''>{$item}</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M303 175C312.4 165.7 327.6 165.7 336.1 175L416.1 255C426.3 264.4 426.3 279.6 416.1 288.1C407.6 298.3 392.4 298.3 383 288.1L344 249.9V384C344 397.3 333.3 408 320 408C306.7 408 296 397.3 296 384V249.9L256.1 288.1C247.6 298.3 232.4 298.3 223 288.1C213.7 279.6 213.7 264.4 223 255L303 175zM144 480C64.47 480 0 415.5 0 336C0 273.3 40.07 219.1 96 200.2V200C96 107.2 171.2 32 264 32C314.9 32 360.4 54.6 391.3 90.31C406.2 83.68 422.6 80 440 80C506.3 80 560 133.7 560 200C560 206.6 559.5 213 558.5 219.3C606.5 240.3 640 288.3 640 344C640 416.4 583.4 475.6 512 479.8V480H144zM264 80C197.7 80 144 133.7 144 200L144 234.1L111.1 245.5C74.64 258.7 48 294.3 48 336C48 389 90.98 432 144 432H506.6L509.2 431.8C555.4 429.2 592 390.8 592 344C592 308 570.4 276.9 539.2 263.3L505.1 248.4L511.1 211.7C511.7 207.9 512 204 512 200C512 160.2 479.8 128 440 128C429.5 128 419.6 130.2 410.8 134.2L378.2 148.7L354.9 121.7C332.8 96.08 300.3 80 263.1 80L264 80z"/></svg>
                                                            </div>
                                                        </span>
                                                    </span>
                                                    <input type="text" class="input-group-btn_readonly_style form-control new-display border-radius-top-left border-r-0" readonly>
                                                    <div class="imagepreview_parent d-flex h-200 flex-wrap w-100 border-radius-bottom hidden-overflow">
                                                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEBLAEsAAD/4QCCRXhpZgAASUkqAAgAAAABAA4BAgBgAAAAGgAAAAAAAABJbWFnZSBwcmV2aWV3IGljb24uIFBpY3R1cmUgcGxhY2Vob2xkZXIgZm9yIHdlYnNpdGUgb3IgdWktdXggZGVzaWduLiBWZWN0b3IgZXBzIDEwIGlsbHVzdHJhdGlvbi7/4QWBaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIj4KCTxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+CgkJPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpJcHRjNHhtcENvcmU9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBDb3JlLzEuMC94bWxucy8iICAgeG1sbnM6R2V0dHlJbWFnZXNHSUZUPSJodHRwOi8veG1wLmdldHR5aW1hZ2VzLmNvbS9naWZ0LzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGx1cz0iaHR0cDovL25zLnVzZXBsdXMub3JnL2xkZi94bXAvMS4wLyIgIHhtbG5zOmlwdGNFeHQ9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBFeHQvMjAwOC0wMi0yOS8iIHhtbG5zOnhtcFJpZ2h0cz0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3JpZ2h0cy8iIHBob3Rvc2hvcDpDcmVkaXQ9IkdldHR5IEltYWdlcy9pU3RvY2twaG90byIgR2V0dHlJbWFnZXNHSUZUOkFzc2V0SUQ9IjEyMjIzNTc0NzUiIHhtcFJpZ2h0czpXZWJTdGF0ZW1lbnQ9Imh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9sZWdhbC9saWNlbnNlLWFncmVlbWVudD91dG1fbWVkaXVtPW9yZ2FuaWMmYW1wO3V0bV9zb3VyY2U9Z29vZ2xlJmFtcDt1dG1fY2FtcGFpZ249aXB0Y3VybCIgPgo8ZGM6Y3JlYXRvcj48cmRmOlNlcT48cmRmOmxpPmRpY2tjcmFmdDwvcmRmOmxpPjwvcmRmOlNlcT48L2RjOmNyZWF0b3I+PGRjOmRlc2NyaXB0aW9uPjxyZGY6QWx0PjxyZGY6bGkgeG1sOmxhbmc9IngtZGVmYXVsdCI+SW1hZ2UgcHJldmlldyBpY29uLiBQaWN0dXJlIHBsYWNlaG9sZGVyIGZvciB3ZWJzaXRlIG9yIHVpLXV4IGRlc2lnbi4gVmVjdG9yIGVwcyAxMCBpbGx1c3RyYXRpb24uPC9yZGY6bGk+PC9yZGY6QWx0PjwvZGM6ZGVzY3JpcHRpb24+CjxwbHVzOkxpY2Vuc29yPjxyZGY6U2VxPjxyZGY6bGkgcmRmOnBhcnNlVHlwZT0nUmVzb3VyY2UnPjxwbHVzOkxpY2Vuc29yVVJMPmh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9waG90by9saWNlbnNlLWdtMTIyMjM1NzQ3NS0/dXRtX21lZGl1bT1vcmdhbmljJmFtcDt1dG1fc291cmNlPWdvb2dsZSZhbXA7dXRtX2NhbXBhaWduPWlwdGN1cmw8L3BsdXM6TGljZW5zb3JVUkw+PC9yZGY6bGk+PC9yZGY6U2VxPjwvcGx1czpMaWNlbnNvcj4KCQk8L3JkZjpEZXNjcmlwdGlvbj4KCTwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InciPz4K/+0ArFBob3Rvc2hvcCAzLjAAOEJJTQQEAAAAAACQHAJQAAlkaWNrY3JhZnQcAngAYEltYWdlIHByZXZpZXcgaWNvbi4gUGljdHVyZSBwbGFjZWhvbGRlciBmb3Igd2Vic2l0ZSBvciB1aS11eCBkZXNpZ24uIFZlY3RvciBlcHMgMTAgaWxsdXN0cmF0aW9uLhwCbgAYR2V0dHkgSW1hZ2VzL2lTdG9ja3Bob3Rv/9sAQwAKBwcIBwYKCAgICwoKCw4YEA4NDQ4dFRYRGCMfJSQiHyIhJis3LyYpNCkhIjBBMTQ5Oz4+PiUuRElDPEg3PT47/9sAQwEKCwsODQ4cEBAcOygiKDs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7/8IAEQgCZAJkAwERAAIRAQMRAf/EABoAAQEBAQEBAQAAAAAAAAAAAAACAwUEAQb/xAAWAQEBAQAAAAAAAAAAAAAAAAAAAQL/2gAMAwEAAhADEAAAAf2KAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAScWyAAAAAAAAAAADor7oAAAAAAAFFAAAAAAAAAzAAAAAAAB5zwWdeUAAAAAAAAAAScSzuygAAAAAACigAAAAAAAAZgAAAAAAA854LOvKAAAAAAAAAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAAAAAA+ElgAAEnEs7soAAAAAAAooAAAAAAAAGYAAAAAAAPOeCzrygAAAAD4cCzy2dCXtSgACTiWd2UAAAAAAAUUAAAAAAAADMAAAAAAAHnPBZ15QAAAAB5z87rIH6jOqAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAAAAAEn56zCz1y9+UAAScSzuygAAAAAACigAAAAAAAAZgAAAAAAA854LOvKAAAAABJibn0AAEnEs7soAAAAAAAooAAAAAAAAGYAAAAAAAPOeCzrygAYEnpAAAAAAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAGBwNSTv5vpAAAAJKABJxLO7KAAAAAAAKKAAAAAAAABmAAAAAAADzngs68oGBwNTNBS9/N9IAABgcHU7EvtgCTiWd2UAAAAAAAUUAAAAAAAADMAAAAAAAHnPBZ15RgcDUzQAUvfzfSAAYHA1M0+ncmvbAk4lndlAAAAAAAFFAAAAAAAAAzAAAAAAAB5zwWdeXA4GpmgAApe/m+kAwOBqZoB9O5Ne2JOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnQl4GpmgAAApe/m+kwOBqZoAB9O5NeuOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec5VnmrNAAAABS9mXkWZoAAB9O3NeBO7KAAAAAAAKKAAAAAAAABmAAAAAAADzn53WQAAAAAAAAAAB7Ze7KAAAAAAAKKAAAAAAAABmAAAAAAADzn53WQAAAAAAAAAAB7Ze7KAAAAAAAKKAAAAAAAABmAAAAAAADE/N6yAAAAAAAAAAAPfL25QAAAAAABRQAAAAAAAAMwAAAAAAADzmdAAAAAAAAAAAemLAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAACQAAAAAAAAAAAAAAAAAAAAAAAAAAAAfT6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/8QAJxAAAQMCBgMBAQEBAQAAAAAAAwABAhFgBBMUMTNAIDBQEBKQITL/2gAIAQEAAQUC/wA+Gs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1vhu/wDLSxJJPnHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWedYc+Z0W+GfgwW/WfbCc3Qb4Z+DBb9Z9sJzdBvhn4MFv7v6b0PthOboN8M/Bgt/aY8iOsPiHaXk+2E5ug3wz8GC39h+H9b/z4vthOboN8M/Bgt/Y7VYonFJAC5JeT7YTm6DfDPwYLf2uzOskXofbCc3Qb4Z+DBb+JCMKITMVve+2E5ug3wz8GC38CEYUZzckoyeEgmYsfTX/AL4PthOboN8M/Bgt/wBIRhRnNyS/IyeEgmYsfMpWFGRJSmA+Y36+2E5ug3wz8GC3/CEYUZzckvCMnhIJmLHxKVhRnNySTPRwHzG/H2wnN0G+GfgwW6IRhRnNyS8oyeEgmYsf0pWFGc3JL9Z6OA+YyfbCc3Qb4Z+DBbkIwozm5JeiMnhIJmLFFKwozm5JeLPRwHzGfbCc3Qb4Z+DDkYTTm5JeqMnhJsVDLnNyS82ejhPmRwnN0G+Gfg6+ywnN0G+Gfg7GE5ug3wyt/Quxg4vmdBviSAOb6US0olpRLSiWlEtKJaUS0olpRLSiWlEtKJaUS0olpRLSiWlEtKJaUS0olpRLSiWmEoxaLdBrNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNbp0VFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRU/zA//EABYRAQEBAAAAAAAAAAAAAAAAAAFgsP/aAAgBAwEBPwHEgI0jSNI0jSNI0jSNI0jSNMm3/8QAFBEBAAAAAAAAAAAAAAAAAAAAwP/aAAgBAgEBPwE5T//EACkQAAEBBgUEAwEBAAAAAAAAAAABAhExMpGhIDBQcYEQQFFhEiFBsCL/2gAIAQEABj8C/hpPX8P8/RFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoOajqjWw13HGqNbDXccao1sNZ8UyeNUa2Gs7wz0+LS/WRxqjWw1mtbYEx8ao1sNZrlHLDz0esqZHGqNbDWd9kiZPGqNbDWJ6nvx2PGqNbDWF6j1Hoe/GU7FxqjWw1geo9er0PfjIep83/Y5ZsPGqNbDXV6j1wvQ9+MT1Hr0eg5ZsHGqNbDXR6j1xvQ9+MD1Hrgeg5ZuvGqNbDQ9R65L0Pfjo9R64noOWbpxqjWw2qj1y3ofJY+B65D0HLMcao1t3PGqNbdzxqjSJ47n5fiaq9WSW5LcluS3JbktyW5LcluS3JbktyW5LcluS3JbktyW5LcluS3JbjkR38NT//EACoQAAECBAYCAgIDAQAAAAAAAAEAMRFBUXEgITBQofAQ4UCxYGGQkaCw/9oACAEBAAE/If8AhpAAAAytBEqT6QAj8fWta1rWta1rWta1rWtagZlQsbXPKe6q4Y+O/ZM3bqrgj47lkzduquCNeKYZ19ByyZu3VXBGqSACSwRWATIHgGjjyBMsblkzduquCNWIQ8CPMeGJyyZu3VXBGqA7BEFAh+lXgZBUNcblkzduquCNYDAARQoCMeNAACAyxuWTN26q4IxT5yFVE4yF/gHLJm7dVcEYZ85CqPD+kOHgQqGF9JAAIiJYYXLJm7dVcEYJ85CqPD+vI4eBCoYX0EyEhVR+/RCSG1hzgcsmbt1VwR5nzkKo8P6wjh4EKhhfEmQkKo8Pn9eCCJAiaG1hz5csmbt1VwR4n3kKo9P6xjh4EKhhfAmQkKo8Pn9YCCJAiaG1hz4csmbt1VwQp85CqPD+tEcPAhUML+EyEhVHh8/rEQRIETQ2sOU5ZM3bqqnGICqPT+tMcPAhFSlTw+f1oEESBE0E2WA/tM3fhigSUQYEJm78NUzdugryORN8gg5DdUIKNRkuol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Eu4lAyCg/0KgAAAAAAAAAAAAAQ/i/8A/9oADAMBAAIAAwAAABBtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttv/8A/wD/AP8A/wD/AP8A/wCG2222222222222222222222222u22222222223222222222222222222222222221W2222222222+22222222222222222222222222q222222/2223222222222222222222222222221W222223i222+22222222222222222222222222q222222yS223222222222222222222222222221W22222+jm22+22222222222222222222222222q222222/+223222222222222222222222222221W2382222222+22222222222222222222222222q23xE2222+23222222222222222222222222221W3wTE222+I2+22222222222222222222222222q3wSTE22+CY3222222222222222222222222221XwSSTE2+CSY+22222222222222222222222222rwSSSTE+CSSZ222222222222222222222222221wSSSSTACSSSY22222222222222222222222222iSSSSSSSSSSTW22222222222222222222222220SSSSSSSSSSSS22222222222222222222222223ySSSSSSSSSSSe222222222222222222222222225JJJJJJJJJJJ22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222223//xAAdEQEAAgIDAQEAAAAAAAAAAAABABExUCAwQBCw/9oACAEDAQE/EPw07ZbLZbLZbLZbLZbLZbLZbLZbLZbLZbLZbLZbBvaOPSNo49I2jj0jaOO8vweg2jjuOOs2jjvJXwOg2jjwKOk2jjmWDfhNo45F+jfgNo44ll8BvoWpcG+JtHHAvMb5LwHgbRx9LF6BvgvIb+m0cfC9Y38XoG/htHEHtvqG4bRx6TaOPSbR9JtalEolEolEolEolEolEolEolEolEolEolEolH4av8A/8QAHREAAwEBAAMBAQAAAAAAAAAAAAERMFAQIECwYP/aAAgBAgEBPxD8NOERERERERERERERERERERERERERERERENdRD+h9RD+h9RD+h9RD2S8NYPqIeqzfUQ9k/DeD6iHvcX1EP3a+F9RDwa+B9RDxaya9X1EPJrJr0fUQ82smvL6iHo1k14fUQ9Zk0PqL6X1F9L/jX1aUpSlKUpSlKUpSlKUpSl/DV//EACgQAAEDAwMDBQEBAQAAAAAAAAEAETFAUWEhUPBB0fEQIDBxoZGQsf/aAAgBAQABPxD/ABxcXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6eiMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMGhJYxhMBHrj02JsrwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsiGwgSSLf8TSgBsOgB3oZmiMGiIQ62sn9pwBCQ4JOKJEzRGDRFzmaf96iRM0Rg0Rc5n5w2zWAX+D96iRM0Rg0Rc5n5TtMByT0CEHJYJZxc+hlh7g5Pprb3/vUSJmiMGiLnM/KZOf8Ax1/PUTojIkwv9t7v3qJEzRGDRFzmflHM5xDBR6QSMWgd/Q20Gcg/ge/96iRM0Rg0Rc5n5ik9SBwmTc/j+ICAAEACPf8AvUSJmiMGiLnM+49I5aDkloE6yjIxQfvUSJmiMGiLnM+09I5aDkk/2JgCAsEQOdoU4Awn1ZGPiIQTzh1Pt/eokTNEYNEXOZ9h6Ry0HJJ/sTAEBYepA52hTgDCfVkY+AlO5aDkk6mBLuN9QgYgG1HQbj2fvUSJmiMGiLnM+p6Ry0HJJ/sTA6BYe0gc7QhOAMJ9WRj3Ep3LQcknOxQOgWHoeAc4A6hAxANqOmY9f3qJEzRGDRFzmfQ8I5aDkk/mJgdAsPeQOdoU4Awn1ZGPYSnctBySc7FA6BYew8A5wEgoGIBtR0zHp+9RImaIwaIucyj0jloOST/YmAICw+Egc7QpwBhPqyMehKdy0HJJzsUDoFh7jwDnASEDEA2o6DcL96iRM0Rg0RFockA5LVP5iYHQLD4yBztCjnQ0iEk4wnOxQOgWHwHgHOAkFG4B1x0FpFEiZojB2kh84hwQdRRImaIwd7LEzRGDQjkc5lyiCRBDEaEGoC4FyCcnpQzNEYNEbmjkhd9ssvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MoDM+GUAjGAUMzRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGE+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T46/5f//Z
"
                                                             data-id="{$nPassenger}{$key}"
                                                             alt="" class="imagepreview w-100 h-100">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    {/foreach}
                                {/if}
                            </div>
                            <div class="clear"></div>
                            </div>
                        {/for}


                        <input type="hidden" id="idTour" name="idTour" value="{$infoTour['id']}">
                        <input type="hidden" id="prepayment_percentage" name="prepayment_percentage"
                               value="{$infoTour['prepayment_percentage']}">
                        <input type="hidden" id="paymentStatus" name="paymentStatus" value="{$paymentStatusValue}">
                        <input type="hidden" id="passengerCount" name="passengerCount" value="{$smarty.post.passengerCount}">
                        <input type="hidden" id="cities" name="cities" value="{$smarty.post.cities}">
                        <input type="hidden" id="serviceTitle" name="serviceTitle" value="{$smarty.post.serviceTitle}">
                        <input type="hidden" id="startDate" name="startDate" value="{$date[0]}">
                        <input type="hidden" id="endDate" name="endDate" value="{$date[1]}">
                        <input type="hidden" id="totalPriceA" name="totalPriceA" value="{$smarty.post.totalPriceA}">
                        <input type="hidden" id="totalPrice" name="totalPrice" value="{$smarty.post.totalPrice}">
                        <input type="hidden" id="totalOriginPrice" name="totalOriginPrice" value="{$smarty.post.totalOriginPrice}">
                        <input type="hidden" id="paymentPrice" name="paymentPrice" value="{$smarty.post.paymentPrice}">
                        <input type="hidden" id="oldIdMember" name="oldIdMember" value="{if isset($smarty.post.idMember)}{$smarty.post.idMember}{/if}">
                        <input type="hidden" id="oldFactorNumber" name="oldFactorNumber" value="{if isset($smarty.post.factor_number)}{$smarty.post.factor_number}{/if}">
                        <input type="hidden" id="factorNumber" name="factorNumber" value="{$objResult->getFactorNumber()}">
                        <input type="hidden" id="packageId" name="packageId" value="{$smarty.post.packageId}">
                        <input type="hidden" id="typeTourReserve" name="typeTourReserve" value="{$smarty.post.typeTourReserve}">
                        <input type="hidden" id="countRoom" name="countRoom" value="{$smarty.post.countRoom}">
                        <input type="hidden" name="is_api" id="is_api" value="{$smarty.post.is_api}">
                        <input type="hidden" name="typeApplication" id="typeApplication" value="reservation">
                        <input type="hidden" name="idMember" id="idMember" value="">



                    </div>



            </div>


            {if not $objSession->IsLogin()}
            <h2 class="passengerDetailReservationTour_title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z"/></svg>
                ##InformationSaler##
            </h2>
            <div class="passengerDetailReservationTour_users m-0">
                    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first">
                        <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                        <div class="clear"></div>
                        <div class="panel-default-change-Buyer">
                            <div class="s-u-passenger-items s-u-passenger-item-change">
                                <input id="Mobile" type="text" placeholder="##Phonenumber## " name="Mobile"
                                        {if isset($smarty.post.memberMobile)}
                                            value='{$smarty.post.memberMobile}'
                                            disabled
                                        {/if}
                                       class="dir-ltr"/>
                            </div>
                            <div class="s-u-passenger-items s-u-passenger-item-change">
                                <input id="Telephone" type="text" placeholder=" ##Telephone##" name="Telephone"
                                       class="dir-ltr"/>
                            </div>
                            <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                                <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr"/>
                            </div>
                        </div>
                        <div id="messageInfo" class='badge badge-danger'></div>
                        <div class="clear"></div>
                    </div>
            </div>
            {/if}
    </div>

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/factor.tpl" targetDetail=$targetDetail}

{*    </div>*}

    </div>
</section>
</form>
<script>
    passengerFormInit('{$smarty.post.passengerCount}');
</script>
{literal}
    <script src="../club/assets/js/jquery.toast.js"></script>
    <script src="assets/js/html5gallery.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <script type="text/javascript">
       /* $('.counter').counter({});

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
    <script type="text/javascript">

        $(document).ready(function () {




            if ($('#SOFTWARE_LANG_SPAN').attr('data-lang') === 'en') {

                $('.nationalityChange[value="0"]').prop('checked', false);
                $('.nationalityChange[value="1"]').prop('checked', true);

                $('.noneIranian').addClass('d-block');
                $('.justIranian').addClass('d-none');

            }

            $(this).find(".closeBtn").click(function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $("div#lightboxContainer").click(function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });

            $("div#lightboxContainer").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });

            $("div#lightboxContainer").click(function () {
                $(".last-p-popup").css("display", "none");
            });


        });

        $(document).on('change', '.btn-file :file', function () {
            const FileType = checkFileType($(this));
            if (FileType) {
                readURL(this, $(this));
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            }
        });

        $(document).ready(function () {
            $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });
        });

        function readURL(input, thiss) {


            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imagepreview[data-id="' + thiss.data('id') + '"]').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('.imagepreview').attr('src', '');
            }
        }

        $(".btn-file :file").change(function () {
            const FileType = checkFileType($(this), true);
            if (FileType) {
                readURL(this, $(this));
            }

        });


    </script>
{/literal}

