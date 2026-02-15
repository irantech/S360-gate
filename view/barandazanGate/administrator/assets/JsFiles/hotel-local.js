$(document).ready(function() {
  let edit_modal = $('#hotel-modal'), new_modal = $('#hotel-new'),
    hotel_table = $('#hotels-table'),
    edit_form = $('#hotel-edit-form'),
    new_form = $('#hotel-new-form'),
    datatable_options = {
      stateSave: true,
      processing: true,
      serverSide: true,
      searchDelay: 350,
      pageLength: 10,
      lengthMenu: [ [10, 25, 50, 100,-1], [10, 25, 50,100, "همه"] ],
      ajax: {
        url: amadeusPath + 'ajax', type: 'POST', dataType: 'JSON', data: function(d) {
          d.className = 'coreHotelSettings'
          d.method = 'getAllHotelLocal'
          return JSON.stringify(d)
        },
      },
      columnDefs: [{
        render: function(data, type, row) {
          let id = row['id'], btn_text = 'ویرایش ', detail_content = JSON.stringify(row)
          return '<a class="btn btn-info" data-detail=\'' + detail_content + '\' data-toggle="modal" data-target="#hotel-modal" data-id="' + id + '">' + btn_text + '</a>' + '' + '<button type="button" class="btn btn-danger delete-hotel" data-id="' + id + '">&times;</button>'
        }, targets: 6,
      }
      ],
      columns: [
        {data: 'id', sortable: false, searchable: false, visible: true},
        {data: 'name',sortable: true,searchable: true,visible: true},
        {data: 'name_en',sortable: true,searchable: true,visible: true},
        {data: 'star_code', sortable: true, searchable: true, visible: true},
        {data: 'city.name', sortable: true, searchable: true, visible: true},
        {data: 'type.name', sortable: true, searchable: true, visible: true}
      ],
    }

  hotel_table.DataTable(datatable_options)


  edit_modal.on('show.bs.modal', function(event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let detail = button.data('detail')
    console.log(detail)
    var modal = $(this)
    modal.find('#hotel_id').val(detail.id)
    modal.find('#type').val(detail.type_id).select2()
    modal.find('#name').val(detail.name)
    modal.find('#name_en').val(detail.name_en)
    modal.find('#name_en').val(detail.name_en)
    modal.find('#star_code').val(detail.star_code)
    modal.find('#phone').val(detail.phone)
    modal.find('#fax').val(detail.fax)
    modal.find('#city_id').val(detail.city_id).select2()
    modal.find('#latitude').val(detail.latitude)
    modal.find('#longitude').val(detail.longitude)
    modal.find('#check_time_in').val(detail.check_time_in)
    modal.find('#check_time_out').val(detail.check_time_out)
    modal.find('#address').val(detail.address)
    modal.find('#address_en').val(detail.address_en)
    modal.find('#cancel_conditions').val(detail.cancel_conditions)
    modal.find('#source_eghamat').val(detail.sources.e24).attr('disabled',true)
    modal.find('#source_parto').val(detail.sources.parto).attr('disabled',true)
  })

  $('.edit-eghamat').on('click',function(e){
    e.preventDefault();
    $('#source_eghamat').removeAttr('disabled');
  });

  $('.edit-parto').on('click',function(e){
    e.preventDefault();
    $('#source_parto').removeAttr('disabled');
  });

  edit_form.submit(function(e) {
    e.preventDefault()

  }).validate({
    rules: {
      id: 'required', DepartureCode: 'required', IsInternal: 'required',
    }, errorElement: 'em', submitHandler: function(form) {
      let form_data = {}
      $.each($(form).serializeArray(), function() {
        form_data[this.name] = this.value
      })
      let json_data = JSON.stringify(form_data)
      $.ajax({
        url: amadeusPath + 'ajax', type: 'post', dataType: 'json', data: json_data, success: function(response) {
          $.toast({
            heading: 'ویرایش هتل ',
            text: response.Message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          edit_modal.modal('hide')
          hotel_table.DataTable().destroy().clear()
          hotel_table.DataTable(datatable_options)
          console.log(response)
        }, error: function(error) {
          $.toast({
            heading: 'ویرایش هتل ',
            text: error.responseJSON.Message,
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

  new_form.submit(function(e) {
    e.preventDefault()
  }).validate({
    rules: {
      DepartureCode: 'required', IsInternal: 'required',
    }, errorElement: 'em', submitHandler: function(form) {
      let form_data = {};
      $.each($(form).serializeArray(), function() {
        form_data[this.name] = this.value
      })
      let json_data = JSON.stringify(form_data)
      $.ajax({
        url: amadeusPath + 'ajax', type: 'post', dataType: 'json', data: json_data, success: function(response) {
          $.toast({
            heading: 'افزودن هتل جدید',
            text: response.Message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          new_form.trigger('reset')
          edit_modal.modal('hide')
          hotel_table.DataTable().destroy().clear()
          hotel_table.DataTable(datatable_options)
        }, error: function(error) {
          $.toast({
            heading: 'افزودن هتل جدید',
            text: error.responseJSON.Message,
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

  $('body').on('click', '.delete-hotel', function(e) {
    e.preventDefault()
    let hotel_id = $(this).data('id')
    if (confirm('آیا برای حذف این هتل مطمئن هستید؟')) {
      $.ajax({
        url: amadeusPath + 'ajax',
        type: 'POST',
        dataType: 'JSON',
        data: JSON.stringify({
          'className': 'coreHotelSettings', 'method': 'deleteHotel', 'id': hotel_id,
        }), success: function(response) {
          $.toast({
            heading: 'حذف هتل',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          hotel_table.DataTable().destroy().clear()
          hotel_table.DataTable(datatable_options)
        }, error: function(error) {
          $.toast({
            heading: 'حذف هتل',
            text: response.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'danger',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          console.log(response)
          hotel_table.DataTable().destroy().clear()
          hotel_table.DataTable(datatable_options)
        },
      })
    }
  })

})