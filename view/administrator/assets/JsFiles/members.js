function changeStatusRequestCredit(id,type) {
    var price = $('#PriceGift'+id).val();
    
    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            type: type,
            price:price,
            flag: 'changeStatusMemberCredit'
        },
        function (data) {
            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: ' بررسی درخواست اعتبار کاربر ',
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
                },1000)
            } else {
                $.toast({
                    heading: ' بررسی درخواست اعتبار کاربر ',
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