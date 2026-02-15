$(document).ready(function () {

    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });

});



function isActive(id) {

    $.post(amadeusPath + 'tour_ajax.php',
        {
            id: id,
            flag: 'isShowLoginPopupActive'
        },
        function (data) {

            var res = data.split(':');
            if (data.indexOf('success') > -1) {
                $.toast({
                    heading: 'ویرایشگر',
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

            } else {
                $.toast({
                    heading: 'ویرایشگر',
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

