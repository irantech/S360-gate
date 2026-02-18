$(document).ready(function() {
  $('.dropify').dropify()
  $('#addSpecialPage').validate({
    rules: {
      language: 'required',
      title: 'required',
      content: 'required',
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
            heading: 'صفحات ویژه',
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
              window.location = `${amadeusPath}itadmin/special_page/list`;
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
  $('#editSpecialPage').validate({
    rules: {
      language: 'required',
      title: 'required',
      content: 'required',
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
            heading: 'صفحات ویژه',
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
              window.location = `${amadeusPath}itadmin/special_page/list`;
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



function deleteSpecialPage(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: "specialPages",
      method: "removeSpecialPage",
      id: id,
    }),
    success: function (data) {
      $.toast({
        heading: 'صفحات ویژه ',
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
        heading: 'صفحات ویژه',
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

$(document).on('click', '.deleteSpecialPage', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteSpecialPage(id)
  }
});


function resetInsertToggle(_this) {
const attach_type=$('input[name="attach_type"][value="main_page"]')
const search_box=$('input[name="attach_type"][value="search_box"]')
const has_search_box=$('input[name="has_search_box"]')

  has_search_box.prop('checked',false);
  search_box.trigger("click")
  attach_type.trigger("click")

}
function removeSpecialPageImage(_this,page_id,src_name,type) {
  if (confirm('آیا مطمئن هستید ؟')) {
    $.ajax({
      url:amadeusPath + 'ajax',
      data: JSON.stringify({
        className: "specialPages",
        method: "removeSpecialPageImage",
        page_id: page_id,
        src_name: src_name,
        type: type,
      }),
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {
          _this.parent().parent().remove()
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
           // window.location = `${amadeusPath}itadmin/special_page/list`;
        }, 1000)
      },
    })
  }
}


$(document).on('click', '.deleteImageSpecialPage', function(e) {
  e.preventDefault()
  if (confirm('آیا از حذف تصویر مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteImageSpecial(id)
  }
})

function deleteImageSpecial(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'specialPages',
      method: 'deleteImageSpecial',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف تصویر صفحات ویژه',
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
        heading: 'حذف تصویر صفحات ویژه',
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











function initializeSelect2Search() {
  $('select.select2').select2()
  $('select.select2SearchHotel').select2({
    ajax: {
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return JSON.stringify({
          q: params.term, // search term
          className: 'specialPages',
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
async function removeSelect2(){
  if ($('.select2').data('select2')) {
    await $('.select2.select2-hidden-accessible').select2('destroy')
  }
  if ($('.select2SearchHotel').data('select2')) {
    await $('.select2SearchHotel.select2-hidden-accessible').select2('destroy')
  }
  await $('.select2-container--default').remove()
}



function getActionsHtml(type){
  let actions=''
  if(type==='both'){
    actions='' +
      '<div data-name="actions" class="align-self-end align-items-center col-md-1 p-0 d-flex flex-wrap justify-content-center actions-style">\n' +
      '    <button type="button" class="action-box-1 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="removePosition($(this))">\n' +
      '        <span class="fa fa-minus font-12"></span>\n' +
      '    </button>\n' +
      '    <button type="button" class="action-box-1 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="addMorePosition($(this))">\n' +
      '        <span class="fa fa-plus font-12"></span>\n' +
      '    </button>\n' +
      '</div>';
  }else if(type==='mines'){
    actions='' +
      '<div data-name="actions" class="align-self-end align-items-center col-md-1 p-0 action-box-1 d-flex flex-wrap justify-content-center">\n' +
      '    <button type="button" class="h-100 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="removePosition($(this))">\n' +
      '        <span class="fa fa-minus font-12"></span>\n' +
      '    </button>\n' +
      '</div>';
  }else if(type==='plus'){
    actions='' +
      '<div data-name="actions" class="align-self-end align-items-center col-md-1 p-0 action-box-1 d-flex flex-wrap justify-content-center">\n' +
      '    <button type="button" class="h-100 align-items-center d-flex justify-content-center none-style-btn p-4 w-100" onclick="addMorePosition($(this))">\n' +
      '        <span class="fa fa-plus font-12"></span>\n' +
      '    </button>\n' +
      '</div>';
  }

  return actions

}
async function rebuildPositionsIndex() {
  $("[data-name='positions']").each(function(service_index) {

    let _positions=$(this);
    $(this).find(".each-position").each(function(index) {
      if(index===0){
        $(this).attr('data-name','position')
      }else{
        $(this).attr('data-name','added-position')
      }

      let index_number = index + 1



      $(this)
        .find('select[data-name="origin"]').each(function() {

        $(this).parent()
          .find('label')
          .attr('for', 'service' + service_index + 'position' + index_number)
          .html(' مبداء ' + index_number)

        if ($(this).attr('name') === 'position[Visa][Type][]') {
          $(this).attr('id', 'service' + service_index + 'position' + index_number + '-type')
        } else {
          $(this).attr('id', 'service' + service_index + 'position' + index_number + '-origin')
        }
      })
      $(this)
        .find('select[data-name="destination"]').each(function() {

        $(this).parent()
          .find('label')
          .attr('for', 'service' + service_index + 'position' + index_number)
          .html(' مقصد ' + index_number)

        $(this).attr('id', 'service' + service_index + 'position' + index_number + '-destination')

      })

      $(this).find('[data-name="actions"]').remove();
      if (index === 0 && _positions.find('.each-position').length === 1) {
        if($('#service'+index_number).val()  != 'Public') {
          $(this).append(getActionsHtml('plus'));
        }
      } else if (index + 1 !== _positions.find('.each-position').length) {
        console.log('index > 1 && index+1 !== $(this).find(".each-position").length', index > 1 && index + 1 !== $(this).find('.each-position').length);
        $(this).append(getActionsHtml('mines'));
      } else if (index + 1 === _positions.find('.each-position').length && index !== 0) {
        console.log('index+1 === $(this).find(".each-position").length && index !== 0 ', index + 1 === _positions.find('.each-position').length && index !== 0);
        $(this).append(getActionsHtml('both'));
      }
    })

  })



}

async function rebuildServiceIndex() {
  const remove_btn =
    '<button onclick="removeService($(this))" type="button" class="btn btn-danger font-12 rounded p-1 gap-2">' +
    '<span class="fa fa-trash"> </span>' +
    ' حذف</button>'

  await $("[data-name='added-service']").each(function(index) {
    let index_number = index + 2
    $(this)
      .find('h4')
      .addClass('w-100 justify-content-between')
      .html('مکان نمایش  ' + index_number + remove_btn)
    $(this)
      .find('select[name="service[]"]')
      .attr('id', 'service' + index_number)
  })
}


async function removePosition(_this) {
  _this.parent().parent().remove()
  await rebuildPositionsIndex()
}

/*function removeCategories(_this) {
   _this.parent().remove()
   rebuildPositionsIndex()
}*/
async function removeService(_this) {
  _this.parent().parent().parent().remove()
  await rebuildServiceIndex()
  await rebuildPositionsIndex()
}

async function addMorePosition(_this) {
  await removeSelect2()

  let position = _this.parents('.each-position').clone()

  const added_position_count = _this.parents("[data-name='added-position']").length + 2
  await position.attr('data-name', 'added-position')
  await position.find('select').attr('id', 'position' + added_position_count)
  await position
    .find('label[for="position1"]')
    .attr('for', 'position' + added_position_count)
  console.log("_this.parents(\"[data-name='positions']\")",_this.parents("[data-name='positions']"))
  console.log('position',position)
  await _this.parents("[data-name='positions']").append(position)

  await rebuildPositionsIndex()
  await initializeSelect2Search()

}

async function addMoreService(_this) {
  await removeSelect2()

  let service = $('[data-name="service"]').clone()
  const added_service_count = $('[data-name=\'added-service\']').length + 2
  service.attr('data-name', 'added-service')
  service
    .find('select[name="service[]"]')
    .attr('id', 'service' + added_service_count)
  service
    .find('label[for="service1"]')
    .attr('for', 'service' + added_service_count)
  console.log('service',service)
  service.find("[data-name='positions']").find("[data-name='added-position']").remove()
  service.find("[data-name='position']").find('select').val('').change()
  service.find(".tooltip-info").remove()
  service.find("[data-test-name='visa-type']").remove()
  $("[data-name='add-more-service']").before(service)

  await rebuildServiceIndex()
  await rebuildPositionsIndex()
  await removeSelect2()
  await initializeSelect2Search()
}




async function getServicePositions(_this) {
  console.log('hello')
  // const has_destination = returnableServices;
  const has_destination1 = returnableServices;
  const has_destination2 =  ["internalFlight", "internationalFlight"];
  const has_destination = has_destination1.concat(has_destination2);

  let positions = _this
    .parent()
    .parent()
    .parent()
    .find('[data-name=\'positions\']')


  /* positions.find('select').each(function() {
     $(this).parent().parent().addClass('d-none')
   })

    console.log('service_that_has_destination')
     positions.find('select').each(function() {
       $(this).parent().parent().removeClass('d-none')
     })*/




  if (has_destination.includes(_this.val())) {
    positions.find('select').each(async function() {
      await $(this).parent().parent().removeClass('d-none')
    })
  } else {
    positions.find('select[data-name="destination"]').parent().parent().addClass('d-none')
  }

  // all
  positions.find('select[data-test-name="visa-type"]').remove()
  positions.find('select').each(async function() {
    await $(this)
      .attr('name', 'position[' + _this.val() + ']['+ $(this).data('name')+'][]')
  })


  if (_this.val() === 'Visa') {
    await removeSelect2()

    positions.find('select').each(async function() {


      $(this).removeClass('select2SearchHotel')
      $(this).addClass('select2')
      let cloned_select = $(this).clone()
      cloned_select.attr('data-test-name','visa-type')
      $(this).after(cloned_select)
      await rebuildPositionsIndex()
      const next_position = $(this).next()
      next_position.attr('name', 'position[Visa][Type][]')
      next_position.attr('id', next_position.attr('id') + '-type')
      initializeSelect2Search()
    })

    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'listAllPositions',
        className: 'specialPages',
        to_json: true,
        service: _this.val(),
      }),
      success: function(response) {
        let countries = '<option value=\'all\'>همه کشور ها</option>'
        let types = '<option value=\'all\'>همه نوع ها</option>'
        if (response.data != '') {
          console.log('response.data', response.data)
          $.each(response.data.countries, function(index, item) {
            countries +=
              '<option value=\'' + index + '\'>' + item.name + '</option>'
          })
          $.each(response.data.types, function(index, item) {
            types +=
              '<option value=\'' + item.id + '\'>' + item.title + '</option>'
          })
        }
        positions.find('select:not([data-test-name="visa-type"])').each(function() {
          $(this)
            .html(countries)
            .change()

        })
        positions.find('select[data-test-name="visa-type"]').each(function() {
          $(this)
            .html(types)
            .change()

        })
      },
      error: function(error) {
        console.log('error', error)
      },
    })

  } else if (_this.val() === 'Hotel') {


    positions.find('select').each(async function() {
      $(this).html('')
      $(this).removeClass('select2')
      $(this).addClass('select2SearchHotel')

    })


  } else {
    positions.find('select').each(async function() {



      $(this).removeClass('select2SearchHotel')
      $(this).addClass('select2')


    })


    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'listAllPositions',
        className: 'specialPages',
        to_json: true,
        service: _this.val(),
      }),
      success: function(response) {
        let options = '<option value=\'all\'>همه مبداء/مقاصد</option>'
        if (response.data != '') {
          console.log('response.data', response.data)
          $.each(response.data, function(index, item) {
            options +=
              '<option value=\'' + index + '\'>' + item.name + '</option>'
          })
        }
        positions.find('select').each(function() {
          $(this)
            .html(options)
            .change()

        })
      },
      error: function(error) {
        console.log('error', error)
      },
    })





  }
  await removeSelect2()
  await initializeSelect2Search()



}
$(document).ready(function() {
  // $('[name="service[]"]').change()
})








