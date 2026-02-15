
$('.owl-blog').owlCarousel({
    rtl:true,
    loop:true,
    margin:20,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:3000,
    dots: true,
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
$('.owl-hotel-ghods').owlCarousel({
    rtl:true,
    loop:true,
    margin:30,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 15000,
    autoplaySpeed:5000,
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
        }
    }
});
$('.owl-airlines').owlCarousel({
    rtl:true,
    loop:true,
    margin:20,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed: 1000,
    dots:true,
    responsive:{
        0:{
            items: 3,
            dots: false,
        },
        600:{
            items:5,
        },
        1000:{
            items:8
        }
    }
});

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

$('.back-to-top').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
});


// کد برای انتخاب نفر در بیمه
//----------------------start passenger Count js-----------------------------//
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggleBime = document.querySelector('.dropdown-toggle-insurance');
    const dropdownMenu = document.querySelector('.dropdown-menu-insurance');
    const increaseButtons = document.querySelectorAll('.increase');
    const decreaseButtons = document.querySelectorAll('.decrease');

    function updateTotalPassengers() {
        const counts = document.querySelectorAll('.counter-insurance span');
        let total = 0;
        counts.forEach((count ,index) => {
            const countValue = parseInt(count.textContent);
            total += countValue;
        });
        if(dropdownToggleBime != null) {
            if (total > 0 ) {
                dropdownToggleBime.textContent = total + ' مسافر';
            } else {
                dropdownToggleBime.textContent = 'تعداد مسافر';
            }
        }
        $('#passengers-count-js').val(total);
    }

    if (dropdownToggleBime != null) {
        // باز و بسته کردن منو با کلیک روی دکمه
        dropdownToggleBime.addEventListener('click', function(event) {
            event.stopPropagation(); // جلوگیری از انتشار رویداد به body
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        // بستن منو با کلیک خارج از آن
        document.addEventListener('click', function(event) {
            if (!dropdownMenu.contains(event.target) && !dropdownToggleBime.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }


    increaseButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const countSpan = this.parentElement.querySelector('span');
            let group = this.getAttribute('data-age')
            let count = parseInt(countSpan.textContent);
            countSpan.textContent = count + 1;
            updateTotalPassengers();
            const newInput = createAgeInput(index + '-' + count , group);
            this.parentElement.parentElement.appendChild(newInput);
        });
    });

    decreaseButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const countSpan = this.parentElement.querySelector('span');
            let count = parseInt(countSpan.textContent);
            if (count > 0) {
                countSpan.textContent = count - 1;
                updateTotalPassengers();
                const inputId = 'txt_birth_insurance' + index + '-' + (count - 1);
                const inputToRemove = document.getElementById(inputId);
                if (inputToRemove) {
                    inputToRemove.remove();
                }
            }
        });
    });

    updateTotalPassengers();
});

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

//----------------------end passenger Count js-----------------------------//

$(".dropdown_custom > div").hide()
$(".dropdown_custom > button").click((e) => {
    $(".dropdown_custom > div").toggle()
    e.stopPropagation()
})
$(".dropdown_custom > button").click((e) => {
    // console.log($(".dropdown_custom > button > span"))
    $(".dropdown_custom > button > span").text(e.target.innerText);
    // console.log(e.target.innerText)
})
$("html,body").click(() => {
    $(".dropdown_custom > div").hide()
})
function textInput(e) {
    $(".dropdown_custom > button > span").text(e);

}




