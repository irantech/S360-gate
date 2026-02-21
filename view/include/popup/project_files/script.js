
function setCookie(cname, cvalue, exdays) {
   const d = new Date();
   d.setTime(d.getTime() + (exdays*2*60*60*1000));
   let expires = "expires="+ d.toUTCString();
   document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$(document).ready(function{
   const popUpDiv = document.createElement('div');
   popUpDiv.id = 'popUpShow';
   popUpDiv.style.display = 'none';
   document.body.appendChild(popUpDiv);
})

$(document).ready(function ModalShowPopUp() {
   $.post(libraryPath + 'ModalCreator.php',
      {
         Controller: 'popUp',
         Method: 'ModalShowPopUp',
      },
      function (data) {
         $('#popUpShow').html(data);
      });
});
function close_modal_pop_up() {
   setCookie('popUpAdmin' , true , 1);
   $('#popUpShow').css({display: 'none'});
}