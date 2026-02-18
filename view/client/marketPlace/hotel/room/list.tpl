{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 textPriceChange"></p>

                <form id="FormHotelRoom" method="post" action="" class="row">
                    <input type="hidden" name="flag" value="insert_hotelRoom">
                    <input type="hidden" name="id_hotel" id="id_hotel" value="{$smarty.get.id}">

                    <div class="form-group col-sm-4">
                        <label for="room_title" class="control-label">عنوان اتاق</label>
                        <select name="room_title" id="room_title" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->SelectAll('reservation_room_title_tb') as $roomTitle}
                                <option value="{$roomTitle['comment']}">{$roomTitle['comment']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="room_quality" class="control-label">کیفیت اتاق</label>
                        <select name="room_quality" id="room_quality" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->SelectAll('reservation_room_quality_tb') as $roomQuality}
                                <option value="{$roomQuality['comment']}">{$roomQuality['comment']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="room_view" class="control-label">منظره اتاق</label>
                        <select name="room_view" id="room_view" class="form-control ">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->SelectAll('reservation_room_view_tb') as $roomView}
                                <option value="{$roomView['comment']}">{$roomView['comment']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="room_name_en" class="control-label">نام انگلیسی اتاق</label>
                        <input type="text" class="form-control" name="room_name_en" value="{$smarty.post.room_name_en}"
                               id="room_name_en" placeholder=" نام انگلیسی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="room_capacity" class="control-label">ظرفیت اصلی اتاق</label>
                        <input type="text" class="form-control" name="room_capacity" value="{$smarty.post.room_capacity}"
                               id="room_capacity" placeholder="ظرفیت اصلی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="maximum_extra_beds" class="control-label">حداکثر تخت اضافه بزرگسال</label>
                        <input type="text" class="form-control" name="maximum_extra_beds" value="{$smarty.post.maximum_extra_beds}"
                               id="maximum_extra_beds" placeholder="حداکثر تخت اضافه بزرگسال را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="maximum_extra_chd_beds" class="control-label">حداکثر تخت اضافه کودک</label>
                        <input type="text" class="form-control" name="maximum_extra_chd_beds" value="{$smarty.post.maximum_extra_chd_beds}"
                               id="maximum_extra_chd_beds" placeholder="حداکثر تخت اضافه کودک را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="room_comment" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control" name="room_comment" value=""
                                  id="room_comment" placeholder=" توضیحات اتاق را وارد نمائید"></textarea>
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

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">اتاق های هتل {$objFunction->ShowName('reservation_hotel_tb', {$smarty.get.id})}</h3>
                <div class="table-responsive" style="width: 100%">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نوع اتاق</th>
                            <th>نام انگلیسی اتاق</th>
                            <th>ظرفیت اصلی</th>
                            <th>حداکثر تخت اضافه بزرگسال</th>
                            <th>حداکثر تخت اضافه کودک</th>
                            <th>توضیحات</th>
                            <th>امکانات اتاق</th>
                            <th>گالری</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->ListHotelRoom({$smarty.get.id})}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                                <td>{$item.comment}</td>

                                <td>{$item.room_name_en}</td>

                                <td>{$item.room_capacity}</td>

                                <td>{$item.maximum_extra_beds}</td>

                                <td>{$item.maximum_extra_chd_beds}</td>

                                <td>{$item.room_comment}</td>



                                <td>
                                    <a href="roomFacility&idHotel={$smarty.get.id}&idRoom={$item.idRoom}" class="waves-effect waves-light" type="button">
                                        <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-bed  "></i>
                                    </a>

                                </td>

                                <td>
                                    <a href="roomGallery&idHotel={$smarty.get.id}&idRoom={$item.idRoom}" class="waves-effect waves-light" type="button">
                                        <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-camera"></i>
                                    </a>
                                </td>
                                <td>
                                    {if $objResult->permissionToDelete_room($smarty.get.id, $item.id_room) eq 'yes'}
                                        <a data-item='{$item|json_encode:256}' onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title=" تغییرات" data-placement="right"
                                           data-content="امکان ویرایش اتاق وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                        </a>
                                    {elseif $item.is_del eq 'yes'}
                                        <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title=" تغییرات" data-placement="right"
                                           data-content="امکان ویرایش اتاق وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                        </a>
                                    {else}
                                        <a href="hotelRoomEdit&id={$item.id}">
                                            <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="ویرایش">

                                            </i>
                                        </a>
                                    {/if}


                                </td>

                                <td>
                                    {if $objResult->permissionToDelete_room($smarty.get.id, $item.id_room) eq 'yes'}
                                        <a data-item='{$item|json_encode:256}' onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                           data-content="امکان حذف اتاق وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                        </a>
                                    {elseif $item.is_del eq 'yes'}
                                        <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                           data-content="اتاق را قبلا حذف کرده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                        </a>
                                    {else}
                                        <a id="DelHotelRoom-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_hotel_room_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                           data-content="حذف اتاق"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                        </a>
                                    {/if}
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
