let response_value;
/* *** List of hotels for preview *** */
let getResultExternalHotelPreview = function (countryNameEn, cityNameEn, startDate, nights) {
    setTimeout(function () {
        $(".resultExternalHotelSearchAlaki").html('');
    }, 10000);

    /*$.ajax({
        type: "POST",
        url: amadeusPath + 'external_hotel_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'getResultExternalHotelPreview',
            countryNameEn: countryNameEn,
            cityNameEn: cityNameEn,
            startDate: startDate,
            nights: nights
        },
        success: function (data) {
            setTimeout(function () {
                $(".resultExternalHotelSearchAlaki").html('');
            }, 10000);
        }
    });*/
}


let priceRangeSlider = function (minPrice, maxPrice) {
    console.log(minPrice);
    console.log(maxPrice);
    minPrice = parseInt(minPrice);
    maxPrice = parseInt(maxPrice);
    console.log(typeof minPrice);
    console.log(typeof maxPrice);
    $("#slider-range").slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        step: 500000,
        animate: false,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            let minRange = ui.values[0];
            let maxRange = ui.values[1];
            $(".filter-price-text span:nth-child(2) i").html(number_format(minRange));
            $(".filter-price-text span:nth-child(1) i").html(number_format(maxRange));
            let hotels = $(".hotel-result-item");
            hotels.hide().filter(function () {
                let price = parseInt($(this).data("price"), 10);
                return price >= minRange && price <= maxRange;
            }).show();

        }
    });

    $(".filter-price-text span:nth-child(2) i").html(number_format(minPrice));
    $(".filter-price-text span:nth-child(1) i").html(number_format(maxPrice));
};

let externalHotelSearchDetails = function(ajax_details){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        dataType: 'JSON',
        data: JSON.stringify(ajax_details),

        success: function(response){
            console.log(response)
            $('#city_name_fa').text(response.City);
            let loading_text = $(document).find('.text_loading');
            loading_text.find('> h4').html(translateXmlByParams('HotelSearchForCity', {'cityName': response.City}));
            loading_text.find('.night_text').html(translateXmlByParams('ForHowMenyNights', {'nightsCount': response.Night}));
            loading_text.find('.start_date_text').html(response.StartDate);
            loading_text.find('.end_date_text').html(response.EndDate);
            let count_text_span = $('.silence_span');
            count_text_span.html(useXmltag('Loading'));

            console.log(loading_text.find('.night_text').html());
            response_value = response;
            $("#autoComplateSearchIN").val(response.Country + ' - ' + response.City);
        },
        error: function(error){
            console.log(error)
        }
    })
}

$("body , html").click(function(e) {
    var target = $(e.target);
    if(!target.is('#autoComplateSearchIN')) {
        if (
          $("#autoComplateSearchIN").val() == ""&&
          $("#destination_city").val() == ""&&
          $("#destination_country").val() == ""){
            if(response_value){
                $("#autoComplateSearchIN").val(response_value.Country + ' - ' + response_value.City)
                $("#destination_city").val(response_value.City)
                $("#destination_country").val(response_value.Country)
            }
        }
        if (
          $("#autoComplateSearchIN").val() != ""&&
          $("#destination_city").val() == ""&&
          $("#destination_country").val() == ""){
            if(response_value){
            $("#autoComplateSearchIN").val(response_value.Country + ' - ' + response_value.City)
            $("#destination_city").val(response_value.City)
            $("#destination_country").val(response_value.Country)
            }
        }
    }
})

let getResultExternalHotelSearch = function (countryNameEn, cityNameEn, startDate, nights, rooms,nationality) {

    // $('#city_name_fa').text(cityNameEn);
    // let loading_text = $(document).find('.text_loading');
    // loading_text.find('> h4').html(translateXmlByParams('HotelSearchForCity', {'cityName': cityNameEn}));
    // loading_text.find('.night_text').html(translateXmlByParams('ForHowMenyNights', {'nightsCount': nights}));
    // loading_text.find('.start_date_text').html(startDate);
    // loading_text.find('.end_date_text').html('');
    // console.log(loading_text.find('.night_text').html());
    let json_data = {
        className : 'resultSearchExternalHotel',
        method : 'getHotels',
        // flag: 'getResultExternalHotelSearch',
        countryNameEn: countryNameEn,
        cityNameEn: cityNameEn,
        startDate: startDate,
        nights: nights,
        rooms: rooms,
        nationality : nationality
    }
    let parsJsonCapacity = {}
    parsJsonCapacity.className = 'fullCapacity'
    parsJsonCapacity.method = 'getFullCapacitySite'
    parsJsonCapacity.id = 1
    parsJsonCapacity.is_json = 1
    let full_capacity_image = '';
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        data: JSON.stringify(parsJsonCapacity),
        success: function(data) {
            if(data.pic_url != '') {
                full_capacity_image = data.pic_url
            }else {
                full_capacity_image = amadeusPath + 'view/client/assets/images/fullCapacity.png'
            }
        }
    })
    $.ajax({
        type: "POST",
        url: amadeusPath + 'ajax',
        dataType: 'JSON',
        data: JSON.stringify(json_data),
        success: function (data) {
            console.log('he he he he h')
            let advertises = data.advertises;
            let request_number = data.requestNumber
            if (data.error) {
                // let htmlError = '<div class="userProfileInfo-messge">' +
                //     '<div class="messge-login BoxErrorSearch">' +
                //     '<div style="float: right;">  <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>' +
                //     '</div>' +
                //     '<div class="TextBoxErrorSearch"><br>' + data.message[0] +
                //     '</div>' +
                let htmlError = `<div id='show_offline_request'>
                    <div class='fullCapacity_div'>
                        <img src='${full_capacity_image}' alt='fullCapacity'>
                            <h2>${useXmltag('Nohotel')}</h2>
                              <kbd class="kbd_style">${request_number}</kbd>
                    </div>
                </div>`;
                $("#hotelResult").html(htmlError);
                $('.silence_span').html(`${useXmltag('NothingFound')}`)
                /*if (data.message == 'isAccess') {
                    $.alert({
                        title: useXmltag("hotel"),
                        icon: 'fa fa-check',
                        content: useXmltag("Noaccesstihspage"),
                        rtl: true,
                        type: 'green',
                    });
                } else {
                    $.alert({
                        title: useXmltag("hotel"),
                        icon: 'fa fa-check',
                        content: 'سیستم درحال به روز رسانی قیمت می باشد...',
                        rtl: true,
                        type: 'green',
                    });
                    setTimeout(function () {
                        getResultExternalHotelSearch(countryNameEn, cityNameEn, startDate, nights, rooms);
                    }, 20000);
                }*/
            }
            else {

                // $("#logExternalHotel").html(data.logs);
                // $("#city_name_fa").html(data.cityNameFa);
                // $("#autoComplateSearchIN").val(data.cityNameFa);
                $("#loginIdApi").val(data.loginIdApi);
                $("#searchIdApi").val(data.searchIdApi);
                $('#boxCountHotels').removeClass('displayN');
                $("#countHotelHtml").html(parseInt(data.hotels.length));
                $('.silence_span').html(`<b id='countHotelHtml'>${parseInt(data.hotels.length)}</b> ${useXmltag('silenceSpanHotel')}`)
                $("#countHotels").val(parseInt(data.hotels.length));
                $("#facilitiesHtml").append(data.htmlFacilitiesPage);

                $('.loader-box-count-hotels').addClass('displayN');

                // sort -> min_room_price
                for (let i = 0; i < parseInt(data.hotels.length); i++) {
                    for (let j = i; j < parseInt(data.hotels.length); j++) {
                        if (data.hotels[j]['hotelStars'] >= data.hotels[i]['hotelStars']) {
                            temp = data.hotels[i];
                            data.hotels[i] = data.hotels[j];
                            data.hotels[j] = temp;
                        }
                    }
                }
                for (let i = 0; i < parseInt(data.hotels.length); i++) {
                    for (let j = i; j < parseInt(data.hotels.length); j++) {
                        if (data.hotels[j]['amountCurrency'] > 0 && data.hotels[j]['amountCurrency'] <= data.hotels[i]['amountCurrency']) {
                            temp = data.hotels[i];
                            data.hotels[i] = data.hotels[j];
                            data.hotels[j] = temp;
                        }
                    }
                }
                // // اگر هتل رزرواسیون قیمت داشت بالاتر از همه نمایش بدهد
                // for (let i = 0; i < parseInt(data.hotels.length); i++) {
                //     for (let j = i; j < parseInt(data.hotels.length); j++) {
                //         if (( data.hotels[j]['typeApp'] == 'reservation') && data.hotels[j]['amountCurrency'] > 0) {
                //             temp = data.hotels[i];
                //             data.hotels[i] = data.hotels[j];
                //             data.hotels[j] = temp;
                //         }
                //     }
                // }
                let specialHotels = []
                let noneSpecialHotels = []

                for (let i = 0; i < parseInt(data.hotels.length); i++) {
                    if(data.hotels[i]['isSpecial'] == 'yes'){
                        specialHotels.push(data.hotels[i])
                    }else {
                        noneSpecialHotels.push(data.hotels[i])
                    }

                }

                data.hotels = specialHotels.concat(noneSpecialHotels);
                $.each(data.hotels, function (index, item) {

                    let Facilities = FreeBreakfast = ribon = hotelname = onClick = '';
                    if (item.typeApp == 'reservation') {
                        hotelname = item.HotelName;
                        FreeBreakfast = item.FreeBreakfast;
                        Facilities = item.Facilities;
                        if(item.isSpecial == 'yes'){
                            ribon = `<div class="ribbon-special-external-hotel"><span><i>${useXmltag('Specialhotel')}</i></span></div>`;
                        }
                        onClick = `hotelDetail('reservation','${item.HotelIndex}','${item.nameEnUrl}','${data.searchIdApi}')`;
                    } else {
                        hotelname = `${item.HotelPersianName} ${item.HotelName}`;
                        FreeBreakfast = '';
                        Facilities = 'MINIBAR|TV|WI-FI|ROOM SERVICE|SATELLITE TV';
                        ribon = '';
                    }
                    let nameWithLink = reserveBtn = imgClick = '';
                    let htmlHotel = `<div class="hotelResultItem" id="boxHotel_${item.HotelIndex}">
                            <div id="a1" class="hotel-result-item"
                                 data-typeApplication="${item.typeApp}"
                                 data-price="${item.amountCurrency}"
                                 data-priority='' 
                                 data-special='${item.isSpecial}'
                                 data-star="${item.hotelStars}"
                                 data-freeBreakfast="${item.freeBreakfast}"
                                 data-facilities="${item.hotelFacilities}"
                                 data-hotelName="${item.HotelName.toLowerCase()}"
                                 data-hotelAddress="${item.HotelAddress.toLowerCase()}">`;
                        let searched_rooms = $('#searchRooms').val();
                        let type = $('#type').val();
                        let nationality = $('#nationality').val();
                        let specialHotelRabon = "";
                  
                        let single_detail_link = `${amadeusPathByLang}detailHotel/${item.typeApp}/${item.HotelIndex}/${item.RequestNumber}&searchRooms=${searched_rooms}&type=${type}&nationality=${nationality}`;

                            // nameWithLink = `<a onclick="hotelDetail('${item.typeApp}','${item.HotelIndex}','${item.nameEnUrl}','${item.RequestNumber}')"><b class="
                    // ">${item.HotelName}</b></a>`;
                            nameWithLink = `<a target='_blank' href='javascript:' class='hotel-result-item-name hotelNameResult text-left'>${item.HotelName}</a>`;
                            if(item.isSpecial == 'yes'){
                                specialHotelRabon = `<div class='ribbon-special-hotel'>${useXmltag( 'Specialhotel' )}</div>`;
                            }
                            nameWithLink += `<kbd style="color: rgba(0,0,0,0); background: none;box-shadow:none;">S${item.SourceId}</kbd>`;
                            if(item.typeApp == 'reservation'){
                                reserveBtn = `<a onclick="hotelDetail('${item.typeApp}','${item.HotelIndex}','${item.nameEnUrl}','${item.RequestNumber}')" class="bookbtn mt1">${useXmltag( 'ShowReservation' )} <svg data-v-2824aec9="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path data-v-2824aec9="" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg></a>`;
                            }else {
                                reserveBtn = `<a target="_blank" href="${single_detail_link}" class="bookbtn mt1">${useXmltag( 'ShowReservation' )} <svg data-v-2824aec9="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path data-v-2824aec9="" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg></a>`;

                            }

                            // imgClick = `<a onClick="hotelDetail('${item.typeApp}','${item.HotelIndex}','${item.nameEnUrl}','${item.RequestNumber}')"><img src="${item.pictureUrl}" alt="${item.HotelName}"></a>`;
                            imgClick = `<a><img src="${item.pictureUrl}" alt="${item.HotelName}"></a>`;

                        // if(item.typeApp == 'externalApi'){
                        //     nameWithLink = `<a onClick="hotelDetail('${item.typeApp}','${item.HotelIndex}','${item.nameEnUrl}','${item.RequestNumber}')"><b class="hotel-result-item-name txtLeft">${item.HotelName}</b></a>`;
                        //
                        //     reserveBtn = `<a onclick="hotelDetail('${item.typeApp}','${item.HotelIndex}','${item.nameEnUrl}','${item.RequestNumber}')" class="bookbtn mt1 site-bg-main-color  site-main-button-color-hover">${useXmltag( 'ShowReservation' )}</a>`;
                        //
                        //     imgClick = `<a onClick="hotelDetail('${item.typeApp}','${item.HotelIndex}','${item.nameEnUrl}','${item.RequestNumber}')"><img src="${item.pictureUrl}" alt=""></a>`;
                        // }

                        let starsEmpty = starsFill = '';
                        if( item.hotelStars > 0 ) {
                            starsFill += ' <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M11.892 3.005c-.429.041-.8.325-.95.735l-1.73 5.182-5.087-.001a1.122 1.122 0 0 0-.675 2.021l4.077 3.078-1.834 5.504c-.153.465.011.974.407 1.261l.093.061c.383.224.868.203 1.232-.062l4.577-3.442 4.59 3.408c.4.292.936.292 1.331.005l.087-.07a1.12 1.12 0 0 0 .32-1.189l-1.856-5.477 4.078-3.079a1.12 1.12 0 0 0 .39-1.251 1.125 1.125 0 0 0-1.067-.768h-5.087l-1.724-5.163A1.131 1.131 0 0 0 12 3l-.108.005Z"></path></svg>';
                        }
                        // for ( ss = 5; ss > item.hotelStars; ss -- ) {
                        let starText = ''
                        if(item.hotelStars > 0 ) {
                            starText = item.hotelStars
                        }

                        let facilities_list = `<ul class="hotelpreferences facilities facilities-21"><div class="external-hotel-facilities">`;


                    $.each(item.facilitiesList,function(faIndex,faItem){
                            if(faItem){
                            facilities_list += `<span>${faItem}</span>`;
                            if (faIndex < item.facilitiesList.length - 1) {
                                facilities_list += `<span>|</span>`;
                            }
                            }
                        });

                    facilities_list +=`</div></ul>`;
                        let withoutDiscountPrice = realPrice = clubPoint = '';
                        if(item.has_discount){
                            withoutDiscountPrice = `
            <div class="d-flex style_Discount">
                <span class="currency priceOff CurrencyCal" data-amount="${item.priceWithoutDiscount}">
                   ${number_format(item.priceWithoutDiscountCurrency.AmountCurrency)}
                </span> 
                <div class="ribbon-hotel site-bg-color-dock-border-top">
                  <span>
                    <i> %${item.discount} </i>
                  </span>
                </div>
            </div>
            `;}

                                realPrice = `
            <div class="price_main" style="display: flex; flex-direction: column; align-items: flex-start;">
            
                ${
                                   item.commissionPercent && item.commissionPercent > 0
                                      ? `
                    <div class="old_price_line">
                    <span class="ribbon-hotel site-bg-color-dock-border-top"">
                            ${item.commissionPercent}%
                        </span>
                        <h2 class="currency priceOff CurrencyCal" data-amount="${item.MinimumRoomPriceWithOutCom}"
                            style="color:#999; font-size:14px; margin:0;">
                            ${number_format(item.MinimumRoomPriceWithOutCom)}
                        </h2>
                    </div>
            
                    <div class="new_price_line" style="display:flex; align-items:center; gap:4px;">
                        <h2 class="CurrencyCal" data-amount="${item.minimumRoomPrice}"
                            style="color:#000; font-size:16px; margin:0;">
                            ${number_format(item.minimumRoomPrice)}
                        </h2>
                        <span class="CurrencyText" style="font-size:14px; color:#000;">${item.mainCurrency.TypeCurrency}</span>
                    </div>
                    `
                                      : `
                    <div class="new_price_line" style="display:flex; align-items:center; gap:4px;">
                        <h2 class="CurrencyCal" data-amount="${item.MinimumRoomPriceEachNightWithOutCom || item.minimumRoomPrice}"
                            style="color:#000; font-size:16px; margin:0;">
                            ${number_format(item.MinimumRoomPriceEachNightWithOutCom || item.minimumRoomPrice)}
                        </h2>
                        <span class="CurrencyText" style="font-size:14px; color:#000;">${item.mainCurrency.TypeCurrency}</span>
                    </div>
                    `
                                }
            
            </div>
            `;




                    htmlHotel += `<div class="cols_hotel hotel_content ">
                                    <div class="hotel-result-item-content external-hotel-content">
                                        <div class="hotel-result-item-text align-items-end">
                                        ${specialHotelRabon}
                                        <div class="parent-hotel-name-result">
                                          <div class='d-flex align-items-center gap-10 flex-row-reverse'>						                      
                                            ${nameWithLink}
											                    </div>
                                            <span class="rp-cel-hotel-star">
                                                <input type="hidden" id="starSortDep" name="starSortDep" value="${item.hotelStars}">
  											                          ${starsFill}
                                                  <span class='rp-cel-hotel-star_span'>${starText}</span>
                                            </span>
                                            </div>
                                            </span>
                                            <input id="idHotel" name="idHotel" type="hidden" value="${item.HotelIndex}">
                                        `;

                                          if(item.calculatePoint > 0){
                                              htmlHotel += `<div class="text_div_more_hotel_f">

                                            <span>${useXmltag('Yourpurchasepoints')} :</span> <i class="site-main-text-color">${item.calculatePoint} ${useXmltag('Point')}</i>
                                            <i class="flat_cup"></i>
                                            </div>`;}
                                           htmlHotel +=  `<span class="hotel-result-item-content-location external-hotel-location show-map-modal" data-longitude="${item.MapLang}" data-latitude="${item.MapLat}">
                                                        <span> 
                                                        <span>:</span>
                                                           ${useXmltag('Address')} 
                                                        </span>
                                            <span class='hotel_result_item_content_location_spanAddres'>
                                            ${item.HotelAddress}
                                            </span>
                                            </span>
                                            ${facilities_list}
                                        </div>

                                        <div class="hotel-result-item-bottom external-hotel-bottom">
                                            <div class="price-box-hotel justify-content-end justify-content-md-center">
                                                <span class='nightText' style="direction : ltr">${useXmltag('Price')} ${nights}   ${useXmltag('Night')} </span>
                                                ${withoutDiscountPrice}
                                                ${realPrice}
											                      ${reserveBtn}
											                      ${clubPoint}
											                      
${nights > 1 ? `
<div class='d-flex align-items-center pricePerNight'>
<h2 class='CurrencyCal' data-amount='${item.minimumRoomPriceEachNight}'>${number_format(item.mainCurrencyEachNight.AmountCurrency)}</h2>
<span>${translateXmlByParams('PriceForEachNight', {'Price': ''})}</span>
</div>
` : ''}
                      											</div>   
                                        </div>
                                    </div>
                                </div>

                                <div class="cols_hotel ">
                                    <div class="hotel-result-item-image external-hotel-image">
                                        ${imgClick}
                                    </div>
                                </div>

                            </div>
                        </div>`;
                    $("#hotelResult").append(htmlHotel);
                });
                if(advertises.length > 0){
                    let mainAdvertise = '<div class="advertises">';
                    console.log('Advertises');
                    $.each(advertises,function(index,item){
                        console.log('Advertise.item');
                        mainAdvertise += '<div class="advertise-item">';
                        mainAdvertise += item.content;
                        mainAdvertise += '</div>';
                    });
                    mainAdvertise += '</div>';
                    $(mainAdvertise).insertBefore('#hotelResult');
                }
                priceRangeSlider(data.minPrice, data.maxPrice);



            }
        },
        error: function (error) {
            $('.loader-for-external-hotel-end').hide();
            let error_message = (error.responseJSON.Message) ? error.responseJSON.Message : error.responseJSON.message[0];
            let htmlError = `<div class="userProfileInfo-messge"><div class="messge-login BoxErrorSearch"><div style="float: right;">  <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div><div class="TextBoxErrorSearch"><br>${error_message}</div></div></div>`;
            $("#hotelResult").html(htmlError);
        },
        complete: function () {
            setTimeout(function() {
                let sort_type = $('#sort_hotel_type').val()
                sortHotelList(sort_type)
            }, 3000)
            $('.loader-for-external-hotel-end').hide();
            $('.container_loading').hide();
        }
    });

}

