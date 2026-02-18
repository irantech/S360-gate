
function modalRequestOffline(requested_data) {
  requested_data =  JSON.stringify(requested_data)
  // $('.loaderPublic').fadeIn();
  // $('.loaderPublic').fadeOut(700);
  // $("#ModalPublic").fadeIn(900);
  $.post(libraryPath + 'ModalCreator.php',
    {
      Controller: 'requestOffline',
      Method: 'requestServiceOffline',
      Param: requested_data
    },
    function (data) {
      $('#ModalPublicContent').html(data);
    });

}
