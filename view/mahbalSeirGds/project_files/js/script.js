


// search box

$(document).ready(function () {
    $(".select2 , .select-route-bus-js , .default-select2 , .gasht-type-js , .select-route-bus-js , .select2_in").select2();
    $('.switch-input-js').on('change', function() {
        if (this.checked && this.value === '1') {
            $('.international-flight-js').css('display', 'flex')
            $('.internal-flight-js').hide()
            $('.flight-multi-way-js').hide()
            $(this).attr('select_type','yes')
        } else {
            $('.internal-flight-js').css('display', 'flex')
            $('.international-flight-js').hide()
            $('.flight-multi-way-js').hide()
            $('.switch-input-js').removeAttr('select_type')
        }
    })
    $('.select-type-way-js').on('click', function () {
        let type = $(this).data('type');
        let class_element = $(`.${type}-one-way-js`);
        let arrival_date =  $(`.${type}-arrival-date-js`)
        if (class_element.is(':checked')) {
            arrival_date.attr("disabled", "disabled");
        } else {
            arrival_date.removeAttr("disabled");
        }
    });
    $('.click_flight_multi_way').on('click', function() {
        $('.flight-multi-way-js').css('display', 'flex')
        $('.internal-flight-js').hide()
        $('.international-flight-js').hide()
    })
    $('.click_flight_oneWay').on('click', function() {
        $('.international-flight-js').css('display', 'flex')
        $('.internal-flight-js').hide()
        $('.flight-multi-way-js').hide()
    })
    $('.click_flight_twoWay').on('click', function() {
        $('.international-flight-js').css('display', 'flex')
        $('.internal-flight-js').hide()
        $('.flight-multi-way-js').hide()
    })
    $(".switch-input-hotel-js").on("change", function () {
        $(".init-shamsi-datepicker").val("")
        $(".init-shamsi-return-datepicker").val("")
        $(".nights-hotel-js").val("")
        if (this.checked && this.value === "1") {
            $(".internal-hotel-js").css("display", "flex")
            $(".international-hotel-js").hide()
            $(".type-section-js").val("internal")
        } else {
            $(".internal-hotel-js").hide()
            $(".international-hotel-js").css("display", "flex")
            $(".type-section-js").val("international")
        }
    })

});

$('.Flight_sec_Owl').owlCarousel({
    loop:true,
    rtl:true,
    margin:10,
    nav:true,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d=\"M305 239c9.4 9.4 9.4 24.6 0 33.9L113 465c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l175-175L79 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L305 239z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d=\"M15 239c-9.4 9.4-9.4 24.6 0 33.9L207 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L65.9 256 241 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L15 239z\"/></svg>"],
    dots:false,
    autoplay:true,
    autoplayTimeout: 5000,
    autoplaySpeed:1000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        }
    }
})



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

    $('.owl-ads').owlCarousel({
        loop:true,
        margin:10,
        rtl:true,
        dots:true,
        nav:false,
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
                items:3
            }
        }
    })

    $('.Advertising_slider').owlCarousel({
        loop:false,
        margin:20,
        rtl:true,
        dots:false,
        nav:false,
        autoplay:true,
        autoplayTimeout:3000,
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

    var owlair = $('#owl-air');
    owlair.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 5,
        nav:false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed:1000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
                dots:true,
                nav:false,

            },
            600: {
                items: 5,

            },
            1000: {
                items: 7,

                margin: 5
            }
        }
    });
    var owl_stour = $('.owl_tour_local');
    owl_stour.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 1,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        nav:true,
        autoplaySpeed:1000,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,


            },
            1200: {
                items: 4,


            }
        }
    });
    var owl_stour = $('.owl_tour_local1');
    owl_stour.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 1,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        nav:true,
        autoplaySpeed:1000,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,
            },
            600: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });
    var owl_stour = $('.owl_quote');
    owl_stour.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 1,
        nav:false,
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,


            }
        }
    });
    var owl_stour = $('.owl_speciol_tour');
    owl_stour.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 1,
        nav:true,
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,

            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
                margin:0,

            }
        }
    });
    var owl_tabliq = $('.owl_tabliq');
    owl_tabliq.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 5,
        animateOut: 'fadeOut',
        nav:false,
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 2,


            }
        }
    });
    var owltour = $('.owl-tour');
    owltour.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 5,
        nav:true,
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
                margin:0,

            }
        }
    });

    var owlhotel = $('.owl-hotel');
    owlhotel.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 1,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        nav:true,
        autoplaySpeed:1000,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots:true,
                nav:false,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,


            },
            1200: {
                items: 4,


            }
        }
    });
    var owlair = $('#owl-air');
    owlair.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 0,
        nav:false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
                margin: 5
            },
            600: {
                items: 5,

            },
            1000: {
                items: 7,


            }
        }
    });
    var owl_sec = $('.owl_sec');
    owl_sec.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 20,
        nav:true,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2

            }
        }
    });
    var owl_sec = $('.owl-flight');
    owl_sec.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 5,
        nav:true,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                margin:0
            },
            600: {
                items: 3
            },
            1000: {
                items: 4

            }
        }
    });
    var owlFlightProposal = $('.owlFlightProposal');
    owlFlightProposal.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 5,
        nav:true,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplaySpeed:1000,
        autoplay: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav:false,
                dots:true,
            },
            600: {
                items: 2,
                nav:true,
                dots:false,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });

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



        if ($('.more_matn').parent().find('.typo__context').height() < 210) {
            $('.more_matn').hide();

            $('.c-card-content .typo__context').addClass('hide_before');
        } else {
            $('.more_matn').show();
        }

    }, 2000);



    var swiper = new Swiper('.blog-slider', {
        spaceBetween: 30,
        effect: 'fade',
        loop: true,
        centeredSlides: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        mousewheel: {
            invert: false,
        },
        // autoHeight: true,
        pagination: {
            el: '.blog-slider__pagination',
            clickable: true,
        }
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(".select2").select2();
    var heiw = $(window).height();

    $('.banner_main').css('min-height' , heiw);

    $('.temp_content').css('min-height' , heiw);

    var winh = $(window).height();

    if($(window).width() > 767){
        $('.banner').css('height' , winh);
    }




    var header = $('.header_area'),
        headerHeight = header.height(),
        treshold = 0,
        lastScroll = 0;

    $(document).on('scroll', function (evt) {
        var newScroll = $(document).scrollTop(),
            diff = newScroll-lastScroll - 10;

        // normalize treshold range
        treshold = (treshold+diff>headerHeight) ? headerHeight : treshold+diff;
        treshold = (treshold < 0) ? 0 : treshold + 10;

        header.css('top', (-treshold)+'px');

        lastScroll = newScroll;
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

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });

    $('.main-navigation__button').click(function () {

        $('.main-navigation__sub-menu').fadeToggle();
        $(this).find('.button-chevron').toggleClass('rotate');
        $('.main-navigation__sub-menu2').hide();
        $('.button-chevron-2').removeClass('rotate');
    });
    var iframe = $('#loginedname').contents();
    iframe.find('span').on('click', function() {
        $('.main-navigation__item').find('.main-navigation__sub-menu2').toggle();
        $('.button-chevron-2').toggleClass('rotate');

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


<!--select oneway toway-->


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


    // $(this).parents(".myroom-hotel-item").remove();
    // let countRoom = parseInt($('#countRoom').val()) - 1;
    // $("#countRoom option:selected").prop("selected", false);
    // $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
    // let numberRoom = 1;
    // let numberText = "اول";
    // $('.myroom-hotel-item').each(function () {
    //     $(this).data("roomnumber", numberRoom);
    //     if (numberRoom == 1) {
    //         numberText = "اول";
    //     } else if (numberRoom == 2) {
    //         numberText = "دوم";
    //     } else if (numberRoom == 3) {
    //         numberText = "سوم";
    //     } else if (numberRoom == 4) {
    //         numberText = "چهارم";
    //     }
      (function($) {
          jQuery(document).ready(function($) {
              let response_valueInternal;
              $(document).on('change', '#countRoom', function() {
                  let roomCount = $('#countRoom').val()
                  console.log(roomCount)
                  createRoomHotel(roomCount)
                  $('.myroom-hotel').find('.myroom-hotel-item').remove()
                  let code = createRoomHotel(roomCount)
                  $('.myroom-hotel').append(code)
              })
              $(document).on('show.bs.modal', 'addChildren', function(e) {
                  console.log('show.bs.modal fired')
                  let inputToken = $(this).find('.modal-body input.room-token')
                  let btnClicked = $(e.relatedTarget)
                  let RoomToken = btnClicked.data('room-code')
                  console.log(RoomToken)
                  inputToken.val(RoomToken)
              })
              let childModal = function(RoomToken, ChildMinAge, ChildMaxAge) {
                  let modalHtml = `
            <!-- Modal -->
        <div class='modal modal_addchild fade addChildren' id='addChildren-${RoomToken}' tabindex='-1' role='dialog' aria-labelledby='addChildrenTitle' aria-hidden='true'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                        <span class='modal-title'>${useXmltag('AddNew')} ${useXmltag('Chd')}</span>
                    </div>
                    <div class='modal-body'>
                        <input type='hidden' class='room-token' value=''>
                        <div class='childAgesContainer d-flex flex-wrap'>`
                  modalHtml += `</div>
                        <!--<span class="btn btn-xs btn-warning d-none addNewChild" data-min="${ChildMinAge}" data-max="${ChildMaxAge}"><i class="fa fa-plus"></i>افزودن</span>-->
                        
                    </div>
        			<div class='modal-footer'>
        				<button type='button' class='btn btn-secondary' data-dismiss='modal'>${useXmltag('Closing')}</button>
        				<button type='button' class='btn btn-primary' onclick="approveChildAges('${RoomToken}')" >${useXmltag('Approve')}</button>
        			</div>
        		</div>
        	</div>
        </div>
        `
                  return modalHtml
              }
              let eachRoomHtml = function(Room, value, IsInternal) {
                  if ( value.Result.SourceId == '29') {
                      return eachRoomHtmlFlightio(Room, value, IsInternal)
                  }else if((IsInternal == true || IsInternal != false) && value.Result.SourceId != '17' ) {
                      return eachRoomHtmlInternal(Room, value, IsInternal)
                  } else {
                      return eachRoomHtmlExternal(Room, value, IsInternal)
                  }
              }
              let eachRoomHtmlInternal = function(Room, value, IsInternal) {
                  let roomHtml = ''
                  roomHtml += `<div class='hotel-detail-room-list hotel-detail-room-list-local'>
  <div class='hotel-rooms-name-container'>
  <span class='hotel-rooms-name'><span class='name'>${Room.RoomName}</span> `
                  if (Room.Rates[0].ReservationState.Status == 'Online') {
                      roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-bolt site-main-text-color'></i>  ${useXmltag('Onlinereservation')}</span></span>`
                  }
                  if (Room.ExtraCapacity && Room.ExtraCapacity > 0 ) {
                      roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-user site-main-text-color'></i>  ${translateXmlByParams('ExtraCapacity', {'number': Room.ExtraCapacity})} </span></span>`
                  }else if(Room.ExtraCapacity ==  0){
                      roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-user site-main-text-color'></i>  ${useXmltag('NoExtraCapacity')} </span></span>`

                  }

                  if (Room.Rates[0].TotalPrices.Discount) {
//todo: discount should be added here
                  }

                  roomHtml += `</span></div><div class='hotel-rooms-item'>`


                  $.each(Room.Rates, function(index, Rate) {
                      roomHtml += `<div class='rate-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-local-content-col'>
                                <div class='hotel-rooms-content-local'>
                                    <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                    <input type='hidden' value='' id='tempExtraBed${Rate.RoomToken}'>

                                    <div class='divided-list divided-list-1'>
                                        <span class='small board'>${Rate.Board.Name}</span>
                                        <div class='divided-list-item'>
                                            <span  class='number_person'><i class='fa fa-male'></i>${Room.MaxCapacity} ${useXmltag('People')}</span>
                                        </div>
                                        <div class='divided-list-item detail_div_local '>
                                            <div class='DetailRoom DetailRoom_local showCancelRule' id='btnCancelRule-${Rate.RoomToken}' data-RoomCode='${Rate.RoomToken}' style='opacity: 1; cursor: pointer;'>
                                                
                                                <span>${useXmltag('Detailprice')}</span>
                                                <i class='fa fa-angle-down'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='divided-list'>
                                        <div class='divided-list-item text-center'>
                                            <span class='title_price'>
                                                ${useXmltag('Priceforanynight')} 
                                            </span>`
                      // if(Rate.Prices[0].Online != Rate.Prices[0].CalculatedOnline) {
                      //   roomHtml += `<span class='currency priceOff'>${number_format(Rate.Prices[0].Online)}</span>`
                      // }

                      roomHtml += `<span class='price_number'>  <i class='site-main-text-color'>${number_format(Rate.Prices[0].CalculatedOnline)}</i>${useXmltag('Rial')}</span>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class='hotel-rooms-price-col'>
                            
                                <div class='Hotel-roomsHead' data-title='${useXmltag('Countroom')}'>
                                    <div class='selsect-room-reserve selsect-room-reserve-local'>${useXmltag('Countroom')}</div>
                                </div>
                                
                             <div class='number_room'>
                                    <i class='plus_room' data-type_application='api' data-room_token='${Rate.RoomToken}'> + </i>
                                    <input  min='1' max='9' type='number' class='val_number_room' value='0' 
                                    name='RoomCount-${Rate.RoomToken}' 
                                    data-room-code='${Rate.RoomToken}' 
                                    data-total-price='${Rate.TotalPrices.CalculatedOnline}' id='RoomCount${Rate.RoomToken}'
                                    onchange="CalculateNewRoomPrice('${Rate.RoomToken}',true,true)"/>
                                    <i class=' minus_room ' data-type_application='api' data-room_token='${Rate.RoomToken}'> - </i>
                                </div>
                                <div class='nuumbrtRoom d-none'>
                                    <input type='hidden' value='' id='FinalRoomCount${Rate.RoomToken}'>
                                    <input type='hidden' value='' id='FinalPriceRoom${Rate.RoomToken}'>
                                    <input id='remainingCapacity${Rate.RoomToken}' name='remainingCapacity${Rate.RoomToken}' type='hidden' value='1'>
                                   
                                    </div>`

                      let Rules = value.Result.Rules
                      let minChildAge = 0
                      let maxChildAge = 0
                      $.each(Rules, function(i, Rule) {
                          if (Rule.Category == 'children' && Rule.Conditions !== null && typeof Rule.Conditions.max_infant_age !== 'undefined') {
                              minChildAge = Rule.Conditions.max_infant_age
                              maxChildAge = Rule.Conditions.max_child_age
                          }
                      })

                      let availabilityBeds
                      availabilityBeds = parseInt(Room.MaxCapacity) - parseInt(Room.ExtraCapacity)
                      // console.log(availabilityBeds);
                      if (Room.ExtraCapacity > 0 && availabilityBeds > 0 && typeof Rate.Prices[0].ExtraBed !== 'undefined' && Rate.Prices[0].ExtraBed > 0) {
                          roomHtml += `<div class='nuumbrtRoom extraBed'>
            <select name='ExtraBed-${Rate.RoomToken}' disabled data-room-code='${Rate.RoomToken}' id='ExtraBed${Rate.RoomToken}' data-price='${Rate.TotalPrices.ExtraBed}' class='ExtraBed select2-num' onchange="CalculateNewRoomPrice('${Rate.RoomToken}',true)">
               <optgroup style='font-family:iransans'>
               <option>${useXmltag('Extrabed')}</option></optgroup>`
                          for (c = 1; c <= availabilityBeds; c++) {
                              roomHtml += `<option value='${c}'>${c} ${useXmltag('Extrabed')}</option>`
                          }

                          roomHtml += `
        </select>
        </div>
            `
                      }
                      if (Room.ExtraChild > 0 && Rate.TotalPrices.Child > 0) {
                          roomHtml += `<button type='button' disabled='disabled' role='button' class='btn addChildren btnAddChildren-${Rate.RoomToken}' data-min-age='${minChildAge}' data-max-age='${maxChildAge}' data-room-code='${Rate.RoomToken}' data-toggle='modal' data-target='#addChildren-${Rate.RoomToken}' data-child-price='${Rate.TotalPrices.Child}'><span>${useXmltag('AddNew')} ${useXmltag('Chd')}</span><i class='fa fa-plus-square pr-1'></i></button>`
                          roomHtml += childModal(Rate.RoomToken, minChildAge, maxChildAge)
                          roomHtml += `<input type='hidden' data-room-code='${Rate.RoomToken}' name='roomChildArr[${Rate.RoomToken}]' id='roomChildArr-${Rate.RoomToken}' value=''>`
                          roomHtml += `<input type='hidden' data-room-code='${Rate.RoomToken}' name='roomChildCount[${Rate.RoomToken}]' id='roomChildCount-${Rate.RoomToken}' value=''>`
                          roomHtml += `<input type='hidden' id='roomChildPrice-${Rate.RoomToken}' value='${Rate.TotalPrices.Child}'>`

                      }
                      roomHtml += `</div>
                        </div>
                        <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel-${Rate.RoomToken}'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule-${Rate.RoomToken}'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>
                        `
                      roomHtml += `<input type='hidden' value='${Rate.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${Rate.TotalPrices.CalculatedOnline}' data-amount='${Rate.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${Rate.RoomToken}' class='priceRoom${Rate.RoomToken}'>
<input type='hidden' value='${value.NightsCount}' id='stayingTime${Rate.RoomToken}' class='stayingTime'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                       
                        <div class='detail_room_hotel'>
`

                      if (Rate.Prices.length > 0) {
                          $.each((Rate.Prices), function(index, Price) {
                              roomHtml += `
                        <div class='details'>
                            <div class='AvailableSeprate site-bg-main-color site-bg-color-border-right-b '>${Price.Date}</div>
                            <div class='seprate'>
                                <span><b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')} <i class='fa fa-male checkIcon'></i><span class='tooltip-price'>${useXmltag('Adult')}</span></span>`
                              if (Price.ExtraBed > 0 && Room.ExtraCapacity > 0 && availabilityBeds > 0) {
                                  roomHtml += `<span><b>${number_format(Price.ExtraBed)}</b>${useXmltag('Rial')} <i data-availabilityBeds='${availabilityBeds}' class='fa fa-bed checkIcon'></i><span class='tooltip-price'>${useXmltag('Extrabed')}</span></span>`
                              }
                              if (Price.Child) {
                                  roomHtml += `<span><b>${number_format(Price.Child)}</b>${useXmltag('Rial')} <i class='fas fa-baby-carriage'></i><span class='tooltip-price'>${useXmltag('Child')}</span></span>`
                              }
                              roomHtml += `</div>   
                    </div>`
                          })
                      }
                      roomHtml += `
                    </div></div>`
                  })
                  roomHtml += `</div></div>`
                  return roomHtml
              }
              let eachRoomHtmlExternal = function(Room, value, IsInternal) {
                  let roomHtml = `<div class='hotel-detail-room-list'>
                        <div class='hotel-rooms-name-container'>
                            <span class='hotel-rooms-name'>${Room.RoomName}</span>
                        </div><!--.hotel-rooms-name-container-->
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-external-content-col'>
                                <div class='hotel-rooms-content'>
                                    <div class='roomRatesContainer'>
`
                  console.log(Room.Rates);
                  $.each(Room.Rates, function(RateIndex, Rate) {

                      roomHtml += `
                                <div class='roomRateItem'>
                                    <div class='divided-list divided-list-external'>
                                        <div class='divided-list-item'>
                                            <span><i class='fa fa-bed'></i>${Rate.Board.Name}</span>
                                        </div><!--.divided-list-item-->
                                        
                                        <div class='divided-list-item'>`
                      if (Rate.ReservationState.Status == 'NonRefundable' || Rate.ReservationState.Status == 'IncludesFines') {
                          roomHtml += `<span class='extradition online-badge'>
                                                <span class='online-txt' style='white-space: nowrap;'>
                                                ${useXmltag(Rate.ReservationState.Status)}</span>
                                            </span>`
                      }

                      roomHtml += `<div data-token='${Rate.RoomToken}' data-request_number='${value.RequestNumber}' class='DetailRoom DetailRoom_external showCancelRule isHide' id='btnCancelRule-${Rate.RoomToken}' data-RoomCode='${Rate.RoomToken}' style='opacity: 1; cursor: pointer;'>
                                                <span>${useXmltag('detailAndCacellation')}</span>
                                                <i class='fa fa-angle-down'></i>
                                            </div><!--DetailRoom-->
                                        </div><!--divided-list-item-->
                                     
                                    </div><!--divided-list-->
                                    <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                        <div class="divided-list">
                                        <div class="divided-list-item text-center">
                                            <span class="title_price">
                                                 ${translateXmlByParams('PriceTotalHotel', {'TotalNights': value.Result.NightsCount})}
                                            </span> `
                      if(Rate.CalculatedDiscount.off_percent > 0 ){
                          roomHtml += ` <span class='currency priceOff'>  <i class="price_number"> ${number_format(Rate.TotalPrices.afterChange)}</i>${useXmltag('Rial')} </span>`
                      }

                      roomHtml += `  <span class='price_number site-main-text-color'>
                                                <i> ${number_format(Rate.TotalPrices.CalculatedOnline)}</i>${useXmltag('Rial')}
                                           </span>
                                        </div><!--divided-list-->
                                    </div><!--divided-list divided-list-external-->
                                    <div class='divided-list divided-list-reserve border-0'>
                                        <input type='hidden' value='' id='FinalRoomCount${Rate.RoomToken}'>
                                        <input type='hidden' value='' id='FinalPriceRoom${Rate.RoomToken}'>
                                        <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                        <input type='hidden' value='1' name='RoomCount-${Rate.RoomToken}' id='RoomCount${Rate.RoomToken}'>
                                        <span class='label_reserve_input site-bg-main-color' id='reserve_input${Rate.RoomToken}' onClick="ReserveExternalApiHotel('${Rate.RoomToken}')">
                                            <span>${useXmltag('Reserve')}</span>
                                        </span>
                                    </div><!--divided-list-->
                                    <div class='detail_room_hotel'>
                                        <h4 class='reservation-state-title'>${useXmltag(Rate.ReservationState.Status)}</h4>
                                        <div class='refund-fees'></div>`

                      roomHtml += `</div><!--detail_room_hotel-->
                        </div><!--roomRateItem-->
                        <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>`
                      if (Rate.Prices.length > 0) {
                          $.each((Rate.Prices), function(index, Price) {
                              roomHtml += `<div class='details'>
                                        <div class='AvailableSeprate'>${Price.Date}</div>
                                            <div class='seprate'>
                                                <b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')}<i class='fa fa-check checkIcon'></i>
                                            </div>
                                        </div>`
                          })
                      }
                      roomHtml += `<input type='hidden' value='${Rate.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${Rate.TotalPrices.CalculatedOnline}' data-amount='${Rate.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${Rate.RoomToken}' class='priceRoom${Rate.RoomToken}'>
<input type='hidden' value='${value.Result.NightsCount}' id='stayingTime${Rate.RoomToken}' class='stayingTime'>
                                                </div><!--DetailPriceView-->
                                            </div><!--RoomDescription-->
                                        </div><!--filter-content-->
                                    </div><!--filtertip-searchbox-->
                                </div><!--#boxCancelRule-->
                            </div><!--box-cancel-rule-->
                        </div><!--hotel-rooms-rule-row-->
                        `
                  })

                  roomHtml += `</div><!--roomRatesContainer-->
                        </div><!--hotel-rooms-content-->
                    </div><!--hotel-rooms-external-content-col-->
                </div><!--hotel-rooms-row-->
            </div><!--hotel-rooms-item-->
        </div><!--hotel-detail-room-list-->`
                  return roomHtml

              }
              let eachRoomHtmlFlightio = function(Room, value, IsInternal) {

                  let each_room_name = Room.RoomName.split('|')
                  let total_room_info = Room.Rates[0]


                  let roomHtml = `<div class='hotel-detail-room-list'>
                   
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-external-content-col'>
                                <div class='hotel-rooms-content'>
                                    <div class='roomRatesContainer'>
`

                  $.each(Room.Rates, function(RateIndex, Rate) {

                      roomHtml += `
                    
                                <div class='roomRateItem_second'>
                                
                                    <span class='hotel-rooms-name font-bold'>${each_room_name[RateIndex]}</span>
                                 
                                    <div class='d-flex justify-between px-2'><div class="d-flex">`

                      if (Rate.Board && Rate.Board.Name) {
                          roomHtml += `<div class='room_second_detail'>
                                            <span>${Rate.Board.Name}</span>
                                       </div>`
                      }
                      if (Rate.ReservationState.Status == 'NonRefundable' || Rate.ReservationState.Status == 'IncludesFines') {
                          roomHtml += `<div class='room_second_detail'>
                            <span>${useXmltag(Rate.ReservationState.Status)}</span>
                        </div>`
                      }

                      roomHtml += `</div><div>`


                      roomHtml += `

                                        </div><!--divided-list-item-->
                                     
                                    </div><!--divided-list-->
                                    
                                    
                                   `

                      roomHtml += `
                        </div><!--roomRateItem-->
                       
                        `
                  })
                  roomHtml += `<input type='hidden' value='' id='tempInput${total_room_info.RoomToken}'>
                      <div class='d-flex justify-between p-2'>
                                        <div class="divided-list">
                                        <div class="divided-list-item text-center">
                                            <span class="title_price">
                                                 ${translateXmlByParams('PriceTotalHotel', {'TotalNights': value.Result.NightsCount})}
                                            </span>`
                  if(total_room_info.CalculatedDiscount &&  total_room_info.CalculatedDiscount.off_percent > 0 ){
                      roomHtml += ` <span class='currency priceOff'>  <i class="price_number"> ${number_format(total_room_info.TotalPrices.afterChange)}</i>${useXmltag('Rial')} </span>`
                  }

                  roomHtml += `  <span class='price_number site-main-text-color'>
                                                <i> ${number_format(total_room_info.TotalPrices.CalculatedOnline)}</i>${useXmltag('Rial')}
                                           </span>
                                        </div><!--divided-list-->
                                    </div><!--divided-list divided-list-external-->`

                  roomHtml +=`<div class='divided-list divided-list-reserve border-0'>
                                        <input type='hidden' value='' id='FinalRoomCount${total_room_info.RoomToken}'>
                                        <input type='hidden' value='' id='FinalPriceRoom${total_room_info.RoomToken}'>
                                        <input type='hidden' value='' id='tempInput${total_room_info.RoomToken}'>
                                        <input type='hidden' value='1' name='RoomCount-${total_room_info.RoomToken}' id='RoomCount${total_room_info.RoomToken}'>
                                        <span class='label_reserve_input site-bg-main-color' id='reserve_input${total_room_info.RoomToken}' onClick="ReserveExternalApiHotel('${total_room_info.RoomToken}')">
                                            <span>${useXmltag('Reserve')}</span>
                                        </span>
                                    </div><!--divided-list--> 
                                    </div>
                  <div class='detail_room_hotel'>
                                      <h4 class='reservation-state-title'>${useXmltag(total_room_info.ReservationState.Status)}</h4>
                  <div class='refund-fees'></div></div>`
                  roomHtml +=` <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>`
                  if (total_room_info.Prices.length > 0) {
                      $.each((total_room_info.Prices), function(index, Price) {
                          roomHtml += `<div class='details'>
                                        <div class='AvailableSeprate'>${Price.Date}</div>
                                            <div class='seprate'>
                                                <b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')}<i class='fa fa-check checkIcon'></i>
                                            </div>
                                        </div>`
                      })
                  }
                  roomHtml += `<input type='hidden' value='${total_room_info.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${total_room_info.TotalPrices.CalculatedOnline}' data-amount='${total_room_info.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${total_room_info.RoomToken}' class='priceRoom${total_room_info.RoomToken}'>
<input type='hidden' value='${value.Result.NightsCount}' id='stayingTime${total_room_info.RoomToken}' class='stayingTime'>
                                                </div><!--DetailPriceView-->
                                            </div><!--RoomDescription-->
                                        </div><!--filter-content-->
                                    </div><!--filtertip-searchbox-->
                                </div><!--#boxCancelRule-->
                            </div><!--box-cancel-rule-->
                        </div><!--hotel-rooms-rule-row-->`
                  roomHtml += `</div><!--roomRatesContainer-->
                        </div><!--hotel-rooms-content-->
                    </div><!--hotel-rooms-external-content-col-->
                </div><!--hotel-rooms-row-->
            </div><!--hotel-rooms-item-->
        </div><!--hotel-detail-room-list-->`
                  return roomHtml

              }
              let generateRoomSelectForm = function(result, hotelValue, RequestNumber) {
                  console.log('hotelValue' , hotelValue)
                  let modal = ''
                  let eachRoom = ''
                  let RoomIds = []
                  $.each(result, function(roomIndex, Room) {
                      $.each(Room.Rates, function(rateIndex, Rate) {
                          RoomIds.push(Rate.RoomToken)
                      })
                      eachRoom += eachRoomHtml(Room, hotelValue, hotelValue.Result.IsInternal)
                  })
                  allRoomIds = RoomIds.join('/')

                  let firstRoom = result[0]

                  let html = `<form target='_self' action='' method='post' id='formHotelReserve' style='width: 100%;'>
        <input id='idHotel_reserve' name='idHotel_reserve' type='hidden' value='${hotelValue.Result.HotelIndex}'>
        <input id='nights_reserve' name='nights_reserve' type='hidden' value='${firstRoom.Rates[0].Prices.length}'>
        <input id='startDate_reserve' name='startDate_reserve' type='hidden' value='${hotelValue.History.StartDate}'>
        <input id='endDate_reserve' name='endDate_reserve' type='hidden' value='${hotelValue.History.EndDate}'>
        <input id='IdCity_Reserve' name='IdCity_Reserve' type='hidden' value='${hotelValue.Result.CityId}'>
        <input id='factorNumber' name='factorNumber' type='hidden' value=''>
        <input id='CurrencyCode' name='CurrencyCode' type='hidden' value=''>
        <input id='IsInternal' name='IsInternal' type='hidden' value='${hotelValue.Result.IsInternal}'>
        <input id='source_id' name='source_id' type='hidden' value='${hotelValue.Result.SourceId}'>
        <input type='hidden' value='${JSON.stringify(hotelValue.History.Rooms)}' name='searchRooms' id='searchRooms'>
        <input id='requestNumber' name='requestNumber' type='hidden' value='${RequestNumber}'>
        <input id='href' name='href' type='hidden' value='newPassengersDetail'>
`

                  html += eachRoom

                  let Rules = hotelValue.Result.Rules
                  let minChildAge = maxChildAge = 0
                  $.each(Rules, function(i, Rule) {
                      if (Rule.Category == 'children' && Rule.Conditions !== null && typeof Rule.Conditions.max_infant_age !== 'undefined') {
                          minChildAge = Rule.Conditions.max_infant_age
                          maxChildAge = Rule.Conditions.max_child_age
                      }
                  })
                  html += `<input type='hidden' name='CountRoom' id='CountRoom' value=''>
        <input type='hidden' name='TypeRoomHotel' id='TypeRoomHotel' value='${allRoomIds}'>
        <input type='hidden' name='allRoomIds' id='allRoomIds' value='${allRoomIds}'>
        <input type='hidden' name='TotalNumberRoom' id='TotalNumberRoom' value=''>
        <input type='hidden' id='TotalNumberRoom_Reserve' name='TotalNumberRoom_Reserve' value=''>
        <input type='hidden' id='TotalNumberExtraBed_Reserve' name='TotalNumberExtraBed_Reserve' value=''>
       `

                  html += `
</form>`
                  $('.RoomsContainer').append(html)
              }
              let ajaxGetPrices = function(RequestNumber, value) {
                  console.log('isInternal==>'+value.History.IsInternal)
                  console.log('SourceId==>'+value.Result.SourceId)
                  return $.ajax({
                      type: 'POST',
                      url: amadeusPath + 'hotel_ajax.php',
                      dataType: 'JSON',
                      data: {
                          requestNumber: RequestNumber,
                          stars: value.Result.Stars,
                          hotelIndex: value.Result.HotelIndex,
                          sourceId: value.Result.SourceId,
                          startDate: value.History.StartDate,
                          cityName: value.History.City,
                          countryName: value.History.Country,
                          typeApplication: (value.History.IsInternal == '0' || (value.History.IsInternal == '1' && (value.Result.SourceId == '17'))) ? 'externalApi' : 'api',
                          check_type_for_price_changes :  (value.History.IsInternal == '1') ? true : false ,
                          flag: 'getPrices',
                      },
                      beforeSend: function() {

                      },
                      success: function(response) {
                          console.log('fffffatttemmme '   , response)
                          $('#ThisPricesResult').val(JSON.stringify(response))

                          if (response.Result.length > 0) {

                              generateRoomSelectForm(response.Result, value, RequestNumber)
                          } else {
                              let msg = useXmltag('NoRoomsAvailable')
                              $.alert({
                                  title: useXmltag('NoAvailableReserve'),
                                  content: msg,
                                  rtl: true,
                                  type: 'red',
                              })
                          }
                      },
                      error: function(error) {
                          let msg = useXmltag('NoAvailableReserve')
                          $.alert({
                              title: useXmltag('Error'),
                              content: msg,
                              rtl: true,
                              type: 'red',
                          })
                          $('.RoomsContainer').append(`<div class='hotel-detail-room-list'>
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row justify-content-center'><p class='mt-3 alert alert-danger'>${msg}</p></div></div></div>`)
                          console.log(error)
                      },
                      complete: function() {
                          $('#resultRoomHotel').hide()
                      },
                  })
              }
              let ajaxGetCancellationPolicy = function(cancelRoleBtn) {
                  let RequestNumber = cancelRoleBtn.data('request_number')
                  let RoomToken = cancelRoleBtn.data('token')
                  let thisdetailBox = cancelRoleBtn.parents('.roomRateItem').find('.detail_room_hotel')
                  thisdetailBox.addClass('active_detail')
                  return $.ajax({
                      type: 'POST',
                      url: amadeusPath + 'hotel_ajax.php',
                      dataType: 'JSON',
                      data: {
                          flag: 'getCancellationPolicy',
                          RequestNumber: RequestNumber,
                          RoomToken: RoomToken,
                      },
                      beforeSend: function() {

                      },
                      success: function(response) {
                          result = response.Result

                          if (result.Fees.length > 0) {
                              boxHtml = `<ul>`
                              $.each(result.Fees, function(index, Fee) {
                                  boxHtml += `<li>${useXmltag('From')}<span style='direction: ltr; display:inline-block'>${Fee.FromDate}</span> ${useXmltag('To')} <span style='direction: ltr; display:inline-block'>${Fee.ToDate}</span> ${useXmltag('CancelationAmount')} <span style='direction: ltr; display:inline-black'>${Fee.Amount}</span></li>`
                              })
                              boxHtml += `<ul>`

                              thisdetailBox.find('.refund-fees').html(boxHtml)
                          }

                          if (result.Status.length > 0 && result.Status.Refundable) {
                              thisdetailBox.find('h4.reservation-state-title').text(useXmltag('Refundable'))
                          } else {
                              thisdetailBox.find('h4.reservation-state-title').text(useXmltag('NonRefundable'))
                          }
                          console.log('success')
                      },
                      error: function(error) {
                          console.log('error')
                      },
                  })
              }
              let generateMap = function(latitude, longitude, mapDiv = 'mapDiv') {
                  map = L.map(mapDiv).setView([latitude, longitude], 16)
                  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                      attribution: 'Map data &copy; <a href="https://www.iran-tech.com/">Iran Technology</a> contributors',
                      // maxZoom: 18,
                      // minZoom: 11,
                  }).addTo(map)
                  marker = L.marker([latitude, longitude]).addTo(map)
              }
              let generateHtmlForSearchHotel = function(data, parseJson) {

                  let value = data.Result,
                    searched_details = data.History,
                    IsInternal = data.Result.IsInternal
                  let addressTxt = value.ContactInformation.Address
                  let hotelName = value.Name
                  let Latitude = value.ContactInformation.Location.Latitude
                  let Longitude = value.ContactInformation.Location.longitude
                  let stars = value.Stars
                  let description = value.ExtraData ? value.ExtraData.Description : ''


                  if (parseJson.lang != 'fa') {
                      hotelName = value.Name
                      if (typeof value.NameEn !== 'undefined' && value.NameEn != '') {
                          hotelName = value.NameEn
                      }

                      if (typeof value.ContactInformation.AddressEn !== 'undefined' && value.ContactInformation.AddressEn !== '') {
                          addressTxt = value.ContactInformation.AddressEn
                      }
                  }
                  let starsHtml = ''
                  for (let star = 0; star < 5; star++) {
                      let starOn = `<i class='fa fa-star' aria-hidden='true'></i>`
                      let starOff = ``
                      if (star < value.Stars) {
                          starsHtml += starOn
                      } else if (star >= value.Stars) {
                          starsHtml += starOff
                      }
                  }

                  let starText = ''
                  if(value.Stars > 0 ) {
                      starText = translateXmlByParams('starText', {'count': value.Stars})
                  }



                  let galleryHtml = ''

                  $.each(value.Pictures, function(index, picture) {
                      galleryHtml += `<div class='hotel-thumb-item'><a data-fancybox='gallery' href='${picture.full}'><img src='${picture.medium}' alt='${hotelName}'></a></div>`
                  })

                  console.log(value)
                  console.log(searched_details)
                  if (value.IsInternal == true || value.IsInternal == 1 ) {
                      console.log(value.SourceId,value.IsInternal);
                      console.log('is internal');
                      $('.hotelDetailHotelName').text(hotelName)
                  } else {
                      console.log('is not internal');
                      $('.hotelDetailCityName').text(value.City)
                      $('#destination_country').val(searched_details.Country)
                      $('#destination_city').val(searched_details.City)
                      $('#autoComplateSearchIN').val(searched_details.Country + ' - ' + searched_details.City)
                  }


                  $('#idCity').val(value.CityId)
                  $('#nights').val(value.NightsCount)
                  $('#startDate,#startDateForeign').val(searched_details.StartDate)
                  $('#endDate,#endDateForeign').val(searched_details.EndDate)
                  $('#stayingTime').val(value.NightsCount)
                  // console.log('rooms count '  + searched_details.Rooms.length);
                  // $('#countRoom').attr('data-rooms',JSON.stringify(searched_details.Rooms)).val(searched_details.Rooms.length).select2().trigger('change');

                  $('span.stayingTime').text(`${value.NightsCount} ${useXmltag('Night')}`)
                  let class_hotel_name = (IsInternal == '1')?'internal-hotel-name': 'external-hotel-name';
                  let class_detail_hotel = (IsInternal == '1') ? 'internal-hotel-detail' : 'external-hotel-detail';
                  let hotel_transfer = ''
                  if(value.ExtraData && value.ExtraData.transfer != undefined) {
                      hotel_transfer = ` <div class='hotel-rate-outer'>
                    <div class="hotel-transfer">
                      <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M39.61 196.8L74.8 96.29C88.27 57.78 124.6 32 165.4 32H346.6C387.4 32 423.7 57.78 437.2 96.29L472.4 196.8C495.6 206.4 512 229.3 512 256V400H0V256C0 229.3 16.36 206.4 39.61 196.8V196.8zM109.1 192H402.9L376.8 117.4C372.3 104.6 360.2 96 346.6 96H165.4C151.8 96 139.7 104.6 135.2 117.4L109.1 192zM96 256C78.33 256 64 270.3 64 288C64 305.7 78.33 320 96 320C113.7 320 128 305.7 128 288C128 270.3 113.7 256 96 256zM416 320C433.7 320 448 305.7 448 288C448 270.3 433.7 256 416 256C398.3 256 384 270.3 384 288C384 305.7 398.3 320 416 320z"/><path class="fa-secondary" d="M346.6 96C360.2 96 372.3 104.6 376.8 117.4L402.9 192H109.1L135.2 117.4C139.7 104.6 151.8 96 165.4 96H346.6zM0 400H96V448C96 465.7 81.67 480 64 480H32C14.33 480 0 465.7 0 448V400zM512 448C512 465.7 497.7 480 480 480H448C430.3 480 416 465.7 416 448V400H512V448z"/></svg></i>
                      <div>
                        <h2>${useXmltag('HotelTransfer')}</h2>`
                      if(value.ExtraData.transfer.price == 0 ) {
                          hotel_transfer +=`<span>(${useXmltag('Free')})</span>`
                      }
                      hotel_transfer +=` </div>
                    </div>
                </div>`
                  }

                  let rules = ''
                  if(value.Rules.length> 0 ) {
                      for (let i = 0; i < value.Rules.length; i++) {
                          console.log(value.Rules[i])
                          rules += `<div>
                    <h6 class='rulesHotel__title text-right'>${value.Rules[i]['Name']}</h6>
                    <div class='rulesHotel__answer'>${value.Rules[i]['Description']}</div>
                  </div>`
                      }
                  }


                  let hotelDetailContainer = `
            <div class='${class_hotel_name} p-3'>
                <div class='hotel-name hotel-name_detail'>
                    <h1>${hotelName}</h1>
                       <div class='hotel-rate'>
                        <div class='rp-cel-hotel-star hotel-stars'> <span class="rp-cel-hotel-star_span"> ${starText} </span> ${starsHtml}</div>
                       </div>
                    <div class='external-hotel-address text-left hotel-address hotel-result-item-content-location'>
                       <span class='address-text'> : ${useXmltag('Address')}</span>
                       <span class='address-text'>${addressTxt}</span>
                    </div>
                </div>
               ${hotel_transfer}
            </div>`
                  if(galleryHtml != '') {
                      hotelDetailContainer += `<div class='hotel-khareji-thumb '>
                    <div class='hotel-thumb-carousel owl-carousel'>${galleryHtml}</div>
                </div>`
                  }

                  hotelDetailContainer +=`<div class=' RoomsContainer'>
            <div class='row'>
            
            </div>
            </div>
            
            <div class='hotel-panel ${parseJson.lang == 'fa' ? 'txtRight' : 'txtLeft'}'>
                <div class='hotel-desc'>`
                  if(description){
                      hotelDetailContainer += `
                  <div class="tabHotel">
                    <div class="tabHotel__buttons">
                      <button onclick="tabHotel('tabHotel__box1',event.target)" class="tabHotel__btns tabHotel__btns--active">${useXmltag('Descriptionhotel')}</button>
                      <button onclick="tabHotel('tabHotel__box2',event.target)" class="tabHotel__btns">${useXmltag('OsafarTermsandConditions')}</button>
                    </div>
                    <div>
                      <div id="tabHotel__box1" class="tabHotel__box"><p>${description}</p></div>
                      
                      <div id="tabHotel__box2" class="tabHotel__box" style="display:none">
                        <div class="rulesHotel">
                          ${rules}
                        </div>  
                      </div>
                    </div>
                  </div>
                  `
                  }
                  hotelDetailContainer += `<div class='hotel-fea'>
                        <div class='hotel-fea-title'>${useXmltag('PossibilitiesHotel')}
                        </div>
                        <div class='hotel-fea-inner'>

`

                  let roomIcons = hotelIcons = ''
                  if (typeof value.Facilities.HotelWithIcons != 'undefined') {
                      if (value.Facilities.HotelWithIcons.length > 0) {
                          $.each(value.Facilities.HotelWithIcons, function(index, value) {
                              hotelIcons += `<div title='${value[0]}' class='hotel-fea-item-2'><i class='site-bg-main-color ${value[1]}'></i>${value[0]}</div>`
                          })
                          hotelDetailContainer += hotelIcons
                      }
                  } else if (typeof value.Facilities.Hotel.En.Base != 'undefined') {
                      if (lang == 'fa') {
                          if (value.Facilities.Hotel.Fa.Base.length > 0) {
                              $.each(value.Facilities.Hotel.Fa.Base, function(index, value) {
                                  hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
                              })
                              hotelDetailContainer += hotelIcons
                          }
                      } else if (value.Facilities.Hotel.En.Base.length > 0) {
                          $.each(value.Facilities.Hotel.En.Base, function(index, value) {
                              hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
                          })
                          hotelDetailContainer += hotelIcons
                      }
                  } else {
                      console.log('no content for facilities')
                      hotelDetailContainer += ``
                  }
                  hotelDetailContainer += `
  
        </div>
        <div class='hotel-fea-inner'>`
                  if (lang == 'fa') {
                      if (value.Facilities.Room.Fa.Base.length > 0) {
                          roomIcons += `<div class='hotel-fea-title'>${useXmltag('PossibilitiesRoom')}</div>`
                      }
                  }else {
                      if (value.Facilities.Room.En.Base.length > 0) {
                          roomIcons += `<div class='hotel-fea-title'>${useXmltag('PossibilitiesRoom')}</div>`
                      }
                  }
                  roomIcons += `<div class='hotel-fea-inner'>`
                  if (typeof value.Facilities.RoomWithIcons != 'undefined') {
                      if (value.Facilities.RoomWithIcons.length > 0) {
                          $.each(value.Facilities.RoomWithIcons, function(index, value) {
                              roomIcons += `<div title='${value[0]}' class='hotel-fea-item-2'><i class='site-bg-main-color ${value[1]}'></i>${value[0]}</div>`
                          })


                          hotelDetailContainer += roomIcons
                      }
                  } else if (typeof value.Facilities.Room.En.Base != 'undefined') {
                      if (value.Facilities.Room.En.Base.length > 0) {
                          $.each(value.Facilities.Room.En.Base, function(index, value) {
                              hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
                          })
                          hotelDetailContainer += hotelIcons
                      }
                  }
                  hotelDetailContainer += `</div>
                    </div>
                    <div class='hotel-fea-inner'>
                        <div class='rp-hotel-box'>
                            <div id='mapDiv' class='gmap3'></div>
                        </div>
                    </div><!-- End Map Section   -->
                </div>
            </div>
</div>`
                  $('#hotelDetailContainer .content-detailHotel').addClass(class_detail_hotel).html('').append(hotelDetailContainer)

                  loadArticles('Hotel')
              }
              let generateCarousel = function(selector) {
                  $(selector).owlCarousel({
                      items: 2,
                      rtl: true,
                      loop: true,
                      center: true,
                      margin: 5,
                      nav: true,
                      dots: false,
                      autoplay: true,
                      autoplayTimeout: 4500,
                      autoplaySpeed: 1000,
                      autoplayHoverPause: true,
                      responsive: {
                          0: {
                              items: 1,
                          },
                          575: {
                              items: 2,

                          },
                      },
                  })
              }
              let priceRangeSlider = function(minPrice, maxPrice) {
                  $('#slider-range').slider({
                      range: true,
                      min: minPrice,
                      max: maxPrice,
                      step: 500000,
                      animate: false,
                      values: [minPrice, maxPrice],
                      slide: function(event, ui) {
                          let minRange = ui.values[0]
                          let maxRange = ui.values[1]
                          $('.filter-price-text span:nth-child(2) i').html(number_format(minRange))
                          $('.filter-price-text span:nth-child(1) i').html(number_format(maxRange))
                          let hotels = $('.hotel-result-item')
                          hotels.hide().filter(function() {
                              let price = parseInt($(this).data('price'), 10)
                              return price >= minRange && price <= maxRange
                          }).show()

                      },
                  })

                  $('.filter-price-text span:nth-child(2) i').html(number_format(minPrice))
                  $('.filter-price-text span:nth-child(1) i').html(number_format(maxPrice))
              }

              let hotelTypeMange = function(hotelTypeList) {
                  let allHotelTypes = [];
                  $("#filterHotelType :input.ShowByHotelFilters").each(function(index, item) {
                      if(!hotelTypeList.includes(parseInt(item.value))){
                          $(`.raste-item${item.value}`).remove()
                      }
                      allHotelTypes.push(item.value);
                  });

              }
              $('body').delegate('#searchDate', 'click', function() {
                  let page = $('#page').val()
                  let href = amadeusPathByLang + page
                  $('#formHotel').attr('action', href).submit()
              })
              $(document).on('click', '.reserve-hotel', function(e) {
                  // $('#formHotel').attr('action',`${amadeusPathByLang}newPassengersDetail`);
                  ReserveHotel()
              })
              $(document).on('click', '.DetailRoom_external.showCancelRule', function(e) {
                  e.preventDefault()
                  let _this = $(this)
                  _this.find('i').toggleClass('rotate')
                  if (_this.hasClass('isHide')) {
                      _this.parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail')
                      _this.toggleClass('isHide isShow')
                      ajaxGetCancellationPolicy(_this)
                  } else {
                      _this.parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail')
                      _this.toggleClass('isHide isShow')

                  }
              })
              $('.datePersian').datepicker({
                  numberOfMonths: 1,
                  minDate: new Date(),
                  dateFormat: 'yy-mm-dd',
                  gotoCurrent: true,
                  showButtonPanel: true,
              })
              if (gdsSwitch == 'searchHotel') {

                  let data = $('#dataSearchHotel').val()


                  let parsJson = JSON.parse(data)
                  // let parsJson = data;
                  // let value = [];
                  parsJson.className = 'searchHotel'
                  parsJson.method = 'searchHotel'

                  let parsJsonCapacity = {}
                  parsJsonCapacity.className = 'fullCapacity'
                  parsJsonCapacity.method = 'getFullCapacitySite'
                  parsJsonCapacity.id = 1
                  parsJsonCapacity.is_json = 1

                  let full_capacity_image = '';

                  $.ajax({
                      type: 'POST',
                      url: amadeusPath + 'ajax',
                      data: JSON.stringify(parsJsonCapacity),
                      success: function(data) {
                          if(data.pic_url != '') {
                              full_capacity_image = data.pic_url
                          }else {
                              full_capacity_image = amadeusPath + 'view/client/assets/images/fullCapacity.png'
                          }
                      }
                  })





                  $.ajax({
                      type: 'POST',
                      url: amadeusPath + 'ajax',
                      // url: amadeusPath + 'hotel_ajax.php',
                      dataType: 'JSON',
                      data: JSON.stringify(parsJson),
                      beforeSend: function() {
                          $('.loaderPublicForHotel').show()
                          $('.silence_span').html(useXmltag('Loading'));
                      },
                      success: function(data) {

                          let value = data.Hotels

                          let advertises = data.Advertises
                          let hotelType  = [];
                          $('#webServiceType').val(data.WebServiceType)
                          $('.silence_span').html(`<b id='countHotelHtml'>${data.Count}</b> ${useXmltag('NumberHotelsFound')}`)
                          $('#hotelResultItem').remove()
                          if (data.Count > 0) {
                              console.log('sssssssssssssss')
                              $.each(value, function(index, item) {
                                  if(!hotelType.includes(item.type_code)) {
                                      hotelType.push(item.type_code)
                                  }


                                  let hotelIndex = null
                                  if (item.type_application == 'reservation') {
                                      hotelIndex = item.hotel_id
                                  } else {
                                      hotelIndex = item.HotelIndex
                                  }
                                  let facilitiesContent = ''
                                  if (item.type_application == 'reservation') {
                                      let html_li = ''
                                      if (typeof item.facilities != 'undefined') {
                                          let html_li = '<div class="internal-hotel-facilities">'
                                          $.each(item.facilities, function(j, facility) {

                                              if (j < 10) {
                                                  html_li += `<span>${facility.title}</span>`
                                              }

                                          })
                                          html_li += `</div>`

                                          facilitiesContent = html_li
                                      }

                                  } else {
                                      let html_li = ''
                                      if (typeof item.facilities != 'undefined') {
                                          let html_li = '<div class="internal-hotel-facilities">'
                                          if (item.facilities.length > 1) {
                                              $.each(item.facilities, function(j, facility) {

                                                  if (j < 10) {
                                                      html_li += `<span>${facility.title}</span>`
                                                  }

                                              })

                                          }


                                          html_li += `</div>`
                                          facilitiesContent = html_li
                                      }
                                  }
                                  let starHtml = ''
                                  if(item.star_code > 0) {
                                      starHtml += `<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M11.892 3.005c-.429.041-.8.325-.95.735l-1.73 5.182-5.087-.001a1.122 1.122 0 0 0-.675 2.021l4.077 3.078-1.834 5.504c-.153.465.011.974.407 1.261l.093.061c.383.224.868.203 1.232-.062l4.577-3.442 4.59 3.408c.4.292.936.292 1.331.005l.087-.07a1.12 1.12 0 0 0 .32-1.189l-1.856-5.477 4.078-3.079a1.12 1.12 0 0 0 .39-1.251 1.125 1.125 0 0 0-1.067-.768h-5.087l-1.724-5.163A1.131 1.131 0 0 0 12 3l-.108.005Z"></path></svg>`;
                                  }
                                  let starText = ''
                                  if(item.star_code > 0 ) {
                                      starText = translateXmlByParams('starText', {'count': item.star_code})
                                  }

                                  let hotelStricke = 0
                                  let hotelPrice = 0
                                  if (item.type_application != 'reservation' && item.discount_price > 0) {
                                      hotelStricke = item.min_room_price_without_discount
                                      hotelPrice = item.min_room_price
                                  } else {
                                      if (item.min_room_price > 0) {
                                          hotelPrice = item.min_room_price
                                      } else {
                                          hotelPrice = 0
                                      }
                                  }
                                  var buttonName = ''
                                  var style = ''
                                  if (hotelPrice > 0) {
                                      buttonName = useXmltag('ShowReservation')
                                      style = ''
                                  } else {
                                      buttonName = useXmltag('Inquire')
                                      if (item.type_application == 'reservation') {
                                          buttonName = useXmltag('NonBookable')
                                      }
                                      style = 'style="background-color: #7d7d7d !important"'
                                  }
                                  let onClickAttr = ''
                                  let single_detail_link = ''
                                  let searched_rooms = $('#searchRooms').val()
                                  let nights = $('#stayingTime').val()
                                  let rooms_query_param = null
                                  if (searched_rooms)
                                      rooms_query_param = `&searchRooms=${searched_rooms}`
                                  else
                                      rooms_query_param = ''
                                  if (item.type_application == 'api') {
                                      // if(hotelPrice > 0 || hotelPrice = 0)
                                      // {
                                      onClickAttr = `hotelDetail('api','${hotelIndex}','${item.hotel_name_en}','${item.requestNumber}','${item.SourceId}',$(this))`
                                      single_detail_link = `${amadeusPathByLang}detailHotel/api/${item.HotelIndex}/${item.requestNumber}${rooms_query_param}`
                                      // }else{
                                      //     onClickAttr = `return false`;
                                      // }

                                      // $(itemAppend).find('.bookbtn').attr('onclick', onClickAttr);
                                  }
                                  if (item.type_application == 'reservation') {
                                      if (hotelPrice > 0) {
                                          single_detail_link = `${amadeusPathByLang}roomHotelLocal/reservation/${hotelIndex}/${item.hotel_name_en}${rooms_query_param}`
                                          onClickAttr = `hotelDetail('reservation', '${hotelIndex}', '${item.hotel_name_en}','','',$(this))`

                                      } else {
                                          single_detail_link = '#'
                                          onClickAttr = `return false`
                                      }

                                  }
                                  var specialHotelRabon = ''
                                  if (item.is_special == 'yes') {
                                      specialHotelRabon = `
                    <div class='ribbon-special-hotel'>${useXmltag( 'Specialhotel' )}</div>
                    `
                                  }
                                  var specialHotelRabonDiscount = `     
                    <div class='ribbon-hotel site-bg-color-dock-border-top'><span><i> %${item.discount}   </i></span></div>
                 `
                                  var apiHotelDiscountRabon = `
                     <div class='ribbon-hotel site-bg-color-dock-border-top'><span>${item.discount}%</span></div>`
                                  var rabonfinal = ''
                                  if (item.type_application == 'reservation') {
                                      if (item.discount > 0) {
                                          rabonfinal = rabonfinal + specialHotelRabonDiscount
                                      }
                                  } else {
                                      if (item.discount > 0) {
                                          rabonfinal = apiHotelDiscountRabon
                                      }
                                  }
                                  let mainItem =
                                    `<div class='hotelResultItem count count-${index}'> <div id='api${index}' class='hotel-result-item'
                     data-typeApplication='${item.type_application}' 
                     data-discount='${item.discount}'
                     data-priority='' 
                     data-price='${item.min_room_price}' 
                     data-star='${item.star_code}' 
                     data-HotelType='${item.type_code}' 
                     data-HotelName='${item.hotel_name}'
                     data-special='${item.is_special}'
                     >
                        <code style='display:none'>${JSON.stringify(item)}</code>
                    <div>
                        <div class='hotel-result-item-image site-bg-main-color-hover hotelImageResult hotelImageResult-${index}'>
                            <a target='_blank' href='${single_detail_link}'>
                                <img title='${item.hotel_name}' id='imageHotel-${index}' src='${item.pic}'>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class='hotel-result-item-content'>
                            <div class='hotel-result-item-text'>
                                    ${specialHotelRabon}
                                <div class='d-flex align-items-center gap-10'>
                                    <a target='_blank' href='${single_detail_link}' class='hotel-result-item-name hotelNameResult hotelNameResult-${index}'>${item.hotel_name}</a>
                                    <kbd class='kbd_style'>S${item.SourceId}</kbd>
                                </div>
                                <span class='rp-cel-hotel-star hotelShowStar-${index}'>
                                  <span class='rp-cel-hotel-star_span'> ${starText} </span> 
                                     ${starHtml}
                                </span>
`

                                  if (item.pointClub > 0) {
                                      mainItem += `<div class='text_div_more_hotel  '>
                        <i class='flat_cup'></i>
                            ${useXmltag('Yourpurchasepoints')} : <i class='site-main-text-color mr-1'> ${item.pointClub} ${useXmltag('Point')} </i>

                            </div>`

                                  }

                                  if (item.address) {
                                      mainItem += `
                                <span class='hotel-result-item-content-location hotelAddress hotelAddress-${index}'>
                                                        <span> ${useXmltag('Address')} : </span>

                                <span> ${item.address} </span>
                             <!-- <span class="text-white">${item.type}</span> -->
                                </span>`
                                  }
                                  // if (item.cancel_conditions) {
                                  //   mainItem += `<p class='hotel-result-item-description height95 hotelRules hotelRules-${index}'>${item.cancel_conditions}</p>`
                                  // }

                                  var mainPrice = ''

                                  if(nights > 1 ) {
                                      mainPrice = ` <h2 class='CurrencyCal' data-amount='${item.price_currency_total_night}'>${number_format(parseInt(item.price_currency_total_night))}</h2>`
                                  }else if(nights == 1 ) {
                                      mainPrice =  ` <h2 class='CurrencyCal' data-amount='${item.price_currency.AmountCurrency}'>${number_format(parseInt(item.price_currency.AmountCurrency))}</h2>`
                                  }


                                  if (facilitiesContent) {
                                      mainItem += `<ul class='hotelpreferences facilities facilities-${index}'>${facilitiesContent}</ul>`
                                  }
                                  mainItem += `</div>
                            <div class='hotel-result-item-bottom'>
                                <input type='hidden' id='starSortDep' name='starSortDep' value='${item.star_code}' class='hotelStar hotelStar-${index}'>
                                <input id='idHotel' name='idHotel' type='hidden' value='${hotelIndex}'  class='hotelId-${index}'>`
                                  if (item.price_currency.AmountCurrency > 0) {
                                      mainItem += `<div class='price-box-hotel'>`
                                      mainItem += `
                                <span class='nightText'> ${useXmltag('Price')} ${nights}   ${useXmltag('Night')}    </span> 
                                ${hotelStricke > 0 ? `
                                      <div class="d-flex style_Discount">
                                      <span class="currency priceOff CurrencyCal" 
                                      data-amount="${hotelStricke}">
                                      ${number_format(parseInt(hotelStricke))}
                                      </span> ${rabonfinal}
                                      </div>` : ''}
                                <div class="price_main">
                                 <span class='CurrencyText'>${item.price_currency.TypeCurrency}</span>
                                  ${mainPrice}
                                </div>
`
                                  }
                                  var mainButton = ''
                                  if (item.type_application == 'reservation') {
                                      mainButton = `<a class='bookbtn mt1 site-bg-main-color' ${style} onclick="${onClickAttr}"> ${buttonName}</a>`
                                  } else {
                                      mainButton = `<a target='_blank' href='${single_detail_link}' class='bookbtn mt1 site-bg-main-color' ${style}> ${buttonName}</a>`
                                  }
                                  var pricePerNight = ''
                                  if(nights > 1 ) {
                                      pricePerNight = ` <div class='d-flex align-items-center pricePerNight'>
                                      <h2 class='CurrencyCal' data-amount='${item.price_currency.AmountCurrency}'>${number_format(parseInt(item.price_currency.AmountCurrency))}</h2>
                                      <span>${translateXmlByParams('PriceForEachNight', {'Price': ''})}</span>
                                   </div>`
                                  }
                                  mainItem += ` ${mainButton}
                            ${pricePerNight}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
                                  $('#hotelResult').append(mainItem)
                              })
                          }
                          else {

                              $('.loaderPublicForHotel').hide()
                              $('.loader-for-local-hotel-end').hide()
                              $('.container_loading').hide()
                              $('.loader-for-external-hotel-end').hide()
                              // let htmlError = `<div class='userProfileInfo-messge'><div class='messge-login BoxErrorSearch'><div style='float: right;'>  <i class='fa fa-exclamation-triangle IconBoxErrorSearch'></i></div><div class='TextBoxErrorSearch'><p><br>${useXmltag('Nohotel')}<br><br></p></div></div></div>`
                              let htmlError =
                                `<div id='show_offline_request'>
                <div class='fullCapacity_div'>
                    <img src='${full_capacity_image}' alt='fullCapacity'>
                    <h2>${useXmltag('Nohotel')}</h2>
                </div>
            </div>`
                              $('#hotelResult').html(htmlError)
                          }
                          // (Start) put advertise
                          if (advertises.length > 0) {
                              let mainAdvertise = '<div class="advertises">'
                              console.log('Advertises')
                              $.each(advertises, function(index, item) {
                                  console.log('Advertise.item')
                                  mainAdvertise += '<div class="advertise-item ">'
                                  mainAdvertise += item.content
                                  mainAdvertise += '</div>'
                              })
                              mainAdvertise += '</div>'
                              $(mainAdvertise).insertBefore('#hotelResult')
                          }
                          console.log('11111111111111')

                          // (end) put advertise
                          priceRangeSlider(data.minPrice, data.maxPrice)
                          console.log('222222222222222')
                          hotelTypeMange(hotelType)
                          console.log('333333333333333333')
                      },
                      error: function(error) {
                          $('.loader-for-external-hotel-end').hide()
                          let htmlError = `<div class='userProfileInfo-messge'><div class='messge-login BoxErrorSearch'><div style='float: right;'>  <i class='fa fa-exclamation-triangle IconBoxErrorSearch'></i></div><div class='TextBoxErrorSearch'><p><br>${error.responseJSON.Message[0]}<br><br></p></div></div></div>`
                          $('#hotelResult').html(htmlError)
                      },
                      complete: function() {

                          $('.loaderPublicForHotel').hide()
                          $('.loader-for-local-hotel-end').hide()
                          $('.container_loading').hide()
                          let sort_type = $('#sort_hotel_type').val()
                          console.log('3' , sort_type)
                          sortHotelList(sort_type)
                          // sortHotelList('min_room_price')
                          let cityId = $('#destination_city').val()
                          loadArticles('Hotel', cityId)
                      },
                      // always: function () {
                      //     $('.loaderPublicForHotel').hide();
                      //     $('.loader-for-local-hotel-end').hide();
                      //     $('.container_loading').hide();
                      //     sortHotelList('min_room_price');
                      //     loadArticles('Hotel',cityId);
                      // }
                  })
              }
              if (gdsSwitch == 'detailHotel') {
                  let data_request = $('#dataDetailHotel').val()
                  let parseJson = JSON.parse(data_request)

                  console.log('parseJson' , parseJson)
                  $.ajax({
                      type: 'POST',
                      url: amadeusPath + 'hotel_ajax.php',
                      dataType:'JSON',
                      data: parseJson,
                      beforeSend: function() {
                          $('.loaderPublicForHotel').show()
                      },
                      success: function(response) {
                          let data = response;
                          console.log('jahsdjashd=>' , response);
                          console.log('type of=>' , typeof response);

                          if (data.Success && data.StatusCode == 200) {
                              let WebServiceType = data.WebServiceType
                              console.log(WebServiceType)
                              let RequestNumber = data.RequestNumber
                              let value = data.Result
                              console.log(value)
                              let lat = value.ContactInformation.Location.latitude ? value.ContactInformation.Location.latitude : 0
                              let lon = value.ContactInformation.Location.longitude ? value.ContactInformation.Location.longitude : 0
                              $('[name="requestNumber"]').val(RequestNumber)
                              $('[name="webServiceType"]').val(WebServiceType)
                              generateHtmlForSearchHotel(data, parseJson)
                              /*Activate Carousel*/
                              generateCarousel('.owl-carousel')
                              generateMap(lat, lon)
                              $('#ThisHotelResult').val(JSON.stringify(data))
                              $('.RoomsContainer').html(`<div id='resultRoomHotel'><div class='roomHotelLocal'><div class='loader-box-user-buy'><span></span><span>${useXmltag('Loading')}</span></div></div></div>`)
                              $('.loaderPublicForHotel').fadeOut(500)
                              setTimeout(function() {
                                  ajaxGetPrices(RequestNumber, data)
                              }, 3000)
                          } else {
                              console.log(data)
                              $.alert({
                                  title: 'خطا ',
                                  content: 'یک خطای غیر منتظره رخ داده . ',
                                  rtl: true,
                                  icon: 'fa shopping-cart',
                                  type: 'red',
                              })
                          }
                      },
                      error: function(error) {
                          console.log('erooooor=>',error)
                          $.alert({
                              title: 'خطا ',
                              content: 'یک خطای غیر منتظره رخ داده . ',
                              rtl: true,
                              icon: 'fa shopping-cart',
                              type: 'red',

                          })

                      },
                      complete: function() {
                          $('.loaderPublicForHotel').hide()

                      },
                      always: function() {
                          $('.loaderPublicForHotel').hide()
                      },
                  })
              }
              $(document).on('click', '.show-map-modal', function() {
                  $('.modal-body #mapContainer').remove()
                  $('.modal-body').append('<div id="mapContainer" class="gmap3"></div>')
                  let lat = $(this).data('latitude')
                  let lng = $(this).data('longitude')

                  map = L.map('mapContainer').setView([lng, lat], 15)
                  // set map tiles source
                  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                      attribution: ' <a href="https://www.iran-tech.com/">Iran Technology</a>',
                      // maxZoom: 18,
                      // minZoom: 11,
                  }).addTo(map)
                  // add marker to the map
                  marker = L.marker([lng, lat]).addTo(map)
                  // add popup to the marker
                  $('#map_modal').modal({
                      show: true,
                  })
              })
              $('#map_modal').on('shown.bs.modal', function() {
                  setTimeout(function() {
                      map.invalidateSize()
                  }, 1)
              })
          })
      })(jQuery)
    
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
    };

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


/*Scripts Packages*/

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

/* End select oneway toway */

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

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

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