$(document).ready(function () {
    $('.close_room').click(function (e){
        e.stopPropagation();
        $(".hotel_local-rooms").removeClass('active_p');
    });
    $('.international-close-room-js').click(function (e){
        e.stopPropagation();
        $(".international-my-hotels-rooms-js").removeClass('active_p');
    });

    if($(window).width() > 992){
        $(window).scroll(function () {
            var sctop = $(this).scrollTop();
            if(sctop > 0){
                $('#navbar').addClass('fixedmenu');
            }
            else{
                $('#navbar').removeClass('fixedmenu');
            }
        });
    }

    $('.owl-blog').owlCarousel({
        loop:true,
        rtl:true,
        margin:20,
        nav:true,
        navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d=\"M89.45 87.5l143.1 152c4.375 4.625 6.562 10.56 6.562 16.5c0 5.937-2.188 11.87-6.562 16.5l-143.1 152C80.33 434.1 65.14 434.5 55.52 425.4c-9.688-9.125-10.03-24.38-.9375-33.94l128.4-135.5l-128.4-135.5C45.49 110.9 45.83 95.75 55.52 86.56C65.14 77.47 80.33 77.87 89.45 87.5z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d=\"M166.5 424.5l-143.1-152c-4.375-4.625-6.562-10.56-6.562-16.5c0-5.938 2.188-11.88 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.9375c9.688 9.125 10.03 24.38 .9375 33.94l-128.4 135.5l128.4 135.5c9.094 9.562 8.75 24.75-.9375 33.94C190.9 434.5 175.7 434.1 166.5 424.5z\"/></svg>"],
        dots:false,
        autoplay:true,
        autoplayTimeout:3500,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            768:{
                items:2
            },
            1000:{
                items:3
            },
            1200:{
                items:4
            }
        },
        stagePadding: 50,
    })
    $('.owl-hotel').owlCarousel({
        loop:true,
        rtl:true,
        margin:20,
        nav:false,
        dots:true,
        autoplay:true,
        autoplayTimeout:3500,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:3
            },
            1200:{
                items:4
            }
        },
    })
});