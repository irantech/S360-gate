$(document).ready(function () {

  $("#Customer").validate({
    rules: {
      ClientId : "required",
      userName: "required",
      ipAddress: "required",
      password: {
        required: true,
        minlength: 6
      },
      Confirm: {
        required: true,
        minlength: 6,
        equalTo: "#password"
      },
    },
    messages: {
      password: {
        required: "وارد کردن این فیلد الزامیست",
        minlength: "رمز عبور نمی تواند از 6 کارکتر کمتر باشد"
      },
      Confirm: {
        required: "وارد کردن این فیلد الزامیست",
        minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
        equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
      },
    },
    errorElement: "em",
    errorPlacement: function(error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'user_ajax.php',
        type: "post",
        success: function(response) {
          var res = response.split(':');

          if (response.indexOf('success') > -1) {
            $.toast({
              heading: 'افزودن مشتری جدید',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

            setTimeout(function() {
              window.location = 'flyAppClient';
            }, 1000);


          } else {

            $.toast({
              heading: 'افزودن مشتری جدید',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'error',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

          }


        }
      });
    },
    highlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });

  $("#EditClient").validate({
    rules: {
      AgencyName: "required",
      Domain: "required",
      MainDomain: "required",
      DbName: "required",
      DbUser: "required",
      DbPass: "required",
      ThemeDir: "required",
      Manager: "required",
      Address: "required",
      Title: "required",
      IsCurrency: "required",
      UrlRuls: "required",
      IsEnableTicketHTC: "required",
      AllowSendSms: "required",
      IsEnableClub: "required",
      default_language: "required",

      UsernameSms: {
        required: {
          depends: function(element) {
            return $('#AllowSendSms').val() == '1';
          }
        }

      },

      PasswordSms: {
        required: {
          depends: function(element) {
            return $('#AllowSendSms').val() == '1';
          }
        }
      },
      // UserIdApi: {
      //     required: {
      //         depends: function (element) {
      //             return $('#UserNameApi').val() !== '';
      //         }
      //     },
      //     number: true
      // },
      ClubPreCardNo: {
        required: {
          depends: function(element) {
            return $('#IsEnableClub').val() === '1';
          }
        }
      },

      Mobile: {
        required: true,
        minlength: 11,
        number: true,
      },
      Phone: {
        required: true,
        minlength: 4,
      },
      Email: {
        required: true,
        email: true
      }
    },
    messages: {},
    errorElement: "em",
    errorPlacement: function(error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'user_ajax.php',
        type: "post",
        success: function(response) {
          var res = response.split(':');

          if (response.indexOf('success') > -1) {
            $.toast({
              heading: 'ویرایش مشتری ',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

            setTimeout(function() {
              window.location = 'flyAppClient';
            }, 1000);


          } else {

            $.toast({
              heading: 'ویرایش مشتری ',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'error',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

          }


        }
      });
    },
    highlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });

})