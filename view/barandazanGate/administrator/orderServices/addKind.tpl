{load_presentation_object filename="orderServicesKind" assign="objKind"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/listKind">
                            لیست انواع درخواست خدمات
                        </a>
                    </li>
                    <li class="active">درج نوع درخواست خدمات جدید</li>
                </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/list"
           class="btn btn-info waves-effect waves-light mb-5" type="button"  style='float: left; margin-left: 5px'>
            <span class="btn-label"><i class="fa fa-list"></i></span>
            لیست درخواست ها
        </a>
        <form data-toggle="validator" id="add_kind_order_services" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertKindOrderServices' id='method' name='method'>
            <input type='hidden' value='orderServicesKind' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن نوع درخواست خدمات</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان فارسی </label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" عنوان فارسی را وارد نمائید"></span>
                                <input type="text" class="form-control" name="titleFa" id="titleFa"
                                       placeholder="عنوان فارسی را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان انگلیسی </label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" عنوان انگلیسی را وارد نمائید"></span>
                                <input type="text" class="form-control" name="titleEn" id="titleEn"
                                       placeholder="عنوان انگلیسی را وارد نمایید">
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

<script type="text/javascript" src="assets/JsFiles/orderServicesKind.js">

