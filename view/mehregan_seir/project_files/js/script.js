(function (document) {

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

    
    
    // ===== Close enamad Text =====
    $('.closeEnamad').click(function (event) {
        event.preventDefault();
        $(this).parent().fadeOut('slow');
    });
    //======social button===============
    // $('.socialbox').click(function(){
    //     $('.socialbox').css('left','0');
    // });
    
    // ===== PopUp Box with clicking =====
    // Showing Box
    $('.package-btn').click(function (e) {
        e.preventDefault();
        $(".blackContainer").fadeIn('slow');
        $(".package-popup").fadeIn('slow');
    });
    $('.customer-btn').click(function (e) {
        e.preventDefault();
        $(".blackContainer").fadeIn('slow');
        $(".customer-popup").fadeIn('slow');
    });
    // Hiding Box when Click on Close Button
    $(".btnClosep").click(function () {
        $(".blackContainer").fadeOut('slow');
        $(".package-popup").fadeOut('fast');

    });
    $(".btnClosec").click(function () {
        $(".blackContainer").fadeOut('slow');
        $(".customer-popup").fadeOut('fast');

    });
    // Hiding Box when Click on Black Area
    $(".blackContainer").click(function () {
        $(".blackContainer").fadeOut('slow');
         $(".customer-popup").fadeOut('fast');
        $(".package-popup").fadeOut('fast');
    });
    // Hiding Box when Pressing Esc Key
    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            $(".blackContainer").fadeOut('slow');
             $(".customer-popup").fadeOut('fast');
        $(".package-popup").fadeOut('fast');
        } else { }
    

    });
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
    $("a.mobMenu").click(function (e) {
        $("ul.mainMenu").slideToggle();
    });
    
    if ($(window).width() > 768) {
        $("ul.mainMenu").slideDown();
    } else {
        $("ul.mainMenu").slideUp();
    }
    
    $(window).resize(function(){
        if ($(window).width() > 768) {
            $("ul.mainMenu").slideDown();
        } else {
            $("ul.mainMenu").slideUp();
        }
    });
    
	// first sub menu
    if ($("ul.mainMenu > li").has("ul.subMenu")) {
        $("ul.mainMenu > li").has("ul.subMenu").children("a").prepend( "<span>+</span>" );
    }
    if ($("ul.mainMenu > li ul.subMenu li").has("ul")) {
        var thisParent2=$("ul.mainMenu > li ul.subMenu li").has('ul').parent();
        
        $("ul.mainMenu > li ul.subMenu li").has("ul").children("a").prepend( "<span>+</span>" );
    }


    if ($(window).width() <768 ) {
    $(".mainMenu > li").find('a').click(function (e) {
        var mainItem=$(this).parent();
        if($(this).parent().find('ul'))
        {
            mainItem.find('.subMenu').slideToggle();
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
    }
    $(".subMenu > li").find('a').click(function (e) {
        var subItem=$(this).parent();
        // $('ul.mainMenu>li').has('ul.subMenu').slideUp();
        if($(this).parent().find('ul'))
        {
            subItem.find('.subsubMenu').slideToggle();
        }
    });
	
	// ===== search btn =====
    $('.search-btn').click(function() {
    	var origin = $('#origin').val();
    	var destination = $('#destination').val();
    	if(origin == '' || destination == ''){
    		alert('لطفا مبدا و مقصد مورد نظر را وارد نمایید.');
    		return false;
    	}
    	$('#origin_form').val(origin);
    	$('#destination_form').val(destination);
		$('.ex-form').fadeIn();
		$(".blackContainer").fadeIn('fast');
	});
	$(".blackContainer").click(function() {
		$(".blackContainer").fadeOut('slow');
		$(".ex-form").fadeOut('fast');
	});

    

})(document);