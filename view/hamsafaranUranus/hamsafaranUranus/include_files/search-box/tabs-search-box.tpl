<style> .banner-slider-display { display: none; } </style>
{$i = 0}
{foreach $services_array as $key=>$val}
    {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
        {if $i eq 0}
            {include file="./{$key}/tab.tpl" active=True}
        {else}
            {include file="./{$key}/tab.tpl" active=False}
        {/if}
        {$i = $i + 1}
    {elseif $active_tab eq 'internalFlight' && $val eq 'Flight' || $active_tab eq $val}
        {include file="./{$key}/tab.tpl" active=True}
    {/if}
{/foreach}
