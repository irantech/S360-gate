{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}

{$objBasic->SelectAllWithCondition('reservatin_one_day_tour_tb', 'id', $smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li class="active">ویرایش تور یک روزه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات تور را در سیستم ویرایش نمائید</p>

                <form id="EditOneDayTour" method="post">
                    <input type="hidden" name="flag" value="EditOneDayTour">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور</label>
                        <select name="origin_country" id="origin_country" class="form-control ">
                            {if $objBasic->list['id_country'] neq ''}
                            <option value="{$objBasic->list['id_country']}">{$objPublic->ShowName(reservation_country_tb,$objBasic->list['id_country'])}</option>
                            {else}
                            <option value="">انتخاب کنید....</option>
                            {/if}
                            {foreach $objPublic->ListCountry() as $country}
                            <option value="{$country['id']}">{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر</label>
                        <select name="origin_city" id="origin_city" class="form-control" onChange="ShowAllHotel()">
                            {if $objBasic->list['id_city'] neq ''}
                            <option value="{$objBasic->list['id_city']}">{$objPublic->ShowName(reservation_city_tb,$objBasic->list['id_city'])}</option>
                            {else}
                            <option value="">انتخاب کنید....</option>
                            {/if}
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
                            {if $objBasic->list['id_hotel'] neq ''}
                            <option value="{$objBasic->list['id_hotel']}">{$objPublic->ShowName(reservation_hotel_tb,$objBasic->list['id_hotel'])}</option>
                            {else}
                            <option value="">انتخاب کنید....</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان تور</label>
                        <input type="text" class="form-control" name="title" value="{$objBasic->list['title']}"
                               id="title" placeholder="عنوان تور را وارد کنید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="adt_price_rial" class="control-label">قیمت بزرگسال (ریالی)</label>
                        <input type="text" class="form-control" name="adt_price_rial" value="{$objBasic->list['adt_price_rial']}"
                               id="adt_price_rial" placeholder="قیمت بزرگسال را به ریال وارد کنید" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="chd_price_rial" class="control-label">قیمت کودک (ریالی)</label>
                        <input type="text" class="form-control" name="chd_price_rial" value="{$objBasic->list['chd_price_rial']}"
                               id="chd_price_rial" placeholder="قیمت کودک را به ریال وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="inf_price_rial" class="control-label">قیمت نوزاد (ریالی)</label>
                        <input type="text" class="form-control" name="inf_price_rial" value="{$objBasic->list['inf_price_rial']}"
                               id="inf_price_rial" placeholder="قیمت نوزاد را به ریال وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>

                    {*<div class="form-group col-sm-4">
                        <label for="adt_price_foreign" class="control-label">قیمت بزرگسال (ارزی)</label>
                        <input type="text" class="form-control" name="adt_price_foreign" value="{$objBasic->list['adt_price_foreign']}"
                               id="adt_price_foreign" placeholder="قیمت بزرگسال را به ارزی وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="chd_price_foreign" class="control-label">قیمت کودک (ارزی)</label>
                        <input type="text" class="form-control" name="chd_price_foreign" value="{$objBasic->list['chd_price_foreign']}"
                               id="chd_price_foreign" placeholder="قیمت کودک را به ارزی وارد کنید"
                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" aria-invalid="false">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="inf_price_foreign" class="control-label">قیمت نوزاد (ارزی)</label>
                        <input type="text" class="form-control" name="inf_price_foreign" value="{$objBasic->list['inf_price_foreign']}"
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

</div>


<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>