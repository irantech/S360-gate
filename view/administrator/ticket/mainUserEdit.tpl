{load_presentation_object filename="members" assign="objCounter"}
{load_presentation_object filename="agency" assign="objAgency"}
{$objCounter->showedit($smarty.get.id)}
{$objAgency->getCounterType()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li><a href="counterList&id={$smarty.get.agencyID}">کاربرها</a></li>
                <li class="active">ویرایش کاربر </li>
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
                <h3 class="box-title m-b-0">ویرایش کاربر </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اطلاعات  کاربر  را در سیستم ویرایش نمائید</p>

                <form  id="EditMainUser" method="post">
                    <input type="hidden" name="flag" id="flag" value="update_user">
                    <input type="hidden" name="memberID" id="memberID" value="{$objCounter->list['id']}">
                    <div class="form-group col-sm-6 ">

                        <label for="name" class="control-label">نام فارسی کاربر</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="نام فارسی کاربر را وارد نمائید" value="{$objCounter->list['name']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="family" class="control-label">نام خانوادگی فارسی کاربر</label>
                        <input type="text" class="form-control" id="family" name="family"
                               placeholder="نام خانوادگی کاربر را وارد نمائید" value="{$objCounter->list['family']}">

                    </div>
                    <div class="form-group col-sm-6 ">

                        <label for="name_en" class="control-label">نام انگلیسی کاربر</label>
                        <input type="text" class="form-control" id="name_en" name="name_en"
                               placeholder="نام انگلیسی کاربر را وارد نمائید" value="{$objCounter->list['name_en']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="family_en" class="control-label">نام خانوادگی انگلیسی کاربر</label>
                        <input type="text" class="form-control" id="family_en" name="family_en"
                               placeholder="نام خانوادگی انگلیسی کاربر را وارد نمائید" value="{$objCounter->list['family_en']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" id="mobile" name="mobile"
                               placeholder=" نام کاربری را وارد نمائید" value="{$objCounter->list['user_name']}" disabled='disabled'>

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">شماره تلفن همراه</label>
                        <input type="text" class="form-control" id="mobile" name="mobile"
                               placeholder=" شماره تلفن همراه کاربر را وارد نمائید" value="{$objCounter->list['mobile']}" disabled='disabled'>

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">تلفن ثابت</label>
                        <input type="text" class="form-control" id="telephone" name="telephone"
                               placeholder=" تلفن ثابت کاربر را وارد نمائید" value="{$objCounter->list['telephone']}" >

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="email" class="control-label">ایمیل کاربر</label>
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="ایمیل کاربر را وارد نمائید" value="{$objCounter->list['email']}"
                        >

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور کاربر</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="در صورتی که قصد تغییر کلمه عبور را ندارید دو فیلد کلمه عبور و تکرار آن را خالی رها نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                        <input type="password" class="form-control" id="Confirm" name="Confirm"
                               placeholder="در صورتی که قصد تغییر کلمه عبور را ندارید دو فیلد کلمه عبور و تکرار آن را خالی رها نمائید">

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

