function ShowErrorLog(id) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'LogErrorServer',
            Method: 'ModalShowLogErrorServer',
            Param: id
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}
