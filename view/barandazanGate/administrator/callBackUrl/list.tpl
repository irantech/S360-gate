{load_presentation_object filename="callBackUrl" assign="objCallBack"}

{assign var="list_call_back" value=$objCallBack->getCallBackUrlList()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/callBackUrl/list">لیست لینک ها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/callBackUrl/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    لینک جدید
                </a>
                <h3 class="box-title m-b-0">لیست لینک ها</h3>
                <div class="table-responsive table-bordered">

                    <table id="myTable" class="table table-striped table-hover">

                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان لینک</th>
                            <th>لینک </th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_call_back != ''}
                        {foreach key=key item=item from=$list_call_back}

                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            {if $item['type'] == 'register_user'}
                                <td class="align-middle">ثبت نام کاربر</td>
                            {else}
                                <td class="align-middle">خرید کاربران</td>
                            {/if}
                            <td class="align-middle">{$item['url']}</td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateStatusCallBack('{$item.id}'); return false">
                                    {if $item.active eq 1}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.id} " class="btn btn-sm btn-outline btn-primary" >
                                    ویرایش اطلاعات
                                </a>
                                <button class="btn btn-sm btn-outline btn-danger deleteRedirect"
                                        data-id="{$item.id}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
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

<script type="text/javascript" src="assets/JsFiles/callBack.js"></script>

