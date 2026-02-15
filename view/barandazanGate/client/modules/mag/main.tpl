{assign var="banner_selected_articles" value=$objArticles->getSelectedArticles($section)}
{assign var="selected_articles" value=$objArticles->getSelectedArticles($section,15)}
{*{assign var="categories" value=$objArticles->getCategories($section,'all')}*}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/mag-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/mag.css'>
{/if}


{if isset($smarty.get.page) && $smarty.get.page}
    {assign var="page_number" value=$smarty.get.page}
{else}
    {assign var="page_number" value='1'}
{/if}


{assign var="main_articles" value=$objArticles->getArticles($section,null,null,$page_number,'ASC')}
{assign var="favorite_articles" value=$objArticles->favoriteArticles($section ,null , null , 'ASC')}
{assign var="controversial_articles" value=$objArticles->controversialArticles($section)}


{if $banner_selected_articles['first_items']}
    <section class="box_one">
        <div class="parent_item">
            <div class="article">
                {foreach $banner_selected_articles['first_items'] as $article}
                    <a href="{$article['link']}">
                        <div class="parent_img">
                            <img src="{$article['image']}"
                                 alt="{$article['alt']}">
                        </div>
                        <div class="text_item">
                            {if $article['heading']}
                            <h2>{$article['heading']}</h2>
                            {/if}
                            <span>{$article['created_at']}</span>
                        </div>
                    </a>
                {/foreach}
            </div>
            {if $banner_selected_articles['center_item']}
            <div class="article">


                <a href="{$banner_selected_articles['center_item']['link']}" class="img-center">
                    <div class="parent_img">
                        <img src="{$banner_selected_articles['center_item']['image']}"
                             alt="{$banner_selected_articles['center_item']['alt']}">
                    </div>
                    <div class="text_item mobil_box">
                        <h2>{$banner_selected_articles['center_item']['heading']}</h2>
                        <span>{$banner_selected_articles['center_item']['created_at']}</span>
                    </div>
                    <div class="content_center">
                        <h2>
                            {$banner_selected_articles['center_item']['heading']}
                        </h2>
                        <span>{$banner_selected_articles['center_item']['created_at']}</span>
                    </div>
                </a>

            </div>
            {/if}
            <div class="article">
                {foreach $banner_selected_articles['second_items'] as $article}
                    <a href="{$article['link']}">
                        <div class="parent_img">
                            <img src="{$article['image']}"
                                 alt="{$article['alt']}">
                        </div>
                        <div class="text_item">
                            <h2>{$article['heading']}</h2>
                            <span>{$article['created_at']}</span>
                        </div>
                    </a>
                {/foreach}
            </div>
        </div>
    </section>
{/if}

<section class="box_two">

    <div class="d-flex flex-wrap">

        <div class="col-lg-3 col-md-4 col-sm-12 col-12 p-0">
            {if $controversial_articles}
            <div class="item_news">
                <div class="position-relative">
                    <i class="fa-regular fa-fire"></i>
                    <h2>##MostControversial##</h2>
                </div>
                {foreach $controversial_articles as $article}
                    <a href="{$article['link']}" class="">
                        <div class="img_box">
                            <img src="{$article['image']}" alt="{$article['alt']}">
                        </div>
                        <div class="text_box">
                            <h6>
                                {$article['heading']}
                            </h6>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"/></svg>
                                {$article['created_at']}
                            </span>
                        </div>
                    </a>
                {/foreach}
            </div>
            {/if}
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-12 p-0">
            <div class="d-flex flex-wrap">
                {if $main_articles['data']}
                {foreach $main_articles['data'] as $article}
                    <div class="col-lg-6 pl-0 padding-en padding_none mb-3 parent_mag_box_two">
                        <div class="mag_box_two">
                            <a href="{$article['link']}" class="btn_box_two">
                                <img src="{$article['image']}" alt="{$article['alt']}">
                            </a>
                            <div class='d-flex w-100 flex-wrap gap-7 mt-2'>
                                {if isset($article['categories_array'])}

                                {foreach $article['categories_array'] as $category}
                                    <a href='{$category['link']}' class='badge badge-primary px-2 py-1'>
                                        {$category['title']}
                                    </a>
                                {/foreach}
                                {/if}
                            </div>
                            <a href="{$article['link']}" class="btn_box_two">
                                <h3>
                                    {$article['title']}
                                </h3>
                            </a>
                            <p>
                                {$article['tiny_text']}
                            </p>
                            <div class="parent_submit">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"/></svg>
                                        {$article['created_at']}
                                    </span>
                                <a href="{$article['link']}" class="btn_box_two">
                                    <button class="submit_btn">
                                        <span>
                                            ##ViewMore##
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg>
                                    </button>
                                </a>
                            </div>
                            </a>
                        </div>
                    </div>
                {/foreach}
                {else}
                    <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                        ##NoInformationToDisplay##
                    </div>
                {/if}

                {if count($main_articles['data'])>5 || $page_number > 1  }
                <div class="col-12 pr-0">
                    <nav aria-label="...">
                        <ul class="gap-8 justify-content-center pagination">
                            <!-- Previous Button -->
                            <li class="page-item {if $page_number == 1} disabled {/if}">
                                <a class="page-link" href="{if $page_number > 1}{$smarty.const.ROOT_ADDRESS}/mag&page={$page_number-1}{/if}" tabindex="-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M85.14 475.8c-3.438-3.141-5.156-7.438-5.156-11.75c0-3.891 1.406-7.781 4.25-10.86l181.1-197.1L84.23 58.86c-6-6.5-5.625-16.64 .9062-22.61c6.5-6 16.59-5.594 22.59 .8906l192 208c5.688 6.156 5.688 15.56 0 21.72l-192 208C101.7 481.3 91.64 481.8 85.14 475.8z"/></svg>
                                    <span>##Previous##</span>
                                </a>
                            </li>

                            <!-- Page Links -->
                            {assign var="start_page" value=max(1, $page_number-2)}
                            {assign var="end_page" value=min(count($main_articles['links']), $page_number+2)}

                            <!-- If there are hidden pages at the start, show the first page and ellipsis -->
                            {if $start_page > 1}
                                <li class="page-item">
                                    <a class="page-link" href="{$smarty.const.ROOT_ADDRESS}/mag&page=1">1</a>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link more-page">...</span>
                                </li>
                            {/if}

                            <!-- Display the range of pages -->
                            {for $i=$start_page to $end_page}
                                <li class="page-item {if $i == $page_number} active {/if}">
                                    <a class="page-link" href="{$smarty.const.ROOT_ADDRESS}/mag&page={$i}">
                                        {$i}
                                    </a>
                                </li>
                            {/for}

                            <!-- If there are hidden pages at the end, show ellipsis and the last page -->
                            {if $end_page < count($main_articles['links'])}
                                <li class="page-item disabled">
                                    <span class="page-link more-page">...</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{$smarty.const.ROOT_ADDRESS}/mag&page={count($main_articles['links'])}">
                                        {count($main_articles['links'])}
                                    </a>
                                </li>
                            {/if}

                            <!-- Next Button -->
                            <li class="page-item {if $page_number >= count($main_articles['links'])} disabled {/if}">
                                <a class="page-link" href="{if $page_number < count($main_articles['links'])}{$smarty.const.ROOT_ADDRESS}/mag&page={$page_number+1}{/if}">
                                    <span>##NextOne##</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                {/if}

            </div>
        </div>
    </div>

</section>

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/mag/sliderBlog.tpl" articles=$favorite_articles}



<script src="assets/js/owl.carousel.min.js"></script>


<script>
</script>