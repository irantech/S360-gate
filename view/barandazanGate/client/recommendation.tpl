{load_presentation_object filename="recommendation" assign="objRecommendation"}
{if $smarty.const.RECOMMENDATION_ID eq ''}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/recommendation/main.tpl" objRecommendation=$objRecommendation}
{else}
 {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/recommendation/item.tpl" }
{/if}
