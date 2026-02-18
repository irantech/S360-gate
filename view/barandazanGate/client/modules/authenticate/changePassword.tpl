<form onsubmit='authenticateChangePassword($(`[data-name="change-password"] [data-name="submit"]`))'
        class="form-return">
    <div class="parent-confirmation">
        <h2>##Enternewpassword##</h2>
    </div>
    <div class="parent-forget-box">
        <div class='d-flex flex-wrap w-100 gap-5'>

            <input type="password"
                   onchange='authenticateChangePasswordValidator()'
                   onkeyup='authenticateChangePasswordValidator()'
                   name='password'
                   class='input-mobile' data-name='password' placeholder="##Newpassword##">
            <div class="invalid-feedback"></div>
        </div>
        <div class='d-flex flex-wrap w-100 gap-5'>

            <input type="password"
                   onchange='authenticateChangePasswordValidator()'
                   onkeyup='authenticateChangePasswordValidator()'
                   name='password_confirmation'
                   class='input-mobile' data-name='password-confirmation' placeholder="##Repeatnewpassword##">
            <div class="invalid-feedback"></div>

        </div>
        <button class="btn-form5"
                data-name='submit'
                onclick='authenticateChangePassword($(this))'
                type="button">##Changpassword##
        </button>
        <a href="javascript:" onclick='authenticateRedirect()'
           class="login-password-sms">##Optout##</a>
    </div>
</form>
