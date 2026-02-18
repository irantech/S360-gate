{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li> حسابداری</li>
                <li class="active">گزارش شارژ حساب</li>
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
                <h3 class="box-title m-b-0">گزارش واریز دستی</h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام آژانس</th>
                            <th>فاکتور</th>
                            <th>توضیحات</th>
                            <th>مبلغ</th>
                            <th>تاریخ تراکنش</th>
                            <th>نوع تراکنش</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="remain" value=$objAccount->total_transaction}
                        {foreach key=key item=item from=$objAccount->ListPendingCreditManual()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td><span>{$item.AgencyName}</span></td>
                                <td>

                                    {$item.FactorNumber}

                                </td>
                                <td>{$item.Comment}</td>
                                <td>{$item.Price|number_format}
                                    {$priceTotal = {$item.Price} + $priceTotal}
                                </td>
                                <td>{$objbook->DateJalali($item.PriceDate)}</td>
                                <td>
                                    {if $item.Reason eq 'buy'}
                                        خرید بلیط
                                    {elseif $item.Reason eq 'charge'}
                                        شارژحساب
                                    {elseif $item.Reason eq  'price_cancel'}
                                        مبلغ کنسلی
                                    {elseif $item.Reason eq 'indemnity_cancel'}
                                        جریمه کنسلی
                                    {elseif $item.Reason eq  'increase'}
                                        واریز به حساب شما
                                    {elseif $item.Reason eq  'decrease'}
                                        کسر از حساب شما
                                    {else }
                                        ـــــــ
                                    {/if}

                                </td>

                                <td>


                                    <div class="btn-group m-r-10">

                                        <button aria-expanded="false" data-toggle="dropdown"
                                                class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                type="button"> عملیات <span class="caret"></span></button>

                                        <ul role="menu" class="dropdown-menu animated flipInY" style="position:absolute; right:-36px">
                                            <li>
                                                <div class="pull-left">
                                                    <div class="pull-left margin-10">
                                                        <a href="#"  onclick="changeStatusPaymentManual('accept','{$item.clientId}','{$item.FactorNumber}');return false" class=""><i
                                                                    class="fcbtn btn btn-outline btn-success btn-1e fa fa-check-square-o tooltip-success"
                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                    data-original-title="تایید درخواست"></i></a>
                                                    </div>
                                                    <div class="pull-left margin-10">
                                                        <a href="#"  onclick="changeStatusPaymentManual('reject','{$item.clientId}','{$item.FactorNumber}');return false"class=""><i
                                                                    class="fcbtn btn btn-outline btn-danger  btn-1e fa fa-frown-o tooltip-danger "
                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                    data-original-title="رد درخواست"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="pull-left">
                                                    <div class="pull-left margin-10">
                                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUser&id={$item.clientId} " class=""><i
                                                                    class="fcbtn btn btn-outline btn-info btn-1e fa fa-money tooltip-info"
                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                    data-original-title="مشاهده تراکنش ها"></i></a>
                                                    </div>
                                                    <div class="pull-left margin-10">
                                                        <a href="http://{$item.Domain}/gds/itadmin/login&id={$item.token}" class="" target="_blank"><i
                                                                    class="fcbtn btn btn-outline btn-primary btn-1e fa fa-sign-in tooltip-primary"
                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                    data-original-title="ورود به ادمین مشتری"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
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
<script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>