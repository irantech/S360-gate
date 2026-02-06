
{load_presentation_object filename="orderServices" assign="objOrder"}
{assign var="list_order" value=$objOrder->listOrderServices()}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/list">لیست درخواست استخدام</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/addKind"
                   class="btn btn-info waves-effect waves-light mb-5" type="button" style='float: left'>
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    نوع جدید
                </a>
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/listKind"
                   class="btn btn-info waves-effect waves-light mb-5" type="button"  style='float: left; margin-left: 5px'>
                    <span class="btn-label"><i class="fa fa-list"></i></span>
                    لیست انواع خدمات
                </a>
                <h3 class="box-title m-b-0">لیست درخواست خدمات</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست درخواست های خدمات را مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>شماره همراه</th>
                            <th>کشور</th>
                            <th>نوع درخواست</th>
                            <th>کد پیگیری</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_order != ''}
                        {foreach key=key item=item from=$list_order}
                        {$number=$number+1}
                        <tr id="del-{$item.oId}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>

                            <td class="align-middle">{$item.name}</td>
                            <td class="align-middle">{if $item.mobile}{$item.mobile}{else}---{/if}</td>
                            <td class="align-middle">
                                {if $item.country}
                                    {$item['country_name']}
                                {else}
                                ---
                                {/if}
                            </td>
                            <td class="align-middle">
                                {if $item.kind_service}
                                   {$item['kind_title']}
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td class="align-middle">{$item.tracking_code}</td>
                            <td class="align-middle">
                                {if $item.status}
                                    {foreach $objStatus->getRequestServiceStatusList() as $status}
                                        {if $item.status=={$status['value']}}
                                            <a class='{$status['btn']}' style='color:#fff;'>{$status['title']}</a>
                                        {/if}
                                    {/foreach}
                                {/if}

                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.oId}" class="btn btn-sm btn-outline gap-4 btn-primary">جزییات درخواست</a>
                                <button class="btn btn-sm btn-outline btn-danger deleteOrderServices"
                                        data-id="{$item.oId}">
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


<script type="text/javascript" src="assets/JsFiles/orderServices.js"></script>

