$(document).ready(function () {

  $("#add_employment").validate({
    rules: {
      name: "required",
    },
    messages: {

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
          var res = response.split(':');

          if (response.indexOf('success') > -1) {
            $.toast({
              heading: 'افزودن  جدید',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

            setTimeout(function () {
              window.location = 'add';
            }, 1000);


          } else {

            $.toast({
              heading: 'افزودن  جدید',
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
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });



});

function deleteEmployment(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'employment',
      method: 'deleteEmployment',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف وضعیت درخواست',
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
        // window.location = `${amadeusPath}itadmin/employment/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteEmployment', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteEmployment(id)
  }
})

$('#editEmployment').validate({
  rules: {
    "status_id": {
      required: true,
    },
    'admin_response': {
      maxlength: 255
    },
  },
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
    $('#submit-button').prop('disabled', true);
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type: 'POST',
      success: function(response) {
        $('#submit-button').prop('disabled', false);
        // console.log(response);
        let displayIcon
        if (response.success === true) {
          displayIcon = 'success'
        } else {
          displayIcon = 'error'
        }

        $.toast({
          heading: 'استخدام',
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
            // window.location = `${amadeusPath}itadmin/employment/list`;
          }, 1000)
        }
      },
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
