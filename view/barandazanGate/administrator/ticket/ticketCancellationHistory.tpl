{if $smarty.const.TYPE_ADMIN eq 1}
    {load_presentation_object filename="listCancel" assign="objCancel"}


    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>گزارش خرید</li>
                    <li class="active">سوابق کنسلی خرید</li>
                </ol>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">جستجوی سوابق کنسلی </h3>

                    <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                        کنید
                    </p>

                    <form id="SearchTicketHistory" method="post"
                          action="{$smarty.const.rootAddress}ticketCancellationHistory">

                        <div class="form-group col-sm-6 ">
                            <label for="date_of" class="control-label">تاریخ شروع</label>
                            <input type="text" class="form-control datepicker" name="date_of" value="{$smarty.post.date_of}"
                                   id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="to_date" class="control-label">تاریخ پایان</label>
                            <input type="text" class="form-control datepickerReturn" name="to_date"
                                   value="{$smarty.post.to_date}" id="to_date"
                                   placeholder="تاریخ پایان جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="Status" class="control-label">وضعیت کنسلی</label>
                            <select name="Status" id="Status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="RequestClient" {if $smarty.post.Status eq 'RequestClient' }selected{/if}>
                                    در انتظار تعیین درصد
                                </option>
                                <option value="SetIndemnity" {if $smarty.post.Status eq  'SetIndemnity' }selected{/if}>نعیین
                                    درصد کنسلی
                                </option>
                                <option value="ConfirmClient" {if $smarty.post.Status eq 'ConfirmClient' }selected{/if}>
                                    در حال رسیدگی و واریز
                                </option>
                                <option value="SetFailedIndemnity"
                                        {if $smarty.post.Status eq 'SetFailedIndemnity' }selected{/if}>رد درصد کنسلی از سمت
                                    آژانس
                                </option>
                                <option value="ConfirmCancel" {if $smarty.post.Status eq 'ConfirmCancel' }selected{/if}>
                                    واریز شد
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="RequestNumber" class="control-label">کد واچر</label>
                            <input type="text" class="form-control " name="RequestNumber"
                                   value="{$smarty.post.RequestNumber}" id="RequestNumber"
                                   placeholder="کد واچر را وارد نمائید">

                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right" >شروع جستجو</button>
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
                    <div class="mt-3 p-0 col-sm-1 float-left text-center">
                        <div class="form-group">
                            <label for="AutoRefreshInput">نرخ تازه سازی (ثانیه)</label>
                            <input type="number" min="5" class="form-control" value="0" id="AutoRefreshInput"
                                   placeholder="~ 20">

                        </div>
                    </div>
                    <a class="table-responsive" >
                        <table id="myTable" class="table table-striped text-center">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>آژانس</th>
                                <th>دلیل درخواست</th>
                                <th>شماره رزرو</th>
                                <th>نوع درخواست
                                </th>
                                <th>نام سرور</th>
                                <th>تاریخ در خواست کاربر</th>
                                <th>تاریخ ارسال به کارگزار</th>
                                <th>تاریخ تایید/رد درخواست</th>
                                <th>درصد جریمه</th>
                                <th style="width: 100px;">مبلغ استرداد</th>
                                <th style="width: 150px;">عملیات</th>
                                <th>وضعیت درخواست</th>


                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {assign var="Db_Nf_Checked" value=[]}
                            {foreach key=key item=item from=$objCancel->ListCancelAdmin()}
                                {$number=$number+1}
                                {if !in_array($item.InfoRecord, $Db_Nf_Checked)}
                                    {append var="Db_Nf_Checked" value=$item.InfoRecord}
                                    {assign var="isFirstForCancel" value=true}
                                {else}
                                    {assign var="isFirstForCancel" value=false}
                                {/if}

                                <tr id=""  {if $item.is_past eq 1}style="background-color:#f6db004f !important; color: #453B3B;" {/if}>
                                    <td style='background-color:{$item.color}'>{$number}</td>
                                    <td><a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/itadmin/transactionUser&id={$item.ClientId}">{$item.AgencyName}</a></td>
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
                                            ----
                                        {/if}
                                    </td>
                                    <td style="text-align:right !important;">

                                        <!-- شماره رزرو -->
                                        <a onclick="ModalShowBook('{$item.RequestNumber}','{$item.TypeCancel}');return false"
                                           data-toggle="modal"
                                           data-target="#ModalPublic"
                                           class="btn btn-info yn"
                                           style="
                                       padding:9px 14px !important;
                                       margin-bottom:8px;
                                       display:inline-block;
                                   ">
                                            {$item.RequestNumber}
                                        </a>

                                        <!-- ردیف PNR + COPY -->
                                        <div style="
                                                display: flex;
                                                flex-direction: row-reverse;
                                                justify-content: flex-end;
                                                align-items: center;
                                                gap: 6px;
                                                margin-top: 6px;

                                        ">

                                            <!-- COPY -->
                                            <a onclick="myFunctionCopyTextFara{$item.id}()"
                                               class="fcbtn btn btn-outline btn-info mdi mdi-content-copy"
                                               style="
                                               width:44px;
                                               height:40px;
                                               display:flex;
                                               align-items:center;
                                               justify-content:center;
                                               padding:0;
                                           ">
                                            </a>

                                            <!-- PNR -->
                                            <div style="
                                                        width:100px;
                                                        height:40px;
                                                        background:#2cabe3;
                                                        color:#fff;
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:center;
                                                        border-radius:4px;
                                                        font-weight:500;
                                                        font-size:13px;
                                                        user-select:all;
                                                    "
                                                 id="myInput{$item.id}">
                                                {$item.pnr}
                                            </div>

                                        </div>

                                        <script>
                                           function myFunctionCopyTextFara{$item.id}() {
                                              const text = document.getElementById("myInput{$item.id}").innerText;
                                              navigator.clipboard.writeText(text);
                                              alert("Copied: " + text);
                                           }
                                        </script>

                                    </td>


                                    <td>
                                        {if $item.TypeCancel eq 'flight' || $item.TypeCancel eq '' }
                                            پرواز-
                                            {if $objFunctions->TypeFlight($item.RequestNumber) eq 'PrivateSystem'}
                                                سیستمی اختصاصی

                                            {elseif $objFunctions->TypeFlight($item.RequestNumber) eq 'PublicSystem'}
                                                سیستمی اشتراکی
                                            {elseif $objFunctions->TypeFlight($item.RequestNumber) eq 'charter'}
                                                چارتری
                                            {/if}
                                        {elseif $item.TypeCancel eq 'train'}
                                            قطار
                                        {elseif $item.TypeCancel eq 'bus'}
                                            اتوبوس
                                        {elseif $item.TypeCancel eq 'hotel'}
                                            هتل
                                        {elseif $item.TypeCancel eq 'insurance'}
                                            بیمه
                                        {/if}

                                    </td>
                                    <td>
                                        {if $item.TypeCancel eq 'flight' || $item.TypeCancel eq '' }
                                            {$item.provider_name}
                                        {elseif $item.TypeCancel eq 'bus'}
                                            اتوبوس
                                        {elseif $item.TypeCancel eq 'bus'}
                                            هتل
                                        {elseif $item.TypeCancel eq 'train'}
                                            قطار
                                        {elseif $item.TypeCancel eq 'insurance'}
                                            بیمه
                                        {/if}
                                    </td>
                                    <td dir="ltr" class="text-left">
                                        {$objDate->jdate('Y-m-d (H:i:s)', $item.DateRequestMemberInt)}
                                        <hr/>
                                        {$objDate->jdate('l', $item.DateRequestMemberInt)}
                                    </td>
                                    <td dir="ltr" class="text-left">
                                        {if $item.DateRequestCancelClientInt neq '0'} {$objDate->jdate('Y-m-d (H:i:s)', $item.DateRequestCancelClientInt)}
                                            <hr/>
                                            {$objDate->jdate('l', $item.DateRequestCancelClientInt)}

                                        {else}---{/if}
                                    </td>
                                    <td dir="ltr" class="text-left">
                                        {if $item.DateSetCancelInt neq '0' || $item.DateConfirmClientInt neq '0' ||
                                        $item.DateSetFailedIndemnityInt neq '0'}

                                            {if $item.Status eq 'SetCancelClient'}

                                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateSetCancelInt)}
                                                <hr/>
                                                {$objDate->jdate('l', $item.DateSetCancelInt)}

                                            {elseif $item.Status eq 'ConfirmClient'}

                                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateConfirmClientInt)}
                                                <hr/>
                                                {$objDate->jdate('l', $item.DateConfirmClientInt)}
                                            {elseif $item.Status eq 'SetFailedIndemnity'}
                                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateSetFailedIndemnityInt)}
                                                <hr/>
                                                {$objDate->jdate('l', $item.DateSetFailedIndemnityInt)}
                                            {/if}


                                        {else}
                                            -----
                                        {/if}
                                    </td>
                                    {if $isFirstForCancel}
                                        <td>
                                            {if $item.Status eq 'SetIndemnity' || $item.Status eq 'ConfirmClient' ||
                                            $item.Status eq 'SetFailedIndemnity' || $item.Status eq 'ConfirmCancel' &&
                                            ($item.ReasonMember neq 'DelayTwoHours' || $item.ReasonMember neq 'CancelByAirline')}
                                                {if $item.TypeCancel eq 'flight' && $item.IsInternal neq '1' }
                                                    -----
                                                {else}
                                                    <span class="yn">
                                            <input class="form-control media03" value="{$item.PercentIndemnity}" name="changePercentIndemnity" id="changePercentIndemnity{$item.ClientId}{$item.id}" onchange="changePercentIndemnity('{$item.id}','{$item.ClientId}')">
                                            <div class="media04">%</div>
                                            </span>

                                                {/if}
                                            {else}
                                                -----
                                            {/if}
                                        </td>
                                        <td>

                                            {if $item.PriceIndemnity neq ''}
                                                <span class="yn">{$item.PriceIndemnity|number_format} &nbsp;ریال</span>
                                            {else}
                                                -----
                                            {/if}
                                        </td>
                                        <td>

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



                                                    {if $item.Status eq 'RequestClient'}
<!--                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                                <span data-toggle="popover" title="ارسال درخواست از سمت آژانس" data-placement="top"
                                                                      data-content="درخواست از سمت آژانس ارسال شده است،لطفا برای اعلام درصد بر روی دکمه زیر کلیک نمائید"
                                                                      class="popoverBox  popover-warning">
                                                                    <a class="fcbtn btn btn-outline btn-warning btn-1c  popover-warning mdi mdi-percent cursor-default"
                                                                       data-toggle="modal" data-target="#ModalPublic"
                                                                       onclick="ShowModalPercent('{$item.RequestNumber}','{$item.IdDetail}','{$item.ClientId}','{$item.TypeCancel}')"
                                                                       id="RequestClientBtn-{$item.IdDetail}"></a>
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </li>-->
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
                                                                       onclick="FinalConfirm('{$item.RequestNumber}','{$item.IdDetail}','{$item.ClientId}','{$item.pnr}')">
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
                                                    <li>
                                                        <div class="pull-left">
                                                            <div class="pull-left margin-10">
                                                                <a class="fcbtn btn btn-outline btn-info btn-1c cursor-default"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalPublic"
                                                                   title="Note"
                                                                   data-placement="top"
                                                                   data-content="یادداشت"
                                                                   onclick="showModalNote('{$item.id}', '{$item.ClientId}', '{$item.note_admin|escape:'javascript'}')">
                                                                    یادداشت
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="pull-left">
                                                            <div class="pull-left margin-10">
                                                                <a class="fcbtn btn btn-outline btn-danger btn-1c cursor-danger"
                                                                   onclick="setExpireTime('{$item.id}', '{$item.ClientId}')">  خارج از تایم
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>


                                        </td>
                                        <td class="align-middle">
                                            {if $item.Status eq 'RequestMember'}
                                                <div class="btn btn-primary cursor-default" disabled="disabled"
                                                     id="RequestMember">درخواست
                                                    کاربر
                                                </div>
                                            {elseif $item.Status eq 'SetCancelClient'}
                                                <div id="SetCancelClient" class="btn btn-danger cursor-default"
                                                     disabled="disabled"
                                                >
                                                    رد
                                                    درخواست
                                                    کاربر
                                                </div>
                                            {elseif $item.Status eq 'RequestClient'}
                                                <div id="RequestClientStatus-{$item.id}" class="btn btn-danger cursor-default"
                                                     disabled="disabled"
                                                >درصد کنسلی را مشخص نمایید</div>
                                            {elseif $item.Status eq 'SetIndemnity'}
                                                <div id="SetIndemnityId" class="btn btn-warning btn-percent cursor-default"
                                                     disabled="disabled"
                                                >
                                                    جریمه مشخص شد / منتظر تایید آژانس

                                                </div>
                                            {elseif $item.Status eq 'ConfirmClient' }
                                                <div id="ConfirmClientStatus-{$item.id}" class="btn btn-info cursor-default"
                                                     disabled="disabled"
                                                >آژانس تایید کرد / واریز کنید</div>
                                            {elseif $item.Status eq 'SetFailedIndemnity' }
                                                <div id="SetFailedIndemnity" class="btn btn-danger cursor-default"
                                                     disabled="disabled"
                                                >
                                                    آژانس رد کرد / واریز نکنید
                                                </div>
                                            {elseif $item.Status eq 'close' }
                                                <div id="SetFailedIndemnity" class="btn btn-danger cursor-default"
                                                     disabled="disabled">بسته شده
                                                </div>
                                            {elseif $item.Status eq 'ConfirmCancel'}
                                                <div id="ConfirmCancel" class="btn btn-success cursor-default"
                                                     disabled="disabled">واریز شد
                                                </div>
                                            {/if}

                                            {if $item.note_admin|trim neq ''}
                                                <div class="admin-note mt-2 px-2 py-1">
                                                    {$item.note_admin}
                                                </div>
                                            {else}
                                                <div class="admin-note mt-2 px-2 py-1"
                                                     style="
                                                    display:flex;
                                                    align-items:center;
                                                    justify-content:center;
                                                    color:#000;
                                                    font-weight:bold;
                                                    font-size: 14px;
                                                 ">
                                                    <i class="fa fa-exclamation-triangle"
                                                       style="color:#dc3545; font-size:20px;"
                                                       title="یادداشت بگذارید"></i>
                                                    یادداشت بگذارید

                                                </div>
                                            {/if}


                                        </td>
                                    {else}
                                        <td style="color:#ccc;">&#8211;</td>
                                        <td style="color:#ccc;">&#8211;</td>
                                        <td style="color:#ccc;">&#8211;</td>
                                        <td style="color:#ccc;">&#8211;</td>
                                    {/if}
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

    </div>
{literal}
    <style>
        .align-middle {
            vertical-align: baseline !important;
        }
    </style>
{/literal}

    <script type="text/javascript" src="assets/JsFiles/listCancel.js"></script>


    <script>



       $(document).ready(function () {
          var interval = null;
          $('#AutoRefreshInput').change(function () {
             clearInterval(interval);
             var thiss = $(this);
             if(thiss.val() == '0'){
                clearInterval(interval);
             }
             if(thiss.val() >= '5')
             {
                interval = setInterval(function () {
                   // document.getElementById("btnClickAotu").click();
                   $("#myTable").load(window.location.href + " #myTable");
                }, thiss.val() * 1000);
             }
             if(thiss.val() <= '5' && thiss.val() != 0)
             {
                thiss.val(5);
                clearInterval(interval);
                interval = setInterval(function () {
                   // document.getElementById("btnClickAotu").click();
                   $("#myTable").load(window.location.href + " #myTable");
                }, thiss.val() * 1000);
             }
          });




       });

    </script>
{/if}