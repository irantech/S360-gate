{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

{$objResult->showFacilities()}

{$objResult->showRoomFacilities($smarty.get.idHotel, $smarty.get.idRoom)}


{assign var="hotel" value=$objResult->getHotel($smarty.get.idHotel)}
{assign var="is_show" value=$hotel['user_id']}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="addHotelRoom&id={$smarty.get.idHotel}">اتاق ها</a></li>
                <li class="active">امکانات اتاق</li>
            </ol>
        </div>
    </div>

    {if !$is_show}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="Facilities" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_room_facilities">
                    <input type="hidden" name="id_hotel" value="{$smarty.get.idHotel}">
                    <input type="hidden" name="id_room" value="{$smarty.get.idRoom}">
                    
                    {assign var="counter" value="0"}
                    {foreach $objResult->listFacilities as $facilities}
                    {$counter=$counter+1}
                    <div class="form-group col-sm-3">
                        <div class="checkbox checkbox-success">
                            <input id="chk_room_facilities{$counter}" name="chk_room_facilities{$counter}" type="checkbox" value="{$facilities['id']}">
                            <label for="chk_room_facilities{$counter}"> <i class="size20 {$facilities['icon_class']}"></i>  {$facilities['title']} </label>
                        </div>
                    </div>
                    {/foreach}

                    <input type="hidden" name="CountFacilities" value="{$counter}">

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
                <h3 class="box-title m-b-0">امکانات اتاق</h3>
                <p class="text-muted m-b-30">
                    <!--<span class="pull-right" style="margin: 10px;">
                         <a href="facilitiesAdd&services=Room" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن امکانات جدید برای اتاق
                        </a>
                    </span>-->
                </p>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>آیکن</th>
                            {if !$is_show}
                            <th>حذف</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$objResult->listRoomFacilities}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">

                            <td id="borderFacilities-{$item.id}">{$number}</td>

                            <td>{$item.title}</td>

                            <td><i class="size30 {$item.icon_class}"></i></td>
                            {if !$is_show}
                            <td>
                                <a id="DelFacilities-{$item.id}" href="#" onclick="logical_deletion('{$item.idFacilities}', 'reservation_room_facilities_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                </a>
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