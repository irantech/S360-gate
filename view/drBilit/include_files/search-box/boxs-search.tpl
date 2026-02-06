{assign var="obj_main_page" value=$obj_main_page }

<div class="tab-content" id="myTabContent">
    {foreach $info_access_client_to_service as $key=>$client}
        {if $smarty.const.GDS_SWITCH eq 'mainPage'  ||
        $smarty.const.GDS_SWITCH eq 'page'}
            {include file="./boxes/{$client['MainService']}.tpl" client=$client active_tab=$active_tab}
        {/if}
    {/foreach}
</div>