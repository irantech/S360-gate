// قرار بده این رو اول از همه (قبل از بقیه اسکریپت‌ها یا در بالا)
// (function(){
//    const PARENT = document.getElementById('exclusiveTour'); // <-- والدت اینجا
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


function searcExclusiveTour(type) {
   let no_error = true
   let obj_url = dataSearchExclusiveTour(type)


   if (no_error) {
      no_error = checkEmptyField(
         obj_url.origin,
         obj_url.destination,
         obj_url.multi_way,
         obj_url.return_date,
      )
   }
   if (no_error) {
      no_error = checkDateFlight(
         obj_url.departure_date,
         obj_url.today,
         obj_url.return_date,
         obj_url.multi_way,
      )
   }
   if (no_error) {
         if (type === 'internal') {
            exclusiveTourInternal(obj_url)
         } else if (type === 'international') {
            exclusiveTourInternational(obj_url)
         }
   }
}

function dataSearchExclusiveTour(type) {
   let origin = $('.origin-' + type + '-js')
   let destination = $('.destination-' + type + '-js')


   let multi_way = $('.' + type + '-two-way-js').is(':checked')
      ? $('.' + type + '-two-way-js').val()
      : $('.' + type + '-one-way-js').val()
   let departure_date = $('.departure-date-' + type + '-exclusive-tour-js')
   let return_date = $('.' + type + '-arrival-date-exclusive-tour-js')

   let today = dateNow('-')
   checkSearchFields(origin, destination, departure_date, return_date)
   origin = origin.val()
   destination = destination.val()
   departure_date = departure_date.val()
   return_date = return_date.val()

   return {
      origin: origin,
      destination: destination,
      multi_way: multi_way,
      departure_date: departure_date,
      return_date: return_date,
      today: today,
   }
}

function checkEmptyField(origin, destination, multi_way, return_date) {
   if (
      origin === '' ||
      destination === '' ||
      (multi_way === '2' && return_date === '')
   ) {
      $.alert({
         title: useXmltag('BookTicket'),
         icon: 'fa fa-cart-plus',
         content: useXmltag('Pleaseenterrequiredfields'),
         rtl: true,
         type: 'red',
      })

      return false
   }
   return true
}

function checkDateFlight(departure_date, today, return_date, multi_way) {
   if (departure_date < today) {
      $.alert({
         title: useXmltag('BookTicket'),
         icon: 'fa fa-cart-plus',
         content: useXmltag('DateWrong'),
         rtl: true,
         type: 'red',
      })
      return false
   } else if (multi_way === '2' && return_date < departure_date) {
      $.alert({
         title: useXmltag('BookTicket'),
         icon: 'fa fa-cart-plus',
         content: useXmltag('DateWrongReturn'),
         rtl: true,
         type: 'red',
      })
      return false
   }

   return true
}

function exclusiveTourInternal(obj) {

   let hotel_select_room = $(".internal-exclusive-tour-hotel-select-room-js")
   let my_room_hotel_item = hotel_select_room.find(".internal-exclusive-tour-my-room-hotel-item-js")
   let rooms = ""
   my_room_hotel_item.each(function () {
      let childAge = 0
      const adult = parseInt($(this).find(".internal-exclusive-tour-count-parent-js").val())
      const child = parseInt($(this).find(".internal-exclusive-tour-count-child-js").val())

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
            rooms = rooms + "-0"
         }
      } else {
         rooms = "1-0"
      }
   })

   let path = `${obj.origin}-${obj.destination}`
   let date = `${obj.departure_date}&${obj.return_date}`

   let url = `${amadeusPathByLang}exclusive-tour/1/${path}/${date}/${rooms}`;

   let target = $('internal_exclusive_tour #internal_flight_form').data('target')
   if(target != 'undefind' && target == '_blank' ){
      window.open(url , '_blank')
   }else {
      window.open(url , '_self')
   }
}
(function () {
   console.clear();
   console.log('[DP-RETURN] INIT');

   const INPUT_ID = 'internal-arrival-date-exclusive-tour-js';
   const DP_SELECTOR = '#ui-datepicker-div';

   let active = false;
   let startStamp = null;
   let lastHoverStamp = null;

   /***********************
    * Inject Style (once)
    ***********************/
   if (!document.getElementById('dp-return-style')) {
      const style = document.createElement('style');
      style.id = 'dp-return-style';
      style.innerHTML = `
            #ui-datepicker-div td.dp-return-hover {
                background-color: rgba(0, 123, 255, 0.2) !important;
            }
        `;
      document.head.appendChild(style);
      console.log('[DP-RETURN] STYLE INJECTED');
   }

   /***********************
    * Utils
    ***********************/
   function stampFromTd(td) {
      if (!td || !td.dataset || !td.dataset.year) return null;
      return (
         (+td.dataset.year) * 10000 +
         (+td.dataset.month + 1) * 100 +
         (+td.dataset.day)
      );
   }

   function detectStartStamp() {
      if (startStamp) return;

      const firstEnabledTd = document.querySelector(
         `${DP_SELECTOR} td:not(.ui-state-disabled):not(.ui-datepicker-unselectable)`
      );

      if (!firstEnabledTd) {
         console.warn('[DP-RETURN] NO ENABLED TD FOUND');
         return;
      }

      startStamp = stampFromTd(firstEnabledTd);
      console.log('[DP-RETURN] START AUTO SET →', startStamp);
   }

   function clearRange() {
      document
         .querySelectorAll(`${DP_SELECTOR} td.dp-return-hover`)
         .forEach(td => td.classList.remove('dp-return-hover'));
   }

   /***********************
    * Activate ONLY on this input
    ***********************/
   document.addEventListener('focusin', function (e) {
      if (e.target.id !== INPUT_ID) return;

      console.log('[DP-RETURN] INPUT FOCUSED');
      active = true;
      startStamp = null;
      lastHoverStamp = null;
   });

   document.addEventListener('focusout', function (e) {
      if (e.target.id !== INPUT_ID) return;

      console.log('[DP-RETURN] INPUT BLURRED');
      active = false;
      startStamp = null;
      lastHoverStamp = null;
      clearRange();
   });

   /***********************
    * Hover Logic (ONLY when active)
    ***********************/
   document.addEventListener('mouseover', function (e) {
      if (!active) return;

      const td = e.target.closest(`${DP_SELECTOR} td`);
      if (!td) return;

      if (
         td.classList.contains('ui-state-disabled') ||
         td.classList.contains('ui-datepicker-unselectable')
      ) return;

      detectStartStamp();
      if (!startStamp) return;

      const hoverStamp = stampFromTd(td);
      if (!hoverStamp || hoverStamp === lastHoverStamp) return;

      lastHoverStamp = hoverStamp;

      clearRange();

      let applied = 0;

      document
         .querySelectorAll(`${DP_SELECTOR} td:not(.ui-state-disabled):not(.ui-datepicker-unselectable)`)
         .forEach(el => {
            const current = stampFromTd(el);
            if (!current) return;

            if (current >= startStamp && current <= hoverStamp) {
               el.classList.add('dp-return-hover');
               applied++;
            }
         });

      console.log('[DP-RETURN] RANGE UPDATE', {
         startStamp,
         hoverStamp,
         applied
      });
   });

   console.log('[DP-RETURN] READY — focus return input to test');
})();


function exclusiveTourInternational(obj) {
   let path = `${obj.origin}-${obj.destination}`
   let date = `${obj.departure_date}&${obj.return_date}`

   let hotel_select_room = $(".international-exclusive-tour-hotel-select-room-js")
   let my_room_hotel_item = hotel_select_room.find(".international-exclusive-tour-my-room-hotel-item-js")
   let rooms = ""
   my_room_hotel_item.each(function () {
      let childAge = 0
      const adult = parseInt(
         $(this).find(".international-exclusive-tour-count-parent-js").val()
      )
      const child = parseInt(
         $(this).find(".international-exclusive-tour-count-child-js").val()
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
            rooms = rooms + "-0"
         }
      } else {
         rooms = "1-0"
      }
   })

   let url = `${amadeusPathByLang}exclusive-tour/0/${path}/${date}/${rooms}`
   let target = $('.international_exclusive_tour #international_flight_form').data('target')
   if(target != 'undefind' && target == '_blank' ){
      window.open(url , '_blank')
   } else {
      window.open(url , '_self')
   }

}

$('.departure-date-internal-js').click(() => {
   $('.departure-date-internal-js').removeClass('border-red')
})

// Exclusive Tour Passenger Picker Functions
function openCountPassengerExclusiveTour(type_section) {
   $("." + type_section + "-exclusive-tour-my-hotels-rooms-js").toggleClass("active_p")
}

$('body').click((e) => {
   if (!$(e.target).closest('.internal-exclusive-tour-passenger-picker-js, .international-exclusive-tour-passenger-picker-js').length) {
      $('.internal-exclusive-tour-my-hotels-rooms-js').removeClass("active_p")
      $('.international-exclusive-tour-my-hotels-rooms-js').removeClass("active_p")
   }
});

$('.internal-exclusive-tour-passenger-picker-js').click((e) => {
   e.stopPropagation()
});

$('.international-exclusive-tour-passenger-picker-js').click((e) => {
   e.stopPropagation()
});

$('.internal-exclusive-tour-close-room-js').click((e) => {
   $('.internal-exclusive-tour-my-hotels-rooms-js').removeClass("active_p")
});

$('.international-exclusive-tour-close-room-js').click((e) => {
   $('.international-exclusive-tour-my-hotels-rooms-js').removeClass("active_p")
});

function addRoomExclusiveTour(type_section) {
   $("." + type_section + "-exclusive-tour-my-hotels-rooms-js ." + type_section + "-exclusive-tour-close-room-js").show()
   let room_count = parseInt($("." + type_section + "-exclusive-tour-my-room-hotel-item-js").length)
   if (room_count <= 4) {

      let number_adult = parseInt($("." + type_section + "-exclusive-tour-number-adult-js").text())
      let number_room = parseInt($("." + type_section + "-exclusive-tour-number-room-js").text())
      $("." + type_section + "-exclusive-tour-number-adult-js").text(number_adult + 1)
      $("." + type_section + "-exclusive-tour-number-room-js").text(number_room + 1)
      let code = createRoomHotelLocalExclusiveTour(room_count, type_section)
      $("." + type_section + "-exclusive-tour-hotel-select-room-js").append(code)
      if (room_count >= 3) {
         $("." + type_section + "-exclusive-tour-btn-add-room-js").hide()
      }
      if (room_count >= 1) {
         $("." + type_section + "-exclusive-tour-my-hotels-rooms-js .close").removeClass("d-none")
         $("." + type_section + "-exclusive-tour-my-hotels-rooms-js .close").show()
      }
   }
}

function addNumberAdultExclusiveTour(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-exclusive-tour-count-parent-js")
      .val()

   if (input_num < 7) {
      input_num++
      let number_adult = parseInt(
         $("." + type_section + "-exclusive-tour-number-adult-js").text()
      )
      let result_number = number_adult + 1
      $(obj)
         .parent("div")
         .find("." + type_section + "-exclusive-tour-count-parent-js")
         .val(input_num)
      $("." + type_section + "-exclusive-tour-number-adult-js").html("")
      $("." + type_section + "-exclusive-tour-number-adult-js").append(result_number)
   }
}

function minusNumberAdultExclusiveTour(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-exclusive-tour-count-parent-js")
      .val()

   if (input_num > 1) {
      input_num--
      let number_adult = parseInt($("." + type_section + "-exclusive-tour-number-adult-js").text())
      let result_number = number_adult - 1
      $(obj)
         .parent("div")
         .find("." + type_section + "-exclusive-tour-count-parent-js")
         .val(input_num)
      $("." + type_section + "-exclusive-tour-number-adult-js").html("")
      $("." + type_section + "-exclusive-tour-number-adult-js").append(result_number)
   }
}

function addNumberChildExclusiveTour(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-exclusive-tour-count-child-js")
      .val()
   input_num++
   if (input_num < 5) {
      let number_child = parseInt(
         $("." + type_section + "-exclusive-tour-number-child-js").text()
      )

      let result_number = number_child + 1
      $(obj)
         .parent("div")
         .find("." + type_section + "-exclusive-tour-count-child-js")
         .val(input_num)
      $("." + type_section + "-exclusive-tour-number-child-js").html("")
      $("." + type_section + "-exclusive-tour-number-child-js").append(result_number)

      let room_number = $(obj)
         .parents("." + type_section + "-exclusive-tour-my-room-hotel-item-js")
         .data("roomnumber")

      let html_box = createBirthdayCalendarExclusiveTour(input_num, room_number)

      $(obj)
         .parents("." + type_section + "-exclusive-tour-my-room-hotel-item-info-js")
         .find("." + type_section + "-exclusive-tour-birth-days-js")
         .html(html_box)
   }
}

function minusNumberChildExclusiveTour(type_section, obj) {
   let input_num = $(obj)
      .parent("div")
      .find("." + type_section + "-exclusive-tour-count-child-js")
      .val()

   if (input_num > 0) {
      let number_child = parseInt(
         $("." + type_section + "-exclusive-tour-number-child-js").text()
      )

      let result_number = number_child - 1

      input_num--
      $(obj)
         .parent("div")
         .find("." + type_section + "-exclusive-tour-count-child-js")
         .val(input_num)
      $("." + type_section + "-exclusive-tour-number-child-js").html("")
      $("." + type_section + "-exclusive-tour-number-child-js").append(result_number)

      let room_number = $(obj)
         .parents("." + type_section + "-exclusive-tour-my-room-hotel-item-js")
         .data("roomnumber")

      let html_box = createBirthdayCalendarExclusiveTour(input_num, room_number)

      $(obj)
         .parents("div." + type_section + "-exclusive-tour-my-room-hotel-item-info-js")
         .find("." + type_section + "-exclusive-tour-birth-days-js")
         .html(html_box)
   } else {
      $(obj)
         .parents("div")
         .find("." + type_section + "-exclusive-tour-count-child-js")
         .val("0")
   }
}

function itemsRoomExclusiveTour(_this, type_section) {
   let room_count = $("." + type_section + "-exclusive-tour-my-room-hotel-item-js").length

   let child_count_this = parseInt(
     _this
         .parents("." + type_section + "-exclusive-tour-my-room-hotel-item-js")
         .find("." + type_section + "-exclusive-tour-count-child-js")
         .val()
   )
   let number_child = parseInt(
      $("." + type_section + "-exclusive-tour-number-child-js").text()
   )

   $("." + type_section + "-exclusive-tour-number-child-js").text(
      number_child - child_count_this
   )

   let adult_count_this = _this
      .parents("." + type_section + "-exclusive-tour-my-room-hotel-item-js")
      .find("." + type_section + "-exclusive-tour-count-parent-js")
      .val()
   let number_adult = $("." + type_section + "-exclusive-tour-number-adult-js").text()
   $("." + type_section + "-exclusive-tour-number-adult-js").text(
      number_adult - adult_count_this
   )

   $("." + type_section + "-exclusive-tour-btn-add-room-js").show()

   _this
      .parents("." + type_section + "-exclusive-tour-my-room-hotel-item-js")
      .remove()
   let number_room = 1
   let number_text = useXmltag('First')
   $("." + type_section + "-exclusive-tour-my-room-hotel-item-js").each(function () {
       $(this).data("roomnumber", number_room)

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
         .find("." + type_section + "-exclusive-tour-my-room-hotel-item-title-js")
         .html(
            `<span class="close" onclick="itemsRoomExclusiveTour($(this),'${type_section}')"><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"/></svg></i> </span> ${useXmltag('Room')} ${number_text}`
         )
      $(this)
         .find("." + type_section + "-exclusive-tour-my-room-hotel-item-info-js")
         .find("input[name^='adult']")
         .attr("name", "adult" + number_room)
      $(this)
         .find("." + type_section + "-exclusive-tour-my-room-hotel-item-info-js")
         .find("input[name^='adult']")
         .attr("id", "adult" + number_room)
      $(this)
         .find("." + type_section + "-exclusive-tour-my-room-hotel-item-info-js")
         .find("input[name^='child']")
         .attr("name", "child" + number_room)
      $(this)
         .find("." + type_section + "-exclusive-tour-my-room-hotel-item-info-js")
         .find("input[name^='child']")
         .attr("id", "child" + number_room)


      let number_child = 1
      let input_name_select_child_age = _this.find(
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
     $("." + type_section + "-exclusive-tour-number-room-js").text()
   )

   $("." + type_section + "-exclusive-tour-number-room-js").text(number_room - 1)


   if (room_count === 2) {
      $("." + type_section + "-exclusive-tour-my-hotels-rooms-js .close").addClass("d-none")
   }

}

function createBirthdayCalendarExclusiveTour(inputNum, roomNumber) {
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

function createRoomHotelLocalExclusiveTour(room_count, type_section) {
   let Html_code = ""
   let i = room_count + 1

   let number_text = useXmltag('First')
   let value_first

   if (i === 1) {
      number_text = useXmltag('First')
      value_first = "2"
   } else if (i === 2) {
      number_text = useXmltag('Second')
      value_first = "1"
   } else if (i === 3) {
      number_text = useXmltag('Third')
      value_first = "1"
   } else if (i === 4) {
      number_text = useXmltag('Fourth')
      value_first = "1"
   }

   if (i <= 4) {
      Html_code += ` <div class="myroom-hotel-item ${type_section}-exclusive-tour-my-room-hotel-item-js" data-roomnumber="${i}">
                        <div class="myroom-hotel-item-title ${type_section}-exclusive-tour-my-room-hotel-item-title-js">
                              <span class="close" onclick="itemsRoomExclusiveTour($(this),'${type_section}')">
                                  <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"/></svg></i>
                              </span>
                            ${useXmltag("Room")}  ${number_text}
                        </div>
                        <div class="myroom-hotel-item-info ${type_section}-exclusive-tour-my-room-hotel-item-info-js">
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

                                <h6>${useXmltag("Adult")}</h6>
                                ${useXmltag('OlderThanTwelve')}
                                <div>
                                    <i class="addParent ${type_section}-exclusive-tour-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal" onclick="addNumberAdultExclusiveTour('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/></svg></i>
                                    <input readonly="" autocomplete="off" class="countParent ${type_section}-exclusive-tour-count-parent-js"
                                           min="0" value="${value_first}"
                                           max="5" type="text" name="adult${i}" id="adult${i}"><i
                                            class="minusParent ${type_section}-exclusive-tour-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal" onclick="minusNumberAdultExclusiveTour('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"/></svg></i>
                                </div>
                            </div>
                            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                <h6>${useXmltag("Child")}</h6>
                                ${useXmltag("BetweenTwoAndTwelve")}

                                <div>
                                    <i class="addChild ${type_section}-exclusive-tour-add-number-child-js hotelroom-minus plus-hotelroom-koodak" onclick="addNumberChildExclusiveTour('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"/></svg></i>
                                    <input readonly="" class="countChild ${type_section}-exclusive-tour-count-child-js" autocomplete="off"
                                           min="0" value="0" max="5"
                                           type="text" name="child${i}" id="child${i}"><i
                                            class="minusChild ${type_section}-exclusive-tour-minus-number-child-js hotelroom-minus minus-hotelroom-koodak" onclick="minusNumberChildExclusiveTour('${type_section}',this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"/></svg></i>
                                </div>
                            </div>
                            <div class="tarikh-tavalods ${type_section}-exclusive-tour-birth-days-js"></div>
                        </div>
                    </div>`
   }

   return Html_code
}