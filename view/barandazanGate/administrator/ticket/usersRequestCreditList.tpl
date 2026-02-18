
{load_presentation_object filename="memberCredit" assign="objCreditDetailUser"}
{assign var="list_item" value=$objCreditDetailUser->getAllRequest()}

{assign value=0 var="format_desimal"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li><a href="mainUserList">لیست کاربران</a></li>
                    <li>لیست درخواست وجه از اعتبار</li>
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
                <h3 class="box-title m-b-0">لیست درخواست وجه از اعتبار</h3>
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
                            <th>نام کاربر</th>
                            <th>شماره همراه کاربر</th>
                            <th>مبلغ درخواستی</th>
                            <th>علت تراکنش</th>
                            <th>شماره فاکتور</th>
                            <th>تاریخ ثبت</th>
                            <td>توضیحات</td>
                            <th>وضعیت</th>


                        </tr>
                        </thead>
                        <tbody>
{*                        {$objCreditDetailUser->list|var_dump}*}
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
                                <td>{$item.mamber_name}</td>
                                <td>{$item.mamber_mobile}</td>

                                <td>
                                   {$item.amount|number_format:$format_desimal}
                                </td>

                                    <td>
                                   برداشت از اعتبار توسط کاربر
                                    </td>
                                   <td>{$item.factorNumber}</td>
                                <td >{$objCreditDetailUser->timeToDateJalali($item.creationDateInt)}</td>
                                <td>{$item.comment}</td>
                                <td>
                                    <span class='pending-bg-text-with-padding-and-radius text-center'>

                                        <a href='javascript:'  onclick="ModalShowRequestCredit({$item.id} , {$item.memberId});return false"
                                                                       data-toggle="modal"
                                                                       data-target="#ModalPublic">
                                        پاسخ ادمین
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