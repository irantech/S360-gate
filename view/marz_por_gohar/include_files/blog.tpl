{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>4]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}

{if $articles}
<section class="blog">
    <div class="container">
        <div class="title">
            <div class="box-right">
                <svg class="svg-title svg-title-2" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                    <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                    <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                </svg>
                <div class="text-title">
                    <h3>مقالات مفید</h3>
                    <span>مشاهده آخرین و بروز ترین و مهمترین مقالات</span>
                </div>
            </div>
            <a href="{$smarty.const.ROOT_ADDRESS}/mag" class="more-title">
                مشاهده بیشتر
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
        <div class="parent-blog">
            {foreach $articles as $key => $article}
                 <a href="{$article['link']}" class="blog-item">
                    <div class="img-blog">
                        <img src="{$article['image']}" alt="{$article['title']}">
                    </div>
                    <div class="text-blog">
                        <h3>{$article['title']}</h3>
                        <p>
                            {$article['tiny_text']}
                        </p>
                        <button  class="btn-blog">ادامه مطلب</button>
                    </div>
                </a>
            {/foreach}

        </div>
    </div>
</section>
{/if}
