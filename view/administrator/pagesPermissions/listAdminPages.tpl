{load_presentation_object filename="adminPages" assign="objPageAccess"}
{assign var="pageAccessList" value=$objPageAccess->getAllPages()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">تعریف صفحات ادمین</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تعریف صفحات ادمین</h3>
                <form id="pageForm" method="post">
                    <input type="hidden" id="page_id" name="id" value="">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="title">عنوان صفحه</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="عنوان صفحه" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="address">آدرس صفحه</label>
                            <input type="text" class="form-control text-left" id="address" name="address" placeholder="بقیه آدرس" required>
                        </div>
                        <div class="form-group col-sm-3" style="padding-top: 25px;">
                            <h5 dir="ltr" style="direction:ltr; unicode-bidi:embed;">
                                https://www.domain.com/gds/itadmin/
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
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
                <table id="myTable" class="table table-striped ">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان آدرس</th>
                        <th>آدرس</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var="number" value=0}
                    {foreach from=$pageAccessList item=item name=list}
                        {$number = $number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>{$item.title}</td>
                            <td>{$item.address}</td>
                            <td>
                                <a href="#" onclick="editPage('{$item.id}')">
                                    <i class="fcbtn btn btn-outline btn-primary btn-1f tooltip-primary ti-pencil-alt"
                                       data-toggle="tooltip" data-placement="top"
                                       title="ویرایش صفحه"></i>
                                </a>
                                <a href="#" onclick="deletePage('{$item.id}')">
                                    <i class="fcbtn btn btn-outline btn-danger btn-1f tooltip-danger ti-trash"
                                       data-toggle="tooltip" data-placement="top"
                                       title="حذف صفحه"></i>
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
<script type="text/javascript" src="assets/JsFiles/adminPages.js"></script>
