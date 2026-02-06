// RPEPOLOMP
$(document).ready(function () {
    $('body').on('click', '.more_close_matn', function () {
        $(this).parents('.card_matn_').removeClass('show_more');
        $(this).parents('.card_matn_').find('.more_read_matn').show();
        $(this).remove();
    });
    $('.more_read_matn').click(function () {
        $(this).parents('.card_matn_').addClass('show_more');
        $(this).hide();
        $(this).parent('.content_card_matn').append('<button type="button" class="btn btn-primary more_close_matn py-2 px-3">بستن</button>');
    });
    $('.more_read').click(function () {
        $(this).parents('.card_').addClass('show_more');
        $(this).hide();
        $(this).parent('.content_card').append('<a class="more_close">بستن</a>');
    });
    $('body').on('click', '.more_close', function () {
        $(this).parents('.card_').removeClass('show_more');
        $(this).parents('.content_card').find('.more_read').show();
        $(this).remove();
    });
    $('.more_matn').click(function () {
        $(this).parent('.c-card-content').toggleClass('selected');
        $(this).toggleClass('select_btn');

        if ($(this).parent('.c-card-content').hasClass('selected')) {
            $(this).text('بستن')
        } else {
            $(this).text('بیشتر بخوانید')
        }
    });
    setTimeout(function () {
        $('.more_matn').parent().find('.typo__context').each(function () {
            if ($( this ).height() < 210) {
                $( this ).nextAll('span.more_matn').first().hide();
            }
        });
    }, 200);
    $('.more_read_matn').parent().find('.typo__context').each(function () {
        if ($( this ).height() < 90) {
            $( this ).nextAll('button.more_read_matn').first().css({ display: "none" });
        }
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // $(".select2 , .select2BusRouteSearch").select2();
    var heiw = $(window).height();

    $('.banner_main').css('min-height' , heiw);

    $('.temp_content').css('min-height' , heiw);

    var winh = $(window).height();

    if($(window).width() > 767){
        $('.banner').css('height' , winh);
    }
    $('body').click(function () {
        $('.main-navigation__sub-menu2').hide();
    });

    $('.smoothScrollTo').on('click', function () {
        var thiss = $(this);
        if (thiss.hasClass('TabScroll')) {
            smoothScrollFunction(thiss, true);
        } else {
            smoothScrollFunction(thiss, false);
        }
    });
    if (window.location.hash != '') {
        var thiss = $('a[data-target="#' + window.location.hash.replace(/\#/g, '') + '-tab"]');
        if (thiss.length > 0) {
            smoothScrollFunction(thiss);
        } else {
            var thiss = $('a[data-target="' + window.location.hash.replace(/\#/g, '.') + '"]');
            var data_hover = thiss.attr('data-hover');
            if (data_hover != null) {
                var target = data_hover.split(',')[0];
                var new_class = data_hover.split(',')[1];
                $(target).addClass(new_class);
                $(target).mouseout(function () {
                    $(target).removeClass(new_class);
                });
            }
            smoothScrollFunction(thiss, false);
        }
    }
    function smoothScrollFunction(thiss, tab = true) {
        if (tab == true) {

            var target = thiss.attr('data-target');
            $('a[data-toggle="tab"]').each(function () {
                $(this).removeClass('active show');
            });
            $(target).addClass('active show');
            $('#myTabContent div').each(function () {
                $(this).removeClass('active show');
            });
            $('div[aria-labelledby="' + target.replace(/\#/g, '').replace(/\./g, '') + '"]').addClass('active show');
            $.smoothScroll({
                scrollTarget: '#myTab',
                offset: -150
            });
            return false;
        } else {
            $.smoothScroll({
                scrollTarget: thiss.attr('data-target'),
                offset: -150
            });
            var data_hover = thiss.attr('data-hover');
            if (data_hover != null) {
                var target = data_hover.split(',')[0];
                var new_class = data_hover.split(',')[1];
                $(target).addClass(new_class);
                $(target).mouseout(function () {
                    $(target).removeClass(new_class);
                });
            }
        }
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


    $(document).ready(function () {




        var wwidth = $(window).width();
        if (wwidth < 575) {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height11 = sheight + 200;
            $(".js-height-full").height(height11);
        } else {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height1 = wheight - sheight;
            var height = height1 + sheight;
            $(".js-height-full").height(height);
        }
    });



    $('#countRoomPackage').on('change', function (e) {

        var roomCount = $("#countRoomPackage").val();
        createRoomHotelPackage(roomCount);
        $(".mypackage-rooms").find(".myroom-hotel-item").remove();
        var code = createRoomHotelPackage(roomCount);
        $(".mypackage-rooms").append(code);


        var wwidth = $(window).width();
        if (wwidth < 575) {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height11 = sheight + 200;
            $(".js-height-full").height(height11);
        } else {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height1 = wheight - sheight;
            var height = height1 + sheight;
            $(".js-height-full").height(height);
        }
    });


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });


    $('.main-navigation__button').click(function () {

        $('.main-navigation__sub-menu').toggle();
        $('.button-chevron').toggleClass('rotate');

    });

    $('body').click(function () {

        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });
    $('.btn-close').click(function () {
        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');

    })
    $('.myhotels-rooms').on('click', '.close_room', function () {

        $(this).parent().removeClass('active_p');

    });

    /* End select oneway toway */

    function createRoomHotel(roomCount) {

        var HtmlCode = "";
        let i = $('.myroom-hotel-item').length +1;
        let numberText = "اول";
        let valuefirst;


        if (i == 1) {
            numberText = "اول";
            valuefirst = "2"
        } else if (i == 2) {
            numberText = "دوم";
            valuefirst = "1";

        } else if (i == 3) {
            numberText = "سوم";
            valuefirst = "1";

        } else if (i == 4) {
            numberText = "چهارم";
            valuefirst = "1";

        }


        if(i < 5){
            HtmlCode +=
              `<div class="myroom-hotel-item" data-roomNumber="${i}">
             <div class="myroom-hotel-item-title">
             <span class="close">
             <i class="fal fa-trash-alt"></i>
            </span>
            اتاق  ${numberText}
            </div><div class="myroom-hotel-item-info">
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>بزرگسال</h6>
           (بزرگتر از ۱۲ سال)
        <div><i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
        <input readonly class="countParent"  min="0" value="${valuefirst}" max="5" type="number" name="adult${i}" id="adult${i}">
        <i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
        </div>
        </div>
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>کودک</h6>
                                                    (کوچکتر از ۱۲ سال)
        <div>
        <i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus">
        
        </i><input readonly class="countChild" min="0" value="0" max="5" type="number" name="child${i}" id="child${i}">
        <i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
        </div>
        </div><div class="tarikh-tavalods"></div>
        </div>
        </div>`;
        }

        return HtmlCode;
    }

    function createRoomHotelPackage(roomCount) {

        var HtmlCode = "";
        let i = $('.myroom-package-item').length +1;
        let numberText = "اول";
        let valuefirst;


        if (i == 1) {
            numberText = "اول";
            valuefirst = "2"
        } else if (i == 2) {
            numberText = "دوم";
            valuefirst = "1";

        } else if (i == 3) {
            numberText = "سوم";
            valuefirst = "1";

        } else if (i == 4) {
            numberText = "چهارم";
            valuefirst = "1";

        }


        if(i < 5){
            HtmlCode +=
              `<div class="myroom-package-item" data-roomNumber="${i}">
             <div class="myroom-package-item-title">اتاق  ${numberText}
             <span class="close">
             <i class="fal fa-trash-alt"></i>
            </span>
            </div><div class="myroom-package-item-info">
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>بزرگسال</h6>
           (بزرگتر از ۱۲ سال)
        <div><i class="addParent_p plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
        <input readonly class="countParent_p"  min="0" value="${valuefirst}" max="5" type="number" name="adultpackage${i}" id="adultpackage${i}">
        <i class="minusParent_p minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
        </div>
        </div>
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>کودک</h6>
                                                    (کوچکتر از ۱۲ سال)
        <div>
        <i class="addChild_p plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus">
        
        </i><input readonly class="countChild_p" min="0" value="0" max="5" type="number" name="childpackage${i}" id="childpackage${i}">
        <i class="minusChild_p minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
        </div>
        </div><div class="tarikh-tavalods"></div>
        </div>
        </div>`;
        }

        return HtmlCode;
    }



    function createBirthdayCalendar(inputNum, roomNumber) {
        var i = 1;
        var HtmlCode = "";
        let numberTextChild = "سلام";
        while (i <= inputNum) {
            if (i == 1) {
                numberTextChild = "اول";
            } else if (i == 2) {
                numberTextChild = "دوم";
            } else if (i == 3) {
                numberTextChild = "سوم";
            } else if (i == 4) {
                numberTextChild = "چهارم";
            }
            HtmlCode += '<div class="tarikh-tavalod-item">'
              + '<span>سن کودک <i>' + numberTextChild + '</i></span>'
              + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">'
              + '<option value="1">0 تا 1 سال</option>'
              + '<option value="2">1 تا 2 سال</option>'
              + '<option value="3">2 تا 3 سال</option>'
              + '<option value="4">3 تا 4 سال</option>'
              + '<option value="5">4 تا 5 سال</option>'
              + '<option value="6">5 تا 6 سال</option>'
              + '<option value="7">6 تا 7 سال</option>'
              + '<option value="8">7 تا 8 سال</option>'
              + '<option value="9">8 تا 9 سال</option>'
              + '<option value="10">9 تا 10 سال</option>'
              + '<option value="11">10 تا 11 سال</option>'
              + '<option value="12">11 تا 12 سال</option>'
              + '</select>'
              + '</div>';
            i++;
        }

        return HtmlCode;
    };


    $('.owl_tour_local').owlCarousel({
        rtl:true,
        loop:true,
        margin:30,
        nav:true,
        autoplay: true,
        autoplayTimeout: 15000,
        autoplaySpeed:5000,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
            },
            1000:{
                items:4
            }
        }
    });




    // var owl_stour = $('.owl_tour_local');
    // owl_stour.owlCarousel({
    //     rtl: true,
    //     dots:false,
    //     loop: false,
    //     margin: 1,
    //     nav:true,
    //     autoplaySpeed:1000,
    //     autoplay: false,
    //     autoplayTimeout: 4000,
    //     autoplayHoverPause: true,
    //     responsiveClass: true,
    //     responsive: {
    //         0: {
    //             items: 1,
    //             dots:true,
    //             nav:false,
    //         },
    //         600: {
    //             items: 2,
    //         },
    //         1000: {
    //             items: 4,
    //
    //
    //         }
    //     }
    // });



    var owlair = $('#owl-air');
    owlair.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 20,
        nav:false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed:1000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
                dots:true,
                nav:false,

            },
            600: {
                items: 5,

            },
            1000: {
                items: 7,

                margin: 5
            }
        }
    });
    var owl_4 = $('.owl_4');
    owl_4.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 10,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        nav:true,
        autoplaySpeed:1000,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav:false
            },
            600: {
                items: 2,
                dots:true,
                nav:false
            },
            1000: {
                items: 3,
            }
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
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


});

// RPEPOLOMP END


if($(window).width() > 576){

    $('#flight-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/airline.jpg")')});
    $('#hotel-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/hotel.jpg")')});
    $('#tour-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/tour.jpg")')});
    $('#train-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/train.jpg")')});
    $('#bus-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/bus.jpg")')});
    $('#fun-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/tafrih.jpg")')});
    $('#car-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/car.jpg")')});
    $('#visa-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/visa.jpg")')});
    $('#gasht-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/gasht.jpg")')});
    $('#insurance-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/insurance.jpg")')});
    $('#package-tab').click(function () {$('.section_slider').css('background-image' , 'url("images/package.jpg")')});

    $('a[data-target="#flight-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/airline.jpg")')});
    $('a[data-target="#hotel-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/hotel.jpg")')});
    $('a[data-target="#tour-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/tour.jpg")')});
    $('a[data-target="#train-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/train.jpg")')});
    $('a[data-target="#bus-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/bus.jpg")')});
    $('a[data-target="#fun-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/tafrih.jpg")')});
    $('a[data-target="#car-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/car.jpg")')});
    $('a[data-target="#visa-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/visa.jpg")')});
    $('a[data-target="#gasht-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/gasht.jpg")')});
    $('a[data-target="#insurance-tab"]').click(function () {$('.section_slider').css('background-image' , 'url("images/insurance.jpg")')});


}
$('.lang ').bind('click', function(e){
    //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
    e.stopPropagation();
});

$('body').click(function () {
    $('.lang_ul').removeClass('active_lang');
});

$('.lang span').click(function () {
    $('.lang_ul').toggleClass('active_lang');
});

$('.top__user_menu').bind('click', function(e){
    e.stopPropagation();
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$('.box-of-count-nafar').bind('click', function(e){
    //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
    e.stopPropagation();

});
$('.main-navigation__button').click(function () {

    $('.main-navigation__sub-menu').toggle();
    $('.button-chevron').toggleClass('rotate');

});

$('body').click(function () {

    $('.main-navigation__sub-menu').hide();
    $('.button-chevron').removeClass('rotate');

    $('.cbox-count-nafar').hide();
    $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
});
$(document).ready(function () {
    $('.top__user_menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });


    $('.FAQOWL').owlCarousel({
        loop:true,
        rtl:true,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        margin:0,
        nav:false,
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
            1000:{
                items:1
            }
        }
    })
    $('.owl_ads').owlCarousel({
        loop: true,
        rtl: true,
        margin: 10,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        nav: false,
        dots: true,
        responsive: {0: {items: 1}, 600: {items: 1}, 1000: {items: 2}}
    });



});


<!--select oneway toway-->




/*Scripts Packages*/

$('.mypackege-rooms').on('click','.btn_add_room_p', function (e) {
    $('.mypackege-rooms .close').show();


    let roomCount = parseInt($('.myroom-package-item').length) ;

    let numberAdult = parseInt($('.number_adult_p').text() );
    let number_room = parseInt($('.number_room_p').text() );
    $('.number_adult_p').text(numberAdult + 1)
    $('.number_room_p').text(number_room + 1)

    let code = createRoomHotelPackage(roomCount);
    $(".package_select_room").append(code);
    if(roomCount ==3){
        $(this).hide();
    }



});
//hotel local


$('.mypackege-rooms').on('click', '.myroom-package-item .close', function () {

    let babyCountThis =$(this).parents('.myroom-package-item').find('.countChild_p').val();
    let number_baby = $('.number_baby_p').text();
    $('.number_baby_p').text(number_baby - babyCountThis );

    let AdultCountThis =$(this).parents('.myroom-package-item').find('.countParent_p').val();
    let number_adult = $('.number_adult_p').text();
    $('.number_adult_p').text(number_adult - AdultCountThis );

    $('.btn_add_room_p').show();

    let roomNumber = $(this).parents(".myroom-package-item").data("roomnumber");
    let roomCount = $(".myroom-package-item").length;

    let number_room = parseInt($('.number_room_p').text());
    $('.number_room_p').text(number_room - 1)


    $(this).parents(".myroom-package-item").remove();
    let countRoom = parseInt($('#countRoom').val()) - 1;
    $("#countRoom option:selected").prop("selected", false);
    $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
    let numberRoom = 1;
    let numberText = "اول";
    $('.myroom-package-item').each(function () {
        $(this).data("roomnumber", numberRoom);
        if (numberRoom == 1) {
            numberText = "اول";
        } else if (numberRoom == 2) {
            numberText = "دوم";
        } else if (numberRoom == 3) {
            numberText = "سوم";
        } else if (numberRoom == 4) {
            numberText = "چهارم";
        }
        $(this).find('.myroom-package-item-title').html(' اتاق ' + numberText + '<span class="close"><i class="fal fa-trash-alt"></i></span>');
        $(this).find(".myroom-package-item-info").find("input[name^='adult_p']").attr("name", "adult_p" + numberRoom);
        $(this).find(".myroom-package-item-info").find("input[name^='adult_p']").attr("id", "adult_p" + numberRoom);
        $(this).find(".myroom-package-item-info").find("input[name^='child_p']").attr("name", "child_p" + numberRoom);
        $(this).find(".myroom-package-item-info").find("input[name^='child_p']").attr("id", "child_p" + numberRoom);
        let numberChild = 1;
        let inputNameSelectChildAge = $(this).find(".tarikh-tavalods .tarikh-tavalod-item");
        inputNameSelectChildAge.each(function () {
            $(this).find("select[name^='childAge']").attr("name", "childAge" + numberRoom + numberChild);
            $(this).find("select[name^='childAge']").attr("id", "childAge" + numberRoom + numberChild);
            numberChild++;
        });
        numberRoom++;
    });
    if(roomCount == 2){
        $('.myroom-package-item-title .close').hide();
    }


});
//hotel local
$('.hotel_local-rooms').on('click', '.myroom-hotel_local-item .close', function () {

    let babyCountThis =$(this).parents('.myroom-hotel_local-item').find('.countChild_hotel_local').val();
    let number_baby = $('.number_baby_hotel_local').text();
    $('.number_baby_hotel_local').text(number_baby - babyCountThis );

    let AdultCountThis =$(this).parents('.myroom-hotel_local-item').find('.countParent_hotel_local').val();
    let number_adult = $('.number_adult_hotel_local').text();
    $('.number_adult_hotel_local').text(number_adult - AdultCountThis );

    $('.btn_add_room_hotel_local').show();

    let roomNumber = $(this).parents(".myroom-hotel_local-item").data("roomnumber");
    let roomCount = $(".myroom-hotel_local-item").length;

    let number_room = parseInt($('.number_room_hotel_local').text());
    $('.number_room_hotel_local').text(number_room - 1)


    $(this).parents(".myroom-hotel_local-item").remove();
    let countRoom = parseInt($('#countRoom').val()) - 1;
    $("#countRoom option:selected").prop("selected", false);
    $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
    let numberRoom = 1;
    let numberText = "اول";
    $('.myroom-hotel_local-item').each(function () {
        $(this).data("roomnumber", numberRoom);
        if (numberRoom == 1) {
            numberText = "اول";
        } else if (numberRoom == 2) {
            numberText = "دوم";
        } else if (numberRoom == 3) {
            numberText = "سوم";
        } else if (numberRoom == 4) {
            numberText = "چهارم";
        }
        $(this).find('.myroom-hotel_local-item-title').html(' اتاق ' + numberText + '<span class="close"><i class="fal fa-trash-alt"></i></span>');
        $(this).find(".myroom-hotel_local-item-info").find("input[name^='adult_hotel_local']").attr("name", "adult_hotel_local" + numberRoom);
        $(this).find(".myroom-hotel_local-item-info").find("input[name^='adult_hotel_local']").attr("id", "adult_hotel_local" + numberRoom);
        $(this).find(".myroom-hotel_local-item-info").find("input[name^='child_hotel_local']").attr("name", "child_hotel_local" + numberRoom);
        $(this).find(".myroom-hotel_local-item-info").find("input[name^='child_hotel_local']").attr("id", "child_hotel_local" + numberRoom);
        let numberChild = 1;
        let inputNameSelectChildAge = $(this).find(".tarikh-tavalods .tarikh-tavalod-item");
        inputNameSelectChildAge.each(function () {
            $(this).find("select[name^='childAge']").attr("name", "childAge" + numberRoom + numberChild);
            $(this).find("select[name^='childAge']").attr("id", "childAge" + numberRoom + numberChild);
            numberChild++;
        });
        numberRoom++;
    });
    if(roomCount == 2){
        $('.myroom-hotel_local-item-title .close').hide();
    }


});

$('.mypackege-rooms').on('click', 'i.addParent_p', function () {


    var inputNum = $(this).siblings(".countParent_p").val();

    if (inputNum < 7) {
        inputNum++;
        let numberAdult =parseInt( $('.number_adult_p').text());
        let resultNumber = numberAdult + 1
        $(this).siblings(".countParent_p").val(inputNum);
        $('.number_adult_p').html('');
        $('.number_adult_p').append(resultNumber);
    }
});
//hotel local
$('.hotel_local-rooms').on('click', 'i.addParent_hotel_local', function () {


    var inputNum = $(this).siblings(".countParent_hotel_local").val();

    if (inputNum < 7) {
        inputNum++;
        let numberAdult =parseInt( $('.number_adult_hotel_local').text());
        let resultNumber = numberAdult + 1
        $(this).siblings(".countParent_hotel_local").val(inputNum);
        $('.number_adult_hotel_local').html('');
        $('.number_adult_hotel_local').append(resultNumber);
    }
});

$('.mypackege-rooms').on('click', 'i.minusParent_p', function () {

    let data_roomnumber = $(this).parents('.myroom-package-item').attr('data-roomnumber');
    let ThiscountParent =  $(this).parents('.myroom-package-item').find('.countParent_p').val();


    var inputNum = $(this).siblings(".countParent_p").val();

    if (inputNum > 1) {
        inputNum--;
        let numberAdult =parseInt( $('.number_adult_p').text());
        let resultNumber = numberAdult - 1
        $(this).siblings(".countParent_p").val(inputNum);
        $('.number_adult_p').html('');
        $('.number_adult_p').append(resultNumber);
    }



});

//hotel local
$('.hotel_local-rooms').on('click', 'i.minusParent_hotel_local', function () {

    let data_roomnumber = $(this).parents('.myroom-hotel_local-item').attr('data-roomnumber');
    let ThiscountParent =  $(this).parents('.myroom-hotel_local-item').find('.countParent_hotel_local').val();


    var inputNum = $(this).siblings(".countParent_hotel_local").val();

    if (inputNum > 1) {
        inputNum--;
        let numberAdult =parseInt( $('.number_adult_hotel_local').text());
        let resultNumber = numberAdult - 1
        $(this).siblings(".countParent_hotel_local").val(inputNum);
        $('.number_adult_hotel_local').html('');
        $('.number_adult_hotel_local').append(resultNumber);
    }



});

$('.mypackege-rooms').on('click', 'i.addChild_p', function () {

    var inputNum = $(this).siblings(".countChild_p").val();
    inputNum++;
    if (inputNum < 5) {
        let numberBaby =parseInt( $('.number_baby_p').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild_p').val()) + 1;

        let resultNumber = numberBaby + 1

        $(this).siblings(".countChild_p").val(inputNum);
        $('.number_baby_p').html('');
        $('.number_baby_p').append(resultNumber);

        $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

        let roomNumber = $(this).parents(".myroom-package-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-package-item-info").find(".tarikh-tavalods").html(htmlBox);
    }
});
//hotel local
$('.hotel_local-rooms').on('click', 'i.addChild_hotel_local', function () {

    var inputNum = $(this).siblings(".countChild_hotel_local").val();
    inputNum++;
    if (inputNum < 5) {
        let numberBaby =parseInt( $('.number_baby_hotel_local').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild_hotel_local').val()) + 1;

        let resultNumber = numberBaby + 1

        $(this).siblings(".countChild_hotel_local").val(inputNum);
        $('.number_baby_hotel_local').html('');
        $('.number_baby_hotel_local').append(resultNumber);

        $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

        let roomNumber = $(this).parents(".myroom-hotel_local-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-hotel_local-item-info").find(".tarikh-tavalods").html(htmlBox);
    }
});

$('.mypackege-rooms').on('click', 'i.minusChild_p', function () {

    var inputNum = $(this).siblings(".countChild_p").val();
    $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

    if (inputNum != 0) {
        let numberBaby =parseInt( $('.number_baby_p').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild_p').val()) + 1;

        let resultNumber = numberBaby - 1

        inputNum--;
        $(this).siblings(".countChild_p").val(inputNum);
        $('.number_baby_p').html('');
        $('.number_baby_p').append(resultNumber);

        let roomNumber = $(this).parents(".myroom-packege-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-package-item-info").find(".tarikh-tavalods").html(htmlBox);

    } else {
        $(this).siblings(".countChild_p").val('0');

    }
});
//hotel local
$('.hotel_local-rooms').on('click', 'i.minusChild_hotel_local', function () {

    var inputNum = $(this).siblings(".countChild_hotel_local").val();
    $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

    if (inputNum != 0) {
        let numberBaby =parseInt( $('.number_baby_hotel_local').text());
        let numberBabyThis =parseInt($(this).parents().find('.countChild_hotel_local').val()) + 1;

        let resultNumber = numberBaby - 1

        inputNum--;
        $(this).siblings(".countChild_hotel_local").val(inputNum);
        $('.number_baby_hotel_local').html('');
        $('.number_baby_hotel_local').append(resultNumber);

        let roomNumber = $(this).parents(".myroom-hotel_local-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-hotel_local-item-info").find(".tarikh-tavalods").html(htmlBox);

    } else {
        $(this).siblings(".countChild_hotel_local").val('0');

    }
});

$('.mypackege-rooms').on('click', '.close_room', function () {

    $(this).parent().removeClass('active_p');


});
//hotel local
$('.internal-my-hotels-rooms-js').on('click', '.close_room', function () {

    $(this).parent().parent().removeClass('active_p');


});
$('.international-my-hotels-rooms-js').on('click', '.close_room', function () {

    $(this).parent().parent().removeClass('active_p');

});

/* End select oneway toway */

function createRoomHotel(roomCount) {

    var HtmlCode = "";
    let i = $('.myroom-hotel-item').length +1;
    let numberText = "اول";
    let valuefirst;


    if (i == 1) {
        numberText = "اول";
        valuefirst = "2"
    } else if (i == 2) {
        numberText = "دوم";
        valuefirst = "1";

    } else if (i == 3) {
        numberText = "سوم";
        valuefirst = "1";

    } else if (i == 4) {
        numberText = "چهارم";
        valuefirst = "1";

    }


    if(i < 5){
        HtmlCode +=
          `<div class="myroom-hotel-item" data-roomNumber="${i}">
             <div class="myroom-hotel-item-title">
             <span class="close">
             <i class="fal fa-trash-alt"></i>
            </span>
            اتاق  ${numberText}
            </div><div class="myroom-hotel-item-info">
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>بزرگسال</h6>
           (بزرگتر از ۱۲ سال)
        <div><i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
        <input readonly class="countParent"  min="0" value="${valuefirst}" max="5" type="number" name="adult${i}" id="adult${i}">
        <i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
        </div>
        </div>
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>کودک</h6>
                                                    (کوچکتر از ۱۲ سال)
        <div>
        <i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus">
        
        </i><input readonly class="countChild" min="0" value="0" max="5" type="number" name="child${i}" id="child${i}">
        <i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
        </div>
        </div><div class="tarikh-tavalods"></div>
        </div>
        </div>`;
    }

    return HtmlCode;
}

function createRoomHotelPackage(roomCount) {

    var HtmlCode = "";
    let i = $('.myroom-package-item').length +1;
    let numberText = "اول";
    let valuefirst;


    if (i == 1) {
        numberText = "اول";
        valuefirst = "2"
    } else if (i == 2) {
        numberText = "دوم";
        valuefirst = "1";

    } else if (i == 3) {
        numberText = "سوم";
        valuefirst = "1";

    } else if (i == 4) {
        numberText = "چهارم";
        valuefirst = "1";

    }


    if(i < 5){
        HtmlCode +=
          `<div class="myroom-package-item" data-roomNumber="${i}">
             <div class="myroom-package-item-title">اتاق  ${numberText}
             <span class="close">
             <i class="fal fa-trash-alt"></i>
            </span>
            </div><div class="myroom-package-item-info">
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>بزرگسال</h6>
           (بزرگتر از ۱۲ سال)
        <div><i class="addParent_p plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
        <input readonly class="countParent_p"  min="0" value="${valuefirst}" max="5" type="number" name="adultpackage${i}" id="adultpackage${i}">
        <i class="minusParent_p minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
        </div>
        </div>
        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
       <h6>کودک</h6>
                                                    (کوچکتر از ۱۲ سال)
        <div>
        <i class="addChild_p plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus">
        
        </i><input readonly class="countChild_p" min="0" value="0" max="5" type="number" name="childpackage${i}" id="childpackage${i}">
        <i class="minusChild_p minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
        </div>
        </div><div class="tarikh-tavalods"></div>
        </div>
        </div>`;
    }

    return HtmlCode;
}





function changeText(text, none) {
    $('#text_search').text(text);
    if (none == 'null') {
        $('#titr_searchBox em').text('');
    } else {
        $('#titr_searchBox em').text('Ø¨Ù„ÛŒØ·');
    }
}


