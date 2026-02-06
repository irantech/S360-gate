$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#scroll-top').addClass("scroll-top_active");
        } else {
            $('#scroll-top').removeClass("scroll-top_active");
        }
    });
    $('#scroll-top').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });
});
window.onscroll = function () {
    myFunction()
};

function myFunction() {
    let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    let scrolled = (winScroll / height) * 100;
    let percentage = scrolled + "%";
    $(".parent_btn_top").css("background", `conic-gradient(#0177bf ${percentage}, #fff 0)`)
};/* number count for stats, using jQuery animate*/
$('.counting').each(function () {
    var $this = $(this), countTo = $this.attr('data-count');
    $({countNum: $this.text()}).animate({countNum: countTo}, {
        duration: 4000, easing: 'linear', step: function () {
            $this.text(Math.floor(this.countNum));
        }, complete: function () {
            $this.text(this.countNum);/*alert('finished');*/
        }
    });
});
$(document).ready(function () {
    $('.owl-banner').owlCarousel({
        loop:true,
        rtl:true,
        margin:10,
        nav:false,
        dots:false,
        autoplay:true,
        autoplayTimeout:3500,
        autoplayHoverPause:true,
        items:1,
    })
    $(".select2").select2();
    $('.owl-customersComments').owlCarousel({
        rtl:true,
        loop:true,
        margin:20,
        nav:false,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:2
            }
        }
    })
    $('.owl-blogSection').owlCarousel({
        rtl:true,
        loop:true,
        margin:20,
        nav:false,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            768:{
                items:2
            },
            1000:{
                items:3
            }
        }
    })
});
$('.box-of-count-passenger-boxes-js,.div_btn').on('click', function(e) {
    $('.cbox-count-passenger-js').toggle()
    $(this).parents().find('.down-count-passenger').toggleClass('fa-caret-up')
    e.stopPropagation()
})
let passengerVisa = ["صفر نفر","یک نفر","دو نفر","سه نفر","چهار نفر","پنج نفر","شش نفر","هفت نفر","هشت نفر","نه نفر"];
let low = document.querySelector(".low");
let person = document.querySelector(".person");
let numberTab = document.querySelector(".number-tab");
let inputHidden = document.querySelector(".adult-visa-js");
let counterVisa = 1;
function pluse_counterVisa(e){
    if (counterVisa<9){
        counterVisa = counterVisa + 1;
        numberTab.innerText = counterVisa;
        person.innerText = passengerVisa[counterVisa];
        console.log(passengerVisa[counterVisa]);
        inputHidden.value = counterVisa
    }

}
function lowOff_counterVisa(){
    if(counterVisa>1){
        counterVisa = counterVisa - 1;
        numberTab.innerText = counterVisa;
        person.innerText = passengerVisa[counterVisa];
        inputHidden.value = counterVisa
    }
}

let isActive = true;
let elementFaQ = $("#contact_HolderPart2");
elementFaQ.hide();

function toggleFaQ(e) {
    if (isActive) {
        isActive = false;
        elementFaQ.show();
        $([document.documentElement, document.body]).animate({scrollTop: elementFaQ.offset().top - 100}, 500);
        e.text = "بستن"
    } else {
        elementFaQ.hide();
        isActive = e.text = "سوال خاصی دارید"
    }
}