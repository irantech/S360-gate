{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>6]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}


<section class="articles">
    <div class="container d-flex flex-wrap">
        <h2 class="col-12 titel">مقالات مفید</h2>
        {foreach $articles as $key => $article}
            <div class="article_Box col-12 col-md-6 col-lg-4 p-1">
            <a class="article_a" href="{$article['link']}">
                <div class="article_img"><img src="{$article['image']}" alt="{$article['title']}"></div>
                <div class="article_text">
                    <i class="article_i">{$article['created_at']} </i>
                    <div class="article_box_star"><div class="article_box_starMain"><i class="fa fa-star"></i></div><span class="article_box_span"> امتیاز {$article['rates']['count']}از 5 (1 رای) </span></div>
                    <h5 class="article_titel">{$article['title']}</h5>
                    <p class="article_description">{$article['tiny_text']}</p>
                </div>
            </a>
        </div>
        {/foreach}
    </div>
</section>