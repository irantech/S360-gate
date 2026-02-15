{load_presentation_object filename="agency" assign="objAgency"}
{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'agency')}
    {$objFunctions->redirectAgency()}
{else}
    {*{$objFunctions->LinkShortener('http://192.168.1.100/s360_test/pdf&target=parvazBookingLocal&id=13981002105941418792852378')}*}
    {*{$objFunctions->LinkExtender('Y5Gbv')}*}
    <div class="gds-login-register gds-login gds-login_en">
        <div class="gds-login-register-inner">
            <div class="gds-login-detail site-bg-main-color-before">
                <div class="gds-login-detail-inner">
                    <div class="login_icons d-flex flex-column">
                        <span class="icon_login_gds"></span>
                        <h2>##Loginuserarea##</h2>
                        <h3 class="btb">B2B</h3>
                    </div>
                    <div class="gds-login-detail-text">
                        <span>##Noaccount##</span>
                        <a href="{$smarty.const.ROOT_ADDRESS}/registerAgency">##SetAccountnow##</a>
                    </div>
                </div>
            </div>
            <div class="gds-login-form">
                <form class="gds-log-reg-form" id="loginAgencyForm">
                    <div class="gds-lgoin-user gds-l-up gds-l-r-error">
                        <span>
                            <i class="new-icon">
                                <svg fill='#bfbfbf' width='15px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"/></svg>
                            </i>
                            <input class="full-width has-padding" id="signin-email2" name="signin-email2" value="{if isset($smarty.cookies.email)}{$smarty.cookies.email}{/if}" type="text" placeholder="##UserName##" data-login="0">
                        </span>
                        <i class="gds-login-register-error" id="error-signin-email2"></i>
                    </div>
                    <div class="gds-login-password gds-l-up gds-l-r-error">
                        <span>
                            <i class="new-icon">
                               <svg fill='#bfbfbf' width='16px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M240 392C240 400.8 232.8 408 224 408C215.2 408 208 400.8 208 392V312C208 303.2 215.2 296 224 296C232.8 296 240 303.2 240 312V392zM224 0C294.7 0 352 57.31 352 128V192H368C412.2 192 448 227.8 448 272V432C448 476.2 412.2 512 368 512H80C35.82 512 0 476.2 0 432V272C0 227.8 35.82 192 80 192H96V128C96 57.31 153.3 0 224 0zM224 32C170.1 32 128 74.98 128 128V192H320V128C320 74.98 277 32 224 32zM80 224C53.49 224 32 245.5 32 272V432C32 458.5 53.49 480 80 480H368C394.5 480 416 458.5 416 432V272C416 245.5 394.5 224 368 224H80z"/></svg>
                           </i>
                            <input class="full-width has-padding" name="signin-password2" value="{if isset($smarty.cookies.password)}{$smarty.cookies.password}{/if}" id="signin-password2" type="password" placeholder="##Password##">
                        </span>
                        <i class="gds-login-register-error" id="error-signin-password2"></i>
                    </div>
                    <div class="login-captcha gds-l-r-error">
                       <span>

                        <input type="text" placeholder="##Securitycode##" name="signin-captcha2" id="signin-captcha2" class="full-width has-padding">
                         <a id="captchaRefresh" title="refresh image" onclick="reloadCaptcha();"></a>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}" alt="">
                       </span>

                    </div>
                    <div class="gds-login-rememmber">
                        <div class="gds-login-rememmber-inner">
                            <div class="custom-checkbox ">
                                <input id='check_1' name='check' type="checkbox"/>
                                <svg viewBox="0 0 35.6 35.6">
                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                </svg>

                            </div>
                            <label for="check_1">##Remember##</label>
                        </div>
                    </div>
                 {*   <div class="gds-login-forget">
                        <a class="site-main-text-color" href="sendMailForm">
                            ##Recoverypassword##
                        </a>
                    </div>*}
                    <div class="gds-login-submit">

                        <input type="submit" class="site-bg-main-color" value="##Login##" >
                        <div class="gds-login-error-box gds-login-error-none">
                            <div class="gds-login-error-box-inner">
                                <div class="message-login txtCenter txtRed"></div>
                                <div class="gds-login-register-error" id="error-signin-captcha2"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


{literal}
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {

                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
            $('.material-field').val('');
            $('.material-field').focus(function () {
                $(this).closest('.form-group-material').addClass('focused has-value');

            }).focusout(function () {
                $(this).closest('.form-group-material').removeClass('focused')
            }).blur(function () {
                if (!this.value) {
                    $(this).closest('.form-group-material').removeClass('has-value');
                }
                $(this).closest('.form-group-material').removeClass('focused');
            });
            //# sourceURL=coffeescript
        })
    </script>
{/literal}
    {*</div>*}

    {*</div>*}
{/if}

<!--<h1 style="margin: 0px auto ; text-align: center">در دست طراحی</h1>-->
