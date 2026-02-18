
{if $objSession->IsLogin() eq false}
    
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/main.tpl"}
    {else}
        {$objFunctions->redirect("`$smarty.const.ROOT_ADDRESS`/profile")}
{/if}
