$$(document).on("click", ".blit-choose-css-reset", function () {
    $$(".blit-detail .tabs").css("transform", "");
});

$$(document).on("click", ".parvazak-parvaz-dakheli-li", function () {
    $$('#TypeSearch').val('Internal');
});
$$(document).on("click", ".parvazak-parvaz-khareji-li", function () {
    $$('#TypeSearch').val('Foreign');
});

//رفتن به صفحه نمایش بلیط
$$(document).on("click", ".SearchTicket", function () {

    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال جست وجو');
    $$(this).css('opacity', '0.5');


    var TypeSearch = $$('#TypeSearch').val();
    console.log(TypeSearch);
    if (TypeSearch == 'Internal') {
        var Origin = $$('#autocomplete-standalone-Origin').find('input').val();
        var Destination = $$('#autocomplete-standalone-Destination').find('input').val();
        var DepartureDate = $$('.DepartureDate').find('input').val();
        var ReturnDate = $$('.ReturnDate').find('input').val();
        var AdultNumber = $$('.AdultNumber').find('span').text();
        var ChildNumber = $$('.ChildNumber').find('span').text();
        var InfantNumber = $$('.InfantNumber').find('span').text();
        if ($$('#DeptReturnButton').is(':checked')) {
            var MultiWay = 'TwoWay';
        } else {
            var MultiWay = 'OneWay';
        }
    } else if (TypeSearch == 'Foreign') {
        var Origin = $$('#autocomplete-standalone-Origin-foreign').find('input').val();
        var Destination = $$('#autocomplete-standalone-Destination-foreign').find('input').val();
        var DepartureDate = $$('.DepartureDateForeign').find('input').val();
        var ReturnDate = $$('.ReturnDateForeign').find('input').val();
        var AdultNumber = $$('.AdultNumberForeign').find('span').text();
        var ChildNumber = $$('.ChildNumberForeign').find('span').text();
        var InfantNumber = $$('.InfantNumberForeign').find('span').text();
        if ($$('#DeptReturnButtonForeign').is(':checked')) {
            var MultiWay = 'TwoWay';
        } else {
            var MultiWay = 'OneWay';
        }
    }

    var CountPassengers = AdultNumber + ChildNumber;


    if (Origin == "" || Destination == "" || DepartureDate == "" || AdultNumber == "" || ChildNumber == "" || InfantNumber == "") {

        var toastLargeMessage = app.toast.create({
            text: 'لطفا موارد لازم را پر نمائید',
            closeTimeout: 4000,
            position: 'top'
        });


    } else if ($$('#DeptReturnButton').is(':checked') && $$('#demo-calendar-default2').val() == '') {
        var toastLargeMessage = app.toast.create({
            text: 'لطفا تاریخ برگشت را وارد نمائید',
            closeTimeout: 4000,
            position: 'top'
        });
    } else if (CountPassengers > '9' || InfantNumber > AdultNumber) {
        var toastLargeMessage = app.toast.create({
            text: ' مجموع بزرگسال و کودک نباید از نه بیشتر باشد و یا تعداد نوزاد نباید از بزرگسال بیشتر باشد',
            closeTimeout: 4000,
            position: 'top'
        });

    } else if (AdultNumber == 0) {
        var toastLargeMessage = app.toast.create({
            text: ' لطفا حداقل یک بزرگسال انتخاب نمایید',
            closeTimeout: 4000,
            position: 'top'
        });
    } else {
        setTimeout(function () {
            $$('.SearchTicketInternal').find('span').text('جست وجوی بلیط');
            $$('.SearchTicketInternal').css('opacity', '1');
            $$('.SearchTicketInternal').find('i').addClass('myhidden');

        }, 2500);


        if (TypeSearch == 'Internal') {
            app.router.navigate("/TicketInternalApp/?Origin=" + Origin +
                "&Destination=" + Destination +
                "&DepartureDate=" + DepartureDate +
                "&ReturnDate=" + ReturnDate +
                "&AdultNumber=" + AdultNumber +
                "&ChildNumber=" + ChildNumber +
                "&InfantNumber=" + InfantNumber +
                "&MultiWay=" + MultiWay +
                "&Foreign=Local"
            );
        } else if (TypeSearch == 'Foreign') {
            app.router.navigate("/TicketForeignApp/?Origin=" + Origin +
                "&Destination=" + Destination +
                "&DepartureDate=" + DepartureDate +
                "&ReturnDate=" + ReturnDate +
                "&AdultNumber=" + AdultNumber +
                "&ChildNumber=" + ChildNumber +
                "&InfantNumber=" + InfantNumber +
                "&MultiWay=" + MultiWay +
                "&Foreign=international"
            );
        }

    }

    if (toastLargeMessage) {

        setTimeout(function () {
            $$('.SearchTicketInternal').find('span').text('جست وجوی بلیط');
            $$('.SearchTicketInternal').css('opacity', '1');
            $$('.SearchTicketInternal').find('i').addClass('myhidden');

        }, 2500);

        toastLargeMessage.open();
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
//رفتن به ریولیدیت
$$(document).on("click", ".GoToRevalidate", function () {

    app.preloader.show();

    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال بررسی');
    $$(this).css('opacity', '0.5');

    var FlightIDReserveOffline = $$('#FlightIDReserveOffline').val();

    if (FlightIDReserveOffline == "") {
        var FlightID = $$(this).attr('data-FlightID');
        var UniqueCode = $$(this).attr('data-UniqueCode');
        var SourceId = $$(this).attr('data-SourceId');
        var adult = $$(this).attr('data-adult');
        var child = $$(this).attr('data-child');
        var infant = $$(this).attr('data-infant');
        var FlightDirection = $$(this).attr('data-FlightDirection');
    } else {

        var FlightID = $$('#FlightIDReserveOffline').val();
        var FlightIdReplaced = FlightID.replace(/#/g, "");
        var info = $$('.Dialog-' + FlightIdReplaced);
        var UniqueCode = info.attr('data-UniqueCode');
        var SourceId = info.attr('data-SourceId');
        var adult = info.attr('data-adult');
        var child = info.attr('data-child');
        var infant = info.attr('data-infant');
        var FlightDirection = info.attr('data-FlightDirection');

    }

    var MultiWay = $$('#MultiWayTicket').val();
    var TypeZoneFlight = $$('#TypeZoneFlightList').val() == 'Local' ? 'Local' : 'Foreign';

    var uniq_id = $$('.selected_session_filght_Id').val();
    var useType = 'ticket';

        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            data: {
                flag: 'revalidate_Fight',
                Flight: FlightID,
                UniqueCode: UniqueCode,
                SourceId: SourceId,
                adt: adult,
                chd: child,
                inf: infant,
                FlightDirection: FlightDirection,
                MultiWay: MultiWay,
                uniq_id: uniq_id,
                Type: 'App'
            },
            success: function (data) {


                if (data.result_status == 'SuccessLogged' || data.result_status == 'SuccessNotLoggedIn') {

                    if (MultiWay == 'TwoWay' && FlightDirection == 'dept' && TypeZoneFlight == 'Local') {
                        app.preloader.hide();
                        $$('.blit-item.deptFlight').hide(1500);
                        $$('.selectedTicket').append(data.result_selected_ticket);
                        $$('html, body').animate({scrollTop: $$('.selectedTicket').offset().top}, 3000);

                        $$('.blit-item.returnFlight').filter(function (index) {
                            //if dept and return date is the same, return flights filter by dept choose
                            if ($$('#dept_date').val() == $$('#return_date').val()) {
                                var returnFlightTime = $$(this).find('.timeSortDep').html();
                                return (returnFlightTime.substr(0, 2) > data.result_selected_time);
                            } else {
                                return $$(this).find('.source').html() != 'reservation';
                            }
                        }).css("cssText", "display: flex !important;");

                    } else {
                        setTimeout(function () {
                            $$('.GoToRevalidate').find('span').text('رزرو بلیط');
                            $$('.GoToRevalidate').css('opacity', '1');
                            $$('.GoToRevalidate').find('i').addClass('myhidden');

                        }, 2500);


                        if (data.result_status == 'SuccessLogged') {
                            app.preloader.hide();
                            app.router.navigate("/TicketDetailApp/?Uniq_id=" + data.result_uniq_id +
                                "&TypeZoneFlight=" + TypeZoneFlight + "&SourceId=" + SourceId + "&useType=" + useType
                            );
                        } else if (data.result_status == 'SuccessNotLoggedIn') {
                            app.preloader.hide();
                            app.router.navigate("/login/?Uniq_id=" + data.result_uniq_id +
                                "&TypeZoneFlight=" + TypeZoneFlight + "&SourceId=" + SourceId + "&useType=" + useType
                            );
                        }
                    }
                } else {


                    var toastLargeMessage = app.toast.create({
                        text: 'خطا در روند رزرو،لطفا مجددا تلاش نمائید',
                        closeTimeout: 4000,
                        position: 'top'
                    });
                    toastLargeMessage.open();

                    setTimeout(function () {
                        $$('.GoToRevalidate').find('span').text('رزرو بلیط');
                        $$('.GoToRevalidate').css('opacity', '1');
                        $$('.GoToRevalidate').find('i').addClass('myhidden');

                    }, 2500);
                }
                // $$('.first-preloader').show(); //var app is initialized by now
                // setTimeout(function () {
                //     $$('.first-preloader').addClass("hide");
                //     $$('#TicketInternal').html(data);
                // }, 1000);

            }
        });

});

//رفتن به صفحه ورود اسامی
$$(document).on("click", ".GoToPassengersDetailApp", function () {
    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال انتقال');
    $$(this).css('opacity', '0.5');

    var Uniq_id = $$('#Uniq_id').val();
    var SourceId = $$('#SourceId').val();
    var TypeZoneFlight = $$('#TypeZoneFlight').val();

    setTimeout(function () {
        $$('.GoToPassengersDetailApp').find('span').text('ورود');
        $$('.GoToPassengersDetailApp').css('opacity', '1');
        $$('.GoToPassengersDetailApp').find('i').addClass('myhidden');

    }, 2500);
    app.router.navigate("/PassengersDetailApp/?Uniq_id=" + Uniq_id +
        "&TypeZoneFlight=" + TypeZoneFlight + "&SourceId=" + SourceId
    );

});

//رفتن به صفحه پیش فاکتور
$$(document).on("click", ".GoToFactorLocalApp", function () {
    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال بررسی');
    $$(this).css('opacity', '0.5');

    var Uniq_id = $$('#Uniq_id').val();
    var TypeZoneFlight = $$('#TypeZoneFlightDetail').val();
    var AdultCount = $$('#AdultCount').val();
    var ChildCount = $$('#ChildCount').val();
    var InfantCount = $$('#InfantCount').val();
    var CurrentTime = $$('#CurrentTime').val();
    var mobile_buyer = $$('#Mobile_buyer').val();
    var email_buyer = $$('#Email_buyer').val();
    var IdMember = $$('#IdMember').val();
    var SourceID = $$('#SourceID').val();

    var errorAdult = 0;
    var errorChild = 0;
    var errorInfant = 0;
    var errorBuyer = 0;
    if (mobile_buyer == '' || email_buyer == '') {
        errorBuyer = 1;
        var toastLargeMessage = app.toast.create({
            text: 'لطفا اطلاعات مربوط به خریدار را وارد نمائید',
            closeTimeout: 2000,
            position: 'top'
        });
        setTimeout(function () {
            $$('.GoToFactorLocalApp').find('span').text('ادامه');
            $$('.GoToFactorLocalApp').css('opacity', '1');
            $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

        }, 2500);
    } else {
        var mobregqx = /(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!mobregqx.test(mobile_buyer)) {

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
        } else if (!emailReg.test(email_buyer)) {
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
    if (InfantCount > 0) {
        var Inf = Infant_members(CurrentTime, InfantCount);
        if (Inf == 'true') {
            errorInfant = 0
        } else {
            errorInfant = 1
            setTimeout(function () {
                $$('.GoToFactorLocalApp').find('span').text('ادامه');
                $$('.GoToFactorLocalApp').css('opacity', '1');
                $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

            }, 2500);
        }
    }


    if (ChildCount > 0) {
        var Chd = Child_members(CurrentTime, ChildCount);
        if (Chd == 'true') {
            errorChild = 0
        } else {
            errorChild = 1
            setTimeout(function () {
                $$('.GoToFactorLocalApp').find('span').text('ادامه');
                $$('.GoToFactorLocalApp').css('opacity', '1');
                $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

            }, 2500);
        }
    }


    if (AdultCount > 0) {
        var adt = Adult_members(CurrentTime, AdultCount);
        console.log('ssm' + adt);
        if (adt == 'true') {
            errorAdult = 0
        } else {
            errorAdult = 1
            setTimeout(function () {
                $$('.GoToFactorLocalApp').find('span').text('ادامه');
                $$('.GoToFactorLocalApp').css('opacity', '1');
                $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

            }, 2500);
        }
    }


    if (errorAdult == 0 && errorChild == 0 && errorInfant == 0 && errorBuyer == 0) {
        var formDataDecode = app.form.convertToData('#my-form');
        var formData = JSON.stringify(formDataDecode);
        var factorNumber = '';

        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            //send "query" to server. Useful in case you generate response dynamically
            data: {
                flag: 'PreReserve',
                uniq_id: Uniq_id,
                dataForm: formData,
                type: 'App'
            },
            success: function (data) {
                console.log(data);
                var factor_number = '';
                var RequestNumber = {};
                if (data.total_status == 'success') {
                    if (typeof data.dept !== 'undefined') {
                        $$('#RequestNumber_dept').val(data.dept.result_request_number);
                        factor_number = data.dept.result_factor_number;
                        RequestNumber['dept'] = $$('#RequestNumber_dept').val();
                    }
                    if (typeof data.return !== 'undefined') {
                        $$('#RequestNumber_return').val(data.return.result_request_number);
                        RequestNumber['return'] = $$('#RequestNumber_return').val();
                        factor_number = data.return.result_factor_number;
                    }
                    if (typeof data.TwoWay !== 'undefined') {
                        $$('#RequestNumber_TwoWay').val(data.TwoWay.result_request_number);
                        RequestNumber['TwoWay'] = $$('#RequestNumber_TwoWay').val();
                        factor_number = data.TwoWay.result_factor_number;
                    }
                    var RequestNumberJsonEncoded = JSON.stringify(RequestNumber);

                    if ($$('#CaptchaCode').length > 0) {
                        var CaptchaCode = $$('#CaptchaCode').val();
                    } else {
                        var CaptchaCode = '';
                    }


                    if ($$('#CaptchaReturnCode').length > 0) {
                        var CaptchaReturnCode = $$('#CaptchaReturnCode').val();
                    } else {
                        var CaptchaReturnCode = '';
                    }

                    BookFlight(RequestNumberJsonEncoded, IdMember, SourceID, CaptchaCode,CaptchaReturnCode, factor_number);

                } else {
                    setTimeout(function () {
                        $$('.GoToFactorLocalApp').find('span').text('ادامه');
                        $$('.GoToFactorLocalApp').css('opacity', '1');
                        $$('.GoToFactorLocalApp').find('i').addClass('myhidden');

                    }, 2500);
                    var toastLargeMessage = app.toast.create({
                        text: 'خطا در روند رزرو بلیط،لطفا مجددا اقدام نمائید',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    return false;
                }
            }


        });

    }


    if (toastLargeMessage) {
        toastLargeMessage.open();
    }

});

function BookFlight(RequestNumber, IdMember, SourceID, CaptchaCode, CaptchaReturnCode, factorNumber) {

    console.log('sss');
    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        //send "query" to server. Useful in case you generate response dynamically
        data: {
            flag: 'bookFlight',
            RequestNumber: RequestNumber,
            IdMember: IdMember,
            SourceId: SourceID,
            CaptchaCode: CaptchaCode,
            CaptchaReturnCode: CaptchaReturnCode,
        },
        success: function (response) {

            console.log(response);

            if (response.total_status == 'success') {

                app.router.navigate("/TicketFactor/?RequestNumber=" + RequestNumber + "&factorNumber=" + factorNumber);

            } else {
                setTimeout(function () {
                    $$('.GoToFactorLocalApp').find('span').text('خطا');
                    $$('.GoToFactorLocalApp').css('opacity', '0.5');
                    $$('.GoToFactorLocalApp').find('i').removeClass('myhidden');

                }, 2500);
                var error_message = '';
                var error_code = '';
                if (response.dept.result_status == 'error') {

                    if (typeof response.dept.result_message == 'object') {
                        error_message = Object.values(response.dept.result_message)
                    } else {
                        error_message = response.dept.result_message;
                    }
                    error_code = response.dept.result_code;

                    if (error_code == '-402' || error_code == '-458' || error_code == '-411') {

                        var src = $$("#ImageCaptcha").attr('src');

                        var ssrc = src + '&temp=12112';

                        $$("#ImageCaptcha").attr('src', ssrc);
                    }
                } else if (typeof response.return !== 'undefined' && response.return.result_status == 'error') {

                    if (typeof  response.return.result_message == 'object') {
                        error_message = Object.values(response.return.result_message);
                    } else {
                        error_message = response.return.result_message;
                    }
                    error_code = response.return.result_code;
                    if (error_code == '-402' || error_code == '-458' || error_code == '-411') {

                        var src = $$("#ImageCaptcha").attr('src');
                        var ssrc = src + '&temp=12112';

                        $$("#ImageCaptcha").attr('src', ssrc);

                    }

                }
                var toastLargeMessage = app.toast.create({
                    text: error_message,
                    closeTimeout: 2000,
                    position: 'top'
                });

                if (toastLargeMessage) {
                    toastLargeMessage.open();
                }
            }

        }
    });
}

function getNationalCode(Code, Input) {

    var National = $$('.UniqNationalCode').map(function () {
        return $$(this).val();
    });

    var NationalCodesArray = National.toString().split(',');
    var flag = 0;

    NationalCodesArray.forEach(function (index, element) {
        if (element != "" && Code == element) {
            // alert(element);
            flag = parseInt(flag) + 1;
        }

    });
    if (flag != 0 && flag != 1) {
        return false;
    }


}

function Adult_members(CurrentTime, numAdult) {
    //  بررسی فیلدهای بزرگسالان
    var error = 0;
    for (var i = 1; i <= numAdult; i++) {

        var gender = $$("#genderA" + i + ":checked").val();
        var PassengerNationality = $$("#passengerNationalityA" + i + ":checked").val();
        var NameFa = $$("#nameFaA" + i).val();
        var FamilyFa = $$("#familyFaA" + i).val();
        var NameEnA = $$("#nameEnA" + i).val();
        var FamilyEnA = $$("#familyEnA" + i).val();
        var TypeZoneFlight = $$('#TypeZoneFlightDetail').val();
        var National_Code = $$('#NationalCodeA' + i).val();


        if (gender != 'Male' && gender != 'Female') {


            var toastLargeMessage = app.toast.create({
                text: 'لطفا جنسیتمسافر بزرگسال دوم  را انتخاب نمائید',
                closeTimeout: 2000,
                position: 'top'
            });


            error = 1;
            console.log('gender=>' + error);
        }

        if (TypeZoneFlight != 'Local') {
            if ($$("#passportNumberA" + i).val() == "" || $$("#passportExpireA" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا اطلاعات پاسپورت را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
                console.log('TypeZoneFlight=>' + error);
            }
        }


        //بررسی تاریخ تولد
        var YearMiladi = $$("#YearMiladiA" + i).val();
        var MonthMiladi = $$("#MonthMiladiA" + i).val();
        var DayMiladi = $$("#DayMiladiA" + i).val();
        var t = YearMiladi + '-' + MonthMiladi + '-' + DayMiladi;
        $$("#birthdayEnA" + i).val(t);
        var d = new Date(t);
        n = Math.round(d.getTime() / 1000);
        if ((CurrentTime - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
            var toastLargeMessage = app.toast.create({
                text: 'تاریخ تولد صحیح نمی باشد',
                closeTimeout: 2000,
                position: 'top'
            });
            error = 1;
            console.log('YearMiladiSahih=>' + error);
        } else if ($$("#birthdayEnA" + i).val() == "") {
            var toastLargeMessage = app.toast.create({
                text: 'تاریخ تولد را وارد نمائید',
                closeTimeout: 2000,
                position: 'top'
            });
            error = 1;
            console.log('YearMiladiEmpty=>' + error);
        }

        if (PassengerNationality == '1') {
            if ($$("#birthdayEnA" + i).val() == "" || $$("#passportCountryA" + i).val() == "" || $$("#passportNumberA" + i).val() == "" || $$("#passportExpireA" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا تمام موارد لازم را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
                console.log('PassengerNationality=>' + error);
            }

        } else {

            var YearJalali = $$("#YearJalaliA" + i).val();
            var MonthJalali = $$("#MonthJalaliA" + i).val();
            var DayJalali = $$("#DayJalaliA" + i).val();
            var t = YearJalali + '-' + MonthJalali + '-' + DayJalali;
            $$("#birthdayA" + i).val(t);

            if ($$("#birthdayA" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'تاریخ تولد را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }


            var CheckEqualNationalCode = getNationalCode(National_Code, $$('#NationalCodeA' + i));
            if (CheckEqualNationalCode == false) {
                var toastLargeMessage = app.toast.create({
                    text: 'کد ملی تکراری می باشد',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }

            // var z1 = /^[0-9]*\d$/;
            // var convertedCode = convertNumber(National_Code);
            // if (National_Code != "") {
            //     if (!z1.test(convertedCode)) {
            //         var toastLargeMessage = app.toast.create({
            //             text: 'کد ملی تکراری می باشد',
            //             closeTimeout: 2000,
            //             position: 'top'
            //         });
            //         error = 1;
            //     } else

            if (National_Code != "") {
                if ((National_Code.toString().length != 10)) {
                    var toastLargeMessage = app.toast.create({
                        text: 'در کد ملی تنها از 10 رقم میتوانید استفاده کنید',
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    error = 1;
                } else {
                    var NCode = checkCodeMeli(National_Code);
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


            //بررسی تاریخ تولد
            // var YearJalali = $$("#YearJalaliA" + i).val();
            // var MonthJalali = $$("#MouthJalaliA" + i).val();
            // var DayJalali = $$("#DayJalaliA" + i).val();
            // // var t = YearJalali +'-'+ MonthJalali +'-'+ DayJalali ;
            // // var splitit = t.split('-');
            // var JDate = require('jdate');
            // var jdate2 = new JDate([YearJalali, MonthJalali, DayJalali]);
            // console.log(jdate2);
            // // var array = jdate2.map(function (value, index) {
            // //     return [value];
            // // });
            // var d = new Date(YearJalali);
            //
            // console.log(d);
            // var n = Math.round(d.getTime() / 1000);
            // console.log(n);
            // console.log(CurrentTime);
            // if ((CurrentTime - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
            //     console.log('ss');
            //     var toastLargeMessage = app.toast.create({
            //         text: 'تاریخ تولد صحیح نمی باشد',
            //         closeTimeout: 2000,
            //         position: 'top'
            //     });
            //
            //     error = 1;
            // }else {
            //     console.log('ss333');
            // }
        }

        if (gender == "" || NameFa == "" || FamilyFa == "" || NameEnA == "" || FamilyEnA == "") {

            var toastLargeMessage = app.toast.create({
                text: 'کلیه موارد را وارد نمائید',
                closeTimeout: 2000,
                position: 'top'
            });
            error = 1;
            console.log('AllData=>' + error);
        }
    }

    if (toastLargeMessage) {
        toastLargeMessage.open();
    }


    console.log('ssd=>' + error);
    if (error == 0) {
        return 'true';
    } else {
        return 'false';
    }
}

function Child_members(CurrentTime, numInfant) {
    // بررسی فبلدهای نوزاد
    var error = 0;
    for (var i = 1; i <= numInfant; i++) {


        var gender = $$("#genderC" + i + ":checked").val();
        var PassengerNationality = $$("#passengerNationalityC" + i + ":checked").val();
        var NameFa = $$("#nameFaC" + i).val();
        var FamilyFa = $$("#familyFaC" + i).val();
        var NameEnA = $$("#nameEnC" + i).val();
        var FamilyEnA = $$("#familyEnC" + i).val();
        var TypeZoneFlight = $$('#TypeZoneFlightDetail').val();
        var National_Code = $$('#NationalCodeC' + i).val();


        if (gender != 'Male' && gender != 'Female') {

            var toastLargeMessage = app.toast.create({
                text: 'لطفا جنسیت را انتخاب نمائید',
                closeTimeout: 2000,
                position: 'top'
            });


            error = 1;
        }

        if (TypeZoneFlight != 'Local') {
            if ($$("#passportNumberC" + i).val() == "" || $$("#passportExpireC" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا اطلاعات پاسپورت را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }
        }

        if (PassengerNationality == '1') {
            if ($$("#birthdayEnC" + i).val() == "" || $$("#passportCountryC" + i).val() == "" || $$("#passportNumberC" + i).val() == "" || $$("#passportExpireC" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا تمام موارد لازم را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }

            // //بررسی تاریخ تولد
            var YearMiladi = $$("#YearMiladiC" + i).val();
            var MonthMiladi = $$("#MonthMiladiC" + i).val();
            var DayMiladi = $$("#DayMiladiC" + i).val();
            var t = YearMiladi + '-' + MonthMiladi + '-' + DayMiladi;
            $$("#birthdayEnC" + i).val(t);
            var d = new Date(t);
            n = Math.round(d.getTime() / 1000);
            if ((CurrentTime - n) < 63072000 || 378691200 < (CurrentTime - n)) { // 12سال =(12*365+3)*24*60*60
                var toastLargeMessage = app.toast.create({
                    text: 'تاریخ تولد کودک صحیح نمی باشد',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }

        } else {
            var YearJalali = $$("#YearJalaliC" + i).val();
            var MonthJalali = $$("#MonthJalaliC" + i).val();
            var DayJalali = $$("#DayJalaliC" + i).val();
            var t = YearJalali + '-' + MonthJalali + '-' + DayJalali;
            $$("#birthdayC" + i).val(t);

            if ($$("#birthdayC" + i).val() == "" || $$('#NationalCodeC' + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'تاریخ تولد کودک را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }


            var CheckEqualNationalCode = getNationalCode(National_Code, $$('#NationalCodeC' + i));
            if (CheckEqualNationalCode == false) {
                var toastLargeMessage = app.toast.create({
                    text: 'کد ملی تکراری می باشد',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }

            // var z1 = /^[0-9]*\d$/;
            // var convertedCode = convertNumber(National_Code);
            // if (National_Code != "") {
            //     if (!z1.test(convertedCode)) {
            //         var toastLargeMessage = app.toast.create({
            //             text: 'کد ملی تکراری می باشد',
            //             closeTimeout: 2000,
            //             position: 'top'
            //         });
            //         error = 1;
            //     } else
            if ((National_Code.toString().length != 10)) {
                var toastLargeMessage = app.toast.create({
                    text: 'در کد ملی تنها از 10 رقم میتوانید استفاده کنید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            } else {
                var NCode = checkCodeMeli(National_Code);
                if (!NCode) {
                    var toastLargeMessage = app.toast.create({
                        text: 'کد ملی وارد شده معتبر نمی باشد',
                        closeTimeout: 2000,
                        position: 'top'
                    });

                    error = 1;
                }
            }


            //بررسی تاریخ تولد
            // var YearJalali = $$("#YearJalaliA" + i).val();
            // var MonthJalali = $$("#MouthJalaliA" + i).val();
            // var DayJalali = $$("#DayJalaliA" + i).val();
            // // var t = YearJalali +'-'+ MonthJalali +'-'+ DayJalali ;
            // // var splitit = t.split('-');
            // var JDate = require('jdate');
            // var jdate2 = new JDate([YearJalali, MonthJalali, DayJalali]);
            // console.log(jdate2);
            // // var array = jdate2.map(function (value, index) {
            // //     return [value];
            // // });
            // var d = new Date(YearJalali);
            //
            // console.log(d);
            // var n = Math.round(d.getTime() / 1000);
            // console.log(n);
            // console.log(CurrentTime);
            // if ((CurrentTime - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
            //     console.log('ss');
            //     var toastLargeMessage = app.toast.create({
            //         text: 'تاریخ تولد صحیح نمی باشد',
            //         closeTimeout: 2000,
            //         position: 'top'
            //     });
            //
            //     error = 1;
            // }else {
            //     console.log('ss333');
            // }
        }

        if (gender == "" || NameFa == "" || FamilyFa == "" || NameEnA == "" || FamilyEnA == "") {

            var toastLargeMessage = app.toast.create({
                text: 'کلیه موارد را وارد نمائید',
                closeTimeout: 2000,
                position: 'top'
            });
            error = 1;
        }
        //10min
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

function Infant_members(CurrentTime, numChild) {
    //  بررسی فیلدهای کودک
    var error = 0;
    for (var i = 1; i <= numChild; i++) {


        var gender = $$("#genderI" + i + ":checked").val();
        var PassengerNationality = $$("#passengerNationalityI" + i + ":checked").val();
        var NameFa = $$("#nameFaI" + i).val();
        var FamilyFa = $$("#familyFaI" + i).val();
        var NameEnA = $$("#nameEnI" + i).val();
        var FamilyEnA = $$("#familyEnI" + i).val();
        var TypeZoneFlight = $$('#TypeZoneFlightDetail').val();
        var National_Code = $$('#NationalCodeI' + i).val();


        if (gender != 'Male' && gender != 'Female') {

            var toastLargeMessage = app.toast.create({
                text: 'لطفا جنسیت را انتخاب نمائید',
                closeTimeout: 2000,
                position: 'top'
            });


            error = 1;
        }

        if (TypeZoneFlight != 'Local') {
            if ($$("#passportNumberC" + i).val() == "" || $$("#passportExpireC" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا اطلاعات پاسپورت را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }
        }
// //بررسی تاریخ تولد
        var YearMiladi = $$("#YearMiladiI" + i).val();
        var MonthMiladi = $$("#MonthMiladiI" + i).val();
        var DayMiladi = $$("#DayMiladiI" + i).val();
        var t = YearMiladi + '-' + MonthMiladi + '-' + DayMiladi;
        $$("#birthdayEnI" + i).val(t);
        var d = new Date(t);
        n = Math.round(d.getTime() / 1000);
        if ((CurrentTime - n) > 63072000) { // 12سال =(2*365+3)*24*60*60
            var toastLargeMessage = app.toast.create({
                text: 'تاریخ تولد  نوزاد صحیح نمی باشد',
                closeTimeout: 2000,
                position: 'top'
            });
            error = 1;
        }
        if (PassengerNationality == '1') {
            if ($$("#birthdayEnI" + i).val() == "" || $$("#passportCountryI" + i).val() == "" || $$("#passportNumberI" + i).val() == "" || $$("#passportExpireI" + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'لطفا تمام موارد لازم را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }


        } else {
            var YearJalali = $$("#YearJalaliI" + i).val();
            var MonthJalali = $$("#MonthJalaliI" + i).val();
            var DayJalali = $$("#DayJalaliI" + i).val();
            var t = YearJalali + '-' + MonthJalali + '-' + DayJalali;
            $$("#birthdayI" + i).val(t);

            if ($$("#birthdayI" + i).val() == "" || $$('#NationalCodeI' + i).val() == "") {
                var toastLargeMessage = app.toast.create({
                    text: 'تاریخ تولد را وارد نمائید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }


            var CheckEqualNationalCode = getNationalCode(National_Code, $$('#NationalCodeI' + i));
            if (CheckEqualNationalCode == false) {
                var toastLargeMessage = app.toast.create({
                    text: 'کد ملی تکراری می باشد',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            }

            if ((National_Code.toString().length != 10)) {
                var toastLargeMessage = app.toast.create({
                    text: 'در کد ملی تنها از 10 رقم میتوانید استفاده کنید',
                    closeTimeout: 2000,
                    position: 'top'
                });
                error = 1;
            } else {
                var NCode = checkCodeMeli(National_Code);
                if (!NCode) {
                    var toastLargeMessage = app.toast.create({
                        text: 'کد ملی وارد شده معتبر نمی باشد',
                        closeTimeout: 2000,
                        position: 'top'
                    });

                    error = 1;
                }
            }


            //بررسی تاریخ تولد
            // var YearJalali = $$("#YearJalaliA" + i).val();
            // var MonthJalali = $$("#MouthJalaliA" + i).val();
            // var DayJalali = $$("#DayJalaliA" + i).val();
            // // var t = YearJalali +'-'+ MonthJalali +'-'+ DayJalali ;
            // // var splitit = t.split('-');
            // var JDate = require('jdate');
            // var jdate2 = new JDate([YearJalali, MonthJalali, DayJalali]);
            // console.log(jdate2);
            // // var array = jdate2.map(function (value, index) {
            // //     return [value];
            // // });
            // var d = new Date(YearJalali);
            //
            // console.log(d);
            // var n = Math.round(d.getTime() / 1000);
            // console.log(n);
            // console.log(CurrentTime);
            // if ((CurrentTime - n) < 378691200) { // 12سال =(12*365+3)*24*60*60
            //     console.log('ss');
            //     var toastLargeMessage = app.toast.create({
            //         text: 'تاریخ تولد صحیح نمی باشد',
            //         closeTimeout: 2000,
            //         position: 'top'
            //     });
            //
            //     error = 1;
            // }else {
            //     console.log('ss333');
            // }
        }

        if (gender == "" || NameFa == "" || FamilyFa == "" || NameEnA == "" || FamilyEnA == "") {

            var toastLargeMessage = app.toast.create({
                text: 'کلیه موارد را وارد نمائید',
                closeTimeout: 2000,
                position: 'top'
            });
            error = 1;
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
    /*return true;*/
}

/*  $$(document).on("click", ".GoToBookTicket", function () {
// function GoToBookTicket(RequestNumber,IdMember,SourceID,ServiceType) {

    $$('.GoToBookTicket').find('i').removeClass('myhidden');
    $$('.GoToBookTicket').find('span').text('در حال بررسی');
    $$('.GoToBookTicket').css('opacity', '0.5');

    var RequestNumber = $$('#RequestNumber').val();
    var ServiceType = $$('#serviceType').val();


    if ($$('#discount-code').length > 0) {
        var discountCode = $$('#discount-code').val();
    } else {
        var discountCode = '';
    }


  app.router.navigate("/ChooseBank/?RequestNumber=" + RequestNumber +
        "&ServiceType=" + ServiceType +
        "&discountCode=" + discountCode +
        "&flag=" + "check_credit" +
        "&nameApplication=" + "flight"
    );

// }
});*/

function SearchAgain(Date, Departure, Arrival, AdultNumber, ChildNumber, InfantNumber) {

    app.preloader.show();
    var origin = Departure;
    var destination = Arrival;
    var dept_date = Date;
    var return_date = '';
    var classf = "Y";
    var adult = AdultNumber;
    var child = ChildNumber;
    var infant = InfantNumber;
    var foreign = $$('#foreign').val();
    app.request({
        url: '../user_ajax.php',
        method: 'post',
        dataType: 'json',
        //send "query" to server. Useful in case you generate response dynamically
        data: {
            flag: 'getResultTicketLocalApp',
            origin: origin,
            destination: destination,
            dept_date: dept_date,
            return_date: return_date,
            classf: classf,
            adult: adult,
            child: child,
            infant: infant,
            foreign: foreign
        },
        success: function (data) {

            app.request({
                url: '../user_ajax.php',
                method: 'post',
                dataType: 'json',
                data: {
                    flag: 'DateSelectedApp',
                    DateSelected: dept_date
                },
                success: function (Response) {

                    $$('.blit-search-date').html(Response.DateSelected);
                    $$('#DatePrev').attr('onclick', "SearchAgain('" + Response.DatePrev + "','" + Departure + "','" + Arrival + "','" + AdultNumber + "','" + ChildNumber + "','" + InfantNumber + "')");
                    $$('#DateNext').attr('onclick', "SearchAgain('" + Response.DateNext + "','" + Departure + "','" + Arrival + "','" + AdultNumber + "','" + ChildNumber + "','" + InfantNumber + "')");

                }
            });

            setTimeout(function () {

                $$('#TicketInternal').html('');
                $$('#dept_date').val(dept_date);
                $$('#TicketInternal').html(data);
                app.preloader.hide();
            }, 1000);

        }
    });

}


$$(document).on("click", ".SendRequestOfflineTicket", function () {
    var FlightID = $$('#FlightIDReserveOffline').val();
    var FlightIdReplaced = FlightID.replace(/#/g, "");
    var info = $$('#InfoTicketResult-' + FlightIdReplaced).val();
    app.router.navigate("/requestOfflineTicket/?InfoRequest=" + info
    );
    app.dialog.close();

});

$$(document).on("click", ".flightReserveOffline", function () {
    var FlightID = $$(this).attr('data-flightid');
    var CLIENT_PHONE = $$(this).attr('data-Phone');
    var UniqueCode = $$(this).attr('data-UniqueCode');
    var SourceId = $$(this).attr('data-SourceId');
    var Adult = $$(this).attr('data-adult');
    var Child = $$(this).attr('data-child');
    var Infant = $$(this).attr('data-infant');
    var FlightDirection = $$(this).attr('data-FlightDirection');

    var FlightIdReplaced = FlightID.replace(/#/g, "");
    $$('#FlightIDReserveOffline').val(FlightID);


    app.dialog.create({
        title: 'رزرو پرواز',
        text: 'شما از روش های زیر میتوانید پرواز خود را رزرو نمائید',
        buttons: [
            {
                text: '<a class="SendRequestOfflineTicket">درخواست رزرو پیامکی</a>',
            },
            {
                text: '<a href="tel:' + CLIENT_PHONE + '" class="link external">درخواست رزرو تلفنی</a>',
            },
            {
                text: '<a class="link GoToRevalidate Dialog-' + FlightIdReplaced + '"' +
                'data-FlightId="' + FlightID + '"' +
                'data-UniqueCode="' + UniqueCode + '" ' +
                'data-SourceId="' + SourceId + '"' +
                'data-adult="' + Adult + '"' +
                'data-child="' + Child + '"' +
                'data-infant="' + Infant + '"' +
                'data-FlightDirection="' + FlightDirection + '">  ' +
                'رزرو آنلاین' +
                '</a>'
            },
            {
                text: '<a class="CloseDialog" style="color: red">بستن</a>'
            }
        ],
        verticalButtons: true,
    }).open();

});
$$(document).on("click", ".CloseDialog", function () {
    app.dialog.close();
});
$$(document).on("click", ".SendRequestOffline", function () {
    var InfoFlight = $$('#InfoFlightRequest').val();
    var fullName = $$('#fullName').val();
    var mobile = $$('#mobile').val();
    $$(this).find('i').removeClass('myhidden');
    $$(this).find('span').text('در حال ارسال');
    $$(this).css('opacity', '0.5');

    if (fullName != '' || mobile != '') {
        app.request({
            url: '../user_ajax.php',
            method: 'post',
            dataType: 'json',
            data: {

                flag: 'RequestTicketOffline',
                InfoFlight: InfoFlight,
                fullName: fullName,
                mobile: mobile
            },
            success: function (Response) {
                setTimeout(function () {
                    $$('.SendRequestOffline').find('span').text('ارسال اطلاعات');
                    $$('.SendRequestOffline').css('opacity', '1');
                    $$('.SendRequestOffline').find('i').addClass('myhidden');

                }, 2500);
                if (Response.messageStatus == 'Success') {
                    var toastLargeMessage = app.toast.create({
                        text: Response.messageRequest,
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    if (toastLargeMessage) {
                        toastLargeMessage.open();
                    }
                    // setTimeout(function () {
                    //     document.location.reload();
                    // }, 2500);
                } else {
                    var toastLargeMessage = app.toast.create({
                        text: Response.messageRequest,
                        closeTimeout: 2000,
                        position: 'top'
                    });
                    if (toastLargeMessage) {
                        toastLargeMessage.open();
                    }
                }

            }

        });
    } else {
        setTimeout(function () {
            $$('.SendRequestOffline').find('span').text('ارسال اطلاعات');
            $$('.SendRequestOffline').css('opacity', '1');
            $$('.SendRequestOffline').find('i').addClass('myhidden');

        }, 2500);
        var toastLargeMessage = app.toast.create({
            text: 'لطفا همه موارد را وارد نمائید',
            closeTimeout: 2000,
            position: 'top'
        });
        if (toastLargeMessage) {
            toastLargeMessage.open();
        }
    }


});

$$(document).on("click", ".showTicket", function () {
    var info = $$(this).attr('RequestNumber');
    app.router.navigate("/showTicket/?RequestNumber=" + info
    );

});

$$(document).on("click", ".cancelTicket", function () {
    var info = $$(this).attr('RequestNumber');
    app.router.navigate("/cancelTicket/?RequestNumber=" + info
    );

});

function SelectUser(RequestNumber) {

    $$('.SendInfoCancel').find('i').removeClass('myhidden');
    $$('.SendInfoCancel').find('span').text('در حال ارسال');
    $$('.SendInfoCancel').css('opacity', '0.5');


    var National = [];
    var Reasons = $$('#ReasonUser').val();
    var FactorNumber = $$('#FactorNumber').val();
    var MemberId = $$('#MemberId').val();
    var AccountOwner = $$('#AccountOwner').val();
    var CardNumber = $$('#CardNumber').val();
    var NameBank = $$('#NameBank').val();
    if ($$('#PercentNoMatter').is(':checked')) {
        var PercentNoMatter = 'Yes';
    } else {
        var PercentNoMatter = 'No';
    }

//    var passenger_age = $('#passenger_age').val();
    var NationalCode = [];
    $$('.SelectUser:checked').forEach(function () {

        National.push($$(this).val());
    });

//    var NationalCodes = National.get();

    if ($$('#Ruls').is(':checked')) {
        if (National != "" && Reasons != "") {

            app.request({
                url: '../user_ajax.php',
                method: 'post',
                dataType: 'json',
                data: {
                    NationalCodes: National,
                    Reasons: Reasons,
                    FactorNumber: FactorNumber,
                    RequestNumber: RequestNumber,
                    MemberId: MemberId,
                    AccountOwner: AccountOwner,
                    CardNumber: CardNumber,
                    NameBank: NameBank,
                    PercentNoMatter: PercentNoMatter,
                    Type: 'App',
                    flag: 'RequestCancelUser'
                },
                success: function (data) {

                    if (data.Status == 'success') {
                        var toastLargeMessage = app.toast.create({
                            text: data.Message,
                            closeTimeout: 2000,
                            position: 'bottom'
                        });

                        setTimeout(function () {
                            $$('.SendInfoCancel').find('span').text('ارسال اطلاعات');
                            $$('.SendInfoCancel').css('opacity', '1');
                            $$('.SendInfoCancel').find('i').addClass('myhidden');

                        }, 2500);
                    } else {
                        var toastLargeMessage = app.toast.create({
                            text: data.Message,
                            closeTimeout: 2000,
                            position: 'bottom'
                        });
                    }

                    setTimeout(function () {
                        $$('.SendInfoCancel').find('span').text('ارسال اطلاعات');
                        $$('.SendInfoCancel').css('opacity', '1');
                        $$('.SendInfoCancel').find('i').addClass('myhidden');

                    }, 2500);
                }


            });

        } else {
            var toastLargeMessage = app.toast.create({
                text: ' یک نفر و یا یک دلیل را انتخاب نمائید',
                closeTimeout: 2000,
                position: 'bottom'
            });
            setTimeout(function () {
                $$('.SendInfoCancel').find('span').text('ارسال اطلاعات');
                $$('.SendInfoCancel').css('opacity', '1');
                $$('.SendInfoCancel').find('i').addClass('myhidden');

            }, 2500);
        }
    } else {
        var toastLargeMessage = app.toast.create({
            text: ' لطفا ابتدا قوانین را مطالعه نمائید',
            closeTimeout: 2000,
            position: 'bottom'
        });
        setTimeout(function () {
            $$('.SendInfoCancel').find('span').text('ارسال اطلاعات');
            $$('.SendInfoCancel').css('opacity', '1');
            $$('.SendInfoCancel').find('i').addClass('myhidden');

        }, 2500);
    }
    if (toastLargeMessage) {
        toastLargeMessage.open();
    }

}

$$(document).on("click", ".dlTicket", function () {
    var RequestNumberPdf = $$(this).attr('RequestNumberPdf');
    app.router.navigate("/PdfViewer/?RequestNumberPdf=" + RequestNumberPdf
    );

});

