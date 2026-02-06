{load_presentation_object filename="user" assign="objUser"}
{*{assign var="redirect_url" value=$smarty.server.HTTP_REFERER}*}
{if isset($smarty.get.redirect_url) AND $smarty.get.redirect_url neq ''}
    {$redirect_url=$smarty.get.redirect_url}
    {$objSession->setReferUrl($redirect_url)}
{/if}

<code style="display:none;">{$smarty.session.refer_url}</code>
{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
    {$objUser->redirect($smarty.session.refer_url)}
{else}

    <div class="gds-login-register gds-register">
        <div class="gds-login-register-inner">
            <div class="gds-login-detail site-bg-main-color-before">
                <div class="gds-login-detail-inner">
                    <span></span>
                    <h2>##Signin## {$smarty.const.TITLE_SITE}</h2>
                    <div class="gds-login-detail-text">
                        <span>##Haveregisteredalready##</span>
                        <a href="{$smarty.const.ROOT_ADDRESS}/loginUser">##Loginuserarea##</a>
                    </div>
                </div>
            </div>
            <div class="gds-login-form">
                <form class="gds-log-reg-form" id="registers-gds-form">
                    <div class="gds-register-nf gds-l-up gds-l-r-error">
                        <span>
                            <i class="new-icon">
                                <svg fill='#bfbfbf' width='15px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"/></svg>
                            </i>
                            <input class="full-width has-padding" type="text" placeholder="##Name##" name="signup-name2" id="signup-name2">
                        </span>
                        <span>
                            <i class="new-icon">
                                <svg fill='#bfbfbf' width='15px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"/></svg>
                            </i>
                            <input class="full-width has-padding" type="text" placeholder="##Family##" name="signup-family2" id="signup-family2">
                        </span>

                    </div>
                    <div class="gds-register-email gds-l-up gds-l-r-error">
                        <span>
                            {if $smarty.const.SOFTWARE_LANG == 'fa'}
                                <i class="new-icon">
                                    <svg fill="#bfbfbf" width="15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0H96C60.65 0 32 28.65 32 64v384c0 35.35 28.65 64 64 64h192c35.35 0 64-28.65 64-64V64C352 28.65 323.3 0 288 0zM320 448c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V64c0-17.64 14.36-32 32-32h192c17.64 0 32 14.36 32 32V448zM224 400H160c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16h64c8.836 0 16-7.164 16-16C240 407.2 232.8 400 224 400z"></path></svg>
                                </i>
                            {else}
                                <i class="new-icon">
                                    <svg fill='#bfbfbf' width='15px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM32 128V167.9L227.6 311.3C244.5 323.7 267.5 323.7 284.4 311.3L480 167.9V128C480 110.3 465.7 96 448 96H63.1C46.33 96 31.1 110.3 31.1 128H32zM32 207.6V384C32 401.7 46.33 416 64 416H448C465.7 416 480 401.7 480 384V207.6L303.3 337.1C275.1 357.8 236.9 357.8 208.7 337.1L32 207.6z"/></svg>
                                </i>
                            {/if}

                            <input class="full-width has-padding" type="text"  {if $smarty.const.SOFTWARE_LANG == 'fa'}placeholder="##Mobile##"{else}placeholder="##Email##"{/if} type="text" name="signup-mobile2" id="signup-mobile2">
                        </span>

                    </div>
                    <div class="gds-register-mobile gds-l-up gds-l-r-error">
                        <span>
                            <i class="new-icon">
                                <svg fill="#bfbfbf" width="16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M240 392C240 400.8 232.8 408 224 408C215.2 408 208 400.8 208 392V312C208 303.2 215.2 296 224 296C232.8 296 240 303.2 240 312V392zM224 0C294.7 0 352 57.31 352 128V192H368C412.2 192 448 227.8 448 272V432C448 476.2 412.2 512 368 512H80C35.82 512 0 476.2 0 432V272C0 227.8 35.82 192 80 192H96V128C96 57.31 153.3 0 224 0zM224 32C170.1 32 128 74.98 128 128V192H320V128C320 74.98 277 32 224 32zM80 224C53.49 224 32 245.5 32 272V432C32 458.5 53.49 480 80 480H368C394.5 480 416 458.5 416 432V272C416 245.5 394.5 224 368 224H80z"></path></svg>
                            </i>
                            <input class="full-width has-padding" type="password" placeholder="##Password##" name="signup-password2" id="signup-password2">
                        </span>

                    </div>
                    <div class="login-captcha gds-l-r-error">
                       <span>
                        <input class="full-width has-padding" type="number" placeholder="##Securitycode##" name="signup-captcha2" id="signup-captcha2">
                         <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php" alt="">
                       </span>
                    </div>
                    <div class="gds-login-rememmber">
                        <div class="gds-login-rememmber-inner gds-login-reagent-code">
                            <div>
                            <div class="custom-checkbox">
                                <input type="checkbox"/>
                                <svg viewBox="0 0 35.6 35.6">
                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                </svg>

                            </div>
                            <span>##Ihavecodemark##</span>
                            </div>
                            <span><input class="full-width has-padding" type="text" placeholder="##Reagentcode##" name="reagent-code2" id="reagent-code2"></span>
                            <i class="gds-login-register-error" id="error-reagent-code2"></i>
                        </div>
                    </div>

                    <div class="gds-login-rememmber gds-login-rules gds-l-r-error">
                        <div class="gds-login-rememmber-inner">
                            <div class="custom-checkbox">
                                <input checked type="checkbox" id='accept-terms2' name='accept-terms2'/>
                                <svg viewBox="0 0 35.6 35.6">
                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                </svg>

                            </div>
                            <span> ##acceptrulesregulations## -
                                {if $smarty.session.layout neq 'pwa'}
                                     <a href="{$smarty.const.URL_RULS}">##Seerules##</a>
                                {else}
                                    <a href="{$smarty.const.ROOT_ADDRESS}/rules">##Seerules##</a>
                                {/if}
                            </span>
                            <i class="gds-login-register-error" id="error-accept-terms2"></i>
                        </div>
                    </div>




                    <div class="gds-login-submit">
                        <button class='btn w-290 site-bg-main-color' {if $smarty.session.layout eq 'pwa'} onclick='$("#authModal").modal("toggle")' data-loading-title='Pleasewait' id="register_submit" type='button' {else} type='submit' {/if}  >
                            ##SetAccount##
                        </button>

                    </div>


                    <!-- Modal -->


                    <div class="gds-login-error-box gds-login-error-none">
                        <div class="gds-login-error-box-inner">
                            <div class="message-login txtCenter txtRed"></div>
                            <div class="gds-login-register-error" id="error-signin-captcha2"></div>
                        </div>
                    </div>
                    <div class='message-register'></div>



                    <section class="modal fade " id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header site-bg-main-color site-main-text-color-a">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="authModalLabel">##acceptenceRules##</h5>
                                </div>
                                <div class="font-15 modal-body p-2 text-justify dir_r">
                                    ##pwaRules##
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="d-flex btn btn-secondary " data-dismiss="modal">##Return##</button>
                                    <button type="submit" onclick='$("#authModal").modal("toggle")' class="d-flex btn btn-primary site-bg-main-color site-main-text-color-a">##acceptRules##</button>
                                </div>
                            </div>
                        </div>
                    </section>


                </form>


            </div>
        </div>
    </div>

            {literal}
                <script>
                    $(document).ready(function () {
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