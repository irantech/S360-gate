{load_presentation_object filename="articles" assign="objArticles"}
{assign var="getServices" value=$objArticles->getServices()}
{*<code>{$positions|json_encode}</code>*}
{if isset($smarty.get.service) && in_array($smarty.get.service,array_keys($getServices))}

{/if}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class='active'> دسترسی ها </li>
            </ol>
        </div>
    </div>

    <div class="row bg-title">
        <div class="col-lg-12 col-sm-12 col-md-6 col-xs-12">

            {if isset($smarty.get['service']) AND isset($getServices[$smarty.get.service])}
                <a class="btn btn-primary rounded" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert?service={$smarty.get.service}">
                    <i class="fa fa-plus"></i>
                    مقاله جدید در بخش
                    <span class='font-bold'>
                    {$getServices[$smarty.get.service]['Title']}
                </span>
                </a>
                {else}
                <a class="btn btn-primary rounded" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert?service={$smarty.get.service}">
                    <i class="fa fa-link"></i>
                    نمایش آخرین مقالات
                </span>
                </a>
            {/if}


            <div class='w-100 mt-4'>
                <a class="btn btn-default rounded" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/categories">
                    <i class="fa fa-tags"></i>
                    دسته بندی ها
                </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {if isset($smarty.get.service) && in_array($smarty.get.service,array_keys($getServices))}
                <div class="white-box">
                    <h3 class="box-title m-b-0">لیست مطالب برای نمایش در نتایج {$getServices[$smarty.get.service]['Title']}</h3>
                    <div class="table-responsive table-bordered">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead class="thead-default">
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>زبان</th>
                                <th>تاریخ</th>
                                <th>مکان نمایش</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="rowNum" value=0}
                            {foreach $objArticles->getArticles($smarty.get.service) as $article}
                                {*<pre>{$article|json_encode}</pre>*}
                                {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$article.title}</td>
                                <td>{$languages[$article.language]}</td>
                                <td>{$objFunctions->ConvertToJalaliOfDateGregorian($article.updated_at)}</td>
                                <td>{$article.positionDisplay}</td>

                                <td>
                                    <a class="btn btn-sm btn-outline btn-primary" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/edit?id={$article.id}"><i class="fa fa-edit"></i>ویرایش </a>

                                    <button class="btn btn-sm{if $article.show_on_result ==0} btn-outline{/if} btn-info showOnResult" {if $article.show_on_result ==1}disabled="disabled"{/if} data-id="{$article.id}" data-position="{$article.position}" data-service-group="{$smarty.get.service}" ><i class="fa fa-list"></i> نمایش در لیست </button>
                                    <button class="btn btn-sm btn-outline btn-danger deleteArticle" data-id="{$article.id}" ><i class="fa fa-trash"></i> حذف </button>
                                </td>


                            </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            {else}
                <div class="white-box">
                    <h3 class="box-title m-b-0">لیست دسترسی های شما</h3>
                    <p class="text-muted m-b-30">در اینجا شما میتوانید تمامی بخشهایی که قابلیت نمایش مطالب را دارد مشاهده کنید</p>
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-hover">
                            <thead class="thead-default">
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="rowNum" value=0}
                            {foreach $getServices as $key => $serviceGroup}
                                {$rowNum=$rowNum+1}
                                <tr>
                                    <td scope="row">{$rowNum}</td>
                                    <td>{$serviceGroup['Title']}</td>
                                    <td>
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/categories?service={$key}"
                                           class="fcbtn btn btn-outline btn-success btn-1c"><i class="fa fa-list"></i> لیست مطالب </a>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/articles.js"></script>
<style>
    .shown-on-result{

    }
</style>