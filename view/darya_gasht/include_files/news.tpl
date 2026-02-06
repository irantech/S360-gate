{assign var="main_articles" value=$obj_main_page->getNewsArticles()}

{assign var="first_item" value=$main_articles['data'][0]}
{assign var="othe_itmes" value=$main_articles['data']|array_slice:1}

{if $main_articles['count'] > 0 }
    <section class="news recent_trip_area">
        <div class="container">
            <div class="title mb-4">
                <h2>
                    اخبار
                </h2>
            </div>
            <div class="row">
                <div class="eqWrap">
                    <div class="col-lg-6 big_news col-md-12 col-sm-12 col-12 d-flex-parent2">
                        <div class="single_trip eq ">
                            <div class="thumb">
                                <img src="{$first_item['image']}"
                                     alt="{$first_item['alt']}">
                            </div>
                            <div class="info">
                                <div class="date">
                                    <a href="{$first_item['link']}">
                                        <span>{$first_item['heading']}</span></a>
                                </div>
                                 {$first_item['heading']}
                            </div>
                            <div class="star d-flex clearfix more_tour">
                                <a class="" href="{$first_item['link']}"><span>مشاهده جزئیات</span></a>
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
                                        <h3 class="p-0 w-100">{$item['description']}</h3>
                                        <div class="more_tour mt-auto">
                                            <a  href="{$item['link']}"><span>##ViewDetails##</span></a>
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
    </section>
{/if}