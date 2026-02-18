
{if $smarty.const.ABOUT_IRAN_ID eq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/aboutIran/main.tpl"
     objAboutIran=$objAboutIran}
{else}
{if $smarty.const.ANCIENT_ID neq ''}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/aboutIran/ancient.tpl" }
{else}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/aboutIran/item.tpl" }
{/if}
{/if}


