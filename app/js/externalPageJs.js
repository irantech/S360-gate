
$(document).ready(function () {
    $('.BankRadioButton').on("click", function () {
        $('#ChooseBank').val($(this).val());
    });

})

function goBankForApp(obj) {

    $(obj).find('i').removeClass('myhidden');
    $(obj).find('span').text('در حال بررسی');
    $(obj).css('opacity', '0.5');

    var bankInput =  $(obj).attr('bankInputs');
    var link =  $(obj).attr('bankAction');
    var inputs = JSON.parse(bankInput);
    inputs['type'] = 'App'; // for flight

    var bankChoose = $('#ChooseBank').val();
    var credit_status = '';
    var price_to_pay = '';
    if ($(".price-after-discount-code").length > 0) {
        price_to_pay = $(".price-after-discount-code").html().replace(/,/g, '');
    }

    $.ajax({
        url: '../../user_ajax.php',
        method: 'post',
        dataType: 'json',
        //send "query" to server. Useful in case you generate response dynamically
        data:
            {
                flag: 'checkMemberCredit',
                price_to_pay: price_to_pay,
                creditUse: $("input[name='chkCreditUse']:checked").val()
            },
        success: function (data) {

            credit_status = data.result_status;
            if (bankChoose != '' || credit_status == 'full_credit') {

                var discountCode = '';
                if ($('#discount-code').length > 0) {
                    discountCode = $('#discount-code').val();
                }
                inputs['discountCode'] = discountCode;

                if ($("input[name='chkCreditUse']").length > 0 && $("input[name='chkCreditUse']:checked").val() == 'member_credit') {
                    inputs['memberCreditUse'] = true;
                }

                console.log(inputs);
               $.ajax({
                    url: '../../user_ajax.php',
                    method: 'post',
                    dataType: 'json',
                    //send "query" to server. Useful in case you generate response dynamically
                    data: inputs,
                    success: function (response) {

                        setTimeout(function () {
                            $(obj).find('i').addClass('myhidden');
                            $(obj).find('span').text('پرداخت');
                            $(obj).css('opacity', '1');

                        }, 2500);
                        if (response.creditStatus == 'TRUE') {

                            var form = document.createElement("form");
                            form.setAttribute("method", "POST");
                            form.setAttribute("action", link);
                            form.setAttribute("id", "FormBankApp");
                            Object.keys(inputs).forEach(function (key) {

                                if (typeof inputs[key] === 'object' && inputs[key] !== null) {
                                    Object.keys(inputs[key]).forEach(function (key2) {
                                        var hiddenField = document.createElement("input");
                                        hiddenField.setAttribute("type", "hidden");
                                        hiddenField.setAttribute("name", key + '[' + key2 + ']');
                                        hiddenField.setAttribute("value", inputs[key][key2]);
                                        form.appendChild(hiddenField);
                                    });
                                } else {
                                    var hiddenField = document.createElement("input");
                                    hiddenField.setAttribute("type", "hidden");
                                    hiddenField.setAttribute("name", key);
                                    hiddenField.setAttribute("value", inputs[key]);
                                    form.appendChild(hiddenField);
                                }
                            });
                            var bank = document.createElement("input");
                            bank.setAttribute("type", "hidden");
                            bank.setAttribute("name", "bankType");
                            bank.setAttribute("value", bankChoose);

                            form.appendChild(bank);
                            document.body.appendChild(form);
                            console.log(form);
                            form.submit();
                            document.body.removeChild(form);

                        } else {

                            setTimeout(function () {
                                $(obj).find('i').addClass('myhidden');
                                $(obj).find('span').text('پرداخت');
                                $(obj).css('opacity', '1');

                            }, 2500);


                            alert('اشکال در اتصال به بانک');
                      /*      var toastLargeMessage = $.toast.create({
                                text: 'اشکال در اتصال به بانک',
                                closeTimeout: 2000,
                                position: 'bottom'
                            });
                            toastLargeMessage.open();*/
                        }

                    }
                });






            } else {
                alert('لطفا یک بانک را انتخاب نمائید');
               /* var toastLargeMessage = $.toast.create({
                    text: 'لطفا یک بانک را انتخاب نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                toastLargeMessage.open();*/
            }


        }
    });


}