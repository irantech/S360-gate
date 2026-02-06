{load_presentation_object filename="uploadFiles" assign="objUpload"}

{assign var="list_upload" value=$objUpload->listUpload()}

<div class='container-fluid' xmlns='http://www.w3.org/1999/html'>
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/uploadFiles/list">لیست آپلودها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/uploadFiles/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button"  style='float: left;'>
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                        آپلود فایل جدید
                </a>

                <h3 class="box-title m-b-0">لیست فایل ها</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه فایل های آپلود شده وب سایت خود را مشاهده نمائید</p>

                <div class="table-responsive">

                    <form data-toggle="validator" id="delete_uploads" method="post"  enctype="multipart/form-data">
                        <input type='hidden' value='deleteAllUpload' id='method' name='method'>
                        <input type='hidden' value='uploadFiles' id='className' name='className'>
                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th width="20px" class="head_right"></th>
                            <th>ردیف</th>
                            <th>فایل</th>
                            <th>نوع</th>
                            <th>لینک</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_upload != ''}
                            {foreach key=key item=item from=$list_upload}
                                {$number=$number+1}
                                <tr id="del-{$item.id}" >
                                    <td class='form-group' ><input type="checkbox" name="checkbox[]" id="checkbox[]" value="{$item.id}" class="checkbox checkbox-upload" style='margin: 17px 0 0 0;' /></td>
                                    <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                    {if $item.type=='pic'}
                                    <td class="align-middle"><img src='{$item.file}' width='50' height='50'> </td>
                                    {else}
                                    <td class="align-middle"><a href='{$item.file}' target='_blank'><img src='assets/css/images/{$item.kind}.png' width='50' height='50'> </a></td>
                                    {/if}
                                    <td class="align-middle">{$item.kind}</td>
                                    <td class="align-middle">
                                        <a href="{$item.file}"  id="p{$item.id}">{$item.file}</a>

                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-outline btn-danger deleteUpload"
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

              {*  <input   class="btn btn-danger" type="submit" onclick='deleteItem()' value="حذف" title="حذف" style='margin: 20px 0 0 0;' />*}
                </form>

                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/uploadFiles.js"></script>

