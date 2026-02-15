
$(document).ready(function () {
    $("#SelectColor").validate({
        rules: {
            colorMainBg: "required",
            colorMainBgHover: "required",
            colorMainBgHover: "required",
            colorMainText: "required",
            colorMainTextHover: "required"

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
                success: function (response) {
                    var ClientId = parseInt($('#ClientId').val());
                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تعیین رنگ',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = (ClientId > 0)?'selectColor&ClientId='+ ClientId : 'selectColor';
                        }, 1000);

                    } else {
                        $.toast({
                            heading: 'تعیین رنگ',
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


$(".gradient-colorpicker").asColorPicker({
    mode: 'gradient'
});

