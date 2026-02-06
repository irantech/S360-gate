
{load_presentation_object filename="iranVisa" assign="objIranVisa"}
{assign var="list_visa" value=$objIranVisa->listIranVisa()}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/iranVisa/list">لیست درخواست ویزای ایران</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست درخواست ویزای ایران</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست درخواست های ویزای ایران را مشاهده نمائید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>شماره همراه</th>
                            <th>جنسیت</th>
                            <th>نوع پاسپورت</th>
                            <th>نوع ویزا</th>
                            <th>کد پیگیری</th>
                            <th>وضعیت درخواست</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_visa != ''}
                        {foreach key=key item=item from=$list_visa}
                        {$number=$number+1}
                        <tr id="del-{$item.vId}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>

                            <td class="align-middle">{$item.name_family}</td>
                            <td class="align-middle">{if $item.mobile}{$item.mobile}{else}---{/if}</td>
                            <td class="align-middle">{$item.gender_title}</td>
                            <td class="align-middle">
                                {if $item.type_passport eq 'Ordinary'}
                                    ##Ordinary##
                                {elseif $item.type_passport eq 'Service'}
                                    ##ServicePassport##
                                {elseif $item.type_passport eq 'Political'}
                                    ##Political##
                                {elseif $item.type_passport eq 'Travel-Document'}
                                    ##TravelDocument##
                                {elseif $item.type_passport eq 'Laissez-Passer'}
                                    ##LaissezPasser##
                                {elseif $item.type_passport eq 'Refuge'}
                                    ##Refuge##
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td class="align-middle">
                                {if $item.type_visa eq 'Tourist'}
                                    ##Tourist##
                                {elseif $item.type_visa eq 'Business'}
                                    ##Business##
                                {elseif $item.type_visa eq 'Multiple_Entry'}
                                    ##MultipleEntry##
                                {elseif $item.type_visa eq 'Pilgrimage'}
                                    ##Pilgrimage##
                                {elseif $item.type_visa eq 'Treatment'}
                                    ##Treatment##
                                {else}
                                    ----
                                {/if}
                            </td>
                            <td class="align-middle">{$item.tracking_code}</td>
                            <td class="align-middle">
                                {if $item.status}
                                    {foreach $objStatus->getRequestServiceStatusList() as $status}
                                        {if $item.status=={$status['value']}}
                                            <a class='{$status['btn']}' style='color:#fff;'>{$status['title']}</a>
                                        {/if}
                                    {/foreach}
                                {/if}

                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.vId}" class="btn btn-sm btn-outline gap-4 btn-primary">جزییات درخواست</a>
                                <button class="btn btn-sm btn-outline btn-danger deleteIranVisa"
                                        data-id="{$item.vId}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
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


<script type="text/javascript" src="assets/JsFiles/iranVisa.js"></script>

