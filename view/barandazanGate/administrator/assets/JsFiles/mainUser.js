function validateMobileOrEmail(inputValue) {
    const mobileRegex = /^[0-9]{11}$/;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Check if the input matches either the mobile regex or email regex
    return mobileRegex.test(inputValue) || emailRegex.test(inputValue);
}
$(document).ready(function () {
    //For switch active And inactive
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });

//

    $.validator.addMethod("validateMobileOrEmail", function(value, element) {
        return this.optional(element) || validateMobileOrEmail(value);
        // Return true if the value is valid, false otherwise
    },'لطفا ایمیل یا شماره همراه خود را وارد کنید');

    $("#AddMainUser").validate({
        rules: {
            name: "required",
            family: "required",
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 13,
                number: true
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
            email: {
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
                            heading: 'افزودن کانتر جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'mainUserList';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن کانتر جدید',
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
    $("#EditMainUser").validate({
        rules: {
            name: "required",
            family: "required",
            typeCounter: "required",
            mobile: {
                required: true,
                minlength: 11,
                maxlength: 13,
                number: true
            },
            password: {
                minlength: 6
            },
            Confirm: {
                required: {
                    depends: function (element) {
                        return $('#password').val() !== '';
                    }
                },
                minlength: 6,
                equalTo: "#password"
            },
            email: {
                required: true,
                validateMobileOrEmail:true
            }
        },
        messages: {
            password: {
                minlength: "رمز عبور نمی تواند از 6 کارکتر کمتر باشد"
            },
            Confirm: {
                required: "وارد کردن این فیلد الزامیست",
                minlength: "تکرار رمز عبور نمی تواند از 6 کارکتر کمتر باشد",
                equalTo: "رمز عبور با تکرار آن برابر نمی باشد"
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
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');
                    var agencyId = $('#agency_id').val();

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن کانتر جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'mainUserList';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن کانتر جدید',
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
    $("#EditBankInfo").validate({
        rules: {
            nameHesab:"required",
            sheba: {
                required: true,
                minlength: 26
            },
            hesabBank:"required"
        },
        messages: {

            nameHesab: {
                required: "وارد کردن این فیلد الزامیست"

            },
            sheba: {
                required: "وارد کردن این فیلد الزامیست"

            },
            hesabBank: {
                required: "وارد کردن این فیلد الزامیست"

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
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');


                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'ویرایش مشخصات حساب بانکی',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'mainUserList';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'ویرایش مشخصات حساب بانکی',
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

function active_User(id) {

    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            flag: 'active_user'
        },
        function (data) {
            var res = data.split(':');

            if (data.indexOf('success') > -1) {

                $.toast({
                    heading: ' وضعیت کاربر ',
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
                    heading: ' وضعیت کاربر ',
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


function ModalAddCounterOfUser(id) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'agency',
            Method: 'ModalAddCounterOfUser',
            Param: id
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}


function ActiveAsCounter(id) {

    var typeCounterId = $('#typeCounterId').val();
    var agency_id = $('#agency_id').val();

    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'انتخاب کاربر به عنوان کانتر',
        icon: 'fa fa-check',
        content: 'آیا از ارسال اطلاعات  اطمینان دارید؟',
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
                            typeCounterId: typeCounterId,
                            agency_id: agency_id,
                            flag: 'ActiveAsCounter'
                        },
                        function (data) {
                            var res = data.split(':');

                            if (data.indexOf('success') > -1) {

                                $.toast({
                                    heading: 'انتخاب کاربر به عنوان کانتر',
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
                                    $('#editUserModal').modal('hide');
                                    $('#del-' + id ).remove();

                                }, 1000);
                            } else {
                                $.toast({
                                    heading: 'انتخاب کاربر به عنوان کانتر',
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



function createExcelForReportMainUserBuy() {

    $('#btn-excel').css('opacity', '0.5');
    $('#loader-excel').removeClass('displayN');

    setTimeout(function () {
        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            data: $('#SearchMainUserBuy').serialize(),
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

function GuestUserConvertModal(email,mobile){

            $('#ModalPublic').html('<div class="modal-dialog modal-lg">' +
                '            <div class="modal-content col-md-12 p-0">' +
                '                <div class="modal-header col-md-12  site-bg-main-color">' +
                '                    <span class="close" onclick="modalClose()">&times;</span>' +
                '                    <h6 class="modal-h">اضافه کردن میهمان به عنوان کاربر</h6>' +
                '                </div>' +
                '                <div class="modal-body col-md-12 ">' +
                '                    <div class="col-md-12 p-0">' +
                '                        <div class="col-md-12 StickyDiv">' +
                '                            <form id="ConvertGuestToMember" method="post">' +
                '                                <div class="form-group col-md-6">' +
                '                                    <label for="NewMemberName">نام</label>' +
                '                                    <input required name="NewMemberName" type="text" class="form-control"' +
                '                                           id="signup-name2"' +
                '                                           placeholder="نام">' +
                '                                    <small id="emailHelp" class="form-text text-muted"></small>' +
                '                                </div>' +
                '                                <div class="form-group col-md-6">' +
                '                                    <label for="NewMemberName">نام خانوادگی</label>' +
                '                                    <input required name="NewMemberName" type="text" class="form-control"' +
                '                                           id="signup-family2"' +
                '                                           placeholder="نام خانوادگی">' +
                '                                    <small id="emailHelp" class="form-text text-muted"></small>' +
                '                                </div>' +
                '                                <button data-target="SubmitForm" type="button" onclick="SubmitNewMemberFromGuestUsersUpdate('+"'"+email+"'"+','+"'"+mobile+"'"+')" class="btn btn-primary mt-4">' +
                'اضافه کردن' +
                '                                </button>' +
                '                            </form>' +
                '                        </div>' +
                '                    </div>' +
                '' +
                '                </div>' +
                '            </div>' +
                '        </div>');
}

function SubmitNewMemberFromGuestUsersUpdate(email,mobile){
  var name = $("#signup-name2").val();
  var family = $("#signup-family2").val();
  var reagentCode = $("#reagent-code2").val();
  $.ajax({
    type: 'post',
    url: amadeusPath + 'user_ajax.php',
    data: {
      name: name,
      family: family,
      mobile: mobile,
      entry: mobile,
      email: email,
      reagentCode: reagentCode,
      setcoockie: "yes",
      flag: 'GuestUpdateUsers'
    },
    success: function (data) {
      if(data.success){
        $.toast({
          heading: 'کاربر به لیست کاربران منتقل شد',
          text:  '',
          position: 'top-right',
          loaderBg: '#fff',
          icon:'success',
          hideAfter:3500,
          textAlign:'right',
          stack:6
        });
        window.location.reload();
      }

      if (data.indexOf('success') > -1) {
        $.toast({
            heading: 'کاربر به لیست کاربران منتقل شد',
          text:  '',
          position: 'top-right',
          loaderBg: '#fff',
          icon:'success',
          hideAfter:3500,
          textAlign:'right',
          stack:6
        });
        window.location.reload();
      } else {
        $.toast({
          heading: 'error',
          text:  '',
          position: 'top-right',
          loaderBg: '#fff',
          icon: 'danger',
          hideAfter: 3500,
          textAlign: 'right',
          stack: 6
        });
        window.location.reload();
      }
    }
  });

}

function SubmitNewMemberFromGuestUsers(email,mobile){
    var name = $("#signup-name2").val();
    var family = $("#signup-family2").val();
    var reagentCode = $("#reagent-code2").val();
    $.ajax({
        type: 'post',
        url: amadeusPath + 'user_ajax.php',
        data: {
            name: name,
            family: family,
            mobile: mobile,
            entry: mobile,
            email: email,
            reagentCode: reagentCode,
            setcoockie: "yes",
            flag: 'memberRegister'
        },
        success: function (data) {
            if(data.success){
                $.toast({
                    heading: 'ثبت شد',
                    text:  '',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon:'success',
                    hideAfter:3500,
                    textAlign:'right',
                    stack:6
                });
                // window.location.reload();
            }

            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'ثبت شد',
                    text:  '',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon:'success',
                    hideAfter:3500,
                    textAlign:'right',
                    stack:6
                });
                // window.location.reload();
            } else {
                $.toast({
                    heading: 'error',
                    text:  '',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'danger',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                // window.location.reload();
            }
        }
    });

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

