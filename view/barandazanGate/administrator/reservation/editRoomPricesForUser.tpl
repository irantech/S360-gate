{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}

{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
{$objBasic->SelectAllWithCondition('reservation_hotel_room_prices_tb', 'id', $smarty.get.id)}

{$objResult->SelectRoomPrices($objBasic->list['id_city'], $objBasic->list['id_hotel'], $objBasic->list['id_room'], $objBasic->list['user_type'], $objBasic->list['id_same'])}

{assign var="board_price" value="0"}
{assign var="online_price" value="0"}

{if $objResult->listRoomPrices_DBL['discount_status'] eq '1'}
    {$board_price = 0}
    {$online_price = $objResult->listRoomPrices_DBL['board_price']}
{elseif $objResult->listRoomPrices_DBL['discount_status'] eq '2'}
    {$board_price = $objResult->listRoomPrices_DBL['board_price']}
    {$online_price = $objResult->listRoomPrices_DBL['online_price']}
{/if}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li><a href="reportHotelRoom&city={$objResult->listRoomPrices_DBL['id_city']}&hotel={$objResult->listRoomPrices_DBL['id_hotel']}">گزارش اتاق های هتل</a></li>
                <li class="active">ویرایش قیمت اتاق</li>
            </ol>
        </div>
    </div>

    <form id="editRoomPricesForUser" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
        <input type="hidden" name="flag" value="editRoomPricesForUser">
        <input type="hidden" name="edit" value="editRoomPricesForUser">
        <input type="hidden" name="id" value="{$smarty.get.id}">
        <input type="hidden" name="sDate" value="{$smarty.get.sDate}">
        <input type="hidden" name="eDate" value="{$smarty.get.eDate}">

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <div class="row show-grid">
                    <div class="col-md-4">
                        <b>شهر: </b>
                        <input type="hidden" id="id_city" name="id_city" value="{$objResult->listRoomPrices_DBL['id_city']}">
                        {$objPublic->ShowName(reservation_city_tb, $objResult->listRoomPrices_DBL['id_city'])}
                    </div>
                    <div class="col-md-4">
                        <b>هتل: </b>
                        <input type="hidden" id="id_hotel" name="id_hotel" value="{$objResult->listRoomPrices_DBL['id_hotel']}">
                        {$objPublic->ShowName(reservation_hotel_tb, $objResult->listRoomPrices_DBL['id_hotel'])}
                    </div>
                    <div class="col-md-4">
                        <b>کانتر: </b>
                        <input type="hidden" id="user_type" name="user_type" value="{$objResult->listRoomPrices_DBL['user_type']}">
                        {$objPublic->ShowName(counter_type_tb, $objResult->listRoomPrices_DBL['user_type'])}
                    </div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4">
                        <b>اتاق: </b>
                        <input type="hidden" id="id_room" name="id_room" value="{$objResult->listRoomPrices_DBL['id_room']}">
                        {$objPublic->ShowName(reservation_room_type_tb, $objResult->listRoomPrices_DBL['id_room'], 'comment')}
                    </div>
                    <div class="col-md-4">
                        <b>از تاریخ: </b>
                        <input type="hidden" id="start_date" name="start_date" value="{$smarty.get.sDate}">
                        {$objPublic->format_Date($smarty.get.sDate)}
                    </div>
                    <div class="col-md-4">
                        <b>تا تاریخ: </b>
                        <input type="hidden" id="end_date" name="end_date" value="{$smarty.get.eDate}">
                        {$objPublic->format_Date($smarty.get.eDate)}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <p class="text-muted m-b-10">توجه : کاربر گرامی قیمت برای مسافر آنلاین به این صورت می باشد که مقدار درصد تخفیف را از کل کم کنید و مابقی را در باکس بزنید.نمونه 93% می خواهید از کل مبلغ اصلی.</p>
                <p class="text-muted m-b-10">در باکس تعداد شب بصورت پیش فرض 15 شب در نظر گرفته شده است. اگر این رنج شب مد نظر نمی باشد لطفا مانند نمونه تعداد شب های مورد نظر را وارد نمائید.</p>

                <div class="form-group col-sm-4">
                        <label for="onrequest_time" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="onrequest_time" value="{$objResult->listRoomPrices_DBL['onrequest_time']}"
                               id="onrequest_time" placeholder="... ساعت مانده به ورود">
                    </div>

                     <div class="form-group col-sm-4">
                        <label for="reserve_time_canceled" class="control-label">زمان باطل شدن رزرو (ساعت)</label>
                        <input type="text" class="form-control" name="reserve_time_canceled" value="{$objResult->listRoomPrices_DBL['reserve_time_canceled']}"
                               id="reserve_time_canceled" placeholder="... ساعت">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="sell_for_night" class="control-label">فروش برای (نمونه 3/5/7/10) شب</label>
                        <input type="text" class="form-control" name="sell_for_night" value="{$objResult->listRoomPrices_DBL['sell_for_night']}"
                               id="sell_for_night" placeholder="فروش برای تعداد شب را وارد کنید.">
                    </div>


                    <div class="form-group col-sm-4">
                        <label for="maximum_capacity" class="control-label">حداکثر خرید</label>
                        <input type="text" class="form-control" name="maximum_capacity" value="{$objResult->listRoomPrices_DBL['maximum_capacity']}"
                               id="maximum_capacity" placeholder="حداکثر خرید vh را وارد کنید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="total_capacity" class="control-label">ظرفیت اصلی</label>
                        <input type="text" class="form-control" name="total_capacity" value="{$objResult->listRoomPrices_DBL['total_capacity']}"
                               id="total_capacity" placeholder="ظرفیت اصلی را وارد کنید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="discount" class="control-label">کمسیون</label>
                        <input type="text" class="form-control" name="discount" value="{$objResult->listRoomPrices_DBL['discount']}"
                               id="discount" placeholder="کمسیون را وارد کنید">
                    </div>


                    <h3 class="box-title m-t-40">خدمات اتاق</h3>
                    <hr>
                    <div class="form-group col-sm-12">

                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="breakfast" name="breakfast" class="form-control" type="checkbox" value="yes"
                                       {if $objResult->listRoomPrices_DBL['breakfast'] eq 'yes'}checked="checked"{/if}>
                                <label for="breakfast"> صبحانه </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="lunch" name="lunch" class="form-control" type="checkbox" value="yes"
                                       {if $objResult->listRoomPrices_DBL['lunch'] eq 'yes'}checked="checked"{/if}>
                                <label for="lunch"> ناهار </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label class="control-label"></label>
                            <div class="checkbox checkbox-success">
                                <input id="dinner" name="dinner" class="form-control" type="checkbox" value="yes"
                                       {if $objResult->listRoomPrices_DBL['dinner'] eq 'yes'}checked="checked"{/if}>
                                <label for="dinner"> شام </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="other_services" class="control-label">گشت و سایر خدمات</label>
                        <textarea type="text" class="form-control" name="other_services" id="other_services">
                            {$objResult->listRoomPrices_DBL['other_services']}
                        </textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="specific_description" class="control-label">توضیحات خاص</label>
                        <textarea type="text" class="form-control" name="specific_description" id="specific_description">
                            {$objResult->listRoomPrices_DBL['specific_description']}
                        </textarea>
                    </div>

                    <h3 class="box-title m-t-40">نحوه نمایش قیمت اتاق ها</h3>
                    <div class="form-group col-sm-12">
                        <div class="radio-inline col-sm-5">
                            <div class="radio radio-info">
                                <input type="radio" name="discount_status" id="discount_status1" value="1"
                                       {if $objResult->listRoomPrices_DBL['discount_status'] eq '1'}checked="checked"{/if}>
                                <label for="discount_status1">نمایش قیمت و اعمال درصد کمسیون برای تخفیف</label>
                            </div>
                        </div>
                        <div class="radio-inline col-sm-6">
                            <div class="radio radio-info">
                                <input type="radio" name="discount_status" id="discount_status2" value="2"
                                       {if $objResult->listRoomPrices_DBL['discount_status'] eq '2'}checked="checked"{/if}>
                                <label for="discount_status2">نمایش قیمت و قیمت بردهتل (محاسبه درصد تخفیف بر اساس قیمت و قیمت بردهتل)</label>
                            </div>
                        </div>
                    </div>

                    <h3 class="box-title m-t-40">کاربر مهمان</h3>
                    <hr>
                    <div class="form-group col-sm-12">
                        <div class="checkbox checkbox-success">
                            <input id="guest_user_status" name="guest_user_status" class="form-control" type="checkbox" value="yes"
                                   {if $objResult->listRoomPrices_DBL['guest_user_status'] eq 'yes'}checked="checked"{/if}>
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
                                    <th>نوع تخت</th>
                                    <th>قیمت</th>
                                    <th>قیمت برد هتل</th>
                                    <th>قیمت ارزی</th>
                                    <th>نوع ارزی</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input name="age1" type="hidden" id="age1" value="DBL"> تخت اصلی </td>
                                    <td>
                                        <div class="input-text">
                                        <input type="text" class="form-control textPrice" name="online_price1" value="{$online_price|number_format:0:".":","}" id="online_price1" placeholder="قیمت برد هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-text">
                                        <input type="text" class="form-control textBoardPrice" name="board_price1" value="{$board_price|number_format:0:".":","}" id="board_price1" placeholder="قیمت را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="currency_price1" value="{$objResult->listRoomPrices_DBL['currency_price']|number_format:0:".":","}" id="currency_price1" placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                                    </td>
                                    {load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
                                    <td>
                                        <select name="currency_type" id="currency_type" class="form-control ">
{*                                            <option value="{$objResult->listRoomPrices_DBL['currency_type']}">{$objResult->listRoomPrices_DBL['currency_type']}</option>*}
                                            <option value="0">ندارد</option>
                                            {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}

                                                <option value="{$item.CurrencyCode}"  {if $objResult->listRoomPrices_DBL['currency_type'] == $item.CurrencyCode} selected {/if}>{$item.CurrencyTitle}({$item.EqAmount})</option>
                                            {/foreach}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="age2" type="hidden" id="age2" value="EXT"> تخت اضافه بزرگسال </td>
                                    <td><input type="text" class="form-control" name="online_price2" disabled value="{$objResult->listRoomPrices_EXT['online_price']|number_format:0:".":","}" id="online_price2" placeholder="قیمت برد هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="board_price2" disabled value="{$objResult->listRoomPrices_EXT['board_price']|number_format:0:".":","}" id="board_price2" placeholder="قیمت را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="currency_price2" disabled value="{$objResult->listRoomPrices_EXT['currency_price']|number_format:0:".":","}" id="currency_price2" placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td  class="d-flex align-items-center"><input name="age3" type="hidden" id="age3" value="ECHD">
                                        تخت کودک
                                        <select name="childFromAge3" id="childFromAge3" class="form-control  mx-2 " style='width: 45px'>
                                            {for $var=0 to 12}
                                                <option {if $objResult->listRoomPrices_ECHD['fromAge'] eq $var}selected{/if} value="{$var}">{$var}</option>
                                            {/for}
                                        </select>
                                        تا
                                        <select name="childToAge3" id="childToAge3" class="form-control  mx-2 " style='width: 45px'>
                                            {for $var=0 to 12}
                                                <option {if $objResult->listRoomPrices_ECHD['toAge'] eq $var}selected{/if} value="{$var}">{$var}</option>
                                            {/for}
                                        </select>
                                        سال
                                    </td>
                                    <td><input type="text" class="form-control" name="online_price3" value="{$objResult->listRoomPrices_ECHD['online_price']|number_format:0:".":","}" id="online_price3" placeholder="قیمت برد هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="board_price3" value="{$objResult->listRoomPrices_ECHD['board_price']|number_format:0:".":","}" id="board_price3" placeholder="قیمت را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="text" class="form-control" name="currency_price3" value="{$objResult->listRoomPrices_ECHD['currency_price']|number_format:0:".":","}" id="currency_price3" placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td  class="d-flex align-items-center"><input name="age4" type="hidden" id="age4" value="CHD">
                                        تخت رایگان کودک تا
                                        <select name="childToAge4" id="childToAge4" class="form-control  mx-2 " style='width: 45px'>
                                            {for $var=0 to 12}
                                                <option {if $objResult->listRoomPrices_CHD['toAge'] eq $var}selected{/if} value="{$var}">{$var}</option>
                                            {/for}
                                        </select>
                                        سال
                                    </td>
                                    <td><input type="hidden" class="form-control" name="online_price4" value="{$objResult->listRoomPrices_ECHD['online_price']|number_format:0:".":","}" id="online_price4" placeholder="قیمت برد هتل را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="hidden" class="form-control" name="board_price4" value="{$objResult->listRoomPrices_ECHD['board_price']|number_format:0:".":","}" id="board_price4" placeholder="قیمت را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td><input type="hidden" class="form-control" name="currency_price4" value="{$objResult->listRoomPrices_ECHD['currency_price']|number_format:0:".":","}" id="currency_price4" placeholder="قیمت ارزی را وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false"></td>
                                    <td></td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>


            </div>

        </div>
    </div>
    </form>

</div>





<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>
