{load_presentation_object filename="visaRequestStatus" assign="objResult"}
{assign var="allVisaRequests" value=$objResult->getAll()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت وضعیت های پردازش ویزا</li>
                <li class="active">انواع وضعیت</li>
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
                <h3 class="box-title m-b-0">لیست وضعیت های پردازش ویزا</h3>
                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید انواع وضعیت های پردازش ویزا را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="visaRequestStatusAdd" method="post">
                    <input type="hidden" name="flag" value="visaRequestStatusAdd">
                    {*<input type="hidden" name="className" value="visaRequestStatus">*}
                    <input type="hidden" name="method" value="addNew">

                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="عنوان را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="description" class="control-label">توضیحات وضعیت ویزا</label>
                        <textarea class="form-control" id="description" name="description" placeholder="توضیحات وضعیت ویزا"></textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="notification_content" class="control-label">متن پیامک ارسالی به کاربر</label>
                        <textarea type="text" class="form-control" id="notification_content" name="notification_content" placeholder="متن پیامک ارسالی به کاربر - این متن در هنگام تغییر وضعیت قابل تغییر است"></textarea>
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
                <h3 class="box-title m-b-0">لیست انواع وضعیت های پردازش ویزا</h3>
                <p class="text-muted m-b-30">در لیست زیر انواع وضعیت های پردازش ویزا را میتوانید مشاهده و ویرایش نمایید</p>
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
                            {foreach $allVisaRequests as $item}
                                {$number = $number + 1}
                                <tr>
                                    <td>{$number}</td>
                                    <td>{$item.title}</td>
                                    <td>
                                        <a href="visaRequestStatusEdit&id={$item.id}"><i
                                                class="fcbtn btn btn-outline btn-primary btn-1f  tooltip-primary ti-pencil-alt "
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title=" ویرایش نوع ویزا "></i></a>
                                    </td>
                                    <td>
                                        <a data-id="{$item.id}" class="delete_request_status popoverBox popover-danger" data-toggle="popover" title=""
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