

{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'2']}*}
{*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$blog|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'3']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <section class="i_modular_blog blog">
        <h3 class="w-100 title mb-5">مجله گردشگری</h3>
        <div class="container">
            <div class="parent-blogs">

            {foreach $blog as $key => $item}
                    <a class="__i_modular_nc_item_class_0 items-blog" href="{$item['link']}">
                        <div class="img-blog mask mask-hexagon">
                            <img alt='{$item["alt"]}' class="__image_class__ img-bg-blog"
                                 src='{$item["image"]}' />
                            <img alt="img-blog" class="img-log-blog" src="project_files/images/logo.png" />
                            <!-- <img class="img-form-blog" src="project_files/images/bg-blog.png" alt="">-->
                        </div>
                        <div class="text-blog">
                            <h5 class='__title_class__'>{$item["heading"]}</h5>
                            <p class="__title_class__">{$item["title"]}</p>
                            <div class="parent-btn-blog">
                                <button type="button">جزئیات</button>
                            </div>
                        </div>
                    </a>
            {/foreach}

            </div>
            <div class="owl-carousel owl-theme owl-blog">
                {foreach $blog as $key => $item}
                <div class="__i_modular_nc_item_class_0 item">
                    <a class="items-blog" href="{$item['link']}">
                        <div class="img-blog mask mask-hexagon">
                            <img alt="img" class="img-bg-blog" src="{$item["image"]}" />
                            <img alt="img-blog" class="img-log-blog" src="project_files/images/logo.png" />
                            <!--<img class="img-form-blog" src="project_files/images/bg-blog.png" alt="">-->
                        </div>
                        <div class="text-blog">
                            <h5 class='__title_class__'>{$item["heading"]}</h5>
                            <p>
                                {$item["title"]}
                            </p>
                            <div class="parent-btn-blog">
                                <button type="button">جزئیات</button>
                            </div>
                        </div>
                    </a>
                </div>
                {/foreach}

            </div>
            <div class="parent-btn-more-blog">
                <a class="" href="{$smarty.const.ROOT_ADDRESS}/mag">
                    <span>بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
{/if}