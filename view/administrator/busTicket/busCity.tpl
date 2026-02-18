{load_presentation_object filename="busPanel" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="../reservation/continent">تعریف کشور / شهر</a></li>
                <li class="active">لیست شهرهای اتوبوس (وب سرویس)</li>
            </ol>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <div class="form-group col-sm-6">
                    <label for="country_name" class="control-label">جستجو:</label>
                    <input type="text" class="form-control" name="search" value="{$smarty.get.search}"
                           id="search" placeholder="مثال: یزد / تهران / tehran / ...">
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group  pull-right">
                            <button type="submit" class="btn btn-primary" onclick="searchBusCity()">ارسال اطلاعات</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست شهرهای اتوبوس</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شهر (فارسی)</th>
                            <th>شهر (انگلیسی)</th>
                            <th>کد یاتا</th>
                            <th>کد یاتا زیرمجموعه</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="list" value=$objResult->getCities($smarty.get.page, $smarty.get.search)}
                        {foreach key=key item=item from=$list}
                            {$number=$number+1}
                            <tr id="{$item.id}" type="{$item.type}" city="{$item.City}">

                                <td>{$number}</td>

                                <td>{$item.City}</td>

                                <td><input type="text" class="updateInput"
                                           name="City_En" id="City_En" value="{$item.City_En}"></td>

                                <td><input type="text" class="updateInput"
                                           name="City_IataCode" id="City_IataCode" value="{$item.City_IataCode}"></td>

                                <td><input type="text" class="updateInput"
                                           name="City_Safar724_Id" id="City_Safar724_Id" value="{$item.Departure_City_Safar724_Id}"></td>

                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/busPanel.js"></script>