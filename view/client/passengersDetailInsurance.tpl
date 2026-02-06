{load_presentation_object filename="insurance" assign="objInsurance"}
{assign var ="price_calculate_information" value=$objInsurance->priceCalculateInformation()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{assign var="discount_data" value=$price_calculate_information['discount_data']}
{assign var="markup_data" value=$price_calculate_information['markup_data']}

<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="passengersDetailInsurance" assign="objDetailInsurance"}
{assign var ="InfoInsurance" value=$objDetailInsurance->getInsuranceInfo($smarty.const.HASH_CODE)}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{$objDetailInsurance->getCustomers()} {*لیست مسافران کاربر لاگین کرده*}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{*{$InfoInsurance|var_dump}*}




{* تشخیص نوع بیمه (داخلی یا خارجی) بر اساس مقصد *}
{assign var="isDomesticInsurance" value=false}
{if $InfoInsurance.destinationIata == 'IR' ||
$InfoInsurance.destination == 'ایران' ||
$InfoInsurance.destination == 'Iran' ||
$InfoInsurance.destination == 'iran' ||
$InfoInsurance.destination == 'IRAN' ||
$InfoInsurance.destinationIata == 'IRN'}
    {assign var="isDomesticInsurance" value=true}
{/if}


{*                                                        {if $InfoInsurance.destinationIata == 'DEU' ||*}
{*                                                        $InfoInsurance.destination == 'آلمان' ||*}
{*                                                        $InfoInsurance.destination == 'Germany' ||*}
{*                                                        $InfoInsurance.destination == 'Germany' ||*}
{*                                                        $InfoInsurance.destination == 'Germany' ||*}
{*                                                        $InfoInsurance.destinationIata == 'DEU'}*}
{*                                                            {assign var="isDomesticInsurance" value=true}*}
{*                                                        {/if}*}



{*{$isDomesticInsurance|var_dump}*}
<div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Searchinsurance##</h3>
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
            <h3> ##Insuranceissuance## </h3>
        </div>
    </div>

    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr">06:00</div>

</div>


<div id="lightboxContainer" class="lightboxContainerOpacity"></div>

<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->


<div class="s-u-content-result">


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change" >
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
        ##Youpurchasingfollowinginsurance##
        </span>
        <div class="s-u-result-wrapper ">
            <div class="insurance-passenger-main-box">
                <div class="insurance-passenger-main-box-img">
                    <span><img src="assets/images/{$InfoInsurance.insurance_api}Insurance.png"></span>
                </div>
                <div class=" insurance-passenger-box-content">
                    <div class="insurance-passenger-content">
                        <div class="insurance-passenger--new">
                            <h2 class="insurance-passenger-description">
                                {$InfoInsurance.insurance_caption}
                            </h2>

                            <div class="parent-data-insurance--new">
                                <span class="insurance-passenger-name">##TitleInsurancePolicy##: <i>{$objDetailInsurance->getInsuranceName($InfoInsurance.insurance_api)}</i> </span>
                                <span class="insurance-passenger-content-location ">
                                  ##Destination##: <span>{$InfoInsurance.destination}</span>
                               </span>
                            </div>
{*                            <span class="insurance-passenger-content-location ">*}
{*                           <i class="fa fa-map-marker"></i>*}
{*                          ##Origin##: {$InfoInsurance.origin}*}
{*                       </span>*}

                        </div>
                        <div class="insurance-passenger-text">
                            <ul>
                                <li class="insurance-passenger-check-text">
                                     ##Durationtrip##  :
                                    <span class="insurance-passenger-date" dir="rtl">{$InfoInsurance.num_day}</span> ##Day##
                                </li>
                                <li class="insurance-passenger-check-text">
                                     ##Countpassengers## :
                                    <span class="insurance-passenger-date" dir="rtl">{$InfoInsurance.member_count}</span> نفر
                                </li>
                                {assign var="totalMainCurrency" value=$objFunctions->CurrencyCalculate($InfoInsurance.insurance_price, $InfoInsurance.CurrencyCode)}
                                <li class="insurance-passenger-check-text">
                                   ##TotalPrice## :
                                    <span class="insurance-passenger-date" dir="rtl">
                                   {$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}
                               </span> {$totalMainCurrency.TypeCurrency}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <form method="post" id="formPassengerDetailInsurance" action="{$smarty.const.ROOT_ADDRESS}/factorInsurance">
        <input type="hidden" name="destination" value="{$InfoInsurance.destination}">
        <input type="hidden" name="destination_iata" value="{$InfoInsurance.destinationIata}">
        <input type="hidden" name="origin" value="{$InfoInsurance.origin}">
        <input type="hidden" name="origin_iata" value="{$InfoInsurance.originIata}">
        <input type="hidden" name="price" value="{$InfoInsurance.insurance_price}">
        <input type="hidden" name="num_day" value="{$InfoInsurance.num_day}">
        <input type="hidden" name="member" value="{$InfoInsurance.member_count}">
        <input type="hidden" name="source_name" value="{$InfoInsurance.insurance_api}">
        <input type="hidden" name="caption" value="{$InfoInsurance.insurance_caption}">
        <input type="hidden" name="zone_code" value="{$InfoInsurance.insurance_zonecode}">
        <input type="hidden" name="CurrencyCode" value="{$InfoInsurance.CurrencyCode}">
        <input type="hidden" name="time_remmaining" id="time_remmaining" value="">
        <input type="hidden" value="" name="IdMember" id="IdMember">
        <input type="hidden" id="numberRow" value="0">

        {for $i=1 to $InfoInsurance.member_count}

            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                {if $InfoInsurance.insurance_type==1}
                    {assign var="AgeTypeMember" value=$objFunctions->type_passengers($InfoInsurance.{$objFunctions->joinStringVariable(birth_date_,$i)})}
                {else}
                    {assign var="AgeTypeMember" value=$objFunctions->type_passengers($objFunctions->ConvertToMiladi($InfoInsurance.{$objFunctions->joinStringVariable(birth_date_,$i)}))}
                {/if}

                {assign var="typeMember" value='' }
                {assign var="icom" value='' }

                {if $AgeTypeMember == Adt}
                    {$typeMember='##Adult## (##More12##)'}
                    {$icon='soap-icon-family'}
                {else}
                    {$typeMember='##Child## (##Less12##)'}
                    {$icon='soap-icon-man-3'}
                {/if}

                <input type="hidden" name="passenger_age{$i}" value="{$AgeTypeMember}">
                <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color ">{$typeMember}<i class="{$icon}"></i>
              {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                  <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('{$i}')">
                        <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerlist##
                    </span>
              {/if}
            </span>
                <div class="panel-default-change site-border-main-color">
                    <div class="panel-heading-change">

                        <span class="hidden-xs-down">##Nation##:</span>

                        <span class="kindOfPasenger">
                        <label class="control--checkbox">
                            <span>##Iranian##</span>
                            <input type="radio" name="passengerNationality{$i}" value="0" class="nationalityChange" checked="checked">
                            <div class="checkbox ">
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
                            <input type="radio" name="passengerNationality{$i}" value="1" class="nationalityChange">
                            <div class="checkbox ">
                                <div class="filler"></div>
                                <svg fill="#000000"  viewBox="0 0 30 30" >
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                            </div>
                        </label>
                    </span>


                        {assign var="memberPrice" value=$objDetailInsurance->getPlanPrice({$InfoInsurance.insurance_api},{$InfoInsurance.destinationIata},{$InfoInsurance.insurance_zonecode},{$InfoInsurance.num_day},{$InfoInsurance.{$objFunctions->joinStringVariable(birth_date_,$i)}})}


                        {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($objInsurance->calculatePrice($memberPrice.basePrice+$memberPrice.taxPrice,$markup_data,$discount_data), $InfoInsurance.CurrencyCode)}
                        <span class="member-price ">
                        <i>{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}</i> {$everyMainCurrency.TypeCurrency}
                    </span>



                        <input type="hidden" name="insurance_baseprice{$i}" value="{$memberPrice.basePrice}">
                        <input type="hidden" name="insurance_tax{$i}" value="{$memberPrice.taxPrice}">
                        <input type="hidden" name="api_commission{$i}" value="{$memberPrice.commission}">
                        <input type="hidden" name="discount_percentage{$i}" value="{$discount_data['value']}">
                        <input type="hidden" name="paid_price{$i}" value="{$everyMainCurrency.AmountCurrency}">

                    </div>
                    <div class="clear"></div>
                    <div class="panel-body-change ">
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <select id="gender{$i}" name="gender{$i}">

                                <option value="" disabled="" selected="selected">##Sex##</option>
                                {if $AgeTypeMember== Adt}

                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                {else}

                                    <option value="Male">##Boy##</option>
                                    <option value="Female">##Girl##</option>
                                {/if}
                            </select>
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input  id="nameEn{$i}" type="text" placeholder="##Nameenglish##" name="nameEn{$i}" onkeypress="return isAlfabetKeyFields(event, 'nameEn{$i}')"  >
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input  id="familyEn{$i}" type="text" placeholder="##Familyenglish##" name="familyEn{$i}" onkeypress="return isAlfabetKeyFields(event, 'familyEn{$i}')" >
                        </div>
                        {if $isDomesticInsurance==true}
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input  id="nameFa{$i}" type="text" placeholder="##Namepersion##" name="nameFa{$i}"  onkeypress=" return persianLetters(event, 'nameFa{$i}')"  class="justpersian">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input  id="familyFa{$i}" type="text" placeholder="##Familypersion##" name="familyFa{$i}"  onkeypress=" return persianLetters(event, 'familyFa{$i}')"  class="justpersian">
                            </div>
                        {/if}




                        <style>
                            .birthday-select-container {
                                display: flex;
                                flex-direction: row;
                                gap: 8px;
                                align-items: center;
                            }

                            .birthday-select {
                                flex: 1;
                                min-width: 80px;
                                padding: 8px 12px;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                background-color: white;
                                height: 40px;
                                box-sizing: border-box;
                            }

                            /* برای نمایش بهتر در موبایل */
                            @media (max-width: 768px) {
                                .birthday-select-container {
                                    flex-wrap: wrap;
                                }

                                .birthday-select {
                                    min-width: 70px;
                                    flex: 1 0 calc(33.333% - 8px);
                                }
                            }

                            @media (max-width: 480px) {
                                .birthday-select {
                                    flex: 1 0 calc(50% - 8px);
                                }

                                .birthday-select:last-child {
                                    flex: 1 0 100%;
                                }
                            }

                            .age-error-message {
                                color: red;
                                font-size: 12px;
                                margin-top: 5px;
                                display: none;
                            }

                            /* اطمینان از پنهان بودن فیلدهای تاریخ قبلی */
                            input[name^="birthday"],
                            input[name^="birthdayEn"] {
                                display: none !important;
                            }

                            .birthday-field {
                                display: none;
                            }

                            /* کلاس‌های کمکی برای نمایش */
                            .birthday-field.visible {
                                display: block !important;
                            }


                            /*input[name^="birthday"], input[name^="birthdayEn"] {*/
                                /*    display: none !important;*/
                                /*}*/
                        </style>


                        {* فیلد تاریخ شمسی - فقط برای بیمه داخلی + ایرانی *}
                        <div id="jalali_birthday_{$i}" class="s-u-passenger-item s-u-passenger-item-change birthday-field ">
                            <div class="birthday-select-container">
                                <select id="birthday_day{$i}" name="birthday_day{$i}" class="birthday-select"
                                        onchange="validateAge('{$i}', 'jalali', '{$AgeTypeMember}'); updateHiddenBirthdayFields('{$i}', 'jalali')">                                        <option value="">روز</option>
                                    {for $day=1 to 31}
                                        <option value="{$day}">{$day}</option>
                                    {/for}
                                </select>

                                <select id="birthday_month{$i}" name="birthday_month{$i}" class="birthday-select"
                                        onchange="validateAge('{$i}', 'jalali', '{$AgeTypeMember}'); updateHiddenBirthdayFields('{$i}', 'jalali')">                                        <option value="">ماه</option>
                                    {for $month=1 to 12}
                                        <option value="{$month}">
                                            {if $month == 1}فروردین
                                            {elseif $month == 2}اردیبهشت
                                            {elseif $month == 3}خرداد
                                            {elseif $month == 4}تیر
                                            {elseif $month == 5}مرداد
                                            {elseif $month == 6}شهریور
                                            {elseif $month == 7}مهر
                                            {elseif $month == 8}آبان
                                            {elseif $month == 9}آذر
                                            {elseif $month == 10}دی
                                            {elseif $month == 11}بهمن
                                            {elseif $month == 12}اسفند
                                            {/if}
                                        </option>
                                    {/for}
                                </select>

                                <select id="birthday_year{$i}" name="birthday_year{$i}" class="birthday-select"
                                        onchange="validateAge('{$i}', 'jalali', '{$AgeTypeMember}'); updateHiddenBirthdayFields('{$i}', 'jalali')">
                                    <option value="">سال</option>
                                    {assign var="currentJalaliDate" value=$objFunctions->ConvertToJalali($smarty.now|date_format:"%Y-%m-%d")}
                                    {assign var="currentJalaliYear" value=$currentJalaliDate|substr:0:4}

                                    {if $AgeTypeMember == 'Adt'}
                                        {assign var="minYear" value=$currentJalaliYear-100}
                                        {assign var="maxYear" value=$currentJalaliYear-12}
                                    {else}
                                        {assign var="minYear" value=$currentJalaliYear-12}
                                        {assign var="maxYear" value=$currentJalaliYear}
                                    {/if}

                                    {for $year=$minYear to $maxYear}
                                        <option value="{$year}">{$year}</option>
                                    {/for}
                                </select>
                            </div>
                            <div id="age_error_{$i}" class="age-error-message"></div>
                        </div>


                        <div id="gregorian_birthday_{$i}" class="s-u-passenger-item s-u-passenger-item-change birthday-field">
                            <div class="birthday-select-container">
                                <select id="birthdayEn_day{$i}" name="birthdayEn_day{$i}" class="birthday-select"
                                        onchange="validateAge('{$i}', 'gregorian', '{$AgeTypeMember}'); updateHiddenBirthdayFields('{$i}', 'gregorian')">
                                    <option value="">روز</option>
                                    {for $day=1 to 31}
                                        <option value="{$day}">{$day}</option>
                                    {/for}
                                </select>

                                <select id="birthdayEn_month{$i}" name="birthdayEn_month{$i}" class="birthday-select"
                                        onchange="validateAge('{$i}', 'gregorian', '{$AgeTypeMember}'); updateHiddenBirthdayFields('{$i}', 'gregorian')">
                                    <option value="">ماه</option>
                                    {for $month=1 to 12}
                                        <option value="{$month}">
                                            {if $month == 1}January
                                            {elseif $month == 2}February
                                            {elseif $month == 3}March
                                            {elseif $month == 4}April
                                            {elseif $month == 5}May
                                            {elseif $month == 6}June
                                            {elseif $month == 7}July
                                            {elseif $month == 8}August
                                            {elseif $month == 9}September
                                            {elseif $month == 10}October
                                            {elseif $month == 11}November
                                            {elseif $month == 12}December
                                            {/if}
                                        </option>
                                    {/for}
                                </select>

                                <select id="birthdayEn_year{$i}" name="birthdayEn_year{$i}" class="birthday-select"
                                        onchange="validateAge('{$i}', 'gregorian', '{$AgeTypeMember}'); updateHiddenBirthdayFields('{$i}', 'gregorian')">
                                    <option value="">سال</option>
                                    {assign var="currentGregorianYear" value=$smarty.now|date_format:"%Y"}
                                    {if $AgeTypeMember == 'Adt'}
                                        {assign var="minYear" value=$currentGregorianYear-100}
                                        {assign var="maxYear" value=$currentGregorianYear-12}
                                    {else}
                                        {assign var="minYear" value=$currentGregorianYear-12}
                                        {assign var="maxYear" value=$currentGregorianYear}
                                    {/if}

                                    {for $year=$minYear to $maxYear}
                                        <option value="{$year}">{$year}</option>
                                    {/for}
                                </select>
                            </div>
                            <div id="age_error_en_{$i}" class="age-error-message"></div>
                        </div>

                        <input id="birthday{$i}" type="hidden" name="birthday{$i}" value="" />
                        <input id="birthday_display{$i}" type="text" placeholder="##Happybirthday##" readonly="readonly" value="" style="display: none;" />

                        <input id="birthdayEn{$i}" type="hidden" name="birthdayEn{$i}" value="" />
                        <input id="birthdayEn_display{$i}" type="text" placeholder="##Happybirthday##" readonly="readonly" value="" style="display: none;" />

{*                        <script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>*}
{*                        <script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date-utils.min.js"></script>*}
                        <script>


                           // تابع نمایش فیلد تاریخ مناسب
                           // منطق نهایی برای نمایش فیلد تاریخ
                           function shouldShowJalaliCalendar(isDomestic, isIranian) {
                              return isDomestic && isIranian;
                           }

                           function updateBirthdayFieldVisibility(passengerId, isIranian) {
                              const isDomestic = {$isDomesticInsurance|json_encode};
                              const showJalali = shouldShowJalaliCalendar(isDomestic, isIranian);

                              if (showJalali) {
                                 $('#jalali_birthday_' + passengerId).show();
                                 $('#gregorian_birthday_' + passengerId).hide();
                              } else {
                                 $('#gregorian_birthday_' + passengerId).show();
                                 $('#jalali_birthday_' + passengerId).hide();
                              }
                           }




                           // تغییر ملیت مسافر
                           $(document).on('change', '.nationalityChange', function() {
                              const passengerWrapper = $(this).closest('.s-u-passenger-wrapper');
                              const passengerId = passengerWrapper.index() + 1;
                              const isIranian = $(this).val() === '0';

                              updateBirthdayFieldVisibility(passengerId, isIranian);
                           });

                           // مقداردهی اولیه برای هر مسافر
                           $(document).ready(function() {
                              console.log('Initializing birthday fields...');

                              $('.s-u-passenger-wrapper').each(function(index) {
                                 const passengerId = index + 1;
                                 const isIranian = $(this).find('.nationalityChange:checked').val() === '0';

                                 updateBirthdayFieldVisibility(passengerId, isIranian);
                              });

                              // مخفی کردن فیلدهای تاریخ قبلی
                              $('input[id^="birthday"], input[id^="birthdayEn"]').closest('.s-u-passenger-item').hide();
                           });

                           // تابع اعتبارسنجی سن
                           function validateAge(passengerId, calendarType, passengerType) {
                              let day, month, year, errorElement;

                              if (calendarType === 'jalali') {
                                 day = parseInt($('#birthday_day' + passengerId).val());
                                 month = parseInt($('#birthday_month' + passengerId).val());
                                 year = parseInt($('#birthday_year' + passengerId).val());
                                 errorElement = $('#age_error_' + passengerId);
                              } else {
                                 day = parseInt($('#birthdayEn_day' + passengerId).val());
                                 month = parseInt($('#birthdayEn_month' + passengerId).val());
                                 year = parseInt($('#birthdayEn_year' + passengerId).val());
                                 errorElement = $('#age_error_en_' + passengerId);
                              }

                              if (!day || !month || !year) {
                                 errorElement.hide();
                                 return true;
                              }

                              const age = calculateAgeFromSelection(day, month, year, calendarType);
                              let isValid = true;
                              let errorMessage = '';

                              switch(passengerType) {
                                 case 'Inf':
                                    if (age < 0 || age > 2) {
                                       isValid = false;
                                       errorMessage = 'سن باید بین 0 تا 2 سال باشد';
                                    }
                                    break;
                                 case 'Chd':
                                    if (age < 2 || age > 12) {
                                       isValid = false;
                                       errorMessage = 'سن باید بین 2 تا 12 سال باشد';
                                    }
                                    break;
                                 case 'Adt':
                                    if (age < 12) {
                                       isValid = false;
                                       errorMessage = 'سن باید بیشتر از 12 سال باشد';
                                    }
                                    break;
                              }

                              if (!isValid) {
                                 errorElement.text(errorMessage).show();
                                 return false;
                              } else {
                                 errorElement.hide();
                                 return true;
                              }
                           }

                           // تابع محاسبه سن
                           function calculateAgeFromSelection(day, month, year, calendarType) {
                              const today = new Date();
                              let birthDate;

                              if (calendarType === 'jalali') {
                                 birthDate = convertJalaliToGregorian(year, month, day);
                              } else {
                                 birthDate = new Date(year, month - 1, day);
                              }

                              let age = today.getFullYear() - birthDate.getFullYear();
                              const monthDiff = today.getMonth() - birthDate.getMonth();

                              if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                                 age--;
                              }

                              return age;
                           }

                           // تابع تبدیل تاریخ شمسی به میلادی (تصحیح شده)
                           function convertJalaliToGregorian(jy, jm, jd) {
                              // استفاده از کتابخانه PersianDate اگر موجود باشد
                              if (typeof PersianDate !== 'undefined') {
                                 const pd = new PersianDate([jy, jm, jd]);
                                 return new Date(pd.toGregorian());
                              }

                              // الگوریتم تبدیل دقیق‌تر
                              jy = parseInt(jy);
                              jm = parseInt(jm);
                              jd = parseInt(jd);

                              var gy = jy + 621;
                              var daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                              // بررسی سال کبیسه میلادی
                              if ((gy % 4 === 0 && gy % 100 !== 0) || gy % 400 === 0) {
                                 daysInMonth[1] = 29;
                              }

                              // محاسبه روزهای گذشته از ابتدای سال شمسی
                              var dayOfYear = jd;
                              for (var i = 0; i < jm - 1; i++) {
                                 dayOfYear += (i < 6) ? 31 : 30;
                              }

                              // تبدیل به میلادی
                              var gDate = new Date(gy, 0, 1);
                              gDate.setDate(gDate.getDate() + dayOfYear - 1);

                              // تنظیم ماه و روز صحیح
                              var gMonth = gDate.getMonth();
                              var gDay = gDate.getDate();
                              var gYear = gDate.getFullYear();

                              return new Date(gYear, gMonth, gDay);
                           }

                           // تابع تبدیل میلادی به شمسی (تصحیح شده)
                           function convertGregorianToJalali(gy, gm, gd) {
                              gy = parseInt(gy);
                              gm = parseInt(gm);
                              gd = parseInt(gd);

                              var gDate = new Date(gy, gm - 1, gd);
                              var gYear = gDate.getFullYear();
                              var gMonth = gDate.getMonth();
                              var gDay = gDate.getDate();

                              // آرایه‌های مربوط به ماه‌ها
                              var gDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                              var jDaysInMonth = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

                              // بررسی سال کبیسه میلادی
                              if ((gYear % 4 === 0 && gYear % 100 !== 0) || gYear % 400 === 0) {
                                 gDaysInMonth[1] = 29;
                              }

                              // محاسبه روزهای گذشته از ابتدای سال میلادی
                              var gDayOfYear = gDay;
                              for (var i = 0; i < gMonth; i++) {
                                 gDayOfYear += gDaysInMonth[i];
                              }

                              // محاسبه سال شمسی
                              var jYear = gYear - 621;
                              var jDayOfYear = gDayOfYear - 79;

                              if (jDayOfYear <= 0) {
                                 jYear--;
                                 jDayOfYear += 365;
                              }

                              // محاسبه ماه و روز شمسی
                              var jMonth = 1;
                              var jDay = jDayOfYear;

                              for (var i = 0; i < 12; i++) {
                                 if (jDay <= jDaysInMonth[i]) {
                                    jMonth = i + 1;
                                    break;
                                 }
                                 jDay -= jDaysInMonth[i];
                              }

                              return [jYear, jMonth, jDay];
                           }

                           // تابع updateHiddenBirthdayFields (تصحیح شده)
                           function updateHiddenBirthdayFields(passengerId, calendarType) {
                              let day, month, year;

                              if (calendarType === 'jalali') {
                                 day = $('#birthday_day' + passengerId).val();
                                 month = $('#birthday_month' + passengerId).val();
                                 year = $('#birthday_year' + passengerId).val();

                                 if (day && month && year) {
                                    const jalaliDate = year + '-' + String(month).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                                    $('#birthday' + passengerId).val(jalaliDate); // فیلد hidden
                                    $('#birthday_display' + passengerId).val(jalaliDate); // فیلد متنی (مخفی)

                                    const gDate = convertJalaliToGregorian(parseInt(year), parseInt(month), parseInt(day));
                                    const gFormatted = gDate.getFullYear() + '-' +
                                       String(gDate.getMonth() + 1).padStart(2, '0') + '-' +
                                       String(gDate.getDate()).padStart(2, '0');
                                    $('#birthdayEn' + passengerId).val(gFormatted); // فیلد hidden
                                    $('#birthdayEn_display' + passengerId).val(gFormatted); // فیلد متنی (مخفی)
                                 }
                              } else {
                                 day = $('#birthdayEn_day' + passengerId).val();
                                 month = $('#birthdayEn_month' + passengerId).val();
                                 year = $('#birthdayEn_year' + passengerId).val();

                                 if (day && month && year) {
                                    const gDate = new Date(year, month - 1, day);
                                    const gFormatted = gDate.getFullYear() + '-' +
                                       String(gDate.getMonth() + 1).padStart(2, '0') + '-' +
                                       String(gDate.getDate()).padStart(2, '0');
                                    $('#birthdayEn' + passengerId).val(gFormatted); // فیلد hidden
                                    $('#birthdayEn_display' + passengerId).val(gFormatted); // فیلد متنی (مخفی)

                                    const j = convertGregorianToJalali(gDate.getFullYear(), gDate.getMonth() + 1, gDate.getDate());
                                    const jFormatted = j[0] + '-' +
                                       String(j[1]).padStart(2, '0') + '-' +
                                       String(j[2]).padStart(2, '0');
                                    $('#birthday' + passengerId).val(jFormatted); // فیلد hidden
                                    $('#birthday_display' + passengerId).val(jFormatted); // فیلد متنی (مخفی)
                                 }
                              }
                           }



                        </script>




                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="NationalCode{$i}" type="tel" placeholder="##Nationalnumber##" name="NationalCode{$i}" maxlength="10" class="UniqNationalCode" >
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="passportNumber{$i}" type="text" placeholder="##Numpassport##" name="passportNumber{$i}" class="UniqPassportNumber" onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberI{$i}')">
                        </div>

                        {*                    <div class="s-u-passenger-item s-u-passenger-item-change no-star">*}
                        {*                        <input id="passportExpire{$i}" type="text" placeholder="##Passportexpirydate##" name="passportExpire{$i}" class="gregorianFromTodayCalendar" readonly="readonly">*}
                        {*                    </div>*}

                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat no-star noneIranian">
                            <select name="passportCountry{$i}" class="select2">
                                <option value="" disabled="disabled" selected>##Countryissuingpassport##</option>
                                {foreach $objFunctions->CountryCodes() as $Country}
                                    <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <select id="visaType{$i}" name="visaType{$i}">
                                <option value="" disabled selected="selected">##Typevisa##</option>
                                <option {if $InfoInsurance.num_day >= 92} disabled {/if} value="single">single</option>
                                <option value="multiple">multiple</option>
                            </select>
                        </div>
                    </div>
                    <div id="message{$i}" class="alert_error_field"></div>
                    <div class="w-100 d-flex flex-wrap">

                        <div class="col-lg-12">
                            <div class="alert alert-warning--new" role="alert">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" class="h-full w-full"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                <p class="">
                                    ##insuranceNote##
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="clear"></div>
            </div>
        {/for}
        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

            <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">##InformationSaler##

            </span>

            <div class="clear"></div>
            {if $objSession->IsLogin()}
                <div class="panel-default-change-Buyer boxInformationBuyer">
                    <div class="s-u-passenger-items widthInputInformationBuyer s-u-passenger-item-change">
                        <input id="Mobile_buyer" type="tel" placeholder="##SalerPhone##" name="Mobile_buyer"
                               value="{$InfoMember.mobile}"
                               onkeypress="return checkNumber(event, 'Mobile_buyer')" />
                    </div>

                    <div class="s-u-passenger-items widthInputInformationBuyer padl0 s-u-passenger-item-change">
                        <input id="Email_buyer" type="email" placeholder="##Emailbuyer##" name="Email_buyer" value="{$InfoMember.email}" />
                    </div>
                    <div id="messageInfo" class="alert_error_field"></div>
                </div>
            {else}
                <div class="panel-default-change-Buyer ">
                    <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input  id="Mobile" type="tel" placeholder="##Phonenumber##" name="Mobile" class="">
                    </div>
                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input  id="Telephone" type="tel" placeholder="##Phone##" name="Telephone" class="">
                    </div>
                    <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                        <input  id="Email" type="email" placeholder="##Email##" name="Email" class="">
                    </div>
                    <div id="messageInfo" style="margin-right: 20px"></div>
                </div>
            {/if}
            <div class="clear"></div>
        </div>
        <div class="submit_btn">
            <a href="" onclick="return false" class="f-loader-check loaderpassengers"  id="loader_check" style="display:none"></a>
            <input type="hidden" name="count" id="count" value="{$i-1}">
            <input type="button" onclick="checkfildInsurance('{$i-1}')"  value="##NextStepInvoice##" class="s-u-submit-passenger s-u-select-flight-change site-bg-main-color s-u-submit-passenger-Buyer" id="send_data" >
        </div>
    </form>
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
    </script>

    <script type="text/javascript">
       function pad(val)
       {
          var valString = val + "";
          if (valString.length < 2)
          {
             return "0" + valString;
          } else
          {
             return valString;
          }
       }

       $('.s-u-price-detail-accordion-btn').on("click", function (e) {
          e.preventDefault();
          $(this).parent().find('.s-u-masir-detal-accordion').slideUp('fast');
          $(this).parent().find('.s-u-bar-rule-accordion').slideUp('fast');
          $(this).parent().find('.s-u-price-detail-accordion').slideToggle('fast');
          $('.s-u-result-item-details > ul > li').removeClass('light-white');
          $(this).addClass('light-white');
       });
       $('.s-u-bar-rules-btn').on("click", function (e) {
          e.preventDefault();
          $(this).parent().find('.s-u-masir-detal-accordion').slideUp('fast');
          $(this).parent().find('.s-u-price-detail-accordion').slideUp('fast');
          $(this).parent().find('.s-u-bar-rule-accordion').slideToggle('fast');
          $('.s-u-result-item-details > ul > li').removeClass('light-white');
          $(this).toggleClass('light-white');
       });
       $('.s-u-masir-detail-accordion-btn').on("click", function (e) {
          e.preventDefault();
          $(this).parent().find('.s-u-bar-rule-accordion').slideUp('fast');
          $(this).parent().find('.s-u-price-detail-accordion').slideUp('fast');
          $(this).parent().find('.s-u-masir-detal-accordion').slideToggle('fast');
          $('.s-u-result-item-details > ul > li').removeClass('light-white');
          $(this).toggleClass('light-white');
       });
       // bar and ticket rules popup
       // show popup
       $(".s-u-ticket-rules-btn").on("click", function () {
          $('.s-u-result-item-details > ul > li').removeClass('light-white');
          $(this).toggleClass('light-white');
          $(this).find('.s-u-t-r-p').fadeIn();
          $('.s-u-black-container').fadeIn();
       });
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

          $(this).find(".price-pop").click(function () {

             $(".price-Box").toggleClass("displayBlock");
             $("#lightboxContainer").addClass("displayBlock");
          });
          $(this).find(".closeBtn").click(function () {

             $(".price-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $("div#lightboxContainer").click(function () {

             $(".price-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $(this).find(".Cancellation-pop").click(function () {

             $(".Cancellation-Box").toggleClass("displayBlock");
             $("#lightboxContainer").addClass("displayBlock");
          });
          $(this).find(".closeBtn").click(function () {

             $(".Cancellation-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $("div#lightboxContainer").click(function () {

             $(".Cancellation-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });

          $("div#lightboxContainer").click(function () {
             $(".last-p-popup").css("display", "none");
          });
          // $('body').delegate('.DetailSelectTicket','click', function(e) {
          $('.DetailSelectTicket').on('click', function (e) {
             $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
          });
       });


    </script>
{/literal}
