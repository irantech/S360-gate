

{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'4']}*}
{*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$blog|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'4']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <section class="i_modular_blog blog-demo">
        <div class="bg-absolute4"></div>
        <div class="container">
            <div class="title-demo">
                <div class="">
                    <h2>
                        <span class="square-title"></span>
                        <span>جدیدترین وبلاگ ها</span>
                    </h2>
                    <p>

                        دنیای جدید در دستان شما، ماجراجویی های جدید در آخرین پست های وبلاگ ما.

                    </p>
                </div>
                <a href="{$smarty.const.ROOT_ADDRESS}/mag">
<span>

                            مشاهده همه

                        </span>
                    <svg viewbox="0 0 256 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"></path>
                    </svg>
                </a>
            </div>
            <div class="blog-grid">
                {if $blog[0]}
                    <div class="__i_modular_c_item_class_0 div1">
                        <a href="{$blog[0]['link']}">
                            <img alt="{$blog[0]['alt']}" class="__image_class__" src="{$blog[0]['image']}" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$blog[0]['title']}</h4>
                                    <span class="__heading_class__">{$blog[0]['tiny_text']}</span>
                                </div>
                                <i>
                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}
                {if $blog[1]}
                    <div class="__i_modular_c_item_class_1 div2">
                        <a href="{$blog[1]['link']}">
                            <img alt="{$blog[1]['alt']}" class="__image_class__" src="{$blog[1]['image']}" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$blog[1]['title']}</h4>
                                    <span class="__heading_class__">{$blog[1]['tiny_text']}</span>
                                </div>
                                <i>
                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}
                {if $blog[2]}
                    <div class="__i_modular_c_item_class_2 div3">
                        <a href="{$blog[2]['link']}">
                            <img alt="{$blog[2]['alt']}" class="__image_class__" src="{$blog[2]['image']}" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$blog[2]['title']}</h4>
                                    <span class="__heading_class__">{$blog[2]['tiny_text']}</span>
                                </div>
                                <i>
                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}
                {if $blog[3]}
                    <div class="__i_modular_c_item_class_3 div4">
                        <a href="{$blog[3]['link']}">
                            <img alt="{$blog[3]['alt']}" class="__image_class__" src="{$blog[3]['image']}" />
                            <div>
                                <div>
                                    <h4 class="__title_class__">{$blog[3]['title']}</h4>
                                    <span class="__heading_class__">{$blog[3]['tiny_text']}</span>
                                </div>
                                <i>
                                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"></path>
                                    </svg>
                                </i>
                            </div>
                        </a>
                    </div>
                {/if}
            </div>
        </div>
    </section>
{/if}