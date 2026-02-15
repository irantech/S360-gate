
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });

  if ($('#description').length) {
    var config = {}
    config.fontSize_sizes = '16/16px;24/24px;48/48px;'
    CKEDITOR.replace('description', config)
  }



  $('#add_category').validate({
    rules: {
      title: 'required',
      code: 'required',
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
            heading: 'دسته بندی جدید خودرو',
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
              window.location = `${amadeusPath}itadmin/rentCar/catList`;
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

  $("#edit_category").validate({
    rules: {
      title: 'required',
      code: 'required',

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
            heading: 'ویرایش دسته بندی',
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
              window.location = `${amadeusPath}itadmin/rentCar/catList`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش دسته بندی',
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
  })


  $('#add_car').validate({
    rules: {
      title: 'required',
      code: 'required',
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
            heading: 'خودرو جدید',
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
              window.location = `${amadeusPath}itadmin/rentCar/catList`;
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

  $("#edit_car").validate({
    rules: {
      title: 'required',
      code: 'required',

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
            heading: 'ویرایش خودرو',
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
              window.location = `${amadeusPath}itadmin/rentCar/carList`;
            }, 1000)
          }
        },

        error:function(error) {
          $.toast({
            heading: 'ویرایش خودرو',
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


function updateStatusCategory(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'updateActiveCategory',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت دسته بندی ',
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
        heading: 'تغییر وضعیت دسته بندی',
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



function deleteCategory(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'deleteCategory',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف دسته بندی ',
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
        heading: 'حذف دسته بندی',
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
        // window.location = `${amadeusPath}itadmin/rentCar/catList`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteCategory', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteCategory(id)
  }
});

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
        className: 'rentCar',
        method: 'changeOrder',
        data: values,
      }),
      success: function (data) {
        $.toast({
          heading: 'تغییر ترتیب دسته بندی ها',
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
          heading: 'تغییر ترتیب دسته بندی ها',
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
          // window.location = `${amadeusPath}itadmin/rentCar/catList`;
        }, 1000)
      },
    });
  }
}


function updateCar(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'updateActiveCar',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت نمایش خودرو',
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
        heading: 'تغییر وضعیت نمایش خودرو',
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


function deleteRentCar(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'deleteCar',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف خودرو',
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
        heading: 'حذف خودرو',
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
        // window.location = `${amadeusPath}itadmin/rentCar/catList`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteCar', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteRentCar(id)
  }
});


function change_order_item(){
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
        className: 'rentCar',
        method: 'changeOrderItem',
        data: values,
      }),
      success: function (data) {
        $.toast({
          heading: 'تغییر ترتیب خودروها',
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
          heading: 'تغییر ترتیب خودروها',
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
          // window.location = `${amadeusPath}itadmin/rentCar/catList`;
        }, 1000)
      },
    });
  }
}
$('#add_car_brand').validate({
  rules: {
    title: 'required',
    title_en: 'required',
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
          heading: 'برند جدید خودرو',
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
            window.location = `${amadeusPath}itadmin/rentCar/brandList`;
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

$("#edit_car_brand").validate({
  rules: {
    title: 'required',
    title_en: 'required',

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
          heading: 'ویرایش برند',
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
            window.location = `${amadeusPath}itadmin/rentCar/brandList`;
          }, 1000)
        }
      },

      error:function(error) {
        $.toast({
          heading: 'ویرایش برند',
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
})




function change_order_brand(){
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
        className: 'rentCar',
        method: 'changeOrderBrand',
        data: values,
      }),
      success: function (data) {
        $.toast({
          heading: 'تغییر ترتیب برندها',
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
          heading: 'تغییر ترتیب برندها',
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
          // window.location = `${amadeusPath}itadmin/rentCar/carList`;
        }, 1000)
      },
    });
  }
}

function updateStatusBrand(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'updateActiveBrand',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت برندها',
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
        heading: 'تغییر وضعیت برندها',
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


function deleteRentCarBrand(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'deleteRentCarBrand',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف برند خودرو ',
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
        heading: 'حذف برند خودرو',
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
        // window.location = `${amadeusPath}itadmin/rentCar/brandList`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteRentCarBrand', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteRentCarBrand(id)
  }
});




$('#editForAdminRespons').validate({
  rules: {
    "status_id": {
      required: true,
    },
    'admin_response': {
      maxlength: 255
    },
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
    $('#submit-button').prop('disabled', true);
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type: 'POST',
      success: function(response) {
        $('#submit-button').prop('disabled', false);
        // console.log(response);
        let displayIcon
        if (response.success === true) {
          displayIcon = 'success'
        } else {
          displayIcon = 'error'
        }

        $.toast({
          heading: 'درخواست خودرو',
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
            window.location = `${amadeusPath}itadmin/rentCar/listReserve`;
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

$(document).on('click', '.deleteReserveRentCar', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')

    deleteReserveRentCar(id)
  }
});

function deleteReserveRentCar(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'deleteReserveRentCar',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف درخواست خودرو',
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
        heading: 'حذف درخواست خودرو',
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
      }, 1000)
    },
  });
}


function AddAddedItem() {
  var CountDiv = $('div[data-target="BaseAddedItemDiv"]').length
  var BaseDiv = $('div[data-target="BaseAddedItemDiv"]:last-child')
  var CloneBaseDiv = $('div[data-target="BaseAddedItemDiv"]:last-child').clone()


  CloneBaseDiv.find("input").val("")
  $('div[data-target="BaseAddedItemDiv"]:last-child').after(CloneBaseDiv)
  var CountDivInEach1 = 0
  $('.DynamicAddedItem select[data-parent="AddedItemValues1"]').each(function () {
    console.log(CountDivInEach1)
    $(this).attr(
      "name",
      "AddedItem[" + CountDivInEach1 + "][" + $(this).attr("data-target") + "]"
    )
    CountDivInEach1 = CountDivInEach1 + 1
  })
  var CountDivInEach2 = 0
  $('.DynamicAddedItem input[data-parent="AddedItemValues2"]').each(function () {
    console.log(CountDivInEach2)
    $(this).attr(
      "name",
      "AddedItem[" + CountDivInEach2 + "][" + $(this).attr("data-target") + "]"
    )

      CountDivInEach2 = CountDivInEach2 + 1

  })
  var CountDivInEach3 = 0
  $('.DynamicAddedItem input[data-parent="AddedItemValues3"]').each(function () {
    console.log(CountDivInEach3)
    $(this).attr(
      "name",
      "AddedItem[" + CountDivInEach3 + "][" + $(this).attr("data-target") + "]"
    )

    CountDivInEach3 = CountDivInEach3 + 1

  })
  var CountDivInEach4 = 0
  $('.DynamicAddedItem input[data-parent="RentCarValuesHasId"]').each(function () {
    $(this).attr(
      "name",
      "AddedItem[" + CountDivInEach4 + "][" + $(this).attr("data-target") + "]"
    )
    CountDivInEach4 = CountDivInEach4 + 1
  })
}

function RemoveAddedItem(_this) {
  if (
    _this
      .parent()
      .parent()
      .parent()
      .parent()
      .find('div[data-target="BaseAddedItemDiv"]').length > 1
  ) {
    _this.parent().parent().parent().remove()

    var CountDivInEach = 0
    $('.DynamicAddedItem input[data-parent="AddedItemValues"]').each(
      function () {
        $(this).attr(
          "name",
          "AddedItem[" +
          CountDivInEach +
          "][" +
          $(this).attr("data-target") +
          "]"
        )
        if ($(this).attr("data-target") == "body") {
          CountDivInEach = CountDivInEach + 1
        }
      }
    )
  }
}

$(document).on('click', '.deleteParameterItem', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')

    deleteParameterItem(id)
  }
});

function deleteParameterItem(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'rentCar',
      method: 'deleteParameterItem',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف پارامتر',
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
        heading: 'حذف پارامتر',
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
      }, 1000)
    },
  });
}




