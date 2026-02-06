{assign var="main_articles" value=$obj_main_page->getNewsArticles()}
{assign var="othe_itmes" value=$main_articles['data']}
{assign var="i" value="2"}
{assign var='counter' value=0}

    {if $othe_itmes }
    <section class="i_modular_news news recent_trip_area">
        <div class="container">
            <div class="titr">

                اخبار مهم

            </div>
            <div class="row">
                {if $othe_itmes[0] }
                    <div class="__i_modular_c_item_class_0 single_news">
                        <div class="single_trip eq">
                            <div class="thumb">
                                <img alt="{$othe_itmes[0]['alt']}" class="__image_class__" src="{$othe_itmes[0]['image']}"/>
                            </div>
                            <div class="info">
                                <div class="date">
                                    <a href="">
                                        <span class="__title_class__">{$othe_itmes[0]['title']}</span>
                                    </a>
                                </div>
                                <h3 class="__heading_class__ p-0">{$othe_itmes[0]['heading']}</h3>
                                <a class="more_news btn_main" href="{$othe_itmes[0]['link']}"><span>مشاهده جزئیات</span></a>
                            </div>
                        </div>
                    </div>
                {/if}
                {if $othe_itmes[1] }
                    <div class="__i_modular_c_item_class_1 single_news">
                        <div class="single_trip eq">
                            <div class="thumb">
                                <img alt="{$othe_itmes[1]['alt']}" class="__image_class__" src="{$othe_itmes[1]['image']}"/>
                            </div>
                            <div class="info">
                                <div class="date">
                                    <a href="">
                                        <span class="__title_class__">{$othe_itmes[1]['title']}</span>
                                    </a>
                                </div>
                                <h3 class="__heading_class__ p-0">{$othe_itmes[1]['heading']}</h3>
                                <a class="more_news btn_main" href="{$othe_itmes[1]['link']}"><span>مشاهده جزئیات</span></a>
                            </div>
                        </div>
                    </div>
                {/if}
                {if $othe_itmes[2] }
                    <div class="__i_modular_c_item_class_2 single_news">
                        <div class="single_trip eq">
                            <div class="thumb">
                                <img alt="{$othe_itmes[2]['alt']}" class="__image_class__" src="{$othe_itmes[2]['image']}"/>
                            </div>
                            <div class="info">
                                <div class="date">
                                    <a href="">
                                        <span class="__title_class__">{$othe_itmes[2]['title']}</span>
                                    </a>
                                </div>
                                <h3 class="__heading_class__ p-0">{$othe_itmes[2]['heading']}</h3>
                                <a class="more_news btn_main" href="{$othe_itmes[2]['link']}"><span>مشاهده جزئیات</span></a>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </section>
{/if}