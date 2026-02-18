$(document).ready(function () {

    //data tables Option
    $('#insuranceHistory').DataTable();

});

function ModalShowBookForInsurance(factorNumber) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookingInsurance',
            Method: 'ModalShowInsuranceBook',
            Param: factorNumber
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}


function ModalSendSms(RequestNumber) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'ModalSendSms',
            Param: RequestNumber
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function displayAdvanceSearch(Obj) {

    if ($(Obj).is(':checked') === true) {
        $('.showAdvanceSearch').fadeIn(500);
    } else {
        $('.showAdvanceSearch').fadeOut(500);
    }
}


$('#insuranceHistory').DataTable({
    "order": [
        [0, 'desc']
    ],
    dom: 'lBfrtip',
    // buttons: [
    //     'copy', 'excel', 'print'
    // ]
    buttons: [
        {
            extend: 'excel',
            text: 'دریافت فایل اکسل',
            exportOptions: {}
        },
        {
            extend: 'print',
            text: 'چاپ سطر های لیست',
            exportOptions: {}
        },
        {
            extend: 'copy',
            text: 'کپی لیست',
            exportOptions: {}
        }

    ]
});


function sendSms(RequestNumber) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'ارسال پیام کوتاه',
        icon: 'fa fa-shopping-cart',
        content: 'آیا ازارسال این پیام اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {

                    var contentSms = $('#contentSms').val();
                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            RequestNumber: RequestNumber,
                            contentSms: contentSms,
                            flag: 'SendSmsForUser'
                        },
                        function (data) {
                            var res = data.split(':');

                            if (data.indexOf('success') > -1) {


                                $.toast({
                                    heading: 'ارسال پیام کوتاه',
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
                            } else {
                                $.toast({
                                    heading: 'ارسال پیام کوتاه',
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




function createExcelForReportInsurance() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            data: $('#SearchInsuranceHistory').serialize(),
            success: function (data) {

                $('#btn-excel').css('opacity', '1');
                $('#loader-excel').addClass('displayN');

                var res = data.split('|');
                if (data.indexOf('success') > -1) {

                    var url = amadeusPath + 'pic/excelFile/' + res[1];
                    var isFileExists = fileExists(url);
                    if (isFileExists){
                        window.open(url, 'Download');
                    } else {
                        $.toast({
                            heading: 'دریافت فایل اکسل',
                            text: 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید.',
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    }


                } else {

                    $.toast({
                        heading: 'دریافت فایل اکسل',
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
    }, 5000);



}


function fileExists(url) {
    if(url){
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status==200;
    } else {
        return false;
    }
}