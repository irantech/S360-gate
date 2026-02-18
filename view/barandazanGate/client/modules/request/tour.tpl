
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
                            ##Count##: {$room['count']} ##Number##
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
            ##Roominformation##
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
                            ##Count##: {$room['count']} ##Number##
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
                        <span>{$date[0]}</span>
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
                        <span>{$date[1]}</span>
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
                            {$infoTour['tour_type']}
                        </li>
                        <li class="list-unstyled">
                            <i class="fa-solid fa-check"></i>
                            {if $infoTour['night'] neq 0}{$infoTour['night']} ##Night## {else} {$infoTour['day']} ##Day## {/if}
                        </li>

                        <li class="list-unstyled">
                            <i class="fa-solid fa-check"></i>
                            {if $smarty.const.SOFTWARE_LANG === 'en'}
                                {$objFunctions->vehicleEnName($objResult->arrayTour['arrayTypeVehicle']['dept']['type_vehicle_name'])}:
                            {else}
                                {$objResult->arrayTour['arrayTypeVehicle']['dept']['type_vehicle_name']}:
                            {/if}



                             {$objResult->arrayTour['arrayTypeVehicle']['dept']['airline_name']}
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
                            ##Special## {$infoTour['tour_reason']}
                        </li>
                        <li class="list-unstyled">
                            <i class="fa-solid fa-check"></i>
                            ##Permissibleamount## :
                            {if is_numeric($infoTour['free'])  && $infoTour['free'] gt 0 }
                                {$infoTour['free']} ##Kg##
                            {elseif $infoTour['free']}
                                {$infoTour['free']}
                            {else}
                                -
                            {/if}
                        </li>
                        <li class="list-unstyled">
                            <i class="fa-solid fa-check"></i>
                            ##Visa##: {if $infoTour['visa'] eq 'yes'}##Have##{else}##Donthave##{/if}
                        </li>
                        <li class="list-unstyled">
                            <i class="fa-solid fa-check"></i>
                            ##Insurance##: {if $infoTour['insurance'] eq 'yes'}##Have##{else}##Donthave##{/if}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


