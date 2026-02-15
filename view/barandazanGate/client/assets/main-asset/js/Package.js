const origin_input = $('.iata-origin-package-js')
const destination_input = $('.iata-destination-package-js')
origin_input.on('keyup', function() {
  getCities(this, 'origin')
})
destination_input.on('keyup', function() {
  getCities(this, 'destination')
})
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

function getCities(obj, type) {
  let list_flight_searched = $('.list-' + type + '-airport-package-js')
  $('.' + type + '-package-js').val('')
  $('.list_popular_' + type + '_external-js').hide();
  list_flight_searched.html(Loading_flight)
  let iata = $(obj).val()
  if (iata.length >= 2) {
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
                AirportFa: value_sub.AirportFa,
                CountryFa: value_sub.CountryFa,
                type: type,
              })
              sub_items_search += `<li onclick='selectAirportItem(${json_sub_value} , event)'  class=''> 
                                      <div class='div_c_sr'>
                                      <i class="svg_icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg></i>
                                            <span class='c-text'>
                                            ${value_sub.AirportFa} - ${value_sub.CountryFa}
                                            </span>
                                            <div class='yata_gdemo'>
                                              <i>${value_sub.DepartureCityFa}</i>
                                              <em>(${value_sub.DepartureCode})</em>
                                            </div>
                                      </div>
                                    </li>`
            })

            sub_items_search_ul = `<ul>${sub_items_search}</ul>`
          }
          let json_sub_value = JSON.stringify({
            DepartureCode: value.DepartureCode,
            DepartureCityFa: value.DepartureCityFa,
            AirportFa: value.AirportFa,
            CountryFa: value.CountryFa,
            type: type,
          })
          items_search += `<li onclick='selectPackageAirportItem(${json_sub_value} , event)'  class=''> 
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
  else if(iata.length === 0) {
    $('.list-origin' + type + '-airport-package-js , .list-' + type + '-airport-package-js').hide();
    $('.list_popular_' + type + '_external-js').show()
  } else {
    list_flight_searched.html(`<ul>${error_flight_text}</ul>`).show()
  }
}
function selectPackageAirportItem(obj, event) {
  jumping(obj.type , "package" , obj.DepartureCode)
  $('.iata-' + obj.type + '-package-js').val(obj.AirportFa + ' - ' + obj.DepartureCode)
  $('.iata-' + obj.type + '-package-js').removeClass("border-red")
  $('.' + obj.type + '-package-js').val(obj.DepartureCode)
  $('.list-' + obj.type + '-airport-package-js').html('').hide()
  event.stopPropagation()
}
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