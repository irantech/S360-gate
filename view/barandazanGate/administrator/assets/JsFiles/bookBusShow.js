$(document).ready(function () {

    //data tables Option
    $('#busHistory').DataTable();

});
$('#busHistory').DataTable({
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

function displayAdvanceSearch(Obj) {

    if ($(Obj).is(':checked') === true) {
        $('.showAdvanceSearch').fadeIn(500);
    } else {
        $('.showAdvanceSearch').fadeOut(500);
    }
}


/*function ModalShowBook(factorNumber) {
    $.post(libraryPath + 'ModalCreatorBus.php',
        {
            Controller: 'bookingBusShow',
            Method: 'ModalShowBusBook',
            Param: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}*/
function ModalShowBookForBus(factorNumber) {
    $.post(libraryPath + 'ModalCreatorBus.php',
        {
            Controller: 'bookingBusShow',
            Method: 'ModalShowBusBook',
            Param: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}



function createExcelForReportBus() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'bus_ajax.php',
            data: $('#SearchBusHistory').serialize(),
            success: function (data) {

                $('#btn-excel').css('opacity', '1');
                $('#loader-excel').addClass('displayN');

                let res = data.split('|');
                if (data.indexOf('success') > -1) {

                    let url = amadeusPath + 'pic/excelFile/' + res[1];
                    let isFileExists = fileExists(url);
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



function checkInquireBusTicket(factorNumber) {
    $.post(amadeusPath + 'bus_ajax.php',
        {
            flag: 'flagCheckInquireBusTicket',
            factorNumber: factorNumber
        },
        function (data) {
        console.log('data', data);
            let res = data.split('|');
            if (data.indexOf('success') > -1) {
                $.alert({
                    title: 'پیگیری رزرو اتوبوس',
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'green'
                });
            } else {
                $.alert({
                    title: 'پیگیری رزرو اتوبوس',
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'red'
                });
            }

            setTimeout(function () {
                location.reload();
            }, 1000);
            
        });
}