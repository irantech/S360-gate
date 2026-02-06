{assign var="obj_main_page" value=$obj_main_page }
{$i = 0}
{*{$active_tab}*}
{foreach $services_array as $key=>$val}
    {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
        {if $i eq 0}
            {include file="./{$key}/box.tpl" active=True}
        {else}
            {include file="./{$key}/box.tpl" active=False }
        {/if}
        {$i = $i + 1}
    {elseif (($active_tab eq 'internalFlight' || $active_tab eq 'internationalFlight') && $val eq 'Flight') || $active_tab eq $val}

        {include file="./{$key}/box.tpl" active=True}
    {/if}
{/foreach}

{*{if $active_tab eq 'internalFlight' && $val['MainService'] eq 'Flight' || $active_tab eq $val['MainService']}*}

{*    {include file="./{$key}/box.tpl" active=True}*}
{*{/if}*}
