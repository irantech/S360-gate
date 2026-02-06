{load_presentation_object filename="dailyQuote" assign="objDailyQuote"}
{assign var="info_daily_quote" value=$objDailyQuote->getDailyQuote($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/dailyQuote/list">
                        لیست سخن روز
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>سخن روز</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_daily_quote" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateDailyQuote' id='method' name='method'>
            <input type='hidden' value='dailyQuote' id='className' name='className'>
            <input type='hidden' value='{$info_daily_quote['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش   {$info_daily_quote['text']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="text" class="control-label">متن سخن روز</label>
                                <textarea id="text" name="text" class="form-control" rows='4'
                                          placeholder="متن سخن روز را وارد نمائید">{$info_daily_quote['text']}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="date_of" class="control-label">از تاریخ </label>
                            <input type="text" class="form-control datepicker" name="date_of" value="{if $info_daily_quote['date_of'] neq ''} {$info_daily_quote['date_of']} {else}{$objFunctions->timeNow()}{/if}"
                                   id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="to_date" class="control-label">تا تاریخ</label>
                            <input type="text" class="form-control datepicker" name="to_date"
                                   value="{if $info_daily_quote['to_date'] neq ''}{$info_daily_quote['to_date']}{else}{$objFunctions->timeNow()}{/if}" id="to_date"
                                   placeholder="تاریخ پایان جستجو را وارد نمائید">

                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="link" class="control-label">آدرس صفحه هدف</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" آدرس صفحه مقصد  را از این قسمت می توانید تغییر دهید"></span>
                                <input type="text" class="form-control" id="link" name="link" value='{$info_gallery_banner['url']}'
                                       placeholder="آدرس صفحه مقصد را وارد نمائید">
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">رنگ پس زمینه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" رنگ پس زمینه را وارد نمائید"></span>
                                <input type="color" class="form-control" name="color" id="color"  {if $info_daily_quote['color']}value="{$info_daily_quote['color']}"{else} value="#ffffff"{/if}
                                       placeholder="از این قسمت می توانید رنگ پس زمینه را تغییر دهید">
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


