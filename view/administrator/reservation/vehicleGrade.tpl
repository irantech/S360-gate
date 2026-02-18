{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">درجه وسیله نقلیه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormVehicleGrade" method="post" action="{$smarty.const.ROOTADDRESS}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_vehicle_grade">

                    <div class="form-group col-sm-6">
                        <label for="vehicle_grade" class="control-label">درجه وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_grade" value=""
                               id="vehicle_grade" placeholder="نام وسیله را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="vehicle_grade_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="vehicle_grade_abbreviation" value=""
                               id="vehicle_grade_abbreviation" placeholder="نام وسیله را وارد نمائید">
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
                <h3 class="box-title m-b-0">درجه وسیله نقلیه</h3>
                <p class="text-muted m-b-30">تمامی درجه های وسایل نقلیه وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>درجه وسیله</th>
                            <th>نام اختصار</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_vehicle_grade_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>{$item.abbreviation}</td>

                            <td>
                                <a href="vehicleGradeEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش درجه وسیله نقلیه">

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
        <span> ویدیو آموزشی بخش درج وسیله نقلیه   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/385/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>