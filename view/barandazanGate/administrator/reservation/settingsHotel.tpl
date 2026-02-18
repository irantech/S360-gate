{load_presentation_object filename="reservationHotel" assign="ObjResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>رزرواسیون</li>
                <li>تنظیمات</li>
                <li class="active">ترتیب نمایش هتل ها</li>
            </ol>
        </div>
    </div>



    {if $smarty.const.TYPE_ADMIN eq '1'}
    {*<div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 textPriceChange"></p>

                <form id="FormOrderHotel" method="post" action="hotel_ajax" novalidate="novalidate">
                    <input name="flag" value="insertOrderHotel" type="hidden">

                    <div class="form-group col-sm-3">
                        <div class="checkbox checkbox-success">
                            <input name="title1" id="title1" value="به ترتیب کمترین قیمت" type="hidden">
                            <input name="title_en1" id="title_en1" value="minPrice" type="hidden">
                            <input id="checkbox1" name="checkbox1" type="checkbox" value="1">
                            <label for=""> به ترتیب کمترین قیمت </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        <div class="checkbox checkbox-success">
                            <input name="title2" id="title2" value="به ترتیب بیشترین قیمت" type="hidden">
                            <input name="title_en2" id="title_en2" value="maxPrice" type="hidden">
                            <input id="checkbox2" name="checkbox2" type="checkbox" value="1">
                            <label for=""> به ترتیب بیشترین قیمت </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        <div class="checkbox checkbox-success">
                            <input name="title3" id="title3" value="به ترتیب ستاره هتل" type="hidden">
                            <input name="title_en3" id="title_en3" value="star" type="hidden">
                            <input id="checkbox3" name="checkbox1" type="checkbox" value="1">
                            <label for=""> به ترتیب ستاره هتل </label>
                        </div>
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
    </div>*}
    {/if}


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ترتیب نمایش هتل ها</h3>
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>عنوان</th>
                            <th>وضعیت</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                {*<th>ویرایش</th>*}
                                <th>حذف</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjResult->orderHotel()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.title}</td>
                                <td>
                                    <a onclick="orderHotelActive('{$item.id}'); return false;">
                                    {if $item.enable eq '1'}
                                        <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                    </a>
                                </td>
                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    {*<td>
                                        <a href="orderHotelEdit&id={$item.id}">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش"></i>
                                        </a>
                                    </td>*}
                                    <td>
                                        <a id="DelHotelRoom-3" href="#" onclick="logical_deletion('{$item.id}', 'reservation_order_hotel_tb'); return false"
                                           class="popoverBox  popover-danger" data-toggle="popover" title="" data-placement="right"
                                           data-content="حذف" data-original-title="حذف">
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش ترتیب نمایش هتل ها   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/377/---.html" target="_blank" class="i-btn"></a>

</div>


<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>