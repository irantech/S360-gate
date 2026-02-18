<link rel='stylesheet' href='assets/modules/css/faq.css'>
{if $smarty.const.CLIENT_ID != '271'}
    <div id="accordion-faq"
         role="tablist"
         aria-multiselectable="true"
         class='parent-accordion flex-wrap w-100'>
        {foreach $faqs as $faq}
            <div class="panel panel-default card">
                <div class="panel-heading card-header" role="tab" id="heading-faq-{$faq.id}">
                    <h4 class="panel-title mb-0 parent-accordion">
                        <a class="collapsed btn-link w-100"
                           type='button'
                           data-toggle="collapse"
                           data-target="#collapse-faq-{$faq.id}"
                           aria-expanded="false"
                           aria-controls="collapse-faq-{$faq.id}">
                            {$faq.title}
                            <i class="fa fa-regular fa-question icone-question"></i>

                            {*                        <i class="fa fa-icone-arrow"></i>*}
                        </a>
                    </h4>
                </div>
                <div id="collapse-faq-{$faq.id}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-faq-1">
                    {$faq.content}
                </div>
            </div>
        {/foreach}
    </div>
{/if}