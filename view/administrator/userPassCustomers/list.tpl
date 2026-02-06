{load_presentation_object filename="userPassCustomers" assign="objCustomer"}

{assign var="list_customer" value=$objCustomer->listCustomer()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userPassCustomers/list">لیست پاپ آپ</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userPassCustomers/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    مشتری جدید
                </a>
                {*
                <a class="btn btn-info waves-effect waves-light mb-5 uploadExcel"
                        data-id="excel">
                    آپلود اکسل
                </a>
                *}
                <h3 class="box-title m-b-0">لیست مشتری ها</h3>
                <div class="table-responsive table-bordered">

                    <table id="myTable" class="table table-striped table-hover">

                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>نام کاربری</th>
                            <th>دامنه</th>
                            <th>لینک لاگین</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_customer != ''}
                        {foreach key=key item=item from=$list_customer}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.title}</td>

                            <td class="align-middle">
                                {if $item.user_name}
                                {$item.user_name}
                                {else}
                                ---
                                {/if}
                            </td>

                            <td class="align-middle">
                                {if $item.domain}
                                <a href='{$item.domain}' target='_blank'>{$item.domain}</a>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td class="align-middle">
                                {if $item.link}
                                <a href='{$item.link}' target='_blank'>{$item.link}</a>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateActiveCustomer('{$item.id}'); return false">
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
                                <a href="edit&id={$item.id} " class="btn btn-sm btn-outline btn-primary" >
                                    ویرایش اطلاعات اولیه
                                </a>
                                <a href="changePassword&id={$item.id} " class="btn btn-sm btn-outline btn-primary" >
                                    تغییر رمز عبور
                                </a>
                                <button class="btn btn-sm btn-outline btn-danger deleteCustomer"
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

<script type="text/javascript" src="assets/JsFiles/userPassCustomers.js"></script>

