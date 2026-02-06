$('.owl-tour-ghods').owlCarousel({
    rtl:true,
    loop:true,
    margin:30,
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
        1000:{
            items:3
        }
    }
});
$('.owl-hotel-ghods').owlCarousel({
    rtl:true,
    loop:true,
    margin:30,
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
        1000:{
            items:3
        }
    }
});
$('.tour-owl').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    nav:false,
    navText: ["<span class='fas fa-chevron-right'></span>","<span class='fas fa-chevron-left'></span>"],
    autoplay: true,
    autoplayTimeout: 15000,
    autoplaySpeed:5000,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
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
        if ($(this).scrollTop() > 200) {
            $('.header_area').addClass('scrolled');
        } else {
            $('.header_area').removeClass('scrolled');
        }
    });
    // if($(window).width() > 576){
    //     $('#Flight-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/flight-bg-js.jpg")');
    //     });
    //     $('#Hotel-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/hotel-bg-js.jpg")');
    //     });
    //     $('#Bus-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/bus-bg-js.jpg")');
    //     });
    //     $('#Insurance-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/bimeh-bg-js.jpg")');
    //     });
    //     $('#Tour-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/tour-bg-js.jpg")');
    //     });
    //     $('#Entertainment-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/tafrihat-bg-js.jpg")');
    //     });
    //     $('#Visa-tab').click(function (){
    //         $('.banner-demo').css('background-image', 'url("images/visa-bg-js.jpg")');
    //     });
    // }



    $('.lang').click(function (e) {
        e.stopPropagation();
        $('.lang_ul').toggleClass('active_lang');
    });
    $('body').click(function () {
        $('.lang_ul').removeClass('active_lang');
    });



});


