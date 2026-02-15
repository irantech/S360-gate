{load_presentation_object filename="galleryBanner" assign="objGalleryBanner"}

{assign var="list_galleryBanner" value=$objGalleryBanner->listGalleryBanner()}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/galleryBanner/list">لیست گالری بنر</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/galleryBanner/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                        بنر جدید
                </a>




                <h3 class="box-title m-b-0">لیست گالری بنر</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه بنرهای وب سایت خود را مشاهده نمائید</p>
                <div class="table-responsive table-bordered">

                    <table id="myTable" class="table table-striped table-hover">

                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>زبان</th>
                            <th>تصویر</th>
                            <th>ترتیب</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_galleryBanner != ''}
                            {foreach key=key item=item from=$list_galleryBanner}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                    <td class="align-middle">{$item.title}</td>
                                    <td class="align-middle">{$languages[$item.language]}</td>

                                    {if $item.iframe_code==''}
                                    {if $item.type=='pic'}
                                    <td class="align-middle"><img src='{$item.pic}' width='50' height='50'> </td>
                                    {else}
                                    <td class="align-middle"><a href='{$item.pic}' target='_blank'><img src='assets/css/images/video.png' width='50' height='50'> </a></td>
                                    {/if}
                                    {else}
                                        <td class="align-middle">
                                             ویدئو iframe
                                        </td>
                                    {/if}
                                    <td class="align-middle"  ><input type="number"  size="10" name="order[{$item.id}]" id="order" value="{$item.orders}" class="list-order"></td>

                                    <td class="align-middle">
                                        <a href="#"
                                           onclick="updateStatusGalleryBanner('{$item.id}'); return false">
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
                                                    data-original-title="ویرایش بنر"></i></a>

                                        <button class="btn btn-sm btn-outline btn-danger deleteGalleryBanner"
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
                <input   class="btn btn-info" type="button" onclick='change_order()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />

            </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/galleryBanner.js"></script>

