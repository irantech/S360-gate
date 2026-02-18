
    {if $smarty.const.ABOUT_COUNTRY_ID eq ''}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/aboutCountry/main.tpl"
        objAboutCountry=$objAboutCountry}
    {else}
        {if $smarty.const.OTHER_COUNTRY_ID neq ''}
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/aboutCountry/details.tpl" }
        {else}
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/aboutCountry/item.tpl" }
        {/if}
    {/if}





