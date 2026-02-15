{load_presentation_object filename="userPassCustomers" assign="objCustomer"}
{assign var="info_customer" value=$objCustomer->getCustomer($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userPassCustomers/list">
                        لیست مشتریان
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_customer['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_customer" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateCustomer' id='method' name='method'>
            <input type='hidden' value='userPassCustomers' id='className' name='className'>
            <input type='hidden' value='{$info_customer['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش   {$info_customer['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام مشتری </label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_customer['title']}'
                                       placeholder="از این قسمت می توانید نام مشتری را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="domain">دامنه </label>
                                <input type="text" class="form-control" name="domain" id="domain" value='{$info_customer['domain']}'
                                       placeholder="دامنه را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="user_name">نام کاربری </label>
                                <input type="text" class="form-control" disabled name="user_name" id="user_name" value='{$info_customer['user_name']}'
                                       placeholder="نام کاربری را وارد نمایید">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="link" class="control-label">لینک لاگین</label>
                                <input type="text" class="form-control" name="link" id="link" value='{$info_customer['link']}'
                                       placeholder="لینک لاگین را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="password" class="control-label">رمز عبور قدیم</label>
                                <input type="text" class="form-control" name="password" id="password" disabled value='{$info_customer['password']}'
                                       placeholder="رمز عبور قدیم">
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


