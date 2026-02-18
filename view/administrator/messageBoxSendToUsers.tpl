{load_presentation_object filename="message" assign="objMessage"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="messageBoxAdmin"> لیست پیام</a></li>
                <li>تنظیمات</li>
                <li class="active">ارسال پیام</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ارسال پیام </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید پیام جدیدی را برای مشتریان خود ارسال
                    نمائید</p>

                <form id="sendMessage" method="post">
                    <input type="hidden" name="flag" value="sendMessage">

                    <div class="form-group ">

                        <label for="title" class="control-label">عنوان پیام</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="عنوان را وارد نمائید">
                    </div>
                    <div class="form-group ">
                        <label for="message" class="control-label">متن پیام</label>
                        <textarea id="message" name="message" class="form-control"
                                  placeholder="متن پیام  را وارد نمائید"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pre-selected-options" class="control-label">نام مشتری
                            <small>(شما می توانید برای ارسال به چند مشتری،از ستون سمت چپ مشتریان مورد نظر خود را انتخاب
                                نمائید و برای انتخاب همه از دکمه زیر استفاده نمائید)
                            </small>
                        </label>
                        <select id='pre-selected-options' multiple='multiple' name="ClientId[]">

                            {foreach $objFunctions->clients() as $client}
                            {if $client['id'] neq '1'}
                            <option value="{$client['id']}">{$client['AgencyName']}</option>
                            {/if}
                            {/foreach}

                        </select>
                        <div class="button-box m-t-20"><a id="select-all" class="btn btn-danger btn-outline" href="#">انتخاب
                            همه</a></div>


                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/messageAdmin.js"></script>

