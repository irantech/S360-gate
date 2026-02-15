

$(document).ready(function () {
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
    $('.dropify').dropify();

    $("#InsertCurrency").validate({
        rules: {
            CurrencyTitle: "required",
            CurrencyTitleEn: "required",
            CurrencyPrice: "required",
            CurrencyShortName: "required"
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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('Success') > -1) {
                        $.toast({
                            heading: 'افزودن ارز جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ="currencyList";
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن ارز جدید',
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

    $("#EditCurrency").validate({
        rules: {
            CurrencyTitle: "required",
            CurrencyTitleEn: "required",
            CurrencyPrice: "required",
            CurrencyShortName: "required"

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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('Success') > -1) {
                        $.toast({
                            heading: 'ویرایش ارز',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ="currencyList";
                        }, 1000);


                    } else {

                        $.toast({
                            heading:'ویرایش ارز',
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



function StatusCurrency(id)
{

    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            flag: 'StatusCurrency'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('Success') > -1)
            {
                $.toast({
                    heading: 'وضعیت ارز',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            } else
            {
                $.toast({
                    heading: 'وضعیت ارز',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }

        });



}


function UpdatePriceGdsCurrency(obj)
{

    var Price =    $(obj).val();
    var Code =    $(obj).data('code');

    if(Price !='')
    {
        $.post(amadeusPath + 'user_ajax.php',
          {
              CurrencyCode: Code,
              EqAmount :Price,
              flag: 'UpdatePriceGdsCurrency'
          },
          function (data) {

              var res = data.split(':');
              if (data.indexOf('Success') > -1)
              {
                  $.toast({
                      heading: 'بروز رسانی قیمت ارز',
                      text: res[1],
                      position: 'top-right',
                      loaderBg: '#fff',
                      icon: 'success',
                      hideAfter: 3500,
                      textAlign: 'right',
                      stack: 6
                  });

              } else
              {
                  $.toast({
                      heading: 'بروز رسانی قیمت ارز',
                      text: res[1],
                      position: 'top-right',
                      loaderBg: '#fff',
                      icon: 'error',
                      hideAfter: 3500,
                      textAlign: 'right',
                      stack: 6
                  });
              }

          });

    }else {
        $.toast({
            heading: 'بروز رسانی قیمت ارز',
            text: "مبلغ معادل نمی تواند خالی باشد",
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
    }



}