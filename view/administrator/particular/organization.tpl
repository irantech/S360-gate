{load_presentation_object filename="organizationLevel" assign="ObjOrganization"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">لیست سطوح سازمانی</li>
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
                <h3 class="box-title m-b-0">سطح سازمانی جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سطوح سازمانی که در کد تخفیف مورد استفاده قرار می گیرد را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="organizationAdd" method="post">
                    <input type="hidden" name="flag" value="organizationAdd">
                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">سطح سازمانی</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="سطح سازمانی را وارد نمائید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">سطوح سازمانی</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjOrganization->ListAll()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.title}</td>
                                <td class="align-middle">
                                    <a href="organizationEdit&id={$item.id}" class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش"></i></a>

                                    {if $item.usedCount eq 0}
                                        <a id="Del-{$item.id}" href="#" onclick="deleteRecord({$item.id}); return false">
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash tooltip-danger"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="حذف"></i>
                                        </a>
                                    {else}
                                        <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-trash tooltip-default"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="این سطح سازمانی در کد تخفیفی استفاده شده و امکان حذف آن وجود ندارد"></i>
                                    {/if}
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
        <span> ویدیو آموزشی بخش سطح سازمانی</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/397/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/organizationLevel.js"></script>