$(document).ready(function () {
    //For switch active And inactive
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });
});

function continentValidateJs(id) {

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'continentActivate',
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else{
                var displayIcon = 'error';
            }

            $.toast({
                heading: ' وضعیت قاره ',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}

function countryValidateJs(id) {

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'visa_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'countryActivate',
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else{
                var displayIcon = 'error';
            }

            $.toast({
                heading: ' وضعیت کشور ',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}