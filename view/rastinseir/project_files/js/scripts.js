$(document).ready(function () {



    $('#number_of_passengers').on('change', function (e) {

        var itemInsu = $(this).val();

        itemInsu++;
        var HtmlCode = "";
        $(".nafaratbime").html('');

        var i = 1;
        while (i < itemInsu) {

            HtmlCode += "<div class=' col-searchi_ nafarat-bime m-t-8 '>" +

                "<input placeholder=' تاریخ تولد مسافر  " + i + "' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='in-tarikh shamsiBirthdayCalendar'  />" +

                "</div>";
            i++;
        }

        $(".nafaratbime ").append(HtmlCode);
    });


    $(".select2").select2();




});