{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
{$objBasic->SelectAllWithCondition('reservation_fly_tb', 'id', $smarty.get.id)}
{load_presentation_object filename="temporaryData" assign="objTemporary"}
{assign var="tempData" value=$objTemporary->getAllByReference($smarty.get.id,'fly_number')}
{assign var="jsonData" value=$tempData.data|@json_decode:true}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="flyNumber">شماره پرواز</a></li>
                <li class="active">ویرایش شماره پرواز</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30"></p>

                <form id="EditFlyNumber" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="EditFlyNumber">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور مبدا</label>
                        <select name="origin_country" id="origin_country" class="form-control ">
                            <option value="{$objBasic->list['origin_country']}">{$objPublic->ShowName('reservation_country_tb',$objBasic->list['origin_country'])}</option>
                            {foreach $objPublic->ListCountry() as $country}
                            <option value="{$country['id']}">{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر مبدا</label>
                        <select name="origin_city" id="origin_city" class="form-control ">
                            <option value="{$objBasic->list['origin_city']}">{$objPublic->ShowName('reservation_city_tb',$objBasic->list['origin_city'])}</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_region" class="control-label">منطقه مبدا / ترمینال</label>
                        <select name="origin_region" id="origin_region" class="form-control ">
                            {if $objBasic->list['origin_region'] neq 0}
                            <option value="{$objBasic->list['origin_region']}">{$objPublic->ShowName('reservation_region_tb',$objBasic->list['origin_region'])}</option>
                            {else}
                            <option value=""></option>
                            {/if}
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="destination_country" class="control-label">کشور مقصد</label>
                        <select name="destination_country" id="destination_country" class="form-control ">
                            <option value="{$objBasic->list['destination_country']}">{$objPublic->ShowName('reservation_country_tb',$objBasic->list['destination_country'])}</option>
                            {foreach $objPublic->ListCountry() as $country}
                            <option value="{$country['id']}">{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="destination_city" class="control-label">شهر مقصد</label>
                        <select name="destination_city" id="destination_city" class="form-control ">
                            <option value="{$objBasic->list['destination_city']}">{$objPublic->ShowName('reservation_city_tb',$objBasic->list['destination_city'])}</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="destination_region" class="control-label">منطقه مقصد / ترمینال</label>
                        <select name="destination_region" id="destination_region" class="form-control ">
                            {if $objBasic->list['destination_region'] neq 0}
                                <option value="{$objBasic->list['destination_region']}">{$objPublic->ShowName('reservation_region_tb',$objBasic->list['destination_region'])}</option>
                            {else}
                                <option value=""></option>
                            {/if}
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="origin_airport_name" class="control-label">نام فرودگاه مبدا (محل حرکت)</label>
                        <select name="origin_airport_name" id="origin_airport_name" class="form-control ">
                            <option value="{$objBasic->list['origin_airport']}">{$objPublic->ShowNameRoute(flight_route_tb,Departure_City,$objBasic->list['origin_airport'])}</option>
                            {foreach $objPublic->ListOriginAirport() as $route}
                            <option value="{$route['Departure_Code']}">{$route['Departure_City']} ({$route['Departure_Code']})</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="destination_airport_name" class="control-label">نام فرودگاه مبدا (محل حرکت)</label>
                        <select name="destination_airport_name" id="destination_airport_name" class="form-control ">
                            <option value="{$objBasic->list['destination_airport']}">{$objPublic->ShowNameRoute(flight_route_tb,Departure_City,$objBasic->list['destination_airport'])}</option>
                            {foreach $objPublic->ListOriginAirport() as $route}
                                <option value="{$route['Departure_Code']}">{$route['Departure_City']} ({$route['Departure_Code']})</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6" >
                        <label for="select_type_flight" class="control-label">نوع پرواز </label>
                        <select name="select_type_flight" id="select_type_flight" class="form-control"  onchange="selectTypFlight(this)">
                            <option value="">انتخاب کنید....</option>
                            <option value="internal" {if $objBasic->list['flight_type'] eq 'internal' || !$objBasic->list['flight_type']}selected="selected"{/if}>داخلی</option>
                            <option value="international" {if $objBasic->list['flight_type'] eq 'international'}selected="selected"{/if}>خارجی</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="fly_code" class="control-label">شماره</label>
                        <input type="text" class="form-control" name="fly_code" value="{$objBasic->list['fly_code']}"
                               id="fly_code" placeholder=" شماره را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="type_of_vehicle" class="control-label">نوع وسیله نقلیه</label>
                        <select name="type_of_vehicle" id="type_of_vehicle" class="form-control " onChange="listSubcategories()">
                            {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                                <option value="{$typeVehicle['id']}" {if $typeVehicle['id'] eq {$objBasic->list['type_of_vehicle_id']}} selected {/if} >{$typeVehicle['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="type_of_plane" class="control-label">مدل وسیله نقلیه</label>
                        <select name="type_of_plane" id="type_of_plane" class="form-control">
                            <option value="">انتخاب کنید...</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="airline" class="control-label">شرکت حمل و نقل</label>
                        <select name="airline" id="airline" class="form-control ">
                            <option value="">انتخاب کنید...</option>
                        </select>
                    </div>
                    {*<div class="form-group col-sm-6">
                        <label for="vehicle_grade_id" class="control-label">درجه</label>
                        <select name="vehicle_grade_id" id="vehicle_grade_id" class="form-control ">
                            <option value="{$objBasic->list['vehicle_grade_id']}">{$objPublic->ShowName(reservation_vehicle_grade_tb,$objBasic->list['vehicle_grade_id'])}</option>
                            {foreach $objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade}
                            <option value="{$vehicleGrade['id']}">{$vehicleGrade['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="free" class="control-label">میزان بار رایگان</label>
                        <input type="text" class="form-control" name="free" value="{$objBasic->list['free']}"
                               id="free" placeholder=" وزن بار را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="total_capacity" class="control-label">ظرفیت کل</label>
                        <input type="text" class="form-control" name="total_capacity" value="{$jsonData.total_capacity|default:'0'}"
                               id="total_capacity" placeholder="ظرفیت کل را وارد کنید" >
                    </div>
                    *}
                    <input type="hidden" name="vehicle_grade_id" value="">
                    <input type="hidden" name="free" value="0">
                    <input type="hidden" name="total_capacity" value="0">

                    <div class="form-group col-sm-6">
                        <label for="day_onrequest" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="day_onrequest" value="{$jsonData.day_onrequest|default:'0'}"
                               id="day_onrequest" placeholder="زمان توقف فروش را وارد کنید"">
                    </div>

                    {$objPublic->explodeTime($objBasic->list['time'])}
                    <div class="form-group col-sm-3">
                        <label for="departure_minutes" class="control-label">ساعت حرکت پرواز (دقیقه)</label>
                        <select name="departure_minutes" id="departure_minutes" class="form-control">
                            <option value="{$jsonData.departure_minutes|default:'0'}">{$jsonData.departure_minutes|default:'0'}</option>
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
                        <select name="departure_hours" id="departure_hours" class="form-control">
                            <option value="{$jsonData.departure_hours|default:'0'}">{$jsonData.departure_hours|default:'0'}</option>
                            {for $n=0 to 9}
                                <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 24}
                                <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="minutes" class="control-label">ساعت فرود پرواز (دقیقه)</label>
                        <select name="minutes" id="minutes" class="form-control ">
                            <option value="{$objPublic->minutes}">{$objPublic->minutes}</option>
                            {for $n=0 to 9}
                            <option value="0{$n}">0{$n}</option>
                            {/for}
                            {for $n=10 to 60}
                            <option value="{$n}">{$n}</option>
                            {/for}
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="hours" class="control-label">ساعت فرود پرواز (ساعت)</label>
                        <select name="hours" id="hours" class="form-control ">
                            <option value="{$objPublic->hours}">{$objPublic->hours}</option>
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
<script type="text/javascript">
   $(document).ready(function() {
      // Initialize airline / type_of_plane dropdown
      listSubcategories('{$objBasic->list['airline']}','{$objBasic->list['type_of_plane']}');

   });
</script>