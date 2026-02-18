{load_presentation_object filename="fullCapacity" assign="objFullCapacity"}

{assign var="list_item" value=$objFullCapacity->listFullCapacity()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/fullCapacity/list">لیست تصاویر</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {*
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/fullCapacity/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                        تصویر جدید
                </a>
                *}

                <h3 class="box-title m-b-0">لیست تصاویر</h3>

                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تصویر</th>
                            <th>عنوان</th>
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
                                    {if $item.type=='pic'}
                                    <td class="align-middle"><img src='{$item.pic}' width='50' height='50'> </td>
                                    {else}
                                    <td class="align-middle"><a href='{$item.pic}' target='_blank'><img src='assets/css/images/video.png' width='50' height='50'> </a></td>
                                    {/if}
                                    <td class="align-middle">{$item.title}</td>
                                    <td class="align-middle">
                                        <a href="#"
                                           onclick="updateStatusFullCapacity('{$item.id}'); return false">
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
                                        <a href="edit&id={$item.id} " class=""><i
                                                    class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="ویرایش تصویر"></i></a>
                                        {*
                                       <button class="btn btn-sm btn-outline btn-danger deleteFullCapacity"
                                               data-id="{$item.id}">
                                           <i class="fa fa-trash"></i> حذف
                                       </button>
                                       *}
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

<script type="text/javascript" src="assets/JsFiles/fullCapacity.js"></script>

