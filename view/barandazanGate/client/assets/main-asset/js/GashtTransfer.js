$("document").ready(function () {
   $(".switch-gashtotransfer-input-js").on("change", function () {
      if (this.checked && this.value === "1") {
         $(".transfer-js").css("display", "flex")
         $(".gasht-js").hide()
      } else {
         $(".gasht-js").css("display", "flex")
         $(".transfer-js").hide()
      }
   })

   $(".gasht-destination-js").change(() => {
      $(".gasht-date-js").focus()
   })
   $(".transfer-destination-js").change(() => {
      $(".transfer-date-js").focus()
   })
   $(".transfer-type-js").change(() => {
      $(".transfer-vehicle-type-js").select2('open')
   })
   $(".transfer-vehicle-type-js").change(() => {
      $(".transfer-location-js").select2('open')
   })

})

function searchGasht() {
   let gasht_destination = $(".gasht-destination-js")
   let gasht_date = $(".gasht-date-js")
   let gasht_type = $(".gasht-type-js")

   checkSearchFields(gasht_destination, gasht_date, gasht_type)

   gasht_destination = gasht_destination.val()
   gasht_date = gasht_date.val()
   gasht_type = gasht_type.val()

   let url = `${amadeusPathByLang}resultGasht/0/${gasht_destination}/${gasht_date}/${gasht_type}`
   console.log(url)
   window.location.href = url
}
function searchTransfer() {
   let transfer_destination = $(".transfer-destination-js")
   let transfer_date = $(".transfer-date-js")
   let transfer_type = $(".transfer-type-js")
   let transfer_vehicle_type = $(".transfer-vehicle-type-js")
   let transfer_location = $(".transfer-location-js")

   checkSearchFields(
      transfer_destination,
      transfer_date,
      transfer_type,
      transfer_vehicle_type,
      transfer_location
   )

   transfer_destination = transfer_destination.val()
   transfer_date = transfer_date.val()
   transfer_type = transfer_type.val()
   transfer_vehicle_type = transfer_vehicle_type.val()
   transfer_location = transfer_location.val()

   let url = `${amadeusPathByLang}resultGasht/1/${transfer_destination}/${transfer_date}/${transfer_type}/${transfer_vehicle_type}/${transfer_location}`
   console.log(url)
   window.location.href = url
}


