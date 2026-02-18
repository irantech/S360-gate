$(document).ready(function () {
  $(".select2").select2();
  $('#reserve-appointment').validate({
    rules: {
      'appointment-name': {
        required: true,
        maxlength: 255
      },
      'appointment-mobile': {
        required: true,
        phone: true,
        maxlength: 11
      },
      'appointment-email': {
        email: true
      },
      'appointment-profession': {
        maxlength: 255
      },
      'appointment-recognition': {
        required: true,
      },
      'appointment-date': {
        required: true,
      },
      'appointment-time': {
        required: true,
      },
      "appointment-field": {
        required: true,
      },
      'appointment-comment': {
        maxlength: 255
      },
    },
    messages: {
      'appointment-name': {
        'required': useXmltag("PleaseenterName"),
        'maxlength': useXmltag("LongNameError")
      },
      'appointment-mobile': {
        'required': useXmltag("PleaseenterPhoneNumber"),
        'phone': useXmltag("PhoneNumberError"),
        'maxlength': useXmltag("LongPhoneNumberError")
      },
      'appointment-email': {
        'email': useXmltag("Invalidemail"),
        'maxlength': useXmltag("Emaillong")
      },
      'appointment-profession': {
        'maxlength': useXmltag("LongProfessionError"),
      },
      'appointment-date': {
        'required': useXmltag("PleaseenterReserveDate"),
      },
      'appointment-time': {
        'required': useXmltag("PleaseenterReserveTime"),
      },
      'appointment-recognition': {
        'required': useXmltag("PleaseenterAppointmentRecognition"),
      },
      'appointment-field': {
        'required': useXmltag("PleaseenterAppointmentField"),
      },
      'appointment-comment': {
        'maxlength': useXmltag("characterExeed")
      }
    },
    submitHandler: function(form) {
      $("#appointmentButton").html(useXmltag('Pleasewait'));
      $('#appointmentButton').prop('disabled', true);
      var fullName = $('#appointment-name').val();
      var mobile = $('#appointment-mobile').val();
      var email = $('#appointment-email').val();
      var profession = $('#appointment-profession').val();
      var field_id = $('#appointment-field').val();
      var recognition_id = $('#appointment-recognition').val();
      var reserved_date = $('#appointment-date').val();
      var reserved_time = $('#appointment-time').val();
      var comment = $('#appointment-comment').val();
      $.post(amadeusPath + 'user_ajax.php',
        {
          fullName: fullName,
          mobile: mobile,
          email: email,
          profession: profession,
          field_id: field_id,
          recognition_id: recognition_id,
          reserved_date: reserved_date,
          reserved_time: reserved_time,
          comment: comment,
          flag: 'appointment'
        },
        function(data) {

          var res = JSON.parse(data);

          if (res.success) {
            $.alert({
              title: useXmltag("reserveAppointment"),
              icon: 'fa fa-check',
              content: res.message,
              rtl: true,
              type: 'green'
            });

            $('#appointment-field').val('');
            $('#appointment-name').val('');
            $('#appointment-mobile').val('');
            $('#appointment-email').val('');
            $('#appointment-profession').val('');
            $('#appointment-recognition').val('');
            $('#appointment-date').val('');
            $('#appointment-time').val('');
            $('#appointment-comment').val('');
            $('#reserve-appointment').find('select').select2();

          } else {
            $.alert({
              title: useXmltag("reserveAppointment"),
              icon: 'fa fa-user',
              content: res.message,
              rtl: true,
              type: 'red'
            });
          }
          $("#appointmentButton").html(useXmltag('Submitapplication'));
          $('#appointmentButton').prop('disabled', false);
        })
    }
  });
  $('#appointment-date').datepicker({
    numberOfMonths: 1,
    minDate: 'Y/M/D',
    showButtonPanel: !0,
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });


  $(document).ready(function(){
    $('#appointment-time').mdtimepicker({
          is24hour: true,
          theme: 'red',
      }
    );
  });

});