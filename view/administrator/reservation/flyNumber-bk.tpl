{load_presentation_object filename="reservationPublicFunctions" assign="objResult"}

{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">ثبت شماره پرواز</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">شماره پرواز</h3>
                <p class="text-muted m-b-30">
                    <span class="pull-right" style="margin: 10px;">
                         <a href="flyNumberAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن شماره پرواز جدید
                        </a>
                    </span>
                </p>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>شماره</th>
                            <th>شرکت حمل و نقل</th>
                            <th>درجه کلاس</th>
                            <th>ویرایش</th>
                            <th>برنامه پروازی</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objBasic->SelectAll('reservation_fly_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objResult->ShowName('reservation_country_tb',$item.origin_country)} - {$objResult->ShowName('reservation_city_tb',$item.origin_city)}</td>

                            <td>{$objResult->ShowName('reservation_country_tb',$item.destination_country)} - {$objResult->ShowName('reservation_city_tb',$item.destination_city)}</td>

                            <td>{$item.fly_code}</td>

                            <td>
                                {if $objResult->ShowName('reservation_type_of_vehicle_tb',$item.type_of_vehicle_id) eq 'هواپیما'}
                                    {$objResult->ShowNameBase('airline_tb','name_fa',$item.airline)}
                                {else}
                                    {$objResult->ShowName('reservation_transport_companies_tb',$item.airline)}
                                {/if}
                            </td>

                            <td>{$objResult->ShowName('reservation_vehicle_grade_tb',$item.vehicle_grade_id)}</td>

                            <td>
                                <a href="flyNumberEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>

                            <td>
                                <a href="ticketAdd?fly_id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-success btn-1e fa fa-ticket tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="افزودن برنامه پروازی">

                                    </i>
                                </a>
                            </td>

                            <td>
{*                                {if $objBasic->permissionToDelete('reservation_ticket_tb', 'fly_code', $item.id) eq 'yes'}*}
{*                                    <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف شماره پرواز" data-placement="right"*}
{*                                       data-content="امکان حذف وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>*}
{*                                    </a>*}
{*                                {else}*}
{*                                    <a id="DelChangePrice-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_fly_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"*}
{*                                       data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>*}
{*                                    </a>*}
{*                                {/if}*}
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
        <span> ویدیو آموزشی بخش ثبت شماره پرواز   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/381/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>