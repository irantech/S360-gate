function removeElement() {
    $('.text-day').fadeIn(300, function() {
        $(this).css("display","none");
        $(".header_area").removeClass("text-day_header");
    });
}

function submitVersaNewsLetter() {
    alert('xasxa');
    let full_name = $('.full-name-js').val();
    let email = $('.email-js').val();
    let mobile = $('.mobile-js').val();
    if ( full_name === "" && (email === "" || mobile === "" )) {
        $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: "fa fa-cart-plus",
            content: 'پر کردن همه فیلدها الزامی است',
            rtl: true,
            type: "red",
        })
        return false;
    }
    if (!validateMobile(mobile)) {
        $.alert({
            title: 'ثبت اطلاعات خبر نامه',
            icon: "fa fa-cart-plus",
            content: 'شماره موبایل معتبر نمی باشد',
            rtl: true,
            type: "red",
        })
        return false;
    }
    let myform = document.getElementById("versa-news-letter");
    let formValue = new FormData(myform );
    $(".news-letter-js").attr('disabled' , true);
    $(".newsletters_text_css").hide()
    $(".newsletters_loading_css").show()
    $.ajax({
        type: "POST",
        url: 'https://about.versagasht.com/fa/user/GlobalFile/Ajax.php',
        method: 'POST',
        processData: false,
        contentType: false,
        crossDomain:true,
        data: formValue,
        success: function(response) {
            $(".news-letter-js").attr('disabled' , false);
            $(".newsletters_text_css").show()
            $(".newsletters_loading_css").hide()

            let result = JSON.parse(response);
            if (result.status == 'success') {
                $.alert({
                    title: 'ثبت اطلاعات خبر نامه',
                    icon: "fa fa-cart-plus",
                    content: 'اطلاعات شما با موفقیت ثبت شد.',
                    rtl: true,
                    type: "green",
                })

                 $('.full-name-js').val('');
                $('.email-js').val('');
                $('.mobile-js').val('');

            } else {
                $.alert({
                    title: 'ثبت اطلاعات خبر نامه',
                    icon: "fa fa-cart-plus",
                    content: 'خطا، در ثبت اطلاعات شما خطایی رخ داد',
                    rtl: true,
                    type: "red",
                })
            }
        }
    });
}

function searchVersaTrain(is_new_tab=false){
    const number_adult = parseInt($(".train-adult-js").val()) ? parseInt($(".train-adult-js").val()) : 0
    const number_child = parseInt($(".train-child-js").val()) ? parseInt($(".train-child-js").val()) : 0
    const number_infant = parseInt($(".train-infant-js").val()) ? parseInt($(".train-infant-js").val()) : 0
    const multi_way = $(".train-one-way-js").is('checked')?1:2
    const train_seat_type = parseInt($(".train-seat-type-js:checked").val())
    const train_coupe_type = $(".train-coupe-type-js:checked").val() ? 1 : 0
    console.log($(".train-adult-js").val())
    console.log($(".train-child-js").val())
    console.log($(".train-infant-js").val())
    let origin_train = $(".origin-train-js")
    let destination_train = $(".destination-train-js")
    let train_departure_date = $(".train-departure-date-js")
    let train_arrival_date = $(".train-arrival-date-js")


    checkSearchFields(
      origin_train,
      destination_train,
      train_departure_date,
      train_arrival_date
    )

    origin_train = origin_train.val()
    destination_train = destination_train.val()
    train_departure_date = train_departure_date.val()
    train_arrival_date = train_arrival_date.val()
    console.log(destination_train)
    let date = multi_way === 2 ? `${train_departure_date}&${train_arrival_date}` : `${train_departure_date}`

    let count_passenger = `${number_adult}-${number_child}-${number_infant}`

    var domain = $("#gds_train").attr('data-action');
    console.log(domain)
    console.log(count_passenger)
    var url = domain ;
    $("#gds_train").attr('action', url);
    document.gds_train.submit();

    // openLink(url,is_new_tab)
}

$(document).ready(function (){

    $(".btn-login").click(function (e) {

        $(".new-click-sub").addClass("show-flex");
    })
    $("body").click(function () {
        $(".new-click-sub").removeClass("show-flex");
    });

    $(function () {
        $('#scroll-top').hide();

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


    $('.owl-baner').owlCarousel({
        rtl:true,
        loop:true,
        dots:true,
        autoplay: true,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        autoplayTimeout: 3000,
        autoplaySpeed:3000,
        margin:10,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:1
            }
        }
    });
    $('.owl-tab-tour').owlCarousel({
        rtl:true,
        loop:true,
        margin:10,
        nav:true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed:3000,
        dots:false,
        responsive:{
            0:{
                items:1,
                nav:false,
                dots:true,
            },
            600:{
                items:2,
                nav:false,
                dots:true,
            },
            1000:{
                items:3
            }
        }
    })
    $('.owl-tablighat').owlCarousel({
        rtl:true,
        loop:true,
        margin:10,
        nav:false,
        autoplay: false,
        autoplayTimeout: 7000,
        autoplaySpeed:3000,
        dots:false,
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
    });



    /*! searchBox*/
    $(document).ready(function () {
        // $(".select2 , .select2_in , .select2BusRouteSearch ").select2({
        //     templateResult: formatState
        // });
        // $('.switch-label-off').click();
        // if ($("input[name='DOM_TripMode_train']:checked").val() == '2' && $('#regds_dept_date_train').val() == "") {
        //     alert_pusher('هنوز فرم کامل نشده است', 'لطفا تاریخ برگشت را وارد نمایید', 'fa fa-exclamation-triangle', "warning");
        //     return false;
        // }
        // if ($('#regds_dept_date_train').val() != "" && $("input[name='DOM_TripMode_train']:checked").val() == '2') {
        //     var returndate = "&" + $('#regds_dept_date_train').val();
        // } else {
        //     var returndate = '';
        // }
        // $('input:radio[name="DOM_TripMode_train"]').change(
        //     function () {
        //         if (this.checked && this.value == '1') {
        //             $('#regds_dept_date_train').attr('disabled', '');
        //         } else {
        //             $('#regds_dept_date_train').removeAttr('disabled', '');
        //         }
        //     });


        $(".plus-nafar").click(function () {
            var nafar = $(this).siblings(".number-count").attr('data-number');
            if (nafar < 9) {
                var newnafar = ++nafar;
                $(this).siblings(".number-count").html(newnafar);
                $(this).siblings(".number-count").attr('data-number', newnafar);
                var whathidden = $(this).siblings(".number-count").attr('data-value');
                $("." + whathidden).val(newnafar);
            }
            var nafarbozorg = Number($(this).parents(".box-of-count-nafar").find(".bozorg-num .number-count").attr('data-number'));
            var nafarkoodak = Number($(this).parents(".box-of-count-nafar").find(".koodak-num .number-count").attr('data-number'));
            var nafarnozad = Number($(this).parents(".box-of-count-nafar").find(".nozad-num .number-count").attr('data-number'));
            var tedad = nafarbozorg + nafarkoodak + nafarnozad;
            if (nafarnozad == 0 && nafarkoodak == 0) {
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            } else {
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            }
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
            var nafarbozorg2 = Number($(this).parents(".box-of-count-nafar").find(".bozorg-num .number-count").attr('data-number'));
            var nafarkoodak2 = Number($(this).parents(".box-of-count-nafar").find(".koodak-num .number-count").attr('data-number'));
            var nafarnozad2 = Number($(this).parents(".box-of-count-nafar").find(".nozad-num .number-count").attr('data-number'));
            var tedad2 = nafarbozorg2 + nafarkoodak2 + nafarnozad2;
            if (nafarnozad2 == 0 && nafarkoodak2 == 0) {
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            } else {
                let allNafarat = nafarbozorg + nafarkoodak + nafarnozad;$(this).parents(".box-of-count-nafar").find(".text-count-nafar").text(allNafarat + " مسافر ");
            }
        });
        $('.box-of-count-nafar-boxes').click(function () {
            $('.cbox-count-nafar').toggle();
            $(this).parents().find('.down-count-nafar').toggleClass('fa-caret-up');
        });
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
                if ($(this).height() < 210) {
                    $(this).nextAll('span.more_matn').first().hide();
                }
            });
        }, 200);
        $('.more_read_matn').parent().find('.typo__context').each(function () {
            if ($(this).height() < 90) {
                $(this).nextAll('button.more_read_matn').first().css({display: "none"});
            }
        });



        var owlFlightProposal = $('.owlFlightProposal');
        owlFlightProposal.owlCarousel({
            rtl: true,
            dots: false,
            loop: true,
            margin: 5,
            nav: true,
            navText: ["<i class='fas fa-chevron-right'></i>", "<i class='fas fa-chevron-left'></i>"],
            autoplaySpeed: 1000,
            autoplay: false,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {0: {items: 1, nav: false, dots: true,}, 600: {items: 2}, 1000: {items: 4}}
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });



        $('#hotel_local_room ul').click(function () {
            $('.hotel_local-rooms').toggleClass('active_p');
        });
        $('#package_room ul').click(function () {
            $('.mypackege-rooms').toggleClass('active_p');
        });
        // $('.hotel_passenger_picker ul').click(function () {
        //     $('.myhotels-rooms').toggleClass('active_p');
        // });
        // $('#hotel_local_room').click(function (event) {
        //     $('html').one('click', function () {
        //         $('.myhotels-rooms').removeClass('active_p');
        //     });
        //     event.stopPropagation();
        // });
        $('#package_room').click(function (event) {
            $('html').one('click', function () {
                $('.myhotels-rooms').removeClass('active_p');
            });
            event.stopPropagation();
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
        $('input:radio[name="DOM_TripMode"]').change(function () {
            if (this.checked && this.value == '1') {
                $('.return_input').removeAttr('disabled', '');
            } else {
                $('.return_input').attr('disabled', '');
            }
        });
        $('input:radio[name="DOM_TripMode2"]').change(function () {
            if (this.checked && this.value == '1') {
                $('.return_input2').removeAttr('disabled', '');
            } else {
                $('.return_input2').attr('disabled', '');
            }
        });
        $('input:radio[name="DOM_TripMode6"]').change(function () {
            if (this.checked && this.value == '1') {
                $('.return_input_train').removeAttr('disabled', '');
            } else {
                $('.return_input_train').attr('disabled', '');
            }
        });




        $('input:radio[name="DOM_TripMode7"]').change(function () {
            if (this.checked && this.value == '1') {
                $('#transfer_div').css('display', 'flex');
                $('#gasht_div').hide();
            } else {
                $('#transfer_div').hide();
                $('#gasht_div').css('display', 'flex');
            }
        });
        $('input:radio[name="DOM_TripMode5"]').change(function () {
            if (this.checked && this.value == '1') {
                $('#tour_khareji').css('display', 'flex');
                $('#tour_dakheli').hide();
            } else {
                $('#tour_khareji').hide();
                $('#tour_dakheli').css('display', 'flex');
            }
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $('.top__user_menu').bind('click', function (e) {/*as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open*/
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
        });
        $('.myhotels-rooms').on('click', '.close_room', function () {
            $(this).parent().removeClass('active_p');
        });

        function createRoomHotel(roomCount) {
            var HtmlCode = "";
            let i = $('.myroom-hotel-item').length + 1;
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
            if (i < 5) {
                HtmlCode += `<div class="myroom-hotel-item" data-roomNumber="${i}"> <div class="myroom-hotel-item-title"> <span class="close"> <i class="fal fa-trash-alt"></i> </span> اتاق  ${numberText} </div><div class="myroom-hotel-item-info"> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>بزرگسال</h6> (بزرگتر از ۱۲ سال) <div><i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i> <input readonly class="countParent"  min="0" value="${valuefirst}" max="5" type="number" name="adult${i}" id="adult${i}"> <i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i> </div> </div> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>کودک</h6> (کوچکتر از ۱۲ سال) <div> <i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"> </i><input readonly class="countChild" min="0" value="0" max="5" type="number" name="child${i}" id="child${i}"> <i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i> </div> </div><div class="tarikh-tavalods"></div> </div> </div>`;
            }
            return HtmlCode;
        }

        function createRoomHotelPackage(roomCount) {
            var HtmlCode = "";
            let i = $('.myroom-package-item').length + 1;
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
            if (i < 5) {
                HtmlCode += `<div class="myroom-package-item" data-roomNumber="${i}"> <div class="myroom-package-item-title"> <span class="close"> <i class="fal fa-trash-alt"></i> </span> اتاق  ${numberText} </div><div class="myroom-package-item-info"> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>بزرگسال</h6> (بزرگتر از ۱۲ سال) <div><i class="addParent_p plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i> <input readonly class="countParent_p"  min="0" value="${valuefirst}" max="5" type="number" name="adultpackage${i}" id="adultpackage${i}"> <i class="minusParent_p minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i> </div> </div> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>کودک</h6> (کوچکتر از ۱۲ سال) <div> <i class="addChild_p plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"> </i><input readonly class="countChild_p" min="0" value="0" max="5" type="number" name="childpackage${i}" id="childpackage${i}"> <i class="minusChild_p minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i> </div> </div><div class="tarikh-tavalods"></div> </div> </div>`;
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
                HtmlCode += '<div class="tarikh-tavalod-item">' + '<span>سن کودک <i>' + numberTextChild + '</i></span>' + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">' + '<option value="1">0 تا 1 سال</option>' + '<option value="2">1 تا 2 سال</option>' + '<option value="3">2 تا 3 سال</option>' + '<option value="4">3 تا 4 سال</option>' + '<option value="5">4 تا 5 سال</option>' + '<option value="6">5 تا 6 سال</option>' + '<option value="7">6 تا 7 سال</option>' + '<option value="8">7 تا 8 سال</option>' + '<option value="9">8 تا 9 سال</option>' + '<option value="10">9 تا 10 سال</option>' + '<option value="11">10 تا 11 سال</option>' + '<option value="12">11 تا 12 سال</option>' + '</select>' + '</div>';
                i++;
            }
            return HtmlCode;
        };$('body').click(function () {
            $('.lang_ul').removeClass('active_lang');
        });
        $('.top__user_menu').bind('click', function (e) {
            e.stopPropagation();
        });
        $('.box-of-count-nafar').bind('click', function (e) {
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
        $('.top__user_menu').bind('click', function (e) {
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
        iframe.find('span').on('click', function () {
            $('.main-navigation__item').find('.main-navigation__sub-menu2').toggle();
            $('.button-chevron-2').toggleClass('rotate');
        });
        $('.main-navigation__button2').click(function () {
            $('.main-navigation__sub-menu2').fadeToggle(function () {
                $('button-chevron-2').toggle();
            });
            $('.button-chevron-2').toggleClass('rotate');
        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "/user/pages/images/flags";
            var $state = $('<span class="city_start">' + state.text + '</span>');
            return $state;
        };
        // $('.multiselectportal').click(function () {
        //     if ($("input[name='select-rb']:checked").val() == '1') {
        //         $('.returnCalendar').prop("disabled", "disabled");
        //     } else {
        //         $('.returnCalendar').removeAttr("disabled");
        //     }
        // });
        // $('.select_multiway3').click(function () {
        //     if ($("input[name='select-rb2']:checked").val() == '1') {
        //         $('#regds_dept_date_local').prop("disabled", "disabled");
        //     } else {
        //         $('#regds_dept_date_local').removeAttr("disabled");
        //     }
        // });





        $('.mypackege-rooms').on('click', '.btn_add_room_p', function (e) {
            $('.mypackege-rooms .close').show();
            let roomCount = parseInt($('.myroom-package-item').length);
            let numberAdult = parseInt($('.number_adult_p').text());
            let number_room = parseInt($('.number_room_p').text());
            $('.number_adult_p').text(numberAdult + 1);
            $('.number_room_p').text(number_room + 1);
            let code = createRoomHotelPackage(roomCount);
            $(".package_select_room").append(code);
            if (roomCount == 3) {
                $(this).hide();
            }
        });
        $('.hotel_local-rooms').on('click', '.btn_add_room_hotel_local', function (e) {
            $('.hotel_local-rooms .close').show();
            $(this).parents(".hotel_local-rooms").find(".close").removeClass("d-none");
            let roomCount = parseInt($('.myroom-hotel_local-item').length);
            let numberAdult = parseInt($('.number_adult_hotel_local').text());
            let number_room = parseInt($('.number_room_hotel_local').text());
            $('.number_adult_hotel_local').text(numberAdult + 1);
            $('.number_room_hotel_local').text(number_room + 1);
            let code = createRoomHotelLocal(roomCount);
            $(".hotel_local_select_room").append(code);
            if (roomCount == 3) {
                $(this).hide();
            }
        });
        $('.hotel_local-rooms').on('click', '.myroom-hotel_local-item .close', function () {
            let babyCountThis = $(this).parents('.myroom-hotel_local-item').find('.countChild_hotel_local').val();
            let number_baby = $('.number_baby_hotel_local').text();
            $('.number_baby_hotel_local').text(number_baby - babyCountThis);
            let AdultCountThis = $(this).parents('.myroom-hotel_local-item').find('.countParent_hotel_local').val();
            let number_adult = $('.number_adult_hotel_local').text();
            $('.number_adult_hotel_local').text(number_adult - AdultCountThis);
            $('.btn_add_room_hotel_local').show();
            let roomNumber = $(this).parents(".myroom-hotel_local-item").data("roomnumber");
            let roomCount = $(".myroom-hotel_local-item").length;
            let number_room = parseInt($('.number_room_hotel_local').text());
            $('.number_room_hotel_local').text(number_room - 1);
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
                $(this).find('.myroom-hotel_local-item-title').html('<span class="close"><i class="fal fa-trash-alt"></i></span>' + ' اتاق ' + numberText);
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
            if (roomCount == 2) {
                $('.myroom-hotel_local-item-title .close').hide();
            }
        });
        $('.mypackege-rooms').on('click', 'i.addParent_p', function () {
            var inputNum = $(this).siblings(".countParent_p").val();
            if (inputNum < 7) {
                inputNum++;
                let numberAdult = parseInt($('.number_adult_p').text());
                let resultNumber = numberAdult + 1;
                $(this).siblings(".countParent_p").val(inputNum);
                $('.number_adult_p').html('');
                $('.number_adult_p').append(resultNumber);
            }
        });
        $('.hotel_local-rooms').on('click', 'i.addParent_hotel_local', function () {
            var inputNum = $(this).siblings(".countParent_hotel_local").val();
            if (inputNum < 7) {
                inputNum++;
                let numberAdult = parseInt($('.number_adult_hotel_local').text());
                let resultNumber = numberAdult + 1;
                $(this).siblings(".countParent_hotel_local").val(inputNum);
                $('.number_adult_hotel_local').html('');
                $('.number_adult_hotel_local').append(resultNumber);
            }
        });
        $('.mypackege-rooms').on('click', 'i.minusParent_p', function () {
            let data_roomnumber = $(this).parents('.myroom-package-item').attr('data-roomnumber');
            let ThiscountParent = $(this).parents('.myroom-package-item').find('.countParent_p').val();
            var inputNum = $(this).siblings(".countParent_p").val();
            if (inputNum > 1) {
                inputNum--;
                let numberAdult = parseInt($('.number_adult_p').text());
                let resultNumber = numberAdult - 1;
                $(this).siblings(".countParent_p").val(inputNum);
                $('.number_adult_p').html('');
                $('.number_adult_p').append(resultNumber);
            }
        });
        $('.hotel_local-rooms').on('click', 'i.minusParent_hotel_local', function () {
            let data_roomnumber = $(this).parents('.myroom-hotel_local-item').attr('data-roomnumber');
            let ThiscountParent = $(this).parents('.myroom-hotel_local-item').find('.countParent_hotel_local').val();
            var inputNum = $(this).siblings(".countParent_hotel_local").val();
            if (inputNum > 1) {
                inputNum--;
                let numberAdult = parseInt($('.number_adult_hotel_local').text());
                let resultNumber = numberAdult - 1;
                $(this).siblings(".countParent_hotel_local").val(inputNum);
                $('.number_adult_hotel_local').html('');
                $('.number_adult_hotel_local').append(resultNumber);
            }
        });
        $('.mypackege-rooms').on('click', 'i.addChild_p', function () {
            var inputNum = $(this).siblings(".countChild_p").val();
            inputNum++;
            if (inputNum < 5) {
                let numberBaby = parseInt($('.number_baby_p').text());
                let numberBabyThis = parseInt($(this).parents().find('.countChild_p').val()) + 1;
                let resultNumber = numberBaby + 1;
                $(this).siblings(".countChild_p").val(inputNum);
                $('.number_baby_p').html('');
                $('.number_baby_p').append(resultNumber);
                $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();
                let roomNumber = $(this).parents(".myroom-package-item").data("roomnumber");
                var htmlBox = createBirthdayCalendar(inputNum, roomNumber);
                $(this).parents(".myroom-package-item-info").find(".tarikh-tavalods").html(htmlBox);
            }
        });
        $('.hotel_local-rooms').on('click', 'i.addChild_hotel_local', function () {
            var inputNum = $(this).siblings(".countChild_hotel_local").val();
            inputNum++;
            if (inputNum < 5) {
                let numberBaby = parseInt($('.number_baby_hotel_local').text());
                let numberBabyThis = parseInt($(this).parents().find('.countChild_hotel_local').val()) + 1;
                let resultNumber = numberBaby + 1;
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
                let numberBaby = parseInt($('.number_baby_p').text());
                let numberBabyThis = parseInt($(this).parents().find('.countChild_p').val()) + 1;
                let resultNumber = numberBaby - 1;
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
        $('.hotel_local-rooms').on('click', 'i.minusChild_hotel_local', function () {
            var inputNum = $(this).siblings(".countChild_hotel_local").val();
            $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();
            if (inputNum != 0) {
                let numberBaby = parseInt($('.number_baby_hotel_local').text());
                let numberBabyThis = parseInt($(this).parents().find('.countChild_hotel_local').val()) + 1;
                let resultNumber = numberBaby - 1;
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
        $('.hotel_local-rooms').on('click', '.close_room', function () {
            $(this).parent().removeClass('active_p');
        });
        $('.myhotels-rooms').on('click', '.close_room', function () {
            $(this).parent().removeClass('active_p');
        });

        function createRoomHotel(roomCount) {
            var HtmlCode = "";
            let i = $('.myroom-hotel-item').length + 1;
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
            if (i < 5) {
                HtmlCode += `<div class="myroom-hotel-item" data-roomNumber="${i}"> <div class="myroom-hotel-item-title"> <span class="close"> <i class="fal fa-trash-alt"></i> </span> اتاق  ${numberText} </div><div class="myroom-hotel-item-info"> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>بزرگسال</h6> (بزرگتر از ۱۲ سال) <div><i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i> <input readonly class="countParent"  min="0" value="${valuefirst}" max="5" type="number" name="adult${i}" id="adult${i}"> <i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i> </div> </div> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>کودک</h6> (کوچکتر از ۱۲ سال) <div> <i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"> </i><input readonly class="countChild" min="0" value="0" max="5" type="number" name="child${i}" id="child${i}"> <i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i> </div> </div><div class="tarikh-tavalods"></div> </div> </div>`;
            }
            return HtmlCode;
        }

        function createRoomHotelLocal(roomCount) {
            var HtmlCode = "";
            let i = $('.myroom-hotel_local-item').length + 1;
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
            if (i < 5) {
                HtmlCode += `<div class="myroom-hotel_local-item" data-roomNumber="${i}"> <div class="myroom-hotel_local-item-title"> <span class="close"> <i class="fal fa-trash-alt"></i> </span> اتاق  ${numberText} </div><div class="myroom-hotel_local-item-info"> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>بزرگسال</h6> (بزرگتر از ۱۲ سال) <div><i class="addParent_hotel_local plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i> <input readonly class="countParent_hotel_local"  min="0" value="${valuefirst}" max="5" type="number" name="adultHotelLocal${i}" id="adultHotelLocal${i}"> <i class="minusParent_hotel_local minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i> </div> </div> <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal"> <h6>کودک</h6> (کوچکتر از ۱۲ سال) <div> <i class="addChild_hotel_local plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"> </i><input readonly class="countChild_hotel_local" min="0" value="0" max="5" type="number" name="childHotelLocal${i}" id="childHotelLocal${i}"> <i class="minusChild_hotel_local minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i> </div> </div><div class="tarikh-tavalods"></div> </div> </div>`;
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
                HtmlCode += '<div class="tarikh-tavalod-item">' + '<span>سن کودک <i>' + numberTextChild + '</i></span>' + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">' + '<option value="1">0 تا 1 سال</option>' + '<option value="2">1 تا 2 سال</option>' + '<option value="3">2 تا 3 سال</option>' + '<option value="4">3 تا 4 سال</option>' + '<option value="5">4 تا 5 سال</option>' + '<option value="6">5 تا 6 سال</option>' + '<option value="7">6 تا 7 سال</option>' + '<option value="8">7 تا 8 سال</option>' + '<option value="9">8 تا 9 سال</option>' + '<option value="10">9 تا 10 سال</option>' + '<option value="11">10 تا 11 سال</option>' + '<option value="12">11 تا 12 سال</option>' + '</select>' + '</div>';
                i++;
            }
            return HtmlCode;
        };
    });
    /*! searchBox END*/
})
$('.stop-propagation').bind('click', function (e) {
    e.stopPropagation();
});