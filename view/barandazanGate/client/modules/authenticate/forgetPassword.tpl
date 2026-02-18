<form onsubmit='authenticateInitDigitCode($(`[data-name="forget-password"] [data-name="submit"]`))'
        class="form-return">
    <div class="parent-confirmation">
        <h2>##Forgotpassword##</h2>
        <p>##recoveryourpassword##</p>
    </div>
    <div class="parent-forget-box">
        <input type="text" name="mobile"
               data-name='main-reader' data-index='entry' data-value
               id="forget-email-number-mobile" placeholder="##emailormobilephone##">
        <button class="btn-form5" data-name='submit' onclick=authenticateInitDigitCode() type="button">##Passwordrecovery##</button>
    </div>
</form>