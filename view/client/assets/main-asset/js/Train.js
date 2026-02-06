$("document").ready(function () {

   $(".destination-train-js, .origin-train-js").select2({
      matcher: function(params, data) {
         if ($.trim(params.term) === '') {
            return data;
         }

         // Normalize both search term and option text
         let searchTerm = normalizePersian(params.term);
         let optionText = normalizePersian(data.text);

         if (optionText.includes(searchTerm)) {
            return data;
         }

         return null;
      }
   });

   $(".origin-train-js").change(() => {
      $(".destination-train-js").select2('open');
   })
   $(".destination-train-js").change(() => {
      $(".train-departure-date-js").focus()
   })
})
function normalizePersian(text) {
   if (!text) return "";
   return text.replace(/ك/g, "ک").replace(/ي/g, "ی");
}

function reversRouteTrain() {
   let origin = "";
   let destination = "";
   let destination_txt = "";
   let origin_txt = "";
   let start_txt = $("#select2-origin_train-container").text();
   let end_txt = $("#select2-destination_train-container").text();
   let element_origin = $("select#origin_train option:selected");
   let element_span_origin = $("span#select2-origin_train-container");
   let element_span_destination = $("span#select2-destination_train-container");
   let element_destination = $("select#destination_train option:selected");
   if (start_txt !== "انتخاب مبدأ" && end_txt !== "انتخاب مقصد") {
      origin = element_origin.val()
      destination = element_destination.val()
      destination_txt = element_destination.text()
      origin_txt = element_origin.text()
      if (destination !== "") {
         element_origin.val(destination)
         element_origin.text(destination_txt)
         element_span_origin.text(destination_txt)
         element_destination.val(origin)
         element_destination.text(origin_txt)
         element_span_destination.text(origin_txt)
      } else {
         $.toast({
            heading: "نغییر مسیر",
            text: "",
            position: "top-right",
            loaderBg: "#fff",
            icon: "error",
            hideAfter: 3500,
            textAlign: "right",
            stack: 6,
         })
      }
   }
}

function searchTrain(is_new_tab=false){
   const number_adult = parseInt($(".train-adult-js").val()) ? parseInt($(".train-adult-js").val()) : 0
   const number_child = parseInt($(".train-child-js").val()) ? parseInt($(".train-child-js").val()) : 0
   const number_infant = parseInt($(".train-infant-js").val()) ? parseInt($(".train-infant-js").val()) : 0
   const multi_way = $(".train-one-way-js").is('checked')?1:2
   const train_seat_type = parseInt($(".train-seat-type-js:checked").val())
   const train_coupe_type = $(".train-coupe-type-js:checked").val() ? 1 : 0

   let origin_train = $(".origin-train-js")
   let destination_train = $(".destination-train-js")
   let train_departure_date = $(".train-departure-date-js")
   let train_arrival_date = $(".train-arrival-date-js")

   checkSearchFields(
      origin_train,
      destination_train,
      train_departure_date,
      train_arrival_date
   )

   origin_train = origin_train.val()
   destination_train = destination_train.val()
   train_departure_date = train_departure_date.val()
   train_arrival_date = train_arrival_date.val()

   let date =
      multi_way === 2
         ? `${train_departure_date}&${train_arrival_date}`
         : `${train_departure_date}`

   let count_passenger = `${number_adult}-${number_child}-${number_infant}`

   let url = `${amadeusPathByLang}trainResult/${origin_train}-${destination_train}/${date}/${train_seat_type}/${count_passenger}/${train_coupe_type}`

   openLink(url,is_new_tab)
}
