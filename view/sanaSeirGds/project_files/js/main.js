"use strict";
/* -------------------------------------
 Google Analytics
 change UA-XXXXX-X to be your site's ID.
 -------------------------------------- */
/*(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
 function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
 e=o.createElement(i);r=o.getElementsByTagName(i)[0];
 e.src='../../../../www.google-analytics.com/analytics.js';
 r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
 ga('create','UA-XXXXX-X','auto');ga('send','pageview');*/
/* -------------------------------------
 CUSTOM FUNCTION WRITE HERE
 -------------------------------------- */

$(document).ready(function () {

    $('.nav-item:nth-child(1)').click(function () {
        $('.bottom_bg').css('right', '0')

    });
    $('.nav-item:nth-child(2)').click(function () {
        $('.bottom_bg').css('right', '50%')

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
        $('#scroll-top button').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });

    $('.col_search').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
 if ($(window).width() > 990 ) {
     $(window).scroll(function () {

         var sctop = $(this).scrollTop();

         if(sctop > 50){

             $('.header_area').addClass('fixedmenu');
             $('.header_area .nav-brand .hotel-logo-text2').attr('src','images/logo-txt2.png');


         }
         else{

             $('.header_area').removeClass('fixedmenu');
             $('.header_area .nav-brand .hotel-logo-text2').attr('src','images/logo-txt.png');

         }


     });

     $('.col_search input').focus(function () {

         $(this).addClass('focused');

     });
     $('.box-of-count-nafar').click(function () {

         $(this).addClass('focused');

     });
    }

    $('.start_search').click(function () {
        $('.start_search').removeClass('boxshodow');
        $(this).addClass('boxshodow')

    });



    $('.tg-nav-tabs').on('click', 'li', function () {
        var buttonWidth = $(this).width();

        var arrowDist = $(this).position().left;
        $('.search-type-arrow').css({
            'left': arrowDist + 15,
            'right': 'auto',
            'transition': 'left 0.4s cubic-bezier(.87,-.41,.19,1.44)'
        });


    });

    $('.box-of-count-nafar').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('.down-count-nafar').click(function () {

        $('.cbox-count-nafar').toggle();
        $(this).parents().find('.down-count-nafar').toggleClass('icofont-rounded-up');
    });
    $('body').click(function () {

        $('.start_search').removeClass('boxshodow');
        $('.box-of-count-nafar').removeClass('focused');
        $('.col_search input').removeClass('focused');
        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('icofont-rounded-up');
    });
    $('input:radio[name="radio1"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('#flightda .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $('.flight_local').css('display', 'flex');
                $('.flight_forign').css('display', 'none');

            }
            else {
                $('#flightda .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '50%');
                $('.flight_local').css('display', 'none');
                $('.flight_forign').css('display', 'flex');
            }
        });
    $('input:radio[name="radio2"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('#room .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '0');
                $('#hotel_dakheli').css('display', 'flex');
                $('#hotel_khareji').css('display', 'none');

            }
            else {
                $('#room .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '50%');
                $('#hotel_dakheli').css('display', 'none');
                $('#hotel_khareji').css('display', 'flex');
            }
        });

    $('input:radio[name="radio3"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('#tour .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '0');
                $('#tour_dakheli').css('display', 'flex');
                $('#tour_khareji').css('display', 'none');

            }
            else {
                $('#tour .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '50%');
                $('#tour_dakheli').css('display', 'none');
                $('#tour_khareji').css('display', 'flex');
            }
        });

    $('input:radio[name="radio_gasht"]').change(
        function () {
            if (this.checked && this.value == '1') {
                $('#gasht .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '0');
                $('#gasht_div').css('display', 'flex');
                $('#transfer_div').css('display', 'none');

            }
            else {
                $('#gasht .inputGroup').removeClass('active_tab');
                $(this).parents('.inputGroup').addClass('active_tab');
                $(this).parents('.switch-tabs').find('.line_tab').css('right', '50%');
                $('#gasht_div').css('display', 'none');
                $('#transfer_div').css('display', 'flex');
            }
        });
    $('#number_of_passengers').on('change', function (e) {


        var itemInsu = $(this).val();

        itemInsu++;
        var HtmlCode = "";
        $(".nafaratbime").html('');

        var i = 1;
        while (i < itemInsu) {

            HtmlCode += "<div class='col-lg-3 col-md-3 col-6 col_search search_col nafarat-bime '>" +
                "<div class='form-group'>" +

                "<input placeholder='  تولد مسافر  " + i + "' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class=' form-control'  />" +
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
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").html("<em>" + tedad + " </em>" + "مسافر ");
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
        $(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(tedad2 + " مسافر ");
    });

    function createRoomHotel(roomCount) {
        var HtmlCode = "";
        var i = 1;
        let numberText = "اول";

        while (i <= roomCount) {
            if (i == 1) {
                numberText = "اول";
            } else if (i == 2) {
                numberText = "دوم";
            } else if (i == 3) {
                numberText = "سوم";
            } else if (i == 4) {
                numberText = "چهارم";
            }

            HtmlCode +=
                '<div class="myroom-hotel-item" data-roomNumber="' + i + '">'
                + '<div class="myroom-hotel-item-title">اتاق  ' + numberText + '<span class="close"></span></div>'
                + '<div class="myroom-hotel-item-info">'
                + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
                + '<span>تعداد بزرگسال<i>(12 سال به بالا)</i></span>'
                + '<div>'
                + '<i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fa fa-plus"></i>'
                + '<input readonly class="countParent"  min="0" value="1" max="5" type="number" name="adult' + i + '" id="adult' + i + '">'
                + '<i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fa fa-minus"></i>'
                + '</div>'
                + '</div>'
                + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
                + '<span>تعداد کودک<i>(زیر 12 سال)</i></span>'
                + '<div>'
                + '<i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fa fa-plus"></i>'
                + '<input readonly class="countChild" min="0" value="0" max="5" type="number" name="child' + i + '" id="child' + i + '">'
                + '<i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fa fa-minus"></i>'
                + '</div>'
                + '</div>'
                + '<div class="tarikh-tavalods">'
                + '</div>'
                + '</div>'
                + '</div>';
            i++;
        }
        return HtmlCode;
    };

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


    $('body').on('click', '.myroom-hotel-item .close', function () {
        let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
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
            $(this).find('.myroom-hotel-item-title').html(' اتاق ' + numberText + '<span class="close"></span>');
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
    });


    $('#countRoom').on('change', function (e) {


        var roomCount = $("#countRoom").val();
        createRoomHotel(roomCount);
        $(".myroom-hotel").find(".myroom-hotel-item").remove();
        var code = createRoomHotel(roomCount);
        $(".myroom-hotel").append(code);


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

    $('body').on('click', 'i.addParent', function () {

        var inputNum = $(this).siblings(".countParent").val();
        inputNum++;
        if (inputNum < 7) {
            $(this).siblings(".countParent").val(inputNum);
        }
    });
    $('body').on('click', 'i.minusParent', function () {
        var inputNum = $(this).siblings(".countParent").val();
        if (inputNum != 0) {
            inputNum--;
            $(this).siblings(".countParent").val(inputNum);
        } else {
            $(this).siblings(".countParent").val('0');
        }
    });

    $('body').on('click', 'i.addChild', function () {
        var inputNum = $(this).siblings(".countChild").val();
        inputNum++;
        if (inputNum < 5) {
            $(this).siblings(".countChild").val(inputNum);

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
            inputNum--;
            $(this).siblings(".countChild").val(inputNum);

            let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");

            var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

            $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);
        } else {
            $(this).siblings(".countChild").val('0');
        }
    });

    $('input:radio[name="radio_flight_l"]').change(
        function () {
            if (this.checked && this.value == '1') {

                $('.return_input_l').attr('disabled', '')


            }
            else {

                $('.return_input_l').removeAttr('disabled', '')
            }
        });

    $('.select2').select2();


})
$(document).ready(function (e) {

    /*-------------------------------------
     HOME SLIDER
     --------------------------------------*/
    var swiper = new Swiper('#tg-home-slider',
        {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            paginationClickable: true,
            mousewheelControl: false,
            direction: 'vertical',
            parallax: true,
            speed: 2000
        }
    );

    /*-------------------------------------
     NAV FUNCTION
     --------------------------------------*/
    function navFunction() {
        $('#tg-burger-menu').on('click', function (event) {
            event.preventDefault();
            $('#tg-nav, #tg-burger-menu').fadeOut();
            $('#tg-additional-nav').delay(500).fadeIn();
        });
        $('#tg-add-menu').on('click', function (event) {
            event.preventDefault();
            $('#tg-nav, #tg-burger-menu').delay(500).fadeIn();
            $('#tg-additional-nav').fadeOut();
        });
    }

    navFunction();

    /* -------------------------------------
     CATEGORY ICONS
     -------------------------------------- */
    function categoryIcon() {
        $('.tg-nav-tabs li a').on('click', function (event) {
            event.preventDefault();
            var hrefValue = $(this).attr('href').replace('#', '');
            $('.tg-category-icon').find('.active').removeClass('active');
            $('.tg-category-icon div.' + hrefValue).addClass('active');
        })
    }

    categoryIcon();
    $('.tg-category-icon').on('click', '.next', function (e) {
        e.preventDefault();
        var currentActive = $(this).parents('.tg-category-holder').find('.tg-categoriesarea .tg-categories .active');
        var prevActive = currentActive.prev();
        var currentHref = prevActive.find('a').attr('href');

        var currentIndex = currentActive.index();
        if (currentIndex == 0) {
            prevActive = $('.tg-category-holder').find('.tg-categoriesarea .tg-categories li').last();
            currentHref = prevActive.find('a').attr('href');
        }

        // Catergoty Title
        var hrefValue = currentHref.replace('#', '');
        $('.tg-category-icon').find('.active').removeClass('active');
        $('.tg-category-icon div.' + hrefValue).addClass('active');
        // Tab List Active
        $('.tg-category-holder').find('.tg-categoriesarea .tg-categories li').removeClass('active');
        prevActive.addClass('active');
        // Content Active
        $('.tg-category-content').find('.tab-pane').removeClass('active').removeClass('in');
        $('.tg-category-content').find(currentHref).addClass('active').addClass('in');


    });
    $('.tg-category-icon').on('click', '.prev', function (e) {
        e.preventDefault();
        var currentActive = $(this).parents('.tg-category-holder').find('.tg-categoriesarea .tg-categories .active');
        var nextActive = currentActive.next();
        var currentHref = nextActive.find('a').attr('href');

        if (currentHref == 'undefined' || currentHref == null) {
            nextActive = $('.tg-category-holder').find('.tg-categoriesarea .tg-categories li').eq(0);
            currentHref = nextActive.find('a').attr('href');
        }

        // Catergoty Title
        var hrefValue = currentHref.replace('#', '');
        $('.tg-category-icon').find('.active').removeClass('active');
        $('.tg-category-icon div.' + hrefValue).addClass('active');
        // Tab List Active
        $('.tg-category-holder').find('.tg-categoriesarea .tg-categories li').removeClass('active');
        nextActive.addClass('active');
        // Content Active
        $('.tg-category-content').find('.tab-pane').removeClass('active').removeClass('in');
        $('.tg-category-content').find(currentHref).addClass('active').addClass('in');

    });
    /* -------------------------------------
     DESTINATION SLIDER
     -------------------------------------- */

    var owl_tour_v = $('.tg-destination-slider');
    owl_tour_v.owlCarousel({
        rtl: true,
        dots: true,
        loop: true,
        margin: 10,
        nav: false,
        autoplay: false,
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
    /* -------------------------------------
     VIDEO SLIDER
     -------------------------------------- */
    var swiper = new Swiper(
        '#tg-video-slider',
        {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            paginationClickable: true,
            mousewheelControl: true,
            direction: 'vertical',
            parallax: true,
            speed: 2000
        }
    );
    /* -------------------------------------
     DESTINATION SLIDER
     -------------------------------------- */
    var owl_tour = $('.tours_owl');
    owl_tour.owlCarousel({
        rtl: true,
        dots: true,
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
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

    /* -------------------------------------
     TEAM SLIDER
     -------------------------------------- */
    $("#tg-team-slider").owlCarousel({
        autoPlay: true,
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [991, 3],
        itemsTabletSmall: [767, 2],
        slideSpeed: 300,
        singleItem: false,
        navigation: false,
        pagination: true,
        paginationSpeed: 400,
        navigationText: [
            "<i class='tg-prev flaticon-left-arrow23'></i>",
            "<i class='tg-next flaticon-left-arrow23'></i>"
        ]
    });
    /* -------------------------------------
     PARTNER SLIDER
     -------------------------------------- */
    $("#tg-partners-slider").owlCarousel({
        autoPlay: true,
        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [991, 3],
        itemsTabletSmall: [767, 2],
        slideSpeed: 300,
        singleItem: false,
        navigation: false,
        pagination: true,
        paginationSpeed: 400,
        navigationText: [
            "<i class='tg-prev flaticon-left-arrow23'></i>",
            "<i class='tg-next flaticon-left-arrow23'></i>"
        ]
    });

    /* -------------------------------------
     TESTIMONIALS SLIDER
     -------------------------------------- */
    function testimonialsSlider() {
        var sync1 = $("#tg-testimonials-message-slider");
        var sync2 = $("#tg-testimonials-pagger-slider");

        sync1.owlCarousel({
            singleItem: true,
            slideSpeed: 1000,
            navigation: false,
            pagination: true,
            afterAction: syncPosition,
            responsiveRefreshRate: 200,
        });
        sync2.owlCarousel({
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3],
            itemsTablet: [768, 3],
            itemsMobile: [479, 2],
            pagination: false,
            responsiveRefreshRate: 100,
            afterInit: function (el) {
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });

        function syncPosition(el) {
            var current = this.currentItem;
            $("#tg-testimonials-pagger-slider")
                .find(".owl-item")
                .removeClass("synced")
                .eq(current)
                .addClass("synced")
            if ($("#tg-testimonials-pagger-slider").data("owlCarousel") !== undefined) {
                center(current)
            }
        }

        $("#tg-testimonials-pagger-slider").on("click", ".owl-item", function (e) {
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });

        function center(number) {
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
            var num = number;
            var found = false;
            for (var i in sync2visible) {
                if (num === sync2visible[i]) {
                    var found = true;
                }
            }
            if (found === false) {
                if (num > sync2visible[sync2visible.length - 1]) {
                    sync2.trigger("owl.goTo", num - sync2visible.length + 2)
                } else {
                    if (num - 1 === -1) {
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if (num === sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]) {
                sync2.trigger("owl.goTo", num - 1)
            }
        }
    }

    testimonialsSlider();
    /* -------------------------------------
     BLOG POST SLIDER
     -------------------------------------- */
    $("#tg-post-slider").owlCarousel({
        autoPlay: false,
        items: 2,
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [991, 2],
        itemsTabletSmall: [767, 2],
        slideSpeed: 300,
        singleItem: false,
        navigation: false,
        pagination: true,
        paginationSpeed: 400,
        navigationText: [
            "<i class='tg-prev flaticon-left-arrow23'></i>",
            "<i class='tg-next flaticon-left-arrow23'></i>"
        ]
    });


    /* -------------------------------------
     TOGGLE SEARCH RESULT VIEW
     -------------------------------------- */
    function toggleView() {
        $('.tg-view-type li a').on('click', function (event) {
            var hrefValue = $(this).attr('href');
            event.preventDefault();
            $('.tg-view-type li').removeClass('active');
            $(this).parent().addClass('active');
            $('#tg-content .tg-search-result').removeClass('tg-grid-view').addClass(hrefValue);
            $('#tg-content .tg-search-result').removeClass('tg-list-view').addClass(hrefValue);
        });
    }

    toggleView();

    /* -------------------------------------
     PRICE RANGE SLIDER
     -------------------------------------- */

//obt3 = new Vivus('obturateur3', {type: 'oneByOne', duration: 150})
    try {
        $('#ps4').appear(function () {
//            alert('test');
            var svg1 = new Walkway({
                selector: '#ps1',
                duration: 3500
            }).draw();
        });
    } catch (err) {
    }
    $('#tg-category-slider li a').on('click', function () {
        var svg1 = new Walkway({
            selector: '#ps1',
            duration: 3500
        }).draw();

        var svg2 = new Walkway({
            selector: '#ps2',
            duration: 3500
        }).draw();

        var svg3 = new Walkway({
            selector: '#ps3',
            duration: 3500
        }).draw();

        var svg4 = new Walkway({
            selector: '#ps4',
            duration: 3500
        }).draw();

        var svg5 = new Walkway({
            selector: '#ps5',
            duration: 3500
        }).draw();

        var svg6 = new Walkway({
            selector: '#ps6',
            duration: 3500
        }).draw();

        var ps10 = new Walkway({
            selector: '#ps10',
            duration: 3500
        }).draw();
        var ps11 = new Walkway({
            selector: '#ps11',
            duration: 3500
        }).draw();

        var ps12 = new Walkway({
            selector: '#ps12',
            duration: 3500
        }).draw();
        var ps12 = new Walkway({
            selector: '#Layer_1',
            duration: 3500
        }).draw();
    });


    /* ---------------------------------------
     GALLERY
     -------------------------------------- */
    var $container = $('.tg-gallarycontent');
    var $optionSets = $('.option-set');
    var $optionLinks = $optionSets.find('a');


    /* -------------------------------------
     COUNTER
     -------------------------------------- */
    try {
        $('.tg-counters').appear(function () {
            $('.tg-timer').countTo()
        });
    } catch (err) {
    }

});


