$(document).ready(function(){
  $('#reserved_time').mdtimepicker({
      is24hour: true,
      theme: 'red',
    }
  );

});


function getStatusReason(_this) {

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'json',
    data: JSON.stringify({
      method: 'getAppointmentStatusReasonById',
      className: 'appointmentStatus',
      is_json: true,
      status_id: _this.val()
    }),
    success: function(response) {
      let options = '<option value=\'\'>انتخاب کنید</option>'
      if (response.data != '') {

        $.each(response.data, function(index, item) {
          options +=
            '<option value=\'' + item.id + '\'>' + item.title + '</option>'
        })
      }
      $('#status_reason_id').html(options)
    },
    error: function(error) {
      console.log('error', error)
    },
  })

}

$('#editAppointment').validate({
  rules: {
    'fullName': {
      required: true,
      maxlength: 255
    },
    'mobile': {
      required: true,
      maxlength: 11
    },
    'email': {
      email: true
    },
    'profession': {
      maxlength: 255
    },
    'recognition_id': {
      required: true,
    },
    'reserved_date': {
      required: true,
    },
    // 'reminder_time': {
    //   required: true,
    // },
    // 'negotiation_comment': {
    //   required: true,
    // },
    'reserved_time': {
      required: true,
    },
    "field_id": {
      required: true,
    },
    'comment': {
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
          heading: 'رزرو مشاوره',
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
            // window.location = `${amadeusPath}itadmin/appointment/list`;
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

function removeAppointment(appointment_id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "appointments",
        method: "DeleteAppointment",
        appointment_id: appointment_id,

      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {

          $.toast({
            heading: "حذف رزرو",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: "حذف رزرو",
            text: response.message,
            position: "top-right",
            icon: "warning",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        }
      },
      complete: function () {
        setTimeout(function () {
          location.reload()
        }, 1000)
      },
    })
  }
}

$('#storeAppointment').validate({
  rules: {
    'fullName': {
      required: true,
      maxlength: 255
    },
    'mobile': {
      required: true,
      maxlength: 11
    },
    'email': {
      email: true
    },
    'profession': {
      maxlength: 255
    },
    'recognition_id': {
      required: true,
    },
    'reserved_date': {
      required: true,
    },
    'reserved_time': {
      required: true,
    },
    "field_id": {
      required: true,
    },
    'comment': {
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
    //tinyMCE.triggerSave();
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
          heading: 'رزروها',
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