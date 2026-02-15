{load_presentation_object filename="faqs" assign="objFaq"}
{assign var="send_data" value=['limit'=>50 , 'service' =>'Public', 'order' => 'DESC']}
{assign var='list_faq' value=$objFaq->getByPosition($send_data)}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/faq-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/faq.css'>
{/if}

<section class="your-question">
    <div class="container">
        <div id="accordion-faq" role="tablist" aria-multiselectable="true">
            {if $list_faq|count > 0}
                {foreach $list_faq as $key => $item}
            <div class="panel panel-default card">
                <div class="panel-heading card-header" role="tab" id="heading-faq-{$item['id']}">
                    <h4 class="panel-title mb-0 parent-accordion">
                        <a class="collapsed btn-link w-100" data-toggle="collapse" data-parent="#accordion-faq" href="#Collapse-faq-{$item['id']}" aria-expanded="false" aria-controls="Collapse-faq-{$item['id']}">
                            <i class=" icone-question">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 160c0-44.2 35.8-80 80-80h32c44.2 0 80 35.8 80 80v4.6c0 24.1-12 46.6-32.1 59.9l-52.3 34.9C133.4 274.2 120 299.2 120 326v2c0 13.3 10.7 24 24 24s24-10.7 24-24v-2c0-10.7 5.3-20.7 14.2-26.6l52.3-34.9c33.4-22.3 53.4-59.7 53.4-99.8V160c0-70.7-57.3-128-128-128H128C57.3 32 0 89.3 0 160c0 13.3 10.7 24 24 24s24-10.7 24-24zm96 320a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                            </i>
                            {$item['title']}
                            <i class="fa icone-arrow"></i>
                        </a>
                    </h4>
                </div>
                <div id="Collapse-faq-{$item['id']}" class="panel-collapse answer-faq collapse" role="tabpanel" aria-labelledby="heading-faq-{$item['id']}">
                    <p>
                        {$item['content']}
                    </p>
                </div>
            </div>
            {/foreach}
            {else}
                <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                    ##NoInformationToDisplay##
                </div>
            {/if}


        </div>
    </div>
</section>


{literal}
    <script src="assets/modules/js/faq/faq.js"></script>
{/literal}

