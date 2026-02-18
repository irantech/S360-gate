$('.owl-news').owlCarousel({
  rtl:true,
  loop:true,
  navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
  margin:10,
  nav:false,
  dots:true,
  autoplay: true,
  autoplayTimeout: 5000,
  autoplaySpeed:3000,
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
})