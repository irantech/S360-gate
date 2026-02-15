{assign var="article" value=$objArticles->getCategoryArticle($section,$title)}
{assign var="related_articles" value=$objArticles->RelatedArticles($article['id'])}
{assign var="user_info" value=$objMembers->getMember()}

{if $article && $article neq ''}



    {if $smarty.const.SOFTWARE_LANG eq 'en'}
        <link rel='stylesheet' href='assets/styles/css/modules-en/mag-en.css'>
    {else}
        <link rel='stylesheet' href='assets/modules/css/mag.css'>
    {/if}

{*<link rel='stylesheet' href='assets/modules/css/mag.css'>*}

<section class="mag_three">
    <div>
        <div class="d-flex flex-wrap">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 my-padding-mobile p-0">
                <div class="parent_box_right text-right">
                    <img class='main-img-banner' src="{$article['image']}" alt="{$article['alt']}">

                    <div class='d-block flex-wrap'>
                        <div class="owl-carousel owl-theme owl-gallery-mag">
                            {foreach $article['gallery'] as $gallery}

                                <div class="item">
                                    <a data-fancybox="gallery" href='{$gallery['src']}' class='link-owl-gallery-mag'>
                                        <img class="owl-gallery-img" src='{$gallery['src']}' alt='{$gallery['alt']}'>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <div class="tag_box gap-7">

                        {if isset($article['categories_array'])}
                            {foreach $article['categories_array'] as $category}
                                <a href="{$category['link']}" class="badge badge-primary px-2 py-1">
                                    {$category['title']}
                                </a>
                            {/foreach}
                        {/if}


                    </div>
                    <span class="h3">
                        {$article['title']}
                    </span>
                    <span class="calendar">
                          <i class="fa-light fa-calendar-days"></i>
                            {$article['created_at']}
                    </span>
                    {if $section eq 'news' and !empty($article['lead'])}
                        <div class="parent-lead">
                            <div class="bg-lead">

                            </div>
                        <div class="lead">
                            <p>{$article['lead']}</p>
                        </div>
                        </div>
                    {/if}
                    {if $article['content']}
                    <div class='content-whatever-special-pages'>{$article['content']}</div>
                    {/if}


                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/rates/rates.tpl"
                        data=$article['id']
                        item_id=$article['id']
                        section='mag'}

<!--                    <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                        <a href="javascript:" class="link_social icone_facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="javascript:" class="link_social icone_twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="javascript:" class="link_social icone_google">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="javascript:" class="link_social icone_linkedin">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="javascript:" class="link_social icone_telegram">
                            <i class="fab fa-telegram"></i>
                        </a>
                    </div>-->
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 p-0">

                {if $related_articles}
{*                <div class="post_parent_box">*}
{*                    {if $section eq 'mag'}*}
{*                        <h2>##RelatedArticles##</h2>*}
{*                    {else}*}
{*                        <h2>##RelatedNews##</h2>*}
{*                    {/if}*}

{*                    <div class="div_item">*}

{*                    </div>*}
{*                </div>*}
                    <div class="post_parent_box">
                        <div class="position-relative">
                            <i class="fa-solid fa-link"></i>
                            <h2>##RelatedArticles##</h2>
                        </div>
                        {foreach $related_articles as $related}
                            <a href="{$related['link']}" class="">
                                <div class="img_box">
                                    <img src="{$related['image']}" alt="{$related['alt']}">
                                </div>
                                <div class="text_box">
                                    <h6>
                                        {$related['heading']}
                                    </h6>
                                    <div>
                                        <span>
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"/></svg>
                                       {$related['created_at']}
                                    </span>
                                            <button class="submit_btn">
                                        <span>
                                            ##Show##
                                        </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                            </button>
                                    </div>
                                </div>
                            </a>
                        {/foreach}
                    </div>

                {/if}
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 p-0">
                {if $article['comments']|count>0}
            <div class="parent_comment_form">
                <div class='title-comment'>
                    <i class='fa fa-comments'></i>
                    <h2>##Comments## </h2>
                </div>
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/comments/comment.tpl"
                comments=$comments item_id=$item_id section=$section  comments=$article['comments']
                user_info=$user_info}

{*                {$article['comments']|var_dump}*}
            </div>
                {/if}
{*                {$article['id']|var_dump}*}
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/comments/comments.tpl"
                comments=$article['comments']
                user_info=$user_info
                item_id=$article['id']
                section=$section}
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="assets/modules/css/jquery.fancybox.min.css">
<script src="assets/modules/js/jquery.fancybox.min.js"></script>
<script src="assets/modules/js/mag.js"></script>
{else}
    404
{/if}