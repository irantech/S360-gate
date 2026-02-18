// قرار بده این رو اول از همه (قبل از بقیه اسکریپت‌ها یا در بالا)
// (function(){
//    const PARENT = document.getElementById('Hotel'); // <-- والدت اینجا
//    if(!PARENT) return;
//
//    // نگهدار متدهای اصلی
//    const _qs  = document.querySelector.bind(document);
//    const _qsa = document.querySelectorAll.bind(document);
//    const _gid = document.getElementById.bind(document);
//    const _gecn = document.getElementsByClassName.bind(document);
//    const _getn = document.getElementsByName ? document.getElementsByName.bind(document) : null;
//    const _gett = document.getElementsByTagName.bind(document);
//
//    document.querySelectorAll = function(sel){
//       // تلاش کن داخل والد پیدا کنی؛ اگر پیدا شد همون نتایج رو برگردون
//       const inside = Array.from(PARENT.querySelectorAll(sel || ''));
//       if(inside.length) return inside;
//       return _qsa(sel);
//    };
//
//    document.querySelector = function(sel){
//       const inside = PARENT.querySelector(sel);
//       if(inside) return inside;
//       return _qs(sel);
//    };
//
//    document.getElementById = function(id){
//       // اول داخل والد بعد سند
//       const inside = PARENT.querySelector('#' + CSS.escape(id));
//       if(inside) return inside;
//       return _gid(id);
//    };
//
//    document.getElementsByClassName = function(name){
//       const inside = Array.from(PARENT.getElementsByClassName(name));
//       if(inside.length) return inside;
//       return _gecn(name);
//    };
//
//    document.getElementsByTagName = function(tag){
//       const inside = Array.from(PARENT.getElementsByTagName(tag));
//       if(inside.length) return inside;
//       return _gett(tag);
//    };
//
//    if(_getn){
//       document.getElementsByName = function(name){
//          const inside = Array.from(PARENT.querySelectorAll(`[name="${name}"]`));
//          if(inside.length) return inside;
//          return _getn(name);
//       };
//    }
//
// })();


$("document").ready(function () {
   $("body").on("click", function () {
      $(".div-hotel-city-js").addClass("d-none")
   })

   $(".div-hotel-city-js").bind("click", function (e) {
      e.stopPropagation()
   })

   $(".switch-input-hotel-js").on("change", function () {
      $(".init-shamsi-datepicker").val("")
      $(".init-shamsi-return-datepicker").val("")
      $(".nights-hotel-js").val("")
      if (this.checked && this.value === "1") {
         $(".internal-hotel-js").css("display", "flex")
         $(".international-hotel-js").hide()
         $(".type-section-js").val("internal")
      } else {
         $(".internal-hotel-js").hide()
         $(".international-hotel-js").css("display", "flex")
         $(".type-section-js").val("international")
      }
   })

   $(".city-view-js").on("click", function () {
      $(this).addClass("activing_tab")
      $(".tabs-content-city-js").show()
      $(".hotel-view-js").removeClass("activing_tab")
      $(".tabs-content-view-hotel-js").hide()
   })

   $(".hotel-view-js").on("click", function () {
      $(this).addClass("activing_tab")
      $(".tabs-content-view-hotel-js").show()
      $(".city-view-js").removeClass("activing_tab")
      $(".tabs-content-city-js").hide()
   })

   $(".search-hotel-js").on("input", function () {
      let input_value = $(this).val()
      let type_search = $(this).data("search")
      let type_application = $(".type-application-js").val()
      if (input_value.length >= 2) {
         $.ajax({
            type: "POST",
            url: amadeusPath + "ajax",
            dataType: "json",
            data: JSON.stringify({
               method: "getResultForSearchBox",
               className: "hotelCities",
               input_value,
               type_application,
               type_search,
            }),
            success: function (response) {
               $(".div-hotel-city-js").show()
               if (response != "") {
                  let data_response = JSON.parse(JSON.stringify(response))
                  if (type_search === "internal") {
                     viewResultInternalHotel(data_response)
                  } else {
                     viewResultInternationalHotel(data_response)
                  }
               } else {
                  console.log("empty message")
                  showEmptyMessage(type_search, true)
               }
            },
         })
      } else {
         showEmptyMessage(type_search)
      }
   })
})

function openCountPassenger(type_section) {
   $("." + type_section + "-my-hotels-rooms-js").toggleClass("active_p")
}

$('body').click((e) => {
   $('.internal-my-hotels-rooms-js').removeClass("active_p")
   $('.international-my-hotels-rooms-js').removeClass("active_p")
   $('.residence-my-hotels-rooms-js').removeClass("active_p")
});

$('.internal-hotel-passenger-picker-js').click((e) => {
   e.stopPropagation()
});
$('.residence-passenger-picker-js').click((e) => {
   e.stopPropagation()
});
$('.international-hotel-passenger-picker-js').click((e) => {
   e.stopPropagation()
});

$('.internal-close-room-js').click((e) => {
   $('.internal-my-hotels-rooms-js').removeClass("active_p")
});

$('.residence-close-room-js').click((e) => {
   $('.residence-my-hotels-rooms-js').removeClass("active_p")
});

$('.international-close-room-js').click((e) => {
   $('.international-my-hotels-rooms-js').removeClass("active_p")
});

$('.residence-close-room-js').click((e) => {
   $('.residence-my-hotels-rooms-js').removeClass("active_p")
});

function addRoom(type_section) {
   $("." + type_section + "-my-hotels-rooms-js ." + type_section + "-close-room-js").show()
   let room_count = parseInt($("." + type_section + "-my-room-hotel-item-js").length)
   if (room_count <= 4) {

      let number_adult = parseInt($("." + type_section + "-number-adult-js").text())
      let number_room = parseInt($("." + type_section + "-number-room-js").text())
      $("." + type_section + "-number-adult-js").text(number_adult + 1)
      $("." + type_section + "-number-room-js").text(number_room + 1)
      let code = createRoomHotelLocal(room_count, type_section)
      $("." + type_section + "-hotel-select-room-js").append(code)
      if (room_count >= 3) {
         $("." + type_section + "-btn-add-room-js").hide()
      }
      if (room_count >= 1) {
         $("." + type_section + "-my-hotels-rooms-js .close").removeClass("d-none")
         $("." + type_section + "-my-hotels-rooms-js .close").show()
      }
   }
}

function addNumberAdult(type_section, obj) {
   console.log('ssssssssssssss')
   console.log(type_section)
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-count-parent-js")
      .val()

   if (input_num < 7) {
      input_num++
      let number_adult = parseInt(
         $("." + type_section + "-number-adult-js").text()
      )
      let result_number = number_adult + 1
      console.log(result_number)
      $(obj)
         .parent("div")
         .find("." + type_section + "-count-parent-js")
         .val(input_num)
      $("." + type_section + "-number-adult-js").html("")
      $("." + type_section + "-number-adult-js").append(result_number)
   }
}

function minusNumberAdult(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-count-parent-js")
      .val()

   if (input_num > 1) {
      input_num--
      let number_adult = parseInt($("." + type_section + "-number-adult-js").text())
      let result_number = number_adult - 1
      $(obj)
         .parent("div")
         .find("." + type_section + "-count-parent-js")
         .val(input_num)
      $("." + type_section + "-number-adult-js").html("")
      $("." + type_section + "-number-adult-js").append(result_number)
   }
}

function addNumberChild(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-count-child-js")
      .val()
   console.log("add child==>" + input_num)
   input_num++
   if (input_num < 5) {
      let number_child = parseInt(
         $("." + type_section + "-number-child-js").text()
      )

      let result_number = number_child + 1
      $(obj)
         .parent("div")
         .find("." + type_section + "-count-child-js")
         .val(input_num)
      $("." + type_section + "-number-child-js").html("")
      $("." + type_section + "-number-child-js").append(result_number)

      let room_number = $(obj)
         .parents("." + type_section + "-my-room-hotel-item-js")
         .data("roomnumber")

      let html_box = createBirthdayCalendar(input_num, room_number)

      $(obj)
         .parents("." + type_section + "-my-room-hotel-item-info-js")
         .find("." + type_section + "-birth-days-js")
         .html(html_box)
   }
}

function minusNumberChild(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-count-child-js")
      .val()

   if (input_num > 0) {
      let number_child = parseInt(
         $("." + type_section + "-number-child-js").text()
      )

      let result_number = number_child - 1

      input_num--
      $(obj)
         .parent("div")
         .find("." + type_section + "-count-child-js")
         .val(input_num)
      $("." + type_section + "-number-child-js").html("")
      $("." + type_section + "-number-child-js").append(result_number)

      let room_number = $(obj)
         .parents("." + type_section + "-my-room-hotel-item-js")
         .data("roomnumber")

      let html_box = createBirthdayCalendar(input_num, room_number)

      $(obj)
         .parents("div." + type_section + "-my-room-hotel-item-info-js")
         .find("." + type_section + "-birth-days-js")
         .html(html_box)
   } else {
      $(obj)
         .parents("div")
         .find("." + type_section + "-count-child-js")
         .val("0")
   }
}

function itemsRoom(_this,type_section) {
   let room_count = $("." + type_section + "-my-room-hotel-item-js").length

   let child_count_this = parseInt(
     _this
         .parents("." + type_section + "-my-room-hotel-item-js")
         .find("." + type_section + "-count-child-js")
         .val()
   )
   let number_child = parseInt(
      $("." + type_section + "-number-child-js").text()
   )

   console.log([number_child,child_count_this]);

   $("." + type_section + "-number-child-js").text(
      number_child - child_count_this
   )

   let adult_count_this =_this
      .parents("." + type_section + "-my-room-hotel-item-js")
      .find("." + type_section + "-count-parent-js")
      .val()
   let number_adult = $("." + type_section + "-number-adult-js").text()
   $("." + type_section + "-number-adult-js").text(
      number_adult - adult_count_this
   )

   $("." + type_section + "-btn-add-room-js").show()

   _this
      .parents("." + type_section + "-my-room-hotel-item-js")
      .remove()
   let number_room = 1
   let number_text = useXmltag('First')
   $("." + type_section + "-my-room-hotel-item-js").each(function () {
       $(this).data("roomnumber", number_room)

      console.log("roomnumber=>" + number_room)
      if (number_room == 1) {
         number_text = useXmltag('First')
      } else if (number_room == 2) {
         number_text = useXmltag('Second')
      } else if (number_room == 3) {
         number_text = useXmltag('Third')
      } else if (number_room == 4) {
         number_text = useXmltag('Fourth')
      }
      $(this)
         .find("." + type_section + "-my-room-hotel-item-title-js")
         .html(
            `<span class="close" onclick="itemsRoom($(this),'${type_section}')"><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"/></svg></i> </span> ${useXmltag('Room')} ${number_text}`
         )
      $(this)
         .find("." + type_section + "-my-room-hotel-item-info-js")
         .find("input[name^='adult']")
         .attr("name", "adult" + number_room)
      $(this)
         .find("." + type_section + "-my-room-hotel-item-info-js")
         .find("input[name^='adult']")
         .attr("id", "adult" + number_room)
      $(this)
         .find("." + type_section + "-my-room-hotel-item-info-js")
         .find("input[name^='child']")
         .attr("name", "child" + number_room)
      $(this)
         .find("." + type_section + "-my-room-hotel-item-info-js")
         .find("input[name^='child']")
         .attr("id", "child" + number_room)


      let number_child = 1
      let input_name_select_child_age =_this.find(
         ".birth-days-js .birth-days-item-js"
      )
      input_name_select_child_age.each(function () {
         $(this)
            .find("select[name^='child_age']")
            .attr("name", "child_age" + number_room + number_child)
         $(this)
            .find("select[name^='child_age']")
            .attr("id", "child_age" + number_room + number_child)
         number_child++
      })
      number_room++
   })

   let number_room_total = parseInt(
     $("." + type_section + "-number-room-js").text()
   )

   $("." + type_section + "-number-room-js").text(number_room - 1)


   if (room_count === 2) {
      $("." + type_section + "-my-hotels-rooms-js .close").addClass("d-none")
   }

}

function viewResultInternalHotel(data_response) {
   let hotels_html = ""
   let cities_html = ""
   let hotels_view = $(".tabs-content-view-hotel-js")
   let cities_view = $(".tabs-content-city-js")

   if (data_response.cities != undefined) {
      $.each(data_response.cities, function (index, city) {
         console.log(city.CityName)
         cities_html += `<li class="tabs_content_sub" id="sub_tabs_hotel">
                                <a  data-citycode="${city.city_id}"
                                    data-cityname="${city.city_name}"
                                    data-hotelid="${city.city_id}"
                                    data-page=${city.page}
                                    data-typeapp=${city.type_app}
                                     onclick="selectCityForHotelLocal('${city.city_id}')" class="selectCityForHotelLocal-${city.city_id}  a_beafore" >
                                    ${city.city_name}
                                </a>
                        </li>`
      })
   } else {
      $(".tabs-sub-hotel-js .tabs_ul_hotel .hotel-view-js").addClass(
         "activing_tab"
      )

      hotels_view.show()
      cities_view.hide()
   }

   if (data_response.hotels != undefined) {
      $.each(data_response.hotels, function (index, hotel) {
         hotels_html += `<li class="tabs_content_sub" id="sub_tabs_hotel">
                            <a class="selectCityForHotelLocal-${hotel.hotel_id}  a_beafore"
                              data-cityCode="${hotel.city_id}"
                              data-cityName="${hotel.city_name}"
                              data-page="${hotel.page}"
                              data-hotelId="${hotel.hotel_id}"
                              data-hotelName="${hotel.hotel_name}"
                              data-typeApp="${hotel.type_app}"
                              data-hotelNameEn="${hotel.hotel_name_en}"
                              onclick="selectCityForHotelLocal('${hotel.hotel_id}')">${hotel.hotel_name}</a>

                            </li>`
      })
      $(".tabs-sub-hotel-js .tabs_ul_hotel .hotel-view-js").addClass(
         "activing_tab"
      )
   } else {
      $(".tabs-sub-hotel-js .tabs_ul_hotel .city-view-js").addClass(
         "activing_tab"
      )

      cities_view.show()
      hotels_view.hide()
   }

   if (hotels_html != "" && cities_html != "") {
      $(".tabs-sub-hotel-js .tabs_ul_hotel .city-view-js").addClass(
         "activing_tab"
      )
      hotels_view.hide()
      cities_view.show()
   }

   cities_view.html(cities_html)
   hotels_view.html(hotels_html)

   $(".div-hotel-city-js").removeClass("d-none")
   $(".error-js").text("")
}

function selectCityForHotelLocal(id) {
   $(".check-in-date-js").trigger("focus")

   let _thisElement = $(".selectCityForHotelLocal-" + id)
   let cityCode = _thisElement.data("citycode")
   let cityName = _thisElement.data("cityname")
   let hotelId = _thisElement.data("hotelid")
   let hotelName = _thisElement.data("hotelname")
   let hotelNameEn = _thisElement.data("hotelnameen")
   let page = _thisElement.data("page")
   let typeApp = _thisElement.data("typeapp")

   if (page === "roomHotelLocal") {
      $(".search-hotel-js").val(hotelName)
   }

   if (page === "hotelCities") {
      $(".search-hotel-js").val(cityName)
   }
   if (page === "apiHotels") {
      $(".search-hotel-js").val(hotelName)
   }

   $(".city-for-hotel-local-js").val(cityCode)
   $(".page-js").val(page)
   $(".hotel-id-js").val(hotelId)
   $(".hotel-name-en-local-js").val(hotelNameEn)
   $(".type-application-js").val(typeApp)

   $(".div-hotel-city-js").addClass("d-none")
}

function showEmptyMessage(type_search, null_message) {
   $(".tabs-content-view-hotel-js").html("")
   $(".tabs-content-city-js").html("")
   let lang_message = ""
   let html = ""
   if (
      null_message != "undefined" &&
      null_message &&
      type_search === "international"
   ) {
      $(".div-hotel-city-js").html("")
      lang_message = "موردی یافت نشد"
      html += `<ul>
                    <li class="textSearchFlightForeign c-sr-airport">
                    No items were found for your search
                    </li>
              </ul>`

      $(".div-hotel-city-js").html(html).removeClass("d-none")
   } else {
      if (
         null_message != "undefined" &&
         null_message &&
         type_search === "internal"
      ) {
         lang_message = "حداقل دو حرف وارد نمائید"
      } else {
         lang_message = "Enter at least two letters"
      }
      html += `<div class="tabs_content_sub" id="sub_tabs_city"> 
                    <ul>
                       <li >
                           <a href="#" onclick="return false">${lang_message}</a>
                       </li>
                    </ul>
               </div>`
      $(".error-js").html(html)
      $(".div-hotel-city-js").removeClass("d-none")
   }
}

function createBirthdayCalendar(inputNum, roomNumber) {
   console.log("inputNum" + inputNum)
   var i = 1
   var HtmlCode = ""
   let number_textChild = "سلام"
   while (i <= inputNum) {
      if (i === 1) {
         number_textChild = useXmltag('First')
      } else if (i === 2) {
         number_textChild = useXmltag('Second')
      } else if (i === 3) {
         number_textChild = useXmltag('Third')
      } else if (i === 4) {
         number_textChild = useXmltag('Fourth')
      }
      HtmlCode +=
         '<div class="tarikh-tavalod-item birth-days-item-js">' +
         "<span><i>" +
        useXmltag('Childage') +
        ' ' +
         number_textChild +
         "</i></span>" +
         '<select id="child_age' +
         roomNumber +
         i +
         '" name="child_age' +
         roomNumber +
         i +
         '">' +
         '<option value="1">'+useXmltag('ZeroToOneYear')+'</option>' +
         '<option value="2">'+useXmltag('OneToTwoYear')+'</option>' +
         '<option value="3">'+useXmltag('TwoToThreeYear')+'</option>' +
         '<option value="4">'+useXmltag('ThreeToFourYear')+'</option>' +
         '<option value="5">'+useXmltag('FourToFiveYear')+'</option>' +
         '<option value="6">'+useXmltag('FiveToSixYear')+'</option>' +
         '<option value="7">'+useXmltag('SixToSevenYear')+'</option>' +
         '<option value="8">'+useXmltag('SevenToEightYear')+'</option>' +
         '<option value="9">'+useXmltag('EightToNineYear')+'</option>' +
         '<option value="10">'+useXmltag('NineToTenYear')+'</option>' +
         '<option value="11">'+useXmltag('TenToElevenYear')+'</option>' +
         '<option value="12">'+useXmltag('ElevenToTwelveYear')+'</option>' +
         "</select>" +
         "</div>"
      i++
   }

   return HtmlCode
}

function createRoomHotelLocal(room_count, type_section) {
   console.log("room_count==>" + room_count)
   let Html_code = ""
   let i = room_count + 1

   console.log("i==>" + i)

   let number_text = useXmltag('First')
   let value_first

   if (i === 1) {
      number_text = useXmltag('First')
      value_first = "2"
      console.log("value_first1==>" + value_first)
   } else if (i === 2) {
      number_text = useXmltag('Second')
      value_first = "1"
      console.log("value_first2==>" + value_first)
   } else if (i === 3) {
      number_text = useXmltag('Third')
      value_first = "1"
      console.log("value_first3==>" + value_first)
   } else if (i === 4) {
      number_text = useXmltag('Fourth')
      value_first = "1"
      console.log("value_first4==>" + value_first)
   }

   if (i <= 4) {
      Html_code += ` <div class="myroom-hotel-item ${type_section}-my-room-hotel-item-js" data-roomnumber="${i}">
                        <div class="myroom-hotel-item-title ${type_section}-my-room-hotel-item-title-js">
                              <span class="close" onclick="itemsRoom($(this),'${type_section}')">
                                  <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"/></svg></i>
                              </span>
                            ${useXmltag("Room")}  ${number_text}
                        </div>
                        <div class="myroom-hotel-item-info ${type_section}-my-room-hotel-item-info-js">
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

                                <h6>${useXmltag("Adult")}</h6>
                                ${useXmltag('OlderThanTwelve')}
                                <div>
                                    <i class="addParent ${type_section}-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal" onclick="addNumberAdult('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/></svg></i>
                                    <input readonly="" autocomplete="off" class="countParent ${type_section}-count-parent-js"
                                           min="0" value="${value_first}"
                                           max="5" type="text" name="adult${i}" id="adult${i}"><i
                                            class="minusParent ${type_section}-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal" onclick="minusNumberAdult('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"/></svg></i>
                                </div>
                            </div>
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                <h6>${useXmltag("Child")}</h6>
                                ${useXmltag("BetweenTwoAndTwelve")}

                                <div>
                                    <i class="addChild ${type_section}-add-number-child-js hotelroom-minus plus-hotelroom-koodak" onclick="addNumberChild('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/></svg></i>
                                    <input readonly="" class="countChild ${type_section}-count-child-js" autocomplete="off"
                                           min="0" value="0" max="5"
                                           type="text" name="child${i}" id="child${i}"><i
                                            class="minusChild ${type_section}-minus-number-child-js hotelroom-minus minus-hotelroom-koodak" onclick="minusNumberChild('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"/></svg></i>
                                </div>
                            </div>
                            <div class="tarikh-tavalods ${type_section}-birth-days-js"></div>
                        </div>
                    </div>`
   }

   return Html_code
}

function viewResultInternationalHotel(data_response) {
   console.log("ss")
   $(".div-hotel-city-js").html(" ")
   $(".item-international-js").addClass("d-none")
   let element = ""
   if (data_response != "") {
      console.log("fill ss")
      element += `<ul>`
      $.each(data_response, function (index, city) {
         let item = JSON.stringify({
            city_name_fa: city.city_name_fa,
            country_name_en: city.country_name_en,
            city_name_en: city.city_name_en,
         })
         element += `<li class="textSearchFlightForeign c-sr-airport item-international-js" onclick='selectCity(${item})' >
                    <div class="div_c_sr">
                          <span class="c-text">${city.country_name_fa}-${city.city_name_fa}</span>
                          <div class="yata_gdemo"><i>${city.country_name_en}-${city.city_name_en}</i></div>
                      </div>
                </li>`
      })

      element += `</ul>`
   } else {
      console.log("empty ss")
      element = ""
      element += `<ul>
                    <li class="textSearchFlightForeign c-sr-airport">
                     No items were found for your search
                    </li>
                  </ul>  `
   }

   $(".div-hotel-city-js").html(element).removeClass("d-none")
}

// function selectCity(city) {
//    $(".text-search-hotel-js").val(city.city_name_fa + "-" + city.city_name_en)
//    $(".destination-country-js").val(city.country_name_en)
//    $(".destination-city-js").val(city.city_name_en)
//    $(".div-hotel-city-js").addClass("d-none")
//    $(".check-in-date-international-js").trigger("focus")
// }
function searchInternalHotel() {
   const form = document.getElementById('internal_hotel_form');
   const is_new_tab = form.target === '_blank';

   let type_application = $("#autoComplateSearchIN_hidden_en")

   let check_in_date = $(".check-in-date-js")
   let nights_hotel = $(".nights-hotel-js")
   const city_for_hotel_local = $("#autoComplateSearchIN_hidden").val()
   const no_select_city = $("#no_select_city").val()
   const hotel_id = $("#autoComplateSearchIN_hidden").val()
   const hotel_name_en_local = $("#autoComplateSearchIN_hidden_en").val()
   checkSearchFields(nights_hotel, check_in_date, type_application)
   nights_hotel = nights_hotel.val()
   check_in_date = check_in_date.val()
   type_application = type_application.val()
   let hotel_select_room = $(".internal-hotel-select-room-js")
   let my_room_hotel_item = hotel_select_room.find(".internal-my-room-hotel-item-js")
   let rooms = ""
   my_room_hotel_item.each(function () {
      let childAge = 0
      const adult = parseInt($(this).find(".internal-count-parent-js").val())
      const child = parseInt($(this).find(".internal-count-child-js").val())

      if (adult > 0) {
         rooms = rooms + "R:" + adult
         if (child > 0) {
            rooms = rooms + "-" + child
            let birth_days_item = $(this).find(".birth-days-item-js")
            birth_days_item.each(function (child_index) {
               childAge = 0
               childAge = $(this).find("select").val()

               if (child_index === 0 && childAge !== undefined) {
                  rooms = rooms + "-" + childAge
               } else if (childAge !== undefined) {
                  rooms = rooms + "," + childAge
               }
            })
         } else {
            rooms = rooms + "-0-0"
         }
      } else {
         rooms = "1-0-0"
      }
   })
   let url = null
   let target = is_new_tab? '_blank' : ''
   if (no_select_city==="city") {
      type_application_searchInternalHotel = "city";
   }


   if (type_application_searchInternalHotel === "api") {
      url = "detailHotel/api/" + hotel_id + "/";

        $("#internal_hotel_form").attr('action', amadeusPathByLang +url);
        $("#internal_hotel_form").attr('target', target);
        $("#internal_hotel_form").submit();
      return false;
   }
   if (type_application_searchInternalHotel === "city") {
      url = `searchHotel&type=new&city=${city_for_hotel_local}&startDate=${check_in_date}&nights=${nights_hotel}&rooms=${rooms}`
   }
   if (type_application_searchInternalHotel === "reservation") {
      url = `roomHotelLocal/reservation/${hotel_id}/${hotel_name_en_local}`
      $("<input>")
         .attr("type", "hidden")
         .attr("name", "startDate")
         .attr("value", check_in_date)
         .appendTo("#internal_hotel_form");
      $("<input>")
        .attr("type", "hidden")
        .attr("name", "nights")
        .attr("value", nights_hotel)
        .appendTo("#internal_hotel_form");

      $("#internal_hotel_form").attr('action', amadeusPathByLang +url);
      $("#internal_hotel_form").attr('target', target);
      $("#internal_hotel_form").submit();
      return false;

   }
   url = amadeusPathByLang + url
   openLink(url, is_new_tab)
}
function searchInternationalHotel() {
   const form = document.getElementById('international_hotel_form');
   const is_new_tab = form.target === '_blank';

   let check_in_date = $(".check-in-date-international-js")
   let check_out_date_js = $(".check-out-date-international-js")
   let nights_hotel = $(".nights-hotel-js")
   let destination_country = $(".destination-country-js")
   const destination_city = $(".destination-city-js").val()
   const check_out_date = $(".check-out-date-international-js").val()
   checkSearchFields(check_in_date, check_out_date_js, destination_country)
   check_in_date = check_in_date.val()
   nights_hotel = nights_hotel.val()
   destination_country = destination_country.val()
   let hotel_select_room = $(".international-hotel-select-room-js")
   let my_room_hotel_item = hotel_select_room.find(".international-my-room-hotel-item-js")
   let rooms = ""
   my_room_hotel_item.each(function () {
      let childAge = 0
      const adult = parseInt(
         $(this).find(".international-count-parent-js").val()
      )
      const child = parseInt(
         $(this).find(".international-count-child-js").val()
      )

      if (adult > 0) {
         rooms = rooms + "R:" + adult
         if (child > 0) {
            rooms = rooms + "-" + child
            let birth_days_item = $(this).find(".birth-days-item-js")
            birth_days_item.each(function (child_index) {
               childAge = 0
               childAge = $(this).find("select").val()

               if (child_index === 0 && childAge !== undefined) {
                  rooms = rooms + "-" + childAge
               } else if (childAge !== undefined) {
                  rooms = rooms + "," + childAge
               }
            })
         } else {
            rooms = rooms + "-0-0"
         }
      } else {
         rooms = "1-0-0"
      }
   })
   let url = null
   url = `resultExternalHotel/${destination_country}/${destination_city}/${check_in_date}/${check_out_date}/${nights_hotel}/${rooms}`
   url = amadeusPathByLang + url
   openLink(url,is_new_tab)
}

function searchResidence(is_new_tab = false) {
   let type_application = $("#autoComplateSearchIN_hidden_en_residence")
   let check_in_date = $(".check-in-date-residence-js")
   let check_out_date_js = $(".check-out-date-residence-js")
   let nights_hotel = $(".nights-hotel-js")
   let type_residence = $(".type_residence")
   const city_for_hotel_local = $("#autoComplateSearchIN_hiddenResidence").val()
   const hotel_id = $("#autoComplateSearchIN_hidden").val()
   const hotel_name_en_local = $("#autoComplateSearchIN_hidden_en").val()
   checkSearchFields(nights_hotel, check_in_date , check_out_date_js, type_application, type_residence)
   nights_hotel = nights_hotel.val()
   check_in_date = check_in_date.val()
   check_out_date_js = check_out_date_js.val()
   type_application = type_application.val()
   type_residence = type_residence.val()
   let hotel_select_room = $(".internal-hotel-select-room-js")
   let my_room_hotel_item = hotel_select_room.find(".internal-my-room-hotel-item-js")
   let rooms = ""
   my_room_hotel_item.each(function () {
      let childAge = 0
      const adult = parseInt($(this).find(".internal-count-parent-js").val())
      const child = parseInt($(this).find(".internal-count-child-js").val())

      if (adult > 0) {
         rooms = rooms + "R:" + adult
         if (child > 0) {
            rooms = rooms + "-" + child
            let birth_days_item = $(this).find(".birth-days-item-js")
            birth_days_item.each(function (child_index) {
               childAge = 0
               childAge = $(this).find("select").val()

               if (child_index === 0 && childAge !== undefined) {
                  rooms = rooms + "-" + childAge
               } else if (childAge !== undefined) {
                  rooms = rooms + "," + childAge
               }
            })
         } else {
            rooms = rooms + "-0-0"
         }
      } else {
         rooms = "1-0-0"
      }
   })
   let url = null

      url = `searchHotel&type=new&city=${city_for_hotel_local}&startDate=${check_in_date}&nights=${nights_hotel}&rooms=${rooms}&type_residence=${type_residence}`


   url = amadeusPathByLang + url
   openLink(url, is_new_tab)
}

(function($) {
   jQuery(document).ready(function($) {
      let response_valueInternal;
      $(document).on('change', '#countRoom', function() {
         let roomCount = $('#countRoom').val()
         console.log(roomCount)
         createRoomHotel(roomCount)
         $('.myroom-hotel').find('.myroom-hotel-item').remove()
         let code = createRoomHotel(roomCount)
         $('.myroom-hotel').append(code)
      })
      $(document).on('show.bs.modal', 'addChildren', function(e) {
         console.log('show.bs.modal fired')
         let inputToken = $(this).find('.modal-body input.room-token')
         let btnClicked = $(e.relatedTarget)
         let RoomToken = btnClicked.data('room-code')
         console.log(RoomToken)
         inputToken.val(RoomToken)
      })
      let childModal = function(RoomToken, ChildMinAge, ChildMaxAge) {
         let modalHtml = `
            <!-- Modal -->
        <div class='modal modal_addchild fade addChildren' id='addChildren-${RoomToken}' tabindex='-1' role='dialog' aria-labelledby='addChildrenTitle' aria-hidden='true'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                        <span class='modal-title'>${useXmltag('AddNew')} ${useXmltag('Chd')}</span>
                    </div>
                    <div class='modal-body'>
                        <input type='hidden' class='room-token' value=''>
                        <div class='childAgesContainer d-flex flex-wrap'>`
         modalHtml += `</div>
                        <!--<span class="btn btn-xs btn-warning d-none addNewChild" data-min="${ChildMinAge}" data-max="${ChildMaxAge}"><i class="fa fa-plus"></i>افزودن</span>-->
                        
                    </div>
        			<div class='modal-footer'>
        				<button type='button' class='btn btn-secondary' data-dismiss='modal'>${useXmltag('Closing')}</button>
        				<button type='button' class='btn btn-primary' onclick="approveChildAges('${RoomToken}')" >${useXmltag('Approve')}</button>
        			</div>
        		</div>
        	</div>
        </div>
        `
         return modalHtml
      }
      let eachRoomHtml = function(Room, value, IsInternal) {
         if ((IsInternal == true || IsInternal != false) && value.Result.SourceId != '17') {
            return eachRoomHtmlInternal(Room, value, IsInternal)
         } else {
            return eachRoomHtmlExternal(Room, value, IsInternal)
         }
      }
      let eachRoomHtmlInternal = function(Room, value, IsInternal) {
         console.log('ddddddddddddddddddddddddd')

         let roomHtml = ''
         roomHtml += `<div class='hotel-detail-room-list hotel-detail-room-list-local'>
  <div class='hotel-rooms-name-container'>
  <span class='hotel-rooms-name'><span class='name'>${Room.RoomName}</span> `
         if (Room.Rates[0].ReservationState.Status == 'Online') {
            roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-bolt site-main-text-color'></i>  ${useXmltag('Onlinereservation')}</span></span>`
         }
         if (Room.ExtraCapacity && Room.ExtraCapacity > 0 ) {
            roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-user site-main-text-color'></i>  ${translateXmlByParams('ExtraCapacity', {'number': Room.ExtraCapacity})} </span></span>`
         }else if(Room.ExtraCapacity ==  0){
            roomHtml += `<span class='online-badge'><span class='online-txt'><i class='fas fa-user site-main-text-color'></i>  ${useXmltag('NoExtraCapacity')} </span></span>`

         }

         if (Room.Rates[0].TotalPrices.Discount) {
//todo: discount should be added here
         }

         roomHtml += `</span></div><div class='hotel-rooms-item'>`


         $.each(Room.Rates, function(index, Rate) {
            console.log('ddddddddddddddddddddddd')
            roomHtml += `<div class='rate-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-local-content-col'>
                                <div class='hotel-rooms-content-local'>
                                    <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                    <input type='hidden' value='' id='tempExtraBed${Rate.RoomToken}'>

                                    <div class='divided-list divided-list-1'>
                                        <span class='small board'>${Rate.Board.Name}</span>
                                        <div class='divided-list-item'>
                                            <span  class='number_person'><i class='fa fa-male'></i>${Room.MaxCapacity} ${useXmltag('People')}</span>
                                        </div>
                                        <div class='divided-list-item detail_div_local '>
                                            <div class='DetailRoom DetailRoom_local showCancelRule' id='btnCancelRule-${Rate.RoomToken}' data-RoomCode='${Rate.RoomToken}' style='opacity: 1; cursor: pointer;'>
                                                
                                                <span>${useXmltag('Detailprice')}</span>
                                                <i class='fa fa-angle-down'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='divided-list'>
                                        <div class='divided-list-item text-center'>
                                            <span class='title_price'>
                                                ${useXmltag('Priceforanynight')} 
                                            </span>`
            // if(Rate.Prices[0].Online != Rate.Prices[0].CalculatedOnline) {
            //   roomHtml += `<span class='currency priceOff'>${number_format(Rate.Prices[0].Online)}</span>`
            // }

            roomHtml += `<span class='price_number'>  <i class='site-main-text-color'>${number_format(Rate.Prices[0].CalculatedOnline)}</i>${useXmltag('Rial')}</span>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class='hotel-rooms-price-col'>
                            
                                <div class='Hotel-roomsHead' data-title='${useXmltag('Countroom')}'>
                                    <div class='selsect-room-reserve selsect-room-reserve-local'>${useXmltag('Countroom')}</div>
                                </div>
                                
                             <div class='number_room'>
                                    <i class='plus_room' data-type_application='api' data-room_token='${Rate.RoomToken}'> + </i>
                                    <input  min='1' max='9' type='number' class='val_number_room' value='0' 
                                    name='RoomCount-${Rate.RoomToken}' 
                                    data-room-code='${Rate.RoomToken}' 
                                    data-total-price='${Rate.TotalPrices.CalculatedOnline}' id='RoomCount${Rate.RoomToken}'
                                    onchange="CalculateNewRoomPrice('${Rate.RoomToken}',true,true)"/>
                                    <i class=' minus_room ' data-type_application='api' data-room_token='${Rate.RoomToken}'> - </i>
                                </div>
                                <div class='nuumbrtRoom d-none'>
                                    <input type='hidden' value='' id='FinalRoomCount${Rate.RoomToken}'>
                                    <input type='hidden' value='' id='FinalPriceRoom${Rate.RoomToken}'>
                                    <input id='remainingCapacity${Rate.RoomToken}' name='remainingCapacity${Rate.RoomToken}' type='hidden' value='1'>
                                   
                                    </div>`

            let Rules = value.Result.Rules
            let minChildAge = 0
            let maxChildAge = 0
            $.each(Rules, function(i, Rule) {
               if (Rule.Category == 'children' && Rule.Conditions !== null && typeof Rule.Conditions.max_infant_age !== 'undefined') {
                  minChildAge = Rule.Conditions.max_infant_age
                  maxChildAge = Rule.Conditions.max_child_age
               }
            })

            let availabilityBeds
            availabilityBeds = parseInt(Room.MaxCapacity) - parseInt(Room.ExtraCapacity)
            // console.log(availabilityBeds);
            if (Room.ExtraCapacity > 0 && availabilityBeds > 0 && typeof Rate.Prices[0].ExtraBed !== 'undefined' && Rate.Prices[0].ExtraBed > 0) {
               roomHtml += `<div class='nuumbrtRoom extraBed'>
            <select name='ExtraBed-${Rate.RoomToken}' disabled data-room-code='${Rate.RoomToken}' id='ExtraBed${Rate.RoomToken}' data-price='${Rate.Prices[0].ExtraBed}' class='ExtraBed select2-num' onchange="CalculateNewRoomPrice('${Rate.RoomToken}',true)">
               <optgroup style='font-family:iransans'>
               <option>${useXmltag('Extrabed')}</option></optgroup>`
               for (c = 1; c <= availabilityBeds; c++) {
                  roomHtml += `<option value='${c}'>${c} ${useXmltag('Extrabed')}</option>`
               }

               roomHtml += `
        </select>
        </div>
            `
            }
            if (Room.ExtraChild > 0 && Rate.TotalPrices.Child > 0) {
               roomHtml += `<button type='button' disabled='disabled' role='button' class='btn addChildren btnAddChildren-${Rate.RoomToken}' data-min-age='${minChildAge}' data-max-age='${maxChildAge}' data-room-code='${Rate.RoomToken}' data-toggle='modal' data-target='#addChildren-${Rate.RoomToken}' data-child-price='${Rate.TotalPrices.Child}'><span>${useXmltag('AddNew')} ${useXmltag('Chd')}</span><i class='fa fa-plus-square pr-1'></i></button>`
               roomHtml += childModal(Rate.RoomToken, minChildAge, maxChildAge)
               roomHtml += `<input type='hidden' data-room-code='${Rate.RoomToken}' name='roomChildArr[${Rate.RoomToken}]' id='roomChildArr-${Rate.RoomToken}' value=''>`
               roomHtml += `<input type='hidden' data-room-code='${Rate.RoomToken}' name='roomChildCount[${Rate.RoomToken}]' id='roomChildCount-${Rate.RoomToken}' value=''>`
               roomHtml += `<input type='hidden' id='roomChildPrice-${Rate.RoomToken}' value='${Rate.TotalPrices.Child}'>`

            }
            roomHtml += `</div>
                        </div>
                        <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel-${Rate.RoomToken}'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule-${Rate.RoomToken}'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>
                        `
            roomHtml += `<input type='hidden' value='${Rate.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${Rate.TotalPrices.CalculatedOnline}' data-amount='${Rate.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${Rate.RoomToken}' class='priceRoom${Rate.RoomToken}'>
<input type='hidden' value='${value.NightsCount}' id='stayingTime${Rate.RoomToken}' class='stayingTime'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                       
                        <div class='detail_room_hotel'>
`

            if (Rate.Prices.length > 0) {
               $.each((Rate.Prices), function(index, Price) {
                  roomHtml += `
                        <div class='details'>
                            <div class='AvailableSeprate site-bg-main-color site-bg-color-border-right-b '>${Price.Date}</div>
                            <div class='seprate'>
                                <span><b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')} <i class='fa fa-male checkIcon'></i><span class='tooltip-price'>${useXmltag('Adult')}</span></span>`
                  if (Price.ExtraBed > 0 && Room.ExtraCapacity > 0 && availabilityBeds > 0) {
                     roomHtml += `<span><b>${number_format(Price.ExtraBed)}</b>${useXmltag('Rial')} <i data-availabilityBeds='${availabilityBeds}' class='fa fa-bed checkIcon'></i><span class='tooltip-price'>${useXmltag('Extrabed')}</span></span>`
                  }
                  if (Price.Child) {
                     roomHtml += `<span><b>${number_format(Price.Child)}</b>${useXmltag('Rial')} <i class='fas fa-baby-carriage'></i><span class='tooltip-price'>${useXmltag('Child')}</span></span>`
                  }
                  roomHtml += `</div>   
                    </div>`
               })
            }
            roomHtml += `
                    </div></div>`
         })
         roomHtml += `</div></div>`
         return roomHtml
      }
      let eachRoomHtmlExternal = function(Room, value, IsInternal) {
         console.log('ddddddddddddddddddddddddd')
         let roomHtml = `<div class='hotel-detail-room-list'>
                        <div class='hotel-rooms-name-container'>
                            <span class='hotel-rooms-name'>${Room.RoomName}</span>
                        </div><!--.hotel-rooms-name-container-->
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row'>
                            <div class='hotel-rooms-external-content-col'>
                                <div class='hotel-rooms-content'>
                                    <div class='roomRatesContainer'>
`
         console.log(Room.Rates);
         $.each(Room.Rates, function(RateIndex, Rate) {
            console.log('fffffffffffffffff')
            roomHtml += `
                                <div class='roomRateItem'>
                                    <div class='divided-list divided-list-external'>
                                        <div class='divided-list-item'>
                                            <span><i class='fa fa-bed'></i>${Rate.Board.Name}</span>
                                        </div><!--.divided-list-item-->
                                        
                                        <div class='divided-list-item'>`
            if (Rate.ReservationState.Status == 'NonRefundable' || Rate.ReservationState.Status == 'IncludesFines') {
               roomHtml += `<span class='extradition online-badge'>
                                                <span class='online-txt' style='white-space: nowrap;'>
                                                ${useXmltag(Rate.ReservationState.Status)}</span>
                                            </span>`
            }

            roomHtml += `<div data-token='${Rate.RoomToken}' data-request_number='${value.RequestNumber}' class='DetailRoom DetailRoom_external showCancelRule isHide' id='btnCancelRule-${Rate.RoomToken}' data-RoomCode='${Rate.RoomToken}' style='opacity: 1; cursor: pointer;'>
                                                <span>${useXmltag('detailAndCacellation')}</span>
                                                <i class='fa fa-angle-down'></i>
                                            </div><!--DetailRoom-->
                                        </div><!--divided-list-item-->
                                     
                                    </div><!--divided-list-->
                                    <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                        <div class="divided-list">
                                        <div class="divided-list-item text-center">
                                            <span class="title_price">
                                                 ${translateXmlByParams('PriceTotalHotel', {'TotalNights': value.Result.NightsCount})}
                                            </span> `
            if(Rate.CalculatedDiscount.off_percent > 0 ){
               roomHtml += ` <span class='currency priceOff'>  <i class="price_number"> ${number_format(Rate.TotalPrices.afterChange)}</i>${useXmltag('Rial')} </span>`
            }

            roomHtml += `  <span class='price_number site-main-text-color'>
                                                <i> ${number_format(Rate.TotalPrices.CalculatedOnline)}</i>${useXmltag('Rial')}
                                           </span>
                                        </div><!--divided-list-->
                                    </div><!--divided-list divided-list-external-->
                                    <div class='divided-list divided-list-reserve border-0'>
                                        <input type='hidden' value='' id='FinalRoomCount${Rate.RoomToken}'>
                                        <input type='hidden' value='' id='FinalPriceRoom${Rate.RoomToken}'>
                                        <input type='hidden' value='' id='tempInput${Rate.RoomToken}'>
                                        <input type='hidden' value='1' name='RoomCount-${Rate.RoomToken}' id='RoomCount${Rate.RoomToken}'>
                                        <span class='label_reserve_input site-bg-main-color' id='reserve_input${Rate.RoomToken}' onClick="ReserveExternalApiHotel('${Rate.RoomToken}')">
                                            <span>${useXmltag('Reserve')}</span>
                                        </span>
                                    </div><!--divided-list-->
                                    <div class='detail_room_hotel'>
                                        <h4 class='reservation-state-title'>${useXmltag(Rate.ReservationState.Status)}</h4>
                                        <div class='refund-fees'></div>`

            roomHtml += `</div><!--detail_room_hotel-->
                        </div><!--roomRateItem-->
                        <div class='hotel-rooms-rule-row'>
                            <div class='col-xs-12 col-md-12 box-cancel-rule'>
                                <img class='imgLoad' src='${amadeusPath}view/client/assets/images/load2.gif' id='loaderCancel'>
                                <div class='box-cancel-rule-col displayN' id='boxCancelRule'>
                                    <div class='filtertip-searchbox'>
                                        <div class='filter-content'>
                                            <div class='RoomDescription'>
                                                <div class='DetailPriceView'>`
            if (Rate.Prices.length > 0) {
               $.each((Rate.Prices), function(index, Price) {
                  roomHtml += `<div class='details'>
                                        <div class='AvailableSeprate'>${Price.Date}</div>
                                            <div class='seprate'>
                                                <b>${number_format(Price.CalculatedOnline)}</b>${useXmltag('Rial')}<i class='fa fa-check checkIcon'></i>
                                            </div>
                                        </div>`
               })
            }
            roomHtml += `<input type='hidden' value='${Rate.RoomToken}' id='idRoom' class='idRoom'>
<input type='hidden' value='${Rate.TotalPrices.CalculatedOnline}' data-amount='${Rate.TotalPrices.CalculatedOnline}' data-unit='${useXmltag('Rial')}' id='priceRoom${Rate.RoomToken}' class='priceRoom${Rate.RoomToken}'>
<input type='hidden' value='${value.Result.NightsCount}' id='stayingTime${Rate.RoomToken}' class='stayingTime'>
                                                </div><!--DetailPriceView-->
                                            </div><!--RoomDescription-->
                                        </div><!--filter-content-->
                                    </div><!--filtertip-searchbox-->
                                </div><!--#boxCancelRule-->
                            </div><!--box-cancel-rule-->
                        </div><!--hotel-rooms-rule-row-->
                        `
         })

         roomHtml += `</div><!--roomRatesContainer-->
                        </div><!--hotel-rooms-content-->
                    </div><!--hotel-rooms-external-content-col-->
                </div><!--hotel-rooms-row-->
            </div><!--hotel-rooms-item-->
        </div><!--hotel-detail-room-list-->`
         return roomHtml

      }
      let generateRoomSelectForm = function(result, hotelValue, RequestNumber) {
         let modal = ''
         let eachRoom = ''
         let RoomIds = []
         $.each(result, function(roomIndex, Room) {
            $.each(Room.Rates, function(rateIndex, Rate) {
               RoomIds.push(Rate.RoomToken)
            })
            eachRoom += eachRoomHtml(Room, hotelValue, hotelValue.Result.IsInternal)
         })
         allRoomIds = RoomIds.join('/')

         let firstRoom = result[0]


         let html = `<form target='_self' action='' method='post' id='formHotelReserve' style='width: 100%;'>
        <input id='idHotel_reserve' name='idHotel_reserve' type='hidden' value='${hotelValue.Result.HotelIndex}'>
        <input id='nights_reserve' name='nights_reserve' type='hidden' value='${firstRoom.Rates[0].Prices.length}'>
        <input id='startDate_reserve' name='startDate_reserve' type='hidden' value='${hotelValue.History.StartDate}'>
        <input id='endDate_reserve' name='endDate_reserve' type='hidden' value='${hotelValue.History.EndDate}'>
        <input id='IdCity_Reserve' name='IdCity_Reserve' type='hidden' value='${hotelValue.Result.CityId}'>
        <input id='factorNumber' name='factorNumber' type='hidden' value=''>
        <input id='CurrencyCode' name='CurrencyCode' type='hidden' value=''>
        <input id='IsInternal' name='IsInternal' type='hidden' value='${hotelValue.Result.IsInternal}'>
        <input id='source_id' name='source_id' type='hidden' value='${hotelValue.Result.SourceId}'>
        <input type='hidden' value='${JSON.stringify(hotelValue.History.Rooms)}' name='searchRooms' id='searchRooms'>
        <input id='requestNumber' name='requestNumber' type='hidden' value='${RequestNumber}'>
        <input id='href' name='href' type='hidden' value='newPassengersDetail'>
`

         html += eachRoom

         let Rules = hotelValue.Result.Rules
         let minChildAge = maxChildAge = 0
         $.each(Rules, function(i, Rule) {
            if (Rule.Category == 'children' && Rule.Conditions !== null && typeof Rule.Conditions.max_infant_age !== 'undefined') {
               minChildAge = Rule.Conditions.max_infant_age
               maxChildAge = Rule.Conditions.max_child_age
            }
         })
         html += `<input type='hidden' name='CountRoom' id='CountRoom' value=''>
        <input type='hidden' name='TypeRoomHotel' id='TypeRoomHotel' value='${allRoomIds}'>
        <input type='hidden' name='allRoomIds' id='allRoomIds' value='${allRoomIds}'>
        <input type='hidden' name='TotalNumberRoom' id='TotalNumberRoom' value=''>
        <input type='hidden' id='TotalNumberRoom_Reserve' name='TotalNumberRoom_Reserve' value=''>
        <input type='hidden' id='TotalNumberExtraBed_Reserve' name='TotalNumberExtraBed_Reserve' value=''>
       `

         html += `
</form>`
         $('.RoomsContainer').append(html)
      }
      let ajaxGetPrices = function(RequestNumber, value) {
         console.log('isInternal==>'+value.History.IsInternal)

         return $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data: {
               requestNumber: RequestNumber,
               stars: value.Result.Stars,
               hotelIndex: value.Result.HotelIndex,
               sourceId: value.Result.SourceId,
               startDate: value.History.StartDate,
               cityName: value.History.City,
               countryName: value.History.Country,
               typeApplication: (value.History.IsInternal == '0' || (value.History.IsInternal == '1' && (value.Result.SourceId == '17' || value.Result.SourceId == '29'))) ? 'externalApi' : 'api',
               check_type_for_price_changes :  (value.History.IsInternal == '1') ? true : false ,
               flag: 'getPrices',
            },
            beforeSend: function() {

            },
            success: function(response) {

               $('#ThisPricesResult').val(JSON.stringify(response))

               if (response.Result.length > 0) {

                  generateRoomSelectForm(response.Result, value, RequestNumber)
               } else {
                  let msg = useXmltag('NoRoomsAvailable')
                  $.alert({
                     title: useXmltag('NoAvailableReserve'),
                     content: msg,
                     rtl: true,
                     type: 'red',
                  })
               }
            },
            error: function(error) {
               let msg = useXmltag('NoAvailableReserve')
               $.alert({
                  title: useXmltag('Error'),
                  content: msg,
                  rtl: true,
                  type: 'red',
               })
               $('.RoomsContainer').append(`<div class='hotel-detail-room-list'>
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row justify-content-center'><p class='mt-3 alert alert-danger'>${msg}</p></div></div></div>`)
               console.log(error)
            },
            complete: function() {
               $('#resultRoomHotel').hide()
            },
         })
      }
      let ajaxGetCancellationPolicy = function(cancelRoleBtn) {
         let RequestNumber = cancelRoleBtn.data('request_number')
         let RoomToken = cancelRoleBtn.data('token')
         let thisdetailBox = cancelRoleBtn.parents('.roomRateItem').find('.detail_room_hotel')
         thisdetailBox.addClass('active_detail')
         return $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data: {
               flag: 'getCancellationPolicy',
               RequestNumber: RequestNumber,
               RoomToken: RoomToken,
            },
            beforeSend: function() {

            },
            success: function(response) {
               result = response.Result

               if (result.Fees.length > 0) {
                  boxHtml = `<ul>`
                  $.each(result.Fees, function(index, Fee) {
                     boxHtml += `<li>${useXmltag('From')}<span style='direction: ltr; display:inline-block'>${Fee.FromDate}</span> ${useXmltag('To')} <span style='direction: ltr; display:inline-block'>${Fee.ToDate}</span> ${useXmltag('CancelationAmount')} <span style='direction: ltr; display:inline-black'>${Fee.Amount}</span></li>`
                  })
                  boxHtml += `<ul>`

                  thisdetailBox.find('.refund-fees').html(boxHtml)
               }

               if (result.Status.length > 0 && result.Status.Refundable) {
                  thisdetailBox.find('h4.reservation-state-title').text(useXmltag('Refundable'))
               } else {
                  thisdetailBox.find('h4.reservation-state-title').text(useXmltag('NonRefundable'))
               }
               console.log('success')
            },
            error: function(error) {
               console.log('error')
            },
         })
      }
      let generateMap = function(latitude, longitude, mapDiv = 'mapDiv') {
         map = L.map(mapDiv).setView([latitude, longitude], 16)
         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.iran-tech.com/">Iran Technology</a> contributors',
            // maxZoom: 18,
            // minZoom: 11,
         }).addTo(map)
         marker = L.marker([latitude, longitude]).addTo(map)
      }
      let generateHtmlForSearchHotel = function(data, parseJson) {

         let value = data.Result,
           searched_details = data.History,
           IsInternal = data.Result.IsInternal
         let addressTxt = value.ContactInformation.Address
         let hotelName = value.Name
         let Latitude = value.ContactInformation.Location.Latitude
         let Longitude = value.ContactInformation.Location.longitude
         let stars = value.Stars
         let description = value.ExtraData ? value.ExtraData.Description : ''


         if (parseJson.lang != 'fa') {
            hotelName = value.Name
            if (typeof value.NameEn !== 'undefined' && value.NameEn != '') {
               hotelName = value.NameEn
            }

            if (typeof value.ContactInformation.AddressEn !== 'undefined' && value.ContactInformation.AddressEn !== '') {
               addressTxt = value.ContactInformation.AddressEn
            }
         }
         let starsHtml = ''
         for (let star = 0; star < 5; star++) {
            let starOn = `<i class='fa fa-star' aria-hidden='true'></i>`
            let starOff = ``
            if (star < value.Stars) {
               starsHtml += starOn
            } else if (star >= value.Stars) {
               starsHtml += starOff
            }
         }

         let starText = ''
         if(value.Stars > 0 ) {
            starText = translateXmlByParams('starText', {'count': value.Stars})
         }



         let galleryHtml = ''

         $.each(value.Pictures, function(index, picture) {
            galleryHtml += `<div class='hotel-thumb-item'><a data-fancybox='gallery' href='${picture.full}'><img src='${picture.medium}' alt='${hotelName}'></a></div>`
         })
         $('#idCity').val(value.CityId)
         $('#nights').val(value.NightsCount)
         $('#startDate,#startDateForeign').val(searched_details.StartDate)
         $('#endDate,#endDateForeign').val(searched_details.EndDate)
         $('#stayingTime').val(value.NightsCount)
         // console.log('rooms count '  + searched_details.Rooms.length);
         // $('#countRoom').attr('data-rooms',JSON.stringify(searched_details.Rooms)).val(searched_details.Rooms.length).select2().trigger('change');

         $('span.stayingTime').text(`${value.NightsCount} ${useXmltag('Night')}`)
         let class_hotel_name = (IsInternal == '1')?'internal-hotel-name': 'external-hotel-name';
         let class_detail_hotel = (IsInternal == '1') ? 'internal-hotel-detail' : 'external-hotel-detail';
         let hotel_transfer = ''
         if(value.ExtraData && value.ExtraData.transfer != undefined) {
            hotel_transfer = ` <div class='hotel-rate-outer'>
                    <div class="hotel-transfer">
                      <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="fa-primary" d="M39.61 196.8L74.8 96.29C88.27 57.78 124.6 32 165.4 32H346.6C387.4 32 423.7 57.78 437.2 96.29L472.4 196.8C495.6 206.4 512 229.3 512 256V400H0V256C0 229.3 16.36 206.4 39.61 196.8V196.8zM109.1 192H402.9L376.8 117.4C372.3 104.6 360.2 96 346.6 96H165.4C151.8 96 139.7 104.6 135.2 117.4L109.1 192zM96 256C78.33 256 64 270.3 64 288C64 305.7 78.33 320 96 320C113.7 320 128 305.7 128 288C128 270.3 113.7 256 96 256zM416 320C433.7 320 448 305.7 448 288C448 270.3 433.7 256 416 256C398.3 256 384 270.3 384 288C384 305.7 398.3 320 416 320z"/><path class="fa-secondary" d="M346.6 96C360.2 96 372.3 104.6 376.8 117.4L402.9 192H109.1L135.2 117.4C139.7 104.6 151.8 96 165.4 96H346.6zM0 400H96V448C96 465.7 81.67 480 64 480H32C14.33 480 0 465.7 0 448V400zM512 448C512 465.7 497.7 480 480 480H448C430.3 480 416 465.7 416 448V400H512V448z"/></svg></i>
                      <div>
                        <h2>${useXmltag('HotelTransfer')}</h2>`
            if(value.ExtraData.transfer.price == 0 ) {
               hotel_transfer +=`<span>(${useXmltag('Free')})</span>`
            }
            hotel_transfer +=` </div>
                    </div>
                </div>`
         }

         let rules = ''
         if(value.Rules.length> 0 ) {
            for (let i = 0; i < value.Rules.length; i++) {
               console.log(value.Rules[i])
               rules += `<div>
                    <h6 class='rulesHotel__title text-right'>${value.Rules[i]['Name']}</h6>
                    <div class='rulesHotel__answer'>${value.Rules[i]['Description']}</div>
                  </div>`
            }
         }


         let hotelDetailContainer = `
            <div class='${class_hotel_name} p-3'>
                <div class='hotel-name hotel-name_detail'>
                    <h1>${hotelName}</h1>
                       <div class='hotel-rate'>
                        <div class='rp-cel-hotel-star hotel-stars'> <span class="rp-cel-hotel-star_span"> ${starText} </span> ${starsHtml}</div>
                       </div>
                    <div class='external-hotel-address text-left hotel-address hotel-result-item-content-location'>
                       <span class='address-text'> : ${useXmltag('Address')}</span>
                       <span class='address-text'>${addressTxt}</span>
                    </div>
                </div>
               ${hotel_transfer}
            </div>`
         if(galleryHtml != '') {
            hotelDetailContainer += `<div class='hotel-khareji-thumb '>
                    <div class='hotel-thumb-carousel owl-carousel'>${galleryHtml}</div>
                </div>`
         }

         hotelDetailContainer +=`<div class=' RoomsContainer'>
            <div class='row'>
            
            </div>
            </div>
            
            <div class='hotel-panel ${parseJson.lang == 'fa' ? 'txtRight' : 'txtLeft'}'>
                <div class='hotel-desc'>`
         if(description){
            hotelDetailContainer += `
                  <div class="tabHotel">
                    <div class="tabHotel__buttons">
                      <button onclick="tabHotel('tabHotel__box1',event.target)" class="tabHotel__btns tabHotel__btns--active">${useXmltag('Descriptionhotel')}</button>
                      <button onclick="tabHotel('tabHotel__box2',event.target)" class="tabHotel__btns">${useXmltag('OsafarTermsandConditions')}</button>
                    </div>
                    <div>
                      <div id="tabHotel__box1" class="tabHotel__box"><p>${description}</p></div>
                      
                      <div id="tabHotel__box2" class="tabHotel__box" style="display:none">
                        <div class="rulesHotel">
                          ${rules}
                        </div>  
                      </div>
                    </div>
                  </div>
                  `
         }
         hotelDetailContainer += `<div class='hotel-fea'>
                        <div class='hotel-fea-title'>${useXmltag('PossibilitiesHotel')}
                        </div>
                        <div class='hotel-fea-inner'>

`

         let roomIcons = hotelIcons = ''
         if (typeof value.Facilities.HotelWithIcons != 'undefined') {
            if (value.Facilities.HotelWithIcons.length > 0) {
               $.each(value.Facilities.HotelWithIcons, function(index, value) {
                  hotelIcons += `<div title='${value[0]}' class='hotel-fea-item-2'><i class='site-bg-main-color ${value[1]}'></i>${value[0]}</div>`
               })
               hotelDetailContainer += hotelIcons
            }
         } else if (typeof value.Facilities.Hotel.En.Base != 'undefined') {
            if (lang == 'fa') {
               if (value.Facilities.Hotel.Fa.Base.length > 0) {
                  $.each(value.Facilities.Hotel.Fa.Base, function(index, value) {
                     hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
                  })
                  hotelDetailContainer += hotelIcons
               }
            } else if (value.Facilities.Hotel.En.Base.length > 0) {
               $.each(value.Facilities.Hotel.En.Base, function(index, value) {
                  hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
               })
               hotelDetailContainer += hotelIcons
            }
         } else {
            console.log('no content for facilities')
            hotelDetailContainer += ``
         }
         hotelDetailContainer += `
  
        </div>
        <div class='hotel-fea-inner'>`
         if (lang == 'fa') {
            if (value.Facilities.Room.Fa.Base.length > 0) {
               roomIcons += `<div class='hotel-fea-title'>${useXmltag('PossibilitiesRoom')}</div>`
            }
         }else {
            if (value.Facilities.Room.En.Base.length > 0) {
               roomIcons += `<div class='hotel-fea-title'>${useXmltag('PossibilitiesRoom')}</div>`
            }
         }
         roomIcons += `<div class='hotel-fea-inner'>`
         if (typeof value.Facilities.RoomWithIcons != 'undefined') {
            if (value.Facilities.RoomWithIcons.length > 0) {
               $.each(value.Facilities.RoomWithIcons, function(index, value) {
                  roomIcons += `<div title='${value[0]}' class='hotel-fea-item-2'><i class='site-bg-main-color ${value[1]}'></i>${value[0]}</div>`
               })


               hotelDetailContainer += roomIcons
            }
         } else if (typeof value.Facilities.Room.En.Base != 'undefined') {
            if (value.Facilities.Room.En.Base.length > 0) {
               $.each(value.Facilities.Room.En.Base, function(index, value) {
                  hotelIcons += `<div title='${value}' class='hotel-fea-item-2'>${value}</div>`
               })
               hotelDetailContainer += hotelIcons
            }
         }
         hotelDetailContainer += `</div>
                    </div>
                    <div class='hotel-fea-inner'>
                        <div class='rp-hotel-box'>
                            <div id='mapDiv' class='gmap3'></div>
                        </div>
                    </div><!-- End Map Section   -->
                </div>
            </div>
</div>`
         $('#hotelDetailContainer .content-detailHotel').addClass(class_detail_hotel).html('').append(hotelDetailContainer)

         loadArticles('Hotel')
      }
      let generateCarousel = function(selector) {
         $(selector).owlCarousel({
            items: 2,
            rtl: true,
            loop: true,
            center: true,
            margin: 5,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4500,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            responsive: {
               0: {
                  items: 1,
               },
               575: {
                  items: 2,

               },
            },
         })
      }
      let priceRangeSlider = function(minPrice, maxPrice) {
         $('#slider-range').slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            step: 500000,
            animate: false,
            values: [minPrice, maxPrice],
            slide: function(event, ui) {
               let minRange = ui.values[0]
               let maxRange = ui.values[1]
               $('.filter-price-text span:nth-child(2) i').html(number_format(minRange))
               $('.filter-price-text span:nth-child(1) i').html(number_format(maxRange))
               let hotels = $('.hotel-result-item')
               hotels.hide().filter(function() {
                  let price = parseInt($(this).data('price'), 10)
                  return price >= minRange && price <= maxRange
               }).show()

            },
         })

         $('.filter-price-text span:nth-child(2) i').html(number_format(minPrice))
         $('.filter-price-text span:nth-child(1) i').html(number_format(maxPrice))
      }
      $('body').delegate('#searchDate', 'click', function() {
         let page = $('#page').val()
         let href = amadeusPathByLang + page
         $('#formHotel').attr('action', href).submit()
      })
      $(document).on('click', '.reserve-hotel', function(e) {
         // $('#formHotel').attr('action',`${amadeusPathByLang}newPassengersDetail`);
         ReserveHotel()
      })
      $(document).on('click', '.DetailRoom_external.showCancelRule', function(e) {
         e.preventDefault()
         let _this = $(this)
         _this.find('i').toggleClass('rotate')
         if (_this.hasClass('isHide')) {
            _this.parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail')
            _this.toggleClass('isHide isShow')
            ajaxGetCancellationPolicy(_this)
         } else {
            _this.parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail')
            _this.toggleClass('isHide isShow')

         }
      })
      $('.datePersian').datepicker({
         numberOfMonths: 1,
         minDate: new Date(),
         dateFormat: 'yy-mm-dd',
         gotoCurrent: true,
         showButtonPanel: true,
      })
      if (gdsSwitch == 'searchHotel') {

         let data = $('#dataSearchHotel').val()


         let parsJson = JSON.parse(data)
         // let parsJson = data;
         // let value = [];
         parsJson.className = 'searchHotel'
         parsJson.method = 'searchHotel'
         $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            // url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data: JSON.stringify(parsJson),
            beforeSend: function() {
               $('.loaderPublicForHotel').show()
               $('.silence_span').html(useXmltag('Loading'));
            },
            success: function(data) {
               let value = data.Hotels
               let advertises = data.Advertises
               $('#webServiceType').val(data.WebServiceType)
               $('.silence_span').html(`<b id='countHotelHtml'>${data.Count}</b> ${useXmltag('NumberHotelsFound')}`)
               $('#hotelResultItem').remove()
               if (data.Count > 0) {
                  $.each(value, function(index, item) {
                     let hotelIndex = null
                     if (item.type_application == 'reservation') {
                        hotelIndex = item.hotel_id
                     } else {
                        hotelIndex = item.HotelIndex
                     }
                     let facilitiesContent = ''
                     if (item.type_application == 'reservation') {
                        let html_li = ''
                        if (typeof item.facilities != 'undefined') {
                           let html_li = '<div class="internal-hotel-facilities">'
                           $.each(item.facilities, function(j, facility) {

                              if (j < 10) {
                                 html_li += `<span>${facility.title}</span>`
                              }

                           })
                           html_li += `</div>`

                           facilitiesContent = html_li
                        }

                     } else {
                        let html_li = ''
                        if (typeof item.facilities != 'undefined') {
                           let html_li = '<div class="internal-hotel-facilities">'
                           if (item.facilities.length > 1) {
                              $.each(item.facilities, function(j, facility) {

                                 if (j < 10) {
                                    html_li += `<span>${facility.title}</span>`
                                 }

                              })

                           }


                           html_li += `</div>`
                           facilitiesContent = html_li
                        }
                     }
                     let starHtml = ''
                     if(item.star_code > 0) {
                        starHtml += `<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M11.892 3.005c-.429.041-.8.325-.95.735l-1.73 5.182-5.087-.001a1.122 1.122 0 0 0-.675 2.021l4.077 3.078-1.834 5.504c-.153.465.011.974.407 1.261l.093.061c.383.224.868.203 1.232-.062l4.577-3.442 4.59 3.408c.4.292.936.292 1.331.005l.087-.07a1.12 1.12 0 0 0 .32-1.189l-1.856-5.477 4.078-3.079a1.12 1.12 0 0 0 .39-1.251 1.125 1.125 0 0 0-1.067-.768h-5.087l-1.724-5.163A1.131 1.131 0 0 0 12 3l-.108.005Z"></path></svg>`;
                     }
                     let starText = ''
                     if(item.star_code > 0 ) {
                        starText = translateXmlByParams('starText', {'count': item.star_code})
                     }

                     let hotelStricke = 0
                     let hotelPrice = 0
                     if (item.type_application != 'reservation' && item.discount_price > 0) {
                        hotelStricke = item.min_room_price_without_discount
                        hotelPrice = item.min_room_price
                     } else {
                        if (item.min_room_price > 0) {
                           hotelPrice = item.min_room_price
                        } else {
                           hotelPrice = 0
                        }
                     }
                     var buttonName = ''
                     var style = ''
                     if (hotelPrice > 0) {
                        buttonName = useXmltag('ShowReservation')
                        style = ''
                     } else {
                        buttonName = useXmltag('Inquire')
                        if (item.type_application == 'reservation') {
                           buttonName = useXmltag('NonBookable')
                        }
                        style = 'style="background-color: #7d7d7d !important"'
                     }
                     let onClickAttr = ''
                     let single_detail_link = ''
                     let searched_rooms = $('#searchRooms').val()
                     let nights = $('#stayingTime').val()
                     let rooms_query_param = null
                     if (searched_rooms)
                        rooms_query_param = `&searchRooms=${searched_rooms}`
                     else
                        rooms_query_param = ''
                     if (item.type_application == 'api') {
                        // if(hotelPrice > 0 || hotelPrice = 0)
                        // {
                        onClickAttr = `hotelDetail('api','${hotelIndex}','${item.hotel_name_en}','${item.requestNumber}','${item.SourceId}',$(this))`
                        single_detail_link = `${amadeusPathByLang}detailHotel/api/${item.HotelIndex}/${item.requestNumber}${rooms_query_param}`
                        // }else{
                        //     onClickAttr = `return false`;
                        // }

                        // $(itemAppend).find('.bookbtn').attr('onclick', onClickAttr);
                     }
                     if (item.type_application == 'reservation') {
                        if (hotelPrice > 0) {
                           single_detail_link = `${amadeusPathByLang}roomHotelLocal/reservation/${hotelIndex}/${item.hotel_name_en}${rooms_query_param}`
                           onClickAttr = `hotelDetail('reservation', '${hotelIndex}', '${item.hotel_name_en}','','',$(this))`

                        } else {
                           single_detail_link = '#'
                           onClickAttr = `return false`
                        }

                     }
                     var specialHotelRabon = ''
                     if (item.is_special == 'yes') {
                        specialHotelRabon = `
                    <div class='ribbon-special-hotel'>${useXmltag( 'Specialhotel' )}</div>
                    `
                     }
                     var specialHotelRabonDiscount = `     
                    <div class='ribbon-hotel site-bg-color-dock-border-top'><span><i> %${item.discount}   </i></span></div>
                 `
                     var apiHotelDiscountRabon = `
                     <div class='ribbon-hotel site-bg-color-dock-border-top'><span>${item.discount}%</span></div>`
                     var rabonfinal = ''
                     if (item.type_application == 'reservation') {
                        if (item.discount > 0) {
                           rabonfinal = rabonfinal + specialHotelRabonDiscount
                        }
                     } else {
                        if (item.discount > 0) {
                           rabonfinal = apiHotelDiscountRabon
                        }
                     }
                     let mainItem =
                       `<div class='hotelResultItem count count-${index}'> <div id='api${index}' class='hotel-result-item'
                     data-typeApplication='${item.type_application}' 
                     data-discount='${item.discount}'
                     data-priority='' 
                     data-price='${item.min_room_price}' 
                     data-star='${item.star_code}' 
                     data-HotelType='${item.type_code}' 
                     data-HotelName='${item.hotel_name}'
                     data-special='${item.is_special}'
                     >
                        <code style='display:none'>${JSON.stringify(item)}</code>
                    <div>
                        <div class='hotel-result-item-image site-bg-main-color-hover hotelImageResult hotelImageResult-${index}'>
                            <a target='_blank' href='${single_detail_link}'>
                                <img title='${item.hotel_name}' id='imageHotel-${index}' src='${item.pic}'>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class='hotel-result-item-content'>
                            <div class='hotel-result-item-text'>
                                    ${specialHotelRabon}
                                <div class='d-flex align-items-center gap-10'>
                                    <a target='_blank' href='${single_detail_link}' class='hotel-result-item-name hotelNameResult hotelNameResult-${index}'>${item.hotel_name}</a>
                                    <kbd class='kbd_style'>S${item.SourceId}</kbd>
                                </div>
                                <span class='rp-cel-hotel-star hotelShowStar-${index}'>
                                  <span class='rp-cel-hotel-star_span'> ${starText} </span> 
                                     ${starHtml}
                                </span>
`
                     // var pointClub = ''
                     // if (item.pointClub > 0) {
                     //   pointClub = `<div class='text_div_more_hotel  '>
                     //           <i class='flat_cup'></i>
                     //               ${useXmltag('Yourpurchasepoints')} : <i class='site-main-text-color mr-1'> ${item.pointClub} ${useXmltag('Point')} </i>
                     //
                     //               </div>`
                     //
                     // }
                     // mainItem += `
                     //               ${pointClub}
                     //               `
                     if (item.address) {
                        mainItem += `
                                <span class='hotel-result-item-content-location hotelAddress hotelAddress-${index}'>
                                                        <span> ${useXmltag('Address')} : </span>

                                <span> ${item.address} </span>
                             <!-- <span class="text-white">${item.type}</span> -->
                                </span>`
                     }
                     // if (item.cancel_conditions) {
                     //   mainItem += `<p class='hotel-result-item-description height95 hotelRules hotelRules-${index}'>${item.cancel_conditions}</p>`
                     // }

                     var mainPrice = ''

                     if(nights > 1 ) {
                        mainPrice = ` <h2 class='CurrencyCal' data-amount='${item.price_currency_total_night}'>${number_format(parseInt(item.price_currency_total_night))}</h2>`
                     }else if(nights == 1 ) {
                        mainPrice =  ` <h2 class='CurrencyCal' data-amount='${item.price_currency.AmountCurrency}'>${number_format(parseInt(item.price_currency.AmountCurrency))}</h2>`
                     }


                     if (facilitiesContent) {
                        mainItem += `<ul class='hotelpreferences facilities facilities-${index}'>${facilitiesContent}</ul>`
                     }
                     mainItem += `</div>
                            <div class='hotel-result-item-bottom'>
                                <input type='hidden' id='starSortDep' name='starSortDep' value='${item.star_code}' class='hotelStar hotelStar-${index}'>
                                <input id='idHotel' name='idHotel' type='hidden' value='${hotelIndex}'  class='hotelId-${index}'>`
                     if (item.price_currency.AmountCurrency > 0) {
                        mainItem += `<div class='price-box-hotel'>`
                        mainItem += `
                                <span class='nightText'> ${useXmltag('Price')} ${nights}   ${useXmltag('Night')}    </span> 
                                ${hotelStricke > 0 ? `
                                      <div class="d-flex style_Discount">
                                      <span class="currency priceOff CurrencyCal" 
                                      data-amount="${hotelStricke}">
                                      ${number_format(parseInt(hotelStricke))}
                                      </span> ${rabonfinal}
                                      </div>` : ''}
                                <div class="price_main">
                                 <span class='CurrencyText'>${item.price_currency.TypeCurrency}</span>
                                  ${mainPrice}
                                </div>
`
                     }
                     var mainButton = ''
                     if (item.type_application == 'reservation') {
                        mainButton = `<a class='bookbtn mt1 site-bg-main-color' ${style} onclick="${onClickAttr}"> ${buttonName}</a>`
                     } else {
                        mainButton = `<a target='_blank' href='${single_detail_link}' class='bookbtn mt1 site-bg-main-color' ${style}> ${buttonName}</a>`
                     }
                     var pricePerNight = ''
                     if(nights > 1 ) {
                        pricePerNight = ` <div class='d-flex align-items-center pricePerNight'>
                                      <h2 class='CurrencyCal' data-amount='${item.price_currency.AmountCurrency}'>${number_format(parseInt(item.price_currency.AmountCurrency))}</h2>
                                      <span>${translateXmlByParams('PriceForEachNight', {'Price': ''})}</span>
                                   </div>`
                     }
                     mainItem += ` ${mainButton}
                            ${pricePerNight}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
                     $('#hotelResult').append(mainItem)
                  })
               } else {
                  $('.loaderPublicForHotel').hide()
                  $('.loader-for-local-hotel-end').hide()
                  $('.container_loading').hide()
                  $('.loader-for-external-hotel-end').hide()
                  let htmlError = `<div class='userProfileInfo-messge'><div class='messge-login BoxErrorSearch'><div style='float: right;'>  <i class='fa fa-exclamation-triangle IconBoxErrorSearch'></i></div><div class='TextBoxErrorSearch'><p><br>${useXmltag('Nohotel')}<br><br></p></div></div></div>`
                  $('#hotelResult').html(htmlError)
               }
               // (Start) put advertise
               if (advertises.length > 0) {
                  let mainAdvertise = '<div class="advertises">'
                  console.log('Advertises')
                  $.each(advertises, function(index, item) {
                     console.log('Advertise.item')
                     mainAdvertise += '<div class="advertise-item ">'
                     mainAdvertise += item.content
                     mainAdvertise += '</div>'
                  })
                  mainAdvertise += '</div>'
                  $(mainAdvertise).insertBefore('#hotelResult')
               }
               // (end) put advertise
               priceRangeSlider(data.minPrice, data.maxPrice)
            },
            error: function(error) {
               $('.loader-for-external-hotel-end').hide()
               let htmlError = `<div class='userProfileInfo-messge'><div class='messge-login BoxErrorSearch'><div style='float: right;'>  <i class='fa fa-exclamation-triangle IconBoxErrorSearch'></i></div><div class='TextBoxErrorSearch'><p><br>${error.responseJSON.Message[0]}<br><br></p></div></div></div>`
               $('#hotelResult').html(htmlError)
            },
            complete: function() {
               $('.loaderPublicForHotel').hide()
               $('.loader-for-local-hotel-end').hide()
               $('.container_loading').hide()
               sortHotelList('min_room_price')
               let cityId = $('#destination_city').val()
               loadArticles('Hotel', cityId)
            },
            // always: function () {
            //     $('.loaderPublicForHotel').hide();
            //     $('.loader-for-local-hotel-end').hide();
            //     $('.container_loading').hide();
            //     sortHotelList('min_room_price');
            //     loadArticles('Hotel',cityId);
            // }
         })
      }
      if (gdsSwitch == 'detailHotel') {
         let data = $('#dataDetailHotel').val()
         let parseJson = JSON.parse(data)
         $.ajax({
            type: 'POST',
            url: amadeusPath + 'hotel_ajax.php',
            dataType: 'JSON',
            data: parseJson,
            beforeSend: function() {
               $('.loaderPublicForHotel').show()
            },
            success: function(data) {
               if (data.Success && data.StatusCode == 200) {
                  let WebServiceType = data.WebServiceType
                  console.log(WebServiceType)
                  let RequestNumber = data.RequestNumber
                  let value = data.Result
                  console.log(value)
                  let lat = value.ContactInformation.Location.latitude ? value.ContactInformation.Location.latitude : 0
                  let lon = value.ContactInformation.Location.longitude ? value.ContactInformation.Location.longitude : 0
                  $('[name="requestNumber"]').val(RequestNumber)
                  $('[name="webServiceType"]').val(WebServiceType)
                  generateHtmlForSearchHotel(data, parseJson)
                  /*Activate Carousel*/
                  generateCarousel('.owl-carousel')
                  generateMap(lat, lon)
                  $('#ThisHotelResult').val(JSON.stringify(data))
                  $('.RoomsContainer').html(`<div id='resultRoomHotel'><div class='roomHotelLocal'><div class='loader-box-user-buy'><span></span><span>${useXmltag('Loading')}</span></div></div></div>`)
                  $('.loaderPublicForHotel').fadeOut(500)
                  setTimeout(function() {
                     ajaxGetPrices(RequestNumber, data)
                  }, 3000)
               } else {
                  console.log(data)
                  $.alert({
                     title: 'خطا ',
                     content: 'یک خطای غیر منتظره رخ داده . ',
                     rtl: true,
                     icon: 'fa shopping-cart',
                     type: 'red',
                  })
               }
            },
            error: function(error) {
               $.alert({
                  title: 'خطا ',
                  content: 'یک خطای غیر منتظره رخ داده . ',
                  rtl: true,
                  icon: 'fa shopping-cart',
                  type: 'red',

               })
               console.log(error)
            },
            complete: function() {
               $('.loaderPublicForHotel').hide()

            },
            always: function() {
               $('.loaderPublicForHotel').hide()
            },
         })
      }
      $(document).on('click', '.show-map-modal', function() {
         $('.modal-body #mapContainer').remove()
         $('.modal-body').append('<div id="mapContainer" class="gmap3"></div>')
         let lat = $(this).data('latitude')
         let lng = $(this).data('longitude')

         map = L.map('mapContainer').setView([lng, lat], 15)
         // set map tiles source
         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ' <a href="https://www.iran-tech.com/">Iran Technology</a>',
            // maxZoom: 18,
            // minZoom: 11,
         }).addTo(map)
         // add marker to the map
         marker = L.marker([lng, lat]).addTo(map)
         // add popup to the marker
         $('#map_modal').modal({
            show: true,
         })
      })
      $('#map_modal').on('shown.bs.modal', function() {
         setTimeout(function() {
            map.invalidateSize()
         }, 1)
      })
   })
})(jQuery)
function openBoxPopular(e) {
   HotelPopular(e);
   $("#autoComplateSearchIN_2,#autoComplateSearchIN,#destination_city,#destination_country,#autoComplateSearchIN_hidden,#autoComplateSearchINResidence,#autoComplateSearchIN_hiddenResidence").val("");
}



function HotelPopular(e) {
   // بستن تمام لیست‌ها
   $('#listSearchCity, #listSearchCity_2, #listSearchCityResidence, #listSearchCityResidence').addClass('displayiN');
   $('#listSearchCity, #listSearchCity_2, #listSearchCityResidence, #listSearchCityResidence').html("");

   let targetUl;
   let flag;
   if (e === 'hotel') {
      targetUl = '#listSearchCity';
      flag = 'popularCityForInternalHotel';
      $(targetUl).html(`<h2>${useXmltag('Popularhotels')}</h2>`);
   } else if (e === 'externalHotel') {
      targetUl = '#listSearchCity_2';
      flag = 'flightExternalRoutesDefault';
      $(targetUl).html(`<h2>${useXmltag('Popularhotels')}</h2>`);
   } else if (e === 'residence') {
      targetUl = '#listSearchCityResidence';
      flag = 'popularCityForInternalHotel'; // همان داده‌های هتل داخلی
      $(targetUl).html(`<h2>${useXmltag('Popularcities')}</h2>`);
   }


   setTimeout(function() {
      $.post(amadeusPath + 'hotel_ajax.php', {
         flag: flag,
         self_Db: true,
      }, function(data) {
         JSON.parse(data).forEach((index) => {
            if (lang === 'en' || lang === 'ar') {
               if (e === 'hotel' || e === 'residence') {
                  $(targetUl).append(`
                     <li onclick="selectCity_internal('${index.id}','${index.city_name_en}' , '${index.city_name_en}' , 'city')"> 
                        <i class="div_c_sr_i">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                        </i>
                        <div class="div_c_sr">
                           <span class="c-text">${index.city_name_en}</span>
                        </div>
                     </li>
                  `);
               } else {
                  $(targetUl).append(item_search(index.CountryEn, index.DepartureCityEn, index.DepartureCityEn, index.DepartureCityEn, index.CountryEn));
               }
            } else if (lang === 'fa') {
               if (e === 'externalHotel' && index.CountryEn !== 'Iran') {
                  let indexCountry = index.CountryFa || index.CountryEn || " ";
                  $(targetUl).append(`
                     <li onclick="selectCity(event , '${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityFa}','${index.DepartureCode}')"> 
                        <i class="div_c_sr_i">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                        </i>
                        <div class="div_c_sr">
                           <span class="c-text">${index.DepartureCityFa}</span>
                           <div class="yata_gdemo">
                              <i>${indexCountry}</i>
                           </div>
                        </div>
                     </li>
                  `);
               }else if (e === 'hotel' || e === 'residence') {
                  $(targetUl).append(`
                     <li onclick="${e === 'hotel' ? 'selectCity_internal' : 'selectCity_residence'}('${index.id}','${index.city_name}' , '${index.city_name_en}' , 'city')"> 
                        <i class="div_c_sr_i">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                        </i>
                        <div class="div_c_sr">
                           <span class="c-text">${lang === 'fa' ? index.city_name : index.city_name_en}</span>
                        </div>
                     </li>
                  `);
               }
            }
         });
         $(targetUl).removeClass('displayiN');
      });
   }, 10);
}



// function HotelPopular(e){
//    $('#listSearchCity , #listSearchCity_2,#listSearchCity3').removeClass('displayiN')
//    $('#listSearchCity').html("");
//    $('#listSearchCity').html(`<h2>${useXmltag('Popularhotels')}</h2>`);
//    $('#listSearchCity_2').html("");
//    $('#listSearchCity_2').html(`<h2>${useXmltag('Popularhotels')}</h2>`);
//    setTimeout(function() {
//       $.post(amadeusPath + 'hotel_ajax.php',
//         {
//            flag: e === 'externalHotel' ? 'flightExternalRoutesDefault' : 'popularCityForInternalHotel' ,
//            self_Db: true,
//         },
//         function(data) {
//            console.log(e)
//            JSON.parse(data).forEach((index) => {
//               if (lang === 'en' || lang === 'ar' ){
//                  if(e === 'hotel') {
//                     document.querySelector('#listSearchCity').innerHTML+=
//                       `<li onclick="selectCity_internal('${index.id}','${index.city_name_en}' , '${index.city_name_en}' , 'city')">
//                          <i class="div_c_sr_i">
//                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
//                         </i>
//                          <div class="div_c_sr">
//                            <span class="c-text">
//                               ${index.city_name_en}
//                            </span>
//                          </div>
//                        </li>`
//                  }else{
//                     document.querySelector('#listSearchCity_2').innerHTML+= item_search(index.CountryEn, index.DepartureCityEn, index.DepartureCityEn, index.DepartureCityEn, index.CountryEn);
//                  }
//               }
//               else if(lang === 'fa'){
//                  console.log('ppppppppppppp')
//                  if(e === 'externalHotel' && index.CountryEn !== 'Iran'){
//                     let indexCountry;
//                     if(index.CountryFa !== null){
//                        indexCountry = index.CountryFa
//                     }else if(index.CountryEn !== null){
//                        indexCountry = index.CountryEn
//                     } else {
//                        indexCountry = " "
//                     }
//                     document.querySelector('#listSearchCity_2').innerHTML+=
//                       `<li onclick="selectCity(event , '${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityFa}','${index.DepartureCode}')">
//                    <i class="div_c_sr_i">
//                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
//                   </i>
//                    <div class="div_c_sr">
//                       <span class="c-text">
//                         ${index.DepartureCityFa}
//                       </span>
//                       <div class="yata_gdemo">
//                         <i>${indexCountry}</i>
//                       </div>
//                    </div>
//                   </li>`;
//                  }
//                  else if(e === 'hotel') {
//                     document.querySelector('#listSearchCity').innerHTML+=
//                       `<li onclick="selectCity_internal('${index.id}','${index.city_name}' , '${index.city_name_en}' , 'city')">
//                          <i class="div_c_sr_i">
//                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
//                         </i>
//                          <div class="div_c_sr">
//                            <span class="c-text">
//                               ${index.city_name}
//                            </span>
//                          </div>
//                        </li>`
//                  }
//
//               }
//            })
//            $('#listSearchCity , #listSearchCity_2, #listSearchCity3').removeClass('displayiN')
//         })
//    },10)
// }
function selectCity_internal(id , name , nameEN , type_application){
   $('#autoComplateSearchIN_hidden').val(id)
   $("#autoComplateSearchIN_hidden_en").val(nameEN)
   $('#autoComplateSearchIN').val(name)
   type_application_searchInternalHotel = type_application;
   $("#startDateForHotelLocal").trigger('click')
   $("#startDateForHotelLocal").focus();

}

function selectCity_residence(id, name, nameEN, type_application) {

   $('#autoComplateSearchIN_hiddenResidence').val(id);
   $('#autoComplateSearchINResidence').val(name);
   $('#autoComplateSearchIN_hidden_en_residence').val(nameEN);
   type_application_searchResidence = type_application;
   $('#type_code').trigger('click');
   $('#type_code').select2('open');
   $('#type_code').focus();
}

function selectCity( e, AirportEn , AirportFa , CountryEn , CountryFa , DepartureCityEn , DepartureCityFa , DepartureCode) {
   let CountryFaLet;
   let DepartureCityFaLet;

   if(lang == 'fa') {
      if(CountryFa !== 'null'){
         CountryFaLet = CountryFa + ' - '
      }else if(CountryEn !== 'null'){
         CountryFaLet = CountryEn + ' - '
      } else {
         CountryFaLet = " "
      }


      if(DepartureCityFa !== 'null'){
         DepartureCityFaLet = DepartureCityFa
      }else if(DepartureCityEn !== 'null'){
         DepartureCityFaLet = DepartureCityEn
      } else {
         DepartureCityFaLet = " "
      }
   }
   else{
      if(CountryEn !== 'null'){
         CountryFaLet = CountryEn + ' - '
      } else {
         CountryFaLet = " "
      }

      if(DepartureCityEn !== 'null'){
         DepartureCityFaLet = DepartureCityEn
      } else {
         DepartureCityFaLet = " "
      }
   }



   $('#autoComplateSearchIN').val(CountryFaLet + DepartureCityFaLet)
   $('#autoComplateSearchIN_2').val(CountryFaLet + DepartureCityFaLet)
   $('#destination_country').val(CountryEn)
   $('#destination_city').val(DepartureCityEn)
   $('#international_hotel .destination-country-js').val(CountryEn)
   $('#international_hotel .destination-city-js').val(DepartureCityEn)
   $('#destination_city_foreign').val(DepartureCityEn)
   $('#listSearchCity , #listSearchCity_2, #listSearchCityResidence').addClass('displayiN')
   e.stopPropagation();

   $("#startDateForExternalHotelInternational").trigger('click')
   $("#startDateForExternalHotelInternational").focus();
}

function item_search(CountryEn,DepartureCityEn,DepartureCityEn,city,country) {
   return `<li onclick="selectCity(event ,'' , '',  '${CountryEn}','', '${DepartureCityEn}', '- ${DepartureCityEn}')"> 
             <i class="div_c_sr_i">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
            </i>
             <div class="div_c_sr">
               <span class="c-text">
                  ${city}
               </span>
                <div class="yata_gdemo">
                  <i>${country}</i>
                </div>
             </div>
           </li>`
}
$("body , html").click(function() {
   $('#listSearchCity , #listSearchCity_2, #listSearchCityResidence').addClass('displayiN')
})

function searchCity(e) {
   let autoComplateSearchIN;
   if(e === 'externalHotel'){
      autoComplateSearchIN = $('#autoComplateSearchIN_2').val()
   } else if(e === 'hotel') {
      autoComplateSearchIN = $('#autoComplateSearchIN').val()
   }

   if(autoComplateSearchIN.length == 1){
      hotelEnterThreeLetters()
   }else if (autoComplateSearchIN.length == 0){
      HotelPopular(e)
   }else if(autoComplateSearchIN.length >= 2 && (e === 'searchCityHotelForInternalHotel' ||e === 'hotel'  ) ||
     autoComplateSearchIN.length >= 3 && e === 'externalHotel'){

      hotelLoader()
      setTimeout(()=>{
         $.post(amadeusPath + 'hotel_ajax.php',
           {
              inputSearchValue: autoComplateSearchIN,
              flag: e === 'externalHotel' ? 'searchCityForExternalHotel' : 'searchCityHotelForInternalHotel' ,
              json:true,
           },
           function(data) {
              if(e === 'externalHotel') {
                 let data_parse = JSON.parse(data)

                 if (data_parse.length >= 1) {
                    $('#listSearchCity , #listSearchCity_2, #listSearchCityResidence').html('');
                    data_parse.forEach((index) => {
                       let indexCountry;
                       if(!index.CountryFa){
                          index.CountryFa = index.CountryEn
                       }
                       console.log(index.CountryFa)
                       if(index.CountryFa !== null && lang == 'fa'){
                          indexCountry = index.CountryFa
                       }else if(index.CountryEn !== null){
                          indexCountry = index.CountryEn
                       } else {
                          indexCountry = " "
                       }
                       document.querySelector('#listSearchCity_2').innerHTML+= `
                              <li onclick="selectCity(event,'${index.AirportEn}','${index.AirportFa}','${index.CountryEn}','${index.CountryFa}','${index.DepartureCityEn}','${index.DepartureCityFa}','${index.DepartureCode}')"> 
                               <i class="div_c_sr_i">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                              </i>
                               <div class="div_c_sr">
                                  <span class="c-text">
                                    ${index.DepartureCityFa == null || lang != 'fa' ? index.DepartureCityEn : index.DepartureCityFa}
                                  </span>
                                  <div class="yata_gdemo">
                                  
                                    <i>${indexCountry}</i>
                                  </div>
                               </div>
                              </li>`

                    })
                 } else {
                    hotelNothingFound();
                 }

              }
              else{
                 let data_parse = JSON.parse(data)
                 setTimeout(function() {
                    if (Object.keys(data_parse).length > 0) {
                       document.querySelector('#listSearchCity').innerHTML=""
                       if(data_parse.Cities !== undefined){
                          data_parse.Cities.forEach((item) => {
                             document.querySelector('#listSearchCity').innerHTML+= `
                              <li onclick="selectCity_internal('${item.CityId}','${item.CityName}' , '${item.CityNameEn}' , 'city')"> 
                               <i class="div_c_sr_i">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"></path></svg>
                              </i>
                               <div class="div_c_sr">
                                  <span class="c-text">
                              
                                    ${lang == 'fa'? item.CityName : item.city_name_en}
                                  </span>
                               </div>
                              </li>`
                          })
                       }
                       if(data_parse.ApiHotels !== undefined){
                          data_parse.ApiHotels.forEach((item) => {
                             document.querySelector('#listSearchCity').innerHTML+= `
                              <li class="div_c_sr_blue" onclick="selectCity_internal('${item.HotelId}','${item.HotelName}' , '${item.HotelNameEn}' , 'api')"> 
                               <i class="div_c_sr_i">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 304C336 295.2 343.2 288 352 288H384C392.8 288 400 295.2 400 304V336C400 344.8 392.8 352 384 352H352C343.2 352 336 344.8 336 336V304zM336 112C336 103.2 343.2 96 352 96H384C392.8 96 400 103.2 400 112V144C400 152.8 392.8 160 384 160H352C343.2 160 336 152.8 336 144V112zM352 256C343.2 256 336 248.8 336 240V208C336 199.2 343.2 192 352 192H384C392.8 192 400 199.2 400 208V240C400 248.8 392.8 256 384 256H352zM448 0C483.3 0 512 28.65 512 64V448C512 483.3 483.3 512 448 512H288C252.7 512 224 483.3 224 448V64C224 28.65 252.7 0 288 0H448zM448 48H288C279.2 48 272 55.16 272 64V448C272 456.8 279.2 464 288 464H448C456.8 464 464 456.8 464 448V64C464 55.16 456.8 48 448 48zM192 176H72C58.75 176 48 186.7 48 200V440C48 453.3 58.75 464 72 464H193.3C196.4 482.3 204.6 498.8 216.4 512H72C32.24 512 0 479.8 0 440V200C0 160.2 32.24 128 72 128H192V176zM144 320C152.8 320 160 327.2 160 336V368C160 376.8 152.8 384 144 384H112C103.2 384 96 376.8 96 368V336C96 327.2 103.2 320 112 320H144zM144 224C152.8 224 160 231.2 160 240V272C160 280.8 152.8 288 144 288H112C103.2 288 96 280.8 96 272V240C96 231.2 103.2 224 112 224H144z"/></svg>
                               </i>
                               <div class="div_c_sr">
                                  <span class="c-text">
                                    ${lang == 'fa' ? item.HotelName : item.HotelNameEn}
                                  </span>
                               </div>
                              </li>`
                          })
                       }
                       if(data_parse.ReservationHotels !== undefined){
                          data_parse.ReservationHotels.forEach((item) => {
                             document.querySelector('#listSearchCity').innerHTML+= `
                              <li class="div_c_sr_blue" onclick="selectCity_internal('${item.HotelId}','${item.HotelName}' , '${item.HotelNameEn}' , 'reservation')"> 
                               <i class="div_c_sr_i">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 488C336 501.3 325.3 512 312 512C298.7 512 288 501.3 288 488V56C288 25.07 313.1 0 344 0H456C486.9 0 512 25.07 512 56V192H544V120C544 106.7 554.7 96 568 96C581.3 96 592 106.7 592 120V192.6C619.1 196.4 640 219.8 640 248V488C640 501.3 629.3 512 616 512C602.7 512 592 501.3 592 488V248C592 243.6 588.4 240 584 240H464V56C464 51.58 460.4 48 456 48H344C339.6 48 336 51.58 336 56V488zM368 96C368 87.16 375.2 80 384 80H416C424.8 80 432 87.16 432 96V128C432 136.8 424.8 144 416 144H384C375.2 144 368 136.8 368 128V96zM416 176C424.8 176 432 183.2 432 192V224C432 232.8 424.8 240 416 240H384C375.2 240 368 232.8 368 224V192C368 183.2 375.2 176 384 176H416zM368 288C368 279.2 375.2 272 384 272H416C424.8 272 432 279.2 432 288V320C432 328.8 424.8 336 416 336H384C375.2 336 368 328.8 368 320V288zM544 272C552.8 272 560 279.2 560 288V320C560 328.8 552.8 336 544 336H512C503.2 336 496 328.8 496 320V288C496 279.2 503.2 272 512 272H544zM496 384C496 375.2 503.2 368 512 368H544C552.8 368 560 375.2 560 384V416C560 424.8 552.8 432 544 432H512C503.2 432 496 424.8 496 416V384zM224 160C224 166 223 171 222 176C242 190 256 214 256 240C256 285 220 320 176 320H160V480C160 498 145 512 128 512C110 512 96 498 96 480V320H80C35 320 0 285 0 240C0 214 13 190 33 176C32 171 32 166 32 160C32 107 74 64 128 64C181 64 224 107 224 160z"/></svg>
                              </i>
                               <div class="div_c_sr">
                                  <span class="c-text">
                                    ${lang == 'fa' ? item.HotelName : item.HotelNameEn}
                                  </span>
                               </div>
                              </li>`
                          })
                       }
                    } else {
                       hotelNothingFound();
                    }
                 }, 10)
              }
           })
      },500)
   }

}
function hotelLoader(){
   $('#listSearchCity , #listSearchCity_2').html("");
   $('#listSearchCity , #listSearchCity_2').html(`
              <li class="hotelLoader_li"> 
                <div class="flight_loading_div">
                      <div class="flight_loading_div_loading"><div id="loading-spinner"></div></div>
                      <div class="loading-line"></div>
                </div>
              </li>`)
}
function hotelNothingFound(){
   $('#listSearchCity , #listSearchCity_2').html("");
   $('#listSearchCity , #listSearchCity_2').html(`
              <li class="listSearchCity_li listSearchCity_li_err"> 
               <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 351.1C218.8 351.1 192.8 369.5 177.6 385.9C168.7 395.6 153.5 396.3 143.7 387.3C133.1 378.3 133.4 363.1 142.4 353.4C164.3 329.5 202.3 303.1 256 303.1C309.7 303.1 347.7 329.5 369.6 353.4C378.6 363.1 378 378.3 368.3 387.3C358.5 396.3 343.3 395.6 334.4 385.9C319.2 369.5 293.2 351.1 256 351.1V351.1zM208.4 208C208.4 225.7 194 240 176.4 240C158.7 240 144.4 225.7 144.4 208C144.4 190.3 158.7 176 176.4 176C194 176 208.4 190.3 208.4 208zM304.4 208C304.4 190.3 318.7 176 336.4 176C354 176 368.4 190.3 368.4 208C368.4 225.7 354 240 336.4 240C318.7 240 304.4 225.7 304.4 208zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg>
               </i>
               <div class="div_c_sr">
                 <span class="c-text">
                    ${useXmltag('NothingFound')}
                 </span>
               </div>
             </li>`)
}
function hotelEnterThreeLetters(){
   $('#listSearchCity , #listSearchCity_2').html("");
   $('#listSearchCity , #listSearchCity_2').html(`
              <li class="EnterThreeLetters_li listSearchCity_li_err"> 
               <i class="div_c_sr_i">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M81.84 152.1C77.43 156.9 71.21 159.8 64.63 159.1C58.05 160.2 51.69 157.6 47.03 152.1L7.029 112.1C-2.343 103.6-2.343 88.4 7.029 79.03C16.4 69.66 31.6 69.66 40.97 79.03L63.08 101.1L118.2 39.94C127 30.09 142.2 29.29 152.1 38.16C161.9 47.03 162.7 62.2 153.8 72.06L81.84 152.1zM81.84 312.1C77.43 316.9 71.21 319.8 64.63 319.1C58.05 320.2 51.69 317.6 47.03 312.1L7.029 272.1C-2.343 263.6-2.343 248.4 7.029 239C16.4 229.7 31.6 229.7 40.97 239L63.08 261.1L118.2 199.9C127 190.1 142.2 189.3 152.1 198.2C161.9 207 162.7 222.2 153.8 232.1L81.84 312.1zM216 120C202.7 120 192 109.3 192 96C192 82.75 202.7 72 216 72H488C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H216zM192 256C192 242.7 202.7 232 216 232H488C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H216C202.7 280 192 269.3 192 256zM160 416C160 402.7 170.7 392 184 392H488C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416zM64 448C46.33 448 32 433.7 32 416C32 398.3 46.33 384 64 384C81.67 384 96 398.3 96 416C96 433.7 81.67 448 64 448z"/></svg>
               </i>
               <div class="div_c_sr">
                 <span class="c-text">
                    ${useXmltag('EnterThreeLetters')}
                 </span>
               </div>
             </li>`)
}


function typeResidenceOpen() {
   $("#startDateForHotelLocalResidence").trigger('click')
   $("#startDateForHotelLocalResidence").focus();
}