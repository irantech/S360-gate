{load_presentation_object filename="redirect" assign="objRedirect"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/callBackUrl/list">
                        لیست لینک ها
                    </a>
                </li>
                <li class="active">افزودن لینک جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_call_back" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='setUrlList' id='method' name='method'>
            <input type='hidden' value='callBackUrl' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن لینک جدید</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="form-group col-sm-6">
                            <label for="type" class="control-label"> نوع را انتخاب نمایید </label>
                            <select name="type" id="type" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option value="register_user">ثبت نام کاربران</option>
                                <option value="book">خرید کاربر</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
                            <div class="form-group">
                                <label class="control-label" for="url">لینک </label>
                                <input type="text" class="form-control" name="url" id="url"
                                       placeholder="لینک را وارد نمایید">
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

<script type="text/javascript" src="assets/JsFiles/callBack.js">

