function UpdateCommissionSource(obj) {
   let CommissionStr = obj.value.replace(/,/g, "");
   let sourceCode = obj.dataset.sourcecode;
   let type = obj.name;


   if (!/^\d*\.?\d*$/.test(CommissionStr)) {
      $.toast({
         heading: 'بروز رسانی کمیسیون',
         text: "مقدار کمیسیون باید عددی باشد",
         position: 'top-right',
         loaderBg: '#fff',
         icon: 'error',
         hideAfter: 3500,
         textAlign: 'right',
         stack: 6
      });
      return;
   }

   let Commission = CommissionStr === '' ? 0 : parseFloat(CommissionStr);

   if (type == 's_d_a_d' || type == 's_kh_a_kh_au' || type == 's_kh_a_d') {
      if (Commission < 0 || Commission > 100) {
         $.toast({
            heading: 'بروز رسانی کمیسیون',
            text: "مقدار کمیسیون پرواز های سیستمی باید بین 0 تا 100 باشد",
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
         return;
      }
   }


   $.post(amadeusPath + 'user_ajax.php', {
      sourceCode: sourceCode,
      Commission: Commission,
      type: type,
      flag: 'UpdatecommissionSources'
   }, function (data) {

      let res = JSON.parse(data);

      if (res.success == true) {
         $.toast({
            heading: 'بروز رسانی کمیسیون',
            text: res.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
      } else {
         $.toast({
            heading: 'بروز رسانی کمیسیون',
            text: res.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
      }
   });
}

function formatNumber(value) {
   value = value.replace(/,/g, "");
   value = value.replace(/\D/g, "");
   if (value === "") return "";
   return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

document.addEventListener("DOMContentLoaded", function() {
   const inputs = document.getElementsByClassName("commission-source");

   Array.from(inputs).forEach(function(input) {
      input.value = formatNumber(input.value);

      input.addEventListener("input", function(e) {
         input.value = formatNumber(input.value);
      });
   });
});



function selectFareStatus(obj){

   let fareStatus = obj.value;
   let sourceCode = obj.dataset.sourcecode;

   console.log(fareStatus)

   if (fareStatus === '') {
      fareStatus = null
   }

   $.post(amadeusPath + 'user_ajax.php', {
      sourceCode: sourceCode,
      fareStatus: fareStatus,
      flag: 'UpdateFareStatusSources'

   }, function (data) {

      let res = JSON.parse(data);

      if (res.success == true) {
         $.toast({
            heading: 'بروز رسانی وضعیت fare',
            text: res.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
      } else {
         $.toast({
            heading: 'بروز رسانی وضعیت fare',
            text: res.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
      }
   });

}