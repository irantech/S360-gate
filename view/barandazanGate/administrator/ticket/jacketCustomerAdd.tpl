{load_presentation_object filename="jacketCustomer" assign="objcustomer"}
{load_presentation_object filename="partner" assign="objpartner"}
{assign var="client" value=$objpartner->InfoClient($smarty.get.id)}
{assign var="jacketClient" value=$objcustomer->jacketCustomerClient($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">لیست مشتریان</a></li>
                {if $smarty.get.id neq '' }
                    <li class="">{$client['AgencyName']}</li>
                {/if}
                <li class="active">افزودن مشتری جدید</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ثبت اطلاعات مشتری ژاکت</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید مشتری جدیدی از سایت ژاکت را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="Customer" method="post">
                    <input type="hidden" name="flag" value="insert_jacket_customer">
                    <input type="hidden" name="ClientId" id="ClientId" value="{$smarty.get.id}">
                    <div class="form-group col-sm-6 ">

                        <label for="userName" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" id="userName" name="userName"
                               value="{$jacketClient['userName']}"
                               placeholder="نام کامل مشتری را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور مشتری</label>
                        <input type="password" class="form-control"  id="password" name="password"
                               placeholder="کلمه عبور مشتری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                        <input type="password" class="form-control" id="Confirm" name="Confirm"
                               placeholder="تکرار رمز عبور">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="ipAddress" class="control-label">ip address</label>
                        <input type="text" class="form-control" id="ipAddress" name="ipAddress"
                               value="{$jacketClient['ipAddress']}"
                               placeholder="ip address را وارد نمائید">

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

{literal}
    <script type="text/javascript" src="assets/JsFiles/jacketCustomer.js"></script>

{/literal}