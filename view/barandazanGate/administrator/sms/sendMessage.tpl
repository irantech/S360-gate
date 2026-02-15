{load_presentation_object filename="smsPanel" assign="objSms"}
{assign var="messagesList" value=$objSms->allMessages('1')} {* پیام ها *}
{assign var="groupsList" value=$objSms->getManualReceiverGroups()} {* گروه های ارسال *}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>پنل پیامکی</li>
                <li class="active">ارسال پیامک</li>
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
                <h3 class="box-title m-b-0">ارسال پیام</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید با توجه به دسته بندی های متفاوت به افراد مورد نظر پیامک ارسال نمائید</p>

                <form data-toggle="validator" id="messageSend" method="post">
                    <input type="hidden" name="flag" value="messageSend">

                    <div class="form-group col-sm-6 ">
                        <label for="smsReceiver" class="control-label">ارسال به</label>
                        <select id="smsReceiver" name="smsReceiver" class="form-control select2">
                            <option value="">گروه دریافت کنندگان را انتخاب نمائید</option>
                            {foreach $groupsList as $key => $group}
                                <option value="{$key}">{$group}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="smsMessage" class="control-label">پیام</label>
                        <select id="smsMessage" name="smsMessage" class="form-control select2">
                            <option value="">پیام مورد نظر را انتخاب نمائید</option>
                            {foreach $messagesList as $key => $message}
                                <option value="{$message.id}">{$message.title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6 showCustom" style="display: none;">
                        <label for="smsNumber" class="control-label">گیرنده (در صورت ورود چند شماره، آنها را با سمی کالن ; از هم جدا کنید)</label>
                        <input class="form-control text-right" id="smsNumber" name="smsNumber"
                                  placeholder="شماره گیرنده را وارد نمائید" />
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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش ارسال پیامک</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/401/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/smsPanel.js"></script>