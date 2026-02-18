
{load_presentation_object filename="memberCredit" assign="objCreditDetailUser"}
{assign var="list_item" value=$objCreditDetailUser->getAllCreditMember()}

{assign value=0 var="format_desimal"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="mainUserList">لیست کاربران</a></li>
                <li>لیست اعتبارات</li>
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
                <h3 class="box-title m-b-0">لیست اعتبارات</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست درخواست وجه را مشاهده
                    نمائید
                    <span class="pull-right">
                </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table  ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
{*                            <th>id</th>*}
{*                            <th>memberId</th>*}
{*                            <th>state</th>*}
{*                            <th>status</th>*}
{*                            <th>reason</th>*}
                            <th>نام ادمین</th>
                            <th>نام کاربر</th>
                            <th>شماره همراه کاربر</th>
                            <th>مبلغ درخواستی</th>
                            <th>علت تراکنش</th>
                            <th>وضعیت تراکنش</th>
                            <th>شماره فاکتور</th>
                            <th>تاریخ ثبت</th>
                            <td>توضیحات</td>
                            <th>وضعیت</th>


                        </tr>
                        </thead>
                        <tbody>
                        {*  {$objCreditDetailUser->list|var_dump}*}
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}

                        {foreach key=key item=item from=$list_item}
                            {$number=$number+1}
                            <tr>
                                <td>{$number}</td>
{*                                <td>{$item.id}</td>*}
{*                                <td>{$item.memberId}</td>*}
{*                                <td>{$item.state}</td>*}
{*                                <td>{$item.status}</td>*}
{*                                <td>{$item.reason}</td>*}
                                <td>{$objCreditDetailUser->infoAdmin($item.type_admin , $item.adminId ,$item.typeAgency)}</td>
                                <td>{$item.mamber_name}</td>
                                <td>{$item.mamber_mobile}</td>

                                <td>
                                    {$item.amount|number_format:$format_desimal}
                                </td>

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
                                <td>{$item.factorNumber}</td>
                                <td >{$objCreditDetailUser->timeToDateJalali($item.creationDateInt)}</td>
                                <td>{$item.comment}</td>
                                <td>
                                    <span class='pending-bg-text-with-padding-and-radius text-center'>

                                        <a href='javascript:'  onclick="ModalShowRequestCredit({$item.id} , {$item.memberId});return false"
                                           data-toggle="modal"
                                           data-target="#ModalPublic" style='color: #fff;'>
                                        مشاهده جزییات
                                        </a>
                                    </span>

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

<script type="text/javascript" src="assets/JsFiles/creditUser.js"></script>