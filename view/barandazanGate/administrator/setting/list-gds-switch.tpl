{load_presentation_object filename="gdsSwitches" assign="obj_gds_switches"}
{assign var="gds_switches" value=$obj_gds_switches->getListGdsSwitches() }

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">لیست بخش های نرم افزار سفر 360</li>
            </ol>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">
                         <span class="pull-right">
                <a href="add-gds-switch" class="btn btn-info waves-effect waves-light" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن بخش جدید
                </a>

                </span>لیست بخش های نرم افزار سفر 360</h3>

                <p class="text-muted m-b-30">

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>عنوان</th>
                            <th>gds switch</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach key=key item=item from=$gds_switches}
                            {$key=$key+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.title}</td>
                                <td>
                                    {$item.gds_switch}
                                </td>
                                <td>
                                    <a href="edit-gds-switch&id={$item.id} " class=""><i
                                                class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="ویرایش بخش"></i></a>
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

