{load_presentation_object filename="masterRate" assign="objMasterRate"}
{assign var="rate_average" value=$objMasterRate->getRateAverage($section,$item_id)}

<div class='d-flex flex-wrap w-100'>
    <div class='align-items-center d-flex flex-wrap gap-5 justify-content-end parent-rate-subscription'>

            <div class='start-color'>
                {assign var="counter" value=5}
                {for $item=1 to 5}

                    <input type="radio" id="star-{$counter}"
                           class='d-none'
                            {if $rate_average['average'] == $counter} checked {/if}
                           name="stars"/>
                    <label onClick='doRate("{$section}","{$item_id}","{$counter}")' for="star-{$counter}"
                           class='p-0 m-0'>
                        <i class="{if $rate_average['average'] >= $counter} fa-solid {else} fa-light {/if} fa-star"></i>
                    </label>


                {assign var="counter" value=$counter-1}
                {/for}
            </div>


        <div class='text-rate-tour'>
            ( ##Average## {$rate_average['average']})
        </div>

    </div>
</div>

<link rel='stylesheet' href='assets/modules/css/rates.css'>
<script src="assets/js/modules/rates.js"></script>