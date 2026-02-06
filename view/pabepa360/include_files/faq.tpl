{load_presentation_object filename="faqs" assign="faqs"}
{assign var="getServices" value=$faqs->getServices(True)}
{assign var="data_search_public" value=['service'=>$getServices]}
{assign var='faqs' value=$obj_main_page->faqsPositionMain($data_search_public)}

{if count($getServices) > 0}
<section class="Terms_Conditions">
    <div class="container">
        <div class="titr_Terms_Conditions">
            <h4>پرسش و پاسخ</h4>
            <ul class="nav nav-pills" id="Domestic_flight_navs" role="tablist">
                {foreach $getServices as  $key => $position}
                {if $position.countFaq>0}
                <li class="nav-item" role="presentation">
                    <button class="nav-link {if $key=='internalFlight'} active {/if}" id="Domestic_{$position.MainService}" data-toggle="pill" data-target="#Domestic_{$position.MainService}_body" type="button" role="tab" aria-controls="Domestic_{$position.MainService}_body" aria-selected="false" autocomplete="off">
                        {if $position.MainService == 'Bus' || $position.MainService == 'Train' }
                            بلیط
                        {/if}
                        {$position.Title}
                    </button>
                </li>
                {/if}
                {/foreach}
            </ul>
        </div>
        <div class="tab_Terms_Conditions">
            <div class="tab-content" id="Terms_Conditions">
                {foreach $faqs as  $key=>$position}
                {if count($position) > 0}
                <div class="tab-pane fade {if $key=='internalFlight'} active show {/if}" id="Domestic_{$key}_body" role="tabpanel" aria-labelledby="Domestic_{$key}">
                    <div class="accordion my_accordion" id="Domestic_{$key}_accordion">
                        {foreach $position as $key2=>$item}
                        <div class="card">
                            <div class="card-header" id="Domestic_{$item.service}_accordion_header_{$item.id}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-right btn_accordion btn_questions collapsed" type="button" data-toggle="collapse" data-target="#collapse_Domestic_{$item.service}_{$item.id}" aria-expanded="true" aria-controls="collapse_Domestic_{$item.service}_{$item.id}" autocomplete="off">
                                        {$item.title}
                                        <i class="far fa-angle-down rot_revers"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse_Domestic_{$item.service}_{$item.id}" class="collapse {if $item.service=='public'}  show {/if}" aria-labelledby="Domestic_{$item.service}_accordion_header_{$item.id}" data-parent="#Terms_Conditions" style="">
                                <div class="card-body">
                                    <p class="txt_color_accordion">
                                    </p><p style="text-align: right;"><span style="font-size: 12pt;">
                                                {$item.content}
                                            </span></p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        {/foreach}
                    </div>
                </div>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
</section>
{/if}