<section class="immigration-internal-page-blog">
    <div class="container">
        <div class="parent-immigration-blog">
            <div class="col-lg-3 col-md-12 col-sm-12 col-12 p-0">
                <div class="parent-sidebar-blog">
                    <h2>
                        دسترسی سریع
                    </h2>
                    <div class="parent-link-data">
                        {foreach $articles as $article}
                            <a href="javascript:" onclick="clickScroll({$article['id']})" class="link-data-immigration-blog">
                                <i class="fa-light fa-link"></i>
                                {$article['title']}
                            </a>
                        {/foreach}

                        <a href="javascript:" onclick="clickScroll('question')" class="link-data-immigration-blog">
                            <i class="fa-light fa-link"></i>
                            سوالات متداول
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 col-12 p-0">
                <div class="parent-text-blog">
                    {foreach $articles as $article}
                     <div class="" id="{$article['id']}">
                         <h2>{$article['title']}</h2>
                        <p>
                            {$article['content']}
                        </p>
                    </div>
                    {/foreach}
                </div>
                <div class="your-question" >
                    <div class="titr-text-blog" id="question">
                        <h2>سوالات متداول</h2>
                    </div>
                    <div id="accordion-faq-blog" role="tablist" aria-multiselectable="true">

                        {foreach $faqs as $faq}
                            <div class="panel-default-migration-blog card">
                            <div class="panel-heading " role="tab" id="heading-faq-11">
                                <h4 class="panel-title mb-0 parent-accordion-blog">
                                    <a class="btn-link-migration-blog w-100 collapsed" data-toggle="collapse" data-parent="#accordion-faq-blog" href="#Collapse-faq-11" aria-expanded="false" aria-controls="Collapse-faq-11">
                                        {$faq['title']}
                                        <i class="fa icone-arrow"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="Collapse-faq-11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-faq-11" style="">
                                <p>
                                    {$faq['content']}
                                </p>
                            </div>
                        </div>
                        {/foreach}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>