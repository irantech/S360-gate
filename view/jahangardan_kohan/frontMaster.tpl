{if $smarty.const.SOFTWARE_LANG eq 'en'}
    {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_en/frontMaster.tpl"}
{else}
    {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_fa/frontMaster.tpl"}
{/if}