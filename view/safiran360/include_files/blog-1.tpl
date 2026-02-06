
                        {*with category*}
                        {*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'14']}*}
                        {*{assign var='articles' value=$obj_main_page->getCategoryArticles($search_array)}*}
                        {*{assign var='counter' value=0}*}
                        {*{assign var="article_count" value=$articles|count}*}
        
                        {assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>14]}
                        {assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
                        {assign var='counter' value=0}
                        {assign var="article_count" value=$articles|count}
                        {if $articles}
                    
<section class="i_modular_blog blog-safiran">
<div class="container">
<div class="title-safiran">
<div class="text-title-safiran">
<h2>پست های اخیر وبلاگ</h2>
<p>دنیای جدید در دستان شما، ماجراجویی‌های جدید در آخرین پست‌های وبلاگ ما</p>
</div>
<a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/mag">
<span>وبلاگ بیشتر</span>
<svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
</a>
</div>
<div class="owl-carousel owl-theme owl-blog-safiran">
{foreach $articles as $key => $article} {if $counter >= 0 and $counter <= 4}
<div class="__i_modular_nc_item_class_0 item">
<a class="link-blog" href="{$article['link']}">
<div class="parent-img-blog">
<img alt='{$article["alt"]}' class="__image_class__" src='{$article["image"]}'/>
<div class="parent-comment-star">
<div class="data-blog">
<i class="fa-light fa-calendar-days"></i>
<span class="__date_class__">{$article["created_at"]}</span>
</div>
<div class="comment-blog">
<i class="fa-light fa-comment"></i>
                                       10
                                   </div>
</div>
</div>
<div class="parent-text-blog">
<h3 class="__title_class__">{$article["title"]}</h3>
<p class="__heading_class__">{$article["heading"]}</p>
<button>
                                   مشاهده بیشتر
                                   <i class="fa-solid fa-arrow-left"></i>
</button>
</div>
</a>
</div>
{/if}{$counter = $counter + 1}{/foreach}




</div>
</div>
</section>
{/if}