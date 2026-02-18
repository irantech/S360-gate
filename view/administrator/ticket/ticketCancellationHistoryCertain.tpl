{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="listCancel" assign="objCancel"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}

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
                      action="{$smarty.const.rootAddress}ticketCancellationHistoryCertain">


                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع</label>
                        <input type="text"
                               class="form-control datepicker" name="date_of" value="{if isset($smarty.post.date_of)}{$smarty.post.date_of}{else}{$objDateTimeSetting->jdate("Y-m-d", strtotime('-7 day'), '', '', 'en')}{/if}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{if isset($smarty.post.date_of)}{$smarty.post.to_date}{else}{$objDateTimeSetting->jdate("Y-m-d", time(), '', '', 'en')}{/if}" id="to_date"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">

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
                <h3 class="box-title m-b-0">سوابق کنسلی تایید شده </h3>
                <p class="text-muted m-b-30">کلیه سوابق را در این لیست میتوانید مشاهده کنید
                </p>
                <a class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>آژانس</th>
                            <th>دلیل درخواست</th>
                            <th>شماره رزرو</th>
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
                        {foreach key=key item=item from=$objCancel->ListCancelAdminCertain()}
                        {$number=$number+1}
                        <tr id="">
                            <td>{$number}</td>
                            <td>{$item.AgencyName}</td>
                            <td>
                                {if $item.ReasonMember eq 'PersonalReason'}
                                کنسلی به دلیل شخصی
                                {else if $item.ReasonMember eq 'DelayTwoHours'}
                                تاخیر بیش از 2 ساعت
                                     {else if $item.ReasonMember eq 'CancelByAirline'}
                               لغو توسط ایرلاین
                                {/if}
                            </td>
                            <td>
                                        <span data-toggle="popover" title="مشاهده خرید" data-placement="top"
                                              data-content="برای مشاهده خرید کلیک کنید"
                                              class="popoverBox  popover-info">
                                            <a onclick="ModalShowBook('{$item.RequestNumber}','{$item.TypeCancel}');return false"
                                               data-toggle="modal" data-target="#ModalPublic" class="btn btn-info yn">
                                                {$item.RequestNumber}
                                            </a>
                                        </span>
                            </td>

                            <td dir="ltr" class="text-left">
                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateRequestMemberInt)}
                            </td>
                            <td dir="ltr" class="text-left">
                                {if $item.DateRequestCancelClientInt neq '0'} {$objDate->jdate('Y-m-d (H:i:s)', $item.DateRequestCancelClientInt)} {else}---{/if}
                            </td>
                            <td dir="ltr" class="text-left">
                                {if $item.DateSetCancelInt neq '0' || $item.DateConfirmCancelInt neq '0' ||
                                $item.DateSetFailedIndemnityInt neq '0'}

                                {if $item.Status eq 'SetCancelClient'}

                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateSetCancelInt)}

                                {else if $item.Status eq 'ConfirmCancel'}

                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateConfirmCancelInt)}

                                {else if $item.Status eq 'SetFailedIndemnity'}

                                {$objDate->jdate('Y-m-d (H:i:s)', $item.DateSetFailedIndemnityInt)}
                                {/if}

                                {else}
                                -----
                                {/if}
                            </td>
                            <td>
                                {if $item.Status eq 'SetIndemnity' || $item.Status eq 'ConfirmClient' ||
                                $item.Status eq 'SetFailedIndemnity' || $item.Status eq 'ConfirmCancel'}
                               <span class="yn">{$item.PercentIndemnity}%</span>
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

                                {if $item.Status eq 'ConfirmCancel'}
                                    <span data-toggle="popover" data-placement="top" data-content="برای دریافت رسید کنسلی کلیک کنید"
                                      class="popoverBox  popover-info" data-original-title="رسید کنسلی">
                                        <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=parvazBookingLocal&id={$item.RequestNumber}&cancelStatus=confirm"
                                           class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                        </a>
                                    </span>
                                {/if}

                                <span data-toggle="popover" title="مشاهده جزئیات" data-placement="top"
                                      data-content="برای مشاهده جزئیات کلیک کنید" class="popoverBox  popover-primary">
                                            <a onclick="ModalTrackingCancelTicket('{$item.RequestNumber}', '{$item.ClientId}' , '{$item.IdDetail}');return false"
                                               data-toggle="modal" data-target="#ModalPublic"
                                               class="fcbtn btn btn-outline btn-primary btn-1c mdi mdi-eye cursor-default">

                                            </a>
                                        </span>

                                {if $item.Status eq 'RequestClient'}

                                <span data-toggle="popover" title="ارسال درخواست از سمت آژانس" data-placement="top"
                                      data-content="درخواست از سمت آژانس ارسال شده است،لطفا برای اعلام درصد بر روی دکمه زیر کلیک نمائید"
                                      class="popoverBox  popover-warning">
                                    <a class="fcbtn btn btn-outline btn-warning btn-1c  popover-warning mdi mdi-percent cursor-default"
                                       data-toggle="modal" data-target="#ModalPublic"
                                       onclick="ShowModalPercent('{$item.RequestNumber}','{$item.IdDetail}','{$item.ClientId}')"
                                       id="RequestClientBtn-{$item.IdDetail}"></a>
                                        </span>
                                {elseif $item.Status eq 'SetIndemnity'}
                                <a
                                        class="fcbtn btn btn-outline btn-warning btn-1c popoverBox  popover-warning mdi mdi-timer cursor-default"
                                        data-placement="top" title="انتظار برای پاسخ آژانس"
                                        data-toggle="popover"
                                        data-content=" در انتظار پاسخ آژانس بابت درصد اعلامی از سوی کارگزار"
                                        id="SetIndemnity-{$item.id}"></a>

                                {elseif $item.Status eq 'ConfirmClient' }
                                <span data-toggle="popover" title="واریز وجه"
                                      data-content=" درصد اعلامی از سوی شما ،با موافقت آژانس همراه بوده است ،لطفا برای واریز وجه دکمه زیر را فشار دهید "
                                      class="popoverBox  popover-info " data-placement="top">
                                    <a class="fcbtn btn btn-outline btn-info btn-1c  mdi mdi-bookmark-check cursor-default"  id="ConfirmClient-{$item.id}"
                                       data-toggle="modal" data-target="#ModalPublic"
                                       onclick="FinalConfirm('{$item.RequestNumber}','{$item.IdDetail}','{$item.ClientId}')">
                                    </a>
                                    </span>

                                {elseif $item.Status eq 'SetFailedIndemnity'}
                                <div class="fcbtn btn btn-outline btn-danger btn-1c cursor-default popoverBox  popover-danger mdi mdi-close-circle-outline "
                                     data-toggle="popover" title="رد درصد توسط آژانس" data-placement="top"
                                     data-content="آژانس درصد اعلامی را قبول نکرده و روند درخواست را متوقف کرده است">

                                </div>

                                {elseif $item.Status eq 'ConfirmCancel'}
                                <div class="fcbtn btn btn-outline btn-success btn-1c cursor-default popoverBox  popover-success mdi mdi-check"
                                     data-toggle="popover" title="واریز وجه درخواست" data-placement="top"
                                     data-content="درخواست نهایی شده و مبلغ مسترد شده است">
                                </div>
                                {/if}
                            </td>
                            <td class="align-middle">
                                {if $item.Status eq 'RequestMember'}
                                <div class="btn btn-primary cursor-default" disabled="disabled"
                                     id="RequestMember">درخواست
                                    کاربر
                                </div>
                                {elseif $item.Status eq 'SetCancelClient'}
                                <div id="SetCancelClient" class="btn btn-danger cursor-default" disabled="disabled"
                                     >رد
                                    درخواست
                                    کاربر
                                </div>
                                {elseif $item.Status eq 'RequestClient'}
                                <div id="RequestClientStatus-{$item.id}" class="btn btn-warning cursor-default" disabled="disabled"
                                     >ارسال
                                    درخواست
                                    به کارگزار
                                </div>
                                {elseif $item.Status eq 'SetIndemnity'}
                                <div id="SetIndemnityId" class="btn btn-warning btn-percent cursor-default" disabled="disabled"
                                     >تعیین
                                    درصد
                                    جریمه
                                </div>
                                {elseif $item.Status eq 'ConfirmClient' }
                                <div id="ConfirmClientStatus-{$item.id}" class="btn btn-info cursor-default" disabled="disabled"
                                    >تایید
                                    درصد
                                    توسط آژانس
                                </div>
                                {else if $item.Status eq 'SetFailedIndemnity' }
                                <div id="SetFailedIndemnity" class="btn btn-danger cursor-default" disabled="disabled"
                                     >
                                    رد درصد توسط آژانس
                                </div>
                                {elseif $item.Status eq 'close' }
                                    <div id="SetFailedIndemnity" class="btn btn-danger cursor-default" disabled="disabled">بسته شد</div>

                                {elseif $item.Status eq 'ConfirmCancel'}
                                <div id="ConfirmCancel" class="btn btn-success cursor-default" disabled="disabled">واریز شد
                                </div>
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


<script type="text/javascript" src="assets/JsFiles/listCancel.js"></script>
{/if}