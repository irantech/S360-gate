const origin_input = $('.iata-origin-package-js')
const destination_input = $('.iata-destination-package-js')

var Loading_package = `<div class='package-loading'>
                                <ul>
                                  <li> 
                                    <div class='package-loading-div'>
                                          <div class='package-loading-div-spinner'><div id='loading-spinner-package'></div></div>
                                          <div class='loading-line-package'></div>
                                    </div>
                                  </li>
                                  <li> 
                                    <div class='package-loading-div'>
                                          <div class='package-loading-div-spinner'><div id='loading-spinner-package'></div></div>
                                          <div class='loading-line-package'></div>
                                    </div>
                                  </li>
                                  <li> 
                                    <div class='package-loading-div'>
                                          <div class='package-loading-div-spinner'><div id='loading-spinner-package'></div></div>
                                          <div class='loading-line-package'></div>
                                    </div>
                                  </li>
                                  <li> 
                                    <div class='package-loading-div'>
                                          <div class='package-loading-div-spinner'><div id='loading-spinner-package'></div></div>
                                          <div class='loading-line-package'></div>
                                    </div>
                                  </li>
                                </ul>
                              </div>`
$(document).ready(function () {
  getPopularCitiesForPackage('origin')
  getPopularCitiesForPackage('destination')
});
$(document).on('click', '.iata-origin-package-js', function () {
  let iata = $(this).val();
  if (iata.length > 0) {
    // پاک کردن مقدار
    $(this).val('');
    $('.origin-package-js').val('');
    $(this).removeAttr('data-selected');
  }
  // نمایش لیست محبوب
  $('.list-origin-airport-package-js').hide();
  $('.list_popular_package_origin-js').show();
});

$(document).on('click', '.iata-destination-package-js', function () {
  let iata = $(this).val();
  if (iata.length > 0) {
    // پاک کردن مقدار
    $(this).val('');
    $('.destination-package-js').val('');
    $(this).removeAttr('data-selected');
  }
  // نمایش لیست محبوب
  $('.list-destination-airport-package-js').hide();
  $('.list_popular_package_destination-js').show();
});
$(document).on('keyup', '.iata-origin-package-js', function () {
  getCitiesForPackage(this, 'origin');
});
$(document).on('keyup', '.iata-destination-package-js', function () {
  getCitiesForPackage(this, 'destination');
});
$(document).on('blur', '.iata-origin-package-js', function () {
  setTimeout(function() {
    if (!$('.list_popular_package_origin-js:hover, .list-origin-airport-package-js:hover').length) {
      $('.list_popular_package_origin-js, .list-origin-airport-package-js').hide();
    }
  }, 200);
});
$(document).on('blur', '.iata-destination-package-js', function () {
  setTimeout(function() {
    if (!$('.list_popular_package_destination-js:hover, .list-destination-airport-package-js:hover').length) {
      $('.list_popular_package_destination-js, .list-destination-airport-package-js').hide();
    }
  }, 200);
});
function getPopularCitiesForPackage(type) {
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
      popular_cities_package = response.data;
      let items_search = [];
      let data;
      let dataList = [];

      // انتخاب لیست مناسب بر اساس نوع (مبدأ یا مقصد) برای پکیج
      let list_popular_package = $('.list_popular_package_' + type + '-js');
      list_popular_package.html('');

      // بررسی localStorage برای نمایش تاریخچه جستجوی پکیج
      let storedData = JSON.parse(localStorage.getItem('packageSearchedCities'));
      if (storedData !== null && Object.keys(storedData).length !== 0) {
        if (type == 'origin' && storedData['origin']) {
          data = storedData['origin'];
          dataList = [];
          data.forEach((item) => {
            let json_sub_value = JSON.stringify({
              AirportFa: item.AirportFa,
              AirportAr: item.AirportAr,
              AirportEn: item.AirportEn,
              CountryFa: item.CountryFa,
              CountryEn: item.CountryEn,
              CountryAr: item.CountryAr,
              CityFa: item.DepartureCityFa,
              CityEn: item.DepartureCityEn,
              CityAr: item.DepartureCityAr,
              CityCode: item.DepartureCode,
              type: type,
            });

            let items_search_local;
            if (lang === 'fa') {
              items_search_local = `<li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportFa} - ${item.CountryFa}</span><div class='yata_gdemo'><i>${item.DepartureCityFa}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`;
              dataList.unshift(items_search_local);
            } else if (lang === 'ar') {
              items_search_local = `<li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportAr ? item.AirportAr : item.AirportEn} - ${item.CountryAr ? item.CountryAr : item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityAr ? item.DepartureCityAr : item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`;
              dataList.unshift(items_search_local);
            } else {
              items_search_local = `<li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportEn} - ${item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`;
              dataList.unshift(items_search_local);
            }
          });
          list_popular_package.append(`<div class='history_items_search'><h2>${useXmltag("History")} <button type='button' onclick="deletePackageLocalStorage('origin' , event)">${useXmltag("Clear")}</button> </h2><ul>${dataList.join('')}</ul></div>`);
        } else if (type == 'destination' && storedData['destination']) {
          data = storedData['destination'];
          dataList = [];
          data.forEach((item) => {
            let json_sub_value = JSON.stringify({
              AirportFa: item.AirportFa,
              AirportAr: item.AirportAr,
              AirportEn: item.AirportEn,
              CountryFa: item.CountryFa,
              CountryEn: item.CountryEn,
              CountryAr: item.CountryAr,
              CityFa: item.DepartureCityFa,
              CityEn: item.DepartureCityEn,
              CityAr: item.DepartureCityAr,
              CityCode: item.DepartureCode,
              type: type,
            });

            let items_search_local;
            if (lang === 'fa') {
              items_search_local = `<li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportFa} - ${item.CountryFa}</span><div class='yata_gdemo'><i>${item.DepartureCityFa}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`;
              dataList.unshift(items_search_local);
            } else if (lang === 'ar') {
              items_search_local = `<li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportAr ? item.AirportAr : item.AirportEn} - ${item.CountryAr ? item.CountryAr : item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityAr ? item.DepartureCityAr : item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`;
              dataList.unshift(items_search_local);
            } else {
              items_search_local = `<li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'><div class='div_c_sr'><i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i><span class='c-text'>${item.AirportEn} - ${item.CountryEn}</span><div class='yata_gdemo'><i>${item.DepartureCityEn}</i><em> ( ${item.DepartureCode} ) </em></div></div></li>`;
              dataList.unshift(items_search_local);
            }
          });
          list_popular_package.append(`<div class='history_items_search'><h2>${useXmltag("History")} <button type='button' onclick="deletePackageLocalStorage('destination' , event)">${useXmltag("Clear")}</button> </h2><ul>${dataList.join('')}</ul></div>`);
        }
      }

      // اضافه کردن شهرهای محبوب برای پکیج
      $(response.data).each(function(key, value) {
        let sub_items_search = [];
        let sub_items_search_ul = '';

        if (value.sub != undefined) {
          $(value.sub).each(function(key_sub, value_sub) {
            let json_sub_value = JSON.stringify({
              AirportFa: value_sub.AirportFa,
              AirportAr: value_sub.AirportAr,
              AirportEn: value_sub.AirportEn,
              CountryFa: value_sub.CountryFa,
              CountryEn: value_sub.CountryEn,
              CountryAr: value_sub.CountryAr,
              CityFa: value_sub.DepartureCityFa,
              CityEn: value_sub.DepartureCityEn,
              CityAr: value_sub.DepartureCityAr,
              CityCode: value_sub.DepartureCode,
              type: type,
            });

            sub_items_search += `
              <li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'> 
                <div class='div_c_sr'>
                  <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                  <span class='c-text'>`;

            if (lang == 'fa') {
              sub_items_search += ` ${value_sub.AirportFa} - ${value_sub.CountryFa} `;
            } else if (lang == 'ar') {
              sub_items_search += ` ${value_sub.AirportAr ? value_sub.AirportAr : value_sub.AirportEn} - ${value_sub.CountryAr ? value_sub.CountryAr : value_sub.CountryEn} `;
            } else {
              sub_items_search += ` ${value_sub.AirportEn} - ${value_sub.CountryEn} `;
            }

            sub_items_search += ` </span>
                  <div class='yata_gdemo'>`;

            if (lang == 'fa') {
              sub_items_search += ` <i>${value_sub.DepartureCityFa}</i> `;
            } else if (lang == 'ar') {
              sub_items_search += ` <i>${value_sub.DepartureCityAr ? value_sub.DepartureCityAr : value_sub.DepartureCityEn}</i> `;
            } else {
              sub_items_search += ` <i>${value_sub.DepartureCityEn}</i> `;
            }

            sub_items_search += ` <em>(${value_sub.DepartureCode})</em>
                  </div>
                </div>
              </li>`;
          });
          sub_items_search_ul = `<ul class="sub-items-package">${sub_items_search}</ul>`;
        }

        let json_sub_value = JSON.stringify({
          AirportFa: value.AirportFa,
          AirportAr: value.AirportAr,
          AirportEn: value.AirportEn,
          CountryFa: value.CountryFa,
          CountryEn: value.CountryEn,
          CountryAr: value.CountryAr,
          CityFa: value.DepartureCityFa,
          CityEn: value.DepartureCityEn,
          CityAr: value.DepartureCityAr,
          CityCode: value.DepartureCode,
          type: type,
        });

        items_search += `
          <li onclick='selectPackagePopularItem(${json_sub_value} , event , $(this))'> 
            <div class='div_c_sr'>
              <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
              <span class='c-text'>`;

        if (lang == 'fa') {
          items_search += ` ${value.AirportFa} - ${value.CountryFa} `;
        } else if (lang == 'ar') {
          items_search += ` ${value.AirportAr ? value.AirportAr : value.AirportEn} - ${value.CountryAr ? value.CountryAr : value.CountryEn} `;
        } else {
          items_search += ` ${value.AirportEn} - ${value.CountryEn} `;
        }

        items_search += `</span>
              <div class='yata_gdemo'>`;

        if (lang == 'fa') {
          items_search += ` <i>${value.DepartureCityFa}</i> `;
        } else if (lang == 'ar') {
          items_search += ` <i>${value.DepartureCityAr ? value.DepartureCityAr : value.DepartureCityEn}</i> `;
        } else {
          items_search += ` <i>${value.DepartureCityEn}</i> `;
        }

        items_search += `<em>(${value.DepartureCode})</em>
              </div>
            </div>
          </li>
          ${sub_items_search_ul}`;
      });

      // اضافه کردن بخش شهرهای محبوب به لیست پکیج
      if (items_search.length > 0) {
        list_popular_package.append(`<h2>${useXmltag("Busy")}</h2><ul class="main-items-package">${items_search}</ul>`);
      }
    },
    error: function(error) {
      console.error('Error loading popular cities for package:', error);
    },
  });
}
function selectPackagePopularItem(obj, event) {
  jumping(obj.type, "package", obj.CityCode);

  $('.iata-' + obj.type + '-package-js').val(obj.AirportFa + ' - ' + obj.CityCode);
  $('.iata-' + obj.type + '-package-js').removeClass("border-red");
  $('.' + obj.type + '-package-js').val(obj.CityCode);

  // ذخیره کن که این فیلد قبلاً مقدار داشته
  $('.iata-' + obj.type + '-package-js').attr('data-selected', 'true');

  // ذخیره در localStorage مخصوص پکیج
  savePackageSearchedCity(obj);

  // بستن همه لیست‌های مربوط به این فیلد
  $('.list-' + obj.type + '-airport-package-js').html('').hide();
  $('.list_popular_package_' + obj.type + '-js').hide();  // این خط رو اضافه کن

  // اگر مبدأ انتخاب شده، برو به مقصد و لیست محبوب مقصد رو نشون بده
  if (obj.type === 'origin') {
    $('.iata-destination-package-js').focus();
    setTimeout(function() {
      getPopularCitiesForPackage('destination');
      $('.list_popular_package_destination-js').show();
    }, 300);
  }

  // اگه مقصد انتخاب شد، برو به فیلد بعدی (مثلاً تاریخ)
  if (obj.type === 'destination') {
    $('.package-date-js').focus();
  }

  event.stopPropagation();
}
function savePackageSearchedCity(cityData) {
  let storedData = JSON.parse(localStorage.getItem('packageSearchedCities')) || {};
  let type = cityData.type == 'origin' ? 'origin' : 'destination';

  if (!storedData[type]) {
    storedData[type] = [];
  }

  // بررسی تکراری نبودن
  let isDuplicate = storedData[type].some(item =>
      item.DepartureCode === cityData.CityCode
  );

  if (!isDuplicate) {
    // ساخت object با ساختار مناسب
    let cityObject = {
      AirportFa: cityData.AirportFa,
      AirportAr: cityData.AirportAr,
      AirportEn: cityData.AirportEn,
      CountryFa: cityData.CountryFa,
      CountryEn: cityData.CountryEn,
      CountryAr: cityData.CountryAr,
      DepartureCityFa: cityData.CityFa,
      DepartureCityEn: cityData.CityEn,
      DepartureCityAr: cityData.CityAr,
      DepartureCode: cityData.CityCode,
      FlightType: 'international'
    };

    storedData[type].unshift(cityObject);

    // محدودیت به 5 آیتم
    if (storedData[type].length > 5) {
      storedData[type] = storedData[type].slice(0, 5);
    }

    localStorage.setItem('packageSearchedCities', JSON.stringify(storedData));
  }
}
function deletePackageLocalStorage(type, event) {
  let storedData = JSON.parse(localStorage.getItem('packageSearchedCities')) || {};
  if (type == 'origin') {
    delete storedData.origin;
  } else if (type == 'destination') {
    delete storedData.destination;
  }
  localStorage.setItem('packageSearchedCities', JSON.stringify(storedData));

  // بستن لیست و باز کردن مجدد
  let list_popular = $('.list_popular_package_' + type + '-js');
  list_popular.html('').hide();
  setTimeout(function() {
    getPopularCitiesForPackage(type);
  }, 100);

  if (event) {
    event.stopPropagation();
    event.preventDefault();
  }
}
function getCitiesForPackage(obj, type) {
  let list_flight_searched = $('.list-' + type + '-airport-package-js');
  let iata = $(obj).val();

  // اگه اینپوت قبلاً مقدار داشته و الان خالی شده، لیست محبوب رو نشون بده
  if (iata.length === 0) {
    $('.list-' + type + '-airport-package-js').hide();
    $('.list_popular_package_' + type + '-js').show();
    return;
  }

  if (iata.length >= 2) {
    // مخفی کردن لیست محبوب
    $('.list_popular_package_' + type + '-js').hide();

    // نمایش لودینگ
    list_flight_searched.html(Loading_package).show();

    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'cityForSearchPackage',
        className: 'routeFlight',
        iata,
        is_json: true,
      }),
      success: function(response) {
        let items_search = [];
        list_flight_searched.html('');

        $(response.data).each(function(key, value) {
          let sub_items_search = [];
          let sub_items_search_ul = '';

          if (value.sub != undefined) {
            $(value.sub).each(function(key_sub, value_sub) {
              let json_sub_value = JSON.stringify({
                DepartureCode: value_sub.DepartureCode,
                DepartureCityFa: value_sub.DepartureCityFa,
                AirportFa: value_sub.AirportFa,
                CountryFa: value_sub.CountryFa,
                type: type,
              });

              sub_items_search += `<li onclick='selectPackageAirportItem(${json_sub_value} , event)'> 
                <div class='div_c_sr'>
                  <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                  <span class='c-text'>${value_sub.AirportFa} - ${value_sub.CountryFa}</span>
                  <div class='yata_gdemo'>
                    <i>${value_sub.DepartureCityFa}</i>
                    <em>(${value_sub.DepartureCode})</em>
                  </div>
                </div>
              </li>`;
            });
            sub_items_search_ul = `<ul>${sub_items_search}</ul>`;
          }

          let json_sub_value = JSON.stringify({
            DepartureCode: value.DepartureCode,
            DepartureCityFa: value.DepartureCityFa,
            AirportFa: value.AirportFa,
            CountryFa: value.CountryFa,
            type: type,
          });

          items_search += `<li onclick='selectPackageAirportItem(${json_sub_value} , event)'> 
            <div class='div_c_sr'>
              <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
              <span class='c-text'>${value.AirportFa} - ${value.CountryFa}</span>
              <div class='yata_gdemo'>
                <i>${value.DepartureCityFa}</i>
                <em>(${value.DepartureCode})</em>
              </div>
            </div>
          </li> ${sub_items_search_ul}`;
        });

        if (items_search.length === 0) {
          list_flight_searched.html(`<ul>${error_flight}</ul>`).show();
        } else {
          list_flight_searched.html(`<ul>${items_search}</ul>`).show();
        }
      },
      error: function(error) {
        list_flight_searched.html(`<ul>${error_flight}</ul>`).show();
      },
    });
  } else if(iata.length === 0) {
    // اگه اینپوت خالی شد، لیست جستجو رو مخفی کن و لیست محبوب رو نشون بده
    $('.list-' + type + '-airport-package-js').hide();
    $('.list_popular_package_' + type + '-js').show();
  } else {
    list_flight_searched.html(`<ul>${error_flight_text}</ul>`).show();
  }
}
function selectPackageAirportItem(obj, event) {
  jumping(obj.type, "package", obj.DepartureCode);

  $('.iata-' + obj.type + '-package-js').val(obj.AirportFa + ' - ' + obj.DepartureCode);
  $('.iata-' + obj.type + '-package-js').removeClass("border-red");
  $('.' + obj.type + '-package-js').val(obj.DepartureCode);

  // بستن همه لیست‌های مربوط به این فیلد
  $('.list-' + obj.type + '-airport-package-js').html('').hide();
  $('.list_popular_package_' + obj.type + '-js').hide();  // این خط رو اضافه کن

  // اگر مبدأ انتخاب شده، برو به مقصد و لیست محبوب مقصد رو نشون بده
  if (obj.type === 'origin') {
    $('.iata-destination-package-js').focus();
    setTimeout(function() {
      getPopularCitiesForPackage('destination');
      $('.list_popular_package_destination-js').show();
    }, 300);
  }

  // اگه مقصد انتخاب شد، برو به فیلد بعدی
  if (obj.type === 'destination') {
    $('.package-date-js').focus();
  }

  event.stopPropagation();
}


$('.box-of-count-package-passenger-boxes-js,.div_btn').on('click', function(e) {
  $('.cbox-package-count-passenger-js').toggle()
  $(this).parents().find('.down-count-passenger').toggleClass('fa-caret-up')
  e.stopPropagation()
})
$('.cbox-package-count-passenger-js').click((e) => {
  e.stopPropagation()
})

$('body').click(() => {
  $('.cbox-package-count-passenger-js').hide()
  $(`
  .list-origin-airport-package-js,
  .list-destination-airport-package-js
  `).hide()
  if ($('.origin-package-js').val() === '') {
    $(".iata-origin-package-js").val('')
  }
  if ($('.destination-package-js').val() === '') {
    $(".iata-destination-package-js").val('')
  }
})


function reversRoutePackage(type, number_selected) {

  let rout_origin = origin_input.val()
  let rout_destination = destination_input.val()
  let origin = $('.origin-package-js').val()
  let destination = $('.destination-package-js').val()
  if (rout_destination !== '') {
    origin_input.val(rout_destination)
    destination_input.val(rout_origin)
    $('.origin-package-js').val(destination)
    $('.destination-package-js').val(origin)

  }

}

function dataSearchPackage(type) {
  let number_adult = parseInt($('.' + type + '-adult-js').val())
  let number_child = parseInt($('.' + type + '-child-js').val())
  let number_infant = parseInt($('.' + type + '-infant-js').val())
  let origin = $('.origin-' + type + '-js')
  let destination = $('.destination-' + type + '-js')
  let departure_date = $('.departure-date-' + type + '-js')
  let return_date = $('.' + type + '-arrival-date-js')
  let today = dateNow('-')
  console.log('.destination-' + type + '-js')
  console.log(destination)
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
    departure_date: departure_date,
    return_date: return_date,
    today: today,
  }
}
function doPackageSearch(obj) {
  let path = `${obj.origin}-${obj.destination}`
  let date = `${obj.departure_date}&${obj.return_date}`

  let count_passenger = `${obj.number_adult}-${obj.number_child}-${obj.number_infant}`
  let url = `${amadeusPathByLang}searchPackage/1/${path}/${date}/Y/${count_passenger}/1`
  console.log(url)
  let target = $(obj).parents().find('#package_form').data('target')
  if(target != 'undefind' && target == '_blank' ){

    window.open(url , '_blank')
  }else {
    window.open(url , '_self')
  }

}
function searchPackage(type) {
  let no_error = true
  let obj_url = dataSearchPackage(type)
  console.log(obj_url)
  no_error = checkCountAdult(obj_url.number_adult)
  doPackageSearch(obj_url)

}