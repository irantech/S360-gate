$('.owl-ads1').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:1000,
    dots:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1,
        },
        1000:{
            items:1
        }
    }
});
$('.owl-ads2').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 8000,
    autoplaySpeed:1000,
    dots:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1,
        },
        1000:{
            items:1
        }
    }
});

$('.owl-work-team-migration').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    nav:false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 8000,
    autoplaySpeed:5000,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:7
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
   $(".cbox-package-count-passenger-js").click(e => {
      e.stopPropagation()
   })
   $("body").click(() => {
      $(".cbox-package-count-passenger-js").hide()
   })

   // if($(window).width() > 576){
   //     $('#Flight-internal-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/u1.jpg")');
   //     });
   //     $('#Flight-international-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/356198391214474779airline.jpg")');
   //     });
   //     $('#Hotel-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/hotel-bg-js.jpg")');
   //     });
   //     $('#Bus-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/bus4.jpg")');
   //     });
   //     $('#Train-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/train6.jpg")');
   //     });
   //     $('#Insurance-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/bimeh-bg-js.jpg")');
   //     });
   //     $('#Tour-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/364496210tour.jpg")');
   //     });
   //     $('#Package-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/bg-hotelParvaz.jpg")');
   //     });
   //     $('#Entertainment-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/tafrihat-bg-js.jpg")');
   //     });
   //     $('#Europcar-tab').click(function (){
   //         $('.banner-safiran').css('background-image', 'url("images/bg-car.jpg")');
   //     });
   // }
   $(".top__user_menu").bind("click", function (e) {
      //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
      e.stopPropagation()
   })

   $(".main-navigation__button2").click(function () {
      $(".main-navigation__sub-menu2").fadeToggle(function () {
         $("button-chevron-2").toggle()
      })
      $(".button-chevron-2").toggleClass("rotate")
   })
   $("body").click(function () {
      $(".main-navigation__sub-menu").hide()
      $(".button-chevron").removeClass("rotate")

      $(".cbox-count-nafar").hide()
      $(this).parents().find(".down-count-nafar").removeClass("fa-caret-up")
   })
   $(document).ready(function () {
      $(".top__user_menu").bind("click", function (e) {
         //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
         e.stopPropagation()
      })

      $("body").click(function () {
         $(".main-navigation__sub-menu2").hide()

         $(".button-chevron-2").removeClass("rotate")

         $(".cbox-count-nafar").hide()
         $(this).parents().find(".down-count-nafar").removeClass("fa-caret-up")
      })

      $(".main-navigation__button").click(function () {
         $(".main-navigation__sub-menu").fadeToggle()
         $(this).find(".button-chevron").toggleClass("rotate")
         $(".main-navigation__sub-menu2").hide()
         $(".button-chevron-2").removeClass("rotate")
      })
      var iframe = $("#loginedname").contents()
      iframe.find("span").on("click", function () {
         $(".main-navigation__item")
            .find(".main-navigation__sub-menu2")
            .toggle()
         $(".button-chevron-2").toggleClass("rotate")
      })

      $(".main-navigation__button2").click(function () {
         $(".button-chevron-2").toggleClass("rotate")
      })

      function formatState(state) {
         if (!state.id) {
            return state.text
         }
         var baseUrl = "/user/pages/images/flags"
         var $state = $(
            '<span class="city_start"><i class="fa fa-map-marker-alt"></i>' +
               state.text +
               "</span>"
         )
         return $state
      }

      $(".select2_in").select2({
         templateResult: formatState,
      })
   })

   $(".stop-propagation").bind("click", function (e) {
      e.stopPropagation()
   })
});


const tourPlusHotelRadio = document.getElementById('rdo-50');
const internalTourRadio = document.getElementById('rdo-40');

const tourPlusHotelInfo = document.getElementById('Package');
const internalTourInfo = document.getElementById('internalTourInfo');

function updateDisplay() {
    if (tourPlusHotelRadio.checked) {
        tourPlusHotelInfo.classList.add('flex');
        internalTourInfo.classList.remove('flex');
    } else if (internalTourRadio.checked) {
        internalTourInfo.classList.add('flex');
        tourPlusHotelInfo.classList.remove('flex');
    }
}

tourPlusHotelRadio.addEventListener('change', updateDisplay);
internalTourRadio.addEventListener('change', updateDisplay);


updateDisplay();

