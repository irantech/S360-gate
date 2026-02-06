{load_presentation_object filename="bookshow" assign="objList"}
{*task : fdasasdf *}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"><span>لیست بلیطهای با پرداخت موفق و عدم رزرو</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست بلیط هایی که خطا رخ داده است</h3>
                <p class="text-muted m-b-30">در لیست زیر برای شما لیست بیلط هایی که پرداخت آنها تکمیل شده است ولی در
                    سیستم به حالت رزرو شده (book) تغییر وضعیت نیافته اند نمایش داده میشود
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 20px">#</th>
                            <th style="width: 120px">نام آژانس</th>
                            <th style="width: 120px">نام مسافر</th>
                            <th style="width: 100px">مسیر بلیط</th>
                            <th style="width: 100px">شماره فاکتور</th>
                            <th style="width: 100px">کد رزرو</th>
                            <th style="width: 100px">تاریخ خرید</th>
                            <th style="width: 100px">زمان پرواز</th>
                            <th style="width: 120px">وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach item=item from=$objList->listUncompletedBookList()}
                            {$number=$number+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.NameOfAgency}</td>
                                <td>{$item.passenger_name} {$item.passenger_family}</td>
                                <td>{$item.origin_city} - {$item.desti_city}</td>
                                <td>{$item.factor_number}</td>
                                <td>{$item.request_number}</td>
                                <td>{$objFunctions->ConvertToJalali($item.creation_date)}</td>
                                <td>{$objFunctions->convertDateFlight($item.date_flight)} {$item.time_flight}</td>
                                <td>{$objFunctions->showPersianTicketStatus({$item.successfull})}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>