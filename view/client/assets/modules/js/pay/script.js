$('.owl-pay').owlCarousel({
    rtl:true,
    loop:true,
    animateOut: 'slideOutDown',
    margin:10,
    nav:false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 20000,
    autoplaySpeed:7000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
function onclick(event) {
    reloadCaptcha();
    return false
}
function checkTrackingCode(code) {
    var count = code.length;
    var val = code.trim();
    var res = code;
    if (count > 3) {
        $.post(amadeusPath + 'user_ajax.php',
          {
              tracking_code: val,
              flag: 'trackingCodeNumber'
          },
          function (response) {

              data = jQuery.parseJSON(response);
              setTimeout(function () {

                  $('#amount_number').html('');
                  if (data) {
                      if (data.use_status == 1) {
                          $("#amount_number_under").html("");
                          document.getElementById("amount_number").setAttribute('value', '');
                          $('#amount_number_under').css({display: 'block'});
                          $('#amount_number_under').append('<span>این کد قبلا استفاده شده است</span>');
                      }else{
                          document.getElementById("amount_number").setAttribute('value', data.price);
                          document.getElementById("reason").setAttribute('value', data.description);
                          $('#amount_number_under').css({display: 'none'});
                          }
                  } else {
                          $("#amount_number_under").html("");
                          document.getElementById("amount_number").setAttribute('value', '');
                          $('#amount_number_under').css({display: 'block'});
                          $('#amount_number_under').append('<span>موردی یافت نشد</span>');
                  }
              }, 500);
          });
    }
}

//add online payment
$("#onlinePaymentAdd").validate({
    rules: {
        tracking_code: 'required',
        amount_number: 'required',
        name: 'required',
        mobile: {
            required: true,
            number: true,
            minlength: 11,
            maxlength: 11
        },
        'item-captcha': {
            required: true,
            //   minlength: 4,
            maxlength: 5
        },

    },
    messages: {
        'tracking_code': {
            'required': useXmltag("EnterTrackingCode")
        },
        'amount_number': {
            'required': useXmltag("EnterAmountValue")
        },
        'name': {
            'required': useXmltag("PleaseEnterNameLastName")
        },
        'mobile': {
            'maxlength': useXmltag("PleaseEnterMobile"),
            'number': useXmltag("PhoneNumberError"),
            'required': useXmltag("PleaseenterPhoneNumber"),
        },
        'item-captcha': {
            'required': useXmltag("Entersecuritycode"),
            'maxlength': useXmltag('WrongSecurityCode')
        }
    },


    submitHandler: function (form) {
        $.post(amadeusPath + 'captcha/securimage_check.php',
          {
              captchaAjax: $('#item-captcha').val()
          },
          function (data) {
              // console.log(data)
              if (data == true) {
                  reloadCaptcha();
        $(form).ajaxSubmit({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            success: function (response) {

                var res = response.split(':');

                if (response.indexOf('success') > -1) {
                    var statusType = 'green';
                } else {
                    var statusType = 'red';
                }

                if (response) {
                    // alert(response);
                    let address = amadeusPathByLang + 'payConfirm' +'&id='+ response;
                    // console.log(address);
                    window.location.href = address;
                    $('#name').val('');
                    $('#tracking_code').val('');
                    $('#amount').val('');
                    $('#mobile').val('');
                }

            }
        });
              } else {
                  reloadCaptcha();
                  $.alert({
                      title: useXmltag("SendVoteAnswer"),
                      icon: 'fa fa-warning',
                      content: useXmltag("WrongSecurityCode"),
                      rtl: true,
                      type: 'red'
                  });
                  return false;
              }
          });
    },

});


