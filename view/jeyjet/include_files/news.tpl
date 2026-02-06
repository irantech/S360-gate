{assign var="main_articles" value=$obj_main_page->getNewsArticles()}
{assign var="othe_itmes" value=$main_articles['data']}
{assign var="i" value="2"}
{assign var='counter' value=0}
{*{$othe_itmes|json_encode}*}
{if $othe_itmes }
        <section class="i_modular_news news">
            <div class="container">
                <div class="recent_trip_area">
                    <div class="container">
                        <div class="title-safiran">
                            <div class="text-title-safiran">
                                <h2>اخبار</h2>
                                <p>آگاهی از اخبار گردشگری ایران و جهان</p>
                            </div>
                            <a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/page/news">
                                <span>بیشتر</span>
                                <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="row">

                              {if $othe_itmes[0] }
                            <div class="col-lg-6 big_news col-md-12 col-sm-12 col-12 d-flex-parent2">
                                <div class="single_trip eq">
                                    <div class="thumb">
                                        <img alt="{$othe_itmes[0]['alt']}" class="__image_class__"
                                                            src="{$othe_itmes[0]['image']}" />
                                    </div>
                                    <div class="info">
                                        <div class="date">
                                            <a href="__link__">
                                    <span class="__title_class__">
                                        {$othe_itmes[0]['title']}
                                    </span>
                                            </a>
                                        </div>
                                        <h3 class="__description_class__ p-0">
                                            {$othe_itmes[0]['tiny_text']}
                                        </h3>
                                    </div>
                                    <div class="star d-flex clearfix more_tour"><a
                                                href="{$othe_itmes[0]['link']}"><span>مشاهده جزییات</span></a>
                                    </div>
                                </div>
                            </div>
                              {/if}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12 small_news d-flex-parent">
                               {if $othe_itmes[1] }
                                <div class="single_trip eq">
                                    <div class="thumb">
                                        <img alt="{$othe_itmes[1]['alt']}" class="__image_class__" src="{$othe_itmes[1]['image']}"/>

                                    </div>
                                    <div class="info">
                                        <div class="date"><a href="__link__"><span class="__title_class__">
                                                {$othe_itmes[1]['title']}
                                            </span></a>
                                        </div>
                                        <h3 class="__description_class__ p-0">
                                            {$othe_itmes[1]['tiny_text']}
                                        </h3>
                                        <div class="more_tour"><a href="{$othe_itmes[1]['link']}"><span>مشاهده جزییات</span></a>
                                        </div>
                                    </div>
                                </div>
                               {/if}
                               {if $othe_itmes[2] }
                                   <div class="single_trip eq">
                                       <div class="thumb">
                                           <img alt="{$othe_itmes[2]['alt']}" class="__image_class__" src="{$othe_itmes[2]['image']}"/>

                                       </div>
                                       <div class="info">
                                           <div class="date"><a href="__link__"><span class="__title_class__">
                                                {$othe_itmes[2]['title']}
                                            </span></a>
                                           </div>
                                           <h3 class="__description_class__ p-0">
                                               {$othe_itmes[2]['tiny_text']}
                                           </h3>
                                           <div class="more_tour"><a href="{$othe_itmes[2]['link']}"><span>مشاهده جزییات</span></a>
                                           </div>
                                       </div>
                                   </div>
                               {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    {/if}