$(document).ready(function () {

  // $('.dropify').dropify();
  $("#FormHotelAdd").validate({
    rules: {
      name: "required",
      name_en: "required"
    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      CKEDITOR.instances.comment.updateElement()
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (data) {

          var res = data.split(':');
          if (data.indexOf('success') > -1) {
            $.alert({
              title: 'افزودن تغییرات هتل',
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'green',
            });
            setTimeout(function () {
              $('#FormHotelAdd')[0].reset();
            }, 1000);
            setTimeout(function() {
              window.location ='hotelList'
            }, 2000);
          }else{
            $.alert({
              title: 'افزودن تغییرات هتل',
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'red',
            });
          }
        }
      });
    },
  });

  $( "#origin_country" ).change(function() {
    var  origin_country = $('#origin_country').val();
    FillComboCity(origin_country, 'origin_city');
  });

  $( "#origin_city" ).change(function() {
    var  origin_city = $('#origin_city').val();
    FillComboRegion(origin_city, 'origin_region');
  });

  $('#hotelList').DataTable();



  $('#myTable').DataTable();

 let book_table = $('#booking').DataTable();

  $("#setUserRole").validate({
    rules: {
      item_id   : 'required',
      user_name : 'required',
      password  : 'required',
      role      : 'required' ,
      item_type : 'hotel'
    },
    messages: {},
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");
    },
    submitHandler: function (form) {
      if(!$('#item_id').val().length > 0  && !$('#role').val().length > 0 ) {
        $.alert({
          title :"ثبت کاربر",
          text: 'وارد کردن همه اطلاعات الزامی است.',
          icon: 'fa fa-trash',
          content: 'وارد کردن همه اطلاعات الزامی است.',
          rtl: true,
          type: 'red'
        })
        return false;
      }
      $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
          method: "setUserRole",
          className: "userRole",
          item_id : $('#item_id').val(),
          entry : $("#user_name").val(),
          password : $("#password").val(),
          role : $("#role").val(),
          item_type :'hotel',
          set_new_user : true
        }),
        success: function (response) {
          let data_response = JSON.parse(JSON.stringify(response))
          console.log(data_response)
          if (data_response.status == 'success') {
            $.alert({
              title :"ثبت کاربر",
              text: 'اطلاعات با موفقیت ثبت شد.',
              icon: 'fa fa-check',
              content: 'اطلاعات با موفقیت ثبت شد.',
              rtl: true,
              type: 'green'
            })

            setTimeout(function(){
              location.reload();
            }, 1000);
          }
        },
        error: function (error) {
          if(error.responseJSON.data && error.responseJSON.data.id ) {
            $.confirm({
              theme: 'supervan',// 'material', 'bootstrap'
              title: 'تایید ثبت کاربر',
              icon: 'fa fa-trash',
              content: error.responseJSON.message,
              rtl: true,
              closeIcon: true,
              type: 'orange',
              buttons: {
                confirm: {
                  text: 'تایید',
                  btnClass: 'btn-green',
                  action: function() {

                    $.ajax({
                      type: "POST",
                      url: amadeusPath + "ajax",
                      dataType: "json",
                      data: JSON.stringify({
                        method: "setUserRole",
                        className: "userRole",
                        item_id : $('#item_id').val(),
                        entry : $("#user_name").val(),
                        password : $("#password").val(),
                        role : $("#role").val(),
                        item_type :'hotel',
                        set_new_user : false
                      }),
                      success: function (response) {
                        let data_response = JSON.parse(JSON.stringify(response))
                        if (data_response.status == 'success') {
                          $.alert({
                            title :"ثبت کاربر",
                            text: 'اطلاعات با موفقیت ثبت شد.',
                            icon: 'fa fa-check',
                            content: 'اطلاعات با موفقیت ثبت شد.',
                            rtl: true,
                            type: 'green'
                          })

                          setTimeout(function(){
                            location.reload();
                          }, 1000);
                        }
                      },
                      error: function (error) {
                        $.alert({
                          title :"ثبت کاربر",
                          text: error.responseJSON.message,
                          icon: 'fa fa-trash',
                          content: error.responseJSON.message,
                          rtl: true,
                          type: 'red'
                        })
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
          else{
            $.alert({
              title :"ثبت کاربر",
              text: error.responseJSON.message,
              icon: 'fa fa-trash',
              content: error.responseJSON.message,
              rtl: true,
              type: 'red'
            })
          }

        }
      })
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });
  $("#updateUserRole").validate({
    rules: {
      update_password  : 'required',
      confirm_password      : 'required'
    },
    messages: {},
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");
    },
    submitHandler: function (form) {
      var newPassword = $('#update_password').val();
      var confirmPassword = $('#confirm-password').val();
      if (newPassword !== confirmPassword) {
        $.alert({
          title :"رمز عبور",
          text: "رمز عبور و تکرار ان یکسان نیستند",
          icon: 'fa fa-trash',
          content: "رمز عبور و تکرار ان یکسان نیستند",
          rtl: true,
          type: 'red'
        })
        return;
      }

      $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
          method: "updateUserRole",
          className: "userRole",
          password : $("#update_password").val(),
          user_role_id : $("#hotel_role_id").val(),
        }),
        success: function (response) {
          let data_response = JSON.parse(JSON.stringify(response))
          if (data_response.status == 'success') {
            $.alert({
              title :"ثبت کاربر",
              text: 'اطلاعات با موفقیت ویرایش شد.',
              icon: 'fa fa-check',
              content: 'اطلاعات با موفقیت ویرایش شد.',
              rtl: true,
              type: 'green'
            })

            setTimeout(function(){
              location.reload();
            }, 1000);
          }
        },
        error: function (error) {
          $.alert({
            title :"ویرایش کاربر",
            text: error.responseJSON.message,
            icon: 'fa fa-trash',
            content: error.responseJSON.message,
            rtl: true,
            type: 'red'
          })
        }
      })
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });

  $("#hotelGallery").validate({
    rules: {
      name: 'required',
      pic: 'required'
    },
    messages: {},
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");
    },
    submitHandler: function (form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {

          var res = response.split(':');

          if (response.indexOf('success') > -1) {
            $.alert({
              title : ' گالری هتل',
              text: res[1],
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'green',
            });
            setTimeout(function(){
              window.location ='hotelGallery&id=' + $('#id_hotel').val();
            }, 1000);


          } else {
            $.alert({
              title : ' گالری هتل',
              text: res[1],
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'red',
            });
          }
        }
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }


  });

  $("#Facilities").validate({
    rules: {

    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {
          var res = response.split(':');

          if (response.indexOf('success') > -1) {

            $.alert({
              title : ' امکانات هتل',
              text: 'افزودن تغییرات هتل',
              icon: 'fa fa-check',
              content: res[1],
              rtl: true,
              type: 'green',
            });

            setTimeout(function(){
              location.reload();
            }, 1000);


          } else {
            $.alert({
              title : ' امکانات هتل',
              text: 'افزودن تغییرات هتل',
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'red',
            });

          }


        }
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }

  });

  $("#FormHotelRoom").validate({
    rules: {
      room_title: "required",
      room_name_en: "required",
      room_capacity: "required",
      maximum_extra_beds: "required",
      maximum_extra_chd_beds:"required"
    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      let id = $('#id_hotel').val();
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {

          var res = response.split(':');

          if (response.indexOf('success') > -1) {

            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-check',
              content: res[1],
              rtl: true,
              type: 'green',
            });

            setTimeout(function(){
              location.reload();
            }, 1000);


          } else {
            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'red',
            });

          }
        }
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }

  });

  $("#EditHotelRoom").validate({
    rules: {
      room_title: "required",
      room_name_en: "required",
      room_capacity: "required",
      maximum_extra_beds: "required",
      maximum_extra_chd_beds:"required"
    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {

          var res = response.split(':');

          if (response.indexOf('success') > -1) {
            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-check',
              content: res[1],
              rtl: true,
              type: 'green',
            });

            setTimeout(function(){
              window.location ='hotelRoomList&id=' + $('#id_hotel').val();
            }, 1000);


          } else {

              $.alert({
                title :'افزودن تغییرات هتل',
                text: res[1],
                icon: 'fa fa-trash',
                content: res[1],
                rtl: true,
                type: 'red',
              });
          }


        }
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }

  });

  $("#EditHotel").validate({
    rules: {
      hotel_name: "required",
      hotel_name_en: "required"
    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      CKEDITOR.instances.comment.updateElement()
      CKEDITOR.instances.distance_to_important_places.updateElement()
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {

          var res = response.split(':');

          if (response.indexOf('success') > -1) {

            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-check',
              content: res[1],
              rtl: true,
              type: 'green',
            });

            setTimeout(function(){
              window.location ='editHotel&id=' + res[2];
            }, 1000);

          }
          else {
            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'red',
            });
          }
        }
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }

  });

  $("#FormGallery").validate({
    rules: {
      pic: "required"
    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {

          var res = response.split(':');

          if (response.indexOf('success') > -1) {

            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-check',
              content: res[1],
              rtl: true,
              type: 'green',
            });


            setTimeout(function(){
              window.location = 'roomGallery&idHotel='+$('#id_hotel').val()+'&idRoom='+$('#id_room').val();
            }, 1000);


          } else {
            $.alert({
              title :'افزودن تغییرات هتل',
              text: res[1],
              icon: 'fa fa-trash',
              content: res[1],
              rtl: true,
              type: 'red',
            });

          }


        }
      });
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }

  });

  $("#Facilities").validate({
    rules: {

    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      $(form).ajaxSubmit({
        url: amadeusPath + 'hotel_ajax.php',
        type: "post",
        success: function (response) {
          var res = response.split(':');

          if (response.indexOf('success') > -1) {
            $.toast({
              heading: 'افزودن تغییرات هتل',
              text: res[1],
              position: 'top-right',
              loaderBg: '#fff',
              icon: 'success',
              hideAfter: 3500,
              textAlign: 'right',
              stack: 6
            });

            setTimeout(function(){
              window.location = 'roomFacility&idHotel='+$('#id_hotel').val()+'&idRoom='+$('#id_room').val();;
            }, 1000);


          } else {

            $.toast({
              heading: 'افزودن تغییرات هتل',
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
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
    }

  });



  $('input[type=radio][name=dayType]').change(function() {
      let type = this.value
      setChartData(type)
  });

  $("#changeRoomCalender").validate({
    rules: {
      from_date: "required",
      end_date: "required"
    },
    messages: {

    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {

      var roomPlus = $("#roomPlus").attr("name");
      const btnRegistration = document.querySelector('.btn-registration span');
      let type_data = $("#roomPlus").val()
      let change_type_room = $("#change_type_room").val()
      let weekDays = [] ;
      let selected_days = [] ;
      let rooms_selected = [] ;
      var selectedRadio = document.querySelector('input[name="monthly-time"]:checked');

      if(selectedRadio.value == 'monthly'){
        var inputs = document.getElementsByName('dateArray[]');

        // Loop through inputs and collect their values
        for (var i = 0; i < inputs.length; i++) {
          selected_days.push(inputs[i].value);
        }

      }
      else{
        let inputs = document.querySelectorAll('.weekday_check input[type="checkbox"]');
        inputs.forEach((input) => {
          if(input.checked) {
            weekDays.push(input.value)
          }
        });
      }

      if(change_type_room == 'multiple_room') {
        let roomInputs = document.querySelectorAll('.checkbox-btn input.room_check[type="checkbox"]');
        roomInputs.forEach((input) => {
          if(input.checked) {
            rooms_selected.push(input.value)
          }
        });
      }else if(change_type_room == 'one_room'){
        rooms_selected.push($('.description-room-item button.active').data('room'))
      }
      if(rooms_selected.length == 0 ) {
        $.alert({
          title :'افزودن تغییرات هتل',
          text: 'هیچ اتاقی انتخاب نشده است ',
          icon: 'fa fa-trash',
          content:'هیچ اتاقی انتخاب نشده است ',
          rtl: true,
          type: 'red',
        });
        return false;
      }

      let room_selected_count = 0
      const inputCheckJs = document.querySelectorAll('.input-check-js');

      inputCheckJs.forEach(checkbox => {
        if(checkbox.checked) {
          room_selected_count = room_selected_count +1 ;
        }
      });
      if((change_type_room == 'multiple_room' && room_selected_count == 0 )||( change_type_room == 'one_room' &&  !$('.description-room-item button.active').data('room'))) {
        $.alert({
          title :'افزودن تغییرات هتل',
          text: 'هیج اتاقی انتخاب نشده است',
          icon: 'fa fa-trash',
          content: 'خطا در انتخاب اتاق ها لطفا مجدد تلاش کنید  ',
          rtl: true,
          type: 'red',
        });
        return false;
      }

      if(type_data && roomPlus ){
        $('#loading').show();
        btnRegistration.style.display='none';
        $.ajax({
          type: "POST",
          url: amadeusPath + "ajax",
          dataType: "json",
          data: JSON.stringify({
            method: "updateRoomPriceData",
            className: "reservationHotel",
            hotel_id : $('#hotel_id').val(),
            rooms_selected : rooms_selected,
            from_date : $("#from_date").val(),
            end_date : $("#end_date").val(),
            change_type :roomPlus ,
            change_data  : type_data ,
            weekDays : weekDays ,
            days : selected_days ,
            type : selectedRadio
          }),
          success: function (response) {
            $('#loading').hide();
            btnRegistration.style.display='block';
            let data_response = JSON.parse(JSON.stringify(response))
            if (data_response.success) {

              setTimeout(function(){
                getWeekData('today');
                emptyFrom();
                let check_all_room = document.getElementById("checkAllRooms")
                check_all_room.setAttribute("checked" , 'false');
                let requestType =  document.querySelector('.parent-request-type');
                requestType.style.display = 'none';
                popup.classList.add('hidden');
                popup.classList.remove('active');
              }, 1000);

            }
            else {
              $.alert({
                title :'افزودن تغییرات هتل',
                text: 'خطا در انتخاب اتاق ها لطفا مجدد تلاش کنید  ',
                icon: 'fa fa-trash',
                content: 'خطا در انتخاب اتاق ها لطفا مجدد تلاش کنید  ',
                rtl: true,
                type: 'red',
              });
            }
          },
        })
      }
      else{
        $.alert({
          title :'افزودن تغییرات هتل',
          text: 'اطلاعات ناقص هستید یا هیچ اتاقی انتخاب نشده',
          icon: 'fa fa-trash',
          content: 'خطا در انتخاب اتاق ها لطفا مجدد تلاش کنید  ',
          rtl: true,
          type: 'red',
        });
        return false;

      }
    },
    invalidHandler: function(event, validator) {
      // This prevents the form from submitting on invalid fields
      event.preventDefault();
    }
  });
// گرفتن المان‌های سفارشی
  let customPopup1 = document.getElementById("customPopup");
  let customBtn = document.getElementById("customPopupBtn");
  let customCloseBtn = document.getElementsByClassName("custom-close-btn")[0];

  if(customBtn) {
    // وقتی روی دکمه سفارشی کلیک می‌شود، پاپ‌آپ باز شود
    customBtn.onclick = function() {
      customPopup1.style.display = "flex";
    }
  }

  if(customCloseBtn) {
// وقتی روی دکمه بستن کلیک می‌شود، پاپ‌آپ بسته شود
    customCloseBtn.onclick = function() {
      customPopup1.style.display = "none";
    }
  }

// اگر بیرون از پاپ‌آپ کلیک شود، پاپ‌آپ بسته شود
  window.onclick = function(event) {
    if (event.target == customPopup1) {
      customPopup1.style.display = "none";
    }
  }
})

let customPopup = document.getElementById("customPopup");

// اگر بیرون از پاپ‌آپ کلیک شود، پاپ‌آپ بسته شود
window.onclick = function(event) {
  if (event.target == customPopup) {
    customPopup.style.display = "none";
  }
}
function setChartData(type){
  let hotel_id  = $('#hotel_id').val()
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "getUserReservationHotelInfo",
      className: "reservationHotel",
      hotel_id : hotel_id,
      type : type
    }),
    success: function (response) {
      let data_response = JSON.parse(JSON.stringify(response))
      let sidebar = data_response['sidebar']
      let chart = data_response['chart']
      $('.total_count').html(sidebar.total)
      $('.available_count').html(sidebar.available)
      $('.reserved_count').html(sidebar.booked)
      let newData = [] ;
      let roomList = [] ;
      let availableList = [] ;
      let bookList = [] ;
      let totalList = [] ;
      if(type == 'today') {
        $(`.tomorrowRadio`).removeClass('btn-primary')
        $(`.weekRadio`).removeClass('btn-primary')
      }else if(type == 'tomorrow') {
        $(`.todayRadio`).removeClass('btn-primary')
        $(`.weekRadio`).removeClass('btn-primary')
      }else{
        $(`.tomorrowRadio`).removeClass('btn-primary')
        $(`.todayRadio`).removeClass('btn-primary')
      }
      $(`.${type}Radio`).removeClass('btn-glass-secondary')
      $(`.${type}Radio`).addClass('btn-primary')

      for (let i = 0; i < chart.length; ++i) {
        // newData.push({
        //   name: chart[i].title	,
        //   color: '#f5f5f5'	,
        //   y: chart[i].available,
        //   booked: chart[i].booked		,
        //   available: chart[i].available	,
        //   total: chart[i].total		,
        // })
        roomList[i] = chart[i].title;
        availableList[i] = chart[i].available;
        bookList[i] = chart[i].booked;
        totalList[i] = chart[i].total;
      }


      Highcharts.chart('container', {
        chart: {
          type: 'column'
        },
        title: {
          text: ''  // Set the title text to an empty string to remove it
        },
        xAxis: {
          categories: roomList  // Two categories: Room1 and Room2
        },
        yAxis: {
          title: {
            text: 'ظرفیت اتاق'
          }
        },
        credits: {
           enabled: false
        },
        exporting: {
          enabled: false
        },
        legend: {
          enabled: false  // Disable the legend
        },
        plotOptions: {
          column: {
            stacking: 'normal',
            states: {
              hover: {
                enabled: false  // Disable hover effect
              }
            }
          }
        },
        tooltip: {
          formatter: function () {
            // Get the reserved and available counts
            const reserved = this.points[0].y;
            const available = this.points[1].y;

            return '<b>' + this.x + '</b><br/>' +
              'ظرفیت اتاق: ' + (reserved + available) + '<br/>' +
              'موجود: ' + reserved + '<br/>' +
              'رزرو شده: ' + available ;  // Display total for clarity
          },
          shared: true  // Enable shared tooltip for all points in a category
        },
        series: [
          {
          data: availableList,  // Room1: 1 reserved, Room2: 2 reserved
          color: 'lightgray'
        },{
          data: bookList,  // Room1: 14 available, Room2: 13 available
          color: 'red'
        }]
      });
    },
  })
}

function FillComboCity(Country, ComboCity){

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      Country: Country,
      ComboCity: ComboCity,
      flag: "FillComboCountry"
    },
    function (data) {

      $( "#" + ComboCity).html(data);

    })

}

function FillComboRegion(City, ComboRegion){

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      City: City,
      ComboRegion: ComboRegion,
      flag: "FillComboCity"
    },
    function (data) {

      $( "#" + ComboRegion).html(data);

    })

}

function logical_deletion(id, tableName) {
  $.confirm({
    theme: 'supervan' ,// 'material', 'bootstrap'
    title: 'حذف تغییرات',
    icon: 'fa fa-trash',
    content: 'آیا از حذف تغییرات اطمینان دارید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function () {
          $.post(amadeusPath + 'hotel_ajax.php',
            {
              id: id,
              tableName: tableName,
              flag: 'logicalDeletion'
            },
            function (data) {

              var res = data.split(':');

              if (data.indexOf('success') > -1)
              {
                $.alert({
                  title :'افزودن تغییرات هتل',
                  text: res[1],
                  icon: 'fa fa-trash',
                  content: res[1],
                  rtl: true,
                  type: 'red',
                });

                setTimeout(function () {
                  location.reload();
                }, 1000);

              }else {
                $.alert({
                  title :'افزودن تغییرات هتل',
                  text: res[1],
                  icon: 'fa fa-trash',
                  content: res[1],
                  rtl: true,
                  type: 'red',
                });

              }

            });
        }
      },
      cancel: {
        text: 'انصراف',
        btnClass: 'btn-orange'
      }
    }
  });
}

function getUserHotelBoolList(){
  let hotel_id  = $('#hotel_id').val()
  if(!$('.table-responsive').hasClass('d-none')){
    $('.table-responsive').addClass('d-none')
  }
  if($('.loading').hasClass('d-none')){
    $('.loading').removeClass('d-none')
  }
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "getUserReservationHotelBook",
      className: "reservationHotel",
      hotel_id : hotel_id,
      date_type : $('#date_type').val(),
      startDate : $('#startDate').val(),
      endDate : $('#endDate').val(),
      factorNumber : $('#factorNumber').val(),
      statusGroup : $('#statusGroup').val(),
      passengerName : $('#passengerName').val(),
    }),
    success: function (data) {
      $('.table-responsive').removeClass('d-none')
      $('.loading').addClass('d-none')
      let book_table = $('#booking').DataTable();
      book_table.clear().draw();
      // memberResultSearch.innerHTML = "";
      let jsonData = JSON.parse(JSON.stringify(data))

      if(jsonData){

        if(jsonData.length>0){

          $.each(jsonData, function (index, item) {
            let status = `<span style='color:${item.status_color}'>${item.status}</span>`
            let button = `<button class='btn btn-bookings' onclick="openBookingDetail('${item.factor_number}')">جزییات</button>`
            if(item.status_main == 'OnRequest'){
              button = button + `<a onclick="newConfirmationHotelReserve('${item.factor_number}');return false" title="مشاهده اطلاعات خرید">
                                    <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-check" data-toggle="tooltip" data-placement="top" title="" data-original-title="تایید رزرو">
                                    </i>
                                </a>
                                <a onclick="cancelHotelReservation('${item.factor_number}');return false" title="مشاهده اطلاعات خرید">
                                    <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times " data-toggle="tooltip" data-placement="top" title="" data-original-title="لغو درخواست">
                                    </i>
                                </a>` ;
            }
            book_table.row.add( [
              item.factor_number+'<br>'+'<span>'+item.serviceTitle+'</span>',
              item.passenger_name+'<br>'+item.room,
              item.start_date,
              item.end_date,
              item.updated_at,
              status,
              button,
            ] ).draw( false );
          })
        }
        else {
          book_table.clear().draw();
        }
      }
      else {
        book_table.clear().draw();
      }
    }
  });
}

function openBookingDetail(factor_number) {
  let hotel_id  = $('#hotel_id').val()
  customPopup.style.display = "flex";
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "getUserReservationHotelBookDetail",
      className: "reservationHotel",
      hotel_id : hotel_id,
      factor_number : factor_number
    }),
    success: function (data) {
      $('#customPopup').html('')

      let jsonData = JSON.parse(JSON.stringify(data))

      if(jsonData) {
          let result = `<div class="custom-popup-content">
            <div class="custom-popup-title">
                <h3>جزئیات رزرو</h3>
                <span class="custom-close-btn" onclick='closePopUp()'>&times;</span>
            </div>
            <div class="custom-popup-root">`;
            if(jsonData.status_main == 'BookedSuccessfully') {
              result = result+`<div class="history-sidebar">
                    <a href="${jsonData.voucher_link}" class="btn">مشاهده رزرونامه</a>
                    <div class="history-timeline">
                        <div class="timeline-header">تاریخچه وضعیت رزرو</div>
                        <button type="button" class="btn timeline-item ">
                            <div class="title">تایید رزرو</div>
                            <div class="date" dir="auto">${jsonData.reservationDate}</div>
                        </button>
                    </div>
                </div>`;
            }

        result = result+`    <div class="history-detail">
                    <div class="date-summary">
                        <div class="date-summary-items">
                            <div class="title-history-detail">تاربخ ورود</div>
                            <h3>${jsonData.startDate}</h3>
                        </div>
                        <div class="date-summary-items">
                            <div class="title-history-detail">تاربخ خروج</div>
                            <h3>${jsonData.endDate}</h3>
                        </div>
                        <div class="date-summary-items">
                            <div class="title-history-detail">مدت اقامت</div>
                            <h3>${jsonData.night_count} شب</h3>
                        </div>
                    </div>
                    <div class="reservation-summary">
                        <div class="reservation-summary-items">
                            <div class="col">
                                <div class="box-reservation-summary">
                                    <div class="title-history-detail">نام رزروکننده</div>
                                    <h3>${jsonData.leader_name}</h3>
                                </div>
                                <div class="box-reservation-summary">
                                    <div class="title-history-detail">شماره رزرو</div>
                                    <h3>${jsonData.pnr}</h3>
                                </div>
                                <div class="box-reservation-summary">
                                    <div class="title-history-detail">مرجع رزرو</div>
                                    <h3>هتلاتو</h3>
                                </div>
                            </div>
                            <div class="col">
                                <div class="box-reservation-summary">
                                    <div class="title-history-detail">وضعیت</div>
                                    <h3 class="status-msg">${jsonData.status}</h3>
                                </div>
                                <div class="box-reservation-summary">
                                    <div class="title-history-detail">تاریخ ثبت / بروزرسانی</div>
                                    <h3>${jsonData.reservationDate}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-row">
<!--                            <div class="col">-->
<!--                                <div class="box-reservation-summary">-->
<!--                                    <div class="title-history-detail">درخواست ویژه</div>-->
<!--                                    <h3>-</h3>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col">-->
<!--                                <div class="box-reservation-summary">-->
<!--                                    <div class="title-history-detail">پروموشن</div>-->
<!--                                    <h3>-</h3>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="rooms-summary">
                        <div class="title-history-detail">اطلاعات اتاق‌ها</div>
                        <table class="table table-striped table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th class="room-title">اتاق</th>
                                    <th>نام مسافر</th>
                                    <th>سرویس اضافه</th>
                                    <th>کودک</th>
                                </tr>
                            </thead>
                            <tbody>`
        jsonData.book_list.forEach((book) => {
          result = result + `
                                <tr>
                                    <td>${book.roomTitle}</td>
                                    <td>${book.first_name} ${book.last_name}</td>
                                    <td>-</td>
                                    <td>${book.childCount}</td>
                                </tr>`;
        });


        result = result + ` </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>`;

          $('#customPopup').html(result)
      }

    }
  });
}


function getHotelFinancialReport(type = ''){
  let hotel_id  = $('#hotel_id').val()
  if(!$('.table-responsive').hasClass('d-none')){
    $('.table-responsive').addClass('d-none')
  }
  if($('.loading').hasClass('d-none')){
    $('.loading').removeClass('d-none')
  }
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "getHotelFinancialReport",
      className: "reservationHotel",
      hotel_id : hotel_id,
      date_type : $('#date_type').val(),
      startDate : $('#startDate').val(),
      endDate : $('#endDate').val(),
      factorNumber : $('#factorNumber').val(),
      statusGroup : $('#statusGroup').val(),
      passengerName : $('#passengerName').val(),
    }),
    success: function (data) {
      $('.table-responsive').removeClass('d-none')
      $('.loading').addClass('d-none')
      let book_table = $('#booking').DataTable();
      book_table.clear().draw();
      // memberResultSearch.innerHTML = "";
      let jsonData = JSON.parse(JSON.stringify(data))

      if(jsonData){

        if(jsonData.length>0){
          $('.all_reserve_count').html(jsonData.length)
          $.each(jsonData, function (index, item) {
            let invoice_number = ''
            if(item.invoice_number) {
              invoice_number = item.invoice_number
            }
            if(type == 'new') {

              let status = `<span style='color:${item.status_color}' onclick="openBookingDetail('${item.factor_number}')">${item.status_main}</span>`
              let check_box = ` 
 <input class='input-newInvoice' type='checkbox' onchange='setNewInvoices()' id='inputLabel_${item.factor_number}'  name='factor_number_list' value="${item.factor_number}">
 <label class='label-newInvoice' for="inputLabel_${item.factor_number}"></label>
`
              book_table.row.add( [
                check_box,
                item.factor_number,
                item.tracking_code+'<br>'+invoice_number,
                item.passenger_name+'<br>'+item.room,
                item.amount,
                item.start_date,
                item.end_date,
                status
              ] ).draw( false );
            }else{
              let status = `<span style='color:${item.status_color}' onclick="openBookingDetail('${item.factor_number}')">${item.status_main}</span>`
              book_table.row.add( [
                item.factor_number,
                item.tracking_code+'<br>'+invoice_number,
                item.passenger_name+'<br>'+item.room,
                item.amount,
                item.start_date,
                item.end_date,
                status
              ] ).draw( false );
            }

          })
        }
        else {
          book_table.clear().draw();
        }
      }
      else {
        book_table.clear().draw();
      }
    }
  });
}

function getHotelLogList(){
  console.log('sss')
  let hotel_id  = $('#hotel_id').val()
  if(!$('.table-responsive').hasClass('d-none')){
    $('.table-responsive').addClass('d-none')
  }
  if($('.loading').hasClass('d-none')){
    $('.loading').removeClass('d-none')
  }

  let memberResultSearch = document.querySelector(".memberResultSearch")
  memberResultSearch.innerHTML = "";
  memberResultSearch.innerHTML +=`<div class="box-style"><div class="box-style-padding"><div class="loading_css"></div></div></div>`;

  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "getLogData",
      className: "activityLog",
      id : hotel_id,
      type : 'market_place_reservation_hotel',
      startDate : $('#startDate').val(),
      endDate : $('#endDate').val(),
      log_id : $('#log_id').val() ,
      status : $('#statusGroup').val()
    }),
    success: function (data) {
      $('.table-responsive').removeClass('d-none')
      $('.loading').addClass('d-none')
      let book_table = $('#booking').DataTable();
      book_table.clear().draw();
      memberResultSearch.innerHTML = "";
      let jsonData = JSON.parse(JSON.stringify(data))
      console.log(jsonData)
      if(jsonData){

        if(jsonData.length>0){

          $.each(jsonData, function (index, item) {
            memberResultSearch.innerHTML += `
                  <div class="box-style">
                    <div class="box-style-padding">
                        <div class="reserves_card">
                           
                            <div class="reserves_footer">
                                <div>
                                    <h2>
                                        ${item.created_at}
                                        <span>${item.id}</span>
                                    </h2>
                                    <h2>
                                      ${item.detail.tiny_text}
                                    </h2>
                                </div>
                                <button onclick="open_details($(event.currentTarget))">
                                    ${useXmltag("Detail")}
                                    <svg class="down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg>
                                    <svg style="display: none" class="up" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M363.9 330.7c-6.271 6.918-16.39 6.783-22.62 1.188L192 197.5l-149.3 134.4c-6.594 5.877-16.69 5.361-22.62-1.188C14.2 324.1 14.73 314 21.29 308.1l159.1-144c6.125-5.469 15.31-5.469 21.44 0l159.1 144C369.3 314 369.8 324.1 363.9 330.7z"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="details_box h-0">
                            <div class="details_box_header">
                              ${item.user_name} ${item.description}
                            </div>
                           
                        </div>
                    </div>
                </div>
                `;

          })
        }
        else {
          memberResultSearch.innerHTML = `
                <div class="box-style">
                  <div class="box-style-padding">
                    <div class="err404_style mt-4 d-flex justify-content-center align-items-center flex-column">
                        <div class='d-flex justify-content-center'>
                            <img src='${amadeusPath}view/client/assets/images/404-294px.jpg' alt='404'>
                        </div>
                        <h2 class="title">` + useXmltag("Noresult") +`!</h2>
                    </div>
                  </div>
                </div>
              `;
        }
      }
      else {
        memberResultSearch.innerHTML = `
                <div class="box-style">
                  <div class="box-style-padding">
                    <div class="err404_style mt-4 d-flex justify-content-center align-items-center flex-column">
                        <div class='d-flex justify-content-center'>
                            <img src='${amadeusPath}view/client/assets/images/404-294px.jpg' alt='404'>
                        </div>
                        <h2 class="title">` + useXmltag("Noresult") +`!</h2>
                    </div>
                  </div>
                </div>
              `;
      }
    }
  });
}

function getWeekData(type = 'next'){

  let start_date ;
  let selected_calender = false
  if(type == 'next') {
    start_date =  $('#next_start_date').val()
  }else{
    start_date =  $('#previous_start_date').val()
  }
  if(type == 'today') {
    start_date = ''
  }
  if(type == 'calender') {
    start_date =  $('#next_start_date').val()
    selected_calender = true
  }
  $('#market-place-loader').show();
    $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
        method: "getWeekData",
        className: "reservationHotel" ,
        start_date  : start_date ,
        selected_calender : selected_calender ,
        hotel_id : $('#hotel_id').val() ,
      }),
      success: function (data) {
        $('#market-place-loader').hide();
        let jsonData = JSON.parse(JSON.stringify(data))
        jsonData = jsonData.data
        if(jsonData){

          if(jsonData.date_list){
            $('.go_previous').prop("disabled", false);
            setCalenderData(jsonData.date_list);
          }
          if(jsonData.room_list){
            setRoomData(jsonData.room_list);
          }


          const inputs = document.querySelectorAll('.checkbox-btn input[type="checkbox"]');
          inputs.forEach((input) => {
            input.addEventListener('change', (event) => {
              if (event.target.checked) {
                requestType.style.display = 'flex';
              } else {
                requestType.style.display = 'none';
              }
            });
          });


          const descriptionRoomBtn = document.querySelectorAll('.description-room-item button');
          descriptionRoomBtn.forEach((btn) =>{
            btn.addEventListener('click' ,requestTypeItemHandlerBtn )
          })

        }

      }
    });
}

function setCalenderData(date_list) {

  let calender_dates = '' ;

  $('.head-calendar').html('');
  let month_list = '' ;
  if(date_list.month_list.length == 1 ) {
    month_list = date_list.month_list[0]
  }else{
    month_list = date_list.month_list[0] + '-' + date_list.month_list[1]
  }
  calender_dates = `  <div class="room-table-head  first-col current-month">
                        ${month_list}
                    </div>
                    <div class="weekly-info-container">
                        <div class="room-table-content">`;
  $.each(date_list.day_list, function (index, item) {
    let date_class =  ''
    if(index == (date_list.day_list.length - 1 ) ){
      date_class = 'friday'
    }else if(item.active) {
      date_class = 'today'
    }else{
      date_class = 'past-date'
    }
    calender_dates += `<div class="room-table-col ${date_class}">
                                <div class='room-table-head'>
                                    <div class='date-day'>${item.day}</div>
                                    <div class='date-num'>${item.weekday}</div>
                                </div>
                            </div>`;
  })
   calender_dates +=`</div>
                    </div>`;
  $('#next_start_date').val(date_list.next_start_date)
  $('#previous_start_date').val(date_list.previous_start_date)

  if(!date_list.previous_start_date_enable) {
    $('.go_previous').prop("disabled", true);
  }
  $('.head-calendar').append(calender_dates);
}

function setCalenderSelectedDate() {
  let selected_date  = $('#startDate').val() ;
  $('#next_start_date').val(selected_date);
  getWeekData('calender');
}

function setRoomData(room_list) {
  let room_data = ''
  $('.room_list').html('')
  $.each(room_list, function (index, item) {
    let requested_checked = item.show_request == 'yes' ? 'checked' : '';
    room_data  += ` <div class='room-boxes-container'>
                          <div class='title-part card-header p-1'>
                              <div class='parent-check-all-rooms'>
                                  <label for='${item.id}' class='checkbox-btn'>
                                      <input class='input-check-js room_check' id='${item.id}' value='${item.id}' type='checkbox'>
                                      <span></span>
                                      ${item.room_name}
                                  </label>
                                   
                              </div>
                              <div class='parent-check-request'>
                                <label for='show_request_${item.id}'>
                                    <input class='input-check-js room_check' id='show_request_${item.id}' type='checkbox' onchange='setShowRequest(${item.id})' ${requested_checked}>
                                    <span></span>
                                    نمایش برچسب هتل استعلامی
                                </label>
                              </div>
                          </div>
                          <div class='parent-option-box-flex-room'>
                          <div class='option-room'>
                            <div class='mb-3'>
                           
                                <div class='room-table'>
                                    <div class='room-table-col '>
<!--                                        <div data-target='1' class='item-room-col'>-->
<!--                                            <h6>قیمت رقابتی</h6>-->
<!--                                             <div class='description-room-item'>-->
<!--                                                <svg class='custom-tooltip' data-toggle='tooltip' data-placement='top' title='قیمت رقابتی فروش متناسب با نواسانات قیمت رقبا برای این اتاق' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>&lt;!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;&gt;<path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z'/></svg>-->
<!--                                                <span>ریال</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <div data-target='1' class='item-room-col'>
                                            <h6>ظرفیت موجود</h6>
                                            <div class='description-room-item'>
                                                <button type='button' data-value='available' data-room='${item.id}' data-name='${item.room_name}' class=''>
                                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M36.4 360.9L13.4 439 1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1L73 498.6l78.1-23c10.4-3 20.1-8 28.6-14.5l.3 .2 .5-.8c1.4-1.1 2.7-2.2 4-3.3c1.4-1.2 2.7-2.5 4-3.8L492.7 149.3c21.9-21.9 24.6-55.6 8.2-80.5c-2.3-3.5-5.1-6.9-8.2-10L453.3 19.3c-25-25-65.5-25-90.5 0L58.6 323.5c-2.5 2.5-4.9 5.2-7.1 8l-.8 .5 .2 .3c-6.5 8.5-11.4 18.2-14.5 28.6zM383 191L197.4 376.6l-49.6-12.4-12.4-49.6L321 129 383 191zM97 358.9l7.7 31c2.1 8.6 8.9 15.3 17.5 17.5l31 7.7-7.4 11.2c-2.6 1.4-5.3 2.6-8.1 3.4l-23.4 6.9L59.4 452.6l16.1-54.8 6.9-23.4c.8-2.8 2-5.6 3.4-8.1L97 358.9zM315.3 218.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96z'/></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div data-target='2' class='item-room-col'>
                                            <h6>اتاق‌های رزرو شده</h6>
                                           
                                        </div>
                                        <div data-target='3' class='item-room-col'>
                                            <h6>قیمت فروش</h6>
                                              <div class='description-room-item'>
                                                <svg class='custom-tooltip' data-toggle='tooltip' data-placement='top' title='قیمت فروش در همه پلتفرم های اسنپ تریپ' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z'/></svg>
                                                <span>ریال</span>
                                              
                                                <button type='button' data-value='adult_price' data-room='${item.id}' data-name='${item.room_name}' class=''>
                                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M36.4 360.9L13.4 439 1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1L73 498.6l78.1-23c10.4-3 20.1-8 28.6-14.5l.3 .2 .5-.8c1.4-1.1 2.7-2.2 4-3.3c1.4-1.2 2.7-2.5 4-3.8L492.7 149.3c21.9-21.9 24.6-55.6 8.2-80.5c-2.3-3.5-5.1-6.9-8.2-10L453.3 19.3c-25-25-65.5-25-90.5 0L58.6 323.5c-2.5 2.5-4.9 5.2-7.1 8l-.8 .5 .2 .3c-6.5 8.5-11.4 18.2-14.5 28.6zM383 191L197.4 376.6l-49.6-12.4-12.4-49.6L321 129 383 191zM97 358.9l7.7 31c2.1 8.6 8.9 15.3 17.5 17.5l31 7.7-7.4 11.2c-2.6 1.4-5.3 2.6-8.1 3.4l-23.4 6.9L59.4 452.6l16.1-54.8 6.9-23.4c.8-2.8 2-5.6 3.4-8.1L97 358.9zM315.3 218.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96z'/></svg>
                                                </button>
                                            </div>
                                           
                                        </div>
                                        <div data-target='4' class='item-room-col'>
                                            <h6>تخت اضافه</h6>
                                            <div class='description-room-item'>
                                                <button type='button' data-value='extra_bed_price' data-room='${item.id}' data-name='${item.room_name}' class=''>
                                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M36.4 360.9L13.4 439 1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1L73 498.6l78.1-23c10.4-3 20.1-8 28.6-14.5l.3 .2 .5-.8c1.4-1.1 2.7-2.2 4-3.3c1.4-1.2 2.7-2.5 4-3.8L492.7 149.3c21.9-21.9 24.6-55.6 8.2-80.5c-2.3-3.5-5.1-6.9-8.2-10L453.3 19.3c-25-25-65.5-25-90.5 0L58.6 323.5c-2.5 2.5-4.9 5.2-7.1 8l-.8 .5 .2 .3c-6.5 8.5-11.4 18.2-14.5 28.6zM383 191L197.4 376.6l-49.6-12.4-12.4-49.6L321 129 383 191zM97 358.9l7.7 31c2.1 8.6 8.9 15.3 17.5 17.5l31 7.7-7.4 11.2c-2.6 1.4-5.3 2.6-8.1 3.4l-23.4 6.9L59.4 452.6l16.1-54.8 6.9-23.4c.8-2.8 2-5.6 3.4-8.1L97 358.9zM315.3 218.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96z'/></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div data-target='5' class='item-room-col'>
                                            <h6>اقامت کودک</h6>
                                            <div class='description-room-item'>
                                                <span>ریال</span>
                                                <button type='button'  data-value='child_price' data-room='${item.id}' data-name='${item.room_name}' class=''> 
                                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M36.4 360.9L13.4 439 1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1L73 498.6l78.1-23c10.4-3 20.1-8 28.6-14.5l.3 .2 .5-.8c1.4-1.1 2.7-2.2 4-3.3c1.4-1.2 2.7-2.5 4-3.8L492.7 149.3c21.9-21.9 24.6-55.6 8.2-80.5c-2.3-3.5-5.1-6.9-8.2-10L453.3 19.3c-25-25-65.5-25-90.5 0L58.6 323.5c-2.5 2.5-4.9 5.2-7.1 8l-.8 .5 .2 .3c-6.5 8.5-11.4 18.2-14.5 28.6zM383 191L197.4 376.6l-49.6-12.4-12.4-49.6L321 129 383 191zM97 358.9l7.7 31c2.1 8.6 8.9 15.3 17.5 17.5l31 7.7-7.4 11.2c-2.6 1.4-5.3 2.6-8.1 3.4l-23.4 6.9L59.4 452.6l16.1-54.8 6.9-23.4c.8-2.8 2-5.6 3.4-8.1L97 358.9zM315.3 218.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96z'/></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div data-target='6' class='item-room-col'>
                                            <h6>تخفیف</h6>
                                            <div class='description-room-item'>
                                                <span>%</span>
                                                <button type='button'  data-value='discount' data-room='${item.id}' data-name='${item.room_name}' class=''> 
                                                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M36.4 360.9L13.4 439 1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1L73 498.6l78.1-23c10.4-3 20.1-8 28.6-14.5l.3 .2 .5-.8c1.4-1.1 2.7-2.2 4-3.3c1.4-1.2 2.7-2.5 4-3.8L492.7 149.3c21.9-21.9 24.6-55.6 8.2-80.5c-2.3-3.5-5.1-6.9-8.2-10L453.3 19.3c-25-25-65.5-25-90.5 0L58.6 323.5c-2.5 2.5-4.9 5.2-7.1 8l-.8 .5 .2 .3c-6.5 8.5-11.4 18.2-14.5 28.6zM383 191L197.4 376.6l-49.6-12.4-12.4-49.6L321 129 383 191zM97 358.9l7.7 31c2.1 8.6 8.9 15.3 17.5 17.5l31 7.7-7.4 11.2c-2.6 1.4-5.3 2.6-8.1 3.4l-23.4 6.9L59.4 452.6l16.1-54.8 6.9-23.4c.8-2.8 2-5.6 3.4-8.1L97 358.9zM315.3 218.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96z'/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='box-room'>
                            
                        `;
    $.each(item.weekly_info , function (index, room) {
      let class_name  = ''
      room_data += `             <div class='room-table-col'>
                                        
                                        <div data-target='1' class='room-item-table'>`;
      if(room.is_past) {
        room_data += `                         <span>${room.availableRooms}</span>`;
      }else {
        if(room.availableRooms == 0 ) {
          class_name = 'has_zero_value'
        }
        room_data += `                         <span><input type='text' class='${class_name}' value='${room.availableRooms}' name='available'
                                                  data-room='${item.id}' data-date='${room.date}' data-change='available' onInput='changeInputData(this)'></span>`;
      }
      room_data += `
                                        </div>
                                        <div data-target='2' class='room-item-table'>`;
      if(!room.bookedRooms) {
        room_data += `             <span>-</span>`;
      }else {
        room_data += `             <span>${room.bookedRooms}</span>`;
      }
      room_data += `               </div>
                                        <div data-target='3' class='room-item-table'>`;
      class_name  = ''
      if(room.is_past) {
        room_data += `                         <span>${room.boardPrice}</span>`;
      }else {
        if(room.boardPrice == 0 ) {
          class_name = 'has_zero_value'
        }
        room_data += `                         <span><input type='text' class='${class_name}' value='${room.boardPrice}' name='boardPrice' 
                                                      data-room='${item.id}' data-date='${room.date}' data-change='adult_price' onInput='changeInputData(this)'></span>`;
      }
      room_data += `
                                        </div>
                                        <div data-target='4' class='room-item-table'>`;
      class_name  = ''
      if(room.is_past) {
        room_data += `                         <span>${room.extraBedPrice}</span>`;
      }else {
        if(room.extraBedPrice == 0 ) {
          class_name = 'has_zero_value'
        }
        room_data += `                         <span><input type='text' class='${class_name}' value='${room.extraBedPrice}' name='extra_bed_price' 
                                                      data-room='${item.id}' data-date='${room.date}' data-change='extra_bed_price' onInput='changeInputData(this)'></span>`;
      }
      room_data += `
                                        </div>
                                        <div data-target='5' class='room-item-table'>`;
      class_name  = ''
      if(room.is_past) {
        room_data += `                         <span>${room.childPrice}</span>`;
      }else {
        if(room.childPrice == 0 ) {
          class_name = 'has_zero_value'
        }
        room_data += `                         <span><input type='text' class='${class_name}' value='${room.childPrice}' name='child_price'
                                              data-room='${item.id}' data-date='${room.date}' data-change='child_price' onInput='changeInputData(this)'></span>`;
      }
      room_data += `
                                        </div>
                                         <div data-target='6' class='room-item-table'>`;
      class_name  = ''
      if(room.is_past) {
        room_data += `                         <span>${room.discount}</span>`;
      }else {
        if(room.discount == 0 ) {
          class_name = 'has_zero_value'
        }
        room_data += `                         <span><input type='text' class='${class_name}' value='${room.discount}' name='discount'
                                              data-room='${item.id}' data-date='${room.date}' data-change='discount' onInput='changeInputData(this)'></span>`;
      }
      room_data += `
                                        </div>
<!--                                        <div class='room-item-table'>-->
<!--                                            <span>-</span>-->
<!--                                        </div>-->
<!--                                        <div class='room-item-table'>-->
<!--                                            <span>-</span>-->
<!--                                        </div>-->
<!--                                          <div class='room-item-table'>-->
<!--                                            <span>-</span>-->
<!--                                        </div>-->
                                    </div>`;
    });
    room_data  += `  
                                    
                                </div>
                            </div>
                        </div>
                    </div>`
  });

  $('.room_list').append(room_data)
}

function setPopUpData() {
  $('#change_type_room').val('multiple_room')
  let room_selected_count = 0
  const inputCheckJs = document.querySelectorAll('.input-check-js');

  inputCheckJs.forEach(checkbox => {
    if(checkbox.checked) {
      room_selected_count = room_selected_count +1 ;
    }
  });

  room_selected_count = `تعداد ${room_selected_count} اتاق انتخاب شده است.`
  $('.title-registration').html(room_selected_count)
  let selected_item = $('.dropdown-items ul li.active').text()

  if(selected_item) {
    $('h3.selected_type').html('ویرایش '  + selected_item )
  }
  let selected_type_change = $('.dropdown-items ul li.active').data('value')
  let label_text = ''
  if(selected_type_change == 'available') {
    label_text = 'ظرفیت' ;
  }else if(selected_type_change == 'child_price'){
    label_text = 'قیمت کودک (ریال)'
  }else if(selected_type_change == 'extra_bed_price'){
    label_text = 'قیمت تخت اضافه (ریال)'
  }else if(selected_type_change == 'half_price') {
    label_text = 'هزینه نیم شارژ (ریال)'
  }else if(selected_type_change == 'discount') {
    label_text = 'تخیف'
  }
  $('.selected_type_label').html(label_text)
  $('#roomPlus').attr('name', selected_type_change);
}
function setPopUpButtonData() {
  $('#change_type_room').val('one_room')
  let selected_button = $('.description-room-item button.active')
  let selected_type_change = $('.description-room-item button.active').data('value')

  $('.title-registration').html(selected_button.data('name'))

  let label_text = ''
  if(selected_type_change == 'available') {
    label_text = 'ظرفیت' ;
  }else if(selected_type_change == 'child_price'){
    label_text = 'قیمت کودک (ریال)'
  }else if(selected_type_change == 'extra_bed_price'){
    label_text = 'قیمت تخت اضافه (ریال)'
  }else if(selected_type_change == 'half_price') {
    label_text = 'هزینه نیم شارژ (ریال)'
  }else if(selected_type_change == 'discount') {
    label_text = 'تخفیف'
  }
  $('.selected_type_label').html(label_text)
  $('h3.selected_type').html('ویرایش '  + label_text )
  $('#roomPlus').attr('name', selected_type_change);
}

function checkDateSelect() {
  let start_date = $('#from_date').val()
  let end_date = $('#end_date').val()

  if(start_date && end_date) {
    // Create date objects
    let date1 = new Date(start_date);
    let date2 = new Date(end_date); // Calculate the difference in milliseconds
    let differenceInMilliseconds = date2 - date1; // Convert the difference from milliseconds to days
    let differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);
    if(differenceInDays >= 7) {
      let inputs = document.querySelectorAll('.weekday_check input[type="checkbox"]');
      inputs.forEach((input) => {
        input.removeAttribute('disabled');
      });
    }else {
      let inputs = document.querySelectorAll('.weekday_check input[type="checkbox"]');
      inputs.forEach((input) => {
        input.checked = false
        input.setAttribute("checked" , 'false');
        input.setAttribute("disabled" , 'true');
      });
    }
  }

}
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})




const requestType =  document.querySelector('.parent-request-type');
// setTimeout(() => {
//   const inputs = document.querySelectorAll('.checkbox-btn input[type="checkbox"]');
//
//   console.log('ss' , inputs)
//   inputs.forEach((input) => {
//
//     input.addEventListener('change', (event) => {
//       alert('ssss')
//       if (event.target.checked) {
//         requestType.style.display = 'flex';
//       } else {
//         requestType.style.display = 'none';
//       }
//     });
//   });
// }, 5000)




const dropdownHandler = (event) => {
  const dropdownItems = document.querySelector('.dropdown-items');
  dropdownItems.classList.toggle('show-dropdown');
  setPopUpData();
  event.stopPropagation();
}

requestType.addEventListener('click', dropdownHandler);

document.body.addEventListener('click', (event) => {
  const dropdownItems = document.querySelector('.dropdown-items');

  if (dropdownItems.classList.contains('show-dropdown')) {
    dropdownItems.classList.remove('show-dropdown');
  }
});



const requestTypeItem = document.querySelectorAll('.dropdown-items ul li');
const popup = document.querySelector('.parent-request-type-popup');
const closeBtn = document.querySelector('.parent-request-type-popup .close-btn');

const requestTypeItemHandler = (event) => {
  const actionsSelectTitle = document.querySelector('.actions-select h5');
  actionsSelectTitle.innerText = event.target.innerText;
  requestTypeItem.forEach((item) => {
    item.classList.remove('active')
  });
  event.target.classList.add('active')
  // نمایش پاپ‌آپ
  popup.classList.remove('hidden');
  document.documentElement.style.overflowY = 'hidden';

}


requestTypeItem.forEach((item) => {
  item.addEventListener('click', requestTypeItemHandler);
});



// بسته شدن پاپ‌آپ
closeBtn.addEventListener('click', () => {
  popup.classList.add('hidden');
  document.documentElement.style.overflowY = '';
});

// بستن پاپ‌آپ وقتی کاربر خارج از آن کلیک می‌کند
window.addEventListener('click', (event) => {
  if (event.target === popup) {
    popup.classList.add('hidden');
    document.documentElement.style.overflowY = '';
  }
});







const checkAllRooms = document.getElementById('checkAllRooms');

const checkAllRoomsHandler = (input) => {
  const inputCheckJs = document.querySelectorAll('.input-check-js');

  inputCheckJs.forEach(checkbox => {
    checkbox.checked = input.checked;
  });
}

checkAllRooms.addEventListener('change', function() {
  checkAllRoomsHandler(this);
});


// const mobileFilter = document.querySelector('.parent-mobile-filter');
//
// const mobilFilterHandler = () =>{
//
//   const mobileFilterDrop = document.querySelector('.mobile-filter-drop');
//   const titleFilterDrop = document.querySelector('.parent-mobile-filter h5');
//   const mobileFilterDropLi = document.querySelectorAll('.mobile-filter-drop li');
//
//   mobileFilterDropLi.forEach(li =>{
//     li.addEventListener('click', () => {
//       titleFilterDrop.innerText = li.innerText;
//     });
//   })
//   mobileFilterDrop.classList.toggle('show-dropdown');
//   document.body.style.overflow = mobileFilterDrop.classList.contains('show-dropdown')? 'hidden' : '';
// }
//
// const descriptionRoomBtn = document.querySelectorAll('.description-room-item button');
// mobileFilter.addEventListener('click' , mobilFilterHandler);

const descriptionRoomBtn = document.querySelectorAll('.description-room-item');
const requestTypeItemHandlerBtn = (event) => {
  descriptionRoomBtn.forEach((item) => {
    item.classList.remove('active');
  });
  event.currentTarget.classList.add('active');
  setPopUpButtonData();
  popup.classList.remove('hidden');
  document.body.style.overflow= 'hidden' ;
}
var typingTimers = {}; // تایمرها برای هر ورودی
var requestSentFlags = {}; // وضعیت ارسال درخواست برای هر ورودی
var doneTypingInterval = 500;

function changeInputData(event) {
  var inputId = event.id;
  var inputValue = event.value;

  clearTimeout(typingTimers[inputId]);
  requestSentFlags[inputId] = false;

  // تنظیم تایمر جدید
  typingTimers[inputId] = setTimeout(function() {
    doneTyping(event);
  }, doneTypingInterval);
}

function doneTyping(event) {

    let data = event.dataset
    let rooms_selected = [] ;
    rooms_selected.push(data.room)

    $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
        method: "updateRoomPriceData",
        className: "reservationHotel",
        hotel_id : $('#hotel_id').val(),
        rooms_selected : rooms_selected,
        from_date : data.date,
        end_date : data.date,
        change_type :data.change ,
        change_data  : event.value
      }),
      success: function (response) {
        let data_response = JSON.parse(JSON.stringify(response))
        if (data_response.success) {

          setTimeout(function(){
            getWeekData('today');
            emptyForm();
          }, 1000);

        }
        else {
          $.alert({
            title :'افزودن تغییرات هتل',
            text: res[1],
            icon: 'fa fa-trash',
            content: res[1],
            rtl: true,
            type: 'red',
          });
        }
      },
    })
}

function open_details(event){

  event.parent().parent().parent().children('.details_box').toggleClass('active')
}

function openBox(event) {
    if(event.value == 'time') {
      $('.time_box').addClass('d-block')
      $('.time_box').removeClass('d-none')
      $('.monthly_box').addClass('d-none')
      $('.monthly_box').removeClass('d-block')
    }else{
      $('.monthly_box').addClass('d-block')
      $('.monthly_box').removeClass('d-none')
      $('.time_box').addClass('d-none')
      $('.time_box').removeClass('d-block')
    }
}

$(function() {
  // Array to hold selected dates
  var selectedDates = [];
  let selected_date_result = document.querySelector(".selected-date-card-wrapper")

  function updateSelectedDates() {
    // Clear the selected dates container
    let date_selected_html = ''
    selected_date_result.innerHTML = ""
    $.each(selectedDates, function (index, item) {
      date_selected_html += `
          <div class="selected-date-card d-flex align-items-center justify-content-between close_item"
          data-value='${item}'>
            ${item}
            <input type='hidden' name='dateArray[]' id='dateArray' value='${item}'>
            <i class="fa fa-times" ></i>
          </div>`
    })
    selected_date_result.innerHTML = date_selected_html

    // Add click event listener to unselect date when clicked
    $(".close_item").click(function() {
      var date = $(this).attr("data-value");
      const index = selectedDates.indexOf(date);
      if (index > -1) { // only splice array when item is found
        selectedDates.splice(index, 1); // 2nd parameter means remove one item only
      }
      let date_selected_html = ''
      selected_date_result.innerHTML = ""
      $.each(selectedDates, function (index, item) {
        date_selected_html += `
          <div class="selected-date-card d-flex align-items-center justify-content-between">
            ${item}
            <input type='hidden' name='dateArray[]' id='dateArray' value='${item}'>
            <i class="fa fa-times colse_item" data-value='${item}'></i>
          </div>`
      })
      selected_date_result.innerHTML = date_selected_html

      $("#datepicker").datepicker('refresh');
      updateSelectedDates();

    });
  }

  // Initialize Datepicker with inline display
  $("#datepicker").datepicker({
    inline: true, // This makes the datepicker always visible
    beforeShowDay: function(date) {
      // Format date to YYYY-MM-DD
      var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);

      // Highlight selected dates
      if (selectedDates.indexOf(dateString) !== -1) {
        return [true, "ui-state-highlight"];  // Apply class to highlight
      }
      return [true, ""];
    },
    onSelect: function(dateText) {
      // Add or remove selected dates
      var index = selectedDates.indexOf(dateText);
      if (index === -1) {
        selectedDates.push(dateText);  // Add date
      } else {
        selectedDates.splice(index, 1);  // Remove date
      }


      // Refresh the Datepicker to apply changes
      $(this).datepicker('refresh');
      updateSelectedDates();
    }
  });

});



function getHotelInvoiceList(){
  let hotel_id  = $('#hotel_id').val()
  if(!$('.table-responsive').hasClass('d-none')){
    $('.table-responsive').addClass('d-none')
  }
  if($('.loading').hasClass('d-none')){
    $('.loading').removeClass('d-none')
  }
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "getHotelInvoiceData",
      className: "invoice",
      hotel_id : hotel_id,
      status : $('#status').val(),
      tracing_code : $('#tracing_code').val(),
    }),
    success: function (data) {
      $('.table-responsive').removeClass('d-none')
      $('.loading').addClass('d-none')
      let book_table = $('#booking').DataTable();
      book_table.clear().draw();
      // memberResultSearch.innerHTML = "";
      let jsonData = JSON.parse(JSON.stringify(data))
      if(jsonData){

        if(jsonData.length>0){

          $.each(jsonData, function (index, item) {
            let status = `<span style='color:${item.status_color}'>${item.status}</span>`
            let payed = ''  ;
            if(item.status_main == 'payed'){
              payed = `<a class='btn btn-bookings' target='_blank' href='/gds/pdf&target=invoice&id=${item.factor_number}'>دریافت رسید</a>` ;
            }
            let invoice_id = `<a target='_blank' href='/gds/pdf&target=invoice&id=${item.tracking_code}&cash=true'>${item.tracking_code}</a>` ;
            let button =
            book_table.row.add( [
              invoice_id,
              item.user,
              item.created_at,
              item.book_count,
              item.amount,
              status,

              `
<div class='parent-btn-excel'>
        ${payed}
                <button class='btn btn-bookings'  onclick="createInvoiceExcel('${item.tracking_code}')" >دریافت اکسل</button>
</div>
`,
            ] ).draw( false );
          })
        }
        else {
          book_table.clear().draw();
        }
      }
      else {
        book_table.clear().draw();
      }
    }
  });
}
function createInvoiceExcel(invoice_id){
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "createExcelFile",
      className: "invoice",
      invoice_id : invoice_id,
    }),
    success: function (data) {
      let jsonData = JSON.parse(JSON.stringify(data))
      if(jsonData){

        var url = amadeusPath + 'pic/excelFile/' + jsonData.excel_file;
        console.log(url)
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


      }
      else {

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





function showSelectHotel() {
  const parentSidebarUser = document.querySelector('.parent-sidebar-user');
  const selectHotel = document.querySelector('.select-hotel');
  const hotelNameSuperAdminSvg = document.querySelector('.hotel-name-super-admin svg');
  selectHotel.classList.toggle('show-select-hotel');
  hotelNameSuperAdminSvg.classList.toggle('rotate-select-hotel-svg');
}

// parentSidebarUser.addEventListener('click' , function() {
//   selectHotel.classList.toggle('show-select-hotel');
//   hotelNameSuperAdminSvg.classList.toggle('rotate-select-hotel-svg');
// });
// selectHotel.addEventListener('click', function(e) {
//   e.stopPropagation();
// })

function closePopUp(){
  customPopup.style.display = "none";
}
function deleteRole(user_role_id) {
  $.confirm({
    theme: 'supervan' ,// 'material', 'bootstrap'
    title: 'حذف نقش',
    icon: 'fa fa-trash',
    content: 'آیا از حذف نقش اطمینان دارید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function() {
          $.ajax({
            type: "POST",
            url: amadeusPath + "ajax",
            dataType: "json",
            data: JSON.stringify({
              method: "deleteRole",
              className: "userRole",
              item_id : user_role_id
            }),
            success: function (response) {
              let data_response = JSON.parse(JSON.stringify(response))
              console.log(data_response)
              if (data_response.status == 'success') {
                $.alert({
                  title :"حذف کاربر",
                  text: 'کاریر با موفقیت حذف شد.',
                  icon: 'fa fa-trash',
                  content: 'اطلاعات با موفقیت ثبت شد.',
                  rtl: true,
                  type: 'red'
                })

                setTimeout(function(){
                  location.reload();
                }, 1000);
              }
            },
            error: function (error) {
              $.alert({
                title :"حذف کاربر",
                text: error.responseJSON.message,
                icon: 'fa fa-trash',
                content: error.responseJSON.message,
                rtl: true,
                type: 'red'
              })
            }
          })
        },
        cancel: {
          text: 'انصراف',
          btnClass: 'btn-orange'
        }
      }
    }
  });
}
// اگر بیرون از پاپ‌آپ کلیک شود، پاپ‌آپ بسته شود
window.onclick = function(event) {
  if (event.target == customPopup) {
    customPopup.style.display = "none";
  }
}



// کدهای مختص  نمایش بر اساس ظرفیت و قیمت و همه

document.addEventListener('DOMContentLoaded', function() {

  toggleRoomVisibility(['1', '2', '3', '4', '5']);

  const buttons = document.querySelectorAll('.filter-box-btn button');

  buttons.forEach(button => {
    button.addEventListener('click', function() {

      buttons.forEach(btn => btn.classList.remove('active-btn-data'));

      this.classList.add('active-btn-data');

      if (this.classList.contains('priceRoom')) {
        toggleRoomVisibility(['3', '4', '5']);
      } else if (this.classList.contains('capacityRoom')) {
        toggleRoomVisibility(['1', '2']);
      } else if (this.classList.contains('allRoom')) {
        toggleRoomVisibility(['1', '2', '3', '4', '5']);
      }
    });
  });
});

function toggleRoomVisibility(visibleTargets) {
  const roomTableCol = document.querySelectorAll('.room-table-col .item-room-col');
  const tableCol = document.querySelectorAll('.room-table-col .room-item-table');

  roomTableCol.forEach(item => {
    item.style.display = visibleTargets.includes(item.dataset.target) ? 'flex' : 'none';
  });

  tableCol.forEach(table => {
    table.style.display = visibleTargets.includes(table.dataset.target) ? 'flex' : 'none';
  });
}





function newConfirmationHotelReserve(factor_number){
  $.confirm({
    theme: 'supervan' ,// 'material', 'bootstrap'
    title: 'تایید رزرو هتل',
    icon: 'fa fa-check',
    content: 'آیا مطمئن به تائید درخواست هستید؟',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function () {
          $.post(amadeusPath + 'hotel_ajax.php',
            {
              factor_number: factor_number,
              type_application: 'reservation',
              flag: 'newConfirmationHotelReserve'
            },
            function (data) {

              var res = data.split('|');

              if (data.indexOf('success') > -1)
              {

                $.toast({
                  heading: 'تایید رزرو هتل',
                  text: res[1],
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
                });

                setTimeout(function () {
                  location.reload();
                }, 1000);

              } else {

                $('#error-log-response-' + factor_number).html(res[2]).css('color', 'red');
                $('#error-log-response-' + factor_number).parent('td').parent('tr').removeClass('displayN').css('color', 'red');

                $.toast({
                  heading: 'تایید رزرو هتل',
                  text: res[1],
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
      },
      cancel: {
        text: 'انصراف',
        btnClass: 'btn-orange'
      }
    }
  });
}

function cancelHotelReservation(factor_number)
{
  $.confirm({
    theme: 'supervan' ,// 'material', 'bootstrap'
    title: 'کنسل رزرو هتل',
    icon: 'fa fa-trash',
    content: 'آیا از حذف تغییرات اطمینان دارید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function () {
          $.post(amadeusPath + 'hotel_ajax.php',
            {
              factor_number: factor_number,
              type_application: 'reservation',
              flag: 'cancelHotelReservation'
            },
            function (data) {

              var res = data.split(':');

              if (data.indexOf('success') > -1)
              {

                $.toast({
                  heading: 'کنسل رزرو هتل',
                  text: res[1],
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
                });

                setTimeout(function () {
                  location.reload();
                }, 1000);
              } else
              {
                $.toast({
                  heading: 'کنسل رزرو هتل',
                  text: res[1],
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
      },
      cancel: {
        text: 'انصراف',
        btnClass: 'btn-orange',
      }
    }
  });
}

function setUserRoleId(user_role_id){
  let customPopup1 = document.getElementById("customPopup");
  customPopup1.style.display = "flex";
  $('#hotel_role_id').val(user_role_id)
}

function deleteRole(user_role_id) {
  $.confirm({
    theme: 'supervan',// 'material', 'bootstrap'
    title: 'حذف کاربر',
    icon: 'fa fa-trash',
    content: 'آیا از حذف کاربر اطمینان دارید',
    rtl: true,
    closeIcon: true,
    type: 'orange',
    buttons: {
      confirm: {
        text: 'تایید',
        btnClass: 'btn-green',
        action: function() {

          $.ajax({
            type: "POST",
            url: amadeusPath + "ajax",
            dataType: "json",
            data: JSON.stringify({
              method: "deleteRole",
              className: "userRole",
              user_role_id: user_role_id
            }),
            success: function (response) {
              let data_response = JSON.parse(JSON.stringify(response))
              if (data_response.status == 'success') {
                $.alert({
                  title :"حذف کاربر",
                  text: 'اطلاعات با موفقیت حذف شد.',
                  icon: 'fa fa-check',
                  content: 'اطلاعات با موفقیت حذف شد.',
                  rtl: true,
                  type: 'green'
                })

                setTimeout(function(){
                  location.reload();
                }, 1000);
              }
            },
            error: function (error) {
              $.alert({
                title :"حذف کاربر",
                text: error.responseJSON.message,
                icon: 'fa fa-trash',
                content: error.responseJSON.message,
                rtl: true,
                type: 'red'
              })
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
document.getElementById('hotelSearch').addEventListener('keyup', function() {

  let query = this.value.trim(); // ورودی کاربر را دریافت کنید
  let items = document.querySelectorAll('#searchResults a'); // تمام آیتم‌های لیست را بگیرید

  items.forEach(function(item) {
    let hotelName = item.querySelector('h2').textContent; // نام هتل را از هر آیتم دریافت کنید
    if (hotelName.includes(query)) {
      item.classList.add('show'); // اگر نام هتل شامل عبارت جستجو بود، نمایش دهید
    } else {
      item.classList.remove('show'); // در غیر این صورت مخفی کنید
    }
  });
});


function authenticateCheckExistenceValidator(_this) {
  if (!validateMobile(_this.val())) {
    authenticateValidator(
      _this,
      true,
      useXmltag("PleaseEnterValidMobile")
    )
    return false
  }
  authenticateValidator(_this, false)
  return true
}

function authenticateValidator(_this, status = true, message = "") {
  if (status) {
    _this.addClass("is-invalid")
    _this.parent().find(".invalid-feedback").html(message)
  } else {
    _this.removeClass("is-invalid")
    _this.parent().find(".invalid-feedback").html("")
  }
}

function emptyFrom() {
  $('#changeRoomCalender #change_type_room').val('')
  $('#changeRoomCalender  #time').prop('checked', true);
  $('.time_box').addClass('d-block')
  $('.time_box').removeClass('d-none')
  $('.monthly_box').addClass('d-none')
  $('.monthly_box').removeClass('d-block')
  $('#changeRoomCalender #from_date').val('')
  $('#changeRoomCalender #end_date').val('')
  $('#changeRoomCalender #roomPlus').val('')
}

function setShowRequest(room_id){
  $.ajax({
    type: "POST",
    url: amadeusPath + "ajax",
    dataType: "json",
    data: JSON.stringify({
      method: "updateRoomRequested",
      className: "reservationHotel",
      room_id : room_id
    }),
    success: function (response) {
      let data_response = JSON.parse(JSON.stringify(response))

      if (data_response.success == true) {
        $.alert({
          title :"نمایش برچسب هتل استعلامی",
          text: 'با موفقیت بروزرسانی شد.',
          icon: 'fa fa-check',
          content:  'با موفقیت بروزرسانی شد.',
          rtl: true,
          type: 'green'
        })
      }
    },
    error: function (error) {
      $.alert({
        title :"نمایش برچسب هتل استعلامی",
        text: 'خطا در بروزرسانی',
        icon: 'fa fa-trash',
        content: 'خطا در بروزرسانی',
        rtl: true,
        type: 'red'
      })
    }
  })
}

function setNewInvoices() {
  const checkboxes = document.querySelectorAll('.input-newInvoice');

  // Filter the NodeList to only include checked checkboxes
  const checkedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;

  $('.selected_reserve_count').html(checkedCount)
  const button = document.querySelector('.preview-invoice');
  if(checkedCount > 0 ) {
// Remove the 'disabled' attribute
    button.removeAttribute('disabled');
  }else if(checkedCount == 0 ){
    // button.addAttribute('disabled');
  }
}


function setPreviewDataAndRedirectPdf(){


  // انتخاب عناصر پاپ‌آپ
  const openPopupButton = document.getElementById('openPopupButton');
  const popupOverlay = document.getElementById('popupOverlay');
  const closePopupButton = document.getElementById('closePopupButton');


  popupOverlay.style.display = 'flex';
 





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

  $.ajax({
    url: amadeusPath + 'ajax',
    type: 'POST',
    dataType: 'JSON',
    data: JSON.stringify({
      className:'temporaryInvoice',
      method:'setTemporaryInvoice',
        factor_number_list
    }),
    success: function (response) {
      let data_response = JSON.parse(JSON.stringify(response))
      setTimeout(function () {
        $('#preview_factor_number').val(data_response.data.tracking_code)
        document.getElementById('pdfFrame').src = data_response.data.pdf_url;
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

function createFacor() {
  let preview_factor_number = $('#preview_factor_number').val()
  $.ajax({
    url: amadeusPath + 'ajax',
    type: 'POST',
    dataType: 'JSON',
    data: JSON.stringify({
      className:'invoice',
      method:'createInvoiceWithPreview',
      preview_factor_number
    }),
    success: function (response) {
      let data_response = JSON.parse(JSON.stringify(response))
      $.alert({
        title: 'ثبت درخواست فاکتور',
        icon: 'fa fa-check',
        content: response.message,
        rtl: true,
        type: 'green',
      });
      document.getElementById('pdfFrame').src = '';
      setTimeout(function () {
        location.reload();
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





function checkInputAllNewInvoice(){
  $('.input-newInvoice').each(function(){
    $(this).prop("checked", !$(this).prop("checked"));
  });
}


function closepopupOverlay() {
  const popupOverlay = document.getElementById('popupOverlay');
  popupOverlay.style.display = 'none';
}