$(document).ready(function () {
    $('#visaHistory').DataTable({
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

    $(document).on('change', '.change_visa_book_request_status', function (e) {
        let visa = $(this).data('visa');
        let status = $(this).val();
        console.log(visa.factor_number);
        $.ajax({
            url: amadeusPath + 'ajax',
            type: 'POST',
            dataType: 'JSON',
            data: JSON.stringify({
                method: 'changeBookRequestStatus',
                className: 'bookingVisa',
                status: status,
                factor_number: visa.factor_number
            }),
            success: function (response) {
                $.post(libraryPath + 'ModalCreator.php',
                    {
                        Controller: 'contactUsController',
                        Method: 'ModalVisaShowSms',
                        Param: {
                            'sms_content': response.data.sms_content,
                            'mobile': response.data.mobile
                        }
                    },
                    function (data) {
                        $('#ModalPublic').html(data).modal('show');

                    })
            },
            error: function (error) {
                $.toast({
                    heading: 'وضعیت ویزا',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            }
        });
        // let method = 'changeBookRequestStatus';

    });

    $(document).on('click', '.sendVisaStatusSms', function (e) {
        let notification_content = $(this).parents('.modal-dialog').find('#notification_content').val();
        let mobile = $(this).parents('.modal-dialog').find('#mobile').val();
        if (notification_content == '' || mobile == '') {
            $.toast({
                heading: 'خطا در ارسال پیامک',
                text: 'فیلدهای ضروری را باید پر کنید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            return false;
        }
        let ajax_data = {
            className: 'bookingVisa',
            method: 'sendSmsToUserByStatusChange',
            as_json: true,
            cellNumber: mobile,
            smsMessage: notification_content,
        };
        $.ajax({
            type: 'POST',
            dataType: 'JSON',

            url: amadeusPath + 'ajax',
            data: JSON.stringify(ajax_data),
            success: function (response) {
                $.toast({
                    heading: 'خطا در ارسال پیامک',
                    text: 'پیام با موفقیت ارسال شد. ',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                $('#ModalPublic').modal('hide');

                console.log(response);
            },
            error: function (error) {
                $.toast({
                    heading: 'خطا در ارسال پیامک',
                    text: 'خطایی در ارسال پیامک رخ داد.',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                $('#ModalPublic').modal('hide');
                console.log(error);
            }
        })
    });

});

function ModalShowBookForVisa(factorNumber) {

    $.post(libraryPath + 'ModalCreator.php',
    {
        Controller: 'bookingVisa',
        Method: 'ModalShowVisaBook',
        Param: factorNumber
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




function createExcelForReportVisa() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'visa_ajax.php',
            data: $('#SearchVisaHistory').serialize(),
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