
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
                    
<section class="i_modular_blog articles">
<div class="container">
<div class="titr">
            اطلاعات مهم و برگزیده مقالات
        </div>
<div class="row">
{if $articles[0] }
<div class="__i_modular_c_item_class_0 masonry-box">
<div class="post-media">
<img alt="website template image" class="__image_class__ img-fluid" src="{$articles[0]['image']}"/>
<div class="shadoweffect">
<div class="shadow-desc">
<div class="blog-meta">
<h4>
<a href="{$articles[0]['link']}"><customr class="__title_class__">{$articles[0]['title']}</customr></a>
</h4>
</div>
<a class="btn btn_more" href="{$articles[0]['link']}">بیشتر بخوانید</a>
</div>
</div>
</div>
</div>
{/if}
{if $articles[1] }
<div class="__i_modular_c_item_class_1 masonry-box">
<div class="post-media">
<img alt="website template image" class="__image_class__ img-fluid" src="{$articles[1]['image']}"/>
<div class="shadoweffect">
<div class="shadow-desc">
<div class="blog-meta">
<h4>
<a href="{$articles[1]['link']}"><customr class="__title_class__">{$articles[1]['title']}</customr></a>
</h4>
</div>
<a class="btn btn_more" href="{$articles[1]['link']}">بیشتر بخوانید</a>
</div>
</div>
</div>
</div>
{/if}
{if $articles[2] }
<div class="__i_modular_c_item_class_2 masonry-box">
<div class="post-media">
<img alt="website template image" class="__image_class__ img-fluid" src="{$articles[2]['image']}"/>
<div class="shadoweffect">
<div class="shadow-desc">
<div class="blog-meta">
<h4>
<a href="{$articles[2]['link']}"><customr class="__title_class__">{$articles[2]['title']}</customr></a>
</h4>
</div>
<a class="btn btn_more" href="{$articles[2]['link']}">بیشتر بخوانید</a>
</div>
</div>
</div>
</div>
{/if}
{if $articles[3] }
<div class="__i_modular_c_item_class_3 masonry-box">
<div class="post-media">
<img alt="website template image" class="__image_class__ img-fluid" src="{$articles[3]['image']}"/>
<div class="shadoweffect">
<div class="shadow-desc">
<div class="blog-meta">
<h4>
<a href="{$articles[3]['link']}"><customr class="__title_class__">{$articles[3]['title']}</customr></a>
</h4>
</div>
<a class="btn btn_more" href="{$articles[3]['link']}">بیشتر بخوانید</a>
</div>
</div>
</div>
</div>
{/if}
{if $articles[4] }
<div class="__i_modular_c_item_class_4 masonry-box">
<div class="post-media">
<img alt="website template image" class="__image_class__ img-fluid" src="{$articles[4]['image']}"/>
<div class="shadoweffect">
<div class="shadow-desc">
<div class="blog-meta">
<h4>
<a href="{$articles[4]['link']}"><customr class="__title_class__">{$articles[4]['title']}</customr></a>
</h4>
</div>
<a class="btn btn_more" href="{$articles[4]['link']}">بیشتر بخوانید</a>
</div>
</div>
</div>
</div>
{/if}
</div>
</div>
</section>
{/if}