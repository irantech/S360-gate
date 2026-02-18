{load_presentation_object filename="memberReportBuy" assign="objMemberReportBuy"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/ticket/mainUserList">کاربران اصلی</a></li>
                <li class="active">سوابق خرید</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">جستجوی سوابق خرید </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو کنید</p>

                <form id="SearchMainUserBuy" method="post" action="{$smarty.const.rootAddress}mainUserBuy&id={$smarty.get.id}">
                    <input type="hidden" name="flag" id="flag" value="createExcelFileForMainUserBuy">
                    <input type="hidden" name="memberId" id="memberId" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع (خرید)</label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{$smarty.post.date_of}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان (خرید)</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{$smarty.post.to_date}" id="to_date"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                    <a onclick="createExcelForReportMainUserBuy()" class="btn btn-primary waves-effect waves-light "
                       type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید</p>

                <div class="table-responsive">
                    <table id="mainUserBuy" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ و ساعت خرید</th>
                            <th>نوع خرید</th>
                            <th>شماره فاکتور</th>
                            <th>آژانس همکار</th>
                            <th>نرم افزار</th>
                            <th>قیمت کل</th>
                            <th>وضعیت</th>
                            <th>فایل pdf</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="listBook" value=$objMemberReportBuy->getMemberReportBuy($smarty.get.id)}
                        {foreach key=key item=item from=$listBook}
                            {$number = $key + 1}

                            <tr id="del-{$item['id']}">

                                <td>{$number}</td>

                                <td>{$item['paymentDate']}</td>

                                <td>{$item['paymentTypeFa']}</td>

                                <td>
                                    {if $item['applicationTitle'] == 'hotel'}
                                        <a onclick="ModalShowBookForHotel('{$item['factorNumber']}');return false"
                                            data-toggle="modal" data-target="#ModalPublic">{$item['factorNumber']}</a>
                                    {elseif $item['applicationTitle'] == 'ticket'}
                                        <a onclick="ModalShowBook('{$item['requestNumber']}');return false"
                                        data-toggle="modal" data-target="#ModalPublic">{$item['requestNumber']}</a>
                                    {elseif $item['applicationTitle'] == 'europcar'}
                                        <a onclick="ModalShowBookForEuropcar('{$item['factorNumber']}');return false"
                                        data-toggle="modal" data-target="#ModalPublic">{$item['factorNumber']}</a>
                                    {elseif $item['applicationTitle'] == 'insurance'}
                                        <a onclick="ModalShowBookForInsurance('{$item['factorNumber']}');return false"
                                        data-toggle="modal" data-target="#ModalPublic">{$item['factorNumber']}</a>
                                    {elseif $item['applicationTitle'] == 'visa'}
                                        <a onclick="ModalShowBookForVisa('{$item['factorNumber']}');return false"
                                        data-toggle="modal" data-target="#ModalPublic">{$item['factorNumber']}</a>
                                    {elseif $item['applicationTitle'] == 'gasht'}
                                        <a onclick="ModalShowBookForGasht('{$item['factorNumber']}');return false"
                                        data-toggle="modal" data-target="#ModalPublic">{$item['factorNumber']}</a>
                                    {elseif $item['applicationTitle'] == 'tour'}
                                        <a onclick="ModalShowBookForTour('{$item['factorNumber']}');return false"
                                        data-toggle="modal" data-target="#ModalPublic">{$item['factorNumber']}</a>
                                    {/if}
                                </td>

                                <td>{$item['agencyName']}</td>

                                <td>{$item['applicationTitleFa']}</td>

                                <td>{$item['totalPrice']|number_format:0:".":","}</td>

                                <td>{$item['statusBookFa']}</td>

                                <td>
                                    {if $item['applicationTitle'] == 'hotel'}

                                        {assign var="linkPDF" value="BookingHotelLocal"}

                                        {if $smarty.const.CLIENT_NAME eq 'آهوان'}{*For Ahuan*}
                                            {$linkView = 'ehotelAhuan'}
                                            {$linkPDF = 'hotelVoucherAhuan'}

                                        {elseif $smarty.const.CLIENT_NAME eq 'زروان مهر آریا'}{*For Zarvan*}
                                            {$linkView = 'ehotelZarvan'}
                                            {$linkPDF = 'BookingHotelLocal'}

                                        {else}
                                            {$linkView = 'ehotelLocal'}
                                            {$linkPDF = 'BookingHotelLocal'}

                                        {/if}

                                        <div class="pull-left margin-10">
                                            {if $item['statusBook'] eq 'BookedSuccessfully'}
                                                <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target={$linkPDF}&id={$item['factorNumber']}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="بلیط پارسی"></i>
                                                </a>
                                            {/if}
                                        </div>

                                    {elseif $item['applicationTitle'] == 'ticket'}

                                        <div class="pull-left margin-10">
                                            {if $item['statusBook'] eq 'book'}
                                                <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=parvazBookingLocal&id={$item['requestNumber']}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="بلیط پارسی"></i>
                                                </a>
                                            {/if}
                                        </div>

                                    {elseif $item['applicationTitle'] == 'europcar'}

                                        <div class="pull-left margin-10">
                                            <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=BookingEuropcarLocal&id={$item['factorNumber']}"
                                               target="_blank">
                                                <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title=" رزرو اجاره خودرو پارسی "></i>
                                            </a>
                                        </div>

                                    {elseif $item['applicationTitle'] == 'insurance'}

                                    {elseif $item['applicationTitle'] == 'visa'}

                                    {elseif $item['applicationTitle'] == 'gasht'}

                                        <div class="pull-left margin-10">
                                            {if $item['statusBook'] eq 'book'}
                                                {$addressClient}
                                                <a href="{$smarty.const.ROOT_ADDRESS}{$smarty.const.CLIENT_DOMAIN}/pdf&target=bookingGasht&id={$item['factorNumber']}"
                                                   target="_blank"
                                                   title="مشاهده اطلاعات خرید" >
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="مشاهده اطلاعات خرید"></i>
                                                </a>

                                            {/if}
                                        </div>

                                    {elseif $item['applicationTitle'] == 'tour'}

                                        {if $item['statusBook'] eq 'BookedSuccessfully' || $item['statusBook'] eq 'TemporaryReservation'}
                                            <div class="pull-left margin-10">
                                                <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=BookingTourLocal&id={$item['factorNumber']}"
                                                   target="_blank">
                                                    <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o"
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title=" رزرو تور پارسی "></i>
                                                </a>
                                            </div>
                                        {/if}

                                    {/if}
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>

                        <tfoot>
                        <tr>

                            <th colspan="4"></th>

                        </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>



{literal}
    <script>
        $(document).ready(function () {
            //data tables Option
            $('#mainUserBuy').DataTable();
            /*$('#mainUserBuy').DataTable({
                "order": [
                    [0, 'desc']
                ],
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'دریافت فایل اکسل',
                        exportOptions: {}
                    },
                    {
                        extend: 'print',
                        text: 'چاپ سطر های لیست',
                        exportOptions: {}
                    },
                    {
                        extend: 'copy',
                        text: 'کپی لیست',
                        exportOptions: {}
                    }

                ]
            });*/
            /*$("#SearchTransaction").validate({
                rules: {
                    date_of: "required",
                    to_date: "required"
                },
                messages: {},
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
                }
            });*/
        });
    </script>
{/literal}


<script type="text/javascript" src="assets/JsFiles/mainUser.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookhotelshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookEuropcarShow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookinsuranceshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookvisashow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookGashtShow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookTourShow.js"></script>