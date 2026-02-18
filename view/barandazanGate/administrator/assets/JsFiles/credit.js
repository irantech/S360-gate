
$(document).ready(function () {


//    
    $("#AddCredit").validate({
        rules: {
            credit: "required",
            becauseOf: "required",
            comment: "required"

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

            $('#loadingbank').show();
            $('#SendFormCredit').text('در حال بررسی').css('opacity','0.5');
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');
                    var id = $('#agencyID').val();


                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن(کسر) اعتبار',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            $('#loadingbank').hide();
                            $('#SendFormCredit').text('ارسال اطلاعات').css('opacity','1');
                            window.location ='creditDetailList&id=' +  id;
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن(کسر) اعتبار',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        $('#loadingbank').hide();
                        $('#SendFormCredit').text('ارسال اطلاعات').css('opacity','1');
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

