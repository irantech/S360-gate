{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="creditDetail" assign="objCreditDetail"}

{$objAgency->get($smarty.get.id)} {*گرفتن مشخصات آژانس*}
{$objCreditDetail->getAll($smarty.get.id)} {*گرفتن لیست اعتبارات*}
{assign var="info_currency" value=$objAgency->showInfoCurrency($objAgency->list['type_currency'])}
{if $objAgency->list['type_payment'] eq 'currency'}
    {assign value=0 var="format_desimal"}
    {else}
    {assign value=0 var="format_desimal"}
{/if}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $objAdmin->isLogin()}
                    <li><a href="agencyList">همکاران</a></li>
                    <li>جزئیات اعتبار</li>
                {else}
                    <li>حسابداری</li>
                    <li>تراکنش ها</li>
                {/if}

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
                <h3 class="box-title m-b-0">جزئیات اعتبار- نوع ارز<span style="color:red"> {$info_currency['CurrencyTitle']}</span></h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید جزئیات اعتبار زیر مجموعه خود را مشاهده
                    نمائید
                    <span class="pull-right">

                         {*{if $objAdmin->isLogin()}*}
                             <a href="creditDetailAdd&id={$smarty.get.id}"  class="btn btn-info waves-effect waves-light" type="button">
                                <span class="btn-label"><i class="mdi mdi-credit-card-plus"></i></span>افزودن/کسر اعتبار
                             </a>
                         {*{else}*}
                            {*<a href="sendAgencyToBank"  class="btn btn-info waves-effect waves-light" type="button">*}
                                {*<span class="btn-label"><i class="mdi mdi-credit-card-plus"></i></span>افزودن اعتبار*}
                             {*</a>*}
                         {*{/if}*}

                </span>

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>افزایش</th>
                            <th>خرید</th>
                            <th>باقی مانده</th>
                            <th>علت تراکنش</th>
                            <th>تاریخ ثبت</th>
                            <td>توضیحات</td>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="remain" value=$objCreditDetail->total_transaction}
                        {foreach key=key item=item from=$objCreditDetail->list}
                            {$number=$number+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{if $item.type eq 'increase'}
                                        {$item.credit|number_format:$format_desimal}
                                    {else}
                                        0
                                    {/if} </td>
                                <td>{if $item.type eq 'decrease'}{$item.credit|number_format:$format_desimal}{else}0{/if} </td>
                                <td><span>{$remain|number_format:$format_desimal}</span>
                                    {if $item.type=='increase'}
                                        {$remain = $remain - $item.credit}
                                    {else}
                                        {$remain = $remain + $item.credit}
                                    {/if}
                                    <td>{if $item.reason eq 'buy'} خرید خدمات{elseif  $item.reason eq 'harvest'} کسر از حساب{elseif  $item.reason eq 'deposit'} واریز به حساب{elseif  $item.reason eq 'settle'} تسویه اعتبار غیر مالی{/if}</td>
                                <td style='direction: ltr;'>{$objCreditDetail->timeToDateJalali($item.creation_date_int)}</td>
                                <td>{$item.comment}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="1">جمع کل</th>
                            <th colspan="">{$objCreditDetail->total_charge|number_format:$format_desimal}</th>
                            <th colspan="">{$objCreditDetail->total_buy|number_format:$format_desimal}</th>
                            <th colspan="">{$objCreditDetail->total_transaction|number_format:$format_desimal} {if $objCreditDetail->total_transaction > 0}بستانکار{elseif $objCreditDetail->total_transaction < 0}بدهی{else}تسویه{/if}</th>
                            <th colspan="2"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/passenger.js"></script>