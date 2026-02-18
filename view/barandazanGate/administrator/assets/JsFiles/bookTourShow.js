$(document).ready(function () {


    //data tables Option
    $('#tourHistory').DataTable();


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


function displayAdvanceSearch(Obj) {

    if ($(Obj).is(':checked') === true) {
        $('.showAdvanceSearch').fadeIn(500);
    } else {
        $('.showAdvanceSearch').fadeOut(500);
    }
}


$('#tourHistory').DataTable({
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


function ModalShowBookForTour(factorNumber) {

    $.post(libraryPath + 'ModalCreatorForTour.php',
        {
            Method: 'ModalShowBook',
            factorNumber: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}


function setTourPaymentsPriceA(factorNumber, paymentsPriceA) {

    /*$.post(amadeusPath + 'tour_ajax.php',
    {
        flag: 'setTourPaymentsPriceA',
        factorNumber : factorNumber,
        paymentsPriceA : paymentsPriceA
    },
    function (data) {

        if (data.indexOf('success') > -1) {
            $.alert({
                title: 'رزرو تور',
                icon: 'fa fa-refresh',
                content: 'ثبت پرداخت نقدی مبلغ ارزی تور با موفقیت انجام شد. ',
                rtl: true,
                type: 'red'
            });
        } else if (data.indexOf('errorLoginHotel') > -1) {
            $.alert({
                title: 'رزرو تور',
                icon: 'fa fa-refresh',
                content: 'خطا در ثبت تغییرات. لطفا مجددا تلاش کنید. ',
                rtl: true,
                type: 'red'
            });
        }

    });*/

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از تایید پرداخت نقدی مبلغ ارزی اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                        {
                            flag: 'setTourPaymentsPriceA',
                            factorNumber : factorNumber,
                            paymentsPriceA : paymentsPriceA
                        },
                        function (data) {

                            if (data.indexOf('success') > -1) {

                                $.alert({
                                    title: 'رزرو تور',
                                    icon: 'fa fa-refresh',
                                    content: 'ثبت پرداخت نقدی مبلغ ارزی تور با موفقیت انجام شد. ',
                                    rtl: true,
                                    type: 'green'
                                });

                            } else if (data.indexOf('errorLoginHotel') > -1) {
                                $.alert({
                                    title: 'رزرو تور',
                                    icon: 'fa fa-refresh',
                                    content: 'خطا در ثبت تغییرات. لطفا مجددا تلاش کنید. ',
                                    rtl: true,
                                    type: 'red'
                                });
                            }

                            setTimeout(function () {
                                location.reload();
                            }, 1000);

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





function createExcelForReportTour() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'tour_ajax.php',
            data: $('#SearchTourHistory').serialize(),
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
function changeRequestedTourStatus(_this,factor_number,status) {
    $.ajax({
        url: amadeusPath + 'ajax',
        data: JSON.stringify({
            className: 'requestReservation',
            method: 'callChangeStatus',
            serviceName: 'tour',
            status: status,
            factor_number: factor_number

        }),
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {

            _this.parent().find('button').each(function(){
                $(this).addClass('btn-outline');
                if($(this).data('name') == status){
                    $(this).removeClass('btn-outline');

                }
            })

            $.toast({
                heading: 'ویرایش شد',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        },
        complete: function() {

        },
    })
}
function changeRequestedEntertainmentStatus(_this,factor_number,status) {
  $.ajax({
    url: amadeusPath + 'ajax',
    data: JSON.stringify({
      className: 'requestReservation',
      method: 'callChangeStatus',
      serviceName: 'entertainment',
      status: status,
      factor_number: factor_number

    }),
    type: 'POST',
    dataType: 'JSON',
    success: function(response) {

      _this.parent().find('button').each(function(){
        $(this).addClass('btn-outline');
        if($(this).data('name') == status){
          $(this).removeClass('btn-outline');

        }
      })

      $.toast({
        heading: 'ویرایش شد',
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
      });

    },
    complete: function() {

    },
  })
}
function changeRequestedTourPrice(_this,factor_number) {
    $.ajax({
        url: amadeusPath + 'ajax',
        data: JSON.stringify({
            className: 'requestReservation',
            method: 'callChangePrice',
            serviceName: 'tour',
            price: _this.val(),
            factor_number: factor_number

        }),
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {

            $.toast({
                heading: 'ویرایش شد',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        },
        complete: function() {

        },
    })
}