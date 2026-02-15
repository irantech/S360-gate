{load_presentation_object filename="contactUs" assign="objcontact"}

{assign var="contactList" value=$objcontact->GetData('feedback')}

{load_presentation_object filename="requestServiceStatus" assign="objRequestStatus"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/contactUs/main">انتقادات و پیشنهادات</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست انتقادات و پیشنهادات </h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه انتقادات و پیشنهادات مشتری ها را مشاهده نمائید</p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                            <tr>
                                <th>کد</th>
                                <th>نام و نام خانوادگی</th>
                                <th>زبان</th>

                                <th>موبایل</th>
                                <th>کد پیگیری</th>
                                <th>وضعیت</th>
{*                                <th>آژانس</th>*}
                                <th>تاریخ</th>
                                <th>مشاهده</th>
                            </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $contactList != ''}
                            {foreach key=key item=item from=$contactList}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                    <td class="align-middle">{$item.name}</td>
                                    <td class="align-middle">{if $item['lang']}{$languages[$item['lang']]}{else}---{/if}</td>
                                    <td class="align-middle">{$item.mobile}</td>
                                    <td class="align-middle">{$item.tracking_code}</td>
                                    <td class="align-middle">
                                        {if $item.status}
                                            {foreach $objRequestStatus->getRequestServiceStatusList() as $status}
                                                {if $item.status==$status['value']}
                                                    <a class='{$status['btn']}' style='color:#fff;'>{$status['title']}</a>
                                                {/if}
                                            {/foreach}
                                        {/if}

                                    </td>
{*                                    <td class="align-middle">*}
{*                                        {if $item.agency_id == 0}*}
{*                                            آژانس اصلی*}
{*                                        {else}*}
{*                                            {$item.name_fa}*}
{*                                        {/if}*}
{*                                    </td>*}
                                    <td class="align-middle">{$objFunctions->ConvertToJalaliOfDateGregorian($item.created_at)}</td>

                                    <td class="align-middle">
                                        <div class="btn-group m-r-10">
                                            {*
                                            <a onclick="ModalShowContact('{$item.id}');return false"
                                               data-toggle="modal"
                                               data-target="#ModalPublic">
                                                <i id="seenContact-{$item.id}" class="fcbtn btn {if $item.seen_at != null } btn-outline {/if} btn-info btn-1c tooltip-info fa fa-eye"
                                                   data-toggle="tooltip"
                                                   data-placement="top" title=""
                                                   data-original-title="مشاهده جزییات"></i>
                                            </a>
                                            *}
                                            <a href="edit&id={$item.cId} " class="btn btn-sm btn-outline gap-4 btn-primary">جزییات درخواست</a>

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

<script type="text/javascript" src="assets/JsFiles/contactUs.js"></script>