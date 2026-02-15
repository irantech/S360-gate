
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });

})


function ExecuteExcelNewsLetter11111(thiss) {
  var TargetFile = thiss.attr('data-target-file');
  var target = thiss.attr('data-target');

  var FilterData = $('#FormExecuteNewsLetter').serialize();
  thiss.addClass('running btn-default').removeClass('btn-primary');
  setTimeout(function () {

    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'createNewsLetterExcel',
        className: 'newsLetter',
        is_json: true,
        param: FilterData
      }),
      success: function (data) {

        thiss.addClass('btn-primary').removeClass('running btn-default');

        var res = data.split('|');
        if(data.indexOf('success') > -1){

          var url = amadeusPath + 'pic/excelFile/' + res[1];
          var isFileExists = fileExists(url);
          if(isFileExists){
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


function ExecuteExcelNewsLetter33333(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'newsLetter',
      method: 'createNewsLetterExcel',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'دریافت فایل اکسل',
        text: data.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      })
      setTimeout(function() {
        location.reload()
        // window.location = `${amadeusPath}itadmin/newsLetter/list`;
      }, 1000)

    },
    error:function(error) {
      $.toast({
        heading: 'دریافت فایل اکسل',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      })
      setTimeout(function() {
        location.reload()
        // window.location = `${amadeusPath}itadmin/vote/list`;
      }, 1000)
    }
  });
}


function fileExists(url) {
  if(url){
    var req = new XMLHttpRequest();
    req.open('GET', url, false);
    req.send();
    return req.status == 200;
  } else {
    return false;
  }
}

function ExecuteExcelNewsLetter(thiss) {
  var TargetFile = thiss.attr('data-target-file');
  var target = thiss.attr('data-target');
  var FilterData = $('#FormExecuteNewsLetter').serialize();
  thiss.addClass('running btn-default').removeClass('btn-primary');

  setTimeout(function () {
    $.ajax({
      type: 'post',
      url: amadeusPath + TargetFile,
      data: FilterData,
      success: function (data) {
        thiss.addClass('btn-primary').removeClass('running btn-default');

        var res = data.split('|');

        if(data.indexOf('success') > -1){
          var url = amadeusPath + 'pic/excelFile/' + res[1];
          var isFileExists = fileExists(url);
          if(isFileExists){
            window.open(url, 'Download');
          } else {
            $.toast({
              heading: 'دریافت فایل اکسل',
              text: 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید.',
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'error',
              hideAfter: 1500,
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
            hideAfter: 1500,
            textAlign: 'right',
            stack: 6
          });

        }

      }
    });
  }, 5000);

}






function deleteNewsLetter(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'newsLetter',
      method: 'deleteNewsLetter',
      id,
    }),
    success: function (data) {
      $.toast({
        heading: 'حذف خبرنامه',
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
        heading: 'حذف خبرنامه',
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
        // window.location = `${amadeusPath}itadmin/newsLetter/list`;
      }, 1000)
    },
  });
}
$(document).on('click', '.deleteNewsLetter', function(e) {
  e.preventDefault()
  if (confirm('آیا مطمئن هستید ؟')) {
    let id = $(this).data('id')
    deleteNewsLetter(id)
  }
})