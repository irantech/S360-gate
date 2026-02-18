
{load_presentation_object filename="reservationHotel" assign="objService"}
{assign var="info_select_hotel" value=$objService->getSelectSrvice('Hotel')}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li class="active">انتخاب شهر منتخب </li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                    توجه:
                </p>
                <p class="text-muted m-b-10 textTicketAttention">کاربر گرامی</p>
                <p class="text-muted m-b-10 textTicketAttention">در صورت انتخاب شهر برای هتل در سرچ باکس جستجوی هتل تنها شهر منتخب نمایش داده خواهد شد و امکان جستجوی شهرهای مختلف را نخواهید داشت!!</p>
                    <br>

                <form data-toggle="validator" id="SelectCityForSearch" method="post"  enctype="multipart/form-data">
                    <input type='hidden' value='updateSelectCity' id='method' name='method'>
                    <input type='hidden' value='reservationHotel' id='className' name='className'>

                    <div class="form-group col-sm-6">
                        <label for="origin_city" class="control-label">شهر منتخب</label>
                        <select name="origin_city" id="origin_city" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objService->ListCityAll() as $key => $city}
                                <option value="{$city['id']}" {if $info_select_hotel['city_id'] eq $city['id'] }selected{/if}>
                                    {$city['city_name']}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="service_name" class="control-label">انتخاب خدمات</label>
                        <select name="service_name" id="service_name" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="Hotel" {if $info_select_hotel['service'] eq 'Hotel' }selected{/if}>هتل</option>
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


<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>