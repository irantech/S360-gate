function getSpecialDiscountCode(currentTarget , passenger_id) {
    $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.post(libraryPath + 'ModalCreatorProfile.php', {
          Method: 'ModalShowSpecialDiscount',
          passenger_id
      },
      function (data) {
          $("#html_modal_change_password").html(data);
          $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
      });
}
function getTotalUserReward(currentTarget , passenger_id ) {
    $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.post(libraryPath + 'ModalCreatorProfile.php', {
          Method: 'ModalTotalUserReward',
          passenger_id
      },
      function (data) {
          $("#html_modal_change_password").html(data);
          $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
      });
}
function getInvitedUserList(currentTarget , passenger_id ) {
    $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.post(libraryPath + 'ModalCreatorProfile.php', {
          Method: 'ModalInvitedUserList',
          passenger_id ,
      },
      function (data) {
          $("#html_modal_change_password").html(data);
          $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
      });
}
function copyOnClipboard(event , e){
    let last_text = $(event.target).children("span").text()
    $(event.target).children("span").text('کپی شد !')
    setTimeout(() => {
        $(event.target).children("span").text(last_text)
    },800)
    navigator.clipboard.writeText(e);
}
function share_btn(reagent_code){
    let address = amadeusPathByLang + 'registerUser' ;
    let shareData = {
        title: "اشتراک گذاری",
        text: `شما می توانید با استفاده این کد در اولین خرید خود از تخفیف خرید استفاده نمایید:  \n${reagent_code}`,
        url: `${address}`,
    };
    navigator.share(shareData)
}
function more_btn_club(id , event){
    $('#'+id).children(".discounts_style_box").addClass('d-flex')
    if(event.currentTarget.querySelector("span").innerText == 'بیشتر'){
        event.currentTarget.querySelector("span").innerText = 'کم تر'
        $('#'+id).children(".discounts_style_box").addClass('d-flex')
    } else {
        event.currentTarget.querySelector("span").innerText = 'بیشتر'
        $('#'+id).children(".discounts_style_box").removeClass('d-flex')
    }
}
function getDiscountCodeWithPoint(currentTarget , id_discount){
    $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.ajax({
        url: amadeusPath + 'ajax',
        type: 'POST',
        dataType: 'JSON',
        data: JSON.stringify({
            className:'discountCodes',
            method:'getDiscountCodeWithPoint',
            id_discount
        }),
        success: function (response) {
            $.post(libraryPath + 'ModalCreatorProfile.php', {
                  Method: 'ModalShowDiscountCode',
                  passenger_id: response.data.discount_code
              },
              function (data) {
                  $("#html_modal_special_codes").html(data);
              });
            $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
        },
        error:function(error) {
            $.alert({
                title: useXmltag("getDiscountCodeWithPoint"),
                icon: 'fa fa-refresh',
                content: error.responseJSON.message,
                rtl: true,
                type: 'red',
            });
            $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
        }
    })
}

let alert_primary_p;
function more_btn(){
    if ($(".box-style-alert .alert-primary button span").text() === 'بیشتر'){
        $(".box-style-alert .alert-primary p").height(`${alert_primary_p}`)
        $(".box-style-alert .alert-primary p").css('overflow' , 'unset');
        $(".box-style-alert .alert-primary button span").text('کم تر');
    } else {
        $(".box-style-alert .alert-primary p").height('56.67px')
        $(".box-style-alert .alert-primary p").css('overflow' , 'hidden')
        $(".box-style-alert .alert-primary button span").text('بیشتر');
    }
}
function dropdown_custom_btn(e){
    $(".profile_dropdown_custom > button > span").text(e.innerHTML)
    $(".profile_dropdown_custom > div > div > button").removeClass("active");
    $(e).addClass("active");
    if(e.innerHTML === 'غیر ایرانی'){
        $(".country_label_profile").show()
        $(".nationalNumber_label_profile").hide()
        document.getElementById("national_type").setAttribute('value','NO_IR');

    } else {
        $(".country_label_profile").hide();
        $(".nationalNumber_label_profile").show()
        document.getElementById("national_type").setAttribute('value','IR');

    }
}
function open_calender(event){
    $(".list_calender_profile").hide()
    $(event.target).siblings('div').toggle()
    event.stopPropagation()
    return false
}
function click_submit(event) {
    $(".list_calender_profile").hide()
    let text = event.target.innerHTML;
    $(event.target).parent().parent().children('input').val(text)
    console.log($(event.target).parent('.list_calender_profile').fadeOut())
    return false
}
let isArrowSvg = false;
function open_details_box(event) {

    // ===== مدیریت فلش‌ها =====
    if (isArrowSvg) {
        isArrowSvg = false;
        event.children('.up').hide();
        event.children('.down').show();
    } else {
        isArrowSvg = true;
        event.children('.up').show();
        event.children('.down').hide();
    }
    let parent = event.closest('.box-style-padding');
    let oldBox = parent.find('.details_box');
    let newBox = parent.find('.info_new_wrapper');
    if (oldBox.length > 0) {
        oldBox.toggleClass('active');
    }

    if (newBox.length > 0) {
        newBox.toggleClass('active');
    }
}



function closeModalParent(e){
    if(e.target === e.currentTarget){
        $(".modal_custom").remove();
        $("body,html").removeClass("overflow-hidden");
    }
}
function closeModal(){
    $(".modal_custom").remove()
    $("body,html").removeClass("overflow-hidden");
}

$(document).ready(() => {
    alert_primary_p = $(".box-style-alert .alert-primary p").height()
    $(".box-style-alert .alert-primary button").hide()
    if($(".box-style-alert .alert-primary p").height() >= 75.56){
        $(".box-style-alert .alert-primary p").height('56.67px')
        $(".box-style-alert .alert-primary p").css('overflow' , 'hidden')
        $(".box-style-alert .alert-primary button").show();
    }

    if ($(".origin .profile_dropdown_custom .NoIranian").length === 1){
        $(".profile_dropdown_custom > div > div > button[name='NO_IR']").addClass("active");
        $(".country_label_profile").show()
        $(".nationalNumber_label_profile").hide()
    }
    if ($(".origin .profile_dropdown_custom .Iranian").length === 1){
        $(".profile_dropdown_custom > div > div > button[name='IR']").addClass("active");
        $(".country_label_profile").hide()
        $(".nationalNumber_label_profile").show()
    }

    $(".profile_dropdown_custom > div").hide()
    $(".profile_dropdown_custom > button").click((event) => {
        $(".profile_dropdown_custom > div").toggle()
        event.stopPropagation()
    })
    $('html , body').click(() => {
        $(".profile_dropdown_custom > div").hide()
        $(".list_calender_profile").hide()
    })
    $("input[name='gender']").change((e) => {
        if (e.target.value == 'female'){
            $(".box-style .img-profile > img").attr("src",amadeusPath + "view/client/assets/images/profile/woman.png");
        } else {
            $(".box-style .img-profile > img").attr("src",amadeusPath + "view/client/assets/images/profile/man.png");
        }
    })
})

$(document.body).on('click', '.PassportCountry', function () {
    var id = $(this).attr('data-id');
    document.getElementById("passport_country_id").setAttribute('value', id);
});
function modalClosePassenger(request_number) {
    $(".modal_custom").remove()
    $("body,html").removeClass("overflow-hidden");
}
function modalClosePassengerAdd(request_number) {
    $(".modal_custom").remove()
    $("body,html").removeClass("overflow-hidden");
}
function openMenuProfile(){
    $("body,html").addClass("overflow-hidden");
    $(".box-style.sticky-100").addClass("bottom-0");
    $(".bg-black-profile-ris").addClass("active-bg-black-profile-ris");
}
function closeMenuProfile(){
    $("body,html").removeClass("overflow-hidden");
    $(".box-style.sticky-100").removeClass("bottom-0");
    $(".bg-black-profile-ris").removeClass("active-bg-black-profile-ris");
}