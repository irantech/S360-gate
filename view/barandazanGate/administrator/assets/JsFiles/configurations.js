$(document).ready(function () {
    $('#content_type').on('change', function (e) {
        console.log('content_type');
        e.preventDefault();
        value = $(this).val();
        if (value == 'image') {
            $('.contnt-image').removeClass('d-none').prop("disabled", false);
            $('.contnt-html').addClass('d-none').prop("disabled", true);
        } else if (value == 'html') {
            $('.contnt-html').removeClass('d-none').prop("disabled", false);
            $('.contnt-image').addClass('d-none').prop("disabled", true);
            setCKEditor();
        }
    });
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });
    $('.dropify').dropify();

    $('#addConfiguration').on('submit', function (e) {
        e.preventDefault();
        addConfiguration();
    });
    $('#editConfiguration').on('submit', function (e) {
        e.preventDefault();
        let configuration_id = $(this).find('#id').val();
        editConfiguration(configuration_id);
    });
    $('.newConfigurationAccess').on('submit', function (e) {
        e.preventDefault();
        let client_id = $(this).find('#client_id').val();
        let configuration_id = $(this).find('#configuration_id').val();

        newConfigurationAccess(client_id, configuration_id);
    });
    $('.deleteContent').on('click', function (e) {
        let thisId = $(this).data('id');
        deleteContent(thisId);
    });
    $('.remove-configuration-access').on('click', function (e) {
        let thisId = $(this).data('id'),
            config = $(this).data('config');
        deleteConfigurationAccess(thisId,config);
    });

    $('.insert-advertise-access').on('click',function(e){
        let id = $(this).data('id');
        insertAdvertiseAccess(id);
    });

    $("#addContent").validate({
        rules: {
            title: 'required',
            is_active: 'required',
            content_type: 'required',
            content: 'required'
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
            let type = $(form).find(`select[name="content_type"]`).val();
            // console.log(type);
            if (type == 'html') {
                CKEDITOR.instances.content.updateElement();
            }
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == 'success') {
                        $.toast({
                            heading: 'افزودن محتوای تبلیغات',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    } else {
                        $.toast({
                            heading: 'افزودن محتوای تبلیغات',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    }
                    if (response.status == 'success') {
                        // console.log(`${amadeusPath}itadmin/configurations/listContent?config=${form.configuration_id.value}`);

                        setTimeout(function () {
                            window.location = `${amadeusPath}itadmin/configurations/listContent?config=${form.configuration_id.value}`;

                        }, 500);
                    }
                },
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });

    $("#editContent").validate({
        rules: {
            title: 'required',
            is_active: 'required',
            content_type: 'required',
            content: 'required'
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
            let type = $(form).find(`select[name="content_type"]`).val();
            // console.log(type);
            if (type == 'html') {
                CKEDITOR.instances.content.updateElement();
            }
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == 'success') {
                        $.toast({
                            heading: 'افزودن محتوای تبلیغات',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    } else {
                        $.toast({
                            heading: 'افزودن محتوای تبلیغات',
                            text: response.Message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    }

                    if (response.status == 'success') {
                        console.log(`${amadeusPath}itadmin/configurations/listContent?config=${form.configuration_id.value}`);

                        setTimeout(function () {
                            window.location = `${amadeusPath}itadmin/configurations/listContent?config=${form.configuration_id.value}`;

                        }, 500);
                    }
                },
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

const setCKEditor = function () {
    if ($('#content')) {
        CKEDITOR.replace('content');
    }
};

const addConfiguration = function () {
    let title = $("#addConfiguration #title").val();
    let title_en = $("#addConfiguration #title_en").val();
    let service_group = $('#addConfiguration #service_group').val();

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            flag: 'addNewConfiguration',
            title: title,
            title_en: title_en,
            service_group: service_group,
            is_active: 1
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function () {
                    // console.log(`${amadeusPath}itadmin/articles/list`);
                    window.location = `${amadeusPath}itadmin/configurations/listConfigurations`;
                }, 1000)
            } else {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: 'خطا در ثبت اطلاعات',
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
};

const editConfiguration = function (configuration_id) {
    let title = $("#editConfiguration #title").val();
    let title_en = $("#editConfiguration #title_en").val();
    let service_group = $('#editConfiguration #service_group').val();

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            id: configuration_id,
            flag: 'editConfiguration',
            title: title,
            title_en: title_en,
            service_group: service_group,
            is_active: 1
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function () {
                    window.location = `${amadeusPath}itadmin/configurations/listConfigurations`;
                }, 1000)
            } else {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: 'خطا در ثبت اطلاعات',
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
};

const changeConfigurationStatus = function (configuration_id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            configuration_id: configuration_id,
            Method: 'changeConfigurationStatus',
            flag: 'changeConfigurationStatus'
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: 'خطا در ثبت اطلاعات',
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
};

const changeConfigurationEdit = function (configuration_id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            configuration_id: configuration_id,
            Method: 'changeConfigurationEdit',
            flag: 'changeConfigurationEdit'
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: 'خطا در ثبت اطلاعات',
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
};

const setClientConfigStatus = function (configuration_id, client_id, action) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            configuration_id: configuration_id,
            client_id: client_id,
            action: action,
            Method: 'setClientConfigStatus',
            flag: 'setClientConfigStatus'
        },

        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'تغییر وضعیت کانفیگ',
                    text: 'خطا در ثبت اطلاعات',
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
};

const newConfigurationAccess = function (client_id, configuration_id) {
    setClientConfigStatus(configuration_id, client_id, 'insert');
    setTimeout(function () {
        window.location = `${amadeusPath}itadmin/configurations/listClientsAccess?id=${client_id}`;
    }, 1000)
};

const deleteConfigurationAccess = function (client_id, configuration_id) {
    setClientConfigStatus(configuration_id, client_id, 'delete');
    setTimeout(function () {
        window.location = `${amadeusPath}itadmin/configurations/listClientsAccess?id=${client_id}`;
    }, 1000)
};

const redirectToConfigurationPage = function (page_slug) {
    setTimeout(function () {
        window.location = `${amadeusPath}itadmin/configurations/${page_slug}`;
    })
};

const addContent = function (content, title, configuration_id, type, is_active) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            title: title,
            content: content,
            configuration_id: configuration_id,
            content_type: type,
            is_active: is_active,
            flag: 'addNewClientContent'
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'افزودن محتوای تبلیغات',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'افزودن محتوای تبلیغات',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            redirectToConfigurationPage('listContent?config=' + configuration_id)
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'افزودن محتوای تبلیغات',
                    text: 'خطا در ثبت اطلاعات',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        }
    })
};

const editContent = function (id, content, title, configuration_id, type, is_active) {

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            id: id,
            title: title,
            content: content,
            configuration_id: configuration_id,
            content_type: type,
            is_active: is_active,
            flag: 'editClientContent'
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'ویرایش محتوای تبلیغات',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'ویرایش محتوای تبلیغات',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            // redirectToConfigurationPage('listContent?config='+configuration_id)
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'افزودن محتوای تبلیغات',
                    text: 'خطا در ثبت اطلاعات',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        }
    })
};

const deleteContent = function (id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            id: id,
            flag: 'deleteClientContent'
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'ویرایش محتوای تبلیغات',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'ویرایش محتوای تبلیغات',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            setTimeout(function () {
                window.location.reload(true);
            }, 500);
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'افزودن محتوای تبلیغات',
                    text: 'خطا در ثبت اطلاعات',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        }
    })
};

const insertAdvertiseAccess = function(id){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'json',
        data: {
            id: id,
            flag: 'insertAdvertiseAccess'
        },
        success: function (data) {
            if (data.status == 'success') {
                $.toast({
                    heading: 'بروزرسانی دسترسی ها',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'بروزرسانی دسترسی ها',
                    text: data.Message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            setTimeout(function () {
                window.location.reload(true);
            }, 500);
        },

        error: function (error) {
            {
                $.toast({
                    heading: 'بروزرسانی دسترسی ها',
                    text: 'خطا در ثبت اطلاعات',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        }
    })
}

function updateStatusConfigurations(id){
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'JSON',
    data:  JSON.stringify({
      className: 'configurations',
      method: 'updateStatusConfigurations',
      id,
    })
    ,
    success: function (data) {
      $.toast({
        heading: 'تغییر وضعیت محتوای تبلیغاتی',
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
      $.toast({
        heading: 'تغییر وضعیت محتوای تبلیغاتی',
        text: error.responseJSON.message,
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
