{load_presentation_object filename="articles" assign="objArticles"}

{*<code>{$getCategory|json_encode}</code>*}
{if isset($smarty.get.service) && in_array($smarty.get.service,array_keys($getServices))}

{/if}

{assign var="section" value=$smarty.get.section}

{assign var="category_id" value=$smarty.get.category_id}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $section eq 'mag'}
                    <li class='active'>لیست مقالات</li>
                {else}
                    <li class='active'>لیست اخبار</li>
                {/if}

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class='parent-toast-notifications'>
                <div class='parent-icon-notifications'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                </div>
                <div class='parent-description-notifications'>
                    <h3>همکار محترم،</h3>
                    <h4>نرم‌افزار سفر 360 به امکانات جدیدی برای سئو مجهز شده است، از جمله:</h4>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>افزودن Title و Description</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>استفاده از تگ h1</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>اتصال صفحات به یکدیگر</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>آدرس‌دهی دلخواه (Slug)</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>Canonical Link</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>ایجاد متن سؤالات دلخواه در صفحات</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>و...</span>
                        </li>
                    </ul>
                    <div class='parent-support'>
                        <p>برای اطلاع از چگونگی دسترسی به این امکانات، لطفاً با پشتیبانی ایران تکنولوژی تماس بگیرید.</p>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M375.8 275.2c-16.4-7-35.4-2.4-46.7 11.4l-33.2 40.6c-46-26.7-84.4-65.1-111.1-111.1L225.3 183c13.8-11.3 18.5-30.3 11.4-46.7l-48-112C181.2 6.7 162.3-3.1 143.6 .9l-112 24C13.2 28.8 0 45.1 0 64v0C0 295.2 175.2 485.6 400.1 509.5c9.8 1 19.6 1.8 29.6 2.2c0 0 0 0 0 0c0 0 .1 0 .1 0c6.1 .2 12.1 .4 18.2 .4l0 0c18.9 0 35.2-13.2 39.1-31.6l24-112c4-18.7-5.8-37.6-23.4-45.1l-112-48zM441.5 464C225.8 460.5 51.5 286.2 48.1 70.5l99.2-21.3 43 100.4L154.4 179c-18.2 14.9-22.9 40.8-11.1 61.2c30.9 53.3 75.3 97.7 128.6 128.6c20.4 11.8 46.3 7.1 61.2-11.1l29.4-35.9 100.4 43L441.5 464zM48 64v0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0s0 0 0 0"/></svg>
                            شماره تماس: 02188866609</span>
                    </div>
                </div>
            </div>

            <div class="white-box">


                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert?section={$section}"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    {if $section eq 'mag'}
                        مقاله جدید
                    {else}
                        خبر جدید
                    {/if}
                </a>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>زبان</th>
                            <th>ترتیب</th>
{*                            <th>تاریخ ثبت</th>*}
                            {if $section eq 'mag'}
                                <th>مکان نمایش</th>
                            {/if}
                            <th>وضعیت نمایش در سایت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_articles" value=$objArticles->getAdminArticles($section ,'1' , $category_id)}
                        {foreach $main_articles as $article}
                            {*<pre>{$article|json_encode}</pre>*}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$article.title}</td>
                                <td>{$languages[$article.language]}</td>
                                <td class="align-middle"  ><input type="number"  size="10" name="order[{$article.id}]" id="order" value="{$article['orders']}" class="list-order"></td>

                                {*<td>{$objFunctions->ConvertToJalaliOfDateGregorian($article.updated_at)}</td>*}
                                {if $section eq 'mag'}
                                    <td>
                                        {foreach $article['positions'] as $service_key=>$positions}
                                            <div class='badge badge-inverse d-flex flex-wrap gap-5'>
                                                {$objFunctions->Xmlinformation($service_key)} :
                                                {foreach $positions as $position_key=>$selected_position}
                                                    <div class="badge badge-purple">

                                                        {foreach $selected_position as $type_name=>$item}

                                                            {$item['title']}
                                                            {if $selected_position['destination'] && $type_name eq 'origin' }
                                                                به
                                                            {/if}
                                                        {/foreach}
                                                    </div>
                                                {/foreach}
                                            </div>
                                        {/foreach}
                                    </td>
                                {/if}

                                <td>
                                    <button class="btn btn-sm btn-outline btn-default"
                                            onclick='articleStateMain($(this),"{$article.id}")'>
                                        {if $article.state_site eq '1'}
                                            <i class="fa fa-star"></i>
                                            <span>
                                            نمایش در سایت
                                            </span>
                                        {else}
                                            <i class="fa fa-star-o"></i>
                                            <span>
                                            عدم نمایش در سایت
                                        </span>
                                        {/if}

                                    </button>
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/edit?id={$article.id}&section={if $section eq 'mag'}mag{else}news{/if}"><i
                                                class="fa fa-edit"></i>ویرایش </a>
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

{*                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/gallery?id={$article.id}"">*}
{*                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-image tooltip-primary"*}
{*                                        data-toggle ="tooltip" data-placement="top" title=""*}
{*                                        data-original-title="گالری">*}

{*                                    </i>*}
{*                                    </a>*}

                                    <button class="btn btn-sm btn-outline btn-danger deleteArticle"
                                            data-id="{$article.id}"><i class="fa fa-trash"></i> حذف
                                    </button>
                                </td>


                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <input   class="btn btn-info" type="button" onclick='change_order_article()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />

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