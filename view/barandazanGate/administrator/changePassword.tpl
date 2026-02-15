{load_presentation_object filename="bankList" assign="ObjBank"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">تغییر رمز عبور</li>

            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    {if $smarty.const.CLIENT_ID == '149'}
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <p class="text-dark m-b-30">شما دسترسی تغییر این صفحه را ندارید</p>
                </div>
            </div>
        </div>
    {else}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تغییر رمز عبور</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید  رمز عبور خود  را در سیستم تغییر دهید</p>

                <form id="changePassword" method="post">
                    <input type="hidden" name="client_id" value="{$smarty.const.CLIENT_ID}">
                    <input type="hidden" name="flag" value="ChangePassword">
                    <div class="form-group col-sm-6 ">

                        <label for="old_pass" class="control-label">رمز عبور قدیمی</label>
                        <input type="password" class="form-control" id="old_pass" name="old_pass"
                               placeholder="رمز عبور قدیمی را وارد نمائید">

                    </div>


                    <div class="form-group col-sm-6">
                        <label for="new_pass" class="control-label">رمز عبور جدید</label>
                        <input type="password" class="form-control" id="new_pass" name="new_pass"
                               placeholder="رمز عبور جدید را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="con_pass" class="control-label">تکرار رمز عبور</label>
                        <input type="password" class="form-control" id="con_pass" name="con_pass"
                               placeholder="تکرار رمز عبور را وارد نمائید">
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
    {/if}
</div>


<script type="text/javascript" src="assets/JsFiles/ChangePassword.js"></script>

