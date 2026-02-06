

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
    <section class="i_modular_blog blog-demo">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>وبلاگ</h2>
                </div>
            </div>
            <div class="owl-carousel owl-theme owl-blog-demo">

                {foreach $blog as $key => $item}
                    <div class="__i_modular_nc_item_class_0 item">
                        <a class="items-tour-demo" href="{$item['link']}">
                            <div class="parent-img-demo">
                                <img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
                            </div>
                            <div class="parent-text-demo">
                                <div class="parent-data-and-comment">
                                    <div class="data-blog-demo">
                                        <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path>
                                        </svg>
                                        <span class="__date_class__">{$item["created_at"]}</span>
                                    </div>

                                    <div class="comment-blog-demo">
                                        <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z"></path>
                                        </svg>
                                        <span>{$item["comments_count"]['comments_count']}  کامنت</span>
                                    </div>
                                </div>
                                <h4 class="__title_class__">{$item["title"]}</h4>
                                <p class="__heading_class__">{$item["description"]}</p>
                                <button>
                                    <span>مطالعه وبلاگ</span>
                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </button>
                            </div>
                        </a>
                    </div>
                {/foreach}


            </div>
            <div class="bg-btn-karvan mx-auto mt-4">
                <a class="btn-karvan" href="{$smarty.const.ROOT_ADDRESS}/mag">
                    <span>بیشتر</span>
                    <i class="fa-solid fa-arrow-left mr-3"></i>
                </a>
            </div>
        </div>
    </section>
{/if}