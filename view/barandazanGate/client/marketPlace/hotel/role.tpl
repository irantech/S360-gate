{load_presentation_object filename="reservationHotel" assign="objResult"}
{assign var="reservationHotelList" value=$objResult->getUserReservationHotels()}
{assign var="userHotelList" value=$objResult->getUserReservationRoleUser()}

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 textPriceChange"></p>

                <form id="setUserRole" method="post" action="" class="row">
                    <div class="form-group col-sm-12">
                        <label for="item_id" class="control-label">انتخاب هتل</label>
                        <select name="item_id[]" id="item_id" class="form-control " multiple="multiple">
                            <option value="">انتخاب کنید....</option>
                            {foreach $reservationHotelList as $hotel}
                                <option value="{$hotel['id']}">{$hotel['name']}</option>
                            {/foreach}
                        </select>
                    </div>

{*                    <div class="form-group col-sm-4">*}
{*                        <label for="room_title" class="control-label">انتخاب کاربر</label>*}
{*                        <select name="room_title" id="room_title" class="form-control ">*}
{*                            <option value="">انتخاب کنید....</option>*}
{*                        </select>*}
{*                    </div>*}
                    <div class="form-group col-sm-4">
                        <label for="user_name" class="control-label" >نام کاربری</label>
                        <input type='text' name="user_name" id="user_name" onkeyup="authenticateCheckExistenceValidator($(this))" class="form-control">
                        <div class='invalid-feedback'></div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="password" class="control-label">رمز عبور</label>
                        <input type='text' name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="room_quality" class="control-label">انتخاب نقش</label>
                        <select name="role[]" id="role" class="form-control " multiple="multiple">
                            <option value="">انتخاب کنید....</option>
                            <option value="counter">کانتر</option>
                            <option value="accountant">حسابدار</option>
                        </select>
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
                <h3 class="box-title m-b-0"></h3>
                <div class="table-responsive" style="width: 100%">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام هتل</th>
                            <th>نام کاربری</th>
                            <th>نقش</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$userHotelList}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>

                                <td>{$item.item_name}</td>

                                <td>{$item.user_name}</td>

                                {if $item.role == 'counter'}
                                    <td>کانتر</td>
                                    {else}
                                    <td>حسابدار</td>
                                {/if}
                                <td>
                                    <a onclick='setUserRoleId({$item.id})'
                                       class="btn_action site-bg-main-color fa fa-pencil-square-o tooltip_w"
                                       data-title="ویرایش" href="javascript:"></a>
                                </td>
                                <td>
                                    <a id="deleteRole-{$item.id}" onclick="deleteRole('{$item.id}'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="حذف اتاق"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                    </a>
                                </td>
{*                                <td>*}
{*                                    {if $objResult->permissionToDelete_room($smarty.get.id, $item.id_room) eq 'yes'}*}
{*                                        <a data-item='{$item|json_encode:256}' onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title=" تغییرات" data-placement="right"*}
{*                                           data-content="امکان ویرایش اتاق وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>*}
{*                                        </a>*}
{*                                    {elseif $item.is_del eq 'yes'}*}
{*                                        <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title=" تغییرات" data-placement="right"*}
{*                                           data-content="امکان ویرایش اتاق وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>*}
{*                                        </a>*}
{*                                    {else}*}
{*                                        <a href="hotelRoomEdit&id={$item.id}">*}
{*                                            <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"*}
{*                                                data-toggle="tooltip" data-placement="top" title=""*}
{*                                                data-original-title="ویرایش">*}

{*                                            </i>*}
{*                                        </a>*}
{*                                    {/if}*}


{*                                </td>*}



                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
                <div id="customPopup" class="custom-popup">
                    <div class="custom-popup-content edit-user">
                        <div class="custom-popup-title">
                            <h3>ویرایش</h3>
                            <span class="custom-close-btn">×</span>
                        </div>
                        <form id="updateUserRole" method="post" action="" class="row" novalidate="novalidate">
                            <input type="hidden" name="hotel_role_id" id="hotel_role_id" class="form-control">
                            <div class="form-group col-12">
                                <label for="password" class="control-label">رمز عبور</label>
                                <input type="password" name="update_password" id="update_password" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="control-label">تکرار رمز عبور</label>
                                <input type="password" name="confirm-password" id="confirm-password" class="form-control">
                            </div>
                            <div class="col-12">
                                    <div class="form-group  pull-right">
                                        <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                                    </div>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
