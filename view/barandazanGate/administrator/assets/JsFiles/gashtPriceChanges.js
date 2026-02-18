$(document).ready(function () {



    $(".gashtPriceChanges").change(function () {
        var price = $(this).val();
        price = price.replace(/,/g, "");
        var changeType = $(this).parents('td').find('.changeType').val();
        var counter = $(this).parents('td').find('.counterID').val();

        if(changeType == 'percent' && price > 100){

            $.toast({
                heading: 'تغییرات قیمت',
                text: 'خطا: مقدار نامعتبر (بیش از 100%)',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        } else {

            $.post(amadeusPath + 'gasht_ajax.php',
                {
                    flag: 'gashtPriceChanges',
                    price: price,
                    changeType: changeType,
                    counterID: counter
                },
                function (data) {

                    var res = data.split(':');

                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییرات قیمت گشت و ترانسفر',
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
                            heading: 'تغییرات قیمت گشت و ترانسفر',
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