{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

{$objPublic->getAllCounter('all')} {*گرفتن لیست انواع کانتر*}

<link href="assets/css/ticketAdd.css" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li class="active">افزودن چارتر جدید</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="FormTicket" method="post" action="{$smarty.const.rootAddress}Hotel_ajax">
                    <input type="hidden" name="flag" value="insert_ticket">
                    
                     

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور مبدا</label><span class="star">*</span>
                        <select name="origin_country" id="origin_country" class="form-control " >
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListCountry() as $country}
                                <option value="{$country['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.origin_country == $country['id']}selected{/if}>{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر مبدا</label><span class="star">*</span>
                        <select name="origin_city" id="origin_city" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.origin_city}" selected>{$objResult->flyDataForTicket.origin_city_name}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_region" class="control-label">منطقه مبدا</label>
                        <select name="origin_region" id="origin_region" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.origin_region}" selected>{$objResult->flyDataForTicket.origin_region_name}</option>
                            {/if}
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="destination_country" class="control-label">کشور مقصد</label><span
                                class="star">*</span>
                        <select name="destination_country" id="destination_country" class="form-control " >
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListCountry() as $country}
                                <option value="{$country['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.destination_country == $country['id']}selected{/if}>{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="destination_city" class="control-label">شهر مقصد</label><span class="star">*</span>
                        <select name="destination_city" id="destination_city" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.destination_city}" selected>{$objResult->flyDataForTicket.destination_city_name}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="destination_region" class="control-label">منطقه مقصد</label>
                        <select name="destination_region" id="destination_region" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.destination_region}" selected>{$objResult->flyDataForTicket.destination_region_name}</option>
                            {/if}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="airline" class="control-label">شرکت حمل و نقل</label><span class="star">*</span>
                        <select name="airline" id="airline" class="form-control " onChange="FlyCodeTicket()" >
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListOtherAirline() as $airline}
                                <option value="{$airline['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.airline == $airline['id']}selected{/if}>{$airline['name']}</option>
                            {/foreach}
                            {foreach $objPublic->ListAirline() as $airline}
                                <option value="{$airline['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.airline == $airline['id']}selected{/if}>{$airline['name_fa']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="fly_code" class="control-label">شماره پرواز</label><span class="star">*</span>
                        <select name="fly_code" id="fly_code" class="form-control " onChange="InformationFlyNumber()" >
                            <option value="">انتخاب کنید....</option>
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.id}" selected>{$objResult->flyDataForTicket.fly_code}</option>
                            {/if}
                        </select>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="free" class="control-label">میزان بار رایگان</label>
                        <input type="text" class="form-control" name="free" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.free}{/if}"
                               id="free" placeholder="میزان بار رایگان را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="vehicle_grade" class="control-label">درجه وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_grade" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.vehicle_grade_id}{/if}"
                               id="vehicle_grade" placeholder="درجه وسیله نقلیه را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="flight_time" class="control-label">مدت زمان پرواز</label><span class="star">*</span>
                        <input type="text" class="form-control" name="flight_time" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.time}{/if}"
                               id="flight_time" placeholder="مدت زمان پرواز را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="type_of_vehicle" class="control-label">مدل وسیله نقلیه</label><span
                                class="star">*</span>
                        <select name="type_of_vehicle" id="type_of_vehicle" class="form-control " >
                            <option value="">انتخاب کنید....</option>
                            {foreach key=key item=item from=$objResult->showTypeOfVehicle()}
                                <option value="{$item['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.type_of_vehicle_id == $item['id']}selected{/if}>{$item['name']} - {$item['name_type_model']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="total_capacity" class="control-label">ظرفیت کل</label><span class="star">*</span>
                        <input type="text" class="form-control" name="total_capacity" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.total_capacity}{/if}"
                               id="total_capacity" placeholder="ظرفیت کل را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="day_onrequest" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="day_onrequest" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.day_onrequest}{/if}"
                               id="day_onrequest" placeholder="زمان توقف فروش را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="minutes" class="control-label">ساعت حرکت پرواز (دقیقه)</label><span
                                class="star">*</span>
                        <select name="minutes" id="minutes" class="form-control " >
                            {for $n=0 to 9}
                                <option value="0{$n}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.departure_minutes == "0{$n}"}selected{/if}>0{$n}</option>
                            {/for}
                            {for $n=10 to 60}
                                <option value="{$n}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.departure_minutes == "{$n}"}selected{/if}>{$n}</option>
                            {/for}
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="hours" class="control-label">ساعت حرکت پرواز (ساعت)</label><span
                                class="star">*</span>
                        <select name="hours" id="hours" class="form-control " >
                            {for $n=0 to 9}
                                <option value="0{$n}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.departure_hours == "0{$n}"}selected{/if}>0{$n}</option>
                            {/for}
                            {for $n=10 to 24}
                                <option value="{$n}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.departure_hours == "{$n}"}selected{/if}>{$n}</option>
                            {/for}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="start_date" class="control-label">شروع تاریخ برگزاری پرواز</label><span
                                class="star">*</span>
                        <input type="text" class="form-control datepicker" name="start_date" value=""
                               id="start_date" placeholder="تاریخ شروع برگزاری پرواز را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="end_date" class="control-label">پایان تاریخ برگزاری پرواز</label><span class="star">*</span>
                        <input type="text" class="form-control datepicker" name="end_date" value="" id="end_date"
                               placeholder="تاریخ پایان برگزاری پرواز را وارد نمائید">
                    </div>


                    <div class="form-group col-sm-12">
                        <h3 class="box-title m-t-40">انتخاب روزها<span class="star">*</span></h3>
                        <hr>
                        <div class="form-group col-sm-1">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh0" name="sh0" class="form-control" type="checkbox" value="0">
                                <label for="sh0"> شنبه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh1" name="sh1" class="form-control" type="checkbox" value="1">
                                <label for="sh1"> یکشنبه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh2" name="sh2" class="form-control" type="checkbox" value="2">
                                <label for="sh2"> دوشنبه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh3" name="sh3" class="form-control" type="checkbox" value="3">
                                <label for="sh3"> سه شنبه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh4" name="sh4" class="form-control" type="checkbox" value="4">
                                <label for="sh4"> چهارشنبه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh5" name="sh5" class="form-control" type="checkbox" value="5">
                                <label for="sh5"> پنج شنبه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-1">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="sh6" name="sh6" class="form-control" type="checkbox" value="6">
                                <label for="sh6"> جمعه </label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group col-sm-12">
                        <h3 class="box-title m-t-40">انتخاب کاربر</h3>
                        <hr>
                        <!-- سایر کاربران -->
                        <table class="table color-table purple-table" id="SecondInsertForUser">
                            <thead>
                            <tr>
                                <th>انتخاب کاربر</th>
                                <th>درصد کمیسیون</th>
                                <th>حداکثر خرید</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$objPublic->listCounter}
                                {$number=$number+1}
                                <tr>
                                    <td>
                                        <div class="checkbox checkbox-success">
                                            <input id="chk_user{$number}" name="chk_user{$number}" class="form-control"
                                                   type="checkbox" value="1">
                                            <label for="chk_user{$number}"> {$item.name} </label>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" name="comition_ticket{$number}" value=""
                                               id="comition_ticket{$number}" placeholder="درصد کمیسیون را وارد کنید">
                                    </td>
                                    <td><input type="text" class="form-control" name="maximum_buy{$number}" value=""
                                               id="maximum_buy{$number}" placeholder="حداکثر خرید را وارد کنید"></td>
                                    <input name="type_user{$number}" type="hidden" id="type_user{$number}"
                                           value="{$item.id}">
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>

                        <input name="id_same" type="hidden" id="id_same" value="">
                        <input name="count_other_user" type="hidden" id="count_other_user" value="{$number}">

                        <h3 class="box-title m-t-40">قیمت گذاری بلیط</h3>
                        <hr>
                        <div class="form-group col-sm-12">
                            <div class="table-responsive">
                                <table class="table color-table purple-table" id="FirstInsertForUser">
                                    <thead>
                                    <tr>
                                        <th>سن</th>
                                        <th>قیمت یک LEG از دو طرفه</th>
                                        <th>قیمت چاپ</th>
                                        <th>قیمت یکطرفه</th>
                                        <th>قیمت چاپ</th>
                                        <th>قیمت بیش از n روز</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>بزرگسال(12+)</td>
                                        <input name="age1" type="hidden" id="age1" value="ADL">
                                        <td><input type="text" class="form-control" name="cost_two_way1" value=""
                                                   id="cost_two_way1" placeholder="قیمت یک LEG از دو طرفه"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_two_way_print1" value=""
                                                   id="cost_two_way_print1" placeholder="قیمت چاپ"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_one_way1" value=""
                                                   id="cost_one_way1" placeholder="قیمت یکطرفه"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_one_way_print1" value=""
                                                   id="cost_one_way_print1" placeholder="قیمت چاپ"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_Ndays1" value=""
                                                   id="cost_Ndays1" placeholder="قیمت بیش از n روز"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>کودک(2 تا 12)</td>
                                        <input name="age2" type="hidden" id="age2" value="CHD">
                                        <td><input type="text" class="form-control" name="cost_two_way2" value=""
                                                   id="cost_two_way2" placeholder="قیمت یک LEG از دو طرفه"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_two_way_print2" value=""
                                                   id="cost_two_way_print2" placeholder="قیمت چاپ"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_one_way2" value=""
                                                   id="cost_one_way2" placeholder="قیمت یکطرفه"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_one_way_print2" value=""
                                                   id="cost_one_way_print2" placeholder="قیمت چاپ"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_Ndays2" value=""
                                                   id="cost_Ndays2" placeholder="قیمت بیش از n روز"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>نوزاد(2-)</td>
                                        <input name="age3" type="hidden" id="age3" value="INF">
                                        <td><input type="text" class="form-control" name="cost_two_way3" value=""
                                                   id="cost_two_way3" placeholder="قیمت یک LEG از دو طرفه"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_two_way_print3" value=""
                                                   id="cost_two_way_print3" placeholder="قیمت چاپ"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_one_way3" value=""
                                                   id="cost_one_way3" placeholder="قیمت یکطرفه"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_one_way_print3" value=""
                                                   id="cost_one_way_print3" placeholder="قیمت چاپ"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                        <td><input type="text" class="form-control" name="cost_Ndays3" value=""
                                                   id="cost_Ndays3" placeholder="قیمت بیش از n روز"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                    <div class="form-group col-sm-12">
                        <h3 class="box-title m-t-40">تخصیص تعداد خرید به همکار</h3>
                        <hr>
                        
                        <!-- Agency Selection -->
                        <div class="agency-selection-minimal">
                            <div class="agency-dropdown-minimal">
                                <label class="control-label">انتخاب آژانس‌ها</label>
                                <div class="dropdown select_agency_for_lock">
                                    <button class="btn btn-outline-secondary dropdown-toggle btn-dropdown-minimal" type="button"
                                            id="dropdownMenu1" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-plus"></i> انتخاب آژانس
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu checkbox-menu allow-focus dropdown-minimal" aria-labelledby="dropdownMenu1">
                                        {foreach $objPublic->getAgencyListClient() as $agency}
                                        <li>
                                            <label class="agency-checkbox-minimal">
                                                <input type="checkbox" onclick="selectAgency('{$agency['id']}','{$agency['name_fa']}',this)"> 
                                                <span class="agency-name">{$agency['name_fa']}</span>
                                            </label>
                                        </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Agencies Table -->
                        <div class="selected-agencies-minimal">
                            <div id="selected-agencies-container" class="agency-table-container">
                                <!-- Dynamic content will be inserted here -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="description_ticket" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control" name="description_ticket" value=""
                                  id="description_ticket" placeholder=""></textarea>
                    </div>


                    <div class="form-group col-sm-12">
                        <label for="services_ticket" class="control-label">خدمات</label>
                        <textarea type="text" class="form-control" name="services_ticket" value="" id="services_ticket"
                                  placeholder=""></textarea>
                    </div>

                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="chk_flag_special" name="chk_flag_special" type="checkbox" value="1">
                            <label for="chk_flag_special"> ویژه </label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary" id="btn_FirstInsert">ارسال اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش اضافه کردن چارتر   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/388/--.html" target="_blank" class="i-btn"></a>

</div>

<div class="loaderPublic displayN"></div>

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/ticketAdd.js"></script>

<script type="text/javascript">
    // Pass PHP variable to JavaScript
    var hasFlyData = {$objResult->hasFlyData|default:false};
</script>