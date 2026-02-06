{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-content" id="myTabContent">
    {foreach $info_access_client_to_service as $key=>$client}
        {if $client['MainService'] eq 'Tour'}
            {include file="./boxes/{$client['MainService']}.tpl" client=$client}
        {/if}
    {/foreach}

</div>