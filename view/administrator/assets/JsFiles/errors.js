
function AddError(_this) {

   let itemCount = _this[0].dataset.counter;
   let displayAgencyId = `displayAgency${itemCount}`;
   let displayPassengerId = `displayPassenger${itemCount}`;
   let displayAdminId = `displayAdmin${itemCount}`
   let displayAgency = document.getElementById(displayAgencyId).value;
   let displayPassenger = document.getElementById(displayPassengerId).value;
   let displayAdmin = document.getElementById(displayAdminId).value



   $.ajax({
      url: `${amadeusPath}ajax`,
      data: JSON.stringify({
         method: 'updateErrorFlight',
         className: 'errors',
         id: itemCount,
         displayAgency: displayAgency,
         displayPassenger: displayPassenger,
         displayAdmin: displayAdmin
      }),
      type: 'POST',
      dataType: 'JSON',
      success: function(response) {
         if (response.success === true) {
            $.toast({
               heading: 'ویرایش نظر',
               text: response.message.message,
               position: 'top-right',
               icon: 'success',
               hideAfter: 3500,
               textAlign: 'right',
               stack: 6,
            })
         } else {
            $.toast({
               heading: 'ویرایش نظر',
               text: response.message.message,
               position: 'top-right',
               icon: 'error',
               hideAfter: 3500,
               textAlign: 'right',
               stack: 6,
            })
         }
      }
   })
}