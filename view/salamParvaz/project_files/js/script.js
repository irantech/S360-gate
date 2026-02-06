$('.owl-ads1').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
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
            items:1,
        },
        1000:{
            items:1
        }
    }
});
$('.owl-ads2').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 8000,
    autoplaySpeed:1000,
    dots:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1,
        },
        1000:{
            items:1
        }
    }
});

$('.owl-work-team-migration').owlCarousel({
    rtl:true,
    loop:true,
    margin:10,
    nav:false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 8000,
    autoplaySpeed:5000,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:7
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

$(document).ready(function() {


    $('.cbox-package-count-passenger-js').click((e) => {
        e.stopPropagation()
    })
    $('body').click(() => {
        $('.cbox-package-count-passenger-js').hide();
    })


    // if($(window).width() > 576){
    //     $('#Flight-internal-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/u1.jpg")');
    //     });
    //     $('#Flight-international-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/356198391214474779airline.jpg")');
    //     });
    //     $('#Hotel-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/hotel-bg-js.jpg")');
    //     });
    //     $('#Bus-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/bus4.jpg")');
    //     });
    //     $('#Train-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/train6.jpg")');
    //     });
    //     $('#Insurance-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/bimeh-bg-js.jpg")');
    //     });
    //     $('#Tour-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/364496210tour.jpg")');
    //     });
    //     $('#Package-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/bg-hotelParvaz.jpg")');
    //     });
    //     $('#Entertainment-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/tafrihat-bg-js.jpg")');
    //     });
    //     $('#Europcar-tab').click(function (){
    //         $('.banner-safiran').css('background-image', 'url("images/bg-car.jpg")');
    //     });
    // }
});


document.addEventListener('DOMContentLoaded', function() {
    const flightTab = document.getElementById('Flight_internal');
    const buttons = flightTab.querySelectorAll('.btn-switch-searchBox');
    const inputOneWay = document.getElementById('arrival_date_internal');
    const inputReturn = document.getElementById('departure_date_internal');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // حذف کلاس active از همه دکمه‌ها
            buttons.forEach(btn => btn.classList.remove('active'));

            // اضافه کردن کلاس active به دکمه کلیک‌شده
            this.classList.add('active');

            // تغییر وضعیت disabled بر اساس دکمه کلیک‌شده
            if (this.getAttribute('data-text') === 'یک طرفه') {
                inputOneWay.disabled = true;
                inputReturn.disabled = false;
                inputOneWay.parentElement.style.setProperty('opacity', '0.3', 'important');
                inputReturn.parentElement.style.opacity = '1';
            } else if (this.getAttribute('data-text') === 'دو طرفه') {
                inputOneWay.disabled = false;
                inputReturn.disabled = false;
                inputOneWay.parentElement.style.opacity = '1';
                inputReturn.parentElement.style.opacity = '1';
            }
        });
    });

    // تنظیم اولیه بر اساس دکمه active
    const activeButton = flightTab.querySelector('.btn-switch-searchBox.active');
    if (activeButton.textContent === 'یک طرفه') {
        inputOneWay.disabled = true;
        inputOneWay.parentElement.style.opacity = '0.3';
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const flightTab2 = document.getElementById('Flight_external');
    const buttons = flightTab2.querySelectorAll('.btn-switch-searchBox');
    const inputOneWay = document.getElementById('arrival_date_international');
    const inputReturn = document.getElementById('departure_date_international');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // حذف کلاس active از همه دکمه‌ها
            buttons.forEach(btn => btn.classList.remove('active'));

            // اضافه کردن کلاس active به دکمه کلیک‌شده
            this.classList.add('active');

            // تغییر وضعیت disabled بر اساس دکمه کلیک‌شده
            if (this.getAttribute('data-text') === 'یک طرفه') {
                inputOneWay.disabled = true;
                inputReturn.disabled = false;
                inputOneWay.parentElement.style.setProperty('opacity', '0.3', 'important');
                inputReturn.parentElement.style.setProperty('opacity', '1', 'important');
            } else if (this.getAttribute('data-text') === 'رفت و برگشت') {
                inputOneWay.disabled = false;
                inputReturn.disabled = false;
                inputOneWay.parentElement.style.setProperty('opacity', '1', 'important');
                inputReturn.parentElement.style.setProperty('opacity', '1', 'important');

            }
        });
    });

    // تنظیم اولیه بر اساس دکمه active
    const activeButton = flightTab2.querySelector('.btn-switch-searchBox.active');
    if (activeButton.textContent === 'یک طرفه') {
        inputOneWay.disabled = true;
        inputOneWay.parentElement.style.opacity = '0.3';
    }
});

const tourPlusHotelRadio = document.getElementById('rdo-50');
const internalTourRadio = document.getElementById('rdo-40');

const tourPlusHotelInfo = document.getElementById('Package');
const internalTourInfo = document.getElementById('internalTourInfo');

function updateDisplay() {
    if (tourPlusHotelRadio.checked) {
        tourPlusHotelInfo.classList.add('flex');
        internalTourInfo.classList.remove('flex');
    } else if (internalTourRadio.checked) {
        internalTourInfo.classList.add('flex');
        tourPlusHotelInfo.classList.remove('flex');
    }
}

tourPlusHotelRadio.addEventListener('change', updateDisplay);
internalTourRadio.addEventListener('change', updateDisplay);


updateDisplay();



function createAgeInput(index , ageGroup) {
    console.log('ageGroup' ,  ageGroup)
    const ageValue = generateBirthDate(ageGroup); // Generate random age between 18 and 60
    const input = document.createElement('input');
    input.setAttribute('autocomplete', 'off');
    input.setAttribute('class', 'form-control passengers-age-js shamsiBirthdayCalendar');
    input.setAttribute('id', 'txt_birth_insurance' + index);
    input.setAttribute('name', 'txt_birth_insurance' + index);
    input.setAttribute('type', 'hidden');
    input.setAttribute('value', ageValue);
    return input;
}

function generateBirthDate(ageGroup){

    const today = new Date(); // Get current date
    const currentYearShamsi = today.getFullYear() - 621; // Convert Gregorian to Shamsi approximately

    let minYear, maxYear;

    if (ageGroup === "0-12") {
        minYear = currentYearShamsi - 12; // Max 12 years old
        maxYear = currentYearShamsi;      // Min 0 years old
    } else if (ageGroup === "13-64") {
        minYear = currentYearShamsi - 64;
        maxYear = currentYearShamsi - 13;
    } else if (ageGroup === "65-70") {
        minYear = currentYearShamsi - 70; // Max 70 years old
        maxYear = currentYearShamsi - 65; // Min 65 years old
    } else if (ageGroup === "71-75") {
        minYear = currentYearShamsi - 75; // Max 75 years old
        maxYear = currentYearShamsi - 71; // Min 71 years old
    } else if (ageGroup === "76-85") {
        minYear = currentYearShamsi - 85; // Max 85 years old
        maxYear = currentYearShamsi - 76; // Min 76 years old
    } else if (ageGroup === "+81") {
        minYear = currentYearShamsi - 100; // Assume max age 100
        maxYear = currentYearShamsi - 81;  // Min 81 years old
    } else {
        throw new Error("Invalid age group");
    }

    const year = Math.floor(Math.random() * (maxYear - minYear + 1)) + minYear; // Random year within range
    const month = String(Math.floor(Math.random() * 12) + 1).padStart(2, '0'); // Random month 01-12
    const day = String(Math.floor(Math.random() * 29) + 1).padStart(2, '0'); // Random day 01-29

    return `${year}-${month}-${day}`; // Format: YYYY-MM-DD
}

