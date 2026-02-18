{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

{$objResult->SelectAllWithCondition('reservation_hotel_tb', 'id', $smarty.get.id)}


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 mb-4">شما با استفاده از فرم زیر میتوانید اطلاعات هتل را در سیستم ویرایش نمائید</p>

                <form id="EditHotel" method="post" class='row'>
                    <input type="hidden" name="flag" value="EditHotel">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="user_id" value="{$smarty.session.userId}">

                    <div class="form-group col-sm-4">
                        <label for="name" class="control-label">نام هتل</label>
                        <input type="text" class="form-control" name="name" value="{$objResult->list['name']}"
                               id="name" placeholder=" نام هتل را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="name_en" class="control-label">نام انگلیسی هتل</label>
                        <input type="text" class="form-control" name="name_en" value="{$objResult->list['name_en']}"
                               id="name_en" placeholder=" نام انگلیسی هتل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="discount" class="control-label">تخفیف تا سقف</label>
                        <input type="text" class="form-control" name="discount" value="{$objResult->list['discount']}"
                               id="discount" placeholder="تخفیف تا سقف">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="star_code" class="control-label">ستاره هتل</label>
                        <select name="star_code" id="star_code" class="form-control ">
                            <option value="{$objResult->list['star_code']}">{$objResult->list['star_code']}</option>
                            <option value="1">1*</option>
                            <option value="2">2*</option>
                            <option value="3">3*</option>
                            <option value="4">4*</option>
                            <option value="5">5*</option>
                        </select>
                    </div>


                    <div class="form-group col-sm-4">
                        <label for="type_code" class="control-label">نوع هتل</label>
                        <select name="type_code" id="type_code" class="form-control">
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
                            <option value="100" {if $objResult->list['type_code'] eq '100'}selected{/if}>هاستل</option>
                            <option value="101" {if $objResult->list['type_code'] eq '101'}selected{/if}>بوتیک</option>
                            <option value="110" {if $objResult->list['type_code'] eq '110'}selected{/if}>سوییت های سنتی بام خلخال</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="number_of_rooms" class="control-label">تعداد اتاق</label>
                        <input type="text" class="form-control" name="number_of_rooms" value="{$objResult->list['number_of_rooms']}"
                               id="number_of_rooms" placeholder=" تعداد اتاق را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="site" class="control-label">سایت</label>
                        <input type="text" class="form-control" name="site" value="{$objResult->list['site']}"
                               id="site" placeholder=" سایت را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="origin_country" class="control-label">کشور</label>
                        <select name="origin_country" id="origin_country" class="form-control select2 select2-hidden-accessible">
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
                    <div class="form-group col-sm-4">
                        <label for="origin_city" class="control-label">شهر</label>
                        <select name="origin_city" id="origin_city" class="form-control  select2 select2-hidden-accessible">
                            <option value="{$objResult->list['city']}">{$objFunction->ShowName(reservation_city_tb,$objResult->list['city'])}</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="origin_region" class="control-label">منطقه</label>
                        <select name="origin_region" id="origin_region" class="form-control  ">
                            <option value=""></option>
                            {if $objResult->list['region'] neq 0}
                                <option value="{$objResult->list['region']}">{$objFunction->ShowName(reservation_region_tb,$objResult->list['region'])}</option>
                            {/if}
                        </select>
                    </div>



                    <div class="form-group col-sm-4">
                        <label for="address" class="control-label">آدرس</label>
                        <input type="text" class="form-control" name="address" value="{$objResult->list['address']}"
                               id="address" placeholder=" آدرس هتل را وارد نمائید">
                    </div>

{*                    <div class="form-group col-sm-4">*}
{*                        <label for="address_en" class="control-label">آدرس انگلیسی</label>*}
{*                        <input type="text" class="form-control" name="address_en" value="{$objResult->list['address_en']}"*}
{*                               id="address_en" placeholder=" آدرس هتل انگلیسی را وارد نمائید">*}
{*                    </div>*}

                    <div class="form-group col-sm-4">
                        <label for="tel_number" class="control-label">تلفن</label>
                        <input type="text" class="form-control" name="tel_number" value="{$objResult->list['tel_number']}"
                               id="tel_number" placeholder=" تلفن هتل را وارد نمائید">
                    </div>

{*                    <div class="form-group col-sm-4">*}
{*                        <label for="trip_advisor" class="control-label">نمره trip advisor</label>*}
{*                        <input type="text" class="form-control" name="trip_advisor" value="{$objResult->list['trip_advisor']}"*}
{*                               id="trip_advisor" placeholder="trip advisor">*}
{*                    </div>*}

{*                    <div class="form-group col-sm-4">*}
{*                        <label for="email_manager" class="control-label">ایمیل مدیر</label>*}
{*                        <input type="text" class="form-control" name="email_manager" value="{$objResult->list['email_manager']}"*}
{*                               id="email_manager" placeholder=" ایمیل مدیر را وارد نمائید">*}
{*                    </div>*}

                    <div class="form-group col-sm-4">
                        <label for="entry_hour" class="control-label">ساعت تحویل</label>
                        <input type="text" class="form-control" name="entry_hour" value="{$objResult->list['entry_hour']}"
                               id="entry_hour" placeholder=" ساعت تحویل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="leave_hour" class="control-label">ساعت تخلیه</label>
                        <input type="text" class="form-control" name="leave_hour" value="{$objResult->list['leave_hour']}"
                               id="leave_hour" placeholder=" ساعت تخلیه را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="longitude" class="control-label">longitude (عرض جغرافیایی)</label>
                        <input type="text" class="form-control" name="longitude" value="{$objResult->list['longitude']}"
                               id="longitude" placeholder=" عرض جغرافیایی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="latitude" class="control-label">latitude (طول جغرافیایی)</label>
                        <input type="text" class="form-control" name="latitude" value="{$objResult->list['latitude']}"
                               id="latitude" placeholder=" طول جغرافیایی را وارد نمائید">
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="comment" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control ckeditor" name="comment"
                                  id="comment" placeholder=" توضیحات را وارد نمائید" >{$objResult->list['comment']}</textarea>
                    </div>

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="comment_en" class="control-label">توضیحات انگلیسی</label>*}
{*                        <textarea type="text" class="form-control ckeditor" name="comment_en"*}
{*                                  id="comment_en" placeholder=" توضیحات انگلیسی را وارد نمائید" >{$objResult->list['comment_en']}</textarea>*}
{*                    </div>*}

                    <div class="form-group col-sm-6">
                        <label for="distance_to_important_places" class="control-label">فاصله تا اماکن مهم</label>
                        <textarea type="text" class="form-control ckeditor" name="distance_to_important_places"
                                  id="distance_to_important_places" placeholder=" فاصله تا اماکن مهم را وارد نمائید">{$objResult->list['distance_to_important_places']}</textarea>
                    </div>

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="distance_to_important_places_en" class="control-label">فاصله تا اماکن مهم انگلیسی</label>*}
{*                        <textarea type="text" class="form-control ckeditor" name="distance_to_important_places_en"*}
{*                                  id="distance_to_important_places_en" placeholder=" فاصله تا اماکن مهم انگلیسی را وارد نمائید">{$objResult->list['distance_to_important_places_en']}</textarea>*}
{*                    </div>*}


                    <div class="form-group col-sm-6">
                        <label for="rules" class="control-label">قوانین</label>
                        <textarea type="text" class="form-control" name="rules"
                                  id="rules" placeholder=" قوانین را وارد نمائید">{$objResult->list['rules']}</textarea>
                    </div>

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="rules_en" class="control-label">قوانین انگلیسی</label>*}
{*                        <textarea type="text" class="form-control" name="rules_en"*}
{*                                  id="rules_en" placeholder=" قوانین انگلیسی را وارد نمائید">{$objResult->list['rules_en']}</textarea>*}
{*                    </div>*}

                    <div class="form-group col-sm-6">
                        <label for="cancellation_conditions" class="control-label">قوانین کنسلی</label>
                        <textarea type="text" class="form-control" name="cancellation_conditions"
                                  id="cancellation_conditions" placeholder=" قوانین کنسلی را وارد نمائید">{$objResult->list['cancellation_conditions']}</textarea>
                    </div>

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="cancellation_conditions_en" class="control-label">قوانین کنسلی انگلیسی</label>*}
{*                        <textarea type="text" class="form-control" name="cancellation_conditions_en"*}
{*                                  id="cancellation_conditions_en" placeholder=" قوانین کنسلی انگلیسی را وارد نمائید">{$objResult->list['cancellation_conditions_en']}</textarea>*}
{*                    </div>*}

                    <div class="form-group col-sm-6">
                        <label for="child_conditions" class="control-label">قوانین خردسال</label>
                        <textarea type="text" class="form-control" name="child_conditions"
                                  id="child_conditions" placeholder=" قوانین خردسال را وارد نمائید">{$objResult->list['child_conditions']}</textarea>
                    </div>

{*                    <div class="form-group col-sm-6">*}
{*                        <label for="child_conditions_en" class="control-label">قوانین خردسال انگلیسی</label>*}
{*                        <textarea type="text" class="form-control" name="child_conditions_en"*}
{*                                  id="child_conditions_en" placeholder=" قوانین خردسال انگلیسی را وارد نمائید">{$objResult->list['child_conditions_en']}</textarea>*}
{*                    </div>*}

                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس هتل</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objResult->list['logo']}"/>
                    </div>
{*                    <div class="form-group col-sm-2">*}
{*                        <div class="checkbox checkbox-success">*}
{*                            <input id="chk_flag_special" name="chk_flag_special" type="checkbox" value="1" {if $objResult->list['flag_special'] eq 'yes'}checked="checked"{/if}>*}
{*                            <label for="chk_flag_special"> هتل ویژه </label>*}
{*                        </div>*}
{*                    </div>*}
                    {*                    <div class="form-group col-sm-2">*}
                    {*                        <div class="checkbox checkbox-success">*}
                    {*                            <input id="chk_flag_discount" name="chk_flag_discount" type="checkbox" value="1" {if $objResult->list['flag_discount'] eq 'yes'}checked="checked"{/if}>*}
                    {*                            <label for="chk_flag_discount"> هتل تخفیف دار </label>*}
                    {*                        </div>*}
                    {*                    </div>*}
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="transfer_went" name="transfer_went" type="checkbox" value="1" {if $objResult->list['transfer_went'] eq 'yes'}checked="checked"{/if}>
                            <label for="transfer_went"> ترانسفر رفت </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="transfer_back" name="transfer_back" type="checkbox" value="1" {if $objResult->list['transfer_back'] eq 'yes'}checked="checked"{/if}>
                            <label for="transfer_back"> ترانسفر برگشت </label>
                        </div>
                    </div>


{*                    {$objResult->getHotelBroker($smarty.get.id)}*}
{*                    <div class="form-group col-sm-12">*}
{*                        <h3 class="box-title m-t-40">کارگزار هتل</h3>*}
{*                        <hr>*}
{*                        <div class="table-responsive">*}

{*                            <table class="table color-table purple-table" id="TableHotelBroker">*}
{*                                <thead>*}
{*                                <tr>*}
{*                                    <th></th>*}
{*                                    <th>کارگزارهتل</th>*}
{*                                    <th>ایمیل</th>*}
{*                                    <th>حذف</th>*}
{*                                </tr>*}
{*                                </thead>*}
{*                                <tbody>*}
{*                                {foreach $objResult->listBroker as $k=>$broker}*}
{*                                    <tr>*}
{*                                        <td>*}
{*                                            <div class="checkbox checkbox-success">*}
{*                                                <input id="chk_broker{$k+1}" name="chk_broker{$k+1}" class="form-control" type="checkbox" value="1" {if $broker['choose'] eq 'yes'}checked="checked"{/if}>*}
{*                                                <label for="chk_broker{$k+1}">انتخاب کارگزار</label>*}
{*                                            </div>*}
{*                                        </td>*}
{*                                        <td>*}
{*                                            <div class="input-text">*}
{*                                                <input type="text" class="form-control textPrice" name="broker{$k+1}" id="broker{$k+1}" value="{$broker['broker']}" id="broker{$k+1}" aria-invalid="false">*}
{*                                            </div>*}
{*                                        </td>*}
{*                                        <td>*}
{*                                            <div class="input-text">*}
{*                                                <input type="text" class="form-control textPrice" name="email{$k+1}" id="email{$k+1}" value="{$broker['email']}" id="email{$k+1}" aria-invalid="false">*}
{*                                            </div>*}
{*                                        </td>*}
{*                                        <td>*}
{*                                            <img src="assets/css/images/delete.png" border="0" onclick="logical_deletion('{$broker['id']}', 'reservation_hotel_broker_tb'); return false"">*}
{*                                        </td>*}
{*                                    </tr>*}
{*                                {/foreach}*}

{*                                </tbody>*}
{*                            </table>*}

{*                        </div>*}
{*                        <div class="row">*}
{*                            <img src="assets/css/images/add.png" border="0" onClick="appendRow(this.form)">*}
{*                            {if $k neq 0}*}
{*                                {assign var="count" value=$k}*}
{*                            {else}*}
{*                                {assign var="count" value="0"}*}
{*                            {/if}*}
{*                            <input name="count_package" id="count_package" value="{$count}" type="hidden">*}
{*                        </div>*}
{*                    </div>*}

                    <div class="">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
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

