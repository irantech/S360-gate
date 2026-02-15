$(document).ready(function () {

    var numberOfMonthsResponsive;
    if ($(window).width() < 992) {
        numberOfMonthsResponsive = 1;
    } else {
        numberOfMonthsResponsive = 2;
    }


    let hotelSetDatePicker = function (startDate,endDate) {
        let hotelStartDateShamsi =  $(startDate);
        let hotelEndDateShamsi = $(endDate);
        let datepickerDiv = $('#ui-datepicker-div');
        let selectedStartDate = '+1d';
        hotelStartDateShamsi.datepicker({
            numberOfMonths:numberOfMonthsResponsive,
            minDate:'Y/M/D',
            showButtonPanel: !0,
            onSelect:function(dateText){
                let dt = $(this).datepicker('getDate');

                hotelEndDateShamsi.val('');
                selectedStartDate = dt;

            },
            beforeShow : function (n) {
                e(n,!0);
                datepickerDiv.addClass('INH_class_Datepicker');
            }
        });
        hotelEndDateShamsi.datepicker({
            numberOfMonths: numberOfMonthsResponsive,
            minDate : selectedStartDate,
            showButtonPanel: !0,
            onSelect: function (dateTextReturn) {

                if(hotelStartDateShamsi.val() !='')
                {
                let startDateGreg = _convertJalaliToGregorian(hotelStartDateShamsi.val());
                let endDateGreg = _convertJalaliToGregorian(dateTextReturn);

                let startDate = new Date(startDateGreg);
                let endDate = new Date(endDateGreg);

                let fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
                let fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);
                let dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;
                    console.log(dayDiff)
                    if(dayDiff <= 0){
                    $.alert({
                        title: useXmltag("GoharHotel"),
                        icon: 'fa fa-cart-plus',
                        content: useXmltag("ArrivalDateHotelEqualBeforeDateArrival"),
                        rtl: true,
                        type: 'red'
                    });
                    return false;
                }


                $('#stayingTimeForSearch').html(dayDiff + useXmltag("Night"));
                $('.stayingTime').html(dayDiff + useXmltag("Night"));
                $("#stayingTime").val(dayDiff);
                $("#nights").val(dayDiff);
                }else{
                    $.alert({
                        title: useXmltag("GoharHotel"),
                        icon: 'fa fa-cart-plus',
                        content: useXmltag("Pleaseenterrequiredfields"),
                        rtl: true,
                        type: 'red'
                    });
                }


            },
            beforeShow: function(n) {
                e(n,!0);
                datepickerDiv.addClass('INH_class_Datepicker');
            }
        });
    };

    hotelSetDatePicker('.hotelStartDateShamsi','.hotelEndDateShamsi');



    if (age == undefined){var age = 18;}

    //for dept and return reservations
    $('.deptCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".returnCalendar").datepicker('option', 'minDate', dateText);
            let disabled_arrival_date_internal = $("#arrival_date_internal").is(":disabled")
            let disabled_arrival_date_international = $("#arrival_date_international").is(":disabled")
            let attr = $('.switch-input-js').attr('select_type');

            if(!disabled_arrival_date_internal && disabled_arrival_date_internal != 'undefided') {
                setTimeout(function(){
                    $('#arrival_date_internal').trigger('click').focus();
                },200)
            }if(disabled_arrival_date_internal &&  attr === undefined ){
                $('.box-of-count-passenger-boxes-js').find('.down-count-passenger').addClass('fa-caret-up')
                $('.cbox-count-passenger-js').show();
            }

            if(!disabled_arrival_date_international && disabled_arrival_date_international != 'undefided') {
                setTimeout(function(){
                    $('#arrival_date_international').trigger('click').focus();
                },200)
            }else if(disabled_arrival_date_international &&  attr !== undefined){
                $('.box-of-count-passenger-boxes-js').find('.down-count-passenger').addClass('fa-caret-up')
                $('.cbox-count-passenger-js').show();
            }

        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });

    $('.deptCalendar-en').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".returnCalendar").datepicker('option', 'minDate', dateText);
            let disabled_arrival_date_internal = $("#arrival_date_internal").is(":disabled")
            let disabled_arrival_date_international = $("#arrival_date_international").is(":disabled")
            let attr = $('.switch-input-js').attr('select_type');

            if(!disabled_arrival_date_internal && disabled_arrival_date_internal != 'undefided') {
                setTimeout(function(){
                    $('#arrival_date_internal').trigger('click').focus();
                },200)
            }if(disabled_arrival_date_internal &&  attr === undefined ){
                $('.box-of-count-passenger-boxes-js').find('.down-count-passenger').addClass('fa-caret-up')
                $('.cbox-count-passenger-js').show();
            }

            if(!disabled_arrival_date_international && disabled_arrival_date_international != 'undefided') {
                setTimeout(function(){
                    $('#arrival_date_international').trigger('click').focus();
                },200)
            }else if(disabled_arrival_date_international &&  attr !== undefined){
                $('.box-of-count-passenger-boxes-js').find('.down-count-passenger').addClass('fa-caret-up')
                $('.cbox-count-passenger-js').show();
            }

        },
        beforeShow: function(n) {

            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });

    $('.returnCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.deptCalendar').val(),
        showButtonPanel: !0,
        onSelect: function(dateText){
            $('.cbox-count-passenger-js').show();
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        },
    });

    $('.returnCalendar-en').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.deptCalendar-en').val(),
        showButtonPanel: !0,
        onSelect: function(dateText){
            $('.cbox-count-passenger-js').show();
        },
        beforeShow: function(n) {
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        },
    });


    $('.packageDeptCalender').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".packageReturnCalender").datepicker('option', 'minDate', dateText);
            setTimeout(function(){
                $('#arrival_date_package').trigger('click').focus()
            },500)

        }
    });
    $('.packageReturnCalender').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.packageDeptCalender').val(),
        onSelect: function(dateText){
            $('.cbox-package-count-passenger-js').show();
        },
        showButtonPanel: !0
    });



    //for just shamsi dept and return train
    $('.trainDeptCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){

            $(".trainReturnCalendar").datepicker('option', 'minDate', dateText);

            let disabled_arrival_date = $("#train_arrival_date").is(":disabled")
            if(!disabled_arrival_date ) {
                setTimeout(function(){
                    $('#train_arrival_date').trigger('click').focus();
                },200)
            }if(disabled_arrival_date ){
                $('.cbox-count-passenger-js').show();
            }

        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });
    $('.trainReturnCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.trainDeptCalendar').val(),
        showButtonPanel: !0,
        onSelect: function(dateText){
            $('.cbox-count-passenger-js').show();
        },
        beforeShow: function(n) {
            e(n, !0);
        }
    });
    //for just shamsi dept and return reservations no gregorian
    $('.shamsiOnlyDeptCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".shamsiOnlyReturnCalendar").datepicker('option', 'minDate', dateText);
        }
    });
    $('.shamsiOnlyReturnCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.shamsiOnlyDeptCalendar').val(),
        showButtonPanel: !0
    });

    //for just shamsi dept and return reservations
    $('.shamsiDeptCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".shamsiReturnCalendar").datepicker('option', 'minDate', dateText);
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });
    $('.shamsiReturnCalendar').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.shamsiDeptCalendar').val(),
        showButtonPanel: !0,
        beforeShow: function(n) {
            e(n, !0);
        }
    });

    $('.shamsiDeptCalendarTransfer').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".shamsiReturnCalendar").datepicker('option', 'minDate', dateText);
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });
    //for just shamsi dept and return reservations With Min Date Tomorrow
    $('.shamsiDeptCalendarWithMinDateTomorrow').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: '+2d',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".shamsiReturnCalendarWithMinDateTomorrow").datepicker('option', 'minDate', dateText);
        }
    });
    $('.shamsiReturnCalendarWithMinDateTomorrow').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.shamsiDeptCalendarWithMinDateTomorrows').val(),
        showButtonPanel: !0
    });


    //for just shamsi dept and return reservations to calculate number nights
    $('.shamsiDeptCalendarToCalculateNights').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function (dateText) {
            // $(".shamsiReturnCalendarToCalculateNights").datepicker('option', 'minDate', dateText);
            $(".shamsiReturnCalendarToCalculateNights").val('');
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });
    $('.shamsiReturnCalendarToCalculateNights').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.shamsiDeptCalendarToCalculateNights').val(),
        showButtonPanel: !0,
        onSelect: function (dateTextReturn) {

            let shamsi_dept = $('.shamsiDeptCalendarToCalculateNights').val();

            let dayDiff = convertJalaliToGregorianDatePicker(dateTextReturn,shamsi_dept);
            // let endDateGreg = _convertJalaliToGregorian(dateTextReturn);

            // let startDate = new Date(startDateGreg);
            // let endDate = new Date(endDateGreg);

            // let fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
            // let fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

            // let dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;
            console.log(dayDiff)
            if(dayDiff < 0){
                $.alert({
                    title: useXmltag("GoharHotel"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ArrivalDateHotelEqualBeforeDateArrival"),
                    rtl: true,
                    type: 'red'
                });

                return false;
            }
            $('#stayingTimeForSearch').html(dayDiff + useXmltag("Night"));
            $("#nights").val(dayDiff);
            $('.stayingTime').html(dayDiff + useXmltag("Night"));
            $("#stayingTime").val(dayDiff);
            $("#stayingTimeForeign").val(dayDiff);
            $(".nights-hotel-js").val(dayDiff);

        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });

    var datepicker_type= '';

    $('.init-shamsi-datepicker').on('click',function(e){

        datepicker_type = $(this).data('type')

    })
    $('.init-miladi-datepicker').on('click',function(e){

        datepicker_type = $(this).data('type')

    })



    $('.init-shamsi-return-datepicker2').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $(".check-in-date-js[data-type='"+datepicker_type+"']").val(),
        showButtonPanel: !0,
        onSelect: function (dateTextReturn) {
            console.log('retuen stop==>', $(".check-in-date-js[data-type='"+datepicker_type+"']").val())
            console.log('retuen==>',datepicker_type)
            let shamsi_dept = $(".init-shamsi-datepicker[data-type='"+datepicker_type+"']").val();

            let dayDiff = convertJalaliToGregorianDatePicker(dateTextReturn,shamsi_dept);

            // let endDateGreg = _convertJalaliToGregorian(dateTextReturn);

            // let startDate = new Date(startDateGreg);
            // let endDate = new Date(endDateGreg);

            // let fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
            // let fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

            // let dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;
            console.log(dayDiff)
            if(dayDiff < 0){
                $.alert({
                    title: useXmltag("GoharHotel"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ArrivalDateHotelEqualBeforeDateArrival"),
                    rtl: true,
                    type: 'red'
                });

                return false;
            }
            $('#stayingTimeForSearch').html(dayDiff + useXmltag("Night"));
            $("#nights").val(dayDiff);
            $('.stayingTime').html(dayDiff + useXmltag("Night"));
            $("#stayingTime").val(dayDiff);
            $("#stayingTimeForeign").val(dayDiff);
            $(".nights-hotel-js").val(dayDiff);
            $("."+datepicker_type+"-my-hotels-rooms-js").addClass('active_p');

        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });





    $('.init-shamsi-datepicker').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".init-shamsi-return-datepicker").datepicker('option', 'minDate', dateText);
            // datepicker_type=$(this).data('type')
            console.log('datepicker_type==>',datepicker_type);
            console.log('init==>', $(".init-shamsi-return-datepicker[data-type='"+datepicker_type+"']").val(''))
            $(".init-shamsi-return-datepicker[data-type='"+datepicker_type+"']").val('');
            setTimeout(function(){
                console.log('dddd')
                $("#endDateForHotelLocal").trigger('click')
                $("#endDateForHotelLocal").focus();
                $("#endDateForExternalHotelInternational").trigger('click')
                $("#endDateForExternalHotelInternational").focus();
                $("#endDateForHotelLocal2").trigger('click')
                $("#endDateForHotelLocal2").focus();
            },500)
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });
    $('.init-miladi-datepicker').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".init-miladi-return-datepicker").datepicker('option', 'minDate', dateText);
            // datepicker_type=$(this).data('type')
            $(".init-miladi-return-datepicker[data-type='"+datepicker_type+"']").val('');
            setTimeout(function(){
                $("#endDateForHotelLocal").trigger('click')
                $("#endDateForHotelLocal").focus();
                $("#endDateForExternalHotelInternational").trigger('click')
                $("#endDateForExternalHotelInternational").focus();
            },500)
        },
        beforeShow: function(n) {

            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });
    $('.init-shamsi-return-datepicker').datepicker({
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $(".check-in-date-js[data-type='"+datepicker_type+"']").val(),
        showRange: true,
        showButtonPanel: !0,
        onSelect: function (dateTextReturn) {
            console.log('retuen stop==>', $(".check-in-date-js[data-type='"+datepicker_type+"']").val())
            console.log('retuen==>',datepicker_type)
            let shamsi_dept = $(".init-shamsi-datepicker[data-type='"+datepicker_type+"']").val();

            let dayDiff = convertJalaliToGregorianDatePicker(dateTextReturn,shamsi_dept);

            // let endDateGreg = _convertJalaliToGregorian(dateTextReturn);

            // let startDate = new Date(startDateGreg);
            // let endDate = new Date(endDateGreg);

            // let fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
            // let fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

            // let dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;
            console.log(dayDiff)
            if(dayDiff < 0){
                $.alert({
                    title: useXmltag("GoharHotel"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ArrivalDateHotelEqualBeforeDateArrival"),
                    rtl: true,
                    type: 'red'
                });

                return false;
            }
            $('#stayingTimeForSearch').html(dayDiff + useXmltag("Night"));
            $("#nights").val(dayDiff);
            $('.stayingTime').html(dayDiff + useXmltag("Night"));
            $("#stayingTime").val(dayDiff);
            $("#stayingTimeForeign").val(dayDiff);
            $(".nights-hotel-js").val(dayDiff);
            $("."+datepicker_type+"-my-hotels-rooms-js").addClass('active_p');

        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });
    $('.init-miladi-return-datepicker').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $(".check-in-date-js[data-type='"+datepicker_type+"']").val(),
        showButtonPanel: !0,
        onSelect: function (dateTextReturn) {
            let shamsi_dept = $(".init-miladi-datepicker[data-type='"+datepicker_type+"']").val();
            console.log(shamsi_dept , datepicker_type)

            // let dayDiff = convertJalaliToGregorianDatePicker(dateTextReturn,shamsi_dept);
            let startDateGreg = _convertJalaliToGregorian(shamsi_dept);
            let endDateGreg = _convertJalaliToGregorian(dateTextReturn);

            let startDate = new Date(startDateGreg);
            let endDate = new Date(endDateGreg);

            let fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
            let fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

            let dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;


            if(dayDiff < 0){
                $.alert({
                    title: useXmltag("GoharHotel"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("ArrivalDateHotelEqualBeforeDateArrival"),
                    rtl: true,
                    type: 'red'
                });

                return false;
            }
            $('#stayingTimeForSearch').html(dayDiff + useXmltag("Night"));
            $("#nights").val(dayDiff);
            $('.stayingTime').html(dayDiff + useXmltag("Night"));
            $("#stayingTime").val(dayDiff);
            $("#stayingTimeForeign").val(dayDiff);
            $(".nights-hotel-js").val(dayDiff);
            $("."+datepicker_type+"-my-hotels-rooms-js").addClass('active_p');

        },
        beforeShow: function(n) {
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });

    //for shamsi and gregorian dept and return hotel reservations
    $('.deptCalendarToCalculateNights').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: true,
        onSelect: function (dateText) {
            $(".returnCalendarToCalculateNights").datepicker('option', 'minDate', dateText);
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });

    $('.returnCalendarToCalculateNights').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.deptCalendarToCalculateNights').val(),
        showButtonPanel: !0,
        onSelect: function (dateTextReturn) {

            let startDate = new Date($('.deptCalendarToCalculateNights').val());
            let endDate = new Date(dateTextReturn);

            let fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
            let fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

            let dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;

            $('#stayingTimeForSearch').html(dayDiff + useXmltag("Night"));
            $('.stayingTime').html(dayDiff + useXmltag("Night"));
            $("#stayingTime").val(dayDiff);
            $("#nights").val(dayDiff);
        },
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker");
        }
    });


    //for just gregorian dept and return reservations
    $('.gregorianDeptCalendar').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        onSelect: function(dateText){
            $(".gregorianReturnCalendar").datepicker('option', 'minDate', dateText);
        }
    });
    $('.gregorianReturnCalendar').datepicker({
        regional: '',
        numberOfMonths: numberOfMonthsResponsive,
        minDate: $('.gregorianDeptCalendar').val(),
        showButtonPanel: !0,
        beforeShow: function(n) {
            e(n, !0);
            $("#ui-datepicker-div").addClass("INH_class_Datepicker")
        }
    });


    //for shamsi birthday
    $('body').delegate('.shamsiBirthdayCalendar','focus', function(e) {
        $(this).datepicker({
            maxDate: 'Y/M/D',
            showButtonPanel: !0,
            changeMonth: true,
            changeYear: true,
            yearRange: '1300:1480'
        });
    });



    //for shamsi birthday
    $('body').delegate('.jalaliBirthdayCalendar','focus', function(e) {
        $(this).datepicker({
            numberOfMonths: numberOfMonthsResponsive,
            minDate: 'Y/M/D',
            showButtonPanel: !0,
            onSelect: function(dateText){
                $(".returnCalendar").datepicker('option', 'minDate', dateText);
            },
            beforeShow: function(n) {
                e(n, !0);
                $("#ui-datepicker-div").addClass("INH_class_Datepicker")
            }
        });
    });

    //for adults shamsi birthday
    $('.shamsiAdultBirthdayCalendar').datepicker({
        maxDate: '[-12Y,-1M]',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });


    //for childs shamsi birthday
    $('.shamsiChildBirthdayCalendar').datepicker({
        minDate: '-12Y',
        maxDate: '-2Y',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });

    let today = new Date();
    let [jy, jm, jd] = gregorianToJalali(today.getFullYear(), today.getMonth() + 1, today.getDate());


    //for infants shamsi birthday
    $('.shamsiInfantBirthdayCalendar').datepicker({
        minDate: '-2Y',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });


    //for -12 shamsi birthday
    $('.shamsiUnder12BirthdayCalendar').datepicker({
        minDate: '-12Y',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });



    //for -6 shamsi birthday
    $('.shamsiUnder6BirthdayCalendar').datepicker({
        minDate: '-6Y',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });


    //for gregorian birthday
    $('.gregorianBirthdayCalendar').datepicker({
        regional: '',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    $('.convertShamsiMiladiCalendar').datepicker({
        regional: 'fa',
        //   maxDate: 'Y/M/D',
      numberOfMonths: 1,
      showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,

    });

    //for convert ghamari to shamsi
    $('.convertMiladiShamsiCalendar').datepicker({
        regional: '',
        // maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });

    //for adults gregorian birthday
    $('.gregorianAdultBirthdayCalendar').datepicker({
        regional: '',
        maxDate: '-12Y',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for childs gregorian birthday
    $('.gregorianChildBirthdayCalendar').datepicker({
        regional: '',
        minDate: '-12Y',
        maxDate: '-2Y',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for infants gregorian birthday
    $('.gregorianInfantBirthdayCalendar').datepicker({
        regional: '',
        minDate: '-2Y',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for -12 gregorian birthday
    $('.gregorianUnder12BirthdayCalendar').datepicker({
        regional: '',
        minDate: '-12Y',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for driver (min age To Rent) shamsi birthday
    $('.shamsiDriverBirthdayCalendar').datepicker({
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });


    //for driver (min age To Rent) gregorian birthday
    $('.gregorianDriverBirthdayCalendar').datepicker({
        regional: '',
        maxDate: '-' + age + 'Y',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for shamsi with no limit
    $('.shamsiNoLimitCalendar').datepicker({
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });


    //for gregorian with no limit
    $('.gregorianNoLimitCalendar').datepicker({
        regional: '',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for shamsi from today
    $('.shamsiFromTodayCalendar').datepicker({
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480'
    });


    //for gregorian from today
    $('.gregorianFromTodayCalendar').datepicker({
        regional: '',
        minDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
    });


    //for shamsi range one month
    $('.shamsiRangeFirstCalendar').datepicker({
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1480',
        onSelect: function (dateText) {

            var newDate = new Date(dateText);
            newDate.setDate(newDate.getDate() + 31);
            if (newDate.getMonth() == 10) {
                var dd = newDate.getDate();
                var mm = newDate.getMonth() - 9;
                var y = newDate.getFullYear() + 1;
            } else {
                var dd = newDate.getDate();
                var mm = newDate.getMonth() + 1;
                var y = newDate.getFullYear();
            }
            var formattedDate = y + '-' + mm + '-' + dd;

            $('.shamsiRangeSecondCalendar').datepicker({
                minDate: dateText,
                maxDate: formattedDate,
                changeMonth: true,
                changeYear: true,
                yearRange: '1300:1480'
            });
        }
    });

});


function convertJalaliToGregorianDatePicker(jDate,elem) {
    var date1 = elem;
    var date2 = jDate;
    var res1 = jalaliToGregorian(date1, '-');
    var res2 = jalaliToGregorian(date2, '-');
    var startDate = new Date(res1);
    var endDate = new Date(res2);
    //
    var fullDaysSinceEpochStart = Math.floor(startDate / 8.64e7);
    var fullDaysSinceEpochEnd = Math.floor(endDate / 8.64e7);

    var diffTime = Math.abs(endDate - startDate);
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    var result = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;

    return result;
}

function jalaliToGregorian(jDate,delimiter){
    if(typeof delimiter === 'undefided'){
        delimiter = '-';
    }
    var dateSplitted = jDate.split(delimiter)
    gD = jalaliObject.jalaliToGregorian(dateSplitted[0], dateSplitted[1], dateSplitted[2]);
    gResult = gD[0] + "-" + gD[1] + "-" + gD[2];
    // // console.log(gResult);
    return gResult;
}
function gregorianToJalali(gy, gm, gd) {
    let g_d_m = [0, 31, ((gy % 4 === 0 && gy % 100 !== 0) || gy % 400 === 0) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    let gy2 = (gm > 2) ? (gy + 1) : gy;
    let days = 355666 + (365 * gy) + parseInt((gy2 + 3) / 4) - parseInt((gy2 + 99) / 100) + parseInt((gy2 + 399) / 400);
    for (let i = 0; i < gm; i++) {
        days += g_d_m[i];
    }
    days += gd;
    let jy = -1595 + (33 * parseInt(days / 12053));
    days %= 12053;
    jy += 4 * parseInt(days / 1461);
    days %= 1461;
    if (days > 365) {
        jy += parseInt((days - 1) / 365);
        days = (days - 1) % 365;
    }
    let jm = (days < 186) ? (1 + parseInt(days / 31)) : (7 + parseInt((days - 186) / 30));
    let jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
    return [jy, jm, jd];
}

jalaliObject = {
    g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
    j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
};

jalaliObject.jalaliToGregorian = function(j_y, j_m, j_d) {

    j_y = parseInt(j_y);
    j_m = parseInt(j_m);
    j_d = parseInt(j_d);
    var jy = j_y - 979;
    var jm = j_m - 1;
    var jd = j_d - 1;

    var j_day_no = 365 * jy + parseInt(jy / 33) * 8 + parseInt((jy % 33 + 3) / 4);
    for (var i = 0; i < jm; ++i) j_day_no += jalaliObject.j_days_in_month[i];

    j_day_no += jd;

    var g_day_no = j_day_no + 79;

    var gy = 1600 + 400 * parseInt(g_day_no / 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
    g_day_no = g_day_no % 146097;

    var leap = true;

    if (g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
    {
        g_day_no--;
        gy += 100 * parseInt(g_day_no / 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
        g_day_no = g_day_no % 36524;

        if (g_day_no >= 365) g_day_no++;
        else leap = false;
    }

    gy += 4 * parseInt(g_day_no / 1461); /* 1461 = 365*4 + 4/4 */
    g_day_no %= 1461;

    if (g_day_no >= 366) {
        leap = false;

        g_day_no--;
        gy += parseInt(g_day_no / 365);
        g_day_no = g_day_no % 365;
    }

    for (var i = 0; g_day_no >= jalaliObject.g_days_in_month[i] + (i == 1 && leap); i++)
        g_day_no -= jalaliObject.g_days_in_month[i] + (i == 1 && leap);
    var gm = i + 1;
    var gd = g_day_no + 1;

    gm = gm < 10 ? "0" + gm : gm;
    gd = gd < 10 ? "0" + gd : gd;

    return [gy, gm, gd];
}

function _convertJalaliToGregorian(jDate) {

    var jqXHR =  $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        async: false,
        data:
        {
            flag: 'convertJalaliToGregorian',
            jDate: jDate
        }
    });

    console.log('jqXHR',jqXHR);
    return jqXHR.responseText;
}
function setTimeoutDeptCalendar (){
    setTimeout(() => {
        $('.deptCalendar').datepicker({
            numberOfMonths: numberOfMonthsResponsive,
            minDate: 'Y/M/D',
            showButtonPanel: !0,
            onSelect: function(dateText){
                $(".returnCalendar").datepicker('option', 'minDate', dateText);
                let disabled_arrival_date_internal = $("#arrival_date_internal").is(":disabled")
                let disabled_arrival_date_international = $("#arrival_date_international").is(":disabled")

                if(!disabled_arrival_date_internal && disabled_arrival_date_internal != 'undefided') {
                    setTimeout(function(){
                        $('#arrival_date_internal').trigger('click').focus()
                    },500)
                }
                if(!disabled_arrival_date_international && disabled_arrival_date_international != 'undefided') {
                    setTimeout(function(){
                        $('#arrival_date_international').trigger('click').focus()
                    },500)
                }

            },
            beforeShow: function(n) {
                e(n, !0);
                $("#ui-datepicker-div").addClass("INH_class_Datepicker")
            }
        });
    },200)
}
function setTimeoutShamsiCalendar (){
    setTimeout(() => {
        $('.shamsiBirthdayCalendar').datepicker({
            maxDate: 'Y/M/D',
            showButtonPanel: !0,
            changeMonth: true,
            changeYear: true,
            yearRange: '1300:1480'
        });

    },200)
}
function setTimeoutMiladiCalendar (){
    setTimeout(() => {
        $('.gregorianBirthdayCalendar').datepicker({
            regional: '',
            maxDate: 'Y/M/D',
            showButtonPanel: !0,
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:2120'
        });
    },200)
}


