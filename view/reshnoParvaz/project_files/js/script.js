$('.owl-banner-kanoun').owlCarousel({
    rtl:true,
    loop:false,
    margin:0,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>"],
    autoplay: true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1,
            nav:true,
        },
        1000:{
            items:1
        }
    }
});
$('.owl-tab-tour').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    dots:false,
    nav:true,
    navText: ["<span class='fas fa-chevron-right'></span>","<span class='fas fa-chevron-left'></span>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    responsive:{
        0:{
            items:1,
            nav:false,
            dots:true,
        },
        576:{
            items:2,
            nav:true,
            dots:false,
        },
        992:{
            items:3,
            nav:true,
            dots:false,
        },
        1200:{
            items:4,
            nav:true,
            dots:false,
        }
    }
})

$('.owl-blog').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    dots:false,
    nav:true,
    navText: ["<span class='fas fa-chevron-right'></span>","<span class='fas fa-chevron-left'></span>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    responsive:{
        0:{
            items:1,
            nav:false,
            dots:true,
        },
        576:{
            items:2,
            nav:true,
            dots:false,
        },
        992:{
            items:3,
        },
        1200:{
            items:4,
        }
    }
})




function clickScroll(e){
    $("html").animate({
        scrollTop: $(`#${e}`).offset().top - 30
    }, 1000);
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(".select2").select2();


// hide #back-top first
$("#scroll-top").addClass('d-none');
// fade in #back-top
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#scroll-top').addClass('d-flex');
            $('#scroll-top').removeClass('d-none');
        } else {
            $('#scroll-top').removeClass('d-flex');
            $('#scroll-top').addClass('d-none');
        }
    });
    // scroll body to 0px on click
    $('#scroll-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
    });
});


$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.bottom-header').addClass('scrolled');
        } else {
            $('.bottom-header').removeClass('scrolled');
        }
    });
});
