

{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'5']}*}
{*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$blog|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'5']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <section class="i_modular_blog services-section">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <h2>مقالات مفید</h2>
                </div>
                <a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/mag">
                    <span>بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path>
                    </svg>
                </a>
            </div>
            <div class="services">
                {if $blog[0]}
                    <a class="__i_modular_c_item_class_0 service1" href="{$blog[0]['link']}">
                        <img alt="{$blog[0]['alt']}" class="__image_class__" src="{$blog[0]['image']}" />
                        <div>
                            <h2 class="__title_class__">{$blog[0]['title']}</h2>
                        </div>
                    </a>
                {/if}
                {if $blog[1]}
                    <a class="__i_modular_c_item_class_1 service2" href="{$blog[1]['link']}">
                        <img alt="{$blog[1]['alt']}" class="__image_class__" src="{$blog[1]['image']}" />
                        <div>
                            <h2 class="__title_class__">{$blog[1]['title']}</h2>
                        </div>
                    </a>
                {/if}
                {if $blog[2]}
                    <a class="__i_modular_c_item_class_2 service3" href="{$blog[2]['link']}">
                        <img alt="{$blog[2]['alt']}" class="__image_class__" src="{$blog[2]['image']}" />
                        <div>
                            <h2 class="__title_class__">{$blog[2]['title']}</h2>
                        </div>
                    </a>
                {/if}
                {if $blog[3]}
                    <a class="__i_modular_c_item_class_3 service4" href="{$blog[3]['link']}">
                        <img alt="{$blog[3]['alt']}" class="__image_class__" src="{$blog[3]['image']}" />
                        <div>
                            <h2 class="__title_class__">{$blog[3]['title']}</h2>
                        </div>
                    </a>
                {/if}
                {if $blog[4]}
                    <a class="__i_modular_c_item_class_4 service5" href="{$blog[4]['link']}">
                        <img alt="{$blog[4]['alt']}" class="__image_class__" src="{$blog[4]['image']}" />
                        <div>
                            <h2 class="__title_class__">{$blog[4]['title']}</h2>
                        </div>
                    </a>
                {/if}
            </div>
        </div>
    </section>
{/if}