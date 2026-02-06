{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

{assign var="hotel" value=$objResult->getHotel($smarty.get.idHotel)}
{assign var="is_show" value=$hotel['user_id']}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="addHotelRoom&id={$smarty.get.idHotel}">اتاق ها</a></li>
                <li class="active">گالری اتاق</li>
            </ol>
        </div>
    </div>

    {if !$is_show}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">  اضافه کردن عکس برای اتاق</h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormGallery" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_Gallery">
                    <input type="hidden" name="id_room" value="{$smarty.get.idRoom}">
                    <input type="hidden" name="id_hotel" value="{$smarty.get.idHotel}">
                    <input type="hidden" name="table_name" value="reservation_room_gallery_tb">
                    <input type="hidden" name="foreign_key_constraint" value="id_room">

                    <div class="form-group col-sm-4">
                        <label for="name" class="control-label">نام عکس</label>
                        <input type="text" class="form-control" name="name" value="{$smarty.post.name}"
                               id="name" placeholder=" نام شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="comment" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control" name="comment" value=""
                                  id="comment" placeholder=" توضیحات عکس را وارد نمائید"></textarea>
                    </div>


                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس اتاق</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/NoPhotoHotel.png"/>
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
    {/if}
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گالری اتاق </h3>
                <p class="text-muted m-b-30">
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>عکس</th>
                            {if !$is_show}
                            <th>ویرایش</th>
                            <th>حذف</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_room_gallery_tb', 'id_room', {$smarty.get.idRoom})}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>
                                {if $item.pic neq ''}
                                <img src="..\..\pic\{$item.pic}" class="all landscape width30" alt="gallery"/>
                                {else}
                                <img src="..\..\pic\NoPhotoHotel.png" class="all landscape width30" alt="gallery"/>
                                {/if}
                            </td>
                            {if !$is_show}
                            <td>
                                {if $item.is_del neq 'yes'}
                                    <a href="editRoomGallery&id={$item.id}">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش">

                                        </i>
                                    </a>
                                {/if}
                            </td>

                            <td>
                                {if $item.is_del neq 'yes'}
                                    <a id="DelHotelGallery-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_room_gallery_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="حذف عکس"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                    </a>
                                {else}
                                    <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="عکس را قبلا حذف کرده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                    </a>
                                {/if}
                            </td>
                            {/if}

                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>