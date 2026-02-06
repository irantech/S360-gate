

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

{*                {$blog|var_dump}*}
            
    {if $check_general}
        <section class="i_modular_blog blog py-5">
        <div class="container">
            <div class="title">
            <h2>وبلاگ های پر طرفدار</h2>
            </div>
            <div class="parent">
            {if $blog[0]}
                <a class="__i_modular_c_item_class_0 div1" href="{$blog[0]['link']}">
                <img alt="{$blog[0]['alt']}" class="__image_class__" src="{$blog[0]['image']}"/>
                <div>
                <h2 class="__title_class__">{$blog[0]['title']}</h2>
                <h3 class="__heading_class__">{$blog[0]['tiny_text']|truncate:200}</h3>
                </div>
                </a>
            {/if}
            {if $blog[1]}
                <a class="__i_modular_c_item_class_1 div2" href="{$blog[1]['link']}">
                <img alt="{$blog[1]['alt']}" class="__image_class__" src="{$blog[1]['image']}"/>
                <div>
                <h2 class="__title_class__">{$blog[1]['title']}</h2>
                <h3 class="__heading_class__">{$blog[1]['tiny_text']|truncate:200}</h3>
                </div>
                </a>
            {/if}
            {if $blog[2]}
                <a class="__i_modular_c_item_class_2 div3" href="{$blog[2]['link']}">
                <img alt="{$blog[2]['alt']}" class="__image_class__" src="{$blog[2]['image']}"/>
                <div>
                <h2 class="__title_class__">{$blog[2]['title']}</h2>
                <h3 class="__heading_class__">{$blog[2]['tiny_text']|truncate:200}</h3>
                </div>
                </a>
            {/if}
            {if $blog[3]}
                <a class="__i_modular_c_item_class_3 div4" href="{$blog[3]['link']}">
                <img alt="{$blog[3]['alt']}" class="__image_class__" src="{$blog[3]['image']}"/>
                <div>
                <h2 class="__title_class__">{$blog[3]['title']}</h2>
                <h3 class="__heading_class__">{$blog[3]['tiny_text']|truncate:200}</h3>
                </div>
                </a>
            {/if}
            </div>
        </div>
        </section>
    {/if}