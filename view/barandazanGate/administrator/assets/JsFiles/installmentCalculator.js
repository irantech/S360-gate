
$("#installmentCalculatorUpdate").validate({
  rules: {

  },
  messages: {},
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
    $('.submit-button').prop("disabled", true);
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type:"POST",
      dataType: "json",
      success: function (response) {
        $('.submit-button').prop("disabled", false);

        if (response) {
          $.toast({
            heading: 'اطلاعات محاسبه گر ویرایش شد',
            text: '',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });


        } else {

          $.toast({
            heading: 'تغییری نداده اید!',
            text: '',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'warning',
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


