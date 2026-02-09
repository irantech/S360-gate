

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'3']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{assign var="first_item" value=$blog['data'][0]}
{assign var="othe_itmes" value=$blog['data']|array_slice:1}


{if $first_item}
    <div class="news recent_trip_area">
        <div class="container">
            <div class="titr">جدیدترین وبلاگ ها</div>
            <div class="row">

                <div class="col-lg-6 big_news col-md-12 col-sm-12 col-12 d-flex-parent2">

                    <div class="single_trip eq ">
                        <div class="thumb"><img
                                    src="{$first_item['image']}"
                                    alt="{$first_item['alt']}"></div>
                        <div class="info">
                            <div class="date">
                                <a href="{$first_item['link']}">
                                    <span>
                                        {$first_item['heading']}
                                    </span>
                                </a>
                            </div>
                            <h3 class="p-0">{$first_item['description']}</h3></div>
                        <div class="star d-flex clearfix more_tour"><a
                                    href="{$first_item['link']}"><span>##ViewDetails##</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 small_news d-flex-parent">
                    {assign var="counter" value=0}
                    {foreach $othe_itmes as $item}
                        {if $counter < 2}

                            <div class="single_trip eq">

                                <div class="thumb"><img src="{$item['image']}"
                                                        alt="{$item['alt']}">
                                </div>
                                <div class="info">
                                    <div class="date"><a
                                                href="{$item['link']}"><span>
                                                {$item['heading']}
                                            </span></a>
                                    </div>
                                    <h3 class="p-0">{$item['description']}</h3>
                                    <div class="more_tour"><a
                                                href="{$item['link']}"><span>##ViewDetails##</span></a>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {$counter = $counter + 1}
                    {/foreach}

                </div>

            </div>
        </div>
    </div>
{/if}