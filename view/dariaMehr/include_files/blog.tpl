

                {*with category*}
                {*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'8']}*}
                {*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
                {*{assign var='counter' value=0}*}
                {*{assign var="article_count" value=$blog|count}*}

                {assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'8']}
                {assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
                {assign var='counter' value=0}
                {assign var="article_count" value=$blog|count}
                {if $blog[0]}
                    {assign var='check_general' value=true}
                {/if}
            
{if $check_general}
<section class="i_modular_blog blog">
<div class="container">
<div class="title">
<h2>مجله سفر 360</h2>
<p>

                    آخرین وبلاگ و مقالات و اخبار مهاجرتی، گردشگری , علمی ، فرهنگی ، هنری و ورزشی.

                </p>
</div>
<div class="parent-blog">


                        

                        {foreach $blog as $key => $item}

                        
<a class="__i_modular_nc_item_class_0 item-blog" href="{$item['link']}">
<div class="parent-img-blog">
<img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}'/>
</div>
<div class="text-blog">
<h2 class="__title_class__">{$item["title"]}</h2>
</div>
</a>


                        {/foreach}
                        










</div>
<div class="owl-carousel owl-theme owl-blog">
<div class="__i_modular_nc_item_class_0 item">
<a class="item-blog" href="__link__">
<img alt="blog-img" class="__image_class__" src="project_files/images/pexels-kübra-arslaner-7594006.jpg"/>
<div class="text-blog">
<h2 class="__title_class__">عکسبرداری از اماکن</h2>
</div>
</a>
</div>





</div>
<a class="btn-more" href="{$smarty.const.ROOT_ADDRESS}/page/blog">

                ورود به دنیای گردشگری

                <i class="fa-solid fa-arrow-left"></i>
</a>
</div>
</section>
{/if}