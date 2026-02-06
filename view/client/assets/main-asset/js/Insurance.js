$("document").ready(function () {
   $(".select-route-insurance-js").select2({
      ajax: {
         type: "POST",
         url: amadeusPath + "ajax",
         dataType: "json",
         delay: 250,
         data: function (params) {
            return JSON.stringify({
               value: params.term, // search term
               className: "insuranceCountry",
               method: "routeInsurance",
            })
         },
         cache: true,
         // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
      },
      placeholder: "جستجو بین شهر ها",
      minimumInputLength: 1,
      language: {
         inputTooShort: function () {
            return "شما باید حداقل یک حرف وارد کنید"
         },
         searching: function () {
            return "در حال جستجو ... "
         },
         noResults: function () {
            return " جستجوی شما نتیجه ایی ندارد"
         },
      },
   })

   $(".insurance-destination-country-js").change(() => {
      $(".travel-time-js").select2('open')
   })
   $(".travel-time-js").change(() => {
      if($(".passengers-count-js").data("select2")) {
      $(".passengers-count-js").select2('open')
      }else{
         const dropdownMenu = document.querySelector('.dropdown-menu-insurance')
         dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
      }
   })
   $(".passengers-count-js").change(() => {
      $("#txt_birth_insurance1").focus()
   })
})

$(".number-of-passengers-js").on("change", function (e) {
   let element_passenger = $(".count-passengers-js")
   let item_insurance = $(this).val()
   item_insurance++
   let i = 1
   let calenders = $('.passenger-age-div-js');
   let clone = calenders.first().clone()
   $('.count-passengers-js').html("")
   console.log(clone)
   while (i < item_insurance) {

       if(i != 1) {
          let calenders = $('.passenger-age-div-js');
          let clone = calenders.first().clone()
          clone.find('input').each(function() {
             $(this).val('')
          })
          calenders.last().after(clone)
       }else {
          clone.find('input').each(function() {
             $(this).val('')
          })
          element_passenger.append(clone)
       }
      setTimeoutShamsiCalendar()
      i++
   }
   let counter = 1
   $('.passenger-age-div-js').each(function() {
      $(this)
        .find('[id]')
        .each(function() {
           $(this).removeClass('hasDatepicker')
           if ($(this).hasClass('passengers-age-js')) {
              $(this).attr('name', `txt_birth_insurance${counter}`)
              $(this).attr('id', `txt_birth_insurance${counter}`)
              $(this).attr('placeholder', `تاریخ تولد مسافر ${counter}`)
           }
        })
      counter++
   })

})

$(".number_2-of-passengers-js").on("change", function (e) {
   console.log('ey vay ')
   let element_passenger = $(".count-passengers-js")
   let item_insurance = $(this).val()

   item_insurance++
   let calender = ""
   element_passenger.html("")

   let i = 1
   while (i < item_insurance) {
      calender += `<div class='col-6 col_search search_col nafarat-bime '>
      <div class='form-group'>
      <input placeholder='تاریخ تولد مسافر ${i}' readonly=""  autocomplete='off' type='text' name='txt_birth_insurance${i}' id='txt_birth_insurance${i}' 
      class='shamsiBirthdayCalendar passengers-age-js form-control' />
      </div>
      </div>`
      i++
   }

   element_passenger.append(calender)
})
function searchInsurance(is_new_tab=false) {
   let insurance_destination_country = $(".insurance-destination-country-js")
   let travel_time = $(".travel-time-js")
   let passengers_count = $(".passengers-count-js")
   const passengers_age = $(".passengers-age-js")
   console.log(passengers_age)
   checkSearchFields(
      insurance_destination_country,
      travel_time,
      passengers_count,
      passengers_age
   )
console.log(passengers_age ,'fararaara')
   insurance_destination_country=insurance_destination_country.val()
   travel_time=travel_time.val()
   passengers_count=passengers_count.val()

   let passengers_age_array = []
   passengers_age.map(function (idx, elem) {
      passengers_age_array.push($(elem).val())
   })

   let passenger_age_list = passengers_age_array.join("/")
// console.log(passenger_age_list)
   let url = `${amadeusPathByLang}resultInsurance/2/${insurance_destination_country}/${travel_time}/${passengers_count}/${passenger_age_list}`
   openLink(url,is_new_tab)
}



function searchInsuranceWithType(is_new_tab=false) {


   let insuranceType = $("#insuranceType").val();

   if (insuranceType === "internal") {
      insurance_destination_country = $(".insurance-destination-country-internal-js")
      type_country = 1
   } else {
      insurance_destination_country = $(".insurance-destination-country-js")
      type_country = 2
   }
   let travel_time = $(".travel-time-js")
   let passengers_count = $(".passengers-count-js")


   const passengers_age = $(".passengers-age-js")
   // console.log(passengers_age)
   console.log(passengers_count)
   checkSearchFields(
      insurance_destination_country,
      travel_time,
      passengers_count,
      passengers_age
   )

   insurance_destination_country=insurance_destination_country.val()
   travel_time=travel_time.val()
   passengers_count=passengers_count.val()
   // alert(passengers_count)
   let passengers_age_array = []
   passengers_age.map(function (idx, elem) {
      passengers_age_array.push($(elem).val())
   })

   let passenger_age_list = passengers_age_array.join("/")

        let url = `${amadeusPathByLang}resultInsurance/${type_country}/${insurance_destination_country}/${travel_time}/${passengers_count}/${passenger_age_list}`

   openLink(url,is_new_tab)
}


function toggleInsuranceType() {
   let type = document.getElementById('insuranceType').value;
   if (type === 'internal') {
      document.getElementById('internalSection').style.display = 'block';
      document.getElementById('externalSection').style.display = 'none';
   } else {
      document.getElementById('internalSection').style.display = 'none';
      document.getElementById('externalSection').style.display = 'block';
   }
}
