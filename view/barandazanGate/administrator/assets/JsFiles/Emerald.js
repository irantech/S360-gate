
function activate(id,clientId)
{
    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            idclient:clientId,
            flag: 'VerifyRequestEmerald'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'وضعیت تایید پرداخت',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function(){
                    window.location ='Emerald';
                }, 1000);
            } else
            {
                $.toast({
                    heading: 'وضعیت تایید پرداخت',
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
function activate2(id,clientId,that)
{
    $.post(amadeusPath + 'user_ajax.php',
        {
            id: id,
            idclient:clientId,
            flag: 'VerifyRequestEmerald'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.toast({
                    heading: 'وضعیت تایید پرداخت',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                setTimeout(function(){
                    window.location =that;
                }, 1000);
            } else
            {
                $.toast({
                    heading: 'وضعیت تایید پرداخت',
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