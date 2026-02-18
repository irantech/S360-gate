{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

{$objResult->SelectAllWithCondition('reservation_type_of_vehicle_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="typeOfVehicle">نوع وسیله نقلیه</a></li>
                <li class="active">ویرایش وسیله نقلیه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید نام وسیله نقلیه را در سیستم ویرایش نمائید</p>

                <form id="EditTypeOfVehicle" method="post">
                    <input type="hidden" name="flag" value="EditTypeOfVehicle">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">


                    <div class="form-group col-sm-6">
                        <label for="vehicle_name" class="control-label">نام وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_name" value="{$objResult->list['name']}"
                               id="vehicle_name" placeholder="نام وسیله را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="vehicle_name" class="control-label">انتخاب نوع</label>
                    <select name="vehicle_type" id="vehicle_type" class="form-control">
                        <option value="">انتخاب کنید....</option>
                        <option value="plane" {if {$objResult->list['type']} eq 'plane'}selected{/if}>هواپیما</option>
                        <option value="bus" {if {$objResult->list['type']} eq 'bus'}selected{/if}>اتوبوس</option>
                        <option value="train" {if {$objResult->list['type']} eq 'train'}selected{/if}>قطار</option>
                        <option value="ship" {if {$objResult->list['type']} eq 'ship'}selected{/if}>کشتی</option>
                        <option value="contactUs" {if {$objResult->list['type']} eq 'contactUs'}selected{/if}>تماس بگیرید</option>
                    </select>
                    </div>

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