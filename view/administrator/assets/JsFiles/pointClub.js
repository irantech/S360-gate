$(document).ready(function () {
    //
    // $("input[name='limitPoint']").TouchSpin();



    /*$(".changePrice").change(function () {
        var price = $(this).val();
        price = price.replace(/,/g, "");
        var counter = $(this).parents('td').find('.counterID').val();
        var service = $(this).parents('td').find('.servicesTitle').val();
        var limitPrice = $('#limitPrice').val();
        var limitPoint = $('#limitPoint').val();

        if(limitPrice=="" || limitPoint==""){

            $(this).val('');
            $.toast({
                heading: 'تعیین امتیاز',
                text: 'خطا: میزان مبلغ و امتیاز را وارد نمائید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

            return false;

        } else {

            $.ajax({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                dataType:'json',
                data:{
                    flag: 'pointClubRegister',
                    price: price,
                    counterID: counter,
                    service: service,
                    limitPrice: limitPrice,
                    limitPoint: limitPoint
                },
                success: function (data) {

                    console.log(data.status);
                    if (data.status=='success') {
                        $.toast({
                            heading: 'تعیین امتیاز',
                            text: data.message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    } else {
                        $.toast({
                            heading: 'تعیین امتیاز',
                            text: data.message,
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
    });*/

    /*$("#AddPointClub").validate({
        rules: {
            limitPoint:
                {
                    required: true,
                    number: true
                },
            limitPrice: {
                required: true,
                number: true
            },
            is_foreign : "required"
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
                            heading: 'افزودن امتیاز جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function () {
                            window.location = 'pointClub';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن امتیاز جدید',
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


    });*/


    $("#formPointClub").validate({
        rules: {
            services: "required",
            limitPrice: "required",
            limitPoint: "required"
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
                success: function (data) {

                    console.log(data);
                    let res = data.split(':');
                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تعیین امتیاز',
                            text: res[1],
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

                    } else {
                        $.toast({
                            heading: 'تعیین امتیاز',
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

    $("#formAddDiscountToTrain").validate({
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
                success: function (data) {

                    console.log(data);
                    let res = data.split(':');
                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تعیین امتیاز',
                            text: res[1],
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

                    } else {
                        $.toast({
                            heading: 'تعیین امتیاز',
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

    $(".editPointClub").change(function () {
        let id = $(this).data('id');
        let nameInput = $(this).attr('name');
        let nameValue = $(this).val();


        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            data:{
                flag: 'pointClubEdit',
                id: id,
                nameInput: nameInput,
                nameValue: nameValue
            },
            success: function (data) {

                console.log(data);
                let res = data.split(':');
                if (data.indexOf('success') > -1) {
                    $.toast({
                        heading: 'تعیین امتیاز',
                        text: res[1],
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

                } else {
                    $.toast({
                        heading: 'تعیین امتیاز',
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
    });

});

function deletePointClub(id) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف امتیاز',
        icon: 'fa fa-trash',
        content: 'آیا از حذف امتیاز اطمینان دارید',
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
                            flag: 'deletePointClub'
                        },
                        function (data) {
                            let res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف امتیاز',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    $('#DelChangePrice-' + id).removeClass('popover-danger').addClass('popover-default').attr('onclick','return false').attr('data-content','شما قبلا این میزان امتیاز را حذف نموده اید').find('i').removeClass('btn-danger fa-trash').addClass('btn-default fa-ban');
                                    $('#borderPrice-' + id).addClass('border-right-change-price');
                                }, 1000);
                            } else
                            {
                                $.toast({
                                    heading: 'حذف امتیاز',
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


function deletePercentTrain(id) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تخفیف',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تخفیف اطمینان دارید',
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
                            flag: 'deletePercentTrain'
                        },
                        function (data) {
                            let res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تخفیف',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    $('#DelChangePrice-' + id).removeClass('popover-danger').addClass('popover-default').attr('onclick','return false').attr('data-content','شما قبلا این میزان امتیاز را حذف نموده اید').find('i').removeClass('btn-danger fa-trash').addClass('btn-default fa-ban');
                                    $('#borderPrice-' + id).addClass('border-right-change-price');
                                }, 1000);
                            } else
                            {
                                $.toast({
                                    heading: 'حذف تخفیف',
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

function getBaseCompany() {
    $('#base_company').prop('disabled', false);
    $('#company').prop('disabled', false);
    let services = $('#services').val();
    if (services != 'all') {
        let groupServices = $('#services').find(':selected').data('groupservices');
        $.post(amadeusPath + 'user_ajax.php',
            {
                groupServices: groupServices,
                flag: "flagGetBaseCompany",
            },
            function (data) {
                if (data != '') {
                    $('#base_company').html(data);
                    $('#base_company').select2('open');
                    if (groupServices == 'Bus') {
                        $('#company').prop('disabled', 'disabled');
                    }
                } else {
                    $('#base_company').prop('disabled', 'disabled');
                    $('#company').prop('disabled', 'disabled');
                }
            });
    }
}


