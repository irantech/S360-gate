{load_presentation_object filename="visaRequestStatus" assign="objResult"}
{assign var="item" value=$objResult->getSingle($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaRequestStatusList">مدیریت وضعیت های پردازش ویزا</a></li>
                <li class="active"> نوع وضعیت پردازش ویزا</li>
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
                <h3 class="box-title m-b-0">ویرایش وضعیت پردازش ویزا</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید انواع وضعیت پردازش ویزا را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="visaRequestStatusEdit" method="post">
                    <input type="hidden" name="flag" value="visaRequestStatusEdit">
                    <input type="hidden" name="id" value="{$item.id}">

                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title" value="{$item.title}" placeholder="عنوان را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="description" class="control-label">توضیحات وضعیت ویزا</label>
                        <textarea class="form-control" id="description" name="description" placeholder="توضیحات وضعیت ویزا">{$item.description}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="notification_content" class="control-label">متن پیامک ارسالی به کاربر</label>
                        <textarea type="text" class="form-control" id="notification_content" name="notification_content" placeholder="متن پیامک ارسالی به کاربر - این متن در هنگام تغییر وضعیت قابل تغییر است">{$item.notification_content}</textarea>
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

