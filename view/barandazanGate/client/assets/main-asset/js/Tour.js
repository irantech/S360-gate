$("document").ready(function () {
   setTimeout(() => {
      $(".internal-date-travel-tour-js").select2();
   },300)
   setTimeout(() => {
      $(".international-date-travel-tour-js").select2();
   },500)

   $(".switch-input-tour-js").on("change", function () {
      if (this.checked && this.value === "1") {
         $(".international-tour-js").css("display", "flex")
         $(".internal-tour-js").hide()
      } else {
         $(".international-tour-js").hide()
         $(".internal-tour-js").css("display", "flex")
      }
   })

   $(".internal-destination-tour-js").change(() => {
      $(".internal-date-travel-tour-js").select2("open")
   })
   $(".international-destination-city-tour-js").change(() => {
      $(".international-date-travel-tour-js").select2("open")
   })


})

function getArrivalCitiesTour(type, obj) {
   let city_id = $(obj).val()
   let category_id = $(`.${type}#category_id`).val()
   let like_category = $(`.${type}#like_category`).val()
   let method = "getTourCities";
   if(type == 'ziaraty') {
       method = "getZiaratyTourCity";
   }
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
         method: method,
         className: "mainTour",
         city_id,
         category_id ,
         like_category ,
         type,
      }),
      success: function (response) {
         let obj_arrival = response.data
         let destination = $("." + type + "-destination-tour-js")
         destination.html(" ")
         destination.append(` <option value="">${useXmltag("ChoseOption")}...</option>`)
         if (obj_arrival !== null){
            Object.keys(obj_arrival).forEach(key => {
               let option_text = ''
               if(lang == 'fa') {
                  option_text =
                    obj_arrival[key]["name"] == ""
                      ? `${obj_arrival[key]["name_en"]}`
                      : `${obj_arrival[key]["name"]}`
               }else{
                  option_text = `${obj_arrival[key]["name_en"]}`
               }


               let option_value = `${obj_arrival[key]["id"]}`
               let new_option = `<option value='${option_value}'>${option_text}</option>`
               destination.append(new_option).trigger("open")
            })
         }
         $(`.${type}-destination-tour-js`).select2("open")
         if (city_id !== undefined) {
            destination.val(city_id).trigger("open")
         } else {
            destination.select2("open")
         }
      },
      error: function (error) {
         $.toast({
            heading: useXmltag("DestinationInfo"),
            text: error.responseJSON.message,
            position: "top-right",
            loaderBg: "#fff",
            icon: "error",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
         })
      },
   })
}

function getDestinationCityTour(type, obj) {
   let country_id = $(obj).val()
   let category_id = $(`.${type}#category_id`).val()
   let like_category = $(`.${type}#like_category`).val()
   let origin_city = $(`#tourOriginCityPortal`).val()
   console.log(country_id)
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
         method: "tourExternalCountryCity",
         className: "mainTour",
         country_id,
         category_id ,
         origin_city ,
         like_category
      }),
      success: function (response) {
         let obj_arrival = response.data
         let destination = $("." + type + "-destination-city-tour-js")
         destination.html(" ")
         destination.append(` <option value="">${useXmltag("ChoseOption")}...</option>`)

         Object.keys(obj_arrival).forEach(key => {
            let option_text = '' ;
            if(lang != 'fa') {
               option_text = `${obj_arrival[key]["name_en"]}`
            }else{
               option_text = `${obj_arrival[key]["name"]}`
            }
            let option_value = `${obj_arrival[key]["id"]}`
            let new_option = `<option value='${option_value}'>${option_text}</option>`
            destination.append(new_option).trigger("open")
         })
         destination.select2("open")
      },
      error: function (error) {
         $.toast({
            heading: useXmltag("DestinationInfo"),
            text: error.responseJSON.message,
            position: "top-right",
            loaderBg: "#fff",
            icon: "error",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
         })
      },
   })
}
function searchInternalTour() {
   const form = document.getElementById('gdsTourLocal');
   const is_new_tab = form.target === '_blank';

   let internal_origin_tour = $(".internal-origin-tour-js")
   let internal_destination_tour = $(".internal-destination-tour-js")
   let internal_date_travel_tour = $(".internal-date-travel-tour-js")

   console.log('internal_date_travel_tour' , internal_date_travel_tour.val())

   checkSearchFields(
      internal_origin_tour,
      internal_destination_tour,
      internal_date_travel_tour
   )

   internal_origin_tour = internal_origin_tour.val()
   internal_destination_tour = internal_destination_tour.val()
   internal_date_travel_tour = internal_date_travel_tour.val()

   let url = `${amadeusPathByLang}resultTourLocal/1-${internal_origin_tour}/1-${internal_destination_tour}/${internal_date_travel_tour}/all`
   openLink(url, is_new_tab)
}
function searchInternationalTour() {
   const form = document.getElementById('gdsPortalLocal');
   const is_new_tab = form.target === '_blank';
   let international_tour = $(".international-tour-origin-city-js")
   let international_destination_tour = $(".international-destination-tour-js")
   let international_destination_city_tour = $(".international-destination-city-tour-js")
   let internal_date_travel_tour = $(".international-date-travel-tour-js")

   checkSearchFields(
      international_tour,
      international_destination_tour,
      international_destination_city_tour,
      internal_date_travel_tour
   )

   international_tour = international_tour.val()
   international_destination_tour = international_destination_tour.val()
   international_destination_city_tour =
      international_destination_city_tour.val()
   internal_date_travel_tour = internal_date_travel_tour.val()

   let url = `${amadeusPathByLang}resultTourLocal/1-${international_tour}/${international_destination_tour}-${international_destination_city_tour}/${internal_date_travel_tour}/all`
   // let url = `${amadeusPathByLang}tours/تور-های-${international_tour.replace(' ','')}?origin=${international_destination_tour}-${international_destination_city_tour}&date=${internal_date_travel_tour}&type=all`
   console.log(url)

   openLink(url, is_new_tab)
}


function searchZiaratiTour(is_new_tab = false) {
   let ziaraty_tour = $(".ziaraty-tour-origin-city-js")
   let ziaraty_destination_tour = $(".ziaraty-destination-tour-js")
   let ziaraty_destination_city_tour = $(
     ".ziaraty-destination-city-tour-js"
   )
   let ziaraty_date_travel_tour = $(".ziaratiy-date-travel-tour-js")

   checkSearchFields(
     ziaraty_tour,
     ziaraty_destination_tour,
     ziaraty_destination_city_tour,
     ziaraty_date_travel_tour
   )

   ziaraty_tour = ziaraty_tour.val()
   ziaraty_destination_tour = ziaraty_destination_tour.val()
   ziaraty_destination_city_tour =
     ziaraty_destination_city_tour.val()
   ziaraty_date_travel_tour = ziaraty_date_travel_tour.val()

   let url = `${amadeusPathByLang}resultTourLocal/1-${ziaraty_tour}/${ziaraty_destination_tour}-${ziaraty_destination_city_tour}/${ziaraty_date_travel_tour}/5`
   openLink(url, is_new_tab)
}
