{foreach $info_access_client_to_service as $service}
    {if file_exists("`$smarty.const.FRONT_CURRENT_CLIENT`assets/main-asset/js/{$service['MainService']|trim}.js")}
       <script  type="text/javascript" src="assets/main-asset/js/{$service['MainService']|trim}.js"></script>
    {/if}
{/foreach}

<script type="text/javascript" src="assets/js/popup.js"></script>

