$('.owl-tour-safiran').owlCarousel({
    rtl:true,
    loop:true,
    margin: 15,
    nav:true,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M297 239c9.4 9.4 9.4 24.6 0 33.9L105 465c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l175-175L71 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L297 239z\"/></svg>",
        "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L199 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 233 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 15000,
    autoplaySpeed:5000,
    dots:true,
    responsive:{
        0:{
            items:1,
            dots:false,
        },
        600:{
            items:2,
        },
        1000:{
            items:3,
        },
        1200:{
            items:4
        }
    }
});
$('.owl-hotel-ghods').owlCarousel({
    rtl:true,
    loop:true,
    margin: 15,
    nav:true,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M297 239c9.4 9.4 9.4 24.6 0 33.9L105 465c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l175-175L71 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L297 239z\"/></svg>",
            "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L199 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 233 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 15000,
    autoplaySpeed:5000,
    dots:true,
    responsive:{
        0:{
            items:1,
            dots:false,
        },
        600:{
            items:2,
        },
        1000:{
            items:3,
        },
        1200:{
            items:6
        }
    }
});
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


$(function () {

$('#scroll-top-footer').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
});
});



$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('.header_area').addClass('scrolled');
        } else {
            $('.header_area').removeClass('scrolled');
        }
    });
});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 180) {
            $('.search-box-scroll-mobile').addClass('d-flex');
        } else {
            $('.search-box-scroll-mobile').removeClass('d-flex');
        }
    });
});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 180) {
            $('.main_header_area').addClass('h64');
        } else {
            $('.main_header_area').removeClass('h64');
        }
    });



    // if($(window).width() > 576){
    //     $('#Flight-tab-Domestic').click(function () {$('.banner-site').css('background-image' , 'url("images/bg.jpg")')});
    //     $('#Flight-tab-Foreign').click(function () {$('.banner-site').css('background-image' , 'url("images/bg-parvaz.jpg")')});
    //     $('#Hotel-tab').click(function () {$('.banner-site').css('background-image' , 'url("images/bg-hotel.jpg")')});
    //     $('#Insurance-tab').click(function () {$('.banner-site').css('background-image' , 'url("images/bg-bime.jpg")')});
    //     $('#Tour-tab1').click(function () {$('.banner-site').css('background-image' , 'url("images/bg-tour.jpg")')});
    //     $('#Tour-tab2').click(function () {$('.banner-site').css('background-image' , 'url("images/tafrihat2.jpg")')});
    // }
});
// انتخاب تمام دکمه‌های آکاردئون
const accordionButtons = document.querySelectorAll('.quick-search-content .btn-link');

// افزودن رویداد به هر دکمه
accordionButtons.forEach(button => {
    button.addEventListener('click', () => {

        const arrowIcon = button.querySelector('.btn-link i');

        // اگر آکاردئون باز است، فلش را بچرخان
        if (button.getAttribute('aria-expanded') === 'true') {
            arrowIcon.classList.add('rotate-up'); // چرخش به سمت بالا
        } else {
            arrowIcon.classList.remove('rotate-up'); // بازگشت به حالت اولیه
        }
    });
});
