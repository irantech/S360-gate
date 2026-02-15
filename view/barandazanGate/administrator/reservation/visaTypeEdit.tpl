{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypeInfo" value=$objVisaType->getVisaTypeByID($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li><a href="visaTypeList">انواع ویزا</a></li>
                <li class="active">ویرایش نوع ویزا</li>
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
                <h3 class="box-title m-b-0">ویرایش نوع ویزا</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید انواع ویزا را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="visaTypeEdit" method="post">
                    <input type="hidden" name="flag" value="visaTypeEdit">
                    <input type="hidden" name="id" value="{$visaTypeInfo['id']}">

                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title" value="{$visaTypeInfo['title']}"
                               placeholder="عنوان را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="documents" class="control-label">مدارک مورد نیاز ویزا ( لطفا مشخص کنید در صورت رزرو این نوع ویزا کاربر چه مدارکی را باید آپلود کند. )</label>
                        <input type="text" class="form-control" id="documents" name="documents" value="{$visaTypeInfo['documents']}"
                               placeholder="مثال: اسکن کارت ملی - اسکن شناسنامه و... ">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
