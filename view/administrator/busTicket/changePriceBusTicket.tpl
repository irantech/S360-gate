{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="busTicketPriceChanges" assign="objPrice"}
{load_presentation_object filename="resultBusTicket" assign="objResult"}


{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}
{assign var="counterTypeListByID" value=$objCounterType->counterTypeListByID()} {*گرفتن لیست انواع کانتر*}




<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تغییرات قیمت بلیط اتوبوس</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">فرم تغییرات قیمت </h3>
                <br>
                <form id="formChangePriceBusTicket" method="post" action="{$smarty.const.rootAddress}bus_ajax">
                    <input type="hidden" name="flag" value="insertBusTicketPriceChanges">

                    <div class="form-group col-sm-6 ">
                        <label for="start_date" class="control-label">تاریخ شروع رزرو</label>
                        <input type="text" class="form-control datepicker" name="start_date"
                               id="start_date" placeholder="تاریخ شروع رزرو  را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="end_date" class="control-label">تاریخ پایان رزرو</label>
                        <input type="text" class="form-control datepicker" name="end_date" id="end_date"
                               placeholder="تاریخ پایان رزرو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="origin_city" class="control-label">نام شهر مبدا</label>
                        <select name="origin_city" id="origin_city"
                                class="form-control select2" onchange="selectDest()">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه شهرها</option>
                            {foreach $objResult->getOriginCities() as $city}
                                <option value="{$city.OriginIataCode}">{$city.OriginCityNamePersian}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="destination_city" class="control-label">نام شهر مقصد</label>
                        <select name="destination_city" id="destination_city" class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه شهرها</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="company_bus" class="control-label">شرکت مسافربری</label>
                        <select name="company_bus" id="company_bus"
                                class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه</option>
                            {foreach $objPrice->listBaseCompanyBus('bus') as $city}
                                <option value="{$city.id}">{$city.name_fa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="change_type" class="control-label">نوع </label>
                        <select name="change_type" id="change_type" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            <option value="increase">افزایش</option>
                            <option value="decrease">کاهش</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <p class="color-red">برای اعمال تغییرات، ابتدا نوع افزایش قیمت (ریال یا %) را انتخاب نموده، سپس مقدار را تغییر دهید</p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    {foreach key=key item=item from=$objCounterType->list}
                                        <th class="text-center">{$item.name}</th>
                                    {/foreach}
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    {foreach key=keyCounter item=itemCounter from=$objCounterType->list}
                                        <td>
                                            <div class="input-group">
                                                <input type="hidden" value="{$itemCounter.id}" id="counter_id{$keyCounter}" name="counter_id{$keyCounter}"/>
                                                <input type="text" value="0" id="price{$keyCounter}" name="price{$keyCounter}"
                                                       class="form-control text-right changePrice"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="{$itemCounter.name}"/>
                                                <span class="input-group-addon">
                                                    <select class="changeType" id="price_type{$keyCounter}" name="price_type{$keyCounter}">
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
                    <input type="hidden" name="countCounter" id="countCounter" value="{$keyCounter}">

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
                <h3 class="box-title m-b-0">لیست تغییرات قیمت بلیط اتوبوس</h3><br/>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ</th>
                            <th>نام شهر مبدا</th>
                            <th>نام شهر مقصد</th>
                            <th>شرکت مسافربری</th>
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
                        {foreach key=key item=item from=$objPrice->listBusTicketPriceChanges()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td id="borderPrice-{$item.id}" {if $item.is_del eq 'yes'} class="border-right-change-price" {/if}>{$number}</td>
                                <td>
                                    {$item.creation_date}
                                </td>
                                <td>
                                    {if $item.origin_city eq 'all'}همه
                                    {else}
                                        {$objPrice->getNameCity($item.origin_city)}
                                    {/if}
                                </td>
                                <td>
                                    {if $item.destination_city eq 'all'}همه
                                    {else}
                                        {$objPrice->getNameCity($item.destination_city)}
                                    {/if}
                                </td>
                                <td>
                                    {if $item.company_bus eq 'all'}همه
                                    {else}
                                        {$objPrice->getNameBaseCompany($item.company_bus)}
                                    {/if}
                                </td>
                                <td>
                                    {if $item.counter_id eq '0'}همه
                                    {else}
                                        {$counterTypeListByID[$item.counter_id]}
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
                                           onclick="deleteBusTicketPriceChanges('{$item.id}'); return false"
                                           class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات"
                                           data-placement="right"
                                           data-content="برای حذف بازه زمانی کلیک کنید"> <i
                                                    class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i></a>
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
        <span> ویدیو آموزشی بخش تغییرات قیمت بلیط اتوبوس   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/359/---.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/busTicketPriceChanges.js"></script>
{/if}