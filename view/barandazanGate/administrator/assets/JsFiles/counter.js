function validateMobileOrEmail(inputValue) {
    const mobileRegex = /^[0-9]{11}$/;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Check if the input matches either the mobile regex or email regex
    return mobileRegex.test(inputValue) || emailRegex.test(inputValue);
}

$(document).ready(function () {
    //For switch active And inactive
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });

    $.validator.addMethod("validateMobileOrEmail", function(value, element) {
        return this.optional(element) || validateMobileOrEmail(value);
        // Return true if the value is valid, false otherwise
    },'لطفا ایمیل یا شماره همراه خود را وارد کنید');

    $.validator.addMethod("validMember", function(value, element) {
        return value === "0" || value === "1" || value === "2";
    }, "مقدار این فیلد باید 0، 1 یا 2 باشد");

    $("#Addcounter").validate({
        rules: {
            is_member: {
                required: true,
                validMember: true
            },
            name: "required",
            family: "required",
            typeCounter: {
                required: function () {
                    return $("#formType").val() === "کانتر";
                }
            },
            accessAdmin: "required",
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 13,
                number: true
            },
            password: {
                required: true,
                minlength: 6
            },
            Confirm: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            is_member: {
                required: "این فیلد الزامیست",
                validMember: "مقدار این فیلد باید 0، 1 یا 2 باشد"
            },
            password: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "رمز عبور نمی تواند از 6 کارکتر کمتر باشد"
            },
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
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
                    var agencyId = $('#agency_id').val();

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن کاربر جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            if($("#formType").val() === "کانتر"){
                                window.location = 'counterList&id=' + agencyId;
                            } else if($("#formType").val() === "مدیر"){
                                window.location = 'list&id=' + agencyId;
                            }
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن کاربر جدید',
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

    $("#Editcounter").validate({
        rules: {
            name: "required",
            family: "required",
            typeCounter: {
                required: function () {
                    return $("#formType").val() === "کانتر";
                }
            },
            accessAdmin: "required",
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 13,
                number: true
            },
            password: {
                minlength: 6
            },
            Confirm: {
                required: {
                    depends: function (element) {
                        return $('#password').val() !== '';
                    }
                },
                minlength: 6,
                equalTo: "#password"
            },
            email: {
                required: true,
                validateMobileOrEmail:true
            }
        },
        messages: {
            password: {
                minlength: "رمز عبور نمی تواند از 6 کارکتر کمتر باشد"
            },
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
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
                    var agencyId = $('#agency_id').val();

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش کاربر',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            if($("#formType").val() === "کانتر"){
                                window.location = 'counterList&id=' + agencyId;
                            } else if($("#formType").val() === "مدیر"){
                                window.location = 'list&id=' + agencyId;
                            }
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش کاربر',
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
    $("#EditBankInfoCounter").validate({
        rules: {
            nameHesab:"required",
            sheba: {
                required: true,
                minlength: 26
            },
            hesabBank:"required"
        },
        messages: {

            nameHesab: {
                required: "وارد کردن این فیلد الزامیست"

            },
            sheba: {
                required: "وارد کردن این فیلد الزامیست"

            },
            hesabBank: {
                required: "وارد کردن این فیلد الزامیست"

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
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');
                    var agencyId = $('#agency_id').val();

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش مشخصات حساب بانکی',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'counterList&id=' + agencyId;
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش مشخصات حساب بانکی',
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

function active_counter_list(id) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            flag: 'active_counter'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('success') > -1) {

                $.toast({
                    heading: ' وضعیت کاربر ',
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
                    heading: ' وضعیت کاربر ',
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

function passengerOnlineConvert(id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'وضعیت کانتر',
        icon: 'fa fa-trash',
        content: 'آیا از تبدیل کانتر به مسافر آنلاین اطمینان دارید',
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
                            flag: 'convert_counter'
                        },
                        function (data) {
                            var res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: ' وضعیت کانتر ',
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
                            } else
                            {
                                $.toast({
                                    heading: ' وضعیت کانتر ',
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