{load_presentation_object filename="employment" assign="objEmployment"}
{assign var="list_employment" value=$objEmployment->listEmployment()}
{load_presentation_object filename="requestServiceStatus" assign="objEmploymentStatus"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/list">لیست درخواست استخدام</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/listJobRequested"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    مشاغل درخواستی
                </a>

                <h3 class="box-title m-b-0">لیست درخواست استخدام</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست درخواست های استخدام را مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>شماره همراه</th>
                            <th>شماره ثابت</th>
                            <th>جنسیت</th>
                            <th>کد پیگیری</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_employment != ''}
                        {foreach key=key item=item from=$list_employment}
                        {$number=$number+1}
                        <tr id="del-{$item.eId}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>

                            <td class="align-middle">{$item.name}</td>
                            <td class="align-middle">{if $item.mobile}{$item.mobile}{else}---{/if}</td>
                            <td class="align-middle">{if $item.phone}{$item.phone}{else}---{/if}</td>
                            <td class="align-middle">{if $item.gender==1}مرد{elseif $item.gender==2 }زن{else}---{/if}</td>
                            <td class="align-middle">{$item.tracking_code}</td>
                            <td class="align-middle">
                                {if $item.status}
                                    {foreach $objEmploymentStatus->getRequestServiceStatusList() as $status}
                                        {if $item.status=={$status['value']}}
                                            <a class='{$status['btn']}' style='color:#fff;'>{$status['title']}</a>
                                        {/if}
                                    {/foreach}
                                {/if}

                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.eId} " class="btn btn-sm btn-outline gap-4 btn-primary">جزییات درخواست</a>
                                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=employment&id={$item.sId}" target="_blank" class="btn btn-sm btn-outline gap-4 btn-primary" title="دانلود رزومه(pdf)">
                                    <i class="  tooltip-success  fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="دانلود رزومه"></i></a>
                                <button class="btn btn-sm btn-outline btn-danger deleteEmployment"
                                        data-id="{$item.eId}">
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


<script type="text/javascript" src="assets/JsFiles/employment.js"></script>

