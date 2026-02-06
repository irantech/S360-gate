{assign var="data_search_public" value=['service'=>'Public','limit'=> 30]}
{assign var='faqs' value=$obj_main_page->faqsPosition($data_search_public)}
{if $faqs|count > 0}
<section class="container mt-5 accordion_sec">
    <div class="titr">
        سوالات متداول
    </div>
    <div class="">
        <div id="accordion">
            {foreach $faqs as $key => $faq}
            <div class="card">
                <div class="card-header" id="heading{$faq['id']}">
                    <h5 class="mb-0">
                        <button aria-controls="collapse{$faq['id']}" aria-expanded="true" class="btn btn-link" data-target="#collapse{$faq['id']}" data-toggle="collapse">
                            <i class="fa-regular fa-location-question" style="font-size: 20px; margin-left:5px;"></i>
                            {$faq['title']}
                        </button>
                    </h5>
                </div>
                <div aria-labelledby="heading{$faq['id']}" class="collapse {if $key==0} show {/if}" data-parent="#accordion" id="collapse{$faq['id']}">
                    <div class="card-body">
                        {$faq['content']}
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
    </div>
</section>
{/if}