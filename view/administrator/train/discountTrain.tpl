{load_presentation_object filename="counterType" assign="objCounterType"}
{load_presentation_object filename="discount" assign="objCompany"}
{$objCounterType->getAll('all')} {*گرفتن لیست انواع کانتر*}
{assign var="counterTypeListByID" value=$objCounterType->counterTypeListByID()}

<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تخفیف ویژه قطار</li>x
            </ol>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تخفیف ویژه قطار</h3>
                <br>
                <form id="formAddDiscountToTrain" method="post" action="{$smarty.const.rootAddress}user_ajax">
                    <input type="hidden" name="flag" value="AddSpecialDiscountTrain">
                    <div class="form-group col-sm-6 ">
                        <label for="startDate" class="control-label">از تاریخ </label>
                        <input type="text" class="form-control datepicker" name="startDate" value=""
                               id="startDate" placeholder="تاریخ شروع تخفیف را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="endDate" class="control-label">تا تاریخ</label>
                        <input type="text" class="form-control datepickerReturn" name="endDate"
                               value="" id="endDate"
                               placeholder="تاریخ پایان تخفیف را وارد نمائید">

                    </div>
                    <div class="form-group col-sm-4">
                        <label for="services" class="control-label">سرویس</label>
                        <select name="services" id="services"
                                class="form-control select2" onchange="getBaseCompany()">
                            <option value="">انتخاب کنید....</option>
                            <option value="all">همه</option>
                            <option value="Train" data-groupServices="Train"> قطار عادی </option>
                            <option value="PrivateTrain" data-groupServices="Train"> قطار سهمیه ایی </option>
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
                        <label for="company" class="control-label">شماره قطار</label>
                        <input type="text" name="company" id="company" value=""
                               class="form-control"
                               placeholder="لطفا شماره قطار را وارد کنید">
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
                                                <input type="text" value="" id="percent{$keyCounter}" name="percent{$keyCounter}"
                                                       class="form-control text-right"
                                                       placeholder="میزان تخفیف را وارد نمائید"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="میزان تخفیف"/>
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
                <h3 class="box-title m-b-0">لیست امتیاز ها</h3><br/>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ ثبت</th>
                            <th>سرویس</th>
                            <th>شرکت مسافربری</br>زیر مجموعه شرکت مسافربری</th>
                            <th>کانتر</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th> درصد تخفیف</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCompany->discountList()}
                            {$number=$number+1}

                            {assign var="service" value=$objCompany->NameServicePoint($item.type_service)}

                            <tr id="del-{$item.id}">

                                <td>{$number}</td>

                                <td>
                                    {$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}
                                </td>

                                <td>
                                    {$service['TitleFa']}
                                </td>

                                <td>
                                    {if $item.company eq 'all'}
                                        همه
                                    {else}
                                        {$item.company}
                                    {/if}
                                </td>

                                <td>
                                    {$counterTypeListByID[$item.counterTypeId]}

                                </td>

                                <td>
                                        {$item.start_date}
                                </td>
                                <td>
                                    {$item.end_date}
                                </td>
                                <td>
                                    {$item.percent}%
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
                                           onclick="deletePercentTrain('{$item.id}'); return false"
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