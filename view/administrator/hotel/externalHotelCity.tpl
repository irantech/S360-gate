{load_presentation_object filename="externalHotel" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="../reservation/continent">تعریف کشور / شهر</a></li>
                <li class="active">لیست شهرهای هتل خارجی (وب سرویس)</li>
            </ol>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <div class="form-group col-sm-6">
                    <label for="country_name" class="control-label">جستجو:</label>
                    <input type="text" class="form-control" name="search" value="{$smarty.get.search}"
                           id="search" placeholder="مثال: دبی / ایتالیا / dubai / ...">
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group  pull-right">
                            <button type="submit" class="btn btn-primary" onclick="searchExternalHotelCity()">ارسال اطلاعات</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">

                <div class="box-btn-excel">
                    <a href="externalHotelRooms&page=1" class="btn btn-primary waves-effect waves-light" type="button">
                        <span class="btn-label"><i class="fa fa-check"></i></span>                                    لیست اتاقهای هتل خارجی (وب سرویس)
                    </a>
                    <a href="externalHotelFacilities&page=1" class="btn btn-success waves-effect waves-light" type="button">
                        <span class="btn-label"><i class="fa fa-check"></i></span>                                    لیست امکانات هتل خارجی (وب سرویس)
                    </a>
                </div>

                <h3 class="box-title m-b-0">لیست شهرهای هتل خارجی</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد یاتا</th>
                            <th>کشور (انگلیسی)</th>
                            <th>کشور (فارسی)</th>
                            <th>شهر (انگلیسی)</th>
                            <th>شهر (فارسی)</th>
                            <th>فرودگاه (انگلیسی)</th>
                            <th>فرودگاه (فارسی)</th>
                            <th>cronjob</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="list" value=$objResult->getCities($smarty.get.page, $smarty.get.search)}
                        {foreach key=key item=item from=$list}
                            {$number=$number+1}
                            <tr id="{$item.id}">

                                <td>{$number}</td>

                                <td><input type="text" class="updateInput"
                                           name="iata_code" id="iata_code" value="{$item.iata_code}"></td>

                                <td>{$item.country_name_en}</td>

                                <td><input type="text" class="updateInput"
                                           name="country_name_fa" id="country_name_fa" value="{$item.country_name_fa}"></td>

                                <td>{$item.city_name_en}</td>

                                <td><input type="text" class="updateInput"
                                           name="city_name_fa" id="city_name_fa" value="{$item.city_name_fa}"></td>

                                <td><input type="text" class="updateInput"
                                           name="airport_en" id="airport_en" value="{$item.airport_en}"></td>

                                <td><input type="text" class="updateInput"
                                           name="airport_fa" id="airport_fa" value="{$item.airport_fa}"></td>

                                {assign var="country" value=$item.country_name_en|replace:' ':'-'}
                                {assign var="city" value=$item.city_name_en|replace:' ':'-'}
                                <td>
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/library/ApiSource/CronJobsForExternalHotel.php?country={$country}&city={$city}&cash=images"
                                       target="_blank">اجرا برای ثبت عکس شاخص هتل </a>
                                    <hr/>
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/library/ApiSource/CronJobsForExternalHotel.php?country={$country}&city={$city}&cash=hotelInfo"
                                       target="_blank">اجرا برای ثبت اتاق ها و امکانات هتل </a>
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="white-box">
                {assign var="CountPages" value=$list[0]['countCities'] / 100}
                {for $c=1 to $CountPages}
                    <a href="externalHotelCity&page={$c}&search={$smarty.get.search}"
                       class="page-number-external-hotel-city {if $c eq $smarty.get.page}page-number-external-hotel-city-active{/if}">{$c}</a>
                {/for}
            </div>


        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/externalHotel.js"></script>