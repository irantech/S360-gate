{load_presentation_object filename="reservationPublicFunctions" assign="objResult"}
{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="flyNumber">شماره پرواز</a></li>
                <li class="active">افزودن شماره پرواز جدید</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="FormFlyNumber" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_flyNumber">

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور مبدا</label>
                        <select name="origin_country" id="origin_country" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->ListCountry() as $country}
                            <option value="{$country['id']}">{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر مبدا</label>
                        <select name="origin_city" id="origin_city" class="form-control ">

                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_region" class="control-label">منطقه مبدا</label>
                        <select name="origin_region" id="origin_region" class="form-control ">
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="destination_country" class="control-label">کشور مقصد</label>
                        <select name="destination_country" id="destination_country" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->ListCountry() as $country}
                            <option value="{$country['id']}">{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="destination_city" class="control-label">شهر مقصد</label>
                        <select name="destination_city" id="destination_city" class="form-control ">
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="destination_region" class="control-label">منطقه مقصد</label>
                        <select name="destination_region" id="destination_region" class="form-control ">
                        </select>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label for="select_type_flight" class="control-label">نوع پرواز </label>
                        <select name="select_type_flight" id="select_type_flight" class="form-control"  onchange="selectTypFlight(this)">
                            <option value="">انتخاب کنید....</option>
                            <option value="internal" selected="selected">داخلی</option>
                            <option value="international">خارجی</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 internal_airport" >
                        <label for="origin_airport_name" class="control-label">نام فرودگاه مبدا (محل حرکت)</label>
                        <select name="origin_airport_name" id="origin_airport_name" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->ListOriginAirport() as $route}
                            <option value="{$route['Departure_Code']}">{$route['Departure_City']} ({$route['Departure_Code']})</option>
                            {/foreach}
                        </select>
                    </div>


{*                    <div class="form-group col-sm-6 international_airport"  style="display:none;">*}
{*                        <label for="origin_airport_name" class="control-label">نام فرودگاه مبدا (محل حرکت)</label>*}
{*                        <select name="origin_airport_name" id="origin_airport_name" class="form-control select2">*}
{*                            <option value="">انتخاب کنید....</option>*}
{*                            {foreach $objResult->ListOriginAirport('international') as $route}*}
{*                                <option value="{$route['DepartureCode']}">{$route['DepartureCityFa']} - {$route['AirportFa']}({$route['DepartureCode']})</option>*}
{*                            {/foreach}*}
{*                        </select>*}
{*                    </div>*}
                    <div class="form-group col-sm-6 internal_airport">
                        <label for="destination_airport_name" class="control-label">نام فرودگاه مقصد (محل حرکت)</label>
                        <select name="destination_airport_name" id="destination_airport_name" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->ListOriginAirport() as $route}
                                <option value="{$route['Departure_Code']}">{$route['Departure_City']} ({$route['Departure_Code']})</option>
                            {/foreach}
                        </select>
                    </div>

{*                    <div class="form-group col-sm-6 international_airport"  style="display:none;">*}
{*                        <label for="destination_airport_name" class="control-label">نام فرودگاه مقصد (محل حرکت)</label>*}
{*                        <select name="destination_airport_name" id="destination_airport_name" class="form-control select2">*}
{*                            <option value="">انتخاب کنید....</option>*}
{*                            {foreach $objResult->ListOriginAirport('international') as $route}*}
{*                                <option value="{$route['DepartureCode']}">{$route['DepartureCityFa']} - {$route['AirportFa']}({$route['DepartureCode']})</option>*}
{*                            {/foreach}*}
{*                        </select>*}
{*                    </div>*}

                    <div class="form-group col-sm-6">
                        <label for="fly_code" class="control-label">شماره</label>
                        <input type="text" class="form-control" name="fly_code" value=""
                               id="fly_code" placeholder=" شماره را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="type_of_plane" class="control-label">نوع هواپیما</label>
                        <input type="text" class="form-control" name="type_of_plane" value=""
                               id="type_of_plane" placeholder=" نوع هواپیما را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="type_of_vehicle" class="control-label">نوع وسیله نقلیه</label>
                        <select name="type_of_vehicle" id="type_of_vehicle" class="form-control" onChange="listAirline()">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                            <option value="{$typeVehicle['id']}">{$typeVehicle['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="airline" class="control-label">شرکت حمل و نقل</label>
                        <select name="airline" id="airline" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {*foreach $objResult->ListAirline() as $airline}
                            <option value="{$airline['id']}">{$airline['name_fa']}</option>
                            {/foreach*}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="vehicle_grade_id" class="control-label">درجه</label>
                        <select name="vehicle_grade_id" id="vehicle_grade_id" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade}
                            <option value="{$vehicleGrade['id']}">{$vehicleGrade['name']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="free" class="control-label">میزان بار رایگان</label>
                        <input type="text" class="form-control" name="free" value=""
                               id="free" placeholder=" وزن بار را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="total_capacity" class="control-label">ظرفیت کل</label>
                        <input type="text" class="form-control" name="total_capacity" value=""
                               id="total_capacity" placeholder="ظرفیت کل را وارد کنید" onkeypress="isDigit(this)">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="day_onrequest" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="day_onrequest" value=""
                               id="day_onrequest" placeholder="زمان توقف فروش را وارد کنید" onkeypress="isDigit(this)">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="departure_minutes" class="control-label">ساعت حرکت پرواز (دقیقه)</label>
                        <select name="departure_minutes" id="departure_minutes" class="form-control ">
                            {for $n=0 to 9}
                            <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 60}
                            <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="departure_hours" class="control-label">ساعت حرکت پرواز (ساعت)</label>
                        <select name="departure_hours" id="departure_hours" class="form-control ">
                            {for $n=0 to 9}
                            <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 24}
                            <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="minutes" class="control-label">مدت زمان مسیر (دقیقه)</label>
                        <select name="minutes" id="minutes" class="form-control ">
                            {for $n=0 to 9}
                            <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 60}
                            <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="hours" class="control-label">مدت زمان مسیر (ساعت)</label>
                        <select name="hours" id="hours" class="form-control ">
                            {for $n=0 to 9}
                            <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 24}
                            <option value="{$n}">{$n}</option>
                            {/for}
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

</div>

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/flyNumberAdd.js"></script>