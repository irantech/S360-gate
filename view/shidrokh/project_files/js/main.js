
	$(document).ready(function() {

		$('.plane').click(function(){

			$([document.documentElement, document.body]).animate({
				scrollTop: $(".container-fluid.fit").offset().top -15
			}, 1000);
		})

	$(".camel svg").click(function() {
		$([document.documentElement, document.body]).animate({
			scrollTop: $(".main-search").offset().top -10
		}, 1000);
	});

		$('.select2').select2({

		});
		<!--select oneway toway-->
		$('.multiselectportal').click(function () {
			if($("input[name='select-rb']:checked").val() == '1'){
				$('.checktest1').prop("disabled", "disabled");
			} else{
				$('.checktest1').removeAttr("disabled");
			}
		});
		$('.select_multiway').click(function () {
			if($("input[name='select-rb2']:checked").val() == '1'){
				$('.checktest').prop("disabled", "disabled");
			} else{
				$('.checktest').removeAttr("disabled");
			}
		});
		$('.radioChangeStations').click(function () {
			if($("input[name='changeStations']:checked").val() == 'sourceStations'){
				$('#destStationId').prop("disabled", "disabled");
			} else{
				$('#destStationId').removeAttr("disabled");
			}
		});

		$(".plus-nafar").click(function () {
			var nafar = $(this).siblings(".number-count").attr('data-number');
			if (nafar < 9) {
				var newnafar = ++nafar;
				$(this).siblings(".number-count").html(newnafar);
				$(this).siblings(".number-count").attr('data-number', newnafar);
				var whathidden = $(this).siblings(".number-count").attr('data-value');
				$("." + whathidden).val(newnafar);

			}
			var nafarbozorg = Number($(this).parents(".search-tab-inner").find(".bozorg-num .number-count").attr('data-number'));
			var nafarkoodak = Number($(this).parents(".search-tab-inner").find(".koodak-num .number-count").attr('data-number'));
			var nafarnozad = Number($(this).parents(".search-tab-inner").find(".nozad-num .number-count").attr('data-number'));
			var tedad = nafarbozorg + nafarkoodak + nafarnozad;
			$(this).parents(".search-tab-inner").find(".text-count-nafar").text(tedad + " مسافر ");
		});
		$(".minus-nafar").click(function () {
			var nafar = $(this).siblings(".number-count").attr('data-number');

			var nmin = $(this).siblings(".number-count").attr('data-min');
			if (nafar > nmin) {
				var newnafar = --nafar;
				$(this).siblings(".number-count").html(newnafar);
				$(this).siblings(".number-count").attr('data-number', newnafar);
				var whathidden = $(this).siblings(".number-count").attr('data-value');
				$("." + whathidden).val(newnafar);
			}
			var nafarbozorg2 = Number($(this).parents(".search-tab-inner").find(".bozorg-num .number-count").attr('data-number'));
			var nafarkoodak2 = Number($(this).parents(".search-tab-inner").find(".koodak-num .number-count").attr('data-number'));
			var nafarnozad2 = Number($(this).parents(".search-tab-inner").find(".nozad-num .number-count").attr('data-number'));
			var tedad2 = nafarbozorg2 + nafarkoodak2 + nafarnozad2;
			$(this).parents(".search-tab-inner").find(".text-count-nafar").text(tedad2 + " مسافر ");
		});
		$(".box-of-count-nafar-boxes").click(function () {
			$(this).siblings(".cbox-count-nafar").toggle();
		});
		$('.box-of-count-nafar').bind('click', function(e){
			//as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
			e.stopPropagation();

		});
		$('#number_of_passengers').on('change', function (e) {

			var itemInsu = $("#number_of_passengers").val();

			itemInsu++;
			var HtmlCode = "";
			$(".nafarat-bime").remove();

			var i = 1;
			while (i < itemInsu) {
				HtmlCode += "<div class='search_item nafarat-bime'>" +
					"<input type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='shamsiBirthdayCalendar search_input'  placeholder=' تولد نفر  " + i + "' /></div>" +
					"</div>";
				i++;
			}

			$(".nafaratbime").append(HtmlCode);
		});
		$('body').click(function () {


			$('.cbox-count-nafar').hide();
			$(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
		});

		$(".parvaz_charter").click(function() {
			$([document.documentElement, document.body]).animate({
				scrollTop: $(".masir-section").offset().top -15
			}, 1000);
		});
		$('input:radio[name="radio_gasht"]').change(
			function () {
				if (this.checked && this.value == '1') {
					$('#gasht_div').css('display', 'flex');
					$('#transfer_div').css('display', 'none');

				}
				else {
					$('#gasht_div').css('display', 'none');
					$('#transfer_div').css('display', 'flex');
				}
			});
		$('input:radio[name="DOM_TripMode5"]').change(
			function(){
				if (this.checked && this.value == '1') {
					$('#tour_khareji').css('display','flex');
					$('#tour_dakheli').hide();
				}
				else {
					$('#tour_khareji').hide();
					$('#tour_dakheli').css('display','flex');
				}
			});
		$('input:radio[name="DOM_TripMode6"]').change(
			function(){
				if (this.checked && this.value == '1') {
					$('#tour_khareji2').css('display','flex');
					$('#tour_dakheli2').hide();
				}
				else {
					$('#tour_khareji2').hide();
					$('#tour_dakheli2').css('display','flex');
				}
			});
	//side bar menu
	$(".hamburger").click(function() {

		$(".background-modal-box").hide();
	if($(".side-mobile-mnu").hasClass('show')){
		$(".side-mobile-mnu").removeClass('show');
		$(".side-mobile-mnu").animate({
			right: '-245px'
		});
	}else{
		$(".background-modal-box").show();
		$(".side-mobile-mnu").addClass('show');
		$(".side-mobile-mnu").animate({
			right: '0px'
		});
	}

});
//side bar menu
	$(".menu-item-mobile ul").hide();
	$(".hide-in-default").hide();
	$(".has-menu").click(function() {
		$(this).siblings("ul").toggle();
		$(this).children(".drop-down-icon").toggle();
	});
	if ($(window).width() < 768) {
		$("#main-search").removeClass('d-none d-md-block');
		$("#main-search").addClass('menu-button-section hidden-lg-up');
		$("#main-search").find('ul').addClass('padding-0 font-size-16 menu-item-mobile nav-menu');
		$("#bg-xs").addClass('side-mobile-mnu hidden-lg-up nav-menus-wrapper nav-menus-wrapper-open');
		$("#closeNav").click(function(){
			$('.background-modal-box').hide();
			$(".side-mobile-mnu").animate({
				right: '-245px'
			});
		});
	}

	$(".menu-button-section").find('li a').click(function() {
		if($(this).siblings('.dropdown-xs').hasClass('active')){
			$(this).siblings('.dropdown-xs').removeClass('active');
			$(this).siblings('.dropdown-xs').css('display','none');
			$(this).siblings('.dropdown-xs').find('ul').css('display','none');
		}else{
			$(this).siblings('.dropdown-xs').addClass('active');
			$(this).siblings('.dropdown-xs').css('display','block');
			$(this).siblings('.dropdown-xs').find('ul').css('display','block');
		}
	});
});



	function ToggleTools(n) {
	$(n).hasClass("open") ? $(n).removeClass("open") : (CloseTools(), ToggleOpen(n))
}
	function CloseTools() {
	$(".tools li").removeClass("open");
}
	function ToggleOpen(n) {
	$(n).hasClass("open") ? $(n).removeClass("open") : $(n).addClass("open")
}
	$(document).ready(function() {


	$('input:radio[name="select-rb"]').change(function () {
		if ($(this).val() == 'yektarafe') {
			if(!$(".bargasht-date").hasClass("disabled")) {
				$(".bargasht-date").addClass("disabled");
			}
		} else {
			if($(".bargasht-date").hasClass("disabled")) {
				$(".bargasht-date").removeClass("disabled");
			}
		}
	});
	$('.select_multiway').click(function () {
	if($("input[name='select-rb']:checked").val() == '1'){
	$('.checktest').prop("disabled", "disabled");
} else{
	$('.checktest').removeAttr("disabled");
}
});

	$('#number_of_passengers').on('change', function(e) {
	var itemInsu = $("#number_of_passengers").val();

	itemInsu++;
	var HtmlCode = "";
	$(".nafarat-bime").remove();

	var i = 1;
	while (i < itemInsu) {
	HtmlCode += "<div class='search_item nafarat-bime'>" +
	"<input type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='txtBirthdayCalendar search_input' placeholder=' تولد نفر  " + i + "' /></div>" +
	"</div>";
	i++;
}

	$(".nafaratbime").append(HtmlCode);
});
		$('input:radio[name="DOM_TripMode5"]').change(
			function(){
				if (this.checked && this.value == '1') {
					$('#tour_khareji').css('display','flex');
					$('#tour_dakheli').hide();
				}
				else {
					$('#tour_khareji').hide();
					$('#tour_dakheli').css('display','flex');
				}
			});

	js_height_init();


	function js_height_init() {
	(function($) {
	var height = $(window).height();
	$(".carousel-item").height(height);
})(jQuery);
}

	$(window).scroll(function() {
	headerFromTop = $(window).height() - 154;
	headerFromTop2 = $(window).height() - 58;
	scrollFromTop = $(document).scrollTop();
	scrollFromTop >= headerFromTop ? $(".tools").addClass("displayc") : $(".tools").removeClass("displayc");
	scrollFromTop >= headerFromTop2 ? $("header").addClass("fixed") : $("header").removeClass("fixed");
	scrollFromTop2 = $(document).scrollTop();
	heightLeft = $(window).height() - 58 - scrollFromTop2;
	destinationHeight = $(".nav ul li.has-sub:first-child").outerHeight(!0);
	destinationHeight > heightLeft ? $(".nav ul li.has-sub:first-child .mega-menu").addClass("up") : $(".nav ul li.has-sub:first-child .mega-menu").removeClass("up");
	destinationHeight2 = $(".nav ul li.has-sub:nth-child(2)").outerHeight(!0);
	destinationHeight2 > heightLeft ? $(".nav ul li.has-sub:nth-child(7) .mega-menu").addClass("up") : $(".nav ul li.has-sub:nth-child(2) .mega-menu").removeClass("up");
	destinationHeight5 = $(".nav ul li.has-sub:nth-child(5)").outerHeight(!0);
	destinationHeight5 > heightLeft ? $(".nav ul li.has-sub:nth-child(5) .mega-menu").addClass("up") : $(".nav ul li.has-sub:nth-child(5) .mega-menu").removeClass("up");
	destinationHeight6 = $(".nav ul li.has-sub:nth-child(6)").outerHeight(!0);
	destinationHeight6 > heightLeft ? $(".nav ul li.has-sub:nth-child(6) .mega-menu").addClass("up") : $(".nav ul li.has-sub:nth-child(6) .mega-menu").removeClass("up");
	destinationHeight4 = $(".nav ul li.has-sub:nth-child(4)").outerHeight(!0);
	destinationHeight4 > heightLeft ? $(".nav ul li.has-sub:nth-child(4) .sub-menu").addClass("up") : $(".nav ul li.has-sub:nth-child(4) .sub-menu").removeClass("up");
});




});




$(document).ready(function () {


	var header = $('.header');
	var menuActive = false;
	setHeader();

	$(window).on('resize', function () {
		setHeader();
	});

	$(document).on('scroll', function () {
		setHeader();
	});


	function setHeader() {
		if (window.innerWidth < 992) {
			if ($(window).scrollTop() > 100) {
				header.addClass('scrolled');
			} else {
				header.removeClass('scrolled');
			}
		} else {
			if ($(window).scrollTop() > 100) {
				header.addClass('scrolled');
			} else {
				header.removeClass('scrolled');
			}
		}
		if (window.innerWidth > 991 && menuActive) {
			closeMenu();
		}
	}







	if ($('.home_slider').length) {
		var homeSlider = $('.home_slider');

		homeSlider.owlCarousel({
			items: 1,
			loop: true,
			autoplay: false,
			smartSpeed: 1200,
			dotsContainer: 'main_slider_custom_dots'
		});

		/* Custom nav events */
		if ($('.home_slider_prev').length) {
			var prev = $('.home_slider_prev');

			prev.on('click', function () {
				homeSlider.trigger('prev.owl.carousel');
			});
		}

		if ($('.home_slider_next').length) {
			var next = $('.home_slider_next');

			next.on('click', function () {
				homeSlider.trigger('next.owl.carousel');
			});
		}

		/* Custom dots events */
		if ($('.home_slider_custom_dot').length) {
			$('.home_slider_custom_dot').on('click', function () {
				$('.home_slider_custom_dot').removeClass('active');
				$(this).addClass('active');
				homeSlider.trigger('to.owl.carousel', [$(this).index(), 300]);
			});
		}

		/* Change active class for dots when slide changes by nav or touch */
		homeSlider.on('changed.owl.carousel', function (event) {
			$('.home_slider_custom_dot').removeClass('active');
			$('.home_slider_custom_dots li').eq(event.page.index).addClass('active');
		});

		// add animate.css class(es) to the elements to be animated
		function setAnimation(_elem, _InOut) {
			// Store all animationend event name in a string.
			// cf animate.css documentation
			var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

			_elem.each(function () {
				var $elem = $(this);
				var $animationType = 'animated ' + $elem.data('animation-' + _InOut);

				$elem.addClass($animationType).one(animationEndEvent, function () {
					$elem.removeClass($animationType); // remove animate.css Class at the end of the animations
				});
			});
		}

		// Fired before current slide change
		homeSlider.on('change.owl.carousel', function (event) {
			var $currentItem = $('.home_slider_item', homeSlider).eq(event.item.index);
			var $elemsToanim = $currentItem.find("[data-animation-out]");
			setAnimation($elemsToanim, 'out');
		});

		// Fired after current slide has been changed
		homeSlider.on('changed.owl.carousel', function (event) {
			var $currentItem = $('.home_slider_item', homeSlider).eq(event.item.index);
			var $elemsToanim = $currentItem.find("[data-animation-in]");
			setAnimation($elemsToanim, 'in');
		})
	}
	var menu = $('.menu');
	var menuActive = false;
	initMenu();

	function initMenu() {
		if ($('.hamburger').length && $('.menu').length) {
			var hamb = $('.hamburger');
			var close = $('.menu_close_container');

			hamb.on('click', function () {
				if (!menuActive) {
					openMenu();
				} else {
					closeMenu();
				}
			});

			close.on('click', function () {
				if (!menuActive) {
					openMenu();
				} else {
					closeMenu();
				}
			});


		}
	}

	function openMenu() {
		menu.addClass('active');
		menuActive = true;
	}

	function closeMenu() {
		menu.removeClass('active');
		menuActive = false;
	}





});
