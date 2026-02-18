{load_presentation_object filename="agency" assign="agency"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $objAdmin->isLogin()}
                    <li><a href="agencyList">همکاران</a></li>
                {else}
                    <li>کاربران</li>
                {/if}
                <li class="active">سوابق خرید</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>



    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="ticketHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th style="text-align: center;">ردیف</th>
                            <th style="text-align: center;">نام کانتر</th>
                            <th style="text-align: center;">مبداء</th>
                            <th style="text-align: center;">مقصد</th>
                            <th style="text-align: center;">ایرلاین</th>
                            <th style="text-align: center;">شماره پرواز</th>
                            <th style="text-align: center;">تاریخ پرواز</th>
                            <th style="text-align: center;">نوع پرواز</th>
                            <th style="text-align: center;">نوع خرید</th>
                            <th style="text-align: center;">شماره رزرو</th>
                            <th style="text-align: center;">مبلغ</th>
                            <th style="text-align: center;">عملیات</th>

                        </tr>
                        </thead>
                        <tbody>
                        {assign var="agencyTickets" value=$agency->TicketsAgency($smarty.get.id,'No')}
                        {assign var="number" value=0}
                        {assign var="totalPrice" value="0"}
                        {foreach  $agencyTickets as $key=>$item}

                            {$number = $number + 1}
                            {$totalPrice = $totalPrice + $objFunctions->CalculateDiscount($item.request_number,'yes')}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.member_name}&nbsp;</td>
                                <td>{$item.origin_city}</td>
                                <td>{$item.desti_city}</td>
                                <td>{$item.airline_name}</td>
                                <td>{$item.flight_number}</td>
                                <td> ({$objFunctions->format_hour($item.time_flight)})&nbsp;&nbsp; {$objFunctions->DateJalali($item.date_flight)}  </td>
                                <td>{if $item.flight_type eq 'charter'}چارتری{else} سیستمی{/if}</td>
                                <td>{if $item.payment_type eq 'cash'}نقدی{else}اعتباری{/if}</td>
                                <td>{$item.request_number}</td>
                                <td>{$objFunctions->CalculateDiscount($item.request_number,'yes')|number_format} ریال</td>
                                <td>
                                    <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=parvazBookingLocal&id={$item.request_number}" target="_blank"
                                       title="دانلود بلیط(pdf)" style="margin: 5px 0;">
                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-file-pdf-o "
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title=" بلیط پارسی"></i>
                                    </a>

                                    <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=bookshow&id={$item.request_number}" target="_blank"
                                       title="دانلود بلیط(pdf)" style="margin: 5px 0;">
                                        <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success fa fa-file-pdf-o "
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title=" بلیط انگلیسی"></i>
                                    </a>
                                </td>
                            </tr>
                        {/foreach}

                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="3"></th>
                            <th colspan="3"></th>
                            <th colspan="2">جمع کل</th>
                            <th colspan="2">{$totalPrice|number_format}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/bookshow.js"></script>
