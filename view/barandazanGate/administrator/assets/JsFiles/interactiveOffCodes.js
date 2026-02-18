$(document).ready(function () {

    //For Upload File
    $('.dropify').dropify();

    $("#interactiveOffCodesAdd, #interactiveOffCodesEdit").validate({
        rules: {
            title:'required',
            expireDate:'required',
            origin:'required',
            destination:'required',
            excelCodes: {
                required: {
                    depends: function (element) {
                        return $('#flag').val() == 'interactiveOffCodesAdd';
                    }
                }
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
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {

                    if (response.result_status == 'success') {
                        var displayIcon = 'success';
                    } else{
                        var displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'افزودن کدهای ترانسفر جدید',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 1000,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function(){
                            window.location = 'interactiveOffCodes';
                        }, 1000);
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