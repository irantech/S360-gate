{load_presentation_object filename="discountCodes" assign="ObjCode"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">لیست کدهای تخفیف</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">کد تخفیف</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید کد تخفیف هایی که تا کنون صادر کرده اید را مشاهده نمائید
                    <span class="pull-right">
                         <a href="discountCodesAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن کد تخفیف جدید
                        </a>
                    </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>کد تخفیف</th>
                            <th>مبلغ</th>
                            <th>تعداد کل</th>
                            <th>تعداد استفاده شده</th>
                            <th>تعداد مانده</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjCode->ListAll()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.title}</td>
                                <td class="align-middle">
                                    {if $item.isGroup eq 'yes'}
                                        <a href="discountGroupCodes&id={$item.groupCode}" class=""><i
                                                    class="fcbtn btn btn-outline btn-warning btn-1e fa fa-ticket tooltip-warning"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="مشاهده کدهای تولید شده"></i></a>
                                    {else}
                                        {$item.code}
                                    {/if}
                                </td>
                                <td class="align-middle">{$item.amount|number_format}</td>
                                <td class="align-middle">
                                    {assign var="remainStock" value="0"}
                                    {if $item.isGroup eq 'yes'}
                                        {$item.groupStock|number_format}
                                        {$remainStock = $item.groupStock - $item.used}
                                    {else}
                                        {$item.stock|number_format}
                                        {$remainStock = $item.stock - $item.used}
                                    {/if}
                                </td>
                                <td class="align-middle">{$item.used|number_format}</td>
                                <td class="align-middle">{$remainStock|number_format}</td>
                                <td class="align-middle">
                                    <a href="#" onclick="activate('{$item.id}'); return false;">
                                        {if $item.isActive eq 'yes'}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked="checked" />

                                        {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a href="discountCodesEdit&id={$item.groupCode}" class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش"></i></a>

                                    <a href="discountCodesUsed&id={$item.groupCode}" class=""><i
                                            class="fcbtn btn btn-outline btn-info btn-1e fa fa-user tooltip-info"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="استفاده کنندگان"></i></a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش کد تخفیف</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/398/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/discountCodes.js"></script>