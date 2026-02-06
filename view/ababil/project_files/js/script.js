$(document).ready(function () {
    $("#newsletter_input").on( "keyup", function() {
        if($("#newsletter_input").val().length > 0){
            $(".footer_main_tow > form button").addClass("active")
        }else {
            $(".footer_main_tow > form button").removeClass("active")
        }
    });
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
    /*! searchBox*/
    $(".select2 , .select2_in").select2();
    $(document).ready(function () {
        $('.switch-label-off').click();
        $('#number_of_passengers').on('change', function (e) {
            var itemInsu = $(this).val();
            itemInsu++;
            var HtmlCode = "";
            $(".nafaratbime").html('');
            var i = 1;
            while (i < itemInsu) {
                HtmlCode += "<div class='col-lg-2 col-md-3 col-6 col_search search_col nafarat-bime '>" + "<div class='form-group'>" + "<input placeholder='تاریخ تولد مسافر " + i + "' autocomplete='off' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar form-control' />" + "</div>" + "</div>";
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
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            } else {
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
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
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            } else {
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            }
        });
        $('.box-of-count-nafar-boxes').click(function () {
            $('.cbox-count-nafar').toggle();
            $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
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
                if ($(this).height() < 210) {
                    $(this).nextAll('span.more_matn').first().hide();
                }
            });
        }, 200);
        $('.more_read_matn').parent().find('.typo__context').each(function () {
            if ($(this).height() < 90) {
                $(this).nextAll('button.more_read_matn').first().css({display: "none"});
            }
        });



        var owlFlightProposal = $('.owlFlightProposal');
        owlFlightProposal.owlCarousel({
            rtl: true,
            dots: false,
            loop: true,
            margin: 5,
            nav: true,
            navText: ["<i class='fas fa-chevron-right'></i>", "<i class='fas fa-chevron-left'></i>"],
            autoplaySpeed: 1000,
            autoplay: false,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {0: {items: 1, nav: false, dots: true,}, 600: {items: 2}, 1000: {items: 4}}
        });
        // $(function () {
        //     $('[data-toggle="tooltip"]').tooltip()
        // });



        $('#hotel_local_room ul').click(function () {
            $('.hotel_local-rooms').toggleClass('active_p');
        });
        $('#package_room ul').click(function () {
            $('.mypackege-rooms').toggleClass('active_p');
        });
        $('#hotel_local_room').click(function (event) {
            $('html').one('click', function () {
                $('.myhotels-rooms').removeClass('active_p');
            });
            event.stopPropagation();
        });
        $('#package_room').click(function (event) {
            $('html').one('click', function () {
                $('.myhotels-rooms').removeClass('active_p');
            });
            event.stopPropagation();
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
        $('input:radio[name="DOM_TripMode"]').change(function () {
            if (this.checked && this.value == '1') {
                $('.return_input').removeAttr('disabled', '');
            } else {
                $('.return_input').attr('disabled', '');
            }
        });
        $('input:radio[name="DOM_TripMode2"]').change(function () {
            if (this.checked && this.value == '1') {
                $('.return_input2').removeAttr('disabled', '');
            } else {
                $('.return_input2').attr('disabled', '');
            }
        });
        $('input:radio[name="DOM_TripMode6"]').change(function () {
            if (this.checked && this.value == '1') {
                $('.return_input_train').removeAttr('disabled', '');
            } else {
                $('.return_input_train').attr('disabled', '');
            }
        });
        $('input:radio[name="DOM_TripMode4"]').change(function () {
            if (this.checked && this.value == '1') {
                $('#hotel_khareji').css('display', 'flex');
                $('#hotel_dakheli').hide();
            } else {
                $('#hotel_khareji').hide();
                $('#hotel_dakheli').css('display', 'flex');
            }
        });
        $('input:radio[name="DOM_TripMode8"]').change(function () {
            if (this.checked && this.value == '1') {
                $('#flight_khareji').css('display', 'flex');
                $('#flight_multiTrack').hide();
            } else {
                $('#flight_khareji').hide();
                $('#flight_multiTrack').hide();
            }
        });
        $(".click_flight_multiTrack").click(function () {
            $('#flight_multiTrack').css('display', 'flex');
            $('#flight_khareji').hide();
        });
        $(".click_flight_oneWay").click(function () {
            $('#flight_khareji').css('display', 'flex');
            $('#flight_multiTrack').hide();
        });
        $(".click_flight_twoWay").click(function () {
            $('#flight_khareji').css('display', 'flex');
            $('#flight_multiTrack').hide();
        });
        $('input:radio[name="DOM_TripMode7"]').change(function () {
            if (this.checked && this.value == '1') {
                $('#transfer_div').css('display', 'flex');
                $('#gasht_div').hide();
            } else {
                $('#transfer_div').hide();
                $('#gasht_div').css('display', 'flex');
            }
        });
        $('input:radio[name="DOM_TripMode5"]').change(function () {
            if (this.checked && this.value == '1') {
                $('#tour_khareji').css('display', 'flex');
                $('#tour_dakheli').hide();
            } else {
                $('#tour_khareji').hide();
                $('#tour_dakheli').css('display', 'flex');
            }
        });
        // $(function () {
        //     $('[data-toggle="tooltip"]').tooltip()
        // });

        $('.top__user_menu').bind('click', function (e) {/*as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open*/
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
        });


        $('.myhotels-rooms').on('click', '.close_room', function () {
            $(this).parent().removeClass('active_p');
        });
        $('.hotel_local-rooms').on('click', '.close_room', function () {
            $(this).parent().removeClass('active_p');
        });
        $('.myhotels-rooms').on('click', '.close_room', function () {
            $(this).parent().removeClass('active_p');
        });
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
                HtmlCode += '<div class="tarikh-tavalod-item">' + '<span>سن کودک <i>' + numberTextChild + '</i></span>' + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">' + '<option value="1">0 تا 1 سال</option>' + '<option value="2">1 تا 2 سال</option>' + '<option value="3">2 تا 3 سال</option>' + '<option value="4">3 تا 4 سال</option>' + '<option value="5">4 تا 5 سال</option>' + '<option value="6">5 تا 6 سال</option>' + '<option value="7">6 تا 7 سال</option>' + '<option value="8">7 تا 8 سال</option>' + '<option value="9">8 تا 9 سال</option>' + '<option value="10">9 تا 10 سال</option>' + '<option value="11">10 تا 11 سال</option>' + '<option value="12">11 تا 12 سال</option>' + '</select>' + '</div>';
                i++;
            }
            return HtmlCode;
        };$('body').click(function () {
            $('.lang_ul').removeClass('active_lang');
        });
        $('.top__user_menu').bind('click', function (e) {
            e.stopPropagation();
        });
        $('.box-of-count-nafar').bind('click', function (e) {
            e.stopPropagation();
        });
        $('.top__user_menu').bind('click', function (e) {
            e.stopPropagation();
        });

        $('body').click(function () {
            $('.main-navigation__sub-menu2').hide();
        });
        $('.main-navigation__button2').click(function (e) {
            e.stopPropagation();
        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "/user/pages/images/flags";
            var $state = $('<span class="city_start"><i class="fa fa-map-marker-alt"></i>' + state.text + '</span>');
            return $state;
        };$('.multiselectportal').click(function () {
            if ($("input[name='select-rb']:checked").val() == '1') {
                $('.returnCalendar').prop("disabled", "disabled");
            } else {
                $('.returnCalendar').removeAttr("disabled");
            }
        });
        $('.select_multiway3').click(function () {
            if ($("input[name='select-rb2']:checked").val() == '1') {
                $('#regds_dept_date_local').prop("disabled", "disabled");
            } else {
                $('#regds_dept_date_local').removeAttr("disabled");
            }
        });

    });
    /*! searchBox END*/
});