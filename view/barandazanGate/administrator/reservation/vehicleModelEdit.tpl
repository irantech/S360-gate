{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_vehicle_model_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="vehicleModel&id={$smarty.get.idModel}">مدل وسیله نقلیه</a></li>
                <li class="active">ویرایش مدل وسیله نقلیه</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید مدل وسیله نقلیه
                    {$objResult->listTypeOfVehicle['name']}
                    را در سیستم ویرایش نمائید</p>

                <form id="EditVehicleModel" method="post">
                    <input type="hidden" name="flag" value="EditVehicleModel">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">


                    <div class="form-group col-sm-6">
                        <label for="vehicle_model" class="control-label">مدل وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_model" value="{$objResult->list['name']}"
                               id="vehicle_model" placeholder="نام وسیله را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="vehicle_abbreviation" class="control-label">نام اختصار وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_abbreviation" value="{$objResult->list['abbreviation']}"
                               id="vehicle_abbreviation" placeholder="نام وسیله را وارد نمائید">
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