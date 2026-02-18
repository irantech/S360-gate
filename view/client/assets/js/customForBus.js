$(document).ready(function () {


    const cityOrigin1 = document.getElementById("cityOrigin")
    const cityDestination1 = document.getElementById("cityOrigin")

    if (cityOrigin1) {
        cityOrigin1.onclick = () => openPopularBusCities("cityOrigin")
    }

    if (cityDestination1) {
        cityDestination1.onclick = () => openPopularBusCities("cityDestination")
    }

    let items_chairNumber = [];
    $('.chair_bus').click(function (event) {

        $('#errorForFemale').html('');
        $('#messageChairNumberReserve').html('');

        if ($(this).parent('span').hasClass('typeAvailable')) {
            $(this).parent('span').removeClass('typeAvailable');
            $(this).parent('span').addClass('typeSelected');
        } else if ($(this).parent('span').hasClass('typeSelected')) {
            $(this).parent('span').removeClass('typeSelected');
            $(this).parent('span').addClass('typeAvailable');
        }

        // مشخص کردن شماره و تعداد صندلی های انتخابی
        let chairNumberReserve = '';
        let countChairReserve = 0;
        $('.seat-item').each(function () {

            if ($(this).children('span').hasClass('typeSelected')) {
                countChairReserve++;
                let chairNumber = $(this).children('span').find('input').val();
                if (countChairReserve == 1) {
                    chairNumberReserve = chairNumber;
                } else {
                    chairNumberReserve = chairNumberReserve + '-' + chairNumber;
                }
            }
        });

        if (countChairReserve > 4) {
            $.confirm({
                title: "محدودیت تعداد نفرات",
                content: "شما می‌توانید حداکثر ۴ نفر را رزرو کنید، برای رزرو نفرات بیشتر، لطفاً پس از صدور بلیت این افراد نسبت به رزرو نفرات باقی‌مانده اقدام نمایید.",
                autoClose: false,
                escapeKey: 'cancelAction',
                type: 'red',
                buttons: {
                    cancelAction: {
                        text: useXmltag("Closing"),
                        btnClass: 'btn-red'

                    }
                }
            });

            if ($(this).parent('span').hasClass('typeSelected')) {
                $(this).parent('span').removeClass('typeSelected').addClass('typeAvailable');
            } else if ($(this).parent('span').hasClass('typeAvailable')) {
                $(this).parent('span').removeClass('typeAvailable').addClass('typeSelected');
            }

            return; // متوقف کردن ادامه‌ی کد
        }



        let _this = this;
        setTimeout(function () {
            $('#chairNumberReserve').val(chairNumberReserve);
            $('#countChairReserve').val(countChairReserve);
            if(countChairReserve == 1) {
                let text = useXmltag("SeatNumber") + chairNumberReserve;
                $('.chair-number').text(text)
                $(".chair-number_aaa").val(event.currentTarget.querySelector('input').value)
            }
            if(countChairReserve > 1 && ($(_this).parent().hasClass("typeSelected") || $(_this).parent().hasClass("typeAvailable"))) {
                $('#bus-passenger-detail').removeClass('d-none')
                createPassengerBox(countChairReserve , event.currentTarget.querySelector('input').value , event.currentTarget);
            }
            checkForFemale();
        }, 10);
        if (items_chairNumber.includes(event.currentTarget.querySelector('input').value)){
            const index = items_chairNumber.indexOf(event.currentTarget.querySelector('input').value);
            if (index > -1) {
                items_chairNumber.splice(index, 1);
            }

            setTimeout(function () {

                var selectedInputs = $('input[name="aaa"]');
                selectedInputs.each(function(index, element) {
                    if($(".s-u-passenger-wrapper.s-u-passenger-wrapper-change-Buyer.first.first_1").length > 1){
                        if (event.currentTarget.querySelector('input').value === $(element).val()){
                            $(element).parent().parent().remove()
                        }
                    } else {
                        $(".s-u-passenger-wrapper.s-u-passenger-wrapper-change-Buyer.first.first_1 .s-u-last-p-bozorgsal.s-u-last-p-bozorgsal-change.site-main-text-color").text("سرپرست مسافران")
                    }

                });
            }, 20);

        } else {
            items_chairNumber.push(event.currentTarget.querySelector('input').value);
        }

    });


    // برای چک کردن و جلوگیری از انتخاب ردیف اول برای بانوان
    $('#gender1').on('change', function() {
        checkForFemale();
    });
});

function checkForFemale() {
    let countChairFirstRow = 0;
    $('.seat-item').each(function () {
        if ($(this).children('span').hasClass('typeSelected') && $(this).children('span').hasClass('row1')) {
            countChairFirstRow++;
        }
    });
    setTimeout(function () {
        let countChairOtherRow = parseInt($('#countChairReserve').val()) - countChairFirstRow;
        if ($('#gender1').val() == 'Female' && countChairFirstRow > 0 && countChairOtherRow <= 0) {

            $('#errorForFemale').css('color', '#f20');
            $('#errorForFemale').html(useXmltag("Womennotallowedbuyseatsfirsttworows"));
            $('#messageChairNumberReserve').html('');
            $('#chairNumberReserve').val('');
            $('#countChairReserve').val('0');
            $('.seat-item').each(function () {
                $(this).children('span').removeClass('typeSelected');
                $(this).children('span').addClass('typeAvailable');
            });

            $('html, body').animate({
                scrollTop: $('#formPassengerDetailBusTicket').offset().top
            }, 'slow');
        }
    }, 20);
    setTimeout(function () {
        if (parseInt($('#countChairReserve').val()) > 0) {
            $('#messageChairNumberReserve').css('color', '#333');
            $('#messageChairNumberReserve').css('margin', '20px 0 0 0');
            $('#messageChairNumberReserve').html(useXmltag("You") + '<i style="color: #227537;font-size: 16px;font-weight: bold;padding: 0 5px;">' + $('#countChairReserve').val() + '</i>' + useXmltag("Bookyourseatnumbersseats"));
        }
    }, 30);
}


function createPassengerBox(counter , chairNumber , e){
    let x = `
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first_1 first">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    اطلاعات مسافر 
                     ${counter}
                     شماره صندلی
                     ${chairNumber}
                     <span class="s-u-last-passenger-btn s-u-last-passenger-btn-bus"
                           onclick="setHidenFildnumberRowBus('${counter}')">
                                 <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ${useXmltag("Passengerbook")}
                     </span>
                 
                 </span>
            <div class="panel-default-change-Buyer">
                <input type="hidden" name="aaa" value='${chairNumber}' >
              
                <div class="panel-heading-change d-none">
                    <i class="room-kind-bed"> ${useXmltag("Adultagegroup")} (+11) </i>
                    <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>${useXmltag("Iranian")}</span>
                                    <input type="radio" name="passengerNationality${counter}"
                                           id="passengerNationality${counter}"
                                           value="0" class="nationalityChange" checked="checked">
                                    <div class="checkbox ">
                                        <div class="filler"></div>
                                       <svg fill="#000000"  viewBox="0 0 30 30" >
                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                               </svg>
                                    </div>
                                </label>
                            </span>
                            <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>${useXmltag("Noiranian")}</span>
                                    <input type="radio" name="passengerNationality${counter}"
                                           id="passengerNationality${counter}"
                                           value="1" class="nationalityChange">
                                    <div class="checkbox ">
                                        <div class="filler"></div>
                                        <svg fill="#000000"  viewBox="0 0 30 30" >
                                        <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                       </svg>
                                    </div>
                                </label>
                            </span>
                    </div>
                  <div class="panel-body-change">
                      <div class="s-u-passenger-item  s-u-passenger-item-change">
                            <select id="gender${counter}" name="gender${counter}">
                                <option value="" disabled="" selected="selected">${useXmltag("Sex")}</option>
                                <option value="Male">${useXmltag("Sir")}</option>
                                <option value="Female">${useXmltag("Lady")}</option>
                            </select>
                        </div>
                     <div class="s-u-passenger-item  s-u-passenger-item-change">
                       <input id="nameFa${counter}" type="text" placeholder="${useXmltag('Namepersion')}" name="nameFa${counter}"
                                       onkeypress=" return persianLetters(event, 'nameFa${counter}')" class="justpersian">
                     </div>
                      <div class="s-u-passenger-item  s-u-passenger-item-change">
                         <input id="familyFa${counter}" type="text" placeholder="${useXmltag('Familypersion')}"
                                       name="familyFa${counter}"
                                       onkeypress=" return persianLetters(event, 'familyFa${counter}')" class="justpersian">
                     </div>
                     <div class="s-u-passenger-item  s-u-passenger-item-change">
                       <input id="birthday${counter}" type="text" placeholder="${useXmltag('shamsihappybirthday')}" name="birthday${counter}"
                                   class="shamsiDriverBirthdayCalendar pwt-datepicker-input-element"
                                   readonly="readonly">
                    </div>
                    
                    <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                        <input id="NationalCode${counter}" type="tel" placeholder="${useXmltag("Nationalnumber")}"
                               name="NationalCode${counter}"
                               maxlength="10"
                               class="UniqNationalCode">
                    </div>
                </div>
                <div id="errorMessagePassenger${counter}"></div>
            </div>
            </div>
          `;
    $(".bus-passenger").append(x);
    setUpCalender();
}

function setUpCalender() {
    if (age == undefined){var age = 18;}
    $('.shamsiDriverBirthdayCalendar').datepicker({
        maxDate: '-' + age + 'Y',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });
}


function selectDest() {
    let thisForm = $('form[name="gds_bus"]');
    thisForm.find('#cityDestination').select2('open');
}

function submitSearchBus() {
    let thisForm = $('form[name="gds_bus"]');
    let cityOrigin = thisForm.find("#cityOrigin").val();
    let cityDestination = thisForm.find("#cityDestination").val();
    let dateMove = thisForm.find("#dateMoveBus").val();
    if (cityOrigin == "" || cityDestination == "" || dateMove == "") {
        $.alert({
            title: useXmltag("Bookingbusticket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
    } else {
        window.location.href = amadeusPathByLang + 'buses/' + cityOrigin + '-' + cityDestination + '/' + dateMove;
    }

}

function  getResultBusSearch(cityOrigin, cityDestination, dateMove,lang) {

    $.ajax({
        type: "POST",
        url: amadeusPath + 'bus_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'getResultBusSearch',
            cityOrigin: cityOrigin,
            cityDestination: cityDestination,
            dateMove: dateMove,
            lang:lang
        },
        success: function (data) {
            $("#originCityName").html(data.originCityName);
            $("#destinationsCityName").html(data.destinationsCityName);
            if (typeof data.date != 'undefined') {
                $("#dateMove").html(data.date.dayName + ' ' + data.date.dataString);
            }
            if (typeof data.countBuses != 'undefined') {
                $("#countBuses").html(data.countBuses);
            }
            if((typeof data.countBuses != 'undefined' && data.countBuses == 0) ||
                (typeof data.notAvailableBus != 'undefined' && data.notAvailableBus == true)) {
                $("#show_offline_request").removeClass('d-none').addClass('d-block');
                $(".bus-sort-by-section").addClass('d-none');
                if(data.countBuses == 0) {
                    $("#show_offline_request .fullCapacity_div h2").html(useXmltag('Noresult'))
                }else{
                    $("#show_offline_request .fullCapacity_div h2").html(useXmltag('FullCapacityRequestOffline'))
                }
            }
            if (typeof data.filterTimeMove != 'undefined') {
                $("#filterTimeMove").html(data.filterTimeMove);
            }
            if (typeof data.filterCompanyName != 'undefined') {
                $("#filterCompanyName").html(data.filterCompanyName);
            }
            $("#resultBusSearch").html(data.resultBuses);
            $("#requestNumber").val(data.requestNumber);

            $('.f-loader-check').hide();
            // sortBuses('min_time_move');
            $('#resultBusSearch').fadeIn();
            setTimeout(function(){
                loadArticles('Bus',cityDestination)
            },1000);
        }
    });

}


function selectSortBus(obj) {
    let sortBy = $(obj).val();
    sortBuses(sortBy);
}

function sortBuses(sortBy) {

    let allBus = [];
    let freeBus = [];
    let temp = [];
    let current_sort_index = '';
    let current_sort_index_first = '';
    let arrayPrice = [];
    let searchResult = $(".international-available-box");

    searchResult.each(function () {


        let timeMove = $(this).data("time");
        let price = $(this).data("price");
        let freeChairs = $(this).data("freechairs");

        if (sortBy == 'min_time_move' || sortBy == 'max_time_move') {

            if (timeMove != '') {
                current_sort_index = timeMove;
            } else {
                current_sort_index = 0;
            }

            if (parseInt(price) > 0) {
                price = current_sort_index_first = parseInt(price);
                arrayPrice.push(price);
            } else {
                price = current_sort_index_first = 0;
            }


        }
        else if (sortBy == 'max_price' || sortBy == 'min_price') {

            if (parseInt(price) > 0) {
                price = current_sort_index = parseInt(price);
                arrayPrice.push(price);
            } else {
                price = current_sort_index = 0;
            }

            if (timeMove != '') {
                current_sort_index_first = price;
            } else {
                current_sort_index_first = 0;
            }

        }
        if( freeChairs == 0 ) {
            freeBus.push({
                'content': $(this).parent().html(),
                'sortIndex': current_sort_index,
                'sortIndexFirst': current_sort_index_first,
                'lastData': freeChairs,
                'price': price
            });
        }else{
            allBus.push({
                'content': $(this).parent().html(),
                'sortIndex': current_sort_index,
                'sortIndexFirst': current_sort_index_first,
                'lastData': freeChairs,
                'price': price
            });
        }


    });

    /*let maxPrice = Math.max.apply(Math, arrayPrice);
    let minPrice = Math.min.apply(Math, arrayPrice);
    $(".filter-price-text span:nth-child(2) i").html(addCommas(minPrice));
    $(".filter-price-text span:nth-child(1) i").html(addCommas(maxPrice));*/



    if (sortBy == 'min_price' || sortBy == 'min_time_move') {

        for (let i = 0; i < parseInt(allBus.length); i++) {
            for (let j = i; j < parseInt(allBus.length); j++) {
                if (allBus[j]['sortIndexFirst'] <= allBus[i]['sortIndexFirst']) {
                    temp = allBus[i];
                    allBus[i] = allBus[j];
                    allBus[j] = temp;
                }
            }
        }

        for (let i = 0; i < parseInt(allBus.length); i++) {
            for (let j = i; j < parseInt(allBus.length); j++) {
                if (allBus[j]['sortIndex'] <= allBus[i]['sortIndex']) {
                    temp = allBus[i];
                    allBus[i] = allBus[j];
                    allBus[j] = temp;
                }
            }
        }



    }
    else if (sortBy == 'max_price' || sortBy == 'max_time_move') {

        for (let i = 0; i < parseInt(allBus.length); i++) {
            for (let j = i; j < parseInt(allBus.length); j++) {
                if (allBus[j]['sortIndexFirst'] >= allBus[i]['sortIndexFirst']) {
                    temp = allBus[i];
                    allBus[i] = allBus[j];
                    allBus[j] = temp;
                }
            }
        }

        for (let i = 0; i < parseInt(allBus.length); i++) {
            for (let j = i; j < parseInt(allBus.length); j++) {
                if (allBus[j]['sortIndex'] >= allBus[i]['sortIndex']) {
                    temp = allBus[i];
                    allBus[i] = allBus[j];
                    allBus[j] = temp;
                }
            }
        }
        // for (let i = 0; i < parseInt(allBus.length); i++) {
        //     for (let j = i; j < parseInt(allBus.length); j++) {
        //         if (allBus[j]['lastData'] >= allBus[i]['lastData']) {
        //             temp = allBus[i];
        //             allBus[i] = allBus[j];
        //             allBus[j] = temp;
        //         }
        //     }
        // }

    }
    allBus = allBus.concat(freeBus)

    setTimeout(function () {
        $('.items').empty();
        let countBus = parseInt(allBus.length);
        $('#countHotel').html(countBus);
        for (i = 0; i < countBus; i++) {

            if (allBus[i]['price'] > 0) {

                $(".items").append('<div class="showListSort">' + allBus[i]['content'] + '</div>');

            }
        }
    }, 200);

}

async function reserveBusTicket(busCode, sourceCode, checkLogin = true, _this = null) {

    if(_this){
        loadingToggle(_this)
    }
    await $('#busCode').val(busCode)
    await $('#sourceCode').val(sourceCode)

    if (checkLogin) {
        $.post(amadeusPath + 'hotel_ajax.php',
            {
                flag: 'CheckedLogin',
            },
            function(data) {
                if (data.indexOf('successLoginHotel') > -1) {
                    reserveBusTicketWithoutRegister()
                }
                else if (data.indexOf('errorLoginHotel') > -1) {
                    $('#noLoginBuy').val(useXmltag('Bookingwithoutregistration'))
                    let isShowLoginPopup = $('#isShowLoginPopup').val()
                    let useTypeLoginPopup = $('#useTypeLoginPopup').val()
                    if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                        $('#login-popup').trigger('click')
                    } else {
                        popupBuyNoLogin(useTypeLoginPopup)
                    }
                    loadingToggle(_this, false)
                }
            },
        )
    }
}
async function showDescriptionDetail(el, busCode, sourceCode) {
    await $('#busCode').val(busCode)
    await $('#sourceCode').val(sourceCode)
    var $container = $(el).closest('.ticketSubDetail')
    $container.find('[data-name="bus-extra-descriptions"]').removeClass('d-block').addClass('d-none')
    $container.find('[data-name="bus-refund-rules"]').html('')
    $container.find('[data-name="bus-extra-descriptions-loading"]').removeClass('d-none').addClass('d-flex')

    await reserveBusTicketWithoutRegister(true, $container)
}
async function reserveBusTicketWithoutRegister(description_only=false, $container=null) {

    let busCode = $('#busCode').val();
    let sourceCode = $('#sourceCode').val();
    let originCity = $('#originCity').val();
    let destinationCity = $('#destinationCity').val();
    let requestNumber = $('#requestNumber').val();
    let dateMove = $('#dateMove').val();
    await $.post(amadeusPath + 'bus_ajax.php',
        {
            busCode: busCode,
            sourceCode: sourceCode,
            originCity: originCity,
            destinationCity: destinationCity,
            dateMove: dateMove,
            requestNumber: requestNumber,
            flag: 'flagSetTemporaryBus'
        },
        function (data) {
            console.log('data: ' , data)
            let dataArray = data.split('|');

            if (data.indexOf('success') > -1) {
                let parseData = JSON.parse(dataArray[1]);

                $('#factorNumber').val(parseData.factor_number);
                $('#requestNumber').val(parseData.requestNumber);
                if(description_only && $container){
                    $container.find('[data-name="bus-extra-descriptions-loading"]').removeClass('d-flex').addClass('d-none')
                    $container.find('[data-name="bus-extra-descriptions"]').removeClass('d-none').addClass('d-block')

                    $.each(parseData.refundRules, function(index, item) {
                        let html_code = '<div class="alert-bus" role="alert">';

                        if (item.From && item.Percent) {
                            let time = item.From.substr(1);
                            let hours = time.replace(":", " ");
                            hours = parseInt(hours);
                            html_code += 'از لحظه خرید تا ' + hours + 'ساعت قبل از حرکت کسر ' + item.Percent + '% جریمه';
                        } else if (item.To && item.Percent) {
                            let time = item.To.substr(1);
                            let hours = time.replace(":", " ");
                            hours = parseInt(hours);
                            html_code += 'از ' + hours + 'ساعت قبل از حرکت کسر ' + item.Percent + '% جریمه';
                        }

                        html_code += '</div>';
                        $container.find('[data-name="bus-refund-rules"]').append(html_code);
                    });

                }else{
                    $("#formReserveBusTicket").attr("action", amadeusPathByLang + 'passengersDetailBusTicket');
                    $("#formReserveBusTicket").submit();
                }

            } else {
                if($container) {
                    $container.find('[data-name="bus-extra-descriptions-loading"]').removeClass('d-flex').addClass('d-none')
                    $container.find('[data-name="bus-extra-descriptions"]').removeClass('d-none').addClass('d-block')
                }
                $.alert({
                    title: useXmltag("Reservation"),
                    icon: 'fa fa-trash',
                    content: dataArray[1],
                    rtl: true,
                    type: 'red'
                });
            }
        });
}

const checkBusLocal = async function(currentDate,_this=null) {


    let error1 = 0;
    let error2 = 0;
    let error3 = 0;

    if (parseInt($('#countChairReserve').val()) > 0) {
        let min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
        let min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
        let sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
        let sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();
        let time = min1 + min2 + ':' + sec1 + sec2;
        $('#time_remmaining').val(time);

        let checkPassenger = checkInfoPassenger(currentDate);
        if (checkPassenger) {
            error1 = 0;
        } else {
            error1 = 1;
        }
        let mob = $('#Mobile').val();
        let email = $('#Email').val();
        let tel = $('#Telephone').val();
        if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
            let resultCheckMember = membersForHotel(mob, email, tel);
            if (resultCheckMember == true) {
                error2 = 0;
            } else {
                error2 = 1
            }
        }

        if (error1 == 0 && error2 == 0 && error3 == 0) {

            if(_this && _this.length){
                loadingToggle(_this)
            }

            $.post(amadeusPath + 'hotel_ajax.php',
                {
                    mobile: mob,
                    telephone: tel,
                    Email: email,
                    flag: "register_memeberHotel"
                },
                function (data) {
                    if (data != "") {

                        $('#idMember').val(data);

                        $('#loader_check').show();
                        $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));

                        setTimeout(
                            function () {
                                $('#loader_check').hide();
                                $('#formPassengerDetailBusTicket').submit();
                            }, 300);

                    } else {
                        if(_this && _this.length){
                            loadingToggle(_this,false)
                        }
                        $.alert({
                            title: useXmltag("Reservationhotel"),
                            icon: 'fa fa-cart-plus',
                            content: useXmltag("Errorrecordinginformation"),
                            rtl: true,
                            type: 'red'
                        });
                        return false;
                    }
                });
        }

    } else {
        if(_this && _this.length){
            loadingToggle(_this,false)
        }

        $('#messageChairNumberReserve').css('color', 'red').html(useXmltag("Pleaseselectyourseat"));
        $('html, body').animate({
            scrollTop: $('#formPassengerDetailBusTicket').offset().top
        }, 'slow');
    }


}

function checkInfoPassenger(currentDate) {



    let error = 0;
    let countPassenger = $("#countChairReserve").val();
    $("#errorMessagePassenger").html('');
    for (let i = 1; i < countPassenger; i++) {
        let counter = i + 1
        $("#errorMessagePassenger"+ counter).html('');
    }


    let gender = $("#gender1 option:selected").val();
    if (gender != 'Male' && gender != 'Female') {
        $("#errorMessagePassenger").css('color', 'red').html(useXmltag("SpecifyGender"));
        error = 1;
    }

    if ($("#nameFa1").val() == "" || $("#familyFa1").val() == "") {
        $("#errorMessagePassenger").css('color', 'red').html(useXmltag("Fillingallfieldsrequired"));
        error = 1;
    }
    if ($("#birthday1").val() == "") {
        $("#errorMessagePassenger").css('color', 'red').html(useXmltag("BirthEnteredNotCorrect"));
        error = 1;
    }

    // چک کردن ایمیل و شماره تلفن سرپرست مسافران
    let mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
    let emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    if($('[name="mobilePhone1"]').length > 0){
        var mobile_buyer = $('[name="mobilePhone1"]').val();
        if (!mobregqx.test($('[name="mobilePhone1"]').val())) {
            $("#messageInfo").css('color', 'red').html(useXmltag("MobileNumberIncorrect"));
            error = 1;
        }
    }
    else{
        var mobile_buyer = $('[name="Mobile"]').val();

        if (!mobregqx.test(mobile_buyer)) {
            $("#messageInfo").css('color', 'red').html(useXmltag("MobileNumberIncorrect"));
            error = 1;
        }
    }
    /*
    if($('[name="email1"]').length){
        if (!emailReg.test($('[name="email1"]').val())) {

            $("#messageInfo").css('color', 'red').html(useXmltag("Theenteredemailformatnotcorrect"));
            error = 1;
        }
    }else{
        if (!emailReg.test($('[name="Email"]').val())) {

            $("#messageInfo").css('color', 'red').html(useXmltag("Theenteredemailformatnotcorrect"));
            error = 1;
        }
    }*/


    if ($("#email1").length > 0) {
        var email_buyer = $('#email1').val();

        if (email_buyer == '') {
            error = 1;

        }
    } else {
        var email_buyer = $('#Email').val();

        if (email_buyer == '' && mobile_buyer != '') {
            $('#Email').val('simple' + mobile_buyer + '@info.com');
        } else {
            if(mobile_buyer == ''){
                $("#messageInfo").css('color', 'red').html(useXmltag("MobileNumberIncorrect"));
                error = 1;
            }
        }
    }

    // else if (!emailReg.test($("#email1").val())) {
    //     $("#errorMessagePassenger").css('color', 'red').html(useXmltag("Theenteredemailformatnotcorrect"));
    //     error = 1;
    // }


    if ($('input[name=passengerNationality1' + ']:checked').val() == '1') {

        if ($("#passportCountry1").val() == "" || $("#passportNumber1").val() == "" || $("#passportExpire1").val() == "") {
            $("#errorMessagePassenger").css('color', 'red').html(useXmltag("Fillingallfieldsrequired"));
            error = 1;
        }

        //بررسی تاریخ تولد
        if ($("#birthdayEn1").val() != '') {
            let t = $("#birthdayEn1").val();
            let d = new Date(t);
            let n = Math.round(d.getTime() / 1000);
            if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
                $("#errorMessagePassenger").css('color', 'red').html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }
        }


    }
    else {

        if ($('#NationalCode1').val() == "") {
            $("#errorMessagePassenger").css('color', 'red').html(useXmltag("Fillingallfieldsrequired"));
            error = 1;
        }

        let National_Code = $('#NationalCode1').val();
        let CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCode1'));
        if (CheckEqualNationalCode == false) {
            $("#errorMessagePassenger").css('color', 'red').html(useXmltag("NationalCodeDuplicate"));
            error = 1;
        }

        let z1 = /^[0-9]*\d$/;
        let convertedCode = convertNumber(National_Code);
        if (National_Code != "") {
            if (!z1.test(convertedCode)) {
                $("#errorMessagePassenger").css('color', 'red').html(useXmltag("NationalCodeNumberOnly"));
                error = 1;
            } else if ((National_Code.toString().length != 10)) {

                $("#errorMessagePassenger").css('color', 'red').html(useXmltag("OnlyTenDigitsNationalCode"));
                error = 1;
            } else {
                let NCode = checkCodeMeli(convertNumber(National_Code));
                if (!NCode) {
                    $("#errorMessagePassenger").css('color', 'red').html(useXmltag("EnteredCationalCodeNotValid"));
                    error = 1;
                }
            }
        }

        for (let i = 1; i < countPassenger; i++) {
            let counter = i + 1

            if ($("#nameFa"+ counter).val() == "" || $("#familyFa"+ counter).val() == "" || $("#gender"+ counter).val() == "") {
                $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }
            if ($("#birthday"+ counter).val() == "") {
                $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("BirthEnteredNotCorrect"));
                error = 1;
            }


            if ($('#NationalCode' + counter).val() == "") {
                $("#errorMessagePassenger" + counter).css('color', 'red').html(useXmltag("Fillingallfieldsrequired"));
                error = 1;
            }
            let National_Code = $('#NationalCode'+ counter).val();

            let CheckEqualNationalCode = getNationalCode(National_Code, $('#NationalCode'+ counter));
            if (CheckEqualNationalCode == false) {
                $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("NationalCodeDuplicate"));
                error = 1;
            }

            let z1 = /^[0-9]*\d$/;
            let convertedCode = convertNumber(National_Code);
            if (National_Code != "") {
                if (!z1.test(convertedCode)) {
                    $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("NationalCodeNumberOnly"));
                    error = 1;
                } else if ((National_Code.toString().length != 10)) {
                    $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("OnlyTenDigitsNationalCode"));
                    error = 1;
                } else {
                    let NCode = checkCodeMeli(convertNumber(National_Code));
                    if (!NCode) {
                        $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("EnteredCationalCodeNotValid"));
                        error = 1;
                    }
                }
            }
            //بررسی تاریخ تولد
            if ($("#birthday"+ counter).val() != '') {
                let t = $("#birthday"+ counter).val();
                let splitit = t.split('-');
                let JDate = require('jdate');
                let jdate2 = new JDate([splitit[0], splitit[1], splitit[2]]);
                let array = $.map(jdate2, function (value, index) {
                    return [value];
                });
                let d = new Date(array[0]);
                let n = Math.round(d.getTime() / 1000);
                if ((currentDate - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
                    $("#errorMessagePassenger"+ counter).css('color', 'red').html(useXmltag("BirthEnteredNotCorrect"));
                    error = 1;
                }
            }

        }
    }


    if (error == 0) {
        return true;
    } else {
        return false;
    }
}

function confirmAndBookingBusTicket(factorNumber, availablePaymentMethods,_this=null) {


    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag('Busticket'),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }
    if(_this && _this.length){
        loadingToggle(_this)
    }
    // $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress');
    // $('#loader_check').css("display", "block");


    $.ajax({
        type: "POST",
        url: amadeusPath + 'bus_ajax.php',
        dataType: 'JSON',
        data: {
            factorNumber: factorNumber,
            availablePaymentMethods: availablePaymentMethods,
            flag: "busTicketPreReserve"
        },
        success: function (data) {

            if (data.result == 'success') {
                setTimeout(function () {
                    if(_this && _this.length){
                        loadingToggle(_this,false)
                    }
                    /*if (availablePaymentMethods == 'Online') {
                        $('a#btn-payaneha').attr('href', data.paymentEndpoint);
                    }*/
                    $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));
                    $('.main-pay-content').css('display','flex');
                    $('#loader_check').css("display", "none");
                    $('html, body').animate({scrollTop: $('.main-pay-content').offset().top}, 'slow');
                }, 2000);
            } else {
                $('#messageBook').html(data.message);
            }
        }
    });


}


function preReserveBus(factorNumber) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title: useXmltag("Busticket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress');
    $('#loader_check').css("display", "block");
    $.ajax({
        type: "POST",
        url: amadeusPath + 'user_ajax.php',
        data: {
            "flag": 'check_credit_bus',
            "factorNumber": factorNumber

        },
        success: function (data) {


            if (data == 'TRUE') {
                $.ajax({
                    type: "POST",
                    url: amadeusPath + 'bus_ajax.php',
                    data: {
                        "flag": 'BusReserve',
                        "factorNumber": factorNumber
                    },
                    success: function (data) {
                        var result = jQuery.parseJSON(data);

                        if (result.result > 0) {

                            setTimeout(function () {
                                $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));
                                // $('.s-u-p-factor-bank-change').show();
                                // $('.s-u-passenger-wrapper-change').show();
                                // $('#loader_check').css("display", "none");
                                // $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                                window.location.href = "https://api.payaneha.com/payment.ashx?PayanehaOrderCode=" + result.result + "&RedirectUrl=" + result.url;
                            }, 2000);

                        } else {

                            setTimeout(function () {
                                $('#final_ok_and_insert_passenger').css('background-color', 'red').text(useXmltag("Errorconfirmation"));
                                $.alert({
                                    title: useXmltag("Bookingbusticket"),
                                    icon: 'fa fa-cart-plus',
                                    content: result.result,
                                    rtl: true,
                                    type: 'red',
                                })
                            }, 1000);

                        }
                    }
                });


            } else {

                setTimeout(function () {
                    $('#final_ok_and_insert_passenger').css('background-color', 'red').text(useXmltag("Errorconfirmation"));
                    $.alert({
                        title: useXmltag("Bookingbusticket"),
                        icon: 'fa fa-cart-plus',
                        content: useXmltag("Errorbookingticket"),
                        rtl: true,
                        type: 'red',
                    })
                }, 1000);

            }
        }
    });


}


function modalListBus(FactorNumber) {

    $('.loaderPublic').fadeIn();
    setTimeout(function () {
        $('.loaderPublic').fadeOut(700);
        $("#ModalPublic").fadeIn(900);

    }, 3000);

    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'user',
            Method: 'ModalShowBus',
            Param: FactorNumber
        },
        function (data) {

            $('#ModalPublicContent').html(data);

        });
}

function SendBusEmailForOther() {
    $('#loaderTracking').fadeIn(500);
    $('#SendBusEmailForOther').attr("disabled", "disabled");
    var Email = $('#SendForOthers').val();
    var request_number = $('#request_number').val();
    var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/;
    $('#SendForOthers').focus(function () {
        $('#SendForOthers').css("background", "white");
    });

    if (Email == "") {
        $('#SendForOthers').css("background", "red");

        $.alert({
            title: useXmltag("Sendemail"),
            icon: 'fa fa-times',
            content: useXmltag("Pleaseenteremailaddress"),
            rtl: true,
            type: 'red',
        });

    } else if (!emailReg.test(Email)) {
        $('#SendForOthers').css("background", "red");

        $.alert({
            title: useXmltag("Sendemail"),
            icon: 'fa fa-times',
            content: useXmltag("Pleaseenteremailcorrectformat"),
            rtl: true,
            type: 'red',
        });


        return false;
    } else {
        $.post(amadeusPath + 'user_ajax.php',
            {
                email: Email,
                request_number: request_number,
                flag: 'SendBusEmailForOther'
            },
            function (data) {
                var res = data.split(':');
                if (data.indexOf('success') > -1) {
                    $.alert({
                        title: useXmltag("Sendemail"),
                        icon: 'fa fa-check',
                        content: res[1],
                        rtl: true,
                        type: 'green',
                    });
                    setTimeout(function () {
                        $("#ModalSendEmail").fadeOut(700);
                        $('#loaderTracking').fadeOut(500);
                        $('#SendBusEmailForOther').attr("disabled", false);
                        $('#SendForOthers').val(' ');
                    }, 1000);

                } else {
                    $.alert({
                        title: useXmltag("Sendemail"),
                        icon: 'fa fa-times',
                        content: res[1],
                        rtl: true,
                        type: 'red',
                    });
                    $('#SendBusEmailForOther').attr("disabled", false);
                    $('#loaderTracking').fadeOut(500);
                }

            });
    }
}
function openPopularBusCities(targetInput){

    // inject CSS یکبار
    if(!document.getElementById("busCityModalStyle")){
        let style = document.createElement("style");
        style.id = "busCityModalStyle";
        style.innerHTML = `
        .bus-city-modal{
            position: fixed;
            inset:0;
            background:rgba(0,0,0,.45);
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:9999;
        }

        .bus-city-box{
            background:#fff;
            width:420px;
            max-height:75vh;
            overflow-y:auto;
            border-radius:16px;
            padding:18px;
            box-shadow:0 10px 30px rgba(0,0,0,.25);
            font-family: iranyekan , sans-serif;
        }

        .bus-city-box h3{
            margin-bottom:12px;
            text-align:center;
        }

        .city-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:10px;
        }

        .city-item{
            padding:10px 12px;
            border-radius:12px;
            border:1px solid #ddd;
            cursor:pointer;
            transition:.2s;
            text-align:center;
        }

        .city-item:hover{
            background:#f3f7ff;
            border-color:#3f51b5;
            color:#3f51b5;
        }
        `;
        document.head.appendChild(style);
    }

    let modal = document.createElement("div");
    modal.className = "bus-city-modal";
    modal.innerHTML = `
        <div class="bus-city-box">
            <h3>شهرهای محبوب</h3>
            <div id="popularCityList">
                <p>در حال بارگذاری...</p>
            </div>
        </div>
    `;


    document.body.appendChild(modal);

    // بسته شدن با کلیک بیرون
    modal.addEventListener("click", (e)=>{
        if(e.target === modal){
            modal.remove();
        }
    });

    // AJAX گرفتن شهرها
    $.ajax({
        type:"POST",
        url: amadeusPath + "ajax",
        data: JSON.stringify({
            className:"busRoute",
            method:"getPopularBusCities"
        }),
        dataType:"json",
        success:function(res){
            $("#popularCityList").html(`
                <div class="city-grid">
                    ${res.map(c=>`
                        <div class="city-item" onclick="selectCity('${targetInput}','${c.id}','${c.name}')">
                            ${c.name}
                        </div>`).join("")}
                </div>
            `)
        },
        error:function(){
            $("#popularCityList").html("<p>خطا در دریافت اطلاعات</p>");
        }
    })
}


function selectCity(inputId, id, name){

    let sel = document.getElementById(inputId);

    sel.innerHTML = `<option value="${id}" selected>${name}</option>`;

    document.querySelector(".bus-city-modal").remove();
}