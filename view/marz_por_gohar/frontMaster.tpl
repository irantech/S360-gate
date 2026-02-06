{include file="include_files/header.tpl" }
{if $smarty.const.GDS_SWITCH eq 'app' || $smarty.const.GDS_SWITCH eq 'page'}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
{else}
    <div class="content_tech">
        <div class="container">
            <div class="temp-wrapper">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
            </div>
        </div>
    </div>
{/if}
{include file="include_files/footer.tpl"}

{include file="include_files/script-footer.tpl"}