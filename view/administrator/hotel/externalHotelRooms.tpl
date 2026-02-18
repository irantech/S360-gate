{load_presentation_object filename="externalHotel" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="../reservation/continent">تعریف کشور / شهر</a></li>
                <li><a href="continent">لیست شهرهای هتل خارجی (وب سرویس)</a></li>
                <li class="active">لیست اتاقهای هتل خارجی  (وب سرویس)</li>
            </ol>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <div class="form-group col-sm-6">
                    <label for="country_name" class="control-label">جستجو:</label>
                    <input type="text" class="form-control" name="search" value="{$smarty.get.search}"
                           id="search" placeholder="مثال: Business Class / 1 KING BED SUPERIOR / ...">
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group  pull-right">
                            <button type="submit" class="btn btn-primary" onclick="searchExternalHotelRoom()">ارسال اطلاعات</button>
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

                <h3 class="box-title m-b-0">لیست اتاقهای هتل خارجی  (وب سرویس)</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام اتاق (انگلیسی)</th>
                            <th>نام اتاق (فارسی)</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="list" value=$objResult->getRooms($smarty.get.page, $smarty.get.search)}
                        {foreach key=key item=item from=$list}
                            {$number=$number+1}
                            <tr room_name="{$item.room_name}">

                                <td>{$number}</td>

                                <td>{$item.room_name}</td>

                                <td><input type="text" class="updateInputRoomName"
                                           name="room_persian_name" id="room_persian_name" value="{$item.room_persian_name}"></td>
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