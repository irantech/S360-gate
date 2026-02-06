// JavaScript Document

 $(document).ready(function(){
	   $(window).bind('scroll', function() {
		   
	   var navHeight = $( window ).height() -100;
			 if ($(window).scrollTop() < navHeight) {
				 //alert('a');
				 $('nav').addClass('fixed');
			 }
			 else {
				 //alert($(window).scrollTop()+'hhh'+navHeight);
				 $('nav').removeClass('fixed');
			 }
		});
	});