{load_presentation_object filename="visa" assign="objVisa"}

{assign var="visaOptionByKeyArray" value=['clientID'=>$smarty.const.CLIENT_ID,'key'=>'marketPlace']}
{assign var="visaOptionByKey" value=$objVisa->visaOptionByKey($visaOptionByKeyArray)}


{if $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and $visaOptionByKey['value'] eq 'available'}

{load_presentation_object filename="reservationTour" assign="objResult"}

{load_presentation_object filename="country" assign="objCountry"}
{*{load_presentation_object filename="currency" assign="objCurrencyList"}*}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
{assign var="continents" value=$objCountry->continentsList()}

{load_presentation_object filename="visaType" assign="objVisaType"}
{load_presentation_object filename="visa" assign="objVisa"}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}

{assign var="requiredData" value=['id'=>$smarty.get.id,'fullData'=>false]}
{assign var="currentVisa" value=json_decode($objVisa->visaDetailData($requiredData),true)}



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
        <input type="hidden" name="flag" value="visaEdit">
        <input type="hidden" name="id" value="{$currentVisa.data.visa.id}">

        <div class="col-md-12 mb-4 bg-white p-3">
            <div class="form-row w-100 d-flex align-content-center justify-content-center">
                <div class="col-md-4 mb-4">
                    <label for="continent" class="control-label mb-2">قاره</label>
                    <select required class="form-control select2" id="continent" name="continent">
                        <option value="">لطفا قاره را انتخاب نمایید</option>
                        {foreach $continents as $each}
                            <option
                                    {if $currentVisa.data.visa.country_id eq $each.id} selected {/if}
                                    value="{$each.id}">{$each.titleFa}</option>
                        {/foreach}
                    </select>
                </div>
                <script>
                    countryCities("{$currentVisa.data.visa.countryCode}");
                </script>
                <div class="col-md-4 mb-4">
                    <label for="countryCode" class="control-label mb-2">کشور</label>
                    <select required class="form-control select2" id="countryCode" name="countryCode"></select>
                </div>

            </div>
        </div>




            <div class="col-md-12 mb-4 bg-white p-3 {if $visaApiDetailOption['value'] == 'available'} d-none {/if}">
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" class="custom-control-input" name="OnlinePayment"
                           id="OnlinePayment">
                    <label class="custom-control-label" for="OnlinePayment">درخواست مشتری به همراه پرداخت آنلاین</label>
                </div>
            </div>



        <div data-name="baseAddVisa" class="col-md-12 p-0">
            <div data-name="addVisaItem" data-count="1"
                 class="animationFadeIn col-md-12 bg-white p-3 mb-4">
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                        <label for="visaTypeID" class="control-label mb-2">نوع ویزا</label>
                        <select required class="form-control"
                                required="required"
                                data-id="visaTypeID"
                                id="visaTypeID" name="visaTypeID">
                            <option>لطفا نوع ویزا را انتخاب نمایید</option>
                            {*                        {$each|print_r}*}
                            {foreach $visaTypeList as $each}
                                <option
                                        {if $currentVisa.data.visa.visaTypeID eq $each.id} selected {/if}
                                        value="{$each.id}">{$each.title}</option>
                            {/foreach}
                        </select>

                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="title" class="control-label mb-2">عنوان ویزا</label>
                        <input onchange="addPlanName($(this))" onkeyup="addPlanName($(this))" type="text" name="title"
                               class="form-control"
                               value="{$currentVisa.data.visa.title}"
                               data-id="title"
                               required="required"
                               id="title"
                               placeholder="مثال : ویزای توریستی ترکیه">
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="deadline" class="control-label mb-2">زمان تحویل</label>
                        <input type="text" class="form-control"
                               data-id="deadline"
                               value="{$currentVisa.data.visa.deadline}"
                               id="deadline" name="deadline"
                               required="required"
                               placeholder="مثال : 2 روزه">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="validityDuration" class="control-label mb-2">مدت اعتبار</label>
                        <input type="text" class="form-control"
                               data-id="validityDuration"
                               id="validityDuration" name="validityDuration"
                               value="{$currentVisa.data.visa.validityDuration}"
                               required="required"
                               placeholder="مثال : 30 روز">
                    </div>


                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                        <label for="allowedUseNo" class="control-label mb-2">تعداد دفعات مجاز به استفاده</label>
                        <input type="text" class="form-control"
                               data-id="allowedUseNo"
                               id="allowedUseNo" name="allowedUseNo"
                               value="{$currentVisa.data.visa.allowedUseNo}"
                               required="required"
                               placeholder="مثال : 2">
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="currencyType" class="control-label mb-2">نوع ارز</label>
                        <select class="form-control"
                                data-id="currencyType"
                                required="required"
                                id="currencyType" name="currencyType">
                            <option value="0">ریال</option>
{*                            {foreach key=key item=item from=$objCurrencyList->CurrencyList()}*}
{*                                {if $item.IsEnable eq 'Enable'}*}
{*                                    <option*}
{*                                            {if $currentVisa.data.visa.currencyType eq $item.CurrencyCode} selected {/if}*}
{*                                            value="{$item.CurrencyCode}">{$item.CurrencyTitle}</option>*}
{*                                {/if}*}
{*                            {/foreach}*}
                            {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}
                                <option value="{$item.CurrencyCode}"  {if {$currentVisa.data.visa.currencyType} eq $item.CurrencyCode} selected {/if}>{$item.CurrencyTitle} ({$item.EqAmount})</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="mainCost" class="control-label mb-2">قیمت ویزا</label>
                        <input type="text" class="form-control"
                               data-id="mainCost"
                               value="{$currentVisa.data.visa.mainCost}"
                               onchange="addComma($(this))"
                               onkeyup="addComma($(this))"
                               required="required"
                               id="mainCost" name="mainCost"
                               placeholder="مثال : 150,000 ریال">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="prePaymentCost" class="control-label mb-2">پیش پرداخت</label>
                        <input type="text" class="form-control"
                               data-id="prePaymentCost"
                               required="required"
                               onchange="addComma($(this))"
                               onkeyup="addComma($(this))"
                               value="{$currentVisa.data.visa.prePaymentCost}"
                               id="prePaymentCost" name="prePaymentCost"
                               placeholder="مثال : 50,000 ریال">
                    </div>
                    <div class="col-lg-9 mb-3">
                        <div class="col-md-12 p-0" data-name="descriptions" data-href="collapseDescription">
                            <label for="visaDescription" class="control-label mb-2">توضیحات</label>
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
                                              id="descriptionsTextarea" name="descriptions">
                                        {$currentVisa.data.visa.descriptions}
                                    </textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div data-name="planBox" class="col-lg-3 mb-3">

                        <label for="visaExpiration" class="control-label mb-2">پلن تبلیغات</label>
                        <select disabled required="required"
                                onchange="visaPlanChanges($(this))"
                                data-id="visaExpiration" class="form-control" id="visaExpiration"
                                name="visaExpiration">
                            <option value="0">بدون پلن</option>
                            {for $foo=1 to 12}
                                <option value="{$foo}"> نمایش {$foo} ماهه {number_format($foo*'100000')} ریال</option>
                            {/for}

                        </select>
                        <small class="text-muted col-md-12 p-0 mt-2">
                            <span>
                                {$currentVisa.data.visa.correctExpired_at}
                            </span>
                        </small>
                    </div>


                </div>
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-12 bg-white align-content-center justify-content-center flex-wrap d-flex p-3 mb-4" data-name="lastDiv">
                <button
                        data-name="submitVisaForm"
                        class="btn btn-primary  site-secondary-text-color site-main-button-flat-color" type="submit">ویرایش
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

<link rel="stylesheet" type="text/css" href="assets/css/ldbtn.min.css">
<script src="assets/js/profile.js"></script>
<script type="text/javascript" src="assets/js/customForVisa.js"></script>
