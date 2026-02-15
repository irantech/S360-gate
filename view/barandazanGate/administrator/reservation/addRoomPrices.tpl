{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
{*{load_presentation_object filename="functions" assign="objFunctions"}*}
{*{assign var="check_custom_currency" value=$objFunctions->checkClientConfigurationAccess('custom_currency' )}*}
{if $check_custom_currency}
{else}
{/if}
{$objPublic->getAllCounter('all')} {*گرفتن لیست انواع کانتر*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li class="active">افزودن قیمت اتاق</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-10 textTicketAttention">توجه : کاربر گرامی قیمت برای مسافر آنلاین به این صورت می باشد که مقدار درصد تخفیف را از کل کم کنید و مابقی را در باکس بزنید.نمونه 93% می خواهید از کل مبلغ اصلی.</p>
                <p class="text-muted m-b-10 textTicketAttention">در باکس تعداد شب بصورت پیش فرض 15 شب در نظر گرفته شده است. اگر این رنج شب مد نظر نمی باشد لطفا مانند نمونه تعداد شب های مورد نظر را وارد نمائید.</p>

                <form id="FormAddRoomPrice" method="post" action="">
                    <input type="hidden" name="flag" value="insert_room_price">

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور</label><span class="star">*</span>
                        <select name="origin_country" id="origin_country" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListCountry() as $country}
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    <option value="{$country['id']}">{$country['name']}</option>
                                {else}
                                    <option value="{$country['id']}">{$country['name_en']}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر</label><span class="star">*</span>
                        <select name="origin_city" id="origin_city" class="form-control" onChange="ShowAllHotel()">

                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_region" class="control-label">منطقه</label>
                        <select name="origin_region" id="origin_region" class="form-control ">
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="hotel_name" class="control-label">نام هتل</label><span class="star">*</span>
                        <select name="hotel_name" id="hotel_name" class="form-control" onChange="ShowAllHotelRoom()">
                            <option value="">انتخاب کنید....</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="onrequest_time" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="onrequest_time" value=""
                               id="onrequest_time" placeholder="... ساعت مانده به ورود">
                    </div>

                     <div class="form-group col-sm-3">
                        <label for="reserve_time_canceled" class="control-label">زمان باطل شدن رزرو (ساعت)</label>
                        <input type="text" class="form-control" name="reserve_time_canceled" value=""
                               id="reserve_time_canceled" placeholder="... ساعت">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="sell_for_night" class="control-label">فروش برای (نمونه 3/5/7/10) شب</label>
                        <input type="text" class="form-control" name="sell_for_night" value=""
                               id="sell_for_night" placeholder="فروش برای تعداد شب را وارد کنید.">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="start_date" class="control-label">شروع تاریخ فروش اتاق</label><span class="star">*</span>
                        {if $smarty.const.CLIENT_ID != '317'}
                        <input type="text" class="form-control datepicker" name="start_date" value=""
                               id="start_date" placeholder="تاریخ شروع برگزاری اتاق را وارد نمائید">
                        {else}
                            <input type="text" class="form-control deptCalendar-en" name="start_date_en" value=""
                                   id="start_date_en" placeholder="تاریخ شروع برگزاری اتاق را وارد نمائید">
                        {/if}
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="end_date" class="control-label">پایان تاریخ فروش اتاق</label><span class="star">*</span>
                        {if $smarty.const.CLIENT_ID != '317'}
                            <input type="text" class="form-control datepicker" name="end_date" value="" id="end_date"
                               placeholder="تاریخ پایان برگزاری اتاق را وارد نمائید">
                        {else}
                            <input type="text" class="form-control deptCalendar-en" name="end_date_en" value="" id="end_date_en"
                                   placeholder="تاریخ پایان برگزاری اتاق را وارد نمائید">
                        {/if}
                    </div>



                    <h3 class="box-title m-t-40">خدمات اتاق</h3>
                    <hr>
                    <div class="form-group col-sm-12">

                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="breakfast" name="breakfast" class="form-control" type="checkbox" value="yes">
                                <label for="breakfast"> صبحانه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="lunch" name="lunch" class="form-control" type="checkbox" value="yes">
                                <label for="lunch"> ناهار </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="dinner" name="dinner" class="form-control" type="checkbox" value="yes">
                                <label for="dinner"> شام </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="other_services" class="control-label">گشت و سایر خدمات</label>
                        <textarea type="text" class="form-control" name="other_services" value="" id="other_services"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="specific_description" class="control-label">توضیحات خاص</label>
                        <textarea type="text" class="form-control" name="specific_description" value="" id="specific_description"></textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="pic" class="control-label">فایل هتل</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/NoPhotoHotel.png"/>
                    </div>

                    <h3 class="box-title m-t-40">نحوه نمایش قیمت اتاق ها</h3>
                    <div class="form-group col-sm-12">
                        <div class="radio-inline col-sm-5">
                            <div class="radio radio-info">
                                <input type="radio" name="discount_status" id="discount_status1" value="1">
                                <label for="discount_status1">نمایش قیمت و اعمال درصد کمسیون برای تخفیف</label>
                            </div>
                        </div>
                        <div class="radio-inline col-sm-6">
                            <div class="radio radio-info">
                                <input type="radio" name="discount_status" id="discount_status2" value="2">
                                <label for="discount_status2">نمایش قیمت و قیمت بردهتل (محاسبه درصد تخفیف بر اساس قیمت و قیمت بردهتل)</label>
                            </div>
                        </div>
                    </div>

                    <h3 class="box-title m-t-40">انتخاب کاربر</h3>
                    <hr>
                    <h6>لطفا برای نمایش هتل ها در قسمت سرچ باکس سایت، حتما تیک مسافرآنلاین را بزنید.</h6>
                    <hr>
                    <!-- کاربران -->

                    <table class="table color-table purple-table">
                        <thead>
                        <tr>
                            <th>انتخاب کاربر</th>
                            <th>درصد کمیسیون</th>
                            <th>حداکثرخرید</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objPublic->listCounter}
                        {$number=$number+1}
                        <tr>
                            <td>
                                <div class="checkbox checkbox-success">
                                    <input id="chk_user{$number}" name="chk_user{$number}" class="form-control" type="checkbox" value="{$number}" onclick="inputRequired('{$number}')">
                                    <label for="chk_user{$number}"> {$item.name} </label>
                                </div>
                            </td>
                            <td>
                                <div class="input-text">
                                <input type="text" class="form-control textComition" name="comition_hotel{$number}" value="" id="comition_hotel{$number}" placeholder="درصد کمیسیون را وارد کنید" >
                                </div>
                                <input name="user_type{$number}" type="hidden" id="user_type{$number}" value="{$item.id}">
                            </td>
                            <td>
                                <div class="input-text">
                                <input type="text" class="form-control textCapacity" name="maximum_capacity{$number}" value="" id="maximum_capacity{$number}" placeholder="حداکثر خرید را وارد کنید" >
                                </div>
                            </td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>

                    <input name="id_same" type="hidden" id="id_same" value="">
                    <input name="count_other_user" type="hidden" id="count_other_user" value="{$number}">


                    <h3 class="box-title m-t-40">کاربر مهمان</h3>
                    <hr>
                    <div class="form-group col-sm-12">
                        <div class="checkbox checkbox-success">
                            <input id="guest_user_status" name="guest_user_status" class="form-control" type="checkbox" value="yes">
                            <label for="guest_user_status"> قیمت و درصد  تخفیف اتاق ها؛ برای کاربر مهمان همانند مسافرآنلاین محاسبه شود. </label>
                        </div>
                    </div>

                    <h3 class="box-title m-t-40">قیمت گذاری اتاق ها</h3>
                    <hr>
                    <div class="form-group col-sm-12">
                        <div class="table-responsive">

                            <table class="table color-table purple-table" id="TableRoomPrice">
                                <thead>
                                <tr>
                                    <th>نوع اتاق / ظرفیت / حداکثر خرید</th>
                                    <th>قیمت <span class="star">*</span></th>
                                    <th>قیمت برد هتل</th>
                                    <th>قیمت ارزی</th>
                                    <th>نوع ارزی</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input name="age11" type="hidden" id="age11" value="DBL">
                                        <select name="room_type1" id="room_type1" class="form-control " onFocus="ShowAllHotelRoom('1')">
                                            <option value="">انتخاب اتاق....</option>

                                        </select>
                                        <br>
                                        <input type="text" class="form-control" name="total_capacity1" value="" id="total_capacity1" placeholder="ظرفیت اتاق را وارد کنید">
                                    </td>
                                    <td>
                                        <div class="input-text">
                                        <input type="text" class="form-control textPrice" name="online_price11" value="" id="online_price11"
                                               placeholder="قیمت هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               aria-invalid="false">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-text">
                                        <input type="text" class="form-control textBoardPrice" name="board_price11" value="" id="board_price11"
                                               placeholder="قیمت برد را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               aria-invalid="false">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="currency_price11" value="" id="currency_price11"
                                               placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                               aria-invalid="false">
                                    </td>
                                    <td>
                                        <select name="currency_type1" id="currency_type1" class="form-control ">
                                            <option value="">انتخاب کنید....</option>
                                            {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}
                                                <option value="{$item.CurrencyCode}">{$item.CurrencyTitle} ({$item.EqAmount})</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><input name="age12" type="hidden" id="age12" value="EXT"> تخت اضافه بزرگسال </td>
                                    <td><input type="text" class="form-control" name="online_price12" value="" id="online_price12"  placeholder="قیمت هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="board_price12" value="" id="board_price12"  placeholder="قیمت برد را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="currency_price12" value="" id="currency_price12"  placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <input name="age13" type="hidden" id="age13" value="ECHD">
                                        تخت کودک
                                        <select name="childFromAge13" id="childFromAge13" class="form-control  mx-2 " style='width: 45px'>
                                            {for $var=0 to 12}
                                                <option value="{$var}">{$var}</option>
                                            {/for}
                                        </select>
                                        تا
                                        <select name="childToAge13" id="childToAge13" class="form-control  mx-2 " style='width: 45px'>
                                            {for $var=0 to 12}
                                                <option value="{$var}">{$var}</option>
                                            {/for}
                                        </select>
                                        سال
                                    </td>
                                    <td><input type="text" class="form-control" name="online_price13" value="" id="online_price13" placeholder="قیمت هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="board_price13" value="" id="board_price13" placeholder="قیمت برد را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="currency_price13" value="" id="currency_price13" placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class='d-flex align-items-center'><input name="age14" type="hidden" id="age14" value="CHD">
                                        تخت کودک رایگان تا
                                        <select name="childToAge14" id="childToAge14" class="form-control  mx-2 " style='width: 45px'>
                                            {for $var=0 to 12}
                                                <option value="{$var}">{$var}</option>
                                            {/for}
                                        </select>
                                        سال
                                    </td>
                                    <td><input type="hidden" class="form-control" name="online_price14" value="" id="online_price14" placeholder="قیمت هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="hidden" class="form-control" name="board_price14" value="" id="board_price14" placeholder="قیمت برد را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="hidden" class="form-control" name="currency_price14" value="" id="currency_price14" placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>


                    <div class="row">
                        <img src="assets/css/images/add.png" border="0" onClick="appendRow(this.form)">
                        <input name="count_package" id="count_package" value="1" type="hidden">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary" id="btnInsertTicket">ارسال اطلاعات</button>
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
        <span> ویدیو آموزشی بخش اضافه کردن اتاق </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/374/--.html" target="_blank" class="i-btn"></a>

</div>



<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>

<SCRIPT LANGUAGE="JavaScript">

    var theTable, theTableBody;
    var aa=[];
    var row=4;
    var radif=2;

    $(document).ready(function () {
        theTable = (document.all) ? document.all.TableRoomPrice : document.getElementById("TableRoomPrice");
        theTableBody = theTable.tBodies[0];
    });

    function appendRow(form) {

        $('#count_package').val(parseInt(radif));

        aa[row]=row;
        insertTableRow(form, -1)
    }

    function insertTableRow(form, where) {
      ShowCurrency(radif)
        var nowData = [
            '<div align="center"><input name="age'+radif+'1" type="hidden" id="age'+radif+'1" value="DBL"><select name="room_type'+radif+'" id="room_type'+radif+'" class="form-control " onFocus="ShowAllHotelRoom('+radif+')"><option value="">انتخاب اتاق....</option></select><br><input type="text" class="form-control" name="total_capacity'+radif+'" value="" id="total_capacity'+radif+'" placeholder="ظرفیت اتاق را وارد کنید"></div>' ,
            '<div align="center"><div class="input-text"><input type="text" class="form-control textPrice" name="online_price'+radif+'1" value="" id="online_price'+radif+'1" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت هتل را وارد کنید"></div></div>' ,
            '<div align="center"><div class="input-text"><input type="text" class="form-control textBoardPrice" name="board_price'+radif+'1" value="" id="board_price'+radif+'1" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت برد را وارد کنید"></div></div>' ,
            '<div align="center"><input type="text" class="form-control" name="currency_price'+radif+'1" value="" id="currency_price'+radif+'1" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت ارزی را وارد کنید"></div>' ,
            '<div align="center" dir="rtl"><select name="currency_type'+radif+'" id="currency_type'+radif+'" class="form-control "><option value="">انتخاب کنید....</option><option value="0">ندارد</option><option value="1">دلار</option><option value="2">درهم</option><option value="3">یورو</option></select></div>',
            '<div align="right" dir="rtl"><img src="assets/css/images/delete.png" border="0" onClick="del_3row('+row+')"></div>'
        ]

        var newCell
        var newRow = theTableBody.insertRow(where)
        for (var i = 0; i < nowData.length; i++) {
            newCell = newRow.insertCell(i)
            newCell.innerHTML = nowData[i]
            newCell.style.backgroundColor = "#A0B7E0"
        }

        var nowData = [
            '<div align="center" dir=ltr><input name="age'+radif+'2" type="hidden" id="age'+radif+'2" value="EXT">تخت اضافه بزرگسال</div>' ,
        '<div align="center"><input type="text" class="form-control" name="online_price'+radif+'2" value="" id="online_price'+radif+'2" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت هتل را وارد کنید"></div>' ,
        '<div align="center"><input type="text" class="form-control" name="board_price'+radif+'2" value="" id="board_price'+radif+'2" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت برد را وارد کنید"></div>' ,
        '<div align="center"><input type="text" class="form-control" name="currency_price'+radif+'2" value="" id="currency_price'+radif+'2" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت ارزی را وارد کنید"></div>' ,
        '<div align="center" dir="rtl">&nbsp;</div>',
        '<div align="right">&nbsp;</div>']
        var newCell
        var newRow = theTableBody.insertRow(where)
        for (var i = 0; i < nowData.length; i++) {
            newCell = newRow.insertCell(i)
            newCell.innerHTML = nowData[i]
            newCell.style.backgroundColor = ""
        }
        var nowData = [
            '<div align="center" class="d-flex align-items-center" dir=rtl><input name="age'+radif+'3" type="hidden" id="age'+radif+'3" value="ECHD"> تخت  کودک از' +
            '<select name="childFromAge'+radif+'3" id="childFromAge'+radif+'3" class="form-control  mx-2 " style="width: 45px">'+
            '<option value="0">0</option>' +
            '<option value="1">1</option>' +
            '<option value="2">2</option>' +
            '<option value="3">3</option>' +
            '<option value="4">4</option>' +
            '<option value="5">5</option>' +
            '<option value="6">6</option>' +
            '<option value="7">7</option>' +
            '<option value="8">8</option>' +
            '<option value="9">9</option>' +
            '<option value="10">10</option>' +
            '<option value="11">11</option>' +
            '<option value="12">12</option>' +
            '</select>'+
            'تا' +
            '<select name="childToAge'+radif+'3" id="childToAge'+radif+'3" class="form-control  mx-2 " style="width: 45px">'+
            '<option value="0">0</option>' +
            '<option value="1">1</option>' +
            '<option value="2">2</option>' +
            '<option value="3">3</option>' +
            '<option value="4">4</option>' +
            '<option value="5">5</option>' +
            '<option value="6">6</option>' +
            '<option value="7">7</option>' +
            '<option value="8">8</option>' +
            '<option value="9">9</option>' +
            '<option value="10">10</option>' +
            '<option value="11">11</option>' +
            '<option value="12">12</option>' +
            '</select>'+
            'سال'+
            '</div>' ,
            '<div align="center"><input type="text" class="form-control" name="online_price'+radif+'3" value="" id="online_price'+radif+'3" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت هتل را وارد کنید"></div>' ,
            '<div align="center"><input type="text" class="form-control" name="board_price'+radif+'3" value="" id="board_price'+radif+'3" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت برد را وارد کنید"></div>' ,
            '<div align="center"><input type="text" class="form-control" name="currency_price'+radif+'3" value="" id="currency_price'+radif+'3" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="قیمت ارزی را وارد کنید"></div>' ,
            '<div align="center" dir="rtl">&nbsp;</div>',
            '<div align="right">&nbsp;</div>']

        var newCell
        var newRow = theTableBody.insertRow(where)
        for (var i = 0; i < nowData.length; i++) {
            newCell = newRow.insertCell(i)
            newCell.innerHTML = nowData[i]
            newCell.style.backgroundColor = ""
        }


        var nowData = [
        '<div align="center" class="d-flex align-items-center" dir=rtl><input name="age'+radif+'4" type="hidden" id="age'+radif+'4" value="CHD">تخت رایگان کودک تا' +
        '<select name="childToAge'+radif+'4" id="childToAge'+radif+'4" class="form-control  mx-2 " style="width: 45px">'+
        '<option value="0">0</option>' +
        '<option value="1">1</option>' +
        '<option value="2">2</option>' +
        '<option value="3">3</option>' +
        '<option value="4">4</option>' +
        '<option value="5">5</option>' +
        '<option value="6">6</option>' +
        '<option value="7">7</option>' +
        '<option value="8">8</option>' +
        '<option value="9">9</option>' +
        '<option value="10">10</option>' +
        '<option value="11">11</option>' +
        '<option value="12">12</option>' +
        '</select>'+
        'سال'+
        '</div>' ,
        '<div align="center"><input type="hidden" class="form-control" name="online_price'+radif+'4" value="" id="online_price'+radif+'4" placeholder="قیمت هتل را وارد کنید"></div>' ,
        '<div align="center"><input type="hidden" class="form-control" name="board_price'+radif+'4" value="" id="board_price'+radif+'4" placeholder="قیمت برد را وارد کنید"></div>' ,
        '<div align="center"><input type="hidden" class="form-control" name="currency_price'+radif+'4" value="" id="currency_price'+radif+'4" placeholder="قیمت ارزی را وارد کنید"></div>' ,
            '<div align="center" dir="rtl">&nbsp;</div>',
            '<div align="right">&nbsp;</div>']

        var newCell
        var newRow = theTableBody.insertRow(where)
        for (var i = 0; i < nowData.length; i++) {
            newCell = newRow.insertCell(i)
            newCell.innerHTML = nowData[i]
            newCell.style.backgroundColor = ""
        }

        row = row + 4;
        radif = radif+1;
    }



    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    function del_3row(index){
        del(index);
        del(index+1);
        del(index+2);
        del(index+3);
    }
    function del(index) {
        var countzero=0;
        var i;
        //1
        for(i=0; i<=aa.length; i++){
            if(aa[i]=="n"){
                countzero++;
            }
        }
        //1   tedade khali bodane khaneha
/////////////////////////

        //if khali nabodane khane ha
        if(countzero==0){
            theTableBody.deleteRow(index);
            aa[index]="n";
            return;
        }
        //end if khali nabodane khane ha

////////////////////////////////////////

        // if khli bodane khane ha
        if(countzero!=0){
            var countkhaneha=0;
            for(var i=0;i<index;i++){
                if(aa[i]=="n"){
                    countkhaneha++;
                }
            }
            //end for

            //1
            if(countkhaneha==0){
                theTableBody.deleteRow(index);
                aa[index]="n";
            }
            //end if 1 age khali gablesh nabod


            //2
            if(countkhaneha!=0){
                var harekat=0;
                for(var i=0;i<index;i++){
                    if(aa[i]=="n"){
                        harekat++;
                    }

                }//end for
                var kam=index-harekat;
                theTableBody.deleteRow(kam);
                aa[index]="n";
            }
            //end if 2 age khali gablesh nabod

        }
        //end if khli bodane khane ha


    }


</script>