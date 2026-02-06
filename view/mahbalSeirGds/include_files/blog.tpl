
{*with category*}
{*{assign var="search_array" value=['section'=>'mag','category'=>1,'limit'=>'3']}*}
{*{assign var='blog' value=$obj_main_page->getCategoryArticles($search_array)}*}
{*{assign var='counter' value=0}*}
{*{assign var="article_count" value=$blog|count}*}

{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'2']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}
{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <div class="i_modular_blog news recent_trip_area">
        <div class="container">
            <div class="titr">
                ##S360Blog##
            </div>
            <div class="row">
                    {if $blog[0]}
                    <div class="col-lg-6 big_news col-md-12 col-sm-12 col-12 d-flex-parent2">
                        <div class="single_trip eq">
                            <div class="thumb">
                                <img alt="{$blog[0]['alt']}" class="__image_class__" src="{$blog[0]['image']}"/>
                            </div>
                            <div class="info">
                                <div class="date">
                                    <a href="{$blog[0]['link']}">
                                        <span class="__title_class__"> {$blog[0]['title']}</span></a>
                                </div>
                                <h3 class="__description_class__ p-0">
                                    {$blog[0]['tiny_text']}
                                </h3>
                            </div>
                            <div class="star d-flex clearfix more_tour">
                                <a class="" href="{$blog[0]['link']}"><span>##Shownformation##</span></a>
                            </div>
                        </div>
                    </div>
                    {/if}
                    {if $blog[1]}
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 small_news d-flex-parent">
                        <div class="single_trip eq">
                            <div class="thumb">
                                <img alt="{$blog[1]['alt']}" class="__image_class__ " src="{$blog[1]['image']}"/>
                            </div>
                            <div class="info">
                                <div class="date">
                                    <a href="{$blog[1]['link']}">
                                        <span class="__title_class__"> {$blog[1]['title']}</span></a>
                                </div>
                                <h3 class="__description_class__ p-0">
                                    {$blog[1]['tiny_text']}
                                </h3>
                                <div class="more_tour">
                                    <a class="" href="{$blog[1]['link']}"><span>##Shownformation##</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {/if}
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <a class="btn_more" href="{$smarty.const.ROOT_ADDRESS}/mag">
                    ##ViewMore##
                    <i class="fa-light fa-chevron-left"></i>
                </a>
            </div>
        </div>
    </div>
{/if}