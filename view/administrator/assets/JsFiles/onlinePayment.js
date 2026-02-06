
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });


  $("#edit_online_payment").validate({
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
            heading: 'ویرایش پرداخت آنلاین',
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
              window.location = `${amadeusPath}itadmin/onlinePayment/add`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش پرداخت آنلاین',
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


  $('#add_price').validate({
    rules: {
      title: 'required',
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
            heading: 'پرداخت آنلاین',
            text: response.message,
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          if (response.success === true) {
            setTimeout(function() {
              // location.reload()
              window.location = `${amadeusPath}itadmin/onlinePayment/listPrice`;
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

  $("#edit_price").validate({
    rules: {
      title: 'required',
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
            heading: 'ویرایش قیمت',
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
              window.location = `${amadeusPath}itadmin/onlinePayment/listPrice`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش قیمت',
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


function updateStatusOnlinePayment(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'onlinePayment',
      method: 'updateStatusOnlinePayment',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت پرداخت آنلاین',
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
        heading: 'تغییر وضعیت پرداخت آنلاین',
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
}



function deleteOnlinePayment(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'onlinePayment',
      method: 'deleteOnlinePayment',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف پرداخت آنلاین',
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
        heading: 'حذف پرداخت آنلاین',
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
        // window.location = `${amadeusPath}itadmin/onlinePayment/list`;
      }, 1000)
    },
  });



}

$(document).on('click', '.deleteOnlinePayment', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteOnlinePayment(id)
  }
})




function updateStatusPrice(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'onlinePayment',
      method: 'updateStatusPrice',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت',
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
        heading: 'تغییر وضعیت',
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
}

$(document).on('click', '.deletePriceItem', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deletePrice(id)
  }
})

function deletePrice(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'onlinePayment',
      method: 'deletePrice',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف قیمت',
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
        heading: 'حذف قیمت',
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
        window.location = `${amadeusPath}itadmin/onlinePayment/listPrice`;
      }, 1000)
    },
  });
}


