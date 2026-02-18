{load_presentation_object filename="user" assign="objUser"}
{load_presentation_object filename="functions" assign="objFunctions"}

{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
    {$objUser->redirect()}
{else}
    {load_presentation_object filename="organizationLevel" assign="objOrganization"}
    {assign var="organizationList" value=$objOrganization->ListAll()} {*گرفتن لیست سطح سازمانی*}

    {*{$objFunctions->LinkShortener('http://192.168.1.100/gds/pdf&target=parvazBookingLocal&id=13981002105941418792852378')}*}
    {*{$objFunctions->LinkExtender('Y5Gbv')}*}


   <div class="gds-login-register gds-login gds-login_en">
       <div class="gds-login-register-inner">
           <div class="gds-login-detail site-bg-main-color-before">
                <div class="gds-login-detail-inner">
                    <div class="login_icons">
                    <span class="icon_login_gds"></span>

                    <h2>##Loginuserarea##</h2>
                    </div>
                    <div class="gds-login-detail-text">
                        <span>##Noaccount##</span>
                        <a href="{$smarty.const.ROOT_ADDRESS}/registerUser">##SetAccountnow##</a>
                    </div>
                </div>
           </div>
           <div class="gds-login-form">
               <form class="gds-log-reg-form" id="login-gds-page">
                   <div class="gds-lgoin-user gds-l-up gds-l-r-error"><span>
                           <i class="new-icon">
                               <svg fill='#bfbfbf' width='15px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 0H96C60.65 0 32 28.65 32 64v384c0 35.35 28.65 64 64 64h192c35.35 0 64-28.65 64-64V64C352 28.65 323.3 0 288 0zM320 448c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V64c0-17.64 14.36-32 32-32h192c17.64 0 32 14.36 32 32V448zM224 400H160c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16h64c8.836 0 16-7.164 16-16C240 407.2 232.8 400 224 400z"/></svg>
                           </i>
                           <input class="full-width has-padding" id="signin-email2" name="signin-email2" value="{if isset($smarty.cookies.email)}{$smarty.cookies.email}{/if}" type="text" placeholder="##MobileOrEmail##" data-login="0">

                           <input type='hidden' id='is_app' value='{if $smarty.session.layout eq 'pwa'}Yes{else}No{/if}'>
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

                   {if $organizationList|count > 0}
                   <div class="gds-login-level ">
                       <span>

                       <select class="select2login full-width has-padding" name="ss" tabindex="-1" id="signin-organization2 ">
                            <option value="0">##Organizationallevel##</option>
                           {foreach $organizationList as $each}
                               <option value="{$each.id}">{$each.title}</option>
                           {/foreach}
                       </select>

                       </span>

                   </div>
                   {/if}
                   <div class="login-captcha gds-l-r-error">
                       <span>

                        <input type="number" placeholder="##Securitycode##" name="signin-captcha2" id="signin-captcha2" class="full-width has-padding">
                         <a id="captchaRefresh" title="refresh image" onclick="reloadCaptcha();"></a>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php" alt="">
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
                   {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                           <a class="site-main-text-color cursor-pointer"
                              onclick='otpLogin($(this),$("#signin-email2"))'
                              data-loading-title='WaitForProcess'>
                               ##SendOTPCode##
                           </a>
                       {else}
                       <div class="gds-login-forget">
                           <a class="site-main-text-color" href="{$smarty.const.ROOT_ADDRESS}/sendMailForm">
                               ##Recoverypassword##
                           </a>
                       </div>
                   {/if}

                   <div class="gds-login-submit">
                       <button type='submit'
                               data-loading-title='WaitForProcess'
                               class='init-loading btn site-bg-main-color site-secondary-text-color btn-sm px-5 py-2 rounded site-main-text-color'>
                           ##Login##
                       </button>

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



    {*<div class="s-u-popup-in-result">*}

        {*<div class=""> <!--  this is the entire modal form, including the background -->*}


            {*<div class="body_form_log_reg">*}
                {*<div class="veen ">*}
                    {*<div class="login-btn splits">*}
                        {*<div class="content">*}
                            {*<div class="svg-register">*}
                                {*<img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.LOGO_AGENCY}"*}
                                     {*alt="{$smarty.const.CLIENT_NAME}">*}
                            {*</div>*}
                            {*<span class="welcome_reg">ورود شما به خانواده {$smarty.const.CLIENT_NAME} را پیشاپیش تبریک می‌گوییم.*}
                                {*<br>*}
{*امیدواریم همسفر خوبی برای سفرهای شما باشیم. </span>*}
                            {*<ul>*}
                                {*<li><i class="fa fa-check-circle  site-main-text-color"></i>سریع تر و ساده تر رزرو کنید*}
                                {*</li>*}
                                {*<li><i class="fa fa-check-circle site-main-text-color"></i> به سادگی سوابق خرید و فعالیت*}
                                    {*های خود را مدیریت کنید*}
                                {*</li>*}
                                {*<li><i class="fa fa-check-circle site-main-text-color"></i>پوشش ۱۰۰ درصدی پروازها و*}
                                    {*قطارها*}
                                {*</li>*}
                                {*<li><i class="fa fa-check-circle site-main-text-color"></i>قیمت رقابتی همراه با تضمین*}
                                    {*بلیط‌های چارتر*}
                                {*</li>*}

                            {*</ul>*}

                        {*</div>*}
                    {*</div>*}
                    {*<div class="rgstr-btn splits">*}

                    {*</div>*}
                    {*<div class="wrapper ">*}
                        {*<form id="login" tabindex="500">*}
                            {*<h3>##Login##</h3>*}
                            {*<div class="mail form-group-material">*}
                                {*<input class="material-field" type="text" name="text" id="signin-email2"*}
                                       {*value="{if isset($smarty.cookies.email)}{$smarty.cookies.email}{/if}">*}

                                {*<label class="material-label" for="name">##Username##</label>*}
                                {*<span class="cd-error-message" id="error-signin-email2"></span>*}
                            {*</div>*}
                            {*<div class="passwd form-group-material" id="show_hide_password">*}
                                {*<input class="material-field passshow" type="password" name="signin-password2"*}
                                       {*value="{if isset($smarty.cookies.password)}{$smarty.cookies.password}{/if}"*}
                                       {*id="signin-password2">*}
                                {*<label class="material-label" for="name"> ##Password##</label>*}
                                {*<span class="cd-error-message" id="error-signin-password2"></span>*}

                                {*<div class="input-group-addon">*}
                                    {*<a style="cursor: pointer"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>*}
                                {*</div>*}
                            {*</div>*}
                            {*{if $organizationList|count > 0}*}
                                {*<p class="fieldset fieldset-change select">*}

                                    {*<select class="full-width has-padding has-border select-text"*}
                                            {*id="signin-organization2">*}
                                        {*<option value="0">##Organizationallevel##</option>*}
                                        {*{foreach $organizationList as $each}*}
                                            {*<option value="{$each.id}">{$each.title}</option>*}
                                        {*{/foreach}*}
                                    {*</select>*}
                                {*</p>*}
                            {*{/if}*}
                            {*<div class="name form-group-material">*}
                                {*<input class="material-field" type="text" name="signup-captcha2" id="signup-captcha2">*}
                                {*<label class="material-label">##Securitycode##</label>*}
                            {*</div>*}

                            {*<div class="name">*}
                                {*<img id="captchaImage"*}
                                     {*src="{$smarty.const.ROOT_ADDRESS}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}"*}
                                     {*alt="captcha image"/>*}

                                {*<a id="captchaRefresh" href="#" title="refresh image"*}
                                   {*onclick="reloadCaptcha(); return false"></a>*}
                                {*<span class="cd-error-message" id="error-signup-captcha2"></span>*}
                            {*</div>*}
                            {*<div class='frame'>*}
                                {*<input id='check_1' name='check' type='checkbox'>*}
                                {*<label class='check__1 ' for='check_1'><i*}
                                            {*class="fa fa-check"></i></label>*}
                                {*<div class="accept-terms2">##Remember##</div>*}
                            {*</div>*}
                            {*<div class="message-login txtCenter txtRed"></div>*}
                            {*<div class="submit">*}
                                {*<a class="dark" onclick="LoginOfPanel()">##Login##</a>*}
                            {*</div>*}
                            {*<p class="cd-form-bottom-message">*}
                                {*<a href="sendMailForm">##RecoveryPassword##</a>*}
                            {*</p>*}
                            {*<div class="loginRegister-footer"> ##Noaccount##*}
                                {*<a id="btnloginRegister" href="{$smarty.const.ROOT_ADDRESS}/registerUser">##Register##</a>*}
                            {*</div>*}
                        {*</form>*}

                    {*</div>*}
                {*</div>*}
            {*</div>*}


            {*<div class="cd-user-modal-container">*}
                {*<div class="cd-login is-selected">*}

                    {*<form class="cd-form">*}
                        {*<p class="fieldset fieldset-change">*}
                            {*<label class="image-replace cd-email" for="signin-email2">نام کاربری (ایمیل)</label>*}
                            {*<input class="full-width has-padding has-border" id="signin-email2" type="email"*}
                                   {*placeholder="نام کاربری (ایمیل)"*}
                                   {*value="{if isset($smarty.cookies.email)}{$smarty.cookies.email}{/if}">*}
                            {*<span class="cd-error-message" id="error-signin-email2"></span>*}
                        {*</p>*}
                        {*<p class="fieldset fieldset-change">*}
                            {*<label class="image-replace cd-password" for="signin-password2">کلمه عبور (موبایل)</label>*}
                            {*<input class="full-width has-padding has-border" id="signin-password2" type="password"*}
                                   {*placeholder="کلمه عبور (موبایل)"*}
                                   {*value="{if isset($smarty.cookies.password)}{$smarty.cookies.password}{/if}">*}
                            {*<span class="hide-password">Show</span>*}
                            {*<span class="cd-error-message" id="error-signin-password2"></span>*}
                        {*</p>*}

                        {*{if $organizationList|count > 0}*}
                            {*<p class="fieldset fieldset-change">*}
                                {*<label class="image-replace cd-organization" for="signin-organization2">سطح*}
                                    {*سازمانی</label>*}
                                {*<select class="full-width has-padding has-border" id="signin-organization2">*}
                                    {*<option value="0">سطح سازمانی</option>*}
                                    {*{foreach $organizationList as $each}*}
                                        {*<option value="{$each.id}">{$each.title}</option>*}
                                    {*{/foreach}*}
                                {*</select>*}
                            {*</p>*}
                        {*{/if}*}

                        {*<p class="fieldset">*}
                            {*<label class="image-replace cd-captcha" for="signup-mobile2">کد امنیتی</label>*}
                            {*<input class="full-width has-padding has-border" id="signup-captcha2" type="text"*}
                                   {*placeholder="تصویر روبرو را در این کادر وارد کنید" name="signup-captcha2">*}
                            {*<a id="captchaRefresh" href="#" title="refresh image"*}
                               {*onclick="reloadCaptcha(); return false"></a>*}
                            {*<img id="captchaImage"*}
                                 {*src="{$smarty.const.ROOT_ADDRESS}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}"*}
                                 {*alt="captcha image"/>*}
                            {*<span class="cd-error-message" id="error-signup-captcha2"></span>*}
                        {*</p>*}
                        {*<p class="fieldset fieldset-change">*}
                            {*<input type="checkbox" id="remember-me2"><label for="remember-me2">مرا به خاطر بسپار</label>*}
                        {*</p>*}
                        {*<div class="message-login txtCenter txtRed"></div>*}
                        {*<p class="fieldset">*}
                            {*<input class="full-width " type="button" value="ورود" onclick="LoginOfPanel()">*}
                        {*</p>*}
                        {*<p class="cd-form-bottom-message"><a href="sendMailForm">رمز عبور خود را فراموش کرده اید؟</a>*}
                        {*</p>*}
                    {*</form>*}
                {*</div>*}
            {*</div>*}
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
