{load_presentation_object filename="onlinePayment" assign="objOnlinePayment"}
{assign var="info_online_payment" value=$objOnlinePayment->getOnlinePayment($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/onlinePayment/list">
                        لیست درخواست پرداخت آنلاین
                    </a>
                </li>
                <li class='active'>
                    جزییات درخواست
                    <span class='font-bold underdash'>{$info_online_payment['name']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row online-payment">
        <div class="container">
            <h2>جزییات درخواست  {$info_online_payment['name']}</h2>
            <p>همه اطلاعات ارسالی را در این قسمت مشاهده نمائید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>متن </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>نام و نام خانوادگی</td>
                    <td>{if $info_online_payment['name']}{$info_online_payment['name']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>شماره تماس</td>
                    <td>{if $info_online_payment['phone']}{$info_online_payment['phone']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>کد رهگیری</td>
                    <td>{if $info_online_payment['code']}{$info_online_payment['code']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>زبان</td>
                    <td >{if $info_online_payment['language']}{$languages[$info_online_payment['language']]}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>مبلغ</td>
                    <td>{if $info_online_payment['amount']}{$info_online_payment['amount']} ریال{else}---{/if}</td>
                </tr>
                <tr>
                    <td>بابت</td>
                    <td>{if $info_online_payment['reason']}{$info_online_payment['reason']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تاریخ واریز</td>
                    <td>{if $info_online_payment['created_at']}{$info_online_payment['created_at']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>کد رهگیری بانک</td>
                    <td>{if $info_online_payment['tracking_code_bank']}{$info_online_payment['tracking_code_bank']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>وضعیت واریز</td>
                    <td>
                        {if $info_online_payment.status == 'hold'}
                                <a class="btn btn-warning" style="color:#fff;">پرداخت نشده</a>
                        {elseif $info_online_payment.status == 'bank'}
                                <a class="btn btn-primary" style="color:#fff;">اتصال به درگاه بانک</a>
                        {elseif $info_online_payment.status == 'cash'}
                                <a class="btn btn-success" style="color:#fff;">پرداخت شده</a>
                        {elseif $info_online_payment.status == 'cancel'}
                                <a class="btn btn-danger" style="color:#fff;">کنسل شده</a>
                        {/if}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/onlinePayment.js"></script>


