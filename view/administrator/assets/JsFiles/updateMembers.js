



function updateMembersClub() {

        $.ajax({
            type: 'post',
            url: amadeusPath + 'user_ajax.php',
            dataType:'JSON',
            data:{
              flag:'updateMembersClub'
            },
            success: function (data) {
                if (data.status == 'success') {

                    $.toast({
                        heading: 'بروز ریانی کاربران باشگاه مشتریان',
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
                        heading: 'بروز ریانی کاربران باشگاه مشتریان',
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


function fileExists(url) {
    if(url){
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status==200;
    } else {
        return false;
    }
}