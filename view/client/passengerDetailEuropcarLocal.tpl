{load_presentation_object filename="resultEuropcarLocal" assign="objResult"}

{assign var="idCar" value=$smarty.post.idCar}
{assign var="sourceStationId" value=$smarty.post.sourceStationId}
{assign var="destStationId" value=$smarty.post.destStationId}
{assign var="getCarDateTime" value=$smarty.post.getCarDateTime}
{assign var="returnCarDateTime" value=$smarty.post.returnCarDateTime}
{assign var="typeApplication" value=$smarty.post.typeApplication}
{assign var="CurrencyCode" value=$smarty.post.CurrencyCode}

{$objResult->getStation($sourceStationId, $destStationId)}
{$objResult->getThings($sourceStationId, $destStationId)}
{$objResult->getCarsById($idCar)}

{$objResult->getDay($getCarDateTime, $returnCarDateTime)}

{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
<div id="lightboxContainer" class="lightboxContainerOpacity"></div>
<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->



<div class="container">
    <form method="post" id="formPassengerDetailEuropcarLocal" action="{$smarty.const.ROOT_ADDRESS}/factorEuropcarLocal" enctype="multipart/form-data">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##bookingcarbelow##<i class="fa fa-car" aria-hidden="true"></i></span>

        <div class="hotel-booking-room marb0 row">

            <div class="col-md-3 nopad">
                <div class="hotel-booking-room-image">
                    <a>
                        <img src="{$objResult->urlImageCar($objResult->infoCars['Img'])}" alt="{$objResult->infoCars['Brand']['Name']}">
                    </a>
                </div>
            </div>

            <div class="col-md-9 ">
                <div class="hotel-booking-room-content">
                    <div class="hotel-booking-room-text">
                        <b class="hotel-booking-room-name">
                            {$objResult->infoCars['Brand']['Name']} - {$objResult->infoCars['Model']} ({$objResult->infoCars['Brand']['EngName']})
                        </b>

                        <b class="hotel-booking-room-name car-booking-price">##Priceday##
                            {if $objResult->serviceDiscountLocal['off_percent'] neq 0}
                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($objResult->setDiscount($objResult->infoCars['PriceEachDayRial']), $CurrencyCode)}
                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                            {else}
                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($objResult->infoCars['PriceEachDayRial'], $CurrencyCode)}
                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                            {/if}
                        </b>


                        <div class="hotel-result-item-rule car-rule">
                            <p>
                                <i class="fa fa-check"></i>##Capacity##: {$objResult->infoCars['PassengerCount']} ##People##
                            </p>
                            <p>
                                <i class="fa fa-check"></i>##MaximumKm##: {$objResult->infoCars['AllowedKm']} Km
                            </p>
                            <p>
                                <i class="fa fa-check"></i>##Minimumagedriver## {$objResult->infoCars['MinAgeToRent']}
                            </p>
                            <p>
                                {assign var="addKmCurrency" value=$objFunctions->CurrencyCalculate($objResult->infoCars['AddKmCostRial'], $CurrencyCode)}
                                <i class="fa fa-check"></i>##Priceperkilometerextra##: {$objFunctions->numberFormat($addKmCurrency.AmountCurrency)} {$addKmCurrency.TypeCurrency}
                            </p>
                            {if $objResult->infoCars['InsuranceCostRial'] neq 0}
                            <p>
                                {assign var="insuranceCurrency" value=$objFunctions->CurrencyCalculate($objResult->infoCars['InsuranceCostRial'], $CurrencyCode)}
                                <i class="fa fa-check"></i>##Insuranceprice##: {$objFunctions->numberFormat($insuranceCurrency.AmountCurrency)} {$insuranceCurrency.TypeCurrency}
                            </p>
                            {/if}
                        </div>

                    </div>

                    <div class="hotel-booking-room-text">
                        <ul>
                            <li class="car-check-text width35"><i class="fa fa-map-marker"></i> ##Delivery## :
                                <span class="hotel-check-date" dir="rtl">{$objResult->sourceStationName}</span>
                            </li>
                            <li class="car-check-text"><i class="fa fa-calendar-check-o"></i> ##Deliverydate## :
                                <span class="hotel-check-date" dir="rtl">{$objResult->getCarDate}</span>
                            </li>
                            <li class="car-check-text"><i class="fa fa-clock-o"></i> ##Timedelivery## :
                                <span class="hotel-check-date" dir="rtl">{$objResult->getCarTime}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="hotel-booking-room-text">
                        <ul>
                            <li class="car-check-text width35"><i class="fa fa-map-marker"></i> ##Return## :
                                <span class="hotel-check-date" dir="rtl">{$objResult->destStationName}</span>
                            </li>
                            <li class="car-check-text"><i class="fa fa-calendar-check-o"></i> ##Returndate## :
                                <span class="hotel-check-date" dir="rtl">{$objResult->returnCarDate}</span>
                            </li>
                            <li class="car-check-text"><i class="fa fa-clock-o"></i> ##Returntime## :
                                <span class="hotel-check-date" dir="rtl">{$objResult->returnCarTime}</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color"> ##Selectcaraccessories##
            <i class="fa fa-indent mart5  zmdi-hc-fw"></i>
        </span>
        {if $objResult->isThingsById['source'] eq 'true'}
        <div class="s-u-result-wrapper">
            <ul>
                <!-- result item -->
                {foreach $objResult->listThingsById['source'] as $things}

                    {if $things['IsTransfer'] neq 1}
                        <li class="s-u-result-item s-u-result-item-change wow fadeInDown car-things-borderB">

                            <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                                <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                    <img src="{$objResult->urlImageThings($things['Name'])}">
                                </div>
                            </div>

                            <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                                <div class="details-wrapper-change">

                                    <div class="s-u-result-raft first-row-change">
                                        <div class="s-u-result-items-div-change right-Cell-car">

                                            <div class="s-u-result-item-div s-u-result-items-div-change displayib fltr">
                                                <input type="hidden" id="thingsName{$things['Id']}" name="thingsName{$things['Id']}" value="{$things['Name']}">
                                                <span class="iranB">{$things['Name']}</span>
                                                <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$things['EngName']}</span>
                                            </div>

                                            <div class="s-u-result-item-div s-u-result-items-div-change displayib fltr show-div">
                                                <span> ##Priceday##:
                                                    {assign var="perThingCurrency" value=$objFunctions->CurrencyCalculate($things['MaxCostRial'], $CurrencyCode)}
                                                    <i class="iranB">{$objFunctions->numberFormat($perThingCurrency.AmountCurrency)}</i> {$perThingCurrency.TypeCurrency}
                                                </span>
                                                <span>({$things['StationStatus']['Name']})</span>
                                            </div>

                                            <input type="hidden" id="priceThings{$things['Id']}" name="priceThings{$things['Id']}" data-amount="{$perThingCurrency.AmountCurrency}" value="{$things['MaxCostRial']}">

                                            <div class="s-u-result-item-div s-u-result-items-div-change displayib fltr  show-div">
                                                <div class="form-hotel-item form-hotel-item-searchBox width90 height50">
                                                    <select name="countThings{$things['Id']}" id="countThings{$things['Id']}" class="select2" onchange="calculateEuropcarPrices('{$things['Id']}')">
                                                        <option value="" selected="selected">##Numberofrequests##</option>
                                                        {if $things['MaxCount'] neq ''}
                                                            {for $n=1 to $things['MaxCount']}
                                                                <option value="{$n}">{$n}</option>
                                                            {/for}
                                                        {else}
                                                            {for $n=1 to 10}
                                                                <option value="{$n}">{$n}</option>
                                                            {/for}
                                                        {/if}

                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="left-Cell-change">
                                            <div class="s-u-bozorg s-u-bozorg-change">
                                                <span class="s-u-price-car"> ##Maximumpricefor## <i class="s-u-price-car-i">{$objResult->day}</i> ##Day##</span>
                                                <span class="s-u-bozorg price">
                                                      <i id="totalPriceThings{$things['Id']}">0</i> {$perThingCurrency.TypeCurrency}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
        {else}
            <div class="s-u-result-wrapper">
               <span class="s-u-result-item-change direcR iranR txt12 txtRed">##Accessoriesprovidedstation##</span>
            </div>
        {/if}

        <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>

    </div>


    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color"> ##Driverprofile##
            <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
        </span>

        <input type="hidden" id="numberRow" value="0">
        <div class="panel-default-change pull-right site-border-main-color">
            <div class="panel-heading-change">

                <span class="hidden-xs-down">##Nation##:</span>

                <span class="kindOfPasenger">
                    <label class="control--checkbox">
                        <span>##Iranian##</span>
                        <input type="radio" name="passengerNationality" id="passengerNationality" value="0" class="nationalityChange" checked="checked">
                        <div class="checkbox">
                            <div class="filler"></div>
                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                        </div>
                    </label>
                </span>
                <span class="kindOfPasenger">
                    <label class="control--checkbox">
                        <span> ##Noiranian##</span>
                        <input type="radio" name="passengerNationality" id="passengerNationality" value="1" class="nationalityChange">
                        <div class="checkbox">
                            <div class="filler"></div>
                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                        </div>
                    </label>
                </span>

                {if $objSession->IsLogin()}
                    <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('A1')">
                         <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                    </span>
                {/if}
            </div>
            <div class="clear"></div>

            <div class="panel-body-change">

                <div class="s-u-passenger-item  s-u-passenger-item-change ">
                    <select id="genderA1" name="genderA1">
                        <option value="" disabled="" selected="selected">##Sex##</option>
                        <option value="Male">##Sir##</option>
                        <option value="Female">##Lady##</option>
                    </select>
                </div>

                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                    <input id="nameEnA1" type="text" placeholder="##Nameenglish##" name="nameEnA1"
                           onkeypress="return isAlfabetKeyFields(event, 'nameEnA1')" class="">
                </div>
                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                    <input id="familyEnA1" type="text" placeholder="##Familyenglish##" name="familyEnA1"
                           onkeypress="return isAlfabetKeyFields(event, 'familyEnA1')" class="">
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                    <input id="birthdayEnA1" type="text" placeholder="##miladihappybirthday##" name="birthdayEnA1"
                           class="gregorianDriverBirthdayCalendar pwt-datepicker-input-element"
                           readonly="readonly">
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="nameFaA1" type="text" placeholder="##Namepersion##" name="nameFaA1"
                           onkeypress=" return persianLetters(event, 'nameFaA1')" class="justpersian">
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="familyFaA1" type="text" placeholder="##Familypersion##" name="familyFaA1"
                           onkeypress=" return persianLetters(event, 'familyFaA1')" class="justpersian">
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                    <input id="birthdayA1" type="text" placeholder="##shamsihappybirthday##" name="birthdayA1"
                           class="shamsiDriverBirthdayCalendar pwt-datepicker-input-element" readonly="readonly">
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                    <input id="NationalCodeA1" type="tel" placeholder="##Nationalnumber## " name="NationalCodeA1" maxlength="10"
                           class="UniqNationalCode">
                </div>
                
                <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                    <select name="passportCountryA1" id="passportCountryA1"
                            class="select2">
                        <option value="">##Countryissuingpassport##</option>
                        {foreach $objFunctions->CountryCodes() as $Country}
                            <option value="{$Country['code']}">{$Country['titleFa']}</option>
                        {/foreach}
                    </select>
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                    <input id="passportNumberA1" type="text" placeholder="##Numpassport##"
                           name="passportNumberA1" class="UniqPassportNumber">
                </div>
                <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                    <input id="passportExpireA1" class="gregorianFromTodayCalendar pwt-datepicker-input-element"
                           type="text" placeholder="##Passportexpirydate##" name="passportExpireA1">
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="MobileA1" type="tel" placeholder="##Phonenumber##" name="MobileA1" maxlength="11" minlength="11">
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="TelephoneA1" type="tel" placeholder="##Telephone##" name="TelephoneA1" maxlength="11" minlength="11">
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="EmailA1" type="email" placeholder="##Email##" name="EmailA1">
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change ">
                    <select id="RefundTypeA1" name="RefundTypeA1">
                        <option value="" disabled="" selected="selected">##Refundtype##</option>
                        <option value="1">##Checkbook##</option>
                        <option value="2">##Promissorynote##</option>
                        <option value="3">##Cash##</option>
                    </select>
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change ">
                    <select id="DrivingCrimesTypeA1" name="DrivingCrimesTypeA1">
                        <option value="" disabled="" selected="selected">##Typevehiclecrimewarranty##</option>
                        <option value="1">##Checkbook##</option>
                        <option value="2">##Promissorynote##</option>
                        <option value="3">##Cash##</option>
                    </select>
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change width100">
                    <textarea id="AddressA1" type="text" placeholder="##Address##" name="AddressA1" class="dir-ltr"></textarea>
                </div>

                <div class="clear"></div>
                <div class="checkbox-passenger-car">
                    <p class="s-u-result-item-RulsCheck-item">
                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top"
                               id="HasSourceStationReturnCost" name="HasSourceStationReturnCost" value="1" type="checkbox">
                        <label class="FilterHoteltypeName site-main-text-color-a " for="HasSourceStationReturnCost">##Deliverycarcustomerpremises##</label>
                    </p>

                    <p class="s-u-result-item-RulsCheck-item">
                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top"
                               id="HasDestStationReturnCost" name="HasDestStationReturnCost" value="1" type="checkbox">
                        <label class="FilterHoteltypeName site-main-text-color-a " for="HasDestStationReturnCost">##Refundscarcustomerlocation##</label>
                    </p>
                </div>

                <div id="messageA1"></div>
            </div>
        </div>
        <div class="clear"></div>

    </div>


    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##InformationidentityDocuments##
            <i class="fa fa-file"></i>
        </span>

        <div class="panel-default-change pull-right site-border-main-color">

            <div class="panel-heading-change">
                <span class="hidden-xs-down">##Identityidentity##:</span>
            </div>
            <div class="clear"></div>

            <div class="panel-body-change">

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <select id="IdentityFileType" name="IdentityFileType">
                        <option value="" disabled="" selected="selected">##Typeidentitydocument##</option>
                        <option value="1">##Nationalcard##</option>
                        <option value="2">##Certificates##</option>
                        <option value="3">##Passport##</option>
                    </select>
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="IdentityFile" type="file" name="IdentityFile">
                </div>

            </div>
        </div>
        <div class="clear"></div>

        <div class="panel-default-change pull-right site-border-main-color">

            <div class="panel-heading-change">
                <span class="hidden-xs-down">##Residencedocument##:</span>
            </div>
            <div class="clear"></div>

            <div class="panel-body-change">

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <select id="HabitationFileType" name="HabitationFileType">
                        <option value="" disabled="" selected="selected">##Locationdocumentfile##</option>
                        <option value="1">##Lastphonebill##</option>
                        <option value="2">##Propertycertificatelease##</option>
                        <option value="3">##Another##</option>
                    </select>
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="HabitationFile" type="file" name="HabitationFile">
                </div>

            </div>
        </div>
        <div class="clear"></div>

        <div class="panel-default-change pull-right site-border-main-color">

            <div class="panel-heading-change">
                <span class="hidden-xs-down">  ##Occupation##:</span>
            </div>
            <div class="clear"></div>

            <div class="panel-body-change">

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <select id="JobFileType" name="JobFileType">
                        <option value="" disabled="" selected="selected">##Jobtypefile##</option>
                        <option value="1">##Lastlegalcheck##</option>
                        <option value="2">##Personnelcard## ( ##MedicalSystem##، ##Engineeringsystem## )</option>
                        <option value="3">##Businesscardbusinesslicense##</option>
                        <option value="4">##Companyrecords##</option>
                        <option value="5">##Printbankaccount##</option>
                        <option value="6">##Another##</option>
                    </select>
                </div>

                <div class="s-u-passenger-item s-u-passenger-item-change">
                    <input id="JobFile" type="file" name="JobFile">
                </div>


            </div>
        </div>
        <div id="message"></div>
        <div class="clear"></div>

    </div>
    <div class="clear"></div>


    {if not $objSession->IsLogin()}
        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
              ##InformationSaler## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
          </span>
            <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
            <div class="clear"></div>
            <div class="panel-default-change-Buyer site-bg-main-color">
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Mobile" type="text" placeholder=" ##Phonenumber##" name="Mobile" class="dir-ltr">
                </div>
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Telephone" type="text" placeholder=" ##Telephone##" name="Telephone" class="dir-ltr">
                </div>
                <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                    <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                </div>
                <div id="messageInfo"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    {/if}


        <input type="hidden" id="idCar" name="idCar" value="{$idCar}">
        <input type="hidden" id="sourceStationId" name="sourceStationId" value="{$sourceStationId}">
        <input type="hidden" id="sourceStationName" name="sourceStationName" value="{$objResult->sourceStationName}">
        <input type="hidden" id="destStationId" name="destStationId" value="{$destStationId}">
        <input type="hidden" id="destStationName" name="destStationName" value="{$objResult->destStationName}">
        <input type="hidden" id="getCarDateTime" name="getCarDateTime" value="{$getCarDateTime}">
        <input type="hidden" id="returnCarDateTime" name="returnCarDateTime" value="{$returnCarDateTime}">
        <input type="hidden" id="typeApplication" name="typeApplication" value="{$typeApplication}">
        <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="Local">
        <input type="hidden" name="CurrencyCode" id="CurrencyCode" value="{$CurrencyCode}">

        <input type="hidden" id="allThingsId" name="allThingsId" value="{$objResult->allThingsId}">
        <input type="hidden" id="paymentsPriceCar" name="paymentsPriceCar" value="{$objResult->infoCars['PriceEachDayRial']}">
        <input type="hidden" id="paymentsPrice" name="paymentsPrice" value="{$objResult->infoCars['PriceEachDayRial']}">
        <input type="hidden" id="selectThingsId" name="selectThingsId" value="">
        <input type="hidden" id="selectThingsCount" name="selectThingsCount" value="">
        <input type="hidden" id="factorNumber" name="factorNumber" value="{$objResult->createFactorNumber()}">
        <input type="hidden" name="IdMember" id="IdMember" value="" >

        <div class="" style="position: relative;display: inline-block;float: right;">
            <a class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
            <input type="button" onclick="checkPassengerCarLocal('{$smarty.now}')" value="##Nextstep##(##Invoice##)&nbsp; >>" class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color" id="send_data">
        </div>

</form>
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

    $(document).ready(function() {

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

<script>
    var age = {/literal}{$objResult->infoCars['MinAgeToRent']}{literal};
</script>

{/literal}

