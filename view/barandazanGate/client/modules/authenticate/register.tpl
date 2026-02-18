<div class="parent-confirmation">
    <h2>##Yourmembership##</h2>
    <div data-name='main-reader' data-index='entry' class='w-100 d-flex justify-content-center number-mobile-data-supplementary'></div>
    <p class='data-supplementary'>##additionalinformation##</p>
</div>
<form onsubmit='authenticateRegister()'
        class="form-return">
    <input type="text" data-name="name" name="name" placeholder="##Name##">
    <input type="text" data-name="family" name="family" placeholder="##LastName##">
    <input type="password" data-name="password" name="password" placeholder="##Password##">
    <input type="text" data-name="introduced-code" name="introduced-code" placeholder="##Reagentcode##">
    <button data-name="submit"
            onclick='authenticateRegister()'
            class="btn-form2" type="button">##SetAccount##</button>
    <div class="parent-forget-sms justify-content-center">
        <a href="javascript:" onclick='authenticateRedirect()' class="login-sms-disposable">##completelater##</a>
    </div>
</form>
