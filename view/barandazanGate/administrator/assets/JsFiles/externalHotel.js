$(document).ready(function () {

    $('.updateInput').on('change', function () {

       let inputName = $(this).attr('name');
       let inputValue = $(this).val();
       let id = $(this).parent('td').parent('tr').attr('id');

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data:
                {
                    inputName: inputName,
                    inputValue: inputValue,
                    id: id,
                    flag: "updateExternalHotelCity"
                },
            success: function (response) {

                if (response){

                    $.toast({
                        heading: 'تغییرات شهر و کشور',
                        text: 'ثبت تغییرات با موفقیت انجام شد.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                } else {

                    $.toast({
                        heading: 'تغییرات شهر و کشور',
                        text: 'خطا در  تغییرات ...',
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


    });

    $('.updateInputRoomName').on('change', function () {

       let inputName = $(this).attr('name');
       let inputValue = $(this).val();
       let roomName = $(this).parent('td').parent('tr').attr('room_name');

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data:
                {
                    inputName: inputName,
                    inputValue: inputValue,
                    roomName: roomName,
                    flag: "updateExternalHotelRoom"
                },
            success: function (response) {

                if (response){

                    $.toast({
                        heading: 'تغییرات اتاق ها',
                        text: 'ثبت تغییرات با موفقیت انجام شد.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                } else {

                    $.toast({
                        heading: 'تغییرات اتاق ها',
                        text: 'خطا در  تغییرات ...',
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


    });

    $('.updateInputRoomFacilities').on('change', function () {

       let inputName = $(this).attr('name');
       let inputValue = $(this).val();
       let value = $(this).parent('td').parent('tr').attr('value');

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data:
                {
                    inputName: inputName,
                    inputValue: inputValue,
                    value: value,
                    flag: "updateExternalHotelFacilities"
                },
            success: function (response) {

                if (response){

                    $.toast({
                        heading: 'تغییرات امکانات',
                        text: 'ثبت تغییرات با موفقیت انجام شد.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                } else {

                    $.toast({
                        heading: 'تغییرات امکانات',
                        text: 'خطا در  تغییرات ...',
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


    });

});

function searchExternalHotelCity() {
    let searchInput = $('#search').val();
    if (searchInput.length > 0){
        window.location = 'externalHotelCity&page=1&search=' + searchInput;
    } else {
        window.location = 'externalHotelCity&page=1';
    }
}



function searchExternalHotelRoom() {
    let searchInput = $('#search').val();
    if (searchInput.length > 0){
        window.location = 'externalHotelRooms&page=1&search=' + searchInput;
    } else {
        window.location = 'externalHotelRooms&page=1';
    }
}

function searchExternalHotelFacilities() {
    let searchInput = $('#search').val();
    if (searchInput.length > 0){
        window.location = 'externalHotelFacilities&page=1&search=' + searchInput;
    } else {
        window.location = 'externalHotelFacilities&page=1';
    }
}