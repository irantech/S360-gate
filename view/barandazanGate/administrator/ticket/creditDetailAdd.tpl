{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->get($smarty.get.id)} {*گرفتن مشخصات آژانس*}

{assign var="info_currency" value=$objAgency->showInfoCurrency($objAgency->list['type_currency'])}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li><a href="creditDetailList&id={$smarty.get.id}">جزئیات اعتبار</a></li>
                <li class="active">افزودن(کسر) اعتبار</li>
                <li>{$objAgency->list['name_fa']}({$objAgency->list['manager']})</li>
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
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعتبار همکار خود  را در سیستم کسر یا افزایش  دهید

                    {if $objAgency->list['type_payment'] eq 'currency'}
                        <br/>
                        توجه داشته باشید آژانس همکار با نوع ارز   <span style="color:red;"> {$info_currency['CurrencyTitle']} </span> در سیستم تعریف شده و تمامی پردازش ها بر روی تراکنش های کاربر بر اساس این ارز میباشد
                    {/if}

                </p>

                <form id="AddCredit" method="post">
                    <input type="hidden" name="flag" id="flag" value="insert_credit">
                    <input type="hidden" name="agencyID" id="agencyID" value="{$smarty.get.id}">
                    <div class="form-group col-sm-6 ">

                        <label for="credit" class="control-label">مبلغ اعتبار</label>
                        <input type="text" class="form-control" id="credit" name="credit"
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


<script type="text/javascript" src="assets/JsFiles/credit.js"></script>

