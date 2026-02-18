{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bank" assign="objBank"}
{$objBank->initBankParams($smarty.get.bank)}
{$objBank->executeBank('return')}

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

                {if $objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq ''}

                    {$objAccount->StoreInfoChargeAgency($objBank->bankAmount, $objBank->categoryNum, $objBank->codRahgiri)}


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
