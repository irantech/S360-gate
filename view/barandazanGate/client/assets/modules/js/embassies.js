let map

function map_click(_this, latLocation, lonLocation) {
   const title=_this.parent().parent().find("[data-name='name']").text()

   map = L.map("g-map",{
      center: L.latLng(latLocation, lonLocation),
      zoom: 1
   })
   L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "",
      maxZoom: 16,
      minZoom: 14,
   }).addTo(map)


   let marker = L.marker([latLocation, lonLocation]).addTo(map)





    $(".parent-embassy-modal h3").text(title)
   $(".embassy-modal").css("display", "flex")
   const description = _this.parent().parent().find("[data-name='description']").text()
   console.log('description',description)
    $(".parent-embassy-modal p").text(description)
   map.invalidateSize()
   const popup = L.popup().setContent(title)

   marker.bindPopup(popup).openPopup()
}

//OPEN MODAL IN HTML
// $(".embassy-phone").click(function (){
//     $(this).children(".open-contact-information").toggleClass("toggle-open");
//     $(this).children(".embassy-data-phone i").toggleClass("fa-angle-up");
//     $(this).children(".embassy-data-phone i").toggleClass("fa-angle-down");
// });

//MODAL OPEN CLOSE
$(".icone-xmark").click(function () {
   $(".embassy-modal").css("display", "none")
   map.remove()
})

$(".embassy-modal").click(function (e) {
   if (e.target === this) {
      map.remove()
      $(".embassy-modal").css("display", "none")
   }
})
$(document).ready(function () {
   $('.embassy-grid').lookingfor({
      input: $('input#search_embassy'),
      items: '.embassy-parent',
      highlight: true,
      highlightColor: '#ffde00',
   });
})
