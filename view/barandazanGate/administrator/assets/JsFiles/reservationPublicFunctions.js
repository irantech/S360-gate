
$(document).ready(function () {


    //////// با انتخاب کشور مبدا، لیست شهرها نمایش داده شود////
    $( "#origin_country" ).change(function() {
        var  origin_country = $('#origin_country').val();
        FillComboCity(origin_country, 'origin_city');
    });

    //////// با انتخاب شهر مبدا، لیست منطقه ها نمایش داده شود////
    $( "#origin_city" ).change(function() {
        var  origin_city = $('#origin_city').val();
            FillComboRegion(origin_city, 'origin_region');
    });

    //////// با انتخاب کشور مقصد، لیست شهرها نمایش داده شود////
    $( "#destination_country" ).change(function() {
        var  destination_country = $('#destination_country').val();
        FillComboCity(destination_country, 'destination_city');
    });

    //////// با انتخاب شهر مقصد، لیست منطقه ها نمایش داده شود////
    $( "#destination_city" ).change(function() {
        var  destination_city = $('#destination_city').val();
        FillComboRegion(destination_city, 'destination_region');
    });


    //////// با انتخاب نام فرودگاه مبدا (محل حرکت)، لیست فرودگاه مقصد نمایش داده شود////
    /*$( "#origin_airport_name" ).change(function() {
        var  origin_airport = $('#origin_airport_name').val();
        FillComboDestinationAirport(origin_airport);
    });*/



});


///////نمایش لیست ایرلاین ها//
function listAirline(Item = null){
    var  type_of_vehicle = $('#type_of_vehicle').val();

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            type_of_vehicle: type_of_vehicle,
            flag: "listTransportCompanies"
        },
        function (data) {
            $( "#airline").html(data);
            $('#airline').val(Item);
        })
}
function listTypeOfPlane(Item = null){
    var  type_of_vehicle = $('#type_of_vehicle').val();
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationPublicFunctions',
            method: 'listTypeOfPlane',
            type_of_vehicle: type_of_vehicle,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response && response.status === 'success') {
                $('#type_of_plane').html(response.data);
                $('#type_of_plane').val(Item);
            }
        }
    });
}
function listSubcategories(Item1 = null, Item2 = null) {
    // Initialize airline / type_of_plane dropdown
    listAirline(Item1);
    listTypeOfPlane(Item2);
}

///////نمایش لیست شهرها//
function FillComboCity(Country, ComboCity){

    $.post(amadeusPath + 'hotel_ajax.php',
    {
        Country: Country,
        ComboCity: ComboCity,
        flag: "FillComboCountry"
    },
    function (data) {

        $( "#" + ComboCity).html(data);

    })

}//end function

///////نمایش لیست منطقه ها//
function FillComboRegion(City, ComboRegion){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            City: City,
            ComboRegion: ComboRegion,
            flag: "FillComboCity"
        },
        function (data) {

            $( "#" + ComboRegion).html(data);

        })

}//end function


///////نمایش لیست فرودگاه مقصد//
function FillComboDestinationAirport(origin_airport){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            origin_airport: origin_airport,
            flag: "FillComboRoute"
        },
        function (data) {
            $( "#destination_airport_name").html(data);

        })

}//end function


///////نمایش شماره پرواز براساس انتخاب ایرلاین(شرکت حمل و نقل)//
function FlyCodeTicket(){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            airline: $('#airline').val(),
            origin_country: $('#origin_country').val(),
            origin_city: $('#origin_city').val(),
            destination_country: $('#destination_country').val(),
            destination_city: $('#destination_city').val(),
            flag: "FlyCodeTicket"
        },
        function (data) {
        
            var arrStates = data.split(",");
            $('#fly_code option').remove();

            var List_option='<option value="">انتخاب کنید....</option>';
            for(i = 0; i < arrStates.length; i++)
            {
                var arrrecord = arrStates[i].split("/*/");
                // $('#fly_code').append( new Option(arrrecord[1],arrrecord[0]) );
                if (arrrecord[0]!=''){
                    List_option+='<option value="'+arrrecord[0]+'">'+arrrecord[1]+'</option>';
                }

            }

            $('#fly_code').html(List_option);

        })


}//end function

///////نمایش اطلاعات مربوط به شماره پرواز انتخاب شده//
/*function InformationFlyNumber(){

    $.post(amadeusPath + 'hotel_ajax.php',
        {
            fly_code: $('#fly_code').val(),
            flag: "InformationFlyNumber"
        },
        function (data) {

            if (data=='error'){

                $('#vehicle_grade').val('');
                $('#flight_time').val('');
                $('#free').val('');
                $('#ticket_type option').remove();

            }else {

                var arrStates = data.split(",");
                $('#vehicle_grade').val(arrStates[0]);
                $('#flight_time').val(arrStates[1]);
                $('#free').val(arrStates[3]);

                var List_option='';
                if(arrStates[2]!=""){
                    if(arrStates[2]=="1"){List_option+='<option value="'+arrStates[2]+'">Stuck</option>';}
                    else{List_option+='<option value="'+arrStates[2]+'">E-ticket</option>';}

                }

                $('#ticket_type').html(List_option);

            }




        })

}*/


function isDigit(entry)
{
    var key = window.event.keyCode;
    if((key>=48 && key<=57) || key==122) {
        return true;
    } else {
        $.confirm({
            title: 'خطا در ورود اطلاعات',
            content: "لطفا در اين فيلد فقط عدد وارد کنید. ",
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: 'بستن',
                    btnClass: 'btn-red'

                }
            }
        });
        return false;
    }
}

function separator(txt){
    var iDistance = 3;
    var strChar = ",";
    var strValue = txt.value;

    if(strValue.length>3){
        var str="";
        for(var i=0;i<strValue.length;i++){
            if(strValue.charAt(i)!=strChar){
                if ((strValue.charAt(i) >= 0) && (strValue.charAt(i) <= 9)){
                    str=str+strValue.charAt(i);
                }
            }
        }

        strValue=str;
        var iPos = strValue.length;
        iPos -= iDistance;
        while(iPos>0){
            strValue = strValue.substr(0,iPos)+strChar+strValue.substr(iPos);
            iPos -= iDistance;
        }
    }
    txt.value=strValue;
}