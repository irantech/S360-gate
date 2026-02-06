$(document).ready(function () {
    $('.owl-banner').owlCarousel({
        loop:true,
        rtl:true,
        margin:0,
        nav:true,
        navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d=\"M166.5 424.5l-143.1-152c-4.375-4.625-6.562-10.56-6.562-16.5c0-5.938 2.188-11.88 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.9375c9.688 9.125 10.03 24.38 .9375 33.94l-128.4 135.5l128.4 135.5c9.094 9.562 8.75 24.75-.9375 33.94C190.9 434.5 175.7 434.1 166.5 424.5z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d=\"M89.45 87.5l143.1 152c4.375 4.625 6.562 10.56 6.562 16.5c0 5.937-2.188 11.87-6.562 16.5l-143.1 152C80.33 434.1 65.14 434.5 55.52 425.4c-9.688-9.125-10.03-24.38-.9375-33.94l128.4-135.5l-128.4-135.5C45.49 110.9 45.83 95.75 55.52 86.56C65.14 77.47 80.33 77.87 89.45 87.5z\"/></svg>"],
        dots:false,
        autoplay:true,
        autoplayTimeout:3500,
        autoplayHoverPause:true,
        items:1,
    })

    $('.owl-blog').owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        dots : true ,
        rtl: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
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

    $('.owl-about-us').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots : true ,
        rtl: true,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });


    $(".my-div").click(function (e) {
        e.stopPropagation()
        $(".parent-drop").toggleClass("dis-flex")
    })
    $("body").click(function () {
        $(".parent-drop").removeClass("dis-flex")
    })

    $('#owl-airLineLogo').owlCarousel({
        loop:true,
        margin:10,
        rtl:true,
        autoplay:true,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplayTimeout:4000,
        autoplayHoverPause:true,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:2,
                nav:false
            },
            600:{
                items:4
            },
            1000:{
                items:7
            }
        }
    });

    $('.owl-tour').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots : true ,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        rtl: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
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
    })

    $('#owl-tourS').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots : false ,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        rtl: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })


    $('.tourSpecialS').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots : true ,
        rtl: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })


    $("#scroll-top").hide();
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scroll-top').fadeIn();
            } else {
                $('#scroll-top').fadeOut();
            }
        });
        $('#scroll-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });
    // *
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
            $(this).parent('.content_card_matn').append('<button class="btn btn-primary more_close_matn">بستن</button>');
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


        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
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
            $('#gds_dept_date_local').trigger('focus');
            $('#gds_dept_date_Portal').trigger('focus');
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


        document.getElementById('loginedname').contentWindow.postMessage('','*');
        // const frame = document.getElementById('loginedname');
        // frame.contentWindow.postMessage('*', 'https://online.manshoortravel.com/gds/iframe&manshore_solh_new&topBarMainName');

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


});

$('.close_room').click(function () {
    $('.myhotels-rooms').removeClass('active_p')
});


$('.stop-propagation').bind('click', function (e) {
    e.stopPropagation();
});

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
