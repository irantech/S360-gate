$(document).ready(function () {

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
    $('#number_of_passengers').on('change', function (e) {

        var itemInsu = $(this).val();

        itemInsu++;
        var HtmlCode = "";
        $(".nafaratbime").html('');

        var i = 1;
        while (i < itemInsu) {

            HtmlCode += "<div class=' search_item nafarat-bime m-t-8 '>" +

                "<input placeholder=' تاریخ تولد مسافر  " + i + "' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar search_input '  />" +

                "</div>";
            i++;
        }

        $(".nafaratbime ").append(HtmlCode);
    });
    var heiw =$(window).height();
    $('.slider .carousel-inner .carousel-item').css('height' , heiw);

    var header = $('.header');
    var menuActive = false;
    setHeader();

    $(window).on('resize', function () {
        setHeader();
    });

    $(document).on('scroll', function () {
        setHeader();
    });

    $("#pills-bime-tab").click(function() {
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#pills-bime-tab").offset().top - 90
        }, 1000);
    });
    function setHeader() {
        if (window.innerWidth < 992) {
            if ($(window).scrollTop() > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        } else {
            if ($(window).scrollTop() > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        }
        if (window.innerWidth > 991 && menuActive) {
            closeMenu();
        }
    }



    


    if ($('.home_slider').length) {
        var homeSlider = $('.home_slider');

        homeSlider.owlCarousel({
            items: 1,
            loop: true,
            autoplay: false,
            smartSpeed: 1200,
            dotsContainer: 'main_slider_custom_dots'
        });

        /* Custom nav events */
        if ($('.home_slider_prev').length) {
            var prev = $('.home_slider_prev');

            prev.on('click', function () {
                homeSlider.trigger('prev.owl.carousel');
            });
        }

        if ($('.home_slider_next').length) {
            var next = $('.home_slider_next');

            next.on('click', function () {
                homeSlider.trigger('next.owl.carousel');
            });
        }

        /* Custom dots events */
        if ($('.home_slider_custom_dot').length) {
            $('.home_slider_custom_dot').on('click', function () {
                $('.home_slider_custom_dot').removeClass('active');
                $(this).addClass('active');
                homeSlider.trigger('to.owl.carousel', [$(this).index(), 300]);
            });
        }

        /* Change active class for dots when slide changes by nav or touch */
        homeSlider.on('changed.owl.carousel', function (event) {
            $('.home_slider_custom_dot').removeClass('active');
            $('.home_slider_custom_dots li').eq(event.page.index).addClass('active');
        });

        // add animate.css class(es) to the elements to be animated
        function setAnimation(_elem, _InOut) {
            // Store all animationend event name in a string.
            // cf animate.css documentation
            var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

            _elem.each(function () {
                var $elem = $(this);
                var $animationType = 'animated ' + $elem.data('animation-' + _InOut);

                $elem.addClass($animationType).one(animationEndEvent, function () {
                    $elem.removeClass($animationType); // remove animate.css Class at the end of the animations
                });
            });
        }

        // Fired before current slide change
        homeSlider.on('change.owl.carousel', function (event) {
            var $currentItem = $('.home_slider_item', homeSlider).eq(event.item.index);
            var $elemsToanim = $currentItem.find("[data-animation-out]");
            setAnimation($elemsToanim, 'out');
        });

        // Fired after current slide has been changed
        homeSlider.on('changed.owl.carousel', function (event) {
            var $currentItem = $('.home_slider_item', homeSlider).eq(event.item.index);
            var $elemsToanim = $currentItem.find("[data-animation-in]");
            setAnimation($elemsToanim, 'in');
        })
    }
    var menu = $('.menu');
    var menuActive = false;
    initMenu();

    function initMenu() {
        if ($('.hamburger').length && $('.menu').length) {
            var hamb = $('.hamburger');
            var close = $('.menu_close_container');

            hamb.on('click', function () {
                if (!menuActive) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });

            close.on('click', function () {
                if (!menuActive) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });


        }
    }

    function openMenu() {
        menu.addClass('active');
        menuActive = true;
    }

    function closeMenu() {
        menu.removeClass('active');
        menuActive = false;
    }



});
