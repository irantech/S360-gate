{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_vehicle_grade_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="vehicleGrade">درجه وسیله نقلیه</a></li>
                <li class="active">ویرایش درجه وسیله نقلیه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید درجه وسیله نقلیه را در سیستم ویرایش نمائید</p>

                <form id="EditVehicleGrade" method="post">
                    <input type="hidden" name="flag" value="EditVehicleGrade">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">


                    <div class="form-group col-sm-6">
                        <label for="vehicle_grade" class="control-label">درجه وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_grade" value="{$objResult->list['name']}"
                               id="vehicle_grade" placeholder="نام وسیله را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="vehicle_grade_abbreviation" class="control-label">نام اختصار وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_grade_abbreviation" value="{$objResult->list['abbreviation']}"
                               id="vehicle_grade_abbreviation" placeholder="نام اختصار وسیله را وارد نمائید">
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