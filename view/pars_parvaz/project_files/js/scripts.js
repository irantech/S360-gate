$(document).ready(function () {
    $('.select2 , .select2BusRouteSearch').select2({
        language: "fa"
    });
    $('.switch-label-off').click();
    $("#return-to-top").hide();
    if($(window).width() > 992){
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {$('#return-to-top').fadeIn();} else {$('#return-to-top').fadeOut();}
            var sctop = $(this).scrollTop();
            if(sctop > 50){$('.header_area').addClass('fixedmenu');}
            else{$('.header_area').removeClass('fixedmenu');}
        });
    }
    $('#return-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
    });
    $('.myhotels-rooms').on('click', '.close_room', function () {

        $(this).parent().parent().removeClass('active_p');

    });
    var owlFlightProposal = $('.owlFlightProposal');
    owlFlightProposal.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 10,
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
                items: 2
            },
            1000: {
                items: 4

            }
        }
    });
    var owl_4 = $('.owl_4');
    owl_4.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 10,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        nav:true,
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav:false,
                dots: true,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });
    var owl_stour = $('.owl_tour_local');
    owl_stour.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 10,
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
                dots:true,
                nav:false,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,


            }
        }
    });
    var owlhotel = $('.owl-hotel');
    owlhotel.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 10,
        autoplaySpeed:1000,
        nav:true,
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
});
function changeText(text, none , name) {
    $('#text_search').text(text);
    if (none == 'null') {
        $('#titr_searchBox em').text('');
    } else {
        $('#titr_searchBox em').text('بلیط');
    }
}