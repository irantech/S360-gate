{if $objAdmin->isLogin()}
    {include file="../{$smarty.const.ADMIN_DIR}/mainDashboard.tpl"}
{else}
    {include file="../{$smarty.const.ADMIN_DIR}/DashboardAgencyPartner.tpl"}
{/if}

{*{include file="../{$smarty.const.ADMIN_DIR}/mainDashboard.tpl"}*}