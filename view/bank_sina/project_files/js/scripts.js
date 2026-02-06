$(document).ready(function () {
    $('.international-close-room-js').click(function (e){
        e.stopPropagation();
        $(".international-my-hotels-rooms-js").removeClass('active_p');
    });
        $('body').click(function() {
            $('.main-navigation__sub-menu2').removeClass('d-flex');
            $('.main-navigation__sub-menu2').addClass('d-none');
        });
        $('.menu-login').click(function(e) {
            e.stopPropagation();
            $('.main-navigation__sub-menu2').toggleClass('d-flex');
        });
    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('input:radio[name="DOM_TripMode"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('.return_input').removeAttr('disabled', '');


            } else {
                $('.return_input').attr('disabled', '');
            }
        });
    $('input:radio[name="DOM_TripMode2"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('.return_input2').removeAttr('disabled', '');

            } else {
                $('.return_input2').attr('disabled', '');
            }
        });

    $('input:radio[name="DOM_TripMode6"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('.return_input_train').removeAttr('disabled', '');

            } else {
                $('.return_input_train').attr('disabled', '');
            }
        });

    $('input:radio[name="DOM_TripMode4"]').change(
        function () {
            if (this.checked && this.value == '1') {


                $('#hotel_khareji').css('display', 'flex');
                $('#hotel_dakheli').hide();


            } else {
                $('#hotel_khareji').hide();
                $('#hotel_dakheli').css('display', 'flex');
            }
        });
    $('input:radio[name="DOM_TripMode8"]').change(
        function () {
            if (this.checked && this.value == '1') {


                $('#flight_khareji').css('display', 'flex');
                $('#flight_dakheli').hide();


            } else {
                $('#flight_khareji').hide();
                $('#flight_dakheli').css('display', 'flex');
            }
        });
    $('input:radio[name="DOM_TripMode7"]').change(
        function () {
            if (this.checked && this.value == '1') {


                $('#transfer_div').css('display', 'flex');
                $('#gasht_div').hide();


            } else {
                $('#transfer_div').hide();
                $('#gasht_div').css('display', 'flex');
            }
        });

    $('input:radio[name="DOM_TripMode5"]').change(
        function () {
            if (this.checked && this.value == '1') {


                $('#tour_khareji').css('display', 'flex');
                $('#tour_dakheli').hide();


            } else {
                $('#tour_khareji').hide();
                $('#tour_dakheli').css('display', 'flex');
            }
        });


    $(".select2").select2();
    $('.switch-label-on').click();

    $('#number_of_passengers').on('change', function (e) {


        var itemInsu = $(this).val();

        itemInsu++;
        var HtmlCode = "";
        $(".nafaratbime").html('');

        var i = 1;
        while (i < itemInsu) {

            HtmlCode += "<div class='col-lg-2 col-md-3 col-6 col_search search_col nafarat-bime '>" +
                "<div class='form-group'>" +

                "<input placeholder='تاریخ تولد مسافر " + i + "' autocomplete='off' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar form-control' />" +


                "</div>" +
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
        if (nafarnozad == 0 && nafarkoodak == 0) {
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg + ' بزرگسال , ' + nafarkoodak + ' کودک , ' + nafarnozad + 'نوزاد');
        } else {
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg + ' بزرگسال , ' + nafarkoodak + ' کودک , ' + nafarnozad + 'نوزاد');

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
        if (nafarnozad2 == 0 && nafarkoodak2 == 0) {
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg2 + ' بزرگسال , ' + nafarkoodak2 + ' کودک , ' + nafarnozad2 + 'نوزاد');
        } else {
            $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(nafarbozorg2 + ' بزرگسال , ' + nafarkoodak2 + ' کودک , ' + nafarnozad2 + 'نوزاد');
        }
    });

    $('.box-of-count-nafar-boxes').click(function () {

        $('.cbox-count-nafar').toggle();
        $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
    });
    $('.box-of-count-nafar').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('body').click(function () {
        $('.main-navigation__sub-menu2').fadeOut();


        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });


    $('input:radio[name="flight_switch"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('#flight_khareji').hide();
                $('#flight_dakheli').css('display', 'flex');

            } else {
                $('#flight_khareji').css('display', 'flex');
                $('#flight_dakheli').hide();
            }
        });
    $('input:radio[name="fd_rb"]').change(
        function () {
            if (this.checked && this.value == '2') {
                $('.return_input').removeAttr('disabled', '');


            } else {
                $('.return_input').attr('disabled', '');
            }
        });
    $('input:radio[name="fk_rb"]').change(
        function () {
            if (this.checked && this.value == '2') {
                $('.return_input2').removeAttr('disabled', '');

            } else {
                $('.return_input2').attr('disabled', '');
            }
        });
    $('input:radio[name="hotel_switch"]').change(
        function () {
            if (this.checked && this.value == '2') {


                $('#hotel_khareji').css('display', 'flex');
                $('#hotel_dakheli').hide();


            } else {
                $('#hotel_khareji').hide();
                $('#hotel_dakheli').css('display', 'flex');
            }
        });
    $('input:radio[name="gasht_switch"]').change(
        function () {
            if (this.checked && this.value == '2') {


                $('#transfer_div').css('display', 'flex');
                $('#gasht_div').hide();


            } else {
                $('#transfer_div').hide();
                $('#gasht_div').css('display', 'flex');
            }
        });

    $('input:radio[name="DOM_TripMode5"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '0');
                $('#tour_dakheli').css('display', 'flex');
                $('#tour_khareji').css('display', 'none');

            } else {
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '50%');
                $('#tour_dakheli').css('display', 'none');
                $('#tour_khareji').css('display', 'flex');
            }
        });

    $('.multiselectportal').click(function () {
        if ($("input[name='select-rb']:checked").val() == '1') {
            $('.checktest1').prop("disabled", "disabled");
        } else {
            $('.checktest1').removeAttr("disabled");
        }
    });
    $('.select_multiway').click(function () {
        if ($("input[name='select-rb2']:checked").val() == '1') {
            $('.checktest').prop("disabled", "disabled");
        } else {
            $('.checktest').removeAttr("disabled");
        }
    });
    $('.select_multiway').click(function () {
        if ($("input[name='select-rb3']:checked").val() == '1') {
            $('#gasht_').show();
            $('#transfer_').hide();

        } else {
            $('#gasht_').hide();
            $('#transfer_').show();
        }


    });
    $('.tip_tabs').click(function () {
        if ($("input[name='tip_tabs']:checked").val() == '1') {
            $('.tabs_ul_hotel li').removeClass('activing_tab');
            $(this).parent('li').addClass('activing_tab');
            $('#sub_tabs_city').show();
            $('#sub_tabs_hotel').hide();

        } else {
            $('.tabs_ul_hotel li').removeClass('activing_tab');
            $(this).parent('li').addClass('activing_tab');
            $('#sub_tabs_city').hide();
            $('#sub_tabs_hotel').show();
        }
    });

    let owl_flight = $('.owl_flight');
    owl_flight.owlCarousel({
        rtl: true,
        dots: false,
        loop: false,
        margin: 0,
        nav: true,
        navText: ['<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-left"></i>'],
        smartSpeed: 500,
        autoplay: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots: true,
                nav: false

            },
            600: {
                items: 2,

            },
            1000: {
                items: 4,

            }
        }
    });

    let owl_hotel = $('.owl_hotel');
    owl_hotel.owlCarousel({
        rtl: true,
        dots: false,
        loop: true,
        margin: 0,
        nav: true,
        navText: ['<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-left"></i>'],
        smartSpeed: 500,
        autoplay: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots: true,
                nav: false
            },
            600: {
                items: 2,

            },
            1000: {
                items: 4,

            }
        }
    });

    let owl_tour = $('.owl_tour');
    owl_tour.owlCarousel({
        rtl: true,
        dots: false,
        loop: true,
        margin: 0,
        nav: true,
        navText: ['<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-left"></i>'],
        smartSpeed: 500,
        autoplay: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots: true,
                nav: false
            },
            600: {
                items: 2,

            },
            1000: {
                items: 4,

            }
        }
    });

    $(window).scroll(function () {

        var sctop = $(this).scrollTop();
        if (sctop > 44) {

            $('.main_header_area').addClass('sticky');

        } else {

            $('.main_header_area').removeClass('sticky');

        }


    });


})
