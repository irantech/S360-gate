{load_presentation_object filename="resultTourLocal" assign="objTour"}

{if $objTour->accessReservationTour() and $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}

{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}

{load_presentation_object filename="reservationTour" assign="objResult"}
{assign var="getIsEditor" value=$objResult->isEditor('editor')}
{if $getIsEditor[0]['enable'] eq '1'}
    {assign var="isEditor" value="ckeditor"}
{else}
    {assign var="isEditor" value="width100"}
{/if}

{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="DeptDatePickerClass" value='shamsiDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='shamsiReturnCalendar'}
{else}
    {assign var="DeptDatePickerClass" value='gregorianDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='gregorianReturnCalendar'}
{/if}
{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}

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
<div class="client-head-content">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="tourHistory">
            <span>
                <a href="{$smarty.const.ROOT_ADDRESS}/tourRegistration">
                    <i class="margin-left-10 font-i"></i>##Newtourentry##</a>
            </span>
               <span>
                <a href="{$smarty.const.ROOT_ADDRESS}/tourRegistration&tourType=oneDayTour">
                    <i class="margin-left-10 font-i"></i>##Onedaytourentry##</a>
            </span>
        </div>
    </div>


    <div class="main-Content-top s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            <i class="fa fa-exclamation mart5  zmdi-hc-fw"></i>##Note##
        </span>
        <div class="s-u-result-wrapper">
           <span class="s-u-result-item-change direcR iranR txt14 txtRed">
               ##Requiredallfield##
           </span>
        </div>
    </div>

    <form id='tourRegistrationForm' name="tourRegistrationForm" method='post'
          data-toggle="validator" enctype='multipart/form-data' action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">
        <input type="hidden" name="flag" id="flag" value="tourRegistration"/>
        <input type="hidden" name="is_routes_changed" id="is_routes_changed" value="1"/>

        <input type="hidden" name="userId" id="userId" value="{$smarty.session.userId}"/>
        <input type="hidden" name="TourTravelProgram[day]" id="TourTravelProgramDays" value=""/>

        <input type="hidden" name="id_one_day_only" id="id_one_day_only" value="{if isset($smarty.get.tourType) && $smarty.get.tourType eq 'oneDayTour'}1{/if}"/>
        <input type="hidden" name="softwareLanguage" id="softwareLanguage" value="{$smarty.const.SOFTWARE_LANG}"/>

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
                          <input class="form-check-input" type="radio" name="is_request" id="isRequest1" checked value="false">
                          <label class="form-check-label mx-3" for="isRequest1">
                            ##Tour## ##online##
                          </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="is_request" id="isRequest2"  value="true">
                      <label class="form-check-label mx-3" for="isRequest2">
                        ##Tour## ##offline##
                      </label>
                    </div>
                    </div>
                {elseif $check_offline eq true}
                    <input type="hidden"  id="is_request" name="is_request" value="true">
                {else}
                     <input type="hidden"  id="is_request" name="is_request" value="false">
                {/if}
            </span>
            <div class="panel-default-change site-border-main-color">
                <div class="s-u-result-item-change">


                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        <div class="s-u-passenger-item ">
                            <label for="tourName" class="flr"> ##Nametour##:</label>
                            <input type="text" name="tourName" id="tourName" value="" placeholder="##Nametour##">
                        </div>
                    {/if}

                    <div class="s-u-passenger-item">
                        <label for="tourNameEn" class="flr">##EnglishNameOfTour##:</label>
                        <input type="text" name="tourNameEn" id="tourNameEn" value=""
                               placeholder="##EnglishNameOfTour##">
                    </div>

                    <div class="s-u-passenger-item ">
                        <label for="tourCode" class="flr"> ##codeTour##:</label>
                        <input type="text" name="tourCode" id="tourCode" value="" placeholder="##codeTour## ">
                    </div>

                    <div class="s-u-passenger-item no-star ">
                        <label for="tourReason" class="flr">##TheOccasionOfTheTour##:</label>
                        <input type="text" name="tourReason" id="tourReason" value=""
                               placeholder="##EidToEid## / ##WorldCup## / ...">
                    </div>

                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        <div class="s-u-passenger-item no-star ">
                            <label for="stopTimeReserve" class="flr">##SaleStopTime## (##Hour##):</label>
                            <input type="text" name="stopTimeReserve" id="stopTimeReserve" value=""
                                   placeholder="##SaleStopTime##"
                               >
                        </div>
                        <div class="s-u-passenger-item no-star ">
                            <label for="stopTimeCancel" class="flr">##Cancelstoptime## (##Hour##):</label>
                            <input type="text" name="stopTimeCancel" id="stopTimeCancel" value=""
                                   placeholder="##Cancelstoptime##"
                                  >
                        </div>
                    {/if}

                    <div class="s-u-passenger-item no-star ">
                        <label for="TourStatus" class="flr">##TourStatus##:</label>
                        <select name="TourStatus" id="TourStatus" class="select2">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                            <option value="1">##InProcess##</option>
                            <option value="2">##Planning##</option>
                            <option value="3">##PlanningFuture##</option>
                            <option value="4">##Registering##</option>
                            <option value="5">##EndOfRegistration##</option>
                            <option value="6">##LastMinuteTours##</option>
                        </select>
                    </div>


                    <div class="s-u-passenger-item no-star ">
                        <label for="TourDifficulties" class="flr">##TourDifficulties##:</label>
                        <select name="TourDifficulties" id="TourDifficulties" class="select2">
                            <option value="" selected>##ChoseOption##</option>
                            <option value="1">##Easy##</option>
                            <option value="2">##Average##</option>
                            <option value="3">##Hard##</option>
                            <option value="4">##VeryHard##</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star ">
                        <label for="TourLeaderLanguage" class="flr">##TourLeaderLanguage##:</label>
                        <input type="text" name="TourLeaderLanguage" id="TourLeaderLanguage" value=""
                               placeholder="##TourLeaderLanguage##">
                    </div>

                </div>
                <div class="s-u-passenger-item no-star width100">
                    <label for="AgeCategories_Young" class="flr width100">##AgeAverage##:</label>
                    <div class="s-u-passenger-item no-star  ">
                        <p class="checkboxStations">
                            <input type="checkbox" class="FilterHoteltype" id="AgeCategories_Young" name="AgeCategories_Young">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="AgeCategories_Young">##Young2Years##</label>
                        </p>
                    </div>
                    <div class="s-u-passenger-item no-star  ">
                        <p class="checkboxStations">
                            <input type="checkbox" class="FilterHoteltype" id="AgeCategories_Children" name="AgeCategories_Children">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="AgeCategories_Children">##Children12Years##</label>
                        </p>
                    </div>
                    <div class="s-u-passenger-item no-star  ">
                        <p class="checkboxStations">
                            <input type="checkbox" class="FilterHoteltype" id="AgeCategories_Teenager" name="AgeCategories_Teenager">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="AgeCategories_Teenager">##Teenagers18Years##</label>
                        </p>
                    </div>
                    <div class="s-u-passenger-item no-star  ">
                        <p class="checkboxStations">
                            <input type="checkbox" class="FilterHoteltype" id="AgeCategories_Adult" name="AgeCategories_Adult">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="AgeCategories_Adult">##Adults50Years##</label>
                        </p>
                    </div>
                    <div class="s-u-passenger-item no-star  ">
                        <p class="checkboxStations">
                            <input type="checkbox" class="FilterHoteltype" id="AgeCategories_UltraAdult" name="AgeCategories_UltraAdult">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="AgeCategories_UltraAdult">##Adults100Years##</label>
                        </p>
                    </div>

                </div>
                <div class="s-u-result-item-change col-md-12 d-flex flex-wrap">


                    <div class="s-u-result-item-change m-0">
                        <div class="s-u-passenger-item no-star width100 d-flex flex-wrap gap-10">
                            <span class='w-100 font-weight-bolder'>
                                ##Category##:
                            </span>
                            {foreach $objTour->getTourTypes() as $key=>$type}
                                <div data-name='default-fillable-data' class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                    <p class="align-items-center d-flex flex-wrap">
                                        <input type="checkbox" class="FilterHoteltype"
                                               value="{$type['id']}"
                                               id="TourTypes{$key}" name="TourTypes[]">
                                        <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                               for="TourTypes{$key}">{$type['tour_type']}</label>
                                    </p>
                                </div>
                            {/foreach}

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
{*                            {$default_services|var_dump}*}
                            {foreach $default_services as $key=>$service}
                                <div data-name='default-fillable-data' class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">
                                    <p class="align-items-center d-flex flex-wrap">
                                        <input type="checkbox" class="FilterHoteltype"
                                               value="{$service}"
                                               id="TourService{$key}" name="TourServices[]">
                                        <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"
                                               for="TourService{$key}">{$service}</label>
                                    </p>
                                </div>
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

                {*<div class="s-u-result-item-change">
                    <div class="s-u-passenger-item no-star width50">
                        <label for="tourType" class="flr">##Typetour##:</label>
                        <select name="tourTypeId[]" id="tourTypeId" class="select2" multiple="multiple"
                                onchange="checkForOneDayTour()">
                            {foreach $objBasic->SelectAll('reservation_tour_type_tb') as $tourType}
                                <option value="{$tourType['id']}">{$tourType['tour_type']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="notifications-oneDayTour displayN" id="notificationOneDayTour">
                        <i class="fa fa-commenting-o"></i>##NoAbleToChooseHotelToStay##
                    </div>
                </div>*}

                <div class="s-u-result-item-change">

                    <div class="s-u-passenger-item  no-star">
                        <label for="free" class="flr">##Permissibleamount##:</label>
                        <input type="text" name="free" id="free" value="" placeholder="##Permissibleamount##">
                    </div>

                        <div class="s-u-passenger-item  txt11">
                            <label for="startDate" class="flr">##Datestarthold##:</label>
                            <input type="text" class="{$DeptDatePickerClass}"
                                   name="startDate" id="startDate" value="" autocomplete='off' placeholder="##Datestarthold##">
                        </div>

                        <div class="s-u-passenger-item  txt11">
                            <label for="endDate" class="flr">##Dateendhold##:</label>
                            <input type="text" class="{$ReturnDatePickerClass}"
                                   name="endDate" id="endDate" value="" autocomplete='off' placeholder="##Dateendhold##">
                        </div>


                    <div class="s-u-passenger-item tooltip-tour">
                        <label for="night" class="flr">##NumberOfNightsStay##:</label>
                        <input type="text" name="night" id="night" value="{if $smarty.get.tourType eq 'oneDayTour'}0{/if}" placeholder="##NumberOfNightsStay##"
                               {if $smarty.get.tourType eq 'oneDayTour'}readonly="readonly"{/if}>
                        {if $smarty.get.tourType neq 'oneDayTour'}
                            <span class="tooltipText-tour">##Tourtooltipnight##</span>
                        {/if}

                    </div>

                    <div class="s-u-passenger-item  tooltip-tour">
                        <label for="day" class="flr">##NumberOfDaysOfTravel##:</label>
                        <input type="text" name="day" id="day" value="{if $smarty.get.tourType eq 'oneDayTour'}1{/if}" placeholder="##NumberOfDaysOfTravel##"
                               {if $smarty.get.tourType eq 'oneDayTour'}readonly="readonly"{/if}
                        >
                        {if $smarty.get.tourType neq 'oneDayTour'}
                            <span class="tooltipText-tour">##Tourtooltipday##</span>
                        {/if}

                    </div>

                    {*<div class="s-u-passenger-item width24 no-star">
                        <label for="startTimeLastMinuteTour" class="flr">##StartTimeLastMinuteTour##:</label>
                        <input type="text" name="startTimeLastMinuteTour" id="startTimeLastMinuteTour"
                               placeholder="##StartTimeLastMinuteTour##">
                    </div>*}

                    {if $check_offline neq true}
                        <div class="s-u-passenger-item  no-star">
                            <label for="prepaymentPercentage" class="flr">##Prepaymentpercentage##:</label>
                            <select name="prepaymentPercentage" id="prepaymentPercentage" class="select2">
                                <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                {section name=foo start=0 loop=100 step=10}
                                    <option value="{$smarty.section.foo.index}">{$smarty.section.foo.index}</option>
                                {/section}
                            </select>
                        </div>
                    {/if}

                    <div class="s-u-passenger-item no-star ">
                        <label for="visa" class="flr">##Visa##:</label>
                        <select name="visa" id="visa" class="select2">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                            <option value="yes">##Have##</option>
                            <option value="no">##Donthave##</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star ">
                        <label for="insurance" class="flr">##Insurance##:</label>
                        <select name="insurance" id="insurance" class="select2">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                            <option value="yes">##Have##</option>
                            <option value="no">##Donthave##</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star width100">


                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}

                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh0" name="sh0" value="0">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh0">##Saturday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh1" name="sh1" value="1">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh1">##Sunday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh2" name="sh2" value="2">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh2">##Monday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh3" name="sh3" value="3">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh3">##Tuesday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh4" name="sh4" value="4">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh4">##Wednesday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh5" name="sh5" value="5">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh5">##Thursday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh6" name="sh6" value="6">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh6">##Friday##</label>
                                </p>
                            </div>

                        {else}


                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh1" name="sh1" value="0">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh1">##Sunday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh2" name="sh2" value="1">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh2">##Monday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh3" name="sh3" value="2">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh3">##Tuesday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh4" name="sh4" value="3">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh4">##Wednesday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh5" name="sh5" value="4">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh5">##Thursday##</label>
                                </p>
                            </div>
                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh6" name="sh6" value="5">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh6">##Friday##</label>
                                </p>
                            </div>

                            <div class="s-u-passenger-item no-star width30 ">
                                <p class="checkboxStations">
                                    <input type="checkbox" class="FilterHoteltype" id="sh0" name="sh0" value="6">
                                    <label class="FilterHoteltypeName site-main-text-color-a"
                                           for="sh0">##Saturday##</label>
                                </p>
                            </div>

                        {/if}
                    </div>


                    <div class="s-u-passenger-item no-star width100 {*margin-b-60*}">
                        <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">##Description##</h2>
                        </div>
                        <div class="panel height0 panel-editor">
                                <textarea name="description" id="description" dir="rtl" cols="100" rows="7"
                                          class="{$isEditor} " style="top: 0;"></textarea>
                        </div>
                        {*<label for="description" class="flr">توضیحات:</label>
                        <textarea name="description" id="description" dir="rtl" cols="100" rows="7"
                                  class="{$isEditor}"></textarea>*}
                    </div>

                    <div class="s-u-passenger-item no-star width100">
                        <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                ##Requireddocuments##</h2></div>
                        <div class="panel height0 panel-editor">
                                <textarea name="requiredDocuments" id="requiredDocuments" dir="rtl" cols="40" rows="7"
                                          class="{$isEditor}"></textarea>
                        </div>
                        {*<label for="requiredDocuments" class="flr">مدارک لازم:</label>
                        <textarea name="requiredDocuments" id="requiredDocuments" dir="rtl" cols="40" rows="7"
                                  class="{$isEditor}"></textarea>*}
                    </div>

                    <div class="s-u-passenger-item no-star width100">
                        <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                ##TermsandConditions##</h2>
                        </div>
                        <div class="panel height0 panel-editor">
                                <textarea name="rules" id="rules" dir="rtl" cols="40" rows="7"
                                          class="{$isEditor}"></textarea>
                        </div>
                        {*<label for="rules" class="flr">قوانین و مقررات:</label>
                        <textarea name="rules" id="rules" dir="rtl" cols="40" rows="7" class="{$isEditor}"></textarea>*}
                    </div>

                    <div class="s-u-passenger-item no-star width100">
                        <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                ##Cancellationrules##</h2></div>
                        <div class="panel height0 panel-editor">
                                <textarea name="cancellationRules" id="cancellationRules" dir="rtl" cols="40" rows="7"
                                          class="{$isEditor}"></textarea>
                        </div>
                        {*<label for="cancellationRules" class="flr">قوانین کنسلی:</label>
                        <textarea name="cancellationRules" id="cancellationRules" dir="rtl" cols="40" rows="7"
                                  class="{$isEditor}"></textarea>*}
                    </div>

                    <div class="s-u-passenger-item no-star width100">
                        <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">
                                ##Tourtravelprogram##</h2>
                        </div>
                        <div class="panel height0 panel-editor p-4">
                            <div class="p-4">
                                <div class="BaseTourTravelProgramDays">
                                    <div class="box-type-1 mb-4 pt-4 d-block" data-counter="1" data-file='0'>
                                        <span class="box-type-1-counter site-bg-main-color">1</span>
                                        <span class="box-type-1-close BaseTourTravelProgramClose">
                                            <span class="fa fa-close"></span>
                                        </span>
                                        <span class="box-type-1-go-bot">
                                            <span class="fa fa-arrow-down"></span>
                                        </span>
                                        <div class="form-row mt-2">
                                            <div class="form-group col-md-12">
                                                <div class="s-u-passenger-item no-star w-100">
                                                    <label for="TourTravelProgramTitle" class="flr"> ##Title##:</label>
                                                    <input type="text" name="TourTravelProgram[day][0][title]"
                                                           id="TourTravelProgramTitle" value=""
                                                           placeholder="##Title## ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-5">
                                            <div class="form-group col-md-12">
                                                <div class="s-u-passenger-item no-star w-100">
                                                    <label for="TourTravelProgramBody" class="flr"> ##Body##:</label>
                                                    <textarea rows="10" name="TourTravelProgram[day][0][body]"
                                                              id="TourTravelProgramBody" dir="rtl"
                                                              cols="40"
                                                              class="w-100"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="BaseTourTravelProgramGalleryPicker form-row">

                                            <div class="box-galery-picker-1 form-group col-md-3 galleryForCloneJs">
                                                <div class="s-u-passenger-item no-star w-100">
                                                    <span class="box-type-1-close BaseTourTravelProgramGalleryPickerClose">
                                                    <span class="fa fa-close"></span>
                                                </span>
                                                    <div class="form-group">
                                                        <label class="text text-right d-block"
                                                               for="TourTravelProgramGalleryTitle">##Gallery##:</label>
                                                        <input type="text" name="TourTravelProgram[day][0][gallery][][title]"
                                                               id="TourTravelProgramGalleryTitle" value=""
                                                               placeholder="##Title##">
                                                    </div>
                                                    <div class="form-group custom-file">
                                                        <input type="file"
                                                               class="custom-file-input inputFilePreview"
                                                               name="TourTravelProgram[day][0][gallery][][file]" id="filepdf">
                                                        <label class="custom-file-label"
                                                               for="filepdf">##Gallery##:</label>
                                                    </div>
                                                    <div class="form-group border rounded-lg text-center p-3">
                                                        <img src="//placehold.it/140?text=IMAGE"
                                                             class="img-fluid divFilePreview"/>
                                                    </div>
                                                </div>
                                            </div>
{*                                            <div class='d-none'>*}
{*                                                <div class="box-galery-picker-1 form-group col-md-3 galleryForCloneJs">*}
{*                                                    <div class="s-u-passenger-item no-star w-100">*}
{*                                                        <span class="box-type-1-close BaseTourTravelProgramGalleryPickerClose">*}
{*                                                        <span class="fa fa-close"></span>*}
{*                                                              </span>*}
{*                                                        <div class="form-group">*}
{*                                                            <label class="text text-right d-block"*}
{*                                                                   for="TourTravelProgramGalleryTitle00">##Gallery##:</label>*}
{*                                                            <input type="text"*}
{*                                                                   name="TourTravelProgram[day][0][gallery][0][title]"*}
{*                                                                   id="TourTravelProgramGalleryTitle00"*}
{*                                                                   value=""*}
{*                                                                   placeholder="##Title##">*}
{*                                                        </div>*}
{*                                                        <div class="form-group custom-file">*}
{*                                                            <input type="file"*}
{*                                                                   class="custom-file-input inputFilePreview"*}
{*                                                                   name="TourTravelProgram[day][0][gallery][0][file]"*}
{*                                                                   value=""*}
{*                                                                   id="filepdf">*}
{*                                                            <input type="hidden"*}
{*                                                                   value=""*}
{*                                                                   name="TourTravelProgram[day][0][gallery][0][file_hidden]">*}
{*                                                            <label class="custom-file-label"*}
{*                                                                   for="filepdf">##Gallery##:</label>*}
{*                                                        </div>*}
{*                                                        <div class="form-group border rounded-lg text-center p-3">*}
{*                                                            <img src=""*}
{*                                                                 class="img-fluid divFilePreview" />*}
{*                                                        </div>*}
{*                                                    </div>*}
{*                                                </div>*}

{*                                            </div>*}
                                            <div class="makeAnotherImage_Js newImageLogo form-group col-md-3">
                                                <div class="s-u-passenger-item no-star w-100">
                                                    <div class="form-group">
                                                        <span class="fa fa-plus"></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 d-block mt-4">
                                    <button type="button" class="btn btn-primary makeAnotherDay_Js">
                                        <span class="fa fa-plus-square"></span>
                                        ##AddDay##
                                    </button>
                                    <div class="d-block mt-3 BaseTourTravelProgramBadge ">
                                        <button class="btn badge-secondary mr-2" data-counter="1" type="button">1</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {*<label for="travelProgram" class="flr">برنامه سفر تور:</label>
                        <textarea rows="10" name="travelProgram" id="travelProgram" dir="rtl" cols="40"
                                  class="{$isEditor}"></textarea>*}
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
                               accept="image/x-png, image/gif, image/jpeg, image/jpg"/>
                    </div>
                    <div class="notifications-upload-image width75">
                        <span><i class="fa fa-angle-double-left"></i>##Photodisplayedresult##</span>
                        <span><i class="fa fa-angle-double-left"></i> ##Selectedfileextension##: <b>.jgp,</b><b> .jpeg,</b><b> .gif,</b><b> png</b></span>
                        <span><i class="fa fa-angle-double-left"></i>##Capacityimage## <b>1MB</b> ##Do##</span>
                    </div>
                </div>
                <div class="s-u-result-item-change">
                    <div class="s-u-passenger-item no-star">
                        <label for="tourCover" class="flr">##CoverImage##:</label>
                        <input type="file" name="tourCover" id="tourCover"
                               accept="image/x-png, image/jpeg, image/jpg"/>
                    </div>
                    <div class="notifications-upload-image width75">
                         <span><i class="fa fa-angle-double-left"></i> ##ImageSizeDescription##: <b>5.6</b> ##Or## <b style='unicode-bidi: plaintext; direction: ltr;'> 1423 × 250 px</b></span>
                        <span><i class="fa fa-angle-double-left"></i>##Capacityimage## <b>2MB</b> ##Do##</span>
                    </div>
                </div>
                <div class="s-u-result-item-change">
                    <div class="s-u-passenger-item no-star">
                        <label for="tourFile" class="flr">##Package##:</label>
                        <input type="file" name="tourFile" id="tourFile" multiple data-height="100"
                               accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf"
                               data-default-file=""/>
                    </div>
                    <div class="notifications-upload-image width75">
                        <span><i class="fa fa-angle-double-left"></i> ##Selectedfileextension##: <b>.pdf,</b><b> .jgp,</b><b> .jpeg,</b><b> .gif,</b><b> png</b></span>
                        <span><i class="fa fa-angle-double-left"></i>##Capacityimage## <b>1MB</b> ##Do##</span>
                    </div>
                </div>
                <div class="s-u-result-item-change">
                    <div class="s-u-passenger-item no-star">
                        <label for="tourVideo" class="flr">##Video##:</label>
                        <input type="text" name="tourVideo" id="tourVideo"   multiple data-height="100"/>
                    </div>
                    <div class="notifications-upload-image width75">
                        <span><i class="fa fa-angle-double-left"></i>##videoIframeLink##</span>

                    </div>
                </div>
            </div>
        </div>


        <div class="main-Content-top s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="fa fa-file-image-o zmdi-hc-fw mart5"></i>##CustomRequiredAssets##
                </span>
            <div class="d-flex flex-wrap panel-default-change p-4 site-border-main-color">



                <div onclick="addCustomFile($(this))" class="align-items-center col-md-3 plus-btn d-flex flex-wrap justify-content-center dashed-3 site-border-main-color">
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

                    <div class="s-u-passenger-item ">
                        <label for="originContinent1" class="flr">##Continent## (##Origin##):</label>
                        <select name="originContinent1" id="originContinent1"
                                class="select2" onchange="fillComboCountry('1', 'origin')">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                            <option value="1">##Asia##</option>
                            <option value="2">##Europe##</option>
                            <option value="3">##America##</option>
                            <option value="4">##Australia##</option>
                            <option value="5">##Africa##</option>
                            <option value="6">##Oceania##</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item">
                        <label for="originCountry1" class="flr">##Country## (##Origin##):</label>
                        <select name="originCountry1" id="originCountry1"
                                class="select2" onchange="fillComboCity('1', 'origin')">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item">
                        <label for="originCity1" class="flr">##City## (##Origin##):</label>
                        <select name="originCity1" id="originCity1"
                                class="select2" onchange="fillComboRegion('1', 'origin')">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star">
                        <label for="originRegion1" class="flr">##Area## (##Origin##):</label>
                        <select name="originRegion1" id="originRegion1" class="select2">
                            <option value="" disabled="disabled" selected>##ChoseOption##</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>


        <div class="main-Content-top s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="fa fa-check zmdi-hc-fw mart5"></i>##Travelroute##
            </span>
            <div class="panel-default-change site-border-main-color">
                <div class="s-u-result-item-change">

                    <div id="rowRout">
                        <div id="rowAnyRout1" class="rowAnyRout bg-light-blue overflow-hidden rounded route_box ">

                            <div class="rout-number">##Firstdestination##</div>

                        <div class='rowAnyRouteBox'>
                            <input type="hidden" name="tourTitle1" id="tourTitle1"
                                   data-values="name,id"
                                   data-name="tourTitle"
                                   class='change_counter_js'
                                   value="dept">

                            <div class="s-u-passenger-item ">
                                <label for="night1"  data-values="for"
                                       data-name="night"
                                       class="flr change_counter_js">##Countnight##:</label>
                                <input type="text" name="night1" id="night1"

                                       data-values="name,id"
                                       data-name="night"
                                       class='change_counter_js'
                                       value="" placeholder="##Countnight##">
                            </div>

                            {*<div class="s-u-passenger-item width10 no-star">
                                <label for="day1" class="flr">##Countday##:</label>
                                <input type="text" name="day1" id="day1" value="" placeholder="##Countday##">
                            </div>*}

                            <div class="s-u-passenger-item ">
                                <label data-values="for" data-name="destinationContinent"
                                       for="destinationContinent1" class="flr change_counter_js">##Continent##
                                    (##Destination##):</label>
                                <select name="destinationContinent1" id="destinationContinent1"
                                        data-name="destinationContinent"
                                        data-values="name,id,data-counter"
                                        data-counter="1"
                                        class="select2 change_counter_js" onchange="fillComboCountryByDataAttr($(this), 'destination')">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                    <option value="1">##Asia##</option>
                                    <option value="2">##Europe##</option>
                                    <option value="3">##America##</option>
                                    <option value="4">##Australia##</option>
                                    <option value="5">##Africa##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item">
                                <label data-values="for" data-name="destinationCountry"
                                       for="destinationCountry1" class="flr">##Country## (##Destination##):</label>
                                <select name="destinationCountry1" id="destinationCountry1"
                                        data-values="name,id,data-counter"
                                        data-name="destinationCountry"
                                        data-counter="1"
                                        class="select2 change_counter_js" onchange="fillComboCityByDataAttr($(this), 'destination')">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item ">
                                <label data-values="for" data-name="destinationCity"
                                       for="destinationCity1" class="flr">##City## (##Destination##):</label>
                                <select name="destinationCity1"
                                        data-values="name,id,data-counter"
                                        data-counter="1"
                                        data-name="destinationCity"
                                        id="destinationCity1"
                                        class="select2 change_counter_js" onchange="fillComboRegionByDataAttr($(this), 'destination')">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item no-star ">
                                <label data-values="for" data-name="destinationRegion"
                                       for="destinationRegion1" class="flr change_counter_js">##Area## (##Destination##):</label>
                                <select name="destinationRegion1"
                                        data-values="name,id"
                                        data-name="destinationRegion"
                                        id="destinationRegion1" class="select2 change_counter_js">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item">
                                <label data-values="for" data-name="typeVehicle"
                                       for="typeVehicle1" class="flr change_counter_js">##Vehicletype##:</label>
                                <select name="typeVehicle1"
                                        data-values="name,id,data-counter"
                                        data-name="typeVehicle"
                                        data-counter="1"
                                        id="typeVehicle1" class="select2 change_counter_js"
                                        onchange="listAirlineByDataAttr($(this))">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                    {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                                        <option value="{$typeVehicle['id']}">{$typeVehicle['name']}</option>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="s-u-passenger-item">
                                <label data-values="for" data-name="airline"
                                       for="airline1" class="flr change_counter_js">##Shippingcompany##:</label>
                                <select name="airline1"
                                        data-values="name,id"
                                        data-name="airline"
                                        id="airline1" class="select2 change_counter_js">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item  no-star">
                                <label data-values="for" data-name="class"
                                       for="class1" class="flr change_counter_js">##Classrate##:</label>
                                <select name="class1"
                                        data-values="name,id"
                                        data-name="class"
                                        id="class1" class="select2 change_counter_js">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                    {foreach $objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade}
                                        <option value="{$vehicleGrade['name']}">{$vehicleGrade['name']}</option>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="s-u-passenger-item  no-star txt11">
                                <label data-values="for" data-name="exitHours"
                                       for="exitHours1" class="flr change_counter_js">##Starttime## (##Hour##):</label>
                                <select name="exitHours1"
                                        data-values="name,id"
                                        data-name="exitHours"
                                        id="exitHours1" class="form-control change_counter_js">
                                    {for $n=0 to 9}
                                        <option value="0{$n}">0{$n}</option>
                                    {/for}
                                    {for $n=10 to 24}
                                        <option value="{$n}">{$n}</option>
                                    {/for}
                                </select>
                            </div>

                            <div class="s-u-passenger-item  no-star txt11">
                                <label data-values="for" data-name="exitMinutes"
                                       for="exitMinutes1" class="flr change_counter_js">##Starttime## (##Minutes##):</label>
                                <select name="exitMinutes1"
                                        data-values="name,id"
                                        data-name="exitMinutes"
                                        id="exitMinutes1" class="form-control change_counter_js">
                                    {for $n=0 to 9}
                                        <option value="0{$n}">0{$n}</option>
                                    {/for}
                                    {for $n=10 to 60}
                                        <option value="{$n}">{$n}</option>
                                    {/for}
                                </select>
                            </div>

                            <div class="s-u-passenger-item  no-star">
                                <label data-values="for" data-name="hours"
                                       for="hours1" class="flr change_counter_js">##Periodoftime## (##Hour##):</label>
                                <select name="hours1"
                                        data-values="name,id"
                                        data-name="hours"
                                        id="hours1" class="form-control change_counter_js">
                                    {for $n=0 to 9}
                                        <option value="0{$n}">0{$n}</option>
                                    {/for}
                                    {for $n=10 to 24}
                                        <option value="{$n}">{$n}</option>
                                    {/for}
                                </select>
                            </div>

                            <div class="s-u-passenger-item  no-star">
                                <label data-values="for" data-name="minutes"
                                       for="minutes1" class="flr change_counter_js">##Periodoftime## (##Minutes##):</label>
                                <select name="minutes1"
                                        data-values="name,id"
                                        data-name="minutes"
                                        id="minutes1" class="form-control change_counter_js">
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
                                       for="is_route_fake1" class="flr change_counter_js">##showInResult##</label>
                                <select name="is_route_fake1"
                                        data-values="name,id"
                                        data-name="is_route_fake"
                                        id="is_route_fake1" class="form-control change_counter_js">

                                        <option value="1">##show##</option>
                                        <option value="0">##NotShow##</option>
                                </select>
                            </div>
                        </div>
                        </div>
                    </div>
                    <input type="hidden" value="1" name="countRowAnyDeptRout" id="countRowAnyDeptRout"/>
                    <div class="tour-btn-add" onclick="insertRowRout('rowRout')">
                        <span class="addRowRoute"></span>
                        <span class="addRowTXT">##Addnextdestination##</span>
                    </div>


                    <div class="clear"></div>
                    <div id="rowReturnRoute">
                        <div id="rowAnyRout2" class="rowAnyRout bg-light-blue overflow-hidden rounded route_box ">

                            <input type="hidden" name="tourTitle2" id="tourTitle2"
                                   data-values="name,id"
                                   data-name="tourTitle"
                                   class='change_counter_js'
                                   value="return">
                            <div class="rout-number divDeleteRow">
                                <div class="rout-number-50">
                                    <span>##Destinationreturned##</span>
                                </div>
                                <div class="rout-number-50"></div>
                            </div>
                            <input type="hidden" name="night2" id="night2"
                                   data-values="name,id"
                                   data-name="night"
                                   class='change_counter_js' value="0">

                            <input type="hidden" name="day2" id="day2"
                                   data-values="name,id"
                                   data-name="day"
                                   class='change_counter_js' value="0">
                            <div class='rowAnyRouteBox'>
                                <div class="s-u-passenger-item width25">
                                    <label data-values="for" data-name="destinationContinent"
                                           for="destinationContinent2" class="flr change_counter_js">##Continent##
                                        (##Destination##):</label>
                                    <select name="destinationContinent2"
                                            data-name="destinationContinent"
                                            data-values="name,id,data-counter"
                                            data-counter="2"
                                            id="destinationContinent2"
                                            class="select2 change_counter_js"
                                            onchange="fillComboCountryByDataAttr($(this), 'destination')">
                                        <option value="" disabled="disabled" selected="">##ChoseOption##</option>
                                        <option value="1">##Asia##</option>
                                        <option value="2">##Europe##</option>
                                        <option value="3">##America##</option>
                                        <option value="4">##Australia##</option>
                                        <option value="5">##Africa##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item width25">
                                    <label data-values="for" data-name="destinationCountry"
                                           for="destinationCountry2" class="flr change_counter_js">##Country## (##Destination##):</label>
                                    <select name="destinationCountry2" id="destinationCountry2"
                                            data-values="name,id,data-counter"
                                            data-name="destinationCountry"
                                            class="select2 change_counter_js"
                                            data-counter="2"
                                            onchange="fillComboCityByDataAttr($(this), 'destination')">
                                        <option value="" disabled="disabled" selected="">##ChoseOption##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item width25">
                                    <label data-values="for" data-name="destinationCity"
                                           for="destinationCity2" class="flr change_counter_js">##City## (##Destination##):</label>
                                    <select name="destinationCity2" id="destinationCity2"
                                            data-values="name,id,data-counter"
                                            data-name="destinationCity"
                                            data-counter="2"
                                            class="select2 change_counter_js"
                                            onchange="fillComboRegionByDataAttr($(this), 'destination')">
                                        <option value="" disabled="disabled" selected="">##ChoseOption##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item no-star width25">
                                    <label data-values="for" data-name="destinationRegion"
                                           for="destinationRegion2" class="flr change_counter_js">##Area## (##Destination##):</label>
                                    <select name="destinationRegion2" id="destinationRegion2"
                                            data-values="name,id"
                                            data-name="destinationRegion"
                                            class="select2 change_counter_js">
                                        <option value="" disabled="disabled" selected="">##ChoseOption##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item">
                                    <label data-values="for" data-name="typeVehicle" for="typeVehicle2" class="flr change_counter_js">##Vehicletype##:</label>
                                    <select name="typeVehicle2" id="typeVehicle2"
                                            data-values="name,id,data-counter"
                                            data-counter="2"
                                            data-name="typeVehicle"
                                            class="select2 change_counter_js"
                                            onchange="listAirlineByDataAttr($(this))">
                                        <option value="" disabled="disabled" selected="">##ChoseOption##</option>
                                        {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                                            <option value="{$typeVehicle['id']}">{$typeVehicle['name']}</option>
                                        {/foreach}
                                    </select>
                                </div>

                                <div class="s-u-passenger-item">
                                    <label data-values="for" data-name="airline" for="airline2" class="flr change_counter_js">##Shippingcompany##:</label>
                                    <select name="airline2" id="airline2"
                                            data-values="name,id"
                                            data-name="airline"
                                            class="select2 change_counter_js">
                                        <option value="" disabled="disabled" selected="">##ChoseOption##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item no-star ">
                                    <label data-values="for" data-name="class" for="class2" class="flr change_counter_js">##Classrate##:</label>
                                    <select name="class2" id="class2"
                                            data-values="name,id"
                                            data-name="class"
                                            class="select2 change_counter_js">
                                        <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                        {foreach $objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade}
                                            <option value="{$vehicleGrade['name']}">{$vehicleGrade['name']}</option>
                                        {/foreach}
                                    </select>
                                </div>

                                <div class="s-u-passenger-item no-star  txt11">
                                    <label data-values="for" data-name="exitHours" for="exitHours2" class="flr change_counter_js">##Starttime## (##Hour##):</label>
                                    <select name="exitHours2" id="exitHours2"
                                            data-values="name,id"
                                            data-name="exitHours"
                                            class="form-control change_counter_js">
                                        {for $n=0 to 9}
                                            <option value="0{$n}">0{$n}</option>
                                        {/for}
                                        {for $n=10 to 24}
                                            <option value="{$n}">{$n}</option>
                                        {/for}
                                    </select>
                                </div>

                                <div class="s-u-passenger-item no-star  txt11">
                                    <label data-values="for" data-name="exitMinutes" for="exitMinutes2" class="flr change_counter_js">##Starttime## (##Minutes##):</label>
                                    <select name="exitMinutes2" id="exitMinutes2"
                                            data-values="name,id"
                                            data-name="exitMinutes"
                                            class="form-control change_counter_js">
                                        {for $n=0 to 9}
                                            <option value="0{$n}">0{$n}</option>
                                        {/for}
                                        {for $n=10 to 60}
                                            <option value="{$n}">{$n}</option>
                                        {/for}
                                    </select>
                                </div>

                                <div class="s-u-passenger-item no-star ">
                                    <label data-values="for" data-name="hours" for="hours2" class="flr change_counter_js">##Periodoftime## (##Hour##):</label>
                                    <select name="hours2" id="hours2"
                                            data-values="name,id"
                                            data-name="hours"
                                            class="form-control change_counter_js">
                                        {for $n=0 to 9}
                                            <option value="0{$n}">0{$n}</option>
                                        {/for}
                                        {for $n=10 to 24}
                                            <option value="{$n}">{$n}</option>
                                        {/for}
                                    </select>
                                </div>

                                <div class="s-u-passenger-item no-star ">
                                    <label data-values="for" data-name="minutes" for="minutes2" class="flr change_counter_js">##Periodoftime## (##Minutes##):</label>
                                    <select name="minutes2" id="minutes2"
                                            data-values="name,id"
                                            data-name="minutes"
                                            class="form-control change_counter_js">
                                        {for $n=0 to 9}
                                            <option value="0{$n}">0{$n}</option>
                                        {/for}
                                        {for $n=10 to 60}
                                            <option value="{$n}">{$n}</option>
                                        {/for}
                                    </select>
                                </div>

                            </div>

                            {*<div id="rowHotel2" class="rowAnyHotel"></div>
                            <input type="hidden" value="0" name="countRowAnyHotel2" id="countRowAnyHotel2">
                            <div class="tour-btn-add displayNone" id="btn-row-hotel2" onclick="insertRowHotel('2')">
                                <span class="addRowHotel"></span>
                                <span class="addRow"></span>
                                <span class="addRowTXT">اضافه کردن هتل</span>
                            </div>*}

                        </div>
                    </div>
                    <input type="hidden" value="1" name="countRowAnyReturnRout" id="countRowAnyReturnRout"/>
                    {*<div id="btnReturnRoute" class="tour-btn-add" onclick="insertRowRout('rowReturnRoute')">
                        <span class="addRowRouteReturn"></span>
                        <span class="addRowTXT">اضافه کردن مسیر برگشت به مبدا</span>
                    </div>*}


                    <input type="hidden" value="2" name="countRowAnyRout" id="countRowAnyRout"/>
                </div>
                <div class="clear"></div>

            </div>
            <div class="clear"></div>

        </div>
        <div class="clear"></div>



        <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnFirst">
{*            <div class="col-3 mx-auto">*}
                <button type="submit"  data-loading-title='Loading'
                        class="btn btn-success tour-register-button">##Next##</button>
            {*</div>*}
        </div>

    </form>


    <form id='tourPackageForm' name="tourPackageForm" method='post'
          data-toggle="validator" enctype='multipart/form-data' action="{$smarty.const.ROOT_ADDRESS}/tour_ajax.php">
        <input type="hidden" name="flag" id="flag" value="tourPackageInsert"/>
        <input type="hidden" name="flagSecond" id="flagSecond" value=""/>
        <input type="hidden" name="fk_tour_id" id="fk_tour_id" value=""/>
        <input type="hidden" name="id_same" id="id_same" value=""/>


        <div class="displayN" id="tourPackage">


{*            <div class="main-Content-top s-u-passenger-wrapper-change">*}
{*            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">*}
{*                <i class="fa fa-exclamation mart5  zmdi-hc-fw"></i>##Note##*}
{*            </span>*}
{*                <div class="s-u-result-wrapper">*}
{*                        <span class="s-u-result-item-change direcR iranR txt14 txtRed"> ##Dearagency## {$smarty.const.CLIENT_NAME}*}
{*                            ##Pleaseenteryourpricesbased##</span>*}
{*                </div>*}
{*            </div>*}

            <div class="main-Content-top s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="fa fa-check zmdi-hc-fw mart5"></i>##Package##
                </span>
                <div class="panel-default-change site-border-main-color">
                    <div class="s-u-result-item-change">

                        <div id="rowPackage"></div>

                        <div class="clear"></div>
                        <input type="hidden" value="0" name="countPackage" id="countPackage"/>
                        <div class="tour-btn-add" id="btn-row-hotel" onclick="insertRowPackage()">
                            <span class="addRowHotel"></span>
                            <span class="addRow"></span>
                            <span class="addRowTXT">##Addnextpackage##</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        {if $smarty.get.tourType eq 'oneDayTour'}
            <div class="displayN" id="oneDayTour">
                {load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
                <div class="main-Content-top s-u-passenger-wrapper-change">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                        <i class="fa fa-check zmdi-hc-fw mart5"></i>##price## ##Onetour##
                    </span>

                    <div class="panel-default-change site-border-main-color">
                        <div class="s-u-result-item-change">

                            <div class="s-u-passenger-item">
                                <label for="adultPriceOneDayTourR" class="flr">##Priceadult## (##Riali##):</label>
                                <input type="text" name="adultPriceOneDayTourR" id="adultPriceOneDayTourR"
                                       placeholder="##Priceadult## ##Riali##" onkeypress="isDigit(this)"
                                       onkeyup="javascript:separator(this);">
                            </div>

                            <div class="s-u-passenger-item">
                                <label for="childPriceOneDayTourR" class="flr">##Pricechild## (##Riali##):</label>
                                <input type="text" name="childPriceOneDayTourR" id="childPriceOneDayTourR"
                                       placeholder="##Pricechild## ##Riali##" onkeypress="isDigit(this)"
                                       onkeyup="javascript:separator(this);">
                            </div>

                            <div class="s-u-passenger-item">
                                <label for="infantPriceOneDayTourR" class="flr">##Pricebaby## (##Riali##):</label>
                                <input type="text" name="infantPriceOneDayTourR" id="infantPriceOneDayTourR"
                                       placeholder="##Pricebaby## ##Riali##" onkeypress="isDigit(this)"
                                       onkeyup="javascript:separator(this);">
                            </div>

                        </div>
                        <div class="s-u-result-item-change">

                            <div class="s-u-passenger-item">
                                <label for="adultPriceOneDayTourA" class="flr">##Priceadult## (##currency##):</label>
                                <input type="text" name="adultPriceOneDayTourA" id="adultPriceOneDayTourA"
                                       placeholder="##Priceadult## ##currency##" onkeypress="isDigit(this)"
                                       onkeyup="javascript:separator(this);">
                            </div>

                            <div class="s-u-passenger-item">
                                <label for="childPriceOneDayTourA" class="flr">##Pricechild## (##currency##):</label>
                                <input type="text" name="childPriceOneDayTourA" id="childPriceOneDayTourA"
                                       placeholder="##Pricechild## ##currency##" onkeypress="isDigit(this)"
                                       onkeyup="javascript:separator(this);">
                            </div>

                            <div class="s-u-passenger-item">
                                <label for="infantPriceOneDayTourA" class="flr">##Pricebaby## (##currency##):</label>
                                <input type="text" name="infantPriceOneDayTourA" id="infantPriceOneDayTourA"
                                       placeholder="##Pricebaby## ##currency##" onkeypress="isDigit(this)"
                                       onkeyup="javascript:separator(this);">
                            </div>

                            <div class="s-u-passenger-item">
                                <label for="currencyTypeOneDayTour" class="flr">##Typecurrency##:</label>
                                <select name="currencyTypeOneDayTour" id="currencyTypeOneDayTour" class="select2">
                                    <option value="" disabled="disabled" selected>##ChoseOption##</option>
                                    {foreach $objCurrency->ListCurrencyEquivalent() as $currency}
                                        <option value="{$currency['CurrencyCode']}">{$currency['CurrencyTitle']}</option>
                                    {/foreach}
                                </select>
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


                                    {foreach $objCounterType->list as $counter_key=>$counter_type}

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
                                                           name="{$entry.index}{$counter_key}"
                                                           id="{$entry.index}{$counter_key}"
                                                           onkeypress="isDigit(this)"
                                                           class="form-control font-12"
                                                           onkeyup="javascript:separator(this);"
                                                           value=""
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
        {/if}

        <div class="userProfileInfo-btn userProfileInfo-btn-change displayN" id="btnSecond">
            <div class="col-3 mx-auto">
                <button type="submit" data-loading-title='Loading'
                        class="btn btn-success tour-register-package-button">##Register## </button>
            </div>
        </div>

    </form>

    <div id='ModalPublicContent2' class='my-modal'></div>

    













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
            $(document).ready(function () {



                $("body").delegate(".makeAnotherDay_Js", "click", function () {
                    $('.box-type-1:first-child').clone().insertAfter('.BaseTourTravelProgramDays .box-type-1:last-child');
                    $('.BaseTourTravelProgramBadge button:first-child').clone().insertAfter('.BaseTourTravelProgramBadge button:last-child');
                    var lengthDives = $('.box-type-1').length;
                    var lengthDivesForIndex = lengthDives-1;
                    $('.box-type-1:last-child input').each(function () {
                      $(this).val('')
                        $(this).attr('name',$(this).attr('name').replace(/\[0]/g, '['+lengthDivesForIndex+']'));
                    });
                    $('.box-type-1:last-child textarea').each(function () {
                      $(this).val('')
                        $(this).attr('name',$(this).attr('name').replace(/\[0]/g, '['+lengthDivesForIndex+']'));
                    });
                    let count = 0 ;
                    $('.box-type-1:last-child .box-galery-picker-1').each(function () {
                       if(count != 0 ){
                         $(this).remove()
                       }else{
                         $(this).find('input').val('')
                       }
                      count = count + 1 ;
                    });

                    $('.box-type-1:last-child #TourTravelProgramBody').attr('id',$('.box-type-1:last-child #TourTravelProgramBody').attr('id')+lengthDives).css({"display":"block"});
                    $('#TourTravelProgramDays').val(lengthDives);
                    $('.box-type-1:last-child').find('textarea').prev().remove();
                    $('.box-type-1:last-child').find('img').attr('src','//placehold.it/140?text=IMAGE');
                    $('.box-type-1:last-child .box-type-1-counter').html(lengthDives);
                    $('.box-type-1:last-child').attr('data-counter',lengthDives);
                    $('.BaseTourTravelProgramBadge button:last-child').attr('data-counter',lengthDives).html(lengthDives);
                    tinymce.init({
                        selector: ".setToEditor"
                    });
                    $.smoothScroll({
                        scrollTarget: '[data-counter='+lengthDives+']',
                        offset: -75
                    });
                });
                // $("body").delegate(".makeAnotherImage_Js", "click", function () {
                //     $(this).parent(".box-type-1").remove();
                // })



                $("body").delegate(".BaseTourTravelProgramBadge button", "click", function () {
                    $.smoothScroll({
                        scrollTarget: '[data-counter='+$(this).attr("data-counter")+']',
                        offset: -75
                    });
                });
                $("body").delegate(".box-type-1-go-bot", "click", function () {
                    $.smoothScroll({
                        scrollTarget: '.makeAnotherDay_Js',
                        offset: -75
                    });
                });
                $("body").delegate(".makeAnotherImage_Js", "click", function () {
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
                });
                $("body").delegate(".BaseTourTravelProgramGalleryPickerClose", "click", function () {
                    // let box = $(this).parents(".box-galery-picker-1").remove();
                    let box = $(this).parents(".box-galery-picker-1")
                    let count = box.parent(".BaseTourTravelProgramGalleryPicker").children().length;
                    if(count > 2) {
                      let file_count =  $(this).parents(".box-type-1").attr('data-file') ;
                      var lengthDivesForIndex = --file_count;
                      $(this).parents(".box-type-1").attr('data-file' , lengthDivesForIndex);
                      box.remove();
                    }
                });
                $("body").delegate(".BaseTourTravelProgramClose", "click", function () {
                    $('.BaseTourTravelProgramBadge button[data-counter='+$(this).parents(".box-type-1").attr('data-counter')+']').remove();
                    $(this).parents(".box-type-1").remove();
                    var lengthDives = $('.box-type-1').length;
                    $('#TourTravelProgramDays').val(lengthDives);
                });
                $("body").delegate(".inputFilePreview", "change", function () {
                    var thiss = $(this);
                    var input = $(this)[0];
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            thiss.parent().parent().find('.divFilePreview').attr('src', e.target.result).fadeIn('slow');
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                });
            });
            var acc = document.getElementsByClassName("accordion");
            var i;
            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function () {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.maxHeight) {
                        panel.style.maxHeight = null;
                    } else {
                        // panel.style.maxHeight = panel.scrollHeight + "px";
                        panel.style.maxHeight = "100%";
                    }
                });
            }
        </script>
    {/literal}

    {else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
            ##Pleaselogin##
        </div>
    </div>
    {/if}
</div>


{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
                </div>
            </div>
        </div>
    </section>
</main>
{/if}

<script src="assets/js/profile.js"></script>