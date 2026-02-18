

$(document).ready(function () {


    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });

    $("#AddBank").validate({
        rules: {
            title: "required",
            param1: "required",
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
                    var ClientId = parseInt($('#ClientId').val());

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن بانک جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location =(ClientId > 0) ? "bankList&id=" + ClientId : "bankList";
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن بانک جدید',
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

    $("#EditBank").validate({
        rules: {
            param1: "required",
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
                    var ClientId = parseInt($('#ClientId').val());

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش بانک',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location =(ClientId > 0) ? "bankList&id=" + ClientId : "bankList";
                        }, 1000);


                    } else {

                        $.toast({
                            heading:'ویرایش بانک',
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
function bank_active(id,ClientId,checkMyBank,param1)
{

        $.post(amadeusPath + 'user_ajax.php',
            {
                id: id,
                ClientId: ClientId,
                param1: param1,
                flag: 'bank_active'
            },
            function (data) {

                var res = data.split(':');
                if (data.indexOf('success') > -1)
                {

                    $.toast({
                        heading: 'وضعیت بانک',
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
                        heading: 'وضعیت بانک',
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




function bank360_active(username)
{

    $.post(amadeusPath + 'user_ajax.php',
        {
            username: username,
            flag: 'bank360_active'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'وضعیت بانک',
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
                    heading: 'وضعیت بانک',
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