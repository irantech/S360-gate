
<div class="s-u-popup-in-result" id="FormTracking">
    <div class="row">


        <div class="{($smarty.const.SOFTWARE_LANG eq 'fa')
        ?'col-md-6':''}">
            <div class="{($smarty.const.SOFTWARE_LANG eq 'fa')
            ?'user-form-style col-md-12':'cd-user-modal-container'} ">
                <div class="cd-login is-selected">
                    <form class="cd-form">
                        <p class="fieldset">
{*                            <label class="image-replace cd-email" for="ResetEmailLocal">##Email##</label>*}
                            <input class="full-width has-padding has-border" id="ResetEmailLocal" type="email"
                                   placeholder="##PleaseEnterEmail##">
                        </p>
                        <div class="login-captcha gds-l-r-error">
                       <span>

                        <input type="text" placeholder="##Securitycode##" name="signin-captcha2" id="signin-captcha2" class="full-width has-padding">
                         <a id="captchaRefresh" title="refresh image" onclick="reloadCaptcha();"></a>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}" alt="">
                       </span>

                        </div>
                        <img src="assets/images/load21.gif" style="display:none" class="loader-tracking"
                             id="loaderTracking">
                        <p class="fieldset">
                            <input class="full-width " type="button" value="{($smarty.const.SOFTWARE_LANG eq 'fa')
                            ?'##SendCodeToPhone##':'##SendCodeToEmail##'}"
                                   onclick="recovery_pass();">
                        </p>
                    </form>
                </div>
            </div>
        </div>

        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
            <div class="col-md-6 code-div-password-form-js">
                <div class="user-form-style user-form-style_js col-md-12" disabled="disabled">
                    <div class="cd-login is-selected">
                        <form class="cd-form">
                            <p class="fieldset">
                                <input class="full-width has-padding has-border" id="ResetEmailLocalCheckCode" type="text"
                                       placeholder="کد ارسال شده" disabled="disabled">
                            </p>
                            <div class="message-login txtCenter txtRed"></div>
                            <img src="assets/images/load21.gif" style="display:none" class="loader-tracking"
                                 id="loaderTracking">
                            <p class="fieldset">
                                <input class="full-width " type="button" value="##Recoverypassword##"
                                       onclick="recovery_pass_check_number();" disabled="disabled">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</div>




