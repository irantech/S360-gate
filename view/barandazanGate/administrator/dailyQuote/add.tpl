{load_presentation_object filename="dailyQuote" assign="objDailyQuote"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/dailyQuote/list">
                        لیست سخن روز
                    </a>
                </li>
                <li class="active">درج سخن روز جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_daily_quote" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertDailyQuote' id='method' name='method'>
            <input type='hidden' value='dailyQuote' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن سخن روز</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="text" class="control-label">متن سخن روز</label>
                                <textarea id="text" name="text" class="form-control" rows='4'
                                          placeholder="متن سخن روز را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="date_of" class="control-label">از تاریخ </label>
                            <input type="text" class="form-control datepicker" name="date_of" value="{if $smarty.post.date_of neq ''} {$smarty.post.date_of} {else}{$objFunctions->timeNow()}{/if}"
                                   id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="to_date" class="control-label">تا تاریخ</label>
                            <input type="text" class="form-control datepicker" name="to_date"
                                   value="{if $smarty.post.to_date neq ''}{$smarty.post.to_date}{else}{$objFunctions->timeNow()}{/if}" id="to_date"
                                   placeholder="تاریخ پایان جستجو را وارد نمائید">

                        </div>


                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="link" class="control-label">آدرس صفحه هدف</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" آدرس صفحه مقصد را وارد نمائید"></span>
                                <input type="text" class="form-control" id="link" name="link"
                                       placeholder="آدرس صفحه مقصد را وارد نمائید">
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">رنگ پس زمینه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" رنگ پس زمینه را وارد نمائید"></span>
                                <input type="color" class="form-control" name="color" id="color" value="#ffffff"
                                       placeholder="رنگ پس زمینه را وارد نمایید">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/dailyQuote.js"></script>

