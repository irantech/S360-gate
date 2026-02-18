$.validator.addMethod("pattern", function (value, element, pattern) {
  if (this.optional(element)) {
    return true;
  }
  return new RegExp(pattern).test(value);
}, "Invalid input format");

$.validator.addMethod("fileType", function(value, element, accept) {
  if (element.files.length === 0) {
    return true; // No file selected; validation is considered successful
  }

  // Get the file extension
  var extension = value.split('.').pop().toLowerCase();

  // Check if the file extension matches the accepted types
  return accept.split(',').map(function(type) {
    return type.trim().toLowerCase();
  }).indexOf(extension) !== -1;
}, "Invalid file type");

$.validator.addMethod("englishFileName", function(value, element) {
  if (element.files.length === 0) {
    return true; // No file selected; validation is considered successful
  }

  // Get the file name without the extension
  var fileName = value.split('.').slice(0, -1).join('.');

  // Check if the file name contains only English characters (letters and spaces)
  var namePattern = /^[A-Za-z\s]+$/;

  return namePattern.test(fileName);
}, "File name should only contain English characters");

$.validator.addMethod("numbersOnly", function(value, element) {
  // Check if the input consists of only numeric characters
  return /^\d+$/.test(value);
}, "Please enter numbers only");

  $('#add_representatives').validate({
    rules: {
      'company_name': {
        required: true,
      },
      'english_company_name': {
        required: true,
        pattern: /^[A-Za-z0-9\s]+$/, // Allow English letters, numbers, and spaces
      },
      'manager_name': {
        required: true,
      },
      'phone_number': {
        required: true,
        phone: true,
        maxlength: 12
      },
      'mobile_number': {
        required: true,
        phone: true,
        maxlength: 11
      },
      'fax_number': {
        required: true,
        maxlength: 20,
        numbersOnly: true // Add the custom 'numbersOnly' method

      },
      'email': {
        email: true
      },
      // 'website': {
      //   required: true,
      //   url: true, // Use the 'url' method for URL validation
      //
      // },
      'postal_code': {
        required: true,
        maxlength: 20
      },
      'city': {
        required: true,
      },
      'activity_type': {
        required: true,
      },
      'country': {
        required: true,
      },
      'province': {
        required: true,
      },
      'address': {
        required: true,
      },
      'image': {
        required: true,
        fileType: "jpg, jpeg, png, gif",
      }
    },
    messages: {
      'company_name': {
        'required': useXmltag("EnterAmountValue"),
      },
      'english_company_name': {
        'required': useXmltag("EnterAmountValue"),
        'pattern': useXmltag("EnglishCharactersOnly"),
      },
      'manager_name': {
        'required': useXmltag("EnterAmountValue"),
      },
      'phone_number': {
        'required': useXmltag("EnterAmountValue"),
        'phone': useXmltag("cellPhoneNumbersError"),
        'maxlength': useXmltag("LongCellPhoneNumbersError")
      },
      'mobile_number': {
        'required': useXmltag("PleaseenterPhoneNumber"),
        'phone': useXmltag("PhoneNumberError"),
        'maxlength': useXmltag("LongPhoneNumberError")
      },
      'fax_number': {
        'required': useXmltag("EnterAmountValue"),
        'maxlength': useXmltag("LongFaxNumbersError"),
        'numbersOnly': useXmltag("NumbersOnlyr")

      },
      'email': {
        'email': useXmltag("Invalidemail"),
        'maxlength': useXmltag("Emaillong")
      },
      // 'website': {
      //   'required': useXmltag("EnterAmountValue"),
      //   'url': useXmltag("InvalidURL"), // Add a custom error message for URL validation
      // },
      'postal_code': {
        'required': useXmltag("EnterAmountValue"),
        'maxlength': useXmltag("LongNumbersError")
      },
      'country': {
        'required': useXmltag("EnterAmountValue"),
      },
      'province': {
        'required': useXmltag("EnterAmountValue"),
      },
      'city': {
        'required': useXmltag("EnterAmountValue"),
      },
      'activity_type': {
        'required': useXmltag("EnterAmountValue"),
      },
      'country': {
        'required': useXmltag("EnterAmountValue"),
      },
      'province': {
        'required': useXmltag("EnterAmountValue"),
      },
      'address': {
        'required': useXmltag("EnterAmountValue"),
      },
      'image': {
        'required': useXmltag("EnterAmountValue"),
        'fileType': useXmltag("InvalidImageFileType")
      }
    },
    errorElement: 'em',
    errorPlacement: function(error, element) {
      // Add the `help-block` class to the error element
      error.addClass('help-block')

      if (element.prop('type') === 'checkbox') {
        error.insertAfter(element.parent('label'))
      } else {
        error.insertAfter(element)
      }
    },
    submitHandler: function(form) {
      $('#submit-button').prop('disabled', true);
      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: 'POST',
        success: function(response) {
          $('#submit-button').prop('disabled', false);
          console.log(response);
          let displayIcon
          if (response.success === true) {
            displayIcon = 'success'
          }


          $.alert({
            title: useXmltag("reserveAgency"),
            icon: 'fa fa-user',
            content: response.message,
            rtl: true,
            type: 'green'
          });

          $('#add_representatives').find(':input:visible').val('');
          $('#add_representatives').find('select').select2();


          if (response.success === true) {
            setTimeout(function() {
              // location.reload()
              window.location = `${amadeusPath}itadmin/representatives/list`;
            }, 1000)
          }
        },
        error: function(response) {
          let displayIcon
          displayIcon = 'error'

          $.alert({
            title: useXmltag("errorReserveAgency"),
            icon: 'fa fa-user',
            content: response.responseJSON.message,
            rtl: true,
            type: 'red'
          });
        }
      })
    },
    highlight: function(element, errorClass, validClass) {
      $(element)
        .parents('.form-group ')
        .addClass('has-error')
        .removeClass('has-success')
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element)
        .parents('.form-group ')
        .addClass('has-success')
        .removeClass('has-error')
    },
  })


///////نمایش لیست شهرها//
function FillComboCity2(Country, ComboCity){

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      Country: Country,
      ComboCity: ComboCity,
      flag: "FillComboCountry"
    },
    function (data) {

      $( "#" + ComboCity).html(data);

    })

}//end function

