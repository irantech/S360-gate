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




let inputElement = document.getElementById('price');

inputElement.addEventListener('input', function() {
    let maxLength = 14;
    let numericValue = inputElement.value.replace(/[^0-9]/g, '');

    if (numericValue.length > maxLength) {
        numericValue = numericValue.slice(0, maxLength);
    }

    let formattedValue = formatNumber(numericValue);
    inputElement.value = formattedValue;
});

function formatNumber(number) {
    let numericValue = parseFloat(number);

    if (!isNaN(numericValue)) {
        let formattedValue = numericValue.toLocaleString();
        return formattedValue;
    }

    return '';
}






function onclick(event) {
    reloadCaptcha();
    return false
}


$("#onlinePaymentAdd").validate({
    rules: {
        name: 'required',
        mobile: {
            required: true,
            number: true,
            minlength: 11,
            maxlength: 11
        },
        price: 'required',
        'item-captcha': {
            required: true,
            //minlength: 4,
            maxlength: 5
        },
    },
    messages: {
        'name': {
            'required': useXmltag("PleaseEnterNameLastName")
        },
        'mobile': {
            'maxlength': useXmltag("PleaseEnterMobile"),
            'number': useXmltag("PhoneNumberError"),
            'required': useXmltag("PleaseenterPhoneNumber"),
        },
        'price': {
            'required': useXmltag("EnterAmountValue")
        },
        'item-captcha': {
            'required': useXmltag("Entersecuritycode"),
            'maxlength': useXmltag('WrongSecurityCode')
        }
    },
    submitHandler: function (form) {
        $(".btn-form.btn-form-result .loading-spinner").hide();
        $(".btn-form.btn-form-result i").show();
        $(".btn-form.btn-form-result i").css("filter","blur(2px)");
        $(".btn-form.btn-form-result ").attr('disabled', 'disabled');
        $.post(amadeusPath + 'captcha/securimage_check.php',
          {
              captchaAjax: $('#item-captcha').val()
          },
          function (data) {

              if (data == true) {

                  reloadCaptcha();
                    $(form).ajaxSubmit({
                    type: 'POST',
                    url: amadeusPath + 'user_ajax.php',
                    success: function (response) {

                dataGet = jQuery.parseJSON(response);


                console.log(dataGet);

                var res = response.split(':');

                if (response.indexOf('success') > -1) {
                    var statusType = 'green';
                } else {
                    var statusType = 'red';
                }

                if (dataGet) {
                if (dataGet.code_rah) {
                    $("#submit").html(useXmltag('Pleasewait'));
                    $('#submit').prop('disabled', true);
                    // $('#showResult').html(data.name);
                    $('#name').attr('disabled', 'disabled');
                    $('#price').attr('disabled', 'disabled');
                    $('#mobile').attr('disabled', 'disabled');
                    $('#reason').attr('disabled', 'disabled');
                    $('#item-captcha').attr('disabled', 'disabled');
                    $('#submit').attr('disabled', 'disabled');

                    setTimeout(function() {
                        $('#showResult').css({display: 'block'});
                        $('.item-form-result').css({display: 'none'});
                        $('#resultName').html(dataGet.name);
                        $('#resultMobile').html(dataGet.phone);
                        $('#resultPrice').html(dataGet.amount);
                        $('#resultReasonPay').html(dataGet.reason);
                        // $('#resultCode').html(dataGet.code_rah);
                        // document.getElementById("result_id").setAttribute('value', dataGet.id);
                        document.getElementById("result_code").setAttribute('value', dataGet.code_rah);
                        // document.getElementById("result_amount").setAttribute('value', dataGet.amount);
                        document.getElementById("amount_to_pay").setAttribute('value', dataGet.amount);
                    }, 200)

                }else {
                    reloadCaptcha();
                    $.alert({
                        title: useXmltag("Paymentprebookingamount"),
                        icon: 'fa fa-warning',
                        content: useXmltag("pricePayDefault"),
                        rtl: true,
                        type: 'red'
                    });
                    $(".btn-form.btn-form-result ").prop('disabled', false);
                    $(".btn-form.btn-form-result .loading-spinner").hide();
                    $(".btn-form.btn-form-result i").show();
                    $(".btn-form.btn-form-result i").css("filter","blur(0)");

                }
                }

            }
        });
              } else {
                  reloadCaptcha();
                  $.alert({
                      title: useXmltag("Paymentprebookingamount"),
                      icon: 'fa fa-warning',
                      content: useXmltag("WrongSecurityCode"),
                      rtl: true,
                      type: 'red'
                  });
                  $(".btn-form.btn-form-result ").prop('disabled', false);
                  $(".btn-form.btn-form-result .loading-spinner").hide();
                  $(".btn-form.btn-form-result i").show();
                  $(".btn-form.btn-form-result i").css("filter","blur(0)");
                  return false;
              }
          });
    },

});


function goBankOnlinePayment(link,inputs) {
    $(".cashPaymentLoader i").show();
    $(".cashPaymentLoader i").css("filter","blur(2px)");
    $(".cashPaymentLoader ").attr('disabled', 'disabled');
    let amount = $('#amount_to_pay').val();
    let priceValue = amount.replace(/,/g, '');
    let priceValueNumber = parseFloat(priceValue);
    let price_to_pay = priceValueNumber;
    let factor_number = $('#result_code').val();
    let bank_selected =$("input[name='bank_to_pay']:checked").val()
    // let factor_number = 'AC' + (Math.floor(Math.random() * 888888) + 100000).toString();
    if (price_to_pay === "" || bank_selected === false) {
        $('.cashPaymentLoader').removeClass('skeleton').removeAttr('disabled').css('cursor', 'default')
        $.alert({
            title: useXmltag("ChargeAccount"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("MessageEmpty"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", link);

    $.each(inputs, function (i, item) {
        if (typeof item === 'object' && item !== null) {
            $.each(item, function (j, item2) {
                let hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", i + '[' + j + ']');
                hiddenField.setAttribute("value", item2);
                form.appendChild(hiddenField);

            });
        } else {
            let hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", i);
            hiddenField.setAttribute("value", item);
            form.appendChild(hiddenField);
            $(".cashPaymentLoader").prop('disabled', false);
            $(".cashPaymentLoader i").show();
            $(".cashPaymentLoader i").css("filter","blur(0)");

        }
    });

    let bank = document.createElement("input");

    bank.setAttribute("type", "hidden");
    bank.setAttribute("name", "bankType");
    bank.setAttribute("value", bank_selected);
    form.appendChild(bank);

    let hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("type", "hidden");
    hiddenField2.setAttribute("name",'price');
    hiddenField2.setAttribute("value", price_to_pay);

    form.appendChild(hiddenField2);


    let hiddenField3 = document.createElement("input");
    hiddenField3.setAttribute("type", "hidden");
    hiddenField3.setAttribute("name",'factorNumber');
    hiddenField3.setAttribute("value", factor_number);
    form.appendChild(hiddenField3);

    console.log(form)

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}