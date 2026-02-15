{load_presentation_object filename="articles" assign="objArticles"}
{if isset($smarty.get.category_id) && $smarty.get.category_id neq ''}
    {assign var="category_id" value=$smarty.get.category_id}
    {assign var="getCategory" value=$objArticles->getAdminCategory($category_id)}
{else}
    {assign var="category_id" value='0'}
    {assign var="getCategory" value=null}
{/if}
{assign var="getCategories" value=$objArticles->getCategories($category_id)}
{assign var="getServices" value=$objArticles->getServices()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if isset($getCategory) && $getCategory neq null}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/categories">
                             دسته بندی ها
                        </a>
                    </li>
                {/if}
                <li class='active'>
                    {if isset($getCategory) && $getCategory neq null}
                    زیر مجموعه ی دسته بندی {$getCategory['title']}
                    {else}
                        دسته بندی ها
                    {/if}
                </li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="border border-primary rounded white-box">
                <h3 class="box-title m-b-0 font-bold font-16">دسته بندی جدید</h3>
                <p class="text-muted  ">
                    در این قسمت میتوانید دسته بندی جدیدی ایجاد نمایید. توجه داشته باشید که:

                </p>
                <ul class='m-b-30'>
                    <li>دسته بندی تکراری نمیتوانید ایجاد کنید</li>

                </ul>

                <form id="storeCategory" method="post" enctype="multipart/form-data">
                    {if isset($getCategory) && $getCategory neq null}
                        <input type='hidden' value='{$category_id}' id='parent_id' name='parent_id'>
                    {/if}
                    <input type='hidden' value='storeCategory' id='method' name='method'>
                    <input type='hidden' value='articles' id='className' name='className'>


                    <div class="form-group col-sm-3">
                        <label for="title" class="control-label">نام</label>
                        <input type="text" class="form-control" name="title" value=""
                               id="title" placeholder=" نام دسته بندی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="slug" class="control-label">نامک</label>
                        <input type="text" class="form-control" name="slug" value=""
                               id="slug" placeholder="نامک جهت نمایش در نوار آدرس">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="slug" class="control-label">زبان</label>
                        <select name="language" class="form-control" id="language">
                            {foreach $languages as $value=>$title}
                                <option value="{$value}">{$title}</option>
                            {/foreach}
                        </select>
                    </div>


                    <div class="form-group col-sm-3">
                        <label for="image">تصویر شاخص</label>
                        <input type="file" name="image" id="image"
                               class="dropify" data-height="100"
                               data-default-file="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pic/articles/no-photo.png"/>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-info waves-effect waves-light">
                                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                                    ارسال اطلاعات
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">

            <div class="border border-primary rounded white-box">
                <h3 class="box-title m-b-0 font-bold font-16">لیست دسته بندی ها</h3>
                <p class="text-muted ">در اینجا شما میتوانید تمامی دسته بندی ها را مشاهده کنید</p>
                <p class="text-muted ">توجه داشته باشید که:</p>
                <ul class='m-b-30'>
                    <li>برای حذف دسته بندی خود، ابتدا همه مقاله های مربوط به دسته بندی مذکور را حذف نمایید.</li>

                </ul>
                <div class="table-responsive table-bordered">

                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>زبان</th>
                            <th>ترتیب</th>
                            <th>دسته بندی زیرمجموعه</th>
                            {*<th>اخبار</th>*}
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {foreach $getCategories as $key => $category}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td scope="row">{$rowNum}</td>
                                <td>{$category['title']}</td>
                                <td>{$languages[$category.language]}</td>
                                <td class="align-middle"  ><input type="number"  size="10" name="order[{$category.id}]" id="order" value="{$category['orders']}" class="list-order"></td>
                                <td>
                                    <a href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/categories?category_id={$category['id']}'
                                       class="align-items-center justify-content-center gap-4 btn btn-primary btn-outline d-flex rounded">
                                        <i class="fa fa-link"></i>
                                        زیرمجموعه ها
                                    </a>
                                </td>
                                {*
                                <td>
                                    <a href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/list?section=mag&category_id={$category['id']}'
                                       class="align-items-center justify-content-center gap-4 btn btn-primary btn-outline d-flex rounded">
                                        <i class="fa fa-link"></i>
                                        {$category.article_count}  خبر
                                    </a>
                                </td>
                                *}

                                <td class="d-flex flex-wrap gap-4">
                                    <button onclick='openEditCategoryModal("{$category['id']}")'
                                            class="align-items-center gap-4 btn btn-info btn-outline d-flex rounded">
                                        <i class="fa fa-edit"></i>
                                        ویرایش
                                    </button>
                                    <button {if $category.article_count>0} disabled {else} onclick='removeCategoryItem("{$category['id']}")' {/if}
                                            class="align-items-center gap-4 btn btn-danger btn-outline d-flex rounded">
                                        <i class="fa fa-ban"></i>
                                        حذف
                                    </button>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                    <input   class="btn btn-info" type="button" onclick='change_order_new()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModal">ویرایش دسته بندی</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='update_category' class="d-flex flex-wrap w-100" method="post" enctype="multipart/form-data">
                    <input type='hidden' value='updateCategory' id='method' name='method'>
                    <input type='hidden' value='articles' id='className' name='className'>
                    <input type='hidden' value='' id='update_id' name='category_id'>
                    {if isset($getCategory) && $getCategory neq null}
                        <input type='hidden' id='update_parent_id' value='{$category_id}' name='update_parent_id'>
                    {/if}


                    <div class="form-group col-sm-6">
                        <label for="update_title" class="control-label">نام</label>
                        <input type="text" class="form-control" name="update_title" value=""
                               id="update_title" placeholder=" نام شرکت را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="slug" class="control-label">نامک</label>
                        <input type="text" class="form-control" name="update_slug" value=""
                               id="slug" placeholder="نامک جهت نمایش در نوار آدرس">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="update_language" class="control-label">دسته بندی</label>
                        <select name="update_language" value='{$update_language}' class="form-control" id="update_language">
                            {foreach $languages as $value=>$title}
                                <option value="{$value}" {if $update_language == $value} selected{/if}>{$title}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="update_image">تصویر شاخص</label>
                        <input type="file" name="update_image" id="update_image"
                               class="dropify" data-height="100"
                               data-default-file="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pic/articles/no-photo.png"/>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                <button onclick='updateCategory()' type="button" class="btn btn-primary">ذخیره تغییرات</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/articles.js"></script>
<style>
    .shown-on-result {

    }
</style>