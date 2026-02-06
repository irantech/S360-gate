{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

{$objResult->showListHotelRoom($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="addHotelRoom&id={$objResult->listHotelRoom['id_hotel']}">اتاق ها</a></li>
                <li class="active">ویرایش اتاق</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات اتاق را در سیستم ویرایش نمائید</p>

                <form id="EditHotelRoom" method="post">
                    <input type="hidden" name="flag" value="EditHotelRoom">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="id_hotel" value="{$objResult->listHotelRoom['id_hotel']}">


                    <div class="form-group col-sm-4">
                        <label for="room_title" class="control-label">عنوان اتاق</label>
                        <select name="room_title" id="room_title" class="form-control ">
                            {if $objResult->listHotelRoomType['room_title'] neq ''}
                                <option value="{$objResult->listHotelRoomType['room_title']}">{$objResult->listHotelRoomType['room_title']}</option>
                            {else}
                                <option value="">انتخاب کنید....</option>
                            {/if}
                            {foreach $objResult->SelectAll('reservation_room_title_tb') as $roomTitle}
                            <option value="{$roomTitle['comment']}">{$roomTitle['comment']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="room_quality" class="control-label">کیفیت اتاق</label>
                        <select name="room_quality" id="room_quality" class="form-control ">
                            {if $objResult->listHotelRoomType['room_quality'] neq ''}
                            <option value="{$objResult->listHotelRoomType['room_quality']}">{$objResult->listHotelRoomType['room_quality']}</option>
                            {else}
                            <option value="">انتخاب کنید....</option>
                            {/if}
                            {foreach $objResult->SelectAll('reservation_room_quality_tb') as $roomQuality}
                            <option value="{$roomQuality['comment']}">{$roomQuality['comment']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="room_view" class="control-label">منظره اتاق</label>
                        <select name="room_view" id="room_view" class="form-control ">
                            {if $objResult->listHotelRoomType['room_view'] neq ''}
                            <option value="{$objResult->listHotelRoomType['room_view']}">{$objResult->listHotelRoomType['room_view']}</option>
                            {else}
                            <option value="">انتخاب کنید....</option>
                            {/if}
                            {foreach $objResult->SelectAll('reservation_room_view_tb') as $roomView}
                            <option value="{$roomView['comment']}">{$roomView['comment']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="room_name_en" class="control-label">نام انگلیسی اتاق</label>
                        <input type="text" class="form-control" name="room_name_en" value="{$objResult->listHotelRoom['room_name_en']}"
                               id="room_name_en" placeholder=" نام انگلیسی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="room_capacity" class="control-label">ظرفیت اصلی اتاق</label>
                        <input type="text" class="form-control" name="room_capacity" value="{$objResult->listHotelRoom['room_capacity']}"
                               id="room_capacity" placeholder="ظرفیت اصلی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="maximum_extra_beds" class="control-label">حداکثر تخت اضافه بزرگسال</label>
                        <input type="text" class="form-control" name="maximum_extra_beds" value="{$objResult->listHotelRoom['maximum_extra_beds']}"
                               id="maximum_extra_beds" placeholder="حداکثر تخت اضافه بزرگسال را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="maximum_extra_chd_beds" class="control-label">حداکثر تخت اضافه کودک</label>
                        <input type="text" class="form-control" name="maximum_extra_chd_beds" value="{$objResult->listHotelRoom['maximum_extra_chd_beds']}"
                               id="maximum_extra_chd_beds" placeholder="حداکثر تخت اضافه کودک را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="room_comment" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control" name="room_comment"
                                  id="room_comment" placeholder=" توضیحات اتاق را وارد نمائید">{$objResult->listHotelRoom['room_comment']}</textarea>
                    </div>


                    <div class="row">
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


<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>