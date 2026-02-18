$(document).ready(function () {

    //for activate/deactivate messages
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });

    //add and edit sms message
    $("#messageAdd, #messageEdit").validate({
        rules: {
            title:'required',
            body:'required',
            usage:'required'
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
                url: amadeusPath + 'sms_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {

                    if (response.result_status == 'success') {
                        var displayIcon = 'success';
                    } else{
                        var displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'متن پیامک',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function(){
                            window.location = 'messages';
                        }, 3500);
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

    //edit service info
    $("#setSmsService").validate({
        rules: {
            smsService:'required',
            smsUsername:'required',
            smsPassword:'required',
            smsNumber:'required'
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
                url: amadeusPath + 'sms_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {

                    if (response.result_status == 'success') {
                        var displayIcon = 'success';
                    } else{
                        var displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'سرویس پیامک',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function(){
                            window.location = 'setSmsService&id=' + $('#clientID').val();
                        }, 3500);
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

    //display on/off smsNumber to enter numbers
    $('#smsReceiver').on('change', function () {
        if($(this).val() == 'custom'){
            $('.showCustom').fadeIn('fast');
        } else{
            $('.showCustom').fadeOut('fast');
        }
    });

    //send sms
    $("#messageSend").validate({
        rules: {
            smsReceiver:'required',
            smsMessage:'required',
            smsNumber: {
                required: {
                    depends: function (element) {
                        return $('#smsReceiver').val() == 'custom';
                    }
                }
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
                url: amadeusPath + 'sms_ajax.php',
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {

                    if (response.result_status == 'success') {
                        var displayIcon = 'success';
                    } else{
                        var displayIcon = 'error';
                    }

                    $.toast({
                        heading: 'ارسال پیامک',
                        text: response.result_message,
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (response.result_status == 'success') {
                        setTimeout(function(){
                            window.location = 'sendMessage';
                        }, 3500);
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

function activate(id)
{
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'sms_ajax.php',
        dataType: 'JSON',
        data:
            {
                flag: 'activateMessage',
                id: id
            },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else{
                var displayIcon = 'error';
            }

            $.toast({
                heading: 'وضعیت پیامک',
                text: response.result_message,
                position: 'top-right',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

            setTimeout(function(){
                window.location = 'messages';
            }, 1000);

        }
    });
}


function Addpattern() {


    var CountDiv = $('div[data-target="BasepatternDiv"]').length
    var BaseDiv = $('div[data-target="BasepatternDiv"]:last-child')
    var CloneBaseDiv = $('div[data-target="BasepatternDiv"]:last-child').clone()
    var CountDivInEach = 0

    CloneBaseDiv.find("input").val("")
    $('div[data-target="BasepatternDiv"]:last-child').after(CloneBaseDiv)

    $('.Dynamicpattern select[data-parent="patternValues"]').each(function () {
        console.log(CountDivInEach)
        $(this).attr(
          "name",
          "pattern[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
        )
        CountDivInEach = CountDivInEach + 1
    })
    var CountDivInEach = 0
    $('.Dynamicpattern input[data-parent="patternValues"]').each(function () {
        $(this).attr(
          "name",
          "pattern[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
        )
        CountDivInEach = CountDivInEach + 1
    })



}


function Removepattern(thiss) {
    if (
      thiss.parent().parent().parent().parent().find('div[data-target="BasepatternDiv"]').length > 1
    ) {
        thiss.parent().parent().parent().remove()

        var CountDivInEach = 0
        $('.Dynamicpattern select[data-parent="patternValues"]').each(
          function () {
              $(this).attr(
                "name",
                "pattern[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
              )
              CountDivInEach = CountDivInEach + 1
          }
        )
        var CountDivInEach = 0
        $('.Dynamicpattern input[data-parent="patternValues"]').each(
          function () {
              $(this).attr("name", "pattern[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
              )
              CountDivInEach = CountDivInEach + 1
          }
        )
    }
}