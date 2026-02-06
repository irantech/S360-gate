$('.owl-mobile').owlCarousel({
  rtl:true,
  loop:true,
  margin:5,
  nav:true,
  navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M85.14 475.8c-3.438-3.141-5.156-7.438-5.156-11.75c0-3.891 1.406-7.781 4.25-10.86l181.1-197.1L84.23 58.86c-6-6.5-5.625-16.64 .9062-22.61c6.5-6 16.59-5.594 22.59 .8906l192 208c5.688 6.156 5.688 15.56 0 21.72l-192 208C101.7 481.3 91.64 481.8 85.14 475.8z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z\"/></svg>"],
  autoplay: true,
  autoplayTimeout: 5000,
  autoplaySpeed:3000,
  dots:false,
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

function search(elm) {
  var count = $(elm).val().length;
  var val = $(elm).val().trim().charAt(0).toUpperCase() + $(elm).val().trim().slice(1);
  val = val.trim();
  // var res = val.toLowerCase();
  var res = val;
  var words = document.body.innerText;
  // var words = $('a').text();
  // var words = words.toLowerCase();
  words = words.replace(/\n/g, " "); //Remove line breaks
  words = words.split(",");
  var str1 = new String(words);
  var result = str1.indexOf(val);
  $(elm).parent().parent().parent().parent().find("div#citySearch a").hide();
  if (count > 1) {
    $(elm).parent().parent().parent().parent().find("div#citySearch a").hide();
    var elms = $(elm).parent().parent().parent().parent().find("div#citySearch a h2:contains(" + res + ")");
    if (result > 0){
      elms.parent().show();
      $('#citySearchRes').css({display: 'none'});
    }else {
      $('#citySearchRes').css({display: 'block'});
    }
  } else {
    $('#citySearchRes').css({display: 'none'});
    $(elm).parent().parent().parent().parent().find("div#citySearch a").show();
  }
}
function clickScroll(e){
  $("html").animate({
    scrollTop: $(`#${e}`).offset().top - 10
  }, 1000);
}

