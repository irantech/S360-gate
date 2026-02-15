<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="passengersDetailGasht" assign="objDetailGasht"}
{load_presentation_object filename="resultGasht" assign="objResult"}
{assign var="InfoGasht" value=$objDetailGasht->getGasht()}
{assign var="orginCities" value=$objFunctions->getListCityLocal()}
{*{load_presentation_object filename="passengersDetailLocal" assign="objDetailPassenger"}*}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}


{$objDetailGasht->getCustomers()}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{*{$orginCities|print_r}*}
{*{assign var="InfoCounter" value=objDetail->infoCounterType($InfoMember.fk_counter_type_id)}*}
{*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{*{$objDetailGasht->getCustomers()}*}


{*{$InfoGasht|@print_r}*}
{*<div>
    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr">  {$objDetailGasht->SetTimeLimit()}</div>
</div>*}
<div class="container-fluid">
    <div id="steps">
        <div class="steps_items">
            <div class="step done ">
                <span class=""><i class="fa fa-check"></i></span>
                <h3>##Reserved##</h3>
            </div>
            <i class="separator donetoactive"></i>
            <div class="step active">
        <span class="flat_icon_airplane">
        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577"
             width="25" xmlns="http://www.w3.org/2000/svg">
    <g>
        <path d="m441 145.789h29v105h-29z"></path>
        <path d="m60 85.789h-60v387.898l60-209.999z"></path>
        <path d="m86.314 280.789-60 210h420.263l55-210z"></path>
        <g>
            <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z"></path>
            <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z"></path>
            <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z"></path>
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
        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z"></path>
        <path d="M21,29H20v1a1,1,0,0,1,1-1Z"></path>
        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z"></path>
        <path d="M21,39H20v1a1,1,0,0,1,1-1Z"></path>
        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z"></path>
        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z"></path>
        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z"></path>
        <path d="M21,19H20v1a1,1,0,0,1,1-1Z"></path>
        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z"></path>
        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z"></path>
        <rect x="20" y="8" width="26" height="4"></rect>
        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z"></path>
    </g>
</svg>
             </span>
                <h3>##Approvefinal##</h3>
            </div>
            <i class="separator"></i>
            <div class="step">
            <span class="flat_icon_airplane">
           <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                preserveAspectRatio="xMidYMid meet">

<g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
   fill="#000000" stroke="none">
<path d="M253 1138 c-4 -7 -25 -53 -45 -102 -42 -98 -41 -102 21 -131 47 -21
69 -63 55 -103 -9 -27 -11 -27 -114 -30 -68 -2 -107 -7 -112 -15 -13 -20 -9
-202 4 -215 7 -7 33 -12 58 -12 70 0 108 -52 84 -115 -9 -24 -58 -45 -102 -45
-27 0 -42 -5 -46 -16 -11 -29 -7 -199 6 -212 17 -17 1139 -17 1156 0 13 13 17
183 6 212 -4 11 -19 16 -46 16 -44 0 -93 21 -102 45 -24 64 14 115 85 115 25
0 50 5 57 12 8 8 12 46 12 104 0 100 -5 124 -26 124 -7 0 -221 85 -474 190
-254 105 -463 190 -465 190 -2 0 -7 -6 -12 -12z m397 -203 c193 -80 359 -149
368 -155 11 -6 -99 -9 -334 -10 l-352 0 5 43 c7 55 -16 101 -63 129 -19 11
-34 23 -34 28 0 16 43 110 51 110 4 0 166 -65 359 -145z m520 -279 l0 -64 -40
-7 c-132 -22 -157 -190 -38 -251 15 -8 38 -14 53 -14 24 0 25 -2 25 -65 l0
-65 -530 0 -530 0 0 65 c0 63 1 65 25 65 15 0 38 6 53 14 119 61 94 229 -38
251 l-40 7 0 64 0 64 530 0 530 0 0 -64z"/>
<path d="M862 658 c-32 -32 -1 -116 33 -88 26 22 14 100 -15 100 -3 0 -11 -5
-18 -12z"/>
<path d="M376 601 c-4 -5 -3 -16 0 -25 5 -14 31 -16 184 -16 181 0 195 3 182
38 -5 14 -357 18 -366 3z"/>
<path d="M862 498 c-32 -32 -1 -116 33 -88 26 22 14 100 -15 100 -3 0 -11 -5
-18 -12z"/>
<path d="M376 464 c-3 -9 -4 -20 0 -25 9 -15 361 -12 367 4 12 34 -3 37 -183
37 -153 0 -179 -2 -184 -16z"/>
<path d="M380 335 c-10 -12 -10 -18 0 -30 18 -22 342 -22 360 0 10 12 10 18 0
30 -10 12 -43 15 -180 15 -137 0 -170 -3 -180 -15z"/>
<path d="M862 338 c-32 -32 -1 -116 33 -88 26 22 14 100 -15 100 -3 0 -11 -5
-18 -12z"/>
</g>
</svg>

            </span>
                <h3>##TicketReservation##</h3>
            </div>
        </div>

        <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
             style="direction: ltr">  {$objDetailGasht->SetTimeLimit($smarty.post.adultQty+$smarty.post.childQty+$smarty.post.infantQty)}</div>

    </div>


    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

    <!-- last passenger list -->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
    <!--end  last passenger list -->

    {*<div class="s-u-content-result">*}
    <div class="s-u-content-result">
       {* <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
            </span>
            <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                    ##DontReloadPageInfo##
                  <br/>

                </span>
            </div>
        </div>*}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change s-u-passenger-wrapper-change-parent">
         <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
             <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
             ##Youareshopping##
             {if $InfoGasht.request_Type eq '0'}
                 ##Gasht##
             {else}
                 ##transfer##
             {/if}

             زیر می باشید
         </span>


            <div class="hotel-booking-room marb0">


                <div class="col-md-12 ">
                    <div class=" gasht_content_passenger">
                        <div class="hotel-booking-room-text">
                            <b class="hotel-booking-room-name"> {$InfoGasht.servicename} </b>


                            <span class="hotel-booking-room-content-location ">
                     <a> {$InfoGasht.servicecomment} </a>
                   </span>
                        </div>

                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i>
                                    ##Date## {if $InfoGasht.request_Type eq '0'}
                                        ##Gasht##
                                    {else}
                                        ##transfer##
                                    {/if} :
                                    <span class="hotel-check-date" dir="rtl">{$InfoGasht.requestdate}</span></li>
                                <li class="hotel-check-text">
                                    <i class="fa fa-map"></i> ##City## {if $InfoGasht.request_Type eq '0'}
                                        ##Gasht##
                                    {else}
                                        ##transfer##
                                    {/if} :
                                    <span class="hotel-check-date" dir="rtl">{$InfoGasht.cityname}</span></li>
                                {assign var="discountManual" value=$objResult->getDiscount($InfoGasht.request_Type)}
                                {if $discountManual  neq 0}
                                <li class="hotel-check-text">


                                    <i class="fa fa-dollar"></i> ##Discount## :
                                    <span class="hotel-check-date" data-amount="{$discountManual}" dir="rtl">%{$discountManual}</span></li>
                                {/if}
                                <li class="hotel-check-text">
                                    {$PriceAfterOff=$InfoGasht.priceafteroff-(($InfoGasht.priceafteroff*$discountManual)/100)}
                                    {assign var="after_price_change" value=$objFunctions->setGashtPriceChanges($PriceAfterOff*10)}
                                    {assign var="price_change" value=($InfoGasht.priceafteroff*10)}
                                    {assign var="afterEveryMainCurrency" value=$objFunctions->CurrencyCalculate($after_price_change)}
                                    {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($price_change)}
                                    <i class="fa fa-dollar"></i> ##Price## :
                                    <span class="hotel-check-date" data-amount="{$after_price_change}" dir="rtl">{$objFunctions->numberFormat($afterEveryMainCurrency.AmountCurrency)}</span><i class="pirce CurrencyText">{$afterEveryMainCurrency.TypeCurrency}</i></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="clear"></div>

        <form method="post" id="formPassengerDetailGasht" action="{$smarty.const.ROOT_ADDRESS}/factorGasht">

            <input type="hidden" name="serviceName" value="{$InfoGasht.servicename}">
            <input type="hidden" name="serviceId" value="{$InfoGasht.serviceid}">
            <input type="hidden" name="serviceComment" value="{$InfoGasht.servicecomment}">
            <input type="hidden" name="servicePrice" value="{$price_change}">
            <input type="hidden" name="serviceDiscount" value="{$discountManual}">
            <input type="hidden" name="servicePriceAfterOff" value="{$after_price_change}">
            <input type="hidden" id="serviceRequestDate" name="serviceRequestDate" value="{$InfoGasht.requestdate}">
            <input type="hidden" name="serviceCityName" value="{$InfoGasht.cityname}">
            <input type="hidden" id="serviceRequestType" name="serviceRequestType" value="{$InfoGasht.request_Type}">
            <input type="hidden" id="factorNumber" name="factorNumber" value="{$objResult->createFactorNumber()}">
            <input type="hidden" id="encryptData" name="encryptData" value="{$InfoGasht.encryptData}">
            <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$InfoGasht.CurrencyCode}">
            <input type="hidden" name="time_remmaining" id="time_remmaining" value="">
            <input type="hidden" value="" name="IdMember" id="IdMember">


            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                    <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color ">
                        ##Headgroupinformation##
                      {if $objSession->IsLogin()}
                          <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                onclick="setHidenFildnumberRow('G1')">
                             <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                        </span>
                      {/if}
                    </span>
                <input type="hidden" id="numberRow" value="0">
                <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                <div class="clear"></div>
                <div class="panel-default-change-Buyer">
                    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

                        <div class="panel-heading-change">

                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
                        <label class="control--checkbox">
                            <span>##Iranian##</span>
                            <input type="radio" name="passengerNationalityG1" id="passengerNationalityG1" value="0"
                                   class="nationalityChange" checked="checked">
                            <div class="checkbox">
                                <div class="filler"></div>
                               <svg fill="#000000"  viewBox="0 0 30 30" >
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                            </div>
                        </label>
                    </span>
                            <span class="kindOfPasenger">
                        <label class="control--checkbox">
                            <span>##Noiranian##</span>
                            <input type="radio" name="passengerNationalityG1" id="passengerNationalityG1" value="1"
                                   class="nationalityChange">
                            <div class="checkbox">
                                <div class="filler"></div>
                                <svg fill="#000000"  viewBox="0 0 30 30" >
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                            </div>
                        </label>
                    </span>


                        </div>
                        <div class="panel-body-change">

                            <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                <select class="" id="genderG1" name="genderG1">
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameFaG1" type="text" placeholder="##Namepersion##" name="nameFaG1"
                                       onkeypress=" return persianLetters(event, 'nameFaG1')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyFaG1" type="text" placeholder="##Familypersion##"
                                       name="familyFaG1"
                                       onkeypress=" return persianLetters(event, 'familyFaG1')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="nameEnG1" type="text" placeholder="##Nameenglish##" name="nameEnG1"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnG1')" class="">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="familyEnG1" type="text" placeholder="##Familyenglish##" name="familyEnG1"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnG1')" class="">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayG1" type="text" placeholder="##shamsihappybirthday##" name="birthdayG1"
                                       class="shamsiDriverBirthdayCalendar pwt-datepicker-input-element" readonly="readonly">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                <input id="NationalCodeG1" type="tel" placeholder="##Nationalnumber##" name="NationalCodeG1"
                                       maxlength="10"
                                       class="UniqNationalCode">
                            </div>

                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                                <select name="passportCountryG1" id="passportCountryG1"
                                        class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportNumberG1" type="text" placeholder="##Numpassport##"
                                       name="passportNumberG1" class="UniqPassportNumber">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportExpireG1" class="gregorianFromTodayCalendar pwt-datepicker-input-element"
                                       type="text" placeholder="##Passportexpirydate##" name="passportExpireG1">
                            </div>

                            <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                <div class="select">
                                    <select id="peoplesG1" name="peoplesG1" class="select2">
                                        <option value="" disabled="" selected="selected">##Countpeople##</option>
                                        {for $i=1 to 9}
                                            <option value="{$i}">{$i}</option>
                                        {/for}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="messageInfo1" class="messageInfo"></div>

                <div class="clear"></div>
            </div>

            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                    <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color">
                        ##StayInformation##
                    </span>
                <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                <div class="clear"></div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="buyerHotelName" type="text" placeholder="##StayHotelName##"
                           name="buyerHotelName">
                </div>
                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                    <input id="buyerHotelAddress" type="text" placeholder="##StayHotelAddress##"
                           name="buyerHotelAddress">
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="entryDate" type="text" placeholder="##Enterdate##" name="entryDate"
                           class="shamsiDeptCalendar"
                           readonly="readonly">
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="departureDate" type="text" placeholder="##Exitdate##" name="departureDate"
                           class="shamsiReturnCalendar"
                           readonly="readonly">
                </div>
                <div class="clear"></div>

                <div id="messageInfo2" class="messageInfo1"></div>
            </div>
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                    <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color ">
                        ##TrasportInformation##
                    </span>
                <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                <div class="clear"></div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <div class="select">
                        <select id="travelVehicle" name="travelVehicle" onchange="vehicleVoucher(this)" class="select2">
                            <option value="" disabled selected="selected">##TransportVehicle##</option>
                            <option value="bus">##Bus##</option>
                            <option value="train">##Train##</option>
                            <option value="airplane">##Airplane##</option>
                        </select>
                    </div>
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <div class="select">
                        <select class="select2" id="orginCity" name="orginCity">
                            <option value="">##Origincity##</option>
                            {foreach from=$orginCities item=city}
                                <option value="{$city.city_name}">{$city.city_name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <div class="select">
                        <select name="startTime" id="startTime" class="select2">
                            <option value="">##Starttime##</option>
                            {$objDetailGasht->getGashtTime()}
                        </select>
                    </div>
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">

                    <select name="endTime" id="endTime" class="select2">
                        <option value="">##Returntime##</option>
                        {$objDetailGasht->getGashtTime()}
                    </select>

                </div>
                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                    <input id="trainOrAierplaneVoucher" type="text" name="trainOrAierplaneVoucher">
                </div>

                <div class="clear"></div>

                <div id="messageInfo3" class="messageInfo2"></div>
            </div>


            {if $objSession->IsLogin()}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                    <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color">
                        ##InformationSaler##
                    </span>
                    <input type="hidden" name="UsageNotLogin" value="no" id="UsageNotLogin">
                    <div class="clear"></div>
                    <div class="panel-default-change-Buyer">


                        <div class="panel-default-change pull-right">

                            <div class="clear"></div>

                            <div class="panel-body-change">

                                <div class="s-u-passenger-item s-u-passenger-item-change widthInputInformationBuyer">
                                    <input id="buyerCompanionCellPhone" type="tel" placeholder="##SalerPhone##"
                                           name="buyerCompanionCellPhone" maxlength="11"
                                           class="UniqNationalCode"
                                           onkeyup="return checkNumber(event, 'buyerCompanionCellPhone')"
                                           value="{$InfoMember.mobile}">
                                </div>
                                <div class="s-u-passenger-items widthInputInformationBuyer s-u-passenger-item-change">
                                        <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr"
                                           value="{$InfoMember.email}">
                                </div>


                            </div>
                        </div>
                        <div class="clear"></div>

                        <div id="messageInfo4" class="messageInfo3" ></div>
                    </div>
                    <div class="clear"></div>
                </div>
            {else}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                    <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color">
                        ##InformationSaler##
                    </span>
                    <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                    <div class="clear"></div>
                    <div class="panel-default-change-Buyer">


                        <div class="panel-default-change pull-right">

                            <div class="clear"></div>

                            <div class="panel-body-change">


                                <div class="s-u-passenger-items s-u-passenger-item-change">
                                    <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                                </div>
                                <div class="s-u-passenger-items s-u-passenger-item-change">
                                    <input id="Telephone" type="tel" placeholder="##Phone##" name="Telephone" class=""
                                           onkeypress="return checkNumber(event, 'Telephone')">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <input id="buyerCompanionCellPhone" type="tel" placeholder="##SalerPhone##"
                                           name="buyerCompanionCellPhone" maxlength="11"
                                           class="UniqNationalCode"
                                           onkeyup="return checkNumber(event, 'buyerCompanionCellPhone')">
                                </div>

                            </div>
                        </div>
                        <div class="clear"></div>

                        <div id="messageInfo5" class="messageInfo"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/if}

            <div class="clear"></div>


            <div class="btns_factors_n">
                <div class="next_pas_de_gasht" >
                    <!-- <a href="" onclick="return false" class="f-loader-check loaderpassengers"  style="display:none"></a> -->
                    <input type="button" value="##Optout##" class="cancel-passenger" onclick="BackToHome('http://{$smarty.const.CLIENT_MAIN_DOMAIN}'); return false">

                </div>
            <div class="next_pas_de_gasht">
                <a href="" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check"
                   style="display:none"></a>

                <input type="hidden" value="" name="IdMember" id="IdMember">
                <input type="button" onclick="checkGashtLocal({$smarty.now})" value="##NextStepInvoice##"
                       class="s-u-submit-passenger s-u-select-flight-change site-bg-main-color s-u-submit-passenger-Buyer"
                       id="send_data">
            </div>



            </div>
        </form>

    </div>

</div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {

            var table = $('#passengers').DataTable();

            $('#passengers tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#button').click(function () {
                table.row('.selected').remove().draw(false);
            });

        });
    </script>

<!-- counter menu -->
    <script src="assets/js/classie.js"></script>
    <script src="assets/js/sidebarEffects.js"></script>

<!-- jQuery Site Scipts -->
    <script src="assets/js/script.js"></script>

    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">
    $('.counter').counter({});
    $('.counter').on('counterStop', function () {
        $('.lazy_loader_flight').slideDown({
            start: function () {
                $(this).css({
                    display: "flex"
                })
            }
        });

    });
/*    $('.counter').on('counterStop', function () {

        $.confirm({
            theme: 'supervan',// 'material', 'bootstrap'
            title: '##Update##',
            icon: 'fa fa-clock',
            content: '##Reservebookingcompletedreservationbeginning##',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: '##Approve##',
                    btnClass: 'btn-green',
                    action: function () {
                        location.href = '{/literal}http://{$smarty.const.CLIENT_MAIN_DOMAIN}{literal}';
                    }
                },
                cancel: {
                    text: '##Optout##',
                    btnClass: 'btn-orange',
                    action: function () {
                        location.href = '{/literal}http://{$smarty.const.CLIENT_MAIN_DOMAIN}{literal}';
                    }
                }
            }
        });

    });*/
</script>

    <script type="text/javascript">
        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }

        // hide popup
        $('.s-u-t-r-p .s-u-t-r-p-h').on("click", function (e) {
            e.preventDefault();
            $(".s-u-black-container").fadeOut('slow');
            $(".s-u-t-r-p").fadeOut('fast');
            return false;
        });
        $('.s-u-b-r-p .s-u-t-r-p-h').on("click", function (e) {
            e.preventDefault();
            $(".s-u-black-container").fadeOut('slow');
            $(".s-u-b-r-p").fadeOut('fast');
            return false;
        });
        $('.s-u-black-container').on("click", function (e) {
            e.preventDefault();
            $('.s-u-black-container').fadeOut('slow');
            $('.s-u-b-r-p').fadeOut('fast');
            $('.s-u-t-r-p').fadeOut('fast');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {


            $('ul.tabs li').on("click", function () {

                $(this).siblings().removeClass("current");
                $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");


                var tab_id = $(this).attr('data-tab');


                $(this).addClass('current');
                $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

            });
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').delegate('.closeBtn', 'click', function () {

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

            $('.DetailSelectTicket').on('click', function (e) {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });
        });

    </script>

{/literal}
