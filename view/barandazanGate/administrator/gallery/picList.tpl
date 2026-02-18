{load_presentation_object filename="gallery" assign="objGallery"}

{*{assign var="list_gallery_pic" value=$objGallery->listGalleryPic()}*}
{*/درصورت دریافت سته بندی از کد زیر استفاده شود/*}
{assign var="catId" value=$smarty.get.catId}
{assign var="type_data" value=['catId'=>$catId]}
{*{$type_data|var_dump}*}
{assign var='list_gallery_pic' value=$objGallery->listGalleryPic($type_data)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/gallery/catList">لیست دسته بندی گالری تصاویر</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {if $catId}
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/gallery/picAdd&catId={$catId}"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    تصویر جدید
                </a>
                {else}
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/gallery/picAdd"
                       class="btn btn-info waves-effect waves-light mb-5" type="button">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        تصویر جدید
                    </a>
                {/if}


                <h3 class="box-title m-b-0">لیست تصاویر</h3>

                <div class="table-responsive">

                        <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th width="20px" class="head_right"></th>
                            <th>عنوان</th>
                            <th>تصویر</th>
                            {if !$catId}
                            <th>دسته بندی</th>
                            {/if}
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_gallery_pic != ''}
                        {foreach key=key item=item from=$list_gallery_pic}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.tiny_title}</td>
                            {if $item.type=='pic'}
                                <td class="align-middle"><img src='{$item.pic}' width='50' height='50'> </td>
                            {else}
                                <td class="align-middle"><a href='{$item.pic}' target='_blank'><img src='assets/css/images/video.png' width='50' height='50'> </a></td>
                            {/if}
                            {if !$catId}
                            <td class="align-middle">{$item.cat_title['title']}</td>
                            {/if}
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateGalleryPic('{$item.id}'); return false">
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
                                <a href="picEdit&id={$item.id}" class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش تصویر"></i></a>

                                <button class="btn btn-sm btn-outline btn-danger deleteGalleryPic"
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

<script type="text/javascript" src="assets/JsFiles/galleryPic.js"></script>

