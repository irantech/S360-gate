
$(document).ready(function () {
    $('#myTable').DataTable();
    $("#Client").validate({
        rules: {
            AgencyName: "required",
            Domain: {
                required: true,
                minlength: 2,
                pattern: /^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z]{2,})+$/
            },
            MainDomain:{
                required: true,
                minlength: 2,
                pattern: /^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z]{2,})+$/
            },
            /*DbName: "required",*/
            DbUser: "required",
            DbPass: "required",
            ThemeDir: "required",
            Manager: "required",
            Address: "required",
            Title: "required",
            id_whmcs: "required",
            UrlRuls: "required",
            IsEnableTicketHTC: "required",
            AllowSendSms: "required",
            IsCurrency: "required",
            Logo: "required",
            IsEnableClub: "required",
            default_language: "required",
            isIframe: "required",
            UsernameSms: {
                required: {
                    depends: function (element) {
                     
                        return $('#AllowSendSms').val() == '1';
                    }
                }

            },

            PasswordSms: {
                required: {
                    depends: function (element) {
                        return $('#AllowSendSms').val() == '1';
                    }
                }
            },
            ClubPreCardNo: {
                required: {
                    depends: function (element) {
                        return $('#IsEnableClub').val() === '1';
                    }
                }
            },

            Mobile: {
                required: true,
                minlength: 11,
                number: true,
            },
            Phone: {
                required: true,
                minlength: 4,
            },
            password: {
                required: true,
                minlength: 6
            },
            Confirm: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            Email: {
                required: true,
                email: true
            }
        },
        messages: {
            password: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "رمز عبور نمی تواند از 6 کارکتر کمتر باشد"
            },
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
            },
            Logo:
                {
                    required: "ارسال لوگو الزامی می باشد"
                },
            Stamp:
                {
                    required: "ارسال تصویر مهر الزامی می باشد"
                }
        },
       normalizer: function(value) {
          // حذف فاصله‌ها از ابتدا و انتها + تبدیل فاصله‌های متوالی به یک فاصله
          return $.trim(value).replace(/\s+/g, ' ');
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
                            heading: 'افزودن مشتری جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'flyAppClientAdd';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن مشتری جدید',
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

    $("#EditClient").validate({
        rules: {
            AgencyName: "required",
            Domain: {
                required: true,
                minlength: 2,
                pattern: /^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z]{2,})+$/
            },
            MainDomain:{
                required: true,
                minlength: 2,
                pattern: /^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z]{2,})+$/
            },
            DbName: "required",
            DbUser: "required",
            DbPass: "required",
            ThemeDir: "required",
            Manager: "required",
            Address: "required",
            Title: "required",
            IsCurrency: "required",
            UrlRuls: "required",
            IsEnableTicketHTC: "required",
            AllowSendSms: "required",
            IsEnableClub: "required",
            default_language: "required",
            id_whmcs: {
                required: {
                    depends: function () {
                        let inputVal = $('#id_whmcs').val().trim();
                        let txtVal = $('#id_whmcs_txt').text().trim();

                        // اگر هر دو خالی باشند → required فعال می‌شود
                        return (inputVal === '' && txtVal === 'کد ندارد');
                    }
                }
            },
            UsernameSms: {
                required: {
                    depends: function (element) {
                        return $('#AllowSendSms').val() == '1';
                    }
                }

            },

            PasswordSms: {
                required: {
                    depends: function (element) {
                        return $('#AllowSendSms').val() == '1';
                    }
                }
            },
            ClubPreCardNo: {
                required: {
                    depends: function (element) {
                        return $('#IsEnableClub').val() === '1';
                    }
                }
            },

            Mobile: {
                required: true,
                minlength: 11,
                number: true,
            },
            Phone: {
                required: true,
                minlength: 4,
            },
            Email: {
                required: true,
                email: true
            }
        },
        messages: {},
        normalizer: function(value) {
            // حذف فاصله‌ها از ابتدا و انتها + تبدیل فاصله‌های متوالی به یک فاصله
            return $.trim(value).replace(/\s+/g, ' ');
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
                            heading: 'ویرایش مشتری ',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'flyAppClient';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش مشتری ',
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


    $("#EditProfile").validate({
        rules: {
            AgencyName: "required",
            Domain: "required",
            MainDomain: "required",
            DbName: "required",
            DbUser: "required",
            DbPass: "required",
            ThemeDir: "required",
            Manager: "required",
            Address: "required",
            Title: "required",
            UserNameApi: "required",

            Mobile: {
                required: true,
                minlength: 11,
                number: true,
            },
            Phone: {
                required: true,
                minlength: 4,
            },
            Email: {
                required: true,
                email: true
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
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش اطلاعات پروفایل ',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });


                    } else {

                        $.toast({
                            heading: 'ویرایش اطلاعات پروفایل ',
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


    $("#client_commission").validate({
        rules: {
            parent_client_id: "required",
            type: "required",
            type_detail: "required",
            type_commission: "required",
            amount_commission: "required"
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

            var client_id_parent= $('#client_id_parent').val();
            var type= $('#type').val();
            var detail_type= $('#detail_type').val();
            var type_commission= $('#type_commission').val();
            var amount_commission= $('#amount_commission').val();
            var client_id= $('#client_id').val();
            var method= $('#method').val();
            $.ajax({
                type: 'POST',
                url: amadeusPath + 'ajax',
                dataType:'json',
                data:JSON.stringify({
                    method: method,
                    className :'partner',
                    client_id_parent: client_id_parent,
                    type: type,
                    type_commission: type_commission,
                    detail_type: detail_type,
                    amount_commission: amount_commission,
                    client_id: client_id,
                }),
                success: function (response) {
                    $.toast({
                        heading: 'تعیین کمیسیون مشتریان در وایت لیبل ',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    setTimeout(function () {

                      location.href = "listClientCommission&id=" + client_id_parent
                    },1000);

                },
                error : function (error) {
                    $.toast({
                        heading: 'تعیین کمیسیون مشتریان در وایت لیبل ',
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
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });

    // For select 2
    $(".select2").select2();
    //For Upload File
    $('.dropify').dropify();


    if ($('#IsEnableClub').val() === '1') {
        $('#ClubPreCardNoDiv').show();
    }

    if ($('#AllowSendSms').val() === '1') {
        $('.smsPanel').show();
    }


});

function SelectAllowPanel(obj) {

    
    if ($(obj).val() === '1') {
        $('.smsPanel').show();
    }else{
        $('.smsPanel').hide();
    }
}

function selectClub() {

    if ($('#IsEnableClub').val() === '1') {
        $('#ClubPreCardNoDiv').show();
    } else {
        $('#ClubPreCardNoDiv').hide();
    }
}

function modalLogAdmin(ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'admin',
            Method: 'modalLogAdmin',
            Param: ClientId
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}
function ModalShowInfoPid(ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'infoSourceTrust',
            Method: 'ModalShowInfoPid',
            Param: ClientId
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}

function creditSeven(){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        data:
            {
                flag: 'checkCreditSeven',
            },
        success: function (data) {
            $('#Source7Credit').html(data)
        }
    });

}

function selectDetailService(){
    var mainService= $('#type').val();
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
                method: 'servicesListClient',
                className: 'services',
                type: mainService
            }),
        success: function (response) {
            console.log(response);

            var option= '';

            $(response.data).each(function (index,item) {
                option += `<option value=${item.TitleEn}>${item.TitleFa}</option>`;
            });

            $('#detail_type').html(option);
        },
        error : function (error) {
            $.toast({
                heading: 'تعیین کمیسیون مشتریان در وایت لیبل ',
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

function deletedCommission(id){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
                method: 'deletedCommission',
                className: 'clientWhiteCommission',
                id: id
            }),
        success: function (response) {
            $.toast({
                heading: 'حذف کمیسیون مشتریان در وایت لیبل ',
                text: response.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

            setTimeout(function () {
                location.reload();
            },10000);
            location.reload();
        },
        error : function (error) {
            $.toast({
                heading: 'حذف کمیسیون مشتریان در وایت لیبل ',
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
function AddAdditionalSearchServiceData() {
    var CountDiv = $('div[data-target="BaseServiceOrderDiv"]').length;
    var BaseDiv = $('div[data-target="BaseServiceOrderDiv"]:last-child');
    var CloneBaseDiv = BaseDiv.clone();

    CloneBaseDiv.find("input").val("");
    CloneBaseDiv.find("select").prop("selectedIndex", 0);

    BaseDiv.after(CloneBaseDiv);

    var CountDivInEach = 0;
    $('.DynamicAdditionalSearchData').find('[data-parent="ServiceOrderValues"]').each(function () {
        var field = $(this);
        var key = field.attr("data-target");

        field.attr(
            "name",
            "AdditionalSearchServiceData[" + CountDivInEach + "][" + key + "]"
        );

        if (key === "order_number") {
            CountDivInEach++;
        }
    });
}

function RemoveAdditionalSearchServiceData(thiss) {
    var container = thiss.closest('.DynamicAdditionalSearchData');

    if (container.find('div[data-target="BaseServiceOrderDiv"]').length > 1) {
        thiss.closest('div[data-target="BaseServiceOrderDiv"]').remove();

        var CountDivInEach = 0;
        container.find('[data-parent="ServiceOrderValues"]').each(function () {
            var field = $(this);
            var key = field.attr("data-target");

            field.attr(
                "name",
                "AdditionalSearchServiceData[" + CountDivInEach + "][" + key + "]"
            );

            if (key === "order_number") {
                CountDivInEach++;
            }
        });
    }
}

function archive(_this, client_id) {
    $.ajax({
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            method: 'archive',
            className: 'partner',
            client_id: client_id,
        }),
        type: 'POST',
        dataType: 'JSON',
        success: function (response) {
            if (response.success === true) {
                $.toast({
                    heading: 'آرشیو مشتری',
                    text: 'مشتری با موفقیت آرشیو شد',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
                disableTableRow(`del-${client_id}`)
            } else {
                $.toast({
                    heading: 'آرشیو مشتری',
                    text: 'خطا در آرشیو مشتری',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }
        },
        complete: function () {
            setTimeout(function () {
                // window.location = `${amadeusPath}itadmin/articles/list`;
            }, 1000)
        },
    })
}
function unarchive(_this, client_id) {
    $.ajax({
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            method: 'unarchive',
            className: 'partner',
            client_id: client_id,
        }),
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
            if (response.success === true) {
                $.toast({
                    heading: 'لغو آرشیو مشتری',
                    text: 'آرشیو مشتری با موفقیت لغو شد',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
                disableTableRow(`del-${client_id}`)
            } else {
                $.toast({
                    heading: 'لغو آرشیو مشتری',
                    text: 'خطا در لغو آرشیو مشتری',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6,
                })
            }
        },
        complete: function() {
            setTimeout(function() {
                // window.location = `${amadeusPath}itadmin/articles/list`;
            }, 1000)
        },
    })
}

$("#flightDataCode").validate({
    errorElement: "em",
    errorPlacement: function (error, element) {
        error.addClass("help-block");
        if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
        } else {
            error.insertAfter(element);
        }
    },
    dataType: "json",
    submitHandler: function (form) {
        $(form).ajaxSubmit({
            url: amadeusPath + 'user_ajax.php',
            type: "post",
            success: function (data) {
                if(!data){
                    $.toast({
                        heading: 'خطا در دریافت اطلاعات',
                        text: 'داده ای با نشخصات ذیل یافت نشد',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }else{
                    $.toast({
                        heading: 'دریافت اطلاعات ',
                        text: 'اطلاعات با موفقیت دریافت شد',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                    var tbody = '';
                    data.forEach(function (item, index) {
                        let response = ''
                        if(item.businessMethodName == 'Search'){
                            response = ` <td><a target="_blank" href="http://safar360.com/Core/V-1/Flight/findFilesource15/${item.response}">${item.response}</a></td>`  ;
                        }else{
                            response = ` <td class="download-log"
                                data-id="${item.code}"
                                data-type="response"
                                data-method="${item.businessMethodName}"
                                data-content="${item.response}">دانلود فایل ریسپانس</td>`  ;
                        }

                        tbody += `
                        <tr id="${item.id}">
                            <td>${index + 1}</td>
                            <td>${item.code}</td>
                            <td>${item.businessMethodName}</td>
                            <td>${item.ApiMethodName}</td>
                            <td class="download-log"
                            data-id="${item.code}"
                            data-type="request"
                            data-method="${item.businessMethodName}"
                            data-content="${item.request}">دانلود فایل درخواست</td>
                            ${response}
                          
                        </tr>
                    `;
                    });
// اول بررسی کن که اگر DataTable هست، حذفش کن
                    if ( $.fn.DataTable.isDataTable('#myTable') ) {
                        $('#myTable').DataTable().clear().destroy();
                    }
                    $('#myTable tbody').remove();
                    $('#myTable').append('<tbody>' + tbody + '</tbody>');
                    $('#myTable').DataTable({
                        pageLength: 10, // نمایش 10 ردیف در هر صفحه
                        lengthMenu: [10, 25, 50, 100], // گزینه‌های تغییر تعداد نمایش
                    });


                    $('.download-log').on('click', function () {
                        var content = $(this).data('content');
                        var type = $(this).data('type');
                        var id = $(this).data('id');
                        var method = $(this).data('method');
                        var type_search = $('#type').val();

                        $.ajax({
                            url: amadeusPath + 'user_ajax.php',
                            type: "POST",
                            dataType: 'json',
                            data: {
                                flag: 'generateTxtContent',
                                content: content,
                                type: type,
                                id: id,
                                method: method,
                                type_search: type_search,
                            },
                            success: function (response) {
                                // حالا باید فایل رو دستی بسازی
                                const blob = new Blob([response.content], { type: 'text/plain' });

                                const a = document.createElement('a');
                                a.href = window.URL.createObjectURL(blob);
                                a.download = response.filename || 'download.txt';
                                document.body.appendChild(a);
                                a.click();
                                a.remove();
                            },
                            error: function (xhr) {
                                alert("خطا در دریافت محتوا");
                            }
                        });
                    });

                }
            },
            error: function (xhr) {
                $.toast({
                    heading: 'خطا در دریافت اطلاعات',
                    text: 'مشکلی در ارتباط با سرور پیش آمد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
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

function disableTableRow(id){
    row = document.getElementById(id);
    row.style.setProperty('background-color', 'rgba(255, 0, 0, 0.3)', 'important');
    row.querySelectorAll('input, button, select, textarea, a').forEach(el => {
        el.disabled = true;
    });
}