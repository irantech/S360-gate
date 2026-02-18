
// let added_files=[]
$(function(){
  $('.passport_input_replacement').click(function(){
    //This will make the element with class passport_input_replacement launch the select file dialog.
    var assocInput = $(this).siblings("input[type=file]");
    console.log(assocInput);
    assocInput.click();
  });
  $('.file_input_with_replacement').change(function(){
    //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
    var thisInput = $(this);
    var assocInput = thisInput.siblings("input.passport_input_replacement");
    if (assocInput.length > 0) {
      var filename = (thisInput.val()).replace(/^.*[\\\/]/, '');
      assocInput.val(filename);
    }
  });
});

$(function(){
  $('.pic_input_replacement').click(function(){
    //This will make the element with class pic_input_replacement launch the select file dialog.
    var assocInput = $(this).siblings("input[type=file]");
    console.log(assocInput);
    assocInput.click();
  });
  $('.pic_input_with_replacement').change(function(){
    //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
    var thisInput = $(this);
    var assocInput = thisInput.siblings("input.pic_input_replacement");
    if (assocInput.length > 0) {
      var picname = (thisInput.val()).replace(/^.*[\\\/]/, '');
      assocInput.val(picname);
    }
  });
});


if (lang == 'fa') {
  $('#enter_date').datepicker({
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
  $('#exit_date').datepicker({
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
}else {
  $('#enter_date').datepicker({
    regional: '',
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
  $('#exit_date').datepicker({
    regional: '',
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
}

//add visa
$('#iranVisaAdd').validate({

  rules: {
    name: 'required',
    family: 'required',
    nationality: 'required',
    sex: 'required',
    country_birth: 'required',
    father_name: 'required',
    type_passport: 'required',
    ever_been_iran: 'required',
    type_visa: 'required',
    married: 'required',
    enter_date: 'required',
    exit_date: 'required',
    previous_nationality: 'required',
    phone: 'required',
    mobile: {
        required: true,
        number: true,
        // phone: true,
        // minlength: 11,
        // maxlength: 11
    },
    email: {
      required: true,
      email: true
    },
    passport_text: 'required',
    pic_text: 'required',
    'item-captcha': {
      required: true,
      //minlength: 4,
      maxlength: 5
    },
  },
  messages: {
    'name': {
      'required': useXmltag("PleaseenterName")
    },
    'family': {
      'required': useXmltag("PleaseenterLastName")
    },
    'nationality': {
      'required': useXmltag("PleaseEnterNationality")
    },
    'sex': {
      'required': useXmltag("PleaseEnterSex")
    },
    'country_birth': {
      'required': useXmltag("PleaseEnterCountryBirth")
    },
    'father_name': {
      'required': useXmltag("PleaseEnterFatherName")
    },
    'type_passport': {
      'required': useXmltag("PleaseEnterTypePassport")
    },
    'ever_been_iran': {
      'required': useXmltag("PleaseEnterEverBeenIran")
    },
    'type_visa': {
      'required': useXmltag("PleaseEnterTypeVisa")
    },
    'married': {
      'required': useXmltag("PleaseEnterMarried")
    },
    'enter_date': {
      'required': useXmltag("PleaseEnterEnterDate")
    },
    'exit_date': {
      'required': useXmltag("PleaseEnterExitDate")
    },
    'previous_nationality': {
      'required': useXmltag("PleaseEnterPreviousNationality")
    },
    'phone': {
      'required': useXmltag("PleaseenterPhone")
    },
    'mobile': {
      'required': useXmltag("PleaseenterPhoneNumber"),
      'number': useXmltag("PhoneNumberError"),
      // 'phone': useXmltag("PhoneNumberError"),
      // 'maxlength': useXmltag("PleaseEnterMobile"),
      // 'maxlength': useXmltag("PhoneNumberError"),
    },
    'email': {
      'email': useXmltag("Invalidemail"),
      'maxlength': useXmltag("Emaillong")
    },
    'passport_text': {
      'required': useXmltag("PleaseEnterPassport")
    },
    'pic_text': {
      'required': useXmltag("PleaseEnterPicUser")
    },
    'item-captcha': {
      'required': useXmltag("Entersecuritycode"),
      'maxlength': useXmltag('WrongSecurityCode')
    }
  },
  errorElement: 'em',
  submitHandler: function(form) {

    //tinyMCE.triggerSave();
    $.post(amadeusPath + 'captcha/securimage_check.php',
      {
        captchaAjax: $('#item-captcha').val()
      },
      function (data) {
        // console.log(data)
        if (data == true) {
          reloadCaptcha();
          $(form).ajaxSubmit({
            url: amadeusPath + 'ajax',
            type: 'POST',
            success: function (response) {

              if (response.success === true) {
                var statusType = 'green';
              } else {
                var statusType = 'red';
              }

              $.alert({
                title: useXmltag("OrderIranVisaForm"),
                icon: 'fa fa-refresh',
                content: response.message,
                rtl: true,
                type: statusType
              });
              if (response.success === true) {

                $('#name').val('');
                $('#nickName').val('');
                $('#family').val('');
                $('#nationality').val('');
                $('#sex').val('');
                $('#country_birth').val('');
                $('#father_name').val('');
                $('#type_passport').val('');
                $('#profession_title').val('');
                $('#company_name').val('');
                $('#ever_been_iran').val('');
                $('#number_trip_iran').val('');
                $('#married').val('');
                $('#type_visa').val('');
                $('#enter_date').val('');
                $('#exit_date').val('');
                $('#previous_nationality').val('');
                $('#mobile').val('');
                $('#phone').val('');
                $('#email').val('');
                $('#hotels_accommodation').val('');
                $('#passport_text').val('');
                $('#file_passport').val('');
                $('#pic_text').val('');
                $('#pic_user').val('');
                $(".select2").select2();
              }


            }

          })
        } else {
          reloadCaptcha();
          $.alert({
            title: useXmltag("OrderIranVisaForm"),
            icon: 'fa fa-warning',
            content: useXmltag("WrongSecurityCode"),
            rtl: true,
            type: 'red'
          });
          return false;
        }
      });

  },

})


