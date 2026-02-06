
$(document).ready(function() {
  $('.dropify').dropify();
  $('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
  });



})


function updateStatusWeather(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'weather',
      method: 'updateStatusWeather',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر شهر منتخب انجام شد',
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
        // window.location = `${amadeusPath}itadmin/weather/list`;
      }, 1000)

    },
    error:function(error) {
      $.toast({
        heading: 'تغییر شهر منتخب',
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
        // window.location = `${amadeusPath}itadmin/weather/list`;
      }, 1000)
    }
  });
}

