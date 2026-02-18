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

$(document).ready(function () {

  $("#add_representatives").validate({
    rules: {
      'company_name': {
        required: true,
      },
      'english_company_name': {
        required: true,
      },
      'manager_name': {
        required: true,
      },
      'phone_number': {
        required: true,
        maxlength: 12
      },
      'mobile_number': {
        required: true,
        maxlength: 11
      },
      'fax_number': {
        required: true,
        maxlength: 20
      },
      'email': {
        email: true
      },
      // 'website': {
      //   required: true,
      //   url: true, // Use the 'url' method for URL validation
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
        fileType: "jpg, jpeg, png, gif", // Add the accepted file types
        englishFileName: true // Validate English characters in the file name
      }
    },
    messages: {
      'company_name': {
        'required': 'فیلد الزامی است',
      },
      'english_company_name': {
        'required': 'فیلد الزامی است',
      },
      'manager_name': {
        'required': 'فیلد الزامی است',
      },
      'phone_number': {
        'required': 'فیلد الزامی است',
        'maxlength': 'محدودیت اعداد'
      },
      'mobile_number': {
        'required': 'فیلد الزامی است',
        'maxlength': 'محدودیت اعداد'
      },
      'fax_number': {
        'required': 'فیلد الزامی است',
        'maxlength': 'رقم طولانیست'
      },
      'email': {
        'email': 'ایمیل وارد شده ولید نیست.',
        'maxlength': 'محدودیت حروف'
      },
      // 'website': {
      //   'required': 'فیلد الزامی است',
      //   'url': 'url مجاز نیست.', // Add a custom error message for URL validation
      // },
      'postal_code': {
        'required': 'فیلد الزامی است',
        'maxlength': 'رقم طولانیست'
      },
      'country': {
        'required': 'فیلد الزامی است',
      },
      'province': {
        'required': 'فیلد الزامی است',
      },
      'city': {
        'required': 'فیلد الزامی است',
      },
      'activity_type': {
        'required': 'فیلد الزامی است',
      },
      'country': {
        'required': 'فیلد الزامی است',
      },
      'province': {
        'required': 'فیلد الزامی است',
      },
      'address': {
        'required': 'فیلد الزامی است',
      },
      'image': {
        'required': 'فیلد الزامی است',
        'fileType': 'فقط فایل عکس مجاز است.',
        'englishFileName': 'نام فایل باید انگلیسی باشد'
      }
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {

      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: "post",
        success: function (response) {
          console.log('sdjflds123')
          console.log(response)

          $.toast({
              heading: 'افزودن  جدید',
              text: response.message,
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });
            setTimeout(function () {
              window.location = 'list';
            }, 3500);

        },
        error: function (response) {
          $.toast({
            heading: 'مشکلی پیش آمد',
            text: '',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });
        }
        });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });



});

function deleteRepresentatives(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'representatives',
      method: 'deleteRepresentatives',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف وضعیت نمایندگی',
        text: data.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });

    },
    error:function(error) {
      $.toast({
        heading: 'حذف وضعیت',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });
    },
    complete: function() {
      setTimeout(function() {
        location.reload()
        // window.location = `${amadeusPath}itadmin/Representatives/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteRepresentatives', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteRepresentatives(id)
  }
})

$('#editRepresentatives').validate({
  rules: {
    'company_name': {
      required: true,
    },
    'english_company_name': {
      required: true,
    },
    'manager_name': {
      required: true,
    },
    'phone_number': {
      required: true,
      maxlength: 12
    },
    'mobile_number': {
      required: true,
      maxlength: 11
    },
    'fax_number': {
      required: true,
      maxlength: 20
    },
    'email': {
      email: true
    },
    'website': {
      required: true,
      url: true, // Use the 'url' method for URL validation
    },
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
    }
  },
  messages: {
    'company_name': {
      'required': 'فیلد الزامی است',
    },
    'english_company_name': {
      'required': 'فیلد الزامی است',
    },
    'manager_name': {
      'required': 'فیلد الزامی است',
    },
    'phone_number': {
      'required': 'فیلد الزامی است',
      'maxlength': 'محدودیت اعداد'
    },
    'mobile_number': {
      'required': 'فیلد الزامی است',
      'maxlength': 'محدودیت اعداد'
    },
    'fax_number': {
      'required': 'فیلد الزامی است',
      'maxlength': 'رقم طولانیست'
    },
    'email': {
      'email': 'ایمیل وارد شده ولید نیست.',
      'maxlength': 'محدودیت حروف'
    },
    'website': {
      'required': 'فیلد الزامی است',
      'url': 'url مجاز نیست.', // Add a custom error message for URL validation
    },
    'postal_code': {
      'required': 'فیلد الزامی است',
      'maxlength': 'رقم طولانیست'
    },
    'country': {
      'required': 'فیلد الزامی است',
    },
    'province': {
      'required': 'فیلد الزامی است',
    },
    'city': {
      'required': 'فیلد الزامی است',
    },
    'activity_type': {
      'required': 'فیلد الزامی است',
    },
    'country': {
      'required': 'فیلد الزامی است',
    },
    'province': {
      'required': 'فیلد الزامی است',
    },
    'address': {
      'required': 'فیلد الزامی است',
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

        $.toast({
          heading: 'نمایندگی ها',
          text: response.message,
          position: 'top-right',
          icon: displayIcon,
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })

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
        $.toast({
          heading: 'مشکلی پیش آمد',
          text: response.message,
          position: 'top-right',
          icon: displayIcon,
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
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
function change_order() {
  if (confirm('آیا از تغییر موارد انتخاب شده مطمئن هستید ؟')) {
    $('#form_data').validate({
      rules: {},
      messages: {},
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
        $(form).ajaxSubmit({
          url: amadeusPath + 'ajax',
          type: 'post',
          success: function(response) {
            // console.log(response);
            let displayIcon
            let displayTitle
            if (response.success === true) {
              displayIcon = 'success'
              displayTitle = 'تغییر ترتیب'
            } else {
              displayIcon = 'error'
              displayTitle = 'عملیات با خطا مواجه شد'
            }

            $.toast({
              heading: displayTitle,
              text: response.message,
              position: 'top-right',
              icon: displayIcon,
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6,
            })

            if (response.success === true) {
              setTimeout(function() {
                location.reload()
                window.location = `${amadeusPath}itadmin/representatives/list`;
              }, 500)
            }
          },

        })
      },
    });
  }

}

function change_order_new(){
  var inputs = document.querySelectorAll('input[name^="order["]');
  var values = {};

  inputs.forEach(function(input) {
    var name = input.name;
    var value = input.value;
    var match = name.match(/\[(\d+)\]/);
    if (match) {
      var numberInsideBrackets = match[1];
      console.log(numberInsideBrackets); // Output: "60"
    }
    values[numberInsideBrackets] = value;
  });
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'representatives',
      method: 'change_order',
      data: values,
    }),
    success: function (data) {
      $.toast({
        heading: 'تغییر ترتیب نمایندگی ها',
        text: data.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });

    },
    error:function(error) {
      $.toast({
        heading: 'حذف وضعیت',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });
    },
    complete: function() {
      setTimeout(function() {
        location.reload()
        // window.location = `${amadeusPath}itadmin/Representatives/list`;
      }, 1000)
    },
  });
}




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