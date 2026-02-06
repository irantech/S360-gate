$(document).ready(function(){

  $('#service').on('change',function(){
    $.ajax({
      url: amadeusPath + 'ajax',
      type: 'post',
      dataType: 'json',
      data:  JSON.stringify({
          className: 'manageMenuAdmin',
          method : 'getRelevantService',
          service : $(this).val(),
          is_json:true
      }),
      success: function(response) {
        console.log(response)
        let obj_arrival = response.data
        let destination = $('#relevant_service')
        destination.html(' ')
        destination.append(' <option value="">انتخاب کنید</option>')
        Object.keys(obj_arrival).forEach(key => {
          let option_text = `${obj_arrival[key]['TitleFa']}`
          let option_value = `${obj_arrival[key]['TitleEn']}`
          let new_option = new Option(option_text, option_value, false, false)
          destination.append(new_option).trigger('open')
        })

        destination.removeAttr('disabled',true);
          destination.select2('open')

      }
    })
  })
})

function setAccessCounterAdmin(){

  let member_id = $('#member_id').val();
  $.ajax({
    url: amadeusPath + 'ajax',
    type: 'post',
    dataType: 'json',
    data:  JSON.stringify({
      className: 'manageMenuAdmin',
      method : 'registerAccessHistoryCounter',
      member_id,
      service_title : $('#relevant_service').val(),
    }),
    success: function(response) {
      $.toast({
        heading: 'ثبت دسترسی سوابق خرید',
        text: response.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6,
      })

      setTimeout(function(){
        window.location = 'accessHistory&id='+ member_id
      },1000)
    },
    error: function(error){
      $.toast({
        heading: 'ثبت دسترسی سوابق خرید',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'warning',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6,
      })

    }
  })
}



function deleteAccessHistoryCounter(id){
  $.ajax({
    url: amadeusPath + 'ajax',
    type: 'post',
    dataType: 'json',
    data:  JSON.stringify({
      className: 'manageMenuAdmin',
      method : 'deleteAccessHistoryCounter',
      id
    }),
    success: function(response) {
      $.toast({
        heading: 'حذف دسترسی سوابق خرید',
        text: response.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6,
      })

      setTimeout(function(){
        $('#del-'+id).remove();
      },1000)
    },
    error: function(error){
      $.toast({
        heading: 'حذف دسترسی سوابق خرید',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'warning',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6,
      })

    }
  })
}