{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->getCounterType()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="mainUserList">کاربران اصلی</a></li>
                <li class="active">افزودن کاربر جدید</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن کابر جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید کاربر جدیدی را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="AddMainUser" method="post">
                    <input type="hidden" name="flag" id="flag" value="insert_user">
                    <input type="hidden" name="agency_id" id="agency_id" value="{$smarty.get.agencyID}">
                    <div class="form-group col-sm-6 ">
                        <label for="name" class="control-label">نام کاربر</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="نام  کاربر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="family" class="control-label">نام خانوادگی کاربر</label>
                        <input type="text" class="form-control" id="family" name="family"
                               placeholder="نام خانوادگی کاربر را وارد نمائید">

                    </div>


                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">شماره تلفن همراه</label>
                        <input type="text" class="form-control" id="mobile" name="mobile"
                               placeholder=" شماره تلفن همراه کاربر را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="email" class="control-label">ایمیل کانتر</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="ایمیل کاربر را وارد نمائید"
                        >

                    </div>


                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور کاربر</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="کلمه عبور کاربر را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                        <input type="password" class="form-control" id="Confirm" name="Confirm"
                               placeholder="تکرار رمز عبور">

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/mainUser.js"></script>

