
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });

  $('#add_galleryBanner').validate({
    rules: {
      title: 'required',
      pic: 'required',
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
            heading: 'گالری بنر',
            text: response.message,
            position: 'top-right',
            icon: displayIcon,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          if (response.success === true) {
            setTimeout(function() {
              location.reload()
              // window.location = `${amadeusPath}itadmin/galleryBanner/list`;
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

  $("#edit_gallery_banner").validate({
    rules: {
      title: 'required',
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
          let displayIcon
          if (response.success === true) {
            displayIcon = 'success'
          } else {
            displayIcon = 'error'
          }

          $.toast({
            heading: 'گالری بنر',
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
              window.location = `${amadeusPath}itadmin/galleryBanner/list`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش گالری بنر',
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


function updateStatusGalleryBanner(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'galleryBanner',
      method: 'updateStatusGalleryBanner',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت گالری بنر',
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
        heading: 'تغییر وضعیت گالری بنر',
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



function deleteGalleryBanner(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'galleryBanner',
      method: 'deleteGalleryBanner',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف وضعیت گالری بنر',
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
        heading: 'حذف وضعیت گالری بنر',
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
        // window.location = `${amadeusPath}itadmin/galleryBanner/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteGalleryBanner', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteGalleryBanner(id)
  }
})

function change_order(){
  if (confirm('آیا از تغییر ترتیب موارد مطمئن هستید ؟')) {
    var inputs = document.querySelectorAll('input[name^="order["]');
    var values = {};

    inputs.forEach(function(input) {
      var name = input.name;
      var value = input.value;
      var match = name.match(/\[(\d+)\]/);
      if (match) {
        var numberInsideBrackets = match[1];
        console.log(numberInsideBrackets); // Output: "60"
      }
      values[numberInsideBrackets] = value;
    });
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'JSON',
      data:  JSON.stringify({
        className: 'galleryBanner',
        method: 'changeOrder',
        data: values,
      }),
      success: function (data) {
        $.toast({
          heading: 'تغییر ترتیب',
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
          heading: 'تغییر ترتیب',
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
          // window.location = `${amadeusPath}itadmin/galleryBanner/list`;
        }, 1000)
      },
    });
  }
}
