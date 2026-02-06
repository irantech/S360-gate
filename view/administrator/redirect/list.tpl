{load_presentation_object filename="redirect" assign="objRedirect"}

{assign var="list_redirect" value=$objRedirect->listRedirect()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/redirect/list">لیست لینک ها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/redirect/add"
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
                            <th>عنوان</th>
                            <th>نوع</th>
                            <th>لینک قدیم</th>
                            <th>لینک جدید</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_redirect != ''}
                        {foreach key=key item=item from=$list_redirect}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.title}</td>
                            <td class="align-middle">
                                {if $item.url_old}
                                <a href='{$item.url_old}' target='_blank'>{$item.url_old}</a>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td class="align-middle">
                                {if $item.type eq '410'}
                                    410
                                {elseif $item.type eq 'canonical'}
                                    Canonical
                                {else}
                                    Redirect
                                {/if}
                            </td>
                            <td class="align-middle">
                                {if $item.url_new}
                                <a href='{$item.url_new}' target='_blank'>{$item.url_new}</a>
                                {else}
                                    ---
                                {/if}
                            </td>

                            <td class="align-middle">
                                <a href="edit&id={$item.id} " class="btn btn-sm btn-outline btn-primary" >
                                    ویرایش اطلاعات
                                </a>
                                <button class="btn btn-sm btn-outline btn-danger deleteRedirect"
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

<script type="text/javascript" src="assets/JsFiles/redirect.js"></script>

