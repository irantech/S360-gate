{load_presentation_object filename="passengers" assign="objPassengers"}
{load_presentation_object filename="agency" assign="objAgency"}
{$objPassengers->showedit($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li><a href="counterList&id={$smarty.get.agencyID}">کانترها</a></li>
                <li><a href="passengerListCounter&id={$smarty.get.CounterId}&agencyID={$smarty.get.agencyID}">مسافران</a></li>
                <li class="active">ویرایش اطلاعات  مسافر </li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش اطلاعات  مسافر</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اطلاعات مسافر  را در سیستم  خود ویرایش نمائید</p>

                <form id="EditPassengerCounter" method="post">
                    <input type="hidden" name="flag" id="flag" value="PassengersUpdate">
                    <input type="hidden" name="agency_id" id="agency_id" value="{$smarty.get.agencyID}">
                    <input type="hidden" name="memberID" id="memberID" value="{$smarty.get.CounterId}">
                    <input type="hidden" name="passengerId" id="passengerId" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="passengerGender" class="control-label">جنسیت</label>
                        <select class="select form-control" name="passengerGender" id="passengerGender">
                            <option value="">انتخاب کنید...</option>
                            <option value="Male" {if $objPassengers->list['gender'] eq 'Male'}selected="selected"{/if}>مرد</option>
                            <option value="Female" {if $objPassengers->list['gender'] eq 'Female'}selected="selected"{/if}>زن</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="passengerNationality" class="control-label">ملیت</label>
                        <select class="select form-control" name="passengerNationality" id="passengerNationality" onchange="showInput()">
                            <option value="0"  {if $objPassengers->list['is_foreign'] eq '0'}selected="selected"{/if}>ایرانی</option>
                            <option value="1"  {if $objPassengers->list['is_foreign'] eq '1'}selected="selected"{/if}>خارجی</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="passengerName" class="control-label">نام </label>
                        <input type="text" class="form-control" id="passengerName" name="passengerName"
                                placeholder="نام  مسافر را وارد نمائید" value="{$objPassengers->list['name']}">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="passengerFamily" class="control-label">نام خانوادگی </label>
                        <input type="text" class="form-control" id="passengerFamily" name="passengerFamily"
                               placeholder="نام خانوادگی مسافر را وارد نمائید" value="{$objPassengers->list['family']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="passengerNameEn" class="control-label">نام لاتین</label>
                        <input type="text" class="form-control" id="passengerNameEn" name="passengerNameEn"
                                placeholder="نام  لاتین مسافر را وارد نمائید" value="{$objPassengers->list['name_en']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="passengerFamilyEn" class="control-label">نام خانوادگی لاتین</label>
                        <input type="text" class="form-control " id="passengerFamilyEn" name="passengerFamilyEn"
                                placeholder="نام خانوادگی لاتین مسافر را وارد نمائید" value="{$objPassengers->list['family_en']}">
                    </div>

                    <div class="form-group col-sm-6 dontShowInput" {if $objPassengers->list['is_foreign'] eq '1'} style="display: none" {/if}>
                        <label for="passengerNationalCode" class="control-label"> کد ملی مسافر</label>
                        <input type="text" class="form-control" id="passengerNationalCode" name="passengerNationalCode"
                               placeholder="کد ملی مسافر را وارد نمائید" value="{$objPassengers->list['NationalCode']}">
                    </div>

                    <div class="form-group col-sm-6 dontShowInput">
                        <label for="passengerBirthday" class="control-label" {if $objPassengers->list['is_foreign'] eq '1'} style="display: none" {/if}>تاریخ تولد-شمسی</label>
                        <input type="text" class="form-control datepicker" id="passengerBirthday" name="passengerBirthday"
                                placeholder="تاریخ تولد شمسی مسافر را وارد نمائید" value="{$objPassengers->list['birthday_fa']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="passengerPassportNumber" class="control-label">شماره پاسپورت</label>
                        <input type="text" class="form-control" id="passengerPassportNumber" name="passengerPassportNumber"
                               placeholder="شماره پاسپورت مسافر را وارد نمائید" value="{$objPassengers->list['passportNumber']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="passengerPassportExpire" class="control-label">تاریخ انقضاء پاسپورت</label>
                        <input type="text" class="form-control datepicker-miladi" id="passengerPassportExpire" name="passengerPassportExpire"
                               placeholder="تاریخ انقضاء پاسپورت مسافر را وارد نمائید" value="{$objPassengers->list['passportExpire']}">
                    </div>

                    <div class="form-group col-sm-6 showInput" {if $objPassengers->list['is_foreign'] eq '0'} style="display: none" {/if}>
                        <label for="passengerPassportCountry" class="control-label">کشور صادر کننده پاسپورت</label>
                        <select class="form-control select2" id="passengerPassportCountry" name="passengerPassportCountry">
                            <option value="">کشور صادر کننده پاسپورت مسافر را وارد نمائید</option>
                            {foreach $objFunctions->CountryCodes() as $Country}
                                <option value="{$Country['code']}" {if $objPassengers->list['passportCountry'] eq $Country['code']}selected="selected"{/if}>{$Country['titleFa']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6 showInput" {if $objPassengers->list['is_foreign'] eq '0'} style="display: none" {/if}>
                        <label for="passengerBirthdayEn" class="control-label">تاریخ تولد-میلادی</label>
                        <input type="text" class="form-control datepicker-miladi " id="passengerBirthdayEn" name="passengerBirthdayEn"
                                placeholder="تاریخ تولد میلادی مسافر را وارد نمائید" value="{$objPassengers->list['birthday']}" >
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/passenger.js"></script>

