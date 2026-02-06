{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>5]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=1}
{assign var="article_count" value=$articles|count}
{if $articles}
<section class="blog d-flex py-5">
    <div class="container">
        <div class="title">
            <h2>وبلاگ</h2>
        </div>
        <div class="mainBlog">
            {assign var="i" value="1"}
            {foreach $articles as $key => $article}
                {if $i < 6}
                    {if $i == 2}<div>{/if}
                    <a href="{$article['link']}"><img  src="{$article['image']}" alt="{$article['title']}">
                        <div><h2>{$article['title']}</h2>
                            <p>
                                {$article['description']}
                            </p>
                        </div>
                    </a>
                    {if $i == 3}</div>{/if}
                    {$i = $i + 1}
                {/if}
            {/foreach}
        </div>
        <div class="moreBtnMobile justify-content-center mt-3"><a href="{$smarty.const.ROOT_ADDRESS}/mag" class="button">بیشتر</a></div>
    </div>
</section>


{/if}