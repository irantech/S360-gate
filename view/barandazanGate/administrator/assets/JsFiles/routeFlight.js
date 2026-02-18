function EditInPlace(Code, Priority)
{
    $('#'+Code + Priority).html('');
    $('#'+Code + Priority).append('<input class="form-control" name="priority'+Code + Priority+'" value="'+ Priority +'" id="priority' + Code + Priority +'" onchange="SendPriority('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')" onblur="hideInput('+"'"+ Priority+"'"+','+"'"+ Code+"'"+')">');
    $('#'+Code + Priority).attr('onclick','return false');

}

function SendPriority(Priority,Code) {

    var PriorityNew = $('#priority' + Code + Priority ).val();
    $.post(amadeusPath + 'user_ajax.php',
        {
            PriorityOld: Priority,
            PriorityNew: PriorityNew,
            CodeDeparture: Code,
            flag: 'ChangePriorityDeparture'
        },
        function (data) {
            var res = data.split(':');
            if (data.indexOf('SuccessChangePriority') > -1)
            {

                $.toast({
                        heading: 'تغییر الویت',
                        text: res[1],
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                $('#'+Code + Priority).html(PriorityNew);
                setTimeout(function () {
                        window.location.reload();
                }, 1000);
            } else
            {
                $.toast({
                        heading: 'تغییر الویت',
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

function  hideInput(Priority,Code) {
    $('#priority'+Priority+Code).hide();
    $('#'+Code + Priority).html(Priority);
    $('#'+Code + Priority).attr('onclick',"EditInPlaceArrival('"+Code +"',"+"'"+Priority+"')");
}


function SendPriorityArrival(DepartureCode,Priority,Code) {

    var PriorityNew = $('#priority' + Code + Priority ).val();

    if(PriorityNew !='')
    {
        $.post(amadeusPath + 'user_ajax.php',
            {
                PriorityOld: Priority,
                PriorityNew: PriorityNew,
                CodeArrival : Code,
                CodeDeparture: DepartureCode,
                flag: 'ChangePriorityArrival'
            },
            function (data) {
                var res = data.split(':');
                if (data.indexOf('SuccessChangePriority') > -1)
                {
                    $.toast({
                        heading: 'تغییر الویت',
                        text: res[1],
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                    $('#'+Code + Priority).html(PriorityNew);
                    setTimeout(function () {
                         window.location.reload();
                    }, 300);
                } else
                {
                    $.toast({
                        heading: 'تغییر الویت',
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
    }else {
        $.toast({
            heading: 'تغییر الویت',
            text: 'مقدار الویت نمی تواند خالی باشد',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
    }


}

function EditInPlaceArrival(DepartureCode,Code,Priority)
{
    $('#'+Code + Priority).html('');
    $('#'+Code + Priority).append('<input class="form-control" name="priority'+Code + Priority+'" value="'+ Priority +'" id="priority' + Code + Priority +'" onchange="SendPriorityArrival('+"'"+ DepartureCode+"'"+','+"'"+ Priority+"'"+','+"'"+ Code+"'"+')" onblur="hideInputArrival('+"'"+ DepartureCode+"'"+','+"'"+ Priority+"'"+','+"'"+ Code+"'"+')">');
    $('#'+Code + Priority).attr('onclick','return false');

}


function  hideInputArrival(DepartureCode,Priority,Code) {
    $('#priority'+Priority+Code).hide();
    $('#'+Code + Priority).html(Priority);
    $('#'+Code + Priority).attr('onclick',"EditInPlaceArrival('"+DepartureCode +"','"+Code +"',"+"'"+Priority+"')");
}

function searchAirportForeign(obj) {
    var Code = $(obj).val();
    console.log(Code);
    $('#LoaderForeignDep').show();
    if (Code.length >= 3) {
        $(".SelectDeparture").show();
        $.post(amadeusPath + 'user_ajax.php',
            {
                Code: Code,
                Type: 'origin',
                flag: 'liveSearchDestination'
            },
            function (response) {
            console.log(response);
                setTimeout(function () {
                    $(".SelectDeparture").hide();
                    $('#LoaderForeignDep').hide();
                    if (response != "") {
                        $('#ListAirPort').html(response);
                    } else {
                        $('#ListAirPort').html('<li><span>موردی یافت نشد</span></li>');
                    }
                    $('#ListAirPort').show();

                }, 10);
            });
    } else {
        $('#ListAirPort').html('<li><span>حداقل سه کاراکتر وارد فرمائید</span></li>');
        $('#ListAirPort').show();
    }
}

function selectDeparture(AirportFa, DepartureCityFa, CountryFa, DepartureCode) {
    $('#cityCodeForeign').val(AirportFa + '-' + DepartureCityFa + '-' + CountryFa + '-' + DepartureCode);
    $('#IataCodeForeign').val(DepartureCode);
    $('#ListAirPort').hide();
}

function chooseAirPort() {

    var airPortCode = $('#IataCodeForeign').val();
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data: JSON.stringify({
                className:'routeFlight',
                method:'addOrderToRouteFlightForeign',
                iata_code: airPortCode,
            }),
        success: function (data) {

            $.toast({
                heading: 'تغییر الویت',
                text: data.message,
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
        },
        error : function (error) {
            $.toast({
                heading: 'تغییر الویت',
                text: error.responseJSON.message,
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

function deleteSortRouteFlightForeign(id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType:'json',
        data: {
            flag: 'deleteSortRouteFlightForeign',
            idFlight: id,
        },
        success: function (data) {
            if(data.result_status =='Success')
            {
                $.toast({
                    heading: 'تغییر الویت',
                    text: data.result_message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {
                   $('#del-'+id).remove();
                },1000);

            } else {
                $.toast({
                    heading: 'تغییر الویت',
                    text: data.result_message,
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