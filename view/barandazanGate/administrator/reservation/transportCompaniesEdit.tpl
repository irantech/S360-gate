{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_transport_companies_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="typeOfVehicle">نوع وسیله نقلیه</a></li>
                <li><a href="transportCompanies&id={$smarty.get.idTypeVehicle}">شرکت های حمل و نقل</a></li>
                <li class="active">ویرایش شرکت حمل و نقل</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید شرکت حمل و نقل
                    {$objResult->list['name']}
                    را در سیستم ویرایش نمائید</p>

                <form id="EditTransportCompanies" method="post">
                    <input type="hidden" name="flag" value="EditTransportCompanies">
                    <input type="hidden" name="id" value="{$smarty.get.id}">

                    <div class="form-group col-sm-4">
                        <label for="name" class="control-label">نام</label>
                        <input type="text" class="form-control" name="name" value="{$objResult->list['name']}"
                               id="name" placeholder=" نام شرکت حمل و نقل را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="name_en" class="control-label">نام انگلیسی</label>
                        <input type="text" class="form-control" name="name_en" value="{$objResult->list['name_en']}"
                               id="name_en" placeholder=" نام انگلیسی شرکت حمل و نقل را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="abbreviation" class="control-label">کد یاتا</label>
                        <input type="text" class="form-control" name="abbreviation" value="{$objResult->list['abbreviation']}"
                               id="abbreviation" placeholder="کد یاتا را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objResult->list['pic']}"/>
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