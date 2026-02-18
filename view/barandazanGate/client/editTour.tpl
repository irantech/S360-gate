{load_presentation_object filename="resultTourLocal" assign="objTour"}
{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

{if $objTour->accessReservationTour() and $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}

    {load_presentation_object filename="reservationTour" assign="objResult"}
    {assign var="infoTour" value=$objResult->infoTourById($smarty.get.id)}

    {assign var="tourId" value=$infoTour['id']}

    {if $infoTour['user_id'] eq $smarty.session.userId}


        {assign var="getIsEditor" value=$objResult->isEditor('editor')}
        {if $getIsEditor[0]['enable'] eq '1'}
            {assign var="isEditor" value="setToEditor"}
        {else}
            {assign var="isEditor" value="width100"}
        {/if}


        {load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
        {load_presentation_object filename="reservationBasicInformation" assign="objBasic"}


        {assign var=tourTypeIdArray value=$infoTour['tour_type_id']|json_decode:true}

        {if $infoTour['is_show'] eq 'no'}
            <div class="main-Content-top s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Disallowshowinssite##
                </span>
                <div class="s-u-result-wrapper">
                    <span class="s-u-result-item-change direcR iranR txt14 txtRed">##BecauseOf## : {$infoTour['comment_cancel']}</span>
                </div>
            </div>
        {/if}
        <form id='editTourForm' name="editTourForm" method='post'
              data-toggle="validator" enctype='multipart/form-data' action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">
            <input type="hidden" name="flag" id="flag" value="editTour"/>
            <input type="hidden" name="tourId" id="tourId" value="{$smarty.get.id}"/>
            <input type="hidden" name="userId" id="userId" value="{$infoTour['user_id']}"/>

            {if 1|in_array:$tourTypeIdArray}
                <input type="hidden" name="tourType" id="tourType" value="oneDayTour"/>
                <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="yes"/>
            {else}
                <input type="hidden" name="tourType" id="tourType" value="{$tourTypeIdArray}"/>
                <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="no"/>
            {/if}

            <div class="main-Content-top s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart5"></i> ##Defualtinformationtour##
            </span>
                <div class="panel-default-change site-border-main-color">

                    <div class="s-u-result-item-change">

                        <div class="s-u-passenger-item no-star ">
                            <label for="tourName" class="flr">##Nametour##:</label>
                            <input type="text" name="tourName" id="tourName" value="{$infoTour['tour_name']}"
                                   placeholder="##Nametour##" readonly>
                        </div>

                        <div class="s-u-passenger-item no-star width16">
                            <label for="tourNameEn" class="flr">##EnglishNameOfTour##:</label>
                            <input type="text" name="tourNameEn" id="tourNameEn" value="{$infoTour['tour_name_en']}">
                        </div>

                        <div class="s-u-passenger-item no-star width16">
                            <label for="tourCode" class="flr">##codeTour##:</label>
                            <input type="text" name="tourCode" id="tourCode" value="{$infoTour['tour_code']}"
                                   placeholder="##codeTour##" disabled>
                        </div>

                        <div class="s-u-passenger-item no-star width16">
                            <label for="tourReason" class="flr">##TheOccasionOfTheTour##:</label>
                            <input type="text" name="tourReason" id="tourReason" value="{$infoTour['tour_reason']}"
                                   placeholder="##EidToEid## / ##WorldCup## / ...">
                        </div>

                        <div class="s-u-passenger-item no-star width16">
                            <label for="stopTimeReserve" class="flr">##SaleStopTime## (##Hour##):</label>
                            <input type="text" name="stopTimeReserve" id="stopTimeReserve" value=""
                                   placeholder="##SaleStopTime##" >
                        </div>

                        <div class="s-u-passenger-item no-star width16">
                            <label for="stopTimeCancel" class="flr">##SaleStopTime## (##Hour##):</label>
                            <input type="text" name="stopTimeCancel" id="stopTimeCancel" value=""
                                   placeholder="##StopTime## ##Cancellation##" >
                        </div>

                    </div>

                    {*<div class="s-u-result-item-change">
                        {assign var=itemArray value=$infoTour['tour_type_id']|json_decode:true}
                        <div class="s-u-passenger-item no-star width50">
                            <label for="tourType" class="flr">##Typetour##:</label>
                            <select name="tourTypeId[]" id="tourTypeId" class="select2" multiple="multiple"
                                    onchange="checkForOneDayTour()">
                                {foreach $objBasic->SelectAll('reservation_tour_type_tb') as $tourType}
                                    {if $tourType['id'] neq '1'}
                                        <option value="{$tourType['id']}"
                                                {if $tourType['id']|in_array:$itemArray}selected{/if}>{$tourType['tour_type']}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>

                        {if 1|in_array:$tourTypeIdArray}
                            <div class="notifications-oneDayTour" id="notificationOneDayTour">
                                <i class="fa fa-commenting-o"></i><i> ##Onetour##؛ </i>##NoAbleToChooseHotelToStay##
                            </div>
                            <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="yes"/>
                        {else}
                            <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="no"/>
                        {/if}
                    </div>*}

                    <div class="s-u-result-item-change">

                        <div class="s-u-passenger-item no-star width12">
                            <label for="free" class="flr">##Permissibleamount##:</label>
                            <input type="text" name="free" id="free" value="{$infoTour['free']}"
                                   placeholder="##Permissibleamount##" disabled>
                        </div>

                        <div class="s-u-passenger-item no-star width12 txt11">
                            <label for="startDate" class="flr">##Datestarthold##:</label>
                            <input type="text" class="shamsiDeptCalendar"
                                   name="startDate" id="startDate"
                                   value="{$objFunctions->convertDate($infoTour['start_date'])}"
                                   placeholder="##Datestarthold## ##Tour##">
                        </div>

                        <div class="s-u-passenger-item no-star width12 txt11">
                            <label for="endDate" class="flr">##Dateendhold##:</label>
                            <input type="text" class="shamsiReturnCalendar"
                                   name="endDate" id="endDate"
                                   value="{$objFunctions->convertDate($infoTour['end_date'])}"
                                   placeholder="##Dateendhold## ##Tour##">
                        </div>

                        <div class="s-u-passenger-item no-star width12 tooltip-tour">
                            <label for="night" class="flr">##NumberOfNightsStay##:</label>
                            <input type="text" name="night" id="night" value="{$infoTour['night']}"
                                   placeholder="##NumberOfNightsStay##">
                            <span class="tooltipText-tour">##Tourtooltipnight##</span>
                        </div>

                        <div class="s-u-passenger-item no-star width12 tooltip-tour">
                            <label for="day" class="flr">##NumberOfDaysOfTravel##:</label>
                            <input type="text" name="day" id="day" value="{$infoTour['day']}" placeholder="##NumberOfDaysOfTravel##">
                            <span class="tooltipText-tour">##Tourtooltipday##</span>
                        </div>

                        <div class="s-u-passenger-item no-star width12">
                            <label for="prepaymentPercentage" class="flr">##Prepaymentpercentage##:</label>
                            <select name="prepaymentPercentage" id="prepaymentPercentage" class="select2">
                                <option value="" disabled="disabled" selected>##Selection##</option>
                                {section name=foo start=10 loop=60 step=10}
                                    <option value="{$smarty.section.foo.index}"
                                            {if $infoTour['prepayment_percentage'] eq $smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                {/section}
                            </select>
                        </div>

                        <div class="s-u-passenger-item no-star width12">
                            <label for="visa" class="flr">##Visa##:</label>
                            <select name="visa" id="visa" class="select2">
                                <option value="" disabled="disabled" selected>##Selection##</option>
                                <option value="yes" {if $infoTour['visa'] eq 'yes'}selected{/if}>##Have##</option>
                                <option value="no" {if $infoTour['visa'] eq 'no'}selected{/if}>##Donthave##</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item no-star width12">
                            <label for="insurance" class="flr">##Insurance##:</label>
                            <select name="insurance" id="insurance" class="select2">
                                <option value="" disabled="disabled" selected> ##Selection##</option>
                                <option value="yes" {if $infoTour['insurance'] eq 'yes'}selected{/if}>##Have##</option>
                                <option value="no" {if $infoTour['insurance'] eq 'no'}selected{/if}>##Donthave##
                                </option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item no-star width100">
                            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">##Description##</h2>
                            </div>
                            <div class="panel height0 panel-editor">
                            <textarea name="description" id="description" dir="rtl" cols="100" rows="7"
                                      class="{$isEditor}">{$infoTour['description']}</textarea>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star width100">
                            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                    ##Requireddocuments##</h2></div>
                            <div class="panel height0 panel-editor">
                            <textarea name="requiredDocuments" id="requiredDocuments" dir="rtl" cols="40" rows="7"
                                      class="{$isEditor}">{$infoTour['required_documents']}</textarea>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star width100">
                            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                    ##Requireddocuments##</h2></div>
                            <div class="panel height0 panel-editor">
                                <textarea name="rules" id="rules" dir="rtl" cols="40" rows="7"
                                          class="{$isEditor}">{$infoTour['rules']}</textarea>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star width100">
                            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                    ##Cancellationrules##</h2></div>
                            <div class="panel height0 panel-editor">
                            <textarea name="cancellationRules" id="cancellationRules" dir="rtl" cols="40" rows="7"
                                      class="{$isEditor}">{$infoTour['cancellation_rules']}</textarea>
                            </div>
                        </div>

                        <div class="s-u-passenger-item no-star width100">
                            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                    ##Tourtravelprogram##</h2></div>
                            <div class="panel height0 panel-editor">
                            <textarea rows="10" name="travelProgram" id="travelProgram" dir="rtl" cols="40"
                                      class="{$isEditor}">{$infoTour['travel_program']}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="main-Content-top s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="fa fa-file-image-o zmdi-hc-fw mart5"></i>##Uploadfilepackage##
            </span>
                <div class="panel-default-change site-border-main-color">
                    <div class="s-u-result-item-change">

                        <div class="s-u-passenger-item no-star">
                            <label for="tourPic" class="flr">##Indeximg##:</label>
                            <input type="file" name="tourPic" id="tourPic" multiple
                                   accept="image/x-png, image/gif, image/jpeg, image/jpg" disabled>
                        </div>
                        <div class="notifications-upload-image">
                            <span><i class="fa fa-angle-double-left"></i>##Photodisplayedresult##</span>
                            <span><i class="fa fa-angle-double-left"></i> ##Selectedfileextension##: <b>.jgp,</b><b> .jpeg,</b><b> .gif,</b><b> png</b></span>
                            <span><i class="fa fa-angle-double-left"></i>##Capacityimage## <b>1MB</b> ##Do##</span>
                        </div>
                        <div class="show-upload-image">
                            <a class="downloadLink"
                               href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_pic']}"
                               target="_blank"
                               type="application/octet-stream">
                                <img style="width: 63% !important;height: auto;"
                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_pic']}"
                                     alt="{$tour['tour_name']}">
                            </a>
                        </div>
                    </div>
                    <div class="s-u-result-item-change">
                        <div class="s-u-passenger-item no-star">
                            <label for="tourFile" class="flr">##Package##:</label>
                            <input type="file" name="tourFile" id="tourFile" multiple data-height="100"
                                   accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf"
                                   data-default-file=""/>
                        </div>
                        <div class="notifications-upload-image">
                            <span><i class="fa fa-angle-double-left"></i> ##Selectedfileextension##: <b>.pdf,</b><b> .jgp,</b><b> .jpeg,</b><b> .gif,</b><b> png</b></span>
                            <span><i class="fa fa-angle-double-left"></i>##Capacityimage##<b>1MB</b> ##Do##</span>
                        </div>
                        <div class="show-upload-image">
                            <a class="downloadLink"
                               href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_file']}"
                               target="_blank"
                               type="application/octet-stream">##Showpackagefile##<i class="mdi mdi-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="main-Content-top s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="fa fa-check zmdi-hc-fw mart5"></i>##Selectsource##
            </span>
                <div class="panel-default-change site-border-main-color">
                    <div class="s-u-result-item-change">

                        <div class="s-u-passenger-item no-star">
                            <label for="originContinent1" class="flr">##Continent## (##Origin##):</label>
                            <select name="originContinent1" id="originContinent1"
                                    class="select2" onchange="fillComboCountry('1', 'origin')" disabled>
                                <option value="" disabled="disabled"> ##Selection##</option>
                                <option value="1" {if $infoTour['origin_continent_id'] eq '1'}selected{/if}>##Asia##
                                </option>
                                <option value="2" {if $infoTour['origin_continent_id'] eq '2'}selected{/if}>##Europe##
                                </option>
                                <option value="3" {if $infoTour['origin_continent_id'] eq '3'}selected{/if}>##America##
                                </option>
                                <option value="4" {if $infoTour['origin_continent_id'] eq '4'}selected{/if}>
                                    ##Australia##
                                </option>
                                <option value="5" {if $infoTour['origin_continent_id'] eq '5'}selected{/if}>##Africa##
                                </option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="originCountry1" class="flr">##Country## (##Origin##):</label>
                            <select name="originCountry1" id="originCountry1"
                                    class="select2" onchange="fillComboCity('1', 'origin')" disabled>
                                <option value="" disabled="disabled"> ##Selection##</option>
                                <option value="{$infoTour['origin_country_id']}"
                                        selected>{$infoTour['origin_country_name']}</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="originCity1" class="flr">##City## (##Origin##):</label>
                            <select name="originCity1" id="originCity1"
                                    class="select2" onchange="fillComboRegion('1', 'origin')" disabled>
                                <option value="" disabled="disabled"> ##Selection##</option>
                                <option value="{$infoTour['origin_city_id']}"
                                        selected>{$infoTour['origin_city_name']}</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item no-star">
                            <label for="originRegion1" class="flr">##Area>## (##Origin##):</label>
                            <select name="originRegion1" id="originRegion1" class="select2" disabled>
                                <option value="" disabled="disabled">##Selection##</option>
                                <option value="{$infoTour['origin_region_id']}"
                                        selected>{$infoTour['origin_region_name']}</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>


            <div class="main-Content-top s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="fa fa-check zmdi-hc-fw mart5"></i> ##Traveldestination##
            </span>
                <div class="panel-default-change site-border-main-color">
                    <div class="s-u-result-item-change">

                        {assign var="route" value=['0' => 'dept', '1' => 'return']}
                        {assign var="numberRout" value="0"}
                        {foreach key=key item=item from=$route}

                            {if $item eq 'dept'}
                                {assign var="idDiv" value="rowRout"}
                              {*  {assign var="classW" value="width20"}*}
                            {elseif $item eq 'return'}
                                {assign var="idDiv" value="rowReturnRoute"}
                                {assign var="classW" value="width25"}
                            {/if}
                            <div id="{$idDiv}">

                                {assign var="count" value="0"}
                                {foreach key=key item=rout from=$objResult->infoTourRoutByIdTour($tourId, $item)}
                                    {$numberRout=$numberRout+1}
                                    {$count=$count+1}
                                    <input type="hidden" name="tourRoutId{$numberRout}" id="tourRoutId{$numberRout}"
                                           value="{$rout['id']}"/>
                                    <input type="hidden" name="tourTitle{$numberRout}" id="tourTitle{$numberRout}"
                                           value="{$item}">
                                    <div id="rowAnyRout{$numberRout}" class="rowAnyRout">

                                        <div class="rout-number divDeleteRow">
                                            <div class="rout-number-50">
                                                <span>##Destination## {if $item eq 'return'}##Return##{else}{$count}{/if}</span>
                                            </div>
                                            <div class="rout-number-50">
                                                {*if $numberRout neq '1'}
                                                    <span class="deleteRow" onclick="logicalDeletionRout('{$rout['id']}')"></span>
                                                {/if*}
                                            </div>
                                        </div>

                                        {if $item eq 'dept'}
                                            <div class="s-u-passenger-item no-star ">
                                                <label for="night{$numberRout}" class="flr">##Countnight##:</label>
                                                <input type="text" name="night{$numberRout}" id="night{$numberRout}"
                                                       value="{$rout['night']}" placeholder="##Countnight##" disabled>
                                            </div>
                                            {*<div class="s-u-passenger-item no-star width10">
                                                <label for="day{$numberRout}" class="flr">##Countday##:</label>
                                                <input type="text" name="day{$numberRout}" id="day{$numberRout}"
                                                       value="{$rout['day']}" placeholder="##Countday##" disabled>
                                            </div>*}
                                        {elseif $item eq 'return'}
                                            <input type="hidden" name="night{$numberRout}" id="night{$numberRout}"
                                                   value="0">
                                            <input type="hidden" name="day{$numberRout}" id="day{$numberRout}"
                                                   value="0">
                                        {/if}

                                        <div class="s-u-passenger-item no-star {$classW}">
                                            <label for="destinationContinent{$numberRout}" class="flr">##Continent##
                                                (##Destination##):</label>
                                            <select name="destinationContinent{$numberRout}"
                                                    id="destinationContinent{$numberRout}"
                                                    class="select2"
                                                    onchange="fillComboCountry({$numberRout}, 'destination')" disabled>
                                                <option value="" disabled="disabled">##Selection##</option>
                                                <option value="1"
                                                        {if $rout['destination_continent_id'] eq '1'}selected{/if}>
                                                    ##Asia##
                                                </option>
                                                <option value="2"
                                                        {if $rout['destination_continent_id'] eq '2'}selected{/if}>
                                                    ##Europe##
                                                </option>
                                                <option value="3"
                                                        {if $rout['destination_continent_id'] eq '3'}selected{/if}>
                                                    ##America##
                                                </option>
                                                <option value="4"
                                                        {if $rout['destination_continent_id'] eq '4'}selected{/if}>
                                                    ##Australia##
                                                </option>
                                                <option value="5"
                                                        {if $rout['destination_continent_id'] eq '5'}selected{/if}>
                                                    ##Africa##
                                                </option>
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star {$classW}">
                                            <label for="destinationCountry{$numberRout}" class="flr">##Country##
                                                (##Destination##):</label>
                                            <select name="destinationCountry{$numberRout}"
                                                    id="destinationCountry{$numberRout}"
                                                    class="select2"
                                                    onchange="fillComboCity({$numberRout}, 'destination')" disabled>
                                                <option value="" disabled="disabled">##Selection##</option>
                                                <option value="{$rout['destination_country_id']}"
                                                        selected>{$rout['destination_country_name']}</option>
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star {$classW}">
                                            <label for="destinationCity{$numberRout}" class="flr">##City##
                                                (##Destination##):</label>
                                            <select name="destinationCity{$numberRout}"
                                                    id="destinationCity{$numberRout}"
                                                    class="select2"
                                                    onchange="fillComboRegion({$numberRout}, 'destination')" disabled>
                                                <option value="" disabled="disabled">##Selection##</option>
                                                <option value="{$rout['destination_city_id']}"
                                                        selected>{$rout['destination_city_name']}</option>
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star ">
                                            <label for="destinationRegion{$numberRout}" class="flr">##Area##
                                                (##Destination##):</label>
                                            <select name="destinationRegion{$numberRout}"
                                                    id="destinationRegion{$numberRout}" class="select2" disabled>
                                                <option value="" disabled="disabled">##Selection##</option>
                                                <option value="{$rout['destination_region_id']}"
                                                        selected>{$rout['destination_region_name']}</option>
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star width12">
                                            <label for="typeVehicle{$numberRout}" class="flr">##Vehicletype##:</label>
                                            <select name="typeVehicle{$numberRout}" id="typeVehicle{$numberRout}"
                                                    class="select2" onchange="listAirline({$numberRout})">
                                                <option value="" disabled="disabled">##Selection##</option>
                                                {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                                                    <option value="{$typeVehicle['id']}"
                                                            {if $rout['type_vehicle_id'] eq $typeVehicle['id']}selected{/if}>{$typeVehicle['name']}</option>
                                                {/foreach}
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star">
                                            <label for="airline{$numberRout}" class="flr">##Shippingcompany##:</label>
                                            <select name="airline{$numberRout}" id="airline{$numberRout}"
                                                    class="select2">
                                                <option value="" disabled="disabled">##Selection##</option>
                                                <option value="{$rout['airline_id']}"
                                                        selected>{$rout['airline_name']}</option>
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star width12">
                                            <label for="class{$numberRout}" class="flr">##Classrate##:</label>
                                            <select name="class{$numberRout}" id="class{$numberRout}" class="select2">
                                                <option value="" disabled="disabled" selected>##Selection##</option>
                                                {foreach $objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade}
                                                    <option value="{$vehicleGrade['name']}"
                                                            {if $rout['class'] eq $vehicleGrade['name']}selected{/if}>{$vehicleGrade['name']}</option>
                                                {/foreach}
                                            </select>
                                        </div>

                                        {assign var=expExitHours value=":"|explode:$rout['exit_hours']}
                                        <div class="s-u-passenger-item no-star width12 txt11">
                                            <label for="exitHours{$numberRout}" class="flr">##Starttime##
                                                (##Hour##):</label>
                                            <select name="exitHours{$numberRout}" id="exitHours{$numberRout}"
                                                    class="form-control ">
                                                <option value="{$expExitHours[0]}">{$expExitHours[0]}</option>
                                                {for $n=0 to 9}
                                                    <option value="0{$n}">0{$n}</option>
                                                {/for}
                                                {for $n=10 to 24}
                                                    <option value="{$n}">{$n}</option>
                                                {/for}
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star width12 txt11">
                                            <label for="exitMinutes{$numberRout}" class="flr">##Starttime##
                                                (##Minutes##):</label>
                                            <select name="exitMinutes{$numberRout}" id="exitMinutes{$numberRout}"
                                                    class="form-control ">
                                                <option value="{$expExitHours[1]}">{$expExitHours[1]}</option>
                                                {for $n=0 to 9}
                                                    <option value="0{$n}">0{$n}</option>
                                                {/for}
                                                {for $n=10 to 60}
                                                    <option value="{$n}">{$n}</option>
                                                {/for}
                                            </select>
                                        </div>

                                        {assign var=expHours value=":"|explode:$rout['hours']}
                                        <div class="s-u-passenger-item no-star width12">
                                            <label for="hours{$numberRout}" class="flr">##Periodoftime##
                                                (##Hour##):</label>
                                            <select name="hours{$numberRout}" id="hours{$numberRout}"
                                                    class="form-control ">
                                                <option value="{$expHours[0]}">{$expHours[0]}</option>
                                                {for $n=0 to 9}
                                                    <option value="0{$n}">0{$n}</option>
                                                {/for}
                                                {for $n=10 to 24}
                                                    <option value="{$n}">{$n}</option>
                                                {/for}
                                            </select>
                                        </div>

                                        <div class="s-u-passenger-item no-star width12">
                                            <label for="minutes{$numberRout}" class="flr">##Periodoftime##
                                                (##Minutes##):</label>
                                            <select name="minutes{$numberRout}" id="minutes{$numberRout}"
                                                    class="form-control ">
                                                <option value="{$expHours[1]}">{$expHours[1]}</option>
                                                {for $n=0 to 9}
                                                    <option value="0{$n}">0{$n}</option>
                                                {/for}
                                                {for $n=10 to 60}
                                                    <option value="{$n}">{$n}</option>
                                                {/for}
                                            </select>
                                        </div>


                                    </div>
                                    <div class="clear"></div>
                                {/foreach}

                            </div>
                            <div class="clear"></div>
                            {*if $item eq 'dept'}
                                <input type="hidden" value="{$count}" name="countRowAnyDeptRout"
                                       id="countRowAnyDeptRout"/>
                                <div class="tour-btn-add" onclick="insertRowRout('rowRout')">
                                    <span class="addRowRoute"></span>
                                    <span class="addRowTXT">اضافه کردن مسیر بعدی</span>
                                </div>
                            {elseif $item eq 'return'}
                                <input type="hidden" value="{$count}" name="countRowAnyReturnRout"
                                       id="countRowAnyReturnRout"/>
                                <div class="tour-btn-add" onclick="insertRowRout('rowReturnRoute')">
                                    <span class="addRowRouteReturn"></span>
                                    <span class="addRowTXT">اضافه کردن مسیر برگشت</span>
                                </div>
                            {/if*}

                        {/foreach}

                        <input type="hidden" value="{$numberRout}" name="countRowAnyRout" id="countRowAnyRout"/>
                    </div>
                    <div class="clear"></div>

                </div>
                <div class="clear"></div>

            </div>
            <div class="clear"></div>


            <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnFirst">
                <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                       type="submit" value="##Next##">
            </div>

        </form>
        <form id='tourPackageEditForm' name="tourPackageEditForm" method='post'
              data-toggle="validator" enctype='multipart/form-data'
              action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">
            <input type="hidden" name="flag" id="flag" value="tourPackageEdit" />
            <input type="hidden" name="id_same" id="id_same" value="{$infoTour['id_same']}" />
            <input type="hidden" name="fk_tour_id" id="fk_tour_id" value="{$tourId}" />

            <div id="tourPackagesBox">
                <div class="displayN" id="tourPackageEdit">


                    {if 1|in_array:$tourTypeIdArray}
                        <input type="hidden" name="flagSecond" id="flagSecond" value="oneDayTourRegistration" />
                        {load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
                        <div class="main-Content-top s-u-passenger-wrapper-change">
                        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                            <i class="fa fa-check zmdi-hc-fw mart5"></i>##Price## ##Onetour##
                        </span>
                            <div class="panel-default-change site-border-main-color">
                                <div class="s-u-result-item-change">

                                    <div class="s-u-passenger-item no-star">
                                        <label for="adultPriceOneDayTourR" class="flr">##Priceadult##
                                            (##Rial##):</label>
                                        <input type="text" name="adultPriceOneDayTourR" id="adultPriceOneDayTourR"
                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               value="{$infoTour['adult_price_one_day_tour_r']|number_format}"
                                               placeholder="##Priceadult##">
                                    </div>

                                    <div class="s-u-passenger-item no-star">
                                        <label for="childPriceOneDayTourR" class="flr">##Pricechild##
                                            (##Rial##):</label>
                                        <input type="text" name="childPriceOneDayTourR" id="childPriceOneDayTourR"
                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               value="{$infoTour['child_price_one_day_tour_r']|number_format}"
                                               placeholder="##Pricechild##">
                                    </div>

                                    <div class="s-u-passenger-item no-star">
                                        <label for="infantPriceOneDayTourR" class="flr">##Pricebaby##
                                            (##Rial##):</label>
                                        <input type="text" name="infantPriceOneDayTourR" id="infantPriceOneDayTourR"
                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               value="{$infoTour['infant_price_one_day_tour_r']|number_format}"
                                               placeholder="##Pricebaby##">
                                    </div>

                                </div>
                                <div class="s-u-result-item-change">

                                    <div class="s-u-passenger-item no-star">
                                        <label for="adultPriceOneDayTourA" class="flr">##Priceadult##
                                            (##currency##):</label>
                                        <input type="text" name="adultPriceOneDayTourA" id="adultPriceOneDayTourA"
                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               value="{$infoTour['adult_price_one_day_tour_a']|number_format}"
                                               placeholder="##Adlpricearz##">
                                    </div>

                                    <div class="s-u-passenger-item no-star">
                                        <label for="childPriceOneDayTourA" class="flr">##Pricechild##
                                            (##currency##):</label>
                                        <input type="text" name="childPriceOneDayTourA" id="childPriceOneDayTourA"
                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               value="{$infoTour['child_price_one_day_tour_a']|number_format}"
                                               placeholder="##Chdpricearz##">
                                    </div>

                                    <div class="s-u-passenger-item no-star">
                                        <label for="infantPriceOneDayTourA" class="flr"> ##Pricebaby##
                                            (##Rial##):</label>
                                        <input type="text" name="infantPriceOneDayTourA" id="infantPriceOneDayTourA"
                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               value="{$infoTour['infant_price_one_day_tour_a']|number_format}"
                                               placeholder="##Infpricearz##">
                                    </div>

                                    <div class="s-u-passenger-item">
                                        <label for="currencyTypeOneDayTour" class="flr">##Typecurrency##:</label>

                                        <select name="currencyTypeOneDayTour" id="currencyTypeOneDayTour"
                                                class="select2">
                                            <option value="" disabled="disabled" selected>##Selection##</option>
                                            {foreach $objCurrency->ListCurrencyEquivalent() as $currency}
                                                <option value="{$currency['CurrencyCode']}"
                                                        {if $infoTour['currency_type_one_day_tour'] eq $currency['CurrencyTitle']}selected{/if}>{$currency['CurrencyTitle']}</option>
                                            {/foreach}
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    {else}
                        <input type="hidden" name="flagSecond" id="flagSecond" value="tourPackageRegistration" />
                        <div class="main-Content-top s-u-passenger-wrapper-change">
                                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                                    <i class="fa fa-check zmdi-hc-fw mart5"></i>##Package##
                                </span>
                            <div class="panel-default-change site-border-main-color">
                                <div class="s-u-result-item-change">

                                    <div id="rowPackage">

                                        {assign var="countPackage" value="0"}
                                        {foreach key=key item=package from=$objResult->infoTourPackageByIdTour($tourId)}
                                            {$countPackage = $countPackage + 1}
                                            <input type='hidden' name='packageId{$countPackage}' value='{$package['id']}'>
                                            <div id="rowAnyPackage{$countPackage}"
                                                 class="bg-light-blue overflow-hidden rounded rowAnyRout package-box">

                                                <div class="d-flex divDeleteRow justify-content-center rout-number">
                                                    <div class="align-items-center d-flex flex-wrap justify-content-between px-2 rout-number-50 w-100 mr-3">
                                                        <span class='font-weight-bold'>##Package## {$countPackage}</span>

                                                        <button type='button' onclick="logicalDeletionGroupPackageByTourId('{$smarty.get.id}','{$package['number_package']}')"
                                                                class='btn btn-danger btn-sm font-12 p-1 px-2'>
                                                            <span class="deleteRow fa fa-trash"></span>
                                                            ##Delete##
                                                        </button>

                                                    </div>
                                                </div>

                                                {assign var="countPackageHotel" value="0"}

                                                {foreach key=key item=hotel from=$objResult->infoTourHotelByIdTourPackage($package['id'])}
                                                    <div class='each-package-hotel'>

                                                        {assign var="hotelList" value=$objResult->getHotelByCityId($hotel['fk_city_id'])}
                                                        <input type="hidden" value="{$hotel['fk_city_id']}"
                                                               name="cityId{$countPackage}{$countPackageHotel}"
                                                               data-name="cityId"
                                                               data-values="name,id"
                                                               class="change_counter_js"
                                                               id="cityId{$countPackage}{$countPackageHotel}">
                                                        <input type="hidden" value="{$hotel['city_name']}"
                                                               data-name="cityName"
                                                               data-values="name,id"
                                                               class="change_counter_js"
                                                               name="cityName{$countPackage}{$countPackageHotel}"
                                                               id="cityName{$countPackage}{$countPackageHotel}">
                                                        <input type="hidden" value="{$hotel['id']}"
                                                               data-name="tourHotelId"
                                                               data-values="name,id"
                                                               class="change_counter_js"
                                                               name="tourHotelId{$countPackage}{$countPackageHotel}"
                                                               id="tourHotelId{$countPackage}{$countPackageHotel}">
                                                        <div class="d-flex flex-wrap gap-10 p-3 w-100">
                                                            <div class="bg-white rounded row-tour-hotel w-100">


                                                                <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                                    <span class="tour-price-r">##Selecthotelforcity## {$hotel['city_name']} </span>
                                                                </div>


                                                                <div class="p-2 py-4 tour-hotel w-100">
                                                                    <div class="box-hotel d-flex flex-wrap w-100">
                                                                        <div class="col-md-4 no-star">
                                                                            <label for="hotelId{$countPackage}{$countPackageHotel}"
                                                                                   class="flr font-12 text-muted">
                                                                                ##Selectionhotel##:</label>
                                                                            <select name="hotelId{$countPackage}{$countPackageHotel}"
                                                                                    id="hotelId{$countPackage}{$countPackageHotel}"
                                                                                    class="select2">
                                                                                <option value=""
                                                                                        disabled="disabled">
                                                                                    ##Selection##
                                                                                </option>
                                                                                {foreach $hotelList as $val}
                                                                                    <option value="{$val['id']}"
                                                                                            {if $val['id'] eq $hotel['fk_hotel_id']}selected{/if}>{$val['name']}</option>
                                                                                {/foreach}
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 no-star">
                                                                            <label for="roomService{$countPackage}{$countPackageHotel}"
                                                                                   class="flr font-12 text-muted">##Selectserviceroom##:</label>
                                                                            <select name="roomService{$countPackage}{$countPackageHotel}"
                                                                                    id="roomService{$countPackage}{$countPackageHotel}"
                                                                                    class="select2">
                                                                                <option value="" disabled="disabled"
                                                                                        selected> ##Selection##
                                                                                </option>
                                                                                <option value="BB"
                                                                                        {if $hotel['room_service'] eq 'BB'}selected{/if}>
                                                                                    BB
                                                                                </option>
                                                                                <option value="HB"
                                                                                        {if $hotel['room_service'] eq 'HB'}selected{/if}>
                                                                                    HB
                                                                                </option>
                                                                                <option value="FB"
                                                                                        {if $hotel['room_service'] eq 'FB'}selected{/if}>
                                                                                    FB
                                                                                </option>
                                                                                <option value="All"
                                                                                        {if $hotel['room_service'] eq 'All'}selected{/if}>
                                                                                    All
                                                                                </option>
                                                                                <option value="UAll"
                                                                                        {if $hotel['room_service'] eq 'UAll'}selected{/if}>
                                                                                    UAll
                                                                                </option>
                                                                                <option value="Exclusive"
                                                                                        {if $hotel['room_service'] eq 'Exclusive'}selected{/if}>
                                                                                    Exclusive
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 no-star">
                                                                            <label for="roomType{$countPackage}{$countPackageHotel}"
                                                                                   class="flr font-12 text-muted">##Selecttyperoom##:</label>
                                                                            <select name="roomType{$countPackage}{$countPackageHotel}"
                                                                                    id="roomType{$countPackage}{$countPackageHotel}"
                                                                                    class="select2">
                                                                                <option value="" disabled="disabled"
                                                                                        selected> ##ChoseOption##
                                                                                </option>
                                                                                <option value="Standard"
                                                                                        {if $hotel['room_type'] eq 'Standard'}selected{/if}>
                                                                                    ##Standard##
                                                                                </option>
                                                                                <option value="Sea Side View"
                                                                                        {if $hotel['room_type'] eq 'Sea Side View'}selected{/if}>
                                                                                    ##Viewsea##
                                                                                </option>
                                                                                <option value="Garden View"
                                                                                        {if $hotel['room_type'] eq 'Garden View'}selected{/if}>
                                                                                    ##Viewgarden##
                                                                                </option>
                                                                                <option value="Studio Room"
                                                                                        {if $hotel['room_type'] eq 'Studio Room'}selected{/if}>
                                                                                    ##StudioRoom##
                                                                                </option>
                                                                                <option value="Club Room"
                                                                                        {if $hotel['room_type'] eq 'Club Room'}selected{/if}>
                                                                                    ##ClubRoom##
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {$countPackageHotel = $countPackageHotel + 1}


                                                    </div>
                                                {/foreach}
                                                <input type="hidden" value="{$countPackageHotel - 1}"
                                                       name="countHotel{$countPackage}"
                                                       id="countHotel{$countPackage}">

                                                <div class="d-flex flex-wrap gap-10 p-3 w-100">

                                                    <div class="bg-white rounded row-tour-hotel w-100">


                                                        <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                            <span class="tour-price-r">##Price## ##Riali##</span>
                                                        </div>

                                                        <div class="p-2 py-4 tour-hotel w-100">
                                                            <div class="box-hotel d-flex flex-wrap w-100">
                                                                <div class="col-md-4 no-star">
                                                                    <label for="threeRoomPriceR{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomthreebed##
                                                                        (##Riali##):</label>
                                                                    <input type="text"
                                                                           name="threeRoomPriceR{$countPackage}"
                                                                           id="threeRoomPriceR{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['three_room_price_r']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="doubleRoomPriceR{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomtwobed##
                                                                        (##Riali##):</label>
                                                                    <input type="text"
                                                                           name="doubleRoomPriceR{$countPackage}"
                                                                           id="doubleRoomPriceR{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['double_room_price_r']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="singleRoomPriceR{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomonebed##
                                                                        (##Riali##):</label>
                                                                    <input type="text"
                                                                           name="singleRoomPriceR{$countPackage}"
                                                                           id="singleRoomPriceR{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['single_room_price_r']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="childWithBedPriceR{$countPackage}"
                                                                           class="flr font-12 text-muted">##Childwithbed##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="childWithBedPriceR{$countPackage}"
                                                                           id="childWithBedPriceR{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['child_with_bed_price_r']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="infantWithoutBedPriceR{$countPackage}"
                                                                           class="flr font-12 text-muted">##Babywithoutbed##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="infantWithoutBedPriceR{$countPackage}"
                                                                           id="infantWithoutBedPriceR{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['infant_without_bed_price_r']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="infantWithoutChairPriceR{$countPackage}"
                                                                           class="flr font-12 text-muted">##Babywithoutchair##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="infantWithoutChairPriceR{$countPackage}"
                                                                           id="infantWithoutChairPriceR{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['infant_without_chair_price_r']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap gap-10 p-3 w-100">

                                                    <div class="bg-white rounded row-tour-hotel w-100">


                                                        <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                            <span class="tour-price-r">##SpecialCounterPrice##</span>
                                                        </div>

                                                        <div class="p-2 py-4 tour-hotel w-100">
                                                            <div class="box-hotel justify-content-center d-flex flex-wrap w-100">

                                                                {assign var="tour_discounts" value=$objResult->getTourDiscountByPackageId($package['id'])}

                                                                {foreach $objCounterType->list as $counter_key=>$counter_type}
                                                                    {assign var="tour_discount" value=$objFunctions->arrayFilterByValue($tour_discounts,'counter_type_id',$counter_type['id'])|array_values}
                                                                    {assign var="tour_discount" value=$tour_discount[0]}


                                                                    <div class="col-lg-2.5 col-md-4 no-star">


                                                                        <div class="d-flex font-13 font-weight-bolder justify-content-center p-2 py-2 w-100">
                                                                            <span class="tour-price-r">{$counter_type.name}</span>
                                                                        </div>

                                                                        {foreach $objTour->tourDiscountFieldsIndex() as $entry_key=>$entry}
                                                                            <div class="w-100 no-star mb-3">
                                                                                <label for="{$entry.index}{$counter_key}{$entry_key}"
                                                                                       class="flr font-12 text-muted">{$entry.title}
                                                                                    (##Riali##):</label>

                                                                                <input type="text"
                                                                                       name="{$entry.index}[{$countPackage}][{$counter_key}]"
                                                                                       id="{$entry.index}{$counter_key}{$entry_key}"
                                                                                       onkeypress="isDigit(this)"
                                                                                       class="form-control font-12"
                                                                                       onkeyup="javascript:separator(this);"
                                                                                       value="{$tour_discount[$entry.index]|number_format}"
                                                                                       placeholder="##Price## ##Riali##">
                                                                            </div>
                                                                        {/foreach}
                                                                    </div>
                                                                {/foreach}

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="d-flex flex-wrap gap-10 p-3 w-100">

                                                    <div class="bg-white rounded row-tour-hotel w-100">


                                                        <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                            <span class="tour-price-r">##Price## ##currency##</span>
                                                        </div>

                                                        <div class="p-2 py-4 tour-hotel w-100">
                                                            <div class="box-hotel d-flex flex-wrap w-100">
                                                                {load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
                                                                <div class="col-md-3 no-star">
                                                                    <label for="currencyType{$countPackage}"
                                                                           class="flr font-12 text-muted">##Typecurrency##
                                                                        :</label>
                                                                    <select name="currencyType{$countPackage}"
                                                                            id="currencyType{$countPackage}"
                                                                            class="select2">
                                                                        <option value=""
                                                                                disabled="disabled">
                                                                            ##Donthave##
                                                                        </option>
                                                                        {foreach $objCurrency->ListCurrencyEquivalent()  as  $Currency}
                                                                            <option value="{$Currency.CurrencyCode}"
                                                                                    {if $package['currency_type'] eq $Currency.CurrencyTitle}selected{/if}>{$Currency.CurrencyTitle}</option>
                                                                        {/foreach}
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 no-star">
                                                                    <label for="threeRoomPriceA{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomthreebed##
                                                                        (##currency##):</label>
                                                                    <input type="text"
                                                                           name="threeRoomPriceA{$countPackage}"
                                                                           id="threeRoomPriceA{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['three_room_price_a']|number_format}"
                                                                           placeholder="##Price## ##Riali##">
                                                                </div>
                                                                <div class="col-md-3 no-star">
                                                                    <label for="doubleRoomPriceA{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomtwobed##
                                                                        (##currency##):</label>
                                                                    <input type="text"
                                                                           name="doubleRoomPriceA{$countPackage}"
                                                                           id="doubleRoomPriceA{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['double_room_price_a']|number_format}"
                                                                           placeholder="##Price## ##currency##">
                                                                </div>
                                                                <div class="col-md-3 no-star">
                                                                    <label for="singleRoomPriceA{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomonebed##
                                                                        (##currency##):</label>
                                                                    <input type="text"
                                                                           name="singleRoomPriceA{$countPackage}"
                                                                           id="singleRoomPriceA{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['single_room_price_a']|number_format}"
                                                                           placeholder="##Price## ##currency##">
                                                                </div>
                                                                <div class="col-md-3 no-star">
                                                                    <label for="childWithBedPriceA{$countPackage}"
                                                                           class="flr font-12 text-muted">##Childwithbed##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="childWithBedPriceA{$countPackage}"
                                                                           id="childWithBedPriceA{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['child_with_bed_price_a']|number_format}"
                                                                           placeholder="##Price## ##currency##">
                                                                </div>
                                                                <div class="col-md-3 no-star">
                                                                    <label for="infantWithoutBedPriceA{$countPackage}"
                                                                           class="flr font-12 text-muted">##Babywithoutchair##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="infantWithoutBedPriceA{$countPackage}"
                                                                           id="infantWithoutBedPriceA{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['infant_without_bed_price_a']|number_format}"
                                                                           placeholder="##Price## ##currency##">
                                                                </div>
                                                                <div class="col-md-3 no-star">
                                                                    <label for="infantWithoutChairPriceA{$countPackage}"
                                                                           class="flr font-12 text-muted">##Babywithoutchair##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="infantWithoutChairPriceA{$countPackage}"
                                                                           id="infantWithoutChairPriceA{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['infant_without_chair_price_a']|number_format}"
                                                                           placeholder="##Price## ##currency##">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="d-flex flex-wrap gap-10 p-3 w-100">

                                                    <div class="bg-white rounded row-tour-hotel w-100">


                                                        <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                            <span class="tour-price-r">##CapacityRoom##</span>
                                                        </div>

                                                        <div class="p-2 py-4 tour-hotel w-100">
                                                            <div class="box-hotel d-flex flex-wrap w-100">

                                                                <div class="col-md-4 no-star">
                                                                    <label for="threeRoomCapacity{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomthreebed##:</label>
                                                                    <input type="text"
                                                                           name="threeRoomCapacity{$countPackage}"
                                                                           id="threeRoomCapacity{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['three_room_capacity']|number_format}"
                                                                           placeholder="##CapacityRoom##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="doubleRoomCapacity{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomtwobed##:</label>
                                                                    <input type="text"
                                                                           name="doubleRoomCapacity{$countPackage}"
                                                                           id="doubleRoomCapacity{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['double_room_capacity']|number_format}"
                                                                           placeholder="##CapacityRoom##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="singleRoomCapacity{$countPackage}"
                                                                           class="flr font-12 text-muted">##Roomonebed##:</label>
                                                                    <input type="text"
                                                                           name="singleRoomCapacity{$countPackage}"
                                                                           id="singleRoomCapacity{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['single_room_capacity']|number_format}"
                                                                           placeholder="##CapacityRoom##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="childWithBedCapacity{$countPackage}"
                                                                           class="flr font-12 text-muted">##Childwithbed##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="childWithBedCapacity{$countPackage}"
                                                                           id="childWithBedCapacity{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['child_with_bed_capacity']|number_format}"
                                                                           placeholder="##CapacityRoom##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="infantWithoutBedCapacity{$countPackage}"
                                                                           class="flr font-12 text-muted">##Babywithoutbed##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="infantWithoutBedCapacity{$countPackage}"
                                                                           id="infantWithoutBedCapacity{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['infant_without_bed_capacity']|number_format}"
                                                                           placeholder="##CapacityRoom##">
                                                                </div>
                                                                <div class="col-md-4 no-star">
                                                                    <label for="infantWithoutChairCapacity{$countPackage}"
                                                                           class="flr font-12 text-muted">##Babywithoutchair##
                                                                        :</label>
                                                                    <input type="text"
                                                                           name="infantWithoutChairCapacity{$countPackage}"
                                                                           id="infantWithoutChairCapacity{$countPackage}"
                                                                           onkeypress="isDigit(this)"
                                                                           class="form-control font-12"
                                                                           onkeyup="javascript:separator(this);"
                                                                           value="{$package['infant_without_chair_capacity']|number_format}"
                                                                           placeholder="##CapacityRoom##">
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        {/foreach}
                                    </div>

                                </div>


                                <div class="clear"></div>
                                <input type="hidden" value="{$countPackage}" name="countPackage"
                                       id="countPackage" />
                                <div class="tour-btn-add" id="btn-row-hotel" onclick="insertRowPackage()">
                                    <span class="addRowHotel"></span>
                                    <span class="addRow"></span>
                                    <span class="addRowTXT">##Addnextpackage##</span>
                                </div>

                            </div>
                        </div>
                    {/if}


                    <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnSecond">
                        <div class="col-3 mx-auto">
                            <button type="submit"
                                    data-loading-title='Loading'
                                    class="btn btn-success tour-edit-package-button">##Nextstep## (##Gallerytour##)
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </form>
    {literal}
        <script>
            $(document).ready(function () {

                // datepicker after ajax call
                $("body").on("click", ".shamsiDeptCalendar", function () {
                    if (!$(this).hasClass("hasDatepicker")) {
                        $(this).datepicker();
                        $(this).datepicker("show");
                    }
                });
                $("body").on("click", ".shamsiReturnCalendar", function () {
                    if (!$(this).hasClass("hasDatepicker")) {
                        $(this).datepicker();
                        $(this).datepicker("show");
                    }
                });

            });

        </script>
    {/literal}

        {* ********************* editor_TinyMCE ********************* *}
    {literal}
        <script type="text/javascript" src="assets/editor_TinyMCE/editor/tinymce.min.js"></script>
        <script type="text/javascript" src="assets/editor_TinyMCE/editor.js"></script>
    {/literal}
        {* ********************* editor_TinyMCE ********************* *}



    {literal}
        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;
            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function () {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.maxHeight) {
                        panel.style.maxHeight = null;
                    } else {
                        panel.style.maxHeight = panel.scrollHeight + "px";
                    }
                });
            }
        </script>
    {/literal}




    {else}
        <div class="userProfileInfo-messge">
            <div class="messge-login">##Noaccesstihspage##</div>
        </div>
    {/if}



{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
            ##Pleasslogin##
        </div>
    </div>
{/if}
