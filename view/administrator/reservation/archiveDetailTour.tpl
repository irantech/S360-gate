{load_presentation_object filename="reservationTour" assign="objReservation"}
{load_presentation_object filename="resultTourLocal" assign="objResult"}

<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت تور رزرواسیون</li>
                <li><a href="reportTour">گزارش تور</a></li>
                <li class="active">جزئیات تور</li>
            </ol>
        </div>
    </div>

    {assign var="infoTour" value=$objReservation->archiveTourByIdSame($smarty.get.id)}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <div class="form-group col-sm-12">
                    <img style="width: 30%;height: auto;" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_pic']}" alt="{$infoTour['tour_pic']}">
                </div>

                <div class="form-group col-sm-12">
                    <a class="downloadLink" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_file']}" target="_blank"
                       type="application/octet-stream">مشاهده فایل پکیج<i class="mdi mdi-download"></i></a>
                </div>

                <div class="row show-grid">
                    <div class="col-md-3">
                        <b>نام تور: </b>
                        {$infoTour['tour_name']}
                    </div>
                    <div class="col-md-3">
                        <b>نوع تور: </b>
                        {$infoTour['tour_type']}
                    </div>
                    <div class="col-md-3">
                        <b>کد تور: </b>
                        {$infoTour['tour_code']}
                    </div>
                    <div class="col-md-3">
                        <b>مناسبت تور: </b>
                        {$infoTour['tour_reason']}
                    </div>
                    <div class="col-md-3">
                        <b>شروع تاریخ فروش تور: </b>
                        {$objFunctions->convertDate($infoTour['minDate'])}
                    </div>
                    <div class="col-md-3">
                        <b>پایان تاریخ فروش تور: </b>
                        {$objFunctions->convertDate($infoTour['maxDate'])}
                    </div>
                    <div class="col-md-2">
                        <b>چند شب: </b>
                        {$infoTour['night']}
                    </div>
                    <div class="col-md-2">
                        <b>چند روز: </b>
                        {$infoTour['day']}
                    </div>
                    <div class="col-md-2">
                        <b>میزان بار مجاز: </b>
                        {$infoTour['free']}
                    </div>
                    <div class="col-md-2">
                        <b>پیش پراخت: </b>
                        {$infoTour['prepayment_percentage']} درصد
                    </div>
                    <div class="col-md-2">
                        <b>ویزا: </b>
                        {if $infoTour['visa'] eq 'yes'}دارد{else}ندارد{/if}
                    </div>
                    <div class="col-md-2">
                        <b>بیمه: </b>
                        {if $infoTour['insurance'] eq 'yes'}دارد{else}ندارد{/if}
                    </div>
                </div>


                {load_presentation_object filename="currencyEquivalent" assign="objCurrency"}



                {assign var="daysWeek" value=$objReservation->getDaysWeek($smarty.get.id)}
                <p class="text-muted m-b-10">انتخاب روز های هفته</p>
                <div class="row show-grid">
                    {foreach $daysWeek as $val}
                        <div class="col-md-1"><i class="fa fa-check"></i>
                            <b>
                                {if $val=='0'}
                                    شنبه
                                {elseif $val=='1'}
                                    یکشنبه
                                {elseif $val=='2'}
                                    دو شنبه
                                {elseif $val=='3'}
                                    سه شنبه
                                {elseif $val=='4'}
                                    چهار شنبه
                                {elseif $val=='5'}
                                    پنج شنبه
                                {elseif $val=='6'}
                                    جمعه
                                {/if}
                            </b>
                        </div>
                    {/foreach}
                    </div>

                <p class="text-muted m-b-10">توضیحات</p>
                <div class="row show-grid">
                    <div class="col-md-12">
                        <p>{$infoTour['description']}</p>
                    </div>
                </div>

                <p class="text-muted m-b-10">مدارک لازم</p>
                <div class="row show-grid">
                    <div class="col-md-12">
                        <p>{$infoTour['required_documents']}</p>
                    </div>
                </div>

                <p class="text-muted m-b-10">قوانین و مقررات</p>
                <div class="row show-grid">
                    <div class="col-md-12">
                        <p>{$infoTour['rules']}</p>
                    </div>
                </div>

                <p class="text-muted m-b-10">قوانین کنسلی</p>
                <div class="row show-grid">
                    <div class="col-md-12">
                        <p>{$infoTour['cancellation_rules']}</p>
                    </div>
                </div>

                <p class="text-muted m-b-10">برنامه سفر</p>
                <div class="row show-grid">
                    <div class="col-md-12">
                        <p>{$infoTour['travel_program']}</p>
                    </div>
                </div>

                <p class="text-muted m-b-10">مبدا</p>
                <div class="row show-grid">
                    <div class="col-md-3">
                        <b>قاره مبدا: </b>
                        {if $infoTour['origin_continent_id'] eq '1'} آسیا
                        {elseif $infoTour['origin_continent_id'] eq '2'}اروپا
                        {elseif $infoTour['origin_continent_id'] eq '3'}آمریکا
                        {elseif $infoTour['origin_continent_id'] eq '4'}استرالیا
                        {elseif $infoTour['origin_continent_id'] eq '5'}آفریقا
                        {/if}
                    </div>
                    <div class="col-md-3">
                        <b>کشور مبدا: </b>
                        {$infoTour['origin_country_name']}
                    </div>
                    <div class="col-md-3">
                        <b>شهر مبدا: </b>
                        {$infoTour['origin_city_name']}
                    </div>
                    <div class="col-md-3">
                        <b>منطقه مبدا: </b>
                        {$infoTour['origin_region_name']}
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">


                {assign var="numberRoutDept" value="0"}
                {assign var="numberRoutReturn" value="0"}
                {foreach key=key item=rout from=$objReservation->infoTourRoutByIdTour($infoTour['id'])}

                    {if $rout['tour_title'] eq 'dept'}
                        {$numberRoutDept=$numberRoutDept+1}
                    {elseif $rout['tour_title'] eq 'return'}
                        {$numberRoutReturn=$numberRoutReturn+1}
                    {/if}

                    <p class="txt-title-tour">مسیر
                        {if $rout['tour_title'] eq 'dept'}{$objReservation->textNumber($numberRoutDept)}
                        {elseif $rout['tour_title'] eq 'return'}{$objReservation->textNumber($numberRoutReturn)}(برگشت)
                        {/if}
                    </p>

                    {if $rout['tour_title'] neq 'return'}
                    <div class="row show-grid">
                        <div class="col-md-3">
                            <b>چند شب: </b>
                            {$rout['night']}
                        </div>
                        <div class="col-md-3">
                            <b>چند روز: </b>
                            {$rout['day']}
                        </div>
                    </div>
                    {/if}

                    <div class="row show-grid">
                        <div class="col-md-3">
                            <b>قاره مقصد: </b>
                            {if $rout['destination_continent_id'] eq '1'} آسیا
                            {elseif $rout['destination_continent_id'] eq '2'}اروپا
                            {elseif $rout['destination_continent_id'] eq '3'}آمریکا
                            {elseif $rout['destination_continent_id'] eq '4'}استرالیا
                            {elseif $rout['destination_continent_id'] eq '5'}آفریقا
                            {/if}
                        </div>
                        <div class="col-md-3">
                            <b>کشور مقصد: </b>
                            {$rout['destination_country_name']}
                        </div>
                        <div class="col-md-3">
                            <b>شهر مقصد: </b>
                            {$rout['destination_city_name']}
                        </div>
                        <div class="col-md-3">
                            <b>منطقه مقصد: </b>
                            {$rout['destination_region_name']}
                        </div>

                        <div class="col-md-3">
                            <b>نوع وسیله نقلیه: </b>
                            {$rout['type_vehicle_name']}
                        </div>
                        <div class="col-md-3">
                            <b>شرکت حمل و نقل: </b>
                            {$rout['airline_name']}
                        </div>
                        <div class="col-md-3">
                            <b>کلاس پرواز: </b>
                            {$rout['class']}
                        </div>
                        <div class="col-md-3">
                            <b>ساعت حرکت: </b>
                            {$rout['exit_hours']}
                        </div>
                        <div class="col-md-3">
                            <b>مدت زمان حرکت: </b>
                            {$rout['hours']}
                        </div>
                    </div>






            {/foreach}


            </div>
        </div>
    </div>

    {assign var=tourTypeIdArray value=$infoTour['tour_type_id']|json_decode:true}
    {if 1|in_array:$tourTypeIdArray}
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <p class="text-muted m-b-10">قیمت تور یک روزه</p>
                    <div class="row show-grid">
                        <div class="col-md-3">
                            <b>قیمت بزرگسال (ریالی): </b>
                            {$infoTour['adult_price_one_day_tour_r']}
                        </div>
                        <div class="col-md-3">
                            <b>قیمت کودک (ریالی): </b>
                            {$infoTour['child_price_one_day_tour_r']}
                        </div>
                        <div class="col-md-3">
                            <b>قیمت نوزاد (ریالی): </b>
                            {$infoTour['infant_price_one_day_tour_r']}
                        </div>
                    </div>

                    <div class="row show-grid">
                        <div class="col-md-3">
                            <b>قیمت بزرگسال (ارزی): </b>
                            {$infoTour['adult_price_one_day_tour_a']}
                        </div>
                        <div class="col-md-3">
                            <b>قیمت کودک (ارزی): </b>
                            {$infoTour['child_price_one_day_tour_a']}
                        </div>
                        <div class="col-md-3">
                            <b>قیمت نوزاد (ارزی): </b>
                            {$infoTour['infant_price_one_day_tour_a']}
                        </div>
                        <div class="col-md-3">
                            <b>نوع ارز: </b>
                            {$infoTour['currency_type_one_day_tour']}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    {else}


        <div class="row white-box">
            <div class="col-sm-12">

                {foreach key=packageCount item=package from=$objReservation->infoTourPackageByIdTour($infoTour['id'])}
                    <p class="txt-title-tour">پکیج {$packageCount+1} </p>

                    <div class="form-group col-sm-12">
                        <div class="table-responsive">
                            
                            {foreach key=hotelCount item=hotel from=$objReservation->infoTourHotelByIdPackage($package['id'])}
                                <div class="row show-grid">
                                    <div class="col-md-6">
                                        <b>هتل: </b>
                                        {$hotel['hotel_name']}
                                    </div>
                                    <div class="col-md-6">
                                        <b>خدمات اتاق: </b>
                                        {$hotel['room_service']}
                                    </div>
                                </div>
                            {/foreach}

                            <table class="table color-table purple-table">
                                <thead>
                                <tr>
                                    <th>قیمت</th>
                                    <th>قیمت سه تخته</th>
                                    <th>قیمت دو تخته</th>
                                    <th>قیمت یک تخته</th>
                                    <th>کودک با تخت</th>
                                    <th>کودک بدون تخت</th>
                                    <th>نوزاد</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>ریالی</td>
                                    <td>{$package['three_room_price_r']|number_format:0:".":","}</td>
                                    <td>{$package['double_room_price_r']|number_format:0:".":","}</td>
                                    <td>{$package['single_room_price_r']|number_format:0:".":","}</td>
                                    <td>{$package['child_with_bed_price_r']|number_format:0:".":","}</td>
                                    <td>{$package['infant_without_bed_price_r']|number_format:0:".":","}</td>
                                    <td>{$package['infant_without_chair_price_r']|number_format:0:".":","}</td>
                                </tr>

                                <tr>
                                    <td>{$hotel['currency_type']}</td>
                                    <td>{$package['three_room_price_a']}</td>
                                    <td>{$package['double_room_price_a']}</td>
                                    <td>{$package['single_room_price_a']}</td>
                                    <td>{$package['child_with_bed_price_a']}</td>
                                    <td>{$package['infant_without_bed_price_a']}</td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                {/foreach}
            </div>
        </div>

    {/if}






    {load_presentation_object filename="resultTourLocal" assign="objResult"}
    <div class="row">
        {foreach key=key item=item from=$objResult->getTourGallery($smarty.get.id)}
            <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> <img class="img-responsive" alt="user" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item.pic_name}">
                <div class="white-box">
                    <h3 class="m-t-20 m-b-20">{$item.pic_title}</h3>
                </div>
            </div>
        {/foreach}
    </div>
    

</div>





<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>