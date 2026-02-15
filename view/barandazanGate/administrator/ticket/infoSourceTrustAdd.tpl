{load_presentation_object filename="bookshow" assign="objbook"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/flyAppClient">مشتریان</a></li>
                <li class="active">افزودن اطلاعات منابع</li>
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
                <h3 class="box-title m-b-0">افزودن اطلاعات منابع</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اطلاعات پید اختصاصی جدیدی را وارد نمائید</p>

                <form data-toggle="validator" id="AddSource" method="post">
                    <input type="hidden" name="flag" value="infoSourceTrust">

                    <div class="form-group col-sm-6">
                        <label for="client_id" class="control-label">نام همکار</label>
                        <select name="client_id" id="client_id" class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه</option>
                            {foreach $objbook->list_hamkar() as $client }
                                <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                            {/foreach}
                        </select>
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label for="username" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control " name="username"
                                 value="" id="username"
                                 placeholder="نام کاربری را وارد کنید">
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label for="password" class="control-label">کلمه عبور</label>
                        <input type="text" class="form-control " name="password"
                               value="" id="password"
                               placeholder="کلمه عبور را وارد کنید">
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


<script type="text/javascript" src="assets/JsFiles/infoSourceTrust.js"></script>

