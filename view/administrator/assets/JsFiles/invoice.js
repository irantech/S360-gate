$(document).ready(function () {

  //data tables Option
  $('#hotelHistory').DataTable();

});



function ModalSetHotelInvoice(tracking_code) {

  // let factor_number_list = [];
  //
  // $("input:checkbox[name=factor_number_list]:checked").each(function(){
  //   console.log($(this).val())
  //   factor_number_list.push($(this).val());
  // });
  // if(factor_number_list.length == 0) {
  //   factor_number_list = ''
  // }
  $.post(libraryPath + 'ModalCreatorForHotel.php',
    {
      Controller: 'invoice',
      Method: 'ModalSetHotelInvoice',
      Param: tracking_code
    },
    function (data) {

      $('#ModalPublic').html(data);

    });
}

function ModalShowBookForHotel(factorNumber) {
  console.log('ModalShowBookForHotel');
  $.post(libraryPath + 'ModalCreatorForHotel.php',
    {
      Controller: 'bookhotelshow',
      Method: 'ModalShowBook',
      Param: factorNumber
    },
    function (data) {

      $('#ModalPublic').html(data);

    });
}
$('#hotelHistory').DataTable({
  "order": [
    [0, 'desc']
  ],
  dom: 'lBfrtip',
});


function createExcelForReportHotel() {

  $('#btn-excel').css('opacity', '0.5');
  $('#loader-excel').removeClass('displayN');

  setTimeout(function () {
    $.ajax({
      type: 'post',
      url: amadeusPath + 'hotel_ajax.php',
      data: $('#SearchHotelHistory').serialize(),
      success: function (data) {

        $('#btn-excel').css('opacity', '1');
        $('#loader-excel').addClass('displayN');

        var res = data.split('|');
        if (data.indexOf('success') > -1) {

          var url = amadeusPath + 'pic/excelFile/' + res[1];
          var isFileExists = fileExists(url);
          if (isFileExists){
            window.open(url, 'Download');
          } else {
            $.toast({
              heading: 'دریافت فایل اکسل',
              text: 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید.',
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'error',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });
          }


        } else {

          $.toast({
            heading: 'دریافت فایل اکسل',
            text: res[1],
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
          });

        }

      }
    });
  }, 5000);



}


function setInvoiceData() {

  let factor_number_list = [];
  $("input:checkbox[name=factor_number_list]:checked").each(function(){
    factor_number_list.push($(this).val());
  });

  if(factor_number_list.length == 0 ) {
    $.alert({
      title: 'ثبت درخواست فاکتور',
      icon: 'fa fa-times',
      content: 'انتخاب حداقل یک خرید الزامی است.',
      rtl: true,
      type: 'red',
    });
    return false ;
  }

  let from_company = $('#from_company').val() ;
  let to_company = $('#to_company').val() ;
  let origin_account = $('#origin_account').val() ;
  let destination_account = $('#destination_account').val() ;
  let account_holder = $('#account_holder').val() ;
  let description = $('#description').val() ;
  if(!from_company && !to_company && !origin_account && !destination_account
  && !account_holder){
    $.alert({
      title: 'ثبت درخواست فاکتور',
      icon: 'fa fa-times',
      content: ',ورود اطلاعات الزامی است.',
      rtl: true,
      type: 'red',
    });
    return false ;
  }

  $.ajax({
    url: amadeusPath + 'ajax',
    type: 'POST',
    dataType: 'JSON',
    data: JSON.stringify({
      className:'invoice',
      method:'setInvoice',
      from_company , to_company , origin_account ,
      destination_account , account_holder ,description  ,factor_number_list
    }),
    success: function (response) {
      $.alert({
        title: 'ثبت درخواست فاکتور',
        icon: 'fa fa-check',
        content: response.responseJSON.message,
        rtl: true,
        type: 'green',
      });
      setTimeout(function () {
        location.reload()
      }, 3000);

    },
    error:function(error) {
      $.alert({
        title: 'ثبت درخواست فاکتور',
        icon: 'fa fa-refresh',
        content: error.responseJSON.message,
        rtl: true,
        type: 'red',
      });
    }
  })

}


function setPaymentData(tracking_code) {

  let from_company = $('#from_company').val() ;
  let to_company = $('#to_company').val() ;
  let origin_account = $('#origin_account').val() ;
  let destination_account = $('#destination_account').val() ;
  let account_holder = $('#account_holder').val() ;
  let description = $('#description').val() ;
  if(!from_company && !to_company && !origin_account && !destination_account) {
    $.alert({
      title: 'ثبت درخواست فاکتور',
      icon: 'fa fa-times',
      content: ',ورود اطلاعات الزامی است.',
      rtl: true,
      type: 'red',
    });
    return false ;
  }
  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: 'پرداخت فاکتور',
    icon: 'fa fa-percent',
    content: 'آیا این فاکتور را پرداخت نمودید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function () {
          $.ajax({
            url: amadeusPath + 'ajax',
            type: 'POST',
            dataType: 'JSON',
            data: JSON.stringify({
              className:'invoice',
              method:'updateInvoiceStatus',
              tracking_code ,  from_company , to_company , origin_account ,
              destination_account , account_holder ,description
            }),
            success: function (response) {

              $.alert({
                title: 'ثبت تاریخ واریز',
                icon: 'fa fa-check',
                content: 'با موفقیت انجام شد',
                rtl: true,
                type: 'green',
              });
              setTimeout(function () {
                location.reload()
              }, 3000);

            },
            error:function(error) {
              $.alert({
                title: 'ثبت درخواست فاکتور',
                icon: 'fa fa-refresh',
                content: error.responseJSON.message,
                rtl: true,
                type: 'red',
              });
            }
          })

        }
      },
      cancel: {
        text: 'انصراف',
        btnClass: 'btn-orange',
      }
    }
  });
}



