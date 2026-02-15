$(document).ready(function () {
  
  $("#marketplace_commission").validate({
    rules: {
      service_id: "required",
      service_type: "required",
      type_commission: "required",
      amount_commission: "required"
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
      
      var type= $('#service_type').val();
      var type_id= $('#service_id').val();
      var type_commission= $('#type_commission').val();
      var amount_commission= $('#amount_commission').val();
      var method= $('#method').val();
      $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
          method: method,
          className :'marketplaceCommission',
          type: type,
          type_commission: type_commission,
          type_id: type_id,
          amount_commission: amount_commission
        }),
        success: function (response) {
          $.toast({
            heading: 'تعیین کمیسیون مارکت پلیس ',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });

          setTimeout(function () {
            location.href = "marketCommission&id=" +  type_id + "&type=" + type
          },1000);

        },
        error : function (error) {
          $.toast({
            heading: 'تعیین کمیسیون مارکت پلیس ',
            text: error.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });
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

  // For select 2
  $(".select2").select2();
  
});
