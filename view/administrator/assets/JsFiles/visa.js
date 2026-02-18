$(document).ready(function () {

    //For switch active And inactive
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });
    $('.js-switch2').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
    //visa type add or edit
    $("#visaTypeAdd, #visaTypeEdit").validate({
        rules: {
            title: 'required'
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
                url: amadeusPath + 'visa_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {

                    if (response.result_status == 'success') {
                        var displayIcon = 'success';
                    } else {
                        var displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'نوع ویزا',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function () {
                            window.location = 'visaTypeList';
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

    //visa add or edit
    $('#visaAdd, #visaEdit .submitForEditor').click(function () {
        if (tinyMCE) {
            tinyMCE.triggerSave();
        }
    });
    $("#visaAdd, #visaEdit").validate({
        rules: {
            title: 'required',
            countryCode: 'required',
            visaTypeID: 'required',
            cover_image: {
                required: function () {
                    return $('#isEdit').val() != '1';
                }
            },
            mainCost: {
                required: '#OnlinePayment:checked',
                number: true,
            },
            prePaymentCost: {
                required: '#OnlinePayment:checked',
                number: true,
            },
            deadline: 'required',
            validityDuration: 'required',
            allowedUseNo: 'required'
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
                url: amadeusPath + 'visa_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.result_status == 'success') {
                        var displayIcon = 'success';
                    } else {
                        var displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'ویزا',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function () {
                            window.location = 'visaList';
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

    //initialize country select by changing continent
    $('#continent').on('change', function () {

        var continentID = $('#continent').val();
        $('#countryCode').html('');

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'visa_ajax.php',
            data: {
                flag: 'initAllCountries',
                continentID: continentID
            },
            success: function (response) {

                $('#countryCode').html(response);

            }
        });

    });


    $("#visaRequestStatusAdd,#visaRequestStatusEdit").validate({
        // focusCleanup: true,
        rules: {
            title: 'required'
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
            let this_id = $(form).attr('id');
            var _data = {
                className: 'visaRequestStatus',
                title: $(form).find('#title').val(),
                description: $(form).find('#description').val(),
                description: $(form).find('#description').val(),
                notification_content: $(form).find('#notification_content').val(),
            };

            _data.method = 'addNew';
            if (this_id == 'visaRequestStatusEdit') {
                _data.method = 'update';
                _data.id = $(form).find('input[name="id"]').val();
            };
            console.log(_data);
            $.ajax({
                url: amadeusPath + 'ajax',
                type: 'POST',
                dataType: 'JSON',
                data: JSON.stringify(_data),

                success: function (response) {

                    let displayIcon = 'success';
                    if (response.status != 'success') {
                        displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'وضعیت ویزا',
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.status == 'success') {
                        setTimeout(function () {
                            window.location = 'visaRequestStatusList';
                        }, 1000);
                    }

                },
                error: function (error) {
                    console.log(error);
                    $.toast({
                        heading: 'وضعیت ویزا',
                        text: error.responseJSON.message,
                        position: 'top-right',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                }
            });
            return false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });



    $(document).on('click','.delete_request_status',function(e){
        console.log('test');
        
        $.ajax({
            url: amadeusPath + 'ajax',
            type: 'POST',
            dataType: 'JSON',
            data: JSON.stringify({
                'className' : 'visaRequestStatus',
                'method' : 'delete',
                'id' : $(this).data('id'),
            }),

            success : function(response){

                let displayIcon = 'success';
                if (response.status != 'success') {
                    displayIcon = 'error';
                }

                $.toast({
                    heading: 'وضعیت ویزا',
                    text: response.message,
                    position: 'top-right',
                    icon: displayIcon,
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                if (response.status == 'success') {
                    setTimeout(function () {
                        window.location = 'visaRequestStatusList';
                    }, 1000);
                }
            },
            error : function (error) {
                console.log(error);
                $.toast({
                    heading: 'وضعیت ویزا',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }

        })
    });

    $('input[type=radio][name=visaCategory]').change(function() {
        if(this.value == 3 || this.value == 4) {
            $( '#deadline' ).each(function( index ) {
                $( this ).addClass('d-none');
            });

            $('label[for=deadline]').addClass('d-none');
            $('#validityDuration').addClass('d-none');
            $('label[for=validityDuration]').addClass('d-none');
            $('#allowedUseNo').addClass('d-none');
            $('label[for=allowedUseNo]').addClass('d-none');
        }else {
            $( '#deadline' ).each(function( index ) {
                $( this ).removeClass('d-none');
            });
            $('label[for=deadline]').removeClass('d-none');
            $('#validityDuration').removeClass('d-none');
            $('label[for=validityDuration]').removeClass('d-none');
            $('#allowedUseNo').removeClass('d-none');
            $('label[for=allowedUseNo]').removeClass('d-none');
        }
    });

});



function visaActivate(id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'visaActivate',
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else {
                var displayIcon = 'error';
            }

            $.toast({
                heading: 'وضعیت ویزا',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}

function visaOptions(id, clientID) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'visaOptions',
            clientID: clientID,
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else {
                var displayIcon = 'error';
            }

            $.toast({
                heading: 'تنظیمات ویزا',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}

function visaValidate(id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'visaValidate',
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else {
                var displayIcon = 'error';
            }

            $.toast({
                heading: 'وضعیت ویزا',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}

function visaAdminReviewChange(id, value) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'visaAdminReviewChange',
            value: value,
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else {
                var displayIcon = 'error';
            }

            $.toast({
                heading: 'یادداشت ویزا',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}

function removeCustomFile(thiss) {
    thiss.parent().remove();
}

function addCustomFile(thiss) {
    const count = $('div[data-name="custom_file_fields"]').length;


    const file_html = '<div data-name="custom_file_fields" class="col-md-3 d-flex flex-wrap">\n' +
        '<span class="fa fa-remove remove-btn" onclick="removeCustomFile($(this))"></span>' +
        '                    <div class="form-group mb-0 w-100">\n' +
        '                        <input type="text" class="form-control"' +
        '                               name="custom_file_fields[]" ' +
        '                               id="custom_file_fields_' + count + '" placeholder="نام فایل">\n' +
        '                    </div>\n' +
        '                </div>';

    thiss.before(file_html);

}


if(document.getElementById('cover_image')){

    document.getElementById('cover_image').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
    alert('فقط فایل تصویری مجاز است');
    this.value = '';
    return;
}

    const reader = new FileReader();
    reader.onload = function (e) {
    const img = document.getElementById('imagePreview');
    img.src = e.target.result;
    img.style.display = 'block';
    document.querySelector('.upload-text').style.display = 'none';
};
    reader.readAsDataURL(file);
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


$('#addVisaFaq').validate({
    rules: {
        question: 'required',
        answer: 'required',
        visa_id: 'required',
    },
    messages: {},
    errorElement: 'em',
    errorPlacement: function(error, element) {
        // Add the `help-block` class to the error element
        error.addClass('help-block')

        if (element.prop('type') === 'checkbox') {
            error.insertAfter(element.parent('label'))
        } else {
            error.insertAfter(element)
        }
    },
    submitHandler: function(form) {

        //tinyMCE.triggerSave();
        // CKEDITOR.instances.content.updateElement()
        if($('#answer').val() === '') {
            $.toast({
                heading: 'خطا',
                text: 'اضافه کردن پاسخ الزامی است',
                position: 'top-right',
                icon:  'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6,
            })
        }else{
            $(form).ajaxSubmit({

                url: amadeusPath + 'ajax',
                type: 'POST',
                // mimeType: "multipart/form-data",
                // contentType: false,
                // processData: false,
                success: function(response) {
                    console.log(response);
                    let displayIcon
                    if (response.success === true) {
                        displayIcon = 'success'
                    } else {
                        displayIcon = 'error'
                    }

                    $.toast({
                        heading: 'مطالب',
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                    if (response.success === true) {
                        setTimeout(function() {
                            // location.reload()
                            window.location = `${amadeusPath}itadmin/reservation/visaFaqList&visaId=${response[0]}`;
                        }, 1000)
                    }
                },
            })
        }

    },
    highlight: function(element, errorClass, validClass) {
        $(element)
           .parents('.form-group ')
           .addClass('has-error')
           .removeClass('has-success')
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element)
           .parents('.form-group ')
           .addClass('has-success')
           .removeClass('has-error')
    },
})
$('#editVisaFaq').validate({
    rules: {
        question: 'required',
        answer: 'required',
        visa_id: 'required',
    },
    messages: {},
    errorElement: 'em',
    errorPlacement: function(error, element) {
        // Add the `help-block` class to the error element
        error.addClass('help-block')

        if (element.prop('type') === 'checkbox') {
            error.insertAfter(element.parent('label'))
        } else {
            error.insertAfter(element)
        }
    },
    submitHandler: function(form) {
        //tinyMCE.triggerSave();
        // CKEDITOR.instances.content.updateElement()
        if($('#answer').val() === '') {
            $.toast({
                heading: 'خطا',
                text: 'اضافه کردن پاسخ الزامی است',
                position: 'top-right',
                icon:  'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6,
            })
        }else{
            $(form).ajaxSubmit({
                url: amadeusPath + 'ajax',
                type: 'POST',
                // mimeType: "multipart/form-data",
                // contentType: false,
                // processData: false,
                success: function(response) {
                    console.log(response);
                    let displayIcon
                    if (response.success === true) {
                        displayIcon = 'success'
                    } else {
                        displayIcon = 'error'
                    }

                    $.toast({
                        heading: 'مطالب',
                        text: response.message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                    })

                    if (response.success === true) {
                        setTimeout(function() {
                            // location.reload()
                            window.location = `${amadeusPath}itadmin/reservation/visaFaqList&visaId=${response[0]}`;
                        }, 1000)
                    }
                },
            })
        }

    },
    highlight: function(element, errorClass, validClass) {
        $(element)
           .parents('.form-group ')
           .addClass('has-error')
           .removeClass('has-success')
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element)
           .parents('.form-group ')
           .addClass('has-success')
           .removeClass('has-error')
    },
})

function deleteVisaFaq(faq_id) {
    if (confirm('آیا مطمئن هستید ؟')) {
        $.ajax({
            url:amadeusPath + 'ajax',
            data: JSON.stringify({
                className: "visa",
                method: "removeFaq",
                id: faq_id,
            }),
            type: "POST",
            dataType: "JSON",
            success: function (response) {
                if (response.success === true) {
                    $.toast({
                        heading: "حذف پرسش و پاسخ",
                        text: response.message,
                        position: "top-right",
                        icon: "success",
                        hideAfter: 3500,
                        textAlign: "right",
                        stack: 6,
                    })
                } else {
                    $.toast({
                        heading: "حذف پرسش و پاسخ",
                        text: response.message,
                        position: "top-right",
                        icon: "warning",
                        hideAfter: 3500,
                        textAlign: "right",
                        stack: 6,
                    })
                }
            },
            complete: function () {
                setTimeout(function () {
                    location.reload()
                    // window.location = `${amadeusPath}itadmin/articles/list`;
                }, 1000)
            },
        })
    }

}




function AddAdditionalData() {
    let BaseDiv = $('div[data-target="BaseAdditionalDataDiv"]:last-child');

    let CloneBaseDiv = BaseDiv.clone();

    CloneBaseDiv.find('.bootstrap-select').remove(); // پاک کردن نمایش گرافیکی select
    CloneBaseDiv.find('select.selectpicker').show(); // نمایش مجدد خود select

    CloneBaseDiv.find("input").val("");
    CloneBaseDiv.find("select").val("");

    BaseDiv.after(CloneBaseDiv);

    CloneBaseDiv.find('select.selectpicker').selectpicker();

    var CountDivInEach = 0;

    $('.DynamicAdditionalData [data-target="BaseAdditionalDataDiv"]').each(function () {
        // تمام input و selectهای داخل هر گروه را پیمایش کن
        $(this).find('[data-parent="AdditionalDataValues"]').each(function () {
            $(this).attr(
               "name",
               "AdditionalData[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
            );
        });

        CountDivInEach++;
    });

}
function RemoveAdditionalData(thiss) {
    if (
       thiss
          .parent()
          .parent()
          .parent()
          .parent()
          .find('div[data-target="BaseAdditionalDataDiv"]').length > 1
    ) {
        thiss.parent().parent().parent().remove()

        var CountDivInEach = 0
        $('.DynamicAdditionalData input[data-parent="AdditionalDataValues"]').each(
           function () {
               $(this).attr(
                  "name",
                  "AdditionalData[" +
                  CountDivInEach +
                  "][" +
                  $(this).attr("data-target") +
                  "]"
               )
               if ($(this).attr("data-target") == "body") {
                   CountDivInEach = CountDivInEach + 1
               }
           }
        )
    }
}

$("#EditDocs").validate({
    rules: {

        AdditionalData: "required",

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
            type: "post",
            success: function (response) {
                var res = response.split(':');

                if (response.indexOf('success') > -1) {
                    $.toast({
                        heading: 'ویرایش مدارک ',
                        text: 'مدارک با موفقیت ویرایش شد',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    setTimeout(function() {
                        // location.reload()
                        window.location = `${amadeusPath}itadmin/reservation/visaList`;
                    }, 1000)

                }


            },
            error:function(response){
               if(response.status === 400){
                       $.toast({
                           heading: 'ویرایش مدارک ',
                           text: 'لطفا تمام فیلد ها را وارد نمایید',
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


$("#EditStep").validate({
    rules: {

        AdditionalData: "required",

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
            type: "post",
            success: function (response) {
                var res = response.split(':');

                if (response.indexOf('success') > -1) {
                    $.toast({
                        heading: 'ویرایش مراحل اخذ ',
                        text: 'مراحل اخذ با موفقیت ویرایش شد',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    setTimeout(function() {
                        // location.reload()
                        window.location = `${amadeusPath}itadmin/reservation/visaList`;
                    }, 1000)

                }


            },
            error:function(response){
                if(response.status === 400){
                    $.toast({
                        heading: 'ویرایش مراحل اخذ ',
                        text: 'لطفا تمام فیلد ها را وارد نمایید',
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
function addVisaData() {
    let lastItem = $('.DynamicVisaData .VisaItem:last');
    let clone = lastItem.clone();

    // پاک کردن مقدارها
    clone.find('input').val('');
    clone.find('select').val('');

    lastItem.after(clone);

    updateVisaNames();
}

function removeVisaData(btn) {
    if ($('.DynamicVisaData .VisaItem').length > 1) {
        btn.closest('.VisaItem').remove();
        updateVisaNames();
    }
}

function updateVisaNames() {
    $('.DynamicVisaData .VisaItem').each(function (index) {
        $(this).find('[data-field]').each(function () {
            let field = $(this).data('field');
            $(this).attr('name', 'VisaData[' + index + '][' + field + ']');
        });
    });
}























