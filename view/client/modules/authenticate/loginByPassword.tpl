<form onsubmit='authenticateLoginByPassword($(`[data-name="login-by-password"] [data-name="submit"]`))'
        class="form-return">
    <div class="parent-confirmation">
        <h2>##Welcomeing##</h2>
        <div data-name='main-reader' data-index='entry' class='w-100 d-flex justify-content-center'></div>
        <p>##insertPassword##. </p>
    </div>
    <div class="parent-input-word-crossing">
         <div class="parent-password-crossing-input position-relative">
            <input type="password" data-name="password" id="password-crossing" name='password' class="text-left">
            <svg class="eye-slash eye" onclick='passwordShow()'  viewBox="0 0 24 24" width="1.3em" fill="#939597"><path d="M19.716 3.22a.756.756 0 0 1 1.065 0 .756.756 0 0 1 0 1.064l-2.632 2.633-1.103 1.095-1.92 1.927-1.101 1.095-2.992 2.993-1.095 1.102-1.515 1.508-1.155 1.155-2.984 2.992a.768.768 0 0 1-.533.218.768.768 0 0 1-.532-.218.756.756 0 0 1 0-1.065l2.632-2.632a11.41 11.41 0 0 1-4.02-3.915 2.229 2.229 0 0 1 0-2.34C3.925 7.39 7.817 5.252 12 5.252c1.657 0 3.262.337 4.732.96l2.984-2.993Zm-.232 4.604a11.17 11.17 0 0 1 2.684 3.008c.443.72.443 1.62 0 2.34-2.092 3.442-5.983 5.58-10.168 5.58a12.16 12.16 0 0 1-3.052-.39l1.268-1.26c.585.097 1.177.15 1.784.15 3.659 0 7.063-1.86 8.885-4.86.15-.24.15-.54 0-.78a9.783 9.783 0 0 0-2.467-2.715l1.066-1.073ZM12 6.752c-3.66 0-7.064 1.86-8.886 4.86-.15.24-.15.54 0 .78.922 1.53 2.265 2.76 3.84 3.6l1.919-1.928a3.734 3.734 0 0 1-.622-2.062c0-2.07 1.68-3.75 3.749-3.75.765 0 1.47.232 2.062.622l1.515-1.507A10.797 10.797 0 0 0 12 6.752Zm3.712 4.853c.015.134.037.262.037.397a3.75 3.75 0 0 1-3.75 3.75c-.134 0-.262-.022-.397-.038l4.11-4.11ZM12 9.752a2.257 2.257 0 0 0-2.25 2.25c0 .345.083.668.225.967l2.992-2.992A2.235 2.235 0 0 0 12 9.752Z" fill-rule="evenodd"></path></svg>
            <svg class="eye-not-slash eye" onclick='passwordShow()' viewBox="0 0 24 24" width="1.3em" fill="#939597"><path d="M12 5.25c4.241 0 8.088 2.153 10.17 5.578.44.722.44 1.623.001 2.343-2.083 3.426-5.93 5.579-10.171 5.579-4.242 0-8.088-2.153-10.17-5.578a2.248 2.248 0 0 1-.001-2.343C3.912 7.403 7.759 5.25 12 5.25Zm0 1.5c-3.719 0-7.08 1.88-8.89 4.859a.749.749 0 0 0 0 .783C4.92 15.37 8.282 17.25 12 17.25c3.719 0 7.08-1.88 8.89-4.859a.749.749 0 0 0 0-.783C19.08 8.63 15.718 6.75 12 6.75Zm0 1.5a3.75 3.75 0 1 1 0 7.5 3.75 3.75 0 0 1 0-7.5Zm0 1.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" fill-rule="evenodd"></path></svg>
        </div>

        <button onclick='authenticateLoginByPassword($(this))' class="btn-form4" type="button">##loginTo## {$smarty.const.CLIENT_NAME}</button>
        <div class="parent-forget-sms">
{*            <a href="javascript:" onclick='authenticateNavigate(`forget-password`)' class="forget-word-crossing">فراموشی کلمه عبور</a>*}

            <a href="javascript:" onclick='authenticateInitDigitCode()' class="login-sms-disposable">##SendOTPCode## </a>
        </div>
    </div>
</form>