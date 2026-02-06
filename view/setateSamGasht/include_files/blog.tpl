

{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'3']}*}
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
        <div class="container">
            <div class="title-kanoun">
                <h4>پست های اخیر وبلاگ</h4>
                <h2>دنیای جدید در دستان شما، ماجراجویی‌های جدید در آخرین پست‌های وبلاگ ما </h2>
            </div>
            <div class="parent">

                {foreach $blog as $key => $item}
                    <a class="__i_modular_nc_item_class_0 div1" href="{$item['link']}">
                        <img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
                        <div>
                            <h2 class="__title_class__">{$item["title"]}</h2>
                            <p class="__heading_class__">{$item["heading"]}</p>
                        </div>
                    </a>
                {/foreach}


            </div>
        </div>
        <img alt="img" class="img3" src="project_files/images/h3-img-1.png" />
    </section>
{/if}