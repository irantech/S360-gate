{if $smarty.const.SOFTWARE_LANG eq 'en'}
    {include file="mainEn.tpl"}
{elseif $smarty.const.SOFTWARE_LANG eq 'ar'}
    {include file="mainAr.tpl"}
{else}
    {include file="mainFa.tpl"}
{/if}