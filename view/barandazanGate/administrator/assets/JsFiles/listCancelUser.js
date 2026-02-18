    $(document).ready(function () {

    });


    function ModalShowBook(RequestNumber,type) {









        $.post(libraryPath + 'ModalCreator.php',
            {
                Controller: 'user',
                Method: 'ModalShowBook',
                Param: RequestNumber,
                ParamId: type
            },
            function (data) {

                $('#ModalPublic').html(data);

            });
    }

    function ModalTrackingCancelTicket(RequestNumber, id,transportType='flight') {



        $.post(libraryPath + 'ModalCreator.php',
            {
                Controller: 'user',
                Method: 'ModalTrackingCancelTicketAdmin',
                Param: RequestNumber,
                transportType: transportType,
                ParamId: id
            },
            function (data) {

                $('#ModalPublic').html(data);

            });
    }
    // function ShowModalPercent(RequestNumber, Id, ClientId,transportType) {
    //     $.post(libraryPath + 'ModalCreator.php',
    //        {
    //            Controller: 'listCancel',
    //            Method: 'ShowModalPercent',
    //            Param: RequestNumber,
    //            ParamId: Id,
    //            ParamClientId: ClientId,
    //            transportType: transportType
    //        },
    //        function (data) {
    //
    //            $('#ModalPublic').html(data);
    //
    //        });
    //
    // }

    function UserShowModalPercent(RequestNumber, Id, ClientId,transportType) {
        $.post(libraryPath + 'ModalCreator.php',
           {
               Controller: 'listCancel',
               Method: 'UserShowModalPercent',
               Param: RequestNumber,
               ParamId: Id,
               ParamClientId: ClientId,
               transportType: transportType
           },
           function (data) {

               $('#ModalPublic').html(data);

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
                                           window.location.reload();
                                           $('#ModalPublic').modal('hide');
                                       }, 500);

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
    function UserSendPercentForAgency(RequestNumber, id, ClientId) {

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
                                   flag: 'UserSendPercentForAgency'
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

    function ShowModalConfirmCancel(RequestNumber, id) {
        $.post(libraryPath + 'ModalCreator.php',
            {
                Controller: 'user',
                Method: 'ShowModalConfirmCancel',
                Param: RequestNumber,
                ParamId: id
            },
            function (data) {

                $('#ModalPublic').html(data);

            });
    }


    function ShowModalConfirmCancelPrivate(RequestNumber, id) {
        $.post(libraryPath + 'ModalCreator.php',
            {
                Controller: 'user',
                Method: 'ModalConfirmCancelPrivate',
                Param: RequestNumber,
                ParamId: id
            },
            function (data) {

                $('#ModalPublic').html(data);

            });
    }

    function ShowModalFailedCancel(RequestNumber, id) {
        $.post(libraryPath + 'ModalCreator.php',
            {
                Controller: 'user',
                Method: 'ShowModalFailedCancel',
                Param: RequestNumber,
                ParamId: id
            },
            function (data) {

                $('#ModalPublic').html(data);

            });
    }

    function ConfirmCancelByAgency(RequestNumber, id,Indemnity) {
        var DescriptionClient = $('#DescriptionClient').val();
        var typeCancel = $('#typeCancel').val();
        if($('#isCreditPayment').length > 0)
        {
            var isCreditPayment = $('#isCreditPayment').is(':checked');
        }else{
            var isCreditPayment = $('#isCreditPayment').is(':checked');
        }

        console.log(isCreditPayment);

        var IndemnityFinal;
        if(Indemnity !=""){
            IndemnityFinal = Indemnity ;
        }else{
            IndemnityFinal ="";
        }

        $("#DescriptionClient").focus(function () {
            $(this).css("background", "#fff");
        });

            $("#DescriptionClient").focus(function () {
                $(this).css("background", "#fff");
            });
            if (DescriptionClient === "") {

                $.toast({
                    heading: ` کنسلی ${typeCancel}`,
                    text: 'لطفا توضیحات خود را وارد نمائید',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                $('#DescriptionClient').css('background-color', '#a94442');
            } else {
                $.confirm({
                    theme: 'supervan' ,// 'material', 'bootstrap'
                    title: ` کنسلی ${typeCancel}`,
                    icon: 'fa fa-bon',
                    content: 'آیا از تایید درخواست اطمینان دارید',
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
                                        DescriptionClient: DescriptionClient,
                                        isCreditPayment: isCreditPayment,
                                        Indemnity: IndemnityFinal,
                                        typeCancel: typeCancel,
                                        flag: 'ConfirmCancelByAgency'
                                    },
                                    function (data) {
                                        var res = data.split(':');
                                        if (data.indexOf('success') > -1) {
                                            $.toast({
                                                heading: ` کنسلی ${typeCancel}`,
                                                text: res[1],
                                                position: 'top-right',
                                                loaderBg: '#fff',
                                                icon: 'success',
                                                hideAfter: 3500,
                                                textAlign: 'right',
                                                stack: 6
                                            });

                                            setTimeout(function () {
                                                $('#FailedCancelRequestUser-'+ id).remove();
                                                $('#RequestMemberText-' + id).removeClass('btn btn-primary').addClass('btn btn-warning').html('انتظار تعیین درصد');
                                                $('#RequestMember-' + id ).attr('onclick','return false').removeAttr('data-toggle').removeAttr('data-target').removeClass('btn btn-success  mdi mdi-check').addClass('btn btn-warning mdi mdi-autorenew').parent().attr('data-original-title', 'در حال بررسی توسط کارگزار').attr('data-content', 'درخواست شما به سمت کارگزار هدایت شده است منتظر اعلام پاسخ باشید').removeClass('popover-success').addClass('popover-warning');
                                                $('#ModalPublic').modal('hide');


                                            }, 1000);
                                        } else {
                                            $.alert({
                                                title: ` کنسلی ${typeCancel}`,
                                                icon: 'fa fa-times',
                                                content: res[1],
                                                rtl: true,
                                                type: 'red',
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

    function FailedCancelByAgency(RequestNumber, id) {
        var DescriptionClient = $('#DescriptionClient').val();
        $("#DescriptionClient").focus(function () {
            $(this).css("background", "#fff");
        });
        if (DescriptionClient == "") {
            $.toast({
                heading: 'رد درخواست کنسلی پرواز',
                text: 'لطفا توضیحات خود را وارد نمائید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            $('#DescriptionClient').css('background-color', '#a94442');
        } else {
            $.confirm({
                theme: 'supervan' ,// 'material', 'bootstrap'
                title: 'رد درخواست کنسلی  پرواز',
                icon: 'fa fa-ban',
                content: 'آیا از رد درخواست اطمینان دارید',
                rtl: true,
                closeIcon: true,
                type: 'orange',
                buttons: {
                    confirm: {
                        text: 'رد درخواست',
                        btnClass: 'btn-red',
                        action: function () {
                            $.post(amadeusPath + 'user_ajax.php',
                                {
                                    RequestNumber: RequestNumber,
                                    id: id,
                                    DescriptionClient: DescriptionClient,
                                    flag: 'FailedCancelByAgency'
                                },
                                function (data) {
                                    var res = data.split(':');

                                    if (data.indexOf('success') > -1) {

                                        $.toast({
                                            heading: 'رد درخواست کنسلی پرواز',
                                            text: res[1],
                                            position: 'top-right',
                                            loaderBg: '#fff',
                                            icon: 'success',
                                            hideAfter: 3500,
                                            textAlign: 'right',
                                            stack: 6
                                        });

                                        setTimeout(function () {
                                            $('#RequestMemberText-' +id).removeClass('btn-primary').addClass('btn-danger').html('رد درخواست کاربر');
                                            $('#ConfirmCancelRequest-' +id).remove();
                                            $('#FailedCancel-' + id ).attr('onclick','return false').removeAttr('data-toggle').removeAttr('data-target').removeClass('btn btn-success  mdi mdi-check').addClass('btn btn-warning mdi mdi-do-not-disturb').parent().attr('data-original-title', 'رد درخواست توسط آژانس').attr('data-content', 'شما قبلا این در خواست را رد کرده اید،برای اقدام مجدد ،می بایستی کاربر خریدار مجددا اقدام به ارسال درخواست کنسلی نماید');
                                          $('#ModalPublic').modal('hide');
                                        }, 1000);
                                    } else {
                                        $.toast({
                                            heading: 'رد درخواست کنسلی پرواز',
                                            text: 'لطفا توضیحات خود را وارد نمائید',
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

    function ConfirmAgencyForPercent(RequestNumber, id,serviceType=null) {
        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: 'تایید درصد جریمه کنسلی ',
            icon: 'fa fa-check',
            content: 'آیا از تایید درصد تعیین شده اطمینان دارید',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید درصد',
                    btnClass: 'btn-green',
                    action: function () {
                        $.post(amadeusPath + 'user_ajax.php',
                            {
                                RequestNumber: RequestNumber,
                                id: id,
                                serviceType: serviceType,
                                flag: 'ConfirmAgencyForPercent'
                            },
                            function (data) {
                                var res = data.split(':');

                                if (data.indexOf('success') > -1) {
                                    $.toast({
                                        heading: 'تایید درصد جریمه کنسلی',
                                        text: res[1],
                                        position: 'top-right',
                                        loaderBg: '#fff',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        textAlign: 'right',
                                        stack: 6
                                    });


                                    setTimeout(function () {
                                        $('#FailedPercent-'+ id).remove();
                                        $('#ConfirmPercent-' + id ).attr('onclick','return false').removeClass('btn btn-success  mdi mdi-check').addClass('btn btn-info mdi mdi-timer').attr('data-original-title', 'انتظار تایید نهایی').attr('data-content', 'شما در صد اعلامی از سوی کارگزار را تایید کرده اید،لطفا  منتظر تایید نهایی باشید').removeClass('popover-success').addClass('popover-info');
                                        $('#ConfirmPercentBtn-' + id).removeClass('btn-warning').addClass('btn-info').html('تایید درصد توسط آژانس');
                                        $('#ModalPublic').modal('hide');
                                    }, 1000);
                                } else {
                                    $.toast({
                                        heading: 'تایید درصد جریمه کنسلی',
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

    function FailedAgencyForPercent(RequestNumber, id) {
        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: 'رد درصد جریمه کنسلی ',
            icon: 'fa fa-times',
            content: 'آیا از رد درصد تعیین شده اطمینان دارید',
            rtl: true,
            closeIcon: true,
            type: 'red',
            buttons: {
                confirm: {
                    text: 'رد درصد',
                    btnClass: 'btn-red',
                    action: function () {
                        $.post(amadeusPath + 'user_ajax.php',
                            {
                                RequestNumber: RequestNumber,
                                id: id,
                                flag: 'FailedAgencyForPercent'
                            },
                            function (data) {
                                var res = data.split(':');

                                if (data.indexOf('success') > -1) {

                                    $.toast({
                                        heading: 'رد درصد جریمه کنسلی',
                                        text: res[1],
                                        position: 'top-right',
                                        loaderBg: '#fff',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        textAlign: 'right',
                                        stack: 6
                                    });

                                    setTimeout(function () {
                                        $('#ConfirmPercent-' + id).remove();
                                        $('#FailedPercent-' + id ).attr('onclick','return false').removeClass('mdi-close-circle').addClass('mdi-close-octagon-outline').attr('data-original-title', 'رد درصد توسط آژانس').attr('data-content', 'شما در صد اعلامی از سوی کارگزار را رد کرده اید و می بایستی برای اقدام مجدد،کاربر مجددا درخواست داده و مراحل طی شود').removeClass('popover-success').addClass('popover-info');
                                        $('#ConfirmPercentBtn-' + id).removeClass('btn-warning').addClass('btn-danger').html('رد درصد توسط آژانس');
                                        $('#ModalPublic').modal('hide');
                                    }, 1000);
                                } else {
                                    $.toast({
                                        heading: 'رد درصد جریمه کنسلی',
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



    function savePercentAndPriceIndemnity(RequestNumber, id,ClientId) {
        var PriceIndemnity = $('#PriceIndemnity').val();
        var PercentIndemnity = $('#PercentIndemnity').val();
        var DescriptionClient = $('#DescriptionClient').val();
        $("#DescriptionClient").focus(function () {
            $(this).css("background", "#fff");
        });
        $("#PercentIndemnity").focus(function () {
            $(this).css("background", "#fff");
        });
        $("#PriceIndemnity").focus(function () {
            $(this).css("background", "#fff");
        });
        if (DescriptionClient == "" || PercentIndemnity == "" || PriceIndemnity=="") {
            $.toast({
                heading: 'ارسال درصد و مبلغ جریمه',
                text: 'لطفا موارد لازم را وارد نمائید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            if (DescriptionClient == "") {

                $('#DescriptionClient').css('background-color', '#5d1717');
            }
            if (PercentIndemnity == "") {

                $('#PercentIndemnity').css('background-color', '#5D1717');
            }
            if (PriceIndemnity == "") {

                $('#PriceIndemnity').css('background-color', '#5D1717');
            }
        } else {
            $.confirm({
                theme: 'supervan',// 'material', 'bootstrap'
                title: 'ارسال درصد و مبلغ جریمه',
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
                                    DescriptionClient: DescriptionClient,
                                    PercentIndemnity: PercentIndemnity,
                                    PriceIndemnity: PriceIndemnity,
                                    flag: 'ConfirmPercentAndPricePrivate'
                                },
                                function (data) {
                                    var res = data.split(':');

                                    if (data.indexOf('success') > -1) {

                                        $.toast({
                                            heading: 'ارسال درصد و مبلغ جریمه',
                                            text: res[1],
                                            position: 'top-right',
                                            loaderBg: '#fff',
                                            icon: 'success',
                                            hideAfter: 3500,
                                            textAlign: 'right',
                                            stack: 6
                                        });

                                        setTimeout(function () {
                                            $('#RequestMemberPrivate-' + id).attr('onclick', 'return false').removeAttr('data-toggle').removeAttr('data-target').removeClass('mdi-check').addClass('mdi-bookmark-check ').parent().attr('data-original-title', 'تایید نهایی آژانس بابت کنسلی پرواز سیستمی اختصاصی').attr('data-content', 'آژانس مربوطه درصد و مبلغ استرداد را اعلام و کنسلی را تایید کرده است');
                                            $('#FailedCancelRequestUserPrivate-' + id).remove();
                                            $('#ModalPublic').modal('hide');
                                        }, 1000);
                                    } else {
                                        $.toast({
                                            heading: 'ارسال درصد و مبلغ جریمه',
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




    function confirmCancelReservationTicket(requestNumber, id) {

        $.confirm({
            theme: 'supervan',// 'material', 'bootstrap'
            title: 'درخواست کنسلی',
            icon: 'fa fa-clock',
            content: 'آیا از تایید درخواست کنسلی اطمینان دارید؟',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید',
                    btnClass: 'btn-green',
                    action: function () {
                        $.post(amadeusPath + 'hotel_ajax.php',
                            {
                                requestNumber: requestNumber,
                                id: id,
                                flag: 'confirmCancelReservationTicket'
                            },
                            function (data) {

                                var res = data.split(':');
                                $.alert({
                                    title: 'درخواست کنسلی',
                                    icon: 'fa fa-cart-plus',
                                    content: res[1],
                                    rtl: true,
                                    type: 'red'
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            });
                    }
                },
                cancel: {
                    text: 'انصراف',
                    btnClass: 'btn-orange',
                    action: function () {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            }
        });

    }



    function ModalConfirmAdminReturnUserWallet(RequestNumber , ItemId , MemberId) {
            $.post(libraryPath + 'ModalCreator.php',
          {
              Controller: 'memberCredit',
              Method: 'returnCreditWallet',
              Param: RequestNumber,
              ParamId: ItemId,
              ParamClientId: MemberId
          },
          function (data) {

              $('#ModalPublic').html(data);

          });
    }


    function ModalConfirmAdminForReturnBank(RequestNumber , ItemId , MemberId , TypeCancel) {
        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: 'تایید واریز به حساب بانکی ',
            icon: 'fa fa-check',
            content: 'آیا از تایید انتقال پول به حساب کاربر اطمینان دارید',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: 'تایید انتقال',
                    btnClass: 'btn-green',
                    action: function () {
                        $.post(amadeusPath + 'user_ajax.php',
                          {
                              RequestNumber: RequestNumber,
                              ParamId: ItemId,
                              memberId: MemberId,
                              TypeCancel: TypeCancel,
                              flag: 'ConfirmReturnBankUser'

                          },
                          function (data) {
                              var res = data.split(':');

                              if (data.indexOf('success') > -1) {
                                  $.toast({
                                      heading: 'تایید انتقال به کارت کاربر',
                                      text: res[1],
                                      position: 'top-right',
                                      loaderBg: '#fff',
                                      icon: 'success',
                                      hideAfter: 3500,
                                      textAlign: 'right',
                                      stack: 6
                                  });


                                  setTimeout(function () {
                                      $('#FailedPercent-'+ id).remove();
                                      $('#ConfirmPercent-' + id ).attr('onclick','return false').removeClass('btn btn-success  mdi mdi-check').addClass('btn btn-info mdi mdi-timer').attr('data-original-title', 'انتظار تایید نهایی').attr('data-content', 'شما در صد اعلامی از سوی کارگزار را تایید کرده اید،لطفا  منتظر تایید نهایی باشید').removeClass('popover-success').addClass('popover-info');
                                      $('#ConfirmPercentBtn-' + id).removeClass('btn-warning').addClass('btn-info').html('تایید انتقال به حساب کاربر');
                                      $('#ModalPublic').modal('hide');
                                  }, 1000);
                              } else {
                                  $.toast({
                                      heading: 'تایید انتقال به حساب کاربر',
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

