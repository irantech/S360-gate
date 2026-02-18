{load_presentation_object filename="articles" assign="objArticles"}






<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class='active'>لیست مقالات </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a class="btn btn-primary rounded"
                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert">
                    <i class="fa fa-plus"></i>
                    مقاله جدید
                </a>


                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>زبان</th>
                            <th>تاریخ</th>
                            <th>مکان نمایش</th>
                            <th>دسته بندی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {foreach $objArticles->getArticles() as $article}
                            {*<pre>{$article|json_encode}</pre>*}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$article.title}</td>
                                <td>{$languages[$article.language]}</td>
                                <td>{$objFunctions->ConvertToJalaliOfDateGregorian($article.updated_at)}</td>
                                <td>
                                    {if $article.service_group neq 'Public'}
                                        {$article.city}
                                    {else}
                                        عمومی
                                    {/if}
                                </td>

                                <td>{$article.category.title}</td>

                                <td>
                                    <a class="btn btn-sm btn-outline btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/edit?id={$article.id}"><i
                                                class="fa fa-edit"></i>ویرایش </a>

                                    <!--                                    <button class="btn btn-sm{if $article.show_on_result ==0} btn-outline{/if} btn-info showOnResult"
                                            {if $article.show_on_result ==1}disabled="disabled"{/if}
                                            data-id="{$article.id}" data-position="{$article.position}"
                                            data-service-group="{$smarty.get.service}"><i class="fa fa-list"></i> نمایش
                                        در لیست
                                    </button>-->
                                    <button class="btn btn-sm btn-outline btn-default"
                                            onclick='articleSelectedToggle($(this),"{$article.id}")'>
                                        {if $article.selected eq '1'}
                                            <i class="fa fa-star"></i>
                                            <span>
                                            حذف از برگزیده
                                        </span>
                                        {else}
                                            <i class="fa fa-star-o"></i>
                                            <span>
                                            افزودن به برگزیده
                                        </span>
                                        {/if}

                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger deleteArticle"
                                            data-id="{$article.id}"><i class="fa fa-trash"></i> حذف
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

<script type="text/javascript" src="assets/JsFiles/articles.js"></script>
<style>
    .shown-on-result {

    }
</style>