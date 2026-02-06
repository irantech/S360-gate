

{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'5']}*}
{*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$blog|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'5']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <section class="i_modular_blog blog">
        <div class="container">
            <div class="title-site">
                <div>
                    <span></span>
                    <h2>مقالات مفید</h2>
                </div>
                <div class="line"></div>
                <a href="javascript:">

                    بیشتر

                    <i class="fa-duotone fa-chevrons-left"></i>
                </a>
            </div>
            <div class="owl-carousel owl-theme owl-blog">

                {foreach $blog as $key => $item}
                    <div class="__i_modular_nc_item_class_0 item">
                        <a class="link-blog" href="{$item['link']}">
                            <div class="parent-img-blog">
                                <img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
                                <div class="parent-comment-star">
                                    <div class="data-blog">
                                        <i class="fa-light fa-calendar-days"></i>
                                        <span class="__date_class__">{$item["created_at"]}</span>
                                    </div>
                                    <div class="comment-blog">
                                        <i class="fa-light fa-comment"></i>
                                        {$item['comments_count']['comments_count']}
                                    </div>
                                </div>
                            </div>
                            <div class="parent-text-blog">
                                <h3 class="__title_class__">{$item["title"]}</h3>
                                <p class="__heading_class__">{$item["heading"]}</p>
                                <button>

                                    مشاهده

                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                            </div>
                        </a>
                    </div>
                {/foreach}


            </div>
        </div>
    </section>
{/if}