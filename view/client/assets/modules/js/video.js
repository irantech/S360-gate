$('.owl-mobile').owlCarousel({
  rtl:true,
  loop:true,
  margin:5,
  nav:false,
  navText: ["<span class='fas fa-chevron-right'></span>","<span class='fas fa-chevron-left'></span>"],
  autoplay: true,
  autoplayTimeout: 5000,
  autoplaySpeed:3000,
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
function search(elm) {
  var count = $(elm).val().length;
  var val = $(elm).val().trim();
  var res = val.toLowerCase();
  // var words = document.body.innerText;
  var words = $('a').text();
  var words = words.toLowerCase();
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

