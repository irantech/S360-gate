{load_presentation_object filename="settingCore" assign="settingCore"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userCore/listAgencyCore">ثبت ایرلاین برای آژانس</a></li>
                <li class="active">ثبت ایرلاین برای آژانس</li>

            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ثبت اطلاعات پید نیرا برای آژانس  {$smarty.get.agencyName}</h3>

                <form id="insert_airline_core" method="post">
                    <input type="hidden" name="Method" id="Method" value="insertAirlineAgency">
                    <input type="hidden" name="agency_source_id" id="agency_source_id" value="{$smarty.get.sourceAgencyId}">


                    <div class="form-group col-sm-6">

                        <label for="airline" class="control-label">نام ایرلاین</label>

                        <select class="form-control select2" name="airline" id="airline" >
                            <option value="">انتخاب کنید...</option>
                                <option value="EP">آسمان</option>
                                <option value="FP">فلای پرشیا</option>
                                <option value="HH">تابان</option>
                                <option value="IV">کاسپین</option>
                                <option value="I3">آتا</option>
                                <option value="J1">معراج</option>
                                <option value="NV">کارون</option>
                                <option value="IRZ">ساها</option>
                                <option value="PA">پارس ایر</option>
                                <option value="QB">قشم ایر</option>
                                <option value="VR">وارش</option>
                                <option value="Y9">کیش ایر</option>
                                <option value="ZV">زاگرس</option>
                                <option value="A1">ایر وان</option>
                                <option value="RI">چابهار</option>
                                <option value="DZD">یزد ایر</option>
                        </select>

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="userName" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" id="user_name" name="user_name"
                               placeholder="نام کاربری را وارد نمائید">

                    </div>


                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور</label>
                        <input type="text" class="form-control" id="password" name="password"
                               placeholder="کلمه عبور را وارد نمائید">

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                                     id="loadingbank">
                                <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">ارسال</button>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/core.js"></script>


