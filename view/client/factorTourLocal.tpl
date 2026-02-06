{load_presentation_object filename="members" assign="objMember"}
{assign var="showTourToman" value = $objFunctions->isEnableSetting('toman')}
{if $showTourToman}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('toman')}
{else}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('Rial')}
{/if}
{$objMember->get()}

{load_presentation_object filename="factorTourLocal" assign="objFactor"}
{load_presentation_object filename="reservationTour" assign="objTour"}

{$objFactor->registerPassengers()}

{load_presentation_object filename="resultTourLocal" assign="objResult"}
{assign var="arrayTypeVehicle" value=$objResult->getTypeVehicle($smarty.post.idTour)}

{assign var="CurrencyCode" value=$smarty.post.CurrencyCode}

{if $objFactor->tourBookingInfo['prepayment_percentage'] neq 0}
    {assign var="paymentStatusValue" value='prePayment'}
    {else}
    {assign var="paymentStatusValue" value='fullPayment'}
{/if}


{if isset($smarty.post.oldFactorNumber) && $smarty.post.oldFactorNumber neq ''}
    {assign var="factorNumber" value=$smarty.post.oldFactorNumber}
{else}
    {assign var="factorNumber" value=$smarty.post.factorNumber}
{/if}

{assign var="GetInfoTour" value=$objFunctions->GetInfoTour($factorNumber,$smarty.post.is_api)}
{$objResult->getInfoTourByIdTour($GetInfoTour['tour_id'])}



{assign var="array_package" value=[]}


{assign var="hotels" value=$objTour->infoTourHotelByIdPackage($smarty.post.packageId,$smarty.post.is_api)}




{foreach from=$hotels item=hotel key=hotel_key}
    {assign var="hotel_information" value=$objTour->getHotelInformation($hotel['fk_hotel_id'],$smarty.post.is_api)}
    {assign var="tour_route_information" value=$objTour->infoTourRoutByIdPackage($GetInfoTour['tour_package']['id'], $hotel['fk_city_id'],$smarty.post.is_api)}
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


{assign var="priceChanged" value=$objTour->getRequestPriceChanged($factorNumber)}

{if isset($smarty.post.oldIdMember) && $smarty.post.oldIdMember neq ''}
    {assign var="idMember" value=$smarty.post.oldIdMember}
{else}
    {assign var="idMember" value=$smarty.post.idMember}
{/if}

{if $objFactor->error eq 'true'}
    <div class="container">

        <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

    </div>
{else}

{if $smarty.post.typeTourReserve eq 'noOneDayTour'}

{assign var="arrayTourPackage" value=$objResult->setInfoReserveTourPackage($smarty.post.packageId, $smarty.post.countRoom,$smarty.post.is_api)}


{/if}
<div class="container">

    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>



    <section class="passengerDetailReservationTour">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 px-lg-3 px-0">
                    {if $smarty.post.typeTourReserve eq 'noOneDayTour'}
                        <h2 class="passengerDetailReservationTour_title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M488 400h-464C10.75 400 0 410.7 0 423.1C0 437.3 10.75 448 23.1 448h464c13.25 0 24-10.75 24-23.1C512 410.7 501.3 400 488 400zM80 352c0-97 79-176 176-176s176 79 176 176v16H480V352c0-112.9-83.5-205.9-192-221.5V112h24c13.25 0 24-10.75 24-24C336 74.74 325.3 64 311.1 64h-112C186.7 64 176 74.74 176 88c0 13.25 10.75 24 24 24H224v18.5C115.5 146.1 32 239.1 32 352v16h48V352z"/>
                            </svg>
                            ##PackageHotels##
                        </h2>
                        {if $array_package['hotels']|count == 1}
                            <div class="passengerDetailReservationTour_hotel">
                                <div class="col-lg-3 col-12 p-0">
                                    <div class="passengerDetailReservationTour_hotel_img">
                                        <img src="{$array_package['hotels'][0]['logo']} " alt="{$array_package['hotels'][0][$index_name]} ">
                                    </div>
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div class="passengerDetailReservationTour_hotel_text">
                                        <div class="passengerDetailReservationTour_hotel_text_hotelNameAndStar">
                                            <h2>{$array_package['hotels'][0][$index_name]}  {if $hotel[$index_city]}<span>({$hotel[$index_city]})</span>{/if}</h2>
                                            <div>
                                                {for $s=1 to $array_package['hotels'][0]['star_code']}
                                                    <svg class="active_star" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 576 512">
                                                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/>
                                                    </svg>

                                                {/for}
                                                {for $ss=$s to 5}
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/>
                                                    </svg>
                                                {/for}
                                            </div>
                                        </div>
                                        <div class="passengerDetailReservationTour_hotel_text_hotelBed">
                                            {foreach $arrayTourPackage['infoRooms'] as $room}
                                                <div class="passengerDetailReservationTour_hotel_text_hotelBed_div">
                                    <span class="passengerDetailReservationTour_hotel_text_hotelBed_div_span">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path
                                                        d="M32 80C32 53.49 53.49 32 80 32H432C458.5 32 480 53.49 480 80V209.1C465.5 200.8 449.3 195.1 431.1 192.1C431.1 192.7 432 192.3 432 192V160C432 142.3 417.7 128 400 128H304C286.3 128 272 142.3 272 160V192H240V160C240 142.3 225.7 128 208 128H112C94.33 128 80 142.3 80 160V192C80 192.3 80.01 192.7 80.02 192.1C62.7 195.1 46.46 200.8 32 209.1V80zM0 320C0 266.1 42.98 224 96 224H416C469 224 512 266.1 512 320V448C512 465.7 497.7 480 480 480C462.3 480 448 465.7 448 448V416H64V448C64 465.7 49.67 480 32 480C14.33 480 0 465.7 0 448V320z"/></svg>
                                            {$room['name_fa']}
                                        </span>
                                                    <h2 class="passengerDetailReservationTour_hotel_text_hotelBed_div_h2">
                                                        ##Count##: <span>{$room['count']} ##Number##</span>
                                                    </h2>
                                                    <div class="passengerDetailReservationTour_hotel_text_hotelBed_div_div">
                                                        <i class=""
                                                           style="display: inline-block">
                                                            {if $showTourToman}
                                                                {round($room['total_price']/10)|number_format:0:".":","}
                                                            {else}
                                                                {$room['total_price']|number_format:0:".":","}
                                                            {/if}


                                                            {$iranCurrency}
                                                        </i>
                                                        {if $room['price_a'] gt 0}
                                                            +
                                                            <i class="green-text"
                                                               style="display: inline-block">{$room['total_price_a']|number_format}


                                                                {if $smarty.const.SOFTWARE_LANG neq 'fa'}
                                                                    {$objFunctions->changeCurrencyName($room['currency_type'])}
                                                                {else}
                                                                    {$room['currency_type']}
                                                                {/if}
                                                            </i>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/foreach}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        {else}
                            <div class="row">
                                {foreach $array_package['hotels'] as $hotel}
                                    <div class="col-lg-6">
                                        <div class="passengerDetailReservationTour_hotel">
                                            <div class="col-lg-12 col-12 p-0">
                                                <div class="passengerDetailReservationTour_hotel_img">
                                                    <img src="{$hotel['logo']}" alt="{$hotel[$index_name]}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-12 p-0 mt-3">
                                                <div class="passengerDetailReservationTour_hotel_text p-0">
                                                    <div class="passengerDetailReservationTour_hotel_text_hotelNameAndStar">
                                                        <h2>{$hotel[$index_name]}</h2>
                                                        <div>
                                                            {for $s=1 to $hotel['star_code']}
                                                                <svg class="active_star" xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 576 512">
                                                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                    <path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/>
                                                                </svg>

                                                            {/for}
                                                            {for $ss=$s to 5}
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                                    <path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/>
                                                                </svg>
                                                            {/for}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                            <h2 class="passengerDetailReservationTour_title">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M48 336H288V184C288 153.1 313.1 128 344 128H520C586.3 128 640 181.7 640 248V464C640 477.3 629.3 488 616 488C602.7 488 592 477.3 592 464V384H48V456C48 469.3 37.25 480 24 480C10.75 480 0 469.3 0 456V56C0 42.75 10.75 32 24 32C37.25 32 48 42.75 48 56V336zM520 176H344C339.6 176 336 179.6 336 184V336H592V248C592 208.2 559.8 176 520 176zM256 216C256 264.6 216.6 304 168 304C119.4 304 80 264.6 80 216C80 167.4 119.4 128 168 128C216.6 128 256 167.4 256 216zM168 176C145.9 176 128 193.9 128 216C128 238.1 145.9 256 168 256C190.1 256 208 238.1 208 216C208 193.9 190.1 176 168 176z"/></svg>
                                اطلاعات اتاق ها
                            </h2>
                            <div class="passengerDetailReservationTour_hotel">
                                <div class="passengerDetailReservationTour_hotel_text w-100 p-0">
                                    <div class="passengerDetailReservationTour_hotel_text_hotelBed">
                                        {foreach $arrayTourPackage['infoRooms'] as $room}
                                            <div class="passengerDetailReservationTour_hotel_text_hotelBed_div">
                                            <span class="passengerDetailReservationTour_hotel_text_hotelBed_div_span">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path
                                                                d="M32 80C32 53.49 53.49 32 80 32H432C458.5 32 480 53.49 480 80V209.1C465.5 200.8 449.3 195.1 431.1 192.1C431.1 192.7 432 192.3 432 192V160C432 142.3 417.7 128 400 128H304C286.3 128 272 142.3 272 160V192H240V160C240 142.3 225.7 128 208 128H112C94.33 128 80 142.3 80 160V192C80 192.3 80.01 192.7 80.02 192.1C62.7 195.1 46.46 200.8 32 209.1V80zM0 320C0 266.1 42.98 224 96 224H416C469 224 512 266.1 512 320V448C512 465.7 497.7 480 480 480C462.3 480 448 465.7 448 448V416H64V448C64 465.7 49.67 480 32 480C14.33 480 0 465.7 0 448V320z"/></svg>
                                                     {$room['name_fa']}
                                                </span>
                                                <h2 class="passengerDetailReservationTour_hotel_text_hotelBed_div_h2">
                                                    ##Count##: {$room['count']} عدد
                                                </h2>
                                                <div class="passengerDetailReservationTour_hotel_text_hotelBed_div_div">
                                                    <i class=""
                                                       style="display: inline-block">
                                                        {if $showTourToman}
                                                            {round($room['total_price']/10)|number_format:0:".":","}
                                                        {else}
                                                            {$room['total_price']|number_format:0:".":","}
                                                        {/if}


                                                        {$iranCurrency}
                                                    </i>
                                                    {if $room['price_a'] gt 0}
                                                        +
                                                        <i class="green-text"
                                                           style="display: inline-block">{$room['total_price_a']|number_format}


                                                            {if $smarty.const.SOFTWARE_LANG neq 'fa'}
                                                                {$objFunctions->changeCurrencyName($room['currency_type'])}
                                                            {else}
                                                                {$room['currency_type']}
                                                            {/if}
                                                        </i>
                                                    {/if}
                                                </div>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        {/if}
                    {/if}
                    <h2 class="passengerDetailReservationTour_title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M296.2 336h-144c-13.2 0-24 10.8-24 24c0 13.2 10.8 24 24 24h144c13.2 0 24-10.8 24-24C320.2 346.8 309.4 336 296.2 336zM296.2 224h-144c-13.2 0-24 10.8-24 24c0 13.2 10.8 24 24 24h144c13.2 0 24-10.8 24-24C320.2 234.8 309.4 224 296.2 224zM352.1 128h-32.07l.0123-80c0-26.51-21.49-48-48-48h-96c-26.51 0-48 21.49-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64c0 17.67 14.4 32 32.07 32s31.94-14.33 31.94-32h128c0 17.67 14.39 32 32.06 32s31.93-14.33 31.93-32c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM176.1 48h96V128h-96V48zM368.2 416c0 8.836-7.164 16-16 16h-256c-8.836 0-16-7.164-16-16V192c0-8.838 7.164-16 16-16h256c8.836 0 16 7.162 16 16V416z"/>
                        </svg>
                        ##TourInformation##
                    </h2>
                    <div class="passengerDetailReservationTour_tour">
                        <div class="tour-details">
                            <div class="box-data-top">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 p-0 py-md-0 py-2">
                                    <div class="box-data-top-item">
                                        <div class="icone-data-tour">
                                            <i class="fa-regular fa-location-dot"></i>
                                        </div>
                                        <div class="text-data-tour">
                                            <span class="box-data-top-titr">##ToursOfCity## :</span>
                                            <span>{$cities|join:', '}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 p-0 py-md-0 py-2">
                                    <div class="box-data-top-item">
                                        <div class="icone-data-tour">
                                            <i class="fa-regular fa-calendar-image"></i>
                                        </div>
                                        <div class="text-data-tour">
                                            <span class="box-data-top-titr">##Wentdate## :</span>
                                            <span>{$smarty.post.startDate}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 p-0 py-md-0 py-2">
                                    <div class="box-data-top-item">
                                        <div class="icone-data-tour">
                                            <i class="fa-regular fa-calendar-week"></i>
                                        </div>
                                        <div class="text-data-tour">
                                            <span class="box-data-top-titr"> ##Returndate## :</span>
                                            <span>{$smarty.post.endDate}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-data-bottom">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="include">
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                {$objFactor->tourBookingInfo['tour_type']}
                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                {if $objFactor->tourBookingInfo['tour_night'] neq 0}{$objFactor->tourBookingInfo['tour_night']} ##Night## {else} {$objFactor->tourBookingInfo['tour_day']} ##Day## {/if}
                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                {if $smarty.const.SOFTWARE_LANG === 'en'}
                                                    {$objFunctions->vehicleEnName($objResult->arrayTour['arrayTypeVehicle']['dept']['type_vehicle_name'])}
                                                {else}
                                                    {$objResult->arrayTour['arrayTypeVehicle']['dept']['type_vehicle_name']}
                                                {/if}



                                                : {$objResult->arrayTour['arrayTypeVehicle']['dept']['airline_name']}
                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                {if $smarty.const.SOFTWARE_LANG === 'en'}
                                                    {$objFunctions->vehicleEnName($objResult->arrayTour['arrayTypeVehicle']['return']['type_vehicle_name'])}
                                                {else}
                                                    {$objResult->arrayTour['arrayTypeVehicle']['return']['type_vehicle_name']}
                                                {/if}



                                                : {$objResult->arrayTour['arrayTypeVehicle']['return']['airline_name']}
                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                ##Special## {$objFactor->tourBookingInfo['tour_reason']}
                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                ##Permissibleamount## :
                                                {if is_numeric($objFactor->tourBookingInfo['tour_free'])  && $objFactor->tourBookingInfo['tour_free'] gt 0 }
                                                    {$objFactor->tourBookingInfo['tour_free']} ##Kg##
                                                {elseif $objFactor->tourBookingInfo['tour_free']}
                                                    {$objFactor->tourBookingInfo['tour_free']}
                                                {else}
                                                    -
                                                {/if}

                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                ##Visa##: {if $objFactor->tourBookingInfo['tour_visa'] eq 'yes'}##Have##{else}##Donthave##{/if}
                                            </li>
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                ##Insurance##: {if $objFactor->tourBookingInfo['tour_insurance'] eq 'yes'}##Have##{else}##Donthave##{/if}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="passengerDetailReservationTour_title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z"/></svg>
                        ##Travelerprofile##
                    </h2>


                    <div class="passengerDetailReservationTour_users passengerDetailReservationTour_users_info">
                        {foreach $objFactor->passenger as $key => $passenger}
                        <div>
                            <h4>##Passenger## {$key}</h4>
                            <div>
                                <div>
                                    <h4>##Name##</h4>
                                    <h5>{$passenger['passenger_name']}</h5>
                                </div>
                                <div>
                                    <h4>##Family##</h4>
                                    <h5>{$passenger['passenger_family']}</h5>
                                </div>
                                {if $passenger['passenger_name_en']}
                                <div>
                                    <h4>##Nameenglish##	</h4>
                                    <h5>{$passenger['passenger_name_en']}</h5>
                                </div>
                                {/if}
                                {if $passenger['passenger_family_en']}
                                <div>
                                    <h4>##Familyenglish##	</h4>
                                    <h5>{$passenger['passenger_family_en']}</h5>
                                </div>
                                {/if}
                                <div>
                                    <h4>##Happybirthday##</h4>
                                    <h5> {if !$passenger['passenger_birthday']} {$passenger['passenger_birthday_en']} {else} {$passenger['passenger_birthday']}{/if}</h5>
                                </div>
                                <div>
                                    <h4>##Numpassport##/##Nationalnumber##	</h4>
                                    <h5>{if !$passenger['passenger_national_code']} {$passenger['passportNumber']} {else} {$passenger['passenger_national_code']}{/if}</h5>
                                </div>
                                {if $passenger['passenger_national_image'] || $passenger['passenger_passport_image']}
                                <div>

                                    {if $passenger['passenger_national_image']}
                                    <h4>##Nationalnumber##</h4>
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/passengersImages/{$passenger['passenger_national_image']}"
                                             alt="{$passenger['passenger_national_code']}"
                                             style="width: 50%;height: auto;">
                                    {elseif $passenger['passenger_passport_image']}
                                        <h4>##Passportphoto##</h4>
                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/passengersImages/{$passenger['passenger_passport_image']}"
                                             alt="{$passenger['passportNumber']}"
                                             style="width: 50%;height: auto;">
                                    {/if}
                                </div>
                                {/if}
                            </div>
                        </div>
                        {/foreach}

                    </div>

                    <h2 class="passengerDetailReservationTour_title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M200.3 81.5C210.9 61.5 231.9 48 256 48s45.1 13.5 55.7 33.5C317.1 91.7 329 96.6 340 93.2c21.6-6.6 46.1-1.4 63.1 15.7s22.3 41.5 15.7 63.1c-3.4 11 1.5 22.9 11.7 28.2c20 10.6 33.5 31.6 33.5 55.7s-13.5 45.1-33.5 55.7c-10.2 5.4-15.1 17.2-11.7 28.2c6.6 21.6 1.4 46.1-15.7 63.1s-41.5 22.3-63.1 15.7c-11-3.4-22.9 1.5-28.2 11.7c-10.6 20-31.6 33.5-55.7 33.5s-45.1-13.5-55.7-33.5c-5.4-10.2-17.2-15.1-28.2-11.7c-21.6 6.6-46.1 1.4-63.1-15.7S86.6 361.6 93.2 340c3.4-11-1.5-22.9-11.7-28.2C61.5 301.1 48 280.1 48 256s13.5-45.1 33.5-55.7C91.7 194.9 96.6 183 93.2 172c-6.6-21.6-1.4-46.1 15.7-63.1S150.4 86.6 172 93.2c11 3.4 22.9-1.5 28.2-11.7zM256 0c-35.9 0-67.8 17-88.1 43.4c-33-4.3-67.6 6.2-93 31.6s-35.9 60-31.6 93C17 188.2 0 220.1 0 256s17 67.8 43.4 88.1c-4.3 33 6.2 67.6 31.6 93s60 35.9 93 31.6C188.2 495 220.1 512 256 512s67.8-17 88.1-43.4c33 4.3 67.6-6.2 93-31.6s35.9-60 31.6-93C495 323.8 512 291.9 512 256s-17-67.8-43.4-88.1c4.3-33-6.2-67.6-31.6-93s-60-35.9-93-31.6C323.8 17 291.9 0 256 0zM192 224a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm160 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM337 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L175 303c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L337 209z"></path></svg>
                        ##RegisterDiscountCode##
                    </h2>
                    <div class="passengerDetailReservationTour_tour">
                        <div class="discount-code-new">
                            <div class="discount-code-data">
                                <h3>##IfYouHaveAdiscountCode##</h3>
                                <div class="form-discount-code">
                                    <input type="text" placeholder="##Codediscount## ..." id="discount-code">
                                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode"
                                           value="{$PriceTotal}"/>
                                    <button type="button" onclick="setDiscountCode('{$serviceType}', '{$CurrencyCode}')" class="site-bg-main-color">
                                        ##Apply##
                                    </button>
                                </div>
                                    <span class="discount-code-error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 px-lg-3 px-0">
                    <aside class="passengerDetailReservationTour_aside">
                        <h2 class="passengerDetailReservationTour_aside_title_main">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M472.8 168.4C525.1 221.4 525.1 306.6 472.8 359.6L360.8 472.9C351.5 482.3 336.3 482.4 326.9 473.1C317.4 463.8 317.4 448.6 326.7 439.1L438.6 325.9C472.5 291.6 472.5 236.4 438.6 202.1L310.9 72.87C301.5 63.44 301.6 48.25 311.1 38.93C320.5 29.61 335.7 29.7 344.1 39.13L472.8 168.4zM144 143.1C144 161.7 129.7 175.1 112 175.1C94.33 175.1 80 161.7 80 143.1C80 126.3 94.33 111.1 112 111.1C129.7 111.1 144 126.3 144 143.1zM410.7 218.7C435.7 243.7 435.7 284.3 410.7 309.3L277.3 442.7C252.3 467.7 211.7 467.7 186.7 442.7L18.75 274.7C6.743 262.7 0 246.5 0 229.5V80C0 53.49 21.49 32 48 32H197.5C214.5 32 230.7 38.74 242.7 50.75L410.7 218.7zM48 79.1V229.5C48 233.7 49.69 237.8 52.69 240.8L220.7 408.8C226.9 415.1 237.1 415.1 243.3 408.8L376.8 275.3C383.1 269.1 383.1 258.9 376.8 252.7L208.8 84.69C205.8 81.69 201.7 79.1 197.5 79.1L48 79.1z"/>
                            </svg>
                            ##Bill##
                        </h2>
                        <div class="passengerDetailReservationTour_aside_box">
                            <h2 class="passengerDetailReservationTour_aside_title">
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    {$objFactor->tourBookingInfo['tour_name']}
                                {else}
                                    {$objFactor->tourBookingInfo['tour_name_en']}
                                {/if}
                                ({$objFactor->tourBookingInfo['tour_code']})
                            </h2>

                            <div class="passengerDetailReservationTour_aside_lastBox">
                                {if $priceChanged neq 0}
                                    <div class="discount">
                                        <span> ##IncreasePrice## :</span>
                                        <span>{$priceChanged|number_format}
                                    <p>{$iranCurrency} :</p>
                                    {assign var="changedPrePaymentPrice" value=$prePaymentPrice}
                                            {$changedPrePaymentPrice|number_format:0:".":","}
                                    <p>{$iranCurrency}</p>
                                </span>
                                    </div>
                                {/if}
                                {if $objFactor->tourBookingInfo['prepayment_percentage'] neq 0}
                                    {if $smarty.post.typeTourReserve neq 'oneDayTour'}
                                        {assign var="prePaymentPrice" value=$objResult->prePaymentCalculate($arrayTourPackage['total_price_package'] , $objFactor->tourBookingInfo['prepayment_percentage'])}
                                    {else}
                                        {assign var="prePaymentPrice" value=$objResult->prePaymentCalculate($smarty.post.totalPrice)}
                                    {/if}
                                    <div class="prepayment">
                                        <span>  ##Prereserve## :</span>
                                        <span> {$prePaymentPrice|number_format:0:".":","} <p>{$iranCurrency}</p></span>
                                    </div>
                                {/if}
                                <div class="price">
                                    <span>##TotalPrice## : </span>
                                    <span>

                                    {if $smarty.post.typeTourReserve neq 'oneDayTour'}
                                        {assign var="total_price" value= ($arrayTourPackage['total_price_package'] )}
                                    {else}
                                        {assign var="total_price" value= ($smarty.post.totalPrice)}
                                    {/if}
                                        {$total_price|number_format:0:".":","}
                                    <p>{$iranCurrency}</p>
                                </span>
                                </div>
                                <p class="s-u-result-item-RulsCheck-item">
                                    {assign var="totalCurrency" value=$objFunctions->CurrencyCalculate($smarty.post.paymentPrice, $CurrencyCode)}

                                    {assign var="serviceType" value=$objFunctions->getTypeServiceTour('reservation', $smarty.post.idTour)} {* لازم برای انتخاب نوع بانک *}
                                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                                    <div class="s-u-result-item-RulsCheck-item">
{*                                        <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code"*}
{*                                               name="" value="" type="checkbox">*}
{*                                        <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code">*}
{*                                            ##Ihavediscountcodewantuse##*}
{*                                        </label>*}

                                        <div class="col-sm-12  parent-discount">
{*                                            <div class="row separate-part-discount">*}
{*                                                <div class='parent-input-btn-cod-discount'>*}
{*                                                    <div>*}
{*                                                    <label for="discount-code">##RegisterDiscountCode##</label>*}
{*                                                    <input type="text" id="discount-code" class="form-control" placeholder='##Codediscount##'>*}
{*                                                    </div>*}
{*                                                    <div>*}
{*                                                        <span class="input-group-btn">*}
{*                                                            <input type="hidden" name="priceWithoutDiscountCode"*}
{*                                                                   id="priceWithoutDiscountCode" value="{$totalCurrency.AmountCurrency}"/>*}
{*                                                            <button type="button"*}
{*                                                                    onclick="setDiscountCode('{$serviceType}', '{$CurrencyCode}')"*}
{*                                                                    class="site-secondary-text-color site-main-button-flat-color btn-code-discount iranR discount-code-btn">##Apply##*}
{*                                                            </button>*}
{*                                                        </span>*}
{*                                                    </div>*}
{*                                                </div>*}
{*                                                <div class="parent-code-error">*}
{*                                                    <span class="discount-code-error"></span>*}
{*                                                </div>*}
{*                                            </div>*}




                                            <div class="row separate-part-discount">
                                                <div class="info-box__price info-box__item pull-left">
                                                    <div class="item-discount">
                                                        <span class="item-discount__label">##Amountpayable## :</span>
                                                        <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($totalCurrency.AmountCurrency)}</span>
                                                        <span class="price__unit-price">{$totalCurrency.TypeCurrency}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {/if}



                                    <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                                           name="heck_list1" value="" type="checkbox">
                                    <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                                        <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a>
                                        ##IhavestudiedIhavenoobjection##

                                    </label>
                                </p>
                                <button id="final_ok_and_insert_passenger"
                                        onclick="reserveTourTemprory('{$factorNumber}')">##Approvefinal##</button>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>


    {if $smarty.post.totalPriceA gt 0}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change ">
            <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12">

                    {assign var="TotalPrice" value="<i style='color: green;font-size: 14px;font-weight: 700;'>`$smarty.post.totalPriceA`</i>"}
                    {assign var="currencyTitleFa" value=$smarty.post.currencyTitleFa}
                    {assign var="ClientName" value=$smarty.const.CLIENT_NAME}
                    {functions::StrReplaceInXml(["@@TotalPrice@@"=>$TotalPrice,"@@currencyTitleFa@@"=>$currencyTitleFa,"@@ClientName@@"=>$ClientName],"DoingReserve")}

                </span>
            </div>
        </div>
    {/if}


    <input type="hidden" id="idTour" name="idTour" value="{$smarty.post.idTour}">
    <input type="hidden" id="passengerCount" name="passengerCount" value="{$smarty.post.passengerCount}">
    <input type="hidden" id="cities" name="cities" value="{$smarty.post.cities}">
    <input type="hidden" id="startDate" name="startDate" value="{$smarty.post.startDate}">
    <input type="hidden" id="endDate" name="endDate" value="{$smarty.post.endDate}">
    <input type="hidden" id="totalPrice" name="totalPrice" value="{$smarty.post.totalPrice}">
    <input type="hidden" id="totalOriginPrice" name="totalOriginPrice" value="{$smarty.post.totalOriginPrice}">
    <input type="hidden" id="paymentPrice" name="paymentPrice" value="{$smarty.post.paymentPrice}">
    <input type="hidden" id="factorNumber" name="factorNumber" value="{$factorNumber}">
    <input type="hidden" name="typeApplication" id="typeApplication" value="reservation">
    <input type="hidden" name="idMember" id="idMember" value="{$idMember}">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  "
         style="padding: 0">
        <div class="s-u-result-wrapper">
            <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                <div style="text-align: right">
                    {assign var="totalCurrency" value=$objFunctions->CurrencyCalculate($smarty.post.paymentPrice, $CurrencyCode)}

                    {assign var="serviceType" value=$objFunctions->getTypeServiceTour('reservation', $smarty.post.idTour)} {* لازم برای انتخاب نوع بانک *}
                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
{*                        <div class="s-u-result-item-RulsCheck-item">*}
{*                            <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code"*}
{*                                   name="" value="" type="checkbox">*}
{*                            <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code">*}
{*                                ##Ihavediscountcodewantuse##*}
{*                            </label>*}

{*                            <div class="col-sm-12  parent-discount displayiN ">*}
{*                                <div class="row separate-part-discount">*}
{*                                    <div class="col-sm-6 col-xs-12">*}
{*                                        <label for="discount-code">##Codediscount## :</label>*}
{*                                        <input type="text" id="discount-code" class="form-control">*}
{*                                    </div>*}
{*                                    <div class="col-sm-2 col-xs-12">*}
{*                                    <span class="input-group-btn">*}
{*                                        <input type="hidden" name="priceWithoutDiscountCode"*}
{*                                               id="priceWithoutDiscountCode" value="{$totalCurrency.AmountCurrency}"/>*}
{*                                        <button type="button"*}
{*                                                onclick="setDiscountCode('{$serviceType}', '{$CurrencyCode}')"*}
{*                                                class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>*}
{*                                    </span>*}
{*                                    </div>*}
{*                                    <div class="col-sm-4 col-xs-12">*}
{*                                        <span class="discount-code-error"></span>*}
{*                                    </div>*}
{*                                </div>*}
{*                                <div class="row separate-part-discount">*}
{*                                    <div class="info-box__price info-box__item pull-left">*}
{*                                        <div class="item-discount">*}
{*                                            <span class="item-discount__label">##Amountpayable## :</span>*}
{*                                            <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($totalCurrency.AmountCurrency)}</span>*}
{*                                            <span class="price__unit-price">{$totalCurrency.TypeCurrency}</span>*}
{*                                        </div>*}
{*                                    </div>*}
{*                                </div>*}
{*                            </div>*}
{*                        </div>*}
                    {/if}
{*                    <p class="s-u-result-item-RulsCheck-item">*}
{*                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"*}
{*                               name="heck_list1" value="" type="checkbox">*}
{*                        <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">*}
{*                            <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a>*}
{*                            ##IhavestudiedIhavenoobjection##*}

{*                        </label>*}
{*                    </p>*}
                </div>
            </div>
        </div>
    </div>
{*    <div class="btns_factors_n">*}
{*    <div class="btn-final-confirmation" id="btn-final-Reserve">*}

{*        <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check"*}
{*           style="display:none"></a>*}
{*        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color"*}
{*           id="final_ok_and_insert_passenger"*}
{*           onclick="reserveTourTemprory('{$factorNumber}')">##Approvefinal## </a>*}
{*    </div>*}
{*    </div>*}

    <div id="messageBook" class="error-flight"></div>


    {/if}

</div>
<!-- bank connect -->
    <div class="main-pay-content">

        <!-- payment methods drop down -->
        {assign var="memberCreditPermition" value="0"}
        {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
            {$memberCreditPermition = "1"}
        {/if}

        {assign var="counterCreditPermition" value="0"}
        {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
            {$counterCreditPermition = "1"}
        {/if}

        {assign var="bankInputs" value=['type_service'=>'tour','flag' => 'check_credit_tour', 'factorNumber' => $factorNumber, 'paymentStatus' => $paymentStatusValue, 'serviceType' => $serviceType]}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankTourLocal"}

        {assign var="creditInputs" value=['flag' => 'buyByCreditTourLocal', 'factorNumber' => $factorNumber, 'paymentStatus' => $paymentStatusValue]}
        {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankTourLocal"}

        {assign var="currencyPermition" value="0"}
        {if $smarty.const.ISCURRENCY && $CurrencyCode > 0}
            {$currencyPermition = "1"}
            {assign var="currencyInputs" value=['flag' => 'check_credit_tour', 'factorNumber' => $factorNumber, 'paymentStatus' => $paymentStatusValue, 'serviceType' => $serviceType, 'amount' => $totalCurrency.AmountCurrency, 'currencyCode' => $CurrencyCode]}
            {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankTourLocal"}
        {/if}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
        <!-- payment methods drop down -->

</div>


{literal}
    <script src="assets/js/html5gallery.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

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
    </script>
{/literal}

