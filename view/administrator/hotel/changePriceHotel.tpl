{load_presentation_object filename="PriceHotelChange" assign="objPrice"}
{assign var="all_counter" value=$objPrice->getAllCounterType()} {*گرفتن لیست انواع کانتر*}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تغییرات قیمت هتل داخلی</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">فرم تغییرات قیمت </h3>
                <br>
                <form autocomplete="off" id="FormChangePriceHotel" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_change_price_hotel">
                    <input type="hidden" name="type_application" id="type_application" value="api">

                    <div class="form-group col-sm-6 ">
                        <label for="start_date" class="control-label">تاریخ شروع رزرو</label>
                        <input type="text" class="form-control datepicker" name="start_date"
                               autocomplete="off" aria-autocomplete="none"
                               value="{$smarty.post.start_date}"
                               id="start_date" placeholder="تاریخ شروع رزرو  را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="end_date" class="control-label">تاریخ پایان رزرو</label>
                        <input type="text" class="form-control datepicker" name="end_date"
                               autocomplete="off" aria-autocomplete="none"
                               value="{$smarty.post.end_date}" id="end_date"
                               placeholder="تاریخ پایان رزرو را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="city_code" class="control-label">نام شهر</label>
                        <select name="city_code" id="city_code" class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه شهرها</option>
                            {foreach $objPrice->AllCity()  as $city }
                                <option value="{$city.city_code}"
                                        {if $smarty.post.city_name eq $city.city_name}selected{/if}>{$city.city_name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="hotel_star" class="control-label">ستاره هتل</label>
                        <select name="hotel_star" id="hotel_star" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه</option>
                            <option value="1">*</option>
                            <option value="2">* *</option>
                            <option value="3">* * *</option>
                            <option value="4">* * * *</option>
                            <option value="5">* * * * *</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="change_type" class="control-label">نوع </label>
                        <select name="change_type" id="change_type" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            <option value="increase" {if $smarty.post.abbreviation eq 'increase'}selected{/if}>افزایش</option>
                            {*<option value="decrease" {if $smarty.post.abbreviation eq 'decrease'}selected{/if}>کاهش</option>*}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="all_type_counter" class="control-label">برای همه کانتر ها </label>
                        <select name="all_type_counter" id="all_type_counter" class="form-control" onchange='selectAllCounterForChangeHotel(this)'>
                            <option value="">انتخاب کنید....</option>
                            <option value="yes">بله</option>
                            <option value="no">خیر</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 is-disable-for-all d-none">
                        <label for="price" class="control-label">میزان تغییر</label>
                        <div class="input-group">
                            <input type="text" value="" id="price" name="price" pattern="[0-9.]+"
                                   class="form-control text-right changePrice is-disable-for-all "
                                   data-toggle="tooltip" data-placement="top"
                                   data-original-title="همه کانتر ها" disabled />
                            <span class="input-group-addon">
                                    <select class="changeType is-disable-for-all " disabled id="price_type" name="price_type">
                                        <option value="cost" selected="selected">ریال</option>
                                        <option value="percent">%</option>
                                    </select>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <p class="color-red">برای اعمال تغییرات، ابتدا نوع افزایش قیمت (ریال یا %) را انتخاب نموده، سپس مقدار را تغییر  دهید</p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    {foreach key=key item=item from=$all_counter}
                                        <th class="text-center">{$item.name}</th>
                                    {/foreach}
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    {foreach key=keyCounter item=itemCounter from=$all_counter}
                                        <td>
                                            <div class="input-group">
                                                <input type="hidden" value="{$itemCounter.id}" id="counter_id{$keyCounter}" name="counter_id{$keyCounter}" class='is-enable-for-all'/>
                                                <input type="text" value="0" id="price{$keyCounter}" name="price{$keyCounter}" pattern="[0-9.]+"
                                                       class="form-control text-right changePrice is-enable-for-all"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="{$itemCounter.name}"/>
                                                <span class="input-group-addon">
                                                    <select class="changeType is-enable-for-all" id="price_type{$keyCounter}" name="price_type{$keyCounter}">
                                                        <option value="cost" selected="selected">ریال</option>
                                                        <option value="percent">%</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </td>
                                    {/foreach}
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <input type="hidden" name="countCounter" id="countCounter" value="{$keyCounter}" class="is-enable-for-all">


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
                <h3 class="box-title m-b-0">لیست تغییرات قیمت هتل</h3><br/>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ</th>
                            <th>نام شهر</th>
                            <th>ستاره هتل</th>
                            <th>کانتر</th>
                            <th>تغییر قیمت</th>
                            <th>نوع تغییر قیمت</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objPrice->PriceChangeList('api')}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td id="borderPrice-{$item.id}" {if $item.is_del eq 'yes'} class="border-right-change-price" {/if}>{$number}</td>
                                <td>
                                    {$item.creation_date}
                                </td>
                                <td>
                                    {if $item.city_code eq 'all'}همه
                                    {else}
                                        {$objPrice->CityName($item.city_code)}
                                    {/if}
                                </td>
                                <td>
                                    {if $item.hotel_star eq 'all'}همه
                                    {else}
                                        {$item.hotel_star}
                                    {/if}
                                </td>
                                <td>
                                    {if $item.counter_id eq '0'}همه
                                    {else}

                                        {$all_counter[$item.counter_id]['name']}
                                    {/if}
                                </td>
                                <td>
                                    {$item.price|number_format:0:".":","} {if $item.price_type eq 'percent'} % {else} ریال {/if}
                                </td>
                                <td>
                                    {if $item.change_type eq 'increase'}افزایش{else}کاهش{/if}
                                </td>
                                <td style="direction :ltr">
                                    {$item.start_date}
                                </td>
                                <td style="direction :ltr">
                                    {$item.end_date}
                                </td>

                                <td>
                                    {if $item.is_del eq yes}
                                        <a href="#" onclick="return false"
                                           class="cursor-default  popoverBox  popover-default" data-toggle="popover"
                                           title="حذف تغییرات" data-placement="right"
                                           data-content="شما قبلا این بازه زمانی را حذف نموده اید"> <i
                                                    class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban "></i></a>
                                    {else}
                                        <a id="DelChangePrice-{$item.id}" href="#"
                                           onclick="deleteChangePrice('{$item.id}'); return false"
                                           class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات"
                                           data-placement="right"
                                           data-content="برای حذف بازه زمانی کلیک کنید"> <i
                                                    class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i></a>

                                        <a id="update" href="#"
                                           onclick="setUpdateChangePrice('{$item.id}'); return false"
                                           class="popoverBox  popover-primary" data-toggle="popover" title="ویرایش تغییرات"
                                           data-placement="right"
                                           data-content="برای ویرایش تغییرات کلیک کنید"> <i
                                                    class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit "></i></a>
                                    {/if}
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
        <span> ویدیو آموزشی بخش  تغییر قیمت هتل داخلی   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/358/------.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/PriceHotelChange.js"></script>