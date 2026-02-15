function ModalShowMessage(id) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            flag: 'CountUnreadMessage'
        },
        function (data) {
            $('#countMessageAjax').html(data);
            $('#inputUnreadMessage').val(data);



        });

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'message',
            Method: 'ModalShowMessage',
            Param: id
        },
        function (data) {

            $('#noView-' + id).removeClass('mdi-bell-off btn-danger tooltip-danger').addClass('mdi-bell-ring btn-success tooltip-success').attr('data-original-title', 'این پیام قبلا مشاهده شده است');
            $('#preview-' + id).remove();
            if ( $('#inputUnreadMessage').val() <= 1) {
                $('.notify').remove();
            }

            $('#ModalPublic').html(data);
        });
}