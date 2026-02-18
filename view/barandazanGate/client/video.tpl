
{if $smarty.const.VIDEO_ID eq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/video/main.tpl"
     objVideo=$objVideo}
{else}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/video/item.tpl" }
{/if}


