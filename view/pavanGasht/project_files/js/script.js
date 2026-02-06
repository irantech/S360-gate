$('.owl-banner-kanoun').owlCarousel({
    rtl:true,
    loop:true,
    margin:0,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 8000,
    autoplaySpeed:1500,
    dots:false,
    responsive:{
        0:{
            items:1,
        },
    }
});

// owl_special_tours
$('.owl_special_tours').owlCarousel({
    nav:true,
    dots:true,
    rtl:true,
    loop:true,
    margin:10,
    navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    responsive:{
        0:{
            items:1,
            nav:false,
        },
        600:{
            items:2,
            nav:false,
        },
        1000:{
            items:3
        }
    }
});
$('.owl_tour_news').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
    nav:true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    responsive:{
        0:{
            items:1,
            nav:false,
        },
        600:{
            items:1,
            nav:false,
        },
        1000:{
            items:1
        }
    }
});
$('.owl_luxury_travel').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
    nav:true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    responsive:{
        0:{
            items:1,
            nav:false,
        },
        600:{
            items:2,
            nav:false,
        },
        1000:{
            items:5
        }
    }
});
$('.owl-hotel-demo').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 15000,
    autoplaySpeed:5000,
    dots:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:2,
        },
        992:{
            items:3
        },
        1200:{
            items:4
        }
    }
});

$(document).ready(function (){
    $("#scroll-top").addClass('d-none');
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scroll-top').addClass('d-flex');
            } else {
                $('#scroll-top').removeClass('d-flex');
            }
        });
        $('#scroll-top ').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });


});
// $(".btn_accordion").children(".rot_revers").toggleClass("rot");
// $(this).children(".rot_revers").toggleClass("rot");

// $(".btn_accordion .collapsed").click(function (){
//
//     $(".rot_revers").toggleClass("rot");
//
// })