
{assign var="category" value=$objArticles->unSlugCategory($smarty.const.MAG_CATEGORY)}
{assign var="search_array" value=[
'section'=>$section,
'category'=>$category['id'],
'limit'=>'10'
]}
{assign var="articles" value=$objArticles->getCategoryArticles($search_array)}
{assign var="subcategories" value=$objArticles->getSubCategories($section,$category['id'])}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/mag-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/mag.css'>
{/if}

<h2 class='title-category d-none'>{$category['title']}</h2>
{if $subcategories|count != 0}
<section class="category_one">
    <div class="container">
        <div class="category_box_item">
            {foreach $subcategories as $category}
                <div class="category_article_box">
                    <a href="{$category['link']}"
                       class="category_item_link">
                        <div class="category_parent_img">
                            <img src="{$category['image']}" alt="{$category['alt']}">
                        </div>
                        <h2>
                            <i class="fa fa-tag"></i>
                            {$category['title']}
                        </h2>
                    </a>
                </div>
            {/foreach}
        </div>
    </div>
</section>
{/if}

{if articles}
<section class="box_two">

    <div class="d-flex flex-wrap">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
            <div class="d-flex flex-wrap">
                {if !$articles}
                    <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                        ##NoInformationToDisplay##
                    </div>
                {/if}
                {foreach $articles as $article}
                    <div class="col-lg-4 pl-0 padding_none mb-3">
                        <div class="mag_box_two">
                            <a href="{$article['link']}" class="btn_box_two">
                                <img src="{$article['image']}" alt="{$article['alt']}">
                            </a>
                            <div class='d-flex w-100 flex-wrap gap-7 mt-2'>
                                {if isset($article['categories_array'])}
                                {foreach $article['categories_array'] as $category}
                                    <a href='{$category['link']}' class='badge badge-me px-2 py-1'>
                                        {$category['title']}
                                    </a>
                                {/foreach}
                                {/if}
                            </div>
                            <a href="{$article['link']}" class="btn_box_two">
                                <h3>
                                    {$article['heading']}
                                </h3>
                            </a>
                            <p>
                                {$article['tiny_text']}
                            </p>
                            <div class="parent_submit">
                                    <span>
                                        <i class="fa fa-light fa-calendar-days"></i>
                                        {$article['created_at']}
                                    </span>
                                <a href="{$article['link']}" class="btn_box_two">
                                    <button class="submit_btn">
                                        <span> ##ViewMore##</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                    </button>
                                </a>
                            </div>
                            </a>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

</section>
{/if}


