$('.owl-tour-arshida').owlCarousel({
    rtl:true,
    loop:true,
    margin: 15,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:1000,
    dots:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:2,
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        }
    }
});
function clickScroll(e){
    $("html").animate({
        scrollTop: $(`#${e}`).offset().top - 30
    }, 1000);
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(".select2").select2();


// hide #back-top first
$("#scroll-top").addClass('d-none');
// fade in #back-top
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#scroll-top').addClass('d-flex');
            $('#scroll-top').removeClass('d-none');
        } else {
            $('#scroll-top').removeClass('d-flex');
            $('#scroll-top').addClass('d-none');
        }
    });
    // scroll body to 0px on click
    $('#scroll-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
    });
});


$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('.header_area').addClass('scrolled');
        } else {
            $('.header_area').removeClass('scrolled');
        }
    });
});


//search_flight

$('.Flight_sec_Owl').owlCarousel({
    loop:true,
    rtl:true,
    margin:15,
    nav:true,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d=\"M305 239c9.4 9.4 9.4 24.6 0 33.9L113 465c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l175-175L79 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L305 239z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d=\"M15 239c-9.4 9.4-9.4 24.6 0 33.9L207 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L65.9 256 241 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L15 239z\"/></svg>"],
    dots:false,
    autoplay:true,
    autoplayTimeout: 5000,
    autoplaySpeed:1000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        }
    }
})

//hotel

$('.owl-hotel-ghods').owlCarousel({
    rtl:true,
    loop:true,
    margin: 15,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:1000,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        }
    }
});



function AdvancedInstallmentCalculatorBtn(){
    $(".AdvancedInstallmentCalculatorBox").toggle();
    $(".AdvancedInstallmentCalculatorBtn__open").toggle();
    $(".AdvancedInstallmentCalculatorBtn__close").toggle();
    $("#AdvancedInstallmentCalculatorBox_response_hide").hide();
    $("#AdvancedInstallmentCalculatorBox_response_hide_error").hide();

}

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function Main_AdvancedInstallmentCalculatorBtn(){
    var priceAll = Number((document.getElementById("priceInput").value).replace(/\D+/g, ""));

    // alert(priceAll);
    if(priceAll == ""){
        $("#AdvancedInstallmentCalculatorBox_response_hide").hide();
        $("#error_show_price").show();
        $("#error_show_price").html(useXmltag('PleaseEnterTourPrice'));
    }else if(priceAll < 2000000){
        $("#AdvancedInstallmentCalculatorBox_response_hide").hide();
        $("#error_show_price").show();
        $("#error_show_price").html(useXmltag('MinimumAmountDivided'));
    }else {
        $("#AdvancedInstallmentCalculatorBox_response_hide").show();
        $("#error_show_price").hide();
        var anAmount_tour = $('#anAmount_tour').val();
        if(anAmount_tour==''){
            var persent_discount = document.getElementById("persent_discount").innerText; // دریافت درصد مثلا 20%
            var initialPayment = Number(persent_discount.slice(0, 2)); // گرفتن عبارت %
            var installments = Number(document.getElementById("number_installments").innerText);
            var installmentsPlus = Number(installments + 1);   // تعدا اقساط به اضافه یک
            var initialPaymentPrice = priceAll*(initialPayment/100);  // محاسبه مبلغ پیش پرداخت
            var priceWithOutInitial = ((priceAll-initialPaymentPrice)/installments)+(((priceAll-initialPaymentPrice)*installmentsPlus)/100);
            var amountEachInstallmentWithSoud = (priceWithOutInitial*installments)+initialPaymentPrice;
            $('#result_calculater').html(numberWithCommas(Math.round(initialPaymentPrice))); // پیش پرداخت
            $('#price_all_calculater').html(numberWithCommas(Math.round(amountEachInstallmentWithSoud))); // قیمت کل
            $('#amount_each_installment_calculater').html(numberWithCommas(Math.round(priceWithOutInitial))); // مبلغ هر قسط
        }else{
            var installments = Number(document.getElementById("number_installments").innerText);
            var installmentsPlus = Number(installments + 1);   // تعدا اقساط به اضافه یک
            var initialPaymentPrice = Number(anAmount_tour);  // محاسبه مبلغ پیش پرداخت
            var priceWithOutInitial = ((priceAll-initialPaymentPrice)/installments)+(((priceAll-initialPaymentPrice)*installmentsPlus)/100);
            var amountEachInstallmentWithSoud = (priceWithOutInitial*installments)+initialPaymentPrice;
            $('#result_calculater').html(numberWithCommas(Math.round(initialPaymentPrice))); // پیش پرداخت
            $('#price_all_calculater').html(numberWithCommas(Math.round(amountEachInstallmentWithSoud))); // قیمت کل
            $('#amount_each_installment_calculater').html(numberWithCommas(Math.round(priceWithOutInitial))); // مبلغ هر قسط
        }
    }
    // alert(totalMoney);
}

function getInfoCalculator() {
    var installments = Number($('#installments').val());  // تعداد اقساط
    var installmentsPlus = Number(installments + 1);   // تعدا اقساط به اضافه یک
    var initialPayment = $('#initial_payment').val();   // درصد پیش پرداخت
    var price = $('#price').val();  // قیمت بدون میلیون
    var priceAll = Number(price*Math.pow(10,6)); //  قیمت برحسب میلیون
    var initialPaymentPrice = priceAll*(initialPayment/100);  // محاسبه مبلغ پیش پرداخت
    var priceWithOutInitial = ((priceAll-initialPaymentPrice)/installments)+(((priceAll-initialPaymentPrice)*installmentsPlus)/100);
    var amountEachInstallmentWithSoud = (priceWithOutInitial*installments)+initialPaymentPrice;
    $('#result_calculate').html(numberWithCommas(Math.round(initialPaymentPrice))); // پیش پرداخت
    $('#price_all').html(numberWithCommas(Math.round(amountEachInstallmentWithSoud))); // قیمت کل
    $('#amount_each_installment').html(numberWithCommas(Math.round(priceWithOutInitial))); // محاسبه هر قسط
}

function formatPrice() {
    let priceInput = document.getElementById('priceInput');
    let price = priceInput.value.replace(/\D/g, '');
    if (!isNaN(price)) {
        let formattedPrice = price.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        priceInput.value = formattedPrice;
    }
}

let percentage = 20;
let NumberOfInstallments = 4;

function plus_box_percentage(e){
    if (percentage < 100 ){
        e.currentTarget.parentNode.querySelector('span').innerText = percentage + 10 + '%';
        percentage = percentage + 10;
    }
}

function minus_box_percentage(e){
    if (percentage > 20 ){
        e.currentTarget.parentNode.querySelector('span').innerText = percentage - 10 + '%';
        percentage = percentage - 10;
    }
}

function plus_box_NumberOfInstallments(e){
    if (NumberOfInstallments < 12 ) {
        e.currentTarget.parentNode.querySelector('span').innerText = NumberOfInstallments + 1;
        NumberOfInstallments = NumberOfInstallments + 1;
    }
}

function minus_box_NumberOfInstallments(e){
    if (NumberOfInstallments > 4 ) {
        e.currentTarget.parentNode.querySelector('span').innerText = NumberOfInstallments - 1;
        NumberOfInstallments = NumberOfInstallments - 1;
    }
}

$(document).ready(function () {
    $('[data-rangeslider]').rangeslider({
        polyfill:false,
        rangeClass:'rangeslider',
        disabledClass:'rangeslider--disabled',
        activeClass:'rangeslider--active',
        horizontalClass:'rangeslider--horizontal',
        verticalClass:'rangeslider--vertical',
        fillClass:'rangeslider__fill',
        handleClass:'rangeslider__handle',
        onSlide:function(position, value) {
            console.log("onSlide" , position , value);
            $(".div-rangeslider > h6").text(value)
        }
    });
    $('[data-rangeslider2]').rangeslider({
        polyfill:false,
        rangeClass:'rangeslider',
        disabledClass:'rangeslider--disabled',
        activeClass:'rangeslider--active',
        horizontalClass:'rangeslider--horizontal',
        verticalClass:'rangeslider--vertical',
        fillClass:'rangeslider__fill',
        handleClass:'rangeslider__handle',
        onSlide:function(position, value) {
            console.log("onSlide" , position , value)
            $(".div-rangeslider2 > h6").text(value)
        }
    })
    setTimeout(function () {
        getInfoCalculator();
    }, 100);
    $(".anAmount_btn").click(() => {
        $(".percentage").hide()
        $(".anAmount").show()
        $(".anAmount_btn").addClass("active")
        $(".percentage_btn").removeClass("active")
        console.log("test")
    })
    $(".percentage_btn").click(() => {
        $(".percentage").show()
        $(".anAmount").hide()
        $(".percentage_btn").addClass("active")
        $(".anAmount_btn").removeClass("active")
        $('#anAmount_tour').val('');


    })
});