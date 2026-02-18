$(document).ready(function () {

    // $('#cancelTicketRequest').ajaxForm({
    //
    //     beforeSubmit: function (arr, $form, options) {
    //         var check = false;
    //         var nameFilde = [
    //             "price",
    //             "comment"
    //         ];
    //
    //         for (var i = 0; i < nameFilde.length; i++) {
    //             if ($('#' + nameFilde[i]).val() == "" && nameFilde[i] != "") {
    //                 check = true;
    //                 $.alert({
    //                     title: ' تایید کنسلی خرید',
    //                     icon: 'fa fa-info-circle',
    //                     content: 'لطفا ' + $('#' + nameFilde[i]).parent('.input-group').parent('.form-group').find('label').text() + ' ' + 'را وارد نمائید',
    //                     rtl: true,
    //                     type: 'orange',
    //                 });
    //             }
    //         }
    //
    //         if (check) {
    //             return false;
    //         }
    //
    //     },
    //     success: function (data) {
    //
    //         var res = data.split(':');
    //         if (data.indexOf('success') > -1) {
    //             $.alert({
    //                 title: ' تایید کنسلی خرید',
    //                 icon: 'fa fa-info-circle',
    //                 content: res[1],
    //                 rtl: true,
    //                 type: 'green',
    //             });
    //             setTimeout(function () {
    //                 $('#cancelTicket-' + $('#RequestNumber').val()).removeAttr('onclick').attr('title', 'تایید شده').addClass('btn-success').addClass('fa-check').removeClass('fa-refresh').removeClass('btn-primary');
    //                 $('#myModal').modal('hide');
    //                 $('#del-' + $('#RequestNumber').val()).modal('hide');
    //                 location.href = "administratorlistCancel";
    //             }, 1000);
    //         } else {
    //             $.alert({
    //                 title: ' تایید کنسلی خرید',
    //                 icon: 'fa fa-info-circle',
    //                 content: res[1],
    //                 rtl: true,
    //                 type: 'red',
    //             });
    //         }
    //     }
    // });

});


function ModalShowBook(RequestNumber,type) {
    $('#ModalPublic').html(' ');
    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'ModalShowBook',
            Param: RequestNumber,
            ParamId: type
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function ModalTrackingCancelTicket(RequestNumber, Id, ClientId,transportType='flight') {


    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'user',
           Method: 'ModalShowInfoCancelForAdmin',
           Param: RequestNumber,
           transportType: transportType,
           ParamId: Id,
           ParamClientId: ClientId
       },
       function (data) {

           $('#ModalPublic').html(data);

       });
}

function ShowModalPercent(RequestNumber, Id, ClientId,transportType) {
    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'listCancel',
            Method: 'ShowModalPercent',
            Param: RequestNumber,
            ParamId: Id,
            ParamClientId: ClientId,
            transportType: transportType
        },
        function (data) {

            $('#ModalPublic').html(data);

        });

}

function FinalConfirm(RequestNumber, Id, ClientId,pnr) {
    let data = {
        RequestNumber: RequestNumber,
        pnr: pnr
    };
    $.post(libraryPath + 'ModalCreator.php',
       {
           Controller: 'listCancel',
           Method: 'FinalConfirm',
           Param: data,
           ParamId: Id,
           ParamClientId: ClientId
       },
       function (data) {

           $('#ModalPublic').html(data);

       });

}

function SendPercentForAgency(RequestNumber, id, ClientId) {

    var DescriptionAdmin = $('#DescriptionAdmin').val();
    var PercentIndemnity = $('#PercentIndemnity').val();
    var DescriptionClient = $('#DescriptionClient').val();
    $("#DescriptionAdmin").focus(function () {
        $(this).css("background", "#fff");
    });
    $("#PercentIndemnity").focus(function () {
        $(this).css("background", "#fff");
    });
    if (DescriptionAdmin == "" || PercentIndemnity == "") {
        $.toast({
            heading: 'ارسال درصد جریمه',
            text: 'لطفا موارد لازم را وارد نمائید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        if (DescriptionAdmin == "") {

            $('#DescriptionAdmin').css('background-color', '#FF0000');
        }
        if (PercentIndemnity == "") {

            $('#PercentIndemnity').css('background-color', '#FF0000');
        }
    } else {
        $.confirm({
            theme: 'supervan',// 'material', 'bootstrap'
            title: 'ارسال درصد جریمه',
            icon: 'fa fa-percent',
            content: 'آیا از ارسال اطلاعات  اطمینان دارید',
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
                                id: id,
                                ClientId: ClientId,
                                DescriptionAdmin: DescriptionAdmin,
                                PercentIndemnity: PercentIndemnity,
                                flag: 'SendPercentForAgency'
                            },
                            function (data) {
                                var res = data.split(':');

                                if (data.indexOf('success') > -1) {

                                    $.toast({
                                        heading: 'ارسال درصد جریمه',
                                        text: res[1],
                                        position: 'top-right',
                                        loaderBg: '#fff',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        textAlign: 'right',
                                        stack: 6
                                    });

                                    setTimeout(function () {
                                        $('#RequestClientBtn-' + id).attr('onclick', 'return false').removeAttr('data-toggle').removeAttr('data-target').removeClass('btn btn-success  mdi mdi-percent ').addClass('btn btn-warning mdi mdi-timer ').parent().attr('data-original-title', 'انتظار برای پاسخ آژانس').attr('data-content', 'در انتظار پاسخ آژانس بابت درصد اعلامی از سوی کارگزار');
                                        $('#RequestClientStatus-' + id).html('تعیین درصد جریمه');
                                        $('#ModalPublic').modal('hide');
                                        location.reload();
                                    }, 1000);
                                } else {
                                    $.toast({
                                        heading: 'ارسال درصد جریمه',
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


}

function SendPriceForCalculate(RequestNumber, id, ClientId) {

    var PriceIndemnity = $('#PriceIndemnity').val();
    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تایید نهایی درخواست',
        icon: 'fa fa-check',
        content: 'آیا از ارسال اطلاعات  اطمینان دارید',
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
                            id: id,
                            ClientId: ClientId,
                            PriceIndemnity: PriceIndemnity,
                            flag: 'SendPriceForCalculate'
                        },
                        function (data) {
                            var res = data.split(':');

                            if (data.indexOf('success') > -1) {

                                $.toast({
                                    heading: 'تایید نهایی درخواست',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {

                                    $('#ConfirmClient-' + id).attr('onclick', 'return false').removeAttr('data-toggle').removeAttr('data-target').removeClass('btn btn-info  mdi mdi-bookmark-check ').addClass('btn btn-success mdi mdi-check ').parent().attr('data-original-title', 'تایید نهایی').attr('data-content', 'درخواست به تایید نهایی رسیده است و مبلغ مسترد شده است').removeClass('popover-info').addClass('popover-success');
                                    $('#ConfirmClientStatus-' + id).removeClass('btn-info').addClass('btn-success').html('تایید نهایی');
                                    $('#ModalPublic').modal('hide');
                                }, 1000);
                            } else {
                                $.toast({
                                    heading: 'تایید نهایی درخواست',
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

function showModalTicketClose(id, clientId) {
    $('#ModalPublic').html(' ');
    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'listCancel',
            Method: 'showModalTicketClose',
            Param: id,
            ParamId: clientId
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
}

function showModalNote(id, clientId, note) {
    $('#ModalPublic').html('');

    const payload = {
        id: id,
        client_id: clientId,
        note: note
    };

    $.post(libraryPath + 'ModalCreator.php', {
        Controller: 'listCancel',
        Method: 'showModalNote',
        Param: JSON.stringify(payload)
    }, function (data) {
        $('#ModalPublic').html(data);
    });
}


function setTicketClose(id, clientId) {

    var descriptionClose = $('#descriptionClose').val();

    if (descriptionClose == "") {
        $.toast({
            heading: 'بسته شدن بلیط',
            text: 'لطفا موارد لازم را وارد نمائید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        if (descriptionClose == "") {
            $('#descriptionClose').css('background-color', '#FF0000');
        }
    } else {
        $.confirm({
            theme: 'supervan',// 'material', 'bootstrap'
            title: 'بسته شدن بلیط',
            icon: 'fa fa-percent',
            content: 'آیا از ارسال اطلاعات  اطمینان دارید',
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
                                id: id,
                                clientId: clientId,
                                descriptionClose: descriptionClose,
                                flag: 'setTicketClose'
                            },
                            function (data) {
                                var res = data.split(':');
                                if (data.indexOf('success') > -1) {

                                    $.toast({
                                        heading: 'بسته شدن بلیط',
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
                                        heading: 'بسته شدن بلیط',
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


}

function setCancelNote(id, client_id) {

    var note_admin = $('#note_admin').val();

    if (note_admin === "") {
        $.toast({
            heading: 'یادداشت',
            text: 'لطفا موارد لازم را وارد نمائید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        if (note_admin === "") {
            $('#note_admin').css('background-color', '#FF0000');
        }
    } else {
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'JSON',
            data:  JSON.stringify({
                className: 'listCancel',
                method: 'setCancelNote',
                id,
                client_id,
                note_admin
            }),
            success: function (data) {
                $.toast({
                    heading: 'یادداشت',
                    text: data.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function () {
                    window.location.reload();
                }, 200);

            },
            error:function(error) {
                console.log(error)
                $.toast({
                    heading: 'یادداشت',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            },
            complete: function() {
                // setTimeout(function() {
                //     $('#ModalPublic').hide();
                // }, 500)
            },
        });

    }


}
function setExpireTime(id, client_id) {

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'JSON',
            data:  JSON.stringify({
                className: 'listCancel',
                method: 'setExpireTime',
                id,
                client_id
            }),
            success: function (data) {
                $.toast({
                    heading: 'ثبت خارج از تایم',
                    text: data.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            },
            error:function(error) {
                console.log(error)
                $.toast({
                    heading: 'ثبت خارج از تایم',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            },
            complete: function() {
                // setTimeout(function() {
                //     $('#ModalPublic').hide();
                // }, 500)
            },
        });
}
function changePercentIndemnity(id,clientId) {
    var changePercentIndemnity = $('#changePercentIndemnity'+clientId+id).val();

    if (changePercentIndemnity == "") {
        $.toast({
            heading: 'تغییر درصد جریمه کنسلی بلیط',
            text: 'لطفا درصد را وارد نمائید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });

    } else {
        $.confirm({
            theme: 'material',// 'material', 'bootstrap'
            title:  'تغییر درصد جریمه کنسلی بلیط',
            icon: 'fa fa-percent',
            content: 'آیا از ارسال اطلاعات  اطمینان دارید',
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
                                id: id,
                                clientId: clientId,
                                changePercentIndemnity: changePercentIndemnity,
                                flag: 'changePercentIndemnity'
                            },
                            function (data) {
                                var res = data.split(':');
                                if (data.indexOf('success') > -1) {

                                    $.toast({
                                        heading: 'بسته شدن بلیط',
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
                                        heading: 'بسته شدن بلیط',
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
}


function cancelAltrabo(requestNumber,transportType,ClientId) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            transportType: transportType,
            ClientId: ClientId,
            requestNumber: requestNumber,
            flag: 'cancelAltrabo'
        },
        function (data) {

        console.table(data);

        var datafinal = JSON.parse(data);

        console.table(datafinal);
            if (datafinal.status) {

                $.toast({
                    heading: 'کنسل شدن بلیط',
                    text: datafinal.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });


            } else {
                $.toast({
                    heading: 'کنسل شدن بلیط',
                    text: datafinal.message,
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
function separator(txt){
    var iDistance = 3;
    var strChar = ",";
    var strValue = txt.value;

    if(strValue != 'undefined' &&  strValue.length>3){
        var str="";
        for(var i=0;i<strValue.length;i++){
            if(strValue.charAt(i)!=strChar){
                if ((strValue.charAt(i) >= 0) && (strValue.charAt(i) <= 9)){
                    str=str+strValue.charAt(i);
                }
            }
        }

        strValue=str;
        var iPos = strValue.length;
        iPos -= iDistance;
        while(iPos>0){
            strValue = strValue.substr(0,iPos)+strChar+strValue.substr(iPos);
            iPos -= iDistance;
        }
    }
    txt.value=strValue;
}
