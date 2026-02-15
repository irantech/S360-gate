$('.owl-tour-image').owlCarousel({
    rtl:true,
    loop:false,
    margin:5,
    nav:false,
    navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplaySpeed:1000,
    dots:true,
    responsive:{
        0:{
            items:1,
        }
    }
});

$('.owl-tour-image').on('changed.owl.carousel', function(event) {
    let totalItems = event.item.count;  // تعداد کل آیتم‌ها
    let currentIndex = event.item.index; // ایندکس آیتم فعلی
    let owlStage = document.querySelector('.parent-owl-tour-image .owl-carousel .owl-stage');
  
    // چون بعضی وقت‌ها index می‌تونه بیشتر از count باشه، بهتره از +1 صرف‌نظر کنیم
    if (currentIndex >= totalItems - 1) {
      console.log('به آیتم آخر رسیدیم!');
    //   owlStage.style.setProperty('padding-left', '0', 'important');
    } else {
      console.log('هنوز نرسیدیم به آخر');
    //   owlStage.style.setProperty('padding-left', '70px', 'important');
    }
  });







function fadeOut(element, duration = 200, callback) {
    console.log(element , 'element')
    console.log(duration , 'duration')
    console.log(callback , 'callback')

    // Check if element exists and is not null
    if (!element) {
        console.warn('fadeOut: element is null or undefined');
        if (callback) callback();
        return;
    }

    let opacity = .8;
    const interval = 16;
    const decrement = interval / duration;

    const fading = setInterval(() => {
        opacity -= decrement;
        if (opacity <= 0) {
            clearInterval(fading);
            element.style.display = 'none';
            if (callback) callback();
        }
        element.style.opacity = opacity;
    }, interval);
}

document.addEventListener('click', function(event) {
    // Use querySelectorAll to get all modals and overlays
    const modals = document.querySelectorAll('#mBox');
    const overlays = document.querySelectorAll('.body-overlay');

    // Check if click is outside any modal
    let clickedOutside = true;
    modals.forEach(modal => {
        if (modal && modal.contains(event.target)) {
            clickedOutside = false;
        }
    });

    if (clickedOutside) {
        // Fade out and remove all modals
        modals.forEach(modal => {
            if (modal) {
                fadeOut(modal, 200, () => {
                    if (modal.parentNode) {
                        modal.remove();
                    }
                });
            }
        });

        // Fade out and remove all overlays
        overlays.forEach(overlay => {
            if (overlay) {
                fadeOut(overlay, 200, () => {
                    if (overlay.parentNode) {
                        overlay.remove();
                    }
                });
            }
        });
    }
});











// $(document).ready(function(){
//     // اطمینان از لود کامل اسلایدشو
//     var owl = $(".owl-carousel");
//     owl.owlCarousel({
//         items: 1, // فقط یک تصویر نمایش داده می‌شود
//         onChanged: function(event) {
//             var currentIndex = event.item.index + 1;  // شمارش از 1 شروع می‌شود
//             $('#current-image').text(currentIndex);  // بروزرسانی شماره تصویر فعلی
//         }
//     });
// });

