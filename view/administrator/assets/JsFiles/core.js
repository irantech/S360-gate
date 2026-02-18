$(document).ready(function () {

    // $('.select2').select2();
    $('.dropify').dropify();
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });

    $("#InsertAgencyCore").validate({
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "وارد کردن این فیلد الزامیست",
            },
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
            $('#btnbank').attr("disabled", "disabled");
            $('#loadingbank').show();
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                dataType: "json",
                success: function (response) {

                    if (response.status == 'success') {
                        $.toast({
                            heading: 'افزودن آژانس به سیستم Core',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        $('#btnbank').attr("disabled", false);
                        $('#loadingbank').hide();
                    } else {
                        $.toast({
                            heading: 'افزودن آژانس به سیستم Core',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        $('#btnbank').attr("disabled", false);
                        $('#loadingbank').hide();
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


    $("#insertSourceAgency").validate({
        rules: {
            sourceId: {
                required: true,
            },
            agencyId: {
                required: true,
            },
            userName: {
                required: true,
            },
            password: {
                required: true,
            },
            isActiveInternal: {
                required: true,
            },
            isActiveExternal: {
                required: true,
            }
        },
        messages: {
            sourceId: {
                required: "وارد کردن این فیلد الزامیست",
            },
            agencyId: {
                required: "وارد کردن این فیلد الزامیست",
            },
            userName: {
                required: "وارد کردن این فیلد الزامیست",
            },
            password: {
                required: "وارد کردن این فیلد الزامیست",
            },
            isActiveInternal: {
                required: "وارد کردن این فیلد الزامیست",
            },
            isActiveExternal: {
                required: "وارد کردن این فیلد الزامیست",
            },
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
            $('#btnbank').attr("disabled", "disabled");
            $('#loadingbank').show();
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                dataType: "json",
                success: function (response) {

                    if (response.status == 'success') {
                        $.toast({
                            heading: 'افزودن آژانس به سیستم Core',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        $('#btnbank').attr("disabled", false);
                        $('#loadingbank').hide();
                    } else {
                        $.toast({
                            heading: 'افزودن آژانس به سیستم Core',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        $('#btnbank').attr("disabled", false);
                        $('#loadingbank').hide();
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

    $("#editSourceAgency").validate({
        rules: {
            userName: {
                required: "وارد کردن این فیلد الزامیست",
            },
            password: {
                required: "وارد کردن این فیلد الزامیست",
            },
            isActiveInternal: {
                required: "وارد کردن این فیلد الزامیست",
            },
            isActiveExternal: {
                required: "وارد کردن این فیلد الزامیست",
            },
        },
        messages: {
            userName: {
                required: "وارد کردن این فیلد الزامیست",
            },
            password: {
                required: "وارد کردن این فیلد الزامیست",
            },
            isActiveInternal: {
                required: "وارد کردن این فیلد الزامیست",
            },
            isActiveExternal: {
                required: "وارد کردن این فیلد الزامیست",
            },
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
            $('#btnbank').attr("disabled", "disabled");
            $('#loadingbank').show();
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                dataType: "json",
                success: function (response) {

                    if (response.status == 'success') {
                        $.toast({
                            heading: 'افزودن آژانس به سیستم Core',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        $('#btnbank').attr("disabled", false);
                        $('#loadingbank').hide();
                    } else {
                        $.toast({
                            heading: 'افزودن آژانس به سیستم Core',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        $('#btnbank').attr("disabled", false);
                        $('#loadingbank').hide();
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


    $("#insert_airline_core").validate({
        rules: {
            airline: {
                required: true,
            },
            user_name: {
                required: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            airline: {
                required: "وارد کردن این فیلد الزامیست",
            },
            userName: {
                required: "وارد کردن این فیلد الزامیست",
            },
            password: {
                required: "وارد کردن این فیلد الزامیست",
            }
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
            let airline = $('#airline').val();
            let airline_name = $('#airline  option:selected').text();
            let user_name = $('#user_name').val();
            let password = $('#password').val();
            let agency_source_id = $('#agency_source_id').val();

            $.ajax({
                type: 'POST',
                url: amadeusPath + 'ajax',
                dataType: 'json',
                data: JSON.stringify({
                    airline,
                    user_name,
                    password,
                    agency_source_id,
                    airline_name,
                    className:'settingCore',
                    method: 'insertPidNira',
                }),
                success: function(data) {
                    console.log(data)
                    if (data.data.status == 'success') {
                        $.toast({
                            heading: 'ثبت پید نیرا',
                            text: data.data.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    } else {
                        $.toast({
                            heading: 'ثبت پید نیرا',
                            text: data.data.Message,
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

function StatusActiveSourceCore(SourceId)
{

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType:'json',
        data: {
            SourceId: SourceId,
            Method: 'statusSource',
            flag: 'changeStatusCore'
        },
        success: function (data) {
            if (data.status == 'success')
            {

                $.toast({
                    heading: 'وضعیت سرور',
                    text: `${data.Message}(سرور${data.status_source})`,
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
                    heading: 'وضعیت سرور',
                    text: data.Message,
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

function StatusActiveInternalAgencySource(agencyId,SourceId) {

    if($("#SourceAgencyStatus"+agencyId+SourceId).is(":checked")){
        var Status = 'Active';
    }else{
        var Status  = 'inActive';
    }

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType:'json',
        data: {
            sourceId: SourceId,
            agencyId: agencyId,
            Status:Status,
            Method: 'changeStatusSourceAgencyInternal',
            flag: 'changeStatusSourceAgencyInternal'
        },
        success: function (data) {
            if (data.status == 'success')
            {

                $.toast({
                    heading: 'وضعیت سرور داخلی',
                    text: data.Message,
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
                    heading: 'وضعیت سرور داخلی',
                    text: data.Message,
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


function StatusActiveExternalAgencySource(agencyId,SourceId) {

    if($("#SourceAgencyStatusExternal"+agencyId+SourceId).is(":checked")){
        var Status = 'Active';
    }else{
        var Status  = 'inActive';
    }

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType:'json',
        data: {
            sourceId: SourceId,
            agencyId: agencyId,
            Status:Status,
            Method: 'changeStatusSourceAgencyExternal',
            flag: 'changeStatusSourceAgencyExternal'
        },
        success: function (data) {
            if (data.status == 'success')
            {

                $.toast({
                    heading: 'وضعیت سرور خارجی',
                    text: data.Message,
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
                    heading: 'وضعیت سرور خارجی',
                    text: data.Message,
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


function StatusActiveSourcePid(airline_agency_pid_id) {

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType: 'json',
        data: JSON.stringify({
            airline_agency_pid_id,
            className:'settingCore',
            method: 'changeStatusPidAgency',
        }),
        success: function (data) {
            if (data.data.status == 'success')
            {
                $.toast({
                    heading: 'وضعیت پید',
                    text: data.data.Message,
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
                    heading: 'وضعیت پید',
                    text: data.data.Message,
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

function SetInfoSource() {
    var source_id = $('#sourceId').val();
    var webServiceType = $('#webServiceType').val();

    // اگر نوع اختصاصی است → سه باکس خالی شوند و تمام
    if (webServiceType === 'private') {
        $('#userName').val('');
        $('#password').val('');
        $('#token').val('');
        return;
    }

    // اگر اشتراکی است اما سرور انتخاب نشده
    if (webServiceType === 'public' && source_id === '') {
        $.toast({
            heading: 'انتخاب سرور',
            text: 'لطفاً ابتدا یک سرور انتخاب کنید.',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'warning',
            hideAfter: 3000,
            textAlign: 'right'
        });
        return;
    }

    // اگر اشتراکی است → اطلاعات را از سرور بگیر
    if (webServiceType === 'public') {
        $.ajax({
            url: amadeusPath + 'ajax',
            type: "POST",
            data: JSON.stringify({
                className: 'sources',
                method: 'getSourceById',
                id: source_id,
                to_json: true
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                let d = response.data;
                if (!d) {
                    alert('اطلاعات سرور اشتراکی خالی است!');
                    return;
                } else {
                    $('#userName').val(d.username || '');
                    $('#password').val(d.password || '');
                    $('#token').val(d.token || '');
                }
            },
            error: function () {
                alert('خطا در ارتباط با سرور.');
            }
        });
    }
}