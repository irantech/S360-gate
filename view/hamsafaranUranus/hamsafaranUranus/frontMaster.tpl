<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{include file="include_files/menu-1.tpl"}
<main>
    {if $smarty.const.GDS_SWITCH eq 'app'  || $smarty.const.GDS_SWITCH eq 'page'}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
    {else}
        <div class="content_tech">
            <div class="container">

                {if $smarty.const.GDS_SWITCH neq 'mainPage' && $smarty.const.GDS_SWITCH neq 'page'}
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/main.tpl" obj_main_page=$obj_main_page}
                {/if}

                <div class="temp-wrapper">
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
                </div>
            </div>
        </div>
    {/if}
</main>
{include file="include_files/footer-1.tpl"}
</body>
{include file="include_files/footer_script.tpl"}
</html>