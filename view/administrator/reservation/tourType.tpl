{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">نوع تور</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormTouType" method="post" action="{$smarty.const.ROOTADDRESS}hotel_ajax">
                    <input type="hidden" name="flag" value="insertTourType">

                    <div class="form-group col-sm-6">
                        <label for="tour_type" class="control-label">نوع تور</label>
                        <input type="text" class="form-control" name="tour_type" id="tour_type" placeholder="نوع تور را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="tour_type" class="control-label">نام انگلیسی</label>
                        <input type="text" class="form-control" name="tour_type_en" id="tour_type_en" placeholder="نوع تور را وارد نمائید">
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
                <h3 class="box-title m-b-0">نوع تور</h3>
                <p class="text-muted m-b-30">تمامی نوع تورهای وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>تایید</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_tour_type_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.tour_type}</td>
                            <td>{$item.tour_type_en}</td>

                            <td>
                                <a href="#" onclick="toggleApproveTourType('{$item.id}'); return false;">
                                    {if $item.is_approved eq '1'}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>

                            <td>
                                {if $item.id neq '1' && $item.id neq '2'}
                                    <a href="tourTypeEdit&id={$item.id}">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" data-original-title="ویرایش نوع تور">
                                        </i>
                                    </a>
                                {/if}
                            </td>

                            <td>
                                {if $item.id neq '1' && $item.id neq '2'}
                                    {if $objResult->permissionToDelete('reservation_tour_tourType_tb', 'fk_tour_type_id', $item.id) eq 'yes'}
                                        <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"
                                           data-toggle="popover" title="حذف نوع تور" data-placement="right"
                                           data-content="امکان حذف وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                        </a>
                                    {else}
                                        <a id="Del-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_tour_type_tb'); return false"
                                           class="popoverBox  popover-danger" data-toggle="popover" title="حذف نوع تور" data-placement="right"
                                           data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                        </a>
                                    {/if}
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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش نوع تور   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/384/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>