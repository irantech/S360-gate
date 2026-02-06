{load_presentation_object filename="members" assign="objCounter"}

{*{load_presentation_object filename="usersWallet" assign="objCreditDetailUser"}*}
{load_presentation_object filename="memberCredit" assign="objCreditDetailUser"}

{$objCounter->showedit($smarty.get.id)} {*گرفتن مشخصات کاربر*}
{$objCreditDetailUser->getAll($smarty.get.id)} {*گرفتن لیست اعتبارات*}

{assign value=0 var="format_desimal"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li><a href="mainUserList">لیست کاربران</a></li>
                    <li>جزئیات اعتبار</li>
                <li class="active">{$objCounter->list['name']} {$objCounter->list['family']}</li>
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
                <h3 class="box-title m-b-0">جزئیات اعتبار کاربران</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید جزئیات اعتبار کاربران را مشاهده
                    نمائید
                    <span class="pull-right">
                     <a href="usersWalletAdd&id={$smarty.get.id}"  class="btn btn-info waves-effect waves-light" type="button">
                        <span class="btn-label"><i class="mdi mdi-credit-card-plus"></i></span>افزودن/کسر اعتبار
                     </a>
                </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table  ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
{*                            <th>id</th>*}
{*                            <th>state</th>*}
{*                            <th>status</th>*}
{*                            <th>type_admin</th>*}
{*                            <th>adminID</th>*}
{*                            <th>typeAgency</th>*}
                            <th>نام ادمین</th>
                            <th>افزایش</th>
                            <th>خرید</th>
                            <th>در حال بررسی</th>
                            <th>ناموفق</th>
                            <th>باقی مانده</th>
                            <th>شماره فاکتور</th>
                            <th>علت تراکنش</th>
                            <th>وضعیت تراکنش</th>
                            <th>تاریخ ثبت</th>
                            <td>توضیحات</td>

                        </tr>
                        </thead>
                        <tbody>
{*                        {$objCreditDetailUser->list|var_dump}*}
                        {assign var="number" value="0"}
                        {assign var="remain" value=$objCreditDetailUser->total_transaction}
{*                        {assign var="remainder" value=$objCreditDetailUser->total_all}*}
                        {assign var="remainder" value=0}
{*                            {$remain|var_dump}*}
                        {foreach key=key item=item from=$objCreditDetailUser->list}
                            {$number=$number+1}
                            <tr    {if $item.state eq 'charge' && $item.status neq 'success'} style='background-color: #ffbebe;' {elseif $item.state eq 'buy'  && $item.status eq 'rejectAdmin' } style='background-color: #fdd0d0;' {elseif $item.state eq 'buy'} style='background-color: #fffae0;' {/if}>
                                <td>{$number}</td>
{*                                <td>{$item.id}</td>*}
{*                                <td>{$item.state}</td>*}
{*                                <td>{$item.status}</td>*}
{*                                <td>{$item.type_admin}</td>*}
{*                                <td>{$item.adminId}</td>*}
{*                                <td>{$item.typeAgency}</td>*}
                                <td>{$objCreditDetailUser->infoAdmin($item.type_admin , $item.adminId ,$item.typeAgency)}</td>

                                <td>
                                    {if $item.state eq 'charge' && $item.status eq 'success'}
                                        {$item.amount|number_format:$format_desimal}
                                    {else}
                                        0
                                    {/if}
                                </td>
                                <td>
                                    {if $item.state eq 'buy' && $item.status neq 'pending'}
                                        {$item.amount|number_format:$format_desimal}
                                    {else}
                                        0
                                    {/if}
                                </td>
                                <td>
                                    {if $item.state eq 'buy' && $item.status eq 'pending'}
                                        {$item.amount|number_format:$format_desimal}
                                    {else}
                                        0
                                    {/if}
                                </td>
                                <td>
                                    {if $item.state eq 'charge' && $item.status neq 'success'}
                                        {$item.amount|number_format:$format_desimal}
                                    {else}
                                        0
                                    {/if}
                                </td>

                                <td>
                                    {if $item.state=='charge'}
                                        {$remainder = $remainder + $item.amount}
                                    {else}
                                        {$remainder = $remainder - $item.amount}
                                    {/if}
                                    <span>{$remainder|number_format}</span>


                                </td>
                                <td>{$item.factorNumber}</td>
                                    <td>
                                    {if $item.reason eq 'charge'}
                                        ##ChargeAccount##
                                    {elseif $item.reason eq 'buy'}
                                        ##Buy##
                                    {elseif $item.reason eq 'giftBuyTicket'}
                                        ##BuyTicket##
                                    {elseif $item.reason eq 'reagent_code_presented'}
                                        ##GiftCodeReference##
                                    {elseif $item.reason eq 'increase'}
                                        ##ChargeAccount## {$smarty.const.CLIENT_NAME}
                                    {elseif $item.reason eq 'decrease'}
                                        ##DecreaseUser## {$smarty.const.CLIENT_NAME}
                                    {elseif $item.reason eq 'credit_deduction'}
                                        ##DecreaseMoneyOfCreditByMember##
                                    {/if}
                                    </td>
                                <td>
                                    {if $item.status eq 'success'}
                                        <span class='success-bg-text-with-padding-and-radius text-center'>##Successpayment##  </span>
                                    {elseif $item.status eq 'error'}
                                        <span class='error-bg-text-with-padding-and-radius text-center'>##ErrorPayment##  </span>
                                    {elseif $item.status eq 'progress'}
                                        <span class='pending-bg-text-with-padding-and-radius text-center'>##Processing##  </span>
                                    {elseif $item.status eq 'pending'}
                                        <span class='pending-bg-text-with-padding-and-radius text-center'>##Pending##  </span>
                                    {elseif $item.status eq 'rejectAdmin'}
                                        <span class='error-bg-text-with-padding-and-radius text-center'>##rejectByAdmin##  </span>
                                    {/if}
                                </td>
                                <td >{$objCreditDetailUser->timeToDateJalali($item.creationDateInt)}</td>
                                <td>{$item.comment}</td>

                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="1">جمع کل</th>
{*                            <th colspan="1"></th>*}
{*                            <th colspan="1"></th>*}
{*                            <th colspan="1"></th>*}
                            <th colspan="">{$objCreditDetailUser->total_charge|number_format:$format_desimal}</th>
                            <th colspan="">{$objCreditDetailUser->total_buy|number_format:$format_desimal}</th>
                            <th colspan="">{$objCreditDetailUser->total_pending|number_format:$format_desimal}</th>
                            <th colspan="">{$objCreditDetailUser->total_failed|number_format:$format_desimal}</th>
                            <th colspan="">{$objCreditDetailUser->total_transaction|number_format:$format_desimal} {if $objCreditDetailUser->total_transaction > 0}بستانکار{elseif $objCreditDetailUser->total_transaction < 0}بدهی{else}تسویه{/if}</th>
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