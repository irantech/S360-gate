function ModalChangeCloseTime(airlineId = '') {
   $.post(libraryPath + 'ModalCreator.php', {
         Controller: 'airlineCloseTime',
         Method: 'ModalChangeCloseTime',
         airlineId: airlineId,
         Param: airlineId,
      },
      function (data) {
         $("#ModalPublic").html(data);
      });
}

function ChangeCloseTime(airlineId = '') {

   const internalHour = $('.internalTime .hours').val();
   const internalMinute = $('.internalTime .minutes').val();
   const externalHour = $('.externalTime .hours').val();
   const externalMinute = $('.externalTime .minutes').val();

   let internalTime = internalHour + ':' + internalMinute;
   let externalTime = externalHour + ':' + externalMinute;

   $.confirm({
      theme: 'supervan' ,// 'material', 'bootstrap'
      title: 'ساعت ارسال مانیفست',
      icon: 'fa fa-trash',
      content: 'آیا از تنظیم ساعت ارسال مانیفست اطمینان دارید ؟',
      rtl: true,
      closeIcon: true,
      type: 'orange',
      buttons: {
         confirm: {
            text: 'تایید',
            btnClass: 'btn-green',
            action: function () {
               $.post(amadeusPath + 'user_ajax.php',
                  {
                     internalTime: internalTime,
                     externalTime: externalTime,
                     airlineId: airlineId,
                     flag: 'airlineCloseTime'
                  },
                  function (data) {
                     var res = JSON.parse(data);
                     console.log(res)
                     if (res.success) {
                        $.toast({
                           heading: 'ساعت ارسال مانیفست',
                           text: res.message,
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'success',
                           hideAfter: 6000,
                           textAlign: 'right',
                           stack: 6,

                        });

                        setTimeout(function () {
                           location.reload();
                        }, 1500);

                     } else {
                        $.toast({
                           heading: 'ساعت ارسال مانیفست',
                           text: res.message,
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'error',
                           hideAfter: 6000,
                           textAlign: 'right',
                           stack: 6
                        });
                     }

                  });
            }
         },
         cancel: {
            text: 'انصراف',
            btnClass: 'btn-orange',
         }
      }
   });


}

function deleteCloseTime(airlineId) {

   $.confirm({
      theme: 'supervan' ,// 'material', 'bootstrap'
      title: 'تنظیمات پیش فرض',
      icon: 'fa fa-trash',
      content: 'آیا از بازگردانی به تنظیمات پیش فرض اطمینان دارید ؟',
      rtl: true,
      closeIcon: true,
      type: 'orange',
      buttons: {
         confirm: {
            text: 'تایید',
            btnClass: 'btn-green',
            action: function () {
               $.post(amadeusPath + 'user_ajax.php',
                  {
                     airlineId: airlineId,
                     flag: 'deleteCloseTime'
                  },
                  function (data) {
                     console.log(data)
                     var res = JSON.parse(data);
                     console.log(res)
                     if (res.success) {
                        $.toast({
                           heading: 'بازگردانی به تنظیمات پیش فرض',
                           text: res.message,
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'success',
                           hideAfter: 6000,
                           textAlign: 'right',
                           stack: 6,

                        });

                        setTimeout(function () {
                           location.reload();
                        }, 1500);

                     } else {
                        $.toast({
                           heading: 'بازگردانی به تنظیمات پیش فرض',
                           text: res.message,
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'error',
                           hideAfter: 6000,
                           textAlign: 'right',
                           stack: 6
                        });
                     }

                  });
            }
         },
         cancel: {
            text: 'انصراف',
            btnClass: 'btn-orange',
         }
      }
   });


}
