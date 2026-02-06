$(document).ready(function () {
    $('#number_of_passengers').on('change', function (e) {

        var itemInsu = $(this).val();

        itemInsu++;
        var HtmlCode = "";
        $(".nafaratbime").html('');

        var i = 1;
        while (i < itemInsu) {

            HtmlCode += "<div class=' col-searchi_ nafarat-bime m-t-8 '>" +

                "<input placeholder=' تاریخ تولد مسافر  " + i + "' type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar in-tarikh '  />" +

                "</div>";
            i++;
        }

        $(".nafaratbime ").append(HtmlCode);
    });


    $(".select2").select2();

//  $('.blackContainer,.close-p').click(function(){
// $('.blackContainer').fadeOut();
// $('.pop-up').fadeOut();
//  })

    // ===== Back to top scroll =====
    $(document).scroll(function () {
      var y = $(window).scrollTop();
      if (y > 300) {
        $('.backToTop').fadeIn('slow');
      } else {
        $('.backToTop').fadeOut('slow');
      }
    });

    $(".backToTop").click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
    });

    // ===== Menu =====



    $('a.mobMenu').click (function(){
            $('.mainMenuContainer').animate({
                right:0
            },700);
        });
    $('.close-menu').click (function(){
            $('.mainMenuContainer').animate({
                right:-545
            },700);
        });

    $('.sp-inner h5').click(function(){
        $(this).parent().find('.sp-box').slideToggle();
    })



	// first sub menu
    if ($("ul.mainMenu > li").has("ul.subMenu")) {
        $("ul.mainMenu > li").has("ul.subMenu").children("a").prepend( "<span>+</span>" );
    }
    if ($("ul.mainMenu > li ul.subMenu li").has("ul")) {
        var thisParent2=$("ul.mainMenu > li ul.subMenu li").has('ul').parent();

        $("ul.mainMenu > li ul.subMenu li").has("ul").children("a").prepend( "<span>+</span>" );
    }


    if ($(window).width() <992 ) {
    $(".mainMenu > li").find('>a').click(function (e) {
        var mainItem=$(this).parent();
        if($(this).parent().find('>ul'))
        {
            mainItem.find('>.subMenu').slideToggle();
        }
    });
    $('ul.mainMenu > li ul.subMenu li a').click(function(){
        var thisParent= $(this).parent();
        thisParent.find('ul').slideToggle();
    });

	}
	// second sub menu
    if ($("ul.mainMenu > li").has("ul.subMenu")) {
        $("ul.mainMenu > li").has("ul.subMenu").find(".subsubMenu").prev("a").prepend( "<span>+</span>" );
        $(".sp-inner h5").prepend( "<span>+</span>" );
    }


	// ===== Menu Fix to Top =====
      if ($(window).width() >545)
        {  $(document).scroll(function () {
          var y = $(window).scrollTop();
          if (y > 5) {
            $('header').addClass('menu-fix');

          } else {
            $('header').removeClass('menu-fix');

          }
        });

}

});