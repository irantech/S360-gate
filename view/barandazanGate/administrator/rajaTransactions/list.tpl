{load_presentation_object filename="rajaTransactions" assign="objTransactions"}

<div class="container-fluid">
    <div class="row bg-title">


        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if  $smarty.const.TYPE_ADMIN eq '1'}
                    <li><a href="flyAppClient">حسابداری</a></li>
                    <li class="active"> لیست تراکنش های رجا</li>
                    {if $smarty.get.id neq ''}
                        <li>{$objFunctions->ClientName($smarty.get.id)}</li>
                    {/if}
                {else}
                    <li class="active"> لیست تراکنش های رجا</li>

                {/if}
            </ol>
        </div>
    </div>



{*    <div class="row">*}
{*        <div class="col-sm-12">*}
{*            <div class="white-box">*}

{*                <h3 class="box-title m-b-0">جستجوی سوابق بارگذاری ها</h3>*}
{*                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق بارگذاری های قبلی را در تاریخ های مورد نظرتان جستجو*}
{*                    کنید </p>*}
{*                <form id="SearchTransaction" method="post"*}
{*                      action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUser{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}">*}

{*                    <input type="hidden" name="flag" id="flag" value="createExcelFileForTransactionUser">*}

{*                    <input type="hidden" name="client_id" id="client_id" value="{$smarty.get.id}">*}


{*                    <div class="form-group col-sm-6 ">*}
{*                        <label for="date_of" class="control-label">تاریخ شروع</label>*}
{*                        <input type="text" class="form-control datepicker" name="date_of" value="{$smarty.post.date_of}"*}
{*                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">*}
{*                    </div>*}

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="to_date" class="control-label">تاریخ پایان</label>*}
{*                        <input type="text" class="form-control datepickerReturn" name="to_date"*}
{*                               value="{$smarty.post.to_date}" id="to_date"*}
{*                               placeholder="تاریخ پایان جستجو را وارد نمائید">*}

{*                    </div>*}

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="CodeRahgiri" class="control-label">کد رهگیری تراکنش</label>*}
{*                        <input type="text" class="form-control" name="CodeRahgiri" value="{$smarty.post.CodeRahgiri}"*}
{*                               id="CodeRahgiri" placeholder="کد رهگیری را وارد نمائید">*}

{*                    </div>*}

{*                    <div class="row">*}
{*                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">*}
{*                            <div class="form-group pull-right">*}
{*                                <button type="submit" class="btn btn-primary">شروع جستجو</button>*}
{*                            </div>*}
{*                        </div>*}
{*                    </div>*}

{*                    <div class="clearfix"></div>*}
{*                </form>*}
{*            </div>*}

{*        </div>*}
{*    </div>*}


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست تراکنش های رجا</h3>
                <p class="text-muted m-b-30">
                    شما در لیست زیر فایل هایی که قبلا بارگذاری شده را مشاهده میکنید ، در صورت تمایل میتوانید جزییات تراکنش های مختص به هر فایل را در بخش جزییات مشاهده نمایید.
                        <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rajaTransactions/insert"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="mdi mdi-trending-up"></i></span>آپلود فایل
                </a>
                </span>
                </p>
                <div class="table-responsive">
                    <table id="newTransaction" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>فایل</th>
                            <th>توضیحات</th>
                            <th>تاریخ</th>
                            <th>کد رهگیری</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="transactions" value=$objTransactions->listExcel()}
                        {foreach $transactions as $transaction}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>
                                    <a href="{$transaction.file}">دانلود فایل</a>
                                </td>
                                <td>{$transaction.comment}</td>
                                <td>{$transaction.created_at}</td>
                                <td>{$transaction.tracking_code}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rajaTransactions/detail?tracking_code={$transaction.tracking_code}">جزییات</a>
                                    {if $transaction.applied_at}
                                        <div class="btn btn-success" disabled="disabled" style="cursor: context-menu;">اعمال شده</div>
                                        {else}
                                        <a class="btn btn-sm btn-outline gap-4 btn-success" href="javascript:" onclick="processExcel('{$transaction.tracking_code}'); return false;">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <a class="btn btn-sm btn-outline gap-4 btn-danger" href="javascript:" onclick="deleteExcel('{$transaction.tracking_code}');">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/rajaTransactions.js"></script>