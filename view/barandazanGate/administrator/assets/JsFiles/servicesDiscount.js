
$(document).ready(function () {

    $(".serviceDiscount").change(function () {
        var off = $(this).val();
        var counter = $(this).parents('td').find('.counterID').val();
        var service = $(this).parents('td').find('.serviceTitle').val();
        var service_id = $(this).parents('td').find('.service_id').val();

        if(off > 100){

            $.toast({
                heading: 'تخفیف ها',
                text: 'خطا: مقدار نامعتبر (بیش از 100%)',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        } else {

            $.post(amadeusPath + 'user_ajax.php',
                {
                    flag: 'servicesDiscount',
                    offPercent: off,
                    counterID: counter,
                    serviceTitle: service ,
                    service_id : service_id
                },
                function (data) {

                    var res = data.split(':');

                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تخفیف ها',
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
                            heading: 'تخفیف ها',
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

    });


    $("#servicesDiscountAll").validate({
        rules: {
            serviceDiscountAll: {
                required: true,
                number: true,
            }
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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تخفیف ها',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='servicesDiscount';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'تخفیف ها',
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

    $("#special_discount").validate({
        rules: {
            service_title: 'required',
            type_discount: 'required',
            amount: 'required',
            type_get_discount: 'required',
            pre_code: 'required',

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

            $.ajax({
                type: 'POST',
                url: amadeusPath + 'ajax',
                data: JSON.stringify({
                    className: 'servicesDiscount',
                    method: 'setSpecialDiscount',
                    service_title: document.getElementById('service_title').value,
                    type_discount : document.getElementById('type_discount').value,
                    pre_code : document.getElementById('pre_code').value,
                    type_get_discount : document.getElementById('type_get_discount').value,
                    amount : document.getElementById('amount').value
                }),
                success: function (response) {
                    $.toast({
                        heading: 'تخفیف ها',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon:  response.status,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                    setTimeout(function () {
                        location.reload();
                    },1000)
                },
                error: function (response) {
                    $.toast({
                        heading: 'تخفیف ها',
                        text: response.responseJSON.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: response.responseJSON.status,
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
    });

    $(".resetForm").click(function () {

        $.confirm({
            theme: 'material',// 'material', 'bootstrap','supervan'
            title: 'ریست مقادیر تخفیف',
            icon: 'fa fa-trash',
            content: 'آیا از ریست کردن تخفیف ها اطمینان دارید؟',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید',
                    btnClass: 'btn-green',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: amadeusPath + 'user_ajax.php',
                            data: {
                                flag: 'resetServicesDiscount'
                            },
                            success: function (response) {
                                var res = response.split(':');

                                if (response.indexOf('success') > -1) {
                                    $.toast({
                                        heading: 'تخفیف ها',
                                        text: res[1],
                                        position: 'top-right',
                                        loaderBg: '#fff',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        textAlign: 'right',
                                        stack: 6
                                    });
                                    setTimeout(function () {
                                        window.location = 'servicesDiscount';
                                    }, 1000);
                                } else {
                                    $.toast({
                                        heading: 'تخفیف ها',
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
                },
                cancel: {
                    text: 'انصراف',
                    btnClass: 'btn-orange',
                }
            }
        });
    });

});


function detectTypeDiscount(obj) {
    let val_type_discount = $(obj).val();
    (val_type_discount =='phone') ? $('#pre_code').attr('maxlength','4') : $('#pre_code').attr('maxlength','3');
}

function deleteSpecialDiscount(id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        data: JSON.stringify({
            className: 'servicesDiscount',
            method: 'softDeleteSpecialDiscount',
            id: id,
        }),
        success: function (response) {

            $.toast({
                heading: 'تخفیف ها',
                text: response.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon:  response.status,
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

            setTimeout(function () {
                location.reload();
            },1000)

        },
        error: function (response) {
            $.toast({
                heading: 'تخفیف ها',
                text: response.responseJSON.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: response.responseJSON.status,
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        }
    });
}