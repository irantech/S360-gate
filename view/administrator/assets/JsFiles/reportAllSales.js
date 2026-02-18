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



function reportContent()
{
  var $url  = amadeusPath + 'ajax';
  var $data = JSON.stringify({
    className: 'reportContentClient',
    method: 'index',
    start_date:$('#date_of').val(),
    end_date:$('#to_date').val()
  });

  var $table =  $('#list-content-table')
  var $thead = $table.find('thead')
  var $tbody = $table.find('tbody')


  var $temp = '';
  $('body').append('<div class="mask"><span class="loader"></span></div>')

  $tbody.empty()
  $.post($url,$data,function(response)
  {
    console.log(response)

    const dataArray = Object.values(response);
    dataArray.sort((a, b) => b.CountSuccess - a.CountSuccess);
  console.log(dataArray)
   var counter = 1;
    $.each(dataArray,function(index,value)
    {

      $temp += '<tr>' +
                '<td>'+counter+'</td>' +
                '<td>'+value['ClinetName']+'</td>' +
                '<td>'+value['CountNews']['count']+'</td>' +
                '<td>'+value['CountMag']['count']+'</td>' +
                '<td>'+value['CountSpecialPages']['count']+'</td>' +
                '<td>-</td>' +
                '<td>-</td>' +
                '<td>'+value['CountTourInternal']['count']+'</td>' +
                '<td>'+value['CountTourForeigner']['count']+'</td>' +
                '<td>'+ value['CountSuccess'] +'</td>' +
               '</tr>'

      counter++;
    }
    )
    $('body').find('.mask').remove()
    $tbody.append($temp);

  })

}

$('body').on('click','#clinet_content',function(e)
{
  reportContent()
});

$('body').on('click','#transactions',function(e){

  $('body').append('<div class="mask"><span class="loader"></span></div>')

  var $url  = amadeusPath + 'ajax';
  var $data = JSON.stringify({
    className: 'transactions',
    method: 'index'
  });

  $.post($url,$data,function(response){

    console.log(response)
    $('body').find('.mask').remove()
  })

});







function reportSales(response)
{
  $("#list-sales-table").find('thead').empty()

  var $temp = '';
  var $temp1 = "<tr><th>ردیف</th><th>نام آژانس</th><th>بلیط د</th><th>بلیط خ</th><th>تور د</th><th>تور خ</th><th>هتل د</th><th>هتل خ</th><th>قطار</th><th>اتوبوس</th><th>ویزا</th><th>بیمه</th><th>خرید - موفق</th></tr>";
  let $response = JSON.parse(response);
  let $SumOfColumn = $response[0];
  $.each($SumOfColumn,function(index,value)
    {
      $temp1 += '<tr class="all-reports">' +
        '<th colspan="1">جمع کل قراردادها نه افراد</th>' +
        '<th>' + value['FlightInternalGBF'] + '</th>' +
        '<th>' + value['FlightForeignerGBF'] + '</th>' +
        '<th>' + value['TourInternalGBF'] + '</th>' +
        '<th>' + value['TourForeignerGBF'] + '</th>' +
        '<th>' + value['HotelInternalGBF'] + '</th>' +
        '<th>' + value['HotelForeignerGBF'] + '</th>' +
        '<th>' + value['TrainGBF'] + '</th>' +
        '<th>' + value['Bus'] + '</th>' +
        '<th>' + value['VisaGBF']+'</th>' +
        '<th>' + value['InsuranceGBF'] + '</th>' +
        '<th>' + value['successPayment'] + '</th>'
      '</tr>';
    }
  );

  $response.shift();

  let mergedResponse = $response.map(item => ({
    ...item.Information,
    ...item.Count
  }));

  mergedResponse.sort((a, b) => b.TotalSuccess - a.TotalSuccess);




  $.each(mergedResponse,function(index,value)
    {


      let $Text1= value['FlightInternal'] +" / "+value['FlightInternalGBF'];
      let $Text2= value['FlightForeigner']+" / "+value['FlightForeignerGBF'];
      let $Text3= value['TourInternal']+" / "+value['TourInternalGBF'];
      let $Text4= value['TourForeigner']+" / "+value['TourForeignerGBF'];
      let $Text5= value['HotelInternal']+" / "+value['HotelInternalGBF'];
      let $Text6= value['HotelForeigner']+" / "+value['HotelForeignerGBF'];
      let $Text7= value['Train']+" / "+value['TrainGBF'];
      let $Text8 = value['Bus'];
      let $Text9= value['Visa']+" / "+value['VisaGBF'];
      let $Text10 = value['Insurance']+" / "+value['InsuranceGBF'];
      let $Text11 = value['TotalSuccess'];

      if ( (value['FlightInternalGBF'] === null) || (value['FlightInternal'] === null)) $Text1 = "0 / 0"
      if ( (value['FlightForeigner'] === null) || (value['FlightForeigner'] === null)) $Text2 = "0 / 0"
      if ( (value['TourInternal'] === null) || (value['TourInternalGBF'] === null)) $Text3 = "0 / 0"
      if ( (value['TourForeigner'] === null) || (value['TourForeignerGBF'] === null)) $Text4 = "0 / 0"
      if ( (value['HotelInternal'] === null) || (value['HotelInternalGBF'] === null)) $Text5 = "0 / 0"
      if ( (value['HotelForeigner'] === null) || (value['HotelForeignerGBF'] === null)) $Text6 = "0 / 0"
      if ( (value['Train'] === null) || (value['TrainGBF'] === null)) $Text7 = "0 / 0"
      if ( (value['Bus'] === null) ) $Text8 = "0"
      if ( (value['Visa'] === null) || (value['VisaGBF'] === null)) $Text9 = "0 / 0"
      if ( (value['Insurance'] === null) || (value['InsuranceGBF'] === null)) $Text10 = "0 / 0"
      if ( (value['TotalSuccess'] === null) ) $Text11 = "0"



      $temp += '<tr>' +
        '<td>'+ index +'</td>' +
        '<td>'+value['NameAgency'] + ' ' + value['Manager'] +'</td>' +
        '<td>'+ $Text1 +'</td>' +
        '<td>'+ $Text2 +'</td>' +
        '<td>'+ $Text3 +'</td>' +
        '<td>'+ $Text4 +'</td>' +
        '<td>'+ $Text5 +'</td>' +
        '<td>'+ $Text6 +'</td>' +
        '<td>'+ $Text7 +'</td>' +
        '<td>'+ $Text8 +'</td>' +
        '<td>'+ $Text9 +'</td>' +
        '<td>'+ $Text10 +'</td>' +
        '<td>'+ $Text11 +'</td>' +
        '</tr>';
    }


  )

  $('#list-sales-table thead').append($temp1)
  $('#list-sales-table tbody').html($temp)

  $('#loading-indicator').hide()
}



$(document).ready(function() {
	var OutAjax='';

	function CallAjax(){
		let ajax_request = {
			  url: amadeusPath + 'ajax',
			  type: 'POST',
			  dataType: 'text',

			  data:  JSON.stringify({
					  className: 'reportAllSales',
					  method: 'retrieveInformation',
					  start_date:$('#date_of').val(),
					  end_date:$('#to_date').val()
				}),
			  success: function(response) {
           reportSales(response)
				},
			error: function(xhr, status, error) {
				console.log('Error: ' + error) // در صورت بروز خطا، خطا را چاپ کنید
				console.log('Response: ' + xhr.responseText) // اگر سرور پیامی ارسال کرد، آن را چاپ کنید
			},
		};
		$.ajax(ajax_request)
	}

	CallAjax()
	/*
  var sales_table = $('#list-sales-table');
  var sales_form = $('#form-sales');


  sales_table.DataTable({
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
            //let total = row['total_count']
            return '<span class="column-value">نام آژانس</span>'
          },
          targets: 1,
        },
        {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">شماره تماس</span>'
          },
          targets: 2,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">بلیط</span>'
          },
          targets: 3,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">بلیط</span>'
          },
          targets: 4,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">تور</span>'
          },
          targets: 5,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">تور</span>'
          },
          targets: 6,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">هتل</span>'
          },
          targets: 7,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">هتل</span>'
          },
          targets: 8,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">قطار</span>'
          },
          targets: 9,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">اتوبوس</span>'
          },
          targets: 10,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">ویزا</span>'
          },
          targets: 11,
        },
    {
          render: function(data, type, row) {
            //let total = row['total_count']
            return '<span class="column-value">بیمه</span>'
          },
          targets: 12,
        },
      ],
      columns: [
        {data: 'id', title: 'ردیف', sortable: false, searchable: false, visible: true},
    {data: 'NameAgency', title: 'نام آژانس', sortable: true, searchable: true, visible: true},
    {data: 'Mobile', title: 'شماره تماس', sortable: true, searchable: true, visible: true},
        {data: 'FlightInternal', title: 'بلیط داخلی', sortable: true, searchable: true, visible: true},
    {data: 'FlightForeigner', title: 'بلیط خارجی', sortable: true, searchable: true, visible: true},
    {data: 'TourInternal', title: 'تور داخلی', sortable: true, searchable: true, visible: true},
    {data: 'TourForeigner', title: 'تور خارجی', sortable: true, searchable: true, visible: true},
        {data: 'HotelInternal', title: 'هتل داخلی', sortable: true, searchable: true, visible: true},
        {data: 'HotelForeigner', title: 'هتل خارجی', sortable: true, searchable: true, visible: true},
        {data: 'Train', title: 'قطار', sortable: true, searchable: true, visible: true},
        {data: 'Bus', title: 'اتوبوس', sortable: true, searchable: true, visible: true},
        {data: 'Visa', title: 'ویزا', sortable: true, searchable: true, visible: true},
        {data: 'Insurance', title: 'بیمه', sortable: true, searchable: true, visible: true},
      ],
      drawCallback: function() {
        let api = this.api(),
          sum_3 = api.column(2, {page: 'current'}).data().sum(),
          sum_4 = api.column(3, {page: 'current'}).data().sum(),
          sum_5 = api.column(4, {page: 'current'}).data().sum(),
          sum_6 = api.column(5, {page: 'current'}).data().sum(),
          sum_7 = api.column(6, {page: 'current'}).data().sum(),
          sum_8 = api.column(7, {page: 'current'}).data().sum(),
      sum_9 = api.column(8, {page: 'current'}).data().sum()
      sum_10 = api.column(9, {page: 'current'}).data().sum()
      sum_11 = api.column(10, {page: 'current'}).data().sum()
      sum_12 = api.column(11, {page: 'current'}).data().sum()
      sum_13 = api.column(12, {page: 'current'}).data().sum()
        let t_footer = $(api.table().footer())
        t_footer.find('th:nth-child(2)').html('جمع کل')
        t_footer.find('th:nth-child(3)').html(nFormatter(sum_3))
        t_footer.find('th:nth-child(4)').html(nFormatter(sum_4))
        t_footer.find('th:nth-child(5)').html(nFormatter(sum_5))
        t_footer.find('th:nth-child(6)').html(nFormatter(sum_6))
        t_footer.find('th:nth-child(7)').html(nFormatter(sum_7))
        t_footer.find('th:nth-child(8)').html(nFormatter(sum_8))
    t_footer.find('th:nth-child(9)').html(nFormatter(sum_9))
    t_footer.find('th:nth-child(10)').html(nFormatter(sum_10))
    t_footer.find('th:nth-child(11)').html(nFormatter(sum_11))
    t_footer.find('th:nth-child(12)').html(nFormatter(sum_12))
    t_footer.find('th:nth-child(13)').html(nFormatter(sum_13))
      },
    })
  })
*/

	$('#button-sales').click(function(e) {
		e.preventDefault(); // جلوگیری از ارسال فرم یا رفتار پیش‌فرض دیگر
		// نمایش علامت لودینگ
		$('#loading-indicator').show();
		// خالی کردن محتوای جدول
		$('#sales_table tbody').empty();
		//$.ajax(ajax_request);
		CallAjax();
	});

})//end document