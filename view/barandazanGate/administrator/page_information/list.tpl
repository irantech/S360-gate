{load_presentation_object filename="infoPages" assign="objInfoPages"}


{assign var="pages" value=$objInfoPages->getPages($smarty.get.service)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                <li class="active">ویرایش نام صفحات</li>
            </ol>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">
                         <span class="pull-right">


               <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/page_information/insert?service=flight"
                  class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    افزودن
                </a>

                </span>لیست بخش های نرم افزار سفر 360</h3>

                <p class="text-muted m-b-30">

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام صفحه</th>
                            <th>title</th>
                            <th>آدرس صفحه</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                            {foreach $pages as $key=>$item}
                                <tr>
                                    <td>{$key+1}</td>
                                    <td>{$item.name}</td>
                                    <td>{$item.title}</td>
                                    <td>
                                        {$item.gds_switch}
                                    </td>
                                    <td>
                                        <a href="edit&id={$item.id} " class="">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="ویرایش بخش">
                                            </i>
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

