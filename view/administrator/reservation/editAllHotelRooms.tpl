{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}

{$objPublic->getAllCounter('all')} {*گرفتن لیست انواع کانتر*}
{$objResult->infoAllHotelRooms($smarty.get.idHotel, $smarty.get.idSame)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li>
                    <a href="reportAllHotelRooms&city={$objResult->infoRoomPrice['id_city']}&hotel={$objResult->infoRoomPrice['id_hotel']}">گزارش
                        کلی هتل</a></li>
                <li class="active">ویرایش کلی اتاق ها</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش اتاق های هتل</h3>
                <div class="row show-grid">
                    <div class="col-md-4"><b>کشور -
                            شهر: </b>{$objPublic->ShowName(reservation_country_tb,$objResult->infoRoomPrice['id_country'])}
                        - {$objPublic->ShowName(reservation_city_tb,$objResult->infoRoomPrice['id_city'])}</div>
                    <div class="col-md-4">
                        <b>هتل: </b>{$objPublic->ShowName(reservation_hotel_tb,$objResult->infoRoomPrice['id_hotel'])}
                    </div>
                    <div class="col-md-4"><b>از
                            تاریخ: </b>{$objPublic->format_Date($objResult->infoRoomPrice['minDate'])}
                        <b>تا </b>{$objPublic->format_Date($objResult->infoRoomPrice['maxDate'])} </div>
                </div>

                <p class="text-muted m-b-10 textTicketAttention">توجه : کاربر گرامی قیمت برای مسافر آنلاین به این صورت
                    می باشد که مقدار درصد تخفیف را از کل کم کنید و مابقی را در باکس بزنید.نمونه 93% می خواهید از کل مبلغ
                    اصلی.</p>
                <p class="text-muted m-b-10 textTicketAttention">در باکس تعداد شب بصورت پیش فرض 15 شب در نظر گرفته شده
                    است. اگر این رنج شب مد نظر نمی باشد لطفا مانند نمونه تعداد شب های مورد نظر را وارد نمائید.</p>

                <form id="FormEditAllHotelRooms" method="post" action="">
                    <input type="hidden" name="flag" value="editAllHotelRooms">
                    <input type="hidden" name="idHotel" value="{$smarty.get.idHotel}">
                    <input type="hidden" name="idSame" value="{$smarty.get.idSame}">
                    <input type="hidden" name="start_date" value="{$objPublic->format_Date($objResult->infoRoomPrice['minDate'])}">
                    <input type="hidden" name="end_date" value="{$objPublic->format_Date($objResult->infoRoomPrice['maxDate'])}">
                    <input type="hidden" name="id_country" value="{$objResult->infoRoomPrice['id_country']}">
                    <input type="hidden" name="id_city" value="{$objResult->infoRoomPrice['id_city']}">
                    <input type="hidden" name="id_region" value="{$objResult->infoRoomPrice['id_region']}">

                    <div class="form-group col-sm-4">
                        <label for="onrequest_time" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="onrequest_time"
                               value="{$objResult->infoRoomPrice['onrequest_time']}"
                               id="onrequest_time" placeholder="... ساعت مانده به ورود">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="reserve_time_canceled" class="control-label">زمان باطل شدن رزرو (ساعت)</label>
                        <input type="text" class="form-control" name="reserve_time_canceled"
                               value="{$objResult->infoRoomPrice['reserve_time_canceled']}"
                               id="reserve_time_canceled" placeholder="... ساعت">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="sell_for_night" class="control-label">فروش برای (نمونه 3/5/7/10) شب</label>
                        <input type="text" class="form-control" name="sell_for_night"
                               value="{$objResult->infoRoomPrice['sell_for_night']}"
                               id="sell_for_night" placeholder="فروش برای تعداد شب را وارد کنید.">
                    </div>


                    <h3 class="box-title m-t-40">خدمات اتاق</h3>
                    <hr>
                    <div class="form-group col-sm-12">

                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="breakfast" name="breakfast" class="form-control" type="checkbox" value="yes"
                                       {if $objResult->infoRoomPrice['breakfast'] eq 'yes'}checked="checked"{/if}>
                                <label for="breakfast"> صبحانه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="lunch" name="lunch" class="form-control" type="checkbox" value="yes"
                                       {if $objResult->infoRoomPrice['lunch'] eq 'yes'}checked="checked"{/if}>
                                <label for="lunch"> ناهار </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="dinner" name="dinner" class="form-control" type="checkbox" value="yes"
                                       {if $objResult->infoRoomPrice['dinner'] eq 'yes'}checked="checked"{/if}>
                                <label for="dinner"> شام </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="other_services" class="control-label">گشت و سایر خدمات</label>
                        <textarea type="text" class="form-control" name="other_services"
                                  id="other_services">{$objResult->infoRoomPrice['other_services']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="specific_description" class="control-label">توضیحات خاص</label>
                        <textarea type="text" class="form-control" name="specific_description"
                                  id="specific_description">{$objResult->infoRoomPrice['specific_description']}</textarea>
                    </div>

                    {*<div class="form-group col-sm-12">
                        <label for="pic" class="control-label">فایل هتل</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/NoPhotoHotel.png"/>
                    </div>*}

                    <h3 class="box-title m-t-40">نحوه نمایش قیمت اتاق ها</h3>
                    <div class="form-group col-sm-12">
                        <div class="radio-inline col-sm-5">
                            <div class="radio radio-info">
                                <input type="radio" name="discount_status" id="discount_status1" value="1"
                                       {if $objResult->infoRoomPrice['discount_status'] eq '1'}checked="checked"{/if}>
                                <label for="discount_status1">نمایش قیمت و اعمال درصد کمسیون برای تخفیف</label>
                            </div>
                        </div>
                        <div class="radio-inline col-sm-6">
                            <div class="radio radio-info">
                                <input type="radio" name="discount_status" id="discount_status2" value="2"
                                       {if $objResult->infoRoomPrice['discount_status'] eq '2'}checked="checked"{/if}>
                                <label for="discount_status2">نمایش قیمت و قیمت بردهتل (محاسبه درصد تخفیف بر اساس قیمت و
                                    قیمت بردهتل)</label>
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
                        {foreach key=key item=item from=$objPublic->listCounter}
                            <tr>
                                <td>
                                    <div class="checkbox checkbox-success">
                                        <input id="chk_user{$key}" name="chk_user{$key}" class="form-control"
                                               type="checkbox" value="{$key}"
                                               {if $objResult->users[$item.id]['user_type'] neq ''}checked{/if}
                                               onclick="inputRequired('{$key}')">
                                        <label for="chk_user{$key}"> {$item.name} </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-text">
                                        <input type="text" class="form-control textComition" name="discount{$key}"
                                               value="{$objResult->users[$item.id]['comition_hotel']}"
                                               id="discount{$key}" placeholder="درصد کمیسیون را وارد کنید">
                                    </div>
                                    <input name="user_type{$key}" type="hidden" id="user_type{$key}" value="{$item.id}">
                                </td>
                                <td>
                                    <div class="input-text">
                                        <input type="text" class="form-control textCapacity"
                                               name="maximum_capacity{$key}"
                                               value="{$objResult->users[$item.id]['maximum_capacity']}"
                                               id="maximum_capacity{$key}" placeholder="حداکثر خرید را وارد کنید">
                                    </div>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <input name="countUser" type="hidden" id="countUser" value="{$key}">


                    <h3 class="box-title m-t-40">کاربر مهمان</h3>
                    <hr>
                    <div class="form-group col-sm-12">
                        <div class="checkbox checkbox-success">
                            <input id="guest_user_status" name="guest_user_status" class="form-control" type="checkbox"
                                   value="yes"
                                   {if $objResult->infoRoomPrice['guest_user_status'] eq 'yes'}checked="checked"{/if}>
                            <label for="guest_user_status"> قیمت و درصد تخفیف اتاق ها؛ برای کاربر مهمان همانند مسافرآنلاین محاسبه شود.</label>
                        </div>
                    </div>


                    <h3 class="box-title m-t-40">قیمت گذاری اتاق ها</h3>
                    <hr>
                    {assign var="board_price" value="0"}
                    {assign var="online_price" value="0"}
                    {foreach key=key item=item from=$objResult->hotelRooms}

                        <p class="text-muted m-b-10 textTicketAttention">
                            اتاق {$objPublic->ShowName(reservation_room_type_tb, $item['DBL']['id_room'], 'comment')}</p>
                        <br>
                        <div class="form-group col-sm-12">
                            <div class="table-responsive">
                                <table class="table color-table purple-table" id="TableRoomPrice">
                                    <thead>
                                    <tr>
                                        <th>ظرفیت</th>
                                        <th>قیمت <span class="star">*</span></th>
                                        <th>قیمت برد هتل</th>
                                        <th>قیمت ارزی</th>
                                        <th>نوع ارزی</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    {if $item['DBL']['discount_status'] eq '1'}
                                        {$board_price = 0}
                                        {$online_price = $item['DBL']['board_price']}
                                    {elseif $item['DBL']['discount_status'] eq '2'}
                                        {$board_price = $item['DBL']['board_price']}
                                        {$online_price = $item['DBL']['online_price']}
                                    {/if}

                                    <tr>

                                        <td>
                                            <input type="hidden" id="id_room{$key}" name="id_room{$key}"
                                                   value="{$item['DBL']['id_room']}">
                                            <input type="text" class="form-control" name="total_capacity{$key}"
                                                   value="{$item['DBL']['total_capacity']}" id="total_capacity{$key}"
                                                   placeholder="ظرفیت اتاق را وارد کنید">
                                        </td>
                                        <td>
                                            <div class="input-text">
                                                <input type="text" class="form-control textPrice"
                                                       name="online_price_DBL{$key}"
                                                       value="{$online_price|number_format:0:".":","}"
                                                       id="online_price_DBL{$key}"
                                                       placeholder="قیمت برد هتل را وارد کنید"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                                       aria-invalid="false">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-text">
                                                <input type="text" class="form-control textBoardPrice"
                                                       name="board_price_DBL{$key}"
                                                       value="{$board_price|number_format:0:".":","}"
                                                       id="board_price_DBL{$key}" placeholder="قیمت را وارد کنید"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                                       aria-invalid="false">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="currency_price_DBL{$key}"
                                                   value="{$item['DBL']['currency_price']}"
                                                   id="currency_price_DBL{$key}" placeholder="قیمت ارزی را وارد کنید"
                                                   aria-invalid="false">
                                        </td>
                                        <td>
                                            <select name="currency_type{$key}" id="currency_type{$key}"
                                                    class="form-control ">
                                                <option value="">انتخاب کنید....</option>
                                                {foreach $objCurrencyEquivalent->ListCurrencyEquivalentAdmin() as $currency}
                                                    <option value="{$currency.CurrencyCode}" {if $item['DBL']['currency_type'] eq $currency.CurrencyCode}selected{/if}>{$currency.CurrencyTitle} ({$currency.EqAmount})</option>
                                                {/foreach}
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td> تخت اضافه بزرگسال</td>
                                        <td>
                                            <input type="text" class="form-control" name="online_price_EXT{$key}"
                                                   value="{$item['EXT']['online_price']|number_format:0:".":","}"
                                                   id="online_price_EXT{$key}" placeholder="قیمت برد هتل را وارد کنید"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                                   aria-invalid="false"></td>
                                        <td>
                                            <input type="text" class="form-control" name="board_price_EXT{$key}"
                                                   value="{$item['EXT']['board_price']|number_format:0:".":","}"
                                                   id="board_price_EXT{$key}" placeholder="قیمت را وارد کنید"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                                   aria-invalid="false"></td>
                                        <td>
                                            <input type="text" class="form-control" name="currency_price_EXT{$key}"
                                                   value="{$item['EXT']['currency_price']}"
                                                   id="currency_price_EXT{$key}" placeholder="قیمت ارزی را وارد کنید"
                                                   aria-invalid="false"></td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="d-flex align-items-center"> تخت  کودک از

                                            <select name="childFromAgeECHD{$key}"  id="childFromAgeECHD{$key}" class="form-control  mx-2 " style='width: 45px'>
                                                {for $var=0 to 12}
                                                    <option {if $item['ECHD']['childFromAge'] eq $var}selected{/if} value="{$var}">{$var}</option>
                                                {/for}
                                            </select>
                                            تا

                                            <select name="childToAgeECHD{$key}" id="childToAgeECHD{$key}" class="form-control  mx-2 " style='width: 45px'>
                                                {for $var=0 to 12}
                                                    <option {if $item['ECHD']['childToAge'] eq $var}selected{/if} value="{$var}">{$var}</option>
                                                {/for}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="online_price_ECHD{$key}"
                                                   value="{$item['ECHD']['online_price']|number_format:0:".":","}"
                                                   id="online_price_ECHD{$key}" placeholder="قیمت برد هتل را وارد کنید"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                                   aria-invalid="false">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="board_price_ECHD{$key}"
                                                   value="{$item['ECHD']['board_price']|number_format:0:".":","}"
                                                   id="board_price_ECHD{$key}" placeholder="قیمت را وارد کنید"
                                                   onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                                   aria-invalid="false">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="currency_price_ECHD{$key}"
                                                   value="{$item['ECHD']['currency_price']}"
                                                   id="currency_price_ECHD{$key}" placeholder="قیمت ارزی را وارد کنید"
                                                   aria-invalid="false">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="d-flex align-items-center"> تخت رایگان کودک تا

                                            <select name="childToAgeCHD{$key}" id="childToAgeCHD{$key}" class="form-control  mx-2 " style='width: 45px'>
                                                {for $var=0 to 12}
                                                    <option {if $item['CHD']['childToAge'] eq $var}selected{/if} value="{$var}">{$var}</option>
                                                {/for}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" name="online_price_CHD{$key}"
                                                   id="online_price_CHD{$key}" >
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" name="board_price_CHD{$key}"
                                                   id="board_price_CHD{$key}" >
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" name="currency_price_CHD{$key}"
                                                   id="currency_price_CHD{$key}">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    {/foreach}
                    <input name="countRoom" type="hidden" id="countRoom" value="{$key}">


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary" id="btnInsertTicket">ارسال اطلاعات
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group" style="text-align: center;">
                            <a href="addRoomPricesByIdSame&idHotel={$smarty.get.idHotel}&idSame={$smarty.get.idSame}"
                               class="btn btn-success" style="width: 40%;">اضافه کردن اتاق جدید</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>