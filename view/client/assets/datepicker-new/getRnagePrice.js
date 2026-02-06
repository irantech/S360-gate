$(document).ready(function () {
   $('[data-toggle="tooltip"]').tooltip();



   $(document).on("click", ".deptCalendar , .btn", function () {
      let id = '';
      if($(this).hasClass('deptCalendar')){
        id = $(this).attr("id")
         var hiddenInput = document.createElement("input");

         // Set attributes for the input element
         hiddenInput.type = "hidden";
         hiddenInput.name = "calender_selected";
         hiddenInput.id = "calender_selected";
         hiddenInput.value = id;
         document.body.appendChild(hiddenInput);
         setTimeout(function(){
            console.log( $('#calender_selected').val())
         },200)
      }else{
         id = $('#calender_selected').val();
      }

      let explode_id = id.split("_")

      let type = explode_id[2]

      let origin = $(".origin-" + type + "-js").val()

      let class_element = $(`.${type}-one-way-js`)

      let min_price_total = []


      if (class_element.is(":checked")) {

         setTimeout(function () {
            let language = "fa"

            if (!$('#ui-datepicker-div').hasClass('ui-datepicker-rtl')) {
               language = "en"
            }
            let destination = $(".destination-" + type + "-js").val()

            let main_element = $("#ui-datepicker-div")
              .find("tbody")
              .find("tr")
              .find("td")
            let main_element_a = main_element.find("a")

               main_element.find('div').remove();


            if (
               origin !== undefined &&
               origin !== null &&
               destination !== undefined &&
               destination !== null
            ) {




               main_element_a.after(`<div class='calender-loader-container'>
                      <div class='calender-loader'></div>
                     </div>`)
               /* $('#ui-datepicker-div').find('tbody').find('tr').find('td').find('span').append(`<div class="calender-loader-container">
           <div class="calender-loader"></div>
          </div>`)*/

              $.ajax({
                type: "POST",
                url: amadeusPath + "ajax",
                dataType: "json",
                data: JSON.stringify({
                  className: "newApiFlight",
                  method: "getRangePriceFlight",
                  origin,
                  destination,
                  language,
                }),
                success: function(response) {
                  let data_response = response.data
                  main_element.each(function(index, element) {
                    let $element = $(element)
                    $element.find('.calender-loader-container').remove();
                    $element.append(`<div class='calender-loader-container'>
                      <div class='w-price'>---</div>
                     </div>`);
                    if (element.attributes["data-month"] !== undefined) {

                      let text_number_date = $element
                        .find("a")
                        .text()
                        .replace(/\s+/g, "");
                      data_response.forEach(function(price, id) {
                        if (text_number_date === price.day && (parseInt(element.attributes["data-month"].nodeValue) + 1).toString() === price.month && element.attributes["data-year"].nodeValue === price.year) {
                          min_price_total.push(price.min_price)
                        }
                      });
                    }
                  });

                  main_element.each(function(index, element) {
                    if (element.attributes["data-month"] !== undefined) {

                      let $element = $(element)

                      let text_number_date = $element
                        .text()
                        .replace(/[\s-]+/g, '');

                      $element.attr('data-toggle', 'tooltip')
                      $element.attr('title', 'جزییات قیمت');
                      // Use .find on the jQuery object
                      let loaderContainer = $element
                        .find("div.calender-loader-container")
                      loaderContainer.addClass('w-price')
                      loaderContainer.removeClass(
                        "calender-loader-container"
                      )
                      loaderContainer.text("---")
                      data_response.forEach(function(price, id) {
                        if (
                          text_number_date === price.day &&
                          (
                            parseInt(
                              element.attributes["data-month"]
                                .nodeValue
                            ) + 1
                          ).toString() === price.month &&
                          element.attributes["data-year"].nodeValue ===
                          price.year
                        ) {

                          loaderContainer.removeClass(
                            "w-price"
                          )
                          loaderContainer.text(
                            price.min_price
                          )
                          let new_div = $('<div class="detail-price">')

                          // let min_price_text = `کمترین قیمت : ${price.min_price}`
                          // let max_price_text = `بیشترین قیمت : ${price.max_price}`
                          // let price_average_price_text = `متوسط قیمت : ${price.price_average}`

                          let airline_min_name =
                            "  ایرلاین " +
                            price.min_name_airlines.join(", ")
                          /* let airline_max_name =
                             "  متعلق به: " +
                             price.max_name_airlines.join(", ")*/

                          // new_div.append(
                          //   $("<span>").text(min_price_text)
                          // )
                          // new_div.append(
                          //   $("<span>").text(max_price_text)
                          // )
                          // new_div.append(
                          //   $("<span>").text(price_average_price_text)
                          // )
                          new_div.append(
                            $("<span>").text(airline_min_name)
                          )
                          // new_div.append(
                          //   $("<span>").text(airline_max_name)
                          // )

                          new_div.attr('data-toggle', 'tooltip');
                          new_div.attr('title', 'جزییات قیمت');

                          $element.append(new_div)

                          let minValue = Math.min(...min_price_total)
                          let maxValue = Math.max(...min_price_total)
                          if(minValue === maxValue){
                            $element
                              .find("div")
                              .css("color", "#8E8D8D")
                          }else{
                            if (price.min_price === minValue) {
                              $element
                                .find("div")
                                .css("color", "#39ae00")
                            }
                            if (price.min_price === maxValue) {
                              $element
                                .find("div")
                                .css("color", "#ef4056")
                            }
                            if (price.min_price !== maxValue && price.min_price !== minValue) {
                              $element
                                .find("div")
                                .css("color", "#8E8D8D")
                            }
                          }

                        }
                      })
                    }
                  })
                  if(min_price_total.length > 0){
                    min_price_total.sort(function(a, b) {
                      return a - b
                    })
                    let minValue = Math.min(...min_price_total)
                    let maxValue = Math.max(...min_price_total)
                    // Find the middle number
                    let middleIndex = Math.floor(min_price_total.length / 2)
                    let middleNumber = min_price_total[middleIndex]
                    if(minValue!==maxValue){
                      $(".ui-datepicker-buttonpane")
                        .append(`<div class='calender-bottom-price'>
                                  <div class='div-calender-bottom-price div-background-color-calender-bottom-price-min'> ${minValue.toLocaleString()} </div>
                                  <div class='div-calender-bottom-price div-background-color-calender-bottom-price-max'>${maxValue.toLocaleString()} </div>
                                  </div>`)
                    }
                  }

                },

                // <div class='div-calender-bottom-price div-background-color-calender-bottom-price-middle'>${middleNumber.toLocaleString()} </div>
                error: function(error) {
                  main_element
                    .find("div.calender-loader-container").find(".calender-loader").removeClass(
                    "calender-loader"
                  );
                  console.log("error=>", error)
                },
              })
            }
         }, 100)
      }else{

         setTimeout(function () {
            let main_element = $("#ui-datepicker-div")
              .find("tbody")
              .find("tr")
              .find("td")

            console.log('return', main_element)
           main_element.find('span.ui-state-default').find('div').remove()
            main_element.find('span.ui-state-default').append(`
                      <div class='calender-loader-container'>
                          <div class='w-price'>---</div>
                      </div>
`);


            main_element.append(`<div class='calender-loader-container'>
                      <div class='w-price'>--</div>
                     </div>`);
         },100);
      }
   });


   $(document).on("click",".returnCalendar", function () {

      let main_element = $("#ui-datepicker-div")
        .find("tbody")
        .find("tr")
        .find("td")

     
      main_element.find('div').remove();

      setTimeout(function () {

         main_element.append(`<div class='calender-loader-container'>
                      <div class='w-price'>--</div>
                     </div>`);
      },100);

   });

})
