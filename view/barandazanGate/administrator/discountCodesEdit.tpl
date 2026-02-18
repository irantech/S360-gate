{load_presentation_object filename="discountCodes" assign="ObjCode"}
{assign var="discountInfo" value=$ObjCode->ShowInfoForEdit($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li><a href="discountCodes">کد تخفیف</a></li>
                <li class="active">ویرایش کد تخفیف</li>
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
                <h3 class="box-title m-b-0">ویرایش کد تخفیف</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید یک و یا تعدادی کد تخفیف در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="DiscountCodesEdit" method="post">
                    <input type="hidden" name="flag" value="DiscountCodesEdit">
                    <input type="hidden" name="groupCode" value="{$discountInfo['groupCode']}">

                    <div class="form-group col-sm-6 ">
                        <label for="Title" class="control-label">عنوان تخفیف </label>
                        <input type="text" class="form-control" id="Title" name="Title" value="{$discountInfo['title']}"
                               placeholder="عنوان تخفیف را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Amount" class="control-label">مبلغ تخفیف</label>
                        <input type="text" class="form-control" id="Amount" name="Amount" value="{$discountInfo['amount']}"
                               placeholder="مبلغ تخفیف را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Stock" class="control-label">تعداد کدهای تخفیف</label>
                        <input type="text" class="form-control" {if $discountInfo['isGroup'] eq 'yes'}readonly="readonly"{else}id="Stock" name="Stock"{/if}
                               value="{if $discountInfo['isGroup'] eq 'yes'}{$discountInfo['groupStock']}{else}{$discountInfo['stock']}{/if}"
                               placeholder="تعداد کدهای تخفیف را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="PreCode" class="control-label">پیشوند کد تخفیف های تولیدی (در صورت تمایل)</label>
                        <input type="text" class="form-control" readonly="readonly" value="{$discountInfo['preCode']}"
                               placeholder="پیشوند کد تخفیف مورد نظر را در صورت تمایل وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="StartDate" class="control-label">تاریخ شروع استفاده</label>
                        <input type="text" class="form-control datepickerOfToday" id="StartDate" name="StartDate" value="{$objDate->jdate('Y-m-d', $discountInfo['startDateInt'])}"
                               placeholder="تاریخ شروع استفاده را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="EndDate" class="control-label">تاریخ انقضای استفاده</label>
                        <input type="text" class="form-control datepickerOfTodayReturn" id="EndDate" name="EndDate" value="{$objDate->jdate('Y-m-d', $discountInfo['endDateInt'])}"
                               placeholder="تاریخ انقضای استفاده را وارد نمائید">
                    </div>



                    <div class="form-group col-sm-12">
                        <input type="checkbox" name="is_allow_counter" id="is_allow_counter" value="{$discountInfo['is_allow_counter']}" {if $discountInfo['is_allow_counter'] eq '1'}checked="checked"{/if} />
                        <label for="is_allow_counter" class="control-label">
                            مجاز برای استفاده کانتر ها
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="left"
                                  title="در صورتیکه می خواهید  کانتر ها اجازه ی استفاده از این کد تخفیف را داشته باشد این گزینه را فعال نمایید"></span>
                        </label>
                    </div>
                    <div class="form-group col-sm-12">
                        <input type="checkbox" name="is_consume" id="is_consume"  onclick="showAmountPointDiscountCode()" value="{$discountInfo['is_consume']}" {if $discountInfo['is_consume'] eq '1'}checked="checked"{/if} />
                        <label for="is_allow_counter" class="control-label">
                            کد تخفیف ویژه
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="left"
                                  title="در صورتی که میخواهید  این کد  تخفیف فقط در ازای کسر از امتیاز کاربر قابل استفاده باشد گزینه زیر را انتخاب کنید"></span>
                        </label>
                    </div>




                    <div class="form-group col-sm-12 limit-point-club" {if $discountInfo['is_consume'] neq '1'}style="display: none;{/if}">
                        <label for="limit_point_club" class="control-label">میزان امتیاز برای خرید کد تخفیف را وارد نمایید</label>
                        <input type="text" class="form-control" id="limit_point_club" name="limit_point_club" value="{$discountInfo['limit_point_club']}"
                               placeholder="میزان  امتیاز را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-12">
                        <p>مایل هستم کد تخفیف را با شرایط بالا به خدماتی که انتخاب می کنم ارائه دهم:</p>
                        <div class="col-sm-3">
                            <input type="checkbox" name="flight_internal" id="flight_internal" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'flight_internal')}checked="checked"{/if} />
                            <label for="flight_internal" class="control-label">پروازداخلی </label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="flight_external" id="flight_external" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'flight_external')}checked="checked"{/if}/>
                            <label for="flight_external" class="control-label">پرواز خارجی</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="hotel_internal" id="hotel_internal" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'hotel_internal')}checked="checked"{/if}/>
                            <label for=hotel_interanl" class="control-label">هتل داخلی</label>
                        </div>

                        <div class="col-sm-3">
                            <input type="checkbox" name="hotel_external" id="hotel_external" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'hotel_external')}checked="checked"{/if}/>
                            <label for=hotel_external" class="control-label">هتل خارجی</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="insurance" id="insurance"  value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'insurance')}checked="checked"{/if}/>
                            <label for="insurance" class="control-label">بیمه </label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="tour_internal" id="tour_internal" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'tour_internal')}checked="checked"{/if}/>
                            <label for="tour_internal"  class="control-label">تور داخلی</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="tour_external" id="tour_external" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'tour_external')}checked="checked"{/if}/>
                            <label for="tour_external"  class="control-label">تور خارجی</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="train" id="train" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'train')}checked="checked"{/if}/>
                            <label for="train"  class="control-label">قطار</label>
                        </div>

                        <div class="col-sm-3">
                            <input type="checkbox" name="train_special" id="train_special" value="1"{if $ObjCode->HasThisService($discountInfo['groupCode'],'train_special')}checked="checked"{/if}/>
                            <label for="train_special"  class="control-label">قطار ویژه</label>
                        </div>

                        <div class="col-sm-3">
                            <input type="checkbox" name="gasht" id="gasht" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'gasht')}checked="checked"{/if}/>
                            <label for="gasht"  class="control-label">گشت</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="transfer" id="transfer" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'transfer')}checked="checked"{/if}/>
                            <label for="transfer"  class="control-label">ترانسفر</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="entertainment" id="entertainment" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'entertainment')}checked="checked"{/if}/>
                            <label for="entertainment"  class="control-label">تفریحات</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="checkbox" name="bus" id="bus" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'bus')}checked="checked"{/if}/>
                            <label for="bus"  class="control-label">اتوبوس</label>
                        </div>

                        <div class="col-sm-3">
                            <input type="checkbox" name="visa" id="visa" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'visa')}checked="checked"{/if}/>
                            <label for="visa"  class="control-label">ویزا</label>
                        </div>


                        <div class="col-sm-3">
                            <input type="checkbox" name="package" id="package" value="1" {if $ObjCode->HasThisService($discountInfo['groupCode'],'package')}checked="checked"{/if}/>
                            <label for="package"  class="control-label">پکیج</label>
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

<script type="text/javascript" src="assets/JsFiles/discountCodes.js"></script>

