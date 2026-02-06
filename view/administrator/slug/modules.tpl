{load_presentation_object filename="slugController" assign="objSlugController"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class='active'>سرویس ها</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

<!--                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/special_page/insert"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    صفحه ی ویژه جدید
                </a>-->

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام سرویس</th>

                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {foreach $objSlugController->getServices() as $service}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$service.Title}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/slug/list?module={$service.MainService}"><i
                                                class="fa fa-edit"></i>
                                        نمایش آدرس ها
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

<script type="text/javascript" src="assets/JsFiles/special_page.js"></script>
<style>
    .shown-on-result {

    }
</style>