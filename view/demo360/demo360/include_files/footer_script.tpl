<script src="project_files/js/bootstrap.min.js"></script>
<script src="project_files/js/select2.min.js"></script>
<script src="project_files/js/header.js"></script>
<script src="project_files/js/rangeslider.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    <script src="project_files/js/owl.carousel.min.js"></script>
    <script src="project_files/js/searchBox.js"></script>
    <script src="assets/js/jquery-confirm.min.js" type="text/javascript"></script>
    <script src="project_files/js/jquery.smoothscroll.min.js"></script>
{*    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.21.0/dist/jquery.validate.min.js"></script>*}
{else}
    {if $smarty.const.GDS_SWITCH neq 'app'}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
    {/if}
{/if}
<div class="after__all"></div>

{*<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>*}
<script src="project_files/js/script.js" type="text/javascript"></script>
<script src="assets/main-asset/js/public-main.js" type="text/javascript"></script>

{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{/if}
