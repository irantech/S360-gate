
$(document).ready(function () {
    $('#addAirlineIataForm').submit(function(e) {
        e.preventDefault();

        var airlineName = $('#airline_name').val().trim();
        var airlineIata = $('#airline_iata').val().trim().toUpperCase();

        // اعتبارسنجی ساده
        if (!airlineName) {
            alert('لطفا نام ایرلاین را وارد کنید');
            return;
        }

        if (!airlineIata || airlineIata.length > 5) {
            alert('کد IATA باید حداکثر 3 کاراکتر باشد');
            return;
        }

        // غیرفعال کردن دکمه برای جلوگیری از کلیک‌های مکرر
        $('#addAirlineBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> در حال افزودن...');

        // ارسال درخواست Ajax
        $.ajax({
            url: amadeusPath + 'user_ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {
                airline_name: airlineName,
                airline_iata: airlineIata,
                flag: 'add_airlineIata'
            },
            success: function(response) {
                if (response) {
                    $.toast({
                        heading: 'با موفقیت ایرلاین اضافه شد.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                $.toast({
                    heading: 'خطا در پردازش',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    });
    $('#addAirlineClassFareForm').submit(function(e) {
        e.preventDefault();

        var class_name = $('#class_name').val();

        // غیرفعال کردن دکمه برای جلوگیری از کلیک‌های مکرر
        $('#addAirlineBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> در حال افزودن...');

        // ارسال درخواست Ajax
        $.ajax({
            url: amadeusPath + 'user_ajax.php',
            type: 'POST',
            dataType: 'json',
            data: {
                class_name: class_name,
                flag: 'add_airlineFareClass'
            },
            success: function(response) {
                if (response) {
                    $.toast({
                        heading: 'با موفقیت ایرلاین اضافه شد.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                $.toast({
                    heading: 'خطا در پردازش',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    });
    $("#fineAdd, #fineEdit").validate({
        rules: {
            airline_iata_id: 'required',
            class_fare_ids: 'required',
            'FineData[]': {
                required: true,
            }
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
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if(response.success == true){
                        $.toast({
                            heading: 'پکیج نرخی',
                            text: response.message,
                            position: 'top-right',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='airlineFinePercentage';
                        }, 1000);

                    }else{
                        $.toast({
                            heading: 'پکیج نرخی',
                            text: response.message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);

                    }
                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });
    $('.dropify').dropify();
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });



    $("#AddRoute").validate({
        rules: {
            nameFa: "required",
            nameEn: "required",
            abbreviation: "required",
            photo: "required"
        },
        messages: {

        },
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
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن خطوط پروازی جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='infoFlightRoute';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن خطوط پروازی جدید',
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
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });

    $("#EditRoute").validate({
        rules: {
            nameFa: "required",
            nameEn: "required",
            abbreviation: "required"
        },
        messages: {

        },
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
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن خطوط پروازی جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='infoFlightRoute';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن خطوط پروازی جدید',
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
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });
});


function delete_counter_list(id)
{
    $.alert({
        title: 'حذف خطوط پروازی',
        icon: 'fa fa-trash',
        content: 'آیا از حذف خطوط پروازی اطمینان دارید',
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
                                flag: 'delete_counter'
                            },
                            function (data) {
                                var res = data.split(':');

                                if (data.indexOf('success') > -1)
                                {

                                    $.alert({
                                        title: 'حذف خطوط پروازی',
                                        icon: 'fa fa-trash',
                                        content: res[1],
                                        rtl: true,
                                        type: 'green',
                                    });

                                    setTimeout(function () {
                                        $('#del-' + id).remove();

                                    }, 1000);
                                } else
                                {
                                    $.alert({
                                        title: 'حذف خطوط پروازی',
                                        icon: 'fa fa-trash',
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



function StatusAirline(ClientId, iata, type)
{
    $.post(amadeusPath + 'user_ajax.php',
    {
        ClientId: ClientId,
        iata: iata,
        type: type,
        flag: 'StatusAirline'
    },
    function (data) {
        var res = data.split(':');

        if (data.indexOf('success') > -1)
        {

            $.toast({
                heading: 'وضعیت خطوط پروازی',
                text: res[1],
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        } else
        {
            $.toast({
                heading: 'وضعیت خطوط پروازی',
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

function StatusPid(ClientId, iata,type)
{
    $.post(amadeusPath + 'user_ajax.php',
    {
        ClientId: ClientId,
        iata: iata,
        type: type,
        flag: 'StatusPid'
    },
    function (data) {
        var res = data.split(':');

        if (data.indexOf('success') > -1)
        {

            $.toast({
                heading: 'وضعیت خطوط پروازی',
                text: res[1],
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

            setTimeout(function () {
                $('#public_load').load('administratorairlineclient&id='+ClientId+'#example1_wrapper');

            }, 1000);
        } else
        {
            $.toast({
                heading: 'وضعیت خطوط پروازی',
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

function openAirlineInfo(obj,id) {
    $(obj).toggleClass('active_open');
    $('#infoAirline'+ id).fadeToggle();
    $(obj).parents('.t_body_demo').children('.t_body_demo');
}

function configPidAirline(ClientId, iata, typeFlight,isInternal,isPublic,type)
{
    $.post(amadeusPath + 'user_ajax.php',
        {
            ClientId: ClientId,
            iataId : iata,
            typeFlight: typeFlight,
            isInternal: isInternal,
            isPublic: isPublic,
            type: type,
            flag: 'configPidAirline'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('success') > -1)
            {

                $.toast({
                    heading: 'وضعیت خطوط پروازی',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            } else
            {
                $.toast({
                    heading: 'وضعیت خطوط پروازی',
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
function configPidAllAirlines(ClientId, iatas, typeFlight,isInternal,isPublic,type)
{
    $.post(amadeusPath + 'user_ajax.php',
        {
            ClientId: ClientId,
            iataIds : iatas,
            typeFlight: typeFlight,
            isInternal: isInternal,
            isPublic: isPublic,
            type: type,
            flag: 'configPidAllAirlines'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('success') > -1)
            {

                $.toast({
                    heading: 'وضعیت خطوط پروازی',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            } else
            {
                $.toast({
                    heading: 'وضعیت خطوط پروازی',
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
function showAllAirlineConfig(ClientId,airLines) {
    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'airline',
            Method: 'configAllAirlines',
            ParamId: ClientId,
            Param: airLines
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}
function showConfigAirline(ClientId,airLine) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'airline',
            Method: 'configAirline',
            ParamId: ClientId,
            Param: airLine
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}


function ShowLogConfigAirline(ClientId,airLine) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'airline',
            Method: 'logConfigAirline',
            ParamId: ClientId,
            Param: airLine
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function selectServer(obj,replace)
{
    var ClientId =$(obj).attr('clientId');
    var iata = $(obj).attr('airlineId');
    var typeFlight = $(obj).attr('typeFlight');
    var isInternal =$(obj).attr('isInternal');
    var serverId = $(obj).val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            ClientId: ClientId,
            iataId : iata,
            typeFlight: typeFlight,
            isInternal: isInternal,
            serverId: serverId,
            replace: replace,
            flag: 'selectServer'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('success') > -1)
            {

                $.toast({
                    heading: 'وضعیت خطوط پروازی',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            } else
            {
                $.toast({
                    heading: 'وضعیت خطوط پروازی',
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

}function selectAllServers(obj,replace)
{
    var ClientId =$(obj).attr('clientId');
    var iatas = $(obj).attr('airlineIds');
    var typeFlight = $(obj).attr('typeFlight');
    var isInternal =$(obj).attr('isInternal');
    var serverId = $(obj).val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            ClientId: ClientId,
            iataIds : iatas,
            typeFlight: typeFlight,
            isInternal: isInternal,
            serverId: serverId,
            replace: replace,
            flag: 'selectAllServers'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('success') > -1)
            {

                $.toast({
                    heading: 'وضعیت خطوط پروازی',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

            } else
            {
                $.toast({
                    heading: 'وضعیت خطوط پروازی',
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

function UpdateCommissionAirline(obj) {
    let CommissionStr = $(obj).val();
    let Iata = obj.dataset.iata;
    let route = obj.name;

    if (!/^\d*\.?\d*$/.test(CommissionStr)) {
        $.toast({
            heading: 'بروز رسانی کمیسیون',
            text: "مقدار کمیسیون باید عددی باشد",
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }

    let Commission = CommissionStr === '' ? 0 : parseFloat(CommissionStr);

    if (Commission < 0 || Commission > 100) {
        $.toast({
            heading: 'بروز رسانی کمیسیون',
            text: "مقدار کمیسیون باید بین 0 تا 100 باشد",
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }

    $.post(amadeusPath + 'user_ajax.php', {
        AirlineIata: Iata,
        Commission: Commission,
        route: route,
        flag: 'UpdateCommissionAirline'
    }, function (data) {

        let res = JSON.parse(data);

        if (res.success == true) {
            $.toast({
                heading: 'بروز رسانی کمیسیون',
                text: res.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        } else {
            $.toast({
                heading: 'بروز رسانی کمیسیون',
                text: res.message,
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

function UpdateTerminalAirline(obj) {
    let TerminalStr = $(obj).val();
    let Iata = obj.dataset.iata;
    let route = obj.name;

    // if (!/^\d*\.?\d*$/.test(TerminalStr)) {
    //     $.toast({
    //         heading: 'بروز رسانی ترمینال',
    //         text: "مقدار کمیسیون باید عددی باشد",
    //         position: 'top-right',
    //         loaderBg: '#fff',
    //         icon: 'error',
    //         hideAfter: 3500,
    //         textAlign: 'right',
    //         stack: 6
    //     });
    //     return;
    // }




    $.post(amadeusPath + 'user_ajax.php', {
        AirlineIata: Iata,
        Terminal: TerminalStr,
        route: route,
        flag: 'UpdateTerminalAirline'
    }, function (data) {

        let res = JSON.parse(data);

        if (res.success == true) {
            $.toast({
                heading: 'بروز رسانی ترمینال',
                text: res.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        } else {
            $.toast({
                heading: 'بروز رسانی ترمینال',
                text: res.message,
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


function selectAmadeusStatus(obj){

    let amadeusStatus = obj.value;
    let Iata = obj.dataset.iata;


    if (amadeusStatus === '') {
        amadeusStatus = null
    }

    $.post(amadeusPath + 'user_ajax.php', {
        AirlineIata: Iata,
        amadeusStatus: amadeusStatus,
        flag: 'UpdateAmadeusStatusAirline'

    }, function (data) {

        let res = JSON.parse(data);

        if (res.success == true) {
            $.toast({
                heading: 'بروز رسانی وضعیت آمادئوس',
                text: res.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        } else {
            $.toast({
                heading: 'بروز رسانی وضعیت آمادئوس',
                text: res.message,
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

// =======airLine iata/classFare changes(flightPureIata/infoFlightRoute/airlineFareClass)========
function selectIata(iata_id,airline_id){


    $.post(amadeusPath + 'user_ajax.php', {
        iata_id: iata_id,
        airline_id: airline_id,
        flag: 'UpdateAirlineiata'
    }, function (data) {

        let res = JSON.parse(data);

        if (res) {
            $.toast({
                heading: 'بروز رسانی کد یاتا',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        } else {
            $.toast({
                heading: 'بروز رسانی کد یاتا',
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
function removeAirlineBtn(id) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
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
                           flag: 'remove_airlineIata'
                       },
                       function (data) {
                        console.log(data);

                           if (data)
                           {
                               $.toast({
                                   heading:'ایرلاین با موفقیت حذف گردید',
                                   position: 'top-right',
                                   loaderBg: '#fff',
                                   icon: 'success',
                                   hideAfter: 3500,
                                   textAlign: 'right',
                                   stack: 6
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {
                               $.alert({
                                   title :'خطا در پردازش',
                                   text: res[1],
                                   icon: 'fa fa-trash',
                                   rtl: true,
                                   type: 'red',
                               });

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
function removeAirlineClassFareBtn(id) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
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
                           flag: 'remove_airlineFareClass'
                       },
                       function (data) {
                           if (data)
                           {
                               $.toast({
                                   heading: 'کلاس نرخ با موفقیت حذف گردید',
                                   position: 'top-right',
                                   loaderBg: '#fff',
                                   icon: 'success',
                                   hideAfter: 3500,
                                   textAlign: 'right',
                                   stack: 6
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {
                               $.alert({
                                   title :'خطا در پردازش',
                                   text: res[1],
                                   icon: 'fa fa-trash',
                                   rtl: true,
                                   type: 'red',
                               });

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

// =======airLine iata changes========
// =======airLine fine percentage changes========
function addFineData() {
    let lastItem = $('.DynamicFineData .FineItem:last');
    let clone = lastItem.clone(true, true); // clone همراه با event ها
    clone.find('input').val('');
    lastItem.after(clone);
    updateFineNames();
}

// حذف ردیف
function removeFineData(button) {
    let container = $('.DynamicFineData .FineItem');
    if (container.length > 1) {
        button.closest('.FineItem').remove();
        updateFineNames();
    } else {
        alert('حداقل یک ردیف باید وجود داشته باشد.');
    }
}

// آپدیت index و name
function updateFineNames() {
    $('.DynamicFineData .FineItem').each(function (index) {
        $(this).find('[data-field]').each(function () {
            let field = $(this).data('field');
            // کلید name رو با index جدید میسازیم
            $(this).attr('name', 'FineData[' + index + '][' + field + ']');
        });
    });
}

// قبل از submit فرم هم یک بار مطمئن شو
$('#fineEdit').on('submit', function() {
    updateFineNames();
});
function soft_deletion(id) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
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
                           flag: 'remove_airlineFine'
                       },
                       function (response) {
                        console.log(response.success);
                           if (response.success == true)
                           {
                               $.toast({
                                   heading: 'نرخ با موفقیت حذف گردید',
                                   position: 'top-right',
                                   loaderBg: '#fff',
                                   icon: 'success',
                                   hideAfter: 3500,
                                   textAlign: 'right',
                                   stack: 6
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {
                               $.alert({
                                   title :'خطا در پردازش',
                                   icon: 'fa fa-trash',
                                   rtl: true,
                                   type: 'red',
                               });

                           }

                       },'json');
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}

function toggleFineFields(el) {

    let parentRow = el.closest(".FineItem");

    let finePercentage = parentRow.find(".fine_percentage");
    let fineDescription = parentRow.find(".fine_description");
    let fineDescriptionEn = parentRow.find(".fine_description_en");

    let percentageVal = finePercentage.val();
    let descriptionVal = fineDescription.val();
    let descriptionEnVal = fineDescriptionEn.val();

    // اگر درصد جریمه پر بود => توضیحات غیرفعال
    if (percentageVal !== "" && percentageVal !== null) {
        fineDescription.prop("disabled", true);
        fineDescriptionEn.prop("disabled", true);
    } else {
        fineDescription.prop("disabled", false);
        fineDescriptionEn.prop("disabled", false);
    }

    // اگر یکی از توضیحات پر بود => درصد غیرفعال
    if (
       (descriptionVal !== "" && descriptionVal !== null) ||
       (descriptionEnVal !== "" && descriptionEnVal !== null)
    ) {
        finePercentage.prop("disabled", true);
    } else {
        finePercentage.prop("disabled", false);
    }

    // اگر همه خالی بودن => همه فعال
    if (
       (percentageVal === "" || percentageVal === null) &&
       (descriptionVal === "" || descriptionVal === null) &&
       (descriptionEnVal === "" || descriptionEnVal === null)
    ) {
        finePercentage.prop("disabled", false);
        fineDescription.prop("disabled", false);
        fineDescriptionEn.prop("disabled", false);
    }
}



// =======airLine fine percentage changes========
