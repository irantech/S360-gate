{if $obj_main_page->isLogin() }
    <span class="logined-name">##Welcomeing##</span>
    {else}
    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
    <a class="logined-name" href="{$smarty.const.ROOT_ADDRESS}/authenticate">##OsafarLogin## / ##OsafarSetAccount##</a>
    {else}
    <a class="logined-name" href="{$smarty.const.ROOT_ADDRESS}/loginUser">##OsafarLogin## / ##OsafarSetAccount##</a>
{/if}
{/if}
