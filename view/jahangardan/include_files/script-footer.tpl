
<script src="project_files/js/bootstrap.min.js"></script>
<script src="project_files/js/megamenu.js"></script>
<script src="project_files/js/script.js"></script>
<script type="text/javascript" src="assets/main-asset/js/public-main.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage'}
    <script src="project_files/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-confirm.min.js"></script>
    <script src="project_files/js/select2.min.js"></script>

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{else}
    {if $smarty.const.GDS_SWITCH neq 'app'}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
    {/if}
{/if}

</html>