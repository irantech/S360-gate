{if $objSession->IsLogin() }
    <span class="logined-name"
    style="font-size: 13px;
	width: 150px;
	color: #0ac80a;
	white-space: nowrap;
	overflow: hidden;">{$objSession->getNameUser()}</span>
    {else}
    <span class="logined-vorood"
    style="font-size: 13px;
    font-family: IRANSansnum,IRANSans !important;
	width: 90px;
	color: #fff;
	white-space: nowrap;
	overflow: hidden;">ورود/ثبت نام</span>
{/if}
