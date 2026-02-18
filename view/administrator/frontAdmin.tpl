{load_presentation_object filename="admin" assign="objAdmin"}


{if ($objAdmin->isLogin() || $objAdmin->IsLoginAgencyPartner())}

    {load_presentation_object filename="general" assign="objGeneral"}
    {load_presentation_object filename="functions" assign="objFunctions"}
    {load_presentation_object filename="frontMaster" assign="obj"}
    {load_presentation_object filename="message" assign="objMessage"}
    {load_presentation_object filename="Session" assign="objsession"}
    {load_presentation_object filename="dateTimeSetting" assign="objDate"}

    {if $smarty.const.ADMIN_FILE == 'login'}
        <script>
            window.location ='admin';
        </script>
    {else}

{*        {if $objAdmin->isLogin()}*}
            {include file="../{$smarty.const.ADMIN_DIR}/mainAdmin.tpl"}
{*        {else}*}
{*            {include file="../{$smarty.const.ADMIN_DIR}/adminAgencyPartner.tpl"}*}
{*        {/if}*}

    {/if}

{else}

    {if $smarty.const.ADMIN_FILE == 'login'}
        {include file="../{$smarty.const.ADMIN_DIR}/login.tpl"}
    {else}
        <script>
            window.location = "{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/login";
        </script>
    {/if}
{/if}