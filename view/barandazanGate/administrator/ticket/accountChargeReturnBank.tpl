
{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bankPasargad" assign="objBank"}
{$objBank->returnBankCharge($smarty.post)}

{*{$objFunctions->insertLog("withClientId-> `$smarty.const.CLIENT_ID` -> `$smarty.post|json_encode`",'log_charge_pasargad')}*}
{*{$objFunctions->insertLog("****************************************************************************************",'log_charge_pasargad')}*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="">تراکنش های کاربر</li>
                <li class="active">شارژ حساب کاربری</li>
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

                {if $objBank->codRahgiri neq 'Error'}
                    {if $smarty.get.type eq 'creditAgency'}
                        {load_presentation_object filename="transaction" assign="objTransaction"}
                        {$objTransaction->updateTransactionAgency($smarty.get.idMember,$objBank->categoryNum,$objBank->codRahgiri)}
                        {else}
                        {$objAccount->initBankData($objBank->bankAmount, $objBank->categoryNum, $objBank->codRahgiri)}
                    {/if}



                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    عملیات پرداخت با موفقیت انجام شد. کد رهگیری بانک: {$objBank->codRahgiri}
                    <br/><br/>
                    حساب شما به مبلغ {$objBank->bankAmount|number_format} ریال شارژ شد.
                </div>

                {else}


                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    متاسفانه در پرداخت مشکلی به وجود آمده. لطفا از طریق مدیریت وب سایت پیگیر پرداخت شوید.
                </div>

                {/if}
            </div>
        </div>

    </div>
    {*<div class="row">

        <div class="col-sm-12">
            <div class="white-box">

                {if $smarty.post.ClientId eq $smarty.const.CLIENT_ID && $smarty.post.status eq 'success'}
                    {if $smarty.post.result eq 'True'}
                        {$objAccount->initBankData($smarty.post.amount, $smarty.post.invoiceNumber, $smarty.post.transactionReferenceID)}
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                        عملیات پرداخت با موفقیت انجام شد. کد رهگیری بانک: {$smarty.post.transactionReferenceID}
                        <br/><br/>
                        حساب شما به مبلغ {$smarty.post.amount|number_format} ریال شارژ شد.
                    </div>

                    {else}


                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        متاسفانه در پرداخت مشکلی به وجود آمده. لطفا از طریق مدیریت وب سایت پیگیر پرداخت شوید.
                    </div>

                    {/if}
                {else}


                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        متاسفانه در پرداخت مشکلی به وجود آمده. لطفا از طریق مدیریت وب سایت پیگیر پرداخت شوید.
                    </div>

                {/if}
            </div>
        </div>

    </div>*}