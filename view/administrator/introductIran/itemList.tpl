{load_presentation_object filename="introductIran" assign="objItem"}

{*{assign var="list_item" value=$objItem->listItem()}*}
{*/درصورت دریافت استان از کد زیر استفاده شود/*}
{assign var="provinceId" value=$smarty.get.provinceId}
{assign var="type_data" value=['provinceId'=>$provinceId]}
{*{$type_data|var_dump}*}
{assign var='list_item' value=$objItem->listItem($type_data)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/list">لیست استان ها</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/list">لیست آثار باستانی</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    استان جدید
                </a>
                {if $provinceId}
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/itemAdd&provinceId={$provinceId}"
                       class="btn btn-info waves-effect waves-light mb-5" type="button">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        آثار باستانی جدید
                    </a>
                {else}
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/itemAdd"
                       class="btn btn-info waves-effect waves-light mb-5" type="button">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        آثار باستانی جدید
                    </a>
                {/if}


                <h3 class="box-title m-b-0">لیست آثار باستانی</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه آثار باستانی وب سایت را مشاهده نمائید</p>
                <div class="table-responsive">
                    <form data-toggle="validator" id="form_data" method="post"  enctype="multipart/form-data">
                        <input type='hidden' value='change_form_item' id='method' name='method'>
                        <input type='hidden' value='introductIran' id='className' name='className'>
                        <table id="myTable" class="table table-striped ">

                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>تصویر</th>
                                <th>ترتیب</th>
                                <th>استان</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {if $list_item != ''}
                                {foreach key=key item=item from=$list_item}
                                    {$number=$number+1}
                                    <tr id="del-{$item.id}">
                                        <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                        <td class="align-middle">{$item.title}</td>
                                        {if $item.type=='pic'}
                                            <td class="align-middle"><img src='{$item.pic_show}' width='50' height='50'> </td>
                                        {else}
                                            <td class="align-middle"><a href='{$item.pic_show}' target='_blank'><img src='assets/css/images/video.png' width='50' height='50'> </a></td>
                                        {/if}
                                        <td class="align-middle"  ><input type="number"  size="10" name="order[{$item.id}]" id="order" value="{$item.orders}" class="list-order"></td>
                                        <td class="align-middle">{$item.cat_title['title']}</td>
                                        <td class="align-middle">
                                            <a href="#"
                                               onclick="updateItem('{$item.id}'); return false">
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
                                            <a href="itemEdit&id={$item.id}" class=""><i
                                                        class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="ویرایش آثار باستانی"></i></a>

                                            <button class="btn btn-sm btn-outline btn-danger deleteItem"
                                                    data-id="{$item.id}">
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        </td>
                                    </tr>

                                {/foreach}
                            {/if}

                            </tbody>

                        </table>
                        <input   class="btn btn-info" type="button" onclick='change_order_item()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />

                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/introductIran.js"></script>

