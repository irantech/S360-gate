{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="busTicketPriceChanges" assign="objBusCompany"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">شرکت های مسافربری اتوبوس</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="formBaseCompaniesBus" method="post" action="{$smarty.const.rootAddress}bus_ajax">
                    <input type="hidden" name="flag" value="flagInsertBaseCompanyBus">

                    <div class="form-group col-sm-4">
                        <label for="type_vehicle" class="control-label">انتخاب نوع وسیله نقلیه</label>
                        <select name="type_vehicle" id="type_vehicle" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="bus">اتوبوس</option>
                            <option value="train">قطار</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="name_fa" class="control-label">نام</label>
                        <input type="text" class="form-control" name="name_fa" value=""
                               id="name_fa" placeholder=" نام شرکت را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="name_en" class="control-label">نام انگلیسی</label>
                        <input type="text" class="form-control" name="name_en" value=""
                               id="name_en" placeholder=" نام انگلیسی شرکت را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="iata_code" class="control-label">کد یاتا</label>
                        <input type="text" class="form-control" name="iata_code" value=""
                               id="iata_code" placeholder="کد یاتا را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="../../pic/NoPhotoHotel.png"/>
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
                <h3 class="box-title m-b-0">شرکت های مسافربری اتوبوس</h3>
                <p class="text-muted m-b-30">تمامی شرکت های مسافربری اتوبوس وارد شده را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نوع وسیله نقلیه</th>
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>کد یاتا</th>
                            <th>عکس</th>
                            <th>زیر مجموعه شرکت های حمل و نقل</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objBusCompany->listBaseCompanyBus()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">

                            <td>{$number}</td>

                            <td>
                                {if $item.type_vehicle eq 'bus'}اتوبوس
                                {elseif $item.type_vehicle eq 'train'}قطار
                                {/if}
                            </td>

                            <td>{$item.name_fa}</td>

                            <td>{$item.name_en}</td>

                            <td>{$item.iata_code}</td>

                            <td>
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/companyBusImages/{$item.logo}"
                                     class="all landscape width30" alt="gallery"/>
                            </td>

                            <td>
                                <a href="busCompanies&id={$item.id}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>                                    اضافه کردن زیر مجموعه
                                </a>
                            </td>

                            <td>
                                <a href="baseCompaniesBusEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">
                                    </i>
                                </a>
                            </td>

                            <td>
                                <a id="Del-{$item.id}" href="#" onclick="logicalDeletionBusCompany('{$item.id}', 'base_company_bus_tb'); return false"
                                   class="popoverBox  popover-danger" data-toggle="popover" title="حذف" data-placement="right"
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

<script type="text/javascript" src="assets/JsFiles/busPanel.js"></script>
{/if}
