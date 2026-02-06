$(document).ready(function () {

    //Add Passenger
    $("#AddPassengerUser, #AddPassengerCounter").validate({
        rules: {
            passengerName: "required",
            passengerFamily: "required",
            passengerNameEn: "required",
            passengerFamilyEn: "required",
            passengerGender: "required",
            passengerNationalCode: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '0';
                    }
                },
                number: true,
                maxlength: 10
            },
            passengerBirthday: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '0';
                    }
                }
            },
            passengerBirthdayEn: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            },
            passengerPassportCountry: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            },
            passengerPassportNumber: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            },
            passengerPassportExpire: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            }
        },
        messages: {},
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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                dataType:'JSON',
                success: function (data) {

                    var backLink = '';
                    if($('#agency_id').length > 0) {
                        backLink = 'passengerListCounter&id=' + $('#memberID').val() + '& agencyID=' + $('#agency_id').val();
                    } else {
                        backLink = 'passengerListUser&id=' + $('#memberID').val();
                    }

                    if (data.result_status == 'success') {

                        $.toast({
                            heading: 'افزودن مسافر جدید',
                            text: data.result_message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = backLink;
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن مسافر جدید',
                            text: data.result_message,
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

    //Edit Passenger
    $("#EditPassengerUser, #EditPassengerCounter").validate({
        rules: {
            passengerName: "required",
            passengerFamily: "required",
            passengerNameEn: "required",
            passengerFamilyEn: "required",
            passengerGender: "required",
            passengerNationalCode: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '0';
                    }
                },
                number: true,
                maxlength: 10
            },
            passengerBirthday: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '0';
                    }
                }
            },
            passengerBirthdayEn: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            },
            passengerPassportCountry: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            },
            passengerPassportNumber: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            },
            passengerPassportExpire: {
                required: {
                    depends: function (element) {
                        return $('#passengerNationality').val() === '1';
                    }
                }
            }
        },
        messages: {},
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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                dataType:'JSON',
                success: function (data) {

                    var backLink = '';
                    // alert(backLink)
                    if($('#agency_id').length > 0) {
                        backLink = 'passengerListCounter&id=' + $('#memberID').val() + '&agencyID=' + $('#agency_id').val();
                    } else {
                        backLink = 'passengerListUser&id=' + $('#memberID').val();
                    }

                    if (data.result_status == 'success') {
                        $.toast({
                            heading: 'ویرایش اطلاعات مسافر',
                            text: data.result_message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            // alert(backLink);
                            // window.location = backLink;
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'ویرایش اطلاعات مسافر',
                            text: data.result_message,
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


function delete_passenger_list(id) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'حذف مسافر ',
        icon: 'fa fa-trash',
        content: 'آیا از حذف مسافر اطمینان دارید؟',
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
                            id: id,
                            flag: 'delete_passenger'
                        },
                        function (data) {
                            var res = data.split(':');

                            if (data.indexOf('success') > -1) {

                                $.toast({
                                    heading: ' حذف مسافر کانتر ',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    $('#del-' + id).remove();

                                }, 1500);
                            } else {
                                $.toast({
                                    heading: ' حذف مسافر کانتر ',
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

function showInput() {
    var type = $('#passengerNationality').val();

    if (type === '1') {
        $('.showInput').fadeIn(500);
        $('.dontShowInput').fadeOut(500);
    } else {
        $('.showInput').fadeOut(500);
        $('.dontShowInput').fadeIn(500);
    }
}
