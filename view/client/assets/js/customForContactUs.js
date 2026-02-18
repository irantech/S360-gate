

$('#fcf-form-id').validate({
    rules: {
        'contactUs-name': {
            required: true,
            maxlength: 255
        },
        'contactUs-phone': {
            required: true,
            phone   : true ,
            maxlength: 11
        },
        'contactUs-Email': {
            required: true,
            email: true
        },
        'contactUs-Message': {
            required: true,
            maxlength: 255
        },
    },
    messages: {
        'contactUs-name': {
            'required': useXmltag("PleaseenterName"),
            'maxlength': useXmltag("LongNameError")
        },
        'contactUs-phone': {
            'required': useXmltag("PleaseenterPhoneNumber"),
            'phone': useXmltag("PhoneNumberError"),
            'maxlength': useXmltag("LongPhoneNumberError")
        },
        'contactUs-Email': {
            'required': useXmltag("Enteremail"),
            'email': useXmltag("Invalidemail"),
            'maxlength': useXmltag("Emaillong")
        },
        'contactUs-Message': {
            'required': useXmltag("Enteringfieldrequired"),
            'maxlength': useXmltag("characterExeed")
        }
    },
    submitHandler : function(form) {
    $("#fcf-button").html(useXmltag('Pleasewait'));
    $('#fcf-button').prop('disabled', true);
    var name = $('#contactUs-name').val();
    var phone = $('#contactUs-phone').val();
    var email = $('#contactUs-Email').val();
    var message = $('#contactUs-Message').val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            name : name ,
            phone : phone ,
            email : email ,
            message : message ,
            flag : 'contactUs'
        },
        function(data){
            var res = JSON.parse(data);
            if (res.success) {
                $.alert({
                    title: useXmltag("EkhtiarContactus"),
                    icon: 'fa fa-check',
                    content: res.message,
                    rtl: true,
                    type: 'green'
                });

                $('#contactUs-phone').val('');
                $('#contactUs-Email').val('');
                $('#contactUs-Message').val('');
            } else {
                $.alert({
                    title: useXmltag("EkhtiarContactus"),
                    icon: 'fa fa-user',
                    content: res.message,
                    rtl: true,
                    type: 'red'
                });
            }
            $("#fcf-button").html(useXmltag('contactSendMessage'));
            $('#fcf-button').prop('disabled', false);
        })
}
});

$('#feedback-form-id').validate({
    rules: {
        'contactUs-name': {
            required: true,
            maxlength: 255
        },
        'contactUs-phone': {
            required: true,
            phone   : true ,
            maxlength: 11
        },
        'contactUs-Email': {
            required: true,
            email: true
        },
        'contactUs-Message': {
            required: true,
            maxlength: 255
        },
    },
    messages: {
        'contactUs-name': {
            'required': useXmltag("PleaseenterName"),
            'maxlength': useXmltag("LongNameError")
        },
        'contactUs-phone': {
            'required': useXmltag("PleaseenterPhoneNumber"),
            'phone': useXmltag("PhoneNumberError"),
            'maxlength': useXmltag("LongPhoneNumberError")
        },
        'contactUs-Email': {
            'required': useXmltag("Enteremail"),
            'email': useXmltag("Invalidemail"),
            'maxlength': useXmltag("Emaillong")
        },
        'contactUs-Message': {
            'required': useXmltag("Enteringfieldrequired"),
            'maxlength': useXmltag("characterExeed")
        }
    },
    submitHandler : function(form) {
        $("#fcf-button").html(useXmltag('Pleasewait'));
        $('#fcf-button').prop('disabled', true);
        var name = $('#contactUs-name').val();
        var phone = $('#contactUs-phone').val();
        var email = $('#contactUs-Email').val();
        var message = $('#contactUs-Message').val();
        var type = 'feedback';
        $.post(amadeusPath + 'user_ajax.php',
          {
              name : name ,
              phone : phone ,
              email : email ,
              message : message ,
              type : type ,
              flag : 'contactUs'
          },
          function(data){
              var res = JSON.parse(data);
              if (res.success) {
                  $.alert({
                      title: useXmltag("S360FeedBack"),
                      icon: 'fa fa-check',
                      content: res.message,
                      rtl: true,
                      type: 'green'
                  });

                  $('#contactUs-phone').val('');
                  $('#contactUs-Email').val('');
                  $('#contactUs-Message').val('');
              } else {
                  $.alert({
                      title: useXmltag("S360FeedBack"),
                      icon: 'fa fa-user',
                      content: res.message,
                      rtl: true,
                      type: 'red'
                  });
              }
              $("#fcf-button").html(useXmltag('contactSendMessage'));
              $('#fcf-button').prop('disabled', false);
          })
    }
});

$('#lastminute-form-id').validate({
    rules: {
        'contactUs-name': {
            required: true,
            maxlength: 255
        },
        'contactUs-phone': {
            required: true,
            phone   : true ,
            maxlength: 11
        },
        'contactUs-Email': {
            required: true,
            email: true
        },
        'contactUs-Message': {
            required: true,
            maxlength: 255
        },
    },
    messages: {
        'contactUs-name': {
            'required': useXmltag("PleaseenterName"),
            'maxlength': useXmltag("LongNameError")
        },
        'contactUs-phone': {
            'required': useXmltag("PleaseenterPhoneNumber"),
            'phone': useXmltag("PhoneNumberError"),
            'maxlength': useXmltag("LongPhoneNumberError")
        },
        'contactUs-Email': {
            'required': useXmltag("Enteremail"),
            'email': useXmltag("Invalidemail"),
            'maxlength': useXmltag("Emaillong")
        },
        'contactUs-Message': {
            'required': useXmltag("Enteringfieldrequired"),
            'maxlength': useXmltag("characterExeed")
        }
    },
    submitHandler : function(form) {
        $("#fcf-button").html(useXmltag('Pleasewait'));
        $('#fcf-button').prop('disabled', true);
        var name = $('#contactUs-name').val();
        var phone = $('#contactUs-phone').val();
        var email = $('#contactUs-Email').val();
        var message = $('#contactUs-Message').val();
        var type = 'lastminute';
        $.post(amadeusPath + 'user_ajax.php',
          {
              name : name ,
              phone : phone ,
              email : email ,
              message : message ,
              type : type ,
              flag : 'contactUs'
          },
          function(data){
              var res = JSON.parse(data);
              if (res.success) {
                  $.alert({
                      title: useXmltag("S360Min90"),
                      icon: 'fa fa-check',
                      content: res.message,
                      rtl: true,
                      type: 'green'
                  });

                  $('#contactUs-phone').val('');
                  $('#contactUs-Email').val('');
                  $('#contactUs-Message').val('');
              } else {
                  $.alert({
                      title: useXmltag("S360Min90"),
                      icon: 'fa fa-user',
                      content: res.message,
                      rtl: true,
                      type: 'red'
                  });
              }
              $("#fcf-button").html(useXmltag('contactSendMessage'));
              $('#fcf-button').prop('disabled', false);
          })
    }
});


function showContactModal(thiss){
    loadingBtn(thiss);
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        data: {
            flag: 'contactDetailData',
            id: thiss.data('id')
        },
        success: function (response) {
            loadingBtn(thiss,false);
           var fullData=JSON.parse(response);
            $(thiss.data('target')).modal('show');
            var modalBody= $(thiss.data('target')).find('.modal-body');
            var newHtml='';
            newHtml='<div class="col-md-12 d-flex flex-wrap">';
            newHtml+=spanLoops(useXmltag("Namefamily"),fullData.name);
            newHtml+=spanLoops(useXmltag("Mobile"),fullData.mobile);
            newHtml+=spanLoops(useXmltag("Email"),fullData.email);
            newHtml+=spanLoops(useXmltag("contactMessage"),fullData.comment);
            newHtml+='</div>';

            modalBody.html(newHtml);

        }
    });
}

function spanLoops(title,value,divClass='col-md-12'){
    if(value == null){
        value = '';
    }
    return '<div class="mb-3 '+divClass+'"><span class="col-md-12 p-1">'+title+' : '+value+'</span></div>';
}