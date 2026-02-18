{load_presentation_object filename="accountcharge" assign="objAccount"}
{assign var="clientList" value=$objFunctions->clients()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                <li class="active"> افزودن تراکنش</li>
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
                <h3 class="box-title m-b-0">افزودن  تراکنش</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید تراکنش جدیدی  را در سیستم ثبت نمائید</p>

                <form id="AddTransaction" method="post">
                    <input type="hidden" name="flag" value="insert_accountcharge">
                    <div class="form-group col-sm-6">
                        <label for="Price" class="control-label">مبلغ تراکنش</label>
                        <input type="text" class="form-control" id="Price" name="Price"
                               placeholder=" مبلغ تراکنش را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="clientId" class="control-label">انتخاب مشتری </label>
                        <select name="clientId" id="clientId" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $clientList as $client}
                            <option value="{$client['id']}">{$client['AgencyName']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="Reason" class="control-label">دلیل تراکنش </label>
                        <select name="Reason" id="Reason" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="decrease">کسر از حساب</option>
                            <option value="increase">واریز به حساب</option>
                            <option value="indemnity_edit_ticket">جریمه اصلاح بلیط</option>
                            <option value="diff_price">واریز تغییر قیمت شناسه نرخی</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Comment" class="control-label">توضیحات</label>
                        <textarea class="form-control m-right-text" name="Comment" id="Comment" placeholder="توضیحات را وارد نمائید"></textarea>

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


<script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>

