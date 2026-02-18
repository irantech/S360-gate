{load_presentation_object filename="reservationBasicInformation" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">نوع وسیله نقلیه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormTypeOfVehicle" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_type_of_vehicle">

                    <div class="form-group col-sm-6">
                        <label for="vehicle_name" class="control-label">نام وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_name" value=""
                               id="vehicle_name" placeholder="نام وسیله را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="vehicle_type" class="control-label">انتخاب نوع</label>
                        <select name="vehicle_type" id="vehicle_type" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="plane">هواپیما</option>
                            <option value="bus">اتوبوس</option>
                            <option value="train">قطار</option>
                            <option value="ship">کشتی</option>
                            <option value="contactUs">تماس بگیرید</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
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
                <h3 class="box-title m-b-0">نوع وسیله نقلیه</h3>
                <p class="text-muted m-b-30">تمامی وسیله های نقلیه وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام وسیله</th>
                            <th>مدل وسیله نقلیه</th>
                            <th>شرکت های حمل و نقل</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_type_of_vehicle_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>
                                {$item.name}
                            </td>

                            <td>
                                <a href="vehicleModel&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    اضافه کردن مدل وسیله نقلیه
                                </a>
                            </td>

                            <td>
                                <a href="transportCompanies&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    اضافه کردن شرکت های حمل و نقل
                                </a>
                            </td>

                            <td>
                                <a href="typeOfVehicleEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش نام وسیله نقلیه">

                                    </i>
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
        <span> ویدیو آموزشی بخش نوع وسیله نقلیه   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/382/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>