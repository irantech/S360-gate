{load_presentation_object filename="partner" assign="objPartner"}
{assign var="isIframe" value=$objPartner->isIframeClient($smarty.const.CLIENT_ID) scope=parent}
<input type="hidden" id="isIframe" value="{$isIframe}">

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/authenticate-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/authenticate.css'>
{/if}
<div data-name='form-scenarios' class="bg-white mx-auto parent-modal-login rounded">
    <div class="remove">
        <svg onclick='authenticateNavigate($(this).attr("data-to"))' data-name='authenticate-navigator' class="arrow-right"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z" />
        </svg>
        {if $smarty.const.GDS_SWITCH neq 'authenticate'}
            <svg class="icon-xmark" onclick='authenticateCloseModal()' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path d="M313 137c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-119 119L41 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l119 119L7 375c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l119-119L279 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-119-119L313 137z" />
            </svg>
        {/if}
    </div>
    <div class="logo-login">
        <img src="project_files/images/logo.png" alt="logo-img">
        <h4>

        </h4>
    </div>
    <div class='d-none' data-name='main-data'>
        <input type='hidden' data-name='entry' />
        <input type='hidden' data-name='came-from' />
        <input type='hidden' data-name='is-member' />
        {if isset($useType)}
            <input type='hidden' data-name='use-type' value='{$useType}' />
        {/if}
    </div>
    <div class="form1 form-item" data-name='check-existence'>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/checkExistence.tpl"}
    </div>

    <div class="form3 form-item" data-name='login-by-code'>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/loginByCode.tpl"}
    </div>
    <div class="form4 form-item" data-name='login-by-password'>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/loginByPassword.tpl"}
    </div>
    <div class="form5 form-item" data-name='forget-password'>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/forgetPassword.tpl"}
    </div>
    <div class="form6 form-item" data-name='change-password'>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/changePassword.tpl"}
    </div>
    <div class="form2 form-item" data-name='register'>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/register.tpl"}

   </div>

</div>
<script src='assets/modules/js/authenticate.js' type='application/javascript'></script>