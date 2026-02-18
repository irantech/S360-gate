

<form method="post" id="formPassengerDetailHotelLocal" action="{$smarty.const.ROOT_ADDRESS}/factorHotelNew">
    <input type="hidden" name="StatusRefresh" id="StatusRefresh" value="NoRefresh">
    <input type="hidden" id="numberRow" value="0">
    <input type="hidden" value="{$requestNumber}" name="requestNumber">
    {*    <code style='color: red;'>{$smarty.post|json_encode}</code>*}


    {assign var="i" value=0}
    {assign var="rooms_count" value=0}
    <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="external">

    {foreach $temproryHotelLocal as $keyRooms=>$room}

        {$keyRooms= $keyRooms+1}
        {$childCount = $room['ChildCount']}
        {$adultCount = $room['AdultsCount']}
        {assign var='room_name' value="{$room['room_name']}"}
        {if ($temproryHotelLocal|count) gt 1}
            {$room_name="{$objFunctions->ConvertNthNumber($keyRooms)} {$room['room_name']}"}
        {/if}
        <input type="hidden" name="adultCount{$keyRooms}" id="adultCount{$keyRooms}" value="{$room['AdultsCount']}">
        {for $adultNumber = 1 to $room['AdultsCount']}
            <input type="hidden" name="roomIndex{$keyRooms}" value="{$room['RoomIndex']}">

            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first pb-2">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">

                   {$objFunctions->displayRoomName($room_name,$adultNumber,'Adt',true)}
                    {*{$room['room_name']} <span class="countRoom">(##Informationpassenger## {$keyRooms} - {$adultNumber})</span>*}
                   <!-- <i class="soap-icon-family"></i> -->
               </span>

                <input type="hidden" name="RoomCount_Reserve{$room['room_id']}" id="RoomCount_Reserve{$room['room_id']}"
                       value="1">
                <input type="hidden" name="Id_Select_Room{$keyRooms}" id="Id_Select_Room{$keyRooms}" value="{$room['room_id']}">

                <div class="panel-default-change site-border-main-color pb-2">
                    <div class="panel-heading-change">

                        <span class="hidden-xs-down">##Nation##:</span>

                        <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityA{$keyRooms}{$adultNumber}"
                                       id="passengerNationalityA{$keyRooms}{$adultNumber}"
                                       value="0" class="nationalityChange" checked="checked">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                     <svg fill="#000000" viewBox="0 0 30 30">
                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                               </svg>
                                </div>
                            </label>
                        </span>
                        <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Another##</span>
                                <input type="radio" name="passengerNationalityA{$keyRooms}{$adultNumber}"
                                       id="passengerNationalityA{$keyRooms}{$adultNumber}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                     <svg fill="#000000" viewBox="0 0 30 30">
                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                               </svg>
                                </div>
                            </label>
                        </span>

                        {if $objSession->IsLogin()}
                            <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                  onclick="setHidenFildnumberRow('A{$keyRooms}{$adultNumber}')">
                                 <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                             </span>
                        {/if}
                    </div>

                    <div class="clear"></div>

                    <div class="panel-body-change">

                        <div class="s-u-passenger-item  s-u-passenger-item-change ">
                            <select id="genderA{$keyRooms}{$adultNumber}" name="genderA{$keyRooms}{$adultNumber}" required aria-required="true">
                                <option value="" disabled="" selected="selected">##Sex##</option>
                                <option value="Male">##Sir##</option>
                                <option value="Female">##Lady##</option>
                            </select>
                        </div>
                        {if $IsInternal eq '1' }
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameFaA{$keyRooms}{$adultNumber}" type="text" placeholder="##Namepersion##"
                                       name="nameFaA{$keyRooms}{$adultNumber}"
                                       oninput="return validatePersianInput('nameFaA{$keyRooms}{$adultNumber}')" class="justpersian">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyFaA{$keyRooms}{$adultNumber}" type="text" placeholder="##Familypersion##"
                                       name="familyFaA{$keyRooms}{$adultNumber}"
                                       oninput="return validatePersianInput('nameFaA{$keyRooms}{$adultNumber}')" class="justpersian">
                            </div>
                        {/if}
                        {if $IsInternal neq '1' }
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameEnA{$keyRooms}{$adultNumber}" type="text" placeholder="##Nameenglish##" name="nameEnA{$keyRooms}{$adultNumber}"
                                       oninput="return validateEnglishInput('nameEnA{$keyRooms}{$adultNumber}')" class="">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyEnA{$keyRooms}{$adultNumber}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnA{$keyRooms}{$adultNumber}"
                                       oninput="return validateEnglishInput('familyEnA{$keyRooms}{$adultNumber}')" class="">
                            </div>
                        {/if}
                        {if $IsInternal eq '1' }
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeA{$keyRooms}{$adultNumber}" type="text" placeholder="##Nationalnumber##"
                                       name="NationalCodeA{$keyRooms}{$adultNumber}" maxlength="10" class="UniqNationalCode">
                            </div>
                        {/if}

                        <div class="s-u-passenger-item s-u-passenger-item-change {if $IsInternal eq '1'}noneIranian {/if}">
                            <input id="passportNumberA{$keyRooms}{$adultNumber}" type="text" placeholder="##Numpassport##"
                                   name="passportNumberA{$keyRooms}{$adultNumber}" class="UniqPassportNumber">
                        </div>



                        <input type="hidden" id="BedType{$keyRooms}{$adultNumber}" name="BedType{$keyRooms}{$adultNumber}" value="Twin">
                        <div class="alert_msg" id="messageA{$keyRooms}{$adultNumber}"></div>
                    </div>
                </div>

                <div class="clear"></div>

            </div>
        {/for}

        {if $room['ChildCount'] gt 0}
            <input type="hidden" name="childCount{$keyRooms}" id="childCount{$keyRooms}" value="{$room['ChildCount']}">
            {for $childNumber = 1 to $room['ChildCount']}
                <input type="hidden" name="roomIndex{$keyRooms}" value="{$room['RoomIndex']}">
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first pb-2">
               <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">

                   {$objFunctions->displayRoomName($room_name,$adultNumber,'Chd',true)}
                   {*{$room['room_name']} <span class="countRoom">(##Informationpassenger## ##Child##{$keyRooms}-{$childNumber})</span>*}
                   <!-- <i class="soap-icon-family"></i> -->
               </span>

                    <input type="hidden" name="RoomCount_Reserve{$room['room_id']}" id="RoomCount_Reserve{$room['room_id']}"
                           value="1">
                    <input type="hidden" name="Id_Select_Room{$keyRooms}" id="Id_Select_Room{$keyRooms}" value="{$room['room_id']}">

                    <div class="panel-default-change site-border-main-color">
                        <div class="panel-heading-change">

                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityC{$keyRooms}{$childNumber}"
                                       id="passengerNationalityC{$keyRooms}{$childNumber}"
                                       value="0" class="nationalityChange" checked="checked">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                               </svg>
                                </div>
                            </label>
                        </span>
                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Another##</span>
                                <input type="radio" name="passengerNationalityC{$keyRooms}{$childNumber}"
                                       id="passengerNationalityC{$keyRooms}{$childNumber}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                               </svg>
                                </div>
                            </label>
                        </span>

                            {if $objSession->IsLogin()}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                      onclick="setHidenFildnumberRow('C{$keyRooms}{$childNumber}')">
                                 <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                             </span>
                            {/if}
                        </div>

                        <div class="clear"></div>

                        <div class="panel-body-change">

                            <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                <select id="genderC{$keyRooms}{$childNumber}" name="genderC{$keyRooms}{$childNumber}">
                                    <option value="" disabled="" selected="selected">##Sex##</option>
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>
                            {if $IsInternal eq '1' }
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <input id="nameFaC{$keyRooms}{$childNumber}" type="text" placeholder="##Namepersion##"
                                           name="nameFaC{$keyRooms}{$childNumber}"
                                           oninput="return validatePersianInput('nameFaC{$keyRooms}{$childNumber}')" class="justpersian">
                                </div>

                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <input id="familyFaC{$keyRooms}{$childNumber}" type="text" placeholder="##Familypersion##"
                                           name="familyFaC{$keyRooms}{$childNumber}"
                                           oninput="return validatePersianInput('familyFaC{$keyRooms}{$childNumber}')"
                                           class="justpersian">
                                </div>
                            {/if}
                            {if $IsInternal neq '1' }
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <input id="nameEnC{$keyRooms}{$childNumber}" type="text" placeholder="##Nameenglish##"
                                           name="nameEnC{$keyRooms}{$childNumber}"
                                           oninput="return validateEnglishInput('nameEnC{$keyRooms}{$childNumber}')" class="">
                                </div>

                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <input id="familyEnC{$keyRooms}{$childNumber}" type="text" placeholder="##Familyenglish##"
                                           name="familyEnC{$keyRooms}{$childNumber}"
                                           oninput="return validateEnglishInput('familyEnC{$keyRooms}{$childNumber}')" class="">
                                </div>
                            {/if}

                            {if $IsInternal eq '1'}
                                <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                    <input id="NationalCodeC{$keyRooms}{$childNumber}" type="text" placeholder="##Nationalnumber##"
                                           name="NationalCodeC{$keyRooms}{$childNumber}" maxlength="10" class="UniqNationalCode">
                                </div>
                            {/if}

                            <div class="s-u-passenger-item s-u-passenger-item-change {if $IsInternal eq '1'}noneIranian {/if}">
                                <input id="passportNumberC{$keyRooms}{$childNumber}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberC{$keyRooms}{$childNumber}" class="UniqPassportNumber">
                            </div>

                            <input type="hidden" id="BedType{$keyRooms}" name="BedType{$keyRooms}" value="Twin">

                            <div class="alert_msg" id="messageC{$keyRooms}{$childNumber}"></div>
                        </div>
                    </div>

                    <div class="clear"></div>

                </div>
            {/for}
        {/if}
        {$rooms_count = ($rooms_count + 1)}
    {/foreach}


    <input type="hidden" name="rooms_count" value="{$rooms_count}">
    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first ">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change passenger_leader site-main-text-color">
             ##Headgroupinformation##
          </span>
        <div class="clear"></div>
        <div class="panel-default-change-Buyer">

            <div class="s-u-passenger-items s-u-passenger-item-change">
                <input id="passenger_leader_room_fullName" type="text" placeholder="##Namefamily##"
                        {if (is_array($InfoMember) && ($InfoMember.name neq '' || $InfoMember.family neq ''))} value="{$InfoMember.name} {$InfoMember.family}" {/if}
                       name="passenger_leader_room_fullName" class="dir-ltr">
            </div>

            <div class="s-u-passenger-items s-u-passenger-item-change">
                <input id="passenger_leader_room" type="text" placeholder="##Phonenumber##" name="passenger_leader_room"
                        {if (is_array($InfoMember) && $InfoMember.name neq '' )} value="{$InfoMember.mobile}" {/if}
                       class="dir-ltr">
            </div>

            <div class="alert_msg" id="messagePassengerLeader"></div>
        </div>
        <div class="clear"></div>
    </div>


    {if not $objSession->IsLogin()}
        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
           <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>   ##InformationSaler##
          </span>
            <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
            <div class="clear"></div>
            <div class="panel-default-change-Buyer">
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Mobile" type="text" placeholder="##Phonenumber##" name="Mobile" class="dir-ltr">
                </div>
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Telephone" type="text" placeholder="##Phone##" name="Telephone" class="dir-ltr">
                </div>
                <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                    <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                </div>
                <div class="alert_msg" id="messageInfo"></div>
            </div>
            <div class="clear"></div>
        </div>
    {/if}


    <input type="hidden" id="TotalNumberRoom_Reserve" name="TotalNumberRoom_Reserve" value="{$TotalNumberRoom}">
    <input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="{$TotalPrice}">
    <input type="hidden" id="idCity_Reserve" name="idCity_Reserve" value="{$smarty.post.IdCity_Reserve}">
    <input type="hidden" id="Hotel_Reserve" name="Hotel_Reserve" value="{$smarty.post.idHotel_reserve}">
    <input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="{$roomTypeCodes}">
    <input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="{$numberOfRooms}">
    <input type="hidden" id="StartDate_Reserve" name="StartDate_Reserve" value="{$smarty.post.startDate_reserve}">
    <input type="hidden" id="EndDate_Reserve" name="EndDate_Reserve" value="{$smarty.post.endDate_reserve}">
    <input type="hidden" id="Nights_Reserve" name="Nights_Reserve" value="{$smarty.post.nights_reserve}">
    <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
    <input type="hidden" id="factorNumber" name="factorNumber" value="{$smarty.post.factorNumber}">
    <input type="hidden" id="typeApplication" name="typeApplication" value="{$typeApplication}">
    <input type="hidden" id="source_id" name="source_id" value="{$smarty.post.source_id}">
    <input type="hidden" id="is_internal" name="is_internal" value="{$IsInternal}">
    <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$smarty.post.CurrencyCode}">
    <input type="hidden" value="" name="idMember" id="idMember">

    <div class="btns_factors_n">
        <div class="next_hotel__">
            <a href="" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
            <button type="button" onclick="checkHotelNew('{$smarty.now}','{$adultCount}','{$childCount}','{$requestNumber}')"
                    class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color"
                    id="send_data">
                ##NextStepInvoice##&nbsp;
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>
    </div>

</form>