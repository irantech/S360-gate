{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'3']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
<section class="i_modular_blog blog d-flex my-5 py-5">
<div class="container">
<h3 class="title">پیشنهاد هتلاتو</h3>
<div class="blog_grid">
{foreach $blog as $key => $item}
<a class="__i_modular_nc_item_class_0" href="{$item['link']}">
<div class="imgBox">
<img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
</div>
<div class="blog_txt">
<div class="blog_txt_header">
<h2 class="__title_class__">{$item["title"]}</h2>
</div>
</div>
</a>
{/foreach}



</div>
</div>
</section>
{/if}