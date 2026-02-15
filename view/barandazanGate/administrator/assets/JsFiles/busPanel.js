$(document).ready(function () {
    $('.updateInput').on('change', function () {

        let inputName = $(this).attr('name');
        let inputValue = $(this).val();
        let id = $(this).parent('td').parent('tr').attr('id');
        let type = $(this).parent('td').parent('tr').attr('type');
        let city = $(this).parent('td').parent('tr').attr('city');

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data:
              {
                  inputName: inputName,
                  inputValue: inputValue,
                  id: id,
                  type: type,
                  city: city,
                  flag: "updateBusCities"
              },
            success: function (response) {

                if (response){

                    $.toast({
                        heading: 'تغییرات شهر و کشور',
                        text: 'ثبت تغییرات با موفقیت انجام شد.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    setTimeout(function () {
                        // location.reload();
                    }, 200);

                } else {

                    $.toast({
                        heading: 'تغییرات شهر و کشور',
                        text: 'خطا در  تغییرات ...',
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
    });

    //For Upload File
    $('.dropify').dropify();


    $("#formBaseCompaniesBus").validate({
        rules: {
            type_vehicle: "required",
            name_fa: "required",
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
                url: amadeusPath + 'bus_ajax.php',
                type: "post",
                success: function (response) {

                    let res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات',
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

    $("#formBaseCompaniesBusEdit").validate({
        rules: {
            name_fa: "required",
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
                url: amadeusPath + 'bus_ajax.php',
                type: "post",
                success: function (response) {

                    let res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات',
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

    $("#formBusCompanies").validate({
        rules: {
            name_fa: "required"
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
                url: amadeusPath + 'bus_ajax.php',
                type: "post",
                success: function (response) {

                    let res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات',
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

    $('.companyName').change(function () {

        let name_fa = $(this).val();
        let id = $(this).data('id');

        console.log('name_fa', name_fa);
        console.log('id', id);

        $.post(amadeusPath + 'bus_ajax.php',
          {
              flag: 'flagUpdateBusCompany',
              name_fa: name_fa,
              id: id
          },
          function (response) {

              let res = response.split(':');
              if (response.indexOf('success') > -1) {
                  $.toast({
                      heading: 'افزودن تغییرات',
                      text: res[1],
                      position: 'top-right',
                      loaderBg: '#fff',
                      icon: 'success',
                      hideAfter: 3500,
                      textAlign: 'right',
                      stack: 6
                  });

                  setTimeout(function(){
                      location.reload();
                  }, 1000);


              } else {

                  $.toast({
                      heading: 'افزودن تغییرات',
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

    });


    $("#form_station_reservation_bus").validate({
        rules: {
            name_fa: "required",
            station_bus: "required"
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
            let name_fa=$('#name_fa').val()
            let station_bus=$('#station_bus').val()
            $(form).ajaxSubmit({
                type: 'POST',
                url: amadeusPath + 'ajax',
                dataType: 'JSON',
                data:  JSON.stringify({
                    className: 'stationReservationBus',
                    method: 'insertStation',
                    name_fa,
                    station_bus,
                })
                ,
                success: function (response) {

                    let res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات',
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




});


function updateBusCities(thiss){
    var dataName=thiss.attr('data-name');
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'hotel_ajax.php',
        dataType: 'JSON',
        data:
            {
                dataName: dataName,
                dataValue: thiss.val(),
                dataId: thiss.parent().parent().attr('id'),
                flag: "updateBusCities"
            },
        success: function (response) {

                $.toast({
                    heading: response.status,
                    text: response.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: response.status,
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
        }
    });
}

function searchBusCity() {
    let searchInput = $('#search').val();
    if (searchInput.length > 0){
        window.location = 'busCity&search=' + searchInput;
    } else {
        window.location = 'busCity';
    }
}

//////////حذف منطقی///////
function logicalDeletionBusCompany(id, tableName) {
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
                    $.post(amadeusPath + 'bus_ajax.php',
                        {
                            id: id,
                            tableName: tableName,
                            flag: 'flagLogicalDeletion'
                        },
                        function (data) {

                            let res = data.split(':');

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


