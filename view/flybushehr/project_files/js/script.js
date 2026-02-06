// var prevScrollpos = window.pageYOffset;
// window.onscroll = function () {
//     var currentScrollPos = window.pageYOffset;
//     if (prevScrollpos > currentScrollPos) {document.getElementById("navbar").style.top = "0";} else {document.getElementById("navbar").style.top = "-150px";}
//     prevScrollpos = currentScrollPos;
// }
$(document).ready(function (){


    var prevScrollpos = window.pageYOffset;
    $(window).scroll(function () {
        let scroll = $(this).scrollTop();
        if (scroll > 10) {
            $('#navbar').addClass('navbar_fix')
        } else {
            $('#navbar').removeClass('navbar_fix')
        }
    });

    $(".dropdown a").click(function (e){
        $(".dropdown button").text(e.target.innerHTML)
    })


    $('.owl-special_tour').owlCarousel({
        loop:false,
        rtl:true,
        margin:10,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:2
            }
        }
    })
    $('.owl-special_hotel').owlCarousel({
        loop:false,
        rtl:true,
        margin:10,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    })

    $(".text_top .fa-times").click(function (){
        $(".text_top").hide();
    })
    // hide #back-top first
    $("#scroll-top").hide();
    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scroll-top').fadeIn();
            } else {
                $('#scroll-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#scroll-top a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });


    // $('#flight-l-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/airline.jpg")')});
    // $('#flight-f-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/airline.jpg")')});
    // $('#hotel-l-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/hotel.jpg")')});
    // $('#hotel-f-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/hotel.jpg")')});
    // $('#tour-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/tour.jpg")')});
    // $('#train-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/train.jpg")')});
    // $('#bus-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/bus.jpg")')});
    // $('#fun-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/tafrih.jpg")')});
    // $('#car-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/car.jpg")')});
    // $('#visa-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/visa.jpg")')});
    // $('#gasht-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/gasht.jpg")')});
    // $('#insurance-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/insurance.jpg")')});
    // $('#package-tab').click(function () {$('.first_sec').css('background-image' , 'url("images/package.jpg")')});
    //
    // $('a[data-target="#flight-l-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/airline.jpg")')});
    // $('a[data-target="#flight-f-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/airline.jpg")')});
    // $('a[hotel-l-tabget="#hotel-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/hotel.jpg")')});
    // $('a[hotel-f-tabet="#hotel-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/hotel.jpg")')});
    // $('a[data-target="#tour-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/tour.jpg")')});
    // $('a[data-target="#train-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/train.jpg")')});
    // $('a[data-target="#bus-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/bus.jpg")')});
    // $('a[data-target="#fun-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/tafrih.jpg")')});
    // $('a[data-target="#car-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/car.jpg")')});
    // $('a[data-target="#visa-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/visa.jpg")')});
    // $('a[data-target="#gasht-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/gasht.jpg")')});
    // $('a[data-target="#insurance-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/insurance.jpg")')});
    // $('a[data-target="#package-tab"]').click(function () {$('.first_sec').css('background-image' , 'url("images/package.jpg")')});




    $('.hotel_passenger_picker').bind('click', function(e){
        e.stopPropagation();
    });
    $('.box-of-count-nafar').bind('click', function(e){
        e.stopPropagation();
    });
    $('#number_of_passengers').on('change', function (e) {
        let itemInsu = $(this).val();
        console.log(itemInsu)
        itemInsu++;
        let HtmlCode = "";
        $(".nafaratbime").html('');
        let i = 1;
        while (i < itemInsu) {
            HtmlCode += "<div class='col-lg-2 col-md-3 col-6 col_search search_col nafarat-bime '>" +
                "<div class='form-group'>"+
                "<input placeholder='تاریخ تولد مسافر " + i + "' autocomplete='off' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar form-control' />" +
                // " <i class='fal fa-calendar-alt'></i>"+
                "</div>"+
                "</div>";
            i++;
        }
        $(".nafaratbime ").append(HtmlCode);
    });

    $(".plus-nafar").click(function () {
        var nafar = $(this).siblings(".number-count").attr('data-number');
        if (nafar < 9) {
            var newnafar = ++nafar;
            $(this).siblings(".number-count").html(newnafar);
            $(this).siblings(".number-count").attr('data-number', newnafar);
            var whathidden = $(this).siblings(".number-count").attr('data-value');
            $("." + whathidden).val(newnafar);

        }
        var nafarbozorg = Number($(this).parents(".box-of-count-nafar").find(".bozorg-num .number-count").attr('data-number'));
        var nafarkoodak = Number($(this).parents(".box-of-count-nafar").find(".koodak-num .number-count").attr('data-number'));
        var nafarnozad = Number($(this).parents(".box-of-count-nafar").find(".nozad-num .number-count").attr('data-number'));
        var tedad = nafarbozorg + nafarkoodak + nafarnozad;
        if(nafarnozad == 0 && nafarkoodak == 0){
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg + nafarkoodak + nafarnozad + 'مسافر');
        }else{
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg + nafarkoodak + nafarnozad + 'مسافر');

        }
    });
    $(".minus-nafar").click(function () {
        var nafar = $(this).siblings(".number-count").attr('data-number');

        var nmin = $(this).siblings(".number-count").attr('data-min');
        if (nafar > nmin) {
            var newnafar = --nafar;
            $(this).siblings(".number-count").html(newnafar);
            $(this).siblings(".number-count").attr('data-number', newnafar);
            var whathidden = $(this).siblings(".number-count").attr('data-value');
            $("." + whathidden).val(newnafar);
        }
        var nafarbozorg2 = Number($(this).parents(".box-of-count-nafar").find(".bozorg-num .number-count").attr('data-number'));
        var nafarkoodak2 = Number($(this).parents(".box-of-count-nafar").find(".koodak-num .number-count").attr('data-number'));
        var nafarnozad2 = Number($(this).parents(".box-of-count-nafar").find(".nozad-num .number-count").attr('data-number'));
        var tedad2 = nafarbozorg2 + nafarkoodak2 + nafarnozad2;
        if(nafarnozad2 == 0 && nafarkoodak2 == 0){
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg2 + nafarkoodak2 + nafarnozad2 + ' مسافر ');
        }else{
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg2 + nafarkoodak2 + nafarnozad2 + ' مسافر ');
        }
    });

    $('.box-of-count-nafar-boxes').click(function () {

        $('.cbox-count-nafar').toggle();
        $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
    });












    $('#flight_khareji').hide();

    $('input:radio[name="DOM_TripMode8"]').change(
        function(){
            if (this.checked && this.value == '1') {


                $('#flight_khareji').css('display','flex');
                $('#flight_dakheli').hide();


            }
            else {
                $('#flight_khareji').hide();
                $('#flight_dakheli').css('display','flex');
            }
        });
    $('input:radio[name="DOM_TripMode4"]').change(
        function(){
            if (this.checked && this.value == '1') {


                $('#hotel_khareji').css('display','flex');
                $('#hotel_dakheli').hide();


            }
            else {
                $('#hotel_khareji').hide();
                $('#hotel_dakheli').css('display','flex');
            }
        });
    $('input:radio[name="DOM_TripMode5"]').change(
        function(){
            if (this.checked && this.value == '1') {


                $('#tour_khareji').css('display','flex');
                $('#tour_dakheli').hide();


            }
            else {
                $('#tour_khareji').hide();
                $('#tour_dakheli').css('display','flex');
            }
        });

    $('input:radio[name="select-rb2"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input').attr('disabled', '');
            }
            else {
                $('.return_input').removeAttr('disabled', '');
            }
        });
    $('input:radio[name="select-rb"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input2').attr('disabled', '');
            }
            else {
                $('.return_input2').removeAttr('disabled', '');
            }
        });

    function createRoomHotel(roomCount) {

        var HtmlCode = "";
        let i = $('.myroom-hotel-item').length +1;
        let numberText = "اول";
        let valuefirst;


        if (i == 1) {
            numberText = "اول";
            valuefirst = "2"
        } else if (i == 2) {
            numberText = "دوم";
            valuefirst = "1";

        } else if (i == 3) {
            numberText = "سوم";
            valuefirst = "1";

        } else if (i == 4) {
            numberText = "چهارم";
            valuefirst = "1";

        }


        if(i < 5){
            HtmlCode +=
                `<div class="myroom-hotel-item" data-roomNumber="${i}">
             <div class="myroom-hotel-item-title">
             <span class="close">
             <i class="fal fa-trash-alt"></i>
            </span>
            اتاق  ${numberText}
            </div><div class="myroom-hotel-item-info">
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>بزرگسال</h6>
           (بزرگتر از ۱۲ سال)
        <div><i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
        <input readonly class="countParent"  min="0" value="${valuefirst}" max="5" type="number" name="adult${i}" id="adult${i}">
        <i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
        </div>
        </div>
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>کودک</h6>
                                                    (کوچکتر از ۱۲ سال)
        <div>
        <i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus">
        
        </i><input readonly class="countChild" min="0" value="0" max="5" type="number" name="child${i}" id="child${i}">
        <i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
        </div>
        </div><div class="tarikh-tavalods"></div>
        </div>
        </div>`;
        }

        return HtmlCode;
    }

    $('.btn-close').click(function () {
        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');

    })

    $('.myhotels-rooms').on('click', '.close_room', function () {

        $(this).parent().removeClass('active_p');

    });
    $('.internal-my-hotels-rooms-js').on('click', '.close_room', function () {

        $(this).parent().parent().removeClass('active_p');


    });
})

