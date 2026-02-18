{load_presentation_object filename="discountCodes" assign="ObjCode"}
{load_presentation_object filename="services" assign="ObjServices"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li><a href="discountCodes">کد تخفیف</a></li>
                <li class="active">استفاده کنندگان کد تخفیف</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">استفاده کنندگان کد تخفیف</h3>
                <p class="text-muted m-b-30">لیست کاربرانی که از این کد تخفیف استفاده نموده اند
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>کد تخفیف</th>
                            <th>خدمات مربوطه</th>
                            <th>تاریخ استفاده</th>
                            <th>مشاهده رزرو</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjCode->UsedList($smarty.get.id)}
                            {$number=$number+1}
                            {assign var="relatedService" value=$ObjServices->getServiceByTitle($item.serviceTitle)}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.name} {$item.family}</td>
                                <td>{$item.discountCode}</td>
                                <td>{$relatedService['TitleFa']}</td>
                                <td dir="ltr" class="text-left">{$objDate->jdate('Y-m-d (H:i:s)', $item.creationDateInt)}</td>
                                <td>
                                    <ul role="menu" class="animated flipInY" style="list-style: none; padding: 0;">
                                        <li>
                                            <a onclick="ModalShowBook('{$relatedService['groupService']}','{$item.factorNumber}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده رزرو"></i>
                                            </a>
                                        </li>
                                    </ul>
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

<script type="text/javascript" src="assets/JsFiles/discountCodes.js"></script>