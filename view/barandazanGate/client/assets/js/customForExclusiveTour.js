let originalData = [];
let disaggregateData = {};
let selectedOptions = {
   roomPackage: null,
   outboundFlight: null,
   returnFlight: null
};
let arrivalcityCode='';
let passengerCn = 1;
let source_id = '';
let pendingEntertainmentSelection = null;
let request_number = '';
let finalPassengers;
let agency_credit;
let total_price;

// اضافه کردن استایل‌های validation به صورت dynamic
(function() {
   if (!document.getElementById('validation-styles')) {
      const style = document.createElement('style');
      style.id = 'validation-styles';
      style.textContent = `
         .field-error {
            border: 2px solid #dc3545 !important;
            background-color: #fff5f5 !important;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.3) !important;
         }
         .field-error:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.5) !important;
         }
         .select2-container.field-error .select2-selection {
            border: 2px solid #dc3545 !important;
            background-color: #fff5f5 !important;
         }
         .text-danger {
            color: #dc3545 !important;
            font-weight: 500;
         }
      `;
      document.head.appendChild(style);
   }
})();

function getCurrentTime() {
   let now = new Date();
   return now.toLocaleTimeString('en-US', { hour12: false });
}

function GetPackageDetail(requestNumber, sourceId, hotelId, agencyCredit) {
   $('#resultRoomHotel').remove();

   $(".content-detailHotel").html(`
        <div id='resultRoomHotel'>
            <div class='roomHotelLocal'>
                <div class='loader-box-user-buy'>
                    <span></span>
                    <span>${useXmltag("Loading")}</span>
                </div>
            </div>
        </div>
    `)

   source_id = sourceId
   request_number = requestNumber
   agency_credit = agencyCredit

   let data = {
      className: "exclusiveTour",
      method: "GetPackageDetail",
      requestNumber: requestNumber,
      sourceId: sourceId,
      hotelId: hotelId,
   }

   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "json",
      data: JSON.stringify(data),
      success: function(response) {
         arrivalcityCode = response?.Arrival_city_code;

         // Store original data
         originalData = response?.Packages;

         // Separate/disaggregate data
         disaggregateData = dataSeparator(response?.Packages)


         // Render components after data is ready
         renderAllComponents()

         // انتخاب پیش‌فرض اولین پکیج با تاخیر کوچک
         setTimeout(() => {
            selectDefaultPackage()

            // چک کردن عملیات معلق بعد از لاگین (با تاخیر بیشتر)
            setTimeout(() => {
               checkPendingActionAfterLogin()
            }, 200)
         }, 100)
      },
      error: function(error) {
         let msg = useXmltag("NoAvailableReserve")
         $.alert({
            title: useXmltag("Error"),
            content: msg,
            rtl: true,
            type: "red",
         })
         $(".RoomsContainer").append(`
                <div class='hotel-detail-room-list'>
                    <div class='hotel-rooms-item'>
                        <div class='hotel-rooms-row justify-content-center'>
                            <p class='mt-3 alert alert-danger'>${msg}</p>
                        </div>
                    </div>
                </div>
            `)
      },
      complete: function() {
         $("#resultRoomHotel").hide()
      },
   })
}

// Modified dataSeparator - فقط FlightNo برای یونیک بودن
function dataSeparator(data) {
   const roomPackagesMap = new Map()
   const outputRoutesMap = new Map()
   const returnRoutesMap = new Map()

   data.forEach((item, packageIndex) => {
      // Process Room Packages - Group rooms by package
      if (item.Hotel?.Rooms && item.Hotel.Rooms.length > 0) {
         const roomIds = item.Hotel.Rooms.map(r => r.Id).sort().join('-');
         const packageKey = `${item.Hotel.Id}_${roomIds}`;

         if (!roomPackagesMap.has(packageKey)) {
            roomPackagesMap.set(packageKey, {
               packageIndex: packageIndex,
               hotelId: item.Hotel.Id,
               hotelName: item.Hotel.Name,
               rooms: item.Hotel.Rooms,
               packageKey: packageKey,
               availableInRecords: [packageIndex]
            });
         } else {
            const existingPackage = roomPackagesMap.get(packageKey);
            existingPackage.availableInRecords.push(packageIndex);
            roomPackagesMap.set(packageKey, existingPackage);
         }
      }

      // Process output routes - فقط FlightNo
      if (item.OutputRoutes) {
         const flightNo = item.OutputRoutes.FlightNo;
         if (!outputRoutesMap.has(flightNo)) {
            outputRoutesMap.set(flightNo, item.OutputRoutes);
         }
      }

      // Process return routes - فقط FlightNo
      if (item.ReturnRoutes) {
         const flightNo = item.ReturnRoutes.FlightNo;
         if (!returnRoutesMap.has(flightNo)) {
            returnRoutesMap.set(flightNo, item.ReturnRoutes);
         }
      }
   });

   $('#resultRoomHotel').hide();

   return {
      uniqueRoomPackages: Array.from(roomPackagesMap.values()),
      uniqueOutputRoutes: Array.from(outputRoutesMap.values()),
      uniqueReturnRoutes: Array.from(returnRoutesMap.values())
   };
}

// Create containers for components
function createContainers() {
   const html = `
        <div id="flights-wrapper" class="flights-wrapper row">
            <div class="arrow-text">
                <span>انتخاب اتاق</span>
            </div>
            <div style="position: relative; width: 100%;">
                     <button class="rooms-arrow right-arrow" onclick="scrollRooms('right')">
                         <i class="fas fa-chevron-right"></i>
                     </button>
                <div id="rooms-container" class="rooms-container col-12"></div>
                     <button class="rooms-arrow left-arrow" onclick="scrollRooms('left')">
                         <i class="fas fa-chevron-left"></i>
                     </button>
            </div>

            <div id="outbound-flights-container" class="flights-container"></div>
            <div id="return-flights-container" class="flights-container"></div>
            
            
            <div class="entertainment-section">
                <div class="section-title-entertainment">خدمات اضافه</div>
                <div style="position: relative; width: 100%;">
                    <button class="ent-arrow right-arrow" onclick="scrollEntertainment('right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
            
                    <div id="entertainment-container" class="entertainment-container"></div>
            
                    <button class="ent-arrow left-arrow" onclick="scrollEntertainment('left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
         </div>

        </div>
    `;
   $('.content-detailHotel').append(html);
}





function getUrlWithoutLang() {
   return amadeusPath
}

function getLang() {
   return lang
}

// Create flight boxes - همه پرواز‌ها فعال هستند
function createFlightBoxes(uniqueFlights, containerId, flightType) {
   const container = document.getElementById(containerId);

   // 1) یک wrapper بساز و قبل از container قرار بده
   wrapper = document.createElement('div');
   wrapper.className = 'col-12 col-lg-6';
   // قرار دادن wrapper به جای container و سپس انتقال container داخل wrapper
   container.parentElement.insertBefore(wrapper, container);
   wrapper.appendChild(container);

   // 2) مطمئن شو هدر فقط یک‌بار ساخته میشه
   const sectionHeader = `
      <div class="flight-section-header">
        <h2>${flightType === 'output' ? 'پروازهای رفت' : 'پروازهای برگشت'}</h2>
      </div>
    `;
   // هدر را قبل از کانتینر داخل wrapper قرار می‌دهیم (کنار هم)
   wrapper.insertAdjacentHTML('afterbegin', sectionHeader);


   // حالا محتویات flight box ها را داخل container قرار بده
   uniqueFlights.forEach((flight, index) => {
      const flightBox = `
      <div class="flight-box ${flightType}-flight"
           data-flight-type="${flightType}"
           data-flight-index="${index}"
           data-flight-no="${flight.FlightNo}"
           onclick="selectFlight('${flightType}', ${index})">
        <!-- ... بقیه html پرواز ... -->
        <div class="flight-header">
          <div class="airline-info ${flight.Airline.Code}">
            <div class="airline-logo logo-airline-ico"></div>
          </div>
        </div>
        <div class="flight-content">
          <div class="airline-details">
            <span class="airline-name">${flight.Airline.Name}</span>
            <span class="flight-number">[${flight.FlightNo}]</span>
          </div>
          <div class="flight-route-section">
            <div class="route-point departure"><span class="time">${flight.DepartureTime}</span></div>
            <div class="flight-duration"><div class="route-line"></div></div>
            <div class="route-point arrival"><span class="time">${flight.ArrivalTime}</span></div>
          </div>
        </div>
      </div>
    `;
      container.insertAdjacentHTML('beforeend', flightBox);
   });
}

// Selection handlers
function selectFlight(type, index) {
   // Remove previous selections
   document.querySelectorAll(`.${type}-flight`).forEach(box => {
      box.classList.remove('selected');
   });

   // Add selected class
   const selectedBox = document.querySelector(`[data-flight-type="${type}"][data-flight-index="${index}"]`);
   selectedBox.classList.add('selected');

   // Store selection
   if (type === 'output') {
      selectedOptions.outboundFlight = disaggregateData.uniqueOutputRoutes[index];
   } else {
      selectedOptions.returnFlight = disaggregateData.uniqueReturnRoutes[index];
   }

   checkAndFindMatch();
}

// Helper function - فقط FlightNo چک میشه
function matchFlights(flight1, flight2) {
   if (!flight1 || !flight2) return false;
   return flight1.FlightNo === flight2.FlightNo;
}

// متغیر سراسری برای ذخیره قیمت‌های قبلی
let previousPrices = {
   base: 0,   // پرواز + هتل
   ent: 0,    // خدمات اضافه
   final: 0   // base + ent
};


// تابع انیمیشن counter برای قیمت‌ها (فقط شمارنده بدون افکت رنگی)
function animateCounter(element, start, end, duration = 800) {
   if (!element) return;

   // ⛔ cancel token
   const token = (Number(element.dataset.animToken || 0) + 1);
   element.dataset.animToken = String(token);

   const suffix = element.dataset.suffix || "";
   const range = end - start;
   const startTime = performance.now();

   function updateCounter(currentTime) {
      // اگر توکن عوض شده یعنی کسی cancel کرده
      if (String(token) !== String(element.dataset.animToken)) return;

      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeOutQuart = 1 - Math.pow(1 - progress, 4);
      const current = Math.floor(start + (range * easeOutQuart));

      element.textContent = current.toLocaleString("fa-IR") + suffix;

      if (progress < 1) requestAnimationFrame(updateCounter);
      else element.textContent = end.toLocaleString("fa-IR") + suffix;
   }

   requestAnimationFrame(updateCounter);
}

// helper برای cancel کردن سریع هر counter
function stopCounter(el) {
   if (!el) return;
   el.dataset.animToken = String(Number(el.dataset.animToken || 0) + 1);
}



// Display matching record
function displayMatchingRecord(record) {

   // --- ۱) استخراج قیمت‌ها و تبدیل به ریال ---
   const newFlightPrice = Math.floor(record.TotalFlightPrice || 0);
   const newHotelPrice  = Math.floor(record.TotalHotelPrice  || 0);
   const newTotalPrice  = Math.floor(record.TotalPrice       || 0);
   passengerCn = getPassengerCountFromRecord(record);


   const baseFormatted = newTotalPrice.toLocaleString("fa-IR");


   // --- ۲) ساخت HTML سایدبار ---
   const sidebarHTML = `
      <aside class="passengerDetailReservationTour_aside">

         <h2 class="passengerDetailReservationTour_aside_title_main">
            پکیج انتخابی شما
         </h2>

         <p class="aside-description">
            با کلیک بر روی اتاق‌ها و پروازهای دیگر انتخاب خود را تغییر دهید
         </p>
<div class="aside-column">
         <div class="passengerDetailReservationTour_aside_box">

            <!-- اطلاعات اتاق و هتل -->
            <div class="selected-package-info">
                <p class="hotel-name">
                    <strong>${record.Hotel.Name}</strong>
                </p>
                <div class="hotel-dates-summary">
                   <div class="date-row">
                       <span class="date-label">تاریخ رفت :</span>
                       <span class="date-value" dir="ltr">
                           ${record.OutputRoutes.PersianDepartureDate}
                       </span>
                   </div>
               
                   <div class="date-row">
                       <span class="date-label">تاریخ برگشت :</span>
                       <span class="date-value" dir="ltr">
                           ${record.ReturnRoutes.PersianDepartureDate}
                       </span>
                   </div>
               </div>
            
                <div class="rooms-row">
                    ${record.Hotel.Rooms.map(
      room => `
                        <div class="room-card">
                            <p class="room-title">${room.Name} (${room.Type})</p>
                            <small class="room-details">
                                ${room.Adults} بزرگسال
                                ${room.Extrabed > 0 ? ` - ${room.Extrabed} تخت اضافه` : ""}
                                ${room.Ages?.length > 0 ? ` - ${room.Ages.length} کودک` : ""}
                            </small>
                        </div>
                    `
   ).join("")}
                </div>
            </div>


            <!-- پرواز رفت -->
               <div>
               <h4 class="flight-title">پرواز رفت</h4>

                <div class="flight-info-row flight-single-line">
                    <div class="flight-info-item flight-main">
                        <span class="airline-name">
                            ${record.OutputRoutes.Airline.Name}
                        </span>
                        <span class="flight-no">
                            (${record.OutputRoutes.FlightNo})
                        </span>
                        <span class="separator"> </span>
                        <span class="datetime-label">تاریخ و ساعت :</span>
                        <span class="datetime-value" dir="ltr">
                            (${record.OutputRoutes.DepartureTime})
                            ${record.OutputRoutes.PersianDepartureDate}
                            
                        </span>
                    </div>
                </div>
            </div>


            <!-- پرواز برگشت -->
            <div>
             <h4 class="flight-title">پرواز برگشت</h4>
         
             <div class="flight-info-row flight-single-line">
                 <div class="flight-info-item flight-main">
                     <span class="airline-name">
                         ${record.ReturnRoutes.Airline.Name}
                     </span>
                     <span class="flight-no">
                         (${record.ReturnRoutes.FlightNo})
                     </span>
                     <span class="separator"></span>
                     <span class="datetime-label">تاریخ و ساعت :</span>
                     <span class="datetime-value" dir="ltr">
                         (${record.ReturnRoutes.DepartureTime})
                         ${record.ReturnRoutes.PersianDepartureDate}
                     </span>
                 </div>
             </div>
            </div>

              <h4 class="flight-title">خدمات اضافه</h4>
            
              <div class="flight-info-row">
                <div class="flight-info-item" id="entertainment-summary-items">خدماتی انتخاب نشده است</div>
              </div>
            </div>
            <!-- 🔥 بخش قیمت‌ها -->
            <div class="passengerDetailReservationTour_aside_lastBox">

               <!-- قیمت پرواز + هتل -->
                <div id="final-price-box" class="price-minimal">

                  <div class="row">
                     <span>قیمت پرواز + هتل</span>
                     <span class="value" data-price-type="total-base">0</span>
                  </div>

               <div class="row">
                  <span>قیمت خدمات اضافه</span>
                  <span class="value" data-price-type="entertain">0</span>
               </div>
               
                  <div class="row total">
                     <span>جمع کل:</span>
                     <span class="value" data-price-type="final-total" data-suffix="">0</span>
                  </div>
               
               </div>

                  
                  <button onclick="proceedWithSelection(event)">
                     مرحله بعد (ورود اسامی)
                  </button>

            </div>
         </div>

         </div>
      </aside>
   `;

   function getPassengerCountFromRecord(record) {
      if (!record?.Hotel?.Rooms) return 1;

      let total = 0;

      record.Hotel.Rooms.forEach(room => {
         const adults = Number(room.Adults) || 0;
         // بین کودک و نوزاد تفاوت نمی‌ذاریم: همه Ages یکسان حساب می‌شوند
         const children = Array.isArray(room.Ages) ? room.Ages.length : 0;

         total += adults + children;
      });

      // اگر به هر دلیلی 0 شد، حداقل 1 در نظر بگیر
      return total > 0 ? total : 1;
   }


   const sidebarDetailHotel = document.querySelector(".sidebar-detailHotel");
   if (sidebarDetailHotel) sidebarDetailHotel.innerHTML = sidebarHTML;

   // --- ۳) انیمیشن شمارش قیمت‌ها (خیلی مهم!) ---
   setTimeout(() => {
      const totalBaseEl  = document.querySelector('[data-price-type="total-base"]');
      const entEl        = document.querySelector('[data-price-type="entertain"]');
      const finalTotalEl = document.querySelector('[data-price-type="final-total"]');
      const hasPendingEntertainment =
         pendingEntertainmentSelection &&
         pendingEntertainmentSelection.length;

      let entPrice = 0;

      if (selectedEntertainment.size > 0) {
         entPrice = calculateEntertainmentPrice().rialTotal;
      } else if (previousPrices.ent > 0) {
         entPrice = previousPrices.ent;
      }



      const newBase  = newTotalPrice;
      const newEnt   = entPrice;
      const newFinal = newBase + newEnt;


      // انیمیشن‌ها
      if (totalBaseEl)  animateCounter(totalBaseEl,  previousPrices.base,  newBase);
      if (entEl)        animateCounter(entEl,        previousPrices.ent,   newEnt);
      if (finalTotalEl) animateCounter(finalTotalEl, previousPrices.final, newFinal);

      updateEntertainmentSummaryInSidebar();

      // ذخیره برای دفعات بعد
      previousPrices.base  = newBase;
      previousPrices.ent   = newEnt;
      previousPrices.final = newFinal;

   }, 50);

}



// Show continue button
function showContinueButton(record) {
   // ذخیره رکورد انتخابی برای استفاده بعدی
   window.finalSelectedRecord = record;
}

// Reset selections
function resetSelections() {
   selectedOptions = {
      roomPackage: null,
      outboundFlight: null,
      returnFlight: null
   };

   // Reset کردن قیمت‌های قبلی
   previousPrices = {
      base: 0,
      ent: 0,
      final: 0,
   };

   document.querySelectorAll('.selected').forEach(el => {
      el.classList.remove('selected');
   });

   // بازگرداندن sidebar به حالت اولیه
   const sidebarHTML = `
      <aside class="passengerDetailReservationTour_aside">
         <h2 class="passengerDetailReservationTour_aside_title_main">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
               <path d="M472.8 168.4C525.1 221.4 525.1 306.6 472.8 359.6L360.8 472.9C351.5 482.3 336.3 482.4 326.9 473.1C317.4 463.8 317.4 448.6 326.7 439.1L438.6 325.9C472.5 291.6 472.5 236.4 438.6 202.1L310.9 72.87C301.5 63.44 301.6 48.25 311.1 38.93C320.5 29.61 335.7 29.7 344.1 39.13L472.8 168.4zM144 143.1C144 161.7 129.7 175.1 112 175.1C94.33 175.1 80 161.7 80 143.1C80 126.3 94.33 111.1 112 111.1C129.7 111.1 144 126.3 144 143.1zM410.7 218.7C435.7 243.7 435.7 284.3 410.7 309.3L277.3 442.7C252.3 467.7 211.7 467.7 186.7 442.7L18.75 274.7C6.743 262.7 0 246.5 0 229.5V80C0 53.49 21.49 32 48 32H197.5C214.5 32 230.7 38.74 242.7 50.75L410.7 218.7zM48 79.1V229.5C48 233.7 49.69 237.8 52.69 240.8L220.7 408.8C226.9 415.1 237.1 415.1 243.3 408.8L376.8 275.3C383.1 269.1 383.1 258.9 376.8 252.7L208.8 84.69C205.8 81.69 201.7 79.1 197.5 79.1L48 79.1z"/>
            </svg>
            صورتحساب
         </h2>
         <div class="passengerDetailReservationTour_aside_box">
            <h2 class="passengerDetailReservationTour_aside_title">
               تور اختصاصی
            </h2>
            <div class="passengerDetailReservationTour_aside_lastBox">
               <div class="price hotel">
                  <span>قیمت پرواز:</span>
                  <span>0 </span>
               </div>
               <div class="price flight">
                  <span>قیمت هتل:</span>
                  <span>0 </span>
               </div>
               <div class="price total">
                  <span>قیمت کل:</span>
                  <span>0 <p>ریال</p></span>
               </div>
               <div class="parent_next_tour_n_">
                  <div class="next_tour_n_">
                     <div class="passengersDetailLocal_next">
                        <input value="انتخاب مجدد" type="button" class="btn-back s-u-submit-passenger s-u-select-flight-change" onclick="resetSelections()">
                     </div>
                  </div>
                  <div class="next_tour_n_">
                     <div class="passengersDetailLocal_next">
                        <input value="ادامه با این پکیج" type="button" class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color" onclick="proceedWithSelection(event)">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </aside>
   `;

   const sidebarDetailHotel = document.querySelector('.sidebar-detailHotel');
   if (sidebarDetailHotel) {
      sidebarDetailHotel.innerHTML = sidebarHTML;
   }
}

// Proceed with selection
// اضافه کردن این تابع به جای proceedWithSelection قبلی
function proceedWithSelection() {
   const record = window.finalSelectedRecord;
   let isLogin = window.isUserLoggedIn;
   let show_popup = document.getElementById('isShowLoginPopup').value ;

   const selectedEntertainmentIndices = Array.from(selectedEntertainment);

   // اگر کاربر لاگین نیست و پاپ‌آپ فعال است
   if(show_popup === '1' && !isLogin){
      // ذخیره وضعیت در localStorage برای ادامه بعد از لاگین
      localStorage.setItem('pendingExclusiveTourAction', JSON.stringify({
         action: 'proceedWithSelection',
         selectedPackageIndex: disaggregateData.uniqueRoomPackages.findIndex(
            p => p.packageKey === selectedOptions.roomPackage?.packageKey
         ),
         selectedOutputFlightIndex: disaggregateData.uniqueOutputRoutes.findIndex(
            f => f.FlightNo === selectedOptions.outboundFlight?.FlightNo
         ),
         selectedReturnFlightIndex: disaggregateData.uniqueReturnRoutes.findIndex(
            f => f.FlightNo === selectedOptions.returnFlight?.FlightNo
         ),
         selectedEntertainmentIndices: selectedEntertainmentIndices   // 👈 این خط جدید
      }));
      setTimeout(function(){
         document.getElementsByClassName('cd-user-modal')[0].classList.add("is-visible");
      }, 500);

      return;
   }

   // مخفی کردن بخش انتخاب
   const flightsWrapper = document.getElementById('flights-wrapper');
   const matchingResult = document.getElementById('matching-result');
   const continueWrapper = document.getElementById('continue-wrapper');

   if (flightsWrapper) flightsWrapper.style.display = 'none';
   if (matchingResult) matchingResult.style.display = 'none';
   if (continueWrapper) continueWrapper.style.display = 'none';

   $('.passengerDetailReservationTour_aside > p').hide();


   // ذخیره محتوای قبلی sidebar و پاک کردنش
   const sidebarDetailHotel = document.querySelector('.sidebar-detailHotel');
   if (sidebarDetailHotel) {
      // ذخیره محتوای اصلی برای بازگشت
      if (!window.originalSidebarContent) {
         window.originalSidebarContent = sidebarDetailHotel.innerHTML;
      }
      // پاک کردن محتوای sidebar
      // sidebarDetailHotel.innerHTML = '';
   }

   // نمایش فرم اطلاعات مسافرین
   showPassengerForm(record);
   goToNextStep();
}
function goToNextStep() {
   const $current = $('#steps .step.active');
   if (!$current.length) return;

   /* 1️⃣ step فعلی → done */
   $current
      .removeClass('active')
      .addClass('done');

   /* 2️⃣ جایگزینی آیکن با تیک */
   const $iconWrapper = $current.find('span').first();

   if (!$iconWrapper.find('.fa-check').length) {
      $iconWrapper.html('<i class="fa fa-check"></i>');
   }

   /* 3️⃣ separator بعدی */
   $current.next('.separator').addClass('donetoactive');

   /* 4️⃣ step بعدی → active */
   const $nextStep = $current.nextAll('.step').first();
   if ($nextStep.length) {
      $nextStep.addClass('active');
   }
}



// محاسبه تعداد کل مسافرین
function calculateTotalPassengers(record) {
   let totalAdults = 0;
   let totalChildren = 0;
   let totalInfants = 0;

   record.Hotel.Rooms.forEach(room => {
      totalAdults += room.Adults || 0;
      if (room.Ages && room.Ages.length > 0) {
         room.Ages.forEach(age => {
            if (age < 2) {
               totalInfants++;
            } else {
               totalChildren++;
            }
         });
      }
   });

   return { totalAdults, totalChildren, totalInfants };
}

// نمایش فرم اطلاعات مسافرین
function showPassengerForm(record) {
   const passengers = calculateTotalPassengers(record);
   let passengerCounter = 0;

   // ساخت آرایه مسافران با شماره‌گذاری صحیح
   let passengersHTML = '';

   // محاسبه تعداد کل مسافران
   const totalPassengers = passengers.totalAdults + passengers.totalChildren + passengers.totalInfants;

   // بزرگسالان
   for (let i = 1; i <= passengers.totalAdults; i++) {
      passengerCounter++;
      passengersHTML += createPassengerFields(passengerCounter, 'adult', totalPassengers);
   }

   // کودکان
   for (let i = 1; i <= passengers.totalChildren; i++) {
      passengerCounter++;
      passengersHTML += createPassengerFields(passengerCounter, 'child', totalPassengers);
   }

   // نوزادان
   for (let i = 1; i <= passengers.totalInfants; i++) {
      passengerCounter++;
      passengersHTML += createPassengerFields(passengerCounter, 'infant', totalPassengers);
   }



   const mainContentHTML = `
            <!-- محتوای اصلی -->
            <div class="passenger-form-main-content">

               <!-- خلاصه سفارش (اطلاعات پکیج) -->

               <!-- عنوان فرم مسافرین -->
               <h2 class="passengerDetailReservationTour_title">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                     <path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z"/>
                  </svg>
                  اطلاعات مسافرین
               </h2>

               <!-- فرم مسافرین -->
               <div class="passengerDetailReservationTour_users">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                     ${passengersHTML}
                  </div>
               </div>

            </div>
   `;

   const btnNextStep = `
                           <div class="parent_next_tour_n_">
                  <div class="next_tour_n_">
            <div class="passengersDetailLocal_next">
               <input value="بازگشت" type="button" class="btn-back s-u-submit-passenger s-u-select-flight-change bg-secondary" onclick="backToSelection()">
                  </div>
               </div>
         <div class="next_tour_n_">
            <div class="passengersDetailLocal_next">
               <input value="مرحله بعد (پیش فاکتور)" type="button" class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color" onclick="handlePassengerFormSubmit(event)">
            </div>
         </div>
         </div>
   `;

   // اضافه کردن محتوا به جای مناسب
   $('.content-detailHotel').append(mainContentHTML);
   $('.passengerDetailReservationTour_aside_lastBox button').hide();
   $('.passengerDetailReservationTour_aside_lastBox').append(btnNextStep);

   // اضافه کردن sidebar به sidebar-detailHotel
   const sidebarDetailHotel = document.querySelector('.sidebar-detailHotel');
   if (sidebarDetailHotel) {
      // sidebarDetailHotel.innerHTML = sidebarHTML;
   }

   // فراخوانی تابع passengerFormInit برای نمایش فیلدهای صحیح
   if (typeof passengerFormInit === 'function') {
      passengerFormInit(totalPassengers.toString());
   }

   // Initialize select2 و datepicker ها بعد از render
   setTimeout(() => {
      // Initialize select2 برای تمام selectها
      $('.select2').select2({
         width: '100%',
         dir: 'rtl'
      });

      // Initialize تقویم‌ها
      initializeJDateCalendars();
   }, 300);
}
$('#internal-arrival-date-exclusive-tour-js').datepicker({
   onSelect: function (dateText) {

      $return
         .prop('readonly', false)
         .datepicker('option', 'minDate', dateText)
         .datepicker('option', 'showRange', true) // ✅ درست
         .datepicker('show');
   }
});


// تابع initialize کردن تقویم‌ها
function initializeJDateCalendars() {

   // ابتدا تقویم‌های میلادی را با jQuery UI Datepicker initialize می‌کنیم
   if (typeof $.fn.datepicker !== 'undefined') {

      // حذف کلاس‌های shamsi از input های gregorian تا jdate روی آن‌ها کار نکند
      $('.gregorianAdultBirthdayCalendar, .gregorianChildBirthdayCalendar, .gregorianInfantBirthdayCalendar, .gregorianFromTodayCalendar').each(function() {
         $(this).removeClass('shamsiBirthdayCalendar shamsiChildBirthdayCalendar shamsiInfantBirthdayCalendar');
         $(this).addClass('ignore-jdate'); // علامت‌گذاری برای jdate که روی این input کار نکند

         // حذف هر گونه data که jdate ممکن است اضافه کرده باشد
         $(this).removeData('jdate');
         $(this).removeData('datepicker');

         // حذف هر گونه event handler که jdate ممکن است اضافه کرده باشد
         $(this).off('click.jdate focus.jdate');
      });

      // تنظیمات خاص برای تقویم‌های میلادی (به صورت object)
      var gregorianDatepickerOptions = {
         dateFormat: 'yy-mm-dd',
         showButtonPanel: true,
         changeYear: true,
         changeMonth: true,
         // Force English locale
         monthNames: ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'],
         monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
         dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
         dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
         dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
         firstDay: 0
      };

      // محاسبه تاریخ‌های مرجع برای رنج سنی
      var today = new Date();
      var maxDateAdult = new Date(today.getFullYear() - 12, today.getMonth(), today.getDate()); // حداکثر 12 سال پیش (بزرگسال)
      var maxDateChild = new Date(today.getFullYear() - 2, today.getMonth(), today.getDate()); // حداکثر 2 سال پیش (کودک)
      var minDateChild = new Date(today.getFullYear() - 12, today.getMonth(), today.getDate()); // حداقل 12 سال پیش (کودک)
      var minDateInfant = new Date(today.getFullYear() - 2, today.getMonth(), today.getDate()); // حداقل 2 سال پیش (نوزاد)

      // تاریخ تولد بزرگسالان میلادی (بیشتر از 12 سال)
      $('.gregorianAdultBirthdayCalendar').each(function() {
         var $input = $(this);

         try {
            $input.datepicker('destroy');
         } catch(e) {}

         $input.datepicker($.extend({}, gregorianDatepickerOptions, {
            yearRange: '-100:-12',
            maxDate: maxDateAdult,
            defaultDate: '-25y'
         }));

         // Force باز کردن jQuery UI datepicker در هنگام click
         $input.on('click.gregorian focus.gregorian', function(e) {
            e.stopPropagation();
            $(this).datepicker('show');
         });
      });

      // تاریخ تولد کودکان میلادی (بین 2 تا 12 سال)
      $('.gregorianChildBirthdayCalendar').each(function() {
         var $input = $(this);

         try {
            $input.datepicker('destroy');
         } catch(e) {}

         $input.datepicker($.extend({}, gregorianDatepickerOptions, {
            yearRange: '-12:-2',
            minDate: minDateChild,
            maxDate: maxDateChild
         }));

         $input.on('click.gregorian focus.gregorian', function(e) {
            e.stopPropagation();
            $(this).datepicker('show');
         });
      });

      // تاریخ تولد نوزادان میلادی (کمتر از 2 سال)
      $('.gregorianInfantBirthdayCalendar').each(function() {
         var $input = $(this);

         try {
            $input.datepicker('destroy');
         } catch(e) {}

         $input.datepicker($.extend({}, gregorianDatepickerOptions, {
            yearRange: '-2:+0',
            minDate: minDateInfant,
            maxDate: today
         }));

         $input.on('click.gregorian focus.gregorian', function(e) {
            e.stopPropagation();
            $(this).datepicker('show');
         });
      });

      // تاریخ انقضای پاسپورت (از امروز به بعد) میلادی
      $('.gregorianFromTodayCalendar').each(function() {
         var $input = $(this);

         try {
            $input.datepicker('destroy');
         } catch(e) {}

         $input.datepicker($.extend({}, gregorianDatepickerOptions, {
            minDate: new Date(),
            yearRange: '+0:+10'
         }));

         $input.on('click.gregorian focus.gregorian', function(e) {
            e.stopPropagation();
            $(this).datepicker('show');
         });
      });

   } else {
   }

   // حالا تقویم‌های شمسی (Persian) - استفاده از jdate

   // چک کردن وجود jdate
   if (typeof $.fn.jDatepicker === 'undefined') {

      // روش جایگزین: استفاده از پکیج persian-datepicker اگر در دسترس باشد
      if (typeof $.fn.persianDatepicker !== 'undefined') {

         // تاریخ تولد بزرگسالان شمسی (بیشتر از 12 سال)
         $('.shamsiBirthdayCalendar').each(function() {
            $(this).persianDatepicker({
               observer: true,
               format: 'YYYY-MM-DD',
               altField: $(this),
               altFormat: 'YYYY-MM-DD',
               maxDate: new persianDate().subtract('year', 12).valueOf(),
               minDate: new persianDate().subtract('year', 100).valueOf(),
               initialValue: false,
               autoClose: true
            });
         });

         // تاریخ تولد کودکان شمسی (بین 2 تا 12 سال)
         $('.shamsiChildBirthdayCalendar').each(function() {
            $(this).persianDatepicker({
               observer: true,
               format: 'YYYY-MM-DD',
               altField: $(this),
               altFormat: 'YYYY-MM-DD',
               maxDate: new persianDate().subtract('year', 2).valueOf(),
               minDate: new persianDate().subtract('year', 12).valueOf(),
               initialValue: false,
               autoClose: true
            });
         });

         // تاریخ تولد نوزادان شمسی (کمتر از 2 سال)
         $('.shamsiInfantBirthdayCalendar').each(function() {
            $(this).persianDatepicker({
               observer: true,
               format: 'YYYY-MM-DD',
               altField: $(this),
               altFormat: 'YYYY-MM-DD',
               maxDate: new persianDate().valueOf(),
               minDate: new persianDate().subtract('year', 2).valueOf(),
               initialValue: false,
               autoClose: true
            });
         });
      } else {
      }
   } else {
      // استفاده از jdate

      // تاریخ تولد بزرگسالان شمسی (بیشتر از 12 سال)
      $('.shamsiBirthdayCalendar').each(function() {
         $(this).jDatepicker({
            dateFormat: 'YYYY-MM-DD',
            maxDate: 'today -12y',
            minDate: 'today -100y',
            showTodayBtn: false
         });
      });

      // تاریخ تولد کودکان شمسی (بین 2 تا 12 سال)
      $('.shamsiChildBirthdayCalendar').each(function() {
         $(this).jDatepicker({
            dateFormat: 'YYYY-MM-DD',
            maxDate: 'today -2y',
            minDate: 'today -12y',
            showTodayBtn: false
         });
      });

      // تاریخ تولد نوزادان شمسی (کمتر از 2 سال)
      $('.shamsiInfantBirthdayCalendar').each(function() {
         $(this).jDatepicker({
            dateFormat: 'YYYY-MM-DD',
            maxDate: 'today',
            minDate: 'today -2y',
            showTodayBtn: false
         });
      });
   }

}

// ساخت فیلدهای هر مسافر
function createPassengerFields(number, type, totalPassengers) {
   const passengerAge = type === 'adult' ? 'adt' : (type === 'child' ? 'chd' : 'inf');

   // متن label بر اساس نوع مسافر
   let typeLabel = '';
   if (passengerAge === 'adt') {
      typeLabel = typeof useXmltag === 'function' ? useXmltag('Adult') : 'بزرگسال';
   } else if (passengerAge === 'chd') {
      typeLabel = typeof useXmltag === 'function' ? useXmltag('Child') : 'کودک';
   } else {
      typeLabel = typeof useXmltag === 'function' ? useXmltag('InfantOrBedlessChild') : 'نوزاد';
   }

   const classNameBirthdayShamsi = type === 'adult' ? 'shamsiBirthdayCalendar' : (type === 'child' ? 'shamsiChildBirthdayCalendar' : 'shamsiInfantBirthdayCalendar');
   const classNameBirthdayMiladi = type === 'adult' ? 'gregorianAdultBirthdayCalendar' : (type === 'child' ? 'gregorianChildBirthdayCalendar' : 'gregorianInfantBirthdayCalendar');

   // دکمه دفترچه مسافرین (فقط در صورت لاگین)
   const passengerBookButton = window.isUserLoggedIn ? `
      <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('${number}')">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"></path>
         </svg>
         ${typeof useXmltag === 'function' ? useXmltag('Passengerbook') : 'دفترچه مسافرین'}
      </span>
   ` : '';

   return `
      <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first require_check require_check_${number}">
         <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            ${typeLabel}
            <i class="soap-icon-family"></i>
            ${passengerBookButton}
         </span>
         <input type="hidden" id="numberRow" value="${number}">
         <input type="hidden" name="passengerAge${number}" id="passengerAge${number}" value="${passengerAge}">

         <div class="panel-default-change site-border-main-color">
            <div class="panel-default-change_kindOfPasenger nationalityChangeBaseDiv">
               <span class="kindOfPasenger">
                  <label class="control--checkbox">
                     <input type="radio" name="passengerNationality${number}"
                            onchange="passengerFormInit('${totalPassengers}')"
                            id="passengerNationality${number}" value="0" checked>
                     <span>${typeof useXmltag === 'function' ? useXmltag('Iranian') : 'ایرانی'}</span>
                  </label>
               </span>
               <span class="kindOfPasenger">
                  <label class="control--checkbox">
                     <input type="radio" name="passengerNationality${number}"
                            onchange="passengerFormInit('${totalPassengers}')"
                            id="passengerNationality${number}" value="1">
                     <span>${typeof useXmltag === 'function' ? useXmltag('Noiranian') : 'غیر ایرانی'}</span>
                  </label>
               </span>
            </div>
            <div class="clear"></div>
            <div class="panel-body-change">
               <div class="s-u-passenger-item s-u-passenger-item-change entry_div">
                  <select class="gend${number}" required="required" id="gender${number}" name="gender${number}">
                     <option value="" disabled="" selected="selected">${typeof useXmltag === 'function' ? useXmltag('Sex') : 'جنسیت'}</option>
                     <option value="Male">${typeof useXmltag === 'function' ? useXmltag('Sir') : 'آقا'}</option>
                     <option value="Female">${typeof useXmltag === 'function' ? useXmltag('Lady') : 'خانم'}</option>
                  </select>
               </div>

               <div class="s-u-passenger-item s-u-passenger-item-changes entry_div d-none">
                  <input data-required="foreign" id="nameEn${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('Name') : 'نام'}"
                         name="nameEn${number}" onkeypress="return isAlfabetKeyFields(event, 'nameEn${number}')" class="">
               </div>
               <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                  <input data-required="foreign" id="familyEn${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('Family') : 'نام خانوادگی'}"
                         name="familyEn${number}" onkeypress="return isAlfabetKeyFields(event, 'familyEn${number}')" class="">
               </div>

               <div class="s-u-passenger-item no-before s-u-passenger-item-change entry_div d-none">
                  <input data-required="iranian" id="nameFa${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('Name') : 'نام'}"
                         name="nameFa${number}" onkeypress=" return isAlfabetKeyFields(event, 'nameFa${number}')" class="justpersian">
               </div>
               <div class="s-u-passenger-item no-before s-u-passenger-item-change entry_div d-none">
                  <input data-required="iranian" id="familyFa${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('Family') : 'نام خانوادگی'}"
                         name="familyFa${number}" onkeypress=" return isAlfabetKeyFields(event, 'familyFa${number}')" class="justpersian">
               </div>

               <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                  <input data-required="iranian" id="birthday${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('shamsihappybirthday') : 'تاریخ تولد شمسی'}"
                         name="birthday${number}" class="${classNameBirthdayShamsi} " readonly="readonly">
               </div>
               <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                  <input data-required="foreign" id="birthdayEn${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('miladihappybirthday') : 'تاریخ تولد میلادی'}"
                         name="birthdayEn${number}" class="${classNameBirthdayMiladi}" readonly="readonly">
               </div>

               <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                  <input data-required="iranian" id="NationalCode${number}" type="tel"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('Nationalnumber') : 'کد ملی'}"
                         name="NationalCode${number}" maxlength="10" class="UniqNationalCode"
                         onkeyup="return checkNumber(event, 'NationalCode${number}')">
               </div>

               <div class="s-u-passenger-item s-u-passenger-item-change select-meliat entry_div d-none">
                  <select placeholder="${typeof useXmltag === 'function' ? useXmltag('Countryissuingpassport') : 'کشور صادر کننده گذرنامه'}"
                          data-required="foreign" name="passportCountry${number}" id="passportCountry${number}" class="select2">
                     <option value="">${typeof useXmltag === 'function' ? useXmltag('Countryissuingpassport') : 'کشور صادر کننده گذرنامه'}</option>
                     ${window.countryCodes ? window.countryCodes.map(country =>
      `<option value="${country.code}">${country.name}</option>`
   ).join('') : ''}
                  </select>
               </div>

               <div class="s-u-passenger-item s-u-passenger-item-change entry_div d-none">
                  <input data-required="foreign" id="passportNumber${number}" type="text"
                         placeholder="${typeof useXmltag === 'function' ? useXmltag('Numpassport') : 'شماره گذرنامه'}"
                         name="passportNumber${number}" class="UniqPassportNumber"
                         onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumber${number}')">
               </div>

               <div class="clear"></div>
               <div class="alert_msg d-flex gap-10 my-3" id="message${number}"></div>
            </div>
         </div>
         <div class="clear"></div>
      </div>
   `;
}

// بازگشت به مرحله انتخاب
function backToSelection() {
   // حذف فرم مسافرین از content-detailHotel
   const mainContent = document.querySelector('.passenger-form-main-content');
   if (mainContent) {
      mainContent.remove();
   }

   // بازگرداندن محتوای اصلی sidebar
   const sidebarDetailHotel = document.querySelector('.sidebar-detailHotel');
   if (sidebarDetailHotel && window.originalSidebarContent) {
      sidebarDetailHotel.innerHTML = window.originalSidebarContent;
   }

   // نمایش مجدد بخش انتخاب
   const flightsWrapper = document.getElementById('flights-wrapper');
   const matchingResult = document.getElementById('matching-result');
   const continueWrapper = document.getElementById('continue-wrapper');

   if (flightsWrapper) flightsWrapper.style.display = 'flex';
   if (matchingResult) matchingResult.style.display = 'flex';
   if (continueWrapper) continueWrapper.style.display = 'flex';
   $('.passengerDetailReservationTour_aside > p').show();

}

// تابع validation فرم مسافرین
function validatePassengerForm() {
   let isValid = true;
   let firstErrorField = null;

   // حذف همه خطاهای قبلی
   $('.s-u-passenger-item input, .s-u-passenger-item select').removeClass('field-error');
   $('.alert_msg').html('');

   // پیدا کردن تعداد مسافران
   const passengerWrappers = $('.s-u-passenger-wrapper');

   passengerWrappers.each(function() {
      const $wrapper = $(this);
      const numberRow = $wrapper.find('#numberRow').val();
      const passengerAge = $wrapper.find(`#passengerAge${numberRow}`).val();

      // چک کردن نوع ملیت (ایرانی/غیر ایرانی)
      const isIranian = $wrapper.find(`input[name="passengerNationality${numberRow}"]:checked`).val() === '0';

      let errors = [];

      // چک جنسیت (الزامی برای همه)
      const gender = $(`#gender${numberRow}`).val();
      if (!gender) {
         errors.push('جنسیت');
         $(`#gender${numberRow}`).addClass('field-error');
         if (!firstErrorField) firstErrorField = $(`#gender${numberRow}`);
         isValid = false;
      }

      if (isIranian) {
         // فیلدهای الزامی برای ایرانی
         const nameFa = $(`#nameFa${numberRow}`).val();
         const familyFa = $(`#familyFa${numberRow}`).val();
         const birthday = $(`#birthday${numberRow}`).val();
         const nationalCode = $(`#NationalCode${numberRow}`).val();

         if (!nameFa || nameFa.trim() === '') {
            errors.push('نام فارسی');
            $(`#nameFa${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#nameFa${numberRow}`);
            isValid = false;
         }

         if (!familyFa || familyFa.trim() === '') {
            errors.push('نام خانوادگی فارسی');
            $(`#familyFa${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#familyFa${numberRow}`);
            isValid = false;
         }

         if (!birthday || birthday.trim() === '') {
            errors.push('تاریخ تولد شمسی');
            $(`#birthday${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#birthday${numberRow}`);
            isValid = false;
         }

         if (!nationalCode || nationalCode.trim() === '') {
            errors.push('کد ملی');
            $(`#NationalCode${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#NationalCode${numberRow}`);
            isValid = false;
         } else if (nationalCode.length !== 10) {
            errors.push('کد ملی باید 10 رقم باشد');
            $(`#NationalCode${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#NationalCode${numberRow}`);
            isValid = false;
         }

      } else {
         // فیلدهای الزامی برای غیر ایرانی
         const nameEn = $(`#nameEn${numberRow}`).val();
         const familyEn = $(`#familyEn${numberRow}`).val();
         const birthdayEn = $(`#birthdayEn${numberRow}`).val();
         const passportNumber = $(`#passportNumber${numberRow}`).val();
         const passportCountry = $(`#passportCountry${numberRow}`).val();

         if (!nameEn || nameEn.trim() === '') {
            errors.push('نام انگلیسی');
            $(`#nameEn${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#nameEn${numberRow}`);
            isValid = false;
         }

         if (!familyEn || familyEn.trim() === '') {
            errors.push('نام خانوادگی انگلیسی');
            $(`#familyEn${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#familyEn${numberRow}`);
            isValid = false;
         }

         if (!birthdayEn || birthdayEn.trim() === '') {
            errors.push('تاریخ تولد میلادی');
            $(`#birthdayEn${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#birthdayEn${numberRow}`);
            isValid = false;
         }

         if (!passportNumber || passportNumber.trim() === '') {
            errors.push('شماره گذرنامه');
            $(`#passportNumber${numberRow}`).addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#passportNumber${numberRow}`);
            isValid = false;
         }

         if (!passportCountry || passportCountry.trim() === '') {
            errors.push('کشور صادر کننده گذرنامه');
            $(`#passportCountry${numberRow}`).addClass('field-error');
            // برای select2 باید parent را قرمز کنیم
            $(`#passportCountry${numberRow}`).parent().find('.select2-container').addClass('field-error');
            if (!firstErrorField) firstErrorField = $(`#passportCountry${numberRow}`);
            isValid = false;
         }
      }

      // نمایش پیغام خطا برای این مسافر
      if (errors.length > 0) {
         const passengerType = passengerAge === 'adt' ? 'بزرگسال' : (passengerAge === 'chd' ? 'کودک' : 'نوزاد');
         const errorMsg = `<span class="text-danger">⚠️ لطفاً فیلدهای زیر را تکمیل کنید: ${errors.join('، ')}</span>`;
         $(`#message${numberRow}`).html(errorMsg);
      }
   });

   // اگر خطا وجود داشت، به اولین فیلد خطا scroll کن
   if (!isValid && firstErrorField) {
      $('html, body').animate({
         scrollTop: firstErrorField.offset().top - 150
      }, 500);

      // نمایش alert کلی
      $.alert({
         title: useXmltag('Error') || 'خطا',
         content: 'لطفاً تمامی فیلدهای الزامی را با دقت تکمیل نمایید.',
         rtl: true,
         type: 'red'
      });
   }

   return isValid;
}

// مدیریت submit فرم
function handlePassengerFormSubmit(e) {
   if (e && e.preventDefault) {
      e.preventDefault();
   }

   // اجرای validation
   if (!validatePassengerForm()) {
      return false;
   }

   // جمع‌آوری داده‌های مسافرین به فرمت استاندارد
   const passengersArray = [];
   const passengerWrappers = $('.s-u-passenger-wrapper');

   passengerWrappers.each(function() {
      const $wrapper = $(this);
      const numberRow = $wrapper.find('#numberRow').val();
      const passengerAge = $wrapper.find(`#passengerAge${numberRow}`).val();
      const isIranian = $wrapper.find(`input[name="passengerNationality${numberRow}"]:checked`).val() === '0';
      const gender = $(`#gender${numberRow}`).val();

      // ساختار مسافر
      const passenger = {
         PassengerType: passengerAge === 'adt' ? 'Adt' : (passengerAge === 'chd' ? 'Chd' : 'Inf'),
         PassengerTitle: gender === 'Male' ? 'MR' : 'MS',
         // Gender: gender
      };

      if (isIranian) {
         // مسافر ایرانی
         passenger.FirstName = $(`#nameFa${numberRow}`).val() || '';
         passenger.LastName = $(`#familyFa${numberRow}`).val() || '';
         passenger.NationalCode = $(`#NationalCode${numberRow}`).val() || '';
         passenger.PassportNumber = '';
         passenger.DateOfBirth = $(`#birthday${numberRow}`).val() || '';
         passenger.Nationality = 'IR';
         passenger.isIranian = true;
      } else {
         // مسافر غیر ایرانی
         passenger.FirstName = $(`#nameEn${numberRow}`).val() || '';
         passenger.LastName = $(`#familyEn${numberRow}`).val() || '';
         passenger.PassportNumber = $(`#passportNumber${numberRow}`).val() || '';
         passenger.NationalCode = '';
         passenger.PassportCountry = $(`#passportCountry${numberRow}`).val() || '';
         passenger.DateOfBirth = $(`#birthdayEn${numberRow}`).val() || '';
         passenger.Nationality = passenger.PassportCountry;
         passenger.isIranian = false;
      }

      passengersArray.push(passenger);
   });

   // فرمت کردن داده‌های کامل پکیج
   const formattedData = formatPackageData(window.finalSelectedRecord, passengersArray);
   const additionalData = formatAdditionalData(window.finalSelectedRecord);

   // ارسال به صفحه پیش فاکتور
   lock(formattedData , additionalData);
   goToNextStep();
}

function formatAdditionalData(packageData) {
   if (!packageData) {
      return null;
   }

   const outputRoutes = [];
   if (packageData.OutputRoutes) {
      outputRoutes.push({
         seatClass: packageData.OutputRoutes.CabinType || '',
         airlineIata: packageData.OutputRoutes.Airline.Code || '',
         airlineName: packageData.OutputRoutes.Airline.Name || '',
      });
   }

   const returnRoutes = [];
   if (packageData.ReturnRoutes) {
      returnRoutes.push({
         seatClass: packageData.ReturnRoutes.CabinType || '',
         airlineIata: packageData.ReturnRoutes.Airline.Code || '',
         airlineName: packageData.ReturnRoutes.Airline.Name || '',
      });
   }

   const rooms = [];
   if (packageData.Hotel?.Rooms) {
      packageData.Hotel.Rooms.forEach(room => {
         rooms.push({
            Id: room.Id || 0,
            name: room.Name || '',
            Type: room.Type || '',
            Adults: room.Adults || 0,
            Children: room.Ages?.length || 0,
            Ages: room.Ages || [],
            Extrabed: room.Extrabed || 0
         });
      });
   }


   const formatadditionalData = {
      HotelName: packageData.Hotel?.Name || '',
      Routes: {
         Output: outputRoutes,
         Return: returnRoutes
      },
      Rooms: rooms,
   };

   return formatadditionalData;
}

// فرمت کردن داده‌های پکیج به فرمت استاندارد
function formatPackageData(packageData, passengersArray) {
   if (!packageData) {
      return null;
   }

   // فرمت کردن پروازهای رفت
   const outputRoutes = [];
   if (packageData.OutputRoutes) {
      outputRoutes.push({
         FlightNo: packageData.OutputRoutes.FlightNo || '',
         DepartureDate: packageData.OutputRoutes.PersianDepartureDate || '',
         DepartureTime: packageData.OutputRoutes.DepartureTime || '',
         DepartureCode: packageData.OutputRoutes.Departure?.Code || '',
         ArrivalCode: packageData.OutputRoutes.Arrival?.Code || '',
         FareName: packageData.OutputRoutes.FareName || ''
      });
   }

   // فرمت کردن پروازهای برگشت
   const returnRoutes = [];
   if (packageData.ReturnRoutes) {
      returnRoutes.push({
         FlightNo: packageData.ReturnRoutes.FlightNo || '',
         DepartureDate: packageData.ReturnRoutes.PersianDepartureDate || '',
         DepartureTime: packageData.ReturnRoutes.DepartureTime || '',
         DepartureCode: packageData.ReturnRoutes.Departure?.Code || '',
         ArrivalCode: packageData.ReturnRoutes.Arrival?.Code || '',
         FareName: packageData.ReturnRoutes.FareName || ''
      });
   }

   // فرمت کردن اتاق‌ها
   const rooms = [];
   if (packageData.Hotel?.Rooms) {
      packageData.Hotel.Rooms.forEach(room => {
         rooms.push({
            Id: room.Id || 0,
            Type: room.Type || '',
            Adults: room.Adults || 0,
            Children: room.Ages?.length || 0,
            Ages: room.Ages || [],
            Extrabed: room.Extrabed || 0
         });
      });
   }

   total_price = packageData.TotalPrice;

   // ساختار نهایی داده
   const formattedData = {
      HotelID: packageData.Hotel?.Id || 0,
      CheckinDate: packageData.OutputRoutes?.PersianDepartureDate || '',
      CheckoutDate: packageData.ReturnRoutes?.PersianDepartureDate || '',
      FlightTotalPrice: packageData.TotalFlightPrice || 0,
      HotelTotalPrice: packageData.TotalHotelPrice || 0,
      // TotalPrice: packageData.TotalPrice || 0,
      Routes: {
         Output: outputRoutes,
         Return: returnRoutes
      },
      Rooms: rooms,
      Passengers: passengersArray
   };

   return formattedData;
}

// رفتن به صفحه پیش فاکتور
function lock(formattedData , additionalData) {
   $('#resultRoomHotel').remove();
   total_price = previousPrices.final;

   $('.passengerDetailReservationTour_title').hide();
   $('.passengerDetailReservationTour_users').hide();
   $(".price-after-discount-code").prepend(total_price);


   document
      .querySelector('.passenger-form-main-content')
      .insertAdjacentHTML(
         'afterend',
         `
    <div id='resultRoomHotel'>
        <div class='roomHotelLocal'>
            <div class='loader-box-user-buy'>
              <span class="loader-spinner"></span>
              <span class="loader-text">${useXmltag("Loading")}</span>
            </div>
        </div>
    </div>
    `
      );

   formattedData.SourceId = source_id;
   let selectedEntertainmentData = Array.from(selectedEntertainment).map(i => {
      const item = entertainmentList[i];
      const passengerCount = passengerCn || 1;  // تعداد مسافر از روی اتاق‌ها

      return {
         id: item.id,
         factorNumber: item.factorNumber,
         tourTitle: item.title,
         final_price: item.final_price * passengerCount,
         original_price: item.tour_price * passengerCount,
         discount_percent: item.discount_percent,
         currency_price: (item.tour_currency_price || 0) * passengerCount,
         currency_type: item.tour_currency_type || null
      };
   });




   let data = {
      className: 'exclusiveTour',
      method: 'Lock',
      requestNumber: request_number,
      lockData: formattedData,
      additionalData: additionalData,
      entertainments: selectedEntertainmentData
   };

   $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify(data),
      success: function(response) {

         finalPassengers = formattedData.Passengers;
         showLock();
      },
      error: function(error) {
         let msg = useXmltag('NoAvailableReserve');
         $.alert({
            title: useXmltag('Error'),
            content: msg,
            rtl: true,
            type: 'red',
         });
      },
      complete: function() {
         $('#resultRoomHotel').hide();
      }
   });

}

function showLock() {

   // ساخت آرایه مسافران با شماره‌گذاری صحیح
   let passengersHTML = '';

   finalPassengers.forEach(function(passenger, index) {
      passengersHTML += createPassengersLockView(passenger , index);
   });

   const mainContentHTML = `
             <h2 class="passengerDetailReservationTour_title">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z"/></svg>
                  ${useXmltag('Travelerprofile')}
             </h2>
             <div class="passengerDetailReservationTour_users passengerDetailReservationTour_users_info">
                  ${passengersHTML}
            </div>
   `;

   const inputRules = `
          <p class="s-u-result-item-RulsCheck-item">
           <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                  name="heck_list1" value="" type="checkbox">
           <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
               <a class="site-main-text-color" href="/gds/fa/rules" target="_blank">${useXmltag('Seerules')}</a>
                  ${useXmltag('IhavestudiedIhavenoobjection')}
           </label>
       </p>
   `;
   const btnPay = `
     <button id="final_ok_and_insert_passenger"
          onclick="finalApproval()">${useXmltag('Approvefinal')}</button>
   `;
   $('.parent_next_tour_n_').hide();
   document
      .querySelector('.passenger-form-main-content')
      .insertAdjacentHTML(
         'afterend',
         mainContentHTML
      );
   document
      .querySelector('.passengerDetailReservationTour_aside_lastBox .row.total')
      .insertAdjacentHTML(
         'afterend',
         inputRules
      );
   document
      .querySelector('.s-u-result-item-RulsCheck-item')
      .insertAdjacentHTML(
         'afterend',
         btnPay
      );
}

function createPassengersLockView(passenger , number) {

   // متن label بر اساس نوع مسافر
   let typeLabel = '';
   if (passenger.PassengerType === 'Adt') {
      typeLabel = typeof useXmltag === 'function' ? useXmltag('Adult') : 'بزرگسال';
   } else if (passenger.PassengerType === 'Chd') {
      typeLabel = typeof useXmltag === 'function' ? useXmltag('Child') : 'کودک';
   }

   let docNum = passenger.PassportNumber == '' ? passenger.NationalCode : passenger.PassportNumber;

   return `
                        <div>
                            <h4>${useXmltag('Passenger')} ${number + 1}</h4>
                            <div>
                                <div>
                                    <h4>${useXmltag('Ages')}</h4>
                                    <h5>${typeLabel}</h5>
                                </div>
                                <div>
                                    <h4>${useXmltag('Nation')}</h4>
                                    <h5>${passenger.NationalCode}</h5>
                                </div>
                                <div>
                                    <h4>${useXmltag('Name')}</h4>
                                    <h5>${passenger.FirstName}</h5>
                                </div>
                                <div>
                                    <h4>${useXmltag('Family')}</h4>
                                    <h5>${passenger.LastName}</h5>
                                </div>
                                <div>
                                    <h4>${useXmltag('Happybirthday')}</h4>
                                    <h5>${passenger.DateOfBirth}</h5>
                                </div>
                                <div>
                                    <h4>${useXmltag('Numpassport')} / ${useXmltag('Nationalnumber')}</h4>
                                    <h5>${docNum}</h5>
                                </div>
                            </div>
                        </div>
   
   `;
}

function finalApproval() {

   if (!$('#RulsCheck').is(':checked')) {
      $.alert({
         title:  useXmltag("Tourreservation"),
         icon: 'fa fa-cart-plus',
         content: useXmltag("ConfirmTermsFirst"),
         rtl: true,
         type: 'red'
      });
      return false;
   }

   $(".main-pay-content").css("display", "flex");
   goToNextStep();
}

// Updated createRoomBoxes to handle room packages
function createRoomPackageBoxes(uniqueRoomPackages) {
   const container = document.getElementById('rooms-container');
   container.innerHTML = '';

   uniqueRoomPackages.forEach((roomPackage, index) => {
      // Create a box for each room package
      const packageBox = `
            <div class="room-package-box" data-package-index="${index}" data-package-key="${roomPackage.packageKey}" onclick="selectRoomPackage(${index})">                
                <div class="rooms-in-package">
                    ${roomPackage.rooms.map(room => `
                        <div class="room-item">
                            <div class="room-item-header">
                                <span class="room-name">${room.Name}</span>
                                <span class="room-type">${room.Type}</span>
                            </div>
                            <div class="room-item-details">
                                <span class="detail">${room.Adults} بزرگسال</span>
                                ${room.Extrabed > 0 ? `<span class="detail">${room.Extrabed} تخت اضافه</span>` : ''}
                                ${room.Ages && room.Ages.length > 0 ? `<span class="detail">${room.Ages.length} کودک</span>` : ''}
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
      container.insertAdjacentHTML('beforeend', packageBox);
   });
}

// Updated selection handler for room packages
function selectRoomPackage(index) {
   // Remove previous selections
   document.querySelectorAll('.room-package-box').forEach(box => {
      box.classList.remove('selected');
   });

   // Add selected class
   document.querySelector(`[data-package-index="${index}"]`).classList.add('selected');

   // Store selected package
   selectedOptions.roomPackage = disaggregateData.uniqueRoomPackages[index];

   checkAndFindMatch();
}

// findMatchingRecord - فقط FlightNo چک میشه
function findMatchingRecord() {
   if (!selectedOptions.roomPackage || !selectedOptions.outboundFlight || !selectedOptions.returnFlight) {
      return null;
   }


   // Find record that has the selected room package and flights
   const matchingRecord = originalData.find((record, index) => {
      // Check if this record index is in the availableInRecords for selected package
      const hasRoomPackage = selectedOptions.roomPackage.availableInRecords.includes(index);

      // فقط FlightNo چک میشه
      const outboundMatch = matchFlights(record.OutputRoutes, selectedOptions.outboundFlight);
      const returnMatch = matchFlights(record.ReturnRoutes, selectedOptions.returnFlight);

      return hasRoomPackage && outboundMatch && returnMatch;
   });

   return matchingRecord;
}
(function addDragHintStyles() {
   const style = document.createElement('style');
   style.innerHTML = `

.arrow-text {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 18px;
  font-weight: 600;
  cursor: pointer;
  margin-bottom: 10px;
}

.arrow-text svg {
  width: 24px;   /* کمی بزرگ‌تر و واضح‌تر */
  height: 24px;
  stroke: black;
  stroke-width: 3;  /* فلش کلفت‌تر */
  transition: transform 0.3s ease, stroke 0.3s ease;
}

.arrow-text:hover svg {
  transform: translateX(-5px); /* حرکت ملایم به چپ هنگام هاور */
  stroke: #ff6600; /* تغییر رنگ فلش هنگام هاور */
}

.rooms-arrow {
    position: absolute;
    top: 38%;
    transform: translateY(-50%);
    z-index: 100;
    background: rgba(70, 80, 100, 0.2); /* کمی شفاف */
    border: 1px solid rgba(0,0,0,0.2);
    border-radius: 6px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15); /* سایه ملایم */
}

.rooms-arrow svg {
    width: 20px;
    height: 20px;
    display: block;
    margin: auto; /* این باعث می‌شود مرکز فلش دقیق وسط دایره باشد */
    transition: all 0.25s ease;
}

.left-arrow {
    left: -23px;
}

/* فلش سمت راست */
.right-arrow {
    right: -7px;
}

/* افکت هاور */
.rooms-arrow:hover {
    background: #fff;
    transform: translateY(-50%) scale(1.1); /* کمی بزرگتر شود */
    border-color: var(--mainColor); /* اگر رنگ اصلی سایت داری */
}

.rooms-arrow:hover svg {
    stroke: var(--mainColor); /* آیکون هم رنگ تغییر کند */
}



    `;
   document.head.appendChild(style);
})();
function scrollRooms(direction) {
   const container = document.getElementById('rooms-container');
   const amount = 300;

   container.scrollBy({
      left: direction === 'left' ? -amount : amount,
      behavior: 'smooth'
   });
}


// Updated renderAllComponents
function renderAllComponents() {

   setTimeout(() => {
      const hint = document.getElementById('drag-hint');
      hint.style.opacity = '1';
      setTimeout(() => hint.remove(), 4500);
   }, 500);

   $('.content-detailHotel').html('');

   createContainers();

   // فعال‌سازی drag-to-scroll بعد از ساخت container
   setTimeout(() => {
      initDragToScroll('.rooms-container');
   }, 100);

   // Use new function for room packages
   createRoomPackageBoxes(disaggregateData.uniqueRoomPackages);
   adjustRoomPackageWidths();

   createFlightBoxes(disaggregateData.uniqueOutputRoutes, 'outbound-flights-container', 'output');

   createFlightBoxes(disaggregateData.uniqueReturnRoutes, 'return-flights-container', 'return');

   createEntertaimentBoxes();

}
function adjustRoomPackageWidths() {
   const items = document.querySelectorAll("#rooms-container .room-package-box");
   const count = items.length;

   if (count === 1) {
      items[0].style.minWidth = "100%";
      items[0].style.maxWidth = "100%";
   }
   else if (count === 2) {
      items.forEach(item => {
         item.style.minWidth = "50%";
         item.style.maxWidth = "50%";
      });
   }
   else {
      // حالت 3+ → همان حالت اسکرولی پیش‌فرض
      items.forEach(item => {
         item.style.minWidth = "";
         item.style.maxWidth = "";
      });
   }
}





let entertainmentList = [];
let selectedEntertainment = new Set();

function createEntertaimentBoxes(){
   let data = {
      className: 'exclusiveTour',
      method: 'findNearEntertainment',
      city_code: arrivalcityCode,
   };

   $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify(data),

      success: function(response) {
         entertainmentList = response || [];
         if (!entertainmentList.length) {
            const section = document.querySelector('.entertainment-section');
            if (section) {
               section.style.display = 'none';
            }
            return;
         }
         const section = document.querySelector('.entertainment-section');
         if (section) {
            section.style.display = '';
         }
         buildEntertainmentUI();
         adjustEntertainmentWidths();
      },

      error: function(error) {
         let msg = useXmltag('NoAvailableReserve');
         $.alert({
            title: useXmltag('Error'),
            content: msg,
            rtl: true,
            type: 'red',
         });
      }
   });
}

function updateEntertainmentSummaryInSidebar() {
   const el = document.getElementById("entertainment-summary-items");
   if (!el) return;

   const titles = Array.from(selectedEntertainment)
      .map(i => entertainmentList[i]?.title)
      .filter(Boolean);

   el.textContent = titles.length ? titles.join(" - ") : "خدماتی انتخاب نشده است";
}



function buildEntertainmentUI() {
   const container = document.getElementById("entertainment-container");
   container.innerHTML = "";

   entertainmentList.forEach((item, index) => {

      /* -----------------------------
         1) قیمت ریالی
      ----------------------------- */
      let rialHTML = "";

      if (item.discount_percent > 0) {
         rialHTML = `
            <div class="price-old">
               <span class="old-number">
                  ${Number(item.tour_price).toLocaleString("fa-IR")} ریال
               </span>
               <span class="discount-badge-inline">${item.discount_percent}%</span>
            </div>

            <div class="price-new">
               ${Number(item.final_price).toLocaleString("fa-IR")} ریال
            </div>
         `;
      } else {
         rialHTML = `
            <div class="price-new">
               ${Number(item.final_price).toLocaleString("fa-IR")} ریال
            </div>
         `;
      }

      /* -----------------------------
         2) قیمت ارزی اگر وجود داشت
      ----------------------------- */
      let currencyHTML = "";

      if (item.tour_currency_price && item.tour_currency_type) {
         currencyHTML = `
            <div class="currency-line">
               + ${item.tour_currency_price} (${item.tour_currency_title})
            </div>
         `;
      }

      /* -----------------------------
         3) Badge تخفیف گوشه کارت
      ----------------------------- */

      /* -----------------------------
         4) ساخت کارت نهایی
      ----------------------------- */
      const cardHTML = `
         <div class="ent-box" 
              data-index="${index}" 
              onclick="toggleEntertainment(${index})">
            <div class="ent-info">
               <div class="ent-title">${item.title}</div>

               <div class="ent-price">
                  ${rialHTML}
                  ${currencyHTML}
               </div>
            </div>

            <div class="ent-checkmark"></div>
         </div>
      `;

      container.insertAdjacentHTML("beforeend", cardHTML);
   });
   if (pendingEntertainmentSelection && pendingEntertainmentSelection.length) {
      restoreEntertainmentSelection(pendingEntertainmentSelection);
   }
}

function adjustEntertainmentWidths() {
   const items = document.querySelectorAll("#entertainment-container .ent-box");
   const count = items.length;

   if (count === 1) {
      items[0].style.minWidth = "100%";
      items[0].style.maxWidth = "100%";
   }
   else if (count === 2) {
      items.forEach(item => {
         item.style.minWidth = "50%";
         item.style.maxWidth = "50%";
      });
   }
   else {
      items.forEach(item => {
         item.style.minWidth = "";
         item.style.maxWidth = "";
      });
   }
}



function scrollEntertainment(direction) {
   const container = document.getElementById('entertainment-container');
   const amount = 300;

   container.scrollBy({
      left: direction === 'left' ? -amount : amount,
      behavior: 'smooth'
   });
}


function calculateEntertainmentPrice() {
   let rialTotal = 0;
   let currencyList = [];


   Array.from(selectedEntertainment).forEach(i => {
      const item = entertainmentList[i];

      // قیمت ریالی نهایی (بعد تخفیف) × تعداد نفرات
      if (item.final_price) {
         rialTotal += Number(item.final_price) * passengerCn;
      }

      // قیمت ارزی اگر داشت (فعلاً جمع ساده – اگر خواستی ضربدر تعداد نفرات هم می‌کنم)
      if (item.tour_currency_price && item.tour_currency_type) {
         currencyList.push({
            price: item.tour_currency_price * passengerCn,
            type: item.tour_currency_type
         });
      }
   });

   return { rialTotal, currencyList };
}
function restoreEntertainmentSelection(indices) {
   if (!indices || !indices.length) return;

   const hasUI =
      entertainmentList &&
      entertainmentList.length &&
      document.querySelector('#entertainment-container .ent-box');

   if (!hasUI) {
      pendingEntertainmentSelection = indices;
      return;
   }

   // UI آماده است
   selectedEntertainment = new Set();

   indices.forEach(i => {
      if (entertainmentList[i]) {
         selectedEntertainment.add(i);
         const box = document.querySelector(`.ent-box[data-index="${i}"]`);
         if (box) box.classList.add('selected');
      }
   });

   pendingEntertainmentSelection = null;

   const { rialTotal } = calculateEntertainmentPrice();
   previousPrices.ent   = 0;
   previousPrices.final = previousPrices.base;

   updateEntertainmentSummaryInSidebar();
   updateEntertainmentPricesInSidebar({ animate: true });
}







function toggleEntertainment(index) {
   const box = document.querySelector(`.ent-box[data-index="${index}"]`);

   if (selectedEntertainment.has(index)) {
      selectedEntertainment.delete(index);
      box.classList.remove("selected");
   } else {
      selectedEntertainment.add(index);
      box.classList.add("selected");
   }
   updateEntertainmentPricesInSidebar({ animate: true });
   updateEntertainmentSummaryInSidebar();


   // مرحله بعدی که گفتی بعداً تعریف می‌کنیم:
   console.log('selected indexes:', Array.from(selectedEntertainment));
   console.log('selected items:', Array.from(selectedEntertainment).map(i => entertainmentList[i]));
}
function updateEntertainmentPricesInSidebar({ animate = true } = {}) {
   const box = document.getElementById("final-price-box");
   if (!box) return;

   const baseEl  = box.querySelector('[data-price-type="total-base"]');
   const entEl   = box.querySelector('[data-price-type="entertain"]');
   const finalEl = box.querySelector('[data-price-type="final-total"]');

   // اگر base هنوز ست نشده، از خود UI بخون (fallback)
   const base = Number(previousPrices.base || 0);

   const { rialTotal } = calculateEntertainmentPrice();
   const newEnt   = Number(rialTotal || 0);
   const newFinal = base + newEnt;

   // انیمیشن‌های قبلی رو قطع کن (برای تداخل کلیک‌های سریع)
   stopCounter(entEl);
   stopCounter(finalEl);

   if (!animate) {
      if (baseEl)  baseEl.textContent  = base.toLocaleString("fa-IR");
      if (entEl)   entEl.textContent   = newEnt.toLocaleString("fa-IR");
      if (finalEl) finalEl.textContent = newFinal.toLocaleString("fa-IR") + " ریال";
   } else {
      // base معمولاً ثابت است؛ اگر خواستی می‌تونی برای base هم انیمیشن بزنی
      if (baseEl) baseEl.textContent = base.toLocaleString("fa-IR");

      // ✅ شمارنده برای خدمات اضافه و جمع کل
      if (entEl)   animateCounter(entEl,   previousPrices.ent   || 0, newEnt);
      if (finalEl) animateCounter(finalEl, previousPrices.final || base, newFinal);
   }

   // ✅ آپدیت مرجع برای انیمیشن بعدی
   previousPrices.ent   = newEnt;
   previousPrices.final = newFinal;
}













// Updated checkAndFindMatch
function checkAndFindMatch() {
   if (selectedOptions.roomPackage && selectedOptions.outboundFlight && selectedOptions.returnFlight) {
      const matchingRecord = findMatchingRecord();

      if (matchingRecord) {
         displayMatchingRecord(matchingRecord);
         showContinueButton(matchingRecord);
      } else {
         $.alert({
            title: useXmltag('Error'),
            content: 'این ترکیب از پکیج اتاق و پروازها موجود نیست.',
            rtl: true,
            type: 'red'
         });
      }
   }
}

// انتخاب خودکار اولین پکیج
function selectDefaultPackage() {
   // بررسی اینکه داده‌ها موجود هستند
   if (!disaggregateData || !disaggregateData.uniqueRoomPackages ||
      !disaggregateData.uniqueOutputRoutes || !disaggregateData.uniqueReturnRoutes) {
      return;
   }

   // بررسی اینکه حداقل یک آیتم در هر بخش وجود دارد
   if (disaggregateData.uniqueRoomPackages.length === 0 ||
      disaggregateData.uniqueOutputRoutes.length === 0 ||
      disaggregateData.uniqueReturnRoutes.length === 0) {
      return;
   }

   // انتخاب اولین room package
   const firstRoomPackageBox = document.querySelector('[data-package-index="0"]');
   if (firstRoomPackageBox) {
      firstRoomPackageBox.classList.add('selected');
      selectedOptions.roomPackage = disaggregateData.uniqueRoomPackages[0];
   }

   // انتخاب اولین پرواز رفت
   const firstOutputFlightBox = document.querySelector('[data-flight-type="output"][data-flight-index="0"]');
   if (firstOutputFlightBox) {
      firstOutputFlightBox.classList.add('selected');
      selectedOptions.outboundFlight = disaggregateData.uniqueOutputRoutes[0];
   }

   // انتخاب اولین پرواز برگشت
   const firstReturnFlightBox = document.querySelector('[data-flight-type="return"][data-flight-index="0"]');
   if (firstReturnFlightBox) {
      firstReturnFlightBox.classList.add('selected');
      selectedOptions.returnFlight = disaggregateData.uniqueReturnRoutes[0];
   }

   // چک کردن و یافتن رکورد منطبق
   checkAndFindMatch();
}

// چک کردن عملیات معلق بعد از لاگین
function checkPendingActionAfterLogin() {
   // فقط اگر کاربر لاگین است
   if (!window.isUserLoggedIn) {
      return;
   }

   // چک کردن localStorage
   const pendingAction = localStorage.getItem('pendingExclusiveTourAction');
   if (!pendingAction) {
      return;
   }

   try {
      const actionData = JSON.parse(pendingAction);

      // پاک کردن از localStorage
      localStorage.removeItem('pendingExclusiveTourAction');

      if (actionData.action === 'proceedWithSelection') {
         const entIndices = actionData.selectedEntertainmentIndices || [];

         // بازیابی انتخاب‌ها
         setTimeout(() => {
            // انتخاب room package
            if (actionData.selectedPackageIndex >= 0) {
               selectRoomPackage(actionData.selectedPackageIndex);
            }

            // انتخاب پرواز رفت
            if (actionData.selectedOutputFlightIndex >= 0) {
               selectFlight('output', actionData.selectedOutputFlightIndex);
            }

            // انتخاب پرواز برگشت
            if (actionData.selectedReturnFlightIndex >= 0) {
               selectFlight('return', actionData.selectedReturnFlightIndex);
            }



            // ادامه عملیات با کمی تاخیر
            setTimeout(() => {
               // 👈 ریکاور تفریحات (اگر UI آماده نباشد، خودش در pending می‌گذارد)
               if (entIndices.length) {
                  restoreEntertainmentSelection(entIndices);
               }
               if (window.finalSelectedRecord) {
                  proceedWithSelection();
               }
            }, 200);
         }, 300);
      }
   } catch (e) {
      console.error('Error parsing pending action:', e);
      localStorage.removeItem('pendingExclusiveTourAction');
   }
}


// ===============================================
// توابع مدیریت دفترچه مسافرین (Passenger Book)
// ===============================================

// متغیر سراسری برای ذخیره شماره مسافر فعلی
let currentPassengerNumber = null;

// باز کردن modal دفترچه مسافرین
function setHidenFildnumberRow(passengerNumber) {
   currentPassengerNumber = passengerNumber;

   // نمایش lightbox و modal
   $('#lightboxContainer').addClass('displayBlock');
   $('.last-p-popup').css('display', 'block');

   // اگر DataTable قبلاً initialize نشده، آن را initialize کنید
   if (!$.fn.DataTable.isDataTable('#passengers')) {
      $('#passengers').DataTable({
         responsive: true
      });
   }
}

// بستن modal دفترچه مسافرین
function setHidenCloseLastP() {
   $('#lightboxContainer').removeClass('displayBlock');
   $('.last-p-popup').css('display', 'none');
   currentPassengerNumber = null;
}

// انتخاب مسافر از لیست
function selectPassengerLocal(idPass, moduleType, _this = null) {
   var found = false;

   if (_this && _this.length) {
      // نمایش loading
      _this.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
   }

   $.post(amadeusPath + 'user_ajax.php', {
      idPass: idPass,
      flag: 'selectPassengerLocal'
   }, function(data) {
      if (_this && _this.length) {
         // حذف loading
         _this.prop('disabled', false).html('<i class="fa fa-check"></i>');
      }

      if (data) {
         var obj = jQuery.parseJSON(data);
         var numberRow = currentPassengerNumber;

         if (!numberRow) {
            return;
         }

         // بررسی تکراری نبودن کد ملی/پاسپورت
         if (obj.NationalCode) {
            $(".UniqNationalCode").each(function(index) {
               if ($(this).val() == obj.NationalCode) {
                  found = true;
               }
            });
         } else {
            $(".UniqPassportNumber").each(function(index) {
               if ($(this).val() == obj.passportNumber) {
                  found = true;
               }
            });
         }

         if (!found) {
            // پر کردن فیلدها
            $("#gender" + numberRow + " option[value=" + obj.gender + "]").prop('selected', true);
            $("#nameEn" + numberRow).val(obj.name_en);
            $("#familyEn" + numberRow).val(obj.family_en);
            $("#nameFa" + numberRow).val(obj.name_fa);
            $("#familyFa" + numberRow).val(obj.family_fa);

            // تاریخ تولد
            if (obj.birthday && obj.birthday !== '0000-00-00') {
               $("#birthdayEn" + numberRow).val(obj.birthday);
            }
            if (obj.birthday_fa) {
               $("#birthday" + numberRow).val(obj.birthday_fa);
            }

            // کد ملی و اطلاعات پاسپورت
            if (obj.NationalCode) {
               $("#NationalCode" + numberRow).val(obj.NationalCode);
               // تنظیم ملیت به ایرانی
               $("input[name='passengerNationality" + numberRow + "'][value='0']").prop('checked', true).trigger('change');
            }

            if (obj.passportNumber) {
               $("#passportNumber" + numberRow).val(obj.passportNumber);
            }

            if (obj.passportCountry) {
               $("#passportCountry" + numberRow).val(obj.passportCountry).trigger('change');
               // بروزرسانی select2
               $("#select2-passportCountry" + numberRow + "-container").html($("#passportCountry" + numberRow + " option:selected").text());
            }


            // اگر پاسپورت دارد، ملیت را غیر ایرانی تنظیم کن
            if (!obj.NationalCode && obj.passportNumber) {
               $("input[name='passengerNationality" + numberRow + "'][value='1']").prop('checked', true).trigger('change');
            }

            // بستن modal
            $(".s-u-close-last-p").trigger("click");
            e
            // نمایش پیام موفقیت
            if (typeof $.toast !== 'undefined') {
               $.toast({
                  heading: typeof useXmltag === 'function' ? useXmltag('Success') : 'موفق',
                  text: 'اطلاعات مسافر با موفقیت بارگذاری شد',
                  icon: 'success',
                  position: 'top-right',
                  hideAfter: 3000
               });
            }
         } else {
            $.alert({
               title: typeof useXmltag === 'function' ? useXmltag('Passengerlist') : 'لیست مسافران',
               content: typeof useXmltag === 'function' ? useXmltag('NoPermissionDuplicateNationalCode') : 'این مسافر قبلاً اضافه شده است',
               rtl: true,
               type: 'red'
            });
            $(".s-u-close-last-p").trigger("click");
         }
      }
   });
}


// تابع برای اضافه کردن قابلیت drag-to-scroll به containers
function initDragToScroll(selector) {
   const container = document.querySelector(selector);

   if (!container) {
      return;
   }

   let isDown = false;
   let startX;
   let scrollLeft;

   container.addEventListener('mousedown', (e) => {
      isDown = true;
      container.classList.add('dragging');
      startX = e.clientX;
      scrollLeft = container.scrollLeft;
   });

   container.addEventListener('mouseleave', () => {
      isDown = false;
      container.classList.remove('dragging');
   });

   container.addEventListener('mouseup', () => {
      isDown = false;
      container.classList.remove('dragging');
   });

   container.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.clientX;
      const walk = (x - startX) * 2;
      container.scrollLeft = scrollLeft - walk;
   });

   console.log('Drag-to-scroll initialized for:', selector);
}

// بستن modal با کلیک روی lightbox
$(document).ready(function() {
   $('#lightboxContainer').click(function() {
      setHidenCloseLastP();
   });

   // حذف خطا هنگام تغییر مقدار فیلد
   $(document).on('input change', '.field-error', function() {
      $(this).removeClass('field-error');
      // برای select2 ها
      if ($(this).is('select')) {
         $(this).parent().find('.select2-container').removeClass('field-error');
      }
      // پاک کردن پیغام خطای مربوط به این فیلد
      const fieldId = $(this).attr('id');
      if (fieldId) {
         const numberMatch = fieldId.match(/\d+/);
         if (numberMatch) {
            const numberRow = numberMatch[0];
            $(`#message${numberRow}`).html('');
         }
      }
   });
});
document.documentElement.style.overflowX = 'hidden';

