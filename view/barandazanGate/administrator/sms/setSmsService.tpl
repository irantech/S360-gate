{load_presentation_object filename="smsPanel" assign="objSms"}
{assign var="allServices" value=$objSms->getAllSmsServices()} {*گرفتن لیست سرویس های پیامکی*}
{assign var="serviceInfo" value=$objSms->getSmsService($smarty.get.id)} {*گرفتن لیست سرویس های پیامکی*}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تنظیم پنل پیامک</li>
                {if $smarty.get.id neq ''}
                    <li class="">{$objFunctions->ClientName($smarty.get.id)}</li>
                {/if}
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
                <h3 class="box-title m-b-0">تنظیم پنل پیامک</h3>
                <p class="text-muted m-b-30">شما از طریق فرم زیر می توانید اطلاعات پنل پیامک را با توجه به سرویس انتخابی وارد نمایید</p>

                <form data-toggle="validator" id="setSmsService" method="post">
                    <input type="hidden" name="flag" value="setSmsService" />
                    <input type="hidden" name="clientID" id="clientID" value="{$smarty.get.id}" />

                    <div class="form-group col-sm-6 ">
                        <label for="smsService" class="control-label">سرویس پیامک</label>
                        <select name="smsService" id="smsService" class="form-control select2">
                            <option value="">سرویس پیامک را انتخاب نمائید</option>
                            {foreach $allServices as $service}
                                <option value="{$service.panelService}" {if $serviceInfo['smsService'] eq $service.panelService}selected="selected"{/if}>{$service.title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="smsUsername" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" id="smsUsername" name="smsUsername" value="{$serviceInfo['smsUsername']}"
                               placeholder="نام کاربری سرویس پیامک را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="smsPassword" class="control-label">رمز عبور</label>
                        <input type="text" class="form-control" id="smsPassword" name="smsPassword" value="{$serviceInfo['smsPassword']}"
                               placeholder="رمز عبور سرویس پیامک را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="smsNumber" class="control-label">شماره ارسال</label>
                        <input type="text" class="form-control" id="smsNumber" name="smsNumber" value="{$serviceInfo['smsNumber']}"
                               placeholder="شماره ارسال سرویس پیامک را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="token" class="control-label">توکن </label>
                        <input type="text" class="form-control" id="token" name="token" value="{$serviceInfo['token']}"
                               placeholder="توکن ارسال سرویس پیامک را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="isActive" class="control-label">وضعیت سرویس پیامک</label>
                        <select name="isActive" id="isActive" class="form-control select2">
                            <option value="1" {if $serviceInfo['isActive'] eq 1}selected="selected"{/if}>فعال</option>
                            <option value="0" {if $serviceInfo['isActive'] eq 0}selected="selected"{/if}>غیر فعال</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="control-label">پترن اس ام اس</label>
                        <div class="row">

                            <div class="form-group col-sm-12 Dynamicpattern">




                                {assign var="sms_paterns" value=['verification_code','one_time_password','forget_password' , 'confirm_requested_hotel' ,'hotel_book_pattern_sms' ,'hotel_preReserve_payment_pattern_sms' ,'hotel_reserve_payment_pattern_sms','hotel_request_confirm_pattern_sms','hotel_request_no_confirm_pattern_sms','hotel_reserve_payment_manager_pattern_sms' ]}
                                {assign var="counter" value='0'}
                                {if $serviceInfo['patternCode'] eq ''}
                                    {$serviceInfo['patternCode'] = '[{"title":"","pattern":""}]'}
                                {/if}
                                {foreach item=item from=$serviceInfo['patternCode']|json_decode:true}

                                    <div data-target="BasepatternDiv" class="col-sm-12 p-0 form-group">
                                        <div class="col-md-3 pr-0">
                                            <select data-parent="patternValues" data-target="title" class="form-control" name="pattern[{$counter}][title]">
                                                <option>انتخاب کنید</option>
                                                {foreach $sms_paterns as $pattern}
                                                    <option {if $item['title'] == $pattern}selected{/if} value="{$pattern}">{$pattern}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input data-parent="patternValues" data-target="pattern" name="pattern[{$counter}][pattern]" placeholder="pattern" class="form-control text-right"
                                                   value="{$item.pattern}" type="text">
                                        </div>
                                        <div class="col-md-1 pl-0">
                                            <div class="col-md-6 p-0">
                                                <button type="button" onclick="Addpattern()" class="btn form-control btn-success">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                            </div>
                                            <div class="col-md-6 p-0">
                                                <button onclick="Removepattern($(this))" type="button" class="btn form-control btn-danger">
                                                    <span class="fa fa-remove"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {assign var="counter" value=$counter+1}
                                {/foreach}

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/smsPanel.js"></script>