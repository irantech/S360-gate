

function deleteIranVisa(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'iranVisa',
      method: 'deleteIranVisa',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف درخواست ویزای ایران',
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
        heading: 'حذف درخواست ویزای ایران',
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
        // window.location = `${amadeusPath}itadmin/iranVisa/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteIranVisa', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteIranVisa(id)
  }
})

$('#editForAdminRespons').validate({
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
          heading: 'درخواست ویزای ایران',
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
            window.location = `${amadeusPath}itadmin/iranVisa/list`;
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
