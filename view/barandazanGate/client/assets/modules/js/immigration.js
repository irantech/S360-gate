
function clickScroll(e){
  $("html").animate({
    scrollTop: $(`#${e}`).offset().top - 10
  }, 1000);
}

function sendToVisaPassengers() {
    var href = amadeusPathByLang + "passengersDetailVisa";

    $("#visaForm").attr("action", href);
    $("#visaForm").submit();
}