{if $objSession->IsLogin() }
    <span style="color: #fff;" class="logined-name">{$objSession->getNameUser()}</span>
    {else}
    <span class="logined-vorood"
    style="color: #fff;">ورود/ثبت نام</span>
{/if}
