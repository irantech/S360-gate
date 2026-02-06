<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css" />
{load_presentation_object filename="passengersDetailTrainApi" assign="objDetail"}
{load_presentation_object filename="resultTrainApi" assign="objResult"}
{load_presentation_object filename="factorTrainApi" assign="objFactor"}
{load_presentation_object filename="members" assign="objMember"}


{assign var="lockseat" value=$smarty.post.lockSeatJson|json_decode:true}
{if $smarty.post.lockSeatJsonReturn neq ''}
{assign var="lockseatReturn" value=$smarty.post.lockSeatJsonReturn|json_decode:true}
{/if}

{assign var="InfoTrain" value=$objDetail->getTrain()}

{if $smarty.post.CheckCoupe eq 1}
    {assign var="pIsExclusive" value=1}
    {assign var="SeatCount" value=($smarty.post.adult+$smarty.post.child+$smarty.post.infant+$smarty.post.ExtraPersonCoupe)}
{else}
    {assign var="pIsExclusive" value=0}
    {assign var="SeatCount" value=($smarty.post.adult+$smarty.post.child+$smarty.post.infant)}
{/if}

{assign var="compareDate" value=$objFunctions->compareDateTrain($InfoTrain[0]['MoveDate'],$InfoTrain[0]['ExitDate'])}
{*{assign var="lockseat" value=$objFactor->LockSeat_v3($InfoTrain[0]['TrainNumber'],$compareDate,$InfoTrain[0]['Dep_Code'],$InfoTrain[0]['Arr_Code'],$InfoTrain[0]['RationCode'],$InfoTrain[0]['WagonType'],$InfoTrain[0]['PassengerNum'],$SeatCount,$InfoTrain[0]['degree'],0,4,$InfoTrain[0]['CompartmentCapicity'],{$pIsExclusive},$InfoTrain[0]['SoldCount'],$InfoTrain[0]['CircularNumberSerial'],$InfoTrain[0]['ServiceSessionId'])}*}
{$objMember->get()}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($objMember->list['fk_counter_type_id'])}
{$objFactor->registerPassengersTrain($lockseat['SellSerial'],$InfoTrain[0],'ONEWAY')}
{assign var="list" value=$objFactor->getPassengerList($smarty.post.requestNumber,$smarty.post.ServiceCode)} {**گرفتن اطلاعات مربوط به مسافران**}

{if $InfoTrain[1] neq ''}
    {assign var="compareDateReturn" value=$objFunctions->compareDateTrain($InfoTrain[1]['MoveDate'],$InfoTrain[1]['ExitDate'])}
    {if $smarty.post.CheckCoupeReturn eq 1}
        {assign var="pIsExclusiveReturn" value=1}
        {assign var="SeatCountReturn" value=($smarty.post.adult+$smarty.post.child+$smarty.post.infant+$smarty.post.ExtraPersonCoupeReturn)}
    {else}
        {assign var="pIsExclusiveReturn" value=0}
        {assign var="SeatCountReturn" value=($smarty.post.adult+$smarty.post.child+$smarty.post.infant)}
    {/if}
{*    {assign var="lockseatreturn" value=$objFactor->LockSeat_v3($InfoTrain[1]['TrainNumber'],$compareDateReturn,$InfoTrain[1]['Dep_Code'],$InfoTrain[1]['Arr_Code'],$InfoTrain[1]['RationCode'],$InfoTrain[1]['WagonType'],$InfoTrain[1]['PassengerNum'],$SeatCountReturn,$InfoTrain[1]['degree'],$lockseat['NewDataSet']['Table']['SellSerial'],4,$InfoTrain[1]['CompartmentCapicity'],{$pIsExclusiveReturn},$InfoTrain[1]['SoldCount'],$InfoTrain[1]['CircularNumberSerial'],$InfoTrain[1]['ServiceSessionId'],$InfoTrain[1]['ServiceCode'])}*}
    {$objFactor->registerPassengersTrain($lockseatReturn['SellSerial'],$InfoTrain[1],'TOWEWAY')}
    {assign var="listReturn" value=$objFactor->getPassengerList($smarty.post.requestNumberReturn,$smarty.post.ServiceCode)} {**گرفتن اطلاعات مربوط به مسافران**}
{/if}

{*{if $lockseat['result_status'] eq 'Error' || $lockseatreturn['result_status'] eq 'Error'}
    <div class="userProfileInfo-messge ">
        <div class="messge-login BoxErrorSearch">
            <div style="float: right;">
                <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
            </div>
            <div class="TextBoxErrorSearch">
                {$lockseat['result_message']}
            </div>
        </div>
    </div>

{else}*}
<div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Selectiontrain##</h3>
        </div>
        <i class="separator donetoactive"></i>
        <div class="step  done">
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
        <i class="separator donetoactive"></i>
        <div class="step active " >
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
               <svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
                    xmlns="http://www.w3.org/2000/svg">
    <path d="m215.249 166.435h-102.992c-5.613 0-10.704 1.331-14.991 3.705-8.425 4.665-13.736 13.37-13.736 24.015v55.92 36.08c0 7.481 2.879 14.302 7.584 19.418 5.254 5.714 12.786 9.303 21.142 9.303h9.267l-5.763 13.771h-12.752c-5.523 0-10 4.477-10 10s4.477 10 10 10h19.385.108 82.56c.011 0 .022.002.033.002.017 0 .034-.002.051-.002h19.353c5.523 0 10-4.477 10-10s-4.477-10-10-10h-12.688l-5.619-13.771h9.058c15.839 0 28.725-12.884 28.725-28.721v-91.996c0-15.287-12.886-27.724-28.725-27.724zm-107.63 20.889c1.447-.643 3.065-.889 4.641-.889h41.493v53.64h-50.221v-45.916c0-2.954 1.317-5.607 4.087-6.835zm-1.529 104.994c-1.579-1.579-2.557-3.759-2.557-6.163v-26.08h120.437v26.08c0 4.809-3.912 8.72-8.72 8.72h-102.99c-2.407 0-4.59-.978-6.17-2.557zm117.88-52.243h-50.217v-53.64h41.497c4.808 0 8.72 3.463 8.72 7.72zm-33.761 88.572h-52.768l5.763-13.771h41.386z"/>
    <path d="m122.78 280.18c3.43 8.375 15.802 7.893 18.701-.608 2.949-8.647-6.792-16.407-14.603-11.791-4.202 2.483-5.971 7.906-4.098 12.399z"/>
    <path d="m186.26 280.18c1.61 3.93 5.727 6.477 9.964 6.148 4.127-.32 7.693-3.2 8.859-7.171 2.472-8.42-6.869-15.819-14.517-11.498-4.33 2.446-6.221 7.928-4.306 12.521z"/>
    <path d="m414.428 195.81h-43.7c-5.522 0-10 4.477-10 10s4.478 10 10 10h43.7c5.522 0 10-4.477 10-10s-4.478-10-10-10z"/>
    <path d="m414.428 246.075h-43.7c-5.522 0-10 4.477-10 10s4.478 10 10 10h43.7c5.522 0 10-4.477 10-10s-4.478-10-10-10z"/>
    <path d="m414.428 296.34h-131.38c-5.522 0-10 4.477-10 10s4.478 10 10 10h131.38c5.522 0 10-4.477 10-10s-4.478-10-10-10z"/>
    <path d="m283.048 215.81h15.503v40.265c0 5.523 4.478 10 10 10s10-4.477 10-10v-40.265h13.511c5.522 0 10-4.477 10-10s-4.478-10-10-10h-49.014c-5.522 0-10 4.477-10 10s4.477 10 10 10z"/>
    <path d="m502 76.985h-492c-5.523 0-10 4.477-10 10v124.37c0 5.523 4.477 10 10 10 15.461 0 28.04 12.579 28.04 28.04 0 15.467-12.579 28.05-28.04 28.05-5.523 0-10 4.477-10 10v137.57c0 5.523 4.477 10 10 10h492c5.522 0 10-4.477 10-10v-137.57c0-5.523-4.478-10-10-10-15.461 0-28.04-12.583-28.04-28.05 0-15.461 12.579-28.04 28.04-28.04 5.522 0 10-4.477 10-10v-124.37c0-5.523-4.478-10-10-10zm-10 338.03h-472v-25.235h472zm-38.04-165.62c0 23.066 16.333 42.389 38.04 47.003v73.382h-472v-73.382c21.707-4.614 38.04-23.937 38.04-47.003 0-23.062-16.333-42.38-38.04-46.993v-60.182h329.441c5.522 0 10-4.477 10-10s-4.478-10-10-10h-329.441v-25.235h472v25.235h-54.581c-5.522 0-10 4.477-10 10s4.478 10 10 10h54.581v60.182c-21.707 4.613-38.04 23.931-38.04 46.993z"/>
    <path d="m384.8 136.04c1.613 3.934 5.718 6.476 9.964 6.148 4.173-.323 7.775-3.265 8.896-7.304 2.362-8.512-7.182-15.758-14.768-11.235-4.197 2.503-5.97 7.884-4.092 12.391z"/>
</svg>
            </span>
            <h3> ##TicketReservation## </h3>
        </div>
    </div>

    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00" style="direction: ltr"> {$smarty.post.time_remmaining}</div>

</div>
<div class="s-u-content-result">
    {*<div>*}
        {*<div class="counter d-none counter-analog" data-direction="down" data-format="59:59.9" data-stop="00:00:00.0" data-interval="100"*}
            {*style="direction: ltr">{$smarty.post.time_remmaining}:0</div>*}
    {*</div>*}



    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Invoice##
        </span>
        <div class="s-u-result-wrapper">
            <ul>

                <li class="s-u-result-item-header displayiN">
                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-logo-icon"></p>
                    </div>
                    <div class="s-u-result-item-wrapper">

                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-time-out"></p>
                        </div>

                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-duration-local"></p>
                        </div>

                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-flight-number-local"></p>
                        </div>

                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-flight-number"></p>
                        </div>

                    </div>


                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-flight-price"></p>
                    </div>

                </li>

                <!-- result item -->

                <li class="s-u-result-item s-u-result-item-change wow blit-flight-passenger fadeInDown">


                    <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                        <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                            {assign var="allowCompartmentCapicity" value=""}
                            {assign var="CompartmentCapicity" value=$InfoTrain[0]['CompartmentCapicity']}
                            {if $CompartmentCapicity && $InfoTrain[0]['Owner']}
                                {$allowCompartmentCapicity=$CompartmentCapicity}
                            {else}
                                {$allowCompartmentCapicity=''}
                            {/if}
                            <img src="{$objFunctions->getCompanyTrainPhoto($InfoTrain[0]['Owner'],$allowCompartmentCapicity)}"
                                 alt="{$objFunctions->getCompanyTrainById($InfoTrain[0]['Owner'])}" title="{$objFunctions->getCompanyTrainById($InfoTrain[0]['Owner'])}">
                        </div>

                        <div class="s-u-result-item-div s-u-result-content-item-div-change">
                            <span> شماره قطار : {$InfoTrain[0]['TrainNumber']}</span>
                        </div>
                        <span class="displayib-change d-block"> ظرفیت : {$InfoTrain[0]['Counting']}</span>
                    </div>
                    <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                        <div class="details-wrapper-change">

                            <div class="s-u-result-raft first-row-change">
                                <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5  ">

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="iranB">{$InfoTrain[0]['Departure_City']}</span>

                                        <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[0]['ExitTime'])}</span>
                                    </div>

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$objResult->DateJalali($InfoTrain[0]['ExitDate'])}
                                            {$objResult->day},{$objResult->date_now}</span>

                                        <span>نوع واگن: {$InfoTrain[0]['WagonName']}</span>
                                        <span>{if $InfoTrain[0]['IsCompartment'] eq 1}کوپه ای {$InfoTrain[0]['CompartmentCapicity']} نفره{/if}</span>
                                    </div>

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="iranB">{$InfoTrain[0]['Arrival_City']}</span>
                                        <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[0]['TimeOfArrival'])}</span>

                                    </div>



                                </div>
                                <div class="left-Cell-change">
                                    <div class="s-u-bozorg s-u-bozorg-change">
                                        {*                                        {assign var="discountManual" value=$objResult->getDiscount($InfoBus.Price,$InfoBus.OriginalPrice)}*}
                                        <span class="s-u-bozorg price">

                                            <i>    {if $objSession->IsLogin()}
                                                    {if $InfoTrain[0]['is_specifice'] eq 'yes'}

                                                        {assign var="TypeTrain" value="PrivateTrain"}
                                                    {else}
                                                        {assign var="TypeTrain" value="Train"}
                                                    {/if}
                                                    {assign var="comapreDate" value=$objFunctions->compareDateTrain($InfoTrain[0]['MoveDate'],$InfoTrain[0]['ExitDate'])}
                                                    <i>{assign var="discount" value=$objResult->CalculateDiscount($TypeTrain,$InfoTrain[0]['Owner'],$InfoTrain[0]['Cost'],$InfoTrain[0]['TrainNumber'],$objFunctions->ConvertToJalali($comapreDate))}</i>
                                                    <i>{$objFunctions->numberFormat({$InfoTrain[0]['Cost']} - {$discount['costOff']})}</i>
                                            {else}
                                                <i>{$objFunctions->numberFormat($InfoTrain[0]['Cost'])}</i>
                                                {/if}</i>
                                            ##Rial##
                                        </span>
                                        {*                                        {if $discountManual  neq 0}*}
                                        {*                                            <div class="shenase-nerkhi">*}

                                        {*                                                <span class="Direction-rtl">%{$discountManual|string_format:"%d"}*}
                                        {*                                                    ##Discount##</span>*}
                                        {*                                            </div>*}
                                        {*                                        {/if}*}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {if $lockseat['SellStatus'] eq '0' && $smarty.post.CheckCoupe eq '1'}
                            <div style="padding: 5px;background-color:brown;color:#fff;">به دلیل پراکندگی صندلی ها امکان رزرو کوپه دربست برای این مسیر موجود نمی باشد لطفا مجددا جستجو نمایید</div>
                        {elseif $lockseat['SellStatus'] eq '1' && $smarty.post.CheckCoupe eq '0'}
                            {assign var="WagonNumbers" value=","|explode:$lockseat['WagonNumbers'] }
                            {assign var="CompartmentNumbers" value=","|explode:$lockseat['CompartmentNumbers']}
                            <div class="train-info">
                                {for $i=0 to {$WagonNumbers|count}-1}
-                                    <span>   سالن  {$WagonNumbers[$i]} - صندلی  {$CompartmentNumbers[$i]} </span>
                                {/for}
                            </div>
                        {else}
                            {assign var="WagonNumbers" value=","|explode:$lockseat['WagonNumbers']}
                            {assign var="CompartmentNumbers" value=","|explode:$lockseat['CompartmentNumbers']}
                            <div class="train-info">
                                {for $i=0 to {$WagonNumbers|count}-1}
                                    <span>   سالن  {$WagonNumbers[$i]} - صندلی  {$CompartmentNumbers[$i]} </span>
                                {/for}
                            </div>
                        {/if}
                    </div>
                </li>

                {if $InfoTrain[1] neq ''}
                    <li class="s-u-result-item s-u-result-item-change wow blit-flight-passenger fadeInDown">


                        <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                            <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                <img src="{$objFunctions->getCompanyTrainPhoto($InfoTrain[1]['Owner'])}"
                                     alt="{$objFunctions->getCompanyTrainById($InfoTrain[1]['Owner'])}" title="{$objFunctions->getCompanyTrainById($InfoTrain[1]['Owner'])}">
                            </div>

                            <div class="s-u-result-item-div s-u-result-content-item-div-change">
                                <span> شماره قطار : {$InfoTrain[1]['TrainNumber']}</span>
                            </div>
                            <span class="displayib-change d-block"> ظرفیت : {$InfoTrain[1]['Counting']}</span>
                        </div>
                        <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                            <div class="details-wrapper-change">

                                <div class="s-u-result-raft first-row-change">
                                    <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5  ">

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$InfoTrain[1]['Departure_City']}</span>

                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[1]['ExitTime'])}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$objResult->DateJalali($InfoTrain[1]['MoveDate'])}
                                            {$objResult->day},{$objResult->date_now}</span>

                                            <span>نوع واگن: {$InfoTrain[1]['WagonName']}</span>
                                            <span>{if $InfoTrain[1]['IsCompartment'] eq 1}کوپه ای {$InfoTrain[1]['CompartmentCapicity']} نفره{/if}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$InfoTrain[1]['Arrival_City']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[1]['TimeOfArrival'])}</span>

                                        </div>



                                    </div>
                                    <div class="left-Cell-change">
                                        <div class="s-u-bozorg s-u-bozorg-change">
                                            {*                                        {assign var="discountManual" value=$objResult->getDiscount($InfoBus.Price,$InfoBus.OriginalPrice)}*}
                                            <span class="s-u-bozorg price">

                                                  <i>    {if $objSession->IsLogin()}
                                                          {if $InfoTrain[1]['is_specifice'] eq 'yes'}

                                                              {assign var="TypeTrain" value="PrivateTrain"}
                                                          {else}
                                                              {assign var="TypeTrain" value="Train"}
                                                          {/if}
                                                          {assign var="comapreDateReturn" value=$objFunctions->compareDateTrain($InfoTrain[1]['MoveDate'],$InfoTrain[1]['ExitDate'])}
                                                          <i>{assign var="discountReturn" value=$objResult->CalculateDiscount($TypeTrain,$InfoTrain[1]['Owner'],$InfoTrain[1]['Cost'],$InfoTrain[1]['TrainNumber'],$objFunctions->ConvertToJalali($comapreDateReturn))}</i>
                                                          <i>{$objFunctions->numberFormat({$InfoTrain[1]['Cost']} - {$discountReturn['costOff']})}</i>
                                            {else}
                                                <i>{$objFunctions->numberFormat($InfoTrain[1]['Cost'])}</i>
                                                      {/if}</i>
                                            ##Rial##
                                        </span>
                                            {*                                        {if $discountManual  neq 0}*}
                                            {*                                            <div class="shenase-nerkhi">*}

                                            {*                                                <span class="Direction-rtl">%{$discountManual|string_format:"%d"}*}
                                            {*                                                    ##Discount##</span>*}
                                            {*                                            </div>*}
                                            {*                                        {/if}*}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {if $lockseatReturn['SellStatus'] eq '0' && $smarty.post.CheckCoupeReturn eq '1'}
                                <div style="padding: 5px;background-color:brown;color:#fff;">به دلیل پراکندگی صندلی ها امکان رزرو کوپه دربست برای این مسیر موجود نمی باشد لطفا مجددا جستجو نمایید</div>
                            {elseif $lockseatReturn['SellStatus'] eq '1' && $smarty.post.CheckCoupeReturn eq '0'}
                                {assign var="WagonNumbers" value=","|explode:$lockseatReturn['WagonNumbers'] }
                                {assign var="CompartmentNumbers" value=","|explode:$lockseatReturn['CompartmentNumbers']}
                                <div class="train-info">
                                    {for $i=0 to {$WagonNumbers|count}-1}
                                        -                                    <span>   سالن  {$WagonNumbers[$i]} - صندلی  {$CompartmentNumbers[$i]} </span>
                                    {/for}
                                </div>
                            {else}
                                {assign var="WagonNumbers" value=","|explode:$lockseatReturn['WagonNumbers']}
                                {assign var="CompartmentNumbers" value=","|explode:$lockseatReturn['CompartmentNumbers']}
                                <div class="train-info">
                                    {for $i=0 to {$WagonNumbers|count}-1}
                                        <span>   سالن  {$WagonNumbers[$i]} - صندلی  {$CompartmentNumbers[$i]} </span>
                                    {/for}
                                </div>
                            {/if}
                        </div>
                    </li>

                {/if}

            </ul>
        </div>

        <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>

    </div>
    </div>

<div class="Clr"></div>
{if ($lockseat['SellSerial'] gt '0' && $InfoTrain[1] eq '') || ($InfoTrain[1] neq '' && $lockseat['SellSerial'] gt '0' && $lockseatReturn['SellSerial'] gt '0')}

<div class="main-Content-bottom Dash-ContentL-B">
    <div class="main-Content-bottom-table Dash-ContentL-B-Table">
        <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
            <i class="icon-table"></i>
            <h3>##Listpassengers##</h3>
            <p>
                (
                <i> {$InfoTrain[0]['Adult']} ##Adult## </i> -
                <i>{$InfoTrain[0]['Child']} ##Child##</i> -
                <i> {$InfoTrain[0]['Infant']} ##Baby## </i>)
            </p>
        </div>

        <div class="table-responsive">
        <table id="passengers" class="display" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>##Ages##</th>
                    <th>##Name## </th>
                    <th>##Family##</th>
                    <th>##Nameenglish##</th>
                    <th>##Familyenglish##</th>
                    <th>##Happybirthday##</th>
                    <th>##Numpassport##/##Nationalnumber##</th>
                    <th>سرویس انتخابی رفت</th>
                    {if $InfoTrain[1] neq ''}
                        <th> سرویس انتخابی برگشت</th>
                    {/if}
                    <th>##Price##</th>
                </tr>
            </thead>
            <tbody>
                {foreach $list as $i=>$passenger}
                <tr>
                    <td>{if {$passenger['Adult']} eq 1} ##Adult## {elseif {$passenger['Child']} eq 1} ##Child## {else} ##Baby## {/if} </td>
                    <td>
                        <p>{if $passenger['passenger_name'] eq null}----{else}{$passenger['passenger_name']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $passenger['passenger_family'] eq null}----{else}{$passenger['passenger_family']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $passenger['passenger_name_en'] eq null}----{else}{$passenger['passenger_name_en']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $passenger['passenger_family_en'] eq null}----{else}{$passenger['passenger_family_en']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $passenger['passenger_birthday'] eq null} {$passenger['passenger_birthday_en']} {else} {$passenger['passenger_birthday']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $passenger['passenger_national_code'] eq ''}{$passenger['passportNumber']}{else}{$passenger['passenger_national_code']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $passenger['Service'] eq null}----{else}{$passenger['Service']}{/if} </p>
                    </td>
                    {if $InfoTrain[1] neq ''}
                        <td>
                            <p>{if $listReturn[$i]['Service'] eq null}----{else}{$listReturn[$i]['Service']}{/if} </p>
                        </td>
                    {/if}
                    <td>
                        {assign var='priceOnePerson' value=$passenger['Cost']-$passenger['discount_inf_price']}
                       
                        {assign var="discountOnePerson" value=$objResult->CalculateDiscount($TypeTrain,$InfoTrain[0]['Owner'],$priceOnePerson,$InfoTrain[0]['TrainNumber'])}

                         {if $InfoTrain[1] neq ''}
                             {assign var='priceOnePersonReturn' value=($listReturn[$i]['Cost'] - $listReturn[$i]['discount_inf_price'])}
                             {assign var="discountOnePersonReturn" value=$objResult->CalculateDiscount($TypeTrain,$InfoTrain[1]['Owner'],$priceOnePersonReturn,$InfoTrain[1]['TrainNumber'])}
                             {assign var="Cost" value=($priceOnePerson )+ ($priceOnePersonReturn )}
                         {else}
                             {assign var="Cost" value=($priceOnePerson)}
                         {/if}
                         <p>{$objFunctions->numberFormat({$Cost})} ##Rial##</p>
                    </td>

                </tr>
                {/foreach}
                {if $smarty.post.CheckCoupe eq 1  || $smarty.post.CheckCoupeReturn eq 1 }
                <tr>
                    {assign var="ExtraChairCost" value=''}
                    {if $smarty.post.CheckCoupe eq 1 }
                        {$ExtraChairCost=$smarty.post.PriceExtraPersonCoupe}
                    {/if}
{*                    {assign var="ExtraChairCost" value=''}*}
                    {if $smarty.post.CheckCoupeReturn eq 1 }
                        {$ExtraChairCost={$ExtraChairCost}+{$smarty.post.PriceExtraPersonCoupeReturn}}
                    {/if}
                    <td colspan="{if $InfoTrain[1] neq ''}9{else}8{/if}"> هزینه مابه التفاوت کوپه دربست</td>
                    <td>{$objFunctions->numberFormat({$ExtraChairCost})}   ##Rial##</td>
                </tr>
                {/if}
                <tr>

                    <td colspan="{if $InfoTrain[1] neq ''}9{else}8{/if}" class="txtLeft TotalPrice_td">##TotalPrice## :</td>
                    <td class="TotalPrice_td_2">
                        <p class="last-price-factor-local">{$objFunctions->numberFormat($objFactor->totalPrice + {$ExtraChairCost})} ##Rial##</p>
                    </td>

                </tr>

            </tbody>

        </table>
        </div>
    </div>
</div>

{*{foreach key=direction item=item from=$objDetail->Direction}*}
{*    {if $direction eq 'dept'}*}
{*<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  " style="padding: 0;margin: 15px 0px 0px !important;">*}
{*<div class="peygiri-code">*}
{*    <div>*}
{*        <span>##TrackingCode## :</span>*}
{*        <span>{$objFactor->RequestNumber['dept']}</span>*}
{*        <span>##TrackingCodeText##</span>*}
{*    </div>*}
{*</div>*}
{*</div>*}
{*    {/if}*}
{*{/foreach}*}
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  " style="padding: 0">

    <div class="s-u-result-wrapper">
        <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
            <div>

                {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                <div class="s-u-result-item-RulsCheck-item">
                    <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name="" value=""   type="checkbox">
                    <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code" >##Ihavediscountcodewantuse##</label>
               
                    <div class="col-sm-12  parent-discount displayiN ">
                        <div class="row separate-part-discount">
                            <div class="col-sm-6 col-xs-12">
                                <label for="discount-code">##Codediscount## :</label>
                                <input type="text" id="discount-code" class="form-control" > 
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <span class="input-group-btn">
                                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="{$objFactor->totalPrice}" />
                                    <button type="button" onclick='setDiscountCode({$serviceType|json_encode}, {$smarty.post.CurrencyCode})' class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>
                                </span>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <span class="discount-code-error"></span>
                            </div>
                        </div>
                        <div class="row">
{*                            <div class="info-box__price info-box__item pull-left">
                                <div class="item-discount">
                                    <span class="item-discount__label">##Amountpayable## :</span>
                                    <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($objDetail->Amount)}</span>
                                    <span class="price__unit-price">{$objDetail->AdtPriceType[$direction]}</span>
                                </div>
                            </div>*}

                            <div class="a-takhfif-box">
                                <div class="a-takhfif-box-inner">
                                    <div class="a-takhfif-before">
                                        <span>قیمت قبلی</span>
                                        <span>{$objFunctions->numberFormat($objFactor->totalPrice + {$ExtraChairCost})}
                                            <i>##Rial##</i></span>
                                    </div>
                                    <div class="a-takhfif-offer">
                                        <span>مبلغ تخفیف</span>
                                        <span><span class="discountAmount">0</span>
                                                <i>##Rial##</i></span>
                                    </div>
                                    <div class="a-takhfif-after">
                                        <span>مبلغ نهایی</span>
                                        <span class="price-after-discount-code">{$objFunctions->numberFormat($objFactor->totalPrice + {$ExtraChairCost})}
                                            <i>##Rial##</i></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                {/if}

                <p class="s-u-result-item-RulsCheck-item">
                    <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                    <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                        <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##
                    </label>
                </p>
            </div>
            
        </div>
    </div>
</div>

<div class="btns_factors_n">


<div class="btn_research__">
    <!-- <a href="" onclick="return false" class="f-loader-check loaderpassengers"  style="display:none"></a> -->
    <button type="button" class="cancel-passenger loading_on_click" onclick="BackToHome('{$objDetail->reSearchAddress}'); return false">##Repeatsearch## <i class="fa fa-refresh"></i> </button>

</div>
    {if ({$lockseat['SellStatus']} eq '0' && $smarty.post.CheckCoupe eq '1')|| ({$lockseatreturn['SellStatus']} eq '0' && $smarty.post.CheckCoupeReturn eq '1')}
        <div></div>
    {else}

        <div class="passengersDetailLocal_next">
            <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check" style="display:none"></a>
            <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color factorLocal-btn"
               id="final_ok_and_insert_passenger" onclick="bookTrain('{$objFactor->factorNumber}')">##Approvefinal##</a>
        </div>
    {/if}
</div>
<div id="messageBook" class="error-flight"></div>



<!-- bank connect -->
<div class="main-pay-content">


    {assign var="serviceType" value=$objFunctions->getTrainServiceType()} {*  لازم برای انتخاب نوع بانک*}


    <!-- payment methods drop down -->
    {assign var="memberCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
        {$memberCreditPermition = "1"}
    {/if}

    {assign var="counterCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
        {$counterCreditPermition = "1"}
    {/if}

    {assign var="bankInputs" value=['flag' => 'check_credit_train', 'factorNumber' => $objFactor->factorNumber,'ticket_number' => $objFactor->ticket_number,'ticket_number_return' => $objFactor->ticket_number_return, 'serviceType' => $serviceType,'serviceSessionId' => $objFactor->serviceSessionId]}
    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankTrain"}

    {assign var="creditInputs" value=['flag' => 'buyByCreditTrain', 'factorNumber' => $objFactor->factorNumber,'ticket_number' => $objFactor->ticket_number,'ticket_number_return' => $objFactor->ticket_number_return,'ServiceCode' => $objFactor->ServiceCode,'serviceSessionId' => $objFactor->serviceSessionId]}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankTrain"}

    {assign var="currencyPermition" value="0"}
{*    {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}*}
{*        {$currencyPermition = "1"}*}
{*        {assign var="currencyInputs" value=['flag' => 'check_credit', 'factorNumber' => $objFactor->factorNumber, 'RequestNumber' => $objFactor->RequestNumber, 'serviceType' => $serviceType, 'amount' => $objDetail->totalPrice, 'currencyCode' => $smarty.post.CurrencyCode]}*}
{*        {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankTrain"}*}
{*    {/if}*}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
    <!-- payment methods drop down -->


</div>
{else}
    <div class="userProfileInfo-messge ">
        <div class="messge-login BoxErrorSearch">

            <div class="TextBoxErrorSearch">
                <span>
                    <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                </span>
                ##ErrorWhenReserve##
            </div>
        </div>
    </div>
{/if}

<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>

{literal}
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
        $(this).find(".closeBtn").click(function () {

            $(".Cancellation-Box").removeClass("displayBlock");
            $("#lightboxContainer").removeClass("displayBlock");
        });
        $("div#lightboxContainer").click(function () {

            $(".Cancellation-Box").removeClass("displayBlock");
            $("#lightboxContainer").removeClass("displayBlock");
        });
        $('.DetailSelectTicket').on('click', function (e) {
            $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
        });
    });
    </script>
    <!-- jQuery Site Scipts -->
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script>
    $('.counter').counter({});
    $('.counter').on('counterStop', function () {

           $('.lazy-loader-parent').css('display','flex')

    });
    </script>
    <script src="assets/js/script.js"></script>

    <!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
{/literal}

<div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>