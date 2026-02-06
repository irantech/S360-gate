{assign var="data_search_public" value=['service'=> [['MainService' => 'Public']]]}
{assign var='faqs' value=$obj_main_page->faqsPositionMain($data_search_public)}

{if count($faqs) > 0}
<section class="your-question py-5">
    <div class="container">
        <div class="titleBlog pb-4">
            <h2>پرسش های متداول</h2>
        </div>
        <div id="accordion">
            {foreach $faqs['Public'] as  $key => $item}

            <div class="card">
                <div class="card-header" id="heading{$key}">
                    <h5 class="mb-0 parent-accordion">
                        <i class="fa-regular fa-question"></i>
                        <button class="btn btn-link collapsed w-100" data-toggle="collapse"
                                data-target="#collapse{$key}" aria-expanded="false"
                                aria-controls="collapse{$key}" autocomplete="off">
                            {$item.title}
                            <i class="far fa-angle-down mr-auto"></i>
                        </button>
                    </h5>
                </div>
                <div id="collapse{$key}" class="collapse" aria-labelledby="heading{$key}"
                     data-parent="#accordion" style="">
                    <div class="card-body">
                        {$item.content}
                    </div>
                </div>
            </div>

            {/foreach}
        </div>
    </div>
</section>
{/if}
