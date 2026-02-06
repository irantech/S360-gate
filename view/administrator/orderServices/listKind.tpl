{load_presentation_object filename="orderServicesKind" assign="objKind"}

{assign var="list_kind" value=$objKind->listKindOrderServices()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderservices/listKind">لیست انواع درخواست خدمات</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/addKind"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    نوع درخواست خدمات جدید
                </a>
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/list"
                   class="btn btn-info waves-effect waves-light mb-5" type="button"  style='float: left; margin-left: 5px'>
                    <span class="btn-label"><i class="fa fa-list"></i></span>
                    لیست درخواست ها
                </a>

                <h3 class="box-title m-b-0">لیست انواع درخواست خدمات</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست انواع درخواست خدمات وب سایت خود را مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان فارسی</th>
                            <th>عنوان انگلیسی</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_kind != ''}
                        {foreach key=key item=item from=$list_kind}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{if $item.titleFa}{$item.titleFa}{else}___{/if}</td>
                            <td class="align-middle">{if $item.titleEn}{$item.titleEn}{else}___{/if}</td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateStatusKind('{$item.id}'); return false">
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
                                <a href="editKind&id={$item.id} " class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش نوع"></i></a>

                                <button class="btn btn-sm btn-outline btn-danger deleteKindOrderServicesItem"
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

<script type="text/javascript" src="assets/JsFiles/orderServicesKind.js"></script>

