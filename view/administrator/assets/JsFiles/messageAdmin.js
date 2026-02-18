
$('document').ready(function () {

    // For multiselect
    $('#pre-selected-options').multiSelect();


    $('#select-all').click(function() {
        $('#pre-selected-options').multiSelect('select_all');
        return false;
    });

    $("#sendMessage").validate({
        rules: {
            title: "required",
            message: "required",
            ClientId: "required"
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
                            heading: 'افزودن پیام جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = "messageBoxAdmin";
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن پیام جدید',
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
function ModalShowMessageAdmin(id) {



    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'message',
            Method: 'ModalShowMessageAdmin',
            Param: id
        },
        function (data) {

            $('#ModalPublic').html(data);
        });
}
function ModalShowUsersForMessage(id) {



    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'message',
            Method: 'ModalShowUsersForMessage',
            Param: id
        },
        function (data) {

            $('#ModalPublic').html(data);
        });
}


function DelMessageForUser(Unique_id , clientId)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف پیام',
        icon: 'fa fa-trash',
        content: 'آیا از حذف پیام اطمینان دارید',
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
                            id: Unique_id,
                            ClientID : clientId,
                            flag : 'delMessageUser'
                        },
                        function (data) {
                        var res = data.split(':');
                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: ' حذف پیام ',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    $('#ModalPublic').modal('hide');
                                }, 1000);
                            } else
                            {
                                $.toast({
                                    heading: ' حذف پیام ',
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
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });

}

