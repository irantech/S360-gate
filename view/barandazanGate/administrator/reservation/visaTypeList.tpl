{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypes" value=$objVisaType->allVisaTypeList()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li class="active">انواع ویزا</li>
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
                <h3 class="box-title m-b-0">نوع ویزای جدید</h3>
                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید انواع ویزا را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="visaTypeAdd" method="post">
                    <input type="hidden" name="flag" value="visaTypeAdd">

                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="عنوان را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="documents" class="control-label">مدارک مورد نیاز ویزا ( لطفا مشخص کنید در صورت رزرو این نوع ویزا کاربر چه مدارکی را باید آپلود کند. )</label>
                        <input type="text" class="form-control" id="documents" name="documents"
                               placeholder="مثال: اسکن کارت ملی - اسکن شناسنامه و... ">
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
                <h3 class="box-title m-b-0">لیست انواع ویزا</h3>
                <p class="text-muted m-b-30">در لیست زیر انواع ویزا را میتوانید مشاهده و ویرایش نمایید</p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="number" value="0"}
                            {foreach $visaTypes as $item}
                                {$number = $number + 1}
                                <tr>
                                    <td>{$number}</td>
                                    <td>{$item.title}</td>
                                    <td>
                                        <a href="visaTypeEdit&id={$item.id}"><i
                                                class="fcbtn btn btn-outline btn-primary btn-1f  tooltip-primary ti-pencil-alt "
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title=" ویرایش نوع ویزا "></i></a>
                                    </td>
                                    <td>
                                        <a id="DelChangePrice-2" onclick="logical_deletion('{$item.id}', 'visa_type_tb'); return false"
                                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                                           data-placement="right" data-content="حذف" data-original-title="حذف تغییرات">
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                        </a>
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
        <span> ویدیو آموزشی بخش انواع ویزا   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/391/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>