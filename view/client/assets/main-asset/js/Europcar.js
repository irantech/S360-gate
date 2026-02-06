$("document").ready(function () {
   $(".type_rent_car-js").change(() => {
      $("#start_date_rent").focus()
   })
   $(".type_rent_car-js1").change(() => {
      $("#start_date_rent1").focus()
   })
   // $(".rent-start-date-js").trigger('change')(() => {
   //    $("#rent_cat_place").select2('open')
   // })

   // $(".travel-time-js").change(() => {
   //    $(".passengers-count-js").select2('open')
   // })
   $(".select-city-rent-car-js").change(() => {
      $("#delivery_rent_car_date").focus()
   })
   $(".select-city-rent-car-js1").change(() => {
      $("#delivery_rent_car_date1").focus()
   })
})

// function rentcar_local(is_new_tab=false) {
//    let type_rent_car = $(".type_rent_car-js")
//    let start_date_rent = $(".rent-start-date-js")
//    let rent_car_place = $(".select-city-rent-car-js")
//    let delivery_rent_car_date = $(".delivery_rent-car-date-js")
//    let delivery_place_rent_car = $(".select-delivery-place-rent-car-js")
//    checkSearchFields(
//      type_rent_car,
//      start_date_rent,
//      rent_car_place,
//      delivery_rent_car_date,
//      delivery_place_rent_car
//    )
//
//    type_rent_car=type_rent_car.val()
//    start_date_rent=start_date_rent.val()
//    rent_car_place=rent_car_place.val()
//    delivery_rent_car_date=delivery_rent_car_date.val()
//    delivery_place_rent_car=delivery_place_rent_car.val()
//
//
//    // let passenger_age_list = passengers_age_array.join("/")
//
//    let url = `${amadeusPathByLang}rentCar/${type_rent_car}/${start_date_rent}/${rent_car_place}/${delivery_rent_car_date}/${delivery_place_rent_car}`
//    openLink(url,is_new_tab)
// }


function rentcar_local(is_new_tab = false, suffix = '') {
   let type_rent_car = $(`.type_rent_car-js${suffix}`);
   let start_date_rent = $(`.rent-start-date-js${suffix}`);
   let rent_car_place = $(`.select-city-rent-car-js${suffix}`);
   let delivery_rent_car_date = $(`.delivery_rent-car-date-js${suffix}`);
   let delivery_place_rent_car = $(`.select-delivery-place-rent-car-js${suffix}`);

   checkSearchFields(
     type_rent_car,
     start_date_rent,
     rent_car_place,
     delivery_rent_car_date,
     delivery_place_rent_car
   );

   type_rent_car = type_rent_car.val();
   start_date_rent = start_date_rent.val();
   rent_car_place = rent_car_place.val();
   delivery_rent_car_date = delivery_rent_car_date.val();
   delivery_place_rent_car = delivery_place_rent_car.val();

   let url = `${amadeusPathByLang}rentCar/${type_rent_car}/${start_date_rent}/${rent_car_place}/${delivery_rent_car_date}/${delivery_place_rent_car}`;
   openLink(url, is_new_tab);
}




if (lang == 'fa') {
   $('#rent_date').datepicker({
      numberOfMonths: 1,
      showButtonPanel: !0,
      minDate: 'Y/M/D',
      beforeShow: function(n) {
         e(n, !0);
         $("#ui-datepicker-div").addClass("INH_class_Datepicker")
      }
   });
   $('#delivery_date').datepicker({
      numberOfMonths: 1,
      showButtonPanel: !0,
      minDate: 'Y/M/D',
      beforeShow: function(n) {
         e(n, !0);
         $("#ui-datepicker-div").addClass("INH_class_Datepicker")
      }
   });
}else{
   $('#rent_date').datepicker({
      regional: '',
      numberOfMonths: 1,
      showButtonPanel: !0,
      minDate: 'Y/M/D',
      beforeShow: function(n) {
         e(n, !0);
         $("#ui-datepicker-div").addClass("INH_class_Datepicker")
      }
   });
   $('#delivery_date').datepicker({
      regional: '',
      numberOfMonths: 1,
      showButtonPanel: !0,
      minDate: 'Y/M/D',
      beforeShow: function(n) {
         e(n, !0);
         $("#ui-datepicker-div").addClass("INH_class_Datepicker")
      }
   });
}

//order Reserve Car

$('#order_reserve_car').validate({
   rules: {
      'count_people': {
         required: true,
      },
      'rent_date': {
         required: true,
      },
      'rent_place': {
         required: true,
      },
      'delivery_date': {
         required: true,
      },
      'delivery_place': {
         required: true,
      },
      'mobile': {
         required: true,
         phone: true,
         maxlength: 11
      },
      'name': {
         required: true,
      },
      'email': {
         email: true,
         required: true
      },
   },
   messages: {
      'count_people': {
         'required': useXmltag("EnterAmountValue"),
      },
      'rent_date': {
         'required': useXmltag("EnterAmountValue"),
      },
      'rent_place': {
         'required': useXmltag("EnterAmountValue"),
      },
      'delivery_date': {
         'required': useXmltag("EnterAmountValue"),
      },
      'delivery_place': {
         'required': useXmltag("EnterAmountValue"),
      },
      'mobile': {
         'required': useXmltag("PleaseenterPhoneNumber"),
         'phone': useXmltag("PhoneNumberError"),
         'maxlength': useXmltag("LongPhoneNumberError")
      },
      'name': {
         'required': useXmltag("EnterAmountValue"),
      },
      'email': {
         'email': useXmltag("Invalidemail"),
         'required': useXmltag("EnterAmountValue")
      },
   },
   errorElement: 'em',
   errorPlacement: function(error, element) {
      // Add the `help-block` class to the error element
      error.addClass('help-block')

      if (element.prop('type') === 'checkbox') {
         error.insertAfter(element.parent('label'))
      } else {
         error.insertAfter(element)
      }
   },
   submitHandler: function(form) {
      //tinyMCE.triggerSave();
      $.post(amadeusPath + 'captcha/securimage_check.php',
        {
           captchaAjax: $('#item-captcha').val()
        },
        function (data) {
           console.log(data)
           if (data == true) {
              reloadCaptcha();
              $(form).ajaxSubmit({
                 url: amadeusPath + 'ajax',
                 type: 'POST',
                 success: function (response) {

                    if (response.success === true) {
                       var statusType = 'green';
                    } else {
                       var statusType = 'red';
                    }
                    $.alert({
                       title: useXmltag("OrderRentCar"),
                       icon: 'fa fa-refresh',
                       content: response.message,
                       rtl: true,
                       type: statusType
                    });
                    if (response.success === true) {

                       $('#count_people').val('');
                       $('#rent_date').val('');
                       $('#rent_place').val('');
                       $('#delivery_date').val('');
                       $('#delivery_place').val('');
                       $('#name').val('');
                       $('#email').val('');
                       $('#mobile').val('');
                       $(".select2").select2();
                    }


                 }

              })
           } else {
              reloadCaptcha();
              $.alert({
                 title: useXmltag("OrderRentCar"),
                 icon: 'fa fa-warning',
                 content: useXmltag("WrongSecurityCode"),
                 rtl: true,
                 type: 'red'
              });
              return false;
           }
        });

   },
   highlight: function(element, errorClass, validClass) {
      $(element)
        .parents('.form-group ')
        .addClass('has-error')
        .removeClass('has-success')
   },
   unhighlight: function(element, errorClass, validClass) {
      $(element)
        .parents('.form-group ')
        .addClass('has-success')
        .removeClass('has-error')
   },
})



