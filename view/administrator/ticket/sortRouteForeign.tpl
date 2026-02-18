{load_presentation_object filename="routeFlight" assign="ObjRoute"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $smarty.get.id neq ''}
                    <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                {/if}
                <li class="active">لیست مسیر ها</li>
                {if $smarty.get.id neq ''}
                    <li>{$objFunctions->ClientName($smarty.get.id)}</li>
                {/if}
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

                <h3 class="box-title m-b-0">افزودن فرودگاه، شهر یا کشور </h3>
                <p class="text-muted m-b-30">نام فرودگاه، شهر یا کشور  مد نظر را در کادر زیر جستجو کرده و بعد از انتخاب دکمه ثبت را بزنید</p>

                    <input type="hidden" name="flag" value="addAirportForeign">
                    <div class="form-group col-md-9">
                        <label for="amount" class="control-label">نام فرودگاه یا شهر ،کشور
                            </label>
                        <input type="text" class="form-control" id="cityCodeForeign" name="cityCodeForeign"
                               placeholder="حداقل سه حرف از نام فرودگاه شهر یا کشور مورد نظر را وارد نمائید" onkeyup="searchAirportForeign(this)">

                        <input id="IataCodeForeign" class="" type="hidden" value="{$Departure['DepartureCode']}"
                               name="IataCodeForeign">
                        <ul id="ListAirPort" class="listAirportSearchForeignAdmin" style="display: none">
                        </ul>
                    </div>


                <div class="form-group col-md-3">
                    <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                         id="loadingbank">
                <button type="button" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="chooseAirPort" name="chooseAirPort" onclick="chooseAirPort()">انتخاب</button>
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست روت های پروازی</h3>
                <p class="text-muted m-b-30">در لیست زیر شما میتوانید شهرهای انتخابی خود را مشاهده نمایید
                    <br>( <small class="text-danger">شما فقط 12 شهر یا فرودگاه رو میتوانید برای نمایش انتخاب کنید</small>)
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 120px">ردیف</th>
                            <th style="width: 120px">نام شهر(فرودگاه)</th>
                            <th style="width: 120px">کشور</th>
                            <th style="width: 120px">عملیات </th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$ObjRoute->ListOrderCityForeign()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="text-align-center">{$number}</td>
                                <td class="text-align-center">
                                    {$item.DepartureCityFa}-{$item.AirportFa}({$item.DepartureCode})
                                </td>
                                <td class="text-align-center">
                                    {$item.CountryFa}
                                </td>
                                <td class="text-align-center"><a class="btn btn-outline btn-danger" onclick="deleteSortRouteFlightForeign('{$item.id}')" ><i class="fa fa-trash"></i> حذف</a></td>
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
        <span> ویدیو آموزشی بخش تعیین مسیر پر تردد خارجی </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/395/-----.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/routeFlight.js"></script>