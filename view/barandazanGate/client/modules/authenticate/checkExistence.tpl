<div class="parent-login">
    <h2>##loginOrSignIn##</h2>
    <p>##mobilenumbertocontinue##</p>
</div>
<form onsubmit='authenticateCheckExistence($(`[data-name="check-existence"] [data-name="submit"]`))'
        class="form-return">
    <div class='d-flex flex-wrap w-100 gap-5'>
        <input data-name="entry" class='input-mobile'
{*               onchange='authenticateCheckExistenceValidator($(this))'*}
{*               onkeyup='authenticateCheckExistenceValidator($(this))'*}
               type="text"
               name="mobile"
               placeholder="##Phonenumber##" value="">
        <div class="invalid-feedback"></div>
    </div>
    <div class="login-captcha gds-l-r-error">
       <span>
         <input type="number" placeholder="##Securitycode##" name="signin-captcha2" id="signin-captcha2" class="full-width has-padding">
         <a id="captchaRefresh" title="refresh image" onclick="reloadCaptchaByClass();"></a>
            <img class="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php" alt="">
       </span>
    </div>

    <button data-name='submit' class="btn-form4" type="button" onclick="authenticateCheckExistence($(this))">##Confirmandcontinue##</button>

    {if in_array($smarty.const.CLIENT_ID, $objFunctions->hasAgencyLogin())}
        <a href='{$smarty.const.ROOT_ADDRESS}/loginAgency' class='colleague-login'>
            <span>##partnerpanel##</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
        </a>
    {/if}
</form>
<div class="parent-rules">
    <svg viewBox="0 0 24 24" width="1.2em" height="1.2em" fill="currentColor" class="align-center ml-1 shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
    {$objFunctions->StrReplaceInXml(['@@client_name@@'=>$smarty.const.CLIENT_NAME],'LoginIsEqualTo')}

    <a class="rules" href="{$smarty.const.ROOT_ADDRESS}/rules">##Rules##</a>
    {$objFunctions->StrReplaceInXml(['@@client_name@@'=>$smarty.const.CLIENT_NAME],'LoginMeansAcceptRules')}

</div>

<script>
$(document).ready(function() {
    reloadCaptchaByClass();
});
</script>
