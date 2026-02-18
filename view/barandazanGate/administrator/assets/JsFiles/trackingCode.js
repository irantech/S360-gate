
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });

  $('#add_tracking_code').validate({
    rules: {
      price: 'required',
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
      //tinyMCE.triggerSave();
      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: 'POST',
        // mimeType: "multipart/form-data",
        // contentType: false,
        // processData: false,
        success: function(response) {
          // console.log(response);
          let displayIcon
          if (response.success === true) {
            displayIcon = 'success'
          } else {
            displayIcon = 'error'
          }

          $.toast({
            heading: 'کد رهگیری',
            text: response.message,
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          if (response.success === true) {
            setTimeout(function() {
              $('#codeShow').html(response.data);
              // location.reload()
              // window.location = `${amadeusPath}itadmin/trackingCode/list`;
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

  $("#edit_tracking_code").validate({
    rules: {
      price: 'required',

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
        url: amadeusPath + 'ajax',
        type: "post",
        success: function (response) {

          $.toast({
            heading: 'ویرایش کد رهگیری',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: response.status,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          })
          if (response.success === true) {
            setTimeout(function() {
              // location.reload()
              window.location = `${amadeusPath}itadmin/trackingCode/add`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش کد رهگیری',
            text: error.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: error.responseJSON.status,
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
})






function deleteTrackingCode(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'trackingCode',
      method: 'deleteTrackingCode',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف کد رهگیری',
        text: data.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });

    },
    error:function(error) {
      $.toast({
        heading: 'حذف کد رهگیری',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });
    },
    complete: function() {
      setTimeout(function() {
        location.reload()
        // window.location = `${amadeusPath}itadmin/trackingCode/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteTrackingCode', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteTrackingCode(id)
  }
})