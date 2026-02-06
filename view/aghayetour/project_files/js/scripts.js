



$(document).ready(function () {



    var heiw = $(window).height();
    var heiheader = $('.header_area').height();


    $('.content_').css('min-height' , heiw);

    var winh = $(window).width();

    if($(window).width() > 990){

        $('.banner').css('height' ,heiw - heiheader);
    }

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
        $('#scroll-top button').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });



    $(window).scroll(function () {

        var sctop = $(this).scrollTop();

        if(sctop > 50){


            $('.header_area').addClass('fixedmenu');


        }
        else{

            $('.header_area').removeClass('fixedmenu');


        }


    });






    $('.carousel').carousel({
        interval: 4000
    });




    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });

    $('.box-of-count-nafar').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });

    $('body').click(function () {

        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });




});