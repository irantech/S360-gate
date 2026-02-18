

(function (document) {

        function addQtyForeign(value) {
            var currentVal = parseInt($("#qtyf" + value).val());
       
            if (!isNaN(currentVal)) {
                $("#qtyf" + value).val(currentVal + 1);
            }
        };

        function minusQtyForeign(value) {
            var currentVal = parseInt($("#qtyf" + value).val());

            if (!isNaN(currentVal)) {
                if (currentVal > 0) {
                    $("#qtyf" + value).val(currentVal - 1);
                }
            }
        };


        $(function () {
            var numButtonsQtyForeign = 6;
            for (var i = 1; i <= numButtonsQtyForeign; i++) {
                $("#addQtyForeign" + i).click(closeOver(addQtyForeign, i));
                $("#minusQtyForeign" + i).click(closeOver(minusQtyForeign, i));
            }
        });

    // =============number input
    function add(value) {
        var currentVal = parseInt($("#qty" + value).val());
        if (!isNaN(currentVal)) {
            $("#qty" + value).val(currentVal + 1);
        }
    };

    function minus(value) {
        var currentVal = parseInt($("#qty" + value).val());
        if (!isNaN(currentVal)) {
            if (currentVal > 0) {
                $("#qty" + value).val(currentVal - 1);
            }
        }
    };

    function closeOver(f, value) {
        return function () {
            f(value);
        };
    }

    $(function () {
        var numButtons = 6;
        for (var i = 1; i <= numButtons; i++) {
            $("#add" + i).click(closeOver(add, i));
            $("#minus" + i).click(closeOver(minus, i));
        }
    });

    //deleteInfuture
        function addExternal(value) {
            var currentVal = parseInt($("#qtyExternal" + value).val());

            if (!isNaN(currentVal)) {
                $("#qtyExternal" + value).val(currentVal + 1);
                console.log($("#qtyExternal" + value).val());
            }
        };

        function minusExternal(value) {
            var currentVal = parseInt($("#qtyExternal" + value).val());
            if (!isNaN(currentVal)) {
                if (currentVal > 0) {
                    $("#qtyExternal" + value).val(currentVal - 1);
                }
            }
        };

        function closeOverExternal(f, value) {
            return function () {
                f(value);
            };
        }

        $(function () {
            var numButtons = 6;
            for (var i = 1; i <= numButtons; i++) {
                $("#addExternal" + i).click(closeOverExternal(addExternal, i));
                $("#minusExternal" + i).click(closeOverExternal(minusExternal, i));
            }
        });

    $('.s-u-update-popup .s-u-in-out-wrapper input').on("click", function () {
        $(this).val("");
    });


    $(".s-u-last-passenger-btn-close").click(function () {
        $(this).parents('.s-u-passenger-wrapper').fadeOut();
    });


    // last-passenger-popup script
    $(".s-u-last-passenger-btn").click(function () {
        $('.s-u-black-container').fadeIn();
        $('.last-p-popup').fadeIn();
    });

    $(".s-u-black-container").click(function () {
        $('.s-u-black-container').fadeOut();
        $('.last-p-popup').fadeOut();
    });

    $(".s-u-close-last-p").click(function () {
        $('.s-u-black-container').fadeOut();
        $('.last-p-popup').fadeOut();
    });


    // add passenger form
    $('span.s-u-passenger-add-adult , .s-u-passenger-add-kid , .s-u-passenger-add-baby').click(function () {

        $("<div class='s-u-passenger-wrapper'><span class='s-u-last-passenger-btn-close'></span><span class='s-u-last-passenger-btn'>"+ useXmltag('Formertravelers') +"</span><div class='clear'></div><div class='s-u-passenger-item'><select ><option value='' disabled selected='selected'>"+ useXmltag('Sex') +"</option><option>"+ useXmltag('Sir') +"</option><option>"+ useXmltag('Lady') +"</option></select></div><div class='s-u-passenger-item'><input type='' placeholder='First Name' name='' class='dir-ltr'></div><div class='s-u-passenger-item'><input type='' placeholder='Last Name' name='' class='dir-ltr'></div><div class='s-u-passenger-item'><input type='' placeholder='"+ useXmltag('DateOfBirth')+"' name=''></div><div class='s-u-passenger-item'><input type='' placeholder='"+useXmltag('CountryBrithDay')+"' name=''></div><div class='s-u-passenger-item'><input type='' placeholder='"+ useXmltag('CountryPassport')+"' name=''></div><div class='s-u-passenger-item'><input type='' placeholder='"+useXmltag('Numpassport')+"' name=''></div><div class='s-u-passenger-item'><input type='' placeholder='"+useXmltag('Passportexpirydate')+"' name=''></div><div class='clear'></div></div>").insertAfter(".s-u-passenger-wrapper.first");


    });


    // ==========hotel room==========

    $('.s-u-hotel-room').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().find(".s-u-hotel-room-wrapper").slideToggle();

    });


    //=========select detail==========

    $('.s-u-select-update').click(function (e) {
        e.preventDefault();
        $(".s-u-update-popup").slideToggle();

    });
    $('.s-u-close-update').click(function (e) {
        e.preventDefault();
        $(".s-u-update-popup").slideUp();

    });


    //======login button===============

    $('.s-u-account-img').click(function (e) {
        e.preventDefault();
        $(".s-u-loginbox").slideToggle('fast');
    });


    // ===== Menu Fix to Top =====
    if ($(window).width() > 545) {
        $(document).scroll(function () {
            var y = $(window).scrollTop();
            if (y > 5) {
                $('.float-panel').addClass('menu-fixed');

            } else {
                $('.float-panel').removeClass('menu-fixed');

            }
        });

    }

    $(".new-cal").datepicker({
        numberOfMonths: 1,
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        gotoCurrent: true,
        showButtonPanel: true,
        maxDate: '-12y',
        yearRange: '1300:1450',

    });

    // ===== flight search box =====
    $('.s-u-filters').click(function () {
        $('#s-u-filter-wrapper-ul').animate({
            left: -0,
            opacity : 1
        }, 100);
    });


    if ($(window).width() > 545) {
        $(document).scroll(function () {
            var y = $(window).scrollTop();
            if (y > 5) {
                $('.s-u-filter-wrapper').addClass('s-u-menu-fixed');

            } else {
                $('.s-u-filter-wrapper').removeClass('s-u-menu-fixed');

            }
        });

    }

})(document);


$(document).ready(function () {

    $('.reaserach_toursha').click(function () {


        $('.filtertip-searchbox ').toggleClass('di__inline_block');

    });
});

// inter
// قرار بده این رو اول از همه (قبل از بقیه اسکریپت‌ها یا در بالا)
// (function(){
//   const PARENT = document.getElementById('Flight-parent'); // <-- والدت اینجا
//   if(!PARENT) return;
//
//   // نگهدار متدهای اصلی
//   const _qs  = document.querySelector.bind(document);
//   const _qsa = document.querySelectorAll.bind(document);
//   const _gid = document.getElementById.bind(document);
//   const _gecn = document.getElementsByClassName.bind(document);
//   const _getn = document.getElementsByName ? document.getElementsByName.bind(document) : null;
//   const _gett = document.getElementsByTagName.bind(document);
//
//   document.querySelectorAll = function(sel){
//     // تلاش کن داخل والد پیدا کنی؛ اگر پیدا شد همون نتایج رو برگردون
//     const inside = Array.from(PARENT.querySelectorAll(sel || ''));
//     if(inside.length) return inside;
//     return _qsa(sel);
//   };
//
//   document.querySelector = function(sel){
//     const inside = PARENT.querySelector(sel);
//     if(inside) return inside;
//     return _qs(sel);
//   };
//
//   document.getElementById = function(id){
//     // اول داخل والد بعد سند
//     const inside = PARENT.querySelector('#' + CSS.escape(id));
//     if(inside) return inside;
//     return _gid(id);
//   };
//
//   document.getElementsByClassName = function(name){
//     const inside = Array.from(PARENT.getElementsByClassName(name));
//     if(inside.length) return inside;
//     return _gecn(name);
//   };
//
//   document.getElementsByTagName = function(tag){
//     const inside = Array.from(PARENT.getElementsByTagName(tag));
//     if(inside.length) return inside;
//     return _gett(tag);
//   };
//
//   if(_getn){
//     document.getElementsByName = function(name){
//       const inside = Array.from(PARENT.querySelectorAll(`[name="${name}"]`));
//       if(inside.length) return inside;
//       return _getn(name);
//     };
//   }
//
// })();


$('.add-flight-to-count-passenger-js').on('click', function() {
    getCountPassengersFlight(this, 'add')
})

$('.minus-flight-to-count-passenger-js').on('click', function() {
    getCountPassengersFlight(this, 'minus')
})


$('.box-of-count-passenger-boxes-js,.div_btn').on('click', function(e) {
    $('.cbox-count-passenger-js').toggle()
    $(this).parents().find('.down-count-passenger').toggleClass('fa-caret-up')
    e.stopPropagation()
})
$('.cbox-count-passenger-js').click((e) => {
    e.stopPropagation()
})
$('body').click(() => {
    $('.cbox-count-passenger-js').hide()
    $(this).parents().find('.down-count-passenger').removeClass('fa-caret-up')

})



function checkCountAdult(number_adult) {
    if (parseInt(number_adult) <= 0) {
        $.alert({
            title: useXmltag('BookTicket'),
            icon: 'fa fa-cart-plus',
            content: useXmltag('LeastOneAdult'),
            rtl: true,
            type: 'red',
        })
        return false
    }
    return true
}

function checkCountAdultVsInfant(number_adult, number_infant) {
    if (parseInt(number_infant) > parseInt(number_adult)) {
        $.alert({
            title: useXmltag('BookTicket'),
            icon: 'fa fa-cart-plus',
            content: useXmltag('SumAdultsChildrenNoGreaterThanAdult'),
            rtl: true,
            type: 'red',
        })
        return false
    }
    return true
}

function checkAdultAndChild(number_adult, number_child) {
    if ((parseInt(number_adult )+ parseInt( number_child) ) > 9) {
        $.alert({
            title: useXmltag('BookTicket'),
            icon: 'fa fa-cart-plus',
            content: useXmltag('ErrorAdultCount'),
            rtl: true,
            type: 'red',
        })
        return false
    }
    return true
}

function getCountPassengersFlight(obj, type) {


    let count_passengers = $(obj).siblings('.number-count-js').attr('data-number')
    let type_passengers = $(obj).siblings('.number-count-js').attr('data-type')
    let type_search = $(obj).siblings('.number-count-js').attr('data-search')

    let adult_count  = $('.' + type_search+'-adult-js').val();
    let child_count  = $('.' + type_search+'-child-js').val();
    let infant_count = $('.' + type_search+'-infant-js').val();

    let total_count_value = (parseInt(adult_count) + parseInt(child_count) + parseInt(infant_count)) ;
    let total_count = parseInt(adult_count) == 1 ? (parseInt(adult_count) + 1) : parseInt(total_count_value);
    if(type === 'add') {
        total_count = 1 + parseInt(total_count_value);

    }else{
        total_count = parseInt(total_count_value) - 1 ;
    }

    if(total_count > 9 && type === 'add'){

        $('.' + type_search + '-count-passenger-js').css('color','#ccc').css('border-color','#ccc');
        return false;

    }else{

        $('.add-flight-to-count-passenger-js').removeAttr('style');
        if (count_passengers <= 9) {
            let new_passenger = count_passengers
            if (type === 'add' && count_passengers < 9) {
                new_passenger = ++count_passengers
            } else if (type !== 'add' && count_passengers > 1 && type_passengers === 'adult') {
                new_passenger = --count_passengers
            } else if ( type !== 'add' && count_passengers >= 1 && type_passengers !== 'adult') {
                new_passenger = --count_passengers
            }

            $(obj).siblings('.number-count-js').html(count_passengers)
            $(obj).siblings('.number-count-js').attr('data-number', count_passengers)
            $('.' + type_passengers).val(new_passenger)

        }


        let passenger_adult   = Number($(obj).parents('.box-of-count-passenger-js').find('.adult-number-js .number-count-js').attr('data-number'))
        let passenger_child   = Number($(obj).parents('.box-of-count-passenger-js').find('.child-number-js .number-count-js').attr('data-number'))
        let passenger_infant  = Number($(obj).parents('.box-of-count-passenger-js').find('.infant-number-js .number-count-js').attr('data-number'))

        if (passenger_adult < passenger_infant && (passenger_infant > 0)) {
            console.log(['less if=>',passenger_adult,passenger_infant]);
            $(obj).parents('.box-of-count-passenger-js').find('.infant-number-js .number-count-js').attr('data-number',(passenger_adult )).text(passenger_adult )
            passenger_infant =passenger_adult ;
            $(obj).parents('.box-of-count-passenger-js').find('.infant-number-js').find('.add-flight-to-count-passenger-js').css('color','#ccc').css('border-color','#ccc')

        }

        $('.' + type_search+'-adult-js').val(passenger_adult);
        $('.' + type_search+'-child-js').val(passenger_child);
        $('.' + type_search+'-infant-js').val(passenger_infant);


        $(obj).parents('.box-of-count-passenger-js').find('.text-count-passenger-js').text(`${passenger_adult}   ${useXmltag("Adult")} ,  ${passenger_child}  ${useXmltag("Child")} ,  ${passenger_infant} ${useXmltag("Infant")}`)

        if (passenger_adult === passenger_infant && (passenger_infant > 0)) {
            console.log(['second if=>',$(obj).data('type')]);

            $(obj).parents('.box-of-count-passenger-js').find('.infant-number-js').find('.add-flight-to-count-passenger-js').css('color','#ccc').css('border-color','#ccc')
            return false;
        }

        if(total_count===9){
            console.log('after=>',total_count);
            $('.' + type_search + '-count-passenger-js').css('color','#ccc').css('border-color','#ccc');
        }



    }
}



