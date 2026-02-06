{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li class="active">افزودن تور یک روزه</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormOneDayTour" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_oneDayTour">

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور</label>
                        <select name="origin_country" id="origin_country" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListCountry() as $country}
                            <option value="{$country['id']}">{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر</label>
                        <select name="origin_city" id="origin_city" class="form-control" onChange="ShowAllHotel()">

                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_region" class="control-label">منطقه</label>
                        <select name="origin_region" id="origin_region" class="form-control ">
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="hotel_name" class="control-label">نام هتل</label>
                        <select name="hotel_name" id="hotel_name" class="form-control">
                            <option value="">انتخاب کنید....</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان تور</label>
                        <input type="text" class="form-control" name="title" value=""
                               id="title" placeholder="عنوان تور را وارد کنید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="adt_price_rial" class="control-label">قیمت بزرگسال (ریالی)</label>
                        <input type="text" class="form-control" name="adt_price_rial" value=""
                               id="adt_price_rial" placeholder="قیمت بزرگسال را به ریال وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="chd_price_rial" class="control-label">قیمت کودک (ریالی)</label>
                        <input type="text" class="form-control" name="chd_price_rial" value=""
                               id="chd_price_rial" placeholder="قیمت کودک را به ریال وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="inf_price_rial" class="control-label">قیمت نوزاد (ریالی)</label>
                        <input type="text" class="form-control" name="inf_price_rial" value=""
                               id="inf_price_rial" placeholder="قیمت نوزاد را به ریال وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>

                    {*<div class="form-group col-sm-4">
                        <label for="adt_price_foreign" class="control-label">قیمت بزرگسال (ارزی)</label>
                        <input type="text" class="form-control" name="adt_price_foreign" value=""
                               id="adt_price_foreign" placeholder="قیمت بزرگسال را به ارزی وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="chd_price_foreign" class="control-label">قیمت کودک (ارزی)</label>
                        <input type="text" class="form-control" name="chd_price_foreign" value=""
                               id="chd_price_foreign" placeholder="قیمت کودک را به ارزی وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="inf_price_foreign" class="control-label">قیمت نوزاد (ارزی)</label>
                        <input type="text" class="form-control" name="inf_price_foreign" value=""
                               id="inf_price_foreign" placeholder="قیمت نوزاد را به ارزی وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>*}

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
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
                <h3 class="box-title m-b-0">تور یک روزه</h3>
                <p class="text-muted m-b-30">تمامی تورهای یک روزه وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کشور</th>
                            <th>شهر</th>
                            <th>هتل</th>
                            <th>عنوان</th>
                            <th>قیمت بزرگسال (ریالی)</th>
                            {*<th>قیمت بزرگسال (ارزی)</th>*}
                            <th>قیمت کودک (ریالی)</th>
                            {*<th>قیمت کودک (ارزی)</th>*}
                            <th>قیمت نوزاد (ریالی)</th>
                            {*<th>قیمت نوزاد (ارزی)</th>*}
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objBasic->SelectAll('reservatin_one_day_tour_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>
                            <td>{$objPublic->ShowName(reservation_country_tb,$item.id_country)}</td>
                            <td>{$objPublic->ShowName(reservation_city_tb,$item.id_city)}</td>
                            <td>{$objPublic->ShowName(reservation_hotel_tb,$item.id_hotel)}</td>
                            <td>{$item.title}</td>
                            <td>{$item.adt_price_rial}</td>
                            {*<td>{$item.adt_price_foreign}</td>*}
                            <td>{$item.chd_price_rial}</td>
                            {*<td>{$item.chd_price_foreign}</td>*}
                            <td>{$item.inf_price_rial}</td>
                            {*<td>{$item.inf_price_foreign}</td>*}
                            <td>
                                <a href="editOneDayTour&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تور یک روزه" data-placement="right"
                                   data-content="امکان حذف وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>

                                <!--<a id="DelChangePrice-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservatin_one_day_tour_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                </a>-->
                            </td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>