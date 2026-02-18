$(document).ready(function () {

    // ('change', function () {
    //     alert($('button.btn-info[data-info=pendingBtn]').attr('data-target'));
    // });


    // data tables Option
    // $('#ticketHistory').DataTable({
    //     "order": [
    //         [0, 'desc']
    // ]});


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

            if(element.prop("type") === "checkbox"){
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

function ModalShowBookForFlight(RequestNumber) {


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


function ModalUploadProof(RequestNumber , type) {


    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: 'bookshow',
          Method: 'ModalUploadProof',
          Param: {
              requestNumber : RequestNumber ,
              type : type
          }
      },
      function (data) {

          $('#ModalPublic').html(data);

      });
}


function ModalSendInteractiveSms(FactorNumber) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'ModalSendInteractiveSms',
            Param: FactorNumber
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}
function editInfoPassenger(RequestNumber, ClientId) {
    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'bookshow',
           Method: 'editInfoPassenger',
           Param: RequestNumber,
           ParamId: ClientId
       },
       function (data) {

           $('#ModalPublic').html(data);
           $("#flightDate").datepicker({
               dateFormat: "yy-mm-dd"
           });
       });
}

function insertPnr(RequestNumber, ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'insertPnr',
            Param: RequestNumber,
            ParamId: ClientId
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function insertHotelPnr(RequestNumber, ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: 'bookshow',
          Method: 'insertHotelPnr',
          Param: RequestNumber,
          ParamId: ClientId
      },
      function (data) {
          $('#ModalPublic').html(data);
      });
}
function changePendingHotel(FactorNumber, ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
      {
          Controller: 'bookshow',
          Method: 'changePendingHotel',
          Param: FactorNumber,
          ParamId: ClientId
      },
      function (data) {

          $('#ModalPublic').html(data);

      });
}

function FlightConvertToBook(RequestNumber, ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'FlightConvertToBook',
            Param: RequestNumber,
            ParamId: ClientId
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function changeFlagBuyPrivate(RequestNumber) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            RequestNumber: RequestNumber,
            flag: 'changeFlagBuyPrivate'
        },
        function (data) {

            if(data.indexOf('success') > -1){
                $('#i_Jump2StepPublic' + RequestNumber).removeClass('btn-info fa-shopping-cart tooltip-info').addClass('btn-danger fa-refresh tooltip-danger').attr('data-original-title', 'در حال رزرو بلیط');
            }

        });
}

function changeFlagBuySystemPublic(RequestNumber) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            RequestNumber: RequestNumber,
            flag: 'changeFlagBuyPublicSystem'
        },
        function (data) {

            if(data.indexOf('success') > -1){
                $('#i_Jump2StepPublic' + RequestNumber).removeClass('btn-info fa-shopping-cart tooltip-info').addClass('btn-danger fa-refresh tooltip-danger').attr('data-original-title', 'در حال رزرو بلیط');
            }

        });
}

function changeFlagBuyPrivateToPublic(RequestNumber) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            RequestNumber: RequestNumber,
            flag: 'changeFlagBuyPrivateToPublic'
        },
        function (data) {

            if(data.indexOf('success') > -1){
                $('#i_Jump2StepPublic' + RequestNumber).removeClass('btn-primary fa-shopping-cart tooltip-info').addClass('btn-danger fa-refresh tooltip-danger').attr('data-original-title', 'در حال رزرو بلیط');
            }

        });
}


function DoneIsPrivate(RequestNumber) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تایید  خرید پید اختصاصی',
        icon: 'fa fa-shopping-cart',
        content: 'آیا از قطعی بودن  این خرید اطمینان دارید',
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
                            RequestNumber: RequestNumber,
                            flag: 'done_private'
                        },
                        function (data) {
                            var res = data.split(':');

                            if(data.indexOf('success') > -1){


                                $.toast({
                                    heading: 'تایید اتمام خرید پید اختصاصی',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    $('#checkWarningFinal' + RequestNumber).remove();
                                    $('#Jump2Step' + RequestNumber).remove();
                                    $('#checkSuccessFinal' + RequestNumber).fadeIn(500);
                                }, 1000);
                            } else {
                                $.toast({
                                    heading: 'تایید اتمام خرید پید اختصاصی',
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

function DoneIsPublice(RequestNumber) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تایید  خرید اشتراکی منبع 10',
        icon: 'fa fa-shopping-cart',
        content: 'آیا از قطعی بودن  این خرید اطمینان دارید',
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
                            RequestNumber: RequestNumber,
                            flag: 'done_public'
                        },
                        function (data) {
                            var res = data.split(':');

                            if(data.indexOf('success') > -1){
                                $.toast({
                                    heading: 'تایید اتمام خرید پید اختصاصی',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    $('#checkWarningFinalPublic' + RequestNumber).remove();
                                    $('#Jump2Step' + RequestNumber).remove();
                                    $('#checkSuccessFinalPublic' + RequestNumber).fadeIn(500);
                                }, 1000);
                            } else {
                                $.toast({
                                    heading: 'تایید اتمام خرید پید اختصاصی',
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


function displayAdvanceSearch(Obj) {

    if($(Obj).is(':checked') === true){
        $('.showAdvanceSearch').fadeIn(500);
    } else {
        $('.showAdvanceSearch').fadeOut(500);
    }
}


$('#ticketHistory').DataTable({
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

$('#RTRDRepoert').DataTable({
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

    ]
});

function ModalShowBookForEntertainment(factorNumber) {
    $.post(libraryPath + 'ModalCreatorForEntertainment.php',
      {
          Method: 'ModalShowBook',
          factorNumber: factorNumber,
      },
      function (data) {
          $('#ModalPublic').html(data);
      });
}
function DonePreReserve(RequestNumber, FactorNumber, ClientID) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'پیش رزرو کردن بلیط',
        icon: 'fa fa-shopping-cart',
        content: 'آیا از قطعی بودن  پیش رزرو کردن خرید اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {

                    $.confirm({
                        theme: 'bootstrap',// 'material', 'bootstrap','supervan'
                        title: 'پیش رزرو کردن بلیط',
                        icon: 'fa fa-shopping-cart',
                        content: 'آیا اطمینان دارید از پیش رزرو کردن این خرید؟',
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
                                            RequestNumber: RequestNumber,
                                            FactorNumber: FactorNumber,
                                            ClientID: ClientID,
                                            flag: 'preReserveBuy'
                                        },
                                        function (data) {
                                            var res = data.split(':');

                                            if(data.indexOf('success') > -1){

                                                $.toast({
                                                    heading: 'پیش رزرو کردن بلیط',
                                                    text: res[1],
                                                    position: 'top-right',
                                                    loaderBg: '#fff',
                                                    icon: 'success',
                                                    hideAfter: 3500,
                                                    textAlign: 'right',
                                                    stack: 6
                                                });

                                                setTimeout(function () {
                                                    $('#DonePrereserve' + RequestNumber).remove();

                                                }, 1000);
                                            } else {
                                                $.toast({
                                                    heading: 'پیش رزرو کردن بلیط',
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
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });
}


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
                    var Reason = $('#Reason').val();
                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            RequestNumber: RequestNumber,
                            contentSms: contentSms,
                            Reason: Reason,
                            flag: 'SendSmsForUser'
                        },
                        function (data) {
                            var res = data.split(':');
                            if(data.indexOf('success') > -1){


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


function sendInteractiveSms(factorNumber, memberID) {
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'ارسال مجدد کد ترانسفر',
        icon: 'fa fa-shopping-cart',
        content: 'آیا از ارسال این پیام اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {

                    $.ajax({
                        type: 'POST',
                        url: amadeusPath + 'user_ajax.php',
                        dataType: 'JSON',
                        data:
                            {
                                flag: 'reSendInteractiveSms',
                                factorNumber: factorNumber,
                                memberID: memberID,
                                offCodeGroup: $('input[name=offCodeGroup]:checked').val()
                            },
                        success: function (response) {

                            if(response.result_status == 'success'){
                                var displayIcon = 'success';
                            } else {
                                var displayIcon = 'error';
                            }

                            $.toast({
                                heading: 'ارسال مجدد پیامک کد ترانسفر',
                                text: response.result_message,
                                position: 'top-right',
                                icon: displayIcon,
                                hideAfter: 3500,
                                textAlign: '1000',
                                stack: 6
                            });

                            if(response.result_status == 'success'){
                                setTimeout(function () {
                                    $('#ModalPublic').modal('hide');
                                }, 1000);
                            }

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

function ModalSenEmailForOther(RequestNumber, ClientID) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'ModalSenEmailForOther',
            Param: RequestNumber,
            ParamId: ClientID
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function createExcelForReportTicket() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            data: $('#SearchTicketHistory').serialize(),
            success: function (data) {

                $('#btn-excel').css('opacity', '1');
                $('#loader-excel').addClass('displayN');

                var res = data.split('|');
                if(data.indexOf('success') > -1){
                    var url = amadeusPath + 'pic/excelFile/' + res[1];
                    var isFileExists = fileExists(url);
                    if(isFileExists){
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
    }, 10000);


}


function fileExists(url) {
    if(url){
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status == 200;
    } else {
        return false;
    }
}

function ModalCancelAdmin(type, RequestNumber) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'user',
            Method: 'ModalCancelAdmin',
            Param: RequestNumber,
            ParamId: type
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}


function SelectUser(RequestNumber) {


    var National = [];
    var Reasons = $('#ReasonUser').val();
    var FactorNumber = $('#FactorNumber').val();
    var MemberId = $('#MemberId').val();
    var typeService = $('#typeService').val();
    var flightType = $('#flightType').val();


//    var passenger_age = $('#passenger_age').val();

    National = $('.SelectUser:checked').map(function () {


        return $(this).val();

    });

    var NationalCodes = National.get();


    if(NationalCodes != "" && Reasons != ""){
        $.post(amadeusPath + 'user_ajax.php',
            {
                NationalCodes: NationalCodes,
                Reasons: Reasons,
                FactorNumber: FactorNumber,
                RequestNumber: RequestNumber,
                MemberId: MemberId,
                typeService: typeService,
                admin: 'yes',
                flightType: flightType,
                flag: 'RequestCancelUser'
            },
            function (data) {
                var res = data.split(':');
                if(data.indexOf('success') > -1){
                    $.alert({
                        title: 'ارسال درخواست کنسلی',
                        icon: 'fa fa-check',
                        content: 'درخواست کنسلی شما با موفقیت ثبت شد',
                        rtl: true,
                        type: 'green'
                    });

                } else {
                    $.alert({
                        title: 'ارسال درخواست کنسلی',
                        icon: 'fa fa-times',
                        content: res[1],
                        rtl: true,
                        type: 'red'
                    });
                    $('#SendEmailForOther').attr("disabled", false);
                    $('#loaderTracking').fadeOut(500);
                }

            });
    } else {
        $.alert({
            title: 'ارسال درخواست کنسلی',
            icon: 'fa fa-times',
            content: 'لطفا دلیل کنسلی و یا حداقل یک نفر را مشخص نمائید',
            rtl: true,
            type: 'red'
        });
    }


}

function DataTableMaker(Target) {
    // اگر DataTable قبلاً وجود دارد، آن را کاملاً destroy کن
    if($.fn.DataTable.isDataTable(Target)){
        $(Target).DataTable().clear().destroy();
    }

    // بررسی کن که جدول موجود است و حداقل یک سطر دارد
    if($(Target).length > 0 && $(Target).find('thead tr th').length > 0){
        // حالا DataTable جدید را initialize کن
        try {
            var table = $(Target).DataTable({
                dom: 'lfrtip', // B را حذف کردیم چون buttons مشکل ایجاد می‌کند
                searching: true,
                processing: false, // processing را false می‌کنیم چون خودمان loading را مدیریت می‌کنیم
                destroy: true // این اطمینان می‌دهد که اگر DataTable قبلی وجود داشت، destroy شود
            });
        } catch(e) {
            console.error('Error initializing DataTable:', e);
        }
    }

}

var RowCounter = 0;
var NewRowCounter = 0;
var OldRowCounter = 0;

function fadeBG(Target) {
    setInterval(function () {
        Target.removeClass('HotTag').addClass('EndHotTag');

    }, 0);

}

function ExecuteHistoryFilter(target) {
    $('[data-info="filter-div"]').addClass('d-none').find('input, select, textarea').prop("disabled", true);
    $('[data-info="filter-div"][data-target="' + target + '"]').removeClass('d-none').find('input, select, textarea').prop("disabled", false);

    var filterData = $('#FormExecuteHistoryFilter').serialize();
    var thiss = $("a[data-target=" + target + "][data-info=pendingBtn]");

    if(thiss.hasClass('running')){

    } else {


        $('a[data-info="pendingBtn"]').prop('disabled', true).removeClass(function (index, className) {
            return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
        });
        $('a[data-info="pendingBtn"]').prop('disabled', true).addClass('btn-default');
        var TableName = '#mainTicketHistory';
        thiss.removeClass(function (index, className) {
            return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
        });
        thiss.addClass('running btn-warning');
        thiss.find('.ld').show(); // نمایش loader داخل دکمه
        $('.table-responsive').addClass('running ld-over'); // اضافه کردن loading overlay
        var DataTarget = thiss.attr('data-target');
        var bussy = false;
        var TableDivision = $('table' + TableName);


        if(bussy === false){
            bussy = true;
            $.ajax({
                url: amadeusPath + 'user_ajax.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    filter: filterData,
                    target: target,
                    flag: 'mainTicketHistory',
                },
                success: function (data) {
                    thiss.removeClass(function (index, className) {
                        return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                    });
                    thiss.removeClass(function (index, className) {
                        return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                    });
                    thiss.addClass('btn-success');

                    // ابتدا DataTable را destroy کن
                    if($.fn.DataTable.isDataTable(TableName)){
                        $(TableName).DataTable().clear().destroy();
                    }
                    // سپس محتوا را خالی کن
                    TableDivision.html('');

                    // بررسی داده دریافتی (دیگر نیازی به JSON.parse نداریم چون dataType: 'json' است)
                    var JsonData = data;

                    if(JsonData !== null && typeof JsonData === 'object' && (typeof JsonData.new !== "undefined" || typeof JsonData.data !== "undefined")){

                        NewRowCounter = (typeof JsonData.new !== "undefined" ? JsonData.new.length : '');
                        OldRowCounter = (typeof JsonData.data !== "undefined" ? JsonData.data.length : '');
                        RowCounter = NewRowCounter + OldRowCounter;


                        $('#RowCounter').val(RowCounter);
                        TableDivision.html("<thead><tr></tr></thead><tbody></tbody><tfoot></tfoot>");
                        var TableThead = TableDivision.find('thead tr');
                        var TableTbody = TableDivision.find('tbody');
                        var TableTfooter = TableDivision.find('tfoot');
                        var TableTbodyHtml = '';
                        var TableTfooterHtml = '';

                        if(typeof JsonData.new !== "undefined"){

                            var eachNewCounter = 0;
                            $.each(JsonData.new, function (key, value) {
                                if(eachNewCounter == 0){
                                    $.each(value, function (key, value) {
                                        if(key !== '' && key !== "رنگ"){
                                            TableThead.append('<th>' + key + '</th>');
                                        }
                                    });
                                }
                                var bgColor = value["رنگ"] || '';
                                var styleAttr = '';
                                if (bgColor != '') {
                                    styleAttr = ' style="background-color:' + bgColor + ' !important;"';
                                }
                                TableTbodyHtml += '<tr class="HotTag"' + styleAttr + '>';
                                $.each(value, function (key, value) {
                                    if(key !== '' && key !== "رنگ"){
                                        TableTbodyHtml += '<td>' + value + '</td>';
                                    }
                                });
                                TableTbodyHtml += '</tr>';
                                eachNewCounter = eachNewCounter + 1;
                            });
                        }
                        if(typeof JsonData.data !== "undefined"){

                            var eachCounter = 0;
                            $.each(JsonData.data, function (key, value) {
                                if(eachCounter == 0 && (NewRowCounter == 0 && OldRowCounter != 0)){
                                    $.each(value, function (key, value) {
                                        if(key !== '' && key !== "رنگ"){
                                            TableThead.append('<th>' + key + '</th>');
                                        }
                                    });
                                }
                                var bgColor = value["رنگ"] || '';
                                var styleAttr = '';
                                if (bgColor != '') {
                                    styleAttr = ' style="background-color:' + bgColor + ' !important;"';
                                }
                                TableTbodyHtml += '<tr' + styleAttr + '>';
                                $.each(value, function (key, value) {
                                    if (key !== '' && key !== "رنگ") {
                                        TableTbodyHtml += '<td>' + value + '</td>';
                                    }
                                });
                                TableTbodyHtml += '</tr>';
                                eachCounter = eachCounter + 1;
                            });
                        }
                        TableTbody.append(TableTbodyHtml);

                        if(typeof JsonData.footer !== "undefined"){

                            $.each(JsonData.footer, function (key, value) {
                                TableTfooterHtml += '<tr>';
                                TableTfooterHtml += value;
                                TableTfooterHtml += '</tr>';
                            });
                            TableTfooter.append(TableTfooterHtml);
                        }

                        // فقط اگر جدول header داشت، DataTable را initialize کن
                        if($('#mainTicketHistory thead tr th').length > 0){
                            DataTableMaker('#mainTicketHistory');
                        }
                        $(".popoverBox").popover({trigger: "hover"});
                        $('[data-toggle="tooltip"]').tooltip();
                        $('[data-toggle="hover"]').popover();
                        $('[data-toggle="popover"]').popover();

                        bussy = false;
                        $('.table-responsive').removeClass('running ld-over'); // حذف loading overlay
                        $('.table-responsive .ld.ld-ring.ld-spin').hide(); // مخفی کردن loader داخل table
                        thiss.removeClass('running btn-warning'); // حذف کامل running و btn-warning
                        $('a[data-info="pendingBtn"]').find('.ld.ld-ring.ld-spin').hide(); // مخفی کردن همه loader های دکمه‌ها
                        $('a[data-info="pendingBtn"]').prop('disabled', false);
                        $('a[data-info="pendingBtn"]').removeClass('running'); // حذف running از همه دکمه‌ها
                        fadeBG($('.HotTag'));

                    } else {
                        TableDivision.html('موردی یافت نشد');
                        bussy = false;
                        $('.table-responsive').removeClass('running ld-over'); // حذف loading overlay
                        $('.table-responsive .ld.ld-ring.ld-spin').hide(); // مخفی کردن loader داخل table
                        thiss.removeClass(function (index, className) {
                            return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                        });
                        thiss.removeClass('running').addClass('btn-danger');
                        $('a[data-info="pendingBtn"]').find('.ld.ld-ring.ld-spin').hide(); // مخفی کردن همه loader های دکمه‌ها
                        $('a[data-info="pendingBtn"]').prop('disabled', false);
                        $('a[data-info="pendingBtn"]').removeClass('running'); // حذف running از همه دکمه‌ها
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    TableDivision.html('خطا در دریافت اطلاعات: ' + error);
                    bussy = false;
                    $('.table-responsive').removeClass('running ld-over'); // حذف loading overlay
                    $('.table-responsive .ld.ld-ring.ld-spin').hide(); // مخفی کردن loader داخل table
                    thiss.removeClass(function (index, className) {
                        return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                    });
                    thiss.removeClass('running').addClass('btn-danger');
                    $('a[data-info="pendingBtn"]').find('.ld.ld-ring.ld-spin').hide(); // مخفی کردن همه loader های دکمه‌ها
                    $('a[data-info="pendingBtn"]').prop('disabled', false);
                    $('a[data-info="pendingBtn"]').removeClass('running'); // حذف running از همه دکمه‌ها
                }
            });
            CheckReserveHotelTab();
        }
    }
}

function ExecuteExcelFilter(thiss) {
    var TargetFile = thiss.attr('data-target-file');
    var target = thiss.attr('data-target');
    var FilterData = $('#FormExecuteHistoryFilter').serialize();
    console.log("FilterData: ", FilterData)
    thiss.addClass('running btn-default').removeClass('btn-primary');
    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + TargetFile,
            data: FilterData,
            success: function (data) {

                thiss.addClass('btn-primary').removeClass('running btn-default');

                var res = data.split('|');
                if(data.indexOf('success') > -1){

                    var url = amadeusPath + 'pic/excelFile/' + res[1];
                    var isFileExists = fileExists(url);
                    if(isFileExists){
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


                }
                else {

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
function CheckReserveHotelTab(){
    $.post(amadeusPath + 'hotel_ajax.php',
        {
            flag: "checkReserveHotel"
        },
        function (data) {
            if (parseInt(data) > 0){
                $('a[data-target="hotel-list2"][data-info="pendingBtn"]').addClass('reap_admin_note');
            } else {
                $('a[data-target="hotel-list2"][data-info="pendingBtn"]').removeClass('reap_admin_note');

            }
        });
}

function selectTextMessage(_this){
    const sample_text=$('input[name="sample_sms_text"]').val()
    let new_text=''
    const content=$('#contentSms')
    switch (_this.val()) {
        case 'Delay':
            new_text=' با تغییر در ساعت 00:00 مورخ --/--/-- انجام خواهد شد. در صورت عدم تمایل به استفاده از پرواز در ساعت جدید لطفا حداکثر تا ساعت 00:00 مورخ --/--/-- جهت استرداد بلیط اقدام نمایید .'
        break;
        case 'HurryUp':
            new_text=' با تغییر در ساعت 00:00 مورخ --/--/-- انجام خواهد شد. در صورت عدم تمایل به استفاده از پرواز در ساعت جدید لطفا حداکثر تا ساعت 00:00 مورخ --/--/-- جهت استرداد بلیط اقدام نمایید .'
        break;
        case 'Cancel':
            new_text=' باطل میباشد . لذا خواهشمند است جهت استرداد بلیت و برگشت وجه اقدام فرمایید . '
        break;
    }
    content.val(sample_text+new_text)
}

function ModalCancelFlightAdmin(RequestNumber , type) {
    $.post(libraryPath + 'ModalCreator.php', {
           Controller: 'user',
           requestNumber: RequestNumber,
           Method: 'ModalCancelFlightAdmin',
           Param: RequestNumber,
           ParamId: type
       },
       function (data) {
           $("#ModalPublic").html(data);
       });
}

function ModalCancelHotelAdmin(factorNumber , type) {
    $.post(libraryPath + 'ModalCreator.php', {
           Controller: 'user',
           typeApplication: type,
           factorNumber: factorNumber,
           Param: factorNumber,
           Method: 'ModalCancelHotelAdmin',
       },
       function (data) {
           $("#ModalPublic").html(data);
       });
}



function DirectCancellationFlightAdmin(RequestNumber) {
    

    var National = [];
    var Reasons = $('#ReasonUser').val();
    var FactorNumber = $('#FactorNumber').val();
    var MemberId = $('#MemberId').val();
    var AccountOwner = $('#AccountOwner').val();
    var CardNumber = $('#CardNumber').val();
    var NameBank = $('#NameBank').val();
    var backCredit = $('#backCredit').val();
    var typeService = $('#typeService').val();
    if ($('#PercentNoMatter').is(':checked')) {
        var PercentNoMatter = 'Yes';
    } else {
        var PercentNoMatter = 'No';
    }

//    var passenger_age = $('#passenger_age').val();

    National = $('.SelectUser:checked').map(function () {


        return $(this).val();

    });

    var NationalCodes = National.get();

    //

    var DescriptionClient = $('#DescriptionClient').val();
    if($('#isCreditPayment').length > 0)
    {
        var isCreditPayment = $('#isCreditPayment').is(':checked');
    }else{
        var isCreditPayment = $('#isCreditPayment').is(':checked');
    }

    $.confirm({
        theme: 'supervan' , // 'material', 'bootstrap'
        title: 'ثبت کنسلی',
        icon: 'fa fa-trash',
        content: 'آیا از ثبت کنسلی اطمینان دارید ؟',
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
                           NationalCodes: NationalCodes,
                           Reasons: Reasons,
                           FactorNumber: FactorNumber,
                           RequestNumber: RequestNumber,
                           MemberId: MemberId,
                           AccountOwner: AccountOwner,
                           CardNumber: CardNumber,
                           NameBank: NameBank,
                           backCredit: backCredit,
                           PercentNoMatter: PercentNoMatter,
                           typeService: typeService,
                           DescriptionClient: DescriptionClient,
                           isCreditPayment: isCreditPayment,
                           flag: 'DirectCancellationFlightAdmin'
                       },
                       function (data) {
                           console.log(data)
                           var res = JSON.parse(data);
                           console.log(res)
                           if (res.success) {
                               $.toast({
                                   heading: 'ثبت کنسلی',
                                   text: res.message,
                                   position: 'top-right',
                                   loaderBg: '#fff',
                                   icon: 'success',
                                   hideAfter: 2000,
                                   textAlign: 'right',
                                   stack: 6,

                               });
                               setTimeout(function() {
                                   $('.modal').modal('hide');
                               }, 200);

                           } else {
                               $.toast({
                                   heading: 'ثبت کنسلی',
                                   text: res.message,
                                   position: 'top-right',
                                   loaderBg: '#fff',
                                   icon: 'error',
                                   hideAfter: 2000,
                                   textAlign: 'right',
                                   stack: 6
                               });
                               setTimeout(function() {
                                   $('.modal').modal('hide');
                               }, 200);
                           }
                           setTimeout(function() {
                               console.log('sdfsfsf');
                               $('.modal').modal('hide');
                           }, 200);

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

function DirectCancellationHotelAdmin(typeApplication, factorNumber) {

    if ($('#Ruls').is(':checked')) {

        $("form#cancelBuyForm").find('#typeService').val(typeService);
        $("form#cancelBuyForm").find('#factorNumber').val(factorNumber);
        var form = $("#cancelBuyForm");
        var formData = $(form).serializeArray();
        var formArray = {};
        $.each(formData, function() {
            formArray[this.name] = this.value;
        });
        var DescriptionClient = $('#DescriptionClient').val();

        var typeService = typeApplication;
        var FactorNumber = formArray['FactorNumber'];
        var commentUser = formArray['comment'];
        var cardNumber = formArray['cardNumber'];
        var AccountOwner = formArray['accountOwner'];
        var backCredit = formArray['backCredit'];
        var Status = 'RequestMember';
        var NameBank = formArray['NameBank'];

        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: 'ثبت کنسلی',
            icon: 'fa fa-trash',
            content: 'آیا از ثبت کنسلی اطمینان دارید ؟',
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
                               typeService: typeApplication,
                               FactorNumber: FactorNumber,
                               RequestNumber: FactorNumber,
                               commentUser: commentUser,
                               CardNumber: cardNumber,
                               AccountOwner: AccountOwner,
                               Status: Status,
                               NameBank: NameBank,
                               backCredit: backCredit,
                               DescriptionClient: DescriptionClient,
                               isCreditPayment: false,
                               Indemnity: '',
                               flag: 'DirectCancellationHotelAdmin'
                           },
                           function (data) {
                               console.log(data)
                               var res = JSON.parse(data);
                               console.log(res)
                               if (res.success) {
                                   $.toast({
                                       heading: 'ثبت کنسلی',
                                       text: res.message,
                                       position: 'top-right',
                                       loaderBg: '#fff',
                                       icon: 'success',
                                       hideAfter: 2000,
                                       textAlign: 'right',
                                       stack: 6,

                                   });
                                   setTimeout(function() {
                                       console.log('sdfsdfs');
                                       $('.modal').modal('hide');
                                   }, 200);
                               } else {
                                   $.toast({
                                       heading: 'ثبت کنسلی',
                                       text: res.message,
                                       position: 'top-right',
                                       loaderBg: '#fff',
                                       icon: 'error',
                                       hideAfter: 2000,
                                       textAlign: 'right',
                                       stack: 6
                                   });
                                   setTimeout(function() {
                                       $('.modal').modal('hide');
                                   }, 200);
                               }
                               setTimeout(function() {
                                   $('.modal').modal('hide');
                               }, 200);
                           });
                    }
                },
                cancel: {
                    text: 'انصراف',
                    btnClass: 'btn-orange',
                }
            }
        });



    } else {
        $.alert({
            title: 'ارسال درخواست کنسلی رزرو',
            icon: 'fa fa-times',
            content: 'لطفا قوانین را مطالعه کرده و انتخاب نمائید',
            rtl: true,
            type: 'red'
        });

    }




}
function FuncreateExcelForRavisFlight() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');
    $('#FormExecuteHistoryFilter input[name="flag"]').val('createExcelForRavisFlight');
    $('#FormExecuteHistoryFilter select[name="successfull"]').val('book').trigger('change');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            data: $('#FormExecuteHistoryFilter').serialize(),
            success: function (data) {
                $('#btn-excel').css('opacity', '1');
                $('#loader-excel').addClass('displayN');
                var res = data.split('|');
                if (data.indexOf('success') > -1) {
                    var url = amadeusPath + 'pic/excelFile/' + res[1];
                    var isFileExists = fileExists(url);
                    if (isFileExists) {
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
function FuncreateExcelForRavisHotel() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');
    $('#FormExecuteHistoryFilter input[name="flag"]').val('createExcelForRavisHotel');
    $('#FormExecuteHistoryFilter select[name="successfull"]').val('book').trigger('change');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            data: $('#FormExecuteHistoryFilter').serialize(),
            success: function (data) {
                $('#btn-excel').css('opacity', '1');
                $('#loader-excel').addClass('displayN');
                var res = data.split('|');
                if (data.indexOf('success') > -1) {
                    var url = amadeusPath + 'pic/excelFile/' + res[1];
                    var isFileExists = fileExists(url);
                    if (isFileExists) {
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