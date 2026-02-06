{load_presentation_object filename="reservationBasicInformation" assign="objResult"}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li class="active">تعریف منطقه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormRegion" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_region">
                    <input type="hidden" name="id_city" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="region_name" class="control-label">نام منطقه</label>
                        <input type="text" class="form-control" name="region_name" value="{$smarty.post.city_name}"
                               id="region_name" placeholder=" نام منطقه را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="region_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="region_abbreviation" value="{$smarty.post.city_abbreviation}"
                               id="region_abbreviation" placeholder="نام اختصار را وارد نمائید">
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
                <h3 class="box-title m-b-0">تعریف منطقه</h3>
                <p class="text-muted m-b-30">
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام منطقه</th>
                            <th>نام اختصار</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_region_tb', 'id_city', {$smarty.get.id})}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>{$item.abbreviation}</td>

                            <td>
                                <a href="regionEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>

                            <td>

                                {if $item.is_del eq 'yes'}
                                <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="منطقه را قبلا حذف کرده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                {else}
                                <a id="DelRegion-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_region_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف منطقه"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>