
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'15']}*}
{*{assign var='articles' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$articles|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>15]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$articles|count}
{if $articles}

    <section class="i_modular_blog blogSection mb-5 py-5">
        <div class="container">
            <div class="clubTitle">
                <h2>وبلاگ</h2>
            </div>
            <div class="col-12 p-0 d-none d-lg-flex flex-wrap">
                <div class="parent">
                    {if $articles[0] }
                        <div class="__i_modular_c_item_class_0 tourSpecial_main div1">
                            <a href="{$articles[0]['link']}">
                                <img alt="blog" class="__image_class__" src="{$articles[0]['image']}"/>
                                <div>
                                    <h6 class="__title_class__">{$articles[0]['title']}</h6>
                                    <span class="__heading_class__">{$articles[0]['heading']}</span>
                                </div>
                            </a>
                        </div>
                    {/if}
                    {if $articles[1] }
                        <div class="__i_modular_c_item_class_1 tourSpecial_main div2">
                            <a href="{$articles[1]['link']}">
                                <img alt="blog" class="__image_class__" src="{$articles[1]['image']}"/>
                                <div>
                                    <h6 class="__title_class__">{$articles[1]['title']}</h6>
                                    <span class="__heading_class__">{$articles[1]['heading']}</span>
                                </div>
                            </a>
                        </div>
                    {/if}
                    {if $articles[2] }
                        <div class="__i_modular_c_item_class_2 tourSpecial_main div3">
                            <a href="{$articles[2]['link']}">
                                <img alt="blog" class="__image_class__" src="{$articles[2]['image']}"/>
                                <div>
                                    <h6 class="__title_class__">{$articles[2]['title']}</h6>
                                    <span class="__heading_class__">{$articles[2]['heading']}</span>
                                </div>
                            </a>
                        </div>
                    {/if}
                    {if $articles[3] }
                        <div class="__i_modular_c_item_class_3 tourSpecial_main div4">
                            <a href="{$articles[3]['link']}">
                                <img alt="blog" class="__image_class__" src="{$articles[3]['image']}"/>
                                <div>
                                    <h6 class="__title_class__">{$articles[3]['title']}</h6>
                                    <span class="__heading_class__">{$articles[3]['heading']}</span>
                                </div>
                            </a>
                        </div>
                    {/if}
                    {if $articles[4] }
                        <div class="__i_modular_c_item_class_4 tourSpecial_main div5">
                            <a href="{$articles[4]['link']}">
                                <img alt="blog" class="__image_class__" src="{$articles[4]['image']}"/>
                                <div>
                                    <h6 class="__title_class__">{$articles[4]['title']}</h6>
                                    <span class="__heading_class__">{$articles[4]['heading']}</span>
                                </div>
                            </a>
                        </div>
                    {/if}
                </div>
            </div>
            <div class="col-12 p-0 d-flex d-lg-none flex-wrap">
                <div class="owl-blogSection owl-carousel owl-theme py-3">
                    {foreach $articles as $key => $article} {if $counter >= 0 and $counter <= 5}
                        <div class="__i_modular_nc_item_class_0 item">
                            <div class="tourSpecial_main">
                                <a href="{$article['link']}">
                                    <img alt="blog" class="__image_class__" src='{$article["image"]}'/>
                                    <div>
                                        <h6 class="__title_class__">{$article["title"]}</h6>
                                        <span class="__heading_class__">{$article["heading"]}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    {/if}{$counter = $counter + 1}{/foreach}





                </div>
            </div>
            <div class="blogMain py-3">
                <div>
                    <div class="w-100 d-flex justify-content-center align-items-center mt-3">
                        <a class="btn_more" href="{$smarty.const.ROOT_ADDRESS}/mag">بیشتر</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}