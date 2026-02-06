
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
// let isArrowSvg = false;
// function open_details_box(event){
//     if(isArrowSvg){
//         isArrowSvg = false;
//         event.children('.up').hide();
//         event.children('.down').show();
//     }else {
//         isArrowSvg = true;
//         event.children('.up').show();
//         event.children('.down').hide();
//     }
//     event.parent().parent().parent().children('.details_box').toggleClass('active')
// }


