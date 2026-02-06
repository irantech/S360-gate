$(document).ready(function() {
  // $('.select2').select2({});
  let ajaxUpdateCountryIds = function() {
    $.ajax({
      url: `${amadeusPath}ajax`,
      type: 'POST',
      dataType: 'JSON',
      data: JSON.stringify({
        method: 'updateCountryIds',
        className: 'hotelCities',
      }),
      success: function(response) {
        console.log('updated countryIds' + response[0])
      },
    })
  }
  // setInterval(ajaxUpdateCountryIds,10000);
  let city_edit_modal = $('#city-modal'), city_new_modal = $('#city-new'),
    city_table = $('#cities-table'),
    city_edit_form = $('#city-edit-form'),
    city_new_form = $('#city-new-form'),
    datatable_options = {
      stateSave: true,
      processing: true,
      serverSide: true,
      searchDelay: 250,
      pageLength: 50,
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'همه']],
      ajax: {
        url: amadeusPath + 'ajax', type: 'POST', dataType: 'JSON', data: function(d) {
          d.className = 'hotelCities'
          d.method = 'allCities'
          return JSON.stringify(d)
        },
      },
      columnDefs: [{
        render: function(data, type, row,meta) {
          // console.log(meta)
          let id = row['id'], btn_text = 'ویرایش ', detail_content = JSON.stringify(row)
          return `<a class='btn btn-info btn-edit-${id}' 
data-name="${row['city_name_en']}"
data-name_fa="${row['city_name_fa']}"
data-country_name="${row['country_name_en']}"
data-country_name_fa="${row['country_name_fa']}"
data-core_id="${row['core_id']}"
data-country_id="${row['country_id']}"
data-toggle="modal"
data-target="#city-modal" 
data-id="${id}">${btn_text}</a>
<button type='button' class='btn btn-danger delete-city' data-id='${id}'>&times;</button>`

        }, targets: 4,
      }],
      columns: [
        {data: 'id', sortable: true, searchable: false, visible: true},
        {
          data: 'city_name_en',
          sortable: true,
          searchable: true,
          visible: true,
        }, {
          data: 'city_name_fa',
          sortable: true,
          searchable: true,
          visible: true,
        }, {
          data: 'country_name_en',
          sortable: true,
          searchable: true,
          visible: true,
        }, {
          data: 'country_id',
          sortable: false,
          searchable: false,
          visible: true,
        },
      ],
    }

  city_table.DataTable(datatable_options)

  city_edit_modal.on('show.bs.modal', function(event) {

    let button = $(event.relatedTarget) // Button that triggered the modal
    let id = button.data('id')
    // let detail = $('input#detail-' + id).val()
    let detail = button.data()
    console.log(detail)
    console.group('detail is', detail)
    let modal = $(this)
    modal.find('#city_id').val(detail.id)
    modal.find('#name').val(detail.name)
    modal.find('#name_fa').val(detail.name_fa)
    modal.find('#country_id').val(detail.country_id)
    if ($('.select2').data('select2')) {
      $('.select2.select2-hidden-accessible').select2('destroy')
    }
    $('.select2').select2({
      dropdownParent: $('.modal-dialog')
    });
  })

  city_edit_form.submit(function(e) {
    e.preventDefault()

  }).validate({
    rules: {
      id: 'required', city_name_en: 'required', country_id: 'required',
    }, errorElement: 'em', submitHandler: function(form) {
      let form_data = {}
      $.each($(form).serializeArray(), function() {
        form_data[this.name] = this.value
      })
      let json_data = JSON.stringify(form_data)
      $.ajax({
        url: amadeusPath + 'ajax', type: 'post', dataType: 'json', data: json_data, success: function(response) {
          $.toast({
            heading: 'ویرایش شهر ',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          city_edit_modal.modal('hide')
          // city_new_modal.modal('hide')
          // city_table.DataTable().destroy().clear()
          // city_table.DataTable(datatable_options)
          city_table.DataTable().ajax.reload(null, false)
          console.log(response)

        }, error: function(error) {
          $.toast({
            heading: 'ویرایش شهر ',
            text: error.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'warning',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          console.log(error)
        },
      })
    },
  })

  city_new_form.submit(function(e) {
    e.preventDefault()
  }).validate({
    rules: {
      city_name_en: 'required', country_id: 'required',
    }, errorElement: 'em', submitHandler: function(form) {
      let form_data = {}
      $.each($(form).serializeArray(), function() {
        form_data[this.name] = this.value
      })
      let json_data = JSON.stringify(form_data)
      $.ajax({
        url: amadeusPath + 'ajax', type: 'post', dataType: 'json', data: json_data, success: function(response) {
          $.toast({
            heading: 'افزودن شهر جدید',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          city_new_form.trigger('reset')
          city_edit_modal.modal('hide')
          // city_table.DataTable().destroy().clear()
          // city_table.DataTable(datatable_options)
          city_table.DataTable().ajax.reload(null, false)
        }, error: function(error) {
          $.toast({
            heading: 'افزودن شهر جدید',
            text: error.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'warning',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          console.log(error)
        },
      })
    },
  })

  $('body').on('click', '.delete-city', function(e) {
    e.preventDefault()
    let city_id = $(this).data('id')
    if (confirm('آیا برای حذف این شهر مطمئن هستید؟')) {
      $.ajax({
        url: amadeusPath + 'ajax',
        type: 'POST',
        dataType: 'JSON',
        data: JSON.stringify({
          'className': 'hotelCities', 'method': 'deleteCity', 'id': city_id,
        }), success: function(response) {
          $.toast({
            heading: 'حذف شهر',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          // city_table.DataTable().destroy().clear()
          // city_table.DataTable(datatable_options)
          city_table.DataTable().ajax.reload(null, false)
        }, error: function(error) {
          $.toast({
            heading: 'حذف شهر',
            text: response.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'danger',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          console.log(response)
          // city_table.DataTable().destroy().clear()
          // city_table.DataTable(datatable_options)
          city_table.DataTable().ajax.reload(null, false)
        },
      })
    }
  })

})

function displayHotel(_this , hotel_id , source_code) {
  $.ajax({
    url: `${amadeusPath}ajax`,
    data: JSON.stringify({
      method: 'setHotel',
      className: 'webserviceHotel',
      hotel_id: hotel_id,
      source_code : source_code
    }),
    type: 'POST',
    dataType: 'JSON',
    success: function(response) {
      console.log(response)
      if (response.success === true) {
        $.toast({
          heading: 'نمایش هتل',
          text: response.message.message,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
        if (response.message.data == '1') {
          _this.find('span').html('نمایش')
        } else {

          _this.find('span').html('عدم نمایش')
        }
      } else {
        $.toast({
          heading: 'ویرایش مقاله',
          text: response.message.message,
          position: 'top-right',
          icon: 'error',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6,
        })
      }
    },
    complete: function() {
      setTimeout(function() {
        // window.location = `${amadeusPath}itadmin/articles/list`;
      }, 1000)
    },
  })
}