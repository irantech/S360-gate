
function getCountries(_this) {
  let positions = _this
    .parent()
    .parent()
    .parent()
    .find('[data-name=\'positions\']')
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'getCountryListByContinentId',
        className: 'recommendation',
        is_json: true,
        continent_id: _this.val()
      }),
      success: function(response) {
        let options = '<option value=\'\'>انتخاب کنید</option>'
        if (response.data != '') {

          $.each(response.data, function(index, item) {
            options +=
              '<option value=\'' + item.id + '\'>' + item.titleFa + '</option>'
          })
        }
        $('#country').html(options)
      },
      error: function(error) {
        console.log('error', error)
      },
    })

}

$('#storeRecommendation').validate({
  rules: {
    fullName: 'required',
    content: 'required'
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
    CKEDITOR.instances.content.updateElement()
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
          heading: 'نظرات',
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
            // window.location = `${amadeusPath}itadmin/articles/list`;
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

function recommendationSelectedToggle(_this, recommendation_id) {
  $.ajax({
    url: `${amadeusPath}ajax`,
    data: JSON.stringify({
      method: 'recommendationSelectedToggle',
      className: 'recommendation',
      recommendation_id: recommendation_id,
    }),
    type: 'POST',
    dataType: 'JSON',
    success: function(response) {
      if (response.success === true) {
        $.toast({
          heading: 'ویرایش نظر',
          text: response.message.message,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
        if (response.message.data == '1') {
          _this.find('i').removeClass('fa-check').addClass('fa-times')
          _this.find('span').html('عدم نمایش')
        } else {
          _this.find('i').removeClass('fa-times').addClass('fa-check')
          _this.find('span').html('نمایش')
        }
      } else {
        $.toast({
          heading: 'ویرایش نظر',
          text: response.message.message,
          position: 'top-right',
          icon: 'error',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
      }
    }
  })
}

$('#editRecommendation').validate({
  rules: {
    fullName: 'required',
    content: 'required'
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
    CKEDITOR.instances.content.updateElement()
    $(form).ajaxSubmit({
      url: amadeusPath + 'ajax',
      type: 'POST',
      success: function(response) {
        // console.log(response);
        let displayIcon
        if (response.success === true) {
          displayIcon = 'success'
        } else {
          displayIcon = 'error'
        }

        $.toast({
          heading: 'نظرات',
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
            // window.location = `${amadeusPath}itadmin/articles/list`;
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
$('.dropify').dropify()

function removeRecommendation(recommendation_id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "recommendation",
        method: "DeleteRecommendation",
        recommendation_id: recommendation_id,

      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {

          $.toast({
            heading: "حذف نظر",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: "حذف نظر",
            text: response.message,
            position: "top-right",
            icon: "warning",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        }
      },
      complete: function () {
        setTimeout(function () {
          location.reload()

          // window.location = `${amadeusPath}itadmin/articles/list`;
        }, 1000)
      },
    })
  }
}