$(document).ready(function () {

    $("#Message").validate({
        rules: {
            title: "required",
            description: "required",
            image: "required"
        },
        messages: {
            image:
                {
                    required: "ارسال لوگو الزامی می باشد"
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

                    var dataMessage = JSON.parse(response);
                    if (dataMessage.Status == 'Success') {
                        $.toast({
                            heading: 'ارسال پیام جدید',
                            text: dataMessage.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'MessageClientOnline';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ارسال پیام جدید',
                            text: dataMessage.Message,
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



    // For select 2
    $(".select2").select2();
    //For Upload File
    $('.dropify').dropify();




});


function DeleteMessage(id) {


    $.post(amadeusPath + 'user_ajax.php',
        {
            flag: 'DeleteMessageClientOnline',
            id: id
        },
        function (data) {
            var data = JSON.parse(data);

            if(data.Status=="Success")
            {
                $('#Del-' + id).remove();

                $.toast({
                    heading: 'حذف پیام',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }else{
                $.toast({
                    heading: 'حذف پیام',
                    text: data.Message,
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