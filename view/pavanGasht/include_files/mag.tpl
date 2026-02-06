{assign var="data_search_blog" value=['service'=>'Public','section'=>'mag', 'limit' =>10 , 'article_limit' => 6]}
{assign var='articlesCategories' value=$obj_main_page->articlesCategoriesMain($data_search_blog)}

{assign var='counter' value=1}
{assign var="article_count" value=$articles|count}

{if $articlesCategories|count > 0}
<section class="data_travel">
    <div class="container">
        <div class="titel_site titel_respancive">
            <h4>اطلاعات سفر</h4>
            <ul class="nav nav-pills " id="pills-tab3" role="tablist">

                {assign var="i" value=0}
                {foreach $articlesCategories as $category}
                    {if $i < 6}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {if $i eq 0} active show {/if}" id="pills-profile-tab3" data-toggle="pill"
                                data-target="#pills-article{$category['id']}" type="button" role="tab" aria-controls="pills-article{$category['id']}" aria-selected="false">{$category['title']}</button>
                    </li>
                    {/if}
                    {$i = $i + 1}
                {/foreach}

            </ul>
        </div>
        <div class="tab-content" id="pills-tabContent3">

            {assign var="i" value=0}
            {foreach $articlesCategories as $item}


                <div class="tab-pane fade  {if $i eq 0} active show {/if}" id="pills-article{$item['id']}" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="accordion" id="accordionExample-{$item['id']}">

                        {foreach $item['articles'] as $key => $article}
                            <div class="card">
                                <div class="card-header" id="heading{$article['id']}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-right collapsed btn_accordion btn_questions"
                                                type="button" data-toggle="collapse" data-target="#collapse{$article['id']}" aria-expanded="false" aria-controls="collapse{$article['id']}">
                                                <span class="info d-flex align-items-center">
                                                    <h3>{$article['title']}</h3>
                                                </span>
                                            <i class="far fa-angle-down rot_revers"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse{$article['id']}" class="collapse {if $key eq 0}  show {/if}" aria-labelledby="heading{$article['id']}" data-parent="#accordionExample-{$item['id']}">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap">
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-12 img_accordion position-relative">
                                                <a href="{$article['link']}" class="">
                                                    <img src="{$article['image']}" alt="{$article['title']}">
                                                </a>
                                            </div>
                                            <div class="col-lg-7 col-md-6 col-sm-12 col-12 text_accordion">
                                                <a href="{$article['link']}" class="btn_accordion ">
                                                    لینک
                                                </a>
                                                <span class="info">
                                                       <i class="far fa-calendar"></i>
                                                        {$objDate->jdate("j F , Y", $article['created_time'] , '', '', 'en')}
                                                </span>
                                                <p class="txt_color_accordion">
                                                    {$article['tiny_text']}
                                                </p>


                                                <a href="{$article['link']}" class="more_accordion">
                                                    بیشتر
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            {$i = $i + 1}
        {/foreach}
        </div>
    </div>
</section>
{/if}
