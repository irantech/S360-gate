{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="LogSms" assign="objLogSms"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>سوابق</li>
                <li class="active">پیامک های
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    ارسال
                    {else}
                    دریافت
                    {/if}
                    شده </li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    ارسال
                    {else}
                    دریافت
                    {/if}
                    پیامک </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTicketHistory" method="post" action="{$smarty.const.rootAddress}logSms">

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

                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    <div class="form-group col-sm-6">
                        <label for="ClientId" class="control-label">نام همکار</label>
                        <select name="ClientId" id="ClientId" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objFunctions->AllClients() as $client }
                                {if $client.id > 1}
                                    <option value="{$client.id}" {if $smarty.post.ClientId eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                    {/if}
                    <div class="form-group col-sm-6">
                        <label for="Mobile" class="control-label">شماره موبایل</label>
                        <input type="text" class="form-control datepickerReturn" name="Mobile"
                               value="{$smarty.post.Mobile}" id="Mobile"
                               placeholder="شماره موبایل را وارد نمائید">

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
                <h3 class="box-title m-b-0">لیست سوابق پیام های
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    ارسال شده
                    {else}
                    دریافت شده
                    {/if}
                </h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست پیام هایی که  شما
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    ارسال
                    {else}
                    دریافت
                    {/if}
                    نموده اید را  مشاهده
                    نمائید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                            <th>نام آژانس</th>
                            {/if}
                            <th>شماره موبایل</th>
                            <th>شماره واچر</th>
                            <th>دلیل پیامک</th>
                            <th>تاریخ</th>
                            <th>مشاهده</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objLogSms->ListLogSms()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                            <td>{$item.AgencyName} </td>
                            {/if}
                            <td>{$item.Mobile}</td>
                            <td>           <span data-toggle="popover" title="مشاهده خرید" data-placement="top"
                                                 data-content="برای مشاهده خرید کلیک کنید"
                                                 class="popoverBox  popover-info">
                                            <a onclick="ModalShowBook('{$item.RequestNumber}');return false"
                                               data-toggle="modal" data-target="#ModalPublic" class="btn btn-info yn">

                                                {$item.RequestNumber}

                                            </a>
                                        </span></td>
                            <td>{if $item.Reason eq 'Delay'}
                                تاخیر
                                {elseif $item.Reason eq 'HurryUp'}
                                تعجیل
                                {elseif $item.Reason eq 'Cancel'}
                                کنسلی
                                {/if}
                            </td>
                            <td dir="ltr" class="text-left">{$objDate->jdate('Y-m-d (H:i:s)', $item.CreationDateInt)}</td>
                            <td>
                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                <a onclick="ModalShowLogSms('{$item.id}','{$item.ClientId}');return false"
                                   data-toggle="modal" data-target="#ModalPublic"
                                   style="margin: 5px 0;"  >
                                    <i class="fcbtn btn btn-outline btn-info btn-1f tooltip-info mdi mdi-eye"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده پیام" ></i>
                                </a>
                                {else}
                                <a onclick="ModalShowLogSms('{$item.id}','{$smarty.const.CLIENT_ID}');return false"
                                   data-toggle="modal" data-target="#ModalPublic"
                                   style="margin: 5px 0;"  >
                                    <i class="fcbtn btn btn-outline btn-info btn-1f tooltip-info mdi mdi-eye"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده پیام" ></i>
                                </a>
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

<script type="text/javascript" src="assets/JsFiles/Logsms.js"></script>
{/if}