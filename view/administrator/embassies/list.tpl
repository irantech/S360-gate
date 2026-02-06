{load_presentation_object filename="embassies" assign="objEmbassies"}
{assign var="getEmbassies" value=$objEmbassies->getEmbassies('all')}


<div class='container-fluid'>
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">لیست سفارت خانه ها</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست سفارت خانه ها</h3>
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/embassies/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    سفارت جدید
                </a>
                <p class="text-muted m-b-30">در این قسمت می توانید لیست سفارت خانه های ثبت شده را مشاهده نموده  ویرایش و یا اطلاعات یک سفارتخانه جدید را وارد نمایید.</p>
                <div class='row'>
                    <div class='table-responsive table-bordered'>
                        <table id="myTable" class="table table-striped table-hover">
                            <thead class="thead-default">
                            <tr>
                                <th>شناسه</th>
                                <th>عنوان سفارت خانه</th>
                                <th>زبان</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $getEmbassies as $key => $embassy}
                            <tr>
                                <td>{$embassy['id']}</td>
                                <td>{$embassy['name']}</td>
                                <td class="align-middle">{$languages[$embassy['language']]}</td>
                                <td>
                                    <div class='d-flex flex-wrap gap-4'>
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/embassies/edit?id={$embassy['id']}">
                                            <button class="align-items-center gap-4 btn btn-info btn-outline d-flex rounded">
                                                <i class="fa fa-edit"></i>
                                                ویرایش
                                            </button>
                                        </a>
                                        <button onClick='removeEmbassy("{$embassy['id']}")' class="align-items-center gap-4 btn btn-danger btn-outline d-flex rounded">
                                            <i class="fa fa-trash"></i>
                                            حذف
                                        </button>
                                    </div>
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
</div>
<script type="text/javascript" src="assets/JsFiles/embassies.js"></script>
