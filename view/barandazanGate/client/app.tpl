{*{if $smarty.server.HTTP_X_REQUESTED_WITH eq 'ir.razdonya.app'}*}


<div class="w-100 position-unset" id="vueApp">
    <pwa-app></pwa-app>
</div>

<script src="assets/js/vueScripts/pwaApp.js"></script>
{*{/if}*}
