
$(document).ready(function () {


    $("#CancellationFee").validate({
        rules: {
            AirlineIata:'required',
            TypeClass:'required',
            ThreeDaysBefore: {
                required: true,
                // max:100,
                // number: true,
            },
            OneDaysBefore: {
                required: true,
                // max:100,
                // number: true
            },
            ThreeHoursBefore: {
                required: true,
                // max:100,
                // number: true
            },
            ThirtyMinutesAgo: {
                required: true,
                // max:100,
                // number: true
            },
            OfThirtyMinutesAgoToNext: {
                required: true,
                // max:100,
                // number: true
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
                            heading: 'افزودن تنظیمات جریمه جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='cancellationFeeSettingList';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'افزودن تنظیمات جریمه جدید',
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

    $("#CancellationFeeEdit").validate({
        rules: {
            AirlineIata:'required',
            TypeClass:'required',
            ThreeDaysBefore: {
                required: true,
                // max:100,
                // number: true
            },
            OneDaysBefore: {
                required: true,
                // max:100,
                // number: true
            },
            ThreeHoursBefore: {
                required: true,
                // max:100,
                // number: true
            },
            ThirtyMinutesAgo: {
                required: true,
                // max:100,
                // number: true
            },
            OfThirtyMinutesAgoToNext: {
                required: true,
                // max:100,
                // number: true
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
                            heading: 'ویرایش تنظیمات جریمه جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='cancellationFeeSettingList';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'ویرایش تنظیمات جریمه جدید',
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

