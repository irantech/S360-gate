<script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/mega-menu.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    <script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/select2.min.js"></script>
    <script src="project_files/{$smarty.const.SOFTWARE_LANG}/js/rangeslider.js"></script>
    <script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/jquery.smoothscroll.min.js"></script>
    <script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/scripts.js"></script>
    <script type="text/javascript" src="assets/js/jquery-confirm.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.21.0/dist/jquery.validate.min.js"></script>
{else}
    {if $smarty.const.GDS_SWITCH neq 'app'}
        <script type="text/javascript" src="project_files/{$smarty.const.SOFTWARE_LANG}/js/modernizr.js"></script>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
    {/if}
{/if}

<script type="text/javascript" src="assets/main-asset/js/public-main.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{/if}
<script src="project_files/js/bootstrap.min.js"></script>
<script src="project_files/js/select2.min.js"></script>
<script src="project_files/js/header.js"></script>
<script src="project_files/js/owl.carousel.min.js"></script>
<script src="project_files/js/searchBox.js"></script>
<script src="project_files/js/script.js"></script>
</html>
