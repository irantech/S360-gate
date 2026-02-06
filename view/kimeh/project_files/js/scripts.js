


$(document).ready(function () {

    setTimeout(function () {
        $('.preloader').fadeOut();
    }, 1000);


    var heiw = $(window).height();

    $('.temp_content').css('min-height' , heiw);

    var winh = $(window).height();

    if($(window).width() > 767){
        $('.banner').css('height' , winh);
    }
    $(".search").click(function() {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".tabs_section").offset().top -80
        }, 1000);
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
        $('#scroll-top button').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        });
    });

    $('.hamburger-menu').on('click',function () {

        $(this).toggleClass('open');
        $('.navigation_2').toggleClass('open');
        $('.main_body').toggleClass('openblur');

    });

    $('.btn.register').click(function () {
        $('.hamburger-menu').toggleClass('open');
        $('.navigation_2').toggleClass('open');
        $('.main_body').toggleClass('openblur');

    });


    $('.navigation_2').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('.act-buttons').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });
    $('.hamburger-menu').bind('click', function(e){
        //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
        e.stopPropagation();

    });



if($(window).width() > 767){



    $(window).scroll(function () {

        var sctop = $(this).scrollTop();

        if(sctop > 50){


            $('.header_area').addClass('fixedmenu');


        }
        else{

            $('.header_area').removeClass('fixedmenu');


        }


    });

}


    $('.down-count-nafar').click(function () {

        $('.cbox-count-nafar').toggle();
        $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
    });




    $('input:radio[name="radio1"]').change(
        function(){
            if (this.checked && this.value == '1') {

                $('.flight_local').css('display', 'flex');
                $('.flight_forign').css('display', 'none');

            }
            else {

                $('.flight_local').css('display', 'none');
                $('.flight_forign').css('display', 'flex');
            }
        });


    $('input:radio[name="radio_gasht"]').change(
        function(){
            if (this.checked && this.value == '1') {

                $('#gasht_div').css('display', 'flex');
                $('#transfer_div').css('display', 'none');

            }
            else {

                $('#gasht_div').css('display', 'none');
                $('#transfer_div').css('display', 'flex');
            }
        });


    $('input:radio[name="radio"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input').attr('disabled', '');

            }
            else {
                $('.return_input').removeAttr('disabled', '');
            }
        });

    $('input:radio[name="radio"]').change(
        function(){
            if (this.checked && this.value == '1') {
                $('.return_input_train').attr('disabled', '');

            }
            else {
                $('.return_input_train').removeAttr('disabled', '');
            }
        });

    $('input:radio[name="radio2"]').change(
        function(){
            if (this.checked && this.value == '1') {

                $('#hotel_dakheli').css('display', 'flex');
                $('#hotel_khareji').css('display', 'none');

            }
            else {

                $('#hotel_dakheli').css('display', 'none');
                $('#hotel_khareji').css('display', 'flex');
            }
        });


    $('input:radio[name="radio3"]').change(
        function(){
            if (this.checked && this.value == '1') {

                $('#tour_dakheli').css('display', 'flex');
                $('#tour_khareji').css('display', 'none');

            }
            else {

                $('#tour_dakheli').css('display', 'none');
                $('#tour_khareji').css('display', 'flex');
            }
        });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
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
        $('.navigation_2').removeClass('open');
        $('.hamburger-menu').removeClass('open');
        $('.main_body').removeClass('openblur');
        $('.main-navigation__sub-menu').hide();
        $('.button-chevron').removeClass('rotate');

        $('.cbox-count-nafar').hide();
        $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
    });

    var highlight = $('.owl_highlight');
    highlight.owlCarousel({
        rtl: true,
        dots:true,
        loop: true,
        margin: 5,
        center:true,
        nav:false,
        autoplay: false,
        responsive: {
            0: {
                items: 1,
                center:false,
                margin:0,

            },
            600: {
                items: 1,
                center:false,
                margin:0,

            },
            900: {
                items: 1,
                center:false,
                margin:0,

            },
            1000: {
                items: 2,

            }
        }
    });

    var owltour = $('.owl-tours');
    owltour.owlCarousel({
        rtl: true,
        dots:false,
        loop: false,
        margin: 5,
        nav:true,
        autoplay: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: true
            },
            1000: {
                items: 4,
                nav: true,
                margin: 5
            }
        }
    });
    var owlair = $('#owl-air');
    owlair.owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 5,
        nav:false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,

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

});



function createRoomHotel(roomCount) {
    var HtmlCode = "";
    var i = 1;
    let numberText = "اول";

    while (i <= roomCount) {
        if (i == 1) {
            numberText = "اول";
        } else if (i == 2) {
            numberText = "دوم";
        } else if (i == 3) {
            numberText = "سوم";
        } else if (i == 4) {
            numberText = "چهارم";
        }

        HtmlCode +=
            '<div class="myroom-hotel-item" data-roomNumber="' + i + '">'
            + '<div class="myroom-hotel-item-title">اتاق  ' + numberText + '<span class="close"></span></div>'
            + '<div class="myroom-hotel-item-info">'
            + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
            + '<span>تعداد بزرگسال<i>(12 سال به بالا)</i></span>'
            + '<div>'
            + '<i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>'
            + '<input readonly class="countParent"  min="0" value="1" max="5" type="number" name="adult' + i + '" id="adult' + i + '">'
            + '<i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>'
            + '</div>'
            + '</div>'
            + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
            + '<span>تعداد کودک<i>(زیر 12 سال)</i></span>'
            + '<div>'
            + '<i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"></i>'
            + '<input readonly class="countChild" min="0" value="0" max="5" type="number" name="child' + i + '" id="child' + i + '">'
            + '<i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>'
            + '</div>'
            + '</div>'
            + '<div class="tarikh-tavalods">'
            + '</div>'
            + '</div>'
            + '</div>';
        i++;
    }
    return HtmlCode;
};

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



$('body').on('click', '.myroom-hotel-item .close', function () {
    let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
    $(this).parents(".myroom-hotel-item").remove();
    let countRoom = parseInt($('#countRoom').val()) - 1;
    $("#countRoom option:selected").prop("selected", false);
    $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
    let numberRoom = 1;
    let numberText = "اول";
    $('.myroom-hotel-item').each(function () {
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
        $(this).find('.myroom-hotel-item-title').html(' اتاق ' + numberText + '<span class="close"></span>');
        $(this).find(".myroom-hotel-item-info").find("input[name^='adult']").attr("name", "adult" + numberRoom);
        $(this).find(".myroom-hotel-item-info").find("input[name^='adult']").attr("id", "adult" + numberRoom);
        $(this).find(".myroom-hotel-item-info").find("input[name^='child']").attr("name", "child" + numberRoom);
        $(this).find(".myroom-hotel-item-info").find("input[name^='child']").attr("id", "child" + numberRoom);
        let numberChild = 1;
        let inputNameSelectChildAge = $(this).find(".tarikh-tavalods .tarikh-tavalod-item");
        inputNameSelectChildAge.each(function () {
            $(this).find("select[name^='childAge']").attr("name", "childAge" + numberRoom + numberChild);
            $(this).find("select[name^='childAge']").attr("id", "childAge" + numberRoom + numberChild);
            numberChild++;
        });
        numberRoom++;
    });
});

const imgContent = document.querySelectorAll('.img-content-hover');

function showImgContent(e) {
    for(var i = 0; i < imgContent.length; i++) {
        x = e.pageX;
        y = e.pageY;
        imgContent[i].style.transform = `translate3d(${x}px, ${y}px, 0)`;
    }
};

document.addEventListener('mousemove', showImgContent);
$('#countRoom').on('change', function (e) {


    var roomCount = $("#countRoom").val();
    createRoomHotel(roomCount);
    $(".myroom-hotel").find(".myroom-hotel-item").remove();
    var code = createRoomHotel(roomCount);
    $(".myroom-hotel").append(code);


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

$('body').on('click', 'i.addParent', function () {

    var inputNum = $(this).siblings(".countParent").val();
    inputNum++;
    if (inputNum < 7) {
        $(this).siblings(".countParent").val(inputNum);
    }
});
$('body').on('click', 'i.minusParent', function () {
    var inputNum = $(this).siblings(".countParent").val();
    if (inputNum != 0) {
        inputNum--;
        $(this).siblings(".countParent").val(inputNum);
    } else {
        $(this).siblings(".countParent").val('0');
    }
});

$('body').on('click', 'i.addChild', function () {
    var inputNum = $(this).siblings(".countChild").val();
    inputNum++;
    if (inputNum < 5) {
        $(this).siblings(".countChild").val(inputNum);

        $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

        let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);
    }
});
$('body').on('click', 'i.minusChild', function () {
    var inputNum = $(this).siblings(".countChild").val();
    $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

    if (inputNum != 0) {
        inputNum--;
        $(this).siblings(".countChild").val(inputNum);

        let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");

        var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

        $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);
    } else {
        $(this).siblings(".countChild").val('0');
    }
});
function viewHotel(href) {

    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", href);
    var hiddenField1 = document.createElement("input");
    hiddenField1.setAttribute("type", "hidden");
    hiddenField1.setAttribute("name", "idHotel_select");
    hiddenField1.setAttribute("value", "1");
    var hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("type", "hidden");
    hiddenField2.setAttribute("name", "typeApplication");
    hiddenField2.setAttribute("value", "reservation");
    var hiddenField3 = document.createElement("input");
    hiddenField3.setAttribute("type", "hidden");
    hiddenField3.setAttribute("name", "isShowReserve");
    hiddenField3.setAttribute("value", "no");

    form.appendChild(hiddenField1);
    form.appendChild(hiddenField2);
    form.appendChild(hiddenField3);

    document.body.appendChild(form);
    form.submit();

}