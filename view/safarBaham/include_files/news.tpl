{assign var="main_articles" value=$obj_main_page->getNewsArticles()}
{assign var="othe_itmes" value=$main_articles['data']}
{assign var="i" value="2"}
{assign var='counter' value=0}

{if $othe_itmes }
<section class="i_modular_news news-demo">
    <div class="container">
        <div class="title-demo">
            <div class="">
                <h2>
                    <span class="square-title"></span>
                    <span>آخرین اخبار و رویدادها</span>
                </h2>
                <p>
                    با تازه‌ترین اخبار و اطلاعات روز از دنیای گردشگری و جاذبه‌های جذاب سراسر جهان همراه شوید.
                </p>
            </div>
            <a href="{$smarty.const.ROOT_ADDRESS}/news">
                        <span>
                            مشاهده همه
                        </span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
            </a>
        </div>
        <div class="parent-news-demo">
            <div class="box-news-demo-indicator">
                {if $othe_itmes[0] }

                <a href="{$othe_itmes[0]['link']}" class="__i_modular_c_item_class_0">
                    <div class="parent-img">
                        <img alt="{$othe_itmes[0]['alt']}" class="__image_class__" src="{$othe_itmes[0]['image']}"/>
                    </div>
                    <div class="parent-text">
                        <div class="parent-data-cate-news">
                            <div class="item-data-news-demo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                                <span class="__date_class__">{$othe_itmes[0]["created_at"]}</span>
                            </div>
                            <div class="item-data-cate-news-demo">
                                {if isset($othe_itmes[0]['categories_array'])}
                                    {foreach $othe_itmes[0]['categories_array'] as $category}
{*                                        <a href='{$category['link']}' >*}
                                            {$category['title']}
{*                                        </a>*}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <h4 class="__title_class__">
                            {$othe_itmes[0]['title']}
                        </h4>
                        <p class="__heading_class__">
                            {$othe_itmes[0]['tiny_text']}
                        </p>
                    </div>
                </a>
                {/if}
                {if $othe_itmes[1] }

                <a href="{$othe_itmes[1]['link']}" class="__i_modular_c_item_class_1">
                    <div class="parent-img">
                        <img alt="{$othe_itmes[1]['alt']}" class="__image_class__" src="{$othe_itmes[1]['image']}"/>
                    </div>
                    <div class="parent-text">
                        <div class="parent-data-cate-news">
                            <div class="item-data-news-demo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                                <span class="__date_class__">{$othe_itmes[1]["created_at"]}</span>
                            </div>
                            <div class="item-data-cate-news-demo">
                                {if isset($othe_itmes[1]['categories_array'])}
                                    {foreach $othe_itmes[1]['categories_array'] as $category}
                                        {*                                        <a href='{$category['link']}' >*}
                                        {$category['title']}
                                        {*                                        </a>*}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <h4 class="__title_class__">
                            {$othe_itmes[1]['title']}
                        </h4>
                        <p class="__heading_class__">
                            {$othe_itmes[1]['tiny_text']}
                        </p>
                    </div>
                </a>
                {/if}
            </div>
            <div class="box-news-demo-category">
                {if $othe_itmes[2] }

                <a href="{$othe_itmes[2]['link']}" class="__i_modular_c_item_class_2">
                    <div class="parent-img">
                        <img alt="{$othe_itmes[2]['alt']}" class="__image_class__" src="{$othe_itmes[2]['image']}"/>
                    </div>
                    <div class="parent-text">
                        <div class="parent-data-cate-news">
                            <div class="item-data-news-demo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                                <span class="__date_class__">{$othe_itmes[2]["created_at"]}</span>
                            </div>
                            <div class="item-data-cate-news-demo">
                                {if isset($othe_itmes[2]['categories_array'])}
                                    {foreach $othe_itmes[2]['categories_array'] as $category}
                                        {*                                        <a href='{$category['link']}' >*}
                                        {$category['title']}
                                        {*                                        </a>*}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <h4 class="__title_class__">
                            {$othe_itmes[2]['title']}
                        </h4>
                        <p class="__heading_class__">
                            {$othe_itmes[2]['tiny_text']}
                        </p>
                    </div>
                </a>
                {/if}
                {if $othe_itmes[3] }
                <a href="{$othe_itmes[3]['link']}" class="__i_modular_c_item_class_3">
                    <div class="parent-img">
                        <img alt="{$othe_itmes[3]['alt']}" class="__image_class__" src="{$othe_itmes[3]['image']}"/>
                    </div>
                    <div class="parent-text">
                        <div class="parent-data-cate-news">
                            <div class="item-data-news-demo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                                <span class="__date_class__">{$othe_itmes[3]['created_at']}</span>
                            </div>
                            <div class="item-data-cate-news-demo">
                                {if isset($othe_itmes[3]['categories_array'])}
                                    {foreach $othe_itmes[3]['categories_array'] as $category}
                                        {*                                        <a href='{$category['link']}' >*}
                                        {$category['title']}
                                        {*                                        </a>*}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <h4 class="__title_class__">
                            {$othe_itmes[3]['title']}
                        </h4>
                        <p class="__heading_class__">
                            {$othe_itmes[3]['tiny_text']}
                        </p>
                    </div>
                </a>
                {/if}
                {if $othe_itmes[4] }
                <a href="{$othe_itmes[4]['link']}" class="__i_modular_c_item_class_4">
                    <div class="parent-img">
                        <img alt="{$othe_itmes[4]['alt']}" class="__image_class__" src="{$othe_itmes[4]['image']}"/>
                    </div>
                    <div class="parent-text">
                        <div class="parent-data-cate-news">
                            <div class="item-data-news-demo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                                <span class="__date_class__">{$othe_itmes[4]["created_at"]}</span>
                            </div>
                            <div class="item-data-cate-news-demo">
                                {if isset($othe_itmes[4]['categories_array'])}
                                    {foreach $othe_itmes[4]['categories_array'] as $category}
                                        {*                                        <a href='{$category['link']}' >*}
                                        {$category['title']}
                                        {*                                        </a>*}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <h4 class="__title_class__">
                            {$othe_itmes[4]['title']}
                        </h4>
                        <p class="__heading_class__">
                            {$othe_itmes[4]['tiny_text']}
                        </p>
                    </div>
                </a>
                {/if}
                {if $othe_itmes[5] }
                <a href="{$othe_itmes[5]['link']}" class="__i_modular_c_item_class_5">
                    <div class="parent-img">
                        <img alt="{$othe_itmes[5]['alt']}" class="__image_class__" src="{$othe_itmes[5]['image']}"/>
                    </div>
                    <div class="parent-text">
                        <div class="parent-data-cate-news">
                            <div class="item-data-news-demo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                                <span class="__date_class__">{$othe_itmes[5]["created_at"]}</span>
                            </div>
                            <div class="item-data-cate-news-demo">
                                {if isset($othe_itmes[5]['categories_array'])}
                                    {foreach $othe_itmes[5]['categories_array'] as $category}
                                        {*                                        <a href='{$category['link']}' >*}
                                        {$category['title']}
                                        {*                                        </a>*}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <h4 class="__title_class__">
                            {$othe_itmes[5]['title']}
                        </h4>
                        <p class="__heading_class__">
                            {$othe_itmes[5]['tiny_text']}
                        </p>
                    </div>
                </a>
                {/if}
            </div>
        </div>
    </div>
</section>

{/if}