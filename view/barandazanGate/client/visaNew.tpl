{load_presentation_object filename="visa" assign="objVisa"}

{assign var="visaOptionByKeyArray" value=['clientID'=>$smarty.const.CLIENT_ID,'key'=>'marketPlace']}
{assign var="visaOptionByKey" value=$objVisa->visaOptionByKey($visaOptionByKeyArray)}

{if $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and $visaOptionByKey['value'] eq 'available'}

{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}

{load_presentation_object filename="reservationTour" assign="objResult"}


{load_presentation_object filename="country" assign="objCountry"}
{*{load_presentation_object filename="currency" assign="objCurrencyList"}*}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
{assign var="continents" value=$objCountry->continentsList()}

{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}

{assign var="visaOptionByKeyArray" value=['clientID'=>$smarty.const.CLIENT_ID,'key'=>'apiDetail']}
{assign var="visaApiDetailOption" value=$objVisa->visaOptionByKey($visaOptionByKeyArray)}

{assign var="getIsEditor" value=$objResult->isEditor('editor')}
{if $getIsEditor[0]['enable'] eq '1'}
    {assign var="isEditor" value="setToEditor"}
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

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`visaPanelLinks.tpl"}

    <style>
        .dir-l {
            direction: ltr;
        }
    </style>


    <form id="visaAdd" method="post">
        <input type="hidden" name="flag" value="visaAdd">
        <input type="hidden" name="visaCount" value="1">
        <input type="hidden" name="pageType" value="client">
        <input type="hidden" name="clientID" value="{$smarty.const.CLIENT_ID}">


        <div class="col-md-12 mb-4 bg-white p-3 section_visanew">
            <div class="form-row w-100 d-flex align-content-center justify-content-center">
                <div class="col-md-4 mb-4">
                    <label for="continent" class="control-label font-13 mb-2">قاره</label>
                    <select required class="form-control select2" id="continent" name="continent">
                        <option value="">لطفا قاره را انتخاب نمایید</option>
                        {foreach $continents as $each}
                            <option value="{$each.id}">{$each.titleFa}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col-md-4 mb-4">
                    <label for="countryCode" class="control-label font-13 mb-2">کشور</label>
                    <select required class="form-control select2" id="countryCode" name="countryCode"></select>
                </div>

            </div>
        </div>

        {if $visaApiDetailOption['value'] == 'disabled'}
            <div class="col-md-12 mb-4 bg-white p-3 section_visanew">
                <div class="custom-control custom-switch ">
                    <input type="checkbox" class="custom-control-input" name="OnlinePayment"
                           id="OnlinePayment">
                    <label class="custom-control-label" for="OnlinePayment">درخواست مشتری به همراه پرداخت آنلاین</label>
                </div>
            </div>
        {/if}

        <div data-name="baseAddVisa" class="col-md-12 p-0">
            <div data-name="addVisaItem" data-count="1"
                 class="animationFadeIn col-md-12 bg-white p-3 mb-4 visanew_sec">
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                        <label for="visaTypeID" class="control-label font-13 mb-2">نوع ویزا</label>
                        <select class="form-control"
                                required="required"
                                data-id="visaTypeID"
                                id="visaTypeID" name="visaTypeID[]">
                            <option>لطفا نوع ویزا را انتخاب نمایید</option>
                            {*{$each|print_r}*}
                            {foreach $visaTypeList as $each}
                                <option value="{$each.id}">{$each.title}</option>
                            {/foreach}
                        </select>

                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="title"
                               class="control-label font-13 ">عنوان ویزا</label>
                        <input onchange="addPlanName($(this))" onkeyup="addPlanName($(this))" type="text" name="title[]"
                               class="form-control"
                               data-id="title"
                               required="required"
                               id="title"
                               placeholder="مثال : ویزای توریستی ترکیه">
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="deadline" class="control-label font-13 mb-2">زمان تحویل</label>
                        <input type="text" class="form-control"
                               data-id="deadline"
                               id="deadline" name="deadline[]"
                               required="required"
                               placeholder="مثال : 2 روزه">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="validityDuration" class="control-label font-13 mb-2">مدت اعتبار</label>
                        <input type="text" class="form-control"
                               data-id="validityDuration"
                               id="validityDuration" name="validityDuration[]"
                               required="required"
                               placeholder="مثال : 30 روز">
                    </div>


                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                        <label for="allowedUseNo" class="control-label font-13 mb-2">تعداد دفعات مجاز به استفاده</label>
                        <input type="number" class="form-control"
                               data-id="allowedUseNo"
                               id="allowedUseNo" name="allowedUseNo[]"
                               required="required"
                               placeholder="مثال : 2">
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="currencyType" class="control-label font-13 mb-2">نوع ارز</label>
                        <select class="form-control"
                                data-id="currencyType"
                                required="required"
                                id="currencyType" name="currencyType[]">
                            <option value="0">ریال</option>
{*                            {foreach key=key item=item from=$objCurrencyList->CurrencyList()}*}
{*                                {if $item.IsEnable eq 'Enable'}*}
{*                                    <option value="{$item.CurrencyCode}">{$item.CurrencyTitle}</option>*}
{*                                {/if}*}
{*                            {/foreach}*}
                            {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}
                                <option value="{$item.CurrencyCode}"  >{$item.CurrencyTitle} ({$item.EqAmount})</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="mainCost" class="control-label font-13 mb-2"> قیمت ویزا (ریال)</label>
                        <input type="text" class="form-control"
                               data-id="mainCost"
                               onchange="addComma($(this))"
                               onkeyup="addComma($(this))"
                               required="required"
                               id="mainCost" name="mainCost[]"
                               placeholder="مثال : 150,000 ریال">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="prePaymentCost" class="control-label font-13 mb-2">پیش پرداخت (ریال)</label>
                        <input type="text" class="form-control"
                               data-id="prePaymentCost"
                               required="required"
                               onchange="addComma($(this))"
                               onkeyup="addComma($(this))"
                               id="prePaymentCost" name="prePaymentCost[]"
                               placeholder="مثال : 50,000 ریال">
                    </div>

                    <div class="col-lg-9 mb-4">
                        <div class="col-md-12 p-0" data-name="descriptions" data-href="collapseDescription">
                            <label for="visaDescription" class="control-label font-13 mb-2">توضیحات</label>
                            <button type="button" data-toggle="collapse" class="form-control btn btn-outline-primary"
                                    aria-expanded="false"
                                    data-target="#collapseDescription"
                                    aria-controls="collapseDescription">
                                توضیحات
                            </button>
                            <small class="text-muted col-md-12 p-0 mt-2">
                                <span class="fa fa-info text-info"></span>
                                فقط متن ضروری را وارد نماید چون سیستم به صورت اتوماتیک توضیحات دقیق این ویزا
                                را به کاربر نشان خواهد داد</small>
                            <div class="mt-2 collapse col-md-12 p-0 show" id="collapseDescription">
                                <div class="card card-body">
                                    <textarea class="setToEditor" data-id="descriptionsTextarea"
                                              id="descriptionsTextarea" name="descriptions[]"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div data-name="planBox" class="col-lg-3 mb-3">

                        <label for="visaExpiration" class="control-label font-13 mb-2">پلن تبلیغات</label>
                        <select required="required"
                                onchange="visaPlanChanges($(this))"
                                data-id="visaExpiration" class="form-control" id="visaExpiration"
                                name="visaExpiration[]">
                            <option value="">بدون پلن</option>
                            <option value="1"> نمایش 1 ماهه {number_format('2000000')} ریال</option>
                            <option value="2"> نمایش 2 ماهه {number_format('3700000')} ریال</option>
                            <option value="3"> نمایش 3 ماهه {number_format('5500000')} ریال</option>


                        </select>
                        <small class="text-muted col-md-12 p-0 mt-2">
                            <span class="fa fa-warning text-danger"></span>
                            <span data-name="status"
                                  class="text-danger">ویزا بدون پلن تبلیغاتی در سایت نمایش داده نمی شود</span></small>
                        <small class="text-muted col-md-12 p-0 mt-2">
                            <span
                                  class="text-secondary">از طرف <b>{$smarty.const.CLIENT_NAME}</b> به شما <span class="text-success text-decoration"> 5/000/000 تومان </span> اعتبار تبلیغاتی داده شده است</span></small>
                    </div>

                </div>
                <span onclick="closeNewVisaForm($(this).parent().attr('data-count'))" class="visaCloseBtn d-none"><span
                            class="fa fa-close"></span></span>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-4 d-flex align-content-center justify-content-center">
                <a onclick="newVisaForm($(this))" class="visaAddButton">
                    <span class="fa fa-plus"></span>
                </a>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 bg-white align-content-center flex-wrap justify-content-center d-flex p-3 mb-4" data-name="lastDiv">
                <span class="text-center col-md-12 mb-3">هزینه نمایش و تبلیغات : <span data-name="value">0</span></span>

                <button
                        data-name="submitVisaForm"
                        class="btn btn-primary  site-secondary-text-color site-main-button-flat-color" type="submit">ثبت
                </button>


            </div>
        </div>

    </form>
    {* ********************* editor_TinyMCE ********************* *}
    {literal}
        <script type="text/javascript" src="assets/editor_TinyMCE/editor/tinymce.min.js"></script>
        <script type="text/javascript" src="assets/editor_TinyMCE/editor.js"></script>
    {/literal}
    {* ********************* editor_TinyMCE ********************* *}


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
<script>
    $(document).ready(function () {
        $('.collapse').collapse('hide');
    });
</script>
<link rel="stylesheet" type="text/css" href="assets/css/ldbtn.min.css">
<script src="assets/js/profile.js"></script>
<script type="text/javascript" src="assets/js/customForVisa.js"></script>
