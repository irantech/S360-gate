{load_presentation_object filename="pointClub" assign="objPointClub"}
{assign var="arrayServices" value=$objPointClub->getAllServices()}



{load_presentation_object filename="counterType" assign="objCounterType"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}
{assign var="counterTypeListByID" value=$objCounterType->counterTypeListByID()}

<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">امتیاز کاربر</li>
            </ol>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تعیین امتیاز خرید</h3>
                <br>
                <form id="formPointClub" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="pointClubRegister">

                    <div class="form-group col-sm-4">
                        <label for="services" class="control-label">سرویس</label>
                        <select name="services" id="services"
                                class="form-control select2" onchange="getBaseCompany()">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه</option>
                            {foreach $arrayServices as $key=>$services}
                                <option value="{$services.ServiceTitleEn}" data-groupServices="{$services.serviceGroup}">{$services.ServiceTitle}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="base_company" class="control-label">شرکت های مسافربری</label>
                        <select name="base_company" id="base_company" class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="company" class="control-label">زیرمجموعه شرکت های مسافربری (ایرلاین/قطار)</label>
                        <input type="text" name="company" id="company" value=""
                               class="form-control"
                               placeholder="لطفا شماره شرکت مسافربری (ایرلاین/قطار) را وارد کنید">
                    </div>

                    <div class="form-group col-sm-12">
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
                                                <input type="text" value="" id="price{$keyCounter}" name="price{$keyCounter}"
                                                       class="form-control text-right"
                                                       placeholder="ضریب امتیاز را وارد نمائید"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="ضریب امتیاز"/>
                                            </div>
                                        </td>
                                    {/foreach}
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="countCounter" id="countCounter" value="{$keyCounter}">

                    <div class="form-group col-sm-1">به ازای هر </div>
                    <div class="form-group col-sm-3 ">
                        <input type="text" class="form-control " name="limitPrice"
                               value="" id="limitPrice"
                               placeholder="مبلغ( به ریال  )را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-3">ریال،معادل 1 امتیاز، که هر امتیاز برابر </div>
                    <div class="form-group col-sm-1">
                        <input type="text" class="form-control " name="limitPoint"
                               value="{$smarty.const.PRICE_POINT}" id="limitPoint"
                               placeholder="میزان ارزش هر امتیاز را وارد نمائید" readonly>
                    </div>
                    <div class="form-group col-sm-2">ریال به خرید تعلق می یابد</div>

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



    {load_presentation_object filename="busTicketPriceChanges" assign="objCompany"}
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست امتیاز ها</h3><br/>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ ثبت</th>
                            <th>سرویس</th>
                            <th>شرکت مسافربری</br>زیر مجموعه شرکت مسافربری</th>
                            <th>کانتر</br>ضریب امتیاز کانتر</th>
                            <th>امتیاز</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objPointClub->PointClubList()}
                            {$number=$number+1}

                            {assign var="service" value=$objPointClub->NameServicePoint($item.type_service)}

                            <tr id="del-{$item.id}">

                                <td>{$number}</td>

                                <td>
                                    {$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}
                                </td>

                                <td>

                                    {if $item.type_service eq 'all'}
                                        همه
                                    {else}
                                            {$service['TitleFa']}

                                    {/if}
                                </td>

                                <td>
                                    {if {$service['MainServiceGroup']} eq 'Flight'}
                                        {if $item.base_company eq 'all'}همه
                                        {else}
                                            {$objFunctions->getAirlineNameById($item.base_company)}
                                        {/if}
                                    {else}
                                        {if $item.base_company eq 'all'}همه
                                        {else}
                                            {$objCompany->getNameBaseCompany($item.base_company)}
                                        {/if}
                                    {/if}
                                    <hr>
                                    {if $item.company eq 'all'}همه
                                    {else}
                                        {$item.company}
                                    {/if}
                                </td>

                                <td>
                                    {$counterTypeListByID[$item.counterTypeId]}
                                    <hr>{*{$item.pointToPrice} ریال*}
                                    <input type="text" class="form-control editPointClub" name="pointToPrice"
                                           value="{$item.pointToPrice}" id="pointToPrice"
                                           data-id="{$item.id}" {if $item.is_enable neq '1'}disabled="disabled"{/if}>
                                </td>

                                <td>
                                    <div class="form-group col-sm-2">به ازای هر </div>
                                    <div class="form-group col-sm-3">
                                        <input type="text" class="form-control editPointClub" name="limitPrice"
                                               value="{$item.limitPrice}" id="limitPrice"
                                               data-id="{$item.id}" {if $item.is_enable neq '1'}disabled="disabled"{/if}>
                                    </div>
                                    <div class="form-group col-sm-3">ریال،معادل 1 امتیاز، که هر امتیاز برابر </div>
                                    <div class="form-group col-sm-2">
                                        <input type="text" class="form-control editPointClub" name="limitPoint"
                                               value="{$item.limitPoint}" id="limitPoint"
                                               data-id="{$item.id}"
                                               placeholder="میزان امتیاز را وارد نمائید"
                                               data-bts-button-down-class="btn btn-default btn-outline"
                                               data-bts-button-up-class="btn btn-default btn-outline"  readonly="readonly">
                                    </div>
                                    <div class="form-group col-sm-2">ریال به خرید تعلق می یابد</div>
                                </td>

                                <td>
                                    {if $item.is_enable neq '1'}
                                        <a href="#" onclick="return false"
                                           class="cursor-default  popoverBox  popover-default" data-toggle="popover"
                                           title="حذف تغییرات" data-placement="right"
                                           data-content="شما قبلا این امتیاز را در تاریخ      {$objDate->jdate('Y-m-d (H:i:s)', $item.disable_date_int)} غیرفعال کرده اید"> <i
                                                    class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban "></i></a>
                                    {else}
                                        <a id="DelChangePrice-{$item.id}" href="#"
                                           onclick="deletePointClub('{$item.id}'); return false"
                                           class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات"
                                           data-placement="right"
                                           data-content="برای غیرفعال کردن امتیاز کلیک کنید"> <i
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

<script type="text/javascript" src="assets/JsFiles/pointClub.js"></script>