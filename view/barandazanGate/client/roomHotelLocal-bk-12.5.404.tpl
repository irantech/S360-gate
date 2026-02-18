<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="resultHotelLocal" assign="objResult"}
{assign var="typeApplication" value=$smarty.const.TYPE_APPLICATION}
{assign var="hotelId" value=$smarty.const.HOTEL_ID}
{assign var="hotelNameEn" value=$smarty.const.HOTEL_NAME_EN}
{assign var="nights" value=$smarty.const.NIGHTS}

{if $smarty.const.START_DATE neq ''}

    {assign var="startDate" value=$smarty.const.START_DATE}
{else}

    {assign var="startDate" value=$objResult->getStartDateToday()}
{/if}



{assign var="isShowReserve" value=$smarty.const.IS_SHOW_RESERVE}
{assign var="isExternal" value=$smarty.const.IS_EXTERNAL}
{assign var="currencyCode" value=$smarty.const.CURRENCY_CODEE}


<code style="display: none;">{$smarty.request|json_encode}</code>


{$objResult->getHotel($hotelId, $typeApplication)}
{assign var="idCity" value=$objResult->SearchHotel.AddressInfo.CityCode}
{assign var="CityName" value=$objResult->getCity($idCity)}
{$objResult->checkSellForNight($hotelId, $nights, $typeApplication)}
{assign var="endDate" value=$objResult->computingEndDate($startDate, $objResult->stayingTime)}


<!-- login and register popup -->
{assign var="useType" value="hotel"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


<div class="container" id="hotelDetailContainer">

    <div class="row">
        <div id="steps">
            <div class="steps_items">
                <div class="step done ">
                    <span class=""><i class="fa fa-check"></i></span>
                    <h3>##Selectionhotel##</h3>
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
                    <h3>##StayInformation##</h3>

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
                    <h3> ##PassengersInformation## </h3>
                </div>
                <i class="separator"></i>
                <div class="step" >
                    <span class="flat_icon_airplane">
                       <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                            width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                            preserveAspectRatio="xMidYMid meet">
                            <metadata>
                            Created by potrace 1.16, written by Peter Selinger 2001-2019
                            </metadata>
                            <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
                               fill="#000000" stroke="none">
                            <path d="M499 1247 c-223 -115 -217 -433 9 -544 73 -36 182 -38 253 -6 237
                            107 248 437 17 552 -52 27 -72 31 -139 31 -68 0 -85 -4 -140 -33z m276 -177
                            c19 -21 18 -22 -75 -115 l-94 -95 -53 52 -53 52 22 23 22 23 31 -30 31 -30 69
                            70 c38 39 72 70 76 70 3 0 14 -9 24 -20z"/>
                            <path d="M70 565 l0 -345 570 0 570 0 0 345 0 345 -104 0 -104 0 -6 -34 c-9
                            -47 -75 -146 -124 -184 -75 -60 -126 -77 -232 -77 -106 0 -157 17 -232 77 -49
                            38 -115 137 -124 184 l-6 34 -104 0 -104 0 0 -345z m980 -150 l0 -105 -145 0
                            -145 0 0 105 0 105 145 0 145 0 0 -105z m-410 -75 l0 -30 -205 0 -205 0 0 30
                            0 30 205 0 205 0 0 -30z"/>
                            <path d="M0 150 c0 -45 61 -120 113 -139 39 -15 1015 -15 1054 0 52 19 113 94
                            113 139 0 7 -207 10 -640 10 -433 0 -640 -3 -640 -10z"/>
                            </g>
                       </svg>
                    </span>
                    <h3> ##Reservationhotel## </h3>
                </div>
            </div>
            <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                 style="direction: ltr"> 06:00</div>
        </div>
        <div class="col-lg-9 col-md-12  col-sm-12 col-12 col-padding-5 right_hotel_section">


            <div class="internal-hotel-name p-3 d-flex align-items-center flex-wrap justify-content-between">

                {if $objResult->whole > 0}
                    <div class="hotel-rate-outer tripAdvizer">
                        <div class="hotel-rate">

                            <div class="hotel-rate-text">
                                <span class="tripadvisor-logo">
                                    <img src="assets/images/1200px-TripAdvisor_logo.png">
                                </span>
                                <span class="tripadvisor-number">{$objResult->SearchHotel.tripAdvisor}</span>
                            </div>

                            <div class="rp-cel-hotel-star">
                                <span class="tripadvisor-box tripadvisor-box-external-hotel">
                                    <ul class="tripadvisorUL">
                                        {for $s=1 to $objResult->whole}
                                            <li class="tripadvisor full"></li>
                                        {/for}
                                        {if $objResult->fraction neq 0}
                                            <li class="tripadvisor half"></li>
                                            {$s = $s + 1}
                                        {/if}
                                        {for $ss=$s to 5}
                                            <li class="tripadvisor"></li>
                                        {/for}
                                    </ul>
                                </span>
                            </div>
                        </div>
                    </div>
                {/if}

                {$objResult->getNumberTripAdvisor($objResult->SearchHotel.tripAdvisor)}
                <div class="hotel-name text-right">

                    <h2>
                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                            {$objResult->SearchHotel['Name']}
                        {else}
                            {$objResult->SearchHotel['NameEn']}
                        {/if}
                    </h2>
                    <div class="hotel-rate">
                        <div class="rp-cel-hotel-star">
                            <span class="rp-cel-hotel-star_span">
                                {functions::StrReplaceInXml(["@@count@@"=>$objResult->SearchHotel.StarCode],"starText")}
                            </span>

                            {if $objResult->SearchHotel.StarCode gt 0}
                                {for $s=1 to $objResult->SearchHotel.StarCode}
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                {/for}
                                {*                                {for $ss=$s to 5}*}
                                {*                                    <i class="fa fa-star-o" aria-hidden="true"></i>*}
                                {*                                {/for}*}
                            {else}
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            {/if}
                        </div>
                    </div>
                    <div class="internal-hotel-address {if $isExternal eq 'no'}txtRight{/if}">
                        <span> ##Address## : </span>
                        <span>
                                 {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                     {{$objResult->SearchHotel.AddressInfo.Address}}
                                 {else}
                                     {{$objResult->SearchHotel.AddressInfo.Address_en}}
                                 {/if}

                            </span>
                    </div>
                </div>
                {if $objResult->SearchHotel['transfer']}
                    <div class='hotel-rate-outer'>
                        <div class="hotel-transfer">
                            <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M39.61 196.8L74.8 96.29C88.27 57.78 124.6 32 165.4 32H346.6C387.4 32 423.7 57.78 437.2 96.29L472.4 196.8C495.6 206.4 512 229.3 512 256V400H0V256C0 229.3 16.36 206.4 39.61 196.8V196.8zM109.1 192H402.9L376.8 117.4C372.3 104.6 360.2 96 346.6 96H165.4C151.8 96 139.7 104.6 135.2 117.4L109.1 192zM96 256C78.33 256 64 270.3 64 288C64 305.7 78.33 320 96 320C113.7 320 128 305.7 128 288C128 270.3 113.7 256 96 256zM416 320C433.7 320 448 305.7 448 288C448 270.3 433.7 256 416 256C398.3 256 384 270.3 384 288C384 305.7 398.3 320 416 320z"/><path class="fa-secondary" d="M346.6 96C360.2 96 372.3 104.6 376.8 117.4L402.9 192H109.1L135.2 117.4C139.7 104.6 151.8 96 165.4 96H346.6zM0 400H96V448C96 465.7 81.67 480 64 480H32C14.33 480 0 465.7 0 448V400zM512 448C512 465.7 497.7 480 480 480H448C430.3 480 416 465.7 416 448V400H512V448z"/></svg></i>
                            <div>
                                <h2>##HotelTransfer##</h2>
                                <span>##Free##</span>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>

            {if count($objResult->SearchHotel.HotelPictures) gt 0 }
                <div id='gallery-section' class="hotel-khareji-thumb">
                    <div class="hotel-thumb-carousel owl-carousel">
                        {foreach $objResult->SearchHotel.HotelPictures as $PicHotel}
                            {if $PicHotel.Name != ''}
                                {assign var="pic_name" value=$PicHotel.Name}
                            {else}
                                {assign var="pic_name" value=$objResult->SearchHotel.Name}
                            {/if}
                            {if $PicHotel.Format eq 'webm'}
                                {*<a href="{$PicHotel.Url}" data-webm="{$PicHotel.Url}">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/video-player.png" alt="{$PicHotel.Name}">
                                </a>*}
                            {else}
                                <div class="hotel-thumb-item">
                                    <a data-fancybox="gallery " href="{$PicHotel.Url}">
                                        <img src="{$PicHotel.Url}" alt="{$pic_name}">
                                    </a>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>

            {/if}


            <!-- detail room -->
            {if $typeApplication eq 'reservation' && $isShowReserve neq 'no'}

                {$objResult->getHotelRoom($hotelId)}
                {$objResult->getHotelRoomPrices($hotelId, $startDate, $endDate)}
                {$objResult->getInfoRoom($hotelId)}

                {assign var="idHotel" value=$hotelId}
                {assign var="idCity" value=$idCity}
                {assign var="number_night" value=$objResult->stayingTime}
                {assign var="typeApplication" value=$typeApplication}
                <div class="container">
                    <div class="row">
                        <form action="" method="post" id="formHotelReserve"
                              style="width: 100%;">
                            <input name="serviceName" id="serviceName" type="hidden" value="hotel">
                            <input id="is_request" name="is_request" type="hidden" value="{if $objResult->SearchHotel['is_request'] eq 1}1{else}0{/if}">
                            <input id="factorNumber" name="factorNumber" type="hidden" value="">
                            <input id="CurrencyCode" name="CurrencyCode" type="hidden" value='{$currencyCode}'/>
                            {if $objResult->SearchHotel['is_request'] neq 1}
                                <input id="href" name="href" type="hidden" value="passengersDetailReservationHotel">
                            {else}
                                <input id="href" name="href" type="hidden" value="submitRequest">
                            {/if}

                            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`reservationHotelRoomPrice.tpl"}
                        </form>
                    </div>
                </div>
            {elseif $typeApplication eq 'api'}
                <div class="container">
                    <div class="row" id="resultRoomHotel">
                        <div class="roomHotelLocal">
                            <div class="loader-box-user-buy">
                                <span></span>
                                <span>##Loading##</span>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            <!-- end detail room -->


            <div class="hotel-panel">

                <div id='detail-section' class="hotel-desc">

                    <div class="tabHotel">
                        <div class="tabHotel__buttons">
                            <button onclick="tabHotel('tabHotel__box_1' , event.target)" class="hotel-fea-title tabHotel__btns tabHotel__btns--active">##Descriptionhotel##</button>
                            <button onclick="tabHotel('tabHotel__box_2' , event.target)" class="hotel-fea-title tabHotel__btns">##OsafarTermsandConditions##</button>
                        </div>
                        <div class="tabHotel__boxes">
                            <div id="tabHotel__box_1" class="tabHotel__box tabHotel__box--active">
                                <p {if $isExternal eq 'no'} class="txtRight"{/if}>
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                        {$objResult->SearchHotel.Comment}
                                    {else}
                                        {$objResult->SearchHotel.Comment_en}
                                    {/if}
                                </p>
                            </div>
                            <div id="tabHotel__box_2" class="tabHotel__box" style="display:none">
                                <div class="rulesHotel">
                                    <div class="rulesHotel__box">
                                        <h4 class="rulesHotel__title text-right">##Exitrules##</h4>
                                        <div class="rulesHotel__answer">
                                            {if $objResult->SearchHotel.EntryHour neq '' && $objResult->SearchHotel.LeaveHour neq ''}

                                                {assign var="EntryHour" value=$objResult->SearchHotel.EntryHour}
                                                {assign var="LeaveHour" value=$objResult->SearchHotel.LeaveHour}
                                                {functions::StrReplaceInXml(["@@EntryHour@@"=>$EntryHour,"@@LeaveHour@@"=>$LeaveHour],"skanRoomUser")}
                                            {else}
                                                {functions::StrReplaceInXml(["@@EntryHour@@"=>"12:00","@@LeaveHour@@"=>"14:00"],"skanRoomUser")}
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="rulesHotel__box">
                                        <h4 class="rulesHotel__title text-right">##Youngrules##</h4>
                                        <div class="rulesHotel__answer">{if $objResult->SearchHotel.ChildHalfPriceCode neq ""}
                                                {assign var="countRule" value=$objResult->SearchHotel.ChildHalfPriceCode|count_characters}
                                                {*                                                <p class="hotel-description slideHotelDescriptionMin {if $countRule lt 200}height126{/if}">*}
                                                {$objResult->SearchHotel.ChildHalfPriceCode}
                                                {*                                                </p>*}
                                            {elseif $objResult->SearchHotel.ChildDescription neq ""}
                                                {assign var="countRule" value=$objResult->SearchHotel.ChildDescription|count_characters}
                                                {*                                                <p class="hotel-description slideHotelDescriptionMin {if $countRule lt 200}height126{/if}">*}
                                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                    {$objResult->SearchHotel.ChildDescription}
                                                {else}
                                                    {$objResult->SearchHotel.ChildDescription_en}
                                                {/if}
                                                {*                                                </p>*}
                                            {else}
                                                {*                                                <p class="hotel-description slideHotelDescriptionMin height126">*}
                                                ##Chd5##
                                                {*                                                </p>*}
                                            {/if}

                                            {*                                            {if $countRule gt 200}*}
                                            {*                                                <span class="maxlist-more slideDownHotelDescription"> <a> ##Open## </a></span>*}
                                            {*                                                <span class="maxlist-more slideUpHotelDescription displayiN"><a> ##Close## </a></span>*}
                                            {*                                            {/if}*}
                                        </div>
                                    </div>
                                    <div class="rulesHotel__box">
                                        <h4 class="rulesHotel__title text-right">##Cancellationrules##</h4>
                                        <div class="rulesHotel__answer">  {if $objResult->SearchHotel.CancellationConditions neq ''}
                                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                    {assign var="countCancellation" value=$objResult->SearchHotel.CancellationConditions|count_characters}
                                                {else}
                                                    {assign var="countCancellation" value=$objResult->SearchHotel.CancellationConditions_en|count_characters}
                                                {/if}
                                                {*                                                <p class="hotel-description slideHotelDescriptionMin {if $countCancellation lt 150}height126{/if}">*}
                                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                    {$objResult->SearchHotel.CancellationConditions}
                                                {else}
                                                    {$objResult->SearchHotel.CancellationConditions_en}
                                                {/if}
                                                {*                                                </p>*}
                                                {*                                                {if $countCancellation gt 150}*}
                                                {*                                                    <span class="maxlist-more slideDownHotelDescription"> <a> ##Open## </a></span>*}
                                                {*                                                    <span class="maxlist-more slideUpHotelDescription displayiN"><a> ##Close## </a></span>*}
                                                {*                                                {/if}*}
                                            {else}
                                                {*                                                <p class="hotel-description slideHotelDescriptionMin">*}
                                                ##Hotelcancelation##
                                                {*                                                </p>*}
                                                {*                                                <span class="maxlist-more slideDownHotelDescription"> <a> ##Open## </a></span>*}
                                                {*                                                <span class="maxlist-more slideUpHotelDescription displayiN"><a> ##Close## </a></span>*}
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {if !empty($objResult->SearchHotel.HotelFacilityList)}
                        <div class="hotel-fea" id='facilities-section'>
                            <div class="hotel-fea-title">##PossibilitiesHotel##</div>
                            <div class="hotel-fea-inner">

                                {assign var="classHotelFacility" value="ravis-icon-hotel"}
                                {foreach $objResult->SearchHotel.HotelFacilityList as $HFacilities}
                                    {if $objResult->HotelFacilityList[$HFacilities]}
                                        {$classHotelFacility=$objResult->HotelFacilityList[$HFacilities]}
                                    {/if}
                                    <div title="{$HFacilities}" class="hotel-fea-item-2"><i
                                                class="site-bg-main-color {$classHotelFacility}"></i>{$HFacilities}
                                    </div>
                                {/foreach}

                            </div>
                        </div>
                    {/if}
                    {if $typeApplication eq 'reservation'}
                        {assign var="countLine" value=$objResult->countLine($objResult->SearchHotel.DistanceToImportantPlaces)}


                        <div class="hotel-fea">
                            <div class="filtertip-searchbox">
                                <div class="box-external-hotel-detail">
                                    <div class="rp-hotel-box">
                                        <div id="mapDiv" class="gmap3"></div>
                                    </div>
                                </div>
                            </div>
                            {if $objResult->SearchHotel.DistanceToImportantPlaces || $objResult->SearchHotel.DistanceToImportantPlaces_en}
                                <div class="hotel-fea-title">##Nearhotel##</div>
                                <div class="NearHotel">
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                        {$objResult->SearchHotel.DistanceToImportantPlaces}
                                    {else}
                                        {$objResult->SearchHotel.DistanceToImportantPlaces_en}
                                    {/if}
                                </div>
                            {/if}



                        </div>
                        {if $objResult->SearchHotel['iframe_code']}
                            <div class="search-hotel-prent-iframe">
                                <iframe src="{$objResult->SearchHotel['iframe_code']}"></iframe>

                            </div>
                        {/if}

                    {elseif $typeApplication eq 'api'}
                        <div class="hotel-fea" id='facilities-section'>
                            <div class="hotel-fea-title">##PossibilitiesRoom##</div>
                            <div class="hotel-fea-inner">
                                {assign var="classRoomFacility" value="ravis-icon-hotel-room"}
                                {foreach $objResult->SearchHotel.RoomFacilitiesList as $RFacilities}
                                    {if $objResult->RoomFacilitiesList[$RFacilities]}
                                        {$classRoomFacility=$objResult->RoomFacilitiesList[$RFacilities]}
                                    {/if}
                                    <div title="{$RFacilities}" class="hotel-fea-item-2"><i
                                                class="site-bg-main-color {$classRoomFacility}"></i>{$RFacilities}</div>
                                {/foreach}
                            </div>
                        </div>


                    {/if}

                </div>

            </div>

        </div>
        <div class="col-lg-3 col-md-12 col-sm-12 col-12 col-padding-5 sidebar-detailHotel">
            <div class="filter_hotel_boxes">
                {if $isShowReserve neq 'no'}

{*                    <div class="filterBox Reserve_box_detail">*}
{*                        <div class="filtertip_hotel_detail site-bg-main-color site-bg-color-border-bottom ">*}
{*                            <p class="txt14">##Reserve##</p>*}
{*                        </div>*}
{*                        <div class="filtertip-searchbox filtertip-searchbox-box1">*}
{*                            <div class="">*}
{*                                <div class="box-reserve-hotel-fix-items-2">*}
{*                                    <span><b class="roomFinalTxt">0 ##Selectedroom## </b> ##For## {$nights} ##Timenight##</span>*}
{*                                    <div class="parent-fixed--new--flex">*}
{*                                        <span class="roomFinalPrice site-main-text-color">0 <i>##Rial##</i></span>*}
{*                                        {if $objResult->SearchHotel.prepayment_percentage gt 0}*}
{*                                            <div class='roomFinalPrepaymentPackage' style='width:100%;text-align: center;' >*}
{*                                        <span> پیش پرداخت :*}
{*                                        {$objResult->SearchHotel.prepayment_percentage} %</span>*}
{*                                            </div>*}
{*                                        {/if}*}
{*                                        <div class='roomFinalPrepaymentPackagePrice' style='width:100%;text-align: center;'></div>*}

{*                                        <span class="roomFinalBtn multi-rooms-price-btn-container">*}
{*                                        <button id="btnReserve" type="button" disabled="disabled" class="site-secondary-text-color site-bg-main-color site-main-button-color-hover" onClick="ReserveHotel()">*}
{*                                            ##Reservation##*}
{*                                        </button>*}
{*                                        <img class="imgLoad" src="assets/images/load2.gif" id="img"/>*}
{*                                    </span>*}
{*                                    </div>*}
{*                                </div>*}
{*                            </div>*}
{*                        </div>*}
{*                    </div>*}



                    <div class="filterBox">
{*                        <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">*}
{*                            <p class="txt14">##Repeatsearch##</p>*}
{*                        </div>*}
                        <span class="City">##Hotel## {$objResult->SearchHotel['Name']}
{*                                            <i class="ravis-icon-hotel icon_hotel_ site-main-text-color"></i>*}
                        </span>
                        <div class="filtertip-searchbox filtertip-searchbox-box1">
                            <div class="box-external-hotel-detail">
                                <form action="" method="post" id="formHotel">

                                    <input id="page" name="page" type="hidden" value="roomHotelLocal">
                                    <input id="idHotel_select" name="idHotel_select" type="hidden" value="{$hotelId}">
                                    <input id="typeApplication" name="typeApplication" type="hidden"
                                           value="{$typeApplication}">
                                    <input id="idCity" name="idCity" type="hidden" value="{$idCity}">
                                    <input id="nights" name="nights" type="hidden" value="{$objResult->stayingTime}">
                                    <input id="CurrencyCode" name="CurrencyCode" type="hidden" value='{$currencyCode}'/>

                                    <div class="filtertip-searchbox filtertip-searchbox-box1">

                                        <div class="form-hotel-room-item form-hotel-item-searchBox-date  ">

{*                                        <span class="City"> {$objResult->SearchHotel['Name']}*}
{*                                            <i class="ravis-icon-hotel icon_hotel_ site-main-text-color"></i>*}
{*                                        </span>*}
                                        </div>
                                        {assign var="classNameStartDate" value="shamsiDeptCalendarToCalculateNights"}
                                        {assign var="classNameEndDate" value="shamsiReturnCalendarToCalculateNights"}
                                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $smarty.const.SEARCH_START_DATE|substr:0:4 gt 2000}
                                            {$classNameStartDate="deptCalendarToCalculateNights"}
                                        {/if}
                                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $search_end_date|substr:0:4 gt 2000}
                                            {$classNameEndDate="returnCalendarToCalculateNights"}
                                        {/if}
                                        <div class="form-hotel-item  form-hotel-item-searchBox-date">
                                            <div class="input parent-box-input">
                                                <div class="parent-box-calendar">
                                                    <i class="fa fa-calendar"></i>
                                                    <input type="text" placeholder=" ##Wentdate## " id="startDate"
                                                           name="startDate"
                                                           class="{$classNameStartDate} calendar--input"
                                                           value="{$startDate}">
                                                </div>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                        </div>
                                        <div class="form-hotel-item  form-hotel-item-searchBox-date">
                                            <div class="input parent-box-input">
                                                <div class="parent-box-calendar">
                                                    <i class="fa fa-calendar"></i>
                                                    <input type="text" placeholder="##Returndate##" id="endDate" name="endDate"
                                                           class="{$classNameEndDate} calendar--input"
                                                           value="{$endDate}">
                                                </div>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                        </div>
                                        <div class="parent-box--icon">
                                            <div class="">
                                                <i class="fa fa-moon"></i>
                                                <span class="lh35 stayingTime">{$objResult->stayingTime} ##Night## </span>
                                                <input type="hidden" id="stayingTime" name="stayingTime"
                                                       value="{$objResult->stayingTime}"/>
                                            </div>
                                            <div class="form-hotel-item  form-hotel-item-searchBox-btn">
                                                <span></span>
                                                <div class="input">
                                                    <button class="site-secondary-text-colo" type="button" id="searchHotelLocal"
                                                            onclick="hotelDetail('{$typeApplication}', '{$hotelId}', '{$hotelNameEn}')">
                                                        ##Repeatsearch##
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        {if $objResult->stayingTime neq $nights}
                                            <div class="form-hotel-room-item form-hotel-item-searchBox form-hotel-room-stay-night-item txtCenter ">
                                                <div class="form-hotel-room-stay-night-border">
                                                    {assign var='Orentiation' value="<i>##Note##:</i>"}
                                                    {assign var='nights' value="<u>{$nights}</u>"}
                                                    {assign var='stayingTime' value="<u>{$objResult->stayingTime}##Night##</u>"}
                                                    {functions::StrReplaceInXml(["@@Orentiation@@"=>$europCar,"@@nights@@"=>$nights,"@@stayTimeNight@@"=>$stayingTime],"RoomHotel")}
                                                </div>
                                            </div>
                                        {/if}
                                    </div>

                                </form>
                            </div>
                        </div>

                            {*                        تست*}

                        <div class="box-reserve-hotel-fix-items-2">
                            <span class="City">صورتحساب  شما</span>
                            <div class="parent--price">
                                <div class="box--price">
                                    <p class="roomFinalTxt">0 اتاق </p>
                                </div>
                                <h6 class="roomFinalPrice site-main-text-color">0 <i>##Rial##</i></h6>
                            </div>

                            {if $objResult->SearchHotel.prepayment_percentage gt 0}
                            <div class="parent-advance--payment">
                                <p>  {$objResult->SearchHotel.prepayment_percentage} % پیش پرداخت</p>
                                <h6 class='roomFinalPrepaymentPackagePrice'></h6>
                            </div>
                            {/if}
                            <span class="roomFinalBtn multi-rooms-price-btn-container">
                                        <button id="btnReserve" type="button" disabled="disabled" class="site-secondary-text-color site-bg-main-color site-main-button-color-hover" onClick="ReserveHotel()">
                                            ##Reservation##
                                        </button>
                                        <img class="imgLoad" src="assets/images/load2.gif" id="img"/>
                                </span>
                        </div>

                    </div>
                {/if}
            </div>
            <script src="assets/js/scrollWithPage.min.js"></script>
            <script>
              // if($(window).width() > 990){
              //   $(".filter_hotel_boxes").scrollWithPage(".sidebar-detailHotel");
              // }
            </script>
        </div>
        <!-- LIST CONTENT-->
    </div>
</div>

{*{if $isShowReserve neq 'no'}*}
{*    <div class="container Hotel_c_Loc">*}
{*        <div class="row">*}

{*            <div class="col-lg-4 col-md-6 col-sm-12 col-12 col-padding-5 ">*}
{*                <div class="hotel-rulls-azm first-item-hotel-azm">*}
{*                    <div class="filtertip-option" id="room-atter">*}
{*                        <div class="box-img-room">*}
{*                            <img class="" alt=" ##Exitrules## " src="assets/images/check-in.png">*}
{*                        </div>*}
{*                        <span class="filter-title-a site-main-text-color-drck ">##Exitrules##</span>*}
{*                        <div class="filter-content padb0" style="min-height: 132px;">*}
{*                            <p class="hotel-description  slideHotelDescriptionMin height126">*}
{*                                {if $objResult->SearchHotel.EntryHour neq '' && $objResult->SearchHotel.LeaveHour neq ''}*}

{*                                    {assign var="EntryHour" value=$objResult->SearchHotel.EntryHour}*}
{*                                    {assign var="LeaveHour" value=$objResult->SearchHotel.LeaveHour}*}
{*                                    {functions::StrReplaceInXml(["@@EntryHour@@"=>$EntryHour,"@@LeaveHour@@"=>$LeaveHour],"skanRoomUser")}*}
{*                                {else}*}
{*                                    {functions::StrReplaceInXml(["@@EntryHour@@"=>"12:00","@@LeaveHour@@"=>"14:00"],"skanRoomUser")}*}
{*                                {/if}*}
{*                            </p>*}

{*                        </div>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
{*            <div class="col-lg-4 col-md-6 col-sm-12 col-12 col-padding-5 ">*}
{*                <div class="hotel-rulls-azm">*}
{*                    <div class="filtertip-option ">*}
{*                        <div class="box-img-room">*}
{*                            <img class="" alt="##Youngrules## " src="assets/images/baby-girl.png">*}
{*                        </div>*}
{*                        <span class="filter-title-a site-main-text-color-drck"> ##Youngrules##</span>*}
{*                        <div class="filter-content nopad ">*}

{*                            {if $objResult->SearchHotel.ChildHalfPriceCode neq ""}*}
{*                                {assign var="countRule" value=$objResult->SearchHotel.ChildHalfPriceCode|count_characters}*}
{*                                <p class="hotel-description slideHotelDescriptionMin {if $countRule lt 200}height126{/if}">*}
{*                                    {$objResult->SearchHotel.ChildHalfPriceCode}*}
{*                                </p>*}
{*                            {elseif $objResult->SearchHotel.ChildDescription neq ""}*}
{*                                {assign var="countRule" value=$objResult->SearchHotel.ChildDescription|count_characters}*}
{*                                <p class="hotel-description slideHotelDescriptionMin {if $countRule lt 200}height126{/if}">*}
{*                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                                        {$objResult->SearchHotel.ChildDescription}*}
{*                                    {else}*}
{*                                        {$objResult->SearchHotel.ChildDescription_en}*}
{*                                    {/if}*}
{*                                </p>*}
{*                            {else}*}
{*                                <p class="hotel-description slideHotelDescriptionMin height126">*}
{*                                    ##Chd5## </p>*}
{*                            {/if}*}

{*                            {if $countRule gt 200}*}
{*                                <span class="maxlist-more slideDownHotelDescription"> <a> ##Open## </a></span>*}
{*                                <span class="maxlist-more slideUpHotelDescription displayiN"><a> ##Close## </a></span>*}
{*                            {/if}*}
{*                        </div>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
{*            <div class="col-lg-4 col-md-12 col-sm-12 col-12 col-padding-5 ">*}
{*                <div class="hotel-rulls-azm">*}
{*                    <div class="filtertip-option " id="hotel-rules">*}
{*                        <div class="box-img-room">*}
{*                            <img class="" alt="  ##Cancellationrules##" src="assets/images/reserved.png">*}
{*                        </div>*}
{*                        <span class="filter-title-a site-main-text-color-drck">  ##Cancellationrules##</span>*}
{*                        <div class="filter-content nopad">*}

{*                            {if $objResult->SearchHotel.CancellationConditions neq ''}*}
{*                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                                    {assign var="countCancellation" value=$objResult->SearchHotel.CancellationConditions|count_characters}*}
{*                                {else}*}
{*                                    {assign var="countCancellation" value=$objResult->SearchHotel.CancellationConditions_en|count_characters}*}
{*                                {/if}*}
{*                                <p class="hotel-description slideHotelDescriptionMin {if $countCancellation lt 150}height126{/if}">*}
{*                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                                        {$objResult->SearchHotel.CancellationConditions}*}
{*                                    {else}*}
{*                                        {$objResult->SearchHotel.CancellationConditions_en}*}
{*                                    {/if}*}
{*                                </p>*}
{*                                {if $countCancellation gt 150}*}
{*                                    <span class="maxlist-more slideDownHotelDescription"> <a> ##Open## </a></span>*}
{*                                    <span class="maxlist-more slideUpHotelDescription displayiN"><a> ##Close## </a></span>*}
{*                                {/if}*}
{*                            {else}*}
{*                                <p class="hotel-description slideHotelDescriptionMin">##Hotelcancelation##</p>*}
{*                                <span class="maxlist-more slideDownHotelDescription"> <a> ##Open## </a></span>*}
{*                                <span class="maxlist-more slideUpHotelDescription displayiN"><a> ##Close## </a></span>*}
{*                            {/if}*}

{*                        </div>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}

{*        </div>*}
{*    </div>*}
{*{/if}*}




{literal}

    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>

<script>
    // position we will use later LOCAL ,
    let lon = {/literal}{$objResult->SearchHotel.MapCoordination.Longitude}{literal};
    let lat = {/literal}{$objResult->SearchHotel.MapCoordination.Latitude}{literal};
    // initialize map
    map = L.map('mapDiv').setView([lat, lon], 15);
    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 100,
    }).addTo(map);
    // add marker to the map
    marker = L.marker([lat, lon]).addTo(map);
</script>

{/literal}{if $typeApplication eq 'api'}{literal}
    <script>
        $(document).ready(function () {
            getInfoHotelRoomPriceForAjax();

        });
    </script>
{/literal}{/if}{literal}

    <script type="text/javascript">
        // $('.counter').counter({});
        // $('.counter').on('counterStop', function () {
        //     $('.lazy_loader_flight').slideDown({
        //         start: function () {
        //             $(this).css({
        //                 display: "flex"
        //             })
        //         }
        //     });

        // });

        $(document).ready(function () {

            $('.hotel-thumb-carousel').owlCarousel({
                items: 2,
                rtl: true,
                loop: true,
                margin: 5,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplaySpeed: 1000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,

                    }
                }
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



            $("body").delegate(".showCancelRule", "click", function () {
                let roomId = $(this).data("roomindex");
                $("#btnCancelRule-" + roomId).removeClass('showCancelRule').addClass('hideCancelRule').css('opacity', '0.5').css('cursor', 'progress');
                $("#btnCancelRule-" + roomId + " i").removeClass("fa fa-angle-down").addClass("fa fa-angle-up");
                $("#boxCancelRule-" + roomId).removeClass('displayN');
                $("#btnCancelRule-" + roomId).css('opacity', '1').css('cursor', 'pointer');
            });
            $("body").delegate(".hideCancelRule", "click", function () {
                let roomId = $(this).data("roomindex");
                $("#boxCancelRule-" + roomId).addClass('displayN');
                $("#btnCancelRule-" + roomId).removeClass('hideCancelRule').addClass('showCancelRule').css('opacity', '1').css('cursor', 'pointer');
                $("#btnCancelRule-" + roomId + " i").removeClass("fa fa-angle-up").addClass("fa fa-angle-down");
            });

            /*var $obj = $('header');
            var top = $obj.offset().top - parseFloat($obj.css('marginTop').replace(/auto/, 0));
            console.log('top', top);*/
            $(window).scroll(function () {

                let y = $(this).scrollTop();
                let topHeader = parseInt($('header').outerHeight()) - 20;
                let topGallery = parseInt($('.hotel-khareji-thumb').outerHeight());
                let width = $('.hotel-detail-room-list').outerWidth();
                let left = $('#formHotelReserve').offset().left;

                if (y > topGallery) {
                    $('.box-reserve-hotel-fix').addClass('fixed-box-reserve');
                    $('.box-reserve-hotel-fix').css('top', topHeader + 'px');
                    /*$('.box-reserve-hotel-fix').css('z-index', '99999');
                    $('.box-reserve-hotel -fix').css('position', 'fixed');*/
                    $('.box-reserve-hotel-fix').css('left', left + 'px');
                    $('.box-reserve-hotel-fix').css('width', width + 'px');
                } else {
                    //$('.box-reserve-hotel-fix').removeAttr('style');
                    $('.box-reserve-hotel-fix').removeClass('fixed-box-reserve');
                }
            });

        });
    </script>
    <script src="assets/js/html5gallery.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
{/literal}

