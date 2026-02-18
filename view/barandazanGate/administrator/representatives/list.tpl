{load_presentation_object filename="representatives" assign="obJRepresentatives"}
{assign var="list_order" value=$obJRepresentatives->listRepresentatives()}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}
{*{$list_order|var_dump}*}

{assign var="languages" value=['fa'=>'فارسی','en'=>'English','ar'=>'العربیه']}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/representatives/list">لیست نمایندگی ها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="white-box">
                <a class="btn btn-primary rounded"
                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/representatives/insert">
                    <i class="fa fa-plus"></i>
                    افزودن
                </a>

                <h3 class="box-title m-b-0">لیست نمایندگی ها</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست نمایندگی ها را مشاهده نمائید</p>
                <div class="table-responsive">
                    <form data-toggle="validator" id="form_data" method="post"  enctype="multipart/form-data">
                        <input type="hidden" name="className" value="representatives">
                        <input type="hidden" name="method" value="change_form">

                        <table id="myTable" class="table table-striped ">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام شرکت</th>
                                <th>زبان</th>
                                <th>کشور</th>
                                <th>استان</th>
                                <th>نام مدیر</th>
                                <th>شماره همراه</th>
                                <th>کد پیگیری</th>
                                <th>ترتیب</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {assign var="sum" value="0"}
                            {if $list_order != ''}
                            {foreach key=key item=item from=$list_order}
                            {$number=$number+1}
                            <tr id="del-{$item.oId}">
                                <td class="align-middle"><span class="badge badge-info">{$number}</span></td>

                                <td class="align-middle">{$item.company_name}</td>
                                <td class="align-middle">{$languages[$item.language]}</td>
                                {assign var="country" value=$obJRepresentatives->RepresentativesCountries($item.country )}
                                <td class="align-middle">{$country[0]['name']}</td>
                                {assign var="province" value=$obJRepresentatives->RepresentativesCity($item.province)}
                                <td class="align-middle">{$province[0]['name']}</td>
                                <td class="align-middle">{$item.manager_name}</td>
                                <td class="align-middle">{if $item.mobile_number}{$item.mobile_number}{else}---{/if}</td>

                                <td class="align-middle">{$item.tracking_code}</td>
                                <td class="align-middle"  style="text-align:center;">
                                    <input type="number"  size="10" name="order[{$item.oId}]" id="order" value="{$item.order_p}" class="list-order">
                                </td>
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
                                    <a href="edit&id={$item.oId}" class="btn btn-sm btn-outline gap-4 btn-primary">جزییات نمایندگی</a>
                                    <button class="btn btn-sm btn-outline btn-danger deleteRepresentatives"
                                            data-id="{$item.oId}">
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
                            </div>
                            </td>
                            </tr>
                            {/foreach}
                            {/if}
                            </tbody>
                        </table>
                <input   class="btn btn-info" type="button" onclick='change_order_new()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />

            </form>

            </div>
        </div>
    </div>

</div>
</div>


<script type="text/javascript" src="assets/JsFiles/representatives.js"></script>

