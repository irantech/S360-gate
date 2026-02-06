
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });




  $('#add_country').validate({
    rules: {
      title: 'required',
      // code: 'required',
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
      CKEDITOR.instances.note_2.updateElement()
      CKEDITOR.instances.note_3.updateElement()
      CKEDITOR.instances.note_4.updateElement()
      CKEDITOR.instances.note_5.updateElement()
      CKEDITOR.instances.note_6.updateElement()
      CKEDITOR.instances.note_7.updateElement()
      CKEDITOR.instances.note_8.updateElement()
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
            heading: 'کشور جدید',
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
              window.location = `${amadeusPath}itadmin/introductCountry/list`;
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

  $("#edit_country").validate({
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
      CKEDITOR.instances.note_2.updateElement()
      CKEDITOR.instances.note_3.updateElement()
      CKEDITOR.instances.note_4.updateElement()
      CKEDITOR.instances.note_5.updateElement()
      CKEDITOR.instances.note_6.updateElement()
      CKEDITOR.instances.note_7.updateElement()
      CKEDITOR.instances.note_8.updateElement()
      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: "post",
        success: function (response) {

          $.toast({
            heading: 'ویرایش کشور',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: response.status,
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          })
          if (response.status === 'success') {
            setTimeout(function() {
              // location.reload()
              window.location = `${amadeusPath}itadmin/introductCountry/list`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش کشور',
            text: error.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: error.statusCode,
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
  })


  $('#add_province').validate({
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
      CKEDITOR.instances.description.updateElement()
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
            heading: 'استان جدید',
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
              window.location = `${amadeusPath}itadmin/introductCountry/list`;
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
  });

  $("#edit_province").validate({
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
      CKEDITOR.instances.description.updateElement()
      $(form).ajaxSubmit({
        url: amadeusPath + 'ajax',
        type: "post",
        success: function (response) {

          $.toast({
            heading: 'ویرایش استان',
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
              window.location = `${amadeusPath}itadmin/introductCountry/provinceList`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش استان',
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


function updateStatusCountry(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'introductCountry',
      method: 'updateActiveCountry',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت کشور ',
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
        heading: 'تغییر وضعیت کشور',
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



function deleteCountry(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'introductCountry',
      method: 'deleteCountry',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف کشور ',
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
        heading: 'حذف کشور',
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
        // window.location = `${amadeusPath}itadmin/introductCountry/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteCountry', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteCountry(id)
  }
});

function change_order(){
  if (confirm('آیا از تغییر ترتیب کشورها مطمئن هستید ؟')) {
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
        className: 'introductCountry',
        method: 'changeOrder',
        data: values,
      }),
      success: function (data) {
        $.toast({
          heading: 'تغییر ترتیب کشورها',
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
          heading: 'تغییر ترتیب کشورها',
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
          // window.location = `${amadeusPath}itadmin/introductCountry/provinceList`;
        }, 1000)
      },
    });
  }
}



function updateProvince(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'introductCountry',
      method: 'updateActiveProvince',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت نمایش استان',
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
        heading: 'تغییر وضعیت نمایش استان',
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


function deleteProvince(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'introductCountry',
      method: 'deleteProvince',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف استان',
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
        heading: 'حذف استان',
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
        // window.location = `${amadeusPath}itadmin/introductCountry/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteProvince', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteProvince(id)
  }
});


function change_order_province(){
  if (confirm('آیا از تغییر ترتیب استان ها مطمئن هستید ؟')) {
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
        className: 'introductCountry',
        method: 'changeOrderProvince',
        data: values,
      }),
      success: function (data) {
        $.toast({
          heading: 'تغییر ترتیب استان ها',
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
          heading: 'تغییر ترتیب استان ها',
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
          // window.location = `${amadeusPath}itadmin/introductCountry/provinceList`;
        }, 1000)
      },
    });
  }
}
