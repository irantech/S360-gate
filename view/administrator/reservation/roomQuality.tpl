{load_presentation_object filename="reservationBasicInformation" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="roomType">نوع اتاق</a></li>
                <li class="active">کیفیت اتاق</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormRoomType" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_room">
                    <input type="hidden" name="table_name" value="reservation_room_quality_tb">

                    <div class="form-group col-sm-6">
                        <label for="comment" class="control-label">کیفیت اتاق</label>
                        <input type="text" class="form-control" name="comment" value="{$smarty.post.comment}"
                               id="comment" placeholder="کیفیت اتاق را وارد نمائید">
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
                <h3 class="box-title m-b-0">کیفیت اتاق</h3>
                <p class="text-muted m-b-30">
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کیفیت اتاق</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_room_quality_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.comment}</td>

                            <td>
                                <a href="roomQualityEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش کیفیت اتاق">

                                    </i>
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

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>