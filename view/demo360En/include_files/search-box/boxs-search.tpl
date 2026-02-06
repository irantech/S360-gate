{assign var="obj_main_page" value=$obj_main_page }
{foreach $info_access_client_to_service as $key=>$client}
    {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
        {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
            {include file="./boxes/{$client['MainService']}.tpl" client=$client}
        {else}
            {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService']}
                {include file="./boxes/{$client['MainService']}.tpl" client=$client active=true}
            {/if}
        {/if}
    {/if}
{/foreach}








