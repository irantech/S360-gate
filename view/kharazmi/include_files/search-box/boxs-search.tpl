
{assign var="obj_main_page" value=$obj_main_page }
{foreach $info_access_client_to_service as $key=>$client}
            {include file="./boxes/{$client['MainService']}.tpl" client=$client}
{/foreach}




