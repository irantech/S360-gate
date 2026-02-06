

{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'4']}*}
{*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$blog|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'4']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <section class="i_modular_blog blog-mahe-asal">
        <div class="container">
            <div class="title">
                <p>پست های اخیر وبلاگ </p>
                <h2>دنیای جدید در دستان شما، ماجراجویی‌های جدید در آخرین پست‌های وبلاگ ما</h2>
                <img alt="img-title" src="project_files/images/img-title.png" />
            </div>
            <div class="parent-blog">

                {foreach $blog as $key => $item}
                    <a class="__i_modular_nc_item_class_0" href="{$item['link']}">
                        <div class="parent-img-blog">
                            <img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
                        </div>
                        <div class="text-blog">
                            <h2 class="__title_class__ col-10 p-0">{$item["title"]}</h2>
                            <i class="col-2 p-0">
                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L199 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 233 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239zM391 47L199 239c-9.4 9.4-9.4 24.6 0 33.9L391 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-175-175L425 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0z"></path>
                                </svg>
                            </i>
                        </div>
                    </a>
                {/foreach}


            </div>
        </div>
    </section>
{/if}