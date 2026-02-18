$(document).ready(function () {
    $('.dropify').dropify();
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
    $("#addMenuAdmin").validate({
            title:'required',
            mainPage:'required',
            accessCustomer:'required',
            url:'required',
            classIcon:'required',


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
                    if (response.indexOf('Success') > -1) {
                        $.toast({
                            heading: 'افزودن منو ادمین',
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
                            heading: 'افزودن منو ادمین',
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


function StatusAccess(id,idMember) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            idMenu: id,
            idMember: idMember,
            flag: 'StatusMenuCounter'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('Success') > -1)
            {

                $.toast({
                    heading: 'وضعیت دسترسی کانتر',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else
            {
                $.toast({
                    heading: 'وضعیت دسترسی کانتر',
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
