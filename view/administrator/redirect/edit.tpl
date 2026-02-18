{load_presentation_object filename="redirect" assign="objRedirect"}
{assign var="info_redirect" value=$objRedirect->getRedirect($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/redirect/list">
                        لیست لینک ها
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_redirect['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_redirect" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateRedirect' id='method' name='method'>
            <input type='hidden' value='redirect' id='className' name='className'>
            <input type='hidden' value='{$info_redirect['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش   {$info_redirect['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="form-group col-sm-6">
                            <label for="typeRedirect" class="control-label"> نوع را انتخاب نمایید </label>
                            <select name="typeRedirect" id="typeRedirect" class="form-control" onchange="SelectTypeRedirect(this)">
                                <option value="">انتخاب کنید...</option>
                                <option value="redirect" {if {$info_redirect['type']} eq 'redirect'}selected="selected"{/if}>redirect</option>
                                <option value="410" {if {$info_redirect['type']} eq '410'}selected="selected"{/if}>410</option>
                                <option value="canonical" {if {$info_redirect['type']} eq 'canonical'}selected="selected"{/if}>canonical</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان </label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_redirect['title']}'
                                       placeholder="از این قسمت می توانید عنوان را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="domain">لینک قدیم </label>
                                <input type="text" class="form-control" name="url_old" id="url_old" value='{$info_redirect['url_old']}'
                                       placeholder="لینک قدیم را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 redirectType" {if {$info_redirect['type']} eq '410'} style='display: none;' {/if}>
                            <div class="form-group">
                                <label class="control-label" for="user_name">لینک جدید </label>
                                <input type="text" class="form-control" name="url_new" id="url_new" value='{$info_redirect['url_new']}'
                                       placeholder="لینک جدید را وارد نمایید">
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


<script type="text/javascript" src="assets/JsFiles/redirect.js">


