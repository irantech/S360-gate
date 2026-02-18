{load_presentation_object filename="gdsModule" assign="obj_gds_module"}

{assign var="data_gds_module" value=$obj_gds_module->getGdsModuleById($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>تنظیمات</li>
                    <li><a href='list-module'>لیست ماژول ها</a></li>
                    <li  class="active" >ویرایش ماژول</li>
                </ol>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box row">
                <h3 class="box-title m-b-0">افزودن بخش جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید بخش جدیدی را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="edit_gds_module" method="post"  enctype="multipart/form-data">
                    <input type='hidden' value='editGdsModule' id='method' name='method'>
                    <input type='hidden' value='gdsModule' id='className' name='className'>
                    <input type='hidden' value='{$data_gds_module['id']}' id='gds_module_id' name='gds_module_id'>
                    <div class="row">
                        <div class="form-group col-sm-6 ">

                            <label for="title" class="control-label">عنوان</label>
                            <input type="text" class="form-control" id="title" name="title" value="{$data_gds_module['title']}"
                                   placeholder="عنوان را وارد نمائید">
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="gds_controller" class="control-label">gds module</label>
                            <input type="text" class="form-control" id="gds_controller" name="gds_controller" value="{$data_gds_module['gds_controller']}"
                                   placeholder="نام کنترلر را وارد نمائید">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gds_table" class="control-label">gds module</label>
                            <input type="text" class="form-control" id="gds_table" name="gds_table" value="{$data_gds_module['gds_table']}"
                                   placeholder="نام دیتابیس را وارد نمائید">
                        </div>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/gdsModule.js">

