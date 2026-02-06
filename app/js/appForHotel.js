
$$(document).on("click", ".hotel-room-css-reset", function () {
    $$(".hotel-detail-inner .tabs").css("transform", "");
});


//رفتن به صفحه نمایش هتل ها
$$(document).on("click", ".searchHotelInternal", function () {

    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال جست وجو');
    $$(this).css('opacity', '0.5');

    var city = $$('#search-city-hotel').find('input').val();
    var startDate = $$('.startDate').find('input').val();
    var endDate = $$('.endDate').find('input').val();
    var nights = $$('#nights').val();

    if (city == '0' || startDate == '' || endDate == '' || nights == '') {

        var toastLargeMessage = app.toast.create({
            text: 'لطفا موارد لازم را پر نمائید',
            closeTimeout: 4000,
            position: 'top'
        });

        setTimeout(function () {
            $$('.searchHotelInternal').find('span').text('جست وجوی هتل');
            $$('.searchHotelInternal').css('opacity', '1');
            $$('.searchHotelInternal').find('i').addClass('myhidden');
        }, 2500);

        toastLargeMessage.open();


    } else {
        setTimeout(function () {
            $$('.SearchTicketInternal').find('span').text('جست وجوی هتل');
            $$('.SearchTicketInternal').css('opacity', '1');
            $$('.SearchTicketInternal').find('i').addClass('myhidden');

        }, 2500);
        app.router.navigate("/searchHotel/?cityId=" + city +
            "&startDate=" + startDate +
            "&endDate=" + endDate +
            "&nights=" + nights
        );
    }

});


//تغییر سرچ تاریخ
$$(document).on("click", ".reSearchHotelInternal", function () {

    $$('#reSearchHotelInternal').text('در حال جست وجو');
    $$('#reSearchHotelInternal').css('opacity', '0.5');

    var hotelId = $$('#hotelId').val();
    var typeApplication = $$('#typeApplication').val();
    var startDate = $$('.startDate').find('input').val();
    var endDate = $$('.endDate').find('input').val();
    var nights = $$('#editNight').find('input').val();
    //var nights = $$('#nights').val();


    if (startDate == '' || endDate == '' || nights == '') {

        var toastLargeMessage = app.toast.create({
            text: 'لطفا موارد لازم را پر نمائید',
            closeTimeout: 4000,
            position: 'top'
        });

        setTimeout(function () {
            $$('#reSearchHotelInternal').text('تغییر');
            $$('#reSearchHotelInternal').css('opacity', '1');
        }, 2500);

        toastLargeMessage.open();


    } else {
        setTimeout(function () {
            $$('#reSearchHotelInternal').text('تغییر');
            $$('#reSearchHotelInternal').css('opacity', '1');

        }, 2500);

        $$(".hidden-raft-input").remove();
        $$(".hidden-bargasht-input").remove();
        app.router.navigate("/hotelDetail/?hotelId=" + hotelId +
            "&typeApplication=" + typeApplication + "&startDate=" + startDate + "&endDate=" + endDate + "&nights=" + nights
        );
    }

});


$$(document).on("click", ".sorting-price,.sorting-time", function () {
    var selectID = $$(this).attr('class');
    var selected = '';
    var currentSelect = '';


    if (selectID == 'sorting-time') {
        currentSelect = $$('#currentTimeSort').val();
        if (currentSelect == 'asc') {
            $$('#currentTimeSort').val('desc');
        } else {
            $$('#currentTimeSort').val('asc');
        }
    } else if (selectID == 'sorting-price') {
        currentSelect = $$('#currentPriceSort').val();
        if (currentSelect == 'asc') {
            $$('#currentPriceSort').val('desc');
        } else {
            $$('#currentPriceSort').val('asc');
        }
    }

    if (currentSelect == 'asc') {
        selected = 'desc';
    } else {
        selected = 'asc';
    }

    var current_flight = '';
    var all_tickets = [];
    var temp = [];
    var current_sort_index = '';
    var key = '';

    var SearchResult = $$("#TicketInternal").find('.showListSort .blit-item');
    $$("#TicketInternal").html('');
    SearchResult.forEach(function (index) {
        current_flight = $$(this).parent();

        if (selectID == 'sorting-time') {
            current_sort_index = current_flight.find(".blit-i-time").html();
        } else if (selectID == 'sorting-price') {
            current_sort_index = current_flight.find(".blit-i-price span").html();
            current_sort_index = parseInt(current_sort_index.replace(/,/g, ''));
        }

        all_tickets.push({
            'content': current_flight.html(),
            'sortIndex': current_sort_index
        });
    });

    if (selected == 'asc') {
        for (var i = 0; i < parseInt(all_tickets.length); i++) {
            key = i;
            for (var j = i; j < parseInt(all_tickets.length); j++) {
                if (all_tickets[j]['sortIndex'] <= all_tickets[key]['sortIndex']) {
                    temp = all_tickets[i];
                    all_tickets[i] = all_tickets[j];
                    all_tickets[j] = temp;
                }
            }
        }
    }//end if
    else if (selected == 'desc') {
        for (var i = 0; i < parseInt(all_tickets.length); i++) {
            min = all_tickets[i];
            key = i;
            for (var j = i; j < parseInt(all_tickets.length); j++) {
                if (all_tickets[j]['sortIndex'] >= all_tickets[key]['sortIndex']) {
                    temp = all_tickets[i];
                    all_tickets[i] = all_tickets[j];
                    all_tickets[j] = temp;
                }
            }
        }
    }//end else if
    setTimeout(function () {
        for (i = 0; i < parseInt(all_tickets.length); i++) {
            // console.log(i + '======' + all_tickets[i]['content']);
            $$("#TicketInternal").append('<div class="showListSort">' + all_tickets[i]['content'] + '</div>');
        }
    }, 100);
});



$$(document).on("click", ".hotelTypeCheckboxAll", function () {
    var check = $$('#hotel-type-checkbox_all').prop('checked');
    if (check == true) {
        $$('.hotelTypeCheckbox:checked').forEach(function () {
            $$(this).prop("checked", false);
        });
    }
});
$$(document).on("click", ".hotelTypeCheckbox", function () {
    //$$('#hotel-type-checkbox_all').prop("checked", false);
    $$('#hotel-type-checkbox_all').prop("checked", true);
    $$('.hotelTypeCheckbox:checked').forEach(function () {
        var check = $$(this).prop('checked');
        if (check == true) {
            $$('#hotel-type-checkbox_all').prop("checked", false);
        }
    });
});


$$(document).on("click", ".hotelStarCheckboxAll", function () {
    var check = $$('#hotel-star-checkbox_all').prop('checked');
    if (check == true) {
        $$('.hotelStarCheckbox:checked').forEach(function () {
            $$(this).prop("checked", false);
        });
    }
});
$$(document).on("click", ".hotelStarCheckbox", function () {
    //$$('#hotel-star-checkbox_all').prop("checked", false);
    $$('#hotel-star-checkbox_all').prop("checked", true);
    $$('.hotelStarCheckbox:checked').forEach(function () {
        var check = $$(this).prop('checked');
        if (check == true) {
            $$('#hotel-star-checkbox_all').prop("checked", false);
        }
    });
});

$$(document).on("click", ".setFilterHotel", function () {

    var hotels = $$(".hotel-result-item");
    hotels.hide();

    var checkTypeAll = $$('#hotel-type-checkbox_all').prop('checked');
    var checkStarAll = $$('#hotel-star-checkbox_all').prop('checked');
    var checkPriceAll = $$('#checkPrice').val();
    var minPrice = $$('#minPriceWithoutComma').val();
    var maxPrice = $$('#maxPriceWithoutComma').val();
    //console.log('checkType ' + checkTypeAll);
    //console.log('checkStar ' + checkStarAll);
    //console.log('checkPrice ' + checkPriceAll);

    if (checkTypeAll == true && checkStarAll == true && checkPriceAll == 'true') {
        hotels.show();

    } else {

        var hotelTypeSelect = [];
        var hotelStarSelect = [];
        $$('.hotelTypeCheckbox:checked').forEach(function () {
            hotelTypeSelect.push($$(this).val());
        });
        $$('.hotelStarCheckbox:checked').forEach(function () {
            hotelStarSelect.push($$(this).val());
        });

        setTimeout(function () {
            hotels.filter(function () {
                var filterType = true;
                var filterStar = true;
                var filterPrice = true;
                var hotelType = parseInt($$(this).data("hotelType"), 10);
                var star = parseInt($$(this).data("star"), 10);
                var price = parseInt($$(this).data("price"), 10);
                if (checkTypeAll == false){
                    filterType = inArray(hotelType, hotelTypeSelect);
                }
                if (checkStarAll == false) {
                    filterStar = inArray(star, hotelStarSelect);
                }
                if (checkPriceAll == 'false') {
                    filterPrice = price >= minPrice && price <= maxPrice;
                }
                return filterType && filterStar && filterPrice;
            }).show();
        }, 200);

        //console.log('filterType ' + filterType);
        //console.log('filterStar ' + filterStar);
        //console.log('filterPrice ' + filterPrice);
        //console.log('-------------------------- ');

        /*setTimeout(function () {
            $$('.hotelTypeCheckbox:checked').forEach(function () {
                var value = $$(this).val();
                hotels.filter(function () {
                    var hotelType = parseInt($$(this).data("hotelType"), 10);
                    console.log('hotelType ' + hotelType + '    value ' + value);
                    return hotelType == value;
                }).show();
            });
        }, 2000);*/
    }

});


function inArray(find, array) {
    var check = 0;
    array.forEach(function (index, element) {
        var value = parseInt(index);
        if (find == value) {
            check = check + 1;
        }

    });
    if (check == 0){
        return false;
    } else {
        return true;
    }
}


function showListHotel() {
    var cityId = $$('#cityId').val();
    var startDate = $$('#startDate').val();
    var endDate = $$('#endDate').val();
    app.request({
        url: '../hotel_ajax.php',
        method: 'post',
        dataType: 'json',
        //send "query" to server. Useful in case you generate response dynamically
        data: {
            flag: 'getResultHotelLocalForApp',
            cityId: cityId,
            startDate: startDate,
            endDate: endDate
        },
        success: function (data) {
            $$('.first-preloader').show(); //var app is initialized by now
            setTimeout(function () {
                $$('.first-preloader').addClass("hide");
                $$('#resultHotelList').html('');
                $$('#resultHotelList').html(data);
            }, 10);
        }
    });
}

function sortHotel(value) {

    var allHotel = [];
    var temp = [];
    var current = '';
    var currentSortIndex = '';
    var key = '';

    var SearchResult = $$("#resultHotelList").find('.hotel-result-item');
    $$("#resultHotelList").html('');
    SearchResult.forEach(function (index) {
        current = $$(this);
        if (value == 'بیشترین ستاره' || value == 'کمترین ستاره') {
            currentSortIndex = parseInt(current.find("#starHotel").html());

        } else if (value == 'بیشترین قیمت' || value == 'کمترین قیمت') {
            currentSortIndex = current.find("#priceHotelTRoom").html();
            //currentSortIndex = parseInt(currentSortIndex.replace(/,/g, ''));
        }

        allHotel.push({
            'content': current.html(),
            'sortIndex': currentSortIndex
        });
    });


    var countHotel = parseInt(allHotel.length);

    if (value == 'بیشترین ستاره' || value == 'بیشترین قیمت') {

        for (var i = 0; i < countHotel; i++) {
            min = allHotel[i];
            key = i;
            for (var j = i; j < countHotel; j++) {
                if (allHotel[j]['sortIndex'] >= allHotel[key]['sortIndex']) {
                    temp = allHotel[i];
                    allHotel[i] = allHotel[j];
                    allHotel[j] = temp;
                }
            }
        }

    } else if (value == 'کمترین ستاره' || value == 'کمترین قیمت') {

        for (var i = 0; i < countHotel; i++) {
            min = allHotel[i];
            key = i;
            for (var j = i; j < countHotel; j++) {
                if (allHotel[j]['sortIndex'] <= allHotel[key]['sortIndex']) {
                    temp = allHotel[i];
                    allHotel[i] = allHotel[j];
                    allHotel[j] = temp;
                }
            }
        }
    }


    setTimeout(function () {
        for (i = 0; i < parseInt(allHotel.length); i++) {
            //console.log(i + '======' + allHotel[i]['content']);
            $$("#resultHotelList").append('<div class="hotel-result-item">' + allHotel[i]['content'] + '</div>');
        }
    }, 100);


}


// go page hotel detail
$$(document).on("click", "#viewHotel", function () {

    //$$(this).css('opacity', '0.5');

    var hotelId = $$(this).attr('hotelId');
    var typeApplication = $$(this).attr('typeApplication');
    var startDate = $$('#startDate').val();
    var endDate = $$('#endDate').val();
    var nights = $$('#nights').val();

    app.router.navigate("/hotelDetail/?hotelId=" + hotelId +
        "&typeApplication=" + typeApplication + "&startDate=" + startDate + "&endDate=" + endDate + "&nights=" + nights
    );

});


function ReplaceNumberWithCommas(yourNumber) {
    //Seperates the components of the number
    var n = yourNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
}


// for reserve room (reservation)
function selectRoom(roomId) {

    var typeApplication = $$('#typeApplication').val();
    var RoomCount = parseInt($$('#RoomCount' + roomId).val());

    if (RoomCount == 0) {

        if (typeApplication == 'reservation') {
            $$('#ExtraBed' + roomId).val(0);
            $$('#ExtraChildBed' + roomId).val(0);
        }
        $$('#room' + roomId).removeClass('choosen-room-rezervasyon');
        $$('#removeRoom' + roomId + ' .remove-room').addClass('myhidden');
        $$('#removeRoom' + roomId + ' .sheet-open').removeClass('myhidden');

    } else {

        $$('#room' + roomId).addClass('choosen-room-rezervasyon');
        $$('#removeRoom' + roomId + ' .remove-room').removeClass('myhidden');
        $$('#removeRoom' + roomId + ' .sheet-open').addClass('myhidden');

    }

    app.sheet.close('.my-sheet' + roomId);
    if (typeApplication == 'reservation') {
        checkForReserve(roomId);
    } else {
        calculateRoomPrices(roomId);
    }

}

function removeRoom(roomId) {

    var typeApplication = $$('#typeApplication').val();

    if (typeApplication == 'reservation') {
        $$('#ExtraChildBed' + roomId).val(0);
        $$('#ExtraBed' + roomId).val(0);
    }
    $$('#RoomCount' + roomId).val(0);

    $$('#room' + roomId).removeClass('choosen-room-rezervasyon');
    $$('#removeRoom' + roomId + ' .remove-room').addClass('myhidden');
    $$('#removeRoom' + roomId + ' .sheet-open').removeClass('myhidden');


    if (typeApplication == 'reservation') {
        calculateRoomPricesForReservation(roomId);
    } else {
        calculateRoomPrices(roomId);
    }
}


function calculateRoomPrices(roomId) {

    var RoomCount = $$('#RoomCount' + roomId).val();
    var priceRoom = $$('#priceRoom' + roomId).val();
    var typeRoomHotel = $$('#typeRoomHotel').val();

    var price = parseInt(RoomCount) * parseInt(priceRoom);
    var count = parseInt(RoomCount);

    $$('#finalRoomCount' + roomId).val(count);
    $$('#finalPriceRoom' + roomId).val(price);

    var priceHotel = 0;
    var countHotel = 0;
    var totalNumberRoomReserve = [];
    var resultIdRoom = typeRoomHotel.split('/');

    for (i = 0; i < resultIdRoom.length; i++) {

        if (parseInt($$('#finalRoomCount' + resultIdRoom[i]).val()) > 0) {

            priceHotel = parseInt(priceHotel) + parseInt($$('#finalPriceRoom' + resultIdRoom[i]).val());
            countHotel = parseInt(countHotel) + parseInt($$('#finalRoomCount' + resultIdRoom[i]).val());
            totalNumberRoomReserve.push(resultIdRoom[i] + '-' + parseInt($$('#finalRoomCount' + resultIdRoom[i]).val()));
        }

    }

    $$('#totalNumberRoom').val(countHotel);
    $$('#totalPriceHotel').val(priceHotel);
    $$("#totalNumberRoomReserve").val(totalNumberRoomReserve);
    $$('#roomFinalTxt').html(countHotel + " اتاق ");
    $$('#roomFinalPrice').html(ReplaceNumberWithCommas(priceHotel));

    if (countHotel > 0) {
        $$('#buttonReserveHotel').removeClass('myhidden');
    } else {
        $$('#buttonReserveHotel').addClass('myhidden');
    }

}


function checkForReserve(roomId) {

    var hotelId = $$('#hotelId').val();
    var startDate = $$('#startDate').val();
    var endDate = $$('#endDate').val();


    app.request({
        url: '../hotel_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {
            flag: 'checkForReserve',
            idRoom: roomId,
            idHotel: hotelId,
            startDate: startDate,
            endDate: endDate,
            dataTypeResult: 'json'
        },
        success: function (data) {

            if (data.message == 'success') {
                calculateRoomPricesForReservation(roomId);
            } else {
                var toastLargeMessage = app.toast.create({
                    text: 'امکان رزرو این اتاق، در تاریخ مورد نظر وجود ندارد.',
                    closeTimeout: 4000,
                    position: 'top'
                });
                $$('#RoomCount' + roomId).prop('disabled', 'disabled');
                toastLargeMessage.open();
            }

        }
    });

}

function calculateRoomPricesForReservation(roomId) {

    var roomCount = $$('#RoomCount' + roomId).val();
    var typeRoomHotel = $$('#typeRoomHotel').val();

    var CostkolHotelRoomDBL = $$('#CostkolHotelRoom_DBL' + roomId).val();
    var CostkolHotelRoomEXT = $$('#CostkolHotelRoom_EXT' + roomId).val();
    var CostkolHotelRoomCHD = $$('#CostkolHotelRoom_CHD' + roomId).val();

    var maximum_extra_beds = parseInt($$('#maximum_extra_beds' + roomId).val()) * roomCount;
    var maximum_extra_chd_beds = parseInt($$('#maximum_extra_chd_beds' + roomId).val()) * roomCount;

    var price = parseInt(roomCount) * parseInt(CostkolHotelRoomDBL);
    var count = parseInt(roomCount);

    //////تخت اضافه//
    var extraBed = $$('#ExtraBed' + roomId).val();
    var extraChildBed = $$('#ExtraChildBed' + roomId).val();
    if (extraBed > maximum_extra_beds) {
        var alert_text = 'حداکثر تعداد مجاز برای انتخاب تخت اضافه بزرگسال ' + maximum_extra_beds + ' نفر میباشد.';
        var toastLargeMessage = app.toast.create({
            text: alert_text,
            closeTimeout: 4000,
            position: 'top'
        });
        $$('#RoomCount' + roomId).prop('disabled', 'disabled');
        toastLargeMessage.open();
        return false;
    } else if (extraBed > 0) {
        price = parseInt(price) + (parseInt(extraBed) * parseInt(CostkolHotelRoomEXT));
    }
    if (extraChildBed > maximum_extra_chd_beds) {
        var alert_text = 'حداکثر تعداد مجاز برای انتخاب تخت اضافه کودک ' + maximum_extra_chd_beds + ' نفر میباشد.';
        var toastLargeMessage = app.toast.create({
            text: alert_text,
            closeTimeout: 4000,
            position: 'top'
        });
        $$('#RoomCount' + roomId).prop('disabled', 'disabled');
        toastLargeMessage.open();
        return false;
    } else if (extraChildBed > 0) {
        price = parseInt(price) + (parseInt(extraChildBed) * parseInt(CostkolHotelRoomCHD));
    }

    $$('#finalRoomCount' + roomId).val(count);
    $$('#finalPriceRoom' + roomId).val(price);

    var priceHotel = 0;
    var countHotel = 0;
    var totalNumberRoomReserve = [];
    var resultIdRoom = typeRoomHotel.split('/');

    for (var i = 0; i < resultIdRoom.length; i++) {

        if (parseInt($$('#finalRoomCount' + resultIdRoom[i]).val()) > 0) {
            priceHotel = parseInt(priceHotel) + parseInt($$('#finalPriceRoom' + resultIdRoom[i]).val());
            countHotel = parseInt(countHotel) + parseInt($$('#finalRoomCount' + resultIdRoom[i]).val());
            totalNumberRoomReserve.push(resultIdRoom[i] + '-' + parseInt($$('#finalRoomCount' + resultIdRoom[i]).val()));
        }

    }

    $$('#totalNumberRoom').val(countHotel);
    $$('#totalPriceHotel').val(priceHotel);
    $$("#totalNumberRoomReserve").val(totalNumberRoomReserve);
    $$('#roomFinalTxt').html(countHotel + " اتاق ");
    $$('#roomFinalPrice').html(ReplaceNumberWithCommas(priceHotel));


    if (countHotel > 0) {
        $$('#buttonReserveHotel').removeClass('myhidden');
    } else {
        $$('#buttonReserveHotel').addClass('myhidden');
    }
}


function checkLogin() {

    //$$('.popup-close').trigger('click');

    $$('#buttonReserveHotel a').text('در حال بررسی');
    $$('#buttonReserveHotel a').css('opacity', '0.5');

    app.request({
        url: '../hotel_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {
            flag: 'CheckedLogin',
            dataTypeResult: 'json'
        },
        success: function (data) {

            if (data.message == 'successLoginHotel') {
                reserveHotel();
            } else {
                app.router.navigate("/login/?useType=hotel"
                );
            }

        }
    });

}

function reserveHotel() {

    var cityId = $$('#cityId').val();
    var hotelId = $$('#hotelId').val();
    var startDate = $$('#startDate').val();
    var endDate = $$('#endDate').val();
    var nights = $$('#nights').val();
    var totalNumberRoomReserve = $$('#totalNumberRoomReserve').val();
    var typeApplication = $$('#typeApplication').val();
    var factorNumber = $$('#factorNumber').val();


    app.request({
        url: '../hotel_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {
            flag: 'nextStepReserveHotel',
            IdCity: cityId,
            IdHotel: hotelId,
            SDate: startDate,
            EDate: endDate,
            Nights: nights,
            TotalNumberRoom_Reserve: totalNumberRoomReserve,
            TypeApplication: typeApplication,
            factorNumber: factorNumber,
            dataTypeResult: 'json'
        },
        success: function (data) {

            if (data.message == 'success_NextStepReserveHotel') {

                $$('#factorNumber').val(data.factorNumber);
                var formData = app.form.convertToData('#formHotelReserve');
                var data = JSON.stringify(formData);
                app.router.navigate("/passengerHotel/?formData=" + data);

            } else {

                var toastLargeMessage = app.toast.create({
                    text: 'اشکال در رزرو هتل ،مجددا تلاش نمایید.',
                    closeTimeout: 4000,
                    position: 'top'
                });
                toastLargeMessage.open();

            }

        }
    });


}


function validateMobile(mob) {
    var mobReg = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
    var error = 0;
    if (mob == "") {
        return 'false';
    } else if (!mobReg.test(mob)) {
        return 'false';
    } else {
        return 'true';
    }
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var error = 0;
    if (email == "") {
        return 'false';
    } else if (!emailReg.test(email)) {
        return 'false';
    } else {
        return 'true';
    }
}

function checkCodeMeli(code) {
    var L = code.length;
    if (L < 8 || parseInt(code, 10) == 0)
        return false;
    code = ('0000' + code).substr(L + 4 - 10);
    if (parseInt(code.substr(3, 6), 10) == 0)
        return false;
    var c = parseInt(code.substr(9, 1), 10);
    var s = 0;
    for (var i = 0; i < 9; i++)
        s += parseInt(code.substr(i, 1), 10) * (10 - i);
    s = s % 11;
    return (s < 2 && c == s) || (s >= 2 && c == (11 - s));
}

function getNationalCode(code) {

    var national = $$('.UniqNationalCode').map(function () {
        return $$(this).val();
    });
    var nationalCodesArray = national.toString().split(',');
    var flag = 0;
    nationalCodesArray.forEach(function (index, element) {
        if (element != "" && code == element) {
            flag = parseInt(flag) + 1;
        }
    });
    if (flag != 0 && flag != 1) {
        return false;
    }
}

function validatePassengers(currentTime, numAdult, typeApplication) {
    var error = 0;
    for (var i = 1; i <= numAdult; i++) {

        var gender = $$("#genderA" + i + ":checked").val();
        var passengerNationality = $$("#passengerNationalityA" + i + ":checked").val();
        var nameFa = $$("#nameFaA" + i).val();
        var familyFa = $$("#familyFaA" + i).val();
        var nameEnA = $$("#nameEnA" + i).val();
        var familyEnA = $$("#familyEnA" + i).val();
        var nationalCode = $$('#NationalCodeA' + i).val();
        var typeZoneFlight = $$('#ZoneFlight').val();

        // اگر وب سرویس بود یا یکی از موارد مربوطه را وارد کرده بود بررسی کند مقادیر را
        if (typeApplication == 'api' || (nameFa != '' || familyFa != '' || nameEnA != '' || familyEnA != '' )) {


            if (gender != 'Male' && gender != 'Female') {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا جنسیت را انتخاب نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }
            if (nameFa == '' || familyFa == '' || nameEnA == '' || familyEnA == '') {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا تمام موارد لازم را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }
            if (typeZoneFlight != 'Local') {
                if ($$("#passportNumberA" + i).val() == "" || $$("#passportExpireA" + i).val() == "") {
                    var toastLargeMessage = app.toast.create({
                        text: 'لطفا اطلاعات پاسپورت را وارد نمائید',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                }
            }
            if (typeApplication == 'api' && ($$("#BedType" + i).val() != 'Double' && $$("#BedType" + i).val() != 'Twin')) {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا نوع چیدمان تخت را انتخاب کنید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }


            if (passengerNationality == '1') {
                if ($$("#birthdayEnA" + i).val() == "" || $$("#passportCountryA" + i).val() == "" || $$("#passportNumberA" + i).val() == "" || $$("#passportExpireA" + i).val() == "") {
                    var toastLargeMessage = app.toast.create({
                        text: 'لطفا تمام موارد لازم را وارد نمائید',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                }

                //بررسی تاریخ تولد
                var YearMiladi = $$("#YearMiladiA" + i).val();
                var MonthMiladi = $$("#MonthMiladiA" + i).val();
                var DayMiladi = $$("#DayMiladiA" + i).val();
                var t = YearMiladi + '-' + MonthMiladi + '-' + DayMiladi;
                $$("#birthdayEn" + i).val(t);
                var d = new Date(t);
                n = Math.round(d.getTime() / 1000);
                if ((currentTime - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
                    var toastLargeMessage = app.toast.create({
                        text: 'تاریخ تولد صحیح نمی باشد',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                } else if ($$("#birthdayEn" + i).val() == "") {
                    var toastLargeMessage = app.toast.create({
                        text: 'تاریخ تولد را وارد نمائید',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                }


            } else {

                var YearJalali = $$("#YearJalaliA" + i).val();
                var MonthJalali = $$("#MonthJalaliA" + i).val();
                var DayJalali = $$("#DayJalaliA" + i).val();
                var t = YearJalali + '-' + MonthJalali + '-' + DayJalali;
                $$("#birthday" + i).val(t);

                if ($$("#birthday" + i).val() == "") {
                    var toastLargeMessage = app.toast.create({
                        text: 'تاریخ تولد را وارد نمائید',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                }


                var CheckEqualNationalCode = getNationalCode(nationalCode);
                if (CheckEqualNationalCode == false) {
                    var toastLargeMessage = app.toast.create({
                        text: 'کد ملی تکراری می باشد',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                }

                if (nationalCode != "") {
                    if ((nationalCode.toString().length != 10)) {
                        var toastLargeMessage = app.toast.create({
                            text: 'در کد ملی تنها از 10 رقم میتوانید استفاده کنید',
                            closeTimeout: 2000,
                            position: 'top'
                        });
                        error = 1;
                    } else {
                        var NCode = checkCodeMeli(nationalCode);
                        if (!NCode) {
                            var toastLargeMessage = app.toast.create({
                                text: 'کد ملی وارد شده معتبر نمی باشد',
                                closeTimeout: 2000,
                                position: 'top'
                            });

                            error = 1;
                        }
                    }
                } else {
                    var toastLargeMessage = app.toast.create({
                        text: 'لطفا تمام موارد را وارد نمائید',
                        closeTimeout: 2000,
                        position: 'top'
                    });

                    error = 1;
                }

            }


        }

    }

    if (toastLargeMessage) {
        toastLargeMessage.open();
    }


    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

$$(document).on("click", "#reserveHotel", function () {

    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال بررسی');
    $$(this).css('opacity', '0.5');

    var errorBuyer = 0;
    var errorPassenger = 0;

    var currentTime = $$('#currentTime').val();
    var typeApplication = $$('#typeApplication').val();
    var countPassenger = $$('#countPassenger').val();
    if (countPassenger > 0) {

        var resultValidate = validatePassengers(currentTime, countPassenger, typeApplication);
        if (resultValidate == 'true') {
            errorPassenger = 0;
        } else {
            errorPassenger = 1;
            setTimeout(function () {
                $$('.GoToFactorLocalApp').find('span').text('ادامه');
                $$('.GoToFactorLocalApp').css('opacity', '1');
                $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

            }, 2500);
        }
    }


    var passengerLeader = $$('#passenger_leader_room_fullName').val();
    var mobile = $$('#Mobile').val();
    var email = $$('#Email').val();
    if (passengerLeader == '' || mobile == '' || email == '') {
        errorBuyer = 1;
        var toastLargeMessage = app.toast.create({
            text: 'لطفا اطلاعات مربوط به خریدار را وارد نمائید',
            closeTimeout: 2000,
            position: 'top'
        });
        toastLargeMessage.open();
        setTimeout(function () {
            $$('.GoToFactorLocalApp').find('span').text('ادامه');
            $$('.GoToFactorLocalApp').css('opacity', '1');
            $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

        }, 2500);

    } else {

        var resultValidateMobile = validateMobile(mobile);
        var resultValidateEmail = validateEmail(email);

        if (resultValidateMobile == 'false') {

            var toastLargeMessage = app.toast.create({
                text: 'فرمت تلفن همراه صحیح نمی باشد',
                closeTimeout: 2000,
                position: 'top'
            });
            errorBuyer = 1;
            setTimeout(function () {
                $$('.GoToFactorLocalApp').find('span').text('ادامه');
                $$('.GoToFactorLocalApp').css('opacity', '1');
                $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

            }, 2500);

        } else if (resultValidateEmail == 'false') {
            var toastLargeMessage = app.toast.create({
                text: 'فرمت ایمیل صحیح نمی باشد',
                closeTimeout: 2000,
                position: 'top'
            });
            errorBuyer = 1;
            setTimeout(function () {
                $$('.GoToFactorLocalApp').find('span').text('ادامه');
                $$('.GoToFactorLocalApp').css('opacity', '1');
                $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

            }, 2500);
        }

    }


    if (errorPassenger == 0 && errorBuyer == 0) {
        var formData = app.form.convertToData('#formNextStepReserveHotel');
        var data = JSON.stringify(formData);
        app.router.navigate("/factorHotel/?formData=" + data);
    }

    if (toastLargeMessage) {
        toastLargeMessage.open();
    }


});



function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    return {
        'total': t,
        'minutes': minutes,
        'seconds': seconds
    };
}

function initializeClockForHotel(id, endtime) {
    var clock = document.getElementById(id);
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');

    function updateClock() {
        var t = getTimeRemaining(endtime);

        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

        if (t.total <= 0) {
            checkForConfirmHotelAfter10Minutes();
            clearInterval(timeinterval);
        }
    }

    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
}


function preReserveHotel(factorNumber, typeApplication) {

    /*var toastLargeMessage = app.toast.create({
        text: 'لطفا ابتدا قوانین و مقررات را تایید نمائید.',
        closeTimeout: 4000,
        position: 'top'
    });
    toastLargeMessage.open();*/

    $$('#btnPreReserve a').text('در حال بررسی');
    $$('#btnPreReserve a').css('opacity', '0.5');


    app.request({
        url: '../hotel_ajax.php',
        method: 'post',
        dataType: 'json',
        data: {
            flag: 'HotelReserve',
            factorNumber: factorNumber,
            typeApplication: typeApplication
        },
        success: function (data) {

            if (data.book == 'yes') {
                $$('#total_price').val(data.total_price);
                $$('#typeApplication').val(typeApplication);
                var serviceType = $$('#serviceType').val();
                setTimeout(function () {
                    app.router.navigate("/ChooseBank/?factorNumber=" + factorNumber +
                        "&typeApplication=" + typeApplication +
                        "&serviceType=" + serviceType +
                        "&nameApplication=" + "hotel" +
                        "&flag=" + "check_credit_hotel" +
                        "&typeTrip" + "hotelLocal"
                    );
                }, 2500);

            } else if (data.book == 'OnRequest') {

                if (data.user_type == '5') {

                    /* counter start */
                    var deadline = new Date(Date.parse(new Date()) + 10 * 60 * 1000);
                    initializeClockForHotel('clockdiv', deadline);

                    $$('#timeConfirmHotel').val('yes');
                    timeForConfirmHotel();
                    $$('#alterRequest').html('<i class="preReserve-icon"></i><span>کاربر گرامی درخواست هتل شما با موفقیت در سیستم ثبت شده است.</span>\n' + ' <span>حداکثر تا 10 دقیقه دیگر نتیجه نهایی رزرو به شما اعلام می گردد.</span>');
                    $$('#alertForOnRequest').removeClass('displayN');

                } else {

                    $$('#alterRequest').html('<i class="preReserve-icon"></i><span>کاربر گرامی درخواست هتل شما با موفقیت در سیستم ثبت شده است.</span>\n' + ' <span>حداکثر تا 10 دقیقه دیگر نتیجه نهایی رزرو به شما اعلام می گردد.</span>');
                    $$('#alertOnRequestForCounter').html('<span>برای تکمیل خرید و پرداخت مبلغ رزرو از لینک سوابق خرید هتل استفاده نمایید</span>');
                    $$('#btnSearchInternalHotel').addClass('displayN');
                    $$('#btnHotelHistory').removeClass('displayN');
                    $$('#alertForOnRequest').removeClass('displayN');
                    $$('#alertOnRequestForCounter').removeClass('displayN');
                    $$('.time-after-pay').addClass('displayN');

                }


            } else if (data.book == 'no') {

                var toastLargeMessage = app.toast.create({
                    text: 'امکان رزرو این هتل وجود ندارد.',
                    closeTimeout: 4000,
                    position: 'top'
                });
                toastLargeMessage.open();

            } else {

                var toastLargeMessage = app.toast.create({
                    text: 'مشکلی در روند رزرو شما پیش آمده است. لطفا مجددا تلاش کنید.',
                    closeTimeout: 4000,
                    position: 'top'
                });
                toastLargeMessage.open();
            }


        }
    });


}


function timeForConfirmHotel() {

    setInterval(function () {

        var factorNumber = $$('#factorNumber').val();
        var timeConfirmHotel = $$('#timeConfirmHotel').val();

        if (timeConfirmHotel == 'yes') {

            app.request({
                url: '../hotel_ajax.php',
                method: 'post',
                dataType: 'json',
                data: {
                    flag: 'checkForConfirmHotel',
                    factorNumber: factorNumber,
                    dataTypeResult: 'json'
                },
                success: function (data) {

                    if (data.message == 'PreReserve') {

                        $$('#timeConfirmHotel').val('no');
                        $$('#alterRequest').html('<i class="success-icon"></i><span>کاربر گرامی درخواست هتل شما تایید شد.</span>\n' + ' <span>شما 10 دقیقه فرصت دارید با پرداخت مبلغ رزرو، واچر خود را دریافت نمایید.</span>');
                        //$('.counterBank').counter({});

                        var typeApplication = $$('#typeApplication').val();
                        if (typeApplication == 'reservation') {
                            typeApplication = typeApplication + '_app';
                        }
                        var serviceType = $$('#serviceType').val();
                        setTimeout(function () {
                            app.router.navigate("/ChooseBank/?factorNumber=" + factorNumber +
                                "&typeApplication=" + typeApplication +
                                "&serviceType=" + serviceType +
                                "&nameApplication=" + "hotel" +
                                "&flag=" + "check_credit_hotel" +
                                "&typeTrip" + "hotelLocal"
                            );
                        }, 2500);

                    } else if (data.message == 'Cancelled') {

                        $$('#timeConfirmHotel').val('no');
                        $$('.time-after-pay').addClass('displayN');
                        $$('#alterRequest').html('<i class="cancel-icon"></i><span>بدلیل عدم ظرفیت هتل درخواست شما لغو گردید.</span>\n' + ' <span> می توانید هتل دیگری رزرو کنید.</span>');
                    }
                }
            });

        }

    }, 60000);

}


function checkForConfirmHotelAfter10Minutes() {

    var factorNumber = $$('#factorNumber').val();
    var timeConfirmHotel = $$('#timeConfirmHotel').val();
    if (timeConfirmHotel == 'yes'){
        app.request({
            url: '../hotel_ajax.php',
            method: 'post',
            dataType: 'json',
            data: {
                flag: 'checkForConfirmHotel',
                factorNumber: factorNumber,
                dataTypeResult: 'json'
            },
            success: function (data) {

                if (data.message == 'PreReserve') {

                    $$('#timeConfirmHotel').val('no');
                    $$('#alterRequest').html('<i class="success-icon"></i><span>کاربر گرامی درخواست هتل شما تایید شد.</span>\n' + ' <span>شما 10 دقیقه فرصت دارید با پرداخت مبلغ رزرو، واچر خود را دریافت نمایید.</span>');

                    var typeApplication = $$('#typeApplication').val();
                    if (typeApplication == 'reservation') {
                        typeApplication = typeApplication + '_app';
                    }
                    var serviceType = $$('#serviceType').val();
                    setTimeout(function () {
                        app.router.navigate("/ChooseBank/?factorNumber=" + factorNumber +
                            "&typeApplication=" + typeApplication +
                            "&serviceType=" + serviceType +
                            "&nameApplication=" + "hotel" +
                            "&flag=" + "check_credit_hotel" +
                            "&typeTrip" + "hotelLocal"
                        );
                    }, 2500);

                } else if (data.message == 'Cancelled') {

                    $$('#timeConfirmHotel').val('no');
                    $$('.time-after-pay').addClass('displayN');
                    $$('#alterRequest').html('<i class="cancel-icon"></i><span>بدلیل عدم ظرفیت هتل درخواست شما لغو گردید.</span>\n' + ' <span> می توانید هتل دیگری رزرو کنید.</span>');

                } else {

                    app.request({
                        url: '../hotel_ajax.php',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            flag: 'cancelReserveHotel',
                            factorNumber: factorNumber,
                            dataTypeResult: 'json'
                        },
                        success: function (data) {

                            $$('#timeConfirmHotel').val('no');
                            $$('.time-after-pay').addClass('displayN');
                            $$('#alterRequest').html('<i class="cancel-icon"></i><span>بدلیل عدم ظرفیت هتل درخواست شما لغو گردید.</span>\n' + ' <span> می توانید هتل دیگری رزرو کنید.</span>');
                        }
                    });

                }
            }
        });
    }


}


$$(document).on("click", ".viewHotelBookingInformation", function () {

    var factorNumber = $$(this).attr('factorNumber');
    app.router.navigate("/hotelBookingInfo/?factorNumber=" + factorNumber
    );

});


$$(document).on("click", ".goBankForHotelOnRequest", function () {

    var factorNumber = $$(this).attr('factorNumber');
    var serviceType = $$(this).attr('serviceType');

    app.router.navigate("/ChooseBank/?factorNumber=" + factorNumber +
        "&typeApplication=" + 'reservation_app' +
        "&serviceType=" + serviceType +
        "&nameApplication=" + "hotel" +
        "&flag=" + "check_credit_hotel" +
        "&typeTrip" + "hotelLocal"
    );

});




