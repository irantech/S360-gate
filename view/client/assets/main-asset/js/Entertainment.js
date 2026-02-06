$("document").ready(function () {})

function getEntertainmentCities(obj) {
   let country_id = $(obj).val()

   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
         method: "getCities",
         className: "entertainment",
         country_id,
         is_json: true,
      }),
      success: function (response) {
         let obj_arrival = response.data
         let destination = $(".entertainment-city-js")
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

function getEntertainmentCategoriesSearchBox(obj) {
   let city_id = $(obj).val()

   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
         method: "getCategories",
         className: "entertainment",
         city_id,
         parent_id: "0",
         is_json: true,
      }),
      success: function (response) {
         let obj_arrival = response.data
         let destination = $(".category-entertainment-js")
         destination.html(" ")
         destination.append(' <option value="">انتخاب کنید...</option>')

         Object.keys(obj_arrival).forEach(key => {
            let option_text = `${obj_arrival[key]["title"]}`
            let option_value = `${obj_arrival[key]["id"]}`
            let new_option = `<option value='${option_value}'>${option_text}</option>`
            destination.append(new_option).trigger("open")
         })
         destination.select2("open")
      },
      error: function (error) {
         $.toast({
            heading: "اطلاعات مقصد",
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

function getEntertainmentSubCategories(obj) {
   let parent_id = $(obj).val()
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify({
         method: "getCategoriesSub",
         className: "entertainment",
         parent_id:parent_id,
         is_json: true,
      }),
      success: function (response) {
         let obj_arrival = response.data
         let destination = $(".sub-category-entertainment-js")
         destination.html(" ")
         destination.append(' <option value="">انتخاب کنید...</option>')

         Object.keys(obj_arrival).forEach(key => {
            let option_text = `${obj_arrival[key]["title"]}`
            let option_value = `${obj_arrival[key]["id"]}`
            let new_option = `<option value='${option_value}'>${option_text}</option>`
            destination.append(new_option).trigger("open")
         })
         destination.select2("open")
      },
      error: function (error) {
         $.toast({
            heading: "اطلاعات مقصد",
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

function searchEntertainment(is_new_tab = false) {
   let entertainment_destination_country = $(
      ".entertainment-destination-country-js"
   )
   let entertainment_city = $(".entertainment-city-js")
   let category_entertainment = $(".category-entertainment-js")
   let sub_category_entertainment = $(".sub-category-entertainment-js")

   checkSearchFields(
      entertainment_destination_country,
      entertainment_city,
      category_entertainment,
      sub_category_entertainment
   )

   entertainment_destination_country = entertainment_destination_country.val()
   entertainment_city = entertainment_city.val()
   category_entertainment = category_entertainment.val()
   sub_category_entertainment = sub_category_entertainment.val()

   let url = `${amadeusPathByLang}resultEntertainment/${entertainment_destination_country}/${entertainment_city}/${sub_category_entertainment}`
   openLink(url, is_new_tab)
}
