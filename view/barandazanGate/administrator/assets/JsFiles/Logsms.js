function ModalShowLogSms(id,ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'LogSms',
            Method: 'ModalShowLogSms',
            Param: id,
            ParamId: ClientId
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

function ModalShowBook(RequestNumber) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'ModalShowBook',
            Param: RequestNumber
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}