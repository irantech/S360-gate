{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

{$objResult->SelectAllWithCondition('reservation_hotel_tb', 'id', $smarty.get.id)}

{*{if !$objResult->list['user_id']}*}
{*    {assign var="disabled" value=''}*}
{*    {else}*}
{*    {assign var="disabled" value='disabled'}*}
{*{/if}*}
{assign var="disabled" value=''}
{assign var="is_show" value=$objResult->list['user_id']}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                {if !$is_show}
                    <li><a href="hotel">هتل ها</a></li>
                {else}
                    <li><a href="marketHotel">هتل ها</a></li>
                {/if}
                <li class="active">ویرایش اطلاعات هتل</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات هتل را در سیستم ویرایش نمائید</p>

                <form id="EditHotel" method="post">
{*                    {if !$objResult->list['user_id']}*}
                        <input type="hidden" name="flag" value="EditHotel">
{*                        {else}*}
{*                        <input type="hidden" name="flag" value="AcceptHotel">*}
{*                    {/if}*}

                    <input type="hidden" name="type_id" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="name" class="control-label">نام هتل</label>
                        <input type="text" class="form-control" name="name" value="{$objResult->list['name']}"
                               id="name" placeholder=" نام هتل را وارد نمائید" {$disabled}>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="name_en" class="control-label">نام انگلیسی هتل</label>
                        <input type="text" class="form-control" name="name_en" value="{$objResult->list['name_en']}"
                               id="name_en" placeholder=" نام انگلیسی هتل را وارد نمائید" {$disabled}>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="title" class="control-label">عنوان هتل</label>
                        <input type="text" class="form-control" name="title" value="{$objResult->list['title']}"
                               id="title" placeholder=" عنوان هتل را وارد نمائید" {$disabled}>
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="control-label" for="heading">عنوان H1</label>
                        <input type="text" class="form-control" name="heading" id="heading"
                               placeholder="عنوان h1"
                               value="{$objResult->list['heading']}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="control-label" for="sepehr_hotel_code">کد هتل سپهر</label>
                        <input type="number" class="form-control" name="sepehr_hotel_code" id="sepehr_hotel_code"
                               placeholder="کد هتل سپهر"
                               value="{$objResult->list['sepehr_hotel_code']}">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="description">متن کوتاه</label>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="متن سئو، حداکثر ( 160 ) حرف"></span>
                            <textarea id='description' maxlength='160' name="description" class="form-control"
                                      placeholder="متن مربوطه">{$objResult->list['description']}</textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="star_code" class="control-label">ستاره هتل</label>
                        <select name="star_code" id="star_code" class="form-control " {$disabled}>
                            <option value="{$objResult->list['star_code']}">{$objResult->list['star_code']}</option>
                            <option value="1">1*</option>
                            <option value="2">2*</option>
                            <option value="3">3*</option>
                            <option value="4">4*</option>
                            <option value="5">5*</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="prepaymentPercentage" class="control-label">درصد پیش پرداخت</label>
                        <select name="prepaymentPercentage" id="prepaymentPercentage" class="form-control ">
                            <option value="" disabled='disabled'>انتخاب کنید</option>
                            {section name=foo start=0 loop=100 step=10}
                                <option value="{$smarty.section.foo.index}" {if $objResult->list['prepayment_percentage'] eq $smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                            {/section}

                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="type_code" class="control-label">نوع هتل</label>
                        <select name="type_code" id="type_code" class="form-control" {$disabled}>
                            <option value="">ندارد</option>
                            <option value="1" {if $objResult->list['type_code'] eq '1'}selected{/if}>هتل</option>
                            <option value="2" {if $objResult->list['type_code'] eq '2'}selected{/if}>هتل آپارتمان</option>
                            <option value="3" {if $objResult->list['type_code'] eq '3'}selected{/if}>مهمانسرا</option>
                            <option value="4" {if $objResult->list['type_code'] eq '4'}selected{/if}>خانه سنتی</option>
                            <option value="5" {if $objResult->list['type_code'] eq '5'}selected{/if}>هتل سنتی</option>
                            <option value="6" {if $objResult->list['type_code'] eq '6'}selected{/if}>اقامتگاه بوم گردی</option>
                            <option value="7" {if $objResult->list['type_code'] eq '7'}selected{/if}>هتل جنگلی</option>
                            <option value="8" {if $objResult->list['type_code'] eq '8'}selected{/if}>مجموعه فرهنگی تفریحی</option>
                            <option value="9" {if $objResult->list['type_code'] eq '9'}selected{/if}>پانسیون</option>
                            <option value="10" {if $objResult->list['type_code'] eq '10'}selected{/if}>متل</option>
                            <option value="12" {if $objResult->list['type_code'] eq '12'}selected{/if}>ویلا</option>
                            <option value="13" {if $objResult->list['type_code'] eq '13'}selected{/if}>کاروانسرا</option>
                            <option value="14" {if $objResult->list['type_code'] eq '14'}selected{/if}>مجتمع اقامتی</option>
                            <option value="15" {if $objResult->list['type_code'] eq '15'}selected{/if}>خانه محلی</option>
                            <option value="16" {if $objResult->list['type_code'] eq '16'}selected{/if}>ویلا هتل</option>
                            <option value="17" {if $objResult->list['type_code'] eq '17'}selected{/if}>خوابگاه</option>
                            <option value="18" {if $objResult->list['type_code'] eq '18'}selected{/if}>سوئیت</option>
                            <option value="100" {if $objResult->list['type_code'] eq '100'}selected{/if}>هاستل</option>
                            <option value="101" {if $objResult->list['type_code'] eq '101'}selected{/if}>بوتیک</option>
                            <option value="110" {if $objResult->list['type_code'] eq '110'}selected{/if}>سوییت های سنتی بام خلخال</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="number_of_rooms" class="control-label">تعداد اتاق</label>
                        <input type="text" class="form-control" name="number_of_rooms" value="{$objResult->list['number_of_rooms']}"
                               id="number_of_rooms" placeholder=" تعداد اتاق را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="site" class="control-label">سایت</label>
                        <input type="text" class="form-control" name="site" value="{$objResult->list['site']}"
                               id="site" placeholder=" سایت را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="origin_country" class="control-label">کشور</label>
                        <select name="origin_country" id="origin_country" class="form-control select2 select2-hidden-accessible" {$disabled}>
                            <option value="{$objResult->list['country']}">{$objFunction->ShowName(reservation_country_tb,$objResult->list['country'])}</option>
                            <option value="">انتخاب کنید....</option>
                            {foreach $objFunction->ListCountry() as $country}
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    <option value="{$country['id']}">{$country['name']}</option>
                                {else}
                                    <option value="{$country['id']}">{$country['name_en']}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="origin_city" class="control-label">شهر</label>
                        <select name="origin_city" id="origin_city" class="form-control  select2 select2-hidden-accessible" {$disabled}>
                            <option value="{$objResult->list['city']}">{$objFunction->ShowName(reservation_city_tb,$objResult->list['city'])}</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="origin_region" class="control-label">منطقه</label>
                        <select name="origin_region" id="origin_region" class="form-control  " {$disabled}>
                            <option value=""></option>
                            {if $objResult->list['region'] neq 0}
                            <option value="{$objResult->list['region']}">{$objFunction->ShowName(reservation_region_tb,$objResult->list['region'])}</option>
                            {/if}
                        </select>
                    </div>



                    <div class="form-group col-sm-9">
                        <label for="address" class="control-label">آدرس</label>
                        <input type="text" class="form-control" name="address" value="{$objResult->list['address']}"
                               id="address" placeholder=" آدرس هتل را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="address_en" class="control-label">آدرس انگلیسی</label>
                        <input type="text" class="form-control" name="address_en" value="{$objResult->list['address_en']}"
                               id="address_en" placeholder=" آدرس هتل انگلیسی را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="tel_number" class="control-label">تلفن</label>
                        <input type="text" class="form-control" name="tel_number" value="{$objResult->list['tel_number']}"
                               id="tel_number" placeholder=" تلفن هتل را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="trip_advisor" class="control-label">نمره trip advisor</label>
                        <input type="text" class="form-control" name="trip_advisor" value="{$objResult->list['trip_advisor']}"
                               id="trip_advisor" placeholder="trip advisor" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="email_manager" class="control-label">ایمیل مدیر</label>
                        <input type="text" class="form-control" name="email_manager" value="{$objResult->list['email_manager']}"
                               id="email_manager" placeholder=" ایمیل مدیر را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="entry_hour" class="control-label">ساعت تحویل</label>
                        <input type="text" class="form-control" name="entry_hour" value="{$objResult->list['entry_hour']}"
                               id="entry_hour" placeholder=" ساعت تحویل را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="leave_hour" class="control-label">ساعت تخلیه</label>
                        <input type="text" class="form-control" name="leave_hour" value="{$objResult->list['leave_hour']}"
                               id="leave_hour" placeholder=" ساعت تخلیه را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="longitude" class="control-label">longitude (عرض جغرافیایی)</label>
                        <input type="text" class="form-control" name="longitude" value="{$objResult->list['longitude']}"
                               id="longitude" placeholder=" عرض جغرافیایی را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="latitude" class="control-label">latitude (طول جغرافیایی)</label>
                        <input type="text" class="form-control" name="latitude" value="{$objResult->list['latitude']}"
                               id="latitude" placeholder=" طول جغرافیایی را وارد نمائید" {$disabled}>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="discount" class="control-label">تخفیف تا سقف</label>
                        <input type="text" class="form-control" name="discount" value="{$objResult->list['discount']}"
                               id="discount" placeholder="تخفیف تا سقف" {$disabled}>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="comment" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control ckeditor" name="comment"
                                  id="comment" placeholder=" توضیحات را وارد نمائید" {$disabled}>{$objResult->list['comment']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="comment_en" class="control-label">توضیحات انگلیسی</label>
                        <textarea type="text" class="form-control ckeditor" name="comment_en"
                                  id="comment_en" placeholder=" توضیحات انگلیسی را وارد نمائید" {$disabled}>{$objResult->list['comment_en']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="distance_to_important_places" class="control-label">فاصله تا اماکن مهم</label>
                        <textarea type="text" class="form-control ckeditor" name="distance_to_important_places" {$disabled}
                                  id="distance_to_important_places" placeholder=" فاصله تا اماکن مهم را وارد نمائید">{$objResult->list['distance_to_important_places']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="distance_to_important_places_en" class="control-label">فاصله تا اماکن مهم انگلیسی</label>
                        <textarea type="text" class="form-control ckeditor" name="distance_to_important_places_en" {$disabled}
                                  id="distance_to_important_places_en" placeholder=" فاصله تا اماکن مهم انگلیسی را وارد نمائید">{$objResult->list['distance_to_important_places_en']}</textarea>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="rules" class="control-label">قوانین</label>
                        <textarea type="text" class="form-control" name="rules"
                                  id="rules" placeholder=" قوانین را وارد نمائید" {$disabled}>{$objResult->list['rules']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="rules_en" class="control-label">قوانین انگلیسی</label>
                        <textarea type="text" class="form-control" name="rules_en"
                                  id="rules_en" placeholder=" قوانین انگلیسی را وارد نمائید" {$disabled}>{$objResult->list['rules_en']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="cancellation_conditions" class="control-label">قوانین کنسلی</label>
                        <textarea type="text" class="form-control" name="cancellation_conditions"
                                  id="cancellation_conditions" placeholder=" قوانین کنسلی را وارد نمائید" {$disabled}>{$objResult->list['cancellation_conditions']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="cancellation_conditions_en" class="control-label">قوانین کنسلی انگلیسی</label>
                        <textarea type="text" class="form-control" name="cancellation_conditions_en" {$disabled}
                                  id="cancellation_conditions_en" placeholder=" قوانین کنسلی انگلیسی را وارد نمائید" > {$objResult->list['cancellation_conditions_en']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="child_conditions" class="control-label">قوانین خردسال</label>
                        <textarea type="text" class="form-control" name="child_conditions" {$disabled}
                                  id="child_conditions" placeholder=" قوانین خردسال را وارد نمائید">{$objResult->list['child_conditions']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="child_conditions_en" class="control-label">قوانین خردسال انگلیسی</label>
                        <textarea type="text" class="form-control" name="child_conditions_en" {$disabled}
                                  id="child_conditions_en" placeholder=" قوانین خردسال انگلیسی را وارد نمائید">{$objResult->list['child_conditions_en']}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="form-group">
                            <label for="iframe_code" class="control-label">کد آی فریم</label>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" کد آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                            {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                            <textarea id="iframe_code" name="iframe_code" class="form-control" rows='4'
                                      placeholder="کد آی فریم را وارد نمائید">{$objResult->list['iframe_code']}</textarea>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="pic" class="control-label">عکس هتل</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100" {$disabled}
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objResult->list['logo']}"/>
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="chk_flag_special" name="chk_flag_special" {$disabled} type="checkbox" value="1" {if $objResult->list['flag_special'] eq 'yes'}checked="checked"{/if}>
                            <label for="chk_flag_special"> هتل ویژه </label>
                        </div>
                    </div>
{*                    <div class="form-group col-sm-2">*}
{*                        <div class="checkbox checkbox-success">*}
{*                            <input id="chk_flag_discount" name="chk_flag_discount" type="checkbox" value="1" {if $objResult->list['flag_discount'] eq 'yes'}checked="checked"{/if}>*}
{*                            <label for="chk_flag_discount"> هتل تخفیف دار </label>*}
{*                        </div>*}
{*                    </div>*}
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="transfer_went" name="transfer_went" {$disabled} type="checkbox" value="1" {if $objResult->list['transfer_went'] eq 'yes'}checked="checked"{/if}>
                            <label for="transfer_went"> ترانسفر رفت </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="transfer_back" name="transfer_back" {$disabled} type="checkbox" value="1" {if $objResult->list['transfer_back'] eq 'yes'}checked="checked"{/if}>
                            <label for="transfer_back"> ترانسفر برگشت </label>
                        </div>
                    </div>


                    {$objResult->getHotelBroker($smarty.get.id)}
                    <div class="form-group col-sm-12">
                        <h3 class="box-title m-t-40">کارگزار هتل</h3>
                        <hr>
                        <div class="table-responsive">

                            <table class="table color-table purple-table" id="TableHotelBroker">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>کارگزارهتل</th>
                                    <th>ایمیل</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $objResult->listBroker as $k=>$broker}
                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-success">
                                                <input id="chk_broker{$k+1}" name="chk_broker{$k+1}" class="form-control" type="checkbox" value="1" {if $broker['choose'] eq 'yes'}checked="checked"{/if}>
                                                <label for="chk_broker{$k+1}">انتخاب کارگزار</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-text">
                                                <input type="text" class="form-control textPrice" name="broker{$k+1}" id="broker{$k+1}" value="{$broker['broker']}" id="broker{$k+1}" aria-invalid="false">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-text">
                                                <input type="text" class="form-control textPrice" name="email{$k+1}" id="email{$k+1}" value="{$broker['email']}" id="email{$k+1}" aria-invalid="false">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="assets/css/images/delete.png" border="0" onclick="logical_deletion('{$broker['id']}', 'reservation_hotel_broker_tb'); return false"">
                                        </td>
                                    </tr>
                                {/foreach}

                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                            <img src="assets/css/images/add.png" border="0" onClick="appendRow(this.form)">
                            {if $k neq 0}
                                {assign var="count" value=$k}
                            {else}
                                {assign var="count" value="0"}
                            {/if}
                            <input name="count_package" id="count_package" value="{$count}" type="hidden">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                    {if $objResult->list['user_id']}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group col-md-6 pull-right" style="text-align: center;">
                                    <a class="btn btn-success" style="width: 50%;" onclick="showDiv('changePrice')">تائید نمایش و رزرو</a>
                                </div>
                                <div class="form-group col-md-6 pull-right" style="text-align: center;">
                                    <a class="btn btn-danger" style="width: 50%;" onclick="showDiv('commentCancel')">عدم نمایش و رزرو</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 {if $objResult->list['is_show'] eq '' || $objResult->list['is_show'] eq 'no' }displayN{/if}" id="changePrice" style="float: left;">
                            <div class="white-box">
                                <div class="row">
{*                                    <p class="text-muted m-b-10">لطفا افزایش قیمت تور را وارد کنید</p>*}
{*                                    <div class="col-md-12eservation/reportTour">*}
{*                                        <input type="text" class="form-control" name="price" value="{$infoTour['change_price']}" id="price"*}
{*                                               onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="مبلغ (ریال)">*}
{*                                    </div>*}
                                    <div class="col-md-12" style="text-align: center;margin-top: 10px;">
                                        <a class="btn btn-success" onclick="showHotelOnSite('{$smarty.get.id}', 'yes')">ثبت تغییرات تایید</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 {if $objResult->list['is_show'] eq '' || $objResult->list['is_show'] eq 'yes' }displayN{/if}" id="commentCancel" style="float: right;">
                            <div class="white-box">
                                <div class="row">

                                    <p class="text-muted m-b-10">لطفا دلیل عدم نمایش تور را وارد کنید.</p>
                                    <div class="col-md-12">
                    <textarea type="text" class="form-control"
                              name="comment_cancel_text" id="comment_cancel_text" placeholder=" توضیحات را وارد نمائید">{$objResult->list['comment_cancel']}</textarea>
                                    </div>
                                    <div class="col-md-12" style="text-align: center;margin-top: 10px;">
                                        <a class="btn btn-danger" onclick="showHotelOnSite('{$smarty.get.id}', 'no')">ثبت تغییرات عدم نمایش</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    {/if}
                </form>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>


<SCRIPT LANGUAGE="JavaScript">

    var count = parseInt($('#count_package').val());

    var theTable, theTableBody;
    var aa=[];
    for(var i=1;i<count+1;i++){
        aa[i] = i;
    }
    var row = count + 1;

    $(document).ready(function () {
        theTable = (document.all) ? document.all.TableHotelBroker : document.getElementById("TableHotelBroker");
        theTableBody = theTable.tBodies[0];
    });

    function appendRow(form) {

        $('#count_package').val(parseInt(row));
        aa[row]=row;
        insertTableRow(form, -1)
    }
    

    function insertTableRow(form, where) {


        var nowData = [
            '<div align="center"><input id="chk_broker' + row + '" name="chk_broker' + row + '" class="form-control" type="checkbox" value="1">\n' +
            '<label for="chk_broker1">انتخاب کارگزار</label></div>' ,
            '<div align="center"><input type="text" class="form-control textPrice" name="broker' + row + '" value="" id="broker' + row + '" placeholder="کارگزار هتل را وارد کنید." aria-invalid="false"</div>' ,
            '<div align="center"><input type="text" class="form-control textPrice" name="email' + row + '" value="" id="email' + row + '" placeholder="ایمیل را وارد کنید" aria-invalid="false"></div>' ,
            '<div align="right" dir="rtl"><img src="assets/css/images/delete.png" border="0" onClick="deleteRow(' + row + ')"></div>'
        ];

        var newCell;
        var newRow = theTableBody.insertRow(where);
        for (var i = 0; i < nowData.length; i++) {
            newCell = newRow.insertCell(i);
            newCell.innerHTML = nowData[i];
            newCell.style.backgroundColor = "#A0B7E0"
        }

        row = row+1;
    }


    /////////////////////////////////////////////////////////
    function deleteRow(index) {

        alert(index);
        alert(aa);

        var countzero=0;
        var i;
        for(i=0; i<=aa.length; i++){
            if(aa[i]=="n"){
                countzero++;
            }
        }//tedade khali bodane khaneha

        alert(countzero);


        //if khali nabodane khane ha
        if(countzero==0){
            theTableBody.deleteRow(index);
            aa[index]="n";
            return;
        }//end if


        // if khli bodane khane ha
        if(countzero!=0){
            var countkhaneha=0;
            for(var i=0;i<index;i++){
                if(aa[i]=="n"){
                    countkhaneha++;
                }
            }//end for

            //age khali gablesh nabod
            if(countkhaneha==0){
                theTableBody.deleteRow(index);
                aa[index]="n";
            }//end if


            //age khali gablesh nabod
            if(countkhaneha!=0){
                var harekat=0;
                for(var i=0;i<index;i++){
                    if(aa[i]=="n"){
                        harekat++;
                    }

                }//end for
                var kam=index-harekat;
                theTableBody.deleteRow(kam);
                aa[index]="n";
            }
            //end if

        }//end if


    }


</script>