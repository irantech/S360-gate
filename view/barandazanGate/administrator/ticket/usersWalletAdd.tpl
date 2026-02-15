


{load_presentation_object filename="members" assign="objCounter"}

{load_presentation_object filename="admin" assign="objAdmin"}

{$objCounter->showedit($smarty.get.id)}  {*گرفتن مشخصات کاربر*}

{assign var="info_currency" value=$objCounter->showInfoCurrency($objCounter->list['type_currency'])}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="mainUserList">کاربران اصلی</a></li>
                <li><a href="usersWalletList&id={$smarty.get.id}">جزئیات اعتبار</a></li>
                <li class="active">افزودن(کسر) اعتبار</li>
                <li>{$objCounter->list['name']} {$objCounter->list['family']}</li>
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
                <h3 class="box-title m-b-0">افزودن(کسر) اعتبار</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعتبار خود  را در سیستم کسر یا افزایش  دهید
                        <br/>
                        توجه داشته باشید نوع ارز   <span style="color:red;"> {$info_currency['CurrencyTitle']} </span> در سیستم تعریف شده و تمامی پردازش ها بر روی تراکنش های کاربر بر اساس این ارز میباشد

                </p>

                <form id="AddCreditUser" method="post">
                    <input type="hidden" name="flag" id="flag" value="insert_user_wallet">
                    <input type="hidden" name="memberID" id="memberID" value="{$smarty.get.id}">
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                        <input type="hidden" name="type_admin" id="type_admin" value="1">
                        <input type="hidden" name="adminId" id="adminId" value="iranTech">
                        <input type="hidden" name="typeAgency" id="typeAgency" value="iranTech">
                    {else}
                        <input type="hidden" name="type_admin" id="type_admin" value="2">
                        {if isset($smarty.session.AgencyPartner) && $smarty.session.AgencyPartner eq 'AgencyHasLogin'}
                            <input type="hidden" name="adminId" id="adminId" value="{$smarty.session.memberIdCounterInAdmin}">
                            <input type="hidden" name="typeAgency" id="typeAgency" value="AgencyPartner">
                        {else}
                            <input type="hidden" name="adminId" id="adminId" value="{$smarty.const.CLIENT_ID}">
                            <input type="hidden" name="typeAgency" id="typeAgency" value="agency">

                        {/if}

                    {/if}

                    <div class="form-group col-sm-6 ">

                        <label for="credit" class="control-label">مبلغ اعتبار</label>
                        <input type="text" class="form-control" id="credit" name="credit" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                               placeholder="مبلغ اعتبار را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="becauseOf" class="control-label">نوع تراکنش</label>
                        <select class="select form-control" name="becauseOf" id="becauseOf">
                            <option  value="">انتخاب کنید</option>
                            <option  value="increase">افزایش اعتبار</option>
                            <option  value="decrease">کاهش اعتبار</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="comment" class="control-label">توضیحات </label>
                   <textarea class="form-control" id="comment" name="comment"></textarea>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                                     id="loadingbank" style="float: left;">
                                <button type="submit" class="btn btn-primary pull-right" id="SendFormCredit">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/creditUser.js"></script>

