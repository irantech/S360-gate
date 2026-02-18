$(document).ready(function() {
  let airport_edit_modal = $('#airport-modal'), airport_new_modal = $('#airport-new'),
    airport_table = $('#airports-table'),
    airport_edit_form = $('#airport-edit-form'),
    airport_new_form = $('#airport-new-form'),
    datatable_options = {
      processing: true,
      serverSide: true,
      searchDelay: 350,
      pageLength: 10,
      lengthMenu: [ [10, 25, 50, 100,-1], [10, 25, 50,100, "همه"] ],
      ajax: {
        url: amadeusPath + 'ajax', type: 'POST', dataType: 'JSON', data: function(d) {
          d.className = 'airports'
          d.method = 'allAirports'
          return JSON.stringify(d)
        },
      },
      columnDefs: [{
        render: function(data, type, row) {
          let IsInternal = row['IsInternal']

          return (IsInternal == '1') ? 'داخلی' : 'خارجی'
        }, targets: 5,
      }, {
        // The `data` parameter refers to the data for the cell (defined by the
        // `data` option, which defaults to the column being worked with, in
        // this case `data: 0`.
        render: function(data, type, row) {
          let id = row['id'], btn_text = 'ویرایش ', detail_content = JSON.stringify(row)

          return '<a class="btn btn-info" data-detail=\'' + detail_content + '\' data-toggle="modal" data-target="#airport-modal" data-id="' + id + '">' + btn_text + '</a>' + '' + '<button type="button" class="btn btn-danger delete-airport" data-id="' + id + '">&times;</button>'
        }, targets: 6,
      }],
      columns: [{data: 'id', sortable: false, searchable: false, visible: true}, {
        data: 'AirportFa',
        sortable: true,
        searchable: true,
        visible: true,
      }, {data: 'DepartureCode', sortable: true, searchable: true, visible: true}, {
        data: 'DepartureCityFa',
        sortable: true,
        searchable: true,
        visible: true,
      }, {data: 'CountryFa', sortable: true, searchable: true, visible: true}, {
        data: 'IsInternal',
        sortable: false,
        searchable: false,
        visible: true,
      }],
    }

  airport_table.DataTable(datatable_options)


  airport_edit_modal.on('show.bs.modal', function(event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let detail = button.data('detail')
    console.log(detail)
    var modal = $(this)
    modal.find('#airport_id').val(detail.id)
    modal.find('#DepartureCode').val(detail.DepartureCode)
    modal.find('#AirportFa').val(detail.AirportFa)
    modal.find('#AirportEn').val(detail.AirportEn)
    modal.find('#AirportAr').val(detail.AirportAr)
    modal.find('#DepartureCityFa').val(detail.DepartureCityFa)
    modal.find('#DepartureCityEn').val(detail.DepartureCityEn)
    modal.find('#DepartureCityAr').val(detail.DepartureCityAr)
    modal.find('#CountryFa').val(detail.CountryFa)
    modal.find('#CountryEn').val(detail.CountryEn)
    modal.find('#CountryAr').val(detail.CountryAr)
    modal.find('#IsInternal').val(detail.IsInternal)
  })

  airport_edit_form.submit(function(e) {
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
            heading: 'ویرایش فرودگاه ',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          airport_new_modal.modal('hide')
          airport_table.DataTable().destroy().clear()
          airport_table.DataTable(datatable_options)
          console.log(response)
        }, error: function(error) {
          $.toast({
            heading: 'ویرایش فرودگاه ',
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

  airport_new_form.submit(function(e) {
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
            heading: 'افزودن فرودگاه جدید',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          airport_new_form.trigger('reset')
          airport_edit_modal.modal('hide')
          airport_table.DataTable().destroy().clear()
          airport_table.DataTable(datatable_options)
        }, error: function(error) {
          $.toast({
            heading: 'افزودن فرودگاه جدید',
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

  $('body').on('click', '.delete-airport', function(e) {
    e.preventDefault()
    let airport_id = $(this).data('id')
    if (confirm('آیا برای حذف این فرودگاه مطمئن هستید؟')) {
      $.ajax({
        url: amadeusPath + 'ajax',
        type: 'POST',
        dataType: 'JSON',
        data: JSON.stringify({
          'className': 'airports', 'method': 'deleteAirport', 'id': airport_id,
        }), success: function(response) {
          $.toast({
            heading: 'حذف فرودگاه',
            text: response.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

          airport_table.DataTable().destroy().clear()
          airport_table.DataTable(datatable_options)
        }, error: function(error) {
          $.toast({
            heading: 'حذف فرودگاه',
            text: response.responseJSON.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'danger',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })
          console.log(response)
          airport_table.DataTable().destroy().clear()
          airport_table.DataTable(datatable_options)
        },
      })
    }
  })

})