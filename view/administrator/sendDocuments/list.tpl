
{load_presentation_object filename="sendDocuments" assign="objSendDocument"}
{assign var="list_document" value=$objSendDocument->listDocuments()}




<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/sendDocuments/list">لیست مدارک</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست ارسال مدارک</h3>

                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>زبان</th>
                            <th>نام و نام خانوادگی</th>
                            <th>کد ملی</th>
                            <th>شماره همراه</th>
                            <th>کد پیگیری</th>
                            <th>وضعیت بررسی مدارک</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_document != ''}
                        {foreach key=key item=item from=$list_document}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$languages[$item.language]}</td>

                            <td class="align-middle">{$item.name}</td>
                            <td class="align-middle">{$item.national_code}</td>
                            <td class="align-middle">{if $item.mobile}{$item.mobile}{else}---{/if}</td>

                            <td class="align-middle">{$item.tracking_code}</td>
                            <td class="align-middle">
                                {if $item.status == 'not_seen'}
                                     بررسی نشده
                                {elseif $item.status == 'seen'}
                                مشاهده شده
                                {elseif $item.status == 'accept'}
                                 پذیرفته شده
                                {elseif $item.status == 'reject'}
                                رد شده
                                {/if}

                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.id}" class="btn btn-sm btn-outline gap-4 btn-primary">جزییات درخواست</a>
                            </td>
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



