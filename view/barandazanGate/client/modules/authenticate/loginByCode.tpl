<form onsubmit='authenticateLoginByCode($(`[data-name="login-by-code"] [data-name="submit"]`))'
        class="form-return">
    <div class="parent-confirmation">
        <h2>##EnterAuthCode##</h2>
        <p>##fourdigitcode##
            <span data-name='main-reader' data-index='entry'></span>
            ##Senttoyou##</p>
    </div>
    <div class="parent-input-sms flex-row-reverse" data-name='codes'>
        <div class='rounded-md'>
            <input class='text-center' type="number" name="sms-number" id="sms-number1" maxlength="1"
                   oninput="authenticateMoveToNextInput(this)">
        </div>
        <div class='rounded-md'>
            <input class='text-center' type="number" name="sms-number" id="sms-number2" maxlength="1"
                   oninput="authenticateMoveToNextInput(this)">
        </div>
        <div class='rounded-md'>
            <input class='text-center' type="number" name="sms-number" id="sms-number3" maxlength="1"
                   oninput="authenticateMoveToNextInput(this)">
        </div>
        <div class='rounded-md'>
            <input class='text-center' type="number" name="sms-number" id="sms-number4" maxlength="1"
                   oninput="authenticateLoginByCode()">
        </div>
    </div>
    <div class="invalid-feedback"></div>
    <div class="parent-submit-edit">

        <div data-name='countdown' class="resend-sms d-none">
            <span class="">##Oneminuteandthirtyseconds##</span>
            <span class="">##Requestcodeagain##</span>
        </div>
        <a href="javascript:" onclick='authenticateNavigate(`check-existence`)' class="edit-mobile-number">##Modifymobilenumber##</a>
    </div>

    <button data-name='submit' onclick='authenticateLoginByCode()' class="btn-form3" type="button">##Confirmandcontinue##
    </button>
{*    <a href="javascript:" onclick='authenticateNavigate(`login-by-password`)' class="login-password">ورود با کلمه عبور</a>*}
</form>