$("document").ready(function () {
   $(".select-route-bus-js").select2({
      ajax: {
         type: "POST",
         url: amadeusPath + "ajax",
         dataType: "json",
         delay: 250,
         data: function (params) {
            // اگر کاربر چیزی تایپ نکرده، شهرهای محبوب رو بگیر
            if (!params.term || params.term.trim() === '') {
               return JSON.stringify({
                  className: "busRoute",
                  method: "getPopularBusCities",
               })
            }

            // اگر کاربر تایپ کرده، جستجوی عادی
            return JSON.stringify({
               value: params.term,
               className: "busRoute",
               method: "routeBus",
            })
         },
         cache: true,
      },
      placeholder: "جستجو بین شهر ها",
      minimumInputLength: 0, // تغییر از 1 به 0 تا بدون تایپ هم باز بشه
      language: {
         inputTooShort: function () {
            return "شما باید حداقل یک حرف وارد کنید"
         },
         searching: function () {
            return "در حال جستجو ... "
         },
         noResults: function () {
            return "جستجوی شما نتیجه ایی ندارد"
         },
      },
   })

   $(".select-origin-route-bus-js").change(() => {
      $(".select-destination-route-bus-js").select2('open')
   })

   $(".select-destination-route-bus-js").change(() => {
      $(".departure-date-bus-js").focus()
   })
})

function searchBus() {
   const form = document.getElementById('gds_local_bus');
   const is_new_tab = form.target === '_blank';

   let origin_bus = $(".select-origin-route-bus-js")
   let destination_bus = $(".select-destination-route-bus-js")
   let departure_date_bus = $(".departure-date-bus-js")
   checkSearchFields(origin_bus, destination_bus, departure_date_bus)

   origin_bus = origin_bus.val()
   destination_bus = destination_bus.val()
   departure_date_bus = departure_date_bus.val()
   let url = `${amadeusPathByLang}buses/${origin_bus}-${destination_bus}/${departure_date_bus}`

   openLink(url, is_new_tab)
}