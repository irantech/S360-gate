$(document).ready(function () {


    //data tables Option
    $('#trainHistory').DataTable();


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


// $('#trainHistory').DataTable({
//     "order": [
//         [0, 'desc']
//     ],
//     dom: 'lBfrtip',
//     // buttons: [
//     //     'copy', 'excel', 'print'
//     // ]
//     buttons: [
//         {
//             extend: 'excel',
//             text: 'دریافت فایل اکسل',
//             exportOptions: {}
//         },
//         {
//             extend: 'print',
//             text: 'چاپ سطر های لیست',
//             exportOptions: {}
//         },
//         {
//             extend: 'copy',
//             text: 'کپی لیست',
//             exportOptions: {}
//         }
//
//     ]
// });


function ModalShowBookForTrain(ticketnumber) {
    $('#ModalPublic').html('<div class="modal-dialog modal-lg"><div class="modal-content">لطفا صبر کنید ...</div></div>');
    $.post(libraryPath + 'ModalCreatorTrain.php',
        {
            Controller: 'booktrainshow',
            Method: 'ModalShowBook',
            ticketnumber: ticketnumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}

function  hideInput(Priority,Code,Destination) {
    if(typeof Destination =='undefined')
    {
        Destination ="";
    }
    $('#priority'+Priority+Destination+Code).hide();
    $('#'+Code+Destination + Priority).html(Priority);
    $('#'+Code +Destination + Priority).attr('onclick',"EditInPlaceArrival('"+Code +"',"+"'"+Priority+"',"+"'"+Destination+"')");
}


function EditInPlaceTrain(Code, Priority,Destination) {

    if(typeof Destination =='undefined')
    {
        Destination ="";
    }
    $('#'+Code +Destination + Priority).html('');
    $('#'+Code + Destination + Priority).append('<input class="form-control" name="priority'+Code+ Destination + Priority+'" value="'+ Priority +'" id="priority' + Code + Destination+Priority +'" onchange="SendPriorityTrain('+"'"+ Priority+"'"+','+"'"+ Code+"'"+','+"'"+ Destination+"'"+')" onblur="hideInput('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')">');
    $('#'+Code + Destination + Priority).attr('onclick','return false');
}

function SendPriorityTrain(Priority,Code,Destination) {

    if(typeof Destination =='undefined')
    {
        Destination ="";
    }


    var PriorityNew = $('#priority' + Code +Destination + Priority ).val();

    $.post(amadeusPath + 'train_ajax.php',
        {
            PriorityOld: Priority,
            PriorityNew: PriorityNew,
            CodeDeparture: Code,
            Destination: Destination,
            flag: 'ChangePriorityTrain'
        },
        function (data) {
            var res = data.split(':');
            if (data.indexOf('SuccessChangePriority') > -1)
            {

                $.toast({
                    heading: 'تغییر الویت',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                $('#'+Code + Priority).html(PriorityNew);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else
            {
                $.toast({
                    heading: 'تغییر الویت',
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
function createExcelForReportTour() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'train_ajax.php',
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


function getInfoTicketTrain(requestNumber) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'train_ajax.php',
        data: {
            flag: "getInfoTicketTrain",
            requestNumber : requestNumber
        },
        success: function (data) {
            if (data.indexOf('success') > -1) {

                    $.toast({
                        heading: 'دریافت اطلاعات بلیط',
                        text: 'اطلاعات بلیط با موفقیت ثبت شد',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

            } else {

                $.toast({
                    heading: 'دریافت اطلاعات بلیط',
                    text: 'خطا در ثبت اطلاعات بلیط',
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

}