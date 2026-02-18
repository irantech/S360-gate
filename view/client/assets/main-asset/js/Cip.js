let airportSearchTimeout;
let origin = null;
let flightType = null;

const cipAirportsList = [
   { AirportFa: 'فرودگاه امام خمینی', AirportEn: 'Imam Khomeini Airport', AirportAr: 'مطار الإمام الخميني', DepartureCode: 'IKA', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه مهرآباد', AirportEn: 'Mehrabad Airport', AirportAr: 'مطار مهرآباد', DepartureCode: 'THR', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه مشهد', AirportEn: 'Mashhad Airport', AirportAr: 'مطار مشهد', DepartureCode: 'MHD', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه اصفهان', AirportEn: 'Isfahan Airport', AirportAr: 'مطار أصفهان', DepartureCode: 'IFN', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه شیراز', AirportEn: 'Shiraz Airport', AirportAr: 'مطار شیراز', DepartureCode: 'SYZ', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه تبریز', AirportEn: 'Tabriz Airport', AirportAr: 'مطار تبریز', DepartureCode: 'TBZ', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه اهواز', AirportEn: 'Ahvaz Airport', AirportAr: 'مطار أهواز', DepartureCode: 'AWZ', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه کرمانشاه', AirportEn: 'Kermanshah Airport', AirportAr: 'مطار کرمانشاه', DepartureCode: 'KSH', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه اردبیل', AirportEn: 'Ardabil Airport', AirportAr: 'مطار أردبیل', DepartureCode: 'ADU', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه کیش', AirportEn: 'Kish Airport', AirportAr: 'مطار کیش', DepartureCode: 'KIH', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه اسخیپول آمستردام', AirportEn: 'Amsterdam Schiphol Airport', AirportAr: 'مطار سخيبول أمستردام', DepartureCode: 'AMS', CountryFa: 'هلند', CountryEn: 'Netherlands' },
   { AirportFa: 'فرودگاه سووارنابومی', AirportEn: 'Suvarnabhumi Airport', AirportAr: 'مطار سوفارنابومي', DepartureCode: 'BKK', CountryFa: 'تایلند', CountryEn: 'Thailand' },
   { AirportFa: 'فرودگاه حمد', AirportEn: 'Hamad International Airport', AirportAr: 'مطار حمد الدولي', DepartureCode: 'DOH', CountryFa: 'قطر', CountryEn: 'Qatar' },
   { AirportFa: 'فرودگاه دبی', AirportEn: 'Dubai International Airport', AirportAr: 'مطار دبي الدولي', DepartureCode: 'DXB', CountryFa: 'امارات', CountryEn: 'UAE' },
   { AirportFa: 'فرودگاه فرانکفورت', AirportEn: 'Frankfurt Airport', AirportAr: 'مطار فرانكفورت', DepartureCode: 'FRA', CountryFa: 'آلمان', CountryEn: 'Germany' },
   { AirportFa: 'فرودگاه استانبول', AirportEn: 'Istanbul Airport', AirportAr: 'مطار إسطنبول', DepartureCode: 'IST', CountryFa: 'ترکیه', CountryEn: 'Turkey' },
   { AirportFa: 'فرودگاه لس آنجلس', AirportEn: 'Los Angeles Airport', AirportAr: 'مطار لوس أنجلوس', DepartureCode: 'LAX', CountryFa: 'آمریکا', CountryEn: 'USA' },
   { AirportFa: 'هیترو لندن', AirportEn: 'London Heathrow Airport', AirportAr: 'مطار هيثرو لندن', DepartureCode: 'LHR', CountryFa: 'انگلستان', CountryEn: 'UK' },
   { AirportFa: 'فرودگاه مسقط', AirportEn: 'Muscat Airport', AirportAr: 'مطار مسقط', DepartureCode: 'MCT', CountryFa: 'عمان', CountryEn: 'Oman' },
   { AirportFa: 'فرودگاه خلیج فارس', AirportEn: 'Persian Gulf Airport', AirportAr: 'مطار الخليج الفارسي', DepartureCode: 'PGU', CountryFa: 'ایران', CountryEn: 'Iran' },
   { AirportFa: 'فرودگاه شارجه', AirportEn: 'Sharjah Airport', AirportAr: 'مطار الشارقة', DepartureCode: 'SHJ', CountryFa: 'امارات', CountryEn: 'UAE' },
];

// =============================================== start airport List ==============================================
// show airport all List
function showAirportList(inputElement) {
   let $listContainer = $('#list_airport_origin_cip');
   let $input = $(inputElement);
   let search_value = $input.val().trim().toLowerCase();

   let filtered = cipAirportsList.filter(function(item) {
      if (!search_value) return true;
      return item.AirportFa.includes(search_value) ||
          item.AirportEn.toLowerCase().includes(search_value) ||
          item.AirportAr.includes(search_value) ||
          item.DepartureCode.toLowerCase().includes(search_value);
   });

   let html = '';

   filtered.forEach(function(item) {
      let airport_name = (lang === 'fa') ? item.AirportFa :
          (lang === 'ar') ? (item.AirportAr || item.AirportEn) :
              item.AirportEn;

      let json_value = JSON.stringify(item);

      html += `<li onclick='onAirportSelect(${json_value}, this)'>
                   <div class='div_c_sr'>
                       <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                       <span class='c-text'>${airport_name}</span>
                       <em>(${item.DepartureCode})</em>
                   </div>
               </li>`;
   });

   if (!html) {
      $listContainer.html(`<ul><li>${error_flight}</li></ul>`).show();
   } else {
      $listContainer.html('<ul>' + html + '</ul>').show();
   }
}

// Close the list when we click outside
$(document).on('click', function(e) {
   let $target = $(e.target);
   if (!$target.closest('#route_origin_all, #list_airport_origin_cip').length) {
      $('#list_airport_origin_cip').hide();
   }
});
function initFlightSelect2() {
   let $select = $('#flightTypeSelect');

   if ($select.hasClass('select2-hidden-accessible')) {
      $select.select2('destroy');
   }

   $select.select2({
      placeholder: 'نوع پرواز / نوع سفر',
      width: '100%',
      allowClear: true
   });
}

$(document).ready(function () {
   initFlightSelect2();
});

$('#flightTypeSelect').on('select2:select', function () {
   flightType = $(this).val();  // مقدار انتخاب شده
   openDepartureDate();
});

function onAirportSelect(item, element) {
   // 🔥 ذخیره IATA فرودگاه
   origin = item.DepartureCode || item.Departure_Code || null;

   let airport_name = (lang === 'fa') ? item.AirportFa :
       (lang === 'ar') ? (item.AirportAr || item.AirportEn) :
           item.AirportEn;

   $('#route_origin_all').val(airport_name);
   $('#list_airport_origin_cip').hide().empty();

   let $flightSelect = $('#flightTypeSelect');

   if ($flightSelect.hasClass('select2-hidden-accessible')) {
      $flightSelect.select2('destroy');
   }

   $flightSelect.empty();
   $flightSelect.append(new Option('', '', true, true));

   let options = (item.CountryFa === 'ایران' || item.CountryEn === 'Iran')
       ? [
          { value: 'dom_inbound', text: 'پرواز داخلی  (ورودی به فرودگاه)' },
          { value: 'dom_outbound', text: 'پرواز داخلی  (خروجی از فرودگاه)' },
          { value: 'intl_inbound', text: 'پرواز بین المللی  (ورودی به فرودگاه)' },
          { value: 'intl_outbound', text: 'پرواز بین المللی  (خروجی از فرودگاه)' }
       ]
       : [
          { value: 'intl_inbound', text: 'پرواز بین المللی  (ورودی به فرودگاه)' },
          { value: 'intl_outbound', text: 'پرواز بین المللی  ( خروجی از فرودگاه)' }
       ];

   options.forEach(opt => {
      $flightSelect.append(new Option(opt.text, opt.value));
   });

   initFlightSelect2();

   setTimeout(() => {
      $flightSelect.select2('open');
   }, 100);
}
function openDepartureDate() {
   $('#dateForCip').datepicker('show');
}
// =============================================== end airport List ==============================================





// =============================================== start search ==============================================
// check data is not empty and create url
function checkSearchCipFieldsValues(...valuesWithNames) {
   // valuesWithNames = [ { value: origin, name: 'فرودگاه مبدا' }, { value: flightType, name: 'نوع پرواز' }, ... ]
   let items_name = [];

   valuesWithNames.forEach(item => {
      if (!item.value || item.value === "") {
         items_name.push(item.name);
      }
   });

   if (items_name.length) {
      let html_tags = "";
      items_name.forEach(name => {
         html_tags += '<span style="font-size:14px;" class="badge badge-danger-2">' + name + "</span>";
      });

      $.alert({
         title: useXmltag("Pleaseenterrequiredfields"),
         icon: "fa fa-cart-plus",
         content: html_tags,
         rtl: true,
         type: "red",
      });

      throw 'fix your entries.';
   }
}
function checkCountAdultVsInfantCip(number_adult, number_infant) {
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
function checkAdultAndChildCip(number_adult, number_child) {
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
function checkEmptyFieldCip(origin , TripType ,  FlightType) {
   if (
       origin === '' ||
       TripType == '' ||
       FlightType == ''

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
function checkCountAdultCip(number_adult) {
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
function dataSearchCip() {
   let number_adult = parseInt($('.internal-adult-js').val())
   let number_child = parseInt($('.internal-child-js').val())
   let number_infant = parseInt($('.internal-infant-js').val())
   let departure_date_cip = $('#dateForCip').val()
   checkSearchCipFieldsValues(
       { value: origin, name: 'فرودگاه مبدا' },
       { value: flightType, name: 'نوع پرواز' },
       { value: departure_date_cip, name: 'تاریخ ورود' }
   );
   let tripType = flightType === "intl_outbound" || flightType === "intl_inbound" ? "international" : "domestic"
   let flightTypeNew = (flightType === "dom_outbound" || flightType === "intl_outbound" ) ? "outbound" : "inbound"

   return {
      number_adult: number_adult,
      number_child: number_child,
      number_infant: number_infant,
      origin: origin,
      departure_date: departure_date_cip,
      TripType:tripType,
      flightType: flightTypeNew
   }
}

function searchFormCip(obj) {
   let count_passenger = `${obj.number_adult}-${obj.number_child}-${obj.number_infant}`
   let url = `${amadeusPathByLang}search-cip/${origin}/${obj.departure_date}/${obj.flightType}&${obj.TripType}/${count_passenger}`;
   const form = $('#cip_form')[0];

   let target = form.target || '_self';

   window.open(url, target);

}

function searchCip() {
   let no_error = true
   let obj_url = dataSearchCip()
   no_error = checkCountAdultCip(obj_url.number_adult)
   if (no_error) {
      no_error = checkCountAdultVsInfantCip(
          obj_url.number_adult,
          obj_url.number_infant,
      )
   }
   if (no_error) {
      no_error = checkAdultAndChildCip(obj_url.number_adult, obj_url.number_child)
   }
   if (no_error) {
      no_error = checkEmptyFieldCip(
          obj_url.origin,
          obj_url.FlightType,
          obj_url.TripType
      )
   }
   if (no_error) {
      searchFormCip(obj_url)

   }


}

// =============================================== end search ==============================================
