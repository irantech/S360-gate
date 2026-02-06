$(document).ready(function () {
    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('body').click(function () {
        $('.main-navigation__sub-menu2').hide();
        $('.button-chevron-2').removeClass('rotate');
        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });
    $('.main-navigation__button').click(function () {
        $('.main-navigation__sub-menu').fadeToggle();
        $(this).find('.button-chevron').toggleClass('rotate');
        $('.main-navigation__sub-menu2').hide();
        $('.button-chevron-2').removeClass('rotate');
    });
    var iframe = $('#loginedname').contents();
    iframe.find('span').on('click', function() {
        $('.main-navigation__item').find('.main-navigation__sub-menu2').toggle();
        $('.button-chevron-2').toggleClass('rotate');

    });
    $('.main-navigation__button2').click(function () {


        $('.main-navigation__sub-menu2').fadeToggle(function () {
            $('button-chevron-2').toggle();
        });
        $('.button-chevron-2').toggleClass('rotate');

    });
});