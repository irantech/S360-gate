<script src="assets/all-js/bootstrap.min.js"></script><script src="assets/all-js/select2.min.js"></script><script src="project_files/js/header.js"></script>
<script src="assets/main-asset/js/public-main.js" type="text/javascript"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    <script src="assets/all-js/owl.carousel.min.js"></script><script src="project_files/js/searchBox.js"></script><script src="project_files/https://unpkg.com/follow-js/dist/follow.min.js"></script>
    <script src="assets/js/jquery-confirm.min.js" type="text/javascript"></script>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{else}
    {if $smarty.const.GDS_SWITCH neq 'app'}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
    {/if}
{/if}
<div class="after__all"></div>
<script src="project_files/js/mega-menu.js"></script>
<script src="project_files/js/script.js" type="text/javascript"></script>

