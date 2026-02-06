$("document").ready(function () {
   $('#visa_destination').next('.select2-container').find('b[role="presentation"]').remove();
   $(".visa-type-js").change(() => {
      $("#gdsVisa .cbox-count-passenger-js").show()
   })

   // بارگذاری خودکار کشورها هنگام لود صفحه
   if ($(".country-visa-js").length > 0) {
      getVisaTypeSpecialCountry()
   }

   // وقتی کشور انتخاب شد، انواع ویزای مربوط به آن را نمایش بده
   $(".country-visa-js").on('change', function() {
      fillVisaTypeByCountry(this)
   })

   if ($(".active-visa-js").length > 0) {
      getActiveVisas();
   }
   $(".active-visa-js").on('change', function() {
      fillActiveVisas(this)
   })
})
function fillComboByContinent(obj) {
   let continent_id = $(obj).val()
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      contentType: "application/json",
      data: JSON.stringify({
         method: "countriesOfContinentWithVisa",
         className: "reservationCountry",
         continent_id,
         is_json: true,
         to_json: true,
      }),
      success: function (response) {
         let obj_arrival = response.data
         let destination = $(".country-visa-js")
         destination.html(" ")
         destination.append(`<option value="">${useXmltag("ChoseOption")}...</option>`)

         Object.keys(obj_arrival).forEach(key => {
            let option_text = ''
            if(lang != 'fa') {
               option_text = `${obj_arrival[key]["name_en"]}`
            } else {
               option_text = `${obj_arrival[key]["name"]}`
            }

            let option_value = `${obj_arrival[key]["abbreviation"]}`
            let new_option = `<option value='${option_value}'>${option_text}</option>`
            destination.append(new_option)
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

function getVisaTypeSpecialCountry(obj) {
   let destination = $(".country-visa-js")

   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      contentType: "application/json",
      data: JSON.stringify({
         method: "getCountriesWithVisa",
         className: "country",
         is_json: true,
         to_json: true,
      }),
      success: function (response) {
         let obj_arrival = response.data
         destination.html("")
         destination.append(`<option value="">${useXmltag("ChoseOption")}...</option>`)
         destination.append(`<option value="all">${useXmltag("All")}</option>`)

         Object.keys(obj_arrival).forEach(key => {
            let option_text = ''

               option_text =  obj_arrival[key]["name"]

            let option_value = `${obj_arrival[key]["abbreviation"]}`
            let new_option = `<option value='${option_value}'>${option_text}</option>`
            destination.append(new_option)
         })
         // destination.select2("open")
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

function fillVisaTypeByCountry(obj) {
   let country_id = $(obj).val()

   if (!country_id) {
      // اگر کشوری انتخاب نشده، لیست نوع ویزا را خالی کن
      let visaTypeSelect = $(".visa-type-js")
      visaTypeSelect.html(`<option value="">${useXmltag("VisaType")}</option>`)
      return
   }

   // اگر "همه" انتخاب شد، همه انواع ویزا را نمایش بده
   let method = country_id === "all" ? "allVisaTypeList" : "getVisaTypeSpecialCountry"
   let data = {
      method: method,
      className: "visaType",
      to_json: true,
   }

   // فقط اگر کشور خاصی انتخاب شده، country_id را ارسال کن
   if (country_id !== "all") {
      data.country_id = country_id
   }

   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {

         let visa_types = response.data

         let visaTypeSelect = $(".visa-type-js")
         visaTypeSelect.html("")
         visaTypeSelect.append(`<option value="">${useXmltag("VisaType")}</option>`)
         visaTypeSelect.append(`<option value="all">${useXmltag("All")}</option>`)

         // visa_types باید یک آرایه باشد
         if (Array.isArray(visa_types)) {
            visa_types.forEach(visa_type => {
               let option_text = visa_type.title
               let option_value = visa_type.id
               let new_option = `<option value='${option_value}'>${option_text}</option>`
               visaTypeSelect.append(new_option)
            })
            visaTypeSelect.select2("open")
         } else {
            console.error('visa_types is not an array:', visa_types)
         }
      },
      error: function (error) {
         $.toast({
            heading: useXmltag("Error"),
            text: error.responseJSON ? error.responseJSON.message : useXmltag("ErrorLoadingVisaTypes"),
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

function getActiveVisas(obj) {
   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      contentType: "application/json",
      data: JSON.stringify({
         method: "getActiveVisa",
         className: "visa",
         is_json: true,
         to_json: true,
      }),
      success: function (response) {
         let destination = $(".active-visa-js")
         let obj_arrival = response.data

         destination.html("")
         destination.append(`<option value="">${useXmltag("ChoseOption")}...</option>`)
         Object.keys(obj_arrival).forEach(key => {
            let option_text = obj_arrival[key]["title"]
            let option_value = `${obj_arrival[key]["id"]}`;
            let distination_code = `${obj_arrival[key]["countryCode"]}`; // گرفتن distination_code
            let visa_type = `${obj_arrival[key]["typeId"]}`; // گرفتن distination_code
            let new_option = `<option value='${option_value}' data-distination-code='${distination_code}' data-visa-type-id='${visa_type}'>${option_text}</option>`;
            destination.append(new_option);
         })
         // destination.select2("open")
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


function fillActiveVisas(obj) {
   let visaId = $(obj).val();
   let distination_code = $(obj).data("distination-code"); // گرفتن distination_code از attribute
   let visa_type_id = $(obj).data("visa-type-id"); // گرفتن distination_code از attribute
   let form = $("#gdsVisa");

   form.find("#distination_code").val(distination_code);
   form.find("#visa_type").val(visa_type_id);
   form.find("#visaID").val(visaId);
}



function searchVisa(is_new_tab = false) {
   let country_visa = $(".country-visa-js")
   let visa_type = $(".visa-type-js")
   let count_passengers = $('.number-count-js').attr('data-number')

   checkSearchFields(
      country_visa,
      visa_type
   )

   country_visa = country_visa.val()
   visa_type = visa_type.val()

   let url = `${amadeusPathByLang}resultVisa/${country_visa}/${visa_type}`
   openLink(url, is_new_tab)
}
function searchActiveVisa(is_new_tab = false) {
   let form = $("#gdsVisa");
   var href = amadeusPathByLang + "passengersDetailVisa";

   form.attr("action", href);
   form.submit();
}

$('.box-of-count-passenger-boxes-visa-js,.div_btn').on('click', function(e) {
   $('.cbox-count-passenger-visa-js').toggle()
   $(this).parents().find('.down-count-passenger-visa').toggleClass('fa-caret-up')
   e.stopPropagation()
})