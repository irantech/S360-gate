{if $objSession->IsLogin() }
{*    <span class="logined-name">{$objSession->getNameUser()}</span>*}
    <span class="logined-name">##Welcomeing##</span>
    {else}
    <span class="logined-name">ورود/ثبت نام</span>
{/if}
