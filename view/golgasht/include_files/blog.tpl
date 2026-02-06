{assign var="data_search_blog" value=['section'=>'article', 'limit' =>6]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$articles|count}
{if $articles}
    <section class="i_modular_hotels_external_cities hotel-ghods py-5">
        <div class="container">
            <h2 class="title mb-5">هتل های لوکس </h2>
            <div data-aos="fade-up">
                <div class="__hotel_function__external__city__ parent-tab-hotel">

                    {foreach $articles as $key => $article}
                        {if $counter >= 0 and $counter <= 6}


                        <div class="__i_modular_nc_item_class_0">
                            <a class="link-parent" href="{$article['link']}">
                                <img alt="{$article["alt"]}" class="__image_class__" src="{$article["image"]}"/>
                                <div class="text-hotel">
                                    {*                                        <div class="star-hotel">*}
                                    {*                                            {for $i = 0; $i < count($item['StarCode']); $i++}*}
                                    {*                                                <i class="__star_class_light__1 fa-solid fa-star"></i>*}
                                    {*                                            {/for}*}




                                    {*                                        </div>*}
                                    <h3 class="__title_class__">{$article["title"]}</h3>
{*                                    <span class="__city_class__">{$article["heading"]}</span>*}
                                </div>
                            </a>
                        </div>

                    {/if}
                        {$counter = $counter + 1}

                    {/foreach}






                </div>
            </div>
        </div>
    </section>
{/if}