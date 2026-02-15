
$(document).ready(function () {

//    $(".commissionPercent").TouchSpin({
//        min: -100,
//        max: 100,
//        step: 0.5,
//        decimals: 2,
//        maxboostedstep: 100,
//        postfix: '%'
//    });

    $(".commissionChange").change(function () {
        var commission = $(this).val();
        var client = $('.clientID').val();
        var service = $(this).siblings('.serviceID').val();
        var source = $(this).siblings('.sourceID').val();

        if(isNaN(commission)){

            $.toast({
                heading: 'تغییرات قیمت',
                text: 'خطا: مقدار نامعتبر، تنها عدد وارد کنید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        } else {

            $.post(amadeusPath + 'user_ajax.php',
                {
                    flag: 'irantechCommissionChange',
                    commission: commission,
                    clientID: client,
                    serviceID: service,
                    sourceID: source
                },
                function (data) {

                    var res = data.split(':');

                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تنظیمات سهم ایران تکنولوژی',
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
                            heading: 'تنظیمات سهم ایران تکنولوژی',
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

    });

});