function submitRequest(_this){
  const requestedMemberName=$('#requestedMemberName').val()
  const requestedMemberPhoneNumber=$('#requestedMemberPhoneNumber').val()
  const is_api = $('#is_api').val()

  if(requestedMemberName == '' || requestedMemberPhoneNumber == '') {
      $.alert({
        title:  useXmltag("ErrorEnteringInformation"),
        icon: 'fa fa-cart-plus',
        content: useXmltag("Fillingallfieldsrequired"),
        rtl: true,
        type: 'red'
      });
      return false;
  }else if(!validateMobile(requestedMemberPhoneNumber)) {

    $.alert({
      title:  useXmltag("ErrorEnteringInformation"),
      icon: 'fa fa-cart-plus',
      content: useXmltag("MobileNumberIncorrect"),
      rtl: true,
      type: 'red'
    });
    return false;
  }
  $.post(amadeusPath + 'hotel_ajax.php',
    {
      Email: requestedMemberPhoneNumber,
      flag: "register_memeberHotel"
    },
    function (data) {
      if (data != "") {
        data =  data.replaceAll(/\s/g,'');
        $('#idMember').val(data);

      } else {

     /*   $.alert({
          title:  useXmltag("Tourreservation"),
          icon: 'fa fa-cart-plus',
          content: useXmltag("Errorrecordinginformation"),
          rtl: true,
          type: 'red'
        });
        return false;*/
      }
    });


  // $('#requestForm').append('<input type="hidden" name="className" value="requestReservation" />');
  // $('#requestForm').append('<input type="hidden" name="method" value="create" />');

  const serviceName=$('#serviceName').val()

  $('#requestForm').append('<input type="hidden" id="requestedMemberName" name="requestedMemberName" value="'+requestedMemberName+'" />');
  $('#requestForm').append('<input type="hidden" id="requestedMemberPhoneNumber" name="requestedMemberPhoneNumber" value="'+requestedMemberPhoneNumber+'" />');
  $('#requestForm').append('<input type="hidden" id="is_api" name="is_api" value="'+is_api+'" />');
  $('#requestForm').append('<input type="hidden" name="serviceName" value="'+serviceName+'" />');



  setTimeout(
    function () {
      $('#requestForm').submit();
    }, 300);


}


function validateMobile(inputValue) {
  const mobileRegex = /^[0-9]{11}$/;
  return mobileRegex.test(inputValue);
}