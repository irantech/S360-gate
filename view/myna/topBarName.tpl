
{if $objSession->IsLogin() }
    <a class="logined-name" target="_parent" href="{$smarty.const.ROOT_ADDRESS}/profile">##Welcomeing## </a>

{*    <span class="logined-name show-box-login-js">##Welcomeing##</span>*}
    {else}
    <a class="logined-name" target="_parent" href="{$smarty.const.ROOT_ADDRESS}/authenticate">##OsafarLogin## / ##OsafarSetAccount##</a>
{/if}
