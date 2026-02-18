$(document).ready(function () {

    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });

    $("#InsertCurrency").validate({
        rules: {
            CurrencyCode: "required",
            EqAmount:{
              required :true,
              number :true
            }
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
                            window.location ="currencyEquivalent";
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


});




function StatusCurrencyCustomer(Code)
{

    $.post(amadeusPath + 'user_ajax.php',
      {
          CurrencyCode: Code,
          flag: 'StatusCurrencyCustomer'
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


function DefaultCurrencyCustomer(Code)
{

    $.post(amadeusPath + 'user_ajax.php',
      {
          CurrencyCode: Code,
          flag: 'DefaultCurrencyCustomer'
      },
      function (data) {

          var res = data.split(':');
          if (data.indexOf('Success') > -1)
          {
              $.toast({
                  heading: 'تعیین ارز پیش فرض',
                  text: res[1],
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
              });
              setTimeout(function(){
                  window.location ='currencyCustomer';
              }, 1000);

          } else
          {
              $.toast({
                  heading: 'تعیین ارز پیش فرض',
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

function ResetCurrencyToDefault(id)
{
    if(confirm('آیا از بازگرداندن این ارز به تنظیمات پیش فرض اطمینان دارید؟'))
    {
        $.post(amadeusPath + 'user_ajax.php',
          {
              id: id,
              flag: 'ResetCurrencyToDefault'
          },
          function (data) {
    
              var res = data.split(':');
              if (data.indexOf('Success') > -1)
              {
                  $.toast({
                      heading: 'بازگشت به پیش فرض',
                      text: res[1],
                      position: 'top-right',
                      loaderBg: '#fff',
                      icon: 'success',
                      hideAfter: 3500,
                      textAlign: 'right',
                      stack: 6
                  });
                  setTimeout(function(){
                      window.location ='currencyCustomer';
                  }, 1000);
    
              } else
              {
                  $.toast({
                      heading: 'بازگشت به پیش فرض',
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
}

function UpdatePriceCusomerCurrency(obj)
{

    var Price =    $(obj).val();
    var Code =    $(obj).data('code');
    if(Price !='')
    {
        $.post(amadeusPath + 'user_ajax.php',
           {
               CurrencyCode: Code,
               EqAmount :Price,
               flag: 'UpdatePriceCustomerCurrency'
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
