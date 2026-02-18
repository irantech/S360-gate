{assign var="banner_selected_articles" value=$objArticles->getSelectedArticles($section,3)}
{assign var="selected_articles" value=$objArticles->getSelectedArticles($section,3,4)}

{if isset($smarty.get.page) && $smarty.get.page}
    {assign var="page_number" value=$smarty.get.page}
{else}
    {assign var="page_number" value='1'}
{/if}


{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/news-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/news.css'>
{/if}



{assign var="main_articles" value=$objArticles->getArticles($section,null,null,$page_number,'ASC')}
{assign var="controversial_articles" value=$objArticles->controversialArticles($section)}
<section class="news-category">
    <div class="container">
        <div class="row">
            {if $controversial_articles|count > 0}
            <div class="col-lg-4 col-sm-12 col-12 news-category-l">
                {if $banner_selected_articles}
                <div class="owl-carousel owl-theme owl-news special-news">

                    {foreach $banner_selected_articles as $article}

                        <div class="item">
                            <a href="{$article['link']}" class="parent-owl-news">
                                <img src="{$article['image']}"
                                     alt="{$article['alt']}">
                                <div class="title-owl-news">
                                    <h3>{$article['title']}</h3>
                                    <span>##DateOfRelease##: {$article['created_at']} </span>
                                </div>
                            </a>
                        </div>

                    {/foreach}
                </div>
                {/if}
                <div class="news-category-item">
                    <div class="position-relative">
                        <i class="fa-regular fa-fire"></i>
                        <h2>##MostControversial##</h2>
                    </div>


                    {foreach $controversial_articles as $article}
                        <a href="{$article['link']}" class="">
                            <div class="img-news-category">
                                <img src="{$article['image']}" alt="{$article['alt']}">
                            </div>
                            <div class="text-news-category">
                                <h6>{$article['title']}</h6>
                                <span>
                                <i class="fa fa-calendar-days"></i>
                                {$article['created_at']}
                            </span>
                            </div>
                        </a>
                    {/foreach}

                </div>
            </div>
            {/if}
            <div class="col-lg-8 col-sm-12 col-12 parent-articles-news news-category-r">
                {if !$main_articles}
                    <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                        ##NoInformationToDisplay##
                    </div>
                {/if}
                {if count($main_articles['data'])>0}
                    {foreach $main_articles['data'] as $article}
                        <div class="news-card">
                            <a href="{$article['link']}" class="news-card-link">
                                <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                    <img src="{$article['image']}"
                                         alt="{$article['alt']}">
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                    <div class="card-text-link">
                                        {if $article['title']}
                                            <h2 class=''>
                                                {$article['title']}
                                            </h2>
                                        {/if}
                                        <div class="under-title">
                                    <span class="card-calendar">
                                        <i class="fa fa-calendar-days"></i>
                                                   {$article['created_at']}
                                    </span>
                                            <!--                                        <span class="card-seen">
                                                                                    10
                                                                                    <i class="fa fa-eye"></i>
                                                                                </span>-->
                                        </div>
                                        {if $article['tiny_text']}
                                            <p>
                                                {$article['tiny_text']}
                                            </p>
                                        {/if}
                                        <div class='submit-btn-parent'>
                                        <button class="submit-btn">
                                        <span>
                                            مشاهده
                                        </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    {/foreach}
                {else}
                    <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                        ##NoInformationToDisplay##
                    </div>
                {/if}
                {if count($main_articles['data'])>5}
                    <div class="col-12 pr-0">
                        <nav aria-label="...">
                            <ul class="gap-8 justify-content-center pagination">
                                <!-- Previous Button -->
                                <li class="page-item {if $page_number == 1} disabled {/if}">
                                    <a class="page-link" href="{if $page_number > 1}{$smarty.const.ROOT_ADDRESS}/news&page={$page_number-1}{/if}" tabindex="-1">
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
                                        <a class="page-link" href="{$smarty.const.ROOT_ADDRESS}/news&page=1">1</a>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link more-page">...</span>
                                    </li>
                                {/if}

                                <!-- Display the range of pages -->
                                {for $i=$start_page to $end_page}
                                    <li class="page-item {if $i == $page_number} active {/if}">
                                        <a class="page-link" href="{$smarty.const.ROOT_ADDRESS}/news&page={$i}">
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
                                        <a class="page-link" href="{$smarty.const.ROOT_ADDRESS}/news&page={count($main_articles['links'])}">
                                            {count($main_articles['links'])}
                                        </a>
                                    </li>
                                {/if}

                                <!-- Next Button -->
                                <li class="page-item {if $page_number >= count($main_articles['links'])} disabled {/if}">
                                    <a class="page-link" href="{if $page_number < count($main_articles['links'])}{$smarty.const.ROOT_ADDRESS}/news&page={$page_number+1}{/if}">
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


<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/modules/js/news.js"></script>
