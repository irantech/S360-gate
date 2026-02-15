{load_presentation_object filename="userPassCustomers" assign="objCustomer"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userPassCustomer/list">
                        لیست مشتریان نرم افزار پرواز
                    </a>
                </li>
                <li class="active">افزودن مشتری جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_customer" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertCustomer' id='method' name='method'>
            <input type='hidden' value='userPassCustomers' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن مشتری جدید</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام مشتری </label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="نام مشتری را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="domain">دامنه </label>
                                <input type="text" class="form-control" name="domain" id="domain"
                                       placeholder="دامنه را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="user_name">نام کاربری </label>
                                <input type="text" class="form-control" name="user_name" id="user_name"
                                       placeholder="نام کاربری را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="password">رمز عبور </label>
                                <input type="text" class="form-control" name="password" id="password"
                                       placeholder="رمز عبور را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="link" class="control-label">لینک لاگین</label>
                                <input type="text" class="form-control" name="link" id="link"
                                       placeholder="لینک لاگین را وارد نمایید">
                            </div>
                        </div>


                    </div>

                </div>
            </div>

            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/userPassCustomers.js">

