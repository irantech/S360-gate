{load_presentation_object filename="listCancelUser" assign="objCancelUser"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق کنسلی خرید های کاربران</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی افزایش قیمت بلیط توسط کانتر ها  </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTicketHistory" method="post"
                      action="{$smarty.const.rootAddress}userTicketCancellationHistory">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">از تاریخ</label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{if $smarty.post.date_of neq ''} {$smarty.post.date_of} {else}{$objFunctions->timeNow()}{/if}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تا تاریخ</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{if $smarty.post.to_date neq ''}{$smarty.post.to_date}{else}{$objFunctions->timeNow()}{/if}" id="to_date"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="RequestNumber" class="control-label">pnr</label>
                        <input type="text" class="form-control " name="pnr"
                               value="{$smarty.post.pnr}" id="pnr"
                               placeholder="pnr را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="RequestNumber" class="control-label">شماره بلیط</label>
                        <input type="text" class="form-control " name="eticket_number"
                               value="{$smarty.post.eticket_number}" id="eticket_number"
                               placeholder="شماره بلیط را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="RequestNumber" class="control-label">شماره رزرو</label>
                        <input type="text" class="form-control " name="RequestNumber"
                               value="{$smarty.post.RequestNumber}" id="RequestNumber"
                               placeholder="شماره رزرو را وارد نمائید">

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
                <h3 class="box-title m-b-0">سوابق کنسلی خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>
                <p class="text-muted m-b-30">
                    پس از آن که سرویس‌دهنده مبلغ مربوط به کنسلی را استرداد نماید، دقیقاً همان مبلغ به اعتبار شما عودت داده خواهد شد.
                </p>
                <a class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>دلیل <br> درخواست</th>
                            <th>شماره <br> رزرو</th>
{*                            <th>نوع <br> درخواست</th>*}
                            <th>تاریخ <br> درخواست کاربر</th>
                            <th>تاریخ ارسال <br> به کارگزار</th>
                            <th>تاریخ تایید/رد درخواست</th>
                            <th>درصد <br> جریمه</th>
                            <th>مبلغ <br> استرداد</th>
                            <th style="width: 227px; text-align: center">عملیات</th>
                            <th>وضعیت <br> درخواست</th>


                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCancelUser->listCancelLocal()}
                            {$number=$number+1}

                            {assign var="typeFlight" value=$objFunctions->TypeFlight($item.RequestNumber)}
                            <tr id="">
                                <td>{$number}</td>
                                <td>
                                    {if $item.ReasonMember eq 'PersonalReason'}
                                        کنسلی به دلیل شخصی
                                    {elseif $item.ReasonMember eq 'DelayTwoHours'}
                                        تاخیر بیش از 2 ساعت
                                    {elseif $item.ReasonMember eq 'CancelByAirline'}
                                        {if $item.TypeCancel eq 'flight' || $item.TypeCancel eq '' }
                                            لغو پرواز توسط ایرلاین
                                        {else}
                                            تاخیر در حرکت قطار
                                        {/if}
                                    {else}
                                        {if $item.comment_user != ''}
                                            {$item.comment_user}
                                        {else}
                                            ----
                                        {/if}
                                    {/if}
                                </td>
                                <td>
                                    <span data-toggle="popover" title="مشاهده خرید" data-placement="top"
                                          data-content="برای مشاهده خرید کلیک کنید"
                                          class="popoverBox  popover-info">
                                            <a onclick="ModalShowBook('{$item.RequestNumber}','{$item.TypeCancel}');return false"
                                               data-toggle="modal" data-target="#ModalPublic" class="btn btn-info yn">
                                                {$item.RequestNumber}
                                                {if $item.Pnr neq ''}-{$item.Pnr}{/if}
                                            </a>
                                    </span>
                                    {if $item.TypeCancel eq 'bus'}
                                        <span class='badge badge-info'>
                                        {$item.FactorNumber}
                                    </span>
                                    {/if}
                                </td>
{*                                <td>*}

{*                                    {if $item.TypeCancel eq 'flight' || $item.TypeCancel eq '' }*}
{*                                        پرواز-*}
{*                                        {if $typeFlight eq 'PrivateSystem'}*}
{*                                            سیستمی اختصاصی*}

{*                                        {elseif $typeFlight eq 'PublicSystem'}*}
{*                                            سیستمی اشتراکی*}
{*                                        {elseif $typeFlight eq 'charter'}*}
{*                                            چارتری*}
{*                                        {elseif $typeFlight eq 'reservation'}*}
{*                                            رزرواسیون*}
{*                                        {/if}*}
{*                                    {elseif $item.TypeCancel eq 'train'}*}
{*                                        قطار*}
{*                                    {elseif $item.TypeCancel eq 'bus'}*}
{*                                        اتوبوس*}
{*                                    {elseif $item.TypeCancel eq 'hotel'}*}
{*                                        هتل*}
{*                                    {elseif $item.TypeCancel eq 'insurance'}*}
{*                                        بیمه*}
{*                                    {elseif $item.TypeCancel eq 'tour'}*}
{*                                        تور*}
{*                                    {/if}*}


{*                                </td>*}
                                <td dir="ltr" class="text-left">
                                    {$objDate->jdate('Y-m-d (H:i:s)', $item.DateRequestMemberInt)}
                                </td>
                                <td dir="ltr" class="text-left">
                                    {if $item.DateRequestCancelClientInt neq '0'}
                                        {$objDate->jdate('Y-m-d (H:i:s)', $item.DateRequestCancelClientInt)} {else}---{/if}
                                </td>
                                <td dir="ltr" class="text-left">
                                    {if $item.DateSetCancelInt neq '0' || $item.DateConfirmCancelInt neq '0' ||
                                    $item.DateSetFailedIndemnityInt neq '0'}

                                        {if $item.Status eq 'SetCancelClient'}

                                            {$objDate->jdate('Y-m-d (H:i:s)', $item.DateSetCancelInt)}

                                        {elseif $item.Status eq 'ConfirmCancel'}

                                            {$objDate->jdate('Y-m-d (H:i:s)', $item.DateConfirmCancelInt)}

                                        {elseif $item.Status eq 'SetFailedIndemnity'}

                                            {$objDate->jdate('Y-m-d (H:i:s)', $item.DateSetFailedIndemnityInt)}
                                        {/if}


                                    {else}
                                        -----
                                    {/if}
                                </td>
                                {*                                <td>*}
                                {*                                    {if $item.Status eq 'SetIndemnity' || $item.Status eq 'ConfirmClient' || $item.Status eq*}
                                {*                                    'SetFailedIndemnity' || $item.Status eq 'ConfirmCancel' || $typeFlight eq 'reservation'}*}

                                {*                                       {if $item.ReasonMember eq 'CancelByAirline' || $item.ReasonMember eq 'DelayTwoHours'}*}
                                {*                                        <span class="yn">---</span>*}
                                {*                                        {else}*}
                                {*                                        <span class="yn">{$item.PercentIndemnity}%</span>*}
                                {*                                        {/if}*}
                                {*                                    {else}*}
                                {*                                        -----*}
                                {*                                    {/if}*}
                                {*                                </td>*}
                                <td>

                                    {*                                    {if $item.ReasonMember eq 'CancelByAirline' || $item.ReasonMember eq 'DelayTwoHours'}*}
                                    {*                                        <span class="yn">---</span>*}
                                    {*                                    {else}*}
                                    {*                                        <span class="yn">{$item.PercentIndemnity}%</span>*}
                                    {*                                    {/if}*}

                                    {if $item.PercentIndemnity neq  0 }
                                        <span class="yn">{$item.PercentIndemnity}%</span>
                                    {else}
                                        <span class="yn">---</span>

                                    {/if}

                                </td>
                                <td>

                                    {*                                    {if $item.PercentIndemnity neq 0}*}
                                    {*                                        <span class="yn">{{$objCancelUser->totalPriceFlight($item.RequestNumber , $item.id , {$smarty.const.CLIENT_ID})}|number_format} &nbsp;ریال</span>*}
                                    {*                                    {else}*}
                                    {*                                        -----*}
                                    {*                                    {/if}*}
                                    {if $item.PriceIndemnity neq 0}
                                        <span class="yn">{$item.PriceIndemnity|number_format} &nbsp;ریال</span>
                                    {else}
                                        -----
                                    {/if}
                                </td>
                                {if ($item.pid_private eq '1' and $item.TypeCancel eq 'flight') || ($item.type_application eq 'reservation' and $item.TypeCancel eq 'hotel')}

                                    <td>
                                        {if $item.Status eq 'ConfirmCancel'}
                                            <span data-toggle="popover" data-placement="top" data-content="برای دریافت رسید کنسلی کلیک کنید"
                                                  class="popoverBox  popover-info" data-original-title="رسید کنسلی">
                                             {if $item.TypeCancel eq 'bus'}
                                                 <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=bookingBusShow&id={$item.FactorNumber}&cancelStatus=confirm"
                                                    class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                            </a>
                                            {elseif $item.TypeCancel eq 'hotel'}
                                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=BookingHotelNew&id={$item.FactorNumber}"
                                               class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                            </a>

                                            {elseif $item.TypeCancel eq 'flight'}
                                             <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=parvazBookingLocal&id={$item.RequestNumber}&cancelStatus=confirm"
                                                class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                            </a>
                                             {/if}
                                        </span>
                                            <span data-toggle="popover" title="مشاهده جزئیات" data-placement="top"
                                                  data-content="برای مشاهده جزئیات کلیک کنید"
                                                  class="popoverBox  popover-primary">
                                                <a onclick="ModalTrackingCancelTicket('{$item.RequestNumber}', '{$item.id}', '{$item.TypeCancel}');return false"
                                                   data-toggle="modal" data-target="#ModalPublic"
                                                   class="fcbtn btn btn-outline btn-primary btn-1c mdi mdi-eye cursor-default">

                                                </a>
                                            </span>
                                            <div class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-bookmark-check popoverBox  popover-success"
                                                 data-placement="top" style="cursor:context-menu"
                                                 data-toggle="popover" title="تایید نهایی"
                                                 data-content="این درخواست از سوی کارگزار به تایید نهایی رسیده">
                                            </div>
                                        {else}
                                            <div class="btn-group m-r-10">

                                                <button aria-expanded="false" data-toggle="dropdown"
                                                        class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                        type="button"> عملیات <span class="caret"></span></button>

                                                <ul role="menu" class="dropdown-menu animated flipInY">

                                                    <li>
                                                        <div class="pull-left">
                                                            <div class="pull-left margin-10">
                                                        <span data-toggle="popover" title="مشاهده جزئیات"
                                                              data-placement="top"
                                                              data-content="برای مشاهده جزئیات کلیک کنید"
                                                              class="popoverBox  popover-primary">
                                                            <a onclick="ModalTrackingCancelTicket('{$item.RequestNumber}', '{$item.ClientId}' , '{$item.IdDetail}','{$item.TypeCancel}');return false"
                                                               data-toggle="modal" data-target="#ModalPublic"
                                                               class="fcbtn btn btn-outline btn-primary btn-1c mdi mdi-eye cursor-default">

                                                            </a>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    {if $item.Status eq 'ConfirmCancel'}
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                        <span data-toggle="popover" title="رسید کنسلی"
                                                              data-placement="top"
                                                              data-content="برای دریافت رسید کنسلی کلیک کنید"
                                                              class="popoverBox  popover-info">
                                                            <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=parvazBookingLocal&id={$item.RequestNumber}&cancelStatus=confirm"
                                                               data-toggle="modal" data-target="#ModalPublic"
                                                               class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default">
                                                            </a>
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    {/if}



                                                    {if $item.Status eq 'RequestMember'}
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                            <span data-toggle="popover" title="ارسال درخواست از سمت آژانس" data-placement="top"
                                                                  data-content="درخواست از سمت آژانس ارسال شده است،لطفا برای اعلام درصد بر روی دکمه زیر کلیک نمائید"
                                                                  class="popoverBox  popover-warning">
                                                                <a class="fcbtn btn btn-outline btn-warning btn-1c  popover-warning mdi mdi-percent cursor-default"
                                                                   data-toggle="modal" data-target="#ModalPublic"
                                                                   onclick="UserShowModalPercent('{$item.RequestNumber}','{$item.id}','{$smarty.const.CLIENT_ID}','{$item.TypeCancel}')"
                                                                   id="RequestClientBtn-{$item.IdDetail}"></a>
                                                            </span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    {elseif $item.Status eq 'SetIndemnity'}
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                                    <a class="fcbtn btn btn-outline btn-warning btn-1c popoverBox  popover-warning mdi mdi-timer cursor-default"
                                                                       data-placement="top" title="انتظار برای پاسخ آژانس"
                                                                       data-toggle="popover"
                                                                       data-content=" در انتظار پاسخ آژانس بابت درصد اعلامی از سوی کارگزار"
                                                                       id="SetIndemnity-{$item.id}"></a>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    {elseif $item.Status eq 'ConfirmClient' }
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                            <span data-toggle="popover" title="واریز وجه"
                                                                  data-content=" درصد اعلامی از سوی شما ،با موافقت آژانس همراه بوده است ،لطفا برای واریز وجه دکمه زیر را فشار دهید "
                                                                  class="popoverBox  popover-info " data-placement="top">
                                                                <a class="fcbtn btn btn-outline btn-info btn-1c  mdi mdi-bookmark-check cursor-default"
                                                                   id="ConfirmClient-{$item.id}"
                                                                   data-toggle="modal" data-target="#ModalPublic"
                                                                   onclick="FinalConfirm('{$item.RequestNumber}','{$item.IdDetail}','{$item.ClientId}')">
                                                                </a>
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    {elseif $item.Status eq 'SetFailedIndemnity'}
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">

                                                                    <div class="fcbtn btn btn-outline btn-danger btn-1c cursor-default popoverBox  popover-danger mdi mdi-close-circle-outline "
                                                                         data-toggle="popover" title="رد درصد توسط آژانس"
                                                                         data-placement="top"
                                                                         data-content="آژانس درصد اعلامی را قبول نکرده و روند درخواست را متوقف کرده است">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    {elseif $item.Status eq 'ConfirmCancel'}
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">

                                                                    <div class="fcbtn btn btn-outline btn-success btn-1c cursor-default popoverBox  popover-success mdi mdi-check"
                                                                         data-toggle="popover" title="واریز وجه درخواست"
                                                                         data-placement="top"
                                                                         data-content="درخواست نهایی شده و مبلغ مسترد شده است">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    {/if}


                                                    <li>
                                                        <div class="pull-left">
                                                            <div class="pull-left margin-10">
                                                                <a class="fcbtn btn btn-outline btn-info btn-1c cursor-default"
                                                                   data-toggle="modal" data-target="#ModalPublic" title="close" data-placement="top"
                                                                   data-content="بسته شدن بلیط"
                                                                   onclick="showModalTicketClose('{$item.id}', '{$item.ClientId}')"> close
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>

                                        {/if}

                                    </td>
                                {else}
                                    <td>


                                        {if $item.Status eq 'ConfirmCancel'}
                                            <span data-toggle="popover" data-placement="top" data-content="برای دریافت رسید کنسلی کلیک کنید"
                                                  class="popoverBox  popover-info" data-original-title="رسید کنسلی">
                                             {if $item.TypeCancel eq 'bus'}
                                                 <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=bookingBusShow&id={$item.FactorNumber}&cancelStatus=confirm"
                                                    class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                            </a>
                                            {elseif $item.TypeCancel eq 'hotel'}
                                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=BookingHotelNew&id={$item.FactorNumber}"
                                               class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                            </a>

                                            {elseif $item.TypeCancel eq 'flight'}
                                             <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=parvazBookingLocal&id={$item.RequestNumber}&cancelStatus=confirm"
                                                class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                            </a>
                                             {/if}
                                        </span>
                                        {/if}

                                        {if $typeFlight eq 'reservation'}

                                            <span data-toggle="popover" title="" data-placement="top" data-content="برای مشاهده جزئیات کلیک کنید"
                                                  class="popoverBox  popover-primary" data-original-title="مشاهده جزئیات">
                                            <a onclick="ModalTrackingCancelTicket('{$item.RequestNumber}', '{$item.id}');return false"
                                               data-toggle="modal" data-target="#ModalPublic"
                                               class="fcbtn btn btn-outline btn-primary btn-1c mdi mdi-eye cursor-default">
                                            </a>
                                        </span>

                                            {if $item.Status eq 'RequestMember'}
                                                <span id="ConfirmCancelRequest-3" title="" data-toggle="popover" data-placement="top"
                                                      class="popoverBox  popover-success" data-content="تایید درخواست کاربر"
                                                      data-original-title="تایید درخواست کاربر">
                                               <a onclick="confirmCancelReservationTicket('{$item.RequestNumber}', '{$item.id}'); return false"
                                                  class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-check " id="RequestMember-3"
                                                  data-toggle="modal" data-target="#ModalPublic"></a>
                                            </span>

                                                <span id="FailedCancelRequestUser-3" title="" data-toggle="popover" data-placement="top"
                                                      class="popoverBox  popover-danger"
                                                      data-content="شما می توانید با زدن این دکمه در کادر باز شده درخواست را رد نموده و در صورت تمایل دلیل آن را برای کاربر شرح دهید"
                                                      data-original-title="رد درخواست کاربر">
                                                <a onclick="ShowModalFailedCancel('{$item.RequestNumber}', '{$item.id}')"
                                                   id="FailedCancel-3" class="fcbtn btn btn-outline btn-danger btn-1c mdi mdi-close "
                                                   data-toggle="modal" data-target="#ModalPublic"></a>
                                            </span>
                                            {/if}

                                        {else}

                                            <span data-toggle="popover" title="مشاهده جزئیات" data-placement="top"
                                                  data-content="برای مشاهده جزئیات کلیک کنید"
                                                  class="popoverBox  popover-primary">
                                                <a onclick="ModalTrackingCancelTicket('{$item.RequestNumber}', '{$item.id}', '{$item.TypeCancel}');return false"
                                                   data-toggle="modal" data-target="#ModalPublic"
                                                   class="fcbtn btn btn-outline btn-primary btn-1c mdi mdi-eye cursor-default">

                                                </a>
                                            </span>

                                            {if $item.Status eq 'RequestMember'}
                                                <span id="ConfirmCancelRequest-{$item.id}"
                                                      title="  تایید درخواست کاربر" data-toggle="popover" data-placement="top"
                                                      class="popoverBox  popover-success"
                                                      data-content="با زدن این دکمه ،کادری برای شما باز میشود که می توانید توضیحات خود را نوشته و در خواست خود را به سمت کارگزار هدایت کنید">

                                               <a onclick="ShowModalConfirmCancel('{$item.RequestNumber}', '{$item.id}'); return false"
                                                  class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-check "
                                                  id="RequestMember-{$item.id}" data-toggle="modal"
                                                  data-target="#ModalPublic"></a>
                                            </span>
                                                <span id="FailedCancelRequestUser-{$item.id}" title="  رد درخواست کاربر"
                                                      data-toggle="popover" data-placement="top"
                                                      class="popoverBox  popover-danger"
                                                      data-content="شما می توانید با زدن این دکمه در کادر باز شده درخواست را رد نموده و در صورت تمایل دلیل آن را برای کاربر شرح دهید  ">

                                                        <a onclick="ShowModalFailedCancel('{$item.RequestNumber}', '{$item.id}')"
                                                           id="FailedCancel-{$item.id}"
                                                           class="fcbtn btn btn-outline btn-danger btn-1c mdi mdi-close "
                                                           data-toggle="modal" data-target="#ModalPublic"
                                                        ></a>

                                            </span>
                                            {elseif $item.Status eq 'SetCancelClient'}
                                                <a class="fcbtn btn btn-outline  popoverBox  popover-danger btn-danger btn-1c mdi  mdi-do-not-disturb"
                                                   title="رد درخواست توسط آژانس"
                                                   data-toggle="popover" data-placement="top"
                                                   data-content="شما قبلا این در خواست را رد کرده اید،برای اقدام مجدد ،می بایستی کاربر خریدار مجددا اقدام به ارسال درخواست کنسلی نماید"></a>
                                            {elseif $item.Status eq 'RequestClient'}
                                                <a class="fcbtn btn btn-outline  popoverBox  popover-warning btn-warning btn-1c mdi  mdi-autorenew"
                                                   title="در حال بررسی توسط کارگزار"
                                                   data-toggle="popover" data-placement="top"
                                                   data-content="درخواست شما به سمت کارگزار هدایت شده است،منتظر اعلام پاسخ باشید"></a>
                                            {elseif $item.Status eq 'SetIndemnity'}
                                                <a onclick="ConfirmAgencyForPercent('{$item.RequestNumber}', '{$item.id}', '{$item.TypeCancel}') ; return false"
                                                   class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-check-circle-outline popoverBox  popover-success"
                                                   data-placement="top"
                                                   title="تایید درصد تعیین شده توسط کارگزار"
                                                   data-toggle="popover" id="ConfirmPercent-{$item.id}"
                                                   data-content=" درصد جریمه برای این درخواست از سمت کارگزار {$item.PercentIndemnity}%  تعیین شده است ،شما میتوانید با زدن این دکمه این در صد را تایید کرده ،تا مراحل بعدی اجرائی شود"></a>
                                                <span data-toggle="modal" data-target="#ModalPublic">
                                                <a onclick="FailedAgencyForPercent('{$item.RequestNumber}', '{$item.id}')"

                                                   class="fcbtn btn btn-outline btn-danger btn-1c mdi mdi-close-circle popoverBox  popover-danger"
                                                   data-placement="top" title="رد درصد تعیین شده توسط کارگزار"
                                                   data-toggle="popover" id="FailedPercent-{$item.id}"
                                                   data-content=" با زدن این دکمه مراحل کنسلی متوقف شده ،و می بایستی برای اقدام مجدد،کاربر مجددا درخواست داده و مراحل طی شود"></a>
                                              </span>
                                            {elseif $item.Status eq 'ConfirmClient' }
                                                <div class="fcbtn btn btn-outline btn-info btn-1c mdi mdi-timer popoverBox  popover-info"
                                                     style="cursor:context-menu" data-placement="top"
                                                     data-toggle="popover" title="انتظار تایید نهایی"
                                                     data-content=" شما در صد اعلامی از سوی کارگزار را تایید کرده اید،لطفا  منتظر تایید نهایی باشید">

                                                </div>
                                            {elseif $item.Status eq 'SetFailedIndemnity' }
                                                <div class="fcbtn btn btn-outline btn-danger btn-1c mdi mdi-close-octagon-outline popoverBox  popover-danger"
                                                     style="cursor:context-menu"
                                                     data-toggle="popover" title="رد درصد توسط آژانس" data-placement="top"
                                                     data-content=" شما در صد اعلامی از سوی کارگزار را رد کرده اید">

                                                </div>
                                            {elseif $item.Status eq 'ConfirmCancel' }
                                                <div class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-bookmark-check popoverBox  popover-success"
                                                     data-placement="top" style="cursor:context-menu"
                                                     data-toggle="popover" title="تایید نهایی"
                                                     data-content="این درخواست از سوی کارگزار به تایید نهایی رسیده">
                                                </div>
                                            {/if}
                                            {*/if*}

                                        {/if}


                                    </td>
                                {/if}
                                <td>
                                    {if $typeFlight eq 'reservation'}

                                        {if $item.Status eq 'RequestMember'}
                                            <div class="btn btn-primary" disabled="disabled" style="cursor: context-menu;"
                                                 id="RequestMemberText-{$item.id}">درخواست کاربر
                                            </div>
                                        {elseif $item.Status eq 'ConfirmCancel'}
                                            <div class="btn btn-success" disabled="disabled" style="cursor: context-menu;">تایید نهایی</div>
                                        {/if}

                                    {else}

                                        {if $item.Status eq 'RequestMember'}
                                            <div class="btn btn-primary" disabled="disabled" style="cursor: context-menu;"
                                                 id="RequestMemberText-{$item.id}">درخواست
                                                کاربر
                                            </div>
                                        {elseif $item.Status eq 'SetCancelClient'}
                                            <div class="btn btn-danger" disabled="disabled" style="cursor: context-menu;">رد
                                                درخواست
                                                کاربر
                                            </div>
                                        {elseif $item.Status eq 'RequestClient'}
                                            <div class="btn btn-warning" disabled="disabled" style="cursor: context-menu;">در انتظار تعیین درصد </div>
                                        {elseif $item.Status eq 'SetIndemnity'}
                                            <div class="btn btn-warning btn-percent" disabled="disabled"
                                                 id="ConfirmPercentBtn-{$item.id}" style="cursor: context-menu;">تعیین درصد جریمه</div>
                                        {elseif $item.Status eq 'ConfirmClient' }
                                            <div class="btn btn-info btn-confirmClient " disabled="disabled"
                                                 style="cursor: context-menu;">در انتظار واریز تامین کننده
                                            </div>
                                        {elseif $item.Status eq 'SetFailedIndemnity' }
                                            <div class="btn btn-danger" disabled="disabled" style="cursor: context-menu;">رد
                                                درصد
                                                توسط آژانس
                                            </div>
                                        {elseif $item.Status eq 'close' }
                                            <div id="SetFailedIndemnity" class="btn btn-danger cursor-default" disabled="disabled">بسته شد</div>

                                        {elseif $item.Status eq 'ConfirmCancel'}
                                            {if ($item.pid_private eq '0' and $item.TypeCancel eq 'flight') || ($item.type_application neq 'reservation' and $item.TypeCancel eq 'hotel')}
                                                <div class="btn btn-success" disabled="disabled" style="cursor: context-menu;">تایید شده</div>
                                            {/if}
                                            {if $item.confirmTransferWallet eq 'none' && $item.backCredit eq 'on' }
                                                {*                                            <div class="btn btn-primary"   onclick="ModalConfirmAdminReturnUserWallet('{$item.RequestNumber}', '{$item.id}' , '{$item.PriceIndemnity}' , '{$item.MemberId}');return false" disabled="disabled" style="cursor: context-menu; background-color: #53e69d;border: 1px solid #53e69d; margin-top:2px">انتقال به کیف پول</div>*}
                                                <div class="btn btn-primary"   onclick="ModalConfirmAdminReturnUserWallet('{$item.RequestNumber}', '{$item.id}'  , '{$item.MemberId}');return false" disabled="disabled"  data-toggle="modal"
                                                     data-target="#ModalPublic" style="cursor: context-menu; background-color: #53e69d;border: 1px solid #53e69d; margin-top:2px">انتقال به کیف پول</div>

                                                <div class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-bookmark-check popoverBox  popover-success"
                                                     onclick="ModalConfirmAdminForReturnBank('{$item.RequestNumber}', '{$item.id}', '{$item.MemberId}' ,'{$item.TypeCancel}') ; return false"
                                                     data-placement="top" style="cursor:context-menu; margin-top:3px" data-toggle="popover"
                                                     title="" data-content="در صورتی که کاربر تلفنی درخواست خود را تغییر داده می توانید از این گزینه استفاده نموده و تایید نمایید که پول به حساب کاربر برگشت داده شده است"
                                                     data-original-title="بازگشت به حساب کاربر">
                                                </div>
                                            {elseif  ($item.confirmTransferWallet eq 'ReturnWallet' || $item.confirmTransferWallet eq 'ReturnWalletCounter' ||  $item.confirmTransferWallet eq 'ReturnBankCart') && $item.backCredit eq 'on'}
                                                {if $item.confirmTransferWallet eq 'ReturnWallet'}
                                                    <div class="btn btn-info" disabled="disabled" style="cursor: context-menu;font-size:10px ; margin-top:2px">به کیف پول کاربر برگردانده شد</div>
                                                {elseif $item.confirmTransferWallet eq 'ReturnWalletCounter'}
                                                    <div class="btn btn-info" disabled="disabled" style="cursor: context-menu;font-size:10px ; margin-top:2px">به اعتبار کانتر برگردانده شد</div>
                                                {elseif $item.confirmTransferWallet eq 'ReturnBankCart'}
                                                    <div class="btn btn-info" disabled="disabled" style="cursor: context-menu;font-size:10px ; margin-top:2px">به درخواست کاربر به کارت واریز شد</div>
                                                {else}
                                                    {*                                                 <div class="btn btn-info" disabled="disabled" style="cursor: context-menu;font-size:10px ; margin-top:2px">به کیف پول کاربر برگردانده شد</div>*}
                                                {/if}

                                            {/if}
                                        {/if}


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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش سوابق کنسلی کاربران</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/369/--.html" target="_blank" class="i-btn"></a>

</div>
{literal}
    <style>
        #myTable td:nth-child(4),
        #myTable td:nth-child(10),
        #myTable td:nth-child(11)
        {
            direction: rtl;
            text-align: right !important;
        }
        .fcbtn {
            padding: 3px 20px !important;
        }
        .fa-file-pdf-o:before {
            content: "\f1c1";
            font-size: 13px !important;
        }
    </style>
{/literal}

<script type="text/javascript" src="assets/JsFiles/listCancelUser.js"></script>
