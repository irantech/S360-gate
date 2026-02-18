{load_presentation_object filename="callBackUrl" assign="objCallBack"}
{assign var="info_call_back" value=$objCallBack->getCallBackUrl($smarty.get.id , true)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/callBackUrl/list">
                        لیست لینک ها
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_call_back_url" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateUrlList' id='method' name='method'>
            <input type='hidden' value='callBackUrl' id='className' name='className'>
            <input type='hidden' value='{$info_call_back['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش  </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="form-group col-sm-6">
                            <label for="type" class="control-label"> نوع را انتخاب نمایید </label>
                            <select name="type" id="type" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option value="register_user" {if {$info_call_back['type']} eq 'register_user'}selected="selected"{/if}>ثبت کاربران</option>
                                <option value="book" {if {$info_call_back['type']} eq 'book'}selected="selected"{/if}>خرید کاربران</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="url">لینک </label>
                                <input type="text" class="form-control" name="url" id="url" value='{$info_call_back['url']}'
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


