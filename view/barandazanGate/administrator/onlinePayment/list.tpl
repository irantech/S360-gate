{load_presentation_object filename="onlinePayment" assign="objOnlinePayment"}
{assign var="trackingCode" value=$smarty.get.trackingCode}
{assign var="type_data" value=['trackingCode'=>$trackingCode]}
{assign var="list_online_payment" value=$objOnlinePayment->listOnlinePayment($type_data)}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/onlinePayment/list">لیست کد رهگیری</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/onlinePayment/listPrice"
                   class="btn btn-info waves-effect waves-light mb-5" type="button"  style='float: left; margin-left: 5px'>
                    <span class="btn-label"><i class="fa fa-list"></i></span>
                    لیست فاکتورها
                </a>


                    <h3 class="box-title m-b-0">لیست درخواست ها</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه پرداختی ها را مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>کد رهگیری</th>
                            <th>قیمت</th>
                            <th>تلفن</th>
                            <th>زبان</th>
                            <th>توضیح</th>
                            <th>بابت</th>
                            <th>وضعیت </th>
                            <th>وضعیت مشاهده</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_online_payment != ''}
                            {foreach key=key item=item from=$list_online_payment}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                    <td class="align-middle">{$item.name}</td>
                                    <td class="align-middle">{$item.code}</td>

                                    <td class="align-middle">{$item.amount} ریال</td>
                                    {if $item.phone}
                                        <td class="align-middle">{$item.phone}</td>
                                    {else}
                                        <td class="align-middle">---</td>
                                    {/if}
                                    <td class="align-middle">{if $item.language}{$languages[$item.language]}{else}---{/if}</td>

                                    {if $item.reason}
                                        <td class="align-middle">{$item.reason}</td>
                                    {else}
                                        <td class="align-middle">---</td>
                                    {/if}
                                    {if $item.title_price}
                                        <td class="align-middle"><a href='editPrice&id={$item.id_price}'>{$item.title_price}</a></td>
                                    {else}
                                        <td class="align-middle">---</td>
                                    {/if}

                                    {if $item.status=='hold'}
                                        <td class="align-middle">
                                            <a class="btn btn-warning" style="color:#fff;">پرداخت نشده</a>
                                        </td>
                                    {elseif $item.status=='bank'}
                                        <td class="align-middle">
                                            <a class="btn btn-primary" style="color:#fff;">اتصال به درگاه بانک</a>
                                        </td>
                                    {elseif $item.status=='cash'}
                                        <td class="align-middle">
                                            <a class="btn btn-success" style="color:#fff;">پرداخت شده</a>
                                        </td>
                                    {elseif $item.status=='cancel'}
                                        <td class="align-middle">
                                            <a class="btn btn-danger" style="color:#fff;">کنسل شده</a>
                                        </td>
                                    {/if}

                                    {if $item.view=='seen'}
                                        <td class="align-middle">
                                            <a class="btn btn-primary" style="color:#fff;">مشاهده شد</a>
                                        </td>
                                    {else}
                                        <td class="align-middle">
                                            <a class="btn btn-warning" style="color:#fff;">مشاهده نشده</a>
                                        </td>
                                    {/if}


                                    <td class="align-middle">
                                        <a href="edit&id={$item.id} " class="btn btn-sm btn-outline gap-4 btn-primary">جزییات پرداخت</a>


                                        <button class="btn btn-sm btn-outline btn-danger deleteOnlinePayment"
                                                data-id="{$item.id}">
                                            <i class="fa fa-trash"></i> حذف
                                        </button>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/onlinePayment.js"></script>

