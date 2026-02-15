//this must be a global plugin for datatable api
jQuery.fn.dataTable.Api.register('sum()', function() {
  return this.flatten().reduce(function(a, b) {
    if (typeof a === 'string') {
      a = a.replace(/[^\d.-]/g, '') * 1
    }
    if (typeof b === 'string') {
      b = b.replace(/[^\d.-]/g, '') * 1
    }

    return a + b
  }, 0)
})
//end plugin code

$(document).ready(function() {
  function nFormatter(num, digits) {
    const lookup = [
      {value: 1, symbol: ''},
      {value: 1e3, symbol: 'هزار'},
      {value: 1e6, symbol: 'میلیون'},
      {value: 1e9, symbol: 'میلیارد'},
    ]
    const rx = /\.0+$|(\.[0-9]*[1-9])0+$/
    var item = lookup.slice().reverse().find(function(item) {
      return num >= item.value
    })
    return item ? (num / item.value).toFixed(digits).replace(rx, '$1') + item.symbol : '0'
  }
  function getNum(num){
    if (isNaN(num)) {
      return 0
    }
    return num
  }
  let title_field = $('#filtered_on option:selected').text()
  let total_field = $('#filter_total option:selected').text()
  $('.filtered_on').text(title_field)
  let ajax_request = {
      url: amadeusPath + 'ajax',
      type: 'POST',
      dataType: 'JSON',
      data: function(d) {
        d.className = 'reportTour'
        d.method = 'reportTourTotalSales'
        d.start_date = $('#date_of').val()
        d.end_date = $('#to_date').val()
        d.filtered_on = $('#filtered_on').val()
        d.filter_total = $('#filter_total').val()
        title_field = $('#filtered_on option:selected').text()
        total_field = $('#filter_total option:selected').text()
        return JSON.stringify(d)
      },
    },
    tour_table = $('#Tour-report-table'),
    tour_form = $('#Tour-report');

  tour_table.DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 250,
    ajax: ajax_request,
    columnDefs: [
      {
        render: function(data, type, row, meta) {
          return meta.row + 1
        },
        targets: 0,
      },
      {
        render: function(data, type, row) {
          let total = row['total_count']
          return '<span class="column-value">' + total + '</span>'
        },
        targets: 2,
      },
      {
        render: function(data, type, row) {
          let count = ( row['total_success'] + row['total_source_error']).toFixed(2),
            col_data = row['total_success'],
            percentage = getNum(((100 * col_data) / count).toFixed(2))
          return '<span class="column-value">' +
            col_data +
            '<span title="موفق" class="column-percentage success">(' +
            percentage +
            '%)</span>' +
            '</span>'
        },
        targets: 3,
      },
      {
        render: function(data, type, row) {
          let count = ( row['total_success'] + row['total_error']).toFixed(2),
            col_data = row['total_source_error'],
            percentage = getNum(((100 * col_data) / count).toFixed(2))
          return '<span class="column-value">' +
            col_data +
            '<span title="خطای منبع" class="column-percentage source-error">(' +
            percentage +
            '%)</span>' +
            '</span>'
        },
        targets: 4,
      },
      {
        render: function(data, type, row) {
          let count = ( row['total_success'] + row['total_error']).toFixed(2),
            //( row['total_success'] + row['total_source_error']).toFixed(2),
            col_data = row['total_user_error'],
            percentage = getNum(((100 * col_data) / count).toFixed(2))
          return '<span class="column-value">' +
            col_data +
            '<span title="خطا از کل رزروها" class="column-percentage error">(' +
            percentage +
            '%)</span>' +
            '</span>'
        },
        targets: 5,
      },
      {
        render: function(data, type, row) {
          let count = ( row['total_success']).toFixed(2),
            col_data = row['total_cancel'],
            percentage = getNum(((100 * col_data) / count).toFixed(2))
          return '<span class="column-value">' +
            col_data +
            '<span title="کنسل" class="column-percentage warning">(' +
            percentage +
            '%)</span>' +
            '</span>'
        },
        targets: 6,
      },
      {
        render: function(data, type, row) {
          let result
          let total_price = row['total_price']
          let price = total_price.toString()
          result = '<span class="column-value">' + nFormatter(total_price, 1) + '</span>'
          result += '<br><span class="column-percentage">' + price.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + '</span>'
          return result
        },
        targets: 7,
      },

    ],
    columns: [
      {data: 'id', title: 'ردیف', sortable: false, searchable: false, visible: true},
      {data: 'title_field', title: title_field, sortable: true, searchable: true, visible: true},
      {data: 'total_count', title: total_field, sortable: true, searchable: false, visible: true},
      {data: 'total_success', title: 'موفق', sortable: true, searchable: false, visible: true},
      {data: 'total_source_error', title: 'خطای منبع', sortable: true, searchable: false, visible: true},
      {data: 'total_user_error', title: 'خطای کاربر', sortable: true, searchable: false, visible: true},
      {data: 'total_cancel', title: 'کنسلی', sortable: true, searchable: false, visible: true},
      {data: 'total_price', title: 'مبلغ فروش (ریال)', sortable: true, searchable: true, visible: true},
    ],
    drawCallback: function() {
      let api = this.api(),
        sum_3 = api.column(2, {page: 'current'}).data().sum(),
        sum_4 = api.column(3, {page: 'current'}).data().sum(),
        sum_5 = api.column(4, {page: 'current'}).data().sum(),
        sum_6 = api.column(5, {page: 'current'}).data().sum(),
        sum_7 = api.column(6, {page: 'current'}).data().sum()
        sum_8 = api.column(7, {page: 'current'}).data().sum()
      let sum_total = (sum_4 + sum_5).toFixed(2) || 0,
        success_percentage = getNum(((100 * sum_4) / sum_total).toFixed(2)),
        error_percentage = getNum(((100 * sum_6) / sum_3).toFixed(2)),
        source_error_percentage = getNum(((100 * sum_5) / sum_total).toFixed(2)),
        cancel_percentage = getNum(((100 * sum_7) / sum_4).toFixed(2));

      let t_footer = $(api.table().footer())
        t_footer.find('th:nth-child(2)').html('جمع کل')
        t_footer.find('th:nth-child(3)').html(sum_3)
        t_footer.find('th:nth-child(4)').html(sum_4 + ' <span class="column-percentage success">('+success_percentage+') %</span>')
        t_footer.find('th:nth-child(5)').html(sum_5 + ' <span class="column-percentage source-error">('+source_error_percentage+') %</span>')
        t_footer.find('th:nth-child(6)').html(sum_6 + ' <span class="column-percentage error">('+error_percentage+') %</span>')
        t_footer.find('th:nth-child(7)').html(sum_7 + ' <span class="column-percentage warning">('+cancel_percentage+') %</span>')
        t_footer.find('th:nth-child(8)').html(nFormatter(sum_7))
    },
    order: [[3, 'DESC']],
  })

  tour_form.on('submit', function(e) {
    e.preventDefault()
    tour_table.DataTable().clear().destroy()
    title_field = $('#filtered_on option:selected').text()
    total_field = $('#filter_total option:selected').text()
    $('.filtered_on').text(title_field);
    tour_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: ajax_request,
      columnDefs: [
        {
          render: function(data, type, row, meta) {
            return meta.row + 1
          },
          targets: 0,
        },
        {
          render: function(data, type, row) {
            let total = row['total_count']
            return '<span class="column-value">' + total + '</span>'
          },
          targets: 2,
        },
        {
          render: function(data, type, row) {
            let count = ( row['total_success'] + row['total_source_error']).toFixed(2),
              col_data = row['total_success'],
              percentage = getNum(((100 * col_data) / count).toFixed(2))
            return '<span class="column-value">' +
              col_data +
              '<span title="موفق" class="column-percentage success">(' +
              percentage +
              '%)</span>' +
              '</span>'
          },
          targets: 3,
        },

        {
          render: function(data, type, row) {
            let count = ( row['total_success'] + row['total_source_error']).toFixed(2),
              col_data = row['total_source_error'],
              percentage = getNum(((100 * col_data) / count).toFixed(2))
            return '<span class="column-value">' +
              col_data +
              '<span title="خطای منبع" class="column-percentage source-error">(' +
              percentage +
              '%)</span>' +
              '</span>'
          },
          targets: 4,
        },
        {
          render: function(data, type, row) {
            let count = row['total_count'].toFixed(2),
                // ( row['total_success'] + row['total_source_error']).toFixed(2),
              col_data = row['total_user_error'],
              percentage = getNum(((100 * col_data) / count).toFixed(2))
            return '<span class="column-value">' +
              col_data +
              '<span title="خطا از کل رزروها" class="column-percentage error">(' +
              percentage +
              '%)</span>' +
              '</span>'
          },
          targets: 5,
        },
        {
          render: function(data, type, row) {
            let count = ( row['total_success']).toFixed(2),
              col_data = row['total_cancel'],
              percentage = getNum(((100 * col_data) / count).toFixed(2))
            return '<span class="column-value">' +
              col_data +
              '<span title="کنسلی" class="column-percentage warning">(' +
              percentage +
              '%)</span>' +
              '</span>'
          },
          targets: 6,
        },
        {
          render: function(data, type, row) {
            let result
            let total_price = row['total_price']
            let price = total_price.toString()
            result = '<span class="column-value">' + nFormatter(total_price, 1) + '</span>'
            result += '<br><span class="column-percentage">' + price.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + '</span>'
            return result
          },
          targets: 7,
        },
      ],
      columns: [
        {data: 'id', title: 'ردیف', sortable: false, searchable: false, visible: true},
        {data: 'title_field', title: title_field, sortable: true, searchable: true, visible: true},
        {data: 'total_count', title: total_field, sortable: true, searchable: false, visible: true},
        {data: 'total_success', title: 'موفق', sortable: true, searchable: false, visible: true},
        {data: 'total_source_error', title: 'خطای منبع', sortable: true, searchable: false, visible: true},
        {data: 'total_user_error', title: 'خطای کاربر', sortable: true, searchable: false, visible: true},
        {data: 'total_cancel', title: 'کنسلی', sortable: true, searchable: false, visible: true},
        {data: 'total_price', title: 'مبلغ فروش (ریال)', sortable: true, searchable: true, visible: true},
      ],
      drawCallback: function() {
        let api = this.api(),
          sum_3 = api.column(2, {page: 'current'}).data().sum(),
          sum_4 = api.column(3, {page: 'current'}).data().sum(),
          sum_5 = api.column(4, {page: 'current'}).data().sum(),
          sum_6 = api.column(5, {page: 'current'}).data().sum(),
          sum_7 = api.column(6, {page: 'current'}).data().sum(),
          sum_8 = api.column(7, {page: 'current'}).data().sum()
        let sum_total = (sum_4 + sum_5).toFixed(2) || 0,
          success_percentage = getNum(((100 * sum_4) / sum_total).toFixed(2)),
          error_percentage = getNum(((100 * sum_6) / sum_3).toFixed(2)),
          source_error_percentage = getNum(((100 * sum_5) / sum_total).toFixed(2)),
          cancel_percentage = getNum(((100 * sum_7) / sum_4).toFixed(2))
        let t_footer = $(api.table().footer())
        t_footer.find('th:nth-child(2)').html('جمع کل')
        t_footer.find('th:nth-child(3)').html(sum_3)
        t_footer.find('th:nth-child(4)').html(sum_4 + ' <span class="column-percentage success">('+success_percentage+') %</span>')
        t_footer.find('th:nth-child(5)').html(sum_5 + ' <span class="column-percentage source-error">('+source_error_percentage+') %</span>')
        t_footer.find('th:nth-child(6)').html(sum_6 + ' <span class="column-percentage error">('+error_percentage+') %</span>')
        t_footer.find('th:nth-child(7)').html(sum_7 + ' <span class="column-percentage warning">('+cancel_percentage+') %</span>')
        t_footer.find('th:nth-child(8)').html(nFormatter(sum_8))
      },
      order: [[3, 'DESC']],
    })
    // console.log('submited filter form');
  })

})