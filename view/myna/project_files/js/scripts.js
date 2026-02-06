 $('.c-header__btn').click(function () {
     $('.main-navigation__sub-menu2').toggleClass('active_log');
 });
 $('.menu-login').bind('click', function(e){
     //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
     e.stopPropagation();
 });

$('body').click(function () {

    $('.main-navigation__sub-menu2').removeClass('active_log');
})
$(document).ready(function (){
    setTimeout(function(){
        $('.nav-menus-wrapper').removeAttr('style');
    }, 1000);
    $(window).scroll(function () {
        var sctop = $(this).scrollTop();
        if (sctop > 50) {
            $('.header_area').addClass('fixedmenu');
            $('.logo_top_right').show();
        }
        else {
            $('.header_area').removeClass('fixedmenu');
            $('.logo_top_right').hide();
        }
    });
})






