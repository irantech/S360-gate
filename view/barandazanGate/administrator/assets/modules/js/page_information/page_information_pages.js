$(document).ready(function() {
  $('#page_information_form').validate({
    rules: {
      title: 'required',
      name: 'required',
      description: 'required',
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
            heading: 'مطالب',
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

})

function AddAddedMeta() {
  var CountDiv = $('div[data-target="BaseAddedMetaDiv"]').length
  var BaseDiv = $('div[data-target="BaseAddedMetaDiv"]:last-child')
  var CloneBaseDiv = $('div[data-target="BaseAddedMetaDiv"]:last-child').clone()
  var CountDivInEach = 0

  CloneBaseDiv.find("input").val("")
  $('div[data-target="BaseAddedMetaDiv"]:last-child').after(CloneBaseDiv)

  $('.DynamicAddedMeta input[data-parent="AddedMetaValues"]').each(function () {
    $(this).attr(
      "name",
      "AddedMeta[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
    )
    if ($(this).attr("data-target") == "content") {
      CountDivInEach = CountDivInEach + 1
    }
  })
}
function RemoveAddedMeta(_this) {
  if (
    _this
      .parent()
      .parent()
      .parent()
      .parent()
      .find('div[data-target="BaseAddedMetaDiv"]').length > 1
  ) {
    _this.parent().parent().parent().remove()

    var CountDivInEach = 0
    $('.DynamicAddedMeta input[data-parent="AddedMetaValues"]').each(
      function () {
        $(this).attr(
          "name",
          "AddedMeta[" +
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
// function getServicePositions(_this) {
//   console.log('infoooooooooooo')
//   const has_destination=['Flight','Train','Bus','Tour']
//   let positions = _this
//     .parent()
//     .parent()
//     .parent()
//     .find('[data-name=\'positions\']')
//
//
//   positions.find('select').each(function() {
//     $(this).parent().parent().addClass('d-none')
//   })
//
//   if(has_destination.includes(_this.val())){
//     console.log('service_that_has_destination')
//     positions.find('select').each(function() {
//       $(this).parent().parent().removeClass('d-none')
//     })
//   }else{
//     positions.find('select[name="origin_position"]').parent().parent().removeClass('d-none')
//   }
//
//
//   if (_this.val() === 'Hotel') {
//
//
//     positions.find('select').each(function() {
//       removeSelect2()
//       $(this).removeClass('select2')
//       $(this).addClass('select2SearchHotel')
//       initializeSelect2Search()
//     })
//
//
//   } else {
//     positions.find('select').each(function() {
//
//       removeSelect2()
//
//       $(this).removeClass('select2SearchHotel')
//       $(this).addClass('select2')
//
//       initializeSelect2Search()
//     })
//
//
//     $.ajax({
//       type: 'POST',
//       url: amadeusPath + 'ajax',
//       dataType: 'json',
//       data: JSON.stringify({
//         method: 'listAllPositions',
//         className: 'articles',
//         to_json: true,
//         service: _this.val(),
//       }),
//       success: function(response) {
//         let options = '<option value=\'all\'>همه مبداء/مقاصد</option>'
//         if (response.data != '') {
//           console.log('response.data', response.data)
//           $.each(response.data, function(index, item) {
//             options +=
//               '<option value=\'' + index + '\'>' + item.name + '</option>'
//           })
//         }
//         positions.find('select').each(function() {
//           $(this)
//             .html(options)
//             .change()
//
//         })
//       },
//       error: function(error) {
//         console.log('error', error)
//       },
//     })
//
//
//   }
//
//
// }
function initializeSelect2Search() {
  $('.select2').select2()
  $('.select2SearchHotel').select2({
    ajax: {
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return JSON.stringify({
          q: params.term, // search term
          className: 'articles',
          method: 'searchHotel',

        })
      },
      cache: true,
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    },
    placeholder: 'جستجو بین شهر ها',
    minimumInputLength: 1,
    language: {
      inputTooShort: function() {
        return 'شما باید حداقل یک حرف وارد کنید'
      }, searching: function() {
        return 'در حال جستجو ... '
      },
    },


  })

}

function removeCategoryItem(category_id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "articles",
        method: "removeCategory",
        id: category_id,

      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {

          $.toast({
            heading: "حذف مطلب",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: "حذف مطلب",
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
function deletePage(page_id) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "infoPages",
        method: "removePage",
        id: page_id,
      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {
          $.toast({
            heading: "حذف عنوان",
            text: response.message,
            position: "top-right",
            icon: "success",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
          })
        } else {
          $.toast({
            heading: "حذف عنوان",
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