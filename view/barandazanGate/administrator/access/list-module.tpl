{load_presentation_object filename="gdsModule" assign="obj_gds_module"}
{assign var="gds_module" value=$obj_gds_module->getListModule() }

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">لیست ماژول های سفر 360</li>
            </ol>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">
                         <span class="pull-right">
                <a href="add-module" class="btn btn-info waves-effect waves-light" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن ماژول جدید
                </a>

                </span>لیست ماژول های سفر 360</h3>

                <p class="text-muted m-b-30">

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>عنوان</th>
                            <th>نام کنترلر</th>
                            <th>نام دیتابیس</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$gds_module}
                            {$number=$number+1}
                            {$key=$key+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.title}</td>
                                <td>
                                    {$item.gds_controller}
                                </td>
                                <td>
                                    {$item.gds_table}
                                </td>
                                <td>
                                    <a href="edit-module&id={$item.id} " class=""><i
                                                class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="ویرایش ماژول"></i></a>
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

