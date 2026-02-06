{assign var="obj_main_page" value=$obj_main_page }

    {foreach $info_access_client_to_service as $key=>$client}
        {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}

            {if  $smarty.const.GDS_SWITCH eq 'mainPage'}

                {include file="./boxes/{$client['MainService']}.tpl" client=$client}
             {else}

                {if ($client['MainService'] eq 'Flight' )   }
                    {include file="./boxes/Flight.tpl" client=$client active=true}
                {elseif $client['MainService'] eq 'Hotel'}
                    {include file="./boxes/Hotel.tpl" client=$client active=true}
                {elseif $client['MainService'] eq 'Visa'}
                    {include file="./boxes/Visa.tpl" client=$client active=true}
                {elseif $client['MainService'] eq 'Tour'}
                    {include file="./boxes/Tour.tpl" client=$client active=true}
                {elseif $client['MainService'] eq 'Hotel'}
                    {include file="./boxes/Hotel.tpl" client=$client active=true}
                {elseif $client['MainService'] eq 'Insurance'}
                    {include file="./boxes/Insurance.tpl" client=$client active=true}

                {/if}
            {/if}
        {/if}
    {/foreach}

{*        {$smarty.const.PAGE_TITLE|var_dump}*}

{*{$client['MainService']|var_dump}*}
{include file="./boxes/holidays.tpl" client=$client active=true}

{*{if  $smarty.const.GDS_SWITCH eq 'page'}*}
{*{include file="./boxes/Hotel.tpl" client=$client active=true}*}
{*{include file="./boxes/Visa.tpl" client=$client active=true}*}
{*{include file="./boxes/Tour.tpl" client=$client active=true}*}
{*{include file="./boxes/Flight.tpl" client=$client active=true}*}
{*{include file="./boxes/Insurance.tpl" client=$client active=true}*}
{*{/if}*}

