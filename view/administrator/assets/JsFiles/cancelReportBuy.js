$(document).ready(function () {


    //data tables Option
    $('#hotelHistory').DataTable();
    $("#SearchTransaction").validate({
        rules: {
            date_of: "required",
            to_date: "required"
        },
        messages: {},
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
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });


});



$('#hotelHistory').DataTable({
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



function createExcel() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            data: $('#cancelReportForm').serialize(),
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

function modalCancelBuy(typeRequest, id, clientId,type_app) {

    $.post(libraryPath + 'modalCancelBuy.php',
        {
            typeRequest: typeRequest,
            factor_number: id,
            clientId: clientId,
            type_app: type_app,
            methodName: 'showModalConfirmCancelBuy'
        },
        function (data) {
            console.log(data);
            $('#ModalPublic').html(data);
        });
}


function setConfirmCancel(factor_number, clientId,typeApp) {

    let cancelPercent = $('#cancelPercent').val();
    let cancelPrice = $('#cancelPrice').val();
    let descriptionClient = $('#descriptionClient').val();

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'درخواست کنسلی',
        icon: 'fa fa-trash',
        content: 'آیا از تایید درخواست کنسلی کاربر اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {

                    $.ajax({
                        type: 'post',
                        url: amadeusPath + 'user_ajax.php',
                        data: {
                            flag : 'flagConfirmCancel',
                            factor_number : factor_number,
                            clientId : clientId,
                            typeApp : typeApp,
                            cancelPercent: cancelPercent,
                            cancelPrice :cancelPrice,
                            descriptionClient :descriptionClient
                        },
                        success: function (data) {

                            console.log('data', data);
                            let res = data.split(':');
                            if (data.indexOf('success') > -1) {

                                $.alert({
                                    title: 'درخواست کنسلی',
                                    icon: 'fa fa-check',
                                    content: res[1],
                                    rtl: true,
                                    type: 'green',
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            } else {
                                $.alert({
                                    title: 'درخواست کنسلی',
                                    icon: 'fa fa-times',
                                    content: res[1],
                                    rtl: true,
                                    type: 'red',
                                });
                                setTimeout(function () {
                                    $("#ModalPublic").fadeOut(700);
                                }, 1000);
                            }

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

function setRejectCancelRequest(factor_number, clientId,typeApp) {

    let descriptionClient = $('#descriptionClient').val();

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'درخواست کنسلی',
        icon: 'fa fa-trash',
        content: 'آیا از رد درخواست کنسلی کاربر اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {

                    $.ajax({
                        type: 'post',
                        url: amadeusPath + 'user_ajax.php',
                        data: {
                            flag: 'flagRejectCancelRequest',
                            factor_number: factor_number,
                            clientId: clientId,
                            descriptionClient: descriptionClient
                        },
                        success: function (data) {

                            let res = data.split(':');
                            if (data.indexOf('success') > -1) {

                                $.alert({
                                    title: 'درخواست کنسلی',
                                    icon: 'fa fa-check',
                                    content: res[1],
                                    rtl: true,
                                    type: 'green',
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            } else {
                                $.alert({
                                    title: 'درخواست کنسلی',
                                    icon: 'fa fa-times',
                                    content: res[1],
                                    rtl: true,
                                    type: 'red',
                                });
                                setTimeout(function () {
                                    $("#ModalPublic").fadeOut(700);
                                }, 1000);
                            }

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