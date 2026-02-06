{if isset($smarty.get.page) && $smarty.get.page}
    {assign var="page_number" value=$smarty.get.page}
{else}
    {assign var="page_number" value='1'}
{/if}
{assign var="recommendation_list" value=$objRecommendation->getRecommendations(null,null,$page_number)}
{assign var="recommendation_count" value=$objRecommendation|count}


{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/recommendation-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/recommendation.css'>
{/if}





<div class="migration">
    <div class="">
        {if $recommendation_list['data']}
        <div class="box-video">
            <div class="parent-items-recommendation">
                {foreach $recommendation_list['data'] as $recommendation}

                    <div class="items-recommendation">
                    <div class="card d-flex mx-auto">
                        <div class="card-image">
                            {if $recommendation.avatar_image}
                            <img class="img-fluid d-flex mx-auto" src="{$recommendation.avatar_image}" alt='{$recommendation.country.titleFa}'>
                            {/if}
                        </div>
                        <div class="card-text">
                            <div class="card-title">
                                <a href='{$smarty.const.ROOT_ADDRESS}/recommendation/{$recommendation['id']}'>
                                {$recommendation.fullName}
                                </a>
                                <span class="visa-sub">

                                    {$recommendation.profession}
                                    {if $recommendation.country.titleFa || $recommendation.country.titleEn}
                                    _
                                    ##Visa## {if $smarty.const.SOFTWARE_LANG eq 'fa'}{$recommendation.country.titleFa} {else} {$recommendation.country.titleEn}{/if}</span>

                                {/if}
                            </div>
                            <div class="card-title">
                                <span class="visa-sub">{$recommendation.visa_type['title']} </span>
                            </div>
                            <p class='recommendation-p'>
                                {$objRecommendation->my_substr(strip_tags($recommendation.content) , 0 , 200)}
                            </p>
                        </div>
                        <div class="footer-card">
                            <a href="{$smarty.const.ROOT_ADDRESS}/recommendation/{$recommendation['id']}">
                                ##Shownformation##
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        </div>
                        <div class="migration-modal">
                            <div class="parent-migration-modal">
                                <div class="parent-header-migration-modal">
                                    <h3>##titleFilme##</h3>
                                    <div class="parent-multiplication">
                                        <i class="fa-light fa-xmark-large"></i>
                                    </div>
                                </div>
                                <div class="parent-video-migration w-100">
                                    {$recommendation.video_link}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
            {if $recommendation_count > 6 }
                <div class="parent-pagination-migration">
                <section class="pagination">
                    <button  id="pg-button-prev" type="button" class="pagination__button {if $page_number eq 1} disabled {/if}">
                        <a href='{$smarty.const.ROOT_ADDRESS}/recommendation&page={$page_number-1}'>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </button>

                    <ul class="pagination__list">
                        {foreach $recommendation_list['links'] as $link}
                            <li class="pagination__item pagination__item--1">
                                <a href='{$link['link']}'>
                                    <button id="pg-button-1" type="button">{$link['index']}</button>
                                </a>

                            </li>
                        {/foreach}
                    </ul>

                    <button id="pg-button-next" type="button" class="pagination__button">
                        <a href='{$smarty.const.ROOT_ADDRESS}/recommendation&page={$page_number+1}'>
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </button>
                </section>
            </div>
            {/if}

        </div>
        {else}
            <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                ##NoInformationToDisplay##
            </div>
        {/if}
    </div>
</div>




<script src="assets/modules/js/recommendation.js"></script>