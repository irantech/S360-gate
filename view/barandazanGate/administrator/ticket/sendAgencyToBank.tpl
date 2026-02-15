{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->get()}
{assign var="infoBank" value=$objFunctions->InfoBank()} {* گرفتن لیست بانک ها *}


{if $smarty.post}
<script language="javascript" type="text/javascript">
    function sendForm(link, inputs) {
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", link);

        var decodedInputs = $.parseJSON(inputs);
        $.each(decodedInputs, function (i, item) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", i);
            hiddenField.setAttribute("value", item);
            form.appendChild(hiddenField);
        });

        document.body.appendChild(form);
//        console.log(form);
//        return false;
        form.submit();
        document.body.removeChild(form);
    }
</script>

{load_presentation_object filename="bank" assign="objBank"}
{$objBank->initBankParams($smarty.post.BankName)}
{$objBank->calculateAmount('Admin', '',$smarty.post.amount)}
{$objBank->executeBank('go')}
{/if}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>حسابداری</li>
                    <li>تراکنش ها</li>
                    <li>افزایش اعتبار</li>
                    <li class="active">{$objAgency->list['name_fa']}({$objAgency->list['manager']})</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن اعتبار حساب کاربری</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعتبار حساب کاربری خود را افزایش
                    دهید </p>

                <form id="chargeAccountForm" method="post" action="">
                    <input type="hidden" name="flag" value="bankAccountAgencyCharge">

                    <div class="form-group col-sm-6">

                        <label for="amount" class="control-label">مبلغ اعتبار<small class="text-muted m-b-30">(با افزایش شدید نرخ بلیط، حداقل افزایش اعتبار نیز افزایش یافته است)</small></label>
                        <input type="text" class="form-control" id="amount" name="amount"
                               placeholder="مبلغ مورد نظر را به ریال وارد نمایید">
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-sm-12" >

                        <label for="amount" class="control-label">انتخاب بانک</label>
                    </div>
                    <div>
                        {foreach $infoBank as $key=>$item}
                            <div class="col-lg-2 col-md-2 col-sm-12 col-sm-12">
                                <div class="radio radio-info">
                                    <input type="radio"  name="BankName" id="BankName{$key}"  value="{$item['bank_dir']}"  >
                                    <label for="BankName{$key}"> {$item['title']} </label>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                    <div class="clearfix"></div>
                    <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                         id="loadingbank">
                    <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">
                        پرداخت
                    </button>
                </form>


                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/agency.js"></script>