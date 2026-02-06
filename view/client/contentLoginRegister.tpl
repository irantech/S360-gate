{load_presentation_object filename="organizationLevel" assign="objOrganization"}
{assign var="organizationList" value=$objOrganization->ListAll()} {*گرفتن لیست سطح سازمانی*}



{load_presentation_object filename="settings" assign="objSettings"}
{assign var="isShowLoginPopup" value=$objSettings->isShowLoginPopup()}

{if $smarty.const.SEARCH_FLIGHT_NUMBER eq '' || $smarty.const.SEARCH_FLIGHT_NUMBER eq 'economy' || $smarty.const.SEARCH_FLIGHT_NUMBER eq 'premium_economy' || $smarty.const.SEARCH_FLIGHT_NUMBER eq 'business'}
    <input type="hidden" name="isShowLoginPopup" id="isShowLoginPopup" value="{$isShowLoginPopup[0]['enable']}">
{else}
    <input type="hidden" name="isShowLoginPopup" id="isShowLoginPopup" value="0">
{/if}
<input type="hidden" name="useTypeLoginPopup" id="useTypeLoginPopup" value="{{$useType}}">


<!-- login popup -->
<div class="s-u-popup-in-result">

    <div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->

        {assign var="new_logion" value=$objFunctions->newLogin()}

        {if in_array($smarty.const.CLIENT_ID,$new_logion)}
        <div class='parent-form-tour-width'>
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/authenticate/main.tpl" useType=$useType}
        </div>
        {else}
        <div class="cd-user-modal-container gds-login-modal"> <!-- this is the container wrapper -->


            <div class="gds-login-modal-inner">

                <div class="gds-login-register-inner">
                    <div class="no-register-buy site-bg-main-color">
                        <div class="modal-login-title">##Buyguest##</div>
                        <div class="modal-login-text">
                            {*##Purchasewithoutregistrationneedtestingdisplay##*}
                            ##Withoutregister##
                        </div>
                        {if $useType neq 'ticket' || ($useType eq 'ticket' && $smarty.const.SEARCH_FLIGHT_NUMBER eq '')}
                            <ul>
                                <li>##Withoutdiscount##</li>
                                <li>##Withoutpoint##</li>
                                <li>##Dontinclub##</li>
                            </ul>
                        {/if}

                        <div class='d-flex flex-wrap justify-content-center align-items-center'>
                            <button class='btn btn-light btn-sm px-5 py-2 rounded site-main-text-color light-shadow'
                                    onclick="popupBuyNoLogin('{$useType}',null,null,$(this))" id="noLoginBuy">
                                ##Purchasewithoutregistration##
                            </button>
                        </div>
                    </div>

                    <div class="registered-buy">
                        <form id="login-gds-popup">

                            <input type="hidden" id="useType" name="useType" value="{$useType}">
                            <div class="gds-login-modal-title site-main-text-color ">##Loginuserarea##</div>
                            <div class="gds-lgoin-user gds-l-up">
                                <span><input placeholder="##UserName##" id="signin-email2" name="signin-email2" type="text"></span>
                            </div>
                            <div class="gds-login-password gds-l-up">
                                <span><input placeholder="##Password##" id="signin-password2" name="signin-password2" type="password"></span>
                            </div>
                            {*	<div class="gds-login-level">
                                      <span>
                            <select class="select2login-popup" name="ss" id="" tabindex="-1">
                                  <option hidden>##Selectionorganizationallevel##</option>
                                  <option>##Organizationallevel##</option>
                                  <option>##Welfarelevel## </option>
                                  <option>##Sociallevel##  </option>
                             </select>
                                <select class="select2login" name="ss" id="" tabindex="-1">
                               <option></option>
                               <option>sdsd</option>
                               <option>asasdsdasds</option>
                               <option>sddsf</option>
                               <option>sdfd</option>
                           </select>
                           </span>
                            </div>*}
                            {*							<div class="login-captcha">
                                                   <span>

                                                    <input type="text" placeholder="##Securitycode##">
                                                     <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}" alt="">
                                                   </span>
                                                        </div>*}
                            <div class="gds-login-rememmber">
                                <div class="gds-login-rememmber-inner">
                                    <div class="custom-checkbox">
                                        <input type="checkbox"/>
                                        <svg viewBox="0 0 35.6 35.6">
                                            <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                            <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                            <polyline class="check"
                                                      points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                        </svg>

                                    </div>
                                    <span>##Remember##</span>
                                </div>
                            </div>
                            <div class="gds-login-forget">
                                <a href="#" target="_blank" onclick="recovery_pass();">##RecoveryPassword##</a>
                            </div>
                            <div class="gds-login-submit w-100">
                                <div class="gds-login-error-box gds-login-error-none">
                                    <div class="gds-login-error-box-inner">
                                        <div class="message-login txtCenter txtRed"></div>
                                    </div>
                                </div>





                                <div class='d-flex flex-wrap justify-content-between w-100 align-items-center'>
                                    <button type='submit'
                                            id='login-submit-btn'
                                            class='btn site-bg-main-color site-secondary-text-color btn-sm px-5 py-2 rounded site-main-text-color light-shadow'>
                                        ##Login##
                                    </button>


                                    <a href="{$objFunctions->registerUserUrl()}"
                                       onclick="loadingToggle($(this));"
                                       class='btn btn-light btn-sm px-5 py-2 rounded site-main-text-color light-shadow'>
                                        ##SetAccount##
                                    </a>
                                </div>

                            </div>


                        </form>

                    </div>


                </div>
            </div>

        </div>
        {/if}



        <a class="cd-close-form">Close</a>

    </div> <!-- cd-user-modal-container -->

</div> <!-- cd-user-modal -->


<!-- modal login  -->


<div class="s-u-next-setep-login-popup">
    <button class="cd-signin" id="login-popup">##Popup##</button>
</div>