authenticateNavigate("check-existence")
$(document).ready(function () {
   const form_scenarios = $('[data-name="form-scenarios"]')
   form_scenarios.find("form").each(function () {
      $(this).on("submit", function (event) {
         // Prevent default form submission
         event.preventDefault()
      })
   })
})

// Token management functions
function storeAuthToken(token) {
   sessionStorage.setItem('auth_token', token);
}

function getAuthToken() {
   return sessionStorage.getItem('auth_token');
}

function clearAuthToken() {
   sessionStorage.removeItem('auth_token');
}

function isTokenValid() {
   const token = getAuthToken();
   return token && token.length > 0;
}

function redirectToCheckExistence() {
   clearAuthToken();
   if (typeof authenticateNavigate === 'function') {
      authenticateNavigate('check-existence');
   } else {
      // If we're not in the authenticate modal, redirect to the authenticate page
      window.location.href = '/authenticate';
   }
}

function mainReader() {
   const main_data = $('[data-name="main-data"]')
   const main_reader = $('[data-name="main-reader"]')
   main_reader.each(function () {
      const index = $(this).data("index")
      if (
         typeof $(this).attr("data-value") !== "undefined" &&
         $(this).attr("data-value") !== false
      ) {
         $(this).val(main_data.find('[data-name="' + index + '"]').val())
      } else {
         $(this).html(main_data.find('[data-name="' + index + '"]').val())
      }
   })
}

function authenticateValidator(_this, status = true, message = "") {
   if (status) {
      _this.addClass("is-invalid")
      _this.parent().find(".invalid-feedback").html(message)
   } else {
      _this.removeClass("is-invalid")
      _this.parent().find(".invalid-feedback").html("")
   }
}

function authenticateCheckExistenceValidator(_this) {
   if (!validateMobileOrEmail(_this.val())) {
      authenticateValidator(
         _this,
         true,
         useXmltag("PleaseEnterValidMobileOrEmail")
      )
      return false
   }
   authenticateValidator(_this, false)
   return true
}

function authenticateCheckExistence(_this) {
   const main_data = $('[data-name="main-data"]')
   const form_scenarios = $('[data-name="form-scenarios"]')
   const entry_input = form_scenarios.find(
      '[data-name="check-existence"] [data-name="entry"]'
   )
   const entry = entry_input.val()

   const captcha_input = $('#signin-captcha2'); // استفاده از کپچا شما
   const captchaValue = captcha_input.val();

   if (!captchaValue || captchaValue.length < 1 || captchaValue.length > 5) {
      reloadCaptchaByClass();
      fireToast(false, useXmltag("WrongSecurityCode"), "");
      loadingToggle(_this, false)
      return false;
   }

   loadingToggle(_this)


   const ajaxData = {
      className: "members",
      method: "callCheckExistence",
      entry,
      captcha_code:captchaValue,
      to_json: true,
   }

   $.ajax({
      url: `${amadeusPath}ajax`,
      type: "POST",
      dataType: "JSON",
      data: JSON.stringify(ajaxData),
      success: function (data) {
         const isMember = data.data.data === true
         main_data.find('[data-name="entry"]').val(entry)
         console.log('data.status',data.status)
         // Store auth token if provided
         if (data.data && data.data.auth_token) {
            storeAuthToken(data.data.auth_token);
            console.log('Auth token stored:', data.data.auth_token);
         }

         if (data.status === "success") {

            console.log('isMember',isMember)
            if (isMember) {
               main_data.find('[data-name="is-member"]').val("1")
               authenticateNavigate("login-by-password")
            } else {
               console.log('else')
               if (!validateMobile(entry)) {
                  fireToast(false, useXmltag("PleaseEnterValidMobile"), "")
                  loadingToggle(_this, false)
                  return false
               }

               main_data.find('[data-name="is-member"]').val("0")
               authenticateInitDigitCode(_this, false) // Skip captcha check for new users
            }
         } else {
            fireToast(false, useXmltag("RequestFailed"), "")
         }

         loadingToggle(_this, false)
         reloadCaptchaByClass();
      },
      error: function (error) {
         // Check if error is related to token expiration
         if (error?.responseJSON?.message &&
            (error.responseJSON.message.includes('احراز هویت نامعتبر') ||
               error.responseJSON.message.includes('invalid') ||
               error.responseJSON.message.includes('expired'))) {
            redirectToCheckExistence();
            fireToast(false, "توکن احراز هویت منقضی شده است. لطفا مجددا تلاش کنید", "");
         } else {
            fireToast(false, error?.responseJSON?.message, "");
         }
         loadingToggle(_this, false);
         reloadCaptchaByClass();
      }
   });

}

function authenticateMoveToNextInput(currentInput) {
   const maxLength = parseInt(currentInput.getAttribute("maxlength"))
   const inputValue = currentInput.value

   if (inputValue.length >= maxLength) {
      const nextInput =
         currentInput.parentNode.nextElementSibling?.querySelector("input")
      if (nextInput) {
         nextInput.focus()
      }
   }
}

function authenticateLoginByPassword(_this) {
   loadingToggle(_this)

   // Check if token is available, if not redirect to check-existence
   if (!isTokenValid()) {
      loadingToggle(_this, false);
      redirectToCheckExistence();
      return false;
   }

   const main_data = $('[data-name="main-data"]')
   const entry = main_data.find('[data-name="entry"]').val()

   const form_scenarios = $('[data-name="form-scenarios"]')
   const password = form_scenarios
      .find('[data-name="login-by-password"] [data-name="password"]')
      .val()

   const ajaxData = {
      className: "members",
      method: "callMemberLogin",
      entry,
      password,
      auth_token: getAuthToken(),
      to_json: true,
   }


   if(password != ''){
      $.ajax({
         url: `${amadeusPath}ajax`,
         type: "POST",
         dataType: "JSON",
         data: JSON.stringify(ajaxData),
         success: function (data) {
            if (data.status === "success") {
               if (data.data) {
                  fireToast(true, useXmltag("Loginsuccessfully"), "")
                  return authenticateRedirect()
               } else {
                  fireToast(false, useXmltag("PasswordIsWrong"), "")
               }
            } else {
               fireToast(false, useXmltag("RequestFailed"), "")
            }
            loadingToggle(_this, false)
            reloadCaptchaByClass();
         },
         error: function (error) {
            // Check if error is related to token expiration
            if (error?.responseJSON?.message &&
               (error.responseJSON.message.includes('احراز هویت نامعتبر') ||
                  error.responseJSON.message.includes('invalid') ||
                  error.responseJSON.message.includes('expired'))) {
               redirectToCheckExistence();
               fireToast(false, "توکن احراز هویت منقضی شده است. لطفا مجددا تلاش کنید", "");
            } else {
               fireToast(false, error?.responseJSON?.message, "");
            }
            loadingToggle(_this, false);
            reloadCaptchaByClass();
         }
      })
   }else{
      fireToast(false, useXmltag("RequestFailed"), "")
      loadingToggle(_this, false)
   }

}
function reloadCaptchaByClass() {
   console.log('a')
   var capcha = amadeusPath + 'captcha/securimage_show.php?sid=' + Math.random();
   console.log('capcha',capcha)
   $(".captchaImage").attr("src", capcha);
}
function authenticateChangePasswordValidator() {
   const form_scenarios = $('[data-name="form-scenarios"]')
   const this_scenario = form_scenarios.find('[data-name="change-password"]')
   const password = this_scenario.find('[data-name="password"]')
   const password_confirmation = this_scenario.find(
      '[data-name="password-confirmation"]'
   )

   if (password.val() !== password_confirmation.val()) {
      authenticateValidator(
         password_confirmation,
         true,
         useXmltag("NewPasswordNotSameRepeating")
      )
      return false
   } else {
      authenticateValidator(password_confirmation, false)
   }
   if (password.val().length < 6) {
      authenticateValidator(
         password,
         true,
         translateXmlByParams("PleaseEnterAtLeastXCharacters", {number: "6"})
      )
      return false
   } else {
      authenticateValidator(password, false)
   }
   return true
}

function authenticateChangePassword(_this) {
   const form_scenarios = $('[data-name="form-scenarios"]')
   const this_scenario = form_scenarios.find('[data-name="change-password"]')
   const password = this_scenario.find('[data-name="password"]').val()
   const password_confirmation = this_scenario
      .find('[data-name="password-confirmation"]')
      .val()
   authenticateChangePasswordValidator()
   if (password !== password_confirmation) {
      fireToast(false, useXmltag("NewPasswordNotSameRepeating"), "")
      return false
   }
   if (password.length < 6) {
      const text = translateXmlByParams("PleaseEnterAtLeastXCharacters", {
         number: "6",
      })
      fireToast(false, text, "")
      return false
   }
   loadingToggle(_this)

   const ajaxData = {
      method: "callChangePassword",
      className: "members",
      password,
      to_json: true,
   }

   $.ajax({
      url: `${amadeusPath}ajax`,
      type: "POST",
      dataType: "JSON",
      data: JSON.stringify(ajaxData),
      success: function (data) {
         if (data.status === "success") {
            fireToast(true, useXmltag("PasswordUpdated"), "")
            return authenticateRedirect()
         } else {
            fireToast(false, useXmltag("RequestFailed"), "")
         }
         loadingToggle(_this, false)
      },
   })
}
let countdownInterval = null;
let isSendingCode = false;
function authenticateInitDigitCode(_this=null, checkCaptcha=true) {
   if (isSendingCode) return; // جلوگیری از کلیک‌های مکرر
   isSendingCode = true; // علامت بزن که داریم ارسال می‌کنیم

   clearInterval(countdownInterval);

   // Check if token is available, if not redirect to check-existence
   if (!isTokenValid()) {
      isSendingCode = false;
      redirectToCheckExistence();
      return false;
   }

   countdownInterval=null

   const codes = $("[data-name='codes']")
   authenticateValidator(codes, false)
   codes.find("div").each(function () {
      loadingToggle($(this))
      $(this).find("input").val("")
   })
   const form_scenarios = $('[data-name="form-scenarios"]')
   const countdownElement = form_scenarios.find(
      '[data-name="login-by-code"] [data-name="countdown"]'
   )
   const main_data = $('[data-name="main-data"]')
   const entry = main_data.find('[data-name="entry"]').val()

   main_data.find('[data-name="entry"]').val(entry)

   let ajaxData = {
      method: "callAuthenticateDigitCodeCreate",
      className: "members",
      entry,
      auth_token: getAuthToken(),
      to_json: true
   }
   console.log('JSON.stringify(ajaxData)',JSON.stringify(ajaxData))
   $.ajax({
      url: `${amadeusPath}ajax`,
      type: "POST",
      dataType: "JSON",
      data: JSON.stringify(ajaxData),
      success: function (data) {
         authenticateNavigate("login-by-code")
         countdownElement.removeClass("d-none")

         if (data.status === "success") {

            if(data.data){

            }
            const targetTime = new Date()
            targetTime.setMinutes(targetTime.getMinutes() + 1)
            targetTime.setSeconds(targetTime.getSeconds() + 30)
            if (!countdownInterval) {
               countdownInterval = setInterval(updateCountdown, 1000)
            }

            function updateCountdown() {
               const currentTime = new Date()
               const timeDifference = targetTime - currentTime


               if (timeDifference <= 0) {
                  clearInterval(countdownInterval)
                  countdownElement.html(`
            <a href='javascript:' onclick='authenticateInitDigitCode()' class='edit-mobile-number'>
              ${useXmltag("SendCode")}
            </a>
            `)
               } else {
                  const minutes = Math.floor(timeDifference / (1000 * 60))
                  const seconds = Math.floor( (timeDifference % (1000 * 60)) / 1000 )

                  countdownElement.html(
                     `${minutes.toString().padStart(2, "0")}:${seconds
                        .toString()
                        .padStart(2, "0")} ${useXmltag("RemainingToSendCode")}`
                  )
               }
            }


            if (data.data) {
               codes.find("div:first-child input").focus()
            } else {
               fireToast(false, useXmltag("WrongCode"), "")
            }
         } else {
            fireToast(false, useXmltag("RequestFailed"), "")
         }

         codes.find("div").each(function () {
            loadingToggle($(this), false)
         })
         isSendingCode = false; // Reset the flag
         reloadCaptchaByClass();
      },
      error:function(error){
         // Check if error is related to token expiration
         console.log('error',error?.responseJSON)
         if(error?.responseJSON?.message ){
            if(error.responseJSON.message.includes('احراز هویت نامعتبر') ||
               error.responseJSON.message.includes('invalid') ||
               error.responseJSON.message.includes('expired')){
               redirectToCheckExistence();
               fireToast(false, "توکن احراز هویت منقضی شده است. لطفا مجددا تلاش کنید", "");
            }else{
               fireToast(false, error?.responseJSON?.message, "");
            }
         }

         reloadCaptchaByClass();
         isSendingCode = false;
      }
   })
}
function authenticateLoginByCode() {

   const main_data = $('[data-name="main-data"]')
   const form_scenarios = $('[data-name="form-scenarios"]')
   const form_scenario = form_scenarios.find('[data-name="login-by-code"]')
   const submit_button = form_scenario.find('[data-name="submit"]')

   // Check if token is available, if not redirect to check-existence
   if (!isTokenValid()) {
      redirectToCheckExistence();
      return false;
   }

   const came_from = main_data.find('[data-name="came-from"]').val()
   const is_member = main_data.find('[data-name="is-member"]').val()
   const entry = main_data.find('[data-name="entry"]').val()
   const codes = form_scenario.find('[data-name="codes"]')
   authenticateValidator(codes, false)
   let password = ""
   codes.find("input").each(function () {
      password += $(this).val()
   })

   if (password.length !== 4) {
      return false
   }

   loadingToggle(submit_button)

   const ajaxData = {
      className: "members",
      method: is_member === "1" ? "callMemberLogin" : "callMemberRegister",
      entry,
      password,
      auth_token: getAuthToken(),
      to_json: is_member === "1" ? true : false,
   }

   $.ajax({
      url: `${amadeusPath}ajax`,
      type: "POST",
      dataType: "JSON",
      data: JSON.stringify(ajaxData),
      success: function (data) {
         console.log(data)
         if (data.data) {
            if (came_from === "forget-password") {
               authenticateNavigate("register")
            } else {
               if (is_member === "0") {
                  authenticateNavigate("register")
               } else {
                  fireToast(
                     true,
                     useXmltag("Loginsuccessfully"),
                     ""
                  )
                  return authenticateRedirect()
               }
            }
         } else {
            authenticateValidator(codes, true, useXmltag("WrongCode"))
            fireToast(false, useXmltag("WrongCode"), "")
         }
         loadingToggle(submit_button, false)
         reloadCaptchaByClass();
      },
      error:function(error){
         // Check if error is related to token expiration
         if (error?.responseJSON?.message &&
            (error.responseJSON.message.includes('احراز هویت نامعتبر') ||
               error.responseJSON.message.includes('invalid') ||
               error.responseJSON.message.includes('expired'))) {
            redirectToCheckExistence();
            fireToast(false, "توکن احراز هویت منقضی شده است. لطفا مجددا تلاش کنید", "");
         } else {
            fireToast(false, useXmltag("accordingError"), error.responseJSON.message)
         }
         loadingToggle(submit_button, false)
         reloadCaptchaByClass();
      }
   })
}

function authenticateRegister() {
   const main_data = $('[data-name="main-data"]')
   const form_scenarios = $('[data-name="form-scenarios"]')
   const form_scenario = form_scenarios.find('[data-name="register"]')
   const submit_button = form_scenario.find('[data-name="submit"]')

   // Check if token is available, if not redirect to check-existence
   if (!isTokenValid()) {
      redirectToCheckExistence();
      return false;
   }

   const entry = main_data.find('[data-name="entry"]').val()
   const name = form_scenario.find('[data-name="name"]').val()
   const family = form_scenario.find('[data-name="family"]').val()
   const password = form_scenario.find('[data-name="password"]').val()
   const introduced_code = form_scenario
      .find('[data-name="introduced-code"]')
      .val()


   if(name == '' && family == '') {
      fireToast(false, 'وارد کردن نام و نام خانوادگی الزامی است .', "")
   }else{
      loadingToggle(submit_button)
      const ajaxData = {
         className: "members",
         method: "callAuthenticateEditUser",
         entry,
         name,
         family,
         password,
         reagentCode:introduced_code,
         auth_token: getAuthToken(),
         to_json: true,
      }
      $.ajax({
         url: `${amadeusPath}ajax`,
         type: "POST",
         dataType: "JSON",
         data: JSON.stringify(ajaxData),
         success: function (data) {
            if (data.status === "success") {
               if (data.data.status) {
                  fireToast(true, useXmltag("SuccessRegisterUser"), "")
                  return authenticateRedirect()
               } else {
                  fireToast(false, data.data.message, "")
               }
            } else {
               fireToast(false, useXmltag("RequestFailed"), "")
            }


            loadingToggle(submit_button, false)
         },
      })
   }


}

function authenticateLoginByCodeOpen() {
   const navigator = $("[data-name='authenticate-navigator']")
   navigator.attr("data-to", "login-by-password")
}

function authenticateNavigate(to) {
   const main_data = $('[data-name="main-data"]')
   const navigator = $('[data-name="authenticate-navigator"]')
   const form_scenarios = $('[data-name="form-scenarios"]')
   const came_from = form_scenarios.find(".form-item.active").data("name")

   main_data.find('[data-name="came-from"]').val(came_from)

   if (to === "check-existence") {
      navigator.addClass("d-none")
   } else {
      navigator.removeClass("d-none")

      if (to === "login-by-code" && came_from === "login-by-password") {
         navigator.attr("data-to", "login-by-password")
      } else if (
         to === "check-existence" &&
         came_from === "login-by-password"
      ) {
         navigator.attr("data-to", "check-existence")
      } else if (to === "login-by-code" && came_from === "change-password") {
         navigator.attr("data-to", "forget-password")
      } else if (to === "register" || to === "login-by-password") {
         navigator.attr("data-to", "check-existence")
      } else if (to === "forget-password") {
         navigator.attr("data-to", "login-by-password")
      } else if (to === "login-by-code") {
         navigator.attr("data-to", "forget-password")
      }
   }

   form_scenarios
      .find(".form-item")
      .removeClass("d-block active")
      .addClass("d-none")
   form_scenarios
      .find(`[data-name="${to}"]`)
      .removeClass("d-none")
      .addClass("d-block active")

   // Manage captcha visibility based on token availability
   manageCaptchaVisibility(to)

   mainReader()
}

function manageCaptchaVisibility(currentPage) {
   const hasToken = isTokenValid();

   // Always show captcha on check-existence page
   if (currentPage === "check-existence") {
      return;
   }

   // For pages that require a token, redirect to check-existence if no token
   const tokenRequiredPages = ['login-by-password', 'login-by-code', 'register', 'change-password'];
   if (tokenRequiredPages.includes(currentPage) && !hasToken) {
      redirectToCheckExistence();
      return;
   }
}

function authenticateRedirect() {
   // Clear token on successful login since user is now authenticated via session
   clearAuthToken();

   const main_data = $('[data-name="main-data"]')
   const use_type = main_data.find('[data-name="use-type"]').val()
   const isIframe = $("#isIframe").val()
   if (use_type && use_type.length && use_type !== "") {
      popupBuyNoLogin(use_type)
   }
   else {
      if (gdsSwitch === "authenticate") {
         if (lang === "fa") {
            
            if (isIframe == 1) {
               window.location.href = clientMainDomain + "/gds/fa/profile"
            } else {
               window.location.href = clientMainDomain
            }
         } else {
            if (default_lang === "en") {
               window.location.href = clientMainDomain
            } else {
               window.location.href = clientMainDomain + "/" + lang
            }
         }
      }
   }
}

function authenticateCloseModal() {
   $(".cd-user-modal").trigger("click")
}




function passwordShow() {
   const password = document.querySelector('#password-crossing');
   const eyeSlash = document.querySelector('.eye-slash');
   const eyeNotSlash = document.querySelector('.eye-not-slash');

   if (password.type === 'password') {
      console.log(password)
      console.log(password.type)
      console.log(eyeSlash.style.display)
      console.log(eyeNotSlash.style.display)
      password.type = 'text';
      eyeSlash.style.display = 'none';
      eyeNotSlash.style.display = 'inline';
   } else {
      password.type = 'password';
      eyeSlash.style.display = 'inline';
      eyeNotSlash.style.display = 'none';
   }

}


