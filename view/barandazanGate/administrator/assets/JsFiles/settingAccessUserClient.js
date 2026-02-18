$(document).ready(function () {
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });


    $("#AddAccess").validate({
        rules: {
            ServiceId:'required',
            SourceId:'required',
            Username:'required'
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
                    var ClientId = $('#ClientId').val();
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن دسترسی جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'settingAccessUserClientList&id='+ClientId;
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن دسترسی جدید',
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

    $("#EditAccess").validate({
        rules: {
            ServiceId:'required',
            SourceId:'required',
            Username:'required'
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
                    var ClientId = $('#ClientId').val();
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش دسترسی جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'settingAccessUserClientList&id='+ClientId;
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش دسترسی جدید',
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



function Access_active(id,ClientId,ServiceId,SourceId)
{
    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            ClientId: ClientId,
            ServiceId: ServiceId,
            SourceId: SourceId,
            flag: 'AccessActive'
        },
        function (data) {
            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'وضعیت دسترسی',
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
                    heading: 'وضعیت دسترسی',
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


function SelectServiceForSource(obj) {


    var ValueSource = $(obj).val();

    $.post(amadeusPath + 'user_ajax.php',
        {
            ValueSource: ValueSource,
            flag: 'SelectServiceForSource'
        },
        function (data) {
            setTimeout(function () {
                $('#SourceId').html(data).removeAttr('disabled');
            },500);
        });

}