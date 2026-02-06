{assign var="data_search_recommendation" value=['limit' =>6]}
{assign var='recommendations' value=$obj_main_page->getRecommendationPosition($data_search_recommendation)}

<section class="customersComments my-5 py-5">
    <div class="container FAQOWL">
        <div class="w-100">
            <div class="clubTitle">
                <h2>نظرات مشتریان</h2>
            </div>
            <div class="owl-customersComments owl-carousel owl-theme py-3">
                {foreach $recommendations as $key => $recommendation}

                    <div class="item">
                        <p>
                            {$recommendation['content']}
                        </p>
                        <div>
                            <img src="{$recommendation['avatar_image']}" alt="{$recommendation['visa_type']['title']}">
                            <span>{$recommendation['fullName']}</span>
                        </div>
                    </div>

                {/foreach}
            </div>
            <div>
                <div class="w-100 d-flex justify-content-center align-items-center mt-3">
                    <a class="btn_more" href="{$smarty.const.ROOT_ADDRESS}/recommendation">بیشتر</a>
                </div>
            </div>
        </div>
    </div>
</section>

