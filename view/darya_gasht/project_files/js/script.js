function changeText(text, none) {
    $('#text_search').text(text);
    if (none == 'null') {
        $('#titr_searchBox em').text('');
    } else {
        $('#titr_searchBox em').text('بلیط');
    }
}

$('.switch-label-off').click();
$('#number_of_passengers').on('change', function (e) {


    var itemInsu = $(this).val();

    itemInsu++;
    var HtmlCode = "";
    $(".nafaratbime").html('');

    var i = 1;
    while (i < itemInsu) {

        HtmlCode += "<div class='col-lg-2 col-md-3 col-6 col_search search_col nafarat-bime '>" +
            "<div class='form-group'>"+

            "<input placeholder='تاریخ تولد مسافر " + i + "' autocomplete='off' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar form-control' />" +
            "<i class='fal fa-calendar-alt'></i>"+

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
$(".plus-nafar-visa").click(function () {
    var nafar = $(this).siblings(".number-count").attr('data-number');
    if (nafar < 9) {
        var newnafar = ++nafar;
        $(this).siblings(".number-count").html(newnafar);
        $(this).siblings(".number-count").attr('data-number', newnafar);
        var whathidden = $(this).siblings(".number-count").attr('data-value');
        $("." + whathidden).val(newnafar);

    }
    var nafarbozorg = Number($(this).parents(".box-of-count-nafar").find(".bozorg-num .number-count").attr('data-number'));

    var tedad = nafarbozorg;
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text( nafarbozorg + ' مسافر ');

});
$(".minus-nafar-visa").click(function () {
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
    var tedad2 = nafarbozorg2 ;
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text( nafarbozorg2 + ' مسافر ');

});
$('.box-of-count-nafar-boxes').click(function () {

    $('.cbox-count-nafar').toggle();
    $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
});
$(document).ready(function () {
    $(".dropdown_custom > div").hide()
    $(".dropdown_custom > button").click((e) => {
        $(".dropdown_custom > div").toggle()
        e.stopPropagation()
    })
    $(".dropdown_custom > div button").click((e) => {
        console.log($(".dropdown_custom > button > span"))
        $(".dropdown_custom > button > span").text(e.target.innerText)
    })
    $("html,body").click(() => {
        $(".dropdown_custom > div").hide()
    })
    let owl_tour_local = $('.owl_tour_local');
    owl_tour_local.owlCarousel({
        rtl: true,
        loop: true,
        margin: 10,
        nav:false,
        navText: ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,


            }
        }
    });
    let owlhotel = $('.owl-hotel');
    owlhotel.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 10,
        autoplaySpeed:1000,
        nav:false,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                dots:true,
                nav:false,
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });
    $('.tour_owl').owlCarousel({
        loop: true,
        rtl: true,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        margin: 20,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        responsive: {0: {items: 1}, 600: {items: 1}, 1000: {items: 3}}
    });

    $('body').on('click', '.more_close_matn', function () {
        $(this).parents('.card_matn_').removeClass('show_more');
        $(this).parents('.card_matn_').find('.more_read_matn').show();
        $(this).remove();
    });
    $('.more_read_matn').click(function () {
        $(this).parents('.card_matn_').addClass('show_more');
        $(this).hide();
        $(this).parent('.content_card_matn').append('<button type="button" class="btn btn-primary more_close_matn py-2 px-3">بستن</button>');
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

        $('.more_matn').parent().find('.typo__context').each(function () {
            if ($( this ).height() < 210) {
                $( this ).nextAll('span.more_matn').first().hide();
            }
    });
    }, 200);

        $('.more_read_matn').parent().find('.typo__context').each(function () {
            if ($( this ).height() < 90) {
                $( this ).nextAll('button.more_read_matn').first().css({ display: "none" });
            }
        });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(".select2_in,.select2,.select2BusRouteSearch").select2();
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


});
if($(window).width() > 576){

    $('#flight-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/airline.jpg")')});
    $('#hotel-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/hotel.jpg")')});
    $('#tour-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/tour.jpg")')});
    $('#train-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/train.jpg")')});
    $('#bus-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/bus.jpg")')});
    $('#fun-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/tafrih.jpg")')});
    $('#car-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/car.jpg")')});
    $('#visa-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/visa.jpg")')});
    $('#gasht-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/gasht.jpg")')});
    $('#insurance-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/insurance.jpg")')});
    $('#package-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/package.jpg")')});

    $('a[data-target="#flight-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/airline.jpg")')});
    $('a[data-target="#hotel-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/hotel.jpg")')});
    $('a[data-target="#tour-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/tour.jpg")')});
    $('a[data-target="#train-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/train.jpg")')});
    $('a[data-target="#bus-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/bus.jpg")')});
    $('a[data-target="#fun-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/tafrih.jpg")')});
    $('a[data-target="#car-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/car.jpg")')});
    $('a[data-target="#visa-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/visa.jpg")')});
    $('a[data-target="#gasht-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/gasht.jpg")')});
    $('a[data-target="#insurance-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/insurance.jpg")')});


}
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



    $('body').click(function () {

        $('.main-navigation__sub-menu2').hide();
        $('.button-chevron-2').removeClass('rotate');
    });


    $('.main-navigation__button2').click(function (e) {
        e.stopPropagation()
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
});
$('.myhotels-rooms').on('click', '.close_room', function () {

    $(this).parent().parent().removeClass('active_p');

});
$('.hotel_local-rooms').on('click', '.close_room', function () {

    $(this).parent().parent().removeClass('active_p');


});