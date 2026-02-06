
// let added_files=[]
$(function(){
  $('.file_input_replacement').click(function(){
    //This will make the element with class file_input_replacement launch the select file dialog.
    var assocInput = $(this).siblings("input[type=file]");
    console.log(assocInput);
    assocInput.click();
  });
  $('.file_input_with_replacement').change(function(){
    //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
    var thisInput = $(this);
    var assocInput = thisInput.siblings("input.file_input_replacement");
    if (assocInput.length > 0) {
      var filename = (thisInput.val()).replace(/^.*[\\\/]/, '');
      assocInput.val(filename);
    }
  });
});

if (lang == 'fa') {
  $('#date_start').datepicker({
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
  $('#date_end').datepicker({
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
}else{
  $('#date_start').datepicker({
    regional: '',
    numberOfMonths: 1,
    showButtonPanel: !0,
    minDate: 'Y/M/D',
    beforeShow: function(n) {
      e(n, !0);
      $("#ui-datepicker-div").addClass("INH_class_Datepicker")
    }
  });
  $('#date_end').datepicker({
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


//add orderServices
$("#orderServicesAdd").validate({
  rules: {
    name: 'required',
    number_requests: 'required',
    mobile: {
        required: true,
        number: true,
        minlength: 11,
        maxlength: 11
    },
    email: {
      email: true
    },
    country: 'required',
    kind_service: 'required',
    date_start: 'required',
    date_end: 'required',
  },
  messages: {
    'name': {
      'required': useXmltag("PleaseEnterNameLastName")
    },
    'number_requests': {
      'required': useXmltag("PleaseEnterRequestNumber")
    },
    'mobile': {
      'maxlength': useXmltag("PleaseEnterMobile"),
      'number': useXmltag("PhoneNumberError"),
      'required': useXmltag("PleaseenterPhoneNumber"),
    },
    'country': {
      'required': useXmltag("PleaseEnterCountry")
    },
    'kind_service': {
      'required': useXmltag("PleaseEnterKindServices")
    },
    'date_start': {
      'required': useXmltag("PleaseEnterDateStart")
    },
    'date_end': {
      'required': useXmltag("PleaseEnterDateEnd")
    },
    'email': {
      'email': useXmltag("Invalidemail"),
      'maxlength': useXmltag("Emaillong")
    },
  },


  submitHandler: function (form) {

    $(form).ajaxSubmit({
      type: 'POST',
      url: amadeusPath + 'user_ajax.php',
      success: function (response) {
        $("#orderServiceButton").html(useXmltag('Pleasewait'));
        $('#orderServiceButton').prop('disabled', true);
        var res = response.split(':');
        console.log(response.indexOf('success'))
        console.log(response)

        $.alert({
          title: useXmltag("SendOrderServices"),
          icon: 'fa fa-refresh',
          content: res[0],
          rtl: true,
          type: 'green'
        });

        $('#orderServicesAdd').find(':input:visible').val('');
        $('#orderServicesAdd').find('select').select2();
        setTimeout(function () {
        $("#orderServiceButton").html(useXmltag('Submitapplication'));
        $('#orderServiceButton').prop('disabled', false);
        }, 1500);


      }
    });
  },

});


