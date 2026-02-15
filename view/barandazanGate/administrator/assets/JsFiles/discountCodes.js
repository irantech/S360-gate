$(document).ready(function () {

    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });

    $("#DiscountCodesAdd").validate({
        rules: {
            Title:'required',
            Amount:'required',
            StartDate:'required',
            EndDate:'required',
            Stock: {
                required: true,
                number: true,
            },
            limit_point_club:{
                required: {
                    depends: function (element) {
                        return $('input#limit_point_club').is(':checked');
                    }
                },
            }
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

                    console.log(response);
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن کد تخفیف جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='discountCodes';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'افزودن کد تخفیف جدید',
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

    $("#DiscountCodesEdit").validate({
        rules: {
            Title:'required',
            Amount:'required',
            StartDate:'required',
            EndDate:'required',
            Stock: {
                required: true,
                number: true,
            }
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
                            heading: 'ویرایش کد تخفیف',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='discountCodes';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'ویرایش کد تخفیف',
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

    //generate output of excel file
    $('#discountCodesExcel').DataTable({
        "order": [
            [0, 'asc']
        ],
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'دریافت فایل اکسل',
                exportOptions: {}
            }
        ]
    });

});

function activate(id)
{
    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            flag: 'ActivateDiscountCode'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'وضعیت کد تخفیف',
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
                    heading: 'وضعیت کد تخفیف',
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

function ModalShowBook(reserveType, factorNumber) {

    if(reserveType == 'Flight'){
        $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookshow',
            Method: 'ModalShowBook',
            Param: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
    }
    else if(reserveType == 'Hotel')
    {
        $.post(libraryPath + 'ModalCreatorForHotel.php',
        {
            Controller: 'bookhotelshow',
            Method: 'ModalShowBook',
            Param: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
    }
    else if(reserveType == 'Insurance')
    {
        $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookingInsurance',
            Method: 'ModalShowInsuranceBook',
            Param: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
    }
    else if(reserveType == 'Europcar')
    {
        $.post(libraryPath + 'ModalCreatorForEuropcar.php',
        {
            Method: 'ModalShowBook',
            factorNumber: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
    }
    else if(reserveType == 'Tour')
    {
        $.post(libraryPath + 'ModalCreatorForTour.php',
        {
            Method: 'ModalShowBook',
            factorNumber: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
    }
    else if(reserveType == 'Visa')
    {
        $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'bookingVisa',
            Method: 'ModalShowVisaBook',
            Param: factorNumber
        },
        function (data) {
            $('#ModalPublic').html(data);
        });
    }
}

function deleteCode(id)
{
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
                            flag: 'discountCodeDelete',
                            id: id
                        },
                        function (data) {

                            var res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
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

                            }else {
                                $.toast({
                                    heading: 'حذف تغییرات',
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
                btnClass: 'btn-orange'
            }
        }
    });
}

function showAmountPointDiscountCode(){
    if ($('#is_consume').is(':checked')) {
        $('.limit-point-club').show()
    }else{
        $('.limit-point-club').hide()
    }

}