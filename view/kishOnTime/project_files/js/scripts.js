$(document).ready(function() {
    $('.c-header__btn').click(function () {

        $('.main-navigation__sub-menu2').toggleClass('active_log');
    });
    $('.menu-login').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });

    $('body').click(function () {

        $('.main-navigation__sub-menu2').removeClass('active_log');
    })


    $('#owl-banner').owlCarousel({
        rtl: true,
        dots: false,
        loop: false,
        margin: 0,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                nav: true,
                dots: false,
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {

                items: 1,

            }
        }
    });
    $('#owl-example2').owlCarousel({
        rtl: true,
        dots: true,
        loop: false,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                nav: false,
                dots: true,
                items: 1,
            },
            768: {
                items: 2,
            },
            1000: {

                items: 4,

            }
        }
    });
    $('#owl-example3').owlCarousel({
        rtl: true,
        dots: true,
        loop: false,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                nav: false,
                dots: true,
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {

                items: 4,

            }
        }
    });

    $('.date_change').click(function () {

        $('.shamsiConvertDate').addClass('convert-date-open');
        $(this).hide();

    });
    //search box
    $('.select2').select2({});
    <!--select oneway toway-->
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
    $('.radioChangeStations').click(function () {
        if ($("input[name='changeStations']:checked").val() == 'sourceStations') {
            $('#destStationId').prop("disabled", "disabled");
        } else {
            $('#destStationId').removeAttr("disabled");
        }
    });


    $('.box-of-count-nafar').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    // $('#number_of_passengers').on('change', function (e) {
    //
    //     var itemInsu = $("#number_of_passengers").val();
    //
    //     itemInsu++;
    //     var HtmlCode = "";
    //     $(".nafarat-bime").remove();
    //
    //     var i = 1;
    //     while (i < itemInsu) {
    //
    //         HtmlCode += "<div class='col-lg-3 col-md-3 col-sm-6 col-12 col_search search_item nafarat-bime '>" +
    //             "<div class='form-group'>" +
    //
    //             "<input placeholder='  تولد مسافر  " + i + "' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class=' form-control shamsiBirthdayCalendar'  />" +
    //             "</div>" +
    //             "</div>";
    //         i++;
    //
    //     }
    //
    //
    //     $(".nafaratbime").append(HtmlCode);
    // });
    $('body').click(function () {


        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });

    $(".parvaz_charter").click(function () {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".masir-section").offset().top - 15
        }, 1000);
    });
    // hide #back-top first
    $("#scroll-top").hide();
    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scroll-top').fadeIn();
                $('.header_area_bg').css('background', '#fff');
                $('.header_area').css('background', 'none');
                $('.nav-menu > li > a').css('color', '#000');
                $('.submenu-indicator-chevron').css('border-color', 'transparent #000 #000 transparent');
                $('.navigation-portrait .nav-menu > li > a').css('color', '#000');
            } else {
                $('#scroll-top').fadeOut();
                $('.header_area_bg').css('background', 'none');
                $('.nav-menu > li > a').css('color', '#fff');
                $('.submenu-indicator-chevron').css('border-color', 'transparent #fff #fff transparent');
                $('.navigation-portrait .nav-menu > li > a').css('color', '#000');
            }
        });
        // scroll body to 0px on click
        $('#scroll-top button').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });
});

var lat = 35.775794375297664;
var lon = 51.35771996927776;
// initialize map
map = L.map('g-map').setView([lat, lon], 15);
// set map tiles source
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '',
    maxZoom: 16,
    minZoom: 14,
}).addTo(map);
// add marker to the map
marker = L.marker([lat, lon]).addTo(map);
// add popup to the marker
marker.bindPopup("کیش آن تایم").openPopup();