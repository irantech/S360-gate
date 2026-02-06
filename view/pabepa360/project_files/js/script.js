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


$(document).ready(function (){
    $("#scroll-top").addClass('d-none');
    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scroll-top').addClass('d-flex');
            } else {
                $('#scroll-top').removeClass('d-flex');
            }
        });
        // scroll body to 0px on click
        $('#scroll-top ').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });
// $("#accordionExample>.card>#collapse0").addClass("show");
// $("#accordionExample2>.card>#collapse0").addClass("show");

});
// $(".btn_accordion").children(".rot_revers").toggleClass("rot");
// $(this).children(".rot_revers").toggleClass("rot");

// $(".btn_accordion .collapsed").click(function (){
//
//     $(".rot_revers").toggleClass("rot");
//
// })













// login register





$(document).ready(function () {


    $('.main-navigation__button').click(function () {

        $('.main-navigation__sub-menu').toggle();
        $('.button-chevron').toggleClass('rotate');

    });

    $('body').click(function () {

        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
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
        $('#scroll-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });


});





$('.lang ').bind('click', function(e){
    //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
    e.stopPropagation();
});

$('body').click(function () {
    $('.lang_ul').removeClass('active_lang');
});

$('.lang span').click(function () {
    $('.lang_ul').toggleClass('active_lang');
});



$('.main-navigation__button').click(function () {

    $('.main-navigation__sub-menu').toggle();
    $('.button-chevron').toggleClass('rotate');

});

$('body').click(function () {

    $('.main-navigation__sub-menu').hide();
    $('.button-chevron').removeClass('rotate');

    $('.cbox-count-nafar').hide();
    $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
});
$(document).ready(function () {
    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });



    $('body').click(function () {

        $('.main-navigation__sub-menu2').hide();

        $('.button-chevron-2').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });

    $('.main-navigation__button').click(function () {

        $('.main-navigation__sub-menu').fadeToggle();
        $(this).find('.button-chevron').toggleClass('rotate');
        $('.main-navigation__sub-menu2').hide();
        $('.button-chevron-2').removeClass('rotate');
    });


    $('.main-navigation__button2').click(function (e) {
        e.stopPropagation();
        $('.main-navigation__sub-menu2').toggleClass("d-flex");

        });

    });
    $('body').click(function (){
        $('.main-navigation__sub-menu2').removeClass("d-flex");
    })

document.addEventListener("DOMContentLoaded", function () {
    const parents = document.querySelectorAll("#tab-content-tour .tab-pane");
    const limit = 8;

    parents.forEach(parent => {
        const items = parent.querySelectorAll(".tour_body");
        const toggleBtnWrapper = parent.querySelector(".showMoreRecentTour");
        const toggleBtn = parent.querySelector(".showMoreRecentTour span");
        const toggleBtnIcon = parent.querySelector(".showMoreRecentTour i");
        let expanded = false;

        if (items.length <= limit) {
            toggleBtnWrapper.classList.add("d-none");
            return;
        }

        items.forEach((item, index) => {
            if (index >= limit) {
                item.classList.add("d-none");
            }
        });

        toggleBtn.addEventListener("click", function () {
            expanded = !expanded;

            if (expanded) {
                items.forEach(item => item.classList.remove("d-none"));
                toggleBtn.textContent = "نمایش کمتر";
                toggleBtnIcon.classList.replace("fa-arrow-down", "fa-arrow-up");
            } else {
                items.forEach((item, index) => {
                    if (index >= limit) {
                        item.classList.add("d-none");
                    }
                });
                toggleBtn.textContent = "نمایش بیشتر";
                toggleBtnIcon.classList.replace("fa-arrow-up", "fa-arrow-down");
            }
        });
    });
});
