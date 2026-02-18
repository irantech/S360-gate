
$(document).ready(function () {

    $("#FormChangePrice").validate({
        rules: {
            start_date: "required",
            end_date: "required",
            abbreviation: "required",
            change_type: "required",
            price: "required"
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
                            heading: 'افزودن تغییرات قیمت جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='changePriceTicket';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات قیمت جدید',
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


function delete_change_price(id)
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
                                id: id,
                                flag: 'delete_price_change'
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
                                        $('#DelChangePrice-' + id).removeClass('popover-danger').addClass('popover-default').attr('onclick','return false').attr('data-content','شما قبلا این بازه زمانی را حذف نموده اید').find('i').removeClass('btn-danger fa-trash').addClass('btn-default fa-ban');
                                        $('#borderPrice-' + id).addClass('border-right-change-price');
                                        }, 1000);
                                } else
                                {
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
                btnClass: 'btn-orange',
            }
        }
    });
}

function StatusChangePrice (id)
{

    $.post(amadeusPath + 'user_ajax.php',
            {
                id: id,
                flag: 'PriceChangeStatus'
            },
            function (data) {
                var res = data.split(':');

                if (data.indexOf('success') > -1)
                {

                    $.alert({
                        title: 'وضعیت تغییر قیمت',
                        icon: 'fa fa-shield',
                        content: res[1],
                        rtl: true,
                        type: 'green',
                    });

                    setTimeout(function () {
                       $('#public_load').load('administratorPriceChange#example1_wrapper');

                    }, 1000);
                } else
                {
                    $.alert({
                        title: 'وضعیت تغییر قیمت',
                        icon: 'fa fa-shield',
                        content: res[1],
                        rtl: true,
                        type: 'red',
                    });
                }

            });



}
