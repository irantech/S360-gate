

{if $smarty.const.INTRODUCT_COUNTRY_ID eq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/introductCountry/main.tpl"
     objAboutCountry=$objAboutCountry}
{else}
{if $smarty.const.PROVINCE_ID neq ''}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/introductCountry/province.tpl" }
{else}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/introductCountry/item.tpl" }
{/if}
{/if}


