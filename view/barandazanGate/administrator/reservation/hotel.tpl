{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">هتل ها</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">هتل</h3>
                <p class="text-muted m-b-30">
                    <span class="pull-right" style="margin: 10px;">
                         <a href="hotelAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن هتل جدید
                        </a>
                    </span>
                </p>


                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام هتل</th>
                            <th>ستاره</th>
                            <th>شهر</th>
                            <th>شناسه سپهر</th>
                            <th>الویت</th>
                            <th>نوع اتاق</th>
                            <th>امکانات هتل</th>
                            <th>گالری</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_hotel_tb' , 'user_id' , 0 , 'is null')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>{$item.star_code}</td>

                            <td>{$objFunction->ShowName(reservation_country_tb,$item.country)} - {$objFunction->ShowName(reservation_city_tb,$item.city)}</td>

                            <td class="text-align-center" onclick="changeHotelSepehrGlobalId('{$item.id}','{$item.sepehr_hotel_code}')" id="{$item.id}{$item.sepehr_hotel_code}">
                                {$item.sepehr_hotel_code}
                            </td>

                            <td class="text-align-center" onclick="EditInPlace('{$item.id}','{$item.priority}')" id="{$item.id}{$item.priority}">
                                {$item.priority}
                            </td>

                            <td>
                                <a href="addHotelRoom&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    اتاق
                                </a>
                            </td>

                            <td>
                                <a href="hotelFacilities&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    امکانات هتل
                                </a>
                            </td>

                            <td>
                                <a href="addHotelGallery&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    عکس
                                </a>
                            </td>

                            <td>
                                <a href="hotelEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>

                            <td>
                                <a id="DelChangePrice-2" onclick="logical_deletion('{$item.id}', 'reservation_hotel_tb'); return false"
                                   class="popoverBox  popover-danger" data-toggle="popover" title=""
                                   data-placement="right" data-content="حذف" data-original-title="حذف تغییرات">
                                    <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش هتل   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/386/-.html" target="_blank" class="i-btn"></a>

</div>


<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>