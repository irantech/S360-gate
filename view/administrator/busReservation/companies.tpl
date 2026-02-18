{load_presentation_object filename="busPanel" assign="objResult"}

{load_presentation_object filename="busTicketPriceChanges" assign="objBusCompany"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href='main'>
                        مدیریت بلیط رزرواسیون اتوبوس
                    </a>
                </li>
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

                    <input type='hidden' name='type_vehicle' value='bus'>

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
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>عکس</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->getBusCompanies()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">

                                <td>{$number}</td>

                                <td>{$item.name_fa}</td>

                                <td>{$item.name_en}</td>


                                <td>
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/companyBusImages/{$item.logo}"
                                         class="all landscape width30" alt="gallery"/>
                                </td>


                                <td>
                                    <a href="companiesEdit&id={$item.id}">
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
