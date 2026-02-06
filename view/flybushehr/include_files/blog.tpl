

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
<section class="i_modular_blog blog container py-5">
<div class="titleBlog pb-4">
<h2>مقالات مفید</h2>
</div>
<div class="mainBlog">
{if $blog[0]}
<a class="__i_modular_c_item_class_0" href="{$blog[0]['link']}"><img alt="{$blog[0]['alt']}" class="__image_class__" src="{$blog[0]['image']}"/>
<div><h2 class="__title_class__">{$blog[0]['title']}</h2>
<p class="__heading_class__">{$blog[0]['heading']}</p>
</div>
</a>
{/if}
<div>
{if $blog[1]}
<a class="__i_modular_c_item_class_1" href="{$blog[1]['link']}"><img alt="{$blog[1]['alt']}" class="__image_class__" src="{$blog[1]['image']}"/>
<div><h2 class="__title_class__">{$blog[1]['title']}</h2>
<p class="__heading_class__">{$blog[1]['heading']}</p></div>
</a>
{/if}
{if $blog[2]}
<a class="__i_modular_c_item_class_2" href="{$blog[2]['link']}"><img alt="{$blog[2]['alt']}" class="__image_class__" src="{$blog[2]['image']}"/>
<div><h2 class="__title_class__">{$blog[2]['title']}</h2>
<p class="__heading_class__">{$blog[2]['heading']}</p></div>
</a>
{/if}
</div>
{if $blog[3]}
<a class="__i_modular_c_item_class_3" href="{$blog[3]['link']}"><img alt="{$blog[3]['alt']}" class="__image_class__" src="{$blog[3]['image']}"/>
<div><h2 class="__title_class__">{$blog[3]['title']}</h2>
<p class="__heading_class__">{$blog[3]['heading']}</p>
</div>
</a>
{/if}
{if $blog[4]}
<a class="__i_modular_c_item_class_4" href="{$blog[4]['link']}"><img alt="{$blog[4]['alt']}" class="__image_class__" src="{$blog[4]['image']}"/>
<div><h2 class="__title_class__">{$blog[4]['title']}</h2>
<p class="__heading_class__">{$blog[4]['heading']}</p></div>
</a>
{/if}
</div>
</section>
{/if}