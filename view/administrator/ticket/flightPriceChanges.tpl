{load_presentation_object filename="priceChanges" assign="objPriceChanges"}
{load_presentation_object filename="airline" assign="objAirline"}
{load_presentation_object filename="counterType" assign="objCounterType"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li><a href="priceChanges">تغییرات قیمت بلیط</a></li>
                <li class="active"> تغییرات قیمت پرواز</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box row">
                <h3 class="box-title m-b-0"> تغییرات قیمت پرواز</h3>

                <p class="text-muted m-b-30">
                    <span class="blink_me">
                        توجه
                        <br/>
                        افزایش قیمت روی پرواز هایی که داری کمیسیون هستند اعمال نمی گردد
                    </span>
                        <br/>
                        در فرم زیر میتوانید  تغییرات قیمت هر ایرلاین با همه ایرلاین ها به صورت یکجا  را اعمال کنید


                </p>

                <div class="form-group col-md-2 ">
                    <label for="airline_iata" class="control-label">نام ایرلاین</label>
                        <select name='airline_iata' id='airline_iata' class='select2 form-control'>
                            <option value=''>انتخاب کنید</option>
                            <option value='all'>همه</option>
                            {foreach $objAirline->airLineList() as $airline_iata}
                                <option value='{$airline_iata['abbreviation']}'>{$airline_iata['name_fa']}({$airline_iata['abbreviation']})</option>
                            {/foreach}
                        </select>
                </div>

                <div class="form-group col-md-2 ">
                    <label for="counter_type" class="control-label">نوع کانتر</label>
                    <select name='counter_type' id='counter_type' class='select2 form-control'>
                        <option value=''>انتخاب کنید</option>
                        <option value='all'>همه</option>
                        {foreach $objCounterType->listCounterType() as $counter_type}
                            <option value='{$counter_type['id']}'>{$counter_type['name']}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group col-md-2 ">
                    <label for="locality" class="control-label">نوع جستجو</label>
                    <select name='locality'  id="locality" class='select2 form-control'>
                        <option value=''>انتخاب کنید</option>
                        <option value='local'>داخلی</option>
                        <option value='international'>خارجی</option>
                    </select>
                </div>
                <div class="form-group col-md-2 ">
                    <label for="flight_type" class="control-label">نوع پرواز</label>
                    <select name='flight_type' id='flight_type' class='select2 form-control'>
                        <option value=''>انتخاب کنید</option>
                        <option value='charter'>چارتری</option>
                        <option value='system'>سیستمی</option>
                    </select>
                </div>
                <div class="form-group col-md-2 ">
                    <label for="change_type" class="control-label">نوع افزایش</label>
                    <select name='change_type' id='change_type' class='select2 form-control'>
                        <option value=''>انتخاب کنید</option>
                        <option value='cost'>ریالی</option>
                        <option value='percent'>درصد</option>
                    </select>
                </div>


                <div class="form-group col-md-2 ">
                    <label for="price" class="control-label">میزان تغییر</label>
                    <input type='text' class='form-control' name='price' id='price' placeholder='میزان تغییر را وارد نمائید'>
                </div>
                <div class="form-group col-md-2 float-left ">
                    <div class="form-group">

                        <button type="submit" class="btn btn-info form-control ColorAndSizeMenu active" onclick='sendPriceChangeData()'>ارسال اطلاعات</button>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست تغییرات قیمت پرواز</h3>
                     <div class='row'>
                         <div class="form-group col-md-6 col-sm-6 col-xs-12" style="margin-top: 27px;">
                            <a class="btn btn-primary" target='_blank' href="priceChangesHistory" style="margin-left: 5px;" >سوابق افزایش قیمت </a>
                            <a type="button" class="btn btn-danger localResetForm" onclick='restChangePrice()'>ریست</a>
                   </div>
               </div>
                <div class="table-responsive">
                    <table id="flight-price-changes-table" class="table table-striped">
                        <thead></thead>
                        <tbody></tbody>
                        <tfoot><tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="assets/JsFiles/priceChanges.js"></script>