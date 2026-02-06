{load_presentation_object filename="onlinePayment" assign="objOnlinePayment"}


{assign var="list_price" value=$objOnlinePayment->listPrice()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/onlinePayment/listPrice">لیست فاکتورها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/onlinePayment/addPrice"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    تعریف فاکتور جدید
                </a>
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/onlinePayment/list"
                   class="btn btn-info waves-effect waves-light mb-5" type="button"  style='float: left; margin-left: 5px'>
                    <span class="btn-label"><i class="fa fa-list"></i></span>
                    لیست درخواست ها
                </a>

                <h3 class="box-title m-b-0">لیست فاکتورها</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست قیمت ها را برای پرداخت آنلاین مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان </th>
                            <th>قیمت</th>
                            <th>کد رهگیری</th>
                            <th>لینک پرداخت</th>
                            <th>تعداد درخواست</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_price != ''}
                        {foreach key=key item=item from=$list_price}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{if $item.title}{$item.title}{else}___{/if}</td>
                            <td class="align-middle">{if $item.price}{$item.price}{else}___{/if}</td>
                            <td class="align-middle">{if $item.tracking_code}{$item.tracking_code}{else}___{/if}</td>
                            <td class="align-middle">
                                <a target='_blank' href='http://{$smarty.const.CLIENT_DOMAIN}/gds/fa/pay/{$item.tracking_code}'>
                                    http://{$smarty.const.CLIENT_DOMAIN}/gds/fa/pay/{$item.tracking_code}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a target='_blank' href='list&trackingCode={$item.tracking_code}'>
                                    {$item.count_user}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateStatusPrice('{$item.id}'); return false">
                                    {if $item.is_active}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="editPrice&id={$item.id} " class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش قیمت"></i></a>

                                <button class="btn btn-sm btn-outline btn-danger deletePriceItem"
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

<script type="text/javascript" src="assets/JsFiles/onlinePayment.js">
