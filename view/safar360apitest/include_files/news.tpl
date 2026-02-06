{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>8]}
{assign var='articles' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=1}
{assign var="article_count" value=$articles|count}


<section class="i_modular_news news">
            <div class="container">
                <div class="title">
                    <h2>اخبار سفر360</h2>
                    <p> اخبار داغ مهاجرت، سفر و فرهنگ در یک نگاه. </p>
                </div>
                <div class="parent-news">
                    {assign var="count" value="1"}
                    {foreach $articles as $item}
                        {if $count <5 }
                        <a class="__i_modular_nc_item_class_0" href="{$item['link']}">
                            <div class="parent-img">
                                <img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
                            </div>
                            <div class="parent-text">
                                <h3 class="__title_class__">{$item["title"]}</h3>
                                <p class="__heading_class__">{$item["heading"]}</p>
                                <button class="btn-news">

                                    مشاهده

                                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239zM359 79L199 239c-9.4 9.4-9.4 24.6 0 33.9L359 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-143-143L393 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0z"></path>
                                    </svg>
                                </button>
                                <span class="__date_class__">{$item["created_at"]}</span>
                            </div>
                        </a>
                        {/if}
                        {$count = $count + 1}

                    {/foreach}


                </div>
            </div>
        </section>
