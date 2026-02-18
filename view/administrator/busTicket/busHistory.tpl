{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookingBusShow" assign="objbook"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید بلیط اتوبوس</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو کنید</p>

                <form id="SearchBusHistory" method="post" action="{$smarty.const.rootAddress}busHistory">
                    <input type="hidden" name="flag" id="flag" value="createExcelFile">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع</label>
                        <input type="text" class="form-control datepicker" name="date_of"
                               value="{$smarty.post.date_of}" id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{$smarty.post.to_date}" id="to_date" placeholder="تاریخ پایان جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="status" class="control-label">وضعیت رزرو</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                            {*<option value="temporaryReservation" {if $smarty.post.status eq  'temporaryReservation' }selected{/if}>رزرو موقت</option>*}
                            <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                            <option value="nobook" {if $smarty.post.status eq 'nobook' }selected{/if}>ناموفق</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="factor_number" class="control-label">شماره فاکتور</label>
                        <input type="text" class="form-control " name="factor_number"
                               value="{$smarty.post.factor_number}" id="factor_number"
                               placeholder="شماره فاکتور را وارد نمائید">

                    </div>

                    {if $smarty.const.TYPE_ADMIN eq '1'}
                        <div class="form-group col-sm-6">
                            <label for="client_id" class="control-label">نام همکار</label>
                            <select name="client_id" id="client_id" class="form-control ">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                {foreach $objbook->list_hamkar() as $client }
                                    <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                {/foreach}
                            </select>
                        </div>
                    {/if}

                    <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                        <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                        <input type="text" class="form-control " name="passenger_name"
                               value="{$smarty.post.passenger_name}" id="passenger_name"
                               placeholder="نام یا نام خانوادگی مسافر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                        <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                        <input type="text" class="form-control " name="member_name"
                               value="{$smarty.post.member_name}" id="member_name"
                               placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                        <label for="member_name" class="control-label">شماره موبایل مسافر</label>
                        <input type="number" class="form-control " name="passenger_mobile"
                               value="{$smarty.post.passenger_mobile}" id="passenger_mobile"
                               placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                        <label for="client_id" class="control-label">نوع خرید</label>
                        <select name="payment_type" id="payment_type" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه</option>
                            <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی</option>
                            <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>اعتباری</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox checkbox-success col-sm-6 ">
                                <input id="checkBoxAdvanceSearch" type="checkbox" name="checkBoxAdvanceSearch"
                                       onclick="displayAdvanceSearch(this)">
                                <label for="checkBoxAdvanceSearch" class="font-30"> جستجوی پیشرفته </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">شروع جستجو</button>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </form>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">

                <div class="box-btn-excel">
                    <a onclick="createExcelForReportBus()" class="btn btn-primary waves-effect waves-light " type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید</p>

                <div class="table-responsive">
                    <table id="gashtHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>

                            <th> تاریخ و ساعت خرید<br/>نام خریدار<br/>نوع کانتر</th>
                            <th>مبدا<br>مقصد</th>
                            <th>تاریخ حرکت<br/>ساعت حرکت</th>
                            <th>شرکت مسافربری<br/>اتوبوس</th>
                            <th>شماره فاکتور<br>شماره بلیط<br/>شماره صندلی</th>
                            <th>نام مسافر<br/>شماره موبایل</th>
                            <th>سهم آژانس</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th style="direction: ltr">+ apiسود<br/> سهم ما</th>
                            {/if}
                            <th>مبلغ</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="bookList" value=$objbook->listBookBusTicket()}
                        {foreach key=key item=item from=$bookList}

                            {assign var="infoMember" value=$objFunctions->infoMember($item['MemberId'],$item['ClientId'])}

                            <tr id="del-{$item.id}">

                                <td>{$item['NumberColumn']}</td>

                                <td>
                                    {if $item['PaymentDate'] neq ''}
                                        {$item['PaymentDate']} {$item['PaymentTime']}
                                        <hr style="margin:3px">
                                    {/if}
                                    {$item['MemberName']}
                                    <hr style='margin:3px'>
                                    {if $infoMember['fk_counter_type_id'] eq '5'}مسافر  {else} کانتر{/if}

                                    {if $item['ServicesDiscount'] neq '' && $infoMember['is_member'] eq '1'}
                                        {$item['ServicesDiscount']} %ای
                                    {/if}
                                </td>

                                <td>{$item['OriginName']}<hr style="margin:3px">{$item['DestinationCity']}</td>

                                <td>{$item['DateMove']}<hr style="margin:3px">{$item['TimeMove']}</td>

                                <td>{$item['BaseCompany']}<hr style="margin:3px">{$item['CarType']}</td>

                                <td>{$item['FactorNumber']}<hr style="margin:3px">{$item['pnr']}<hr style="margin:3px">{$item['PassengerChairs']}</td>

                                <td>{$item['PassengerName']}<hr style="margin:3px">{$item['PassengerMobile']}</td>

                                <td>{$item['AgencyCommission']}</td>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                <td>{$item['IrantechCommission']|number_format:0:".":","}<hr style="margin:3px">{$item['priceForMa']|number_format:0:".":","}</td>
                                {/if}

                                <td>{*{$item['Price']}<hr style="margin:3px">*}{$item['totalPrice']|number_format:0:".":","}</td>

                                <td>
                                    {if $smarty.const.TYPE_ADMIN eq '1'}
                                        {assign var="addressClient" value=$objbook->ShowAddressClient($item['ClientId'])}
                                    {else}
                                        {assign var="addressClient" value=$objbook->ShowAddressClient($smarty.const.CLIENT_ID)}
                                    {/if}
                                    {if $item.Status neq 'nothing'}
                                        <div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu animated flipInY">
                                                <li>
                                                    <div class="pull-left margin-10">
                                                        <a onclick="ModalShowBook('{$item['FactorNumber']}');return false"
                                                           data-toggle="modal" data-target="#ModalPublic">
                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="مشاهده خرید"></i>
                                                        </a>
                                                    </div>
                                                    {if $item.Status eq 'book'}
                                                        <div class="pull-left margin-10">
                                                            <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/eBusTicket&num={$item['FactorNumber']}"
                                                               target="_blank"
                                                               title="مشاهده اطلاعات خرید" >
                                                                <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده اطلاعات خرید"></i>
                                                            </a>
                                                        </div>
                                                        <div class="pull-left margin-10">
                                                            <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookingBusShow&id={$item['FactorNumber']}"
                                                               target="_blank"
                                                               title="مشاهده اطلاعات خرید" >
                                                                <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده اطلاعات خرید"></i>
                                                            </a>
                                                        </div>
                                                    {/if}

                                                    {if $smarty.const.TYPE_ADMIN eq '1'
                                                        && ($item.Status eq 'temporaryReservation' || $item.Status eq 'prereserve' || $item.Status eq 'book')}
                                                        <div class="pull-left margin-10">
                                                            <a onclick="checkInquireBusTicket('{$item['FactorNumber']}');return false"
                                                               data-toggle="modal" data-target="#ModalPublic">
                                                                <i class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="پیگیری رزرو از وب سرویس"></i>
                                                            </a>
                                                        </div>
                                                    {/if}

                                                </li>
                                            </ul>

                                            <hr style='margin:3px'>
                                            {if $item.payment_type eq 'cash'}نقدی
                                            {elseif $item.payment_type eq 'credit' || $item.payment_type eq 'member_credit'}اعتباری
                                            {/if}

                                            {if $smarty.const.TYPE_ADMIN eq '1' && $item.payment_type eq 'cash'}
                                                <hr style='margin:3px'>
                                                {$item.numberPortBank}
                                            {/if}

                                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                                <hr style='margin:3px'>
                                                {$item.SourceName}
                                            {/if}

                                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                                <hr style='margin:3px'>
                                                {$item.AgencyName}
                                            {/if}
                                        </div>
                                    {/if}
                                </td>

                                <td>
                                    {if $item.Status eq 'book'}
                                        <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                    {elseif $item.Status eq 'temporaryReservation'}
                                        <a class="btn btn-warning cursor-default" onclick="return false;">رزرو موقت</a>
                                    {elseif $item.Status eq 'prereserve'}
                                        <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>
                                    {elseif $item.Status eq 'bank' && $item.tracking_code_bank eq ''}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">پرداخت اینترنتی نا موفق</a>
                                    {elseif $item.Status eq 'cancel'}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>
                                    {elseif $item.Status eq 'error'}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">خطا</a>
                                    {else}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>
                                    {/if}

                                    {* *** لینک درگاه پابانه برای پرداخت و قطعی شدن رزرو *** *}
                                    {if $smarty.const.TYPE_ADMIN eq '1' && $item.Status eq 'temporaryReservation'}
                                        <br/>
                                        <br/>
                                        <a href="https://api.payaneha.com/payment.ashx?PayanehaOrderCode={$item['OrderCode']}"
                                                class="btn btn-success cursor-default" target="_blank">پرداخت از طریق درگاه پایانه ها</a>
                                    {/if}
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7"></th>
                                <th>
                                    {if $objbook->agencyCommissionCost neq ''}
                                        {$objbook->agencyCommissionCost|number_format:0:".":","} ريال
                                        <br>
                                    {/if}
                                    {if $objbook->agencyCommissionPercent neq ''}
                                        {$objbook->agencyCommissionPercent} %
                                    {/if}
                                </th>
                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <th>
                                        ({$objbook->irantechCommission|number_format:0:".":","})ريال
                                        <hr>({$objbook->priceForMa|number_format:0:".":","})ريال
                                    </th>
                                {/if}
                                <th>({$objbook->totalPrice|number_format:0:".":","})ريال</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="ModalPublic" class="modal">
    <div class="modal-content" id="ModalPublicContent"></div>
</div>


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش سوابق خرید اتوبوس   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/370/---.html" target="_blank" class="i-btn"></a>

</div>
{if $smarty.post.checkBoxAdvanceSearch neq ''}
    {literal}
        <script type="text/javascript">
            $('document').ready(function () {
                $('.showAdvanceSearch').fadeIn();
                $('#checkBoxAdvanceSearch').attr('checked',true);
            });
        </script>
    {/literal}
{/if}
{if $objAdmin->Access() eq false}
    {literal}
        <script>
            $(document).ready(function () {
                $('#ModalAccessMessage').modal('show');
            })
        </script>
    {/literal}
{/if}

<script type="text/javascript" src="assets/JsFiles/bookBusShow.js"></script>
{/if}