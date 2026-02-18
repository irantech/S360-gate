{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

{$objResult->showFacilities()}

{$objResult->showHotelFacilities($smarty.get.id)}

<div class="container-fluid">
    <div class="">
        <div class="col-sm-12 p-0">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 textPriceChange"></p>

                <form id="Facilities" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_hotel_facilities">
                    <input type="hidden" name="id_hotel" value="{$smarty.get.id}">

                    {assign var="counter" value="0"}
                    {foreach $objResult->listFacilities as $facilities}
                        {$counter=$counter+1}
                        <div class="item-facilities">
                            <div class="checkbox_facility checkbox-success">
                                <input id="chk_hotel_facilities{$counter}" name="chk_hotel_facilities{$counter}" type="checkbox" value="{$facilities['id']}">
                                <label for="chk_hotel_facilities{$counter}"> <i class="size20 {$facilities['icon_class']}"></i>  {$facilities['title']} </label>
                            </div>
                        </div>
                    {/foreach}

                    <input type="hidden" name="CountFacilities" value="{$counter}">

                    <div class="parent-btn-submit">
                          <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


    <div class="">

        <div class="col-sm-12 p-0">
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
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$objResult->listHotelFacilities}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">

                                <td id="borderFacilities-{$item.id}">{$number}</td>

                                <td>{$item.title}</td>

                                <td><i class="size30 {$item.icon_class}"></i></td>

                                <td>
                                    <a id="DelFacilities-{$item.id}" href="#" onclick="logical_deletion('{$item.idFacilities}', 'reservation_hotel_facilities_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                    </a>
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
