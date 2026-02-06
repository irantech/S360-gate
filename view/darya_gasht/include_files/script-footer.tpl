<script src="project_files/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="project_files/js/mega-menu.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    <script type="text/javascript" src="project_files/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="project_files/js/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-confirm.min.js"></script>
    
{else}
    {if $smarty.const.GDS_SWITCH neq 'app'}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
    {/if}
{/if}
<script src="project_files/js/script.js"></script>
<script type="text/javascript" src="assets/main-asset/js/public-main.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{/if}
</html>
