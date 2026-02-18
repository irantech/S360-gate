$(document).ready(function () {

    $("#organizationAdd, #organizationEdit").validate({
        rules: {
            title:'required'
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
                        heading: 'سطوح سازمانی',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function(){
                            window.location = 'organization';
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

function deleteRecord(id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف رکورد',
        icon: 'fa fa-trash',
        content: 'آیا از حذف رکورد اطمینان دارید',
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
                        flag: 'organizationDelete',
                        id: id
                    },
                    function (data) {

                        var res = data.split(':');

                        if (data.indexOf('success') > -1) {
                            var displayIcon = 'success';
                        } else {
                            var displayIcon = 'error';
                        }

                        $.toast({
                            heading: 'حذف رکورد',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: displayIcon,
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        if (data.indexOf('success') > -1) {

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}