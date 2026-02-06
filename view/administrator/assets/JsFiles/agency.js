$(".gradient-colorpicker").asColorPicker({
    mode: 'gradient'
});

$(document).ready(function () {
    $('#payment').on('change',function(){
        selectTypePayment();
    });

    //For Upload File
    $('.dropify').dropify();

    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });

    if($('#type_edit').val()=='acceptWhiteLabel')
    {
        $("input").attr('disabled', true);
        $("select").attr('disabled', true);
        $("textarea").attr('disabled', true);
        $("#submitEdit").attr('disabled', true).css('display','none');
    }
    $("#chargeAccountForm").validate({
        rules: {
            amount: {
                required: true,
            },
            BankName: {
                required: true,
            }
        },
        messages: {
            amount: {
                required: "انتخاب کردن این فیلد الزامیست"

            },
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");


            if (element.prop("type") === "radio") {
                error.insertAfter(element.parents().find("label.show"));
                element.parents().find("label.show").parent().addClass("has-error");
            } else {
                error.insertAfter(element);
            }
        },

        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });

    $("#AddAgency").validate({
        rules: {
            name_fa: "required",
            manager: "required",
            seat_charter_code: "required",
            payment: "required",
            type_payment: "required",
            hasSite: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            domain: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainBg: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainBgHover: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainText: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainTextHover: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 13,
                number: true
            },
            phone: {
                required: true,
                minlength: 8,
                number: true
            },
            password:{
                minlength: 6
            },
            Confirm: {
                required: {
                    depends: function(element) {
                        return $('#password').val() !== '' ;
                    }
                },
                minlength: 6,
                equalTo: "#password"
            },
        },
        messages: {
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
            },
            seat_charter_code: {
                required: "وارد کردن این فیلد الزامیست"
            },
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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ثبت همکار جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='agencyList';
                        }, 1000);


                    } else if (response.indexOf('کد یکتای مقیم') > -1) {
                        // نمایش خطا برای کد یکتا
                        $("#seat_charter_code")
                           .addClass("error")                // استایل قرمز
                           .parents(".form-group")
                           .addClass("has-error");

                        $("<em class='help-block'>کد یکتای مقیم تکراری است</em>")
                           .insertAfter("#seat_charter_code");
                        $.toast({
                            heading: 'کد یکتای مقیم',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    } else {

                        $.toast({
                            heading: 'ثبت همکار جدید',
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
    $("#EditAgency").validate({
        rules: {
            nameFa: "required",
            manager: "required",
            seat_charter_code: "required",
            payment: "required",
            type_payment: "required",
            hasSite: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            domain: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainBg: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainBgHover: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainText: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            colorMainTextHover: {
                required: {
                    depends: function (element) {
                        return $('#isColleague').val() == '1';
                    }
                },
            },
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 13,
                number: true
            },
            phone: {
                required: true,
                minlength: 8,
                number: true
            },
            password:{
                minlength: 6
            },
            Confirm: {
                required: {
                    depends: function(element) {
                        return $('#password').val() !== '' ;
                    }
                },
                minlength: 6,
                equalTo: "#password"
            }
        },
        messages: {
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
            },
            seat_charter_code: {
                required: "وارد کردن این فیلد الزامیست"
            },

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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش همکار جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='agencyList';
                        }, 1000);
                    } else if (response.indexOf('کد یکتای مقیم') > -1) {
                        // نمایش خطا برای کد یکتا
                        $("#seat_charter_code")
                           .addClass("error")                // استایل قرمز
                           .parents(".form-group")
                           .addClass("has-error");

                        $("<em class='help-block'>کد یکتای مقیم تکراری است</em>")
                           .insertAfter("#seat_charter_code");

                        $.toast({
                            heading: 'کد یکتای مقیم',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }   else {
                        $.toast({
                            heading: 'ویرایش همکار جدید',
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


function delete_agency_list(id) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف همکار',
        icon: 'fa fa-trash',
        content: 'آیا از حذف همکار اطمینان دارید؟',
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
                                flag: 'delete_agency'
                            },
                            function (data) {
                                var res = data.split(':');

                            if (data.indexOf('success') > -1) {
                                $.toast({
                                    heading: 'حذف همکار',
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

                                }, 1000);
                            } else {
                                $.toast({
                                    heading: 'حذف همکار ',
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

function selectWhiteLabelForPartner(obj) {

    var valOption = $(obj).val();

    if (valOption == 1) {
        $('#hasSite').parent().removeClass('hidden');
        $('.disabledWhiteLabelField').attr('disabled', false);
    } else {
        $('#hasSite').parent().addClass('hidden');
        $('#hasSite option:eq(0)').prop('selected', true);
        $('.fieldsWhiteLabel').addClass('show-white-label');
        $('.disabledWhiteLabelField').attr('disabled', true);
    }

}

function showFieldsWhiteLabel(obj) {

    var valOption = $(obj).val();

    if (valOption == 1) {
        $('.fieldsWhiteLabel').removeClass('show-white-label');
    } else {
        $('.fieldsWhiteLabel').addClass('show-white-label')
    }

}
function selectTypeCurrency(obj) {

    var valOption = $(obj).val();

    if (valOption == 'currency') {
        $('.type-currency').removeAttr('disabled');
    } else {
        $('.type-currency').attr('disabled','disabled')
    }

}

function changeStatusAgency(id) {
    $.post(amadeusPath + 'user_ajax.php',
       {
           id: id,
           flag: 'changeStatusAgency'
       },
       function (data) {
           var res = data.split(':');

           if (data.indexOf('success') > -1) {

               $.toast({
                   heading: ' وضعیت همکار ',
                   text: res[1],
                   position: 'top-right',
                   loaderBg: '#fff',
                   icon: 'success',
                   hideAfter: 3500,
                   textAlign: 'right',
                   stack: 6
               });
           } else {
               $.toast({
                   heading: ' وضعیت همکار ',
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
function changeStatusAgencyاا(id) {
    alert(id);
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'غیر فعال کردن همکار',
        icon: 'fa fa-trash',
        content: 'آیا از غیر فعال کردن همکار اطمینان دارید؟',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: amadeusPath + "user_ajax.php",
                        data: {
                            id: id,
                            flag: 'changeStatusAgency'
                        },
                        success: function (data) {
                            $.toast({
                                heading: 'غیر فعال کردن همکار',
                                text: data.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon: (data.status == 'success') ? 'success' : 'error',
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6
                            });
                            if (data.status == 'success') {
                                setTimeout(function () {
                                }, 1000);

                            }

                        }
                    });

                },
                cancel: {
                    text: 'انصراف',
                    btnClass: 'btn-orange',
                }
            }
        }
    });


}

function ModalShowAccessAgency(ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'agency',
            Method: 'ModalShowAccessAgency',
            Param: ClientId
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}

function changeStatusServiceAgency(agencyId,servicesGroupId) {

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: amadeusPath + "user_ajax.php",
        data: {
            agencyId: agencyId,
            servicesGroupId: servicesGroupId,
            flag: 'changeStatusServiceAgency'
        },
        success: function (data) {
            $.toast({
                heading: 'دسترسی به خدمت وایت لیبل همکار',
                text: data.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: (data.status == 'success') ? 'success' : 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        }
    });

}

function acceptSubAgencyWhiteLabel(agencyId) {

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: amadeusPath + "user_ajax.php",
        data: {
            agencyId: agencyId,
            flag: 'acceptSubAgencyWhiteLabel'
        },
        success: function (data) {
            $.toast({
                heading: 'تایید وایت لیبل همکار',
                text: data.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: (data.status === 'success') ? 'success' : 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

            setTimeout(function () {

                $(document).reload();
            },1000)
        }
    });

}

function selectTypePayment(){

    let type_payment = $('#payment').val();

    console.log(type_payment)
        if(type_payment==='credit'){
            $('.limit_credit').removeAttr('disabled').parent('div').removeClass('d-none')
        }else{
            $('.limit_credit').attr('disabled','diabled').parent('div').addClass('d-none')
        }
}

