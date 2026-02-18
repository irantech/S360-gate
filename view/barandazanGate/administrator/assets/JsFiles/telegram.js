

$(document).ready(function () {
    $("#changeListRobot").validate({
        rules: {
            listads: "required"
        },
        messages: {
            listads: {
                required: "وارد کردن این فیلد الزامیست"

            }
        },
        errorElement: "em",

        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'telegram_ajax.php',
                type: "post",
                success: function (response) {
                    obj = $.parseJSON(response);
                    console.log(obj);


                    if (obj.size > 0) {
                        $.toast({
                            heading: 'به روز رسانی اطلاعات',
                            text: "ویرایش اطلاعات انجام شد",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='manageTelegram';
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'عدم ثبت اطلاعات',
                            text: "تعداد لیست باید حداقل 1  مورد باشد",
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


    $("#createListRobot").validate({
        rules: {
            listads: "required"
        },
        messages: {
            listads: {
                required: "وارد کردن این فیلد الزامیست"
            }
        },
        errorElement: "em",

        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'telegram_ajax.php',
                type: "post",
                success: function (response) {
                    obj = $.parseJSON(response);
                    console.log(obj);


                    if (obj.filter=="1") {
                        $.toast({
                            heading: 'به روز رسانی اطلاعات',
                            text: "ویرایش اطلاعات انجام شد",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='manageTelegram';
                        }, 1000);

                    } else if(obj.filter=="2") {

                        $.toast({
                            heading: 'عدم ثبت اطلاعات',
                            text: "انتخاب مسیر ها الزامیست",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }
                    else if(obj.filter=="3") {

                        $.toast({
                            heading: 'عدم ثبت اطلاعات',
                            text: "   این مسیر قبلا ثبت شده ",
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


    $("#checkUser").validate({
        rules: {
            username: "required"

        },
        messages: {
            username: {
                required: "وارد کردن آیدی کاربر الزامیست"

            }
        },
        errorElement: "em",

        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'telegram_ajax.php',
                type: "post",
                success: function (response) {
                    obj = $.parseJSON(response);
                    console.log(obj);


                    if (obj.status) {
                        $.toast({
                            heading: ' موفقیت آمیز',
                            text: "کاربر مورد نظر در گروه یا کانال عضو است",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='manageRobot';
                        }, 100000);

                    }


                    else   {

                        $.toast({
                            heading: 'ناموفق ',
                            text: "  کاربر مورد نظر عضو نیست    ",
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


    $("#createRobot").validate({
        rules: {
            chat_id: "required",
            token:"required",
            title: "required",
            brand:"required"
        },
        messages: {
            chat_id: {
                required: "وارد کردن فیلد چت آیدی الزامیست"

            },
            token: {
                required: "وارد کردن فیلد توکن الزامیست"

            },
            title: {
                required: "وارد کردن فیلد عنوان الزامیست"

            },
            brand: {
                required: "وارد کردن فیلد برند الزامیست"

            }
        },
        errorElement: "em",

        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'telegram_ajax.php',
                type: "post",
                success: function (response) {
                    obj = $.parseJSON(response);
                    console.log(obj);


                    if (obj.resultStatus=="1") {
                        $.toast({
                            heading: 'به روز رسانی اطلاعات',
                            text: "ربات عضو نیست یا هبچ پیامی در گروه یا کانال وجود ندارد",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 4500,
                            textAlign: 'right',
                            stack: 6
                        });



                    }
                    else if(obj.resultStatus=="2")  {

                        $.toast({
                            heading: 'عدم ثبت اطلاعات',
                            text: "   اطلاعات ربات نادرست است   ",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }
                    else if(obj.resultStatus=="3")  {

                        $.toast({
                            heading: 'تبت ربات',
                            text: "  ربات جدید ثب شد ",
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='manageRobot';
                        }, 1000);

                    }
                    else if(obj.resultStatus=="4")  {

                        $.toast({
                            heading: 'تبت ربات',
                            text: "  این ربات قبلا ثبت شده ",
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



    $("#insertRouteRobot").validate({
        rules: {
            origin: "required",
            destination:"required"
        },
        messages: {
            origin: {
                required: "وارد کردن مبدا الزامیست"

            },
            destination: {
                required: "وارد کردن مقصد الزامیست"

            }
        },
        errorElement: "em",

        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'telegram_ajax.php',
                type: "post",
                success: function (response) {
                   let obj = $.parseJSON(response);
                    console.log(obj);


                    if (obj.status=="success") {
                        $.toast({
                            heading: 'افزودن مسیر',
                            text: obj.message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 4500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }else {
                        $.toast({
                            heading: 'افزودن مسیر',
                            text: obj.messages,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 4500,
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


})
function select_Airport() {
    var Departure = $('#origin_local').val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            Departure: Departure,
            flag: "select_Airport",
        },
        function (data) {
            $('#destination_local').html(data);
            $('#destination_local').select2('open');
        })
}

function removeRobot(e,id) {
    e.preventDefault();
    $.post(amadeusPath + 'telegram_ajax.php',
        {
            flag: 'removeRobot',
            id:id

        },
        function (response) {

            obj = $.parseJSON(response);



            if (obj.status) {
                $.toast({
                    heading: '  ویرایش اطلاعات',
                    text: "ربات حذف شد",
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function () {
                    window.location = 'manageRobot';
                }, 1000);

            }
            else {
                $.toast({
                    heading: '  ویرایش اطلاعات',
                    text: "ریات حذف نشد",
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



    // $.post(amadeusPath + 'telegram_ajax.php',
    //     {
    //         flag: 'DeactiveList',
    //         value:itemvalue
    //
    //
    //     },
    //     function (response) {
    //
    //         // obj = $.parseJSON(response);
    //         console.log(response);
    //
    //
    //         if (response) {
    //             $.toast({
    //                 heading: ' ثبت تغییرات',
    //                 text: "لیست انتخاب شده غیر فعال شد",
    //                 position: 'top-right',
    //                 loaderBg: '#fff',
    //                 icon: 'success',
    //                 hideAfter: 3500,
    //                 textAlign: 'right',
    //                 stack: 6
    //             });
    //             setTimeout(function(){
    //                 window.location ='manageTelegram';
    //             }, 1000);
    //
    //         } else {
    //
    //             $.toast({
    //                 heading: ' خطا ',
    //                 text: "اروری در ثبت تغییرات وجود دارد",
    //                 position: 'top-right',
    //                 loaderBg: '#fff',
    //                 icon: 'error',
    //                 hideAfter: 3500,
    //                 textAlign: 'right',
    //                 stack: 6
    //             });
    //
    //         }
    //
    //     });
// });

function ModalShowindexActiveRobot(ClientId) {

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'infoRobot',
            Method: 'ModalShowindexActiveRobot',
            Param: ClientId
        },
        function (data) {

            $('#ModalPublic').html(data);

        });
}


function SendRobot(id) {



    $.post(amadeusPath + 'telegram_ajax.php',
        {
            flag: 'sendListRobotInGroup',
            id:id

        },
        function (response) {

            obj = $.parseJSON(response);
            console.log(obj);


            if (obj.status) {
                $.toast({
                    heading: '  ارسال اطلاعات',
                    text: "اطلاعات ارسال شد",
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function () {
                    window.location = 'manageTelegram';
                }, 100000);

            } else {

                $.toast({
                    heading: ' خطا ',
                    text: "اطلاعات ارسال نشد",
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
// $("#Send").click(function () {
//
//
//    alert("");
    //
    // $.post(amadeusPath + 'telegram_ajax.php',
    //     {
    //         flag: 'sendinformationInGroup'
    //
    //     },
    //     function (response) {
    //
    //          obj = $.parseJSON(response);
    //         console.log(obj);
    //
    //
    //         if (obj.resultStatus) {
    //             $.toast({
    //                 heading: '  ارسال اطلاعات',
    //                 text: "لیست پرواز ها در گروه به اشتراک گذاشته شد",
    //                 position: 'top-right',
    //                 loaderBg: '#fff',
    //                 icon: 'success',
    //                 hideAfter: 3500,
    //                 textAlign: 'right',
    //                 stack: 6
    //             });
    //             setTimeout(function(){
    //                 window.location ='manageTelegram';
    //             }, 1000);
    //
    //         } else {
    //
    //             $.toast({
    //                 heading: ' خطا ',
    //                 text: "اطلاعات ارسال نشد",
    //                 position: 'top-right',
    //                 loaderBg: '#fff',
    //                 icon: 'error',
    //                 hideAfter: 3500,
    //                 textAlign: 'right',
    //                 stack: 6
    //             });
    //
    //         }
    //
    //     });

//
//
// });






function StatuslistTelegram(ClientId, iata, type,e)
{
    var itemvalue=e.data("value");
    var itemstatus=e.find("input#status").data("value");
    $.post(amadeusPath + 'telegram_ajax.php',
        {

            value: itemvalue,
            statusitem:itemstatus,
            flag: 'DeactiveList'
        },
        function (data) {


            if (true)
            {

                $.toast({
                    heading: 'وضعیت لیست های تلگرام ',
                    text: "تغییر وضعیت انجام شد",
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
                    heading: 'وضعیت لیست های تلگرام',
                    text: "خطا در تغییر وضعیت",
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




$(document).ready(function () {
    $('.dropify').dropify();
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });


});



