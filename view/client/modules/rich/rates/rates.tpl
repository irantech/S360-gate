{load_presentation_object filename="masterRate" assign="objMasterRate"}
{assign var="rate_average" value=$objMasterRate->getRateAverage($section,$item_id)}


<div class='parent-blog-rate'>
    <p>##RateArticle##</p>
    <div class="d-flex rates-box flex-wrap gap-5 justify-content-center  star" style='margin-top: 20px;'>
    <div class="d-flex gap-10 justify-content-center parent-star">
        <div class="active-star">
            <i class="fa-regular fa-thumbs-up"></i>
        </div>
        <div class="result-star">
            ({$rate_average['average']}/{$rate_average['count']})
        </div>
    </div>
    {assign var="counter" value=5}
{*    <span class='help-star'>خیلی خوب</span>*}
    {for $item=1 to 5}
            <input type="radio" id="star-{$counter}"

                    {if $rate_average['average'] == $counter} checked {/if}
                   name="stars"/>
            <label class='p-0 m-0'  {if $item==1} title="خیلی خوب" {elseif $item==5} title="خیلی بد"{/if}
                    onClick='doRate("{$section}","{$item_id}","{$counter}")' for="star-{$counter}">
                <i class="fas fa-star"></i>
            </label>
        {assign var="counter" value=$counter-1}
    {/for}
{*    <span class='help-star'>خیلی بد</span>*}
</div>
</div>
<link rel='stylesheet' href='assets/modules/css/rates.css'>
<script src="assets/js/modules/rates.js"></script>