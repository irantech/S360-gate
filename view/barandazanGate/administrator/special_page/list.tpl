{load_presentation_object filename="specialPages" assign="objSpecialPages"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class='active'>صفحات ویژه</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/special_page/insert"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    صفحه ی ویژه جدید
                </a>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نوع</th>
                            <th>عنوان</th>
                            <th>لینک صفحه در سایت</th>
                            <th>زبان</th>
                            <th>سرچ باکس</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_special_pages" value=$objSpecialPages->getSpecialPages()}
                        {foreach $main_special_pages as $page}
                            {*<pre>{$faq|json_encode}</pre>*}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>
                                    {if $page.page_type eq 'separate'}
                                        <img loading="lazy"
                                             style='width: 25px;'
                                             src="assets/images/git.png"
                                             alt="" />
                                        مجزا
                                    {else}
                                        <img loading="lazy"
                                             style='width: 25px;'
                                             src="assets/images/link.png"
                                             alt="" />
                                        وابسته
                                    {/if}
                                </td>
                                <td>{$page.title}  /{$page.slug}</td>
                                <td><a target='_blank' href='http://{$smarty.const.CLIENT_DOMAIN}/gds/{$page.language}/page/{$page.slug}'>
                                        http://{$smarty.const.CLIENT_DOMAIN}/gds/{$page.language}/page/{$page.slug}
                                    </a></td>
                                <td>{$languages[$page.language]}</td>
                                <td>
                                    {if $page.page_type eq 'separate'}
                                        {if $page.position neq NULL}
                                            <span class='fa fa-check-square bg-success rounded-max p-3'></span>
                                            {$objFunctions->Xmlinformation($page.position)}
                                        {else}
                                            <span class='fa fa-sticky-note bg-warning rounded-max p-3'></span>
                                            بدون سرچ باکس
                                        {/if}
                                    {else}
                                        {if $page.position eq 'MainPage'}
                                            <span class='fa fa-home bg-primary rounded-max p-3'></span>
                                            صفحه اصلی
                                        {elseif $page.position eq NULL}
                                            <span class='fa fa-sticky-note bg-warning rounded-max p-3'></span>
                                            بدون سرچ باکس
                                        {else}
                                            <span class='fa fa-check-square bg-success rounded-max p-3'></span>
                                            {$objFunctions->Xmlinformation($page.position)}
                                        {/if}

                                    {/if}
                                </td>


                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/special_page/edit?id={$page.id}"><i
                                                class="fa fa-edit"></i>ویرایش </a>


                                    <button class="btn btn-sm btn-outline btn-danger deleteSpecialPage"
                                            data-id="{$page.id}">
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

<script type="text/javascript" src="assets/JsFiles/special_page.js"></script>
<style>
    .shown-on-result {

    }
</style>