{load_presentation_object filename="interactiveOffCodes" assign="objCode"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">لیست کدهای ترانسفر</li>
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
                         <a href="interactiveOffCodesAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن کد تخفیف جدید
                        </a>
                    </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>اولویت</th>
                            <th>عنوان</th>
                            <th>تاریخ انقضا</th>
                            <th>تعداد کل</th>
                            <th>تعداد استفاده شده</th>
                            <th>تعداد مانده</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCode->listAllGroup()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$item.priority}</td>
                                <td class="align-middle">{$item.title}</td>
                                <td class="align-middle">{$objDate->jdate('Y-m-d', $item.expireDateInt)}</td>
                                <td class="align-middle">{$item.codesCount|number_format}</td>
                                <td class="align-middle">{$item.usedCount|number_format}</td>
                                <td class="align-middle">{($item.codesCount - $item.usedCount)|number_format}</td>
                                <td class="align-middle">
                                    <a href="interactiveOffCodesEdit&id={$item.id}" class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش"></i></a>

                                    <a href="interactiveOff&id={$item.id}" class=""><i
                                            class="fcbtn btn btn-outline btn-info btn-1e fa fa-list tooltip-info"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="لیست کدها"></i></a>

                                    {*<a href="discountCodesUsed&id={$item.id}" class=""><i
                                            class="fcbtn btn btn-outline btn-info btn-1e fa fa-user tooltip-info"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="استفاده کنندگان"></i></a>*}
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

<script type="text/javascript" src="assets/JsFiles/interactiveOffCodes.js"></script>