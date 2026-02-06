{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>5]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=1}
{assign var="article_count" value=$articles|count}

{if $articles}
    {$i = 1}

    <section class="services-section">
        <div class="container">
            <div class="services py-5 my-4">
                {assign var="count" value="1"}
                {foreach $articles as $key => $article}
                    {if $i < 5}
                        <a href="{$article['link']}" class="service{$i}">
                            <img src="{$article['image']}" alt="{$article['title']}">
                            <div>
                                <p>{$article['title']}</p>
                                <h2>{$article['heading']}</h2>
                            </div>
                        </a>
                    {/if}
                    {$i = $i + 1}
                {/foreach}

            </div>
        </div>
    </section>


{/if}

