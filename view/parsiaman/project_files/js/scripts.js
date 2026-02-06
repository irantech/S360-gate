$(document).ready(function () {
    $('.c-header__btn').click(function () {
        $('.main-navigation__sub-menu2').toggleClass('active_log');
    });

    $('.menu-login').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();
    });

    $('#divCityHotelLocalLists').bind('click', function (e) {
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();
    });
    $('body').click(function () {
        $('.main-navigation__sub-menu2').removeClass('active_log');
    })
    window.onload = function(){
        setTimeout(function(){
                $('.loading_pars').fadeOut()},
            500);

    };


    $(this).keypress(function (e) {
        if (e.which === 115 || e.which === 1587) {
            $('#Search_modal').modal();

        }
    });
    $('.flat_search').click(function () {
        $('#Search_modal').modal()
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(".languages_header button").click(function (e) {
        $(".languages_header ul").toggleClass("activeLang");
        e.stopPropagation();
    })
    $('body').click(function () {
        $(".languages_header ul").removeClass("activeLang");
    })

})



$(window).scroll(function () {


    let sctop = $(this).scrollTop();

    if (sctop > 46) {


        $('.header_area').addClass('fixedmenu');


    } else {

        $('.header_area').removeClass('fixedmenu');


    }


});
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
    $('#scroll-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
    });
});




// position we will use later ,
var lat = 35.803188874298144;
var lon = 51.4388426597446;
// initialize map
map = L.map('gmap').setView([lat, lon], 15);
// set map tiles source

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '',
    maxZoom: 20,
    minZoom: 14,
}).addTo(map);
// add marker to the map
marker = L.marker([lat, lon]).addTo(map);
// add popup to the marker
marker.bindPopup("ParsiaMan").openPopup();


