
{load_presentation_object filename="busTicketPriceChanges" assign="objBusCompany"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/busTicket/baseCompaniesBus">شرکت های مسافربری اتوبوس</a></li>
                <li class="active">زیر مجموعه شرکت های مسافربری اتوبوس</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="formBusCompanies" method="post" action="{$smarty.const.rootAddress}bus_ajax">
                    <input type="hidden" name="flag" value="flagInsertBusCompany">
                    <input type="hidden" name="id_base_company" value="{$smarty.get.id}">

                    <div class="form-group col-sm-4">
                        <label for="name_fa" class="control-label">نام</label>
                        <input type="text" class="form-control" name="name_fa" value=""
                               id="name_fa" placeholder=" نام زیر مجموعه را وارد نمائید">
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
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objBusCompany->listCompanyBus($smarty.get.id)}
                        {$number=$number+1}
                        <tr>

                            <td>{$number}</td>

                            <td><input type="text" name="name_fa" id="name_fa"
                                       class="companyName" value="{$item.name_fa}"
                                       data-id="{$item.id}" style="width: 100%;"></td>

                            <td>
                                <a id="Del-{$item.id}" href="#" onclick="logicalDeletionBusCompany('{$item.id}', 'company_bus_tb'); return false"
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
