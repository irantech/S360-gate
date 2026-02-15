// قرار بده این رو اول از همه (قبل از بقیه اسکریپت‌ها یا در بالا)
// (function(){
//   const PARENT = document.getElementById('Flight-parent'); // <-- والدت اینجا
//   if(!PARENT) return;
//
//   // نگهدار متدهای اصلی
//   const _qs  = document.querySelector.bind(document);
//   const _qsa = document.querySelectorAll.bind(document);
//   const _gid = document.getElementById.bind(document);
//   const _gecn = document.getElementsByClassName.bind(document);
//   const _getn = document.getElementsByName ? document.getElementsByName.bind(document) : null;
//   const _gett = document.getElementsByTagName.bind(document);
//
//   document.querySelectorAll = function(sel){
//     // تلاش کن داخل والد پیدا کنی؛ اگر پیدا شد همون نتایج رو برگردون
//     const inside = Array.from(PARENT.querySelectorAll(sel || ''));
//     if(inside.length) return inside;
//     return _qsa(sel);
//   };
//
//   document.querySelector = function(sel){
//     const inside = PARENT.querySelector(sel);
//     if(inside) return inside;
//     return _qs(sel);
//   };
//
//   document.getElementById = function(id){
//     // اول داخل والد بعد سند
//     const inside = PARENT.querySelector('#' + CSS.escape(id));
//     if(inside) return inside;
//     return _gid(id);
//   };
//
//   document.getElementsByClassName = function(name){
//     const inside = Array.from(PARENT.getElementsByClassName(name));
//     if(inside.length) return inside;
//     return _gecn(name);
//   };
//
//   document.getElementsByTagName = function(tag){
//     const inside = Array.from(PARENT.getElementsByTagName(tag));
//     if(inside.length) return inside;
//     return _gett(tag);
//   };
//
//   if(_getn){
//     document.getElementsByName = function(name){
//       const inside = Array.from(PARENT.querySelectorAll(`[name="${name}"]`));
//       if(inside.length) return inside;
//       return _getn(name);
//     };
//   }
//
// })();


// internal
const origin_input_internal = $('.route_origin_internal-js')
const destination_input_internal = $('.route_destination_internal-js')
// internal
// international
const origin_input_international = $('.iata-origin-international-js')
const destination_input_international = $('.iata-destination-international-js')
// international
// multi_way
const destination_multi_way = $('.destination-multi-way-js')
const origin_multi_way = $('.origin-multi-way-js')
// multi_way
const numberOfMonthsResponsive = $(window).width() > 768 ? 2 : 1

const nothing_found  = useXmltag("NothingFound")
const threeLetters  = useXmltag("EnterThreeLettersAtLeast")
let Loading_flight = `<div class='flight_loading'>
                                <ul>
                                  <li> 
                                    <div class='flight_loading_div'>
                                          <div class='flight_loading_div_loading'><div id='loading-spinner'></div></div>
                                          <div class='loading-line'></div>
                                    </div>
                                  </li>
                                  <li> 
                                    <div class='flight_loading_div'>
                                          <div class='flight_loading_div_loading'><div id='loading-spinner'></div></div>
                                          <div class='loading-line'></div>
                                    </div>
                                  </li>
                                  <li> 
                                    <div class='flight_loading_div'>
                                          <div class='flight_loading_div_loading'><div id='loading-spinner'></div></div>
                                          <div class='loading-line'></div>
                                    </div>
                                  </li>
                                  <li> 
                                    <div class='flight_loading_div'>
                                          <div class='flight_loading_div_loading'><div id='loading-spinner'></div></div>
                                          <div class='loading-line'></div>
                                    </div>
                                  </li>
                                </ul>
                              </div>`
let error_flight = `<div class='flight_error'>
                                <ul> 
                                  <li> 
                                    <div class='flight_error_div'>
                                        <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 351.1C218.8 351.1 192.8 369.5 177.6 385.9C168.7 395.6 153.5 396.3 143.7 387.3C133.1 378.3 133.4 363.1 142.4 353.4C164.3 329.5 202.3 303.1 256 303.1C309.7 303.1 347.7 329.5 369.6 353.4C378.6 363.1 378 378.3 368.3 387.3C358.5 396.3 343.3 395.6 334.4 385.9C319.2 369.5 293.2 351.1 256 351.1V351.1zM208.4 208C208.4 225.7 194 240 176.4 240C158.7 240 144.4 225.7 144.4 208C144.4 190.3 158.7 176 176.4 176C194 176 208.4 190.3 208.4 208zM304.4 208C304.4 190.3 318.7 176 336.4 176C354 176 368.4 190.3 368.4 208C368.4 225.7 354 240 336.4 240C318.7 240 304.4 225.7 304.4 208zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg></i>
                                        <div class='error-line'>${nothing_found} !</div>
                                    </div>
                                  </li>
                                </ul>
                              </div>`
let error_flight_text = `<div class='flight_error_text'>
                                <ul> 
                                  <li> 
                                    <div class='flight_error_text_div'>
                                        <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M81.84 152.1C77.43 156.9 71.21 159.8 64.63 159.1C58.05 160.2 51.69 157.6 47.03 152.1L7.029 112.1C-2.343 103.6-2.343 88.4 7.029 79.03C16.4 69.66 31.6 69.66 40.97 79.03L63.08 101.1L118.2 39.94C127 30.09 142.2 29.29 152.1 38.16C161.9 47.03 162.7 62.2 153.8 72.06L81.84 152.1zM81.84 312.1C77.43 316.9 71.21 319.8 64.63 319.1C58.05 320.2 51.69 317.6 47.03 312.1L7.029 272.1C-2.343 263.6-2.343 248.4 7.029 239C16.4 229.7 31.6 229.7 40.97 239L63.08 261.1L118.2 199.9C127 190.1 142.2 189.3 152.1 198.2C161.9 207 162.7 222.2 153.8 232.1L81.84 312.1zM216 120C202.7 120 192 109.3 192 96C192 82.75 202.7 72 216 72H488C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H216zM192 256C192 242.7 202.7 232 216 232H488C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H216C202.7 280 192 269.3 192 256zM160 416C160 402.7 170.7 392 184 392H488C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H184C170.7 440 160 429.3 160 416zM64 448C46.33 448 32 433.7 32 416C32 398.3 46.33 384 64 384C81.67 384 96 398.3 96 416C96 433.7 81.67 448 64 448z"/></svg></i>
                                        <div class='error_text-line'>${threeLetters} !</div>
                                    </div>
                                  </li>
                                </ul>
                              </div>`


$(document).ready(function() {
  getPopularInternalCities('origin')
  getPopularInternalCities('destination')
  getPopularCityInternational('origin')
  getPopularCityInternational('destination')
})


$('.origin-internal-js').on('change', function() {
  let iata = $(this).val()
  getArrivalRouteFlight(iata)
})


$('.add-flight-to-count-passenger-js').on('click', function() {
  getCountPassengersFlight(this, 'add')
})

$('.minus-flight-to-count-passenger-js').on('click', function() {
  getCountPassengersFlight(this, 'minus')
})
// internal
origin_input_internal.on('keyup', function() {
  getCityInternal(this, 'origin')
})
destination_input_internal.on('keyup', function() {
  getCityInternal(this, 'destination')
})
function getCityInternal(obj, type) {
  let list_flight_searched = $('.list-' + type + '-airport-internal-js')
  list_flight_searched.html(Loading_flight)
  $('.' + type + '-internal-js').val('')
  $('.list_popular_' + type + '_internal-js').hide()
  let search_date = $(obj).val()
  if (search_date.length >= 3) {
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'searchCitiesFlightInternal',
        className: 'newApiFlight',
        value: search_date,
        use_customer_db: true,
        is_group: true,
      }),
      success: function(response) {
        let items_search = []
        list_flight_searched.html('')
        $(response.data).each(function(key, value) {
          let sub_items_search = []
          let sub_items_search_ul = ''
          if (value.sub != undefined) {
            $(value.sub).each(function(key_sub, value_sub) {
              let json_sub_value = JSON.stringify({
                DepartureCode: value_sub.Departure_Code,
                DepartureCityFa: value_sub.Departure_City,
                DepartureCityEn: value_sub.Departure_CityEn,
                type: type,
              })
              if(lang == 'fa') {
                let departure_city = value_sub.DepartureCityFa
              }else{
                let departure_city = value_sub.DepartureCityEn
              }

              sub_items_search += `<li onclick='selectCityItem(${json_sub_value} , event , $(this))'> 
                                      <div class='div_c_sr'>
                                            <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                            <div class='c-text'>
                                              ${departure_city}
                                              (${value_sub.Departure_Code})
                                            </div>
                                      </div>
                                    </li>`
            })

            sub_items_search_ul = `<ul>${sub_items_search}</ul>`
          }

          let json_sub_value = JSON.stringify({
            DepartureCode: value.Departure_Code,
            DepartureCityFa: value.Departure_City,
            DepartureCityEn: value.Departure_CityEn,
            type: type,
          })
          let departure_city = ''
          if(lang == 'fa') {
            departure_city = value.Departure_City
          }else{
            departure_city = value.Departure_CityEn
          }
          items_search += `<li onclick='selectCityItem(${json_sub_value} , event , $(this))'> 
                                <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                      <div class='c-text'>
                                        ${departure_city}
                                        (${value.Departure_Code})
                                      </div>
                                </div>
                             
                            </li>
                            ${sub_items_search_ul}`
        })
        if (items_search.length === 0) {
          list_flight_searched.html(`<ul>${error_flight}</ul>`).show()
        }else {
          list_flight_searched.html(`<ul>${items_search}</ul>`).show()
        }
      },
      error: function(error) {
        // $.toast({
        //   heading: 'اطلاعات مقصد',
        //   text: error.responseJSON.message,
        //   position: 'top-right',
        //   loaderBg: '#fff',
        //   icon: 'error',
        //   hideAfter: 3500,
        //   textAlign: 'right',
        //   stack: 6,
        // })
      },
    })
  }
  else if(search_date.length === 0) {
    $('.list-' + type + '-airport-internal-js').hide();
    $('.list_popular_' + type + '_internal-js').show()
  } else {
    list_flight_searched.html(`<ul>${error_flight_text}</ul>`).show()
  }
}
// internal
// international
origin_input_international.on('keyup', function() {
  getCityInternational(this, 'origin')
})
destination_input_international.on('keyup', function() {
  getCityInternational(this, 'destination')
})

let origin_internal_international_flight = null;

function getCityInternational(obj, type) {

  let list_flight_searched = $('.list-' + type + '-airport-international-js')
  $('.' + type + '-international-js').val('')
  $('.list_popular_' + type + '_external-js').hide();
  list_flight_searched.html(Loading_flight)
  let iata = $(obj).val()
  if (iata.length >= 3) {
    if ($("#internal_international_flight_form").length === 1){
      $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType: 'json',
        data: JSON.stringify({
          method: 'searchAirports',
          className: 'airports',
          origin: origin_internal_international_flight,
          search_for: iata,
          is_json: true
        }),
        success: function(response) {
          let items_search = []
          list_flight_searched.html('')
          $(response.data).each(function(key, value) {
            let sub_items_search = []
            let sub_items_search_ul = ''
            // if (value.sub != undefined) {
            //   $(value.sub).each(function(key_sub, value_sub) {
            //     let json_sub_value = JSON.stringify({
            //       DepartureCode: value_sub.DepartureCode,
            //       DepartureCityFa: value_sub.DepartureCityFa,
            //       AirportFa: value_sub.AirportFa,
            //       CountryFa: value_sub.CountryFa,
            //       type: type,
            //     })
            //     sub_items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''>
            //                           <div class='div_c_sr'>
            //                     <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
            //                                 <span class='c-text'>
            //                                 ${value_sub.AirportFa} - ${value_sub.CountryFa}
            //                                 </span>
            //                                 <div class='yata_gdemo'>
            //                                   <i>${value_sub.DepartureCityFa}</i>
            //                                   <em>(${value_sub.DepartureCode})</em>
            //                                 </div>
            //                           </div>
            //                         </li>`
            //   })
            //
            //   sub_items_search_ul = `<ul>${sub_items_search}</ul>`
            // }
            let json_sub_value = JSON.stringify({
              DepartureCode: value.DepartureCode,
              DepartureCityFa: value.DepartureCityFa,
              AirportFa: value.AirportFa,
              AirportAr: value.AirportAr,
              AirportEn: value.AirportEn,
              CountryFa: value.CountryFa,
              FlightType: value.FlightType,
              type: type,
            })
            if(lang === 'fa'){
              items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''> 
                                <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                      <span class='c-text'>
                                      ${value.AirportFa} - ${value.CountryFa}
                                      </span>
                                      <div class='yata_gdemo'>
                                        <i>${value.DepartureCityFa}</i>
                                        <em>(${value.DepartureCode})</em>
                                      </div>
                                </div>
                             
                            </li> ${sub_items_search_ul}`
            }
            else if(lang === 'ar'){
              items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''> 
                                <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                      <span class='c-text'>
                                      ${value.AirportAr ? value.AirportAr : value.AirportEn} - ${value.CountryAr ?value.CountryAr : value.CountryEn}
                                      </span>
                                      <div class='yata_gdemo'>
                                        <i>${value.DepartureCityAr ? value.DepartureCityAr :value.DepartureCityEn}</i>
                                        <em>(${value.DepartureCode})</em>
                                      </div>
                                </div>
                             
                            </li> ${sub_items_search_ul}`
            }
            else{
              items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''> 
                                <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                      <span class='c-text'>
                                      ${value.AirportEn} - ${value.CountryEn}
                                      </span>
                                      <div class='yata_gdemo'>
                                        <i>${value.DepartureCityEn}</i>
                                        <em>(${value.DepartureCode})</em>
                                      </div>
                                </div>
                             
                            </li> ${sub_items_search_ul}`
            }
          })
          if (items_search.length === 0) {
            list_flight_searched.html(`<ul>${error_flight}</ul>`).show()
          }else {
            list_flight_searched.html(`<ul>${items_search}</ul>`).show()
          }
        },
        error: function(error) {
          list_flight_searched.html(`<ul>${error_flight}</ul>`).show()
        },
      })
    }
    else {
      $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType: 'json',
        data: JSON.stringify({
          method: 'cityForSearchInternational',
          className: 'routeFlight',
          iata,
          is_json: true,
        }),
        success: function(response) {

          let items_search = []
          list_flight_searched.html('')
          $(response.data).each(function(key, value) {
            let sub_items_search = []
            let sub_items_search_ul = ''
            if (value.sub != undefined) {
              $(value.sub).each(function(key_sub, value_sub) {
                let json_sub_value = JSON.stringify({
                  DepartureCode: value_sub.DepartureCode,
                  DepartureCityFa: value_sub.DepartureCityFa,
                  DepartureCityEn: value_sub.DepartureCityEn	,
                  AirportFa: value_sub.AirportFa,
                  AirportAr: value_sub.AirportAr,
                  AirportEn: value_sub.AirportEn,
                  CountryFa: value_sub.CountryFa,
                  FlightType: value_sub.FlightType,
                  type: type,
                })

                sub_items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''> 
                                      <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                            <span class='c-text'>`
                if(lang == 'fa') {
                  sub_items_search += `${value_sub.AirportFa} - ${value_sub.CountryFa}`
                }else if(lang == 'ar') {
                  sub_items_search += `${value_sub.AirportAr ? value_sub.AirportAr : value_sub.AirportEn } - ${value_sub.CountryAr ? value_sub.CountryAr : value_sub.CountryEn}`
                }else{
                  sub_items_search += `${value_sub.AirportEn} - ${value_sub.CountryEn}`
                }

                sub_items_search += `</span>
                                            <div class='yata_gdemo'>`
                if(lang == 'fa') {
                  sub_items_search += `<i>${value_sub.DepartureCityFa}</i>`
                }else if(lang == 'ar') {
                  sub_items_search += `<i>${value_sub.DepartureCityAr ? value_sub.DepartureCityAr : value_sub.DepartureCityEn}</i>`
                }else{
                  sub_items_search += `<i>${value_sub.DepartureCityEn}</i>`
                }
                sub_items_search += `<em>(${value_sub.DepartureCode})</em>
                                            </div>
                                      </div>
                                    </li>`
              })

              sub_items_search_ul = `<ul>${sub_items_search}</ul>`
            }
            let json_sub_value = JSON.stringify({
              DepartureCode: value.DepartureCode,
              DepartureCityFa: value.DepartureCityFa,
              DepartureCityEn: value.DepartureCityEn,
              AirportFa: value.AirportFa,
              AirportAr: value.AirportAr,
              AirportEn: value.AirportEn,
              CountryFa: value.CountryFa,
              FlightType: value.FlightType,
              type: type,
            })
            items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''> 
                                <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                      <span class='c-text'>`
            if(lang == 'fa') {
              items_search += `${value.AirportFa} - ${value.CountryFa}`
            }else if(lang == 'ar') {
              items_search += `${value.AirportAr ? value.AirportAr : value.AirportEn } - ${value.CountryAr ? value.CountryAr : value.CountryEn}`
            }else {
              items_search += `${value.AirportEn} - ${value.CountryEn}`
            }


            items_search += `</span>
                                      <div class='yata_gdemo'>`
            if(lang == 'fa') {
              items_search += `<i>${value.DepartureCityFa}</i>`
            }else if(lang == 'ar') {
              items_search += `<i>${value.DepartureCityAr ? value.DepartureCityAr : value.DepartureCityEn}</i>`
            }else{
              items_search += `<i>${value.DepartureCityEn}</i>`
            }
            items_search += `<em>(${value.DepartureCode})</em>
                                      </div>
                                </div>
                             
                            </li> ${sub_items_search_ul}`
          })
          if (items_search.length === 0) {
            list_flight_searched.html(`<ul>${error_flight}</ul>`).show()
          }else {
            list_flight_searched.html(`<ul>${items_search}</ul>`).show()
          }
        },
        error: function(error) {
          list_flight_searched.html(`<ul>${error_flight}</ul>`).show()
          // $.toast({
          //   heading: 'اطلاعات مقصد',
          //   text: error.responseJSON.message,
          //   position: 'top-right',
          //   loaderBg: '#fff',
          //   icon: 'error',
          //   hideAfter: 3500,
          //   textAlign: 'right',
          //   stack: 6,
          // })
        },
      })
    }
  }
  else if(iata.length === 0) {
    $('.list-origin' + type + '-airport-international-js').hide();
    $('.list_popular_' + type + '_external-js').show();

    $('.list-' + type + '-airport-international-js').hide();
  } else {
    list_flight_searched.html(`<ul>${error_flight_text}</ul>`).show()
  }
}
// international
// internal & international
function displayCityList(type) {
  $('.list_popular_origin_internal-js , .list_popular_destination_internal-js , .list-destination-airport-internal-js , .list-origin-airport-internal-js').hide()
  $('.list_popular_' + type + '_internal-js').show()
  if (type === 'destination') {
    if ($('.route_origin_internal-js').val() !== '') {
      if ($('.origin-internal-js').val() == '') {
        $('.route_origin_internal-js').addClass('border-red')
        $('.route_origin_internal-js').val('')
        $('.list-origin-airport-internal-js').hide()
      } else {
        $('.route_origin_internal-js').removeClass('border-red')
      }
    }
  }
}
// internal & international

$('body').on('focus', '.origin-multi-way-js', function() {
  $(this).val('')
})
$('body').on('focus', '.destination-international-js', function() {
  $(this).val('')
})
$('body').on('keyup', '.origin-multi-way-js', function() {
  let number = $(this).data('number')
  getCityInternational(this, `multi-${number}-origin`)
})
$('body').on('keyup', '.destination-multi-way-js', function() {
  let number = $(this).data('number')
  getCityInternational(this, `multi-${number}-destination`)
})
$('.switch-input-js').on('change', function() {
  if (this.checked && this.value === '1') {
    $('.international-flight-js').css('display', 'flex')
    $('.internal-flight-js').hide()
    $('.flight-multi-way-js').hide()
    $(this).attr('select_type','yes')
  } else {
    $('.internal-flight-js').css('display', 'flex')
    $('.international-flight-js').hide()
    $('.flight-multi-way-js').hide()
    $('.switch-input-js').removeAttr('select_type')
  }
})
$('.click_flight_multi_way').on('click', function() {
  $('.flight-multi-way-js').css('display', 'flex')
  $('.internal-flight-js').hide()
  $('.international-flight-js').hide()
})
$('.click_flight_oneWay').on('click', function() {
  $('.international-flight-js').css('display', 'flex')
  $('.internal-flight-js').hide()
  $('.flight-multi-way-js').hide()
})
$('.click_flight_twoWay').on('click', function() {
  $('.international-flight-js').css('display', 'flex')
  $('.internal-flight-js').hide()
  $('.flight-multi-way-js').hide()
})

$('.box-of-count-passenger-boxes-js,.div_btn').on('click', function(e) {
  $('.cbox-count-passenger-js').toggle()
  $(this).parents().find('.down-count-passenger').toggleClass('fa-caret-up')
  e.stopPropagation()
})
$('.cbox-count-passenger-js').click((e) => {
  e.stopPropagation()
})
$('body').click(() => {
  $('.cbox-count-passenger-js').hide()
  $(this).parents().find('.down-count-passenger').removeClass('fa-caret-up')
  $(`
  .list_popular_destination_internal-js, .list_popular_origin_internal-js,
  .list_popular_origin_external-js,
  .list_popular_destination_external-js,
  .list-origin-airport-internal-js,
  .list-destination-airport-internal-js,
  .list-origin-airport-international-js,
  .list-destination-airport-international-js,
  
  .list-multi-0-origin-airport-international-js,
  .list-multi-1-origin-airport-international-js,
  .list-multi-2-origin-airport-international-js,
  .list-multi-3-origin-airport-international-js,
  .list-multi-0-destination-airport-international-js,
  .list-multi-1-destination-airport-international-js,
  .list-multi-2-destination-airport-international-js,
  .list-multi-3-destination-airport-international-js
  `).hide()
  if ($('.origin-international-js').val() === '') {
    origin_input_international.val('')
  }
  if ($('.destination-international-js').val() === '') {
    destination_input_international.val('')
  }
  if ($('.origin-internal-js').val() === '') {
    origin_input_internal.val('')
  }
  if ($('.destination-internal-js').val() === '') {
    destination_input_internal.val('')
  }

  if ($('.multi-0-origin-international-js').val() === '') {
    $(".iata-multi-0-origin-international-js").val('')
  }
  if ($('.multi-1-origin-international-js').val() === '') {
    $(".iata-multi-1-origin-international-js").val('')
  }
  if ($('.multi-2-origin-international-js').val() === '') {
    $(".iata-multi-2-origin-international-js").val('')
  }
  if ($('.multi-3-origin-international-js').val() === '') {
    $(".iata-multi-3-origin-international-js").val('')
  }
  if ($('.multi-0-origin-international-js').val() === '') {
    $(".iata-multi-0-destination-international-js").val('')
  }
  if ($('.multi-1-origin-international-js').val() === '') {
    $(".iata-multi-1-destination-international-js").val('')
  }
  if ($('.multi-2-origin-international-js').val() === '') {
    $(".iata-multi-2-destination-international-js").val('')
  }
  if ($('.multi-3-origin-international-js').val() === '') {
    $(".iata-multi-3-destination-international-js").val('')
  }
})
origin_input_internal.click((event) => {
  event.stopPropagation()
})
destination_input_internal.click((event) => {
  event.stopPropagation()
})

function getPopularInternalCities(type) {
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'json',
    data: JSON.stringify({
      method: 'searchCitiesFlightInternal',
      className: 'newApiFlight',
      use_customer_db: true,
      is_group: true,
      limit: 12,
    }),
    success: function(response) {
      popular_cities = response.data
      let items_search = []
      let list_flight_popular = $(
          '.list_popular_' + type + '_internal-js',
      )
      list_flight_popular.html('')
      let data
      let dataList = []
      if (JSON.parse(localStorage.getItem('internalSearchedCities')) !== null && Object.keys(JSON.parse(localStorage.getItem('internalSearchedCities'))).length !== 0) {
        if (type == 'origin') {
          if (JSON.parse(localStorage.getItem('internalSearchedCities'))['origin']) {
            data = JSON.parse(localStorage.getItem('internalSearchedCities'))['origin']

            dataList = []
            for (let item of data) {

              let departure_city = item.Departure_CityFa
              if(lang == 'ar' && item.Departure_CityAr){

                departure_city = item.Departure_CityAr
              } else if( item.Departure_CityEn){

                departure_city = item.Departure_CityEn
              }


              let items_search_local = `<li onclick='selectCityItem({"DepartureCode":"${item.Departure_Code}","DepartureCityFa":"${item.Departure_CityFa}","DepartureCityEn":"${departure_city}" , "type":"origin"} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><div class='c-text'>${departure_city} (${item.Departure_Code})</div></div></li>`
              dataList.unshift(items_search_local)
            }
            list_flight_popular.html(`<div class='history_items_search'><h2>${useXmltag("History")} <button type='button' onclick="deleteLocalStorage('internalSearchedCities','arrival' , event)">${useXmltag("Clear")}</button> </h2><ul>${dataList.join('')}</ul></div>`)
          }
        } else {
          if (JSON.parse(localStorage.getItem('internalSearchedCities'))['arrival']) {
            data = JSON.parse(localStorage.getItem('internalSearchedCities'))['arrival']
            dataList = []
            for (let item of data) {
              let departure_city = item.Departure_CityFa
              if(lang == 'ar' && item.Departure_CityAr){
                departure_city = item.Departure_CityAr
              } else if( item.Departure_CityEn ){
                departure_city = item.Departure_CityEn
              }
              let items_search_local = `<li onclick='selectCityItem({"DepartureCode":"${item.Departure_Code}","DepartureCityFa":"${item.Departure_CityFa}","DepartureCityEn":"${departure_city}","type":"destination"} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><div class='c-text'>${departure_city} (${item.Departure_Code})</div></div></li>`
              dataList.unshift(items_search_local)
            }
            list_flight_popular.html(`<div class='history_items_search'><h2>${useXmltag("History")} <button type='button' onclick="deleteLocalStorage('internalSearchedCities','origin' , event)">${useXmltag("Clear")}</button> </h2><ul>${dataList.join('')}</ul></div>`)
          }
        }
      }
      $(popular_cities).each(function(key, value) {
        let sub_items_search = []
        let sub_items_search_ul = ''
        if (value.sub != undefined) {
          $(value.sub).each(function(key_sub, value_sub) {
            let departure_city = value_sub.Departure_CityFa
            if(lang != 'fa' && value_sub.Departure_CityEn ){
              departure_city = value_sub.Departure_CityEn
            }
            let json_sub_value = JSON.stringify({
              DepartureCode: value_sub.Departure_Code,
              DepartureCityFa: value_sub.Departure_CityFa,
              DepartureCityEn: departure_city,
              type: type,
            })
            sub_items_search += `
                         <li onclick='selectCityItem(${json_sub_value} , event , $(this))')> 
                           <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                             <span class='c-text'>
                               ${departure_city}
                               (${value_sub.Departure_Code})
                             </span>
                           </div>
                         </li>
                      `
          })
          sub_items_search_ul = `<ul>${sub_items_search}</ul>`
        }

        let departure_city = value.Departure_CityFa
        if(lang != 'fa' && value.Departure_CityEn ){
          departure_city = value.Departure_CityEn
        }

        let json_sub_value = JSON.stringify({
          DepartureCode: value.Departure_Code,
          DepartureCityFa: value.Departure_CityFa,
          DepartureCityEn: departure_city,
          type: type,
        })
        items_search += `
                   <li onclick='selectCityItem(${json_sub_value} , event , $(this))'> 
                     <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                       <div class='c-text'>
                         ${departure_city}
                         (${value.Departure_Code})
                       </div>
                     </div>
                   </li>
                   ${sub_items_search_ul}
                `
      })
      list_flight_popular.append(`<h2>${useXmltag("Busy")}</h2><ul>${items_search}</ul>`)
    },
    error: function(error) {
      // $.toast({
      //   heading: 'اطلاعات مقصد',
      //   text: error.responseJSON.message,
      //   position: 'top-right',
      //   loaderBg: '#fff',
      //   icon: 'error',
      //   hideAfter: 3500,
      //   textAlign: 'right',
      //   stack: 6,
      // })
    },
  })
}

function deleteLocalStorage(LocalStorageName, LocalStorageType, event) {
  let searchedCitiesGet = JSON.parse(localStorage.getItem(LocalStorageName))
  let localStorageTypeSet = {[LocalStorageType]: searchedCitiesGet[LocalStorageType]}
  localStorage.setItem(LocalStorageName, JSON.stringify(localStorageTypeSet))
  event.target.parentElement.parentElement.classList.add('d-none')
  event.stopPropagation()
}

function displayCityListExternal(type, event) {
  $('.list_popular_origin_external-js , .list_popular_destination_external-js , .list-origin-airport-international-js , .list-destination-airport-international-js').hide()
  $(`.list_popular_${type}_external-js`).show()
  event.stopPropagation()
}

function getArrivalRouteFlight(iata, iata_destination) {
  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'json',
    data: JSON.stringify({
      method: 'listRouteArrival',
      className: 'routeFlight',
      iata,
      is_json: true,
    }),
    success: function(response) {
      let obj_arrival = response.data
      let destination = $('.destination-internal-js')
      destination.html(' ')
      destination.append(' <option value="">انتخاب مقصد</option>')
      Object.keys(obj_arrival).forEach(key => {
        let option_text = `${obj_arrival[key]['Arrival_City']}(${obj_arrival[key]['Arrival_Code']})`
        let option_value = `${obj_arrival[key]['Arrival_Code']}`
        let new_option = new Option(option_text, option_value, false, false)
        destination.append(new_option).trigger('open')
      })
      if (iata_destination !== undefined) {
        destination.val(iata_destination).trigger('open')
      } else {
        destination.select2('open')
      }
    },
    error: function(error) {
      // $.toast({
      //   heading: 'اطلاعات مقصد',
      //   text: error.responseJSON.message,
      //   position: 'top-right',
      //   loaderBg: '#fff',
      //   icon: 'error',
      //   hideAfter: 3500,
      //   textAlign: 'right',
      //   stack: 6,
      // })
    },
  })
}

function reversRouteFlight(type, number_selected) {

  let rout_origin = origin_input_internal.val()
  let rout_destination = destination_input_internal.val()
  let origin = $('.origin-internal-js').val()
  let destination = $('.destination-internal-js').val()
  if (rout_destination !== '') {
    origin_input_internal.val(rout_destination)
    destination_input_internal.val(rout_origin)
    $('.origin-internal-js').val(destination)
    $('.destination-internal-js').val(origin)

  }

}

function reversDestination(type, number_selected) {

  let rout_origin = $('.iata-origin-international-js').val()
  let rout_destination = $('.iata-destination-international-js').val()
  let origin = $('.origin-international-js').val()
  let destination = $('.destination-international-js').val()
  if (rout_destination !== '') {
    $('.iata-origin-international-js').val(rout_destination)
    $('.iata-destination-international-js').val(rout_origin)
    $('.origin-international-js').val(destination)
    $('.destination-international-js').val(origin)

  }

}

function getPopularCityInternational(type) {

  $.ajax({
    type: 'POST',
    url: amadeusPath + 'ajax',
    dataType: 'json',
    data: JSON.stringify({
      method: 'getPopularInternationalFlight',
      className: 'newApiFlight',
      limit: 5,
      self_Db: true,
    }),
    success: function(response) {
      popular_cities = response.data;
      let items_search = [];
      let data;
      let dataList = [];
      let list_flight_popular = $('.list_popular_' + type + '_external-js');
      list_flight_popular.html('');
      if (JSON.parse(localStorage.getItem('internationalSearchedCities')) !== null && Object.keys(JSON.parse(localStorage.getItem('internationalSearchedCities'))).length !== 0) {
        if (type == 'origin') {
          if (JSON.parse(localStorage.getItem('internationalSearchedCities'))['origin']) {
            data = JSON.parse(localStorage.getItem('internationalSearchedCities'))['origin']
            dataList = []
            data.forEach((item) => {
              let json_sub_value = JSON.stringify({
                AirportFa: item.AirportFa,
                AirportAr: item.AirportAr,
                AirportEn: item.AirportEn,
                CountryFa: item.CountryFa,
                CountryEn: item.CountryEn,
                CountryAr: item.CountryAr,
                DepartureCityFa: item.DepartureCityFa,
                DepartureCityEn: item.DepartureCityEn,
                DepartureCityAr: item.DepartureCityAr,
                DepartureCode: item.DepartureCode,
                FlightType: item.FlightType,
                type: type,
              })
              let items_search_local;
              if(lang === 'fa'){
                items_search_local = `<li onclick='selectAirportItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportFa} - ${item.CountryFa}</span><div class='yata_gdemo'><i>${item.DepartureCityFa}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`
              }
              else if(lang === 'ar') {
                items_search_local = `<li onclick='selectAirportItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportAr ? item.AirportAr :item.AirportEn } - ${item.CountryAr ? item.CountryAr : item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityAr ? item.DepartureCityAr :item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`
              }
              else{
                items_search_local = `<li onclick='selectAirportItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportEn} - ${item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`
              }
              dataList.unshift(items_search_local)
            })
            list_flight_popular.html(`<div class='history_items_search'><h2>${useXmltag("History")} <button type='button' onclick="deleteLocalStorage('internationalSearchedCities' , 'arrival' , event)">${useXmltag("Clear")}</button> </h2><ul>${dataList.join('')}</ul></div>`)
          }
        } else {
          if (JSON.parse(localStorage.getItem('internationalSearchedCities'))['arrival']) {
            data = JSON.parse(localStorage.getItem('internationalSearchedCities'))['arrival']
            dataList = []
            console.log('1')
            data.forEach((item) => {
              let json_sub_value = JSON.stringify({
                DepartureCode: item.DepartureCode,
                DepartureCityFa: item.DepartureCityFa,
                DepartureCityEn: item.DepartureCityEn,
                DepartureCityAr: item.DepartureCityAr,
                AirportFa: item.AirportFa,
                AirportEn: item.AirportEn,
                AirportAr: item.AirportAr,
                CountryFa: item.CountryFa,
                CountryEn: item.CountryEn,
                CountryAr: item.CountryAr,
                FlightType: item.FlightType,
                type: type,
              })
              let items_search_local;
              if(lang === 'fa'){
                items_search_local = `<li onclick='selectAirportItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportFa}</span><div class='yata_gdemo'><i>${item.DepartureCityFa}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`
              }
              else if(lang === 'ar') {
                items_search_local = `<li onclick='selectAirportItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportAr ? item.AirportAr : item.AirportEn} - ${item.CountryAr ? item.CountryAr : item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityAr ? item.DepartureCityAr : item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`
              }
              else {
                items_search_local = `<li onclick='selectAirportItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportEn} - ${item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`
              }
              dataList.unshift(items_search_local)
            })
            list_flight_popular.html(`<div class='history_items_search'><h2>${useXmltag("History")} <button type='button' onclick="deleteLocalStorage('internationalSearchedCities' , 'origin' , event)">${useXmltag("Clear")}</button> </h2><ul>${dataList.join('')}</ul></div>`)
          }
        }
      }
      $(response.data).each(function(key, value) {
        let sub_items_search = []
        let sub_items_search_ul = ''

        if (value.sub != undefined) {
          $(value.sub).each(function(key_sub, value_sub) {
            let json_sub_value = JSON.stringify({
              DepartureCode: value_sub.DepartureCode,
              DepartureCityFa: value_sub.DepartureCityFa,
              DepartureCityEn: value_sub.DepartureCityEn,
              DepartureCityAr: value_sub.DepartureCityAr,
              AirportFa: value_sub.AirportFa,
              AirportAr: value_sub.AirportAr,
              AirportEn: value_sub.AirportEn,
              CountryFa: value_sub.CountryFa,
              CountryEn: value_sub.CountryEn,
              CountryAr: value_sub.CountryAr,
              FlightType: value_sub.FlightType,
              type: type,
            })
            sub_items_search += `
                         <li onclick='selectAirportItem(${json_sub_value} , event , $(this))'> 
                           <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                             <span class='c-text'>`

            if(lang == 'fa') {
              sub_items_search += ` ${value_sub.AirportFa} - ${value_sub.CountryFa} `
            }
            else if(lang == 'ar') {
              sub_items_search += ` ${value_sub.AirportAr ? value_sub.AirportAr :value_sub.AirportEn} - ${value_sub.CountryAr ? value_sub.CountryAr : value_sub.CountryEn} `
            }
            else {
              sub_items_search += ` ${value_sub.AirportEn} - ${value_sub.CountryEn} `
            }

            sub_items_search += ` <div class='yata_gdemo'>`
            if(lang == 'fa') {
              sub_items_search += ` <i>${value_sub.DepartureCityFa}</i> `
            }
            else if(lang == 'ar') {
              sub_items_search += ` <i>${value_sub.DepartureCityAr ? value_sub.DepartureCityAr : value_sub.DepartureCityEn}</i> `
            }
            else {
              sub_items_search += ` <i>${value_sub.DepartureCityEn}</i> `
            }

            sub_items_search += ` <em>(${value_sub.DepartureCode})</em>
                              </div>
                           </div>
                         </li>
                      `
          })
          sub_items_search_ul = `<ul>${sub_items_search}</ul>`
        }
        let json_sub_value = JSON.stringify({
          DepartureCode: value.DepartureCode,
          DepartureCityFa: value.DepartureCityFa,
          DepartureCityEn: value.DepartureCityEn,
          DepartureCityAr: value.DepartureCityAr,
          AirportFa: value.AirportFa,
          AirportAr: value.AirportAr,
          AirportEn: value.AirportEn,
          CountryFa: value.CountryFa,
          CountryEn: value.CountryEn,
          CountryAr: value.CountryAr,
          FlightType: value.FlightType,
          type: type,
        })

        items_search += `
                   <li onclick='selectAirportItem(${json_sub_value} , event , $(this))'> 
                     <div class='div_c_sr'>
                                <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                       <span class='c-text'>`
        if(lang == 'fa') {
          items_search += ` ${value.AirportFa} - ${value.CountryFa} `
        }
        else if(lang == 'ar'){
          items_search += ` ${value.AirportAr ? value.AirportAr :value.AirportEn} - ${value.CountryAr ? value.CountryAr :value.CountryEn} `
        }
        else{
          items_search += ` ${value.AirportEn} - ${value.CountryEn} `
        }
        items_search += `</span>
                          <div class='yata_gdemo'>`
        if(lang == 'fa') {
          items_search += ` <i>${value.DepartureCityFa}</i> `
        }
        else if(lang == 'ar') {

          items_search += ` <i>${value.DepartureCityAr ?value.DepartureCityAr :value.DepartureCityEn}</i> `
        }
        else{
          items_search += ` <i>${value.DepartureCityEn}</i> `
        }
        items_search += `<em>(${value.DepartureCode})</em>
                        </div>
                     </div>
                   </li>
                   ${sub_items_search_ul}
                `
      })
      list_flight_popular.append(`<h2>${useXmltag("Busy")}</h2><ul>${items_search}</ul>`)
    },
    error: function(error) {
      // $.toast({
      //   heading: 'اطلاعات مقصد',
      //   text: error.responseJSON.message,
      //   position: 'top-right',
      //   loaderBg: '#fff',
      //   icon: 'error',
      //   hideAfter: 3500,
      //   textAlign: 'right',
      //   stack: 6,
      // })
    },
  })
}

function jumping(obj_type,type,DepartureCode){
  if (type === "internal"){
    if(obj_type === "origin"){
      $(".list_popular_origin_internal-js , .list-origin-airport-internal-js").hide();
      $(".list_popular_destination_internal-js").show();
      destination_input_internal.focus().val("");
      $(".destination-internal-js").val("")
    } else if(obj_type === "destination"){
      if($(".origin-internal-js").val() === DepartureCode){
        $(".list_popular_destination_internal-js , .list-destination-airport-internal-js").hide();
        $(".list_popular_origin_internal-js , .list-origin-airport-internal-js").show();
        origin_input_internal.focus().val("");
        $(".origin-internal-js").val("")
      } else {
        $(".list_popular_destination_internal-js , .list-destination-airport-internal-js").hide();

        // تاریخ رفت معمولی
        $("#departure_date_internal").trigger("click").focus()

        // تاریخ رفت تور اختصاصی داخلی
        if($("#departure_date_internal_exclusive_tour").length) {
          var departureInput = $("#departure_date_internal_exclusive_tour")[0];
          var lastValue = departureInput.value;

          // استفاده از interval برای رصد تغییرات
          var checkInterval = setInterval(function() {
            if(departureInput.value !== lastValue && departureInput.value !== '') {
              lastValue = departureInput.value;
              clearInterval(checkInterval);

              setTimeout(function() {
                if($("#internal-arrival-date-exclusive-tour-js").length) {
                  $("#internal-arrival-date-exclusive-tour-js").trigger("click").focus();
                }
              }, 300);
            }
          }, 100);

          // پاکسازی interval بعد از 10 ثانیه
          setTimeout(function() {
            clearInterval(checkInterval);
          }, 10000);

          $("#departure_date_internal_exclusive_tour").trigger("click").focus();
        }



      }
    }
  } else if(type === "international"){
    if(obj_type === "origin"){
      $(".list_popular_origin_external-js , .list-origin-airport-international-js").hide();
      $(".list_popular_destination_external-js").show();
      destination_input_international.focus().val("");
      $(".destination-international-js").val("")
    } else if(obj_type === "destination"){
      if($(".origin-international-js").val() === DepartureCode){
        $(".list_popular_destination_external-js , .list-destination-airport-international-js").hide();
        $(".list_popular_origin_external-js , .list-origin-airport-international-js").show();
        origin_input_international.focus().val("");
        $(".origin-international-js").val("")
      } else {
        $(".list_popular_destination_external-js , .list-destination-airport-international-js").hide();

        // تاریخ رفت معمولی
        $("#departure_date_international").trigger("click").focus()

        // تاریخ رفت تور اختصاصی بین‌المللی
        if($("#departure_date_international_exclusive_tour").length) {
          var departureInput = $("#departure_date_international_exclusive_tour")[0];
          var lastValue = departureInput.value;

          // استفاده از interval برای رصد تغییرات
          var checkInterval = setInterval(function() {
            if(departureInput.value !== lastValue && departureInput.value !== '') {
              lastValue = departureInput.value;
              clearInterval(checkInterval);

              setTimeout(function() {
                if($("#international-arrival-date-exclusive-tour-js").length) {
                  $("#international-arrival-date-exclusive-tour-js").trigger("click").focus();
                }
              }, 300);
            }
          }, 100);

          // پاکسازی interval بعد از 10 ثانیه
          setTimeout(function() {
            clearInterval(checkInterval);
          }, 10000);

          $("#departure_date_international_exclusive_tour").trigger("click").focus();
        }
      }
    } else if(obj_type === "multi-0-origin"){
      $(".iata-multi-0-destination-international-js").focus().val("");
      $(".multi-0-destination-international-js").val("")
    } else if(obj_type === "multi-0-destination"){
      $(".date-multi-0-js").focus();
    }  else if(obj_type === "multi-1-origin"){
      $(".iata-multi-1-destination-international-js").focus().val("");
      $(".multi-1-destination-international-js").val("")
    } else if(obj_type === "multi-1-destination"){
      $(".date-multi-1-js").focus();
    }  else if(obj_type === "multi-2-origin"){
      $(".iata-multi-2-destination-international-js").focus().val("");
      $(".multi-2-destination-international-js").val("")
    } else if(obj_type === "multi-2-destination"){
      $(".date-multi-2-js").focus();
    }  else if(obj_type === "multi-3-origin"){
      $(".iata-multi-3-destination-international-js").focus().val("");
      $(".multi-3-destination-international-js").val("")
    } else if(obj_type === "multi-3-destination"){
      $(".date-multi-3-js").focus();
    }
  } else if(type === "package"){
    if(obj_type === "origin"){
      $(".list-origin-airport-package-js").hide();
      $(".iata-destination-package-js").focus().val("");
      $(".destination-package-js").val("")
    } else if(obj_type === "destination"){
      $(".departure-date-package-js").focus();
    }
  }
}

let internal_international = "international"
let CountryFa_origin = false;
let CountryFa_destination = false;

function selectAirportItem(obj, event) {

  if ($("#internal_international_flight_form").length === 1){
    if(obj.type === "origin" && obj.FlightType == 'Internal') {
      $("#origin-flight-type-js").val("Internal")
      CountryFa_origin = true;
    } else {
      CountryFa_origin = false;
    }

    if( obj.FlightType == 'Internal' && obj.type === "destination") {
      $("#destination-flight-type-js").val("Internal")
      CountryFa_destination = true;
    } else {
      CountryFa_destination = false;
    }
    let origin_flight_type = $("#origin-flight-type-js").val()
    let destination_flight_type = $("#destination-flight-type-js").val()
    console.log(origin_flight_type , destination_flight_type)
    if (origin_flight_type == 'Internal' && destination_flight_type == 'Internal') {
      internal_international = "search-flight";
      console.log('if')
    } else {
      internal_international = "international";
      console.log('else')
    }

    if(obj.type === "destination"){
      origin_internal_international_flight = obj.DepartureCode;
    }
  }
  jumping(obj.type , "international" , obj.DepartureCode)
  if(lang == 'fa') {
    $('.iata-' + obj.type + '-international-js').val(obj.AirportFa + ' - ' + obj.DepartureCode)
  }else if(lang == 'ar') {
    $('.iata-' + obj.type + '-international-js').val(obj.AirportAr === null ? obj.AirportEn : obj.AirportAr + ' - ' + obj.DepartureCode)
  }else{
    $('.iata-' + obj.type + '-international-js').val(obj.AirportEn + ' - ' + obj.DepartureCode)
  }

  $('.iata-' + obj.type + '-international-js').removeClass("border-red")
  $('.' + obj.type + '-international-js').val(obj.DepartureCode)
  $('.list-' + obj.type + '-airport-international-js').html('').hide()
  event.stopPropagation()
}

function selectCityItem(obj, e, element) {
  jumping(obj.type , "internal" , obj.DepartureCode)
  let text_origin = ''
  if(lang == 'fa') {
    text_origin = `${obj.DepartureCityFa}`
  }else{
    text_origin = `${obj.DepartureCityEn}`
  }


  $('.route_' + obj.type + '_internal-js').val(text_origin)
  $('.route_' + obj.type + '_internal-js').removeClass("border-red")
  $('.' + obj.type + '-internal-js').val(obj.DepartureCode)
  $('.list-' + obj.type + '-airport-internal-js').html('').hide()
  e.stopPropagation()
}

$('.departure-date-internal-js').click(() => {
  $('.departure-date-internal-js').removeClass('border-red')
})
$('.internal-arrival-date-js').click(() => {
  $('.internal-arrival-date-js').removeClass('border-red')
})
$('.departure-date-international-js').click(() => {
  $('.departure-date-international-js').removeClass('border-red')
})
$('.international-arrival-date-js').click(() => {
  $('.international-arrival-date-js').removeClass('border-red')
})

function newAdditionalExternal(_this) {
  let routes = $('.additional-flight-multi-way-js')
  if (routes.length < 3) {
    let clone = routes.first().clone()
    clone.find('input').each(function() {
      $(this).val('')
    })
    setTimeoutDeptCalendar()
    routes.last().after(clone)
    let count_path = parseInt($('.count-path-js').val())
    count_path = count_path + 1
    $('.count-path-js').val(count_path)
    console.log($('.count-path-js').val())
    initIdAdditionalExternal()
  }
}

function initIdAdditionalExternal() {
  let counter = 1
  $('.additional-flight-multi-way-js').each(function() {
    $(this)
        .find('[id]')
        .each(function() {
          if (counter !== 1 && $(this).hasClass('remove_btn')) {
            $(this).removeClass('d-none')
          }

          addIdAndName($(this), counter)
        })
    counter++
  })
}

function addIdAndName(item, counter) {
  if (item.hasClass('origin-multi-way-js')) {
    item.attr('name', `iata_multi_${counter}_origin_international`)
    item.attr('id', `iata_multi_${counter}_origin_international`)
    item.removeAttr('class')
    item.attr(
        'class',
        `iata-multi-${counter}-origin-international-js origin-multi-way-js form-control  inputSearchForeign`,
    )
    item.attr('data-number', counter)
  } else if (item.hasClass('iata-multi-js')) {
    item.attr('name', `multi_${counter}_origin_airport`)
    item.attr('id', `multi_${counter}_origin_airport`)
    item.removeAttr('class')
    item.attr(
        'class',
        `multi-${counter}-origin-international-js iata-multi-js`,
    )
  } else if (item.hasClass('list-show-result-js')) {
    item.attr('name', `list_multi_${counter}_origin_airport`)
    item.attr('id', `list_multi_${counter}_origin_airport`)
    item.removeAttr('class')
    item.attr(
        'class',
        `resultUlInputSearch list-show-result list-multi-${counter}-origin-airport-international-js list-show-result-js`,
    )
  } else if (item.hasClass('switch-routs-js')) {
    let arg_title = 'multi_way_flight'
    item.attr(
        'onclick',
        'reversRouteFlight(' +
        '\'' +
        `${arg_title}` +
        '\'' +
        ',' +
        '\'' +
        `${counter}` +
        '\'' +
        ')',
    )
  } else if (item.hasClass('destination-multi-way-js')) {
    item.attr('name', `iata_multi_${counter}_destination_international`)
    item.attr('id', `iata_multi_${counter}_destination_international`)
    item.attr('data-number', counter)
    item.removeAttr('class')
    item.attr(
        'class',
        `iata-multi-${counter}-destination-international-js destination-multi-way-js form-control  inputSearchForeign`,
    )
  } else if (item.hasClass('destination-iata-multi-js')) {
    item.attr('name', `multi_${counter}_destination_airport`)
    item.attr('id', `multi_${counter}_destination_airport`)
    item.removeAttr('class')
    item.attr(
        'class',
        `multi-${counter}-destination-international-js iata-multi-js`,
    )
  } else if (item.hasClass('destination-list-show-result-js')) {
    item.attr('id', `list_multi_${counter}_destination_airport`)
    item.removeAttr('class')
    item.attr(
        'class',
        `resultUlInputSearch list-show-result destination-list-js list-multi-${counter}-destination-airport-international-js  destination-list-show-result-js `,
    )
  } else if (item.hasClass('date_multi_way')) {
    item.attr('name', `date_multi_${counter}`)
    item.attr('id', `date_multi_${counter}`)
    item.removeAttr('class')
    item.attr(
        'class',
        `deptCalendar date_multi_way form-control date-multi-${counter}-js `,
    )
  }
}

function removeAdditionalExternal(_this) {
  let route = _this.parent().parent().parent()
  route.remove()
  let count_path = parseInt($('.count-path-js').val())
  count_path = count_path - 1
  $('.count-path-js').val(count_path)
  initIdAdditionalExternal()
}

function dataSearchFlight(type) {
  let number_adult = parseInt($('.' + type + '-adult-js').val())
  let number_child = parseInt($('.' + type + '-child-js').val())
  let number_infant = parseInt($('.' + type + '-infant-js').val())
  let origin = $('.origin-' + type + '-js')
  let destination = $('.destination-' + type + '-js')
  let classFlight = type === 'internal' ? $('#flight_class_internal').val() : $('#flight_class_international').val()


  let multi_way = $('.' + type + '-two-way-js').is(':checked')
      ? $('.' + type + '-two-way-js').val()
      : $('.' + type + '-one-way-js').val()
  let departure_date = $('.departure-date-' + type + '-js')
  let return_date = $('.' + type + '-arrival-date-js')
  let today = dateNow('-')
  checkSearchFields(origin, destination, departure_date, return_date)
  origin = origin.val()
  destination = destination.val()
  departure_date = departure_date.val()
  return_date = return_date.val()

  return {
    number_adult: number_adult,
    number_child: number_child,
    number_infant: number_infant,
    origin: origin,
    destination: destination,
    multi_way: multi_way,
    departure_date: departure_date,
    return_date: return_date,
    today: today,
    classFlight:classFlight
  }
}

function searchFlight(type) {
  console.log(type)
  let no_error = true
  let obj_url = dataSearchFlight(type)
  console.log(obj_url)
  no_error = checkCountAdult(obj_url.number_adult)
  if (no_error) {
    no_error = checkCountAdultVsInfant(
        obj_url.number_adult,
        obj_url.number_infant,
    )
  }
  if (no_error) {
    no_error = checkAdultAndChild(obj_url.number_adult, obj_url.number_child)
  }
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
    if ($("#internal_international_flight_form").length === 1){
      search_international_flight_form(obj_url)
    } else {
      if (type === 'internal') {
        searchInternal(obj_url)
      } else if (type === 'international') {
        searchInternational(obj_url)
      }
    }
  }
}

function searchInternal(obj) {
  //for parto test

  let path = `${obj.origin}-${obj.destination}`
  let date =
      obj.multi_way === '2'
          ? `${obj.departure_date}&${obj.return_date}`
          : `${obj.departure_date}`
  let count_passenger = `${obj.number_adult}-${obj.number_child}-${obj.number_infant}`


  let is_parto_test = false  ;
  if($('#set_international').val() == "1" && obj.multi_way === '2') {
    is_parto_test = true
  }

  // Only add classFlight to URL if it's not 'all' or empty
  let classFlightParam = (obj.classFlight && obj.classFlight !== 'all' && obj.classFlight !== '')
      ? `/${obj.classFlight}`
      : '';

  let url = `${amadeusPathByLang}search-flight/${obj.multi_way}/${path}/${date}/Y/${count_passenger}${classFlightParam}`;
  console.log('url -> ' , obj)
  if(is_parto_test) {
    url = `${amadeusPathByLang}international/${obj.multi_way}/${path}/${date}/Y/${count_passenger}`
  }

  const form = $('#internal_flight_form')[0];
  let target = form.target === '_blank';
  console.log('target: ' , target)
  if(target){
    window.open(url , '_blank')
  }else {
    window.open(url , '_self')
  }
}

function searchInternational(obj) {
  let path = `${obj.origin}-${obj.destination}`
  let date =
      obj.multi_way === '2'
          ? `${obj.departure_date}&${obj.return_date}`
          : `${obj.departure_date}`
  let count_passenger = `${obj.number_adult}-${obj.number_child}-${obj.number_infant}`

  // Only add classFlight to URL if it's not 'all' or empty
  let classFlightParam = (obj.classFlight && obj.classFlight !== 'all' && obj.classFlight !== '')
      ? `/${obj.classFlight}`
      : '';

  let url = `${amadeusPathByLang}international/${obj.multi_way}/${path}/${date}/Y/${count_passenger}${classFlightParam}`
  // let target = $('#international_flight_form').data('target')
  const form = $('#international_flight_form')[0];
  const target = form.target === '_blank';
  if(target){
    window.open(url , '_blank')
  }else {
    window.open(url , '_self')
  }

}
function search_international_flight_form(obj) {
  let path = `${obj.origin}-${obj.destination}`
  let date =
      obj.multi_way === '2'
          ? `${obj.departure_date}&${obj.return_date}`
          : `${obj.departure_date}`
  let count_passenger = `${obj.number_adult}-${obj.number_child}-${obj.number_infant}`
  let url = `${amadeusPathByLang}${internal_international}/${obj.multi_way}/${path}/${date}/Y/${count_passenger}`

  let target = $(obj).parents().find('#international_flight_form').data('target')
  if(target != 'undefind' && target == '_blank' ){
    window.open(url , '_blank')
  }else {
    window.open(url , '_self')
  }
}

function severalPathFlight() {
  //international&mroute=yes&departure[0]=IKA&arrival[0]=DXBALL&departuredate[0]=1401-09-29&departure[1]=DXBALL&arrival[1]=NJF&departuredate[1]=1401-09-30&adult=1&child=0&infant=0
  let count_path = parseInt($('.count-path-js').val())

  let origin = []
  let destination = []
  let departure_date = []
  let error_multi = true
  let path_multi = ''
  let today = dateNow('-')
  let number_adult = $('.multi-adult-js').val()
  let number_child = $('.multi-child-js').val()
  let number_infant = $('.multi-infant-js').val()
  for (let i = 0; i < count_path; i++) {

    origin[i] = $('.multi-' + i + '-origin-international-js').val()
    destination[i] = $('.multi-' + i + '-destination-international-js').val()
    departure_date[i] = $('.date-multi-' + i + '-js').val()

    if (
        departure_date[i] == '' ||
        origin[i] == '' ||
        destination[i] == ''
    ) {

      error_multi = false
    } else {
      error_multi = true

      if (i === 0) {
        path_multi = `&mroute=yes`
      }
      path_multi += `&departure[${i}]=${origin[i]}&arrival[${i}]=${destination[i]}&departuredate[${i}]=${departure_date[i]}`
    }
  }

  if (!error_multi) {
    $.alert({
      title: useXmltag('BookTicket'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('Fillingallfieldsrequired'),
      rtl: true,
      type: 'red',
    })
    return false
  }

  error_multi = checkCountAdult(number_adult)
  if (error_multi) {
    error_multi = checkCountAdultVsInfant(number_adult, number_infant)
  }
  if (error_multi) {
    error_multi = checkAdultAndChild(number_adult, number_child)
  }
  if (error_multi) {
    error_multi = checkDateFlight(departure_date, today)
  }
  if (error_multi) {
    let count_passenger = `&adult=${number_adult}&child=${number_child}&infant=${number_infant}`
    let url = amadeusPathByLang + 'international' + path_multi + count_passenger

    let target = $(this).parents().find('#gds_portal').data('target')
    if(target != 'undefind' && target == '_blank' ){
      window.open(url , '_blank')
    }else {
      window.open(url , '_self')
    }

  }
}

function checkCountAdult(number_adult) {
  if (parseInt(number_adult) <= 0) {
    $.alert({
      title: useXmltag('BookTicket'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('LeastOneAdult'),
      rtl: true,
      type: 'red',
    })
    return false
  }
  return true
}

function checkCountAdultVsInfant(number_adult, number_infant) {
  if (parseInt(number_infant) > parseInt(number_adult)) {
    $.alert({
      title: useXmltag('BookTicket'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('SumAdultsChildrenNoGreaterThanAdult'),
      rtl: true,
      type: 'red',
    })
    return false
  }
  return true
}

function checkAdultAndChild(number_adult, number_child) {
  if ((parseInt(number_adult )+ parseInt( number_child) ) > 9) {
    $.alert({
      title: useXmltag('BookTicket'),
      icon: 'fa fa-cart-plus',
      content: useXmltag('ErrorAdultCount'),
      rtl: true,
      type: 'red',
    })
    return false
  }
  return true
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

function getCountPassengersFlight(obj, type) {


  let count_passengers = $(obj).siblings('.number-count-js').attr('data-number')
  let type_passengers = $(obj).siblings('.number-count-js').attr('data-type')
  let type_search = $(obj).siblings('.number-count-js').attr('data-search')

  let adult_count  = $('.' + type_search+'-adult-js').val();
  let child_count  = $('.' + type_search+'-child-js').val();
  let infant_count = $('.' + type_search+'-infant-js').val();

  let total_count_value = (parseInt(adult_count) + parseInt(child_count) + parseInt(infant_count)) ;
  let total_count = parseInt(adult_count) == 1 ? (parseInt(adult_count) + 1) : parseInt(total_count_value);
  if(type === 'add') {
    total_count = 1 + parseInt(total_count_value);

  }else{
    total_count = parseInt(total_count_value) - 1 ;
  }

  if(total_count > 9 && type === 'add'){

    $('.' + type_search + '-count-passenger-js').css('color','#ccc').css('border-color','#ccc');
    return false;

  }else{

    $('.add-flight-to-count-passenger-js').removeAttr('style');
    if (count_passengers <= 9) {
      let new_passenger = count_passengers
      if (type === 'add' && count_passengers < 9) {
        new_passenger = ++count_passengers
      } else if (type !== 'add' && count_passengers > 1 && type_passengers === 'adult') {
        new_passenger = --count_passengers
      } else if ( type !== 'add' && count_passengers >= 1 && type_passengers !== 'adult') {
        new_passenger = --count_passengers
      }

      $(obj).siblings('.number-count-js').html(count_passengers)
      $(obj).siblings('.number-count-js').attr('data-number', count_passengers)
      $('.' + type_passengers).val(new_passenger)

    }


    let passenger_adult   = Number($(obj).parents('.box-of-count-passenger-js').find('.adult-number-js .number-count-js').attr('data-number'))
    let passenger_child   = Number($(obj).parents('.box-of-count-passenger-js').find('.child-number-js .number-count-js').attr('data-number'))
    let passenger_infant  = Number($(obj).parents('.box-of-count-passenger-js').find('.infant-number-js .number-count-js').attr('data-number'))

    if (passenger_adult < passenger_infant && (passenger_infant > 0)) {
      console.log(['less if=>',passenger_adult,passenger_infant]);
      $(obj).parents('.box-of-count-passenger-js').find('.infant-number-js .number-count-js').attr('data-number',(passenger_adult )).text(passenger_adult )
      passenger_infant =passenger_adult ;
      $(obj).parents('.box-of-count-passenger-js').find('.infant-number-js').find('.add-flight-to-count-passenger-js').css('color','#ccc').css('border-color','#ccc')

    }

    $('.' + type_search+'-adult-js').val(passenger_adult);
    $('.' + type_search+'-child-js').val(passenger_child);
    $('.' + type_search+'-infant-js').val(passenger_infant);


    $(obj).parents('.box-of-count-passenger-js').find('.text-count-passenger-js').text(`${passenger_adult}   ${useXmltag("Adult")} ,  ${passenger_child}  ${useXmltag("Child")} ,  ${passenger_infant} ${useXmltag("Infant")}`)

    if (passenger_adult === passenger_infant && (passenger_infant > 0)) {
      console.log(['second if=>',$(obj).data('type')]);

      $(obj).parents('.box-of-count-passenger-js').find('.infant-number-js').find('.add-flight-to-count-passenger-js').css('color','#ccc').css('border-color','#ccc')
      return false;
    }

    if(total_count===9){
      console.log('after=>',total_count);
      $('.' + type_search + '-count-passenger-js').css('color','#ccc').css('border-color','#ccc');
    }


  }

}