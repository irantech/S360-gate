
!function(){var i="SwVZUf",a=window,d=document;function g(){var g=d.createElement("script"),s="https://www.goftino.com/widget/"+i,l=localStorage.getItem("goftino_"+i);g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();

$(document).ready(function () {
    $('.OWL_slider_banner').owlCarousel({
        loop:true,
        rtl:true,
        navText: ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
        margin:0,
        nav:true,
        dots:false,
        autoplay:true,
        autoplayTimeout:3500,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    })
    $('.Flight_sec_Owl').owlCarousel({
        loop:true,
        rtl:true,
        margin:10,
        nav:false,
        dots:true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
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

    var prevScrollpos = window.pageYOffset;
    window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {$("#navbar").removeClass("navbarStatic")} else {$("#navbar").addClass("navbarStatic")}
        prevScrollpos = currentScrollPos;
    }

$('.switch-label-off').click();
$('#number_of_passengers').on('change', function (e) {
    var itemInsu = $(this).val();
    itemInsu++;
    var HtmlCode = "";
    $(".nafaratbime").html('');
    var i = 1;
    while (i < itemInsu) {
        HtmlCode += "<div class='col-lg-2 col-md-6 col-6 col_search search_col nafarat-bime '>" +
            "<div class='form-group'>"+

            "<input placeholder='تاریخ تولد مسافر " + i + "' autocomplete='off' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar form-control' />" +
            " <i class='fal fa-calendar-alt'></i>"+

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
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text( nafarbozorg + ' بزرگسال , ' + nafarkoodak + ' کودک , ' + nafarnozad + 'نوزاد');
    }else{
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text( nafarbozorg + ' بزرگسال , ' + nafarkoodak + ' کودک , ' + nafarnozad + 'نوزاد');

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
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text( nafarbozorg2 + ' بزرگسال , ' + nafarkoodak2 + ' کودک , ' + nafarnozad2 + 'نوزاد');
    }else{
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text( nafarbozorg2 + ' بزرگسال , ' + nafarkoodak2 + ' کودک , ' + nafarnozad2 + 'نوزاد');
    }
});
$('.box-of-count-nafar-boxes').click(function () {

    $('.cbox-count-nafar').toggle();
    $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
});
$(document).ready(function () {


    $('body').on('click', '.more_close_matn', function () {
        $(this).parents('.card_matn_').removeClass('show_more');
        $(this).parents('.card_matn_').find('.more_read_matn').show();
        $(this).remove();
    });
    $('.more_read_matn').click(function () {
        $(this).parents('.card_matn_').addClass('show_more');
        $(this).hide();
        $(this).parent('.content_card_matn').append('<a class="more_close_matn">بستن</a>');
    });
    $('.more_read').click(function () {
        $(this).parents('.card_').addClass('show_more');
        $(this).hide();
        $(this).parent('.content_card').append('<a class="more_close">بستن</a>');
    });
    $('body').on('click', '.more_close', function () {
        $(this).parents('.card_').removeClass('show_more');
        $(this).parents('.content_card').find('.more_read').show();
        $(this).remove();
    });
    $('.more_matn').click(function () {
        $(this).parent('.c-card-content').toggleClass('selected');
        $(this).toggleClass('select_btn');

        if ($(this).parent('.c-card-content').hasClass('selected')) {
            $(this).text('بستن')
        } else {
            $(this).text('بیشتر بخوانید')
        }
    });

    setTimeout(function () {
        $('.more_matn').each(function (){
            if ($(this).parent().find('.typo__context p ').height() <= 210) {
                $(this).hide();
                $(this).parent().find('.typo__context').addClass('hide_before');
            } else {
                $(this).show();
            }
        });

    }, 200);

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(".select2").select2();

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
        $('#scroll-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });
    $(document).ready(function () {
        $('#package_room ul').click(function () {
            $('.mypackege-rooms').toggleClass('active_p');
        });
        $('.hotel_passenger_picker ul').click(function () {
            $('.myhotels-rooms').toggleClass('active_p');
        });
        $('#package_room').click(function(event) {
            $('html').one('click',function() {
                $('.myhotels-rooms').removeClass('active_p');
            });

            event.stopPropagation();
        });


        var wwidth = $(window).width();
        if (wwidth < 575) {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height11 = sheight + 200;
            $(".js-height-full").height(height11);
        } else {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height1 = wheight - sheight;
            var height = height1 + sheight;
            $(".js-height-full").height(height);
        }
    });



    $('#countRoomPackage').on('change', function (e) {

        var roomCount = $("#countRoomPackage").val();
        createRoomHotelPackage(roomCount);
        $(".mypackage-rooms").find(".myroom-hotel-item").remove();
        var code = createRoomHotelPackage(roomCount);
        $(".mypackage-rooms").append(code);


        var wwidth = $(window).width();
        if (wwidth < 575) {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height11 = sheight + 200;
            $(".js-height-full").height(height11);
        } else {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height1 = wheight - sheight;
            var height = height1 + sheight;
            $(".js-height-full").height(height);
        }
    });




    $('input:radio[name="DOM_TripMode"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input').removeAttr('disabled', '');


            }
            else {
                $('.return_input').attr('disabled', '');
            }
        });
    $('input:radio[name="DOM_TripMode2"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input2').removeAttr('disabled', '');

            }
            else {
                $('.return_input2').attr('disabled', '');
            }
        });

    $('input:radio[name="DOM_TripMode6"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input_train').removeAttr('disabled', '');

            }
            else {
                $('.return_input_train').attr('disabled', '');
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
    $('input:radio[name="DOM_TripMode7"]').change(
        function(){
            if (this.checked && this.value == '1') {


                $('#transfer_div').css('display','flex');
                $('#gasht_div').hide();


            }
            else {
                $('#transfer_div').hide();
                $('#gasht_div').css('display','flex');
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });


    $('.main-navigation__button').click(function () {

        $('.main-navigation__sub-menu').toggle();
        $('.button-chevron').toggleClass('rotate');

    });

    $('body').click(function () {

        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });
    $('.btn-close').click(function () {
        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');

    })

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

});
$('.lang ').bind('click', function(e){
    //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
    e.stopPropagation();
});
$('body').click(function () {
    $('.lang_ul').removeClass('active_lang');
});
$('.lang span').click(function () {
    $('.lang_ul').toggleClass('active_lang');
});
$('.top__user_menu').bind('click', function(e){
    e.stopPropagation();
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
$('.box-of-count-nafar').bind('click', function(e){
    //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
    e.stopPropagation();

});
$('.main-navigation__button').click(function () {

    $('.main-navigation__sub-menu').toggle();
    $('.button-chevron').toggleClass('rotate');

});
$('body').click(function () {

    $('.main-navigation__sub-menu').hide();
    $('.button-chevron').removeClass('rotate');

    $('.cbox-count-nafar').hide();
    $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
});
$(document).ready(function () {
    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('.stop-propagation').bind('click', function (e) {
        e.stopPropagation();
    });
    $('body').click(function () {
        $('.main-navigation__sub-menu2').hide();
        $('.button-chevron-2').removeClass('rotate');
        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });
    $('.main-navigation__button2').click(function (e) {
        $('.main-navigation__sub-menu2').toggle();
        e.stopPropagation();
    });
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "/user/pages/images/flags";
        var $state = $(
            '<span class="city_start"><i class="fa fa-map-marker-alt"></i>' + state.text + '</span>'
        );
        return $state;
    };
    $(".select2_in").select2({
        templateResult: formatState
    });
});
$('.multiselectportal').click(function () {
    if ($("input[name='select-rb']:checked").val() == '1') {
        $('.returnCalendar').prop("disabled", "disabled");
    } else {
        $('.returnCalendar').removeAttr("disabled");
    }
});
$('.select_multiway').click(function () {
    if ($("input[name='select-rb2']:checked").val() == '1') {
        $('.checktest').prop("disabled", "disabled");
    } else {
        $('.checktest').removeAttr("disabled");
    }
});
$('body').on('click','.btn_add_room', function (e) {
    $('.myroom-hotel-item-title .close').show();


    let roomCount = parseInt($('.myroom-hotel-item').length) ;

    let numberAdult = parseInt($('.number_adult').text() );
    let number_room = parseInt($('.number_room').text() );
    $('.number_adult').text(numberAdult + 1)
    $('.number_room').text(number_room + 1)


    let code = createRoomHotel(roomCount);
    $(".hotel_select_room").append(code);
    if(roomCount ==3){
        $(this).hide();
    }



});
$('body').on('click', '.myroom-hotel-item .close', function () {

    let babyCountThis =$(this).parents('.myroom-hotel-item').find('.countChild').val();
    let number_baby = $('.number_baby').text();
    $('.number_baby').text(number_baby - babyCountThis );

    let AdultCountThis =$(this).parents('.myroom-hotel-item').find('.countParent').val();
    let number_adult = $('.number_adult').text();
    $('.number_adult').text(number_adult - AdultCountThis );

    $('.btn_add_room').show();

    let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
    let roomCount = $(".myroom-hotel-item").length;

    let number_room = parseInt($('.number_room').text());
    $('.number_room').text(number_room - 1)


    $(this).parents(".myroom-hotel-item").remove();
    let countRoom = parseInt($('#countRoom').val()) - 1;
    $("#countRoom option:selected").prop("selected", false);
    $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
    let numberRoom = 1;
    let numberText = "اول";
    $('.myroom-hotel-item').each(function () {
        $(this).data("roomnumber", numberRoom);
        if (numberRoom == 1) {
            numberText = "اول";
        } else if (numberRoom == 2) {
            numberText = "دوم";
        } else if (numberRoom == 3) {
            numberText = "سوم";
        } else if (numberRoom == 4) {
            numberText = "چهارم";
        }
        $(this).find('.myroom-hotel-item-title').html('<span class="close"><i class="fal fa-trash-alt"></i></span> اتاق ' + numberText);
        $(this).find(".myroom-hotel-item-info").find("input[name^='adult']").attr("name", "adult" + numberRoom);
        $(this).find(".myroom-hotel-item-info").find("input[name^='adult']").attr("id", "adult" + numberRoom);
        $(this).find(".myroom-hotel-item-info").find("input[name^='child']").attr("name", "child" + numberRoom);
        $(this).find(".myroom-hotel-item-info").find("input[name^='child']").attr("id", "child" + numberRoom);
        let numberChild = 1;
        let inputNameSelectChildAge = $(this).find(".tarikh-tavalods .tarikh-tavalod-item");
        inputNameSelectChildAge.each(function () {
            $(this).find("select[name^='childAge']").attr("name", "childAge" + numberRoom + numberChild);
            $(this).find("select[name^='childAge']").attr("id", "childAge" + numberRoom + numberChild);
            numberChild++;
        });
        numberRoom++;
    });
    if(roomCount == 2){
        $('.close').hide();
    }


});
$('body').on('click', 'i.addParent', function () {


    var inputNum = $(this).siblings(".countParent").val();

    if (inputNum < 7) {
        inputNum++;
        let numberAdult =parseInt( $('.number_adult').text());
        let resultNumber = numberAdult + 1
        $(this).siblings(".countParent").val(inputNum);
        $('.number_adult').html('');
        $('.number_adult').append(resultNumber);
    }
});
$('body').on('click', 'i.minusParent', function () {

    let data_roomnumber = $(this).parents('.myroom-hotel-item').attr('data-roomnumber');
    let ThiscountParent =  $(this).parents('.myroom-hotel-item').find('.countParent').val();


    var inputNum = $(this).siblings(".countParent").val();

    if (inputNum > 1) {
        inputNum--;
        let numberAdult =parseInt( $('.number_adult').text());
        let resultNumber = numberAdult - 1
        $(this).siblings(".countParent").val(inputNum);
        $('.number_adult').html('');
        $('.number_adult').append(resultNumber);
    }



});
$('body').on('click', 'i.addChild', function () {
    var inputNum = $(this).siblings(".countChild").val();
    inputNum++;
    if (inputNum < 5) {
        let numberBaby =parseInt( $('.number_baby').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild').val()) + 1;

        let resultNumber = numberBaby + 1

        $(this).siblings(".countChild").val(inputNum);
        $('.number_baby').html('');
        $('.number_baby').append(resultNumber);

        $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

        let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);
    }
});
$('body').on('click', 'i.minusChild', function () {

    var inputNum = $(this).siblings(".countChild").val();
    $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

    if (inputNum != 0) {
        let numberBaby =parseInt( $('.number_baby').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild').val()) + 1;

        let resultNumber = numberBaby - 1

        inputNum--;
        $(this).siblings(".countChild").val(inputNum);
        $('.number_baby').html('');
        $('.number_baby').append(resultNumber);

        let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);

    } else {
        $(this).siblings(".countChild").val('0');

    }
});
$('.mypackege-rooms').on('click','.btn_add_room_p', function (e) {
    $('.mypackege-rooms .close').show();


    let roomCount = parseInt($('.myroom-package-item').length) ;

    let numberAdult = parseInt($('.number_adult_p').text() );
    let number_room = parseInt($('.number_room_p').text() );
    $('.number_adult_p').text(numberAdult + 1)
    $('.number_room_p').text(number_room + 1)

    let code = createRoomHotelPackage(roomCount);
    $(".package_select_room").append(code);
    if(roomCount ==3){
        $(this).hide();
    }



});
$('.mypackege-rooms').on('click', '.myroom-package-item .close', function () {

    let babyCountThis =$(this).parents('.myroom-package-item').find('.countChild_p').val();
    let number_baby = $('.number_baby_p').text();
    $('.number_baby_p').text(number_baby - babyCountThis );

    let AdultCountThis =$(this).parents('.myroom-package-item').find('.countParent_p').val();
    let number_adult = $('.number_adult_p').text();
    $('.number_adult_p').text(number_adult - AdultCountThis );

    $('.btn_add_room_p').show();

    let roomNumber = $(this).parents(".myroom-package-item").data("roomnumber");
    let roomCount = $(".myroom-package-item").length;

    let number_room = parseInt($('.number_room_p').text());
    $('.number_room_p').text(number_room - 1)


    $(this).parents(".myroom-package-item").remove();
    let countRoom = parseInt($('#countRoom').val()) - 1;
    $("#countRoom option:selected").prop("selected", false);
    $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
    let numberRoom = 1;
    let numberText = "اول";
    $('.myroom-package-item').each(function () {
        $(this).data("roomnumber", numberRoom);
        if (numberRoom == 1) {
            numberText = "اول";
        } else if (numberRoom == 2) {
            numberText = "دوم";
        } else if (numberRoom == 3) {
            numberText = "سوم";
        } else if (numberRoom == 4) {
            numberText = "چهارم";
        }
        $(this).find('.myroom-package-item-title').html(' اتاق ' + numberText + '<span class="close"><i class="fal fa-trash-alt"></i></span>');
        $(this).find(".myroom-package-item-info").find("input[name^='adult_p']").attr("name", "adult_p" + numberRoom);
        $(this).find(".myroom-package-item-info").find("input[name^='adult_p']").attr("id", "adult_p" + numberRoom);
        $(this).find(".myroom-package-item-info").find("input[name^='child_p']").attr("name", "child_p" + numberRoom);
        $(this).find(".myroom-package-item-info").find("input[name^='child_p']").attr("id", "child_p" + numberRoom);
        let numberChild = 1;
        let inputNameSelectChildAge = $(this).find(".tarikh-tavalods .tarikh-tavalod-item");
        inputNameSelectChildAge.each(function () {
            $(this).find("select[name^='childAge']").attr("name", "childAge" + numberRoom + numberChild);
            $(this).find("select[name^='childAge']").attr("id", "childAge" + numberRoom + numberChild);
            numberChild++;
        });
        numberRoom++;
    });
    if(roomCount == 2){
        $('.myroom-package-item-title .close').hide();
    }


});
$('.mypackege-rooms').on('click', 'i.addParent_p', function () {


    var inputNum = $(this).siblings(".countParent_p").val();

    if (inputNum < 7) {
        inputNum++;
        let numberAdult =parseInt( $('.number_adult_p').text());
        let resultNumber = numberAdult + 1
        $(this).siblings(".countParent_p").val(inputNum);
        $('.number_adult_p').html('');
        $('.number_adult_p').append(resultNumber);
    }
});
$('.mypackege-rooms').on('click', 'i.minusParent_p', function () {

    let data_roomnumber = $(this).parents('.myroom-package-item').attr('data-roomnumber');
    let ThiscountParent =  $(this).parents('.myroom-package-item').find('.countParent_p').val();


    var inputNum = $(this).siblings(".countParent_p").val();

    if (inputNum > 1) {
        inputNum--;
        let numberAdult =parseInt( $('.number_adult_p').text());
        let resultNumber = numberAdult - 1
        $(this).siblings(".countParent_p").val(inputNum);
        $('.number_adult_p').html('');
        $('.number_adult_p').append(resultNumber);
    }



});
$('.mypackege-rooms').on('click', 'i.addChild_p', function () {

    var inputNum = $(this).siblings(".countChild_p").val();
    inputNum++;
    if (inputNum < 5) {
        let numberBaby =parseInt( $('.number_baby_p').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild_p').val()) + 1;

        let resultNumber = numberBaby + 1

        $(this).siblings(".countChild_p").val(inputNum);
        $('.number_baby_p').html('');
        $('.number_baby_p').append(resultNumber);

        $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

        let roomNumber = $(this).parents(".myroom-package-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-package-item-info").find(".tarikh-tavalods").html(htmlBox);
    }
});
$('.mypackege-rooms').on('click', 'i.minusChild_p', function () {

    var inputNum = $(this).siblings(".countChild_p").val();
    $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

    if (inputNum != 0) {
        let numberBaby =parseInt( $('.number_baby_p').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild_p').val()) + 1;

        let resultNumber = numberBaby - 1

        inputNum--;
        $(this).siblings(".countChild_p").val(inputNum);
        $('.number_baby_p').html('');
        $('.number_baby_p').append(resultNumber);

        let roomNumber = $(this).parents(".myroom-packege-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-package-item-info").find(".tarikh-tavalods").html(htmlBox);

    } else {
        $(this).siblings(".countChild_p").val('0');

    }
});
$('.mypackege-rooms').on('click', '.close_room', function () {

    $(this).parent().removeClass('active_p');


});
$('.myhotels-rooms').on('click', '.close_room', function () {

    $(this).parent().removeClass('active_p');

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
function createRoomHotelPackage(roomCount) {

    var HtmlCode = "";
    let i = $('.myroom-package-item').length +1;
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
            `<div class="myroom-package-item" data-roomNumber="${i}">
             <div class="myroom-package-item-title">اتاق  ${numberText}
             <span class="close">
             <i class="fal fa-trash-alt"></i>
            </span>
            </div><div class="myroom-package-item-info">
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>بزرگسال</h6>
           (بزرگتر از ۱۲ سال)
        <div><i class="addParent_p plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
        <input readonly class="countParent_p"  min="0" value="${valuefirst}" max="5" type="number" name="adultpackage${i}" id="adultpackage${i}">
        <i class="minusParent_p minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
        </div>
        </div>
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>کودک</h6>
                                                    (کوچکتر از ۱۲ سال)
        <div>
        <i class="addChild_p plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus">
        
        </i><input readonly class="countChild_p" min="0" value="0" max="5" type="number" name="childpackage${i}" id="childpackage${i}">
        <i class="minusChild_p minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
        </div>
        </div><div class="tarikh-tavalods"></div>
        </div>
        </div>`;
    }

    return HtmlCode;
}
function createBirthdayCalendar(inputNum, roomNumber) {
    var i = 1;
    var HtmlCode = "";
    let numberTextChild = "سلام";
    while (i <= inputNum) {
        if (i == 1) {
            numberTextChild = "اول";
        } else if (i == 2) {
            numberTextChild = "دوم";
        } else if (i == 3) {
            numberTextChild = "سوم";
        } else if (i == 4) {
            numberTextChild = "چهارم";
        }
        HtmlCode += '<div class="tarikh-tavalod-item">'
            + '<span>سن کودک <i>' + numberTextChild + '</i></span>'
            + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">'
            + '<option value="1">0 تا 1 سال</option>'
            + '<option value="2">1 تا 2 سال</option>'
            + '<option value="3">2 تا 3 سال</option>'
            + '<option value="4">3 تا 4 سال</option>'
            + '<option value="5">4 تا 5 سال</option>'
            + '<option value="6">5 تا 6 سال</option>'
            + '<option value="7">6 تا 7 سال</option>'
            + '<option value="8">7 تا 8 سال</option>'
            + '<option value="9">8 تا 9 سال</option>'
            + '<option value="10">9 تا 10 سال</option>'
            + '<option value="11">10 تا 11 سال</option>'
            + '<option value="12">11 تا 12 سال</option>'
            + '</select>'
            + '</div>';
        i++;
    }
    return HtmlCode;
};


})