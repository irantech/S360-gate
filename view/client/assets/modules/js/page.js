$(".owl-gallery-page").owlCarousel({
   nav: false,
   dots: true,
   rtl: true,
   loop: false,
   margin: 10,
   navText: [
      "<i class='fas fa-chevron-right'></i>",
      "<i class='fas fa-chevron-left'></i>",
   ],
   autoplay: true,
   autoplayTimeout: 5000,
   autoplaySpeed: 3000,
   responsive: {
      0: {
         items: 1,
         nav: false,
      },
      600: {
         items: 3,
         nav: false,
      },
      1000: {
         items: 5,
      },
   },
})


