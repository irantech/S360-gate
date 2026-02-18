
$(document).ready(function () {

    /*$("#insurancePriceChanges").validate({
        rules: {
            price: "required",
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
                            heading: 'تغییرات قیمت بیمه',
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
                            heading: 'تغییرات قیمت بیمه',
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

    });*/

    $(".insurancePriceChanges").change(function () {
        var price = $(this).val();
        price = price.replace(/,/g, "");
        var changeType = $(this).parents('td').find('.changeType').val();
        var counter = $(this).parents('td').find('.counterID').val();

        if(changeType == 'percent' && price > 100){

            $.toast({
                heading: 'تغییرات قیمت',
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
                    flag: 'insurancePriceChanges',
                    price: price,
                    changeType: changeType,
                    counterID: counter
                },
                function (data) {

                    var res = data.split(':');

                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییرات قیمت بیمه',
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
                            heading: 'تغییرات قیمت بیمه',
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

});