

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
    <section class="i_modular_blog blog">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <div class="parent-svg-title">
                        <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M512 337.2V52.4L344 77V373l168-35.8zM296 373V77L128 52.4V337.2L296 373zM523.4 2.2C542.7-.7 560 14.3 560 33.8V350.1c0 15.1-10.6 28.1-25.3 31.3l-201.3 43c-8.8 1.9-17.9 1.9-26.7 0l-201.3-43C90.6 378.3 80 365.2 80 350.1V33.8C80 14.3 97.3-.7 116.6 2.2L320 32 523.4 2.2zM38.3 23.7l10.2 2c-.3 2.7-.5 5.4-.5 8.1V74.6 342.1v66.7l265.8 54.5c2 .4 4.1 .6 6.2 .6s4.2-.2 6.2-.6L592 408.8V342.1 74.6 33.8c0-2.8-.2-5.5-.5-8.1l10.2-2C621.5 19.7 640 34.8 640 55V421.9c0 15.2-10.7 28.3-25.6 31.3L335.8 510.4c-5.2 1.1-10.5 1.6-15.8 1.6s-10.6-.5-15.8-1.6L25.6 453.2C10.7 450.2 0 437.1 0 421.9V55C0 34.8 18.5 19.7 38.3 23.7z"></path>
                        </svg>
                        <h2>مقالات مفید بیلیتیوم </h2>
                    </div>
                    <p>دنیای جدید در دستان شما، ماجراجویی‌های جدید در آخرین پست‌های وبلاگ ما </p>
                </div>
                <a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/page/blog">
                    <span>بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path>
                    </svg>
                </a>
            </div>
            <div class="owl-carousel owl-theme owl-tour-safiran">

                {foreach $blog as $key => $item}
                        <div class="__i_modular_nc_item_class_0 item">
                            <a class="__i_modular_nc_item_class_0 blog-item" href="{$item['link']}">
                                <div class="parent-img-blog">
                                    <img alt='{$item["alt"]}' class="__image_class__" src='{$item["image"]}' />
                                </div>
                                <div class="parent-text-blog">
                                    <h2 class="__title_class__">{$item["title"]}</h2>
                                    <p class="__heading_class__">{$item["heading"]}</p>
                                    <div>
                                        <p class="__date_class__ data-blog">{$item["created_at"]}</p>
                                        <span>نمایش مطلب</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    {/foreach}





            </div>
        </div>
    </section>
{/if}