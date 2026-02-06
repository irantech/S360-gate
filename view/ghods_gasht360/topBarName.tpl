{if $obj_main_page->isLogin() }
    <a class="button  btn-user  {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
       href="javascript:">
        <svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24"><path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z" fill-rule="evenodd"></path></svg>
        <span>##Welcomeing##</span>
    </a>
{else}
    <a class="__login_register_class__ button  btn-user  {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
       href="{$smarty.const.ROOT_ADDRESS}/authenticate">
        <svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24"><path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z" fill-rule="evenodd"></path></svg>
        <span>##OsafarLogin## / ##OsafarSetAccount##</span>
    </a>
{/if}
