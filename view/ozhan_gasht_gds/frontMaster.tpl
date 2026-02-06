<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>

<main>
    {if $smarty.const.GDS_SWITCH eq 'app'  || $smarty.const.GDS_SWITCH eq 'page'}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
    {else}
        <div class="content_tech">
            <div class="container">

                {if $smarty.const.GDS_SWITCH neq 'mainPage' && $smarty.const.GDS_SWITCH neq 'page' && $smarty.const.GDS_SWITCH neq 'detailTour'}
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/main.tpl" obj_main_page=$obj_main_page}
                {/if}

                <div class="temp-wrapper">
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
                </div>
            </div>
        </div>
    {/if}
</main>

</body>
{include file="include_files/footer_script.tpl"}
</html>