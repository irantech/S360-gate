{load_presentation_object filename="reservationBasicInformation" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li class="active">تعریف شهر</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div style="background:#fff; border:1px solid #e0e0e0; border-radius:10px;
                    padding:15px 20px; margin-bottom:20px;
                    box-shadow:0 2px 6px rgba(0,0,0,0.05); text-align:center;">
                <i class="fa fa-info-circle" style="margin-left:8px; color:#555;"></i>
                <span style="font-size:16px; font-weight:500; color:#333;">
                شما فقط امکان
                <span style="color:#0073aa; font-weight:600;">ویرایش</span> و
                <span style="color:#0073aa; font-weight:600;">حذف</span>
                آیتم‌هایی را دارید که خودتان اضافه کرده‌اید،
                و در آیتم‌های قبلی فقط امکان
                <span style="color:#0073aa; font-weight:600;">ویرایش تصویر شهر</span>
                را وجود دارد.
            </span>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 textPriceChange"></p>

                <form id="FormCity" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_city">
                    <input type="hidden" name="id_country" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="city_name" class="control-label">نام شهر</label>
                        <input type="text" class="form-control" name="city_name" value="{$smarty.post.city_name}"
                               id="city_name" placeholder=" نام شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="city_name_en" class="control-label">نام انگلیسی شهر</label>
                        <input type="text" class="form-control" name="city_name_en" value="{$smarty.post.city_name_en}"
                               id="city_name_en" placeholder=" نام انگلیسی شهر را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="city_name_en" class="control-label">نام عربی شهر</label>
                        <input type="text" class="form-control" name="city_name_ar" value="{$smarty.post.city_name_ar}"
                               id="city_name_ar" placeholder=" نام عربی شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="city_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="city_abbreviation" value="{$smarty.post.city_abbreviation}"
                               id="city_abbreviation" placeholder="نام اختصار را وارد نمائید">
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="pic" class="control-label">عکس شهر</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/no-image.png"/>
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
                <h3 class="box-title m-b-0">لیست شهر</h3>
                <p class="text-muted m-b-30">
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام شهر</th>
                            <th>نام اختصار</th>
                            <th>عکس</th>
                            <th>تعریف منطقه</th>
{*                            {if $smarty.get.id neq '1'}*}
                            <th>ویرایش</th>
                            <th>حذف</th>
{*                            {/if}*}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_city_tb', 'id_country', {$smarty.get.id})}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.name}</td>

                            <td>{$item.abbreviation}</td>

                            <td>
                                {if $item.pic neq ''}
                                <img src="..\..\pic\{$item.pic}" class="all landscape width30" alt="gallery" style="width:50px"/>
                                {else}
                                <img src="..\..\pic\no-image.png" class="all landscape width30" alt="gallery" style="width:50px"/>
                                {/if}
                            </td>

                            <td>
                                <a href="region&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    اضافه کردن منطقه
                                </a>
                            </td>

{*                            {if $smarty.get.id neq '1'}*}
                            <td>
                                {if $item.id >300}
                                <a href="cityEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                                {else}
                                    <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="ویرایش تغییرات" data-placement="right"
                                       data-content="امکان ویرایش شهر وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                    </a>
                                {/if}
                            </td>


                            <td>

                                {*<a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="امکان حذف شهر وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>*}

                             {if $item.id >300}
                                {if $objResult->permissionToDelete('reservation_region_tb', 'id_city', $item.id) eq 'yes'}
                                    <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="امکان حذف شهر وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                    </a>
                                {elseif $item.is_del eq 'yes'}
                                    <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="شهر را قبلا حذف کرده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                    </a>
                                {else}
                                    <a id="DelCity-{$item.id}" onclick="logical_deletion('{$item.id}', 'reservation_city_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="حذف شهر"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                    </a>
                                {/if}
                                {else}
                                    <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                       data-content="امکان حذف شهر وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                    </a>
                                {/if}

                            </td>
{*                            {/if}*}

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