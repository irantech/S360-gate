<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">تنظیمات</a></li>
                <li class="active">ارسال پیام به کاربران</li>
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
                <h3 class="box-title m-b-0">ارسال پیام به کاربران</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید به تمام کاربران ثبت نام شده در سیستم پیام ارسال نمائید</p>

                <form data-toggle="validator" id="Message" method="post">
                    <input type="hidden" name="flag" value="SendMessageClient">

                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان پیام </label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="عنوان را وارد نمائید">
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label for="description" class="control-label">متن پیام</label>
                        <textarea id="description" name="description" class="form-control"
                                  placeholder="متن پیام را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Logo" class="control-label">تصویر</label>
                        <input type="file" name="image" id="image" class="dropify" data-height="100"
                               data-default-file="assets/plugins/images/defaultLogo.png"/>
                    </div>

                    <div class="row">
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
</div>


<script type="text/javascript" src="assets/JsFiles/messageClientOnline.js"></script>

