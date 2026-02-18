
$(document).ready(function () {

    // $('.js-switch').each(function() {
    //     new Switchery($(this)[0], $(this).data());
    // });



    $("#discount_status1").change(function(){
        $('.input-text .textPrice').addClass('requiredPrice');
        $('.input-text .textBoardPrice').removeClass('requiredPrice');

        $('input[type=checkbox]').each(function () {
            if (this.checked) {
                var id = $(this).val();
                $('#comition_hotel'+id).addClass('requiredPrice');
            }
        });

    });

    $("#discount_status2").change(function(){
        $('.input-text .textPrice').addClass('requiredPrice');
        $('.input-text .textBoardPrice').addClass('requiredPrice');
        $('.input-text .textComition').removeClass('requiredPrice');
    });


    ///////اضافه کردن قیمت گذاری اتاق ها//
    $("#FormAddRoomPrice").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            hotel_name: "required",
            start_date: "required",
            end_date: "required",
            discount_status:{ required:true }
        },
        messages: {

            discount_status:
                {
                    required:"لطفا نحوه نمایش قیمت اتاق را انتخاب کنید<br/>"
                }

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

                    console.log(response);
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {

                        $.toast({
                            heading: 'افزودن قیمت اتاق جدید',
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

                        $.toast({
                            heading: 'افزودن قیمت اتاق جدید',
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


    ///////اضافه کردن تور یک روزه//
    $("#FormOneDayTour").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            hotel_name: "required",
            adt_price_rial: "required"
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

                        $(".loaderPublic").css("display","none");

                        $.toast({
                            heading: 'افزودن تور ی روزه جدید',
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

                        $.toast({
                            heading: 'افزودن تور ی روزه جدید',
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


    ///////ویرایش تور یک روزه//
    $("#EditOneDayTour").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            hotel_name: "required",
            adt_price_rial: "required"
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
                            heading: 'افزودن تور ی روزه جدید',
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

                        $.toast({
                            heading: 'افزودن تور ی روزه جدید',
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


    ///////ویرایش قیمت اتق ها//
    $("#editRoomPricesForUser").validate({
        rules: {
            origin_country: "required",
            origin_city: "required",
            hotel_name: "required",
            start_date: "required",
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
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات قیمت اتاق ها',
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

                        $.toast({
                            heading: 'افزودن تغییرات قیمت اتاق ها',
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


    ///////اضافه کردن قیمت اتاق برای هتل در بازه زمانی مشخص//
    $("#FormAddHotelRoomPrices").validate({
        rules: {
            start_date: "required",
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

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    console.log(response);
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {

                        $.toast({
                            heading: 'افزودن قیمت اتاق',
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

                        $.toast({
                            heading: 'افزودن قیمت اتاق',
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

    ///////اضافه کردن قیمت گذاری اتاق هابرای هتل در بازه زمانی مشخص//
    $("#addRoomPricesForUser").validate({
        rules: {
            start_date: "required",
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

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {

                        $.toast({
                            heading: 'افزودن قیمت اتاق جدید',
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

                        $.toast({
                            heading: 'افزودن قیمت اتاق جدید',
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


    $("#FormOrderHotel").validate({
        rules: {
            title:"required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
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

                        setTimeout(function () {
                            location.reload();
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


    $("#FormEditAllHotelRooms").validate({
        rules: {
            maximum_capacity5:"required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
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

                    console.log(response);
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

                        setTimeout(function () {
                            location.reload();
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



    $("#SelectCityForSearch").validate({
        rules: {
            origin_city: 'required',
            service_name: 'required',

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
                url: amadeusPath + 'ajax',
                type: "post",
                success: function (response) {

                    $.toast({
                        heading: 'انتخاب شهر منتخب',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: response.status,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    })
                    if (response.status === 'success') {
                        setTimeout(function() {
                            // location.reload()
                            window.location = `${amadeusPath}itadmin/reservation/citySelectSearch`;
                        }, 1000)
                    }
                },

                error:function(error) {
                    $.toast({
                        heading: 'انتخاب شهر منتخب',
                        text: error.responseJSON.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: error.responseJSON.status,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    })










});




///////نمایش نام هتل براساس انتخاب شهر//
function ShowAllHotel(){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            origin_city: $('#origin_city').val(),
            flag: "ShowAllHotel"
        },
        function (data) {
            if(data.indexOf('null') < 0) {
                var arrHotel = data.split(",");
                $('#hotel_name option').remove();

                var List_option = '<option value="">انتخاب کنید....</option>';
                for (i = 0; i < arrHotel.length; i++) {
                    var arrrecord = arrHotel[i].split("/*/");
                    if (arrrecord[0] != '') {
                        List_option += '<option value="' + arrrecord[0] + '">' + arrrecord[1] + '</option>';
                    }

                }

                $('#hotel_name').html(List_option);
            }

        })


}//end function


///////نمایش نام اتاق ها براساس انتخاب هتل//
function ShowAllHotelRoom(number){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            hotel_name: $('#hotel_name').val(),
            flag: "ShowAllHotelRoom"
        },
        function (data) {

            var arrHotel = data.split(",");
            $('#room_type option').remove();

            var List_option='<option value="">انتخاب کنید....</option>';
            for(i = 0; i < arrHotel.length; i++)
            {
                var arrrecord = arrHotel[i].split("/*/");
                if (arrrecord[0]!=''){
                    List_option+='<option value="'+arrrecord[0]+'">'+arrrecord[1]+'</option>';
                }

            }

            $('#room_type' + number).html(List_option);

        })


}//end function

///////نمایش نام اتاق ها براساس انتخاب هتل//
function ShowCurrency(number){

    $.post(amadeusPath + 'user_ajax.php',
      {
          flag: "ListCurrencyEquivalent"
      },
      function (data) {

          var result =  JSON.parse(data);

          $('#currency_type' + number + ' option').remove();

          var List_currency='<option value="">انتخاب کنید....</option>';

          for(i = 0; i < result.length; i++)
          {

              List_currency+='<option value="'+result[i]['CurrencyCode']+'">'+result[i]['CurrencyTitle']+'</option>';
          }

          $('#currency_type' + number ).html(List_currency);

      })


}//end function


////حذف قیمت اتاق
function deleteRoomPricesForUser(id_city, id_hotel, id_room, user_type, sDate, eDate)
{
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
                            id_city: id_city,
                            id_hotel: id_hotel,
                            id_room: id_room,
                            user_type: user_type,
                            startDate: sDate,
                            endDate: eDate,
                            flag: 'deleteRoomPricesForUser'
                        },
                        function (data) {

                            var res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
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
                                    heading: 'حذف تغییرات',
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


////کنسل درخواست رزرو هتل توسط مدیر
function cancelHotelReservation(factor_number, type_application)
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
                            type_application: type_application,
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

function newConfirmationHotelReserve(factor_number,type_application){
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
                            type_application: type_application,
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

////تااید درخواست رزرو هتل توسط مدیر
function confirmationHotelReservation(factor_number, type_application)
{
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
                            type_application: type_application,
                            flag: 'confirmationHotelReservation'
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


function ajaxCheckOfflineStatus(request_number) {
    $.ajax({
        url : amadeusPath + 'hotel_ajax.php',
        type:'POST',
        dataType: 'JSON',
        data : {
            request_number: request_number,
            flag: 'checkOfflineStatus'
        },
        success : function(data){
            console.log(data);
            if(data.Result.Status == 'pending'){
                $.toast({
                    heading: 'وضعیت رزرو',
                    text: 'وضعیت در انتظار تایید',
                    position: 'top-left',
                    loaderBg: '#fff',
                    icon: 'warning',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            if(data.Result.Status == 'booking'){
                $.toast({
                    heading: 'وضعیت رزرو',
                    text: 'وضعیت رزرو شده',
                    position: 'top-left',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },
        error : function(error){
            console.log(error);
            $.toast({
                heading: 'خطا',
                text: 'خطا در بررسی وضعیت',
                position: 'top-left',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        }
    });
}

////ارسال ایمیل به کارکزار هتل
function sendEmailForHotelBroker(factor_number, hotel_id)
{
    $.post(amadeusPath + 'hotel_ajax.php',
        {
            factor_number: factor_number,
            hotel_id: hotel_id,
            flag: 'sendEmailForHotelBroker'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {

                $.toast({
                    heading: 'ارسال ایمیل به کارگزار هتل',
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
                    heading: 'ارسال ایمیل به کارگزار هتل',
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

function inputRequired(id) {

    var check = $('#chk_user'+id).is(':checked');
    var checkDiscount = $('#discount_status1').is(':checked');

    if (check==true && checkDiscount==true){

        $('#comition_hotel'+id).addClass('requiredPrice');
        $('#maximum_capacity'+id).addClass('requiredPrice');

    }else if (check==true && checkDiscount==false){

        $('#maximum_capacity'+id).addClass('requiredPrice');
        $('#comition_hotel'+id).removeClass('requiredPrice');

    }else {

        $('#comition_hotel'+id).removeClass('requiredPrice');
        $('#maximum_capacity'+id).removeClass('requiredPrice');
    }

}



// ترتیب نمایش هتل ها
function orderHotelActive(id)
{

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            id: id,
            flag: 'orderHotelActive'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'ترتیب نمایش هتل',
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
                    heading: 'ترتیب نمایش هتل',
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


//////////حذف منطقی///////
function deleteRoomPrice(idHotel, id, type)
{
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
                            idHotel: idHotel,
                            id: id,
                            type: type,
                            flag: 'deleteRoomPrice'
                        },
                        function (data) {

                            var res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
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

                            }else {
                                $.toast({
                                    heading: 'حذف تغییرات',
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


////تااید درخواست رزرو هتل توسط مدیر
function allowEditingHotel(factor_number, member_id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'تغییرات هتل',
        icon: 'fa fa-trash',
        content: 'آیا مطمئن به برگرداندن اعتبار و ظرفیت برای ویرایش هتل هستید؟',
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
                            member_id: member_id,
                            flag: 'allowEditingHotel'
                        },
                        function (data) {

                            var res = data.split(':');
                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'ثبت تغییرات',
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
                                    heading: 'ثبت تغییرات',
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
function EditInPlace(Code, Priority)
{
    $('#'+Code + Priority).html('');
    $('#'+Code + Priority).append('<input class="form-control" name="priority'+Code + Priority+'" value="'+ Priority +'" id="priority' + Code + Priority +'" onchange="SendPriority('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')" onblur="hideInput('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')">');
    $('#'+Code + Priority).attr('onclick','return false');

}

function SendPriority(Priority,Code) {

    var PriorityNew = $('#priority' + Code + Priority ).val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            PriorityOld: Priority,
            PriorityNew: PriorityNew,
            CodeDeparture: Code,
            flag: 'ChangePriorityHotel'
        },
        function (data) {
            var res = data.split(':');
            if (data.indexOf('SuccessChangePriority') > -1)
            {

                $.toast({
                    heading: 'تغییر الویت',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                $('#'+Code + Priority).html(PriorityNew);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else
            {
                $.toast({
                    heading: 'تغییر الویت',
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

function isSpecialHotel(id) {

    $.post(amadeusPath + 'hotel_ajax.php',
      {
          id   : id,
          flag : 'isSpecialHotel'
      },
      function (data) {

          var res = data.split(':');
          if (data.indexOf('success') > -1) {
              $.toast({
                  heading: 'هتل ویژه',
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
              $.toast({
                  heading: 'هتل ویژه',
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
function isAcceptHotel(id) {

    $.post(amadeusPath + 'hotel_ajax.php',
      {
          id   : id,
          flag : 'isAcceptHotel'
      },
      function (data) {

          var res = data.split(':');
          if (data.indexOf('success') > -1) {
              $.toast({
                  heading: 'تایید هتل',
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
              $.toast({
                  heading: 'تایید هتل',
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
function showInHome(id) {

    $.post(amadeusPath + 'hotel_ajax.php',
      {
          id   : id,
          flag : 'showHotelAtHome'
      },
      function (data) {

          var res = data.split(':');
          if (data.indexOf('success') > -1) {
              $.toast({
                  heading: 'نمایش هتل در صفحه اول',
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
              $.toast({
                  heading: 'نمایش هتل در صفحه اول',
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



function changeHotelSepehrGlobalId(Code, sepehr_hotel_code)
{
    $('#'+Code + sepehr_hotel_code).html('');
    $('#'+Code + sepehr_hotel_code).append('<input class="form-control" name="sepehr_hotel_code'+Code + sepehr_hotel_code+'" value="'+ sepehr_hotel_code +'" id="sepehr_hotel_code' + Code + sepehr_hotel_code +'" onchange="SendHotelSepehrGlobalId('+"'"+ sepehr_hotel_code+"'"+','+"'"+ Code+"'"+')" onblur="hideInput('+"'"+ sepehr_hotel_code+"'"+','+"'"+ Code+"'"+')">');
    $('#'+Code + sepehr_hotel_code).attr('onclick','return false');

}

function SendHotelSepehrGlobalId(sepehr_hotel_code,Code) {

    var sepehr_hotel_code_new = $('#sepehr_hotel_code' + Code + sepehr_hotel_code ).val();
    $.post(amadeusPath + 'user_ajax.php',
       {
           sepehr_hotel_code_old: sepehr_hotel_code,
           sepehr_hotel_code_new: sepehr_hotel_code_new,
           CodeDeparture: Code,
           flag: 'changeHotelSepehrGlobalId'
       },
       function (data) {
           var res = data.split(':');
           if (data.indexOf('SuccessChangeSpecialSepehr') > -1)
           {

               $.toast({
                   heading: 'شناسه سپهر',
                   text: res[1],
                   position: 'top-right',
                   loaderBg: '#fff',
                   icon: 'success',
                   hideAfter: 3500,
                   textAlign: 'right',
                   stack: 6
               });
               $('#'+Code + sepehr_hotel_code).html(sepehr_hotel_code_new);
               setTimeout(function () {
                   window.location.reload();
               }, 1000);
           } else
           {
               $.toast({
                   heading: 'شناسه سپهر',
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
