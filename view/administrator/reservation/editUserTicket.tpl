{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

{$objResult->getInfoTicket($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li><a href="reportTicket">گزارش چارتر</a></li>
                <li><a href="dailyTicket&airline={$objResult->infoTicket.airline}&flyCode={$objResult->infoTicket.fly_code}">گزارش پرواز روزانه</a></li>
                <li class="active">ویرایش پرواز (کاربران - کلاس نرخی)</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش پرواز (کاربران - کلاس نرخی)</h3>

                <div class="row show-grid">
                    <div class="col-md-6"><b>مبدا: </b>{$objPublic->ShowName(reservation_country_tb,$objResult->infoTicket.origin_country)} - {$objPublic->ShowName(reservation_city_tb,$objResult->infoTicket.origin_city)}</div>
                    <div class="col-md-6"><b>مقصد: </b>{$objPublic->ShowName(reservation_country_tb,$objResult->infoTicket.destination_country)} - {$objPublic->ShowName(reservation_city_tb,$objResult->infoTicket.destination_city)}</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-3"><b>شرکت حمل و نقل: </b>{$objPublic->ShowNameBase(airline_tb,name_fa,$objResult->infoTicket.airline)}</div>
                    <div class="col-md-3"><b>شماره پرواز: </b>{$objPublic->getFlyNumber($objResult->infoTicket.fly_code)}</div>
                    <div class="col-md-2"><b>مدت زمان پرواز: </b>{$objResult->infoTicket.time}</div>
                    <div class="col-md-2"><b>کلاس نرخی: </b>{$objResult->infoTicket.vehicle_grade}</div>
                    <div class="col-md-2"><b>میزان بار رایگان: </b>{$objResult->infoTicket.free}</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4"><b>کاربر: </b>{$objPublic->ShowName(counter_type_tb,$objResult->infoTicket.type_user)}</div>
                    <div class="col-md-4"><b>روز: </b>{$objPublic->nameDayWeek($objResult->infoTicket.date)}</div>
                    <div class="col-md-4"><b>تاریخ: </b>{$objPublic->format_Date($objResult->infoTicket.date)}</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4"><b>ظرفیت کل: </b>{$objResult->infoTicket.fly_total_capacity}</div>
                    <div class="col-md-4"><b>ظرفیت کل پر شده: </b>{$objResult->infoTicket.fly_full_capacity}</div>
                    <div class="col-md-4"><b>فضای آزاد: </b>{$objResult->infoTicket.remaining_capacity}</div>
                </div>

            </div>
        </div>

    </div>



    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30"></p>

                <form id="FormEditOneTicket" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="editOneTicket">
                    <input type="hidden" name="id" id="id" value="{$smarty.get.id}">
                    {*<input type="hidden" name="type_user" id="type_user" value="{$objResult->infoTicket.type_user}">
                    <input type="hidden" name="date" id="date" value="{$objResult->infoTicket.date}">
                    <input type="hidden" value="{$objResult->infoTicket['origin_country']}" name="origin_country" id="origin_country">
                    <input type="hidden" value="{$objResult->infoTicket['origin_city']}" name="origin_city" id="origin_city">
                    <input type="hidden" value="{$objResult->infoTicket['destination_country']}" name="destination_country" id="destination_country">
                    <input type="hidden" value="{$objResult->infoTicket['destination_city']}" name="destination_city" id="destination_city">
                    <input type="hidden" value="{$objResult->infoTicket['airline']}" name="airline" id="airline">
                    <input type="hidden" value="{$objResult->infoTicket['fly_code']}" name="fly_code" id="fly_code">*}

                    <div class="form-group col-sm-4">
                        <label for="type_of_vehicle" class="control-label">مدل وسیله نقلیه</label><span class="star">*</span>
                        <select name="type_of_vehicle" id="type_of_vehicle" class="form-control ">
                            <option value="{$objResult->infoTicket.type_of_vehicle}">{$objResult->getTypeOfVehicle($objResult->infoTicket.type_of_vehicle)}</option>
                            <option value="">انتخاب کنید....</option>
                            {foreach key=key item=item from=$objResult->showTypeOfVehicle()}
                            <option value="{$item[0]}">{$item[2]} - {$item[1]}</option>
                            {/foreach}
                        </select>
                    </div>

                    {$objPublic->explodeTime($objResult->infoTicket.exit_hour)}
                    <div class="form-group col-sm-4">
                        <label for="minutes" class="control-label">ساعت حرکت پرواز (دقیقه)</label><span class="star">*</span>
                        <select name="minutes" id="minutes" class="form-control ">
                            <option value="{$objPublic->minutes}">{$objPublic->minutes}</option>
                            {for $n=0 to 9}
                                <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 60}
                                <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="hours" class="control-label">ساعت حرکت پرواز (ساعت)</label><span class="star">*</span>
                        <select name="hours" id="hours" class="form-control ">
                            <option value="{$objPublic->hours}">{$objPublic->hours}</option>
                            {for $n=0 to 9}
                                <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 24}
                                <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>


                    <div class="form-group col-sm-3">
                        <label for="day_onrequest" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="day_onrequest" value="{$objResult->infoTicket.day_onrequest}"
                               id="day_onrequest" placeholder="زمان توقف فروش را وارد کنید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="total_capacity" class="control-label">ظرفیت کل</label><span class="star">*</span>
                        <input type="text" class="form-control" name="total_capacity" value="{$objResult->infoTicket['fly_total_capacity']}"
                               id="total_capacity" placeholder="ظرفیت کل را وارد کنید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="maximum_buy" class="control-label">حداکثر خرید</label><span class="star">*</span>
                        <input type="text" class="form-control" name="maximum_buy" value="{$objResult->infoTicket['maximum_buy']}"
                               id="maximum_buy" placeholder="حداکثر خرید را وارد کنید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="comition_ticket" class="control-label">درصد کمیسیون</label><span class="star">*</span>
                        <input type="text" class="form-control" name="comition_ticket" value="{$objResult->infoTicket['comition_ticket']}"
                               id="comition_ticket" placeholder="درصد کمیسیون را وارد کنید">
                    </div>




                    {*<div class="form-group col-sm-3">
                        <label for="sales_type" class="control-label">نوع فروش</label>
                        <select name="sales_type" id="sales_type" class="form-control ">
                            <option value="" {if $objResult->infoTicket.sales_type eq ''}selected{/if}>انتخاب کنید....</option>
                            <option value="1" {if $objResult->infoTicket.sales_type eq '1'}selected{/if}>فروش معمولی</option>
                            <option value="2" {if $objResult->infoTicket.sales_type eq '2'}selected{/if}>افزایش نرخ</option>
                            <option value="3" {if $objResult->infoTicket.sales_type eq '3'}selected{/if}>توقف فروش</option>
                            <option value="4" {if $objResult->infoTicket.sales_type eq '4'}selected{/if}>فروش دو طرفه</option>
                            <option value="5" {if $objResult->infoTicket.sales_type eq '5'}selected{/if}>چارتر</option>
                            <option value="6" {if $objResult->infoTicket.sales_type eq '6'}selected{/if}>کنسل شد</option>
                            <option value="7" {if $objResult->infoTicket.sales_type eq '7'}selected{/if}>سهمیه تور</option>
                            <option value="8" {if $objResult->infoTicket.sales_type eq '8'}selected{/if}>عدم نمایش</option>
                            <option value="9" {if $objResult->infoTicket.sales_type eq '9'}selected{/if}>فروش فوق العاده</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="reservation_time_canceled" class="control-label">زمان باطل شدن رزرو</label>
                        <input type="text" class="form-control" name="reservation_time_canceled" value="{$objResult->infoTicket.reservation_time_canceled}"
                               id="reservation_time_canceled" placeholder="زمان باطل شدن رزرو را وارد کنید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="request_time_canceled" class="control-label">زمان باطل شدن درخواست</label>
                        <input type="text" class="form-control" name="request_time_canceled" value="{$objResult->infoTicket.request_time_canceled}"
                               id="request_time_canceled" placeholder="زمان باطل شدن درخواست را وارد کنید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="open" class="control-label">فروش open</label>
                        <select name="open" id="open" class="form-control ">
                            <option value="" {if $objResult->infoTicket.open eq ''}selected{/if}>انتخاب کنید</option>
                            <option value="0" {if $objResult->infoTicket.open eq '0'}selected{/if}>ندارد</option>
                            <option value="1" {if $objResult->infoTicket.open eq '1'}selected{/if}>دارد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="tour_capacity" class="control-label">ظرفیت حداقل با تور</label>
                        <input type="text" class="form-control" name="tour_capacity" value="{$objResult->infoTicket.fly_tour_capacity}"
                               id="tour_capacity" placeholder="ظرفیت حداقل با تور را وارد کنید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="cost_open" class="control-label">قیمت فروش open</label>
                        <input type="text" class="form-control" name="cost_open" value="{$objResult->infoTicket.cost_open}" id="cost_open"
                               placeholder="قیمت فروش open را وارد کنید">
                    </div>*}





                    <br>
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
                                    <input name="id1" type="hidden" id="id1" value="{$objResult->infoTicket.idADL}">
                                    <td><input type="text" class="form-control" name="cost_two_way1" value="{$objResult->infoTicket.cost_two_wayADL}" id="cost_two_way1" placeholder="قیمت یک LEG از دو طرفه" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_two_way_print1" value="{$objResult->infoTicket.cost_two_way_printADL}" id="cost_two_way_print1" placeholder="قیمت چاپ" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_one_way1" value="{$objResult->infoTicket.cost_one_wayADL}" id="cost_one_way1" placeholder="قیمت یکطرفه" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_one_way_print1" value="{$objResult->infoTicket.cost_one_way_printADL}" id="cost_one_way_print1" placeholder="قیمت چاپ" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_Ndays1" value="{$objResult->infoTicket.cost_NdaysADL}" id="cost_Ndays1" placeholder="قیمت بیش از n روز" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                </tr>
                                <tr>
                                    <td>کودک(2 تا 12)</td>
                                    <input name="id2" type="hidden" id="id2" value="{$objResult->infoTicket.idCHD}">
                                    <td><input type="text" class="form-control" name="cost_two_way2" value="{$objResult->infoTicket.cost_two_wayCHD}" id="cost_two_way2" placeholder="قیمت یک LEG از دو طرفه" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_two_way_print2" value="{$objResult->infoTicket.cost_two_way_printCHD}" id="cost_two_way_print2" placeholder="قیمت چاپ" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_one_way2" value="{$objResult->infoTicket.cost_one_wayCHD}" id="cost_one_way2" placeholder="قیمت یکطرفه" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_one_way_print2" value="{$objResult->infoTicket.cost_one_way_printCHD}" id="cost_one_way_print2" placeholder="قیمت چاپ" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_Ndays2" value="{$objResult->infoTicket.cost_NdaysCHD}" id="cost_Ndays2" placeholder="قیمت بیش از n روز" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                </tr>
                                <tr>
                                    <td>نوزاد(2-)</td>
                                    <input name="id3" type="hidden" id="id3" value="{$objResult->infoTicket.idINF}">
                                    <td><input type="text" class="form-control" name="cost_two_way3" value="{$objResult->infoTicket.cost_two_wayINF}" id="cost_two_way3" placeholder="قیمت یک LEG از دو طرفه" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_two_way_print3" value="{$objResult->infoTicket.cost_two_way_printINF}" id="cost_two_way_print3" placeholder="قیمت چاپ" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_one_way3" value="{$objResult->infoTicket.cost_one_wayINF}" id="cost_one_way3" placeholder="قیمت یکطرفه" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_one_way_print3" value="{$objResult->infoTicket.cost_one_way_printINF}" id="cost_one_way_print3" placeholder="قیمت چاپ" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                    <td><input type="text" class="form-control" name="cost_Ndays3" value="{$objResult->infoTicket.cost_NdaysINF}" id="cost_Ndays3" placeholder="قیمت بیش از n روز" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="description_ticket" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control" name="description_ticket" id="description_ticket">{$objResult->infoTicket.description_ticket}</textarea>
                    </div>


                    <div class="form-group col-sm-12">
                        <label for="services_ticket" class="control-label">خدمات</label>
                        <textarea type="text" class="form-control"
                                  name="services_ticket" id="services_ticket" placeholder="">{$objResult->infoTicket.services_ticket}</textarea>
                    </div>

                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="chk_flag_special" name="chk_flag_special" type="checkbox" value="1"
                                   {if $objResult->infoTicket['flag_special'] eq 'yes'}checked{/if}>
                            <label for="chk_flag_special"> ویژه </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            {*if $objResult->infoTicket.fly_full_capacity eq 0*}
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                            {*/if*}
                        </div>
                    </div>

                </form>



            </div>

        </div>
    </div>




</div>

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>