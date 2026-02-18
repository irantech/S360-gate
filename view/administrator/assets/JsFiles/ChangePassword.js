

$(document).ready(function () {
    $("#changePassword").validate({
        rules: {
            old_pass: "required",

            new_pass: {
                required: true,
                minlength: 6
            },
            con_pass: {
                required: true,
                minlength: 6,
                equalTo: "#new_pass"
            }
        },
        messages: {
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
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییر کلمه عبور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'admin'
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'تغییر کلمه عبور',
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
