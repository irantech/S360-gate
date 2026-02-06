$(document).ready(function() {
  $('#FormChangePriceHotel').validate({
    rules: {
      start_date: 'required',
      end_date: 'required',
      city_code: 'required',
      hotel_star: 'required',
      change_type: 'required',
      price: 'required',
    }, messages: {}, errorElement: 'em', errorPlacement: function(error, element) {
      // Add the `help-block` class to the error element
      error.addClass('help-block')

      if (element.prop('type') === 'checkbox') {
        error.insertAfter(element.parent('label'))
      } else {
        error.insertAfter(element)
      }
    }, submitHandler: function(form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php', type: 'post', success: function(response) {

          let typeApplication = $('#type_application').val()
          let page = '';
          if (typeApplication == 'api') {
             page = 'changePriceHotel'
          }else if (typeApplication == 'marketplaceHotel'){
             page = 'marketChangePrice'
          } else {
             page = 'changePriceExternalHotel'
          }


          let res = response.split(':')
          if (response.indexOf('success') > -1) {
            $.toast({
              heading: 'افزودن تغییرات قیمت جدید',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6,
            })

            setTimeout(function() {
              if(page == 'marketChangePrice') {
                location.reload() ;
              }else{
                window.location = page
              }

            }, 1000)


          } else {

            $.toast({
              heading: 'افزودن تغییرات قیمت جدید',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'error',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6,
            })

          }


        },
      })
    }, highlight: function(element, errorClass, validClass) {
      $(element).parents('.form-group ').addClass('has-error').removeClass('has-success')
    }, unhighlight: function(element, errorClass, validClass) {
      $(element).parents('.form-group ').addClass('has-success').removeClass('has-error')
    },

  })
  $(document).on('keyup', '#search-external-cities', function(e) {
    e.preventDefault()
    let element = $(this), input_value = element.val(), results_html = '', ajaxReq = 'stopableRequest'

    console.log(input_value.length)
    if (input_value.length < 2) {
      results_html = `<div class='p-2 text-muted'>لطفا حداقل ۲ کاراکتر وارد کنید</div>`
      $('.search-cities-result').addClass('loaded').html(results_html)
    } else {
      results_html = ''
      ajaxReq = $.ajax({
        type: 'POST', url: amadeusPath + 'ajax', dataType: 'json', delay: 300, data: JSON.stringify({
          search: input_value, className: 'PriceHotelChange', method: 'searchExternalCity',
        }), beforeSend: function() {
          // ajaxReq.abort()
          // if (ajaxReq.readyState < 4) {
          // }
          $('.search-cities-result').addClass('loading')
        }, success: function(response) {
          let results = response
          if (results.length > 0) {
            results_html = '<ul class="result-list list-unstyled">'
            $(results).each(function(index, el) {
              results_html += `<li class='external-city-item' data-id='${el.id}'>${el.text}</li>`
            })
            results_html += '</ul>'
          } else {
            results_html = `<div class='p-2 text-warning'>شهری یافت نشد</div>`
          }
        }, error: function(error) {
          console.log(error)
          results_html = 'خطا در جستجوی شهر'
        }, complete: function() {
          $('.search-cities-result').removeClass('loading').addClass('loaded').html(results_html)
        },
      })
    }
  })

  $(document).on('click', '.update-cities-list', function(e) {
    $.ajax({
      type: 'POST', url: amadeusPath + 'ajax', dataType: 'json', delay: 300, data: JSON.stringify({
        className: 'PriceHotelChange', method: 'updateExternalHotelCitiesFromOldDb',
      }),
      beforeSend : function(){
        alert('start update 100 cities');
      },
      success : function(response){
        alert('success');
        console.log(response)
      },
      error: function(error){
        alert('error');
        console.log(error);
      },
      complete: function(){
        alert('import completed');
      }
    });
  });
  $(document).on('click', '.external-city-item', function(e) {
    let this_id = $(this).data('id'), this_text = $(this).text()

    $('#city_code').val(this_id)
    $('#search-external-cities').val(this_text)
    $('.search-cities-result').html('')
  })

  $(document).on('click', '#search-external-cities', function(e) {
    $(this).select()
    let html_content = `<div class='p-2 text-muted'>لطفا دوباره جستجو کنید</div>`
    $('.search-cities-result').addClass('loaded').html(html_content)
  })

  let search_city_group = $('.search-city-group')
  $(document).mouseup(function (e) {
  if (!search_city_group.is(event.target) && search_city_group.has(event.target).length === 0) {
    $('.search-cities-result').removeClass('loaded loading')
  }
  })
  // $(document).on('focusout', '#search-external-cities', function(e) {
  //   $('.search-cities-result').removeClass('loading loaded')
  // })
})


function deleteChangePrice(id) {
  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: 'حذف تغییرات',
    icon: 'fa fa-trash',
    content: 'آیا از حذف تغییرات اطمینان دارید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید', btnClass: 'btn-green', action: function() {
          $.post(amadeusPath + 'hotel_ajax.php', {
            id: id, flag: 'delete_change_price_hotel',
          }, function(data) {
            let res = data.split(':')

            if (data.indexOf('success') > -1) {

              $.toast({
                heading: 'حذف تغییرات',
                text: res[1],
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6,
              })

              setTimeout(function() {
                $('#DelChangePrice-' + id).removeClass('popover-danger').addClass('popover-default').attr('onclick', 'return false').attr('data-content', 'شما قبلا این بازه زمانی را حذف نموده اید').find('i').removeClass('btn-danger fa-trash').addClass('btn-default fa-ban')
                $('#borderPrice-' + id).addClass('border-right-change-price')
              }, 1000)
            } else {
              $.toast({
                heading: 'حذف تغییرات',
                text: res[1],
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6,
              })

            }

          })
        },
      }, cancel: {
        text: 'انصراف', btnClass: 'btn-orange',
      },
    },
  })
}

function setUpdateChangePrice(id) {
  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: 'ویرایش تغییرات',
    icon: 'fa fa-trash',
    content: 'آیا از ویرایش تغییرات اطمینان دارید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function() {
          $.post(libraryPath + 'ModalCreator.php',
            {
              Controller: 'PriceHotelChange',
              Method: 'modalUpdatePriceChangeHotel',
              Param: id,
            },
            function (data) {

              $('#ModalPublic').modal('show');
              $('#ModalPublic').html(data);

            });
        },
      }, cancel: {
        text: 'انصراف', btnClass: 'btn-orange',
      },
    },
  })
}


function updatePriceChange(id){
  let price_type = $('#ModalPublic #price_type').val();
  let price = $('#ModalPublic #price').val();

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType:'json',
    data:JSON.stringify({
      method: 'updatePriceChangeHotel',
      className :'PriceHotelChange',
      id: id,
      price_type: price_type,
      price: price,
    }),
    success: function (response) {
      $.toast({
        heading: 'ویرایش تغییرات قیمت هنل ',
        text: response.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });

      setTimeout(function () {
        $('#ModalPublic').hide();
      },1000);
      setTimeout(function (){
          location.reload() ;
        },1000);

    },
    error : function (error) {
      $.toast({
        heading: 'ویرایش تغییرات قیمت هنل ',
        text: error.responseJSON.message,
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });
    }
  });
}

function selectAllCounterForChangeHotel(obj){
  let type_change_counter = $(obj).val();
  if(type_change_counter =='yes'){
    $('.is-disable-for-all').removeClass('d-none').removeAttr('disabled');
    $('.is-enable-for-all').attr('disabled','disabled');
  }else{
    $('.is-disable-for-all').addClass('d-none').attr('disabled');
    $('.is-enable-for-all').removeAttr('disabled');
  }
}