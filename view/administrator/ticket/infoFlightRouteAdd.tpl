{load_presentation_object filename="airline" assign="objAirline"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات </li>
                <li><a href="infoFlightRoute">اطلاعات خطوط پروازی </a></li>
                <li class="active">افزودن خطوط پروازی جدید</li>

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
                <h3 class="box-title m-b-0">افزودن  خطوط پروازی جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید خطوط پروازی  جدیدی را در سیستم ثبت نمائید</p>

                <form id="EditRoute" method="post">
                    <input type="hidden" name="flag" value="insert_airline">
                    <div class="form-group col-sm-6 ">

                        <label for="nameFa" class="control-label">نام ایرلاین</label>
                        <input type="text" class="form-control" id="nameFa" name="nameFa"
                               placeholder="نام ایرلاین را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="nameEn" class="control-label">نام لاتین ایرلاین</label>
                        <input type="text" class="form-control" id="nameEn" name="nameEn"
                               placeholder="نام لاتین ایرلاین را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="abbreviation" class="control-label">کد یاتای ایرلاین</label>
                        <input type="text" class="form-control" id="abbreviation" name="abbreviation"
                               placeholder="کد یاتای ایرلاین را وارد نمائید">
                    </div>



                    <div class="form-group col-sm-6">
                        <label for="photo" class="control-label">لوگو</label>
                        <input type="file" name="photo" id="photo" class="dropify" data-height="100"
                               data-default-file="assets/plugins/images/defaultLogo.png"/>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/airline.js"></script>

