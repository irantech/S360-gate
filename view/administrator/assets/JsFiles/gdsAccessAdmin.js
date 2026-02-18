$(document).ready(function () {
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });



});




function updateGdsAccessAdmin(moduleId , agencyId){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType: 'JSON',
        data:  JSON.stringify({
            className: 'gdsModule',
            method: 'updateGdsAccessAdmin',
            moduleId,
            agencyId,
        })
        ,
        success: function (data) {
            $.toast({
                heading: 'تغییر دسترسی انجام شد',
                text: data.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            })
            setTimeout(function() {
                location.reload()
                // window.location = `${amadeusPath}itadmin/weather/list`;
            }, 1000)

        },
        error:function(error) {
            $.toast({
                heading: 'تغییر دسترسی',
                text: error.responseJSON.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            })
            setTimeout(function() {
                location.reload()
                // window.location = `${amadeusPath}itadmin/weather/list`;
            }, 1000)
        }
    });
}

