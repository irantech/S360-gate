{load_presentation_object filename="personnel" assign="objPersonnel"}

{*<code>{$getCategory|json_encode}</code>*}
{if isset($smarty.get.service) && in_array($smarty.get.service,array_keys($getServices))}

{/if}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                <li class='active'>لیست پرسنل</li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a class="btn btn-primary rounded"
                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/personnel/insert">
                    <i class="fa fa-plus"></i>
                        پرسنل جدید
                </a>
                <hr>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>زبان</th>
                            <th>سمت</th>
                            <th>تحصیلات</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="personnel_list" value=$objPersonnel->getPersonnels()}

                        {foreach $personnel_list['data'] as $personnel}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$personnel['name']}</td>
                                <td>{$languages[$personnel['language']]}</td>
                                <td>{$personnel['position']}</td>
                                <td>{$personnel['education']}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/personnel/edit?id={$personnel['id']}"><i
                                                class="fa fa-edit"></i>ویرایش </a>
                                    </a>

                                    <button class="btn btn-sm btn-outline btn-danger deletepersonnel"
                                            onclick='removePersonnel("{$personnel['id']}")'>
                                        <i class="fa fa-trash"></i> حذف
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

<script type="text/javascript" src="assets/JsFiles/personnel.js"></script>
<style>
    .shown-on-result {

    }
</style>