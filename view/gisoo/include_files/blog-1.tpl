
{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'13']}*}
{*{assign var='articles' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$articles|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>13]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$articles|count}
{if $articles}

    <div class="i_modular_blog blog-gisoo">
        <div class="container">
            <div class="parent-bg-gisoo">
                <div class="title-gisoo">
                    <div class="text-title-gisoo">
                        <h2>پست های اخیر وبلاگ</h2>
                        <p>دنیای جدید در دستان شما، ماجراجویی‌های جدید در آخرین پست‌های وبلاگ ما</p>
                    </div>
                    <a class="more-title-gisoo" href="{$smarty.const.ROOT_ADDRESS}/mag">
                        <span>وبلاگ های بیشتر</span>
                        <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
                    </a>
                </div>
                <div class="parent-blog-gisso">
                    {foreach $articles as $key => $article} {if $counter >= 0 and $counter <= 3}
                        <a class="__i_modular_nc_item_class_0 items-blogs" href="{$article['link']}">
                            <div class="parent-img-blog">
                                <img alt='{$article["alt"]}' class="__image_class__" src='{$article["image"]}'/>
                                <h2 class="__title_class__">{$article["title"]}</h2>
                            </div>
                            <div class="parent-text-blog">
                                <div class="data-blog">
                                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"></path></svg>
                                    <span class="__date_class__">{$article["created_at"]}</span>
                                </div>
                                <p class="__heading_class__">{$article["tiny_text"]}</p>
                            </div>
                        </a>
                    {/if}{$counter = $counter + 1}{/foreach}



                </div>
            </div>
        </div>
    </div>
{/if}