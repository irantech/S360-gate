$(document).ready(function () {
    $('.owl-blog').owlCarousel({
        rtl: true,
        loop: true,
        margin: 10,
        dots: true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        nav: false,
        responsive: {0: {items: 1}, 600: {items: 2}, 1000: {nav: true, items: 4},},
    });
    $('.OWL_banner').owlCarousel({
        rtl: true,
        loop: true,
        margin: 0,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        dots: true,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        nav: true,
        items: 1,
    });
});

function changeTitleTour(e) {
    $(".tour .title > h2").text(e);
}