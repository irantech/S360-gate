$('.owl-tour').owlCarousel({
    rtl:true,
    loop:true,
    margin:20,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    dots: true,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:1
        }
    }
});



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

$('.back-to-top').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
});




function clickScroll(e) {
    $("html").animate({
        scrollTop: $(`#${e}`).offset().top - 30
    }, 1000);
}




