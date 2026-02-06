



if (window.innerWidth <= 576) {
    const openSheetButton = document.querySelectorAll('.sheet-js');
    const closeSheetButton = document.getElementById('closeSheet');
    const bottomSheet = document.getElementById('bottomSheet');
    const overlay = document.getElementById('overlay');
    const handle = document.querySelector('.handle');

// Open bottom sheet
    openSheetButton.forEach(tab => {
        tab.addEventListener('click', () => {
            // Reset transform before adding open class
            bottomSheet.style.transform = 'translateY(100%)';
            // Use setTimeout to ensure the initial transform is applied before transition
            setTimeout(() => {
                bottomSheet.style.transform = 'translateY(0)';
                bottomSheet.classList.add('open');
                overlay.classList.add('active');
                document.body.classList.add('no-scroll');
            }, 10);
        });
    });

// Close bottom sheet with X button
    closeSheetButton.addEventListener('click', closeBottomSheet);

// Close bottom sheet with overlay
    overlay.addEventListener('click', closeBottomSheet);

    function closeBottomSheet() {
        bottomSheet.classList.remove('open');
        overlay.classList.remove('active');
        document.body.classList.remove('no-scroll');
        bottomSheet.style.transform = 'translateY(100%)';
        currentTranslateY = 0; // Reset the translation tracking
    }

// Drag functionality
    let isDragging = false;
    let startY, startTranslateY;
    let currentTranslateY = 0;

    handle.addEventListener('mousedown', (e) => {
        isDragging = true;
        startY = e.clientY;
        startTranslateY = getTranslateY(bottomSheet);
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
    });

    handle.addEventListener('touchstart', (e) => {
        isDragging = true;
        startY = e.touches[0].clientY;
        startTranslateY = getTranslateY(bottomSheet);
        document.addEventListener('touchmove', onTouchMove);
        document.addEventListener('touchend', onTouchEnd);
    });

    function onMouseMove(e) {
        if (!isDragging) return;
        const deltaY = e.clientY - startY;
        const newTranslateY = startTranslateY + deltaY;
        if (newTranslateY >= 0) {
            currentTranslateY = newTranslateY;
            bottomSheet.style.transform = `translateY(${newTranslateY}px)`;
        }
    }

    function onMouseUp() {
        if (!isDragging) return;
        isDragging = false;
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
        snapBottomSheet();
    }

    function onTouchMove(e) {
        if (!isDragging) return;
        const deltaY = e.touches[0].clientY - startY;
        const newTranslateY = startTranslateY + deltaY;
        if (newTranslateY >= 0) {
            currentTranslateY = newTranslateY;
            bottomSheet.style.transform = `translateY(${newTranslateY}px)`;
        }
    }

    function onTouchEnd() {
        if (!isDragging) return;
        isDragging = false;
        document.removeEventListener('touchmove', onTouchMove);
        document.removeEventListener('touchend', onTouchEnd);
        snapBottomSheet();
    }

// Modified snap function to only allow fully open or closed states
    function snapBottomSheet() {
        const sheetHeight = bottomSheet.offsetHeight;
        const dragThreshold = sheetHeight * 0.3; // 30% of sheet height as threshold

        if (currentTranslateY > dragThreshold) {
            // If dragged more than threshold, close the sheet
            closeBottomSheet();
        } else {
            // If dragged less than threshold, snap back to fully open
            bottomSheet.style.transform = 'translateY(0)';
            currentTranslateY = 0; // Reset the translation tracking
        }
    }

    function getTranslateY(element) {
        const style = window.getComputedStyle(element);
        const transform = style.transform;
        if (transform === 'none') return 0;
        const matrix = transform.match(/matrix.*\((.+)\)/)[1].split(', ');
        return parseFloat(matrix[5] || matrix[13]);
    }
}






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












// fade in #back-top
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#scroll-top').addClass('active-btn-down');
            $('#scroll-top').removeClass('active-btn-up');
        } else {
            $('#scroll-top').removeClass('active-btn-down');
            $('#scroll-top').addClass('active-btn-up');
        }
    });
    // scroll body to 0px on click
    $('#scroll-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
    });
});

// تغییر عکس بنر و نوشته بنر
if (window.innerWidth > 576) {  // فقط برای دسکتاپ
    document.querySelectorAll('#searchBoxTabs li a').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const mainData = [
                {
                    index: 'Flight',
                    title: 'رزرو بلیط هواپیما داخلی و خارجی',
                    description: ' برای خرید آنلاین بلیط هواپیما در ﻣﻨﺼﻮر ﺳﯿﺮ ﻣﻌﯿﻦ کافیست مبدا، مقصد و تاریخ پرواز خود را انتخاب کنید. ',
                    image: 'gds/view/demo360/project_files/images/bg-parvaz.jpg',
                },
                {
                    index: 'Hotel',
                    title: 'رزرو هتل‌های داخلی و خارجی با بهترین قیمت',
                    description: ' بهترین هتل‌ها را در داخل و خارج از کشور با تخفیف‌های ویژه رزرو کنید و از سفری راحت و بی‌دغدغه لذت ببرید.  ',
                    image: 'gds/view/demo360/project_files/images/bg-hotel.jpg',
                },
                {
                    index: 'Package',
                    title: 'پرواز + هتل؛ سفری آسان و به‌یادماندنی',
                    description: ' ترکیب پرواز و هتل برای سفری آسان و به‌یادماندنی، با انتخاب بهترین گزینه‌ها برای شما.  ',
                    image: 'gds/view/demo360/project_files/images/bg-hotelParvaz.jpg',
                },
                {
                    index: 'Train',
                    title: 'رزرو آسان بلیط قطارهای داخلی ',
                    description: ' بلیط قطارهای داخلی را با بهترین قیمت و تخفیف‌های ویژه تهیه کنید و از سفری آسوده و مطمئن لذت ببرید.   ',
                    image: 'gds/view/demo360/project_files/images/bg-train.jpg',
                },
                {
                    index: 'Bus',
                    title: 'سفر راحت با رزرو بلیط اتوبوس‌های داخلی ',
                    description: '  ﻣﻨﺼﻮر ﺳﯿﺮ ﻣﻌﯿﻦ بهترین گزینه‌ها را برای رزرو بلیط اتوبوس‌های داخلی با قیمت‌های مناسب و خدمات عالی ارائه می‌دهد.    ',
                    image: 'gds/view/demo360/project_files/images/bg-bus.jpg',
                },
                {
                    index: 'Insurance',
                    title: 'بیمه مسافرتی مطمئن برای سفرهای داخلی و خارجی',
                    description: ' بهترین بیمه مسافرتی با پوشش‌های جامع و قیمت‌های رقابتی را تهیه کنید و با خیال راحت به سفرهای داخلی و خارجی بروید. ',
                    image: 'gds/view/demo360/project_files/images/bg-bime.jpg',
                },
                {
                    index: 'Tour',
                    title: 'تورهای ویژه داخلی و خارجی با خدمات استثنایی',
                    description: 'با ﻣﻨﺼﻮر ﺳﯿﺮ ﻣﻌﯿﻦ، سفرهای داخلی و خارجی خود را به تورهایی فراموش‌ نشدنی تبدیل کنید. ',
                    image: 'gds/view/demo360/project_files/images/bg-tour.jpg',
                },
                {
                    index: 'Entertainment',
                    title: 'تفریحات جذاب و هیجان‌انگیز در مقصدهای داخلی و خارجی',
                    description: 'بهترین و متنوع‌ترین تفریحات را در سفرهای داخلی و خارجی خود تجربه کنید. از فعالیت‌های هیجان‌انگیز تا لحظات آرامش‌بخش.',
                    image: 'gds/view/demo360/project_files/images/bg-tafrihat.jpg',
                },
                {
                    index: 'Visa',
                    title: 'اخذ ویزای سریع و مطمئن برای مقاصد بین‌المللی',
                    description: 'فرآیند اخذ ویزا را به سادگی و با اطمینان کامل انجام دهید و به راحتی برای سفرهای بین‌المللی خود آماده شوید.',
                    image: 'gds/view/demo360/project_files/images/bg-visa.jpg',
                },
                {
                    index: 'Europcar',
                    title: 'اجاره خودرو با شرایط عالی برای سفرهای داخلی و خارجی',
                    description: 'با ﻣﻨﺼﻮر ﺳﯿﺮ ﻣﻌﯿﻦ، خودروهای باکیفیت و متنوع را با قیمت‌های مناسب و شرایط انعطاف‌پذیر اجاره کنید. ',
                    image: 'gds/view/demo360/project_files/images/bg-car.jpg',
                },
            ];

            const dataName = link.dataset.name;
            const filteredData = mainData.find(item => item.index === dataName);

            if (filteredData) {
                const bgBanner = document.getElementById('bg-banner-demo');
                const titleBanner = document.getElementById('title-banner');
                const captionBanner = document.getElementById('caption-banner');

                if (bgBanner && titleBanner && captionBanner) {
                    bgBanner.style.backgroundImage = `url(${filteredData.image})`;
                    titleBanner.textContent = filteredData.title;
                    captionBanner.textContent = filteredData.description;
                }
            } else {
                console.warn('داده‌ای با این نام یافت نشد:', dataName);
            }
        });
    });
}


// کد برای انتخاب نفر در بیمه
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
// کد برای دیسیبل بودن اینپوت های رفت
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.parent-input-search-box input');

    inputs.forEach(input => {
        if (input.hasAttribute('disabled')) {
            input.parentElement.style.opacity = '0.3';
        }
    });
});

const switchWay = document.querySelectorAll('.dropdown-menu .switch-way-js');

switchWay.forEach((item) =>{
    item.addEventListener('click' , function(event){
        console.log(event.target)
    })
})


const dropdown2 = document.getElementById('dropdown-flight-internal-external');
const dropdownContent = document.getElementById('flight-dropdown');
const dropdownIcon = document.getElementById('dropdown-icon');

function toggleDropdown() {
    dropdownContent.classList.toggle('activeDropdown');
    // dropdownIcon.classList.toggle('active-internal-external-svg');
}
document.body.addEventListener('click', function(event) {
if(dropdown2){

    if (!dropdown2.contains(event.target)) {
        dropdownContent.classList.remove('activeDropdown');
        dropdownIcon.classList.remove('active-internal-external-svg');
    }
}
});


function selectOptionBtnInternalExternal(optionText, type) {
    const toggleText = document.getElementById('toggle-text');
    const internalContent = document.querySelector('.internal-content-flight');
    const externalContent = document.querySelector('.external-content-flight');


    const boxDakheli = document.querySelector('.parent-dakheli-cheng');
    const boxKharegi = document.querySelector('.parent-kharegi-cheng');


    toggleText.innerText = optionText;

    if (type === 'internal') {
        internalContent.style.display = 'flex';
        externalContent.style.display = 'none';

        toggleText.innerText = optionText;
        boxDakheli.style.display = 'flex';
        boxKharegi.style.display = 'none';
    } else {
        internalContent.style.display = 'none';
        externalContent.style.display = 'flex';

        boxDakheli.style.display = 'none';
        boxKharegi.style.display = 'flex';
        toggleText.innerText = optionText;
    }

    // بستن dropdown بعد از انتخاب
    document.getElementById('flight-dropdown').style.display = 'none';
    document.getElementById('dropdown-icon').style.transform = 'rotate(0deg)';
}



// تعیین گزینه اکتیو به صورت اولیه
document.addEventListener('DOMContentLoaded', function() {
    initializeToggleContent();
});

function initializeToggleContent() {
    const toggleTextElement = document.getElementById('toggle-text');

    // بررسی وجود عنصر با شناسه 'toggle-text'
    if (toggleTextElement) {
        const initialOption = toggleTextElement.innerText.trim(); // trim برای حذف فاصله‌های اضافی

        if (initialOption === 'داخلی') {
            document.querySelector('.internal-content-flight').style.display = 'flex';
            document.querySelector('.external-content-flight').style.display = 'none';
        } else {
            document.querySelector('.internal-content-flight').style.display = 'none';
            document.querySelector('.external-content-flight').style.display = 'flex';
        }
    }
}



// برای هتل؟
function selectOptionBtnInternalExternalHotel(optionText, type) {
    const toggleText = document.getElementById('toggle-text-hotel');
    const internalContent = document.querySelector('.internal-content-hotel');
    const externalContent = document.querySelector('.external-content-hotel');


    toggleText.innerText = optionText;

    if (type === 'internal') {
        internalContent.style.display = 'flex';
        externalContent.style.display = 'none';
        toggleText.innerText = optionText;
    } else {
        internalContent.style.display = 'none';
        externalContent.style.display = 'flex';
        toggleText.innerText = optionText;
    }

    // بستن dropdown بعد از انتخاب
    document.getElementById('hotel-dropdown').style.display = 'none';
    document.getElementById('dropdown-icon-hotel').style.transform = 'rotate(0deg)';
}


const dropdownHotel = document.getElementById('dropdown-hotel-internal-external');
const dropdownContentHotel = document.getElementById('hotel-dropdown');
const dropdownIconHotel = document.getElementById('dropdown-icon-hotel');

function toggleDropdownHotel() {
    dropdownContentHotel.classList.toggle('activeDropdown');
    dropdownIcon.classList.toggle('active-internal-external-svg');
}
document.body.addEventListener('click', function(event) {
    if(dropdownHotel){

        if (!dropdownHotel.contains(event.target)) {
            dropdownContentHotel.classList.remove('activeDropdown');
            dropdownIconHotel.classList.remove('active-internal-external-svg');
        }
    }
});

if(dropdownHotel){

    dropdownHotel.addEventListener('click', function(event) {
        event.stopPropagation();
    });
}


// start
// یک طرفه دو طرفه داخلی
const dropdownToggleChengDakheli = document.querySelector('#Flight .parent-dakheli-cheng .dropdown-toggle-cheng');
const dropdownMenuDakheli = document.querySelector('#Flight .parent-dakheli-cheng #dropdown-menu-dakheli');
const dropdownTextDakheli = document.querySelector('#Flight .parent-dakheli-cheng .dropdown-text');
const menuItemsDakheli = document.querySelectorAll('#Flight .parent-dakheli-cheng .switch-way-js');


if (dropdownToggleChengDakheli !== null) {
    dropdownToggleChengDakheli.addEventListener('click', function() {

        dropdownMenuDakheli.classList.toggle('activeDropdown');
    });
}



const flightInputInternal = document.getElementById('arrival_date_internal');

menuItemsDakheli.forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.stopPropagation(); // جلوگیری از انتقال رویداد به والدین
        dropdownTextDakheli.textContent = this.textContent;
        dropdownMenuDakheli.classList.remove('activeDropdown'); // بستن منو پس از انتخاب


        if(e.target.getAttribute('data-text') === 'یک طرفه'){
            flightInputInternal.parentElement.style.opacity='0.3';
            flightInputInternal.disabled = true;

        } if (e.target.getAttribute('data-text') === 'رفت و برگشت') {
            flightInputInternal.parentElement.style.opacity='1';
            flightInputInternal.disabled = false;

        }
    });
});

// بستن منو با کلیک بیرون از آن
// window.addEventListener('click', function(e) {
//     if (!dropdownToggleChengDakheli.contains(e.target) && !dropdownMenuDakheli.contains(e.target)) {
//         dropdownMenuDakheli.classList.remove('activeDropdown');
//     }
// });
// end


// start
// یک طرفه دو طرفه خارجی
const dropdownToggleChengKharegi = document.querySelector('#Flight .parent-kharegi-cheng .dropdown-toggle-cheng');
const dropdownMenuKharegi = document.querySelector('#Flight .parent-kharegi-cheng #dropdown-menu-kharegi');
const dropdownTextKharegi = document.querySelector('#Flight .parent-kharegi-cheng .dropdown-text');
const menuItemsKharegi = document.querySelectorAll('#Flight .parent-kharegi-cheng .switch-way-js');

const internalContent = document.querySelector('.internal-content-flight');
const externalContent = document.querySelector('.external-content-flight');

if (dropdownToggleChengKharegi !== null) {
    dropdownToggleChengKharegi.addEventListener('click', function() {

        dropdownMenuKharegi.classList.toggle('activeDropdown');
    });
}


const flightInputInternational = document.getElementById('arrival_date_international');

menuItemsKharegi.forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.stopPropagation(); // جلوگیری از انتقال رویداد به والدین

        // بررسی وجود dropdownTextKharegi و dropdownMenuKharegi
        if (!dropdownTextKharegi || !dropdownMenuKharegi) {
            console.error("Element not found: dropdownTextKharegi or dropdownMenuKharegi");
            return;
        }

        dropdownTextKharegi.textContent = this.textContent;
        dropdownMenuKharegi.classList.remove('activeDropdown'); // بستن منو پس از انتخاب

        if(e.target.getAttribute('data-text') === 'یک طرفه'){
            if (flightInputInternational && flightInputInternational.parentElement) {
                flightInputInternational.parentElement.style.opacity='0.3';
                flightInputInternational.disabled = true;
            }

            if (externalContent) {
                externalContent.style.display = 'flex';
            }
        }
        else if (e.target.getAttribute('data-text') === 'رفت و برگشت') {
            if (flightInputInternational && flightInputInternational.parentElement) {
                flightInputInternational.parentElement.style.opacity='1';
                flightInputInternational.disabled = false;
            }

            if (externalContent) {
                externalContent.style.display = 'flex';
            }
        }
        else if(e.target.getAttribute('data-text') === 'چند مسیره'){
            if (internalContent) {
                internalContent.style.display = 'none';
            }
            if (externalContent) {
                externalContent.style.display = 'none';
            }
        }
    });
});

// بستن منو با کلیک بیرون از آن
    window.addEventListener('click', function(e) {
        if (!dropdownToggleChengKharegi.contains(e.target) && !dropdownMenuKharegi.contains(e.target)) {
            dropdownMenuKharegi.classList.remove('activeDropdown');
        }
    });
// end



// start
// یک طرفه دو طرفه قطار
//     const dropdownToggleChengTrain = document.querySelector('#Train .dropdown-toggle-cheng-train');
//     const dropdownMenuTrain = document.querySelector('#Train .dropdown-menu-train');
//     const dropdownTextTrain = document.querySelector('#Train .dropdown-text-train');
//     const menuItemsTrain = document.querySelectorAll('#Train .switch-way-js');
//
//     if (dropdownToggleChengTrain !== null) {
//         dropdownToggleChengTrain.addEventListener('click', function() {
//
//             dropdownMenuTrain.classList.toggle('activeDropdown');
//         });
//     }
//
//     const trainInput = document.getElementById('train_arrival_date');
//
//
//     menuItemsTrain.forEach(function(item) {
//         item.addEventListener('click', function(e) {
//             e.stopPropagation(); // جلوگیری از انتقال رویداد به والدین
//             dropdownTextTrain.textContent = this.textContent;
//             dropdownMenuTrain.classList.remove('activeDropdown'); // بستن منو پس از انتخاب
//
//
//             if(e.target.getAttribute('data-text') === 'یک طرفه'){
//                 trainInput.parentElement.style.opacity='0.3';
//                 trainInput.disabled = true;
//
//             } if (e.target.getAttribute('data-text') === 'رفت و برگشت') {
//                 trainInput.parentElement.style.opacity='1';
//                 trainInput.disabled = false;
//
//             }
//         });
//     });
//
// // بستن منو با کلیک بیرون از آن
// window.addEventListener('click', function(e) {
//     // بررسی وجود dropdownToggleChengTrain و dropdownMenuTrain
//     if (dropdownToggleChengTrain && dropdownMenuTrain) {
//         if (!dropdownToggleChengTrain.contains(e.target) && !dropdownMenuTrain.contains(e.target)) {
//             dropdownMenuTrain.classList.remove('activeDropdown');
//         }
//     }
// });
// end



$('.owl-tour-demo').owlCarousel({
    rtl:true,
    loop:true,
    margin:20,
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
            items:4
        }
    }
});
$('.owl-hotel-demo').owlCarousel({
    rtl:true,
    loop:true,
    margin:20,
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
            items:4
        }
    }
});



// برای تور
function selectOptionBtnInternalExternalTour(optionText, type) {
    const toggleText = document.getElementById('toggle-text-tour');
    const internalContent = document.querySelector('.internal-content-tour');
    const externalContent = document.querySelector('.external-content-tour');


    toggleText.innerText = optionText;

    if (type === 'internal') {
        internalContent.style.display = 'flex';
        externalContent.style.display = 'none';
        toggleText.innerText = optionText;
    } else {
        internalContent.style.display = 'none';
        externalContent.style.display = 'flex';
        toggleText.innerText = optionText;
    }

    // بستن dropdown بعد از انتخاب
    document.getElementById('tour-dropdown').style.display = 'none';
    document.getElementById('dropdown-icon-tour').style.transform = 'rotate(0deg)';
}


const dropdownTour = document.getElementById('dropdown-tour-internal-external');
const dropdownContentTour = document.getElementById('tour-dropdown');
const dropdownIconTour = document.getElementById('dropdown-icon-tour');

function toggleDropdownTour() {
    dropdownContentTour.classList.toggle('activeDropdown');
    // dropdownIconTour.classList.toggle('active-internal-external-svg');
}
document.body.addEventListener('click', function(event) {
    if(dropdownTour){

        if (!dropdownTour.contains(event.target)) {
            dropdownContentTour.classList.remove('activeDropdown');
            dropdownIconTour.classList.remove('active-internal-external-svg');
        }
    }
});
if(dropdownTour){

    dropdownTour.addEventListener('click', function(event) {
        event.stopPropagation();
    });

}

// // گرفتن المان‌های مورد نظر
//     const dropdownToggle = document.getElementById('dropdown-toggle');
//     const dropdownMenu = document.getElementById('dropdown-menu');
//     const dropdownText = document.getElementById('dropdown-text');
//     const menuItems = document.querySelectorAll('.switch-way-js');
//
//
//     dropdownToggle.addEventListener('click', function() {
//
//         dropdownMenu.classList.toggle('activeDropdown');
//     });
//
//     const flightInputInternal = document.getElementById('arrival_date_internal');
//     const flightInputInternational = document.getElementById('arrival_date_international');
// // تابع برای انتخاب آیتم و بستن منو
//     menuItems.forEach(function(item) {
//         item.addEventListener('click', function(e) {
//             e.stopPropagation(); // جلوگیری از انتقال رویداد به والدین
//             dropdownText.textContent = this.textContent;
//             dropdownMenu.classList.remove('activeDropdown'); // بستن منو پس از انتخاب
//
//
//             if(e.target.getAttribute('data-text') === 'یک طرفه'){
//                 flightInputInternal.parentElement.style.opacity='0.3';
//                 flightInputInternal.disabled = true;
//                 flightInputInternational.parentElement.style.opacity='0.3';
//                 flightInputInternational.disabled = true;
//             } if (e.target.getAttribute('data-text') === 'رفت و برگشت') {
//                 flightInputInternal.parentElement.style.opacity='1';
//                 flightInputInternal.disabled = false;
//                 flightInputInternational.parentElement.style.opacity='1';
//                 flightInputInternational.disabled = false;
//             }
//
//         });
//     });
//
// // بستن منو با کلیک بیرون از آن
//     window.addEventListener('click', function(e) {
//         if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
//             dropdownMenu.classList.remove('activeDropdown');
//         }
//     });







// به دایو سرچ باکس یه container اضافه کردم
// const checkWidth = ()=>{
//     const addContainer = document.querySelector('.search_box');
//     window.innerWidth <= 992 ? addContainer.classList.add('container') : addContainer.classList.remove('container');
// }
// checkWidth();
// window.addEventListener('resize',checkWidth);


    $('.owl-tour-demo').owlCarousel({
        rtl:true,
        loop:true,
        margin:20,
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
                items:4
            }
        }
    });
    $('.owl-hotel-demo').owlCarousel({
        rtl:true,
        loop:true,
        margin:20,
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
                items:4
            }
        }
    });


// particlesJS("particles-js", {
//     particles: {
//         number: {
//             value: 200,
//             density: {
//                 enable: true,
//                 value_area: 800,
//             },
//         },
//         color: {
//             value: "#f0c394",
//         },
//         opacity: {
//             value: 0.3,
//             random: false,
//             anim: {
//                 enable: false,
//                 speed: 1,
//                 opacity_min: 0.1,
//                 sync: false,
//             },
//         },
//         size: {
//             value: 3,
//             random: true,
//             anim: {
//                 enable: false,
//                 speed: 40,
//                 size_min: 0.1,
//                 sync: false,
//             },
//         },
//         line_linked: {
//             enable: true,
//             distance: 150,
//             color: "#eee",
//             opacity: 0.3,
//             width: 1,
//         },
//         move: {
//             enable: true,
//             speed: 0.5,
//             direction: "none",
//             random: false,
//             straight: false,
//             out_mode: "out",
//             bounce: false,
//             attract: {
//                 enable: false,
//                 rotateX: 600,
//                 rotateY: 1200,
//             },
//         },
//     },
//     retina_detect: true,
// });



// // Thanks : particle.js
// //----ANIMATED HEADER---//
// ! function(t, e) {
//     "use strict";
//     var i = t.GreenSockGlobals = t.GreenSockGlobals || t;
//     if (!i.TweenLite) {
//         var n, s, r, a, o, h = function(t) {
//               var e, n = t.split("."),
//                 s = i;
//               for (e = 0; n.length > e; e++) s[n[e]] = s = s[n[e]] || {};
//               return s
//           },
//           l = h("com.greensock"),
//           _ = 1e-10,
//           u = function(t) {
//               var e, i = [],
//                 n = t.length;
//               for (e = 0; e !== n; i.push(t[e++]));
//               return i
//           },
//           c = function() {},
//           p = function() {
//               var t = Object.prototype.toString,
//                 e = t.call([]);
//               return function(i) {
//                   return null != i && (i instanceof Array || "object" == typeof i && !!i.push && t.call(i) === e)
//               }
//           }(),
//           f = {},
//           m = function(n, s, r, a) {
//               this.sc = f[n] ? f[n].sc : [], f[n] = this, this.gsClass = null, this.func = r;
//               var o = [];
//               this.check = function(l) {
//                   for (var _, u, c, p, d = s.length, g = d; --d > -1;)(_ = f[s[d]] || new m(s[d], [])).gsClass ? (o[d] = _.gsClass, g--) : l && _.sc.push(this);
//                   if (0 === g && r)
//                       for (u = ("com.greensock." + n).split("."), c = u.pop(), p = h(u.join("."))[c] = this.gsClass = r.apply(r, o), a && (i[c] = p, "function" == typeof define && define.amd ? define((t.GreenSockAMDPath ? t.GreenSockAMDPath + "/" : "") + n.split(".").pop(), [], function() {
//                           return p
//                       }) : n === e && "undefined" != typeof module && module.exports && (module.exports = p)), d = 0; this.sc.length > d; d++) this.sc[d].check()
//               }, this.check(!0)
//           },
//           d = t._gsDefine = function(t, e, i, n) {
//               return new m(t, e, i, n)
//           },
//           g = l._class = function(t, e, i) {
//               return e = e || function() {}, d(t, [], function() {
//                   return e
//               }, i), e
//           };
//         d.globals = i;
//         var v = [0, 0, 1, 1],
//           w = [],
//           y = g("easing.Ease", function(t, e, i, n) {
//               this._func = t, this._type = i || 0, this._power = n || 0, this._params = e ? v.concat(e) : v
//           }, !0),
//           T = y.map = {},
//           P = y.register = function(t, e, i, n) {
//               for (var s, r, a, o, h = e.split(","), _ = h.length, u = (i || "easeIn,easeOut,easeInOut").split(","); --_ > -1;)
//                   for (r = h[_], s = n ? g("easing." + r, null, !0) : l.easing[r] || {}, a = u.length; --a > -1;) o = u[a], T[r + "." + o] = T[o + r] = s[o] = t.getRatio ? t : t[o] || new t
//           };
//         for (r = y.prototype, r._calcEnd = !1, r.getRatio = function(t) {
//             if (this._func) return this._params[0] = t, this._func.apply(null, this._params);
//             var e = this._type,
//               i = this._power,
//               n = 1 === e ? 1 - t : 2 === e ? t : .5 > t ? 2 * t : 2 * (1 - t);
//             return 1 === i ? n *= n : 2 === i ? n *= n * n : 3 === i ? n *= n * n * n : 4 === i && (n *= n * n * n * n), 1 === e ? 1 - n : 2 === e ? n : .5 > t ? n / 2 : 1 - n / 2
//         }, n = ["Linear", "Quad", "Cubic", "Quart", "Quint,Strong"], s = n.length; --s > -1;) r = n[s] + ",Power" + s, P(new y(null, null, 1, s), r, "easeOut", !0), P(new y(null, null, 2, s), r, "easeIn" + (0 === s ? ",easeNone" : "")), P(new y(null, null, 3, s), r, "easeInOut");
//         T.linear = l.easing.Linear.easeIn, T.swing = l.easing.Quad.easeInOut;
//         var b = g("events.EventDispatcher", function(t) {
//             this._listeners = {}, this._eventTarget = t || this
//         });
//         r = b.prototype, r.addEventListener = function(t, e, i, n, s) {
//             s = s || 0;
//             var r, h, l = this._listeners[t],
//               _ = 0;
//             for (null == l && (this._listeners[t] = l = []), h = l.length; --h > -1;) r = l[h], r.c === e && r.s === i ? l.splice(h, 1) : 0 === _ && s > r.pr && (_ = h + 1);
//             l.splice(_, 0, {
//                 c: e,
//                 s: i,
//                 up: n,
//                 pr: s
//             }), this !== a || o || a.wake()
//         }, r.removeEventListener = function(t, e) {
//             var i, n = this._listeners[t];
//             if (n)
//                 for (i = n.length; --i > -1;)
//                     if (n[i].c === e) return void n.splice(i, 1)
//         }, r.dispatchEvent = function(t) {
//             var e, i, n, s = this._listeners[t];
//             if (s)
//                 for (e = s.length, i = this._eventTarget; --e > -1;) n = s[e], n.up ? n.c.call(n.s || i, {
//                     type: t,
//                     target: i
//                 }) : n.c.call(n.s || i)
//         };
//         var S = t.requestAnimationFrame,
//           k = t.cancelAnimationFrame,
//           x = Date.now || function() {
//               return (new Date).getTime()
//           },
//           A = x();
//         for (n = ["ms", "moz", "webkit", "o"], s = n.length; --s > -1 && !S;) S = t[n[s] + "RequestAnimationFrame"], k = t[n[s] + "CancelAnimationFrame"] || t[n[s] + "CancelRequestAnimationFrame"];
//         g("Ticker", function(t, e) {
//             var i, n, s, r, h, l = this,
//               u = x(),
//               p = e !== !1 && S,
//               f = 500,
//               m = 33,
//               d = function(t) {
//                   var e, a, o = x() - A;
//                   o > f && (u += o - m), A += o, l.time = (A - u) / 1e3, e = l.time - h, (!i || e > 0 || t === !0) && (l.frame++, h += e + (e >= r ? .004 : r - e), a = !0), t !== !0 && (s = n(d)), a && l.dispatchEvent("tick")
//               };
//             b.call(l), l.time = l.frame = 0, l.tick = function() {
//                 d(!0)
//             }, l.lagSmoothing = function(t, e) {
//                 f = t || 1 / _, m = Math.min(e, f, 0)
//             }, l.sleep = function() {
//                 null != s && (p && k ? k(s) : clearTimeout(s), n = c, s = null, l === a && (o = !1))
//             }, l.wake = function() {
//                 null !== s ? l.sleep() : l.frame > 10 && (A = x() - f + 5), n = 0 === i ? c : p && S ? S : function(t) {
//                     return setTimeout(t, 0 | 1e3 * (h - l.time) + 1)
//                 }, l === a && (o = !0), d(2)
//             }, l.fps = function(t) {
//                 return arguments.length ? (i = t, r = 1 / (i || 60), h = this.time + r, void l.wake()) : i
//             }, l.useRAF = function(t) {
//                 return arguments.length ? (l.sleep(), p = t, void l.fps(i)) : p
//             }, l.fps(t), setTimeout(function() {
//                 p && (!s || 5 > l.frame) && l.useRAF(!1)
//             }, 1500)
//         }), r = l.Ticker.prototype = new l.events.EventDispatcher, r.constructor = l.Ticker;
//         var R = g("core.Animation", function(t, e) {
//             if (this.vars = e = e || {}, this._duration = this._totalDuration = t || 0, this._delay = Number(e.delay) || 0, this._timeScale = 1, this._active = e.immediateRender === !0, this.data = e.data, this._reversed = e.reversed === !0, G) {
//                 o || a.wake();
//                 var i = this.vars.useFrames ? j : G;
//                 i.add(this, i._time), this.vars.paused && this.paused(!0)
//             }
//         });
//         a = R.ticker = new l.Ticker, r = R.prototype, r._dirty = r._gc = r._initted = r._paused = !1, r._totalTime = r._time = 0, r._rawPrevTime = -1, r._next = r._last = r._onUpdate = r._timeline = r.timeline = null, r._paused = !1;
//         var C = function() {
//             o && x() - A > 2e3 && a.wake(), setTimeout(C, 2e3)
//         };
//         C(), r.play = function(t, e) {
//             return null != t && this.seek(t, e), this.reversed(!1).paused(!1)
//         }, r.pause = function(t, e) {
//             return null != t && this.seek(t, e), this.paused(!0)
//         }, r.resume = function(t, e) {
//             return null != t && this.seek(t, e), this.paused(!1)
//         }, r.seek = function(t, e) {
//             return this.totalTime(Number(t), e !== !1)
//         }, r.restart = function(t, e) {
//             return this.reversed(!1).paused(!1).totalTime(t ? -this._delay : 0, e !== !1, !0)
//         }, r.reverse = function(t, e) {
//             return null != t && this.seek(t || this.totalDuration(), e), this.reversed(!0).paused(!1)
//         }, r.render = function() {}, r.invalidate = function() {
//             return this
//         }, r.isActive = function() {
//             var t, e = this._timeline,
//               i = this._startTime;
//             return !e || !this._gc && !this._paused && e.isActive() && (t = e.rawTime()) >= i && i + this.totalDuration() / this._timeScale > t
//         }, r._enabled = function(t, e) {
//             return o || a.wake(), this._gc = !t, this._active = this.isActive(), e !== !0 && (t && !this.timeline ? this._timeline.add(this, this._startTime - this._delay) : !t && this.timeline && this._timeline._remove(this, !0)), !1
//         }, r._kill = function() {
//             return this._enabled(!1, !1)
//         }, r.kill = function(t, e) {
//             return this._kill(t, e), this
//         }, r._uncache = function(t) {
//             for (var e = t ? this : this.timeline; e;) e._dirty = !0, e = e.timeline;
//             return this
//         }, r._swapSelfInParams = function(t) {
//             for (var e = t.length, i = t.concat(); --e > -1;) "{self}" === t[e] && (i[e] = this);
//             return i
//         }, r.eventCallback = function(t, e, i, n) {
//             if ("on" === (t || "").substr(0, 2)) {
//                 var s = this.vars;
//                 if (1 === arguments.length) return s[t];
//                 null == e ? delete s[t] : (s[t] = e, s[t + "Params"] = p(i) && -1 !== i.join("").indexOf("{self}") ? this._swapSelfInParams(i) : i, s[t + "Scope"] = n), "onUpdate" === t && (this._onUpdate = e)
//             }
//             return this
//         }, r.delay = function(t) {
//             return arguments.length ? (this._timeline.smoothChildTiming && this.startTime(this._startTime + t - this._delay), this._delay = t, this) : this._delay
//         }, r.duration = function(t) {
//             return arguments.length ? (this._duration = this._totalDuration = t, this._uncache(!0), this._timeline.smoothChildTiming && this._time > 0 && this._time < this._duration && 0 !== t && this.totalTime(this._totalTime * (t / this._duration), !0), this) : (this._dirty = !1, this._duration)
//         }, r.totalDuration = function(t) {
//             return this._dirty = !1, arguments.length ? this.duration(t) : this._totalDuration
//         }, r.time = function(t, e) {
//             return arguments.length ? (this._dirty && this.totalDuration(), this.totalTime(t > this._duration ? this._duration : t, e)) : this._time
//         }, r.totalTime = function(t, e, i) {
//             if (o || a.wake(), !arguments.length) return this._totalTime;
//             if (this._timeline) {
//                 if (0 > t && !i && (t += this.totalDuration()), this._timeline.smoothChildTiming) {
//                     this._dirty && this.totalDuration();
//                     var n = this._totalDuration,
//                       s = this._timeline;
//                     if (t > n && !i && (t = n), this._startTime = (this._paused ? this._pauseTime : s._time) - (this._reversed ? n - t : t) / this._timeScale, s._dirty || this._uncache(!1), s._timeline)
//                         for (; s._timeline;) s._timeline._time !== (s._startTime + s._totalTime) / s._timeScale && s.totalTime(s._totalTime, !0), s = s._timeline
//                 }
//                 this._gc && this._enabled(!0, !1), (this._totalTime !== t || 0 === this._duration) && (this.render(t, e, !1), D.length && Q())
//             }
//             return this
//         }, r.progress = r.totalProgress = function(t, e) {
//             return arguments.length ? this.totalTime(this.duration() * t, e) : this._time / this.duration()
//         }, r.startTime = function(t) {
//             return arguments.length ? (t !== this._startTime && (this._startTime = t, this.timeline && this.timeline._sortChildren && this.timeline.add(this, t - this._delay)), this) : this._startTime
//         }, r.timeScale = function(t) {
//             if (!arguments.length) return this._timeScale;
//             if (t = t || _, this._timeline && this._timeline.smoothChildTiming) {
//                 var e = this._pauseTime,
//                   i = e || 0 === e ? e : this._timeline.totalTime();
//                 this._startTime = i - (i - this._startTime) * this._timeScale / t
//             }
//             return this._timeScale = t, this._uncache(!1)
//         }, r.reversed = function(t) {
//             return arguments.length ? (t != this._reversed && (this._reversed = t, this.totalTime(this._timeline && !this._timeline.smoothChildTiming ? this.totalDuration() - this._totalTime : this._totalTime, !0)), this) : this._reversed
//         }, r.paused = function(t) {
//             if (!arguments.length) return this._paused;
//             if (t != this._paused && this._timeline) {
//                 o || t || a.wake();
//                 var e = this._timeline,
//                   i = e.rawTime(),
//                   n = i - this._pauseTime;
//                 !t && e.smoothChildTiming && (this._startTime += n, this._uncache(!1)), this._pauseTime = t ? i : null, this._paused = t, this._active = this.isActive(), !t && 0 !== n && this._initted && this.duration() && this.render(e.smoothChildTiming ? this._totalTime : (i - this._startTime) / this._timeScale, !0, !0)
//             }
//             return this._gc && !t && this._enabled(!0, !1), this
//         };
//         var E = g("core.SimpleTimeline", function(t) {
//             R.call(this, 0, t), this.autoRemoveChildren = this.smoothChildTiming = !0
//         });
//         r = E.prototype = new R, r.constructor = E, r.kill()._gc = !1, r._first = r._last = null, r._sortChildren = !1, r.add = r.insert = function(t, e) {
//             var i, n;
//             if (t._startTime = Number(e || 0) + t._delay, t._paused && this !== t._timeline && (t._pauseTime = t._startTime + (this.rawTime() - t._startTime) / t._timeScale), t.timeline && t.timeline._remove(t, !0), t.timeline = t._timeline = this, t._gc && t._enabled(!0, !0), i = this._last, this._sortChildren)
//                 for (n = t._startTime; i && i._startTime > n;) i = i._prev;
//             return i ? (t._next = i._next, i._next = t) : (t._next = this._first, this._first = t), t._next ? t._next._prev = t : this._last = t, t._prev = i, this._timeline && this._uncache(!0), this
//         }, r._remove = function(t, e) {
//             return t.timeline === this && (e || t._enabled(!1, !0), t._prev ? t._prev._next = t._next : this._first === t && (this._first = t._next), t._next ? t._next._prev = t._prev : this._last === t && (this._last = t._prev), t._next = t._prev = t.timeline = null, this._timeline && this._uncache(!0)), this
//         }, r.render = function(t, e, i) {
//             var n, s = this._first;
//             for (this._totalTime = this._time = this._rawPrevTime = t; s;) n = s._next, (s._active || t >= s._startTime && !s._paused) && (s._reversed ? s.render((s._dirty ? s.totalDuration() : s._totalDuration) - (t - s._startTime) * s._timeScale, e, i) : s.render((t - s._startTime) * s._timeScale, e, i)), s = n
//         }, r.rawTime = function() {
//             return o || a.wake(), this._totalTime
//         };
//         var I = g("TweenLite", function(e, i, n) {
//               if (R.call(this, i, n), this.render = I.prototype.render, null == e) throw "Cannot tween a null target.";
//               this.target = e = "string" != typeof e ? e : I.selector(e) || e;
//               var s, r, a, o = e.jquery || e.length && e !== t && e[0] && (e[0] === t || e[0].nodeType && e[0].style && !e.nodeType),
//                 h = this.vars.overwrite;
//               if (this._overwrite = h = null == h ? U[I.defaultOverwrite] : "number" == typeof h ? h >> 0 : U[h], (o || e instanceof Array || e.push && p(e)) && "number" != typeof e[0])
//                   for (this._targets = a = u(e), this._propLookup = [], this._siblings = [], s = 0; a.length > s; s++) r = a[s], r ? "string" != typeof r ? r.length && r !== t && r[0] && (r[0] === t || r[0].nodeType && r[0].style && !r.nodeType) ? (a.splice(s--, 1), this._targets = a = a.concat(u(r))) : (this._siblings[s] = X(r, this, !1), 1 === h && this._siblings[s].length > 1 && Y(r, this, null, 1, this._siblings[s])) : (r = a[s--] = I.selector(r), "string" == typeof r && a.splice(s + 1, 1)) : a.splice(s--, 1);
//               else this._propLookup = {}, this._siblings = X(e, this, !1), 1 === h && this._siblings.length > 1 && Y(e, this, null, 1, this._siblings);
//               (this.vars.immediateRender || 0 === i && 0 === this._delay && this.vars.immediateRender !== !1) && (this._time = -_, this.render(-this._delay))
//           }, !0),
//           M = function(e) {
//               return e.length && e !== t && e[0] && (e[0] === t || e[0].nodeType && e[0].style && !e.nodeType)
//           },
//           O = function(t, e) {
//               var i, n = {};
//               for (i in t) N[i] || i in e && "transform" !== i && "x" !== i && "y" !== i && "width" !== i && "height" !== i && "className" !== i && "border" !== i || !(!L[i] || L[i] && L[i]._autoCSS) || (n[i] = t[i], delete t[i]);
//               t.css = n
//           };
//         r = I.prototype = new R, r.constructor = I, r.kill()._gc = !1, r.ratio = 0, r._firstPT = r._targets = r._overwrittenProps = r._startAt = null, r._notifyPluginsOfEnabled = r._lazy = !1, I.version = "1.13.1", I.defaultEase = r._ease = new y(null, null, 1, 1), I.defaultOverwrite = "auto", I.ticker = a, I.autoSleep = !0, I.lagSmoothing = function(t, e) {
//             a.lagSmoothing(t, e)
//         }, I.selector = t.$ || t.jQuery || function(e) {
//             var i = t.$ || t.jQuery;
//             return i ? (I.selector = i, i(e)) : "undefined" == typeof document ? e : document.querySelectorAll ? document.querySelectorAll(e) : document.getElementById("#" === e.charAt(0) ? e.substr(1) : e)
//         };
//         var D = [],
//           z = {},
//           F = I._internals = {
//               isArray: p,
//               isSelector: M,
//               lazyTweens: D
//           },
//           L = I._plugins = {},
//           q = F.tweenLookup = {},
//           B = 0,
//           N = F.reservedProps = {
//               ease: 1,
//               delay: 1,
//               overwrite: 1,
//               onComplete: 1,
//               onCompleteParams: 1,
//               onCompleteScope: 1,
//               useFrames: 1,
//               runBackwards: 1,
//               startAt: 1,
//               onUpdate: 1,
//               onUpdateParams: 1,
//               onUpdateScope: 1,
//               onStart: 1,
//               onStartParams: 1,
//               onStartScope: 1,
//               onReverseComplete: 1,
//               onReverseCompleteParams: 1,
//               onReverseCompleteScope: 1,
//               onRepeat: 1,
//               onRepeatParams: 1,
//               onRepeatScope: 1,
//               easeParams: 1,
//               yoyo: 1,
//               immediateRender: 1,
//               repeat: 1,
//               repeatDelay: 1,
//               data: 1,
//               paused: 1,
//               reversed: 1,
//               autoCSS: 1,
//               lazy: 1
//           },
//           U = {
//               none: 0,
//               all: 1,
//               auto: 2,
//               concurrent: 3,
//               allOnStart: 4,
//               preexisting: 5,
//               "true": 1,
//               "false": 0
//           },
//           j = R._rootFramesTimeline = new E,
//           G = R._rootTimeline = new E,
//           Q = F.lazyRender = function() {
//               var t = D.length;
//               for (z = {}; --t > -1;) n = D[t], n && n._lazy !== !1 && (n.render(n._lazy, !1, !0), n._lazy = !1);
//               D.length = 0
//           };
//         G._startTime = a.time, j._startTime = a.frame, G._active = j._active = !0, setTimeout(Q, 1), R._updateRoot = I.render = function() {
//             var t, e, i;
//             if (D.length && Q(), G.render((a.time - G._startTime) * G._timeScale, !1, !1), j.render((a.frame - j._startTime) * j._timeScale, !1, !1), D.length && Q(), !(a.frame % 120)) {
//                 for (i in q) {
//                     for (e = q[i].tweens, t = e.length; --t > -1;) e[t]._gc && e.splice(t, 1);
//                     0 === e.length && delete q[i]
//                 }
//                 if (i = G._first, (!i || i._paused) && I.autoSleep && !j._first && 1 === a._listeners.tick.length) {
//                     for (; i && i._paused;) i = i._next;
//                     i || a.sleep()
//                 }
//             }
//         }, a.addEventListener("tick", R._updateRoot);
//         var X = function(t, e, i) {
//               var n, s, r = t._gsTweenID;
//               if (q[r || (t._gsTweenID = r = "t" + B++)] || (q[r] = {
//                   target: t,
//                   tweens: []
//               }), e && (n = q[r].tweens, n[s = n.length] = e, i))
//                   for (; --s > -1;) n[s] === e && n.splice(s, 1);
//               return q[r].tweens
//           },
//           Y = function(t, e, i, n, s) {
//               var r, a, o, h;
//               if (1 === n || n >= 4) {
//                   for (h = s.length, r = 0; h > r; r++)
//                       if ((o = s[r]) !== e) o._gc || o._enabled(!1, !1) && (a = !0);
//                       else if (5 === n) break;
//                   return a
//               }
//               var l, u = e._startTime + _,
//                 c = [],
//                 p = 0,
//                 f = 0 === e._duration;
//               for (r = s.length; --r > -1;)(o = s[r]) === e || o._gc || o._paused || (o._timeline !== e._timeline ? (l = l || H(e, 0, f), 0 === H(o, l, f) && (c[p++] = o)) : u >= o._startTime && o._startTime + o.totalDuration() / o._timeScale > u && ((f || !o._initted) && 2e-10 >= u - o._startTime || (c[p++] = o)));
//               for (r = p; --r > -1;) o = c[r], 2 === n && o._kill(i, t) && (a = !0), (2 !== n || !o._firstPT && o._initted) && o._enabled(!1, !1) && (a = !0);
//               return a
//           },
//           H = function(t, e, i) {
//               for (var n = t._timeline, s = n._timeScale, r = t._startTime; n._timeline;) {
//                   if (r += n._startTime, s *= n._timeScale, n._paused) return -100;
//                   n = n._timeline
//               }
//               return r /= s, r > e ? r - e : i && r === e || !t._initted && 2 * _ > r - e ? _ : (r += t.totalDuration() / t._timeScale / s) > e + _ ? 0 : r - e - _
//           };
//         r._init = function() {
//             var t, e, i, n, s, r = this.vars,
//               a = this._overwrittenProps,
//               o = this._duration,
//               h = !!r.immediateRender,
//               l = r.ease;
//             if (r.startAt) {
//                 this._startAt && (this._startAt.render(-1, !0), this._startAt.kill()), s = {};
//                 for (n in r.startAt) s[n] = r.startAt[n];
//                 if (s.overwrite = !1, s.immediateRender = !0, s.lazy = h && r.lazy !== !1, s.startAt = s.delay = null, this._startAt = I.to(this.target, 0, s), h)
//                     if (this._time > 0) this._startAt = null;
//                     else if (0 !== o) return
//             } else if (r.runBackwards && 0 !== o)
//                 if (this._startAt) this._startAt.render(-1, !0), this._startAt.kill(), this._startAt = null;
//                 else {
//                     i = {};
//                     for (n in r) N[n] && "autoCSS" !== n || (i[n] = r[n]);
//                     if (i.overwrite = 0, i.data = "isFromStart", i.lazy = h && r.lazy !== !1, i.immediateRender = h, this._startAt = I.to(this.target, 0, i), h) {
//                         if (0 === this._time) return
//                     } else this._startAt._init(), this._startAt._enabled(!1)
//                 }
//             if (this._ease = l = l ? l instanceof y ? l : "function" == typeof l ? new y(l, r.easeParams) : T[l] || I.defaultEase : I.defaultEase, r.easeParams instanceof Array && l.config && (this._ease = l.config.apply(l, r.easeParams)), this._easeType = this._ease._type, this._easePower = this._ease._power, this._firstPT = null, this._targets)
//                 for (t = this._targets.length; --t > -1;) this._initProps(this._targets[t], this._propLookup[t] = {}, this._siblings[t], a ? a[t] : null) && (e = !0);
//             else e = this._initProps(this.target, this._propLookup, this._siblings, a);
//             if (e && I._onPluginEvent("_onInitAllProps", this), a && (this._firstPT || "function" != typeof this.target && this._enabled(!1, !1)), r.runBackwards)
//                 for (i = this._firstPT; i;) i.s += i.c, i.c = -i.c, i = i._next;
//             this._onUpdate = r.onUpdate, this._initted = !0
//         }, r._initProps = function(e, i, n, s) {
//             var r, a, o, h, l, _;
//             if (null == e) return !1;
//             z[e._gsTweenID] && Q(), this.vars.css || e.style && e !== t && e.nodeType && L.css && this.vars.autoCSS !== !1 && O(this.vars, e);
//             for (r in this.vars) {
//                 if (_ = this.vars[r], N[r]) _ && (_ instanceof Array || _.push && p(_)) && -1 !== _.join("").indexOf("{self}") && (this.vars[r] = _ = this._swapSelfInParams(_, this));
//                 else if (L[r] && (h = new L[r])._onInitTween(e, this.vars[r], this)) {
//                     for (this._firstPT = l = {
//                         _next: this._firstPT,
//                         t: h,
//                         p: "setRatio",
//                         s: 0,
//                         c: 1,
//                         f: !0,
//                         n: r,
//                         pg: !0,
//                         pr: h._priority
//                     }, a = h._overwriteProps.length; --a > -1;) i[h._overwriteProps[a]] = this._firstPT;
//                     (h._priority || h._onInitAllProps) && (o = !0), (h._onDisable || h._onEnable) && (this._notifyPluginsOfEnabled = !0)
//                 } else this._firstPT = i[r] = l = {
//                     _next: this._firstPT,
//                     t: e,
//                     p: r,
//                     f: "function" == typeof e[r],
//                     n: r,
//                     pg: !1,
//                     pr: 0
//                 }, l.s = l.f ? e[r.indexOf("set") || "function" != typeof e["get" + r.substr(3)] ? r : "get" + r.substr(3)]() : parseFloat(e[r]), l.c = "string" == typeof _ && "=" === _.charAt(1) ? parseInt(_.charAt(0) + "1", 10) * Number(_.substr(2)) : Number(_) - l.s || 0;
//                 l && l._next && (l._next._prev = l)
//             }
//             return s && this._kill(s, e) ? this._initProps(e, i, n, s) : this._overwrite > 1 && this._firstPT && n.length > 1 && Y(e, this, i, this._overwrite, n) ? (this._kill(i, e), this._initProps(e, i, n, s)) : (this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration) && (z[e._gsTweenID] = !0), o)
//         }, r.render = function(t, e, i) {
//             var n, s, r, a, o = this._time,
//               h = this._duration,
//               l = this._rawPrevTime;
//             if (t >= h) this._totalTime = this._time = h, this.ratio = this._ease._calcEnd ? this._ease.getRatio(1) : 1, this._reversed || (n = !0, s = "onComplete"), 0 === h && (this._initted || !this.vars.lazy || i) && (this._startTime === this._timeline._duration && (t = 0), (0 === t || 0 > l || l === _) && l !== t && (i = !0, l > _ && (s = "onReverseComplete")), this._rawPrevTime = a = !e || t || l === t ? t : _);
//             else if (1e-7 > t) this._totalTime = this._time = 0, this.ratio = this._ease._calcEnd ? this._ease.getRatio(0) : 0, (0 !== o || 0 === h && l > 0 && l !== _) && (s = "onReverseComplete", n = this._reversed), 0 > t ? (this._active = !1, 0 === h && (this._initted || !this.vars.lazy || i) && (l >= 0 && (i = !0), this._rawPrevTime = a = !e || t || l === t ? t : _)) : this._initted || (i = !0);
//             else if (this._totalTime = this._time = t, this._easeType) {
//                 var u = t / h,
//                   c = this._easeType,
//                   p = this._easePower;
//                 (1 === c || 3 === c && u >= .5) && (u = 1 - u), 3 === c && (u *= 2), 1 === p ? u *= u : 2 === p ? u *= u * u : 3 === p ? u *= u * u * u : 4 === p && (u *= u * u * u * u), this.ratio = 1 === c ? 1 - u : 2 === c ? u : .5 > t / h ? u / 2 : 1 - u / 2
//             } else this.ratio = this._ease.getRatio(t / h);
//             if (this._time !== o || i) {
//                 if (!this._initted) {
//                     if (this._init(), !this._initted || this._gc) return;
//                     if (!i && this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration)) return this._time = this._totalTime = o, this._rawPrevTime = l, D.push(this), void(this._lazy = t);
//                     this._time && !n ? this.ratio = this._ease.getRatio(this._time / h) : n && this._ease._calcEnd && (this.ratio = this._ease.getRatio(0 === this._time ? 0 : 1))
//                 }
//                 for (this._lazy !== !1 && (this._lazy = !1), this._active || !this._paused && this._time !== o && t >= 0 && (this._active = !0), 0 === o && (this._startAt && (t >= 0 ? this._startAt.render(t, e, i) : s || (s = "_dummyGS")), this.vars.onStart && (0 !== this._time || 0 === h) && (e || this.vars.onStart.apply(this.vars.onStartScope || this, this.vars.onStartParams || w))), r = this._firstPT; r;) r.f ? r.t[r.p](r.c * this.ratio + r.s) : r.t[r.p] = r.c * this.ratio + r.s, r = r._next;
//                 this._onUpdate && (0 > t && this._startAt && this._startTime && this._startAt.render(t, e, i), e || (this._time !== o || n) && this._onUpdate.apply(this.vars.onUpdateScope || this, this.vars.onUpdateParams || w)), s && (!this._gc || i) && (0 > t && this._startAt && !this._onUpdate && this._startTime && this._startAt.render(t, e, i), n && (this._timeline.autoRemoveChildren && this._enabled(!1, !1), this._active = !1), !e && this.vars[s] && this.vars[s].apply(this.vars[s + "Scope"] || this, this.vars[s + "Params"] || w), 0 === h && this._rawPrevTime === _ && a !== _ && (this._rawPrevTime = 0))
//             }
//         }, r._kill = function(t, e) {
//             if ("all" === t && (t = null), null == t && (null == e || e === this.target)) return this._lazy = !1, this._enabled(!1, !1);
//             e = "string" != typeof e ? e || this._targets || this.target : I.selector(e) || e;
//             var i, n, s, r, a, o, h, l;
//             if ((p(e) || M(e)) && "number" != typeof e[0])
//                 for (i = e.length; --i > -1;) this._kill(t, e[i]) && (o = !0);
//             else {
//                 if (this._targets) {
//                     for (i = this._targets.length; --i > -1;)
//                         if (e === this._targets[i]) {
//                             a = this._propLookup[i] || {}, this._overwrittenProps = this._overwrittenProps || [], n = this._overwrittenProps[i] = t ? this._overwrittenProps[i] || {} : "all";
//                             break
//                         }
//                 } else {
//                     if (e !== this.target) return !1;
//                     a = this._propLookup, n = this._overwrittenProps = t ? this._overwrittenProps || {} : "all"
//                 }
//                 if (a) {
//                     h = t || a, l = t !== n && "all" !== n && t !== a && ("object" != typeof t || !t._tempKill);
//                     for (s in h)(r = a[s]) && (r.pg && r.t._kill(h) && (o = !0), r.pg && 0 !== r.t._overwriteProps.length || (r._prev ? r._prev._next = r._next : r === this._firstPT && (this._firstPT = r._next), r._next && (r._next._prev = r._prev), r._next = r._prev = null), delete a[s]), l && (n[s] = 1);
//                     !this._firstPT && this._initted && this._enabled(!1, !1)
//                 }
//             }
//             return o
//         }, r.invalidate = function() {
//             return this._notifyPluginsOfEnabled && I._onPluginEvent("_onDisable", this), this._firstPT = null, this._overwrittenProps = null, this._onUpdate = null, this._startAt = null, this._initted = this._active = this._notifyPluginsOfEnabled = this._lazy = !1, this._propLookup = this._targets ? {} : [], this
//         }, r._enabled = function(t, e) {
//             if (o || a.wake(), t && this._gc) {
//                 var i, n = this._targets;
//                 if (n)
//                     for (i = n.length; --i > -1;) this._siblings[i] = X(n[i], this, !0);
//                 else this._siblings = X(this.target, this, !0)
//             }
//             return R.prototype._enabled.call(this, t, e), this._notifyPluginsOfEnabled && this._firstPT ? I._onPluginEvent(t ? "_onEnable" : "_onDisable", this) : !1
//         }, I.to = function(t, e, i) {
//             return new I(t, e, i)
//         }, I.from = function(t, e, i) {
//             return i.runBackwards = !0, i.immediateRender = 0 != i.immediateRender, new I(t, e, i)
//         }, I.fromTo = function(t, e, i, n) {
//             return n.startAt = i, n.immediateRender = 0 != n.immediateRender && 0 != i.immediateRender, new I(t, e, n)
//         }, I.delayedCall = function(t, e, i, n, s) {
//             return new I(e, 0, {
//                 delay: t,
//                 onComplete: e,
//                 onCompleteParams: i,
//                 onCompleteScope: n,
//                 onReverseComplete: e,
//                 onReverseCompleteParams: i,
//                 onReverseCompleteScope: n,
//                 immediateRender: !1,
//                 useFrames: s,
//                 overwrite: 0
//             })
//         }, I.set = function(t, e) {
//             return new I(t, 0, e)
//         }, I.getTweensOf = function(t, e) {
//             if (null == t) return [];
//             t = "string" != typeof t ? t : I.selector(t) || t;
//             var i, n, s, r;
//             if ((p(t) || M(t)) && "number" != typeof t[0]) {
//                 for (i = t.length, n = []; --i > -1;) n = n.concat(I.getTweensOf(t[i], e));
//                 for (i = n.length; --i > -1;)
//                     for (r = n[i], s = i; --s > -1;) r === n[s] && n.splice(i, 1)
//             } else
//                 for (n = X(t).concat(), i = n.length; --i > -1;)(n[i]._gc || e && !n[i].isActive()) && n.splice(i, 1);
//             return n
//         }, I.killTweensOf = I.killDelayedCallsTo = function(t, e, i) {
//             "object" == typeof e && (i = e, e = !1);
//             for (var n = I.getTweensOf(t, e), s = n.length; --s > -1;) n[s]._kill(i, t)
//         };
//         var W = g("plugins.TweenPlugin", function(t, e) {
//             this._overwriteProps = (t || "").split(","), this._propName = this._overwriteProps[0], this._priority = e || 0, this._super = W.prototype
//         }, !0);
//         if (r = W.prototype, W.version = "1.10.1", W.API = 2, r._firstPT = null, r._addTween = function(t, e, i, n, s, r) {
//             var a, o;
//             return null != n && (a = "number" == typeof n || "=" !== n.charAt(1) ? Number(n) - i : parseInt(n.charAt(0) + "1", 10) * Number(n.substr(2))) ? (this._firstPT = o = {
//                 _next: this._firstPT,
//                 t: t,
//                 p: e,
//                 s: i,
//                 c: a,
//                 f: "function" == typeof t[e],
//                 n: s || e,
//                 r: r
//             }, o._next && (o._next._prev = o), o) : void 0
//         }, r.setRatio = function(t) {
//             for (var e, i = this._firstPT, n = 1e-6; i;) e = i.c * t + i.s, i.r ? e = Math.round(e) : n > e && e > -n && (e = 0), i.f ? i.t[i.p](e) : i.t[i.p] = e, i = i._next
//         }, r._kill = function(t) {
//             var e, i = this._overwriteProps,
//               n = this._firstPT;
//             if (null != t[this._propName]) this._overwriteProps = [];
//             else
//                 for (e = i.length; --e > -1;) null != t[i[e]] && i.splice(e, 1);
//             for (; n;) null != t[n.n] && (n._next && (n._next._prev = n._prev), n._prev ? (n._prev._next = n._next, n._prev = null) : this._firstPT === n && (this._firstPT = n._next)), n = n._next;
//             return !1
//         }, r._roundProps = function(t, e) {
//             for (var i = this._firstPT; i;)(t[this._propName] || null != i.n && t[i.n.split(this._propName + "_").join("")]) && (i.r = e), i = i._next
//         }, I._onPluginEvent = function(t, e) {
//             var i, n, s, r, a, o = e._firstPT;
//             if ("_onInitAllProps" === t) {
//                 for (; o;) {
//                     for (a = o._next, n = s; n && n.pr > o.pr;) n = n._next;
//                     (o._prev = n ? n._prev : r) ? o._prev._next = o: s = o, (o._next = n) ? n._prev = o : r = o, o = a
//                 }
//                 o = e._firstPT = s
//             }
//             for (; o;) o.pg && "function" == typeof o.t[t] && o.t[t]() && (i = !0), o = o._next;
//             return i
//         }, W.activate = function(t) {
//             for (var e = t.length; --e > -1;) t[e].API === W.API && (L[(new t[e])._propName] = t[e]);
//             return !0
//         }, d.plugin = function(t) {
//             if (!(t && t.propName && t.init && t.API)) throw "illegal plugin definition.";
//             var e, i = t.propName,
//               n = t.priority || 0,
//               s = t.overwriteProps,
//               r = {
//                   init: "_onInitTween",
//                   set: "setRatio",
//                   kill: "_kill",
//                   round: "_roundProps",
//                   initAll: "_onInitAllProps"
//               },
//               a = g("plugins." + i.charAt(0).toUpperCase() + i.substr(1) + "Plugin", function() {
//                   W.call(this, i, n), this._overwriteProps = s || []
//               }, t.global === !0),
//               o = a.prototype = new W(i);
//             o.constructor = a, a.API = t.API;
//             for (e in r) "function" == typeof t[e] && (o[r[e]] = t[e]);
//             return a.version = t.version, W.activate([a]), a
//         }, n = t._gsQueue) {
//             for (s = 0; n.length > s; s++) n[s]();
//             for (r in f) f[r].func || t.console.log("GSAP encountered missing dependency: com.greensock." + r)
//         }
//         o = !1
//     }
// }("undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window, "TweenLite");
// var _gsScope = "undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window;
// (_gsScope._gsQueue || (_gsScope._gsQueue = [])).push(function() {
//     "use strict";
//     _gsScope._gsDefine("easing.Back", ["easing.Ease"], function(t) {
//         var e, i, n, s = _gsScope.GreenSockGlobals || _gsScope,
//           r = s.com.greensock,
//           a = 2 * Math.PI,
//           o = Math.PI / 2,
//           h = r._class,
//           l = function(e, i) {
//               var n = h("easing." + e, function() {}, !0),
//                 s = n.prototype = new t;
//               return s.constructor = n, s.getRatio = i, n
//           },
//           _ = t.register || function() {},
//           u = function(t, e, i, n) {
//               var s = h("easing." + t, {
//                   easeOut: new e,
//                   easeIn: new i,
//                   easeInOut: new n
//               }, !0);
//               return _(s, t), s
//           },
//           c = function(t, e, i) {
//               this.t = t, this.v = e, i && (this.next = i, i.prev = this, this.c = i.v - e, this.gap = i.t - t)
//           },
//           p = function(e, i) {
//               var n = h("easing." + e, function(t) {
//                     this._p1 = t || 0 === t ? t : 1.70158, this._p2 = 1.525 * this._p1
//                 }, !0),
//                 s = n.prototype = new t;
//               return s.constructor = n, s.getRatio = i, s.config = function(t) {
//                   return new n(t)
//               }, n
//           },
//           f = u("Back", p("BackOut", function(t) {
//               return (t -= 1) * t * ((this._p1 + 1) * t + this._p1) + 1
//           }), p("BackIn", function(t) {
//               return t * t * ((this._p1 + 1) * t - this._p1)
//           }), p("BackInOut", function(t) {
//               return 1 > (t *= 2) ? .5 * t * t * ((this._p2 + 1) * t - this._p2) : .5 * ((t -= 2) * t * ((this._p2 + 1) * t + this._p2) + 2)
//           })),
//           m = h("easing.SlowMo", function(t, e, i) {
//               e = e || 0 === e ? e : .7, null == t ? t = .7 : t > 1 && (t = 1), this._p = 1 !== t ? e : 0, this._p1 = (1 - t) / 2, this._p2 = t, this._p3 = this._p1 + this._p2, this._calcEnd = i === !0
//           }, !0),
//           d = m.prototype = new t;
//         return d.constructor = m, d.getRatio = function(t) {
//             var e = t + (.5 - t) * this._p;
//             return this._p1 > t ? this._calcEnd ? 1 - (t = 1 - t / this._p1) * t : e - (t = 1 - t / this._p1) * t * t * t * e : t > this._p3 ? this._calcEnd ? 1 - (t = (t - this._p3) / this._p1) * t : e + (t - e) * (t = (t - this._p3) / this._p1) * t * t * t : this._calcEnd ? 1 : e
//         }, m.ease = new m(.7, .7), d.config = m.config = function(t, e, i) {
//             return new m(t, e, i)
//         }, e = h("easing.SteppedEase", function(t) {
//             t = t || 1, this._p1 = 1 / t, this._p2 = t + 1
//         }, !0), d = e.prototype = new t, d.constructor = e, d.getRatio = function(t) {
//             return 0 > t ? t = 0 : t >= 1 && (t = .999999999), (this._p2 * t >> 0) * this._p1
//         }, d.config = e.config = function(t) {
//             return new e(t)
//         }, i = h("easing.RoughEase", function(e) {
//             e = e || {};
//             for (var i, n, s, r, a, o, h = e.taper || "none", l = [], _ = 0, u = 0 | (e.points || 20), p = u, f = e.randomize !== !1, m = e.clamp === !0, d = e.template instanceof t ? e.template : null, g = "number" == typeof e.strength ? .4 * e.strength : .4; --p > -1;) i = f ? Math.random() : 1 / u * p, n = d ? d.getRatio(i) : i, "none" === h ? s = g : "out" === h ? (r = 1 - i, s = r * r * g) : "in" === h ? s = i * i * g : .5 > i ? (r = 2 * i, s = .5 * r * r * g) : (r = 2 * (1 - i), s = .5 * r * r * g), f ? n += Math.random() * s - .5 * s : p % 2 ? n += .5 * s : n -= .5 * s, m && (n > 1 ? n = 1 : 0 > n && (n = 0)), l[_++] = {
//                 x: i,
//                 y: n
//             };
//             for (l.sort(function(t, e) {
//                 return t.x - e.x
//             }), o = new c(1, 1, null), p = u; --p > -1;) a = l[p], o = new c(a.x, a.y, o);
//             this._prev = new c(0, 0, 0 !== o.t ? o : o.next)
//         }, !0), d = i.prototype = new t, d.constructor = i, d.getRatio = function(t) {
//             var e = this._prev;
//             if (t > e.t) {
//                 for (; e.next && t >= e.t;) e = e.next;
//                 e = e.prev
//             } else
//                 for (; e.prev && e.t >= t;) e = e.prev;
//             return this._prev = e, e.v + (t - e.t) / e.gap * e.c
//         }, d.config = function(t) {
//             return new i(t)
//         }, i.ease = new i, u("Bounce", l("BounceOut", function(t) {
//             return 1 / 2.75 > t ? 7.5625 * t * t : 2 / 2.75 > t ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : 2.5 / 2.75 > t ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375
//         }), l("BounceIn", function(t) {
//             return 1 / 2.75 > (t = 1 - t) ? 1 - 7.5625 * t * t : 2 / 2.75 > t ? 1 - (7.5625 * (t -= 1.5 / 2.75) * t + .75) : 2.5 / 2.75 > t ? 1 - (7.5625 * (t -= 2.25 / 2.75) * t + .9375) : 1 - (7.5625 * (t -= 2.625 / 2.75) * t + .984375)
//         }), l("BounceInOut", function(t) {
//             var e = .5 > t;
//             return t = e ? 1 - 2 * t : 2 * t - 1, t = 1 / 2.75 > t ? 7.5625 * t * t : 2 / 2.75 > t ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : 2.5 / 2.75 > t ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375, e ? .5 * (1 - t) : .5 * t + .5
//         })), u("Circ", l("CircOut", function(t) {
//             return Math.sqrt(1 - (t -= 1) * t)
//         }), l("CircIn", function(t) {
//             return -(Math.sqrt(1 - t * t) - 1)
//         }), l("CircInOut", function(t) {
//             return 1 > (t *= 2) ? -.5 * (Math.sqrt(1 - t * t) - 1) : .5 * (Math.sqrt(1 - (t -= 2) * t) + 1)
//         })), n = function(e, i, n) {
//             var s = h("easing." + e, function(t, e) {
//                   this._p1 = t || 1, this._p2 = e || n, this._p3 = this._p2 / a * (Math.asin(1 / this._p1) || 0)
//               }, !0),
//               r = s.prototype = new t;
//             return r.constructor = s, r.getRatio = i, r.config = function(t, e) {
//                 return new s(t, e)
//             }, s
//         }, u("Elastic", n("ElasticOut", function(t) {
//             return this._p1 * Math.pow(2, -10 * t) * Math.sin((t - this._p3) * a / this._p2) + 1
//         }, .3), n("ElasticIn", function(t) {
//             return -(this._p1 * Math.pow(2, 10 * (t -= 1)) * Math.sin((t - this._p3) * a / this._p2))
//         }, .3), n("ElasticInOut", function(t) {
//             return 1 > (t *= 2) ? -.5 * this._p1 * Math.pow(2, 10 * (t -= 1)) * Math.sin((t - this._p3) * a / this._p2) : .5 * this._p1 * Math.pow(2, -10 * (t -= 1)) * Math.sin((t - this._p3) * a / this._p2) + 1
//         }, .45)), u("Expo", l("ExpoOut", function(t) {
//             return 1 - Math.pow(2, -10 * t)
//         }), l("ExpoIn", function(t) {
//             return Math.pow(2, 10 * (t - 1)) - .001
//         }), l("ExpoInOut", function(t) {
//             return 1 > (t *= 2) ? .5 * Math.pow(2, 10 * (t - 1)) : .5 * (2 - Math.pow(2, -10 * (t - 1)))
//         })), u("Sine", l("SineOut", function(t) {
//             return Math.sin(t * o)
//         }), l("SineIn", function(t) {
//             return -Math.cos(t * o) + 1
//         }), l("SineInOut", function(t) {
//             return -.5 * (Math.cos(Math.PI * t) - 1)
//         })), h("easing.EaseLookup", {
//             find: function(e) {
//                 return t.map[e]
//             }
//         }, !0), _(s.SlowMo, "SlowMo", "ease,"), _(i, "RoughEase", "ease,"), _(e, "SteppedEase", "ease,"), f
//     }, !0)
// }), _gsScope._gsDefine && _gsScope._gsQueue.pop()(),
//   function() {
//       for (var t = 0, e = ["ms", "moz", "webkit", "o"], i = 0; i < e.length && !window.requestAnimationFrame; ++i) window.requestAnimationFrame = window[e[i] + "RequestAnimationFrame"], window.cancelAnimationFrame = window[e[i] + "CancelAnimationFrame"] || window[e[i] + "CancelRequestAnimationFrame"];
//       window.requestAnimationFrame || (window.requestAnimationFrame = function(e) {
//           var i = (new Date).getTime(),
//             n = Math.max(0, 16 - (i - t)),
//             s = window.setTimeout(function() {
//                 e(i + n)
//             }, n);
//           return t = i + n, s
//       }), window.cancelAnimationFrame || (window.cancelAnimationFrame = function(t) {
//           clearTimeout(t)
//       })
//   }(),
//
//   // Particle JS (.large-header) change as you need....:)
//   function() {
//       function t() {
//           u = window.innerWidth, c = window.innerHeight, g = {
//               x: u / 2,
//               y: c / 2
//           }, p = document.getElementById("large-header"), p.style.height = c + "px", f = document.getElementById("demo-canvas"), f.width = u, f.height = c, m = f.getContext("2d"), d = [];
//           for (var t = 0; u > t; t += u / 20)
//               for (var e = 0; c > e; e += c / 20) {
//                   var i = t + Math.random() * u / 20,
//                     n = e + Math.random() * c / 20,
//                     s = {
//                         x: i,
//                         originX: i,
//                         y: n,
//                         originY: n
//                     };
//                   d.push(s)
//               }
//           for (var r = 0; r < d.length; r++) {
//               for (var a = [], o = d[r], h = 0; h < d.length; h++) {
//                   var v = d[h];
//                   if (o != v) {
//                       for (var w = !1, y = 0; 5 > y; y++) w || void 0 == a[y] && (a[y] = v, w = !0);
//                       for (var y = 0; 5 > y; y++) w || _(o, v) < _(o, a[y]) && (a[y] = v, w = !0)
//                   }
//               }
//               o.closest = a
//           }
//           for (var r in d) {
//               var T = new l(d[r], 2 + 2 * Math.random(), "rgba(255,255,255,0.3)");
//               d[r].circle = T
//           }
//       }
//
//       function e() {
//           "ontouchstart" in window || window.addEventListener("mousemove", i), window.addEventListener("scroll", n), window.addEventListener("resize", s)
//       }
//
//       function i(t) {
//           var e = posy = 0;
//           t.pageX || t.pageY ? (e = t.pageX, posy = t.pageY) : (t.clientX || t.clientY) && (e = t.clientX + document.body.scrollLeft + document.documentElement.scrollLeft, posy = t.clientY + document.body.scrollTop + document.documentElement.scrollTop), g.x = e, g.y = posy
//       }
//
//       function n() {
//           v = document.body.scrollTop > c ? !1 : !0
//       }
//
//       function s() {
//           u = window.innerWidth, c = window.innerHeight, p.style.height = c + "px", f.width = u, f.height = c
//       }
//
//       function r() {
//           a();
//           for (var t in d) o(d[t])
//       }
//
//       function a() {
//           if (v) {
//               m.clearRect(0, 0, u, c);
//               for (var t in d) Math.abs(_(g, d[t])) < 4e3 ? (d[t].active = .3, d[t].circle.active = .6) : Math.abs(_(g, d[t])) < 2e4 ? (d[t].active = .1, d[t].circle.active = .3) : Math.abs(_(g, d[t])) < 4e4 ? (d[t].active = .02, d[t].circle.active = .1) : (d[t].active = 0, d[t].circle.active = 0), h(d[t]), d[t].circle.draw()
//           }
//           requestAnimationFrame(a)
//       }
//
//       function o(t) {
//           TweenLite.to(t, 1 + 1 * Math.random(), {
//               x: t.originX - 50 + 100 * Math.random(),
//               y: t.originY - 50 + 100 * Math.random(),
//               ease: Circ.easeInOut,
//               onComplete: function() {
//                   o(t)
//               }
//           })
//       }
//
//       // Strokestyle color change as you need ...:)
//       function h(t) {
//           if (t.active)
//               for (var e in t.closest) m.beginPath(), m.moveTo(t.x, t.y), m.lineTo(t.closest[e].x, t.closest[e].y), m.strokeStyle = "rgba(255,255,255," + t.active + ")", m.stroke()
//       }
//
//       // Strokestyle color change as you need ...:)
//       function l(t, e, i) {
//           var n = this;
//           ! function() {
//               n.pos = t || null, n.radius = e || null, n.color = i || null
//           }(), this.draw = function() {
//               n.active && (m.beginPath(), m.arc(n.pos.x, n.pos.y, n.radius, 0, 2 * Math.PI, !1), m.fillStyle = "rgba(255,255,255," + n.active + ")", m.fill())
//           }
//       }
//
//       function _(t, e) {
//           return Math.pow(t.x - e.x, 2) + Math.pow(t.y - e.y, 2)
//       }
//       var u, c, p, f, m, d, g, v = !0;
//       t(), r(), e()
//   }();

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

