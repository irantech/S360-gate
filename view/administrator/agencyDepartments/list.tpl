{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>لیست واحدها</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <p class="text-muted col-sm-12">
                    <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/agencyDepartments/insert"
                            class="btn btn-info waves-effect waves-light" type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>
                            تعریف جدید
                         </a>
                    </span>
                </p>
                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>تیتر واحد</th>
                            <th>کد واحد</th>
                            <th>قسمتی از توضیحات</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_depart" value=$objAgencyDepart->getAgencyDepart()}
                        {foreach $main_depart as $depart}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$depart.title}</td>
                                <td>{$depart.code}</td>
                                <td>{$depart.short_description}</td>
                                   <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/agencyDepartments/edit?id={$depart.id}"><i
                                                class="fa fa-edit"></i>ویرایش </a>


                                    <button class="btn btn-sm btn-outline btn-danger"
                                            onclick='deleteAgencyDepart("{$depart.id}")'
                                            data-id="{$depart.id}"><i class="fa fa-trash"></i> حذف
                                    </button>
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
<script type="text/javascript" src="assets/JsFiles/agencyDepartments.js"></script>