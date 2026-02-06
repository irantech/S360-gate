$(document).ready(function (){
    // if(window.location.hash === "#hotel-tab"){
    //     $("#hotel-tab").trigger("click");
    // };
    // $(".link_flight").click(function(){
    //     $('html, body').animate({
    //         scrollTop: $("#myTab").offset().top
    //     }, 2000);
    //     $("#hotel-tab").trigger("click");
    // });


    $(".main-navigation__button2").click(function (e) {
        e.stopPropagation()
        $(".main-navigation__sub-menu2").toggleClass("d-flex")
    })
    $("body").click(function () {
        $(".main-navigation__sub-menu2").removeClass("d-flex")
    })

    $("#scroll-top").hide();
    // fade in #back-top
    $(function () {
        $('#scrollTop').fadeOut();

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scrollTop').fadeIn();
            } else {
                $('#scrollTop').fadeOut();
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

        let sctop = $(this).scrollTop();

        if(sctop > 20){
            $('#header').addClass('fixedmenu');
        }
        else{
            $('#header').removeClass('fixedmenu');
        }
    });
    $(document).ready(function(){
// menu scroll bottom
        $('.fixicone').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
        var header = $('.header_area'),
            headerHeight = header.height(),
            treshold = 0,
            lastScroll = 0;

        $(document).on('scroll', function (evt) {
            var newScroll = $(document).scrollTop(),
                diff = newScroll-lastScroll - 10;

            // normalize treshold range
            treshold = (treshold+diff>headerHeight) ? headerHeight : treshold+diff;
            treshold = (treshold < 0) ? 0 : treshold + 10;

            header.css('top', (-treshold)+'px');

            lastScroll = newScroll;
        });
    });
});
//iframe register
$('.stop-propagation').bind('click', function (e) {
    e.stopPropagation();
});
