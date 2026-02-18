

$.validator.addMethod("userNameM", function(value, element) {
  if (element.length === 0) {
    return true; // No file selected; validation is considered successful
  }
  // Password-like pattern: Four groups of 8 characters separated by '-'
  var usernamePattern = /^[A-Za-z\d]+(?:_[A-Za-z\d]+)*$/;

  return usernamePattern.test(value);
}, "username  format is invalid");

$.validator.addMethod("checkPass", function(value, element) {
  if (element.length === 0) {
    return true; // No file selected; validation is considered successful
  }
  // Password-like pattern: Four groups of 8 characters separated by '-'
  var passPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@]{5,10}-[A-Za-z\d@]{5,10}-[A-Za-z\d@]{5,10}-[A-Za-z\d@]{5,10}$/;

  return passPattern.test(value);
}, "Password format is invalid");

$('#FormAddApiClients').validate({
  rules: {
    'userName': {
      required: true,
      userNameM: true,
    },
    'keyTabdol': {
      required: true,
      checkPass: true

    },
  },
  messages: {
    'userName': {
      'required': 'فیلد الزامی است.',
      'userNameM': 'فرمت نام کاربری اشتباه است.<br>' +
        'حتما از حروف انگلیسی استفاده کنید.<br>' +
        'بجای فاصله از (_) استفاده کنید.'
    },
    'keyTabdol': {
      'required': 'فیلد الزامی است.',
      'checkPass': 'فرمت پسورد اشتباه است.<br>' +
        'پسورد باید از چهار رشته که هرکدام حداقل 5 دیجیت و حداکثر داشته باشند ساخته شود.<br>' +
        'هر رشته باید با یک - به دیگری متصل شود.<br>' +
        'حتما باید شامل کلمات بزرگ و کوچک و اعداد باشد.'

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

    //tinyMCE.triggerSave();
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type: 'POST',
      success: function(response) {


        let displayIcon
        if (response.success === true) {
          displayIcon = 'success'
        } else {
          displayIcon = 'error'
        }

        $.toast({
          heading: 'کاربران api',
          text: response.message,
          position: 'top-right',
          icon: displayIcon,
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
        if (response.success === true) {
          setTimeout(function() {
            window.location = `${amadeusPath}itadmin/apiClients/list`;
          }, 1000)
        }

      },
      error: function(response) {
        displayIcon = 'error'
        $.toast({
          heading: 'کاربران api',
          text: response.responseJSON.message,
          position: 'top-right',
          icon: displayIcon,
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })        },
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

function updateApi(id){
  val = $('#is_enable_' + id).val()
  if (val == 0) {
    $('#is_enable_' + id).val(1)
  } else {
    $('#is_enable_' + id).val(0)
  }

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'apiClients',
      method: 'make_enable',
      id,
      val
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت  انجام شد',
        text: data.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      })

    },
    error:function(error) {
      $.toast({
        heading: 'تغییر وضعیت ',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      })

    }
  });
}

$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function() {
    new Switchery($(this)[0], $(this).data());
  });
});