{if $smarty.const.TYPE_ADMIN eq 1 }
{load_presentation_object filename="bannerBackground" assign="objBannerBackground"}

{assign var="list_bannerBackground" value=$objBannerBackground->listBannerBackground()}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/bannerBackground/list">لیست بنر بک گراند</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/bannerBackground/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                        بنر بک گراند جدید
                </a>




                <h3 class="box-title m-b-0">لیست بنرهای بک گراند</h3>

                <div class="table-responsive table-bordered">

                    <table id="myTable" class="table table-striped table-hover">

                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>تصویر</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_bannerBackground != ''}
                            {foreach key=key item=item from=$list_bannerBackground}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                    <td class="align-middle">{$item.title}</td>
                                    {if $item.type=='pic'}
                                        <td class="align-middle"><img src='{$item.pic}' width='50' height='50'> </td>
                                    {else}
                                        <td class="align-middle"><a href='{$item.pic}' target='_blank'><img src='assets/css/images/icon-file.png' width='50' height='50'> </a></td>
                                    {/if}
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-outline btn-danger deleteBannerBackground"
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

<script type="text/javascript" src="assets/JsFiles/bannerBackground.js"></script>

{/if}

