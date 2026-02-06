
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
    <section class="i_modular_blog blog">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>وبلاگ</h2>
                </div>
                <a href="{$smarty.const.ROOT_ADDRESS}/mag" class="more-title-safiran">
                    <span>بیشتر</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"/></svg>
                </a>
            </div>
            <div class="parent-blog">

                {if $blog[0]}
                    <a class="__i_modular_nc_item_class_0 project div3" href="{$blog[0]['link']}">
                        <div class="img">
                            <img alt="{$blog[0]['alt']}" class="__image_class__ img-fluid" src="{$blog[0]['image']}" />
                        </div>
                        <div class="text">
                            <h3 class="__title_class__">
                                {$blog[0]['title']}
                            </h3>
                            <p class="__heading_class__">
                                {$blog[0]['tiny_text']}
                            </p>
                            <div class="d-flex clearfix more_tour">
                                <span class="more_tour_btn">مشاهده جزئیات</span>
                            </div>
                        </div>
                    </a>
                {/if}

                {if $blog[1]}
                    <a class="__i_modular_nc_item_class_1 project div2" href="{$blog[1]['link']}">
                        <div class="img">
                            <img alt="{$blog[1]['alt']}" class="__image_class__ img-fluid" src="{$blog[1]['image']}" />
                        </div>
                        <div class="text">
                            <h3 class="__title_class__">
                                {$blog[1]['title']}
                            </h3>
                            <p class="__heading_class__">
                                {$blog[1]['tiny_text']}
                            </p>
                            <div class="d-flex clearfix more_tour">
                                <span class="more_tour_btn">مشاهده جزئیات</span>
                            </div>
                        </div>
                    </a>
                {/if}
                {if $blog[2]}
                    <a class="__i_modular_nc_item_class_2 project div1" href="{$blog[2]['link']}">
                        <div class="img">
                            <img alt="{$blog[2]['alt']}" class="__image_class__ img-fluid" src="{$blog[2]['image']}" />
                        </div>
                        <div class="text">
                            <h3 class="__title_class__">
                                {$blog[2]['title']}
                            </h3>
                            <p class="__heading_class__">
                                {$blog[2]['tiny_text']}
                            </p>
                            <div class="d-flex clearfix more_tour">
                                <span class="more_tour_btn">مشاهده جزئیات</span>
                            </div>
                        </div>
                    </a>
                {/if}
            </div>
        </div>
    </section>
{/if}