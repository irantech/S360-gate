{load_presentation_object filename="bookshow" assign="objBookShow"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>سوابق</li>
                <li class="active">سوابق افزایش قیمت کانتر</li>
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
                <h3 class="box-title m-b-0">جستجوی سوابق کنسلی </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchIncreasePriceHistory" method="post"
                      action="{$smarty.const.rootAddress}logIncreasePrice">

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
                        <label for="factorNumber" class="control-label">شماره فاکتور</label>
                        <input type="text" class="form-control " name="factorNumber"
                               value="{$smarty.post.factorNumber}" id="factorNumber"
                               placeholder="شماره فاکتور را وارد نمائید">

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
                <!-- Tabstyle start -->
                <h3 class="box-title m-b-0">لیست افزایش قیمت بلیط توسط کانتر ها </h3>
                <hr>
                <section>
                    <div class="sttabs tabs-style-bar">
                        <nav>
                            <ul>
                                {*<li class="tab-current"><a href="#section-bar-1" class="sticon ti-home"><span>پرواز</span></a></li>*}
                             {*   <li class="" disabled="disabled"><a href="#section-bar-2" class="sticon ti-trash"><span>هتل</span></a></li>
                                <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li>*}
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>نام کانتر</th>
                                            <th>تعداد خرید</th>
                                            <th>شماره رزرو</th>
                                            <th>تاریخ خرید</th>
                                            <th>مبدا/مقصد</th>
                                            <th>تاریخ پرواز</th>
                                            <th>شماره فاکتور</th>
                                            <th>شماره pnr</th>
                                            <th>مبلغ افزایش داده شده</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {assign var="number" value="0"}
                                        {assign var="list" value=$objBookShow->listIncreasePriceCounterFLight()}
                                        {foreach key=key item=item from=$list}
                                            {$number=$number+1}
                                            <tr id="{$item.id}">

                                                <td>{$number}</td>
                                                <td>{$item.member_name}</td>
                                                <td>{$item.Count_request_number}</td>

                                                <td>{$item.request_number}</td>

                                                <td> {$objFunctions->showDate('Y-m-d (H:i:s)', $item.creation_date_int)}</td>

                                                <td>{$item.origin_city}/{$item.desti_city}</td>

                                                <td> {$objFunctions->format_hour($item.time_flight)}/{$objFunctions->DateJalali($item.date_flight)}</td>

                                                <td>{$item.factor_number}</td>

                                                <td>{$item.pnr}</td>

                                                <td>{$item.amount_added|number_format}ریال </td>

                                            </tr>
                                        {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                         {*   <section id="section-bar-2" class="">
                                <h2>Tabbing 2</h2></section>
                            <section id="section-bar-3" class="">
                                <h2>Tabbing 3</h2></section>
                            <section id="section-bar-4" class="">
                                <h2>Tabbing 4</h2></section>
                            <section id="section-bar-5" class="">
                                <h2>Tabbing 5</h2></section>*}
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->
                </section>

            </div>
        </div>

    </div>
</div>


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش سوابق افزایش قیمت کانتر   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/350/---.html" target="_blank" class="i-btn"></a>

</div>


<script type="text/javascript" src="assets/JsFiles/logInCreasePrice.js"></script>