{load_presentation_object filename="introductIran" assign="objProvince"}

{assign var="list_province" value=$objProvince->listProvince()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/list">لیست استان ها</a></li>
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

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/list"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    لیست آثار باستانی
                </a>
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/itemAdd"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    آثار باستانی جدید
                </a>


                <h3 class="box-title m-b-0">لیست استان ها</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه استان های وب سایت را مشاهده نمائید</p>
                <div class="table-responsive">
                    <form data-toggle="validator" id="form_data" method="post"  enctype="multipart/form-data">
                        <input type='hidden' value='change_form' id='method' name='method'>
                        <input type='hidden' value='introductIran' id='className' name='className'>
                        <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>زبان</th>
                            <th>تصویر</th>
                            <th>ترتیب</th>
                            <th>وضعیت</th>
                            <th>تعداد آثار باستانی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_province != ''}
                        {foreach key=key item=item from=$list_province}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.title}</td>
                            <td class="align-middle">{$languages[$item.language]}</td>
                            {if $item.type=='pic'}
                                <td class="align-middle"><img src='{$item.pic_show}' width='50' height='50'> </td>
                            {else}
                                <td class="align-middle"><a href='{$item.pic_show}' target='_blank'><img src='assets/css/images/delete.png' width='50' height='50'> </a></td>
                            {/if}
                            <td class="align-middle"  ><input type="number"  size="10" name="order[{$item.id}]" id="order" value="{$item.orders}" class="list-order"></td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateStatusProvince('{$item.id}'); return false">
                                    {if $item.is_active}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td class="align-middle"><a  href="itemList&provinceId={$item.id}" >{$objProvince->countItemList({$item.id})} مکان تاریخی </a></td>
                            <td class="align-middle">
                                <a href="itemAdd&provinceId={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    افزودن آثار باستانی جدید
                                </a>
                                <a href="edit&id={$item.id}" class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش استان"></i></a>

                                <button class="btn btn-sm btn-outline btn-danger deleteProvince"
                                        data-id="{$item.id}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>


                        </td>
                        </tr>

                {/foreach}
                {/if}

                </tbody>

                </table>
                        <input   class="btn btn-info" type="button" onclick='change_order()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />
                    </form>
                </div>

            </div>
    </div>

</div>
</div>

<script type="text/javascript" src="assets/JsFiles/introductIran.js"></script>

