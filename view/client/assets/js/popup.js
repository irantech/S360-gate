function setCookieSession(cname, cvalue) {
   document.cookie = cname + "=" + cvalue + ";path=/";
}

// بستن پاپ‌آپ
function close_modal_pop_up() {
   setCookieSession('popUpAdmin', true);
   $('#popUpShow').hide();
}

// نمایش پاپ‌آپ فقط اگر کوکی نباشد
$(function() {
   if ($('#popUpShow').length === 0) {
      $('body').append('<div id="popUpShow" style="display:none;"></div>');
   }

   if (!document.cookie.split('; ').find(row => row.startsWith('popUpAdmin='))) {
      $.post(libraryPath + 'ModalCreator.php', {
         Controller: 'popUp',
         Method: 'ModalShowPopUp'
      }, function(data) {
         $('#popUpShow').html(data).show();
      });
   }
});
