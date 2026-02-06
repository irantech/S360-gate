{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-content" id="myTabContentSearchBox">
    {foreach $info_access_client_to_service as $key=>$client}
        {assign var="file_search_box" value="./boxes/{$client['MainService']}.tpl"}
        {if $active_tab}
            {if $client['MainService'] eq $active_tab}
                {if $client['MainService'] neq 'Flight'}
                    {include file="./boxes/{$client['MainService']}.tpl" active_tab=$active_tab client=$client}
                {/if}
            {/if}
        {else}
            {if $client['MainService'] neq 'Flight'}
                {include file="./boxes/{$client['MainService']}.tpl" client=$client}
            {/if}
        {/if}
    {/foreach}
</div>