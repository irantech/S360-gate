{load_presentation_object filename="reservationBasicInformation" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="typeOfVehicle">نوع وسیله نقلیه</a></li>
                <li class="active">مدل وسیله نقلیه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormVehicleModel" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_vehicle_model">
                    <input type="hidden" name="id_type_of_vehicle" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="vehicle_model" class="control-label">مدل وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_model" value=""
                               id="vehicle_model" placeholder=" نام مدل وسیله نقلیه را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="vehicle_abbreviation" class="control-label">مدل وسیله نقلیه به اختصار</label>
                        <input type="text" class="form-control" name="vehicle_abbreviation" value=""
                               id="vehicle_abbreviation" placeholder="نام اختصار را وارد نمائید">
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
                <h3 class="box-title m-b-0">مدل وسیله نقلیه</h3>
                <p class="text-muted m-b-30">تمامی مدل های وسیله نقلیه ... وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام مدل وسیله</th>
                            <th>نام اختصار</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_vehicle_model_tb', 'id_type_of_vehicle', {$smarty.get.id})}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>{$item.abbreviation}</td>

                            <td>
                                <a href="vehicleModelEdit&id={$item.id}&idModel={$smarty.get.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش مدل وسیله نقلیه">

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

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>