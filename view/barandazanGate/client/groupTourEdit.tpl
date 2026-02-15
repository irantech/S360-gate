{load_presentation_object filename="resultTourLocal" assign="objTour"}
{load_presentation_object filename="counterType" assign="objCounterType"}
{assign var="isEachPerson" value=$objTour->isEachPersonEnabled()}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

{if $objTour->accessReservationTour() and $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}


    {load_presentation_object filename="reservationTour" assign="objResult"}
    {assign var="infoTour" value=$objResult->infoTourByIdSameForEdit($smarty.get.id,true)}


    {if $infoTour['queryStatus']}

        {*        {if ($infoTour['maxDate'] lt $infoTour['dateNow']) || ( ($infoTour['minDate'] gt $infoTour['dateNow']) && ($infoTour['maxDate'] gt $infoTour['dateNow']) )}*}


        {assign var="infoTourCountry" value=$objResult->FindCountry($infoTour['origin_country_id'])}
        {assign var="infoTourCity" value=$objResult->FindCity($infoTour['origin_city_id'])}
        {assign var="infoTourCountryByLanguage" value=$infoTourCountry[$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'name')]}
        {assign var="infoTourCityByLanguage" value=$infoTourCity[$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'name')]}


        {assign var="tour_services" value=","|explode:$infoTour['tour_services']}
        {assign var="tourId" value=$infoTour['id']}

        {assign var=TourTravelProgram value=$objTour->listTourTravelProgram({$smarty.get.id})}
        {assign var=TourTravelProgramData value=$TourTravelProgram['data']|json_decode:true}
        {assign var=age_categories value=$infoTour['age_categories']|json_decode:true}



        {if $infoTour['user_id'] eq $smarty.session.userId}

            {assign var="getIsEditor" value=$objResult->isEditor('editor')}
            {if $getIsEditor[0]['enable'] eq '1'}
                {assign var="isEditor" value="ckeditor"}
            {else}
                {assign var="isEditor" value="width100"}
            {/if}

            {load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
            {load_presentation_object filename="reservationBasicInformation" assign="objBasic"}

            {assign var=tourTypeIdArray value=$infoTour['tour_type_id']|json_decode:true}
{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
<main>
    <section class="profile_section mt-3 mb-3 row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-static">
                    <div class="menu-profile-ris d-lg-none">
                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}" class="logo_img"><img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}' alt='logo'></a>
                        <button onclick="openMenuProfile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 88C0 74.75 10.75 64 24 64H424C437.3 64 448 74.75 448 88C448 101.3 437.3 112 424 112H24C10.75 112 0 101.3 0 88zM0 248C0 234.7 10.75 224 24 224H424C437.3 224 448 234.7 448 248C448 261.3 437.3 272 424 272H24C10.75 272 0 261.3 0 248zM424 432H24C10.75 432 0 421.3 0 408C0 394.7 10.75 384 24 384H424C437.3 384 448 394.7 448 408C448 421.3 437.3 432 424 432z"/></svg></button>
                    </div>
                    <div onclick="closeMenuProfile()" class="bg-black-profile-ris d-lg-none"></div>
                    <div class="box-style sticky-100">
                        {include file="./profileSideBar.tpl"}
                    </div>
                </div>
                <div class="col-lg-9">
                    {else}
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}
                    {/if}
            {if $infoTour['is_show'] eq 'no'}
                <div class="main-Content-top s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Dontshow##
                </span>
                    <div class="s-u-result-wrapper">
                        <span class="s-u-result-item-change direcR iranR txt14 txtRed">##BecauseOf##: {$infoTour['comment_cancel']}</span>
                    </div>
                </div>
            {/if}
            <form id='editTourWithIdSameForm' name="editTourWithIdSameForm" method='post'
                  data-toggle="validator" enctype='multipart/form-data'
                  action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">



                <input type="hidden" name="flag" id="flag" value="editTourWithIdSame" />
                <input type="hidden" name="is_routes_changed" id="is_routes_changed" value="0" />
                <input type="hidden" name="tourIdSame" id="tourIdSame" value="{$smarty.get.id}" />
                <input type="hidden" name="userId" id="userId" value="{$infoTour['user_id']}" />
                <input type="hidden" name="tourCode" id="tourCode" value="{$infoTour['tour_code']}" />
                <input type="hidden" name="agencyId" id="agencyId" value="{$infoTour['agency_id']}" />
                <input type="hidden" name="softwareLanguage" id="softwareLanguage"
                       value="{$smarty.const.SOFTWARE_LANG}" />
                <input type="hidden" name="agencyName" id="agencyName" value="{$infoTour['agency_name']}" />
                <input type="hidden" name="tourName" id="tourName" value="{$infoTour['tour_name']}" />
                <input type="hidden" name="pic" id="pic" value="{$infoTour['tour_pic']}" />
                <input type="hidden" name="cover" id="cover" value="{$infoTour['tour_cover']}" />
                <input type="hidden" name="file" id="file" value="{$infoTour['tour_file']}" />
                <input type="hidden" name="tourVideo" id="tourVideo" value="{$infoTour['tour_video']}" />


                {if 1|in_array:$tourTypeIdArray}
                    <input type="hidden" name="tourType" id="tourType" value="oneDayTour" />
                    <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="yes" />
                    <input type='hidden' name='id_one_day_only' id='id_one_day_only' value='1'>
                {else}
                    <input type="hidden" name="tourType" id="tourType" value="" />
                    <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="no" />
                    <input type='hidden' name='id_one_day_only' id='id_one_day_only' value='2'>
                {/if}


                <div class="main-Content-top s-u-passenger-wrapper-change">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color d-flex justify-content-between">
                        <span class='d-flex'>
                              <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart5"></i> ##Defualtinformationtour##
                        </span>
                        {assign var="check_offline" value=$objFunctions->checkClientConfigurationAccess('offline_tour')}
                        {assign var="check_online" value=$objFunctions->checkClientConfigurationAccess('online_tour')}

                        {if $check_offline eq true  && $check_online eq true}
                             <div class='d-flex'>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="is_request" id="isRequest1" {if $infoTour['is_request'] eq '0'}checked{/if} value="false">
                                  <label class="form-check-label mx-3" for="isRequest1">
                                    ##Tour## ##online##
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="is_request" id="isRequest2" {if $infoTour['is_request'] eq '1'}checked{/if}  value="true">
                                  <label class="form-check-label mx-3" for="isRequest2">
                                   ##Tour## ##offline##
                                  </label>
                                </div>
                            </div>
                             {elseif $check_offline eq true && $infoTour['is_request'] eq '1'}
                                 <input type="hidden"  id="is_request" name="is_request" value="true">
                             {else}
                                <input type="hidden"  id="is_request" name="is_request" value="false">
                             {/if}
                    </span>
                    <div class="panel-default-change site-border-main-color">





                        <div class="s-u-result-item-change">
                            {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                            <div class="s-u-passenger-item">
                                <label for="tourName" class="flr">##Nametour##:</label>
                                <input type="text" name="tourName" value="{$infoTour['tour_name']}">
                            </div>
                            {/if}


                            <div class="s-u-passenger-item width16">
                                <label for="tourNameEn" class="flr">##EnglishNameOfTour##:</label>
                                <input type="text" name="tourNameEn" id="tourNameEn"
                                       value="{$infoTour['tour_name_en']}">
                            </div>

                            <div class="s-u-passenger-item width16">
                                <label for="tourCode" class="flr">##codeTour##:</label>
                                <input type="text" name="tourCode" value="{$infoTour['tour_code']}">
                            </div>

                            <div class="s-u-passenger-item no-star width16">
                                <label for="tourReason" class="flr">##TheOccasionOfTheTour##:</label>
                                <input type="text" name="tourReason" id="tourReason"
                                       value="{$infoTour['tour_reason']}"
                                       placeholder="##EidToEid## / ##WorldCup## / ...">
                            </div>

                            <div class="s-u-passenger-item no-star width16">
                                <label for="stopTimeReserve" class="flr">##SaleStopTime## (##Hour##):</label>
                                <input type="text" name="stopTimeReserve" id="stopTimeReserve"
                                       value="{$infoTour['stop_time_reserve']}"
                                       placeholder="##SaleStopTime##">
                            </div>

                            <div class="s-u-passenger-item no-star width16">
                                <label for="stopTimeCancel" class="flr">##Cancelstoptime## (##Hour##):</label>
                                <input type="text" name="stopTimeCancel" id="stopTimeCancel"
                                       value="{$infoTour['stop_time_cancel']}"
                                       placeholder="##Cancelstoptime##" >
                            </div>

                            <div class="s-u-passenger-item no-star width16">
                                <label for="TourStatus" class="flr">##TourStatus##:</label>
                                <select name="TourStatus" id="TourStatus" class="select2">
                                    <option {if $infoTour['tour_status'] == 'In Process' } selected {/if} value="1">
                                        ##InProcess##
                                    </option>
                                    <option {if $infoTour['tour_status'] == 'Planning' } selected {/if} value="2">
                                        ##Planning##
                                    </option>
                                    <option {if $infoTour['tour_status'] == 'PlanningFuture' } selected {/if}
                                            value="3">##PlanningFuture##
                                    </option>
                                    <option {if $infoTour['tour_status'] == 'Registering' } selected {/if}value="4">
                                        ##Registering##
                                    </option>
                                    <option {if $infoTour['tour_status'] == 'EndOfRegistration' } selected {/if}
                                            value="5">##EndOfRegistration##
                                    </option>
                                    <option {if $infoTour['tour_status'] == 'LastMinuteTours' } selected {/if}
                                            value="6">##LastMinuteTours##
                                    </option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item no-star ">
                                <label for="TourDifficulties" class="flr">##TourDifficulties##:</label>
                                <select name="TourDifficulties" id="TourDifficulties" class="select2">
                                    <option {if $infoTour['tour_difficulties'] == '' } selected {/if} value="">
                                        ##ChoseOption##
                                    </option>
                                    <option {if $infoTour['tour_difficulties'] == 'easy' } selected {/if} value="1">
                                        ##Easy##
                                    </option>
                                    <option {if $infoTour['tour_difficulties'] == 'average' } selected {/if}
                                            value="2">##Average##
                                    </option>
                                    <option {if $infoTour['tour_difficulties'] == 'hard' } selected {/if} value="3">
                                        ##Hard##
                                    </option>
                                    <option {if $infoTour['tour_difficulties'] == 'very_hard' } selected {/if}
                                            value="4">##VeryHard##
                                    </option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item no-star ">
                                <label for="TourLeaderLanguage" class="flr">##TourLeaderLanguage##:</label>
                                <input type="text" name="TourLeaderLanguage" id="TourLeaderLanguage"
                                       value="{$infoTour['tour_leader_language']}"
                                       placeholder="##TourLeaderLanguage##">
                            </div>

                        </div>

                        <div class="s-u-passenger-item no-star width100">
                            <div class="s-u-passenger-item no-star width20 ">
                                <p class="checkboxStations">
                                    <input {if in_array('AgeCategories_Young',$age_categories)} checked {/if}
                                            type="checkbox" class="FilterHoteltype" id="AgeCategories_Young"
                                            name="AgeCategories_Young">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="AgeCategories_Young">##Young2Years##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width20 ">
                                <p class="checkboxStations">
                                    <input {if in_array('AgeCategories_Children',$age_categories)} checked {/if}
                                            type="checkbox" class="FilterHoteltype" id="AgeCategories_Children"
                                            name="AgeCategories_Children">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="AgeCategories_Children">##Children12Years##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width20 ">
                                <p class="checkboxStations">
                                    <input {if in_array('AgeCategories_Teenager',$age_categories)} checked {/if}
                                            type="checkbox" class="FilterHoteltype" id="AgeCategories_Teenager"
                                            name="AgeCategories_Teenager">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="AgeCategories_Teenager">##Teenagers18Years##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width20 ">
                                <p class="checkboxStations">
                                    <input {if in_array('AgeCategories_Adult',$age_categories)} checked {/if}
                                            type="checkbox" class="FilterHoteltype" id="AgeCategories_Adult"
                                            name="AgeCategories_Adult">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="AgeCategories_Adult">##Adults50Years##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width20 ">
                                <p class="checkboxStations">
                                    <input {if in_array('AgeCategories_UltraAdult',$age_categories)} checked {/if}
                                            type="checkbox" class="FilterHoteltype" id="AgeCategories_UltraAdult"
                                            name="AgeCategories_UltraAdult">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="AgeCategories_UltraAdult">##Adults100Years##</label>
                                </p>
                            </div>

                        </div>

                        {*<div class="s-u-result-item-change">
                            {assign var=itemArray value=$infoTour['tour_type_id']|json_decode:true}
                            <div class="s-u-passenger-item no-star width50">
                                <label for="tourType" class="flr">##Typetour##:</label>
                                <select name="tourTypeId[]" id="tourTypeId" class="select2" multiple="multiple">
                                    {foreach $objBasic->SelectAll('reservation_tour_type_tb') as $tourType}
                                        {if 1|in_array:$tourTypeIdArray || (!1|in_array:$tourTypeIdArray && $tourType['id'] neq '1')}
                                            <option value="{$tourType['id']}"
                                                    {if $tourType['id']|in_array:$itemArray}selected{/if}>{$tourType['tour_type']}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>

                            {if 1|in_array:$tourTypeIdArray}
                                <div class="notifications-oneDayTour" id="notificationOneDayTour">
                                    <i class="fa fa-commenting-o"></i><i> ##Onetour##؛ </i>

                                    ##NoAbleToChooseHotelToStay##
                                </div>
                                <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="yes"/>
                            {else}
                                <input type="hidden" name="flagOneDayTour" id="flagOneDayTour" value="no"/>
                            {/if}
                        </div>*}


                        <div class="s-u-result-item-change col-md-12 d-flex flex-wrap">


                            <div class="s-u-result-item-change m-0">
                                <div class="s-u-passenger-item no-star width100 d-flex flex-wrap gap-10">
                                    <span class='w-100 font-weight-bolder'>
                                        ##Category##:
                                    </span>
                                    {assign var="all_categories" value=$objTour->getTourTypes()}
                                    {assign var="tour_categories_id" value=$infoTour['tour_type_id']|json_decode:true}
                                    {assign var="tour_categories" value=$objTour->getTourTypes($tour_categories_id)}


                                    {if !empty($tour_categories)}
                                        {foreach $tour_categories as $key=>$category}
                                            {foreach $all_categories as $category_key=>$default_category}
                                                {if in_array($default_category['id'],$tour_categories_id) neq true && $key eq 0 }
                                                    <div data-name='default-fillable-data'
                                                         class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                                        <p class="align-items-center d-flex flex-wrap">
                                                            <input type="checkbox" class="FilterHoteltype"
                                                                   value="{$default_category['id']}"
                                                                   id="TourTypes{$key}{$category_key}"
                                                                   name="TourTypes[]">
                                                            <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                                                   for="TourTypes{$key}{$category_key}">{$default_category['tour_type']}</label>
                                                        </p>
                                                    </div>
                                                {/if}
                                            {/foreach}
                                            <div data-name='default-fillable-data'
                                                 class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                                <p class="align-items-center d-flex flex-wrap">
                                                    <input type="checkbox" class="FilterHoteltype"
                                                           checked
                                                           value="{$category['id']}"
                                                           id="TourTypes{$key}" name="TourTypes[]">
                                                    <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                                           for="TourTypes{$key}">{$category['tour_type']}</label>
                                                </p>
                                            </div>
                                        {/foreach}
                                    {else}
                                        {foreach $all_categories as $category_key=>$default_category}
                                            {if in_array($default_category['id'],$tour_categories_id) neq true && $key eq 0 }
                                                <div data-name='default-fillable-data'
                                                     class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                                    <p class="align-items-center d-flex flex-wrap">
                                                        <input type="checkbox" class="FilterHoteltype"
                                                               value="{$default_category['id']}"
                                                               id="TourTypes{$key}{$category_key}" name="TourTypes[]">
                                                        <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                                               for="TourTypes{$key}{$category_key}">{$default_category['tour_type']}</label>
                                                    </p>
                                                </div>
                                            {/if}
                                        {/foreach}
                                    {/if}
                                    <button type='button'
                                            onclick='addNewFillAbleField($(this),"TourTypes")'
                                            class="align-items-center bg-light border d-flex flex-wrap gap-5 px-3 py-2 rounded-pill site-border-main-color">
                                        <span class='fa fa-plus'></span>
                                        ##AddNew##
                                    </button>
                                </div>
                            </div>


                            <div class="s-u-result-item-change m-0">
                                <div class="s-u-passenger-item no-star width100 d-flex flex-wrap gap-10">
                                    <span class='w-100 font-weight-bolder'>
                                            ##TourServices##:
                                    </span>
                                    {assign var="default_services" value=$objTour->getTourServices()}

                                    {foreach $tour_services as $key=>$service}
                                        {foreach $default_services as $service_key=>$default_service}
                                            {if in_array($default_service,$tour_services) neq true && $key eq 0 }
                                                <div data-name='default-fillable-data'
                                                     class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                                    <p class="align-items-center d-flex flex-wrap">
                                                        <input type="checkbox" class="FilterHoteltype"
                                                               value="{$default_service}"
                                                               id="TourServices{$key}{$service_key}"
                                                               name="TourServices[]">
                                                        <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                                               for="TourServices{$key}{$service_key}">{$default_service}</label>
                                                    </p>
                                                </div>
                                            {/if}
                                        {/foreach}
                                        {if $service neq ''}
                                            <div data-name='default-fillable-data'
                                                 class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                                <p class="align-items-center d-flex flex-wrap">
                                                    <input type="checkbox" class="FilterHoteltype"
                                                           checked
                                                           value="{$service}"
                                                           id="TourServices{$key}" name="TourServices[]">
                                                    <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                                           for="TourServices{$key}">{$service}</label>
                                                </p>
                                            </div>
                                        {/if}



                                    {/foreach}

                                    <button type='button'
                                            onclick='addNewFillAbleField($(this),"TourServices")'
                                            class="align-items-center bg-light border d-flex flex-wrap gap-5 px-3 py-2 rounded-pill site-border-main-color">
                                        <span class='fa fa-plus'></span>
                                        ##AddNew##
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="s-u-result-item-change">

                            <div class="s-u-passenger-item no-star width12">
                                <label for="free" class="flr">##Permissibleamount##:</label>
                                <input type="hidden" name="free" id="free" value="{$infoTour['free']}">
                                <input type="text" value="{$infoTour['free']}">
                            </div>

                                <div class="s-u-passenger-item width12 txt11">
                                    <label for="startDate" class="flr">##Datestarthold##:</label>
                                    <input type="text" class="shamsiDeptCalendar"
                                           name="startDate" id="startDate"
                                           autocomplete='off'
                                           value="{$objFunctions->convertDate($infoTour['minDate'])}"
                                           placeholder="##Datestarthold## ##Tour##">
                                </div>

                                <div class="s-u-passenger-item width12 txt11">
                                    <label for="endDate" class="flr">##Dateendhold##:</label>
                                    <input type="text" class="shamsiReturnCalendar"
                                           name="endDate" id="endDate"
                                           autocomplete='off'
                                           value="{$objFunctions->convertDate($infoTour['maxDate'])}"
                                           placeholder="##Dateendhold## ##Tour##">
                                </div>


                            <div class="s-u-passenger-item width12 tooltip-tour">
                                <label for="night" class="flr">##NumberOfNightsStay##:</label>
                                <input type="text" name="night" id="night" value="{$infoTour['night']}"
                                       placeholder="##NumberOfNightsStay##">
                                <span class="tooltipText-tour">##Tourtooltipnight##</span>
                            </div>

                            <div class="s-u-passenger-item width12 tooltip-tour">
                                <label for="day" class="flr">##NumberOfDaysOfTravel##:</label>
                                <input type="text" name="day" id="day" value="{$infoTour['day']}"
                                       placeholder="##NumberOfDaysOfTravel##">
                                <span class="tooltipText-tour">##Tourtooltipday##</span>
                            </div>


                            {if $infoTour['is_request'] neq '1'}
                            <div class="s-u-passenger-item no-star width12">
                                <label for="prepaymentPercentage" class="flr">##Prepaymentpercentage##:</label>
                                <select name="prepaymentPercentage" id="prepaymentPercentage" class="select2">
                                    <option value="" disabled="disabled" selected> ##Selection##</option>
                                    {section name=foo start=0 loop=100 step=10}
                                        <option value="{$smarty.section.foo.index}"
                                                {if $infoTour['prepayment_percentage'] eq $smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                    {/section}
                                </select>
                            </div>
                            {/if}

                            <div class="s-u-passenger-item no-star width12">
                                <label for="visa" class="flr">##Visa##:</label>
                                <select name="visa" id="visa" class="select2">
                                    <option value="" disabled="disabled" selected> ##Selection##</option>
                                    <option value="yes" {if $infoTour['visa'] eq 'yes'}selected{/if}>##Have##
                                    </option>
                                    <option value="no" {if $infoTour['visa'] eq 'no'}selected{/if}>##Donthave##
                                    </option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item no-star width12">
                                <label for="insurance" class="flr">##Insurance##:</label>
                                <select name="insurance" id="insurance" class="select2">
                                    <option value="" disabled="disabled" selected> ##Selection##</option>
                                    <option value="yes" {if $infoTour['insurance'] eq 'yes'}selected{/if}>##Have##
                                    </option>
                                    <option value="no" {if $infoTour['insurance'] eq 'no'}selected{/if}>
                                        ##Donthave##
                                    </option>
                                </select>
                            </div>


                            {assign var="daysWeek" value=$objResult->getDaysWeekAnyTour($smarty.get.id)}
                            <div class="s-u-passenger-item no-star width100">
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh0" name="sh0"
                                               {if 0|in_array:$daysWeek}checked{/if} value="0">
                                        <label class="FilterHoteltypeName site-main-text-color-a"
                                               for="sh0">##Saturday##</label>
                                    </p>
                                </div>
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh1" name="sh1"
                                               {if 1|in_array:$daysWeek}checked{/if} value="1">
                                        <label class="FilterHoteltypeName site-main-text-color-a"
                                               for="sh1">##Sunday## </label>
                                    </p>
                                </div>
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh2" name="sh2"
                                               {if 2|in_array:$daysWeek}checked{/if} value="2">
                                        <label class="FilterHoteltypeName site-main-text-color-a" for="sh2">
                                            ##Monday##</label>
                                    </p>
                                </div>
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh3" name="sh3"
                                               {if 3|in_array:$daysWeek}checked{/if} value="3">
                                        <label class="FilterHoteltypeName site-main-text-color-a"
                                               for="sh3">##Tuesday## </label>
                                    </p>
                                </div>
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh4" name="sh4"
                                               {if 4|in_array:$daysWeek}checked{/if} value="4">
                                        <label class="FilterHoteltypeName site-main-text-color-a" for="sh4">##Wednesday##
                                        </label>
                                    </p>
                                </div>
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh5" name="sh5"
                                               {if 5|in_array:$daysWeek}checked{/if} value="5">
                                        <label class="FilterHoteltypeName site-main-text-color-a"
                                               for="sh5">##Thursday##</label>
                                    </p>
                                </div>
                                <div class="s-u-passenger-item no-star width12">
                                    <p class="checkboxStations">
                                        <input type="checkbox" class="FilterHoteltype" id="sh6" name="sh6"
                                               {if 6|in_array:$daysWeek}checked{/if} value="6">
                                        <label class="FilterHoteltypeName site-main-text-color-a"
                                               for="sh6">##Friday##</label>
                                    </p>
                                </div>
                            </div>


                            <div class="s-u-passenger-item no-star width100">
                                <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                        ##Description##</h2></div>
                                <div class="panel height0 panel-editor">
                            <textarea name="description" id="description" dir="rtl" cols="100" rows="7"
                                      class="{$isEditor}">{$infoTour['description']}</textarea>
                                </div>
                            </div>

                            <div class="s-u-passenger-item no-star width100">
                                <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                        ##Requireddocuments##</h2>
                                </div>
                                <div class="panel height0 panel-editor">
                            <textarea name="requiredDocuments" id="requiredDocuments" dir="rtl" cols="40" rows="7"
                                      class="{$isEditor}">{$infoTour['required_documents']}</textarea>
                                </div>
                            </div>

                            <div class="s-u-passenger-item no-star width100">
                                <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                        ##TermsandConditions##</h2>
                                </div>
                                <div class="panel height0 panel-editor">
                                <textarea name="rules" id="rules" dir="rtl" cols="40" rows="7"
                                          class="{$isEditor}">{$infoTour['rules']}</textarea>
                                </div>
                            </div>

                            <div class="s-u-passenger-item no-star width100">
                                <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                        ##Cancellationrules##</h2>
                                </div>
                                <div class="panel height0 panel-editor">
                            <textarea name="cancellationRules" id="cancellationRules" dir="rtl" cols="40" rows="7"
                                      class="{$isEditor}">{$infoTour['cancellation_rules']}</textarea>
                                </div>
                            </div>

                            <div class="s-u-passenger-item no-star width100">
                                <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                        ##Tourtravelprogram##</h2>
                                </div>
                                <div class="panel height0 panel-editor p-4">
                                    <div class="p-4">
                                        <div class="BaseTourTravelProgramDays">
                                            {assign var=TourTravelProgramCounter value=1}

                                            {if !is_array($TourTravelProgramData)}
                                                {assign var=TourTravelProgramData value="array ('day' => array ( 0 => array ( 'title' => '', 'body' => '', 'gallery' => array ( 0 => array ( 'title' => '', 'file' => '', ) ) ) ) )"}
                                            {/if}
                                            {foreach $TourTravelProgramData.day as $TourTravelProgramDay}
                                                {assign var=galleryCount value=count($TourTravelProgramDay.gallery)-1}
                                                <div class="box-type-1 mb-4 pt-4 d-block"
                                                     data-counter="{$TourTravelProgramCounter}"
                                                      data-file='{$galleryCount}'>
                                                    <span class="box-type-1-counter site-bg-main-color">{$TourTravelProgramCounter}</span>
                                                    <span class="box-type-1-close BaseTourTravelProgramClose">
                                            <span class="fa fa-close"></span>
                                        </span>
                                                    <span class="box-type-1-go-bot">
                                            <span class="fa fa-arrow-down"></span>
                                        </span>
                                                    <div class="form-row mt-2">
                                                        <div class="form-group col-md-12">
                                                            <div class="s-u-passenger-item no-star w-100">
                                                                <label for="TourTravelProgramTitle" class="flr">
                                                                    ##Title##:</label>
                                                                <input type="text"
                                                                       name="TourTravelProgram[day][{$TourTravelProgramCounter-1}][title]"
                                                                       id="TourTravelProgramTitle"
                                                                       value="{$TourTravelProgramDay['title']}"
                                                                       placeholder="##Title## ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row mb-5">
                                                        <div class="form-group col-md-12">
                                                            <div class="s-u-passenger-item no-star w-100">
                                                                <label for="TourTravelProgramBody" class="flr">
                                                                    ##Body##:</label>
                                                                <textarea rows="10"
                                                                          name="TourTravelProgram[day][{$TourTravelProgramCounter-1}][body]"
                                                                          id="TourTravelProgramBody{$TourTravelProgramCounter}"
                                                                          dir="rtl"
                                                                          cols="40"
                                                                          class="w-100">{$TourTravelProgramDay['body']|strip_tags}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="BaseTourTravelProgramGalleryPicker form-row">
                                                        {assign var=TourTravelProgramGalleryCounter value=1}

                                                        {foreach $TourTravelProgramDay.gallery as $TourTravelProgramGallery }
                                                            {if $TourTravelProgramGalleryCounter-1 == 0 }
                                                                {assign var=counter value=''}
                                                            {else}
                                                                {assign var=counter value=$TourTravelProgramGalleryCounter-1}
                                                            {/if}
                                                            <div class="box-galery-picker-1 form-group col-md-3 {if $counter == 0 }galleryForCloneJs{/if}">

                                                                <div class="s-u-passenger-item no-star w-100">
                                                        <span class="box-type-1-close BaseTourTravelProgramGalleryPickerClose">
                                                        <span class="fa fa-close"></span>
                                                              </span>
                                                                    <div class="form-group">
                                                                        <label class="text text-right d-block" for="TourTravelProgramGalleryTitle{$TourTravelProgramCounter}{$TourTravelProgramGalleryCounter}">##Gallery##:</label>
                                                                        <input type="text" name="TourTravelProgram[day][{$TourTravelProgramCounter-1}][gallery][{$counter}][title]" id="TourTravelProgramGalleryTitle{$TourTravelProgramCounter}{$TourTravelProgramGalleryCounter}" value="{$TourTravelProgramGallery.title}" placeholder="##Title##">
                                                                    </div>
                                                                    <div class="form-group custom-file">
                                                                        <input type="file" class="custom-file-input inputFilePreview" name="TourTravelProgram[day][{$TourTravelProgramCounter-1}][gallery][{$counter}][file]" value="{$TourTravelProgramGallery.file}" id="filepdf">
                                                                        <input type="hidden" value="{$TourTravelProgramGallery.file}" name="TourTravelProgram[day][{$TourTravelProgramCounter-1}][gallery][{$counter}][file_hidden]">
                                                                        <label class="custom-file-label" for="filepdf">##Gallery##:</label>
                                                                    </div>
                                                                    <div class="form-group border rounded-lg text-center p-3">
                                                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$TourTravelProgramGallery.file}" class="img-fluid divFilePreview" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {$TourTravelProgramGalleryCounter = $TourTravelProgramGalleryCounter+1}
                                                        {/foreach}







                                                        <div class="makeAnotherImage_Js newImageLogo form-group col-md-3">
                                                            <div class="s-u-passenger-item no-star w-100">
                                                                <div class="form-group">
                                                                    <span class="fa fa-plus"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                {$TourTravelProgramCounter = $TourTravelProgramCounter+1}
                                            {/foreach}
                                        </div>
                                        <div class="w-100 d-block mt-4">
                                            <button type="button" class="btn btn-primary makeAnotherDay_Js">
                                                <span class="fa fa-plus-square"></span>
                                                ##AddDay##
                                            </button>
                                            <div class="d-block mt-3 BaseTourTravelProgramBadge ">
                                                {for $foo=1 to $TourTravelProgramCounter-1}
                                                    <button class="btn badge-secondary mr-2" data-counter="{$foo}"
                                                            type="button">{$foo}</button>
                                                {/for}
                                            </div>
                                        </div>
                                    </div>
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
                                       accept="image/x-png, image/gif, image/jpeg, image/jpg" />
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
                                <label for="tourCover" class="flr">##CoverImage##:</label>
                                <input type="file" name="tourCover" id="tourCover"
                                       accept="image/x-png, image/jpeg, image/jpg" />
                            </div>
                            <div class="notifications-upload-image">
                                <span><i class="fa fa-angle-double-left"></i> ##ImageSizeDescription##: <b>5.6</b> ##Or## <b style='unicode-bidi: plaintext; direction: ltr;'> 1423 × 250 px</b></span>
                                <span><i class="fa fa-angle-double-left"></i>##Capacityimage## <b>2MB</b> ##Do##</span>
                            </div>
                            <div class="show-upload-image">
                                <a class="downloadLink"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_cover']}"
                                   target="_blank"
                                   type="application/octet-stream">
                                    <img style="width: 63% !important;height: auto;"
                                         src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_cover']}"
                                         alt="{$tour['tour_name']}">
                                </a>

                            </div>
                        </div>


                        <div class="s-u-result-item-change">
                            <div class="s-u-passenger-item no-star">
                                <label for="tourFile" class="flr">##Package##:</label>
                                <input type="hidden" name="file" id="file" value="{$infoTour['tour_file']}" />
                                <input type="file" name="tourFile" id="tourFile" multiple data-height="100"
                                       accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf"
                                       data-default-file="" />
                            </div>
                            <div class="notifications-upload-image">
                                <span><i class="fa fa-angle-double-left"></i> ##Selectedfileextension##: <b>.pdf,</b><b> .jgp,</b><b> .jpeg,</b><b> .gif,</b><b> png</b></span>
                                <span><i class="fa fa-angle-double-left"></i>##Capacityimage##<b>1MB</b> ##Do##</span>
                            </div>
                            {if $infoTour['tour_file']}
                            <div class="show-upload-image">
                                <a class="downloadLink"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_file']}"
                                   target="_blank"
                                   type="application/octet-stream">##Showpackagefile##<i
                                            class="mdi mdi-download"></i></a>
                            </div>
                            {/if}
                        </div>


                        <div class="s-u-result-item-change">

                            <div class="s-u-passenger-item no-star">
                                <label for="tourVideo" class="flr">##Video##:</label>
                                <input type="text" name="tourVideo" id="tourVideo"  />
                            </div>
                            <div class="notifications-upload-image">
                                <span><i class="fa fa-angle-double-left"></i>##videoIframeLink##</span>
                            </div>
                            {if $infoTour['tour_video']}


                            <div class="show-upload-image">
                                <a class="downloadLink"
                                   href="{$infoTour['tour_video']}"
                                   target="_blank"
                                   type="application/octet-stream">##seeVideo##<i
                                            class="mdi mdi-download"></i></a>
                            </div>
                            {/if}

                        </div>

                    </div>
                </div>


                <div class="main-Content-top s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="fa fa-file-image-o zmdi-hc-fw mart5"></i>##CustomRequiredAssets##
                </span>
                    <div class="d-flex flex-wrap panel-default-change p-4 site-border-main-color">

                        {assign var="custom_file_fields" value=$infoTour['custom_file_fields']|json_decode:true}

                        {foreach $custom_file_fields as $key=>$field}
                            <div data-name="custom_file_fields" class="col-md-3 d-flex flex-wrap">
                                <span class="fa fa-remove " onclick="removeCustomFile($(this))"></span>
                                <div class="form-group w-100">
                                    <label for="custom_file_fields_{$key}">##fileName##</label>
                                    <input type="text" class="form-control" name="custom_file_fields[]"
                                           value='{$field}'
                                           id="custom_file_fields_{$key}" placeholder="{$field}">
                                </div>
                            </div>
                        {/foreach}


                        <div onclick="addCustomFile($(this))"
                             class="align-items-center col-md-3 plus-btn d-flex flex-wrap justify-content-center dashed-3 site-border-main-color">
                            <div class="form-group align-items-center d-flex m-0 flex-wrap justify-content-center w-100">
                                <label for="custom_file_field" class="m-0">+</label>
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


                            <div class="s-u-passenger-item">
                                <label for="originContinent1" class="flr">##Continent## (##Origin##):</label>
                                <select name="originContinent1" id="originContinent1"
                                        class="select2" onchange="fillComboCountry('1', 'origin')">
                                    <option value="" disabled="disabled">##Selection##</option>
                                    <option value="1" {if $infoTour['origin_continent_id'] eq '1'}selected{/if}>
                                        ##Asia##
                                    </option>
                                    <option value="2" {if $infoTour['origin_continent_id'] eq '2'}selected{/if}>
                                        ##Europe##
                                    </option>
                                    <option value="3" {if $infoTour['origin_continent_id'] eq '3'}selected{/if}>
                                        ##America##
                                    </option>
                                    <option value="4" {if $infoTour['origin_continent_id'] eq '4'}selected{/if}>
                                        ##Australia##
                                    </option>
                                    <option value="5" {if $infoTour['origin_continent_id'] eq '5'}selected{/if}>
                                        ##Africa##
                                    </option>
                                    <option value="6" {if $infoTour['origin_continent_id'] eq '6'}selected{/if}>
                                        ##Oceania##
                                    </option>
                                </select>
                            </div>


                            <div class="s-u-passenger-item">
                                <label for="originCountry1" class="flr">##Country## (##Origin##):</label>
                                <input type="hidden" name="originCountryName1"
                                       id="originCountryName1"
                                       value="{$rout['origin_country_name']}">
                                <select name="originCountry1" id="originCountry1"
                                        class="select2" onchange="fillComboCity('1', 'origin')">
                                    <option value="" disabled="disabled"> ##Selection##</option>
                                    {foreach $objPublic->getCountries($infoTour['origin_continent_id']) as $country}
                                        <option value="{$country['id']}"
                                                {if $infoTour['origin_country_id'] eq $country['id']}selected{/if}
                                        >{$country['title']}</option>
                                    {/foreach}

                                </select>
                            </div>

                            <div class="s-u-passenger-item ">
                                <label for="originCity1" class="flr">##City## (##Origin##):</label>
                                <input type="hidden" name="originCityName1"
                                       id="originCityName1"
                                       value="{$rout['origin_city_name']}">
                                <select name="originCity1" id="originCity1"
                                        class="select2" onchange="fillComboRegion('1', 'origin')">
                                    <option value="" disabled="disabled"> ##Selection##</option>


                                    {foreach $objPublic->getCities($infoTour['origin_country_id']) as $city}
                                        <option value="{$city['id']}"
                                                {if $infoTour['origin_city_id'] eq $city['id']}selected{/if}
                                        >{$city['title']}</option>
                                    {/foreach}

                                </select>
                            </div>

                            <div class="s-u-passenger-item no-star">
                                <label for="originRegion1" class="flr">##Area## (##Origin##):</label>
                                <input type="hidden" name="originRegionName1"
                                       id="originRegionName1"
                                       value="{$rout['origin_region_name']}">
                                <select name="originRegion1" id="originRegion1" class="select2">
                                    <option value="" disabled="disabled"> ##Selection##</option>

                                    {foreach $objPublic->getRegions($infoTour['origin_city_id']) as $region}
                                        <option value="{$region['id']}"
                                                {if $infoTour['origin_region_id'] eq $region['id']}selected{/if}
                                        >{$region['title']}</option>
                                    {/foreach}


                                </select>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="main-Content-top s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="fa fa-check zmdi-hc-fw mart5"></i>##Traveldestination##
            </span>
                    <div class="panel-default-change site-border-main-color">
                        <div class="s-u-result-item-change">

                            {assign var="route" value=['0' => 'dept', '1' => 'return']}
                            {assign var="numberRout" value="0"}
                            {foreach key=key item=item from=$route}

                                {if $item eq 'dept'}
                                    {assign var="idDiv" value="rowRout"}
                                    {assign var="classW" value="width20"}
                                {elseif $item eq 'return'}
                                    {assign var="idDiv" value="rowReturnRoute"}
                                    {assign var="classW" value="width25"}
                                {/if}
                                <div id="{$idDiv}">

                                    {assign var="count" value="0"}
                                    {foreach key=key item=rout from=$objResult->infoTourRoutByIdTour($tourId, $item)}

                                        {$numberRout=$numberRout+1}
                                        {$count=$count+1}
                                        <div id="rowAnyRout{$numberRout}"
                                             class="rowAnyRout bg-light-blue overflow-hidden rounded route_box ">
                                            <input type="hidden"
                                                   name="tourTitle{$numberRout}"
                                                   id="tourTitle{$numberRout}"
                                                   data-values="name,id"
                                                   data-name="tourTitle"
                                                   class='change_counter_js'
                                                   value="{$item}">
                                            <div class='rowAnyRouteBox'>
                                            <div class="rout-number divDeleteRow">
                                                <div class="align-items-center d-flex flex-wrap justify-content-between px-2 rout-number-50 w-100">
                                                    <span class='font-weight-bold' {if $item neq 'return'} data-name="title-counter" {/if}>##Destination## {if $item eq 'return'}##Return##{else}{$count}{/if}</span>

                                                    {if $item neq 'return'}
                                                        <button type='button'
                                                                onclick="removeRowRout('{$numberRout}')"
                                                                data-name='remove-btn'
                                                                class="btn btn-danger btn-sm font-12 p-1 px-2">
                                                            <span class="deleteRow fa fa-trash"></span>
                                                            ##Delete##
                                                        </button>
                                                    {/if}
                                                </div>
                                                <!--                                                    <div class="rout-number-50">
                                                        {if $numberRout neq '1'}
                                                            <span class="deleteRow" onclick="logicalDeletionRout('{$rout['id']}')">d</span>
                                                        {/if}
                                                    </div>-->
                                            </div>
                                            <div class='rowAnyRouteBox'>
                                            {if $item eq 'dept'}
                                                <div class="s-u-passenger-item  width20">
                                                    <label for="night{$numberRout}"
                                                           data-name="night"
                                                           data-values="for"
                                                           class="flr change_counter_js">##Countnight##:</label>
                                                    <input type="text" name="night{$numberRout}"
                                                           id="night{$numberRout}"
                                                           data-name="night"
                                                           data-values="name,id"
                                                           class='change_counter_js'
                                                           value="{$rout['night']}">

                                                </div>
                                                {*<div class="s-u-passenger-item no-star width10">
                                                    <label for="day{$numberRout}" class="flr">##Countday##:</label>
                                                    <input type="text" value="{$rout['day']}" disabled>
                                                    <input type="hidden" name="day{$numberRout}" id="day{$numberRout}"
                                                           value="{$rout['day']}">
                                                </div>*}
                                            {elseif $item eq 'return'}
                                                <input type="hidden" name="night{$numberRout}"
                                                       id="night{$numberRout}"
                                                       data-name="night"
                                                       data-values="name,id"
                                                       class='change_counter_js'
                                                       value="0">
                                                <input type="hidden"
                                                       data-name="day"
                                                       data-values="name,id"

                                                       class='change_counter_js'
                                                       name="day{$numberRout}" id="day{$numberRout}"
                                                       value="0">
                                            {/if}

                                            <div class="s-u-passenger-item no-star {$classW}">
                                                <label for="destinationContinent{$numberRout}"
                                                       data-name="destinationContinent"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Continent##
                                                    (##Destination##):</label>
                                                <select class="select2 change_counter_js"
                                                        name="destinationContinent{$numberRout}"
                                                        id="destinationContinent{$numberRout}"
                                                        data-name="destinationContinent"
                                                        data-values="name,id,data-counter"
                                                        data-counter='{$numberRout}'
                                                        data-previous-value='{$rout['destination_continent_id']}'
                                                        onchange="fillComboCountryByDataAttr($(this), 'destination')">
                                                    <option value="" disabled="disabled"> ##Selection##</option>
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

                                            {assign var="infoTourDestinationCountry" value=$objResult->FindCountry($rout['destination_country_id'])}
                                            {assign var="infoTourDestinationCity" value=$objResult->FindCity($rout['destination_city_id'])}
                                            {assign var="infoTourDestinationCountryByLanguage" value=$infoTourDestinationCountry[$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'name')]}
                                            {assign var="infoTourDestinationCityByLanguage" value=$infoTourDestinationCity[$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'name')]}

                                            <div class="s-u-passenger-item no-star {$classW}">
                                                <label for="destinationCountry{$numberRout}"
                                                       data-name="destinationCountry"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Country##
                                                    (##Destination##):</label>

                                                <input type="hidden" name="destinationCountryName{$numberRout}"
                                                       id="destinationCountryName{$numberRout}"
                                                       data-values="name,id"
                                                       data-name="destinationCountryName"
                                                       class='change_counter_js'
                                                       value="{$rout['destination_country_name']}">


                                                <select class="select2 change_counter_js"
                                                        data-name="destinationCountry"
                                                        data-values="name,id,data-counter"
                                                        name="destinationCountry{$numberRout}"
                                                        id="destinationCountry{$numberRout}"
                                                        data-counter='{$numberRout}'
                                                        data-previous-value='{$rout['destination_country_id']}'
                                                        onchange="fillComboCityByDataAttr($(this), 'destination')"

                                                >
                                                    <option value="" disabled="disabled"> ##Selection##</option>


                                                    {foreach $objPublic->getCountries($rout['destination_continent_id']) as $country}
                                                        <option value="{$country['id']}"
                                                                {if $rout['destination_country_id'] eq $country['id']}selected{/if}
                                                        >{$country['title']}</option>
                                                    {/foreach}


                                                </select>
                                            </div>

                                            <div class="s-u-passenger-item no-star {$classW}">
                                                <label for="destinationCity{$numberRout}"
                                                       data-name="destinationCity"
                                                       data-values="for"
                                                       class="flr change_counter_js">##City##
                                                    (##Destination##):</label>

                                                <input type="hidden" name="destinationCityName{$numberRout}"
                                                       id="destinationCityName{$numberRout}"
                                                       data-values="name,id"
                                                       data-name="destinationCityName"
                                                       class='change_counter_js'
                                                       value="{$rout['destination_city_name']}">

                                                <select class="select2 change_counter_js"
                                                        data-name="destinationCity"
                                                        data-values="name,id,data-counter"
                                                        name="destinationCity{$numberRout}"
                                                        id="destinationCity{$numberRout}"
                                                        data-counter='{$numberRout}'
                                                        data-previous-value='{$rout['destination_city_id']}'
                                                        onchange="fillComboRegionByDataAttr($(this), 'destination')">
                                                    <option value="" disabled="disabled"> ##Selection##</option>

                                                    {foreach $objPublic->getCities($rout['destination_country_id']) as $city}
                                                        <option value="{$city['id']}"
                                                                {if $rout['destination_city_id'] eq $city['id']}selected{/if}
                                                        >{$city['title']}</option>
                                                    {/foreach}

                                                </select>
                                            </div>

                                            <div class="s-u-passenger-item no-star width20">
                                                <label for="destinationRegion{$numberRout}"
                                                       data-name="destinationRegion"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Area##
                                                    (##Destination##):</label>


                                                <input type="hidden" name="destinationRegionName{$numberRout}"
                                                       id="destinationRegionName{$numberRout}"
                                                       data-values="name,id"
                                                       data-name="destinationRegionName"
                                                       class='change_counter_js'
                                                       value="{$rout['destination_region_name']}">


                                                <select class="select2 change_counter_js"
                                                        data-name="destinationRegion"
                                                        data-values="name,id"
                                                        name="destinationRegion{$numberRout}"
                                                        id="destinationRegion{$numberRout}">
                                                    <option value="" disabled="disabled"> ##Selection##</option>

                                                    {foreach $objPublic->getRegions($rout['destination_city_id']) as $region}
                                                        <option value="{$region['id']}"
                                                                {if $rout['destination_region_id'] eq $region['id']}selected{/if}
                                                        >{$region['title']}</option>
                                                    {/foreach}

                                                </select>
                                            </div>

                                            <div class="s-u-passenger-item width12">
                                                <label for="typeVehicle{$numberRout}"
                                                       data-name="typeVehicle"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Vehicletype##:</label>
                                                <select name="typeVehicle{$numberRout}"
                                                        id="typeVehicle{$numberRout}"
                                                        data-name="typeVehicle"
                                                        data-values="name,id,data-counter"
                                                        class="select2 change_counter_js"
                                                        data-counter='{$numberRout}'
                                                        data-previous-value='{$rout['type_vehicle_id']}'
                                                        onchange="listAirlineByDataAttr($(this))">
                                                    <option value="" disabled="disabled">##Selection##</option>
                                                    {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                                                        <option value="{$typeVehicle['id']}"
                                                                {if $rout['type_vehicle_id'] eq $typeVehicle['id']}selected{/if}>{$typeVehicle['name']}</option>
                                                    {/foreach}
                                                </select>
                                            </div>

                                            <div class="s-u-passenger-item ">
                                                <label for="airline{$numberRout}"
                                                       data-name="airline"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Shippingcompany##:</label>
                                                <select name="airline{$numberRout}" id="airline{$numberRout}"
                                                        data-name="airline"
                                                        data-values="name,id"
                                                        class="select2 change_counter_js">
                                                    <option value="" disabled="disabled">##Selection##</option>
                                                    <option value="{$rout['airline_id']}"
                                                            selected>{$rout['airline_name']}</option>
                                                </select>
                                            </div>

                                            <div class="s-u-passenger-item no-star width12">
                                                <label for="class{$numberRout}"
                                                       data-name="class"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Classrate##:</label>
                                                <select name="class{$numberRout}" id="class{$numberRout}"
                                                        data-name="class"
                                                        data-values="name,id"
                                                        class="select2 change_counter_js">
                                                    <option value="" disabled="disabled" selected>##Selection##
                                                    </option>
                                                    {foreach $objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade}
                                                        <option value="{$vehicleGrade['name']}"
                                                                {if $rout['class'] eq $vehicleGrade['name']}selected{/if}>{$vehicleGrade['name']}</option>
                                                    {/foreach}
                                                </select>
                                            </div>

                                            {assign var=expExitHours value=":"|explode:$rout['exit_hours']}
                                            <div class="s-u-passenger-item no-star width12 txt11">
                                                <label for="exitHours{$numberRout}"
                                                       data-name="exitHours"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Starttime##
                                                    (##Hour##):</label>
                                                <select name="exitHours{$numberRout}" id="exitHours{$numberRout}"
                                                        data-name="exitHours"
                                                        data-values="name,id"
                                                        class="form-control change_counter_js">
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
                                                <label for="exitMinutes{$numberRout}"
                                                       data-name="exitMinutes"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Starttime##
                                                    (##Minutes##):</label>
                                                <select name="exitMinutes{$numberRout}"
                                                        id="exitMinutes{$numberRout}"
                                                        data-name="exitMinutes"
                                                        data-values="name,id"
                                                        class="form-control change_counter_js">
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
                                                <label for="hours{$numberRout}"
                                                       data-name="hours"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Periodoftime##
                                                    (##Hour##):</label>
                                                <select name="hours{$numberRout}" id="hours{$numberRout}"
                                                        data-name="hours"
                                                        data-values="name,id"
                                                        class="form-control change_counter_js">
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
                                                <label for="minutes{$numberRout}"
                                                       data-name="minutes"
                                                       data-values="for"
                                                       class="flr change_counter_js">##Periodoftime##
                                                    (##Minutes##):</label>
                                                <select name="minutes{$numberRout}" id="minutes{$numberRout}"
                                                        data-name="minutes"
                                                        data-values="name,id"
                                                        class="form-control change_counter_js">
                                                    <option value="{$expHours[1]}">{$expHours[1]}</option>
                                                    {for $n=0 to 9}
                                                        <option value="0{$n}">0{$n}</option>
                                                    {/for}
                                                    {for $n=10 to 60}
                                                        <option value="{$n}">{$n}</option>
                                                    {/for}
                                                </select>
                                            </div>

                                            <div class="s-u-passenger-item  no-star">
                                                <label data-values="for" data-name="minutes"
                                                       for="is_route_fake{$numberRout}" class="flr change_counter_js">##showInResult##</label>

                                                <select name="is_route_fake{$numberRout}"
                                                        data-values="name,id"
                                                        data-name="is_route_fake"
                                                        id="is_route_fake{$numberRout}" class="form-control change_counter_js">

                                                    <option value="1" {if $rout['is_route_fake'] eq '1' || $rout['is_route_fake'] eq ''}selected="selected"{/if}>##show##</option>
                                                    <option value="0" {if $rout['is_route_fake'] eq '0'}selected="selected"{/if}>>##NotShow##</option>
                                                </select>
                                            </div>
                                            </div>
                                           </div>
                                        </div>
                                        <div class="clear"></div>
                                    {/foreach}

                                </div>
                                <div class="clear"></div>
                                {if $item eq 'dept'}
                                    <input type="hidden" value="{$count}" name="countRowAnyDeptRout"
                                           id="countRowAnyDeptRout" />
                                    <div class="tour-btn-add" onclick="insertRowRout('rowRout')">
                                        <span class="addRowRoute"></span>
                                        <span class="addRowTXT">##AddNewRoute##</span>
                                    </div>
                                {elseif $item eq 'return'}
                                    <!--                                        <input type="hidden" value="{$count}" name="countRowAnyReturnRout"
                                               id="countRowAnyReturnRout"/>
                                        <div class="tour-btn-add" onclick="insertRowRout('rowReturnRoute')">
                                            <span class="addRowRouteReturn"></span>
                                            <span class="addRowTXT">اضافه کردن مسیر برگشت</span>
                                        </div>-->
                                {/if}

                            {/foreach}
                            {*                                {$numberRout=$numberRout+1}*}
                            <input type="hidden" value="{$numberRout}" name="countRowAnyRout" id="countRowAnyRout" />
                        </div>
                        <div class="clear"></div>

                    </div>
                    <div class="clear"></div>

                </div>
                <div class="clear"></div>


                <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnFirst">
                    {*<div class="col-3 mx-auto">*}
                    <button type="submit"

                            data-loading-title='Loading'
                            class="btn btn-success tour-edit-button">##Nextstep## (##Tourpackagechanges##)
                    </button>
                    {*</div>*}
                    {*<input class="s-u-select-flight-change site-secondary-text-color bgGreen"
                           type="submit" value="##Nextstep## (##Tourpackagechanges##)">*}
                </div>

            </form>
            <form id='tourPackageEditForm' name="tourPackageEditForm" method='post'
                  data-toggle="validator" enctype='multipart/form-data'
                  action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">
                <input type="hidden" name="flag" id="flag" value="editTourPackageWithIdSame" />
                <input type="hidden" name="id_same" id="id_same" value="{$smarty.get.id}" />
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
                                    <div class="d-flex flex-wrap gap-10 p-3 w-100">

                                        <div class="bg-white rounded row-tour-hotel w-100">
                                            <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                <span class="tour-price-r">##SpecialCounterPrice##</span>
                                            </div>

                                            <div class="p-2 py-4 tour-hotel w-100">
                                                <div class="box-hotel justify-content-center d-flex flex-wrap w-100">

                                                    {assign var="tour_discounts" value=$objResult->getTourDiscountByIdSame($infoTour['id_same'])}

                                                    {foreach $objCounterType->list as $counter_key=>$counter_type}
                                                        {assign var="tour_discount" value=$objFunctions->arrayFilterByValue($tour_discounts,'counter_type_id',$counter_type['id'])|array_values}
                                                        {assign var="tour_discount" value=$tour_discount[0]}


                                                        <div class="col-lg-2.5 col-md-4 no-star">


                                                            <div class="d-flex font-13 font-weight-bolder justify-content-center p-2 py-2 w-100">
                                                                <span class="tour-price-r">{$counter_type.name}</span>
                                                            </div>

                                                            {foreach $objTour->tourDiscountFieldsIndex() as $entry_key=>$entry}
                                                                <div class="w-100 no-star mb-3">
                                                                    <label for="{$entry.index}{$counter_key}"
                                                                           class="flr font-12 text-muted">{$entry.title}
                                                                        (##Riali##):</label>

                                                                    <input type="text"
                                                                           name="{$entry.index}{$counter_key}"
                                                                           id="{$entry.index}{$counter_key}"
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

                                </div>
                            </div>
                        {else}
                            <input type="hidden" name="flagSecond" id="flagSecond" value="tourPackageRegistration" />
                            <input type="hidden" name="count_edit" id="count_edit" value="" />
                            <div class="main-Content-top s-u-passenger-wrapper-change">
                                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                                    <i class="fa fa-check zmdi-hc-fw mart5"></i>
                                    {if $smarty.const.SOFTWARE_LANG == 'en'}
                                        Package
                                        {else}
                                        ##Package##
                                    {/if}

                                </span>
                                <div class="panel-default-change site-border-main-color">
                                    <div class="s-u-result-item-change">

                                        <div id="rowPackage">

                                            {assign var="countPackage" value="0"}

                                            {foreach key=key item=package from=$objResult->infoTourPackageByIdTour($tourId)}
                                                {if $objFunctions->isEnableSetting('eachPerson')}
                                                    <p class="py-1 mt-1 text-dark bg-warning">##enterPricePerPerson##</p>
                                                {/if}
                                                {$countPackage = $countPackage + 1}
                                                <div id="rowAnyPackage{$countPackage}"
                                                     class="bg-light-blue overflow-hidden rounded rowAnyRout package-box">

                                                    <div class="d-flex divDeleteRow justify-content-center rout-number">
                                                        <div class="align-items-center d-flex flex-wrap justify-content-between px-2 rout-number-50 w-100 mr-3">
                                                            <span style='flex-grow: 1; text-align: right;' class='font-weight-bold'>##Package## {$countPackage}</span>

                                                            <button type='button' onclick="logicalDeletionGroupPackage('{$smarty.get.id}','{$package['number_package']}')"
                                                                    class='btn btn-danger btn-sm font-12 p-1 px-2'>
                                                                <span class="deleteRow fa fa-trash"></span>
                                                                ##Delete##
                                                            </button>

                                                            <button type="button" onclick="modalAddRoom('{$package['number_package']}')" class="btn btn-primary btn-sm font-12 p-1 px-2">
                                                                <span class="addRoom fa fa-plus"></span>
                                                                ##AddRoomPackage##
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
                                                                        <div class="box-hotel d-flex flex-wrap w-100 justify-content-center">
                                                                            <div class="col-md-4 no-star">
                                                                                <label for="hotelId{$countPackage}{$countPackageHotel}"
                                                                                       class="flr font-12 text-muted">
                                                                                    ##Selectionhotel##:</label>
                                                                                <select name="hotelId{$countPackage}{$countPackageHotel}"
                                                                                        id="hotelId{$countPackage}{$countPackageHotel}"
                                                                                        class="select2"  onchange="getRoomsHotel(this)">
                                                                                    <option value="">
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
                                                                                {assign var="rooms_hotel" value=$objResult->getRoomsTypeHotelPackageTour(['hotel_id'=>$hotel['fk_hotel_id']])}

                                                                                <label for="roomType{$countPackage}{$countPackageHotel}"
                                                                                       class="flr font-12 text-muted">##Selecttyperoom##:</label>
                                                                                <select name="roomType{$countPackage}{$countPackageHotel}"
                                                                                        id="roomType{$countPackage}{$countPackageHotel}"
                                                                                        class="select2 hotel_rooms_selected">
                                                                                    <option value="" disabled="disabled" selected> ##Selection## </option>

                                                                                    {foreach $rooms_hotel as $room}
                                                                                        <option value="{$room['room_name']}" {if $hotel['room_type'] eq $room['room_name']}selected{/if}>{$room['room_name']}</option>
                                                                                    {/foreach}
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
                                                                               class="flr font-12 text-muted">
                                                                            {if $isEachPerson}
                                                                                ##RoomthreebedEachPerson##
                                                                            {else}
                                                                                ##Roomthreebed##
                                                                            {/if}

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
                                                                               class="flr font-12 text-muted">
                                                                            {if $isEachPerson}
                                                                                ##Roomtwobedeachperson##
                                                                            {else}
                                                                                ##Roomtwobed##
                                                                            {/if}
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
                                                                                           name="{$entry.index}{$countPackage}{$counter_key}"
                                                                                           id="{$entry.index}{$countPackage}{$counter_key  }"
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
                                                    <div id='rowRooBed{$countPackage}'>
                                                    {foreach $package['custom_room']|json_decode:256:64 as $key => $room}
                                                        {if $room['fourRoom']}
                                                            {assign var='roomName' value="fourRoom"}
                                                            {assign var='number_room' value="4"}
                                                        {/if}
                                                        {if $room['fiveRoom']}
                                                            {assign var='roomName' value="fiveRoom"}
                                                            {assign var='number_room' value="5"}
                                                        {/if}
                                                        {if $room['sixRoom']}
                                                            {assign var='roomName' value="sixRoom"}
                                                            {assign var='number_room' value="6"}
                                                        {/if}




                                                                <div id="customRoomPackage{$countPackage}R{$number_room}" class="bg-white rounded row-tour-hotel w-100">

                                                                    <div class="border-bottom d-flex justify-content-between font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                                                        <span class="tour-price-r">{$objFunctions->StrReplaceInXml(['@@number@@'=>$number_room],'roomBedInfo')} </span>

                                                                        <button onclick="deleteRoomPackage('{$countPackage}','{$number_room}')" class="btn btn-danger btn-sm font-12 p-1 px-2">
                                                                            <span class="deleteRow fa fa-trash"></span>
                                                                            ##Delete##
                                                                        </button>
                                                                    </div>
                                                                     <div class="d-flex flex-wrap p-2 py-4 tour-hotel w-100">

                                                                        <div class="col-md-4 mb-3 px-2 no-star width14">
                                                                            <label for="{$roomName}PriceR{$countPackage}"
                                                                                   data-name="{$roomName}PriceR"
                                                                                   data-values="for"
                                                                                   class="flr font-12 text-muted change_counter_js">{$objFunctions->StrReplaceInXml(['@@number@@'=>$number_room],'Roomcountbed')} {$objFunctions->Xmlinformation('Riali')}</label>
                                                                            <input type="text" name="{$roomName}PriceR{$countPackage}"
                                                                                   data-name="{$roomName}PriceR"
                                                                                   data-values="name,id"
                                                                                   value="{$room[$roomName]['price_r']|number_format}"
                                                                                   class="form-control font-12 change_counter_js" id="{$roomName}PriceR{$countPackage}"
                                                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="##PriceRial##">
                                                                        </div>

                                                                        <div class="col-md-4 mb-3 px-2 no-star width14">
                                                                            <label for="{$roomName}PriceA{$countPackage}"
                                                                                   data-name="{$roomName}PriceA"
                                                                                   data-values="for" class="flr font-12 text-muted change_counter_js">{$objFunctions->StrReplaceInXml(['@@number@@'=>$number_room],'Roomcountbed')} {$objFunctions->Xmlinformation('Arzi')}</label>
                                                                            <input type="text" name="{$roomName}PriceA{$countPackage}"
                                                                                   data-name="{$roomName}PriceA"
                                                                                   data-values="name,id" id="{$roomName}PriceA{$countPackage}"
                                                                                   class="form-control font-12 change_counter_js"
                                                                                   value="{$room[$roomName]['price_a']|number_format}"
                                                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="##ArziPrice##">
                                                                        </div>

                                                                        <div class="col-md-4 mb-3 px-2 no-star width14">
                                                                            <label for="{$roomName}Capacity{$countPackage}"
                                                                                   data-name="{$roomName}Capacity"
                                                                                   data-values="for" class="flr font-12 text-muted change_counter_js">{$objFunctions->StrReplaceInXml(['@@number@@'=>$number_room],'Roomcountbed')}</label>
                                                                            <input type="text" name="{$roomName}Capacity{$countPackage}"
                                                                                   data-name="{$roomName}Capacity"
                                                                                   data-values="name,id" id="{$roomName}Capacity{$countPackage}"
                                                                                   class="form-control font-12 change_counter_js"
                                                                                   value="{$room[$roomName]['capacity']}"
                                                                                   onkeypress="isDigit(this)" placeholder="##CapacityRoom##" value="9">
                                                                        </div>


                                                                    </div>
                                                                </div>


                                                    {/foreach}
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
                                        class="btn btn-success tour-edit-package-button">##Register##
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
                </div>
            </div>
        </div>
    </section>
</main>
{/if}
            <div id='ModalPublic'></div>
            <div id='ModalPublicContent2' class='modal'></div>
        {literal}
            <script>
              $(document).ready(function() {

                // datepicker after ajax call
                $('body').on('click', '.shamsiDeptCalendar', function() {
                  if (!$(this).hasClass('hasDatepicker')) {
                    $(this).datepicker()
                    $(this).datepicker('show')
                  }
                })
                $('body').on('click', '.shamsiReturnCalendar', function() {
                  if (!$(this).hasClass('hasDatepicker')) {
                    $(this).datepicker()
                    $(this).datepicker('show')
                  }
                })

              })

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
              $(document).ready(function() {

                $('body').delegate('.makeAnotherDay_Js', 'click', function() {
                  $('.box-type-1:first-child').clone().insertAfter('.BaseTourTravelProgramDays .box-type-1:last-child')
                  $('.BaseTourTravelProgramBadge button:first-child').clone().insertAfter('.BaseTourTravelProgramBadge button:last-child')
                  var lengthDives = $('.box-type-1').length
                  var lengthDivesForIndex = lengthDives - 1
                  $('.box-type-1:last-child input').each(function() {
                    $(this).val('')
                    $(this).attr('name', $(this).attr('name').replace(/\[0]/g, '[' + lengthDivesForIndex + ']'))
                  })
                  $('.box-type-1:last-child textarea').each(function() {
                    $(this).val('')
                    $(this).attr('name', $(this).attr('name').replace(/\[0]/g, '[' + lengthDivesForIndex + ']'))
                  })
                  let count = 0 ;
                  $('.box-type-1:last-child .box-galery-picker-1').each(function () {
                    if(count != 0 ){
                      $(this).remove()
                    }else{
                      $(this).find('input').val('')
                    }
                    count = count + 1 ;
                  });
                  $('.box-type-1:last-child #TourTravelProgramBody').attr('id', $('.box-type-1:last-child #TourTravelProgramBody').attr('id') + lengthDives).css({'display': 'block'})
                  $('#TourTravelProgramDays').val(lengthDives)
                  $('.box-type-1:last-child').find('textarea').prev().remove()
                  $('.box-type-1:last-child').find('textarea').attr('id', $('.box-type-1:last-child').find('textarea').attr('id') + lengthDives)
                  $('.box-type-1:last-child .box-type-1-counter').html(lengthDives)
                  $('.box-type-1:last-child').attr('data-counter', lengthDives)
                  $('.BaseTourTravelProgramBadge button:last-child').attr('data-counter', lengthDives).html(lengthDives)
                  tinymce.init({
                    selector: '.setToEditor',
                  })
                  $.smoothScroll({
                    scrollTarget: '[data-counter=' + lengthDives + ']',
                    offset: -75,
                  })
                })
                // $("body").delegate(".makeAnotherImage_Js", "click", function () {
                //     $(this).parent(".box-type-1").remove();
                // })


                $('body').delegate('.BaseTourTravelProgramBadge button', 'click', function() {
                  $.smoothScroll({
                    scrollTarget: '[data-counter=' + $(this).attr('data-counter') + ']',
                    offset: -75,
                  })
                })
                $('body').delegate('.box-type-1-go-bot', 'click', function() {
                  $.smoothScroll({
                    scrollTarget: '.makeAnotherDay_Js',
                    offset: -75,
                  })
                })
                $('body').delegate('.makeAnotherImage_Js', 'click', function() {
                  var lengthDives = $('.box-type-1').length;
                  let file_count =  $(this).parents(".box-type-1").attr('data-file') ;
                  var lengthDivesForIndex = ++file_count;

                  $(this).parents(".box-type-1").attr('data-file' , lengthDivesForIndex);
                  var dataCounter = parseInt($(this).parents(".box-type-1").attr('data-counter'))-1;
                  let forClone = $('.BaseTourTravelProgramGalleryPicker').find(".galleryForCloneJs").first();

                  forClone.clone().insertBefore($(this));

                  $(this).parents(".box-type-1").find('.BaseTourTravelProgramGalleryPicker .box-galery-picker-1').children().last().find('input').each(function () {
                    $(this).val('')
                  });
                  $(this).parents(".box-type-1").find('.BaseTourTravelProgramGalleryPicker .box-galery-picker-1').children().last().find('img').each(function () {
                    $(this).attr('src','//placehold.it/140?text=IMAGE')
                  });
                  let count = 0 ;
                  $(this).parents(".box-type-1").find('.BaseTourTravelProgramGalleryPicker .box-galery-picker-1 input').each(function () {
                    if(count != 0 && count != 1 ) {
                      $(this).attr('name',$(this).attr('name').replace('TourTravelProgram[day][0][gallery][][file]', 'TourTravelProgram[day]['+dataCounter+'][gallery]['+lengthDivesForIndex+'][file]'));

                      $(this).attr('name',$(this).attr('name').replace('TourTravelProgram[day][0][gallery][][title]', 'TourTravelProgram[day]['+dataCounter+'][gallery]['+lengthDivesForIndex+'][title]'));
                      $(this).attr('name',$(this).attr('name').replace('TourTravelProgram[day][0][gallery][][file_hidden]', 'TourTravelProgram[day]['+dataCounter+'][gallery]['+lengthDivesForIndex+'][file_hidden]'));

                    }
                    ++count
                  });
                })
                $('body').delegate('.BaseTourTravelProgramGalleryPickerClose', 'click', function() {
                  let box = $(this).parents(".box-galery-picker-1")
                  let count = box.parent(".BaseTourTravelProgramGalleryPicker").children().length;
                  if(count > 2) {
                    let file_count =  $(this).parents(".box-type-1").attr('data-file') ;
                    var lengthDivesForIndex = --file_count;
                    $(this).parents(".box-type-1").attr('data-file' , lengthDivesForIndex);
                    box.remove();
                  }
                })
                $('body').delegate('.BaseTourTravelProgramClose', 'click', function() {
                  $('.BaseTourTravelProgramBadge button[data-counter=' + $(this).parents('.box-type-1').attr('data-counter') + ']').remove()
                  $(this).parents('.box-type-1').remove()
                  var lengthDives = $('.box-type-1').length
                  $('#TourTravelProgramDays').val(lengthDives)
                })
                $('body').delegate('.inputFilePreview', 'change', function() {
                  var thiss = $(this)
                  var input = $(this)[0]
                  if (input.files && input.files[0]) {
                    var reader = new FileReader()
                    reader.onload = function(e) {
                      thiss.parent().parent().find('.divFilePreview').attr('src', e.target.result).fadeIn('slow')
                    }
                    reader.readAsDataURL(input.files[0])
                  }
                })
              })
              var acc = document.getElementsByClassName('accordion')
              var i
              for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener('click', function() {
                  this.classList.toggle('active')
                  var panel = this.nextElementSibling
                  if (panel.style.maxHeight) {
                    panel.style.maxHeight = null
                  } else {
                    // panel.style.maxHeight = panel.scrollHeight + "px";
                    panel.style.maxHeight = '100%'
                  }
                })
              }
            </script>
        {/literal}


        {else}
            <div class="userProfileInfo-messge">
                <div class="messge-login">##Noaccesstihspage##</div>
            </div>
        {/if}

        {*{else}
            <div class="userProfileInfo-messge">
                <div class="messge-login">
                    ##TourStarted##
                </div>
            </div>
        {/if}*}
    {else}
        <div class="userProfileInfo-messge">
            <div class="messge-login">
                از این تور رزرو شده است و دیگر قابل ویرایش نیست
            </div>
        </div>
    {/if}

{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
            ##Pleasslogin##
        </div>
    </div>
{/if}

<script src="assets/js/profile.js"></script>