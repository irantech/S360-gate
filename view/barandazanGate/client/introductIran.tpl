
{if $smarty.const.INTRODUCT_IRAN_ID eq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/introductIran/main.tpl"
     objAboutIran=$objAboutIran}
{else}
{if $smarty.const.ANCIENT_ID neq ''}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/introductIran/ancient.tpl" }
{else}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/introductIran/item.tpl" }
{/if}
{/if}


